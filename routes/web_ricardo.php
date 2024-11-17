<?php

use Illuminate\Support\Facades\Route;

// Productos
use App\Livewire\Productos;
use App\Livewire\Marcas;
use App\Livewire\ProductosCategorias;
use App\Livewire\ProductosUnidadMedidas;
use App\Livewire\ProductosMarcas;
use App\Livewire\Traslados;
use App\Livewire\NuevoTraslados;
use App\Livewire\EditarTraslado;
use App\Livewire\ProgramacionMenu;
use App\Livewire\ProgramacionMenuNuevo;
use App\Livewire\ProgramacionMenuEditar;
use App\Livewire\Empleados;
use App\Livewire\Cargos;

Route::middleware('auth')->group(function () {
    Route::get('/productos/{imagen}', [Productos::class, 'renderImage'])->name('productos.mostrar')->can('Productos_Index');

    Route::get('productos', Productos::class)->name('productos')->can('Productos_Index');
    Route::get('productosCategorias', ProductosCategorias::class)->name('productosCategorias')->can('ProductosCategorias_Index');
    Route::get('productosUnidadMedidas', ProductosUnidadMedidas::class)->name('productosUnidadMedidas')->can('ProductosUnidadMedidas_Index');
    Route::get('traslados', Traslados::class)->name('traslados')->can('Traslados_Index');
    Route::get('nuevotraslados', NuevoTraslados::class)->name('nuevotraslados')->can('NuevoTraslados_Index');
    Route::get('editartraslados/{idTraslado}', EditarTraslado::class)->name('editartraslados')->can('NuevoTraslados_Index');
    Route::get('programacionmenu', ProgramacionMenu::class)->name('programacionmenu')->can('ProgramacionMenu_Index');
    Route::get('programacionmenunuevo', ProgramacionMenuNuevo::class)->name('programacionmenunuevo')->can('ProgramacionMenu_Create');
    Route::get('programacionmenueditar/{idProgmenu}', ProgramacionMenuEditar::class)->name('programacionmenueditar')->can('ProgramacionMenu_Update');

    Route::get('/marcas/{imagen}', [ProductosMarcas::class, 'renderImage'])->name('marcas.mostrar')->can('ProductosMarcas_Index')
    ;
    Route::get('/marcas_prod/{imagen}', [Marcas::class, 'renderImage'])->name('marcas_prod.mostrar')->can('Marcas_Index');

    Route::get('productosMarcas', ProductosMarcas::class)->name('productosMarcas')->can('ProductosMarcas_Index');

    Route::get('empleados', Empleados::class)->name('empleados')->can('Empleados_Index');

    Route::get('cargos', Cargos::class)->name('cargos')->can('Cargos_Index');
});