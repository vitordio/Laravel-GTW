<?php

namespace App\Exports;

use App\Models\Cadastros\Motoristas;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MotoristasExport implements FromView, Responsable, ShouldAutoSize
{
    use Exportable;

    /**
    * It's required to define the fileName within
    * the export class when making use of Responsable.
    */
    private $fileName = 'motoristas.xlsx';
    
    /**
    * Optional Writer Type
    */
    private $writerType = Excel::XLSX;

    /**
     * Instânciamos as colunas e passamos via construtor
     * pois na controller, enviamos quais colunas devem ir para o excel
     */
    protected $columns;

    public function __construct(array $columns)
    {
        $this->columns = $columns;    
    }

    public function view(): View
    {
        return view('Admin.cadastros.motoristas.excel', [
            'motoristas' => Motoristas::all($this->columns),
            'colunas' => $this->columns
        ]);
    }
}
