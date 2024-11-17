<?php

use App\Livewire\ActividadEconomicas;
use App\Livewire\Ajustes;
use App\Livewire\AmbienteDestinos;
use App\Livewire\Clientes;
use App\Livewire\Compras;
use App\Livewire\CondicionOperacions;
use App\Livewire\Cotizaciones;
use App\Livewire\Departamentos;
use App\Livewire\Distritos;
use App\Livewire\DocumentoAsociados;
use App\Livewire\DocumentoContingencias;
use App\Livewire\DomicilioFiscals;
use App\Livewire\EditarAjustes;
use App\Livewire\EditarCompras;
use App\Livewire\Facturas;
use App\Livewire\FormaPagos;
use App\Livewire\GeneracionDocumentos;
use App\Livewire\IdentificacionReceptors;
use App\Livewire\Incoterms;
use App\Livewire\ModeloFacturacions;
use App\Livewire\Municipios;
use App\Livewire\NuevaCompra;
use App\Livewire\NuevaCotizacion;
use App\Livewire\NuevoAjustes;
use App\Livewire\Pais;
use App\Livewire\Plazos;
use App\Livewire\Pos;
use App\Livewire\Proveedores;
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

    Route::get('unidad_medidas', UnidadMedidas::class)->name('unidad_medidas');
    Route::get('actividad_economicas', ActividadEconomicas::class)->name('actividad_economicas');
    Route::get('departamentos', Departamentos::class)->name('departamentos');
    Route::get('municipios', Municipios::class)->name('municipios');
    Route::get('distritos', Distritos::class)->name('distritos');
    Route::get('ambiente_destinos', AmbienteDestinos::class)->name('ambiente_destinos');
    Route::get('tipo_documentos', TipoDocumentos::class)->name('tipo_documentos');
    Route::get('modelo_facturacions', ModeloFacturacions::class)->name('modelo_facturacions');
    Route::get('tipo_transmisions', TipoTransmisions::class)->name('tipo_transmisions');
    Route::get('tipo_contingencias', TipoContingencias::class)->name('tipo_contingencias');
    Route::get('retencion_ivas', RetencionIvas::class)->name('retencion_ivas');
    Route::get('generacion_documentos', GeneracionDocumentos::class)->name('generacion_documentos');
    Route::get('tipo_establecimientos', TipoEstablecimientos::class)->name('tipo_establecimientos');
    Route::get('tipo_servicio_medicos', TipoServicioMedicos::class)->name('tipo_servicio_medicos');
    Route::get('tipo_items', TipoItems::class)->name('tipo_items');
    Route::get('tributos', Tributos::class)->name('tributos');
    Route::get('condicion_operacions', CondicionOperacions::class)->name('condicion_operacions');
    Route::get('forma_pagos', FormaPagos::class)->name('forma_pagos');
    Route::get('plazos', Plazos::class)->name('plazos');
    Route::get('pais', Pais::class)->name('pais');
    Route::get('documento_asociados', DocumentoAsociados::class)->name('documento_asociados');
    Route::get('identificacion_receptors', IdentificacionReceptors::class)->name('identificacion_receptors');
    Route::get('documento_contingencias', DocumentoContingencias::class)->name('documento_contingencias');
    Route::get('tipo_invalidacions', TipoInvalidacions::class)->name('tipo_invalidacions');
    Route::get('remision_bienes', RemisionBienes::class)->name('remision_bienes');
    Route::get('tipo_donacions', TipoDonacions::class)->name('tipo_donacions');
    Route::get('recinto_fiscals', RecintoFiscals::class)->name('recinto_fiscals');
    Route::get('regimens', Regimens::class)->name('regimens');
    Route::get('tipo_personas', TipoPersonas::class)->name('tipo_personas');
    Route::get('transportes', Transportes::class)->name('transportes');
    Route::get('incoterms', Incoterms::class)->name('incoterms');
    Route::get('domicilio_fiscals', DomicilioFiscals::class)->name('domicilio_fiscals');
    Route::get('ajustes', Ajustes::class)->name('ajustes');
    Route::get('nuevo_ajustes', NuevoAjustes::class)->name('nuevo_ajustes');
    Route::get('editar_ajustes/{idAjuste}', EditarAjustes::class)->name('editar_ajustes');
    Route::get('facturas', Facturas::class)->name('facturas');
    Route::get('proveedores', Proveedores::class)->name('proveedores');
    Route::get('compras', Compras::class)->name('compras');
    Route::get('nueva_compra', NuevaCompra::class)->name('nueva_compra');
    Route::get('editar_compras/{selected_id}', EditarCompras::class)->name('editar_compras');
    Route::get('producto', NuevaCompra::class)->name('producto');
    Route::get('clientes', Clientes::class)->name('clientes');
    Route::get('/pos/{id}', Pos::class)->name('pos');
    Route::get('cotizaciones', Cotizaciones::class)->name('cotizaciones');
    Route::get('nueva_cotizacion', NuevaCotizacion::class)->name('nueva_cotizacion');

});