<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Inventario extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'empresa',
        'sucursal',
        'producto',
        'existencia'
    ];

    public function Rproductos(){
        return $this->belongsTo(Producto::class,'producto');
    }
    public function Rempresa(){
        return $this->belongsTo(Empresas::class,'empresa');
    }
    public function Rsucursal(){
        return $this->belongsTo(Sucursales::class,'sucursal');
    }
}
