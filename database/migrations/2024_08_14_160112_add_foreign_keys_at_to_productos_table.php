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
            $table->unsignedBigInteger('unidad_medida')->change();
            $table->foreign('unidad_medida')->references('id')->on('producto_categorias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            Schema::table('productos', function (Blueprint $table) {
                $table->dropForeign(['unidad_medida']);
                $table->string('unidad_medida')->change();
            });
        });
    }
};
