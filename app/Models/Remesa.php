<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa',
        'sucursal',
        'caja',
        'cajero',
        'numero',
        'fecha',
        'hora',
        'monto',
        'validador',
        'estado',
        'arqueado'
    ];
}
