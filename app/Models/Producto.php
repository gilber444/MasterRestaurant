<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'codigo_barra',
        'producto',
        'categoria',
        'marca',
        'unidad_medida',
        'unidad_medida_mh',
        'csiva',
        'civa',
        'presentacion'
    ];

    public function RunidadMedidaMH()
    {
        return $this->belongsTo(UnidadMedida::class, 'unidad_medida_mh');
    }
    public function RunidadMedida()
    {
        return $this->belongsTo(ProductoUnidadMedida::class, 'unidad_medida');
    }
    public function RcategoriaProducto()
    {
        return $this->belongsTo(ProductoCategoria::class, 'categoria');
    }
}
