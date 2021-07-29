<?php

namespace App\Http\Controllers\Admin\Configuracoes;

use App\Components\Biblioteca;
use App\Http\Controllers\Controller;
use App\Http\Requests\Configuracoes\FuncionalidadeRequest;
use App\Models\Configuracoes\Funcionalidade;
use App\Models\Configuracoes\Menu;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate as Gate;
use Illuminate\Support\Facades\View as FacadesView;
use Yajra\DataTables\DataTables;

class FuncionalidadeController extends Controller
{
    /**
     * Instância das funcionalidades
    */
    protected $funcionalidades;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Funcionalidade $funcionalidades, Menu $menus)
    {
        $this->middleware('auth');
        $this->funcionalidades = $funcionalidades;

        /** Verifica as permissões **/
        $this->middleware('can:AcessarFuncionalidades');
        $this->middleware('can:CriarFuncionalidade', ['only' => ['create', 'store']]);
        $this->middleware('can:VisualizarFuncionalidade', ['only' => ['show']]);
        $this->middleware('can:EditarFuncionalidade', ['only' => ['edit', 'update']]);
        $this->middleware('can:ExcluirFuncionalidade', ['only' => ['destroy']]);

        // Menus para o form disponível em todas as views
        FacadesView::share('menus', $menus->where('flg_ativo', Biblioteca::FLG_ATIVO)->get());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = $this->funcionalidades->all();
        $options = [
            'viewName' => '_grid',
        ];

        return view('Admin.configuracoes.funcionalidade.index', compact('model', 'options'));
    }

    /**
     * Função para retornarmos os registros
     * utilizando datatable
     */
    public function ajaxDataTable()
    {
        $funcionalidades = $this->funcionalidades->with('menu')->select();
        $dataTable = DataTables::of($funcionalidades);

        // Colunas de ação
        if(Gate::allows('VisualizarFuncionalidade') || Gate::allows('EditarFuncionalidade') || Gate::allows('ExcluirFuncionalidade'))
        {
            $dataTable
            ->addColumn('action', function ($funcionalidade) {
                $actionColumns = '';

                if(Gate::allows('VisualizarFuncionalidade'))
                    $actionColumns = '<a href="'. route('funcionalidade.show', ['funcionalidade' => Crypt::encryptString($funcionalidade->id)]) .'" class="m-r-5 button-view" title='. trans('labels.show') . ' data-toggle="tooltip" data-placement="top">
                                    <i class="anticon anticon-eye"></i>
                                    <span class="m-l-3">' . trans('labels.show') . '</span>
                                </a>';

                if(Gate::allows('EditarFuncionalidade'))
                    $actionColumns .= '<a href="'. route('funcionalidade.edit', ['funcionalidade' => Crypt::encryptString($funcionalidade->id)]) .'" class="m-r-5 button-edit" title='. trans('labels.edit') . ' data-toggle="tooltip" data-placement="top">
                                <i class="anticon anticon-edit"></i>
                                <span class="m-l-3">' . trans('labels.edit') . '</span>
                            </a>';

                if(Gate::allows('ExcluirFuncionalidade'))
                    $actionColumns .= '<a class="delete-button button-delete" data-name="'. $funcionalidade->des_nome . '" data-id="' . $funcionalidade->id . '" data-method="DELETE" data-item="' . trans('labels.des_funcionalidade') . '"
                                title="' . trans('labels.delete') . '" data-toggle="tooltip" data-placement="top" onclick="deleteRegister(this)"
                                href="#"
                                data-href="' . route('funcionalidade.destroy', ['funcionalidade' => Crypt::encryptString($funcionalidade->id)]) . '"> 
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
        $model = new Funcionalidade();
        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_POST,
            'route'  => route('funcionalidade.store')
        ];

        return view('Admin.configuracoes.funcionalidade.index', compact('model', 'options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\FuncionalidadeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FuncionalidadeRequest $request)
    {
        try
        {
            $model = new Funcionalidade();
            $model->fill($request->all())->save();

            return redirect(route('funcionalidade.index'))->with('success', trans('messages.saved'));

        } catch (Exception $ex)
        {
            if(env('AMBIENTE') == 'DSV')
            {
                return back()->with('error', $ex->getMessage());
            } else {
                return back()->with('Não foi possível realizar a criação da funcionalidade, tente novamente.');
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
        $idFuncionalidade = Biblioteca::desencriptar($id);
        $model = $this->funcionalidades->findOrFail($idFuncionalidade);

        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_SHOW,
            'route'  => route('funcionalidade.store'),
        ];

        return view('Admin.configuracoes.funcionalidade.index', compact('model', 'options'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $idFuncionalidade = Biblioteca::desencriptar($id);
        $model = $this->funcionalidades->findOrFail($idFuncionalidade);

        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_UPDATE,
            'route'  => route('funcionalidade.update', $model->id),
        ];


        return view('Admin.configuracoes.funcionalidade.index', compact('model', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\FuncionalidadeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FuncionalidadeRequest $request, $id)
    {
        try
        {
            $model = $this->funcionalidades->findOrFail($id);
            $model->fill($request->all())->update();

            return redirect(route('funcionalidade.index'))->with('success', trans('messages.edited'));

        } catch (Exception $ex)
        {
            if(env('AMBIENTE') == 'DSV')
            {
                return back()->with('error', $ex->getMessage());
            } else {
                return back()->with('Não foi possível realizar a atualização da funcionalidade, tente novamente.');
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
            $idFuncionalidade = Biblioteca::desencriptar($id);
            $model = $this->funcionalidades->findOrFail($idFuncionalidade);

            $model->delete();

            return response(['message' => trans('messages.deleted'), 'response' => 'ok']);

        } catch (Exception $ex) {
            return response(['message' => trans('messages.delete_failed')]);
        }
    }
}
