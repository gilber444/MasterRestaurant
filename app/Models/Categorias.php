<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categorias extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['categoria', 'linea'];


    public function Rlineas()
    {
        return $this->belongsTo(Lineas::class, 'linea');
    }
}
