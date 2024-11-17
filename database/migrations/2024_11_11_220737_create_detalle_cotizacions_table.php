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
        Schema::create('detalle_cotizacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cotizacion');
            $table->unsignedBigInteger('producto');
            $table->decimal('cantidad', 10,4);
            $table->foreign('cotizacion')->references('id')->on('cotizaciones');
            $table->foreign('producto')->references('id')->on('productos');
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
        Schema::dropIfExists('detalle_cotizacions');
    }
};
