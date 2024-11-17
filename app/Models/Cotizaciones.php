<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cotizaciones extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['numero', 'fecha', 'proveedor', 'user', 'observaciones', 'estado'];

    public function Rproveedor()
    {
        return $this->belongsTo(Proveedores::class, 'proveedor');
    }

    public function Rusuario(){
        return $this->belongsTo(User::class,'user');
    }
}
