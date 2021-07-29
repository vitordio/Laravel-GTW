<?php

namespace App\Http\Controllers\Admin\Cadastros;

use App\Components\Biblioteca;
use App\Exports\MotoristasExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cadastros\MotoristasRequest;
use App\Models\Cadastros\Motoristas;
use App\Models\CamposPersonalizados\ModelosGridExcel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View as FacadesView;
use Yajra\DataTables\DataTables;

class MotoristasController extends Controller
{
    /**
     * Instância dos motoristas
    */
    protected $motoristas, $idFuncionalidade, $modeloPadrao;

    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct(Motoristas $motoristas, Carbon $carbon)
    {
        $this->middleware('auth');
        $this->motoristas = $motoristas;
        $this->idFuncionalidade = ($motoristas)->getIdFuncionalidade();
        $this->modeloPadrao = (new ModelosGridExcel)->getModeloPadrao($this->idFuncionalidade);
        
        /** Verifica as permissões **/
        $this->middleware('can:AcessarMotoristas');
        $this->middleware('can:CriarMotoristas', ['only' => ['create', 'store']]);
        $this->middleware('can:VisualizarMotoristas', ['only' => ['show']]);
        $this->middleware('can:EditarMotoristas', ['only' => ['edit', 'update']]);
        $this->middleware('can:ExcluirMotoristas', ['only' => ['destroy']]);

        // Carbon disponível em todas as views
        FacadesView::share('carbon', $carbon);

        // Envia a variável de motoristas para a view
        FacadesView::share('idFuncionalidade', $this->idFuncionalidade);

        // Envia as informações do modelo padrão da funcionalidade de motoristas
        FacadesView::share('modeloPadrao', $this->modeloPadrao);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = $this->motoristas->all($this->modeloPadrao->colunas);

        // Pegamos as configurações padrão da index
        extract($this->defaultOptionsIndex());

        return view('Admin.cadastros.motoristas.index', compact('model', 'options', 'optionsModelo', 'modelosGridExcel'));
    }

    /**
     * Função que receberá o modelo de grid selecionado e
     * criará a grid de acordo com o modelo
     * 
     * @param app\Models\CamposPersonalizados\ModelosGridExcel $id
    */
    public function exibeGridModelo($idModelo)
    {
        // Pegamos as configurações padrão da index
        extract($this->defaultOptionsIndex());

        $idModelo = Biblioteca::desencriptar($idModelo);
        $modeloSelecionado = ModelosGridExcel::findOrFail($idModelo);

        // Pegamos os registros de motoristas, mas apenas nas colunas do modelo selecionado
        $model = $this->motoristas->get($modeloSelecionado->colunas);

        return view('Admin.cadastros.motoristas.index', compact('model', 'options', 'optionsModelo', 'modelosGridExcel', 'modeloSelecionado'));
    }

