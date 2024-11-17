<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductoMenu extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'producto',
        'marca',
        'linea',
        'categoria',
        'forma_venta',
        'comun',
        'status',
    ];

    public function Rmarcas()
    {
        return $this->belongsTo(Marcas::class, 'marca');
    }

    public function Rlineas()
    {
        return $this->belongsTo(Lineas::class, 'linea');
    }

    public function Rcategorias()
    {
        return $this->belongsTo(Categorias::class, 'categoria');
    }

    public function Rventas()
    {
        return $this->belongsTo(FormaVenta::class, 'forma_venta');
    }
}
