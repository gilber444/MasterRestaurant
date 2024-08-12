<?php

use App\Livewire\ActividadEconomicas;
use App\Livewire\AmbienteDestinos;
use App\Livewire\Departamentos;
use App\Livewire\Distritos;
use App\Livewire\GeneracionDocumentos;
use App\Livewire\ModeloFacturacions;
use App\Livewire\Municipios;
use App\Livewire\RetencionIvas;
use App\Livewire\TipoContingencias;
use App\Livewire\TipoDocumentos;
use App\Livewire\TipoEstablecimientos;
use App\Livewire\TipoItems;
use App\Livewire\TipoServicioMedicos;
use App\Livewire\TipoTransmisions;
use App\Livewire\Tributos;
use App\Livewire\UnidadMedidas;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {

    Route::get('unidad_medidas', UnidadMedidas::class)->name('unidad_medidas')->can('Unidades_Index');
    Route::get('actividad_economicas', ActividadEconomicas::class)->name('actividad_economicas')->can('Actividades_Index');
    Route::get('departamentos', Departamentos::class)->name('departamentos')->can('Departamentos_Index');
    Route::get('municipios', Municipios::class)->name('municipios')->can('Municipios_Index');
    Route::get('distritos', Distritos::class)->name('distritos')->can('Distritos_Index');
    Route::get('ambiente_destinos', AmbienteDestinos::class)->name('ambiente_destinos')->can('Ambientes_Index');
    Route::get('tipo_documentos', TipoDocumentos::class)->name('tipo_documentos')->can('Documentos_Index');
    Route::get('modelo_facturacions', ModeloFacturacions::class)->name('modelo_facturacions')->can('Facturacion_Index');
    Route::get('tipo_transmisions', TipoTransmisions::class)->name('tipo_transmisions')->can('Transmision_Index');
    Route::get('tipo_contingencias', TipoContingencias::class)->name('tipo_contingencias')->can('Contingencias_Index');
    Route::get('retencion_ivas', RetencionIvas::class)->name('retencion_ivas')->can('Retencion_Index');
    Route::get('generacion_documentos', GeneracionDocumentos::class)->name('generacion_documentos')->can('Generacion_Index');
    Route::get('tipo_establecimientos', TipoEstablecimientos::class)->name('tipo_establecimientos')->can('Establecimientos_Index');
    Route::get('tipo_servicio_medicos', TipoServicioMedicos::class)->name('tipo_servicio_medicos')->can('Servicios_Index');
    Route::get('tipo_items', TipoItems::class)->name('tipo_items')->can('Items_Index');
    Route::get('tributos', Tributos::class)->name('tributos')->can('Tributos_Index');
    //Route::get('condicion_operacions', CondicionOperacions::class)->name('condicion_operacions')->can('Condicion_Index');
});
