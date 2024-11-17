<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tempPos extends Model
{
    use HasFactory;

    protected $fillable = ['marca', 'producto', 'observaciones', 'nombre', 'cantidad', 'costo',
        'total', 'user'
    ];
}
