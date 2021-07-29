<?php

namespace App\Http\Controllers\Admin\Configuracoes;

use App\Http\Controllers\Controller;
use App\Models\Configuracoes\CadUsuario;
use App\Components\Biblioteca;
use App\Http\Requests\Configuracoes\UsuarioRequest;
use App\Models\Configuracoes\PerfilAcesso;
use Exception;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UsuarioController extends Controller
{
    /**
     * Instância dos usuários
    */
    protected $usuarios;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CadUsuario $usuarios, PerfilAcesso $perfilAcesso)
    {
        $this->middleware('auth');
        $this->usuarios = $usuarios;

        /** Verifica as permissões **/
        $this->middleware('can:AcessarUsuários')->except(['alterarMeusDados', 'updateDados']);
        $this->middleware('can:CriarUsuario', ['only' => ['create', 'store']])->except(['alterarMeusDados', 'updateDados']);
        $this->middleware('can:VisualizarUsuario', ['only' => ['show']])->except(['alterarMeusDados', 'updateDados']);
        $this->middleware('can:EditarUsuario', ['only' => ['edit', 'update']])->except(['alterarMeusDados', 'updateDados']);
        $this->middleware('can:ExcluirUsuario', ['only' => ['destroy']])->except(['alterarMeusDados', 'updateDados']);

        // Menus para o form disponível em todas as views
        FacadesView::share('perfisAcesso', $perfilAcesso->where('flg_ativo', Biblioteca::FLG_ATIVO)->get());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = $this->usuarios->all();
        $options = [
            'viewName' => '_grid',
        ];

        return view('Admin.configuracoes.usuario.index', compact('model', 'options'));
    }

    /**
     * Função para retornarmos os registros
     * utilizando datatable
     */
    public function ajaxDataTable()
    {
        $usuarios = $this->usuarios->with('perfilAcesso')->select();
        $dataTable = DataTables::of($usuarios);

        // Colunas de ação
        if(Gate::allows('VisualizarUsuario') || Gate::allows('EditarUsuario') || Gate::allows('ExcluirUsuario'))
        {
            $dataTable
            ->addColumn('action', function ($usuario) {
                $actionColumns = '';

                if(Gate::allows('VisualizarUsuario'))
                    $actionColumns = '<a href="'. route('usuario.show', ['usuario' => Crypt::encryptString($usuario->id)]) .'" class="m-r-5 button-view" title='. trans('labels.show') . ' data-toggle="tooltip" data-placement="top">
                                    <i class="anticon anticon-eye"></i>
                                    <span class="m-l-3">' . trans('labels.show') . '</span>
                                </a>';

                if(Gate::allows('EditarUsuario'))
                    $actionColumns .= '<a href="'. route('usuario.edit', ['usuario' => Crypt::encryptString($usuario->id)]) .'" class="m-r-5 button-edit" title='. trans('labels.edit') . ' data-toggle="tooltip" data-placement="top">
                                <i class="anticon anticon-edit"></i>
                                <span class="m-l-3">' . trans('labels.edit') . '</span>
                            </a>';

                if(Gate::allows('ExcluirUsuario'))
                    $actionColumns .= '<a class="delete-button button-delete" data-name="'. $usuario->des_nome . '" data-id="' . $usuario->id . '" data-method="DELETE" data-item="' . trans('labels.usuario') . '"
                                title="' . trans('labels.delete') . '" data-toggle="tooltip" data-placement="top" onclick="deleteRegister(this)"
                                href="#"
                                data-href="' . route('usuario.destroy', ['usuario' => Crypt::encryptString($usuario->id)]) . '"> 
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
        $model = new CadUsuario();
        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_POST,
            'route'  => route('usuario.store')
        ];

        return view('Admin.configuracoes.usuario.index', compact('model', 'options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuarioRequest $request)
    {
        try
        {
            $model = new CadUsuario;
            $model->fill($request->all())->save();

            return redirect(route('usuario.index'))->with('success', trans('messages.saved'));

        } catch (Exception $ex)
        {
            if(env('AMBIENTE') == 'DSV')
            {
                return back()->with('error', $ex->getMessage());
            } else {
                return back()->with('Não foi possível realizar a criação do usuário, tente novamente.');
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
        $idUsuario = Biblioteca::desencriptar($id);
        $model = $this->usuarios->findOrFail($idUsuario);

        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_SHOW,
            'route'  => route('usuario.store'),
        ];

        return view('Admin.configuracoes.usuario.index', compact('model', 'options'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $idUsuario = Biblioteca::desencriptar($id);
        $model = $this->usuarios->findOrFail($idUsuario);

        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_UPDATE,
            'route'  => route('usuario.update', $model->id),
        ];

        return view('Admin.configuracoes.usuario.index', compact('model', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsuarioRequest $request, $id)
    {
        try
        {
            $model = $this->usuarios->findOrFail($id);
            
            $data = $request->all();
            if(isset($data['password']))
            {
                $data['password'] = Hash::make($data['password']);
            } else {
                $data['password'] = $model->password;
            }

            $model->fill($data)->update();

            return redirect(route('usuario.index'))->with('success', trans('messages.edited'));

        } catch (Exception $ex)
        {
            if(env('AMBIENTE') == 'DSV')
            {
                return back()->with('error', $ex->getMessage());
            } else {
                return back()->with('Não foi possível realizar a atualização do usuário, tente novamente.');
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
            $idUsuario = Biblioteca::desencriptar($id);
            $model = $this->usuarios->findOrFail($idUsuario);

            $model->delete();

            return response(['message' => trans('messages.deleted'), 'response' => 'ok']);

        } catch (Exception $ex) {
            return response(['message' => trans('messages.delete_failed')]);
        }
    }

    /**
     * Função para o usuário realizar a alteração de seus dados
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function alterarMeusDados($id)
    {
        $idUsuario = Biblioteca::desencriptar($id);
        $model = $this->usuarios->findOrFail($idUsuario);

        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_UPDATE,
            'route'  => route('usuario.updateDados', $model->id),
        ];

        return view('Admin.configuracoes.usuario.index', compact('model', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDados(UsuarioRequest $request, $id)
    {
        try
        {
            $model = $this->usuarios->findOrFail($id);
            
            $data = $request->all();
            if(isset($data['password']))
            {
                $data['password'] = Hash::make($data['password']);
            } else {
                $data['password'] = $model->password;
            }

            $model->fill($data)->update();

            return redirect(route('home'))->with('success', trans('messages.dadosAlterados'));

        } catch (Exception $ex)
        {
            if(env('AMBIENTE') == 'DSV')
            {
                return back()->with('error', $ex->getMessage());
            } else {
                return back()->with('Não foi possível realizar a atualização do usuário, tente novamente.');
            }
        }
    }
}
