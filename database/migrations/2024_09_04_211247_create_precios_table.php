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
        Schema::create('precios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto');
            $table->foreign('producto')->references('id')->on('producto_menus');
            $table->unsignedBigInteger('lineaP');
            $table->foreign('lineaP')->references('id')->on('lineas');
            $table->unsignedBigInteger('categoriaP');
            $table->foreign('categoriaP')->references('id')->on('categorias');
            $table->string('cantidadP', 10, 2);
            $table->string('costo', 10, 4);
            $table->string('costoIva', 10, 4);
            $table->string('utilidad', 10, 2);
            $table->string('precioVenta', 10, 4);
            $table->string('precioVentaIva', 10, 4);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precios');
    }
};
