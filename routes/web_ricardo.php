<?php

use Illuminate\Support\Facades\Route;

// Productos
use App\Livewire\Productos;

Route::middleware('auth')->group(function () {
    Route::get('/productos/{imagen}', [Productos::class, 'renderImage'])->name('productos.mostrar')->can('Productos_Index');
    Route::get('productos', Productos::class)->name('productos')->can('Productos_Index');
});