<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleAjuste extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['ajuste', 'producto', 'inventario', 'unidad', 'cantidad',
    'costo', 'total'];

    public function Rproductos(){
        return $this->belongsTo(Producto::class,'producto');
    }

    public function Rmedidas(){
        return $this->belongsTo(UnidadMedida::class,'unidad');
    }

    public function Rajustes(){
        return $this->belongsTo(Ajuste::class,'ajuste');
    }
}
