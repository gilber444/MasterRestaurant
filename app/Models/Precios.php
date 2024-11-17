<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Precios extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [ 'producto', 'lineaP', 'categoriaP', 'cantidadP', 'costo', 'costoIva', 'utilidad', 'precioVenta', 'precioVentaIva'];

    public function Rproductos()
    {
        return $this->belongsTo(ProductoMenu::class, 'producto');
    }

    public function Rlineas()
    {
        return $this->belongsTo(Lineas::class, 'lineaP');
    }

    public function Rcategorias()
    {
        return $this->belongsTo(Categorias::class, 'categoriaP');
    }
}
