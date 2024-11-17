<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosMarca extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'estado',
        'image'
    ];
    public function HProducto()
    {
        return $this->hasMany(Producto::class, 'marca'); 
    }
}
