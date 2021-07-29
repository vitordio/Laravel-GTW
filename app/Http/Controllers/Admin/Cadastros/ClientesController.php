<?php

namespace App\Http\Controllers\Admin\Cadastros;

use App\Components\Biblioteca;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cadastros\ClientesRequest;
use App\Models\Cadastros\Clientes;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\View as FacadesView;

use App\Exports\ClientesExport;
use App\Models\Cadastros\RelClientesEmailsAlternativos;
use App\Models\CamposPersonalizados\ModelosGridExcel;
use App\Models\CamposPersonalizados\TipoAtividade;
use App\Traits\AjaxTrait;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

use Yajra\DataTables\DataTables;

class ClientesController extends Controller
{
    use AjaxTrait;

    /**
     * Instância dos clientes
    */
    protected $clientes, $idFuncionalidade, $modeloPadrao;

    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct(Clientes $clientes, Carbon $carbon)
    {
        $this->middleware('auth');
        $this->clientes = $clientes;  
        $this->idFuncionalidade = ($clientes)->getIdFuncionalidade();
        $this->modeloPadrao = (new ModelosGridExcel)->getModeloPadrao($this->idFuncionalidade);
        
        /** Verifica as permissões **/
        $this->middleware('can:AcessarClientes');
        $this->middleware('can:CriarClientes', ['only' => ['create', 'store']]);
        $this->middleware('can:VisualizarClientes', ['only' => ['show']]);
        $this->middleware('can:EditarClientes', ['only' => ['edit', 'update']]);
        $this->middleware('can:ExcluirClientes', ['only' => ['destroy']]);

        // Alterar para model
        $tiposAtividade = TipoAtividade::where('flg_ativo', Biblioteca::FLG_ATIVO)->get();

        // Carbon disponível em todas as views
        FacadesView::share('carbon', $carbon);

        // Envia os registros dos tipos de atividade para as views
        FacadesView::share('tiposAtividade', $tiposAtividade);

        // Envia a variável de clientes para a view
        FacadesView::share('idFuncionalidade', $this->idFuncionalidade);

        // Envia as informações do modelo padrão da funcionalidade de clientes
        FacadesView::share('modeloPadrao', $this->modeloPadrao);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = $this->clientes->all($this->modeloPadrao->colunas);

        // Pegamos as configurações padrão da index
        extract($this->defaultOptionsIndex());

        return view('Admin.cadastros.clientes.index', compact('model', 'options', 'optionsModelo', 'modelosGridExcel'));
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

        // Pegamos os registros de clientes, mas apenas nas colunas do modelo selecionado
        $model = $this->clientes->get($modeloSelecionado->colunas);

        return view('Admin.cadastros.clientes.index', compact('model', 'options', 'optionsModelo', 'modelosGridExcel', 'modeloSelecionado'));
    }

