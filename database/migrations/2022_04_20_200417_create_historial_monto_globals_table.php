<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialMontoGlobalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_monto_globals', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('monto_global_id')->references('id')->on('monto_globals')->default(1);
            $table->double('total')->default(0);
            $table->string('fecha');
            $table->string('dia');
            $table->string('mes');
            $table->string('year');
            $table->string('descripcion');
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
        Schema::dropIfExists('historial_monto_globals');
    }
}
