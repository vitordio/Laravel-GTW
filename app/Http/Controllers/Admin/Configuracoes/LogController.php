<?php

namespace App\Http\Controllers\Admin\Configuracoes;

use App\Http\Controllers\Controller;
use App\Models\Configuracoes\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\View as FacadesView;
use Yajra\DataTables\DataTables;

class LogController extends Controller
{
    /**
     * Instância dos registros de logs
    */
    protected $logs;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Log $logs, Carbon $carbon)
    {
        $this->middleware('auth');
        $this->logs = $logs;
        
        /** Verifica as permissões **/
        $this->middleware('can:AcessarLog de Acessos');

        // Carbon disponível em todas as views
        FacadesView::share('carbon', $carbon);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = $this->logs->all();
        $options = [
            'viewName' => '_grid',
        ];

        return view('Admin.configuracoes.log.index', compact('model', 'options'));
    }

    /**
     * Função para retornarmos os registros
     * utilizando datatable
     */
    public function ajaxDataTable()
    {
        $logs = $this->logs->with('usuario')->select();

        return DataTables::of($logs)
                ->editColumn('created_at', function ($log) {
                    return Carbon::parse($log->created_at)->format('d/m/Y H:i:s');
                })
                ->make(true);
    }
}
