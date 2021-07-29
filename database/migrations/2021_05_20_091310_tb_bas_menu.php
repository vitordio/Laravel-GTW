<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbBasMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_bas_menu', function(Blueprint $table) {
            $table->increments('id');
            $table->string('des_menu', 100)->nullable(false);
            $table->string('des_icon', 50)->nullable(true);
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
        Schema::dropIfExists('tb_bas_menu');
    }
}
