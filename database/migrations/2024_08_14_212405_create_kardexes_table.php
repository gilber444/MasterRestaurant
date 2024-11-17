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
        Schema::create('kardexes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa');
            $table->foreign('empresa')->references('id')->on('empresas');

            $table->unsignedBigInteger('sucursal');
            $table->foreign('sucursal')->references('id')->on('sucursales');

            $table->unsignedBigInteger('producto');
            $table->foreign('producto')->references('id')->on('productos');

            $table->unsignedBigInteger('inventario');
            $table->foreign('inventario')->references('id')->on('inventarios');

            $table->date('fecha');
            $table->time('hora');
            $table->string('descripcion');
            $table->decimal('ingreso', 10, 2)->default(0);
            $table->decimal('totalingreso', 14, 4)->default(0);
            $table->decimal('egreso', 10, 2)->default(0);
            $table->decimal('totalegreso', 14, 4)->default(0);
            $table->decimal('costoUmovimiento', 14, 4)->default(0);
            $table->decimal('costoUnitario', 14, 4)->default(0);
            $table->decimal('saldo', 10, 2)->default(0);
            $table->decimal('saldototal', 14, 4)->default(0);
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kardexes');
    }
};
