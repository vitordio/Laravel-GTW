<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbBasFuncionalidade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_bas_funcionalidade', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_menu')->unsigned()->comment('Coluna da tabela menu');
            $table->string('des_link', 500);
            $table->string('des_funcionalidade', 100)->nullable(false);
            $table->char('flg_ativo', 1)->default('S');
            $table->timestamps();
            $table->foreign('id_menu')
                ->references('id')
                ->on('tb_bas_menu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_bas_funcionalidade');
    }
}
