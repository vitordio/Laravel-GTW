<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** Inclusão dos menus iniciais do sistema **/
        DB::table('tb_bas_menu')->insert([
            'des_menu' => 'Dashboard',
            'des_icon' => 'dashboard',
            'flg_ativo' => 'S',
        ]);

        DB::table('tb_bas_menu')->insert([
            'des_menu' => 'Configurações',
            'des_icon' => 'setting',
            'flg_ativo' => 'S',
        ]);

        DB::table('tb_bas_menu')->insert([
            'des_menu' => 'Cadastros',
            'des_icon' => 'plus-circle',
            'flg_ativo' => 'S',
        ]);

        DB::table('tb_bas_menu')->insert([
            'des_menu' => 'Campos Personalizados',
            'des_icon' => 'edit',
            'flg_ativo' => 'S',
        ]);
    }
}
