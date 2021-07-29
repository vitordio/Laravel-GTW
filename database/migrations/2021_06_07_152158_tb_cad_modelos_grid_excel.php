<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbCadModelosGridExcel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Tabela que guardará os modelos de exibição da grid e download do excel
         */
        Schema::create('tb_cad_modelos_grid_excel', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_funcionalidade')->unsigned()->comment('Referencia a qual funcionalidade o modelo pertence');
            $table->string('des_modelo', 60)->nullable(false);
            $table->json('colunas');

            $table->timestamps();
            $table->foreign('id_funcionalidade')
            ->references('id')
            ->on('tb_bas_funcionalidade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_cad_modelos_grid_excel');
    }
}
