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
        Schema::create('producto_menus', function (Blueprint $table) {
            $table->id();
            $table->string('producto', 255);
            $table->unsignedBigInteger('marca');
            $table->unsignedBigInteger('linea');
            $table->unsignedBigInteger('categoria');
            $table->unsignedBigInteger('forma_venta');
            $table->foreign('marca')->references('id')->on('marcas');
            $table->foreign('linea')->references('id')->on('lineas');
            $table->foreign('categoria')->references('id')->on('categorias');
            $table->foreign('forma_venta')->references('id')->on('forma_ventas');
            $table->enum('comun', ['SI', 'NO'])->default('No');
            $table->enum('status', ['Activo', 'Desactivado'])->default('Desactivado');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_menus');
    }
};
