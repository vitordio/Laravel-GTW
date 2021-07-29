<?php

namespace App\Http\Controllers\Admin\Consultas;

use App\Http\Controllers\Controller;
use App\Traits\AjaxTrait;
use Illuminate\Http\Request;

class CpfCnpjController extends Controller
{
    use AjaxTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:AcessarCPF/CNPJ');
    }

    /**
     * Single action controller para realizarmos apenas
     * as consultas e exibições dos dados do CPF ou CNPJ digitados
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        /** Enviamos o old input para a view */
        session()->flashInput($request->input());

        if(!empty($request->all())) {
            if(!isset($request->cpf_cnpj) || $request->cpf_cnpj === '') 
                return back()
                        ->with('errorCpfCnpj', trans('messages.cpfCnpjObrigatorio'));

            
            /** Chamamos a trait do ajax para chamada na API **/
            $dadosRetornoApi = $this->apiCpfCnpj($request->cpf_cnpj);

            /** Caso dê algum erro, retornamos a mensagem do erro na tela */
            if(isset($dadosRetornoApi->erro))
                return back()
                        ->with('error', $dadosRetornoApi->erro);
        }

        return view('Admin.consultas.cpfCnpj.index', compact('request->input()', 'dadosRetornoApi'));
    }
}
