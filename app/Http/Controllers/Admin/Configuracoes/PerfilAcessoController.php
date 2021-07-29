<?php

namespace App\Http\Controllers\Admin\Configuracoes;

use App\Components\Biblioteca;
use App\Http\Controllers\Controller;
use App\Http\Requests\Configuracoes\PerfilAcessoRequest;
use App\Models\Configuracoes\Funcionalidade;
use App\Models\Configuracoes\Log;
use App\Models\Configuracoes\Menu;
use App\Models\Configuracoes\PerfilAcesso;
use App\Models\Configuracoes\Permissoes;
use App\Models\Configuracoes\RelFuncionalidadePerfil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View as FacadesView;
use Yajra\DataTables\DataTables;

class PerfilAcessoController extends Controller
{
    /**
     * Instância dos perfis de acesso
     */
    protected $perfilAcesso;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PerfilAcesso $perfilAcesso, Menu $menus, Permissoes $permissoes)
    {
        $this->middleware('auth');
        $this->perfilAcesso = $perfilAcesso;

        /** Verifica as permissões **/
        $this->middleware('can:AcessarPerfis de Acesso');
        $this->middleware('can:CriarPerfilAcesso', ['only' => ['create', 'store']]);
        $this->middleware('can:VisualizarPerfilAcesso', ['only' => ['show']]);
        $this->middleware('can:EditarPerfilAcesso', ['only' => ['edit', 'update']]);
        $this->middleware('can:ExcluirPerfilAcesso', ['only' => ['destroy']]);
        
        // Passamos as instâncias dos menus e das permissões para as views
        $menus = $menus->where('flg_ativo', Biblioteca::FLG_ATIVO)
        ->where('des_menu', '!=', Menu::DASHBOARD_MENU)
        ->get();

        $permissoes = $permissoes->where('flg_ativo', Biblioteca::FLG_ATIVO)->get();
        
        FacadesView::share('menus', $menus);
        FacadesView::share('permissoes', $permissoes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = $this->perfilAcesso->get();
        $options = [
            'viewName' => '_grid',
        ];

        return view('Admin.configuracoes.perfilAcesso.index', compact('model', 'options'));
    }

    /**
     * Função para retornarmos os registros
     * utilizando datatable
     */
    public function ajaxDataTable()
    {
        $perfilAcesso = $this->perfilAcesso->select();
        $dataTable = DataTables::of($perfilAcesso);

        // Colunas de ação
        if(Gate::allows('VisualizarPerfilAcesso') || Gate::allows('EditarFuncionalidade') || Gate::allows('ExcluirFuncionalidade'))
        {
            $dataTable
            ->addColumn('action', function ($perfilAcesso) {
                $actionColumns = '';

                if(Gate::allows('VisualizarPerfilAcesso'))
                    $actionColumns = '<a href="'. route('perfilAcesso.show', ['perfilAcesso' => Crypt::encryptString($perfilAcesso->id)]) .'" class="m-r-5 button-view" title='. trans('labels.show') . ' data-toggle="tooltip" data-placement="top">
                                    <i class="anticon anticon-eye"></i>
                                    <span class="m-l-3">' . trans('labels.show') . '</span>
                                </a>';

                if(Gate::allows('EditarPerfilAcesso'))
                    $actionColumns .= '<a href="'. route('perfilAcesso.edit', ['perfilAcesso' => Crypt::encryptString($perfilAcesso->id)]) .'" class="m-r-5 button-edit" title='. trans('labels.edit') . ' data-toggle="tooltip" data-placement="top">
                                <i class="anticon anticon-edit"></i>
                                <span class="m-l-3">' . trans('labels.edit') . '</span>
                            </a>';

                if(Gate::allows('ExcluirPerfilAcesso'))
                    $actionColumns .= '<a class="delete-button button-delete" data-name="'. $perfilAcesso->des_nome . '" data-id="' . $perfilAcesso->id . '" data-method="DELETE" data-item="' . trans('labels.des_perfil') . '"
                                title="' . trans('labels.delete') . '" data-toggle="tooltip" data-placement="top" onclick="deleteRegister(this)"
                                href="#"
                                data-href="' . route('perfilAcesso.destroy', ['perfilAcesso' => Crypt::encryptString($perfilAcesso->id)]) . '"> 
                                    <i class="anticon anticon-delete"></i>
                                    <span class="m-l-3">' . trans('labels.delete') . '</span>
                        </a>';

                return $actionColumns;
            });
        }

        return $dataTable->rawColumns(['action'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new PerfilAcesso();
        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_POST,
            'route'  => route('perfilAcesso.store')
        ];

        return view('Admin.configuracoes.perfilAcesso.index', compact('model', 'options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\PerfilAcessoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PerfilAcessoRequest $request)
    {
        try
        {
            $model = new PerfilAcesso();
            $model->fill($request->all())->save();

            // Salva as permissões do perfil de acesso
            $this->storePermissoes($request->all(), $model);

            return redirect(route('perfilAcesso.index'))->with('success', trans('messages.saved'));

        } catch (Exception $ex)
        {
            if(env('AMBIENTE') == 'DSV')
            {
                return back()->with('error', $ex->getMessage());
            } else {
                return back()->with('Não foi possível realizar a criação do perfil de acesso, tente novamente.');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $idPerfilAcesso = Biblioteca::desencriptar($id);
        $model = $this->perfilAcesso->findOrFail($idPerfilAcesso);

        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_SHOW,
            'route'  => route('perfilAcesso.store'),
        ];

        return view('Admin.configuracoes.perfilAcesso.index', compact('model', 'options'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $idPerfilAcesso = Biblioteca::desencriptar($id);
        $model = $this->perfilAcesso->findOrFail($idPerfilAcesso);

        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_UPDATE,
            'route'  => route('perfilAcesso.update', $model->id),
        ];

        return view('Admin.configuracoes.perfilAcesso.index', compact('model', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PerfilAcessoRequest $request, $id)
    {
        try
        {
            $model = $this->perfilAcesso->findOrFail($id);
            $model->fill($request->all())->update();

            // Atualiza as permissões do perfil de acesso
            $this->storePermissoes($request->all(), $model);

            return redirect(route('perfilAcesso.index'))->with('success', trans('messages.edited'));

        } catch (Exception $ex)
        {
            if(env('AMBIENTE') == 'DSV')
            {
                return back()->with('error', $ex->getMessage());
            } else {
                return back()->with('Não foi possível realizar a atualização do perfil de acesso, tente novamente.');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $idPerfilAcesso = Biblioteca::desencriptar($id);
            $model = $this->perfilAcesso->findOrFail($idPerfilAcesso);

            $model->delete();

            return response(['message' => trans('messages.deleted'), 'response' => 'ok']);

        } catch (Exception $ex) {
            return response(['message' => trans('messages.delete_failed')]);
        }
    }

    /**
     * Salva e atualiza as permissões
     * delegadas ao perfil de acesso
     * 
     * @param $request
     * @param PerfilAcesso $model
     */
    protected function storePermissoes($request, PerfilAcesso $model)
    {
        /**
         * Se o método for de update, removemos as relações anteriores
         */
        if(in_array($request['_method'], [Biblioteca::METHOD_UPDATE, Biblioteca::METHOD_PUT]))
            RelFuncionalidadePerfil::where('id_perfil_acesso', $model->id)->delete();

        foreach ($request as $key => $value) {
            if((bool) strpos($key, 'submenu')) {
                $flgSave = true;
                $idsFuncPermissao = explode('_', $key);

                $idPermissao = $idsFuncPermissao[2];
                $idFunc = $idsFuncPermissao[3];

                /** Se for Log de Acesso, salva apenas o visualizar */
                if($idFunc == (new Log())->getIdFuncionalidade())
                {
                    $permissao = new Permissoes();
                    $permissao->setPermissao('Visualizar');

                    $idPermissao != $permissao->getId() ? $flgSave = false : $flgSave = true;
                }

                if($flgSave)
                {
                    $modelRelation = new RelFuncionalidadePerfil([
                        'id_funcionalidade' => $idFunc,
                        'id_perfil_acesso' => $model->id,
                        'id_permissao' => $idPermissao   
                    ]);
    
                    $modelRelation->save();
                }
            }
        }
    }
}
