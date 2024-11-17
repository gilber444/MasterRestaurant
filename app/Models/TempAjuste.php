<?php

namespace App\Models;

use App\Livewire\Productos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempAjuste extends Model
{

    use HasFactory;

    protected $fillable = ['codigo', 'producto', 'medida', 'nombre', 'cantidad', 'costo',
        'total', 'user'
    ];
}
