<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Actividades;
use App\Livewire\AsignarPermisos;
use App\Livewire\Categorias;
use App\Livewire\EditarProducto;
use App\Livewire\Empresas;
use App\Livewire\FormaVentas;
use App\Livewire\Inventarios;
use App\Livewire\Kardexs;
use App\Livewire\Lineas;
use App\Livewire\Marcas;
use App\Livewire\Parametros;
use App\Livewire\ProductoMenus;
use App\Livewire\Roles;
use App\Livewire\Sucursales;
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
    Route::get('/dashboard/{imagen}', [Users::class, 'renderImagen'])->name('dashboard.mostrar');
    Route::get('roles', Roles::class)->name('roles')->can('Roles_Index');
    Route::get('asignar', AsignarPermisos::class)->name('asignar')->can('Asignar_Permisos');
    Route::get('users', Users::class)->name('users')->can('Usuarios_Index');
    Route::get('/users/{imagen}', [Users::class, 'renderImage'])->name('user.mostrar')->can('Usuarios_Index');
    Route::get('empresa', Empresas::class)->can('Empresas_Index')->name('empresa');
    Route::get('/empresa/{imagen}', [Empresas::class, 'renderImage'])->name('empresas.mostrar')->can('Empresas_Index');
    Route::get('sucursal', Sucursales::class)->can('Sucursales_Index')->name('sucursal');
    Route::get('parametro', Parametros::class)->can('Sucursales_Index')->name('parametro');
    Route::get('kardex', Kardexs::class)->can('Kardex_Index')->name('kardex');
    Route::get('inventario', Inventarios::class)->can('Inventarios_Index')->name('inventario');
    Route::get('marcas', Marcas::class)->can('Marcas_Index')->name('marcas');
    Route::get('lineas', Lineas::class)->can('Lineas_Index')->name('lineas');
    Route::get('categorias', Categorias::class)->can('Categorias_Index')->name('categorias');
    Route::get('forma_ventas', FormaVentas::class)->can('FormaVenta_Index')->name('forma_ventas');
    Route::get('producto_menus', ProductoMenus::class)->can('ProductoMenu_Index')->name('producto_menus');
    Route::get('EditarProducto/{id}', EditarProducto::class)->name('EditarProducto');
    Route::get('actividades', Actividades::class)->name('actividades')->can('Actividades_Index');
});

require __DIR__.'/auth.php';
require __DIR__.'/web_ricardo.php';
require __DIR__.'/web_javier.php';
