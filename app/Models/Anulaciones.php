<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anulaciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'caja',
        'sucursal',
        'empresa',
        'corte',
        'venta',
        'cajas',
        'facturador',
        'tipoPago',
        'correlativo',
        'codigo',
        'numero',
        'sello',
        'fecha',
        'hora',
        'cajero',
        'autorizado',
        'comprobante',
        'efectivo',
        'cambio',
        'subtotal',
        'descuento',
        'iva',
        'total',
        'estado'
    ];
}
