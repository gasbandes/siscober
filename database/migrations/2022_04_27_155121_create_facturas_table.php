<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fecha_factura');
            $table->string('nu_factura');
            $table->string('nu_control');
            $table->foreignId('proveedor_id')->references('id')->on('proveedores')->default(1);
            $table->foreignId('personal_id')->references('id')->on('personals')->default(1);
            $table->integer('beneficiario_id')->unsigned()->nullable();
            $table->foreign('beneficiario_id')->references('id')->on('beneficiarios');
            $table->double('base_importe')->default(0);
            $table->double('iva')->default(0);
            $table->double('total_factura')->default(0);
            $table->double('total_dolar')->default(0);
            $table->double('monto_pagado')->default(0);
            $table->string('titular_beneficiario')->nullable();
            $table->smallInteger('status');
            $table->string('fecha_emision')->default(date('Y-m-d'));           
            $table->foreignId('usuario_id')->references('id')->on('users')->default(1);
            $table->foreignId('tasa_id')->references('id')->on('tasas')->default(1);
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
        
        Schema::dropIfExists('facturas');
    }
}
