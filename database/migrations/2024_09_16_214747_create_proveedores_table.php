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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id(); 
            $table->string('nombre', 150)->nullable();
            $table->string('razon_social', 150)->nullable();
            $table->string('tipo', 100)->nullable();
            $table->unsignedBigInteger('tipoPersona');
            $table->foreign('tipoPersona')->references('id')->on('tipo_personas');
            $table->unsignedBigInteger('departamento');
            $table->foreign('departamento')->references('id')->on('departamentos');
            $table->unsignedBigInteger('municipio');
            $table->foreign('municipio')->references('id')->on('municipios');
            $table->unsignedBigInteger('distrito');
            $table->foreign('distrito')->references('id')->on('distritos');
            $table->unsignedBigInteger('actividad');
            $table->foreign('actividad')->references('id')->on('actividad_economicas');
            $table->string('direccion', 255)->nullable();
            $table->string('telefono', 9)->nullable();
            $table->string('correo', 255)->nullable();
            $table->string('registro', 20)->nullable();
            $table->string('nit', 20)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
