<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResumenDte extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected$fillable = [
        'dte',
        'totalNoSuj',
        'totalExenta',
        'totalGravada',
        'totalIva',
        'subTotalVentas',
        'descuNoSuj',
        'descuExenta',
        'descuGravada',
        'porcentajeDescuento',
        'totalDescu',
        'tributo',
        'codigo',
        'descripcion',
        'valor',
        'subTotal',
        'ivaPerci1',
        'ivaRete1',
        'reteRenta',
        'montoTotalOperacion',
        'totalNoGravado',
        'totalPagar',
        'totalLetras',
        'saldoFavor',
        'condicionOperacion',
        'pagos',
        'montoPagado',
        'refencia',
        'palzo',
        'periodo',
        'numPagoElectronico'
    ];
}
