<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\ActividadEconomicas;
use App\Livewire\AsignarPermisos;
use App\Livewire\Roles;
use App\Livewire\UnidadMedidas;
use App\Livewire\Users;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('roles', Roles::class)->name('roles')->can('Roles_Index');
    Route::get('asignar', AsignarPermisos::class)->name('asignar')->can('Asignar_Permisos');
    Route::get('users', Users::class)->name('users')->can('Usuarios_Index');
    Route::get('/users/{imagen}', [Users::class, 'renderImage'])->name('user.mostrar')->can('Usuarios_Index');
    Route::get('unidad_medidas', UnidadMedidas::class)->name('unidad_medidas')->can('Unidades_Index');
    Route::get('actividad_economicas', ActividadEconomicas::class)->name('actividad_economicas')->can('Actividades_Index');

});

require __DIR__.'/auth.php';
