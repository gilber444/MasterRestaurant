<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temptraslado extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo',
        'producto',
        'medida',
        'nombre',
        'cantidad',
        'costo',
        'total',
        'user'
    ];


}
