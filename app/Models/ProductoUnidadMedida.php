<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductoUnidadMedida extends Model
{

    use HasFactory, SoftDeletes;
    protected $fillable = [
        'nombre',
        'simbolo',
        'estado'
    ];

    public function HProducto()
    {
        return $this->hasMany(Producto::class, 'unidad_medida'); 
    }
}
