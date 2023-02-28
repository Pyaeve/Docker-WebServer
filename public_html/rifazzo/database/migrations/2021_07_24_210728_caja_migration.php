<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CajaMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('usuario_id')->index();
            $table->bigInteger('cliente_id')->index();
            $table->string('tipo')->index();
            $table->string('tipo_id')->index();
            $table->integer('cant')->index();
            $table->string('concepto')->index();
            $table->integer('precio')->index();
            $table->integer('ingreso')->index();
            $table->integer('egreso')->index();
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
        Schema::dropIfExists('caja');
    }
}
