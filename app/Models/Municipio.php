<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Municipio extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'codigo',
        'municipio',
        'departamento',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the department associated with the municipio.
     */
    public function departamentos()
    {
        return $this->belongsTo(Departamento::class, 'departamento');
    }


    public function scopeActivo($query)
    {
        return $query->where('status', 'Activo');
    }

    
    public function scopeDesactivado($query)
    {
        return $query->where('status', 'Desactivado');
    }
}
