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
        Schema::create('temp_compras', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->integer('producto');
            $table->integer('medida');
            $table->string('nombre');
            $table->decimal('cantidad',10,2);
            $table->decimal('costo', 10,4);
            $table->decimal('total', 10, 4);
            $table->integer('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_compras');
    }
};
