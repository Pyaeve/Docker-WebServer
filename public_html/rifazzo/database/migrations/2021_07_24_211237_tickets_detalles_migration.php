<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TicketsDetallesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets_detalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ticket_id')->index();
            $table->bigInteger('orden')->index();
            $table->bigInteger('premio_id')->index();
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
        Schema::dropIfExists('tickets_detalles');
    }
}
