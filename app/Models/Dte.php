<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dte extends Model
{
    use HasFactory;

    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['motivoContin', 'version', 'ambiente', 'tipoDte', 'numeroControl', 'codigoGeneracion', 'tipoModelo', 'tipoOperacion', 'tipoContingencia', 'fecEmi', 'horEmi', 'tipoMoneda', 'documentoRelacionado', 'emisor', 'receptor', 'otrosDocuentos', 'ventaTercero', 'venta', 'tocken', 'sello', 'estado', 'jsonDte', 'caja', 'sucursal', 'empresa'];

    public function tipoDte()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipoDte');
    }

    public function ambiente()
    {
        return $this->belongsTo(AmbienteDestino::class, 'ambiente');
    }

    public function tipoOperacion()
    {
        return $this->belongsTo(TipoTransmision::class, 'tipoOperacion');
    }

    public function tipoContingencia()
    {
        return $this->belongsTo(TipoContingencia::class, 'tipoContingencia');
    }

    public function tipoModelo()
    {
        return $this->belongsTo(ModeloFacturacion::class, 'tipoModelo');
    }

    //public function empresa()
    //{
        //return $this->belongsTo(Empresas::class, 'empresa');
    //}

    public function emisor()
    {
        return $this->belongsTo(Sucursales::class, 'emisor');
    }
}
