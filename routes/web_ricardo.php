<?php

use Illuminate\Support\Facades\Route;

// Productos
use App\Livewire\Productos;

Route::middleware('auth')->group(function () {

    Route::get('productos', Productos::class)->name('productos');
});