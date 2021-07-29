<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbBasLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_bas_log', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_usuario')->unsigned()->comment('ID do Usuario que realizou a acao');
            $table->string('des_acao');
            $table->longText('des_url')->nullable();
            $table->ipAddress('num_ip')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at', $precision = 0);
            $table->foreign('id_usuario')
                ->references('id')
                ->on('tb_cad_usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_bas_log');
    }
}
