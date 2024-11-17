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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->unsignedBigInteger('factura');
            $table->foreign('factura')->references('id')->on('facturas');
            $table->integer('correlativo');
            $table->string('serie', 20)->nullable();
            $table->date('fechaCompra');
            $table->decimal('saldo', 10,2);
            $table->decimal('total', 10,2);
            $table->unsignedBigInteger('condicionPago');
            $table->foreign('condicionPago')->references('id')->on('condicion_operacions');
            $table->string('vendedor', 150)->nullable();
            $table->date('fechaPago')->nullable();
            $table->unsignedBigInteger('proveedor');
            $table->foreign('proveedor')->references('id')->on('proveedores');
            $table->unsignedBigInteger('sucursal');
            $table->foreign('sucursal')->references('id')->on('sucursales');
            $table->unsignedBigInteger('user');
            $table->foreign('user')->references('id')->on('users');
            $table->string('observaciones', 255)->nullable();
            $table->string('estado', 50);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
