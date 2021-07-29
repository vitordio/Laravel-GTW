<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbBasPermissoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_bas_permissoes', function(Blueprint $table) {
            $table->increments('id');
            $table->string('des_permissao')->comment('Permissão de Visualizar, Criar, Editar, Excluir');
            $table->char('flg_ativo', 1)->default('S');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_bas_permissoes');
    }
}
