<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilAcessoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_cad_perfil_acesso')->insert([
            'des_perfil' => 'Administrador',
            'des_descricao_perfil' => 'Perfil de administração do sistema',
            'flg_ativo' => 'S',
        ]);
    }
}
