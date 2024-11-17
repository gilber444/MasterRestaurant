<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compra extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['numero', 'sucursal', 'correlativo', 'serie', 'factura', 'fechaCompra', 'condicionPago', 'vendedor', 'saldo', 'total', 'fechaPago', 'proveedor', 'user', 'observaciones', 'estado',
    ];

    public function Rproveedor()
    {
        return $this->belongsTo(Proveedores::class, 'proveedor');
    }

    public function Rusuario(){
        return $this->belongsTo(User::class,'user');
    }
    
    public function Rcondicion(){
        return $this->belongsTo(CondicionOperacion::class,'condicionPago');
    }

    public function Rsucursal(){
        return $this->belongsTo(Sucursales::class,'sucursal');
    }
}
