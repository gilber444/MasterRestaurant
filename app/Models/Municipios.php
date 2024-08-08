<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Municipios extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'codigo',
        'municipio',
        'departamento_id',
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
        return $this->belongsTo(Departamentos::class, 'departamento');
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
