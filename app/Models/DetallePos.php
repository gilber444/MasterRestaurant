<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetallePos extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['pos', 'producto', 'cantidad', 'descargar', 'precio', 'descuento', 'totalDescuento', 'total', 'inventario', 'medida'];

    public function Rpos()
    {
        return $this->belongsTo(Pos::class, 'pos');
    }
    
    public function Rproductos(){
        return $this->belongsTo(Producto::class,'producto');
    }

    public function Rinventario(){
        return $this->belongsTo(Inventario::class,'inventario');
    }

    public function Rmedida(){
        return $this->belongsTo(UnidadMedida::class,'medida');
    }
}
