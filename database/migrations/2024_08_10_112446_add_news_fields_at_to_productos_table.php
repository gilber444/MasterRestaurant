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
            $table->string('image')->nullable(); 
            $table->string('presentacion')->nullable(); 
            $table->decimal('csiva', 8, 4)->nullable(); 
            $table->decimal('civa', 8, 4)->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['image', 'presentacion', 'csiva', 'civa']);
        });
    }
};
