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
        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['unidad_medida']);
            $table->foreign('unidad_medida')
                  ->references('id')
                  ->on('producto_unidad_medidas')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['unidad_medida']);

            $table->foreign('unidad_medida')
                  ->references('id')
                  ->on('producto_categorias')
                  ->onDelete('cascade');
        });
    }
};
