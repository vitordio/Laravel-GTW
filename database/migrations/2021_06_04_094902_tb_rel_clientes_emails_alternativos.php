<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbRelClientesEmailsAlternativos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_rel_clientes_emails_alternativos', function(Blueprint $table) {
            $table->bigInteger('id_cliente')->unsigned();
            $table->string('des_email', 60)->nullable(false);

            $table->foreign('id_cliente')
            ->references('id')
            ->on('tb_cad_clientes')
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
        Schema::dropIfExists('tb_rel_clientes_emails_alternativos');
    }
}
