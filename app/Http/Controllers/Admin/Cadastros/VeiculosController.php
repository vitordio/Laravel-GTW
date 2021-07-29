<?php

namespace App\Http\Controllers\Admin\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Cadastros\Veiculos;
use Illuminate\Http\Request;

class VeiculosController extends Controller
{
    /**
     * Instância dos veículos
    */
    protected $veiculos;

    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct(Veiculos $veiculos)
    {
        $this->middleware('auth');
        $this->veiculos = $veiculos;  
        
        /** Verifica as permissões **/
        $this->middleware('can:AcessarVeículos');
        $this->middleware('can:CriarVeiculos', ['only' => ['create', 'store']]);
        $this->middleware('can:VisualizarVeiculos', ['only' => ['show']]);
        $this->middleware('can:EditarVeiculos', ['only' => ['edit', 'update']]);
        $this->middleware('can:ExcluirVeiculos', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
