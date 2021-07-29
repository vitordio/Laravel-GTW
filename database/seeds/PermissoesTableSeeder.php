<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** Inclusão das permissões iniciais (Criar, Visualizar, Editar, Excluri e Gerar Relatório) */
        DB::table('tb_bas_permissoes')->insert([
            'des_permissao' => 'Criar',
            'flg_ativo' => 'S',
        ]);

        DB::table('tb_bas_permissoes')->insert([
            'des_permissao' => 'Visualizar',
            'flg_ativo' => 'S',
        ]);

        DB::table('tb_bas_permissoes')->insert([
            'des_permissao' => 'Editar',
            'flg_ativo' => 'S',
        ]);

        DB::table('tb_bas_permissoes')->insert([
            'des_permissao' => 'Excluir',
            'flg_ativo' => 'S',
        ]);

        DB::table('tb_bas_permissoes')->insert([
            'des_permissao' => 'Gerar Relatório',
            'flg_ativo' => 'S',
        ]);

    }
}