    /**
     * Função para retornarmos os registros
     * utilizando datatable
     */
    public function ajaxDataTable($idModeloSelecionado)
    {
        $modeloSelecionado = ModelosGridExcel::findOrFail($idModeloSelecionado);

        $motoristas = $this->motoristas->select($modeloSelecionado->colunas);
        $dataTable = DataTables::of($motoristas);
        
        // Coluna para selecionar todos os registros
        $dataTable
        ->addColumn('checkbox', function ($motorista) {
            $selectAllColumn = '<input type="checkbox" class="delete-checkbox" name=delete-item-"' . $motorista->id . '" value="' . $motorista->id . '">';

            return $selectAllColumn;
        });

        // Colunas de ação
        if(Gate::allows('VisualizarMotoristas') || Gate::allows('EditarMotoristas') || Gate::allows('ExcluirMotoristas'))
        {
            $dataTable
            ->addColumn('action', function ($motorista) {
                $actionColumns = '';

                if(Gate::allows('VisualizarMotoristas'))
                    $actionColumns = '<a href="'. route('motoristas.show', ['motorista' => Crypt::encryptString($motorista->id)]) .'" class="m-r-5 button-view" title='. trans('labels.show') . ' data-toggle="tooltip" data-placement="top">
                                    <i class="anticon anticon-eye"></i>
                                    <span class="m-l-3">' . trans('labels.show') . '</span>
                                </a>';

                if(Gate::allows('EditarMotoristas'))
                    $actionColumns .= '<a href="'. route('motoristas.edit', ['motorista' => Crypt::encryptString($motorista->id)]) .'" class="m-r-5 button-edit" title='. trans('labels.edit') . ' data-toggle="tooltip" data-placement="top">
                                <i class="anticon anticon-edit"></i>
                                <span class="m-l-3">' . trans('labels.edit') . '</span>
                            </a>';

                if(Gate::allows('ExcluirMotoristas'))
                    $actionColumns .= '<a class="delete-button button-delete" data-name="'. $motorista->des_nome . '" data-id="' . $motorista->id . '" data-method="DELETE" data-item="' . trans('labels.motorista') . '"
                                title="' . trans('labels.delete') . '" data-toggle="tooltip" data-placement="top" onclick="deleteRegister(this)"
                                href="#"
                                data-href="' . route('motoristas.destroy', ['motorista' => Crypt::encryptString($motorista->id)]) . '"> 
                                    <i class="anticon anticon-delete"></i>
                                    <span class="m-l-3">' . trans('labels.delete') . '</span>
                        </a>';

                return $actionColumns;
            });
        }

        return $dataTable->rawColumns(['checkbox','action'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Motoristas();
        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_POST,
            'route' => route('motoristas.store')
        ];

        return view('Admin.cadastros.motoristas.index', compact('model', 'options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MotoristasRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $idMotorista = Biblioteca::desencriptar($id);
        $model = $this->motoristas->findOrFail($idMotorista);

        $options = [
            'viewName' => '_visualizar',
            'method' => Biblioteca::METHOD_SHOW,
        ];

        return view('Admin.cadastros.motoristas.index', compact('model', 'options'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $idMotorista = Biblioteca::desencriptar($id);
        $model = $this->motoristas->findOrFail($idMotorista);

        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_UPDATE,
            'route'  => route('motoristas.update', $model->id),
        ];

        return view('Admin.cadastros.motoristas.index', compact('model', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MotoristasRequest $request, $id)
    {
        try {
            $model = $this->motoristas->findOrFail($id);
            $data = $request->all();
            $model->fill($data)->update();

            return redirect(route('motoristas.index'))->with('success', trans('messages.saved'));

        } catch (Exception $ex) {
            if(env('AMBIENTE') == 'DSV')
            {
                return back()->with('error', $ex->getMessage());
            } else {
                return back()->with('Não foi possível realizar a edição do motorista, tente novamente.');
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
            $idMotorista = Biblioteca::desencriptar($id);
            $model = $this->motoristas->findOrFail($idMotorista);

            $model->delete();

            /**
             * Enviamos também a URL de recirect pois no visualizar também
             * conseguimos deletar o motorista, após deletar, redirecionamos para a index
             */
            return response(['message' => trans('messages.deleted'), 'response' => 'ok', 'urlRedirect' => route('motoristas.index')]);
        } catch (Exception $ex) {
            return response(['message' => trans('messages.delete_failed')]);
        }
    }

    /**
     * Exclui todos os motoristas
     * selecionados na grid
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAllSelected()
    {
        try {
            /* Recebemos por POST o array com os IDS selecionados */
            $idsMotoristas = $_POST['data'];
            if(!empty($idsMotoristas))
            {
                foreach ($idsMotoristas as $key => $id)
                    $this->motoristas->findOrFail($id)->delete();
            }

            return response(['message' => trans('messages.deletedAllSucess'), 'response' => 'ok']);
        } catch (Exception $ex)
        {
            return response(['message' => trans('messages.delete_failed')]);
        }
    }

    /**
     * Função para exportar o excel dos motoristas
     * passamos o ID do modelo selecionado para exportar o excel com as colunas do modelo
     * 
     * @param app\Models\CamposPersonalizados\ModelosGridExcel $idModelo 
     * @return App\Exports\MotoristasExport;
     */
    public function exportarExcel($idModelo)
    {
        $modeloSelecionado = ModelosGridExcel::findOrFail($idModelo);
        return new MotoristasExport($modeloSelecionado->colunas);
    }

    /**
     * Opções padrão da index
    */
    protected function defaultOptionsIndex()
    {
        $options = [
            'viewName' => '_grid',
        ];

        /** Rota e método para o formulário de
         * inclusão dos modelos para grid e excel
        */
        $optionsModelo = [
            'route' => route('modelosGridExcel.store')
        ];

        /**
         * Populamos o dropdown dos modelos de grid e
         * excel com os modelos da funcionalidade de Motoristas
        */
        $modelosGridExcel = ModelosGridExcel::where('id_funcionalidade', $this->idFuncionalidade)->get();

        return [
            'options' => $options,
            'optionsModelo' => $optionsModelo,
            'modelosGridExcel' => $modelosGridExcel
        ];
    }
}
