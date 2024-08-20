<?php

use App\Livewire\ActividadEconomicas;
use App\Livewire\Ajustes;
use App\Livewire\AmbienteDestinos;
use App\Livewire\CondicionOperacions;
use App\Livewire\Departamentos;
use App\Livewire\Distritos;
use App\Livewire\DocumentoAsociados;
use App\Livewire\DocumentoContingencias;
use App\Livewire\DomicilioFiscals;
use App\Livewire\FormaPagos;
use App\Livewire\GeneracionDocumentos;
use App\Livewire\IdentificacionReceptors;
use App\Livewire\Incoterms;
use App\Livewire\ModeloFacturacions;
use App\Livewire\Municipios;
use App\Livewire\NuevoAjustes;
use App\Livewire\Pais;
use App\Livewire\Plazos;
use App\Livewire\RecintoFiscals;
use App\Livewire\Regimens;
use App\Livewire\RemisionBienes;
use App\Livewire\RetencionIvas;
use App\Livewire\TipoContingencias;
use App\Livewire\TipoDocumentos;
use App\Livewire\TipoDonacions;
use App\Livewire\TipoEstablecimientos;
use App\Livewire\TipoInvalidacions;
use App\Livewire\TipoItems;
use App\Livewire\TipoPersonas;
use App\Livewire\TipoServicioMedicos;
use App\Livewire\TipoTransmisions;
use App\Livewire\Transportes;
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
    Route::get('condicion_operacions', CondicionOperacions::class)->name('condicion_operacions')->can('Condicion_Index');
    Route::get('forma_pagos', FormaPagos::class)->name('forma_pagos')->can('Pago_Index');
    Route::get('plazos', Plazos::class)->name('plazos')->can('Plazos_Index');
    Route::get('pais', Pais::class)->name('pais')->can('Pais_Index');
    Route::get('documento_asociados', DocumentoAsociados::class)->name('documento_asociados')->can('Documento_Index');
    Route::get('identificacion_receptors', IdentificacionReceptors::class)->name('identificacion_receptors')->can('Receptor_Index');
    Route::get('documento_contingencias', DocumentoContingencias::class)->name('documento_contingencias')->can('DocContingencia_Index');
    Route::get('tipo_invalidacions', TipoInvalidacions::class)->name('tipo_invalidacions')->can('Invalidacion_Index');
    Route::get('remision_bienes', RemisionBienes::class)->name('remision_bienes')->can('Remision_Index');
    Route::get('tipo_donacions', TipoDonacions::class)->name('tipo_donacions')->can('Donacion_Index');
    Route::get('recinto_fiscals', RecintoFiscals::class)->name('recinto_fiscals')->can('Recinto_Index');
    Route::get('regimens', Regimens::class)->name('regimens')->can('Regimen_Index');
    Route::get('tipo_personas', TipoPersonas::class)->name('tipo_personas')->can('Persona_Index');
    Route::get('transportes', Transportes::class)->name('transportes')->can('Transporte_Index');
    Route::get('incoterms', Incoterms::class)->name('incoterms')->can('INCOTERMS_Index');
    Route::get('domicilio_fiscals', DomicilioFiscals::class)->name('domicilio_fiscals')->can('Fiscal_Index');
    Route::get('ajustes', Ajustes::class)->name('ajustes')->can('Ajustes_Index');
    Route::get('nuevo_ajustes', NuevoAjustes::class)->name('nuevo_ajustes');
});
