<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apertura extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'caja',
        'sucursal',
        'empresa',
        'fechaApertura',
        'horaApertura',
        'inicio',
        'final',
        'FcierreApertura',
        'HcierreApertura',
        'estado',
        'cajero'
    ];

    public function Rcaja()
    {
        return $this->belongsTo(Parametros::class, 'caja');
    }

    public function Rsucursal()
    {
        return $this->belongsTo(Sucursales::class, 'sucursal');
    }

    public function Rempresa()
    {
        return $this->belongsTo(Empresas::class, 'empresa');
    }

    public function Rcajero()
    {
        return $this->belongsTo(User::class, 'cajero');
    }
}
