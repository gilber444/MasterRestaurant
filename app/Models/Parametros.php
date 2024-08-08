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
        'consumidor',
        'concorrelativo',
        'credito',
        'crecorrelativo',
        'cotizacion',
        'cocorrelativo',
        'efectivo',
        'cheque',
        'tarjeta',
        'creditos',
        'bono',
        'xlinea',
        'xvendedor',
        'arqueo',
        'tasa',
        'ventamin',
        'obligatoriocredito',
        'estado',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'ventamin' => 'decimal:4',
    ];

    public function sucursales()
    {
        return $this->belongsTo(Sucursales::class, 'sucursal_id');
    }

    public function empresas()
    {
        return $this->belongsTo(Empresas::class, 'sucursal_id');
    }
}
