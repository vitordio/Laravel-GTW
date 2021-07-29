<?php

use App\Components\Biblioteca;
use App\Models\Cadastros\Clientes;
use App\Models\Cadastros\Motoristas;
use App\Models\Configuracoes\Funcionalidade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModeloGridExcelPadraoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Criação do modelo padrão de grid para a tabela de clientes
        $idFuncionalidadeCliente = Funcionalidade::where('id', (new Clientes())->getIdFuncionalidade())->first()->id;
        
        DB::table('tb_cad_modelos_grid_excel')->insert([
            'id_funcionalidade' => $idFuncionalidadeCliente,
            'des_modelo' => Biblioteca::MODELO_PADRAO,
            'colunas' =>  '["id", "des_cpf_cnpj", "des_inscricao_estadual", "des_nome", "des_telefone", "des_email"]',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Criação do modelo padrão de grid para a tabela de motoristas
        $idFuncionalidadeMotoristas = Funcionalidade::where('id', (new Motoristas())->getIdFuncionalidade())->first()->id;
        
        DB::table('tb_cad_modelos_grid_excel')->insert([
            'id_funcionalidade' => $idFuncionalidadeMotoristas,
            'des_modelo' => Biblioteca::MODELO_PADRAO,
            'colunas' =>  '["id", "des_nome", "des_cpf", "des_cnh", "des_rg", "des_apelido"]',
            'created_at' => date('Y-m-d H:i:s')
        ]);

    }
}
