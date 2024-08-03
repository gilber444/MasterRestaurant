<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Livewire\AsignarPermisos;
use App\Livewire\Roles;
use App\Livewire\Users;
use App\Livewire\Empresas;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth')->group(function () {
    //Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('roles', Roles::class)->name('roles')->can('Roles_Index');
    Route::get('asignar', AsignarPermisos::class)->name('asignar')->can('Asignar_Permisos');
    Route::get('users', Users::class)->name('users')->can('Usuarios_Index');
    Route::get('/users/{imagen}', [Users::class, 'renderImage'])->name('user.mostrar')->can('Usuarios_Index');
    Route::get('empresas', Empresas::class)->name('empresas')->can('Empresas_Index');
    Route::get('/empresas/{imagen}', [Empresas::class, 'renderImage'])->name('empresas.mostrar')->can('Empresas_Index');

});

require __DIR__.'/auth.php';
