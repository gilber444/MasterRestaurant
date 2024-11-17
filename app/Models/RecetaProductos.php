<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecetaProductos extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = ['producto', 'producto_primary', 'unidad', 'cantidad'];

    public function RProductoMenu()
    {
        return $this->belongsTo(ProductoMenu::class, 'producto');
    }
    public function RProducto()
    {
        return $this->belongsTo(Producto::class, 'producto_primary');
    }
    public function RUnidad()
    {
        return $this->belongsTo(ProductoUnidadMedida::class, 'unidad');
    }
}
