<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedores extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nombre', 'razon_social', 'tipoPersona', 'departamento', 'municipio', 'distrito', 'actividad', 'direccion', 'telefono', 'correo', 'registro', 'nit', 'tipo'
    ];

    public function RtipoPersona()
    {
        return $this->belongsTo(TipoPersona::class, 'tipoPersona');
    }

    public function Rdepartamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento');
    }

    public function Rmunicipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio');
    }

    public function Rdistrito()
    {
        return $this->belongsTo(Distritos::class, 'distrito');
    }

    public function RactividadEconomica()
    {
        return $this->belongsTo(ActividadEconomica::class, 'actividad');
    }
}
