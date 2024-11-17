<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actividades extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user', 'empresa', 'sucursal', 'caja', 'marca', 'fecha', 'hora', 'status'
    ];

    public function Rusuario()
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function Rempresa()
    {
        return $this->belongsTo(Empresas::class, 'empresa');
    }

    public function Rsucursal()
    {
        return $this->belongsTo(Sucursales::class, 'sucursal');
    }

    public function Rcaja()
    {
        return $this->belongsTo(Parametros::class, 'caja');
    }

    public function Rmarca()
    {
        return $this->belongsTo(Marcas::class, 'marca');
    }
}
