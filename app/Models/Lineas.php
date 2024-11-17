<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lineas extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['linea', 'marca'];


    public function Rmarcas()
    {
        return $this->belongsTo(Marcas::class, 'marca');
    }
}
