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
        Schema::create('receta_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto');
            $table->foreign('producto')->references('id')->on('producto_menus');
            $table->unsignedBigInteger('producto_primary');
            $table->foreign('producto_primary')->references('id')->on('productos');
            $table->unsignedBigInteger('unidad');
            $table->foreign('unidad')->references('id')->on('producto_unidad_medidas');
            $table->string('cantidad', 10, 3);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receta_productos');
    }
};
