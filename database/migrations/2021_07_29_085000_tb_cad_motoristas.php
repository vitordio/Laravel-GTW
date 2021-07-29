<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbCadMotoristas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_cad_motoristas', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('des_cpf', 14);
            $table->string('des_nome');
            $table->string('des_rntrc', 8);
            $table->string('des_cnh')->nullable();
            $table->string('des_uf_cnh')->nullable();

            $table->char('flg_ativo', 1)->default('S');
            $table->timestamps();

            // Dados complementares
            $table->string('des_apelido')->nullable();
            $table->string('des_rg')->nullable();
            $table->string('des_orgao_expedidor')->nullable();
            $table->string('des_pis')->nullable();
            $table->string('des_inss')->nullable();
            $table->string('dat_nascimento')->nullable();
            $table->string('des_telefone', 10)->nullable();
            $table->string('des_email', 60)->nullable();

            // Endereços
            $table->string('des_cep', 8);
            $table->string('des_pais');
            $table->string('des_uf');
            $table->string('des_municipio', 60);
            $table->string('des_logradouro', 255);
            $table->string('des_numero', 60);
            $table->string('des_complemento', 60)->nullable(true);
            $table->string('des_bairro', 60);

            // Dados bancários
            $table->bigInteger('id_banco')->nullable()->unsigned()->comment('Id do banco selecionad');
            $table->string('des_agencia')->nullable();
            $table->string('des_conta')->nullable();
            $table->string('des_tipo_conta')->nullable();

            // Foreign Keys
            $table->foreign('id_banco')
            ->references('id')
            ->on('tb_cad_bancos')
            ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_cad_motoristas');
    }
}
