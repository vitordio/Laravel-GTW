<?php

namespace App\Exports;

use App\Models\Cadastros\Clientes;
use Maatwebsite\Excel\Excel;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ClientesExport implements FromView, Responsable, ShouldAutoSize
{
    use Exportable;
    
    /**
    * It's required to define the fileName within
    * the export class when making use of Responsable.
    */
    private $fileName = 'clientes.xlsx';
    
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
        return view('Admin.cadastros.clientes.excel', [
            'clientes' => Clientes::all($this->columns),
            'colunas' => $this->columns
        ]);
    }

}