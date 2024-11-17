<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleCotizacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['cotizacion', 'producto', 'cantidad', 'medida'];

    public function Rcotizacion(){
        return $this->belongsTo(Cotizaciones::class,'cotizacion');
    }

    public function Rproductos(){
        return $this->belongsTo(Producto::class,'producto');
    }

    public function Rmedida(){
        return $this->belongsTo(UnidadMedida::class,'medida');
    }
}
