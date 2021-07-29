<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $idPerfilAdmin = DB::table('tb_cad_perfil_acesso')->where('des_perfil', 'Administrador')->first()->id;

        DB::table('tb_cad_usuario')->insert([
            'id_perfil_acesso' => $idPerfilAdmin,
            'des_nome' => 'Electra Informática',
            'des_email' => 'software@electra.com.br',
            'flg_ativo' => 'S',
            'password' => Hash::make('1984ELectra@V'),
        ]);
    }
}
