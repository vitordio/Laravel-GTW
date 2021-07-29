<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbCadPerfilAcesso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_cad_perfil_acesso', function(Blueprint $table) {
            $table->increments('id');
            $table->string('des_perfil')->comment('Nome do perfil de acesso');
            $table->string('des_descricao_perfil')->comment('Descrição do perfil de acesso');
            $table->char('flg_ativo', 1)->default('S');
            $table->timestamps();
            $table->softDeletes('deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_cad_perfil_acesso');
    }
}
