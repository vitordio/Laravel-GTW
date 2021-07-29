<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbCadClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_cad_clientes', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('des_cpf_cnpj', 14)->nullable(false);
            $table->string('des_inscricao_estadual', 14)->nullable(true);
            $table->string('des_nome', 60)->nullable(false);
            $table->string('des_nome_fantasia', 60)->nullable(true);
            $table->string('des_divisao', 70)->nullable(true);
            $table->string('des_telefone', 10)->nullable(true);
            $table->string('des_email', 60)->nullable(true);
            $table->bigInteger('id_tipo_atividade')->unsigned()->comment('Id do tipo da atividade selecionada');

            // Dados de acesso
            $table->string('des_login')->unique();
            $table->string('password');
            $table->rememberToken();

            // Endereços
            $table->string('des_cep', 8);
            $table->string('des_pais');
            $table->string('des_uf');
            $table->string('des_municipio', 60);
            $table->string('des_logradouro', 255);
            $table->string('des_numero', 60);
            $table->string('des_complemento', 60)->nullable(true);
            $table->string('des_bairro', 60);

            $table->char('flg_ativo', 1)->default('S');
            $table->timestamps();

            $table->foreign('id_tipo_atividade')
            ->references('id')
            ->on('tb_cad_tipo_atividade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_cad_clientes');
    }
}
