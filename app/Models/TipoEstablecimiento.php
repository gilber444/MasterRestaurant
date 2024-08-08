<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoEstablecimiento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'codigo',
        'valor',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function scopeActivo($query)
    {
        return $query->where('status', 'Activo');
    }

    public function scopeDesactivado($query)
    {
        return $query->where('status', 'Desactivado');
    }
}
