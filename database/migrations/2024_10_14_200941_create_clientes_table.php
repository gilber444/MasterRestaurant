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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombreCliente');
            $table->string('nit')->nullable();
            $table->string('dui')->nullable();
            $table->string('registro')->nullable();
            $table->string('correo')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->text('direccion')->nullable();
            $table->unsignedBigInteger('departamento');
            $table->unsignedBigInteger('municipio');
            $table->unsignedBigInteger('tipoPersona');
            $table->enum('homologado', ['NO', 'SI'])->default('NO');
            $table->unsignedBigInteger('distrito');
            $table->string('tipoCliente');
            $table->unsignedBigInteger('actividad');
            $table->unsignedBigInteger('identificacion');
            $table->foreign('identificacion')->references('id')->on('identificacion_receptors');
            $table->foreign('actividad')->references('id')->on('actividad_economicas');
            $table->foreign('departamento')->references('id')->on('departamentos');
            $table->foreign('municipio')->references('id')->on('municipios');
            $table->foreign('distrito')->references('id')->on('distritos');
            $table->foreign('tipoPersona')->references('id')->on('tipo_personas');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_pos');
    }
};
