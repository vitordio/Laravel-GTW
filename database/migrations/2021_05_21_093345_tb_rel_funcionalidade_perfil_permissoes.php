<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbRelFuncionalidadePerfilPermissoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_rel_funcionalidade_perfil', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_funcionalidade')->unsigned();
            $table->integer('id_perfil_acesso')->unsigned();
            $table->integer('id_permissao')->unsigned();
            $table->foreign('id_funcionalidade')
            ->references('id')
            ->on('tb_bas_funcionalidade')->onDelete('cascade');
            $table->foreign('id_perfil_acesso')
            ->references('id')
            ->on('tb_cad_perfil_acesso')->onDelete('cascade');;
            $table->foreign('id_permissao')
            ->references('id')
            ->on('tb_bas_permissoes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_rel_funcionalidade_perfil');
    }
}
