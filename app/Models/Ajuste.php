<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ajuste extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['sucursal', 'detalle', 'fecha', 'tipo', 'user', 'status'];

    public function Rsucursal(){
        return $this->belongsTo(Sucursales::class,'sucursal');
    }
}
