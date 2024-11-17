<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevolucionesDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'devolucion',
        'producto',
        'medida',
        'unidad',
        'descargar',
        'cantidad',
        'precio',
        'descuento',
        'subtotal',
        'iva',
        'total'
    ];
}
