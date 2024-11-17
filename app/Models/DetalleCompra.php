<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleCompra extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['compra', 'producto', 'inventario', 'medida', 'cantidad', 'costo', 'total'
    ];

    public function Rproductos(){
        return $this->belongsTo(Producto::class,'producto');
    }

    public function Rcompra(){
        return $this->belongsTo(Compra::class,'compra');
    }

    public function Rinventario(){
        return $this->belongsTo(Inventario::class,'inventario');
    }

    public function Rmedida(){
        return $this->belongsTo(UnidadMedida::class,'medida');
    }
}
