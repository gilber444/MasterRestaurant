<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tempCotizacion extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'producto', 'medida', 'nombre', 'cantidad', 'user'];
}
