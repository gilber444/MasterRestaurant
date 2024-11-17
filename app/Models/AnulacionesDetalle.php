<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnulacionesDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'anulacion',
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
