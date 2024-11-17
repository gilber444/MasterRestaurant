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
        Schema::create('detalle_pos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pos');
            $table->unsignedBigInteger('producto');
            $table->decimal('cantidad', 10,4);
            $table->decimal('descargar', 10,4);
            $table->decimal('precio', 10,4);
            $table->decimal('descuento', 10,4)->nullable();
            $table->decimal('totalDescuento', 10,4)->nullable();
            $table->decimal('total', 10,4);
            $table->foreign('pos')->references('id')->on('pos');
            $table->foreign('producto')->references('id')->on('producto_menus');
            $table->unsignedBigInteger('inventario');
            $table->foreign('inventario')->references('id')->on('inventarios');
            $table->unsignedBigInteger('medida');
            $table->foreign('medida')->references('id')->on('producto_unidad_medidas');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_pos');
    }
};
