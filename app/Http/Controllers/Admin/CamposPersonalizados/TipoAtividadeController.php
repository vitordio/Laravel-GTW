<?php

namespace App\Http\Controllers\Admin\CamposPersonalizados;

use App\Components\Biblioteca;
use App\Http\Controllers\Controller;
use App\Http\Requests\CamposPersonalizados\TipoAtividadeRequest;
use App\Models\CamposPersonalizados\TipoAtividade;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class TipoAtividadeController extends Controller
{
    /**
     * Instância dos tipos de atividades
    */
    protected $tipoAtividade;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TipoAtividade $tipoAtividade)
    {
        $this->middleware('auth');
        $this->tipoAtividade = $tipoAtividade;

        /** Verifica as permissões **/
        $this->middleware('can:AcessarTipo Atividade');
        $this->middleware('can:CriarTipoAtividade', ['only' => ['create', 'store']]);
        $this->middleware('can:VisualizarTipoAtividade', ['only' => ['show']]);
        $this->middleware('can:EditarTipoAtividade', ['only' => ['edit', 'update']]);
        $this->middleware('can:ExcluirTipoAtividade', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = $this->tipoAtividade->get();
        $options = [
            'viewName' => '_grid',
        ];

        return view('Admin.camposPersonalizados.tipoAtividade.index', compact('model', 'options'));
    }

    /**
     * Função para retornarmos os registros
     * utilizando datatable
     */
    public function ajaxDataTable()
    {
        $tipoAtividade = $this->tipoAtividade->select();
        $dataTable = DataTables::of($tipoAtividade);

        // Colunas de ação
        if(Gate::allows('VisualizarTipoAtividade') || Gate::allows('EditarTipoAtividade') || Gate::allows('ExcluirTipoAtividade'))
        {
            $dataTable
            ->addColumn('action', function ($tipoAtividade) {
                $actionColumns = '';

                if(Gate::allows('VisualizarTipoAtividade'))
                    $actionColumns = '<a href="'. route('tipoAtividade.show', ['tipoAtividade' => Crypt::encryptString($tipoAtividade->id)]) .'" class="m-r-5 button-view" title='. trans('labels.show') . ' data-toggle="tooltip" data-placement="top">
                                    <i class="anticon anticon-eye"></i>
                                    <span class="m-l-3">' . trans('labels.show') . '</span>
                                </a>';

                if(Gate::allows('EditarTipoAtividade'))
                    $actionColumns .= '<a href="'. route('tipoAtividade.edit', ['tipoAtividade' => Crypt::encryptString($tipoAtividade->id)]) .'" class="m-r-5 button-edit" title='. trans('labels.edit') . ' data-toggle="tooltip" data-placement="top">
                                <i class="anticon anticon-edit"></i>
                                <span class="m-l-3">' . trans('labels.edit') . '</span>
                            </a>';

                if(Gate::allows('ExcluirTipoAtividade'))
                    $actionColumns .= '<a class="delete-button button-delete" data-name="'. $tipoAtividade->des_nome . '" data-id="' . $tipoAtividade->id . '" data-method="DELETE" data-item="' . trans('labels.tipoAtividade') . '"
                                title="' . trans('labels.delete') . '" data-toggle="tooltip" data-placement="top" onclick="deleteRegister(this)"
                                href="#"
                                data-href="' . route('tipoAtividade.destroy', ['tipoAtividade' => Crypt::encryptString($tipoAtividade->id)]) . '"> 
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
        $model = new TipoAtividade();
        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_POST,
            'route'  => route('tipoAtividade.store')
        ];

        return view('Admin.camposPersonalizados.tipoAtividade.index', compact('model', 'options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\TipoAtividadeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoAtividadeRequest $request)
    {
        try
        {
            $model = new TipoAtividade();
            $model->fill($request->all())->save();

            /** Se o post for via Ajax, enviamos como resposta JSON, se não, redirecionamos para a index */
            if($request->ajax())
            {
                // Enviamos todos os tipos de atividades atipos para atualizar as opções no select
                $tipoAtividade = $this->tipoAtividade->where('flg_ativo', Biblioteca::FLG_ATIVO)->get();
                return response()->json(['success' => 'Cadastro realizado com sucesso', 'tipoAtividade' => $tipoAtividade]);
            }

            return redirect(route('tipoAtividade.index'))->with('success', trans('messages.saved'));

        } catch (Exception $ex)
        {
            if(env('AMBIENTE') == 'DSV')
            {
                if($request->ajax())
                {
                    return response()->json(['error' => $ex->getMessage()]);
                }

                return back()->with('error', $ex->getMessage());
            } else {
                if($request->ajax())
                {
                    return response()->json(['error' => 'Não foi possível realizar a criação do tipo de atividade, tente novamente.']);
                }

                return back()->with('error', 'Não foi possível realizar a criação do tipo de atividade, tente novamente.');
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
        $idTipoAtividade = Biblioteca::desencriptar($id);
        $model = $this->tipoAtividade->findOrFail($idTipoAtividade);

        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_SHOW,
            'route'  => route('tipoAtividade.store'),
        ];

        return view('Admin.camposPersonalizados.tipoAtividade.index', compact('model', 'options'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $idTipoAtividade = Biblioteca::desencriptar($id);
        $model = $this->tipoAtividade->findOrFail($idTipoAtividade);

        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_UPDATE,
            'route'  => route('tipoAtividade.update', $model->id),
        ];


        return view('Admin.camposPersonalizados.tipoAtividade.index', compact('model', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\TipoAtividadeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoAtividadeRequest $request, $id)
    {
        try
        {
            $model = $this->tipoAtividade->findOrFail($id);
            $model->fill($request->all())->update();

            return redirect(route('tipoAtividade.index'))->with('success', trans('messages.edited'));

        } catch (Exception $ex)
        {
            if(env('AMBIENTE') == 'DSV')
            {
                return back()->with('error', $ex->getMessage());
            } else {
                return back()->with('Não foi possível realizar a atualização do tipo de atividade, tente novamente.');
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
            $idTipoAtividade = Biblioteca::desencriptar($id);
            $model = $this->tipoAtividade->findOrFail($idTipoAtividade);

            $model->delete();

            return response(['message' => trans('messages.deleted'), 'response' => 'ok']);

        } catch (Exception $ex) {
            return response(['message' => trans('messages.delete_failed')]);
        }
    }
}
