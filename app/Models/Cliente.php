<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nombreCliente', 'nit', 'dui', 'registro', 'correo', 'telefono', 'celular', 'direccion', 'departamento', 'municipio', 'tipoPersona', 'homologado', 'distrito', 'tipoCliente', 'actividad', 'identificacion'];

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
    public function RtipoPersona()
    {
        return $this->belongsTo(TipoPersona::class, 'tipoPersona');
    }
    public function Ractividad()
    {
        return $this->belongsTo(ActividadEconomica::class, 'actividad');
    }
    public function Ridentificacion()
    {
        return $this->belongsTo(IdentificacionReceptor::class, 'identificacion');
    }
}
