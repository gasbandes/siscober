<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tx_nombres');
            $table->string('tx_apellidos');
            $table->string('cedula')->unique();
            $table->smallInteger('status')->default(1);
            $table->string('fecha_emisison')->default(date('d/m/Y'));
            $table->foreignId('gerencia_id')->references('id')->on('gerencias');
            $table->foreignId('usuario_id')->references('id')->on('users')->default(1);
            $table->foreignId('monto_global_id')->references('id')->on('monto_globals')->default(1);
            $table->string('ente');
            $table->double('saldo_disponible')->default(0);
            $table->double('saldo_consumido')->default(0);
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
        Schema::dropIfExists('personals');
    }
}
