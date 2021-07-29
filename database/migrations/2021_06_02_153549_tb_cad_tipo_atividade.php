<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbCadTipoAtividade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_cad_tipo_atividade', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('des_atividade', 50)->nullable(false);
            $table->char('flg_ativo', 1)->default('S');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_cad_tipo_atividade');
    }
}
