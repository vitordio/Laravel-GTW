<?php

use App\Models\Configuracoes\Funcionalidade;
use App\Models\Configuracoes\Permissoes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelFuncionalidadePerfilTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** Atribuímos todas as permissões do sistema ao perfil de acesso administrador */
        $idPerfilAdmin = DB::table('tb_cad_perfil_acesso')->where('des_perfil', 'Administrador')->first()->id;
        Funcionalidade::all()->map(function($funcionalidade) use ($idPerfilAdmin) {
            Permissoes::all()->map(function($permissao) use ($funcionalidade, $idPerfilAdmin) {
                DB::table('tb_rel_funcionalidade_perfil')->insert([
                    'id_funcionalidade' => $funcionalidade->id,
                    'id_perfil_acesso' => $idPerfilAdmin,
                    'id_permissao' => $permissao->id
                ]);
            });
        });
    }
}
