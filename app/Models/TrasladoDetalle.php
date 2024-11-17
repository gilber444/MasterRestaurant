<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TrasladoDetalle extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'traslado',
        'producto',
        'cantidad',
    ];

    public function Rtraslado(){
        return $this->belongsTo(Traslado::class,'traslado');
    }
    public function Rproducto(){
        return $this->belongsTo(Producto::class,'producto');
    }
}