    /**
     * Função para retornarmos os registros
     * utilizando datatable
     */
    public function ajaxDataTable($idModeloSelecionado)
    {
        $modeloSelecionado = ModelosGridExcel::findOrFail($idModeloSelecionado);

        $clientes = $this->clientes->select($modeloSelecionado->colunas);
        $dataTable = DataTables::of($clientes);
        
        // Coluna para selecionar todos os registros
        $dataTable
        ->addColumn('checkbox', function ($cliente) {
            $selectAllColumn = '<input type="checkbox" class="delete-checkbox" name=delete-item-"' . $cliente->id . '" value="' . $cliente->id . '">';

            return $selectAllColumn;
        });

        // Colunas de ação
        if(Gate::allows('VisualizarClientes') || Gate::allows('EditarClientes') || Gate::allows('ExcluirClientes'))
        {
            $dataTable
            ->addColumn('action', function ($cliente) {
                $actionColumns = '';

                if(Gate::allows('VisualizarClientes'))
                    $actionColumns = '<a href="'. route('clientes.show', ['cliente' => Crypt::encryptString($cliente->id)]) .'" class="m-r-5 button-view" title='. trans('labels.show') . ' data-toggle="tooltip" data-placement="top">
                                    <i class="anticon anticon-eye"></i>
                                    <span class="m-l-3">' . trans('labels.show') . '</span>
                                </a>';

                if(Gate::allows('EditarClientes'))
                    $actionColumns .= '<a href="'. route('clientes.edit', ['cliente' => Crypt::encryptString($cliente->id)]) .'" class="m-r-5 button-edit" title='. trans('labels.edit') . ' data-toggle="tooltip" data-placement="top">
                                <i class="anticon anticon-edit"></i>
                                <span class="m-l-3">' . trans('labels.edit') . '</span>
                            </a>';

                if(Gate::allows('ExcluirClientes'))
                    $actionColumns .= '<a class="delete-button button-delete" data-name="'. $cliente->des_nome . '" data-id="' . $cliente->id . '" data-method="DELETE" data-item="' . trans('labels.cliente') . '"
                                title="' . trans('labels.delete') . '" data-toggle="tooltip" data-placement="top" onclick="deleteRegister(this)"
                                href="#"
                                data-href="' . route('clientes.destroy', ['cliente' => Crypt::encryptString($cliente->id)]) . '"> 
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
        $model = new Clientes();
        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_POST,
            'route'  => route('clientes.store')
        ];

        return view('Admin.cadastros.clientes.index', compact('model', 'options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ClientesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientesRequest $request)
    {
        try {
            $model = new Clientes();
            $model->fill($request->all())->save();

            /* Chama a função para atualizar os e-mails alternativos */
            $this->updateEmailsAlternativos($request, $model);
            
            return redirect(route('clientes.index'))->with('success', trans('messages.saved'));
        } catch (Exception $ex) {
            if(env('AMBIENTE') == 'DSV')
            {
                return back()->with('error', $ex->getMessage());
            } else {
                return back()->with('Não foi possível realizar a criação do cliente, tente novamente.');
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
        $idCliente = Biblioteca::desencriptar($id);
        $model = $this->clientes->findOrFail($idCliente);

        $options = [
            'viewName' => '_visualizar',
            'method' => Biblioteca::METHOD_SHOW,
        ];

        return view('Admin.cadastros.clientes.index', compact('model', 'options'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $idCliente = Biblioteca::desencriptar($id);
        $model = $this->clientes->findOrFail($idCliente);

        $options = [
            'viewName' => '_form',
            'method' => Biblioteca::METHOD_UPDATE,
            'route'  => route('clientes.update', $model->id),
        ];

        return view('Admin.cadastros.clientes.index', compact('model', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientesRequest $request, $id)
    {
        try {
            $model = $this->clientes->findOrFail($id);

            $data = $request->all();
            if(isset($data['password']))
            {
                $data['password'] = Hash::make($data['password']);
            } else {
                $data['password'] = $model->password;
            }

            $model->fill($data)->update();

            /* Chama a função para atualizar os e-mails alternativos */
            $this->updateEmailsAlternativos($request, $model);

            return redirect(route('clientes.index'))->with('success', trans('messages.saved'));

        } catch (Exception $ex) {
            if(env('AMBIENTE') == 'DSV')
            {
                return back()->with('error', $ex->getMessage());
            } else {
                return back()->with('Não foi possível realizar a criação do cliente, tente novamente.');
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
            $idCliente = Biblioteca::desencriptar($id);
            $model = $this->clientes->findOrFail($idCliente);

            $model->delete();

            /**
             * Enviamos também a URL de recirect pois no visualizar também
             * conseguimos deletar o cliente, após deletar, redirecionamos para a index
             */
            return response(['message' => trans('messages.deleted'), 'response' => 'ok', 'urlRedirect' => route('clientes.index')]);
        } catch (Exception $ex) {
            return response(['message' => trans('messages.delete_failed')]);
        }
    }

    /**
     * Exclui todos os clientes
     * selecionados na grid
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAllSelected()
    {
        try {
            /* Recebemos por POST o array com os IDS selecionados */
            $idsClientes = $_POST['data'];
            if(!empty($idsClientes))
            {
                foreach ($idsClientes as $key => $id)
                    $this->clientes->findOrFail($id)->delete();
            }

            return response(['message' => trans('messages.deletedAllSucess'), 'response' => 'ok']);
        } catch (Exception $ex)
        {
            return response(['message' => trans('messages.delete_failed')]);
        }
    }

    /**
     * Função para exportar o excel dos clientes
     * passamos o ID do modelo selecionado para exportar o excel com as colunas do modelo
     * 
     * @param app\Models\CamposPersonalizados\ModelosGridExcel $idModelo 
     * @return App\Exports\ClientesExport;
     */
    public function exportarExcel($idModelo)
    {
        $modeloSelecionado = ModelosGridExcel::findOrFail($idModelo);
        return new ClientesExport($modeloSelecionado->colunas);
    }

    /**
     * Atualiza os e-mails alternativos do cliente
     * independente se algum campo foi alterado ou não
    */
    protected function updateEmailsAlternativos($request, Clientes $model)
    {
        /** Excluímos todos os registros antigos e atualizamos os e-mails na tabela de relacionamento */
        if(in_array($request['_method'], [Biblioteca::METHOD_UPDATE, Biblioteca::METHOD_PUT]))
            RelClientesEmailsAlternativos::where('id_cliente', $model->id)->delete();

        if($request->get('emailsAlternativos'))
        {
            foreach ($request->get('emailsAlternativos') as $email) {
                RelClientesEmailsAlternativos::create([
                    'id_cliente' => $model->id,
                    'des_email' => $email
                ]);
            }
        }
    }

    /**
     * Função para pesquisar na base de dados se existe algum CPF/CNPJ
     * cadastrado conforme digitado, caso não exista, chamamos a função
     * no arquivo trait para pesquisar na API externa os dados.
     * 
     * Se o cliente já existir no nosso banco, enviamos a informação ao frontend
     * para que exiba a mensagem informando que não foi necessária a chamada na API
     * 
     * @param $cpfCnpj
     * @return \Illuminate\Http\Response
     */
    public function ajaxCpfCnpj($cpfCnpj)
    {
        $cliente = $this->clientes->where('des_cpf_cnpj', $cpfCnpj)->first();
        $hasCliente = true;

        /**
         * Caso não encontre o cliente na base de dados, chamamos a trait do ajax para chamada na API
         * Chamamos a função para que recebemos um json da maneira que usamos no arquivo js para popular os campos
        */
        if(!isset($cliente)) {
            $dadosRetornoApi = $this->apiCpfCnpj($cpfCnpj, true);
            $hasCliente = false;

            if(isset($dadosRetornoApi) && !isset($dadosRetornoApi->erro)) {
                $cliente = $this->isCpf($cpfCnpj) ? $this->customJson($dadosRetornoApi, true): $this->customJson($dadosRetornoApi);
            } else {
                $cliente = $dadosRetornoApi;
            }
        }

        return response()->json(['cliente' => $cliente, 'hasCliente' => $hasCliente]);
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
         * excel com os modelos da funcionalidade de Clientes
        */
        $modelosGridExcel = ModelosGridExcel::where('id_funcionalidade', $this->idFuncionalidade)->get();

        return [
            'options' => $options,
            'optionsModelo' => $optionsModelo,
            'modelosGridExcel' => $modelosGridExcel
        ];
    }

    // Função para retornar o json para o js como retornamos os dados do banco
    protected function customJson($dadosRetornoApi, $isCpf = false) {
        // Se for PF, conseguimos utilizar apenas o nome dos dados retornados pela API
        if($isCpf) {
            $returnJson = json_encode([
                'des_nome' => $dadosRetornoApi->nome,
            ]);
        } else {
            // Pegamos a primeira posição da matriz de telefones
            $telefonePrincipal = $dadosRetornoApi->telefones ? reset($dadosRetornoApi->telefones) : null;
            $returnJson = [
                'des_nome' => $dadosRetornoApi->razao,
                'des_nome_fantasia' => $dadosRetornoApi->fantasia,
                'des_telefone' => $telefonePrincipal ? $telefonePrincipal->ddd . $telefonePrincipal->numero : '',
                'des_email' => $dadosRetornoApi->email,
            ];

            // Se houver a matriz de endereço na API, inclui no array
            if(isset($dadosRetornoApi->matrizEndereco)) {
                $arrEndereco = [
                    'des_cep' => $dadosRetornoApi->matrizEndereco ? $dadosRetornoApi->matrizEndereco->cep : '',
                    'des_logradouro' => $dadosRetornoApi->matrizEndereco->logradouro,
                    'des_complemento' => $dadosRetornoApi->matrizEndereco->complemento,
                    'des_bairro' => $dadosRetornoApi->matrizEndereco->bairro,
                    'des_municipio' => $dadosRetornoApi->matrizEndereco->cidade,
                    'des_uf' => $dadosRetornoApi->matrizEndereco->uf,
                    'des_numero' => $dadosRetornoApi->matrizEndereco->numero,
                    'des_pais' => 'Brasil'
                ];

                $returnJson = array_merge($returnJson, $arrEndereco);
            }

            $returnJson = json_encode($returnJson);
        }

        return json_decode($returnJson);
    }
}
