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
        Schema::create('parametros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa');
            $table->foreign('empresa')->references('id')->on('empresas');
            $table->unsignedBigInteger('sucursal');
            $table->foreign('sucursal')->references('id')->on('sucursales');
            $table->string('caja', 20);
            $table->string('token', 25);
            $table->string('full', 5)->nullable();
            $table->string('slip', 5)->nullable();
            $table->string('multiple', 5)->nullable();
            $table->string('centralizada', 5)->nullable();
            $table->string('ticket', 5)->nullable();
            $table->integer('tcorrelativo')->nullable();
            $table->string('consumidor', 5)->nullable();
            $table->integer('concorrelativo')->nullable();
            $table->string('credito', 5)->nullable();
            $table->integer('crecorrelativo')->nullable();
            $table->string('cotizacion', 5)->nullable();
            $table->integer('cocorrelativo')->nullable();
            $table->string('efectivo', 5)->nullable();
            $table->string('cheque', 5)->nullable();
            $table->string('tarjeta', 5)->nullable();
            $table->string('creditos', 5)->nullable();
            $table->string('bono', 5)->nullable();
            $table->string('xlinea', 5)->nullable();
            $table->string('xvendedor', 5)->nullable();
            $table->string('arqueo', 5)->nullable();
            $table->integer('tasa')->nullable();
            $table->decimal('ventamin', 10, 4)->nullable();
            $table->string('obligatoriocredito', 5)->nullable();
            $table->string('estado', 50)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametros');
    }
};
