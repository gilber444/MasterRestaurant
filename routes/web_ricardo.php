<?php

use Illuminate\Support\Facades\Route;

// Productos
use App\Livewire\Productos;
use App\Livewire\ProductosCategorias;
use App\Livewire\ProductosUnidadMedidas;
use App\Livewire\Traslados;
use App\Livewire\NuevoTraslados;

Route::middleware('auth')->group(function () {
    Route::get('/productos/{imagen}', [Productos::class, 'renderImage'])->name('productos.mostrar')->can('Productos_Index');
    Route::get('productos', Productos::class)->name('productos')->can('Productos_Index');
    Route::get('productosCategorias', ProductosCategorias::class)->name('productosCategorias')->can('ProductosCategorias_Index');
    Route::get('productosUnidadMedidas', ProductosUnidadMedidas::class)->name('productosUnidadMedidas')->can('ProductosUnidadMedidas_Index');
    Route::get('traslados', Traslados::class)->name('traslados')->can('Traslados_Index');
    Route::get('nuevotraslados', NuevoTraslados::class)->name('nuevotraslados')->can('NuevoTraslados_Index');
});