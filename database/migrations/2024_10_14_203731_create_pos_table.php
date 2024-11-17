<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('formas');
            $table->foreign('formas')->references('id')->on('forma_pagos');
            $table->decimal('efectivo', 10, 4)->nullable();
            $table->decimal('cambio', 10, 4)->nullable();
            $table->string('factura', 100);
            $table->string('comprobante')->nullable();
            $table->unsignedBigInteger('idC');
            $table->foreign('idC')->references('id')->on('clientes');
            $table->date('fecha')->nullable();
            $table->string('correlativo')->nullable();
            $table->string('tipoPedido');
            $table->text('direccion')->nullable();
            $table->string('estado', 50);
            $table->unsignedBigInteger('usuario');
            $table->foreign('usuario')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos');
    }
};
