<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'empresa',
        'razon',
        'direccion',
        'telefono',
        'responsable',
        'registro',
        'giro',
        'nit',
        'tipoContribuyente',
        'actividad',
        'desActividad',
        'correo',
        'departamento',
        'municipio',
        'distrito',
        'image',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    public function actividadEconomicas()
    {
        return $this->belongsTo(ActividadEconomica::class, 'actividad');
    }


    public function departamentos()
    {
        return $this->belongsTo(Departamento::class, 'departamento');
    }


    public function municipios()
    {
        return $this->belongsTo(Municipio::class, 'municipio');
    }


    public function distritos()
    {
        return $this->belongsTo(Distritos::class, 'distrito');
    }
}

