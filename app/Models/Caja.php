<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $fillable = [
        'caja',
        'sucursal',
        'empresa',
        'corte',
        'venta',
        'facturador',
        'tipoPago',
        'correlativo',
        'codigo',
        'numero',
        'sello',
        'fecha',
        'hora',
        'cajero',
        'comprobante',
        'efectivo',
        'cambio',
        'subtotal',
        'descuento',
        'iva',
        'percepcion',
        'total',
        'estado',
        'arqueado'
    ];

    public function Rventas()
    {
        return $this->belongsTo(Pos::class, 'venta');
    }

    public function Rcajas()
    {
        return $this->belongsTo(Parametros::class, 'caja');
    }

    public function Rcortes()
    {
        return $this->belongsTo(Cortes::class, 'corte');
    }

    public function Rcajeros()
    {
        return $this->belongsTo(User::class, 'cajero');
    }
}
