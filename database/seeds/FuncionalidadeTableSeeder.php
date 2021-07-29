<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuncionalidadeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** Inclusão das funcionalidades iniciais do sistema **/
        $idMenuConfiguracoes = DB::table('tb_bas_menu')->where('des_menu', 'Configurações')->first()->id;
        $idMenuCadastros = DB::table('tb_bas_menu')->where('des_menu', 'Cadastros')->first()->id;
        $idMenuCamposPersonalizados = DB::table('tb_bas_menu')->where('des_menu', 'Campos Personalizados')->first()->id;

        /** Funcionalidades do menu configurações */
        DB::table('tb_bas_funcionalidade')->insert([
            'id_menu' => $idMenuConfiguracoes,
            'des_link' => 'admin/usuario',
            'des_funcionalidade' => 'Usuários',
            'flg_ativo' => 'S',
        ]);

        DB::table('tb_bas_funcionalidade')->insert([
            'id_menu' => $idMenuConfiguracoes,
            'des_link' => 'admin/log',
            'des_funcionalidade' => 'Log de Acessos',
            'flg_ativo' => 'S',
        ]);

        DB::table('tb_bas_funcionalidade')->insert([
            'id_menu' => $idMenuConfiguracoes,
            'des_link' => 'admin/menu',
            'des_funcionalidade' => 'Menus',
            'flg_ativo' => 'S',
        ]);

        DB::table('tb_bas_funcionalidade')->insert([
            'id_menu' => $idMenuConfiguracoes,
            'des_link' => 'admin/funcionalidade',
            'des_funcionalidade' => 'Funcionalidades',
            'flg_ativo' => 'S',
        ]);

        DB::table('tb_bas_funcionalidade')->insert([
            'id_menu' => $idMenuConfiguracoes,
            'des_link' => 'admin/perfilAcesso',
            'des_funcionalidade' => 'Perfis de Acesso',
            'flg_ativo' => 'S',
        ]);

        /** Funcionalidades do menu cadastro */
        DB::table('tb_bas_funcionalidade')->insert([
            'id_menu' => $idMenuCadastros,
            'des_link' => 'admin/clientes',
            'des_funcionalidade' => 'Clientes',
            'flg_ativo' => 'S',
        ]);

        /** Funcionalidades do menu Campos Personalizados */
        DB::table('tb_bas_funcionalidade')->insert([
            'id_menu' => $idMenuCamposPersonalizados,
            'des_link' => 'admin/tipoAtividade',
            'des_funcionalidade' => 'Tipo Atividade',
            'flg_ativo' => 'S',
        ]);
    }
}
