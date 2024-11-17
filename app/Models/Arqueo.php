<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Arqueo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'numero',
        'fecha',
        'hora',
        'caja',
        'sucursal',
        'empresa',
        'cajero',
        'tipo',
        'efectivo',
        'tarjeta',
        'cheque',
        'credito',
        'subtotalPagos',
        'devoluciones',
        'anulaciones',
        'remesas',
        'percepcion',
        'sumaTotales',
        'ticketDesde',
        'ticketHasta',
        'gravadosT',
        'ivaT',
        'subT',
        'totalT',
        'consumidorDesde',
        'consumidorHasta',
        'gravadosCon',
        'ivaCon',
        'subCon',
        'totalCon',
        'CreDesde',
        'CreHasta',
        'gravadosCre',
        'ivaCre',
        'subCre',
        'totalCre',
        'dteDesde',
        'dteHasta',
        'gravadosDTE',
        'ivaDTE',
        'subDTE',
        'totalDTE',
        'creditosDesde',
        'creditosHasta',
        'gravadosCredi',
        'ivaCredi',
        'subCredi',
        'totalCredi',
        'totalGeneral',
        'ivaGeneral',
        'percepcion',
        'subGeneral',
        'totalPercepcion',
        'totalGlobal',
        'totalEfectivo',
        'diferencia'
    ];

    // Define las relaciones con otras tablas si es necesario
    public function cajas()
    {
        return $this->belongsTo(Parametros::class, 'caja');
    }

    public function sucursales()
    {
        return $this->belongsTo(Sucursales::class, 'sucursal');
    }

    public function empresas()
    {
        return $this->belongsTo(Empresas::class, 'empresa');
    }

    public function usuarios()
    {
        return $this->belongsTo(User::class, 'cajero');
    }
}
