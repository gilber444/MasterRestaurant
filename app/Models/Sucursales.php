<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sucursales extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'numero',
        'nombre',
        'direccion',
        'telefono',
        'cajas',
        'empresa',
        'tipo',
        'departamento',
        'municipio',
        'distrito',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function empresas()
    {
        return $this->belongsTo(Empresas::class, 'empresa_id');
    }

    public function tipoEstablecimientos()
    {
        return $this->belongsTo(TipoEstablecimiento::class, 'tipo_id');
    }

    public function departamentos()
    {
        return $this->belongsTo(Departamentos::class, 'departamento');
    }

    public function municipios()
    {
        return $this->belongsTo(Municipios::class, 'municipio');
    }

    public function distritos()
    {
        return $this->belongsTo(Distritos::class, 'distrito');
    }
}
