<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\UnidadMedidas;
use App\Livewire\ActividadEconomicas;

Route::middleware('auth')->group(function () {

    Route::get('unidad_medidas', UnidadMedidas::class)->name('unidad_medidas')->can('Unidades_Index');
    Route::get('actividad_economicas', ActividadEconomicas::class)->name('actividad_economicas')->can('Actividades_Index');
});
