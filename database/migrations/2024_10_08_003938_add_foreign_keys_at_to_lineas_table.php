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
        Schema::table('lineas', function (Blueprint $table) {
            $table->unsignedBigInteger('marca')->nullable();
            $table->foreign('marca')->references('id')->on('marcas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lineas', function (Blueprint $table) {
            $table->dropForeign(['marca']);
            $table->string('marca')->change();
        });
    }
};
