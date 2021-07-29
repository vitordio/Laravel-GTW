<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbCadUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_cad_usuario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_perfil_acesso')->unsigned()->comment('Perfil de acesso do usuário');
            $table->string('des_nome');
            $table->string('des_email')->unique();
            $table->char('flg_ativo', 1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes('deleted_at', $precision = 0);
            $table->foreign('id_perfil_acesso')
            ->references('id')
            ->on('tb_cad_perfil_acesso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_cad_usuario');
    }
}
