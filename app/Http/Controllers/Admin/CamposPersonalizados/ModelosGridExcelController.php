<?php

namespace App\Http\Controllers\Admin\CamposPersonalizados;

use App\Components\Biblioteca;
use App\Http\Controllers\Controller;
use App\Http\Requests\CamposPersonalizados\ModelosGridExcelRequest;
use App\Models\CamposPersonalizados\ModelosGridExcel;
use Exception;
use Illuminate\Http\Request;

class ModelosGridExcelController extends Controller
{
    /**
     * Instância dos modelos
    */
    protected $modelos;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ModelosGridExcel $modelos)
    {
        $this->middleware('auth');
        $this->modelos = $modelos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ModelosGridExcelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModelosGridExcelRequest $request)
    {
        try
        {
            $model = new ModelosGridExcel();
            $model->fill($request->all())->save();

            return response()->json(['success' => 'Cadastro realizado com sucesso']);

        } catch (Exception $ex)
        {
            if(env('AMBIENTE') == 'DSV')
            {
                return response()->json(['error' => $ex->getMessage()]);
            } else {
                return response()->json(['error' => 'Não foi possível realizar a criação do modelo.']);
            }
        }
    }

    /**
     * Função para retornar as colunas do modelo selecionado na view
     * 
     * @param $idModelo
     * @return \Illuminate\Http\Response
     */
    public function getModelo($idModelo)
    {
        $model = $this->modelos->find($idModelo);
        if($model) return response()->json($model->colunas);
            
        return response()->json(['error' => 'Não foi possível encontrar o modelo selecionado.']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ModelosGridExcelRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModelosGridExcelRequest $request, $id)
    {
        try
        {
            $model = $this->modelos->findOrFail($id);
            $model->fill($request->all())->update();

            return response()->json(['success' => trans('messages.edited')]);

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
            $model = $this->modelos->findOrFail($id);
            $model->delete();

            return response()->json(['message' => trans('messages.deleted'), 'response' => 'ok', 'urlRedirect' => route('clientes.index')]);

        } catch (Exception $ex)
        {
            return response()->json(['message' => 'Não foi possível excluir o modelo selecionado.']);
        }
    }
}
