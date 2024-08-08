<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamentos extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'codigo',
        'departamento',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Departamento::activo()->get() para obtener todos los departamentos activos.
     */
    public function scopeActivo($query)
    {
        return $query->where('status', 'Activo');
    }

    public function scopeDesactivado($query)
    {
        return $query->where('status', 'Desactivado');
    }
}
