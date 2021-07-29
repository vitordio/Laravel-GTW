<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissoesTableSeeder::class);
        $this->call(MenuTableSeeder::class);
        $this->call(FuncionalidadeTableSeeder::class);
        $this->call(PerfilAcessoTableSeeder::class);
        $this->call(RelFuncionalidadePerfilTableSeeder::class);
        $this->call(UsuariosTableSeeder::class);
        $this->call(ModeloGridExcelPadraoTableSeeder::class);
    }
}
