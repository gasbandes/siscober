<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMontoGlobalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monto_globals', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('usuario_id')->references('id')->on('users')->default(1);
            $table->double('total')->default(0);
            $table->string('fecha');
            $table->string('dia');
            $table->string('mes');
            $table->string('year');
            $table->smallInteger('status')->default(0);
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
        Schema::dropIfExists('monto_globals');
    }
}
