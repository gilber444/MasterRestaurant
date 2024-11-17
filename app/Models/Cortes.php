<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cortes extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable =[
        'caja',
        'sucursal',
        'empresa',
        'corte',
        'fecha',
        'hora',
        'estado',
        'efectivo',
        'tarjeta',
        'cheque',
        'credito',
        'subtotalPagos',
        'devoluciones',
        'anulaciones',
        'remesas',
        'percepcion',
        'cortes',
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
        'subGeneral',
        'totalPercepcion',
        'totalGlobal',
        'totalEfectivo',
        'diferencia'
    ];

    public function Rparametros()
    {
        return $this->belongsTo(Parametros::class, 'caja');
    }

    public function Rsucursal()
    {
        return$this->belongsTo(Sucursales::class, 'sucursal');
    }

    public function Rempresa()
    {
        return$this->belongsTo(Empresas::class, 'empresa');
    }
}
