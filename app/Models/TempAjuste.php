<?php

namespace App\Models;

use App\Livewire\Productos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempAjuste extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = ['producto', 'cantidad', 'precio'];

    public function Rproductos(){
        return $this->belongsTo(Productos::class,'producto');
    }
}
