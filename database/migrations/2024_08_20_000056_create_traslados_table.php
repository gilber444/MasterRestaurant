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
        Schema::create('traslados', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sorigen');
            $table->foreign('sorigen')->references('id')->on('sucursales');

            $table->unsignedBigInteger('sdestino');
            $table->foreign('sdestino')->references('id')->on('sucursales');

            $table->integer('correlativo');
            $table->date('fecha');
            $table->string('detalle');

            $table->unsignedBigInteger('solicitante');
            $table->foreign('solicitante')->references('id')->on('users');

            $table->unsignedBigInteger('autorizacion');
            $table->foreign('autorizacion')->references('id')->on('users');

            $table->dateTime('fechaautorizado')->nullable();
            $table->enum('estado', ['Solicitado', 'Autorizado', 'Rechazado'])->default('Solicitado');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traslados');
    }
};
