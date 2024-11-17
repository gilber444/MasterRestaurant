<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parametros extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'empresa',
        'sucursal',
        'caja',
        'token',
        'full',
        'slip',
        'multiple',
        'centralizada',
        'ticket',
        'tcorrelativo',
        'tresulucion',
        'tserie',
        'consumidor',
        'concorrelativo',
        'conresolucion',
        'conserie',
        'credito',
        'crecorrelativo',
        'creresolucion',
        'creserie',
        'notacredito',
        'nccorrelativo',
        'ncresolucion',
        'ncserie',
        'notadebito',
        'ndcorrelativo',
        'ndresolucion',
        'ndserie',
        'cotizacion',
        'cocorrelativo',
        'tasa',
        'ventamin',
        'dte',
        'dteAutomatico',
        'tiquedte',
        'estado'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'ventamin' => 'decimal:4',
    ];

    public function Rsucursales()
    {
        return $this->belongsTo(Sucursales::class, 'sucursal_id');
    }

    public function Rempresas()
    {
        return $this->belongsTo(Empresas::class, 'sucursal_id');
    }

    public function Ractividades()
    {
        return $this->hasMany(Actividades::class, 'caja'); 
    }
}
