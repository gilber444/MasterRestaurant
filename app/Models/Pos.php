<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pos extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
            'formas', 'efectivo', 'cambio', 'factura', 'comprobante', 'idC', 'fecha', 'correlativo', 'estado', 'usuario', 'tipoPedido', 'direccion'
    ];

    public function RformaPago()
    {
        return $this->belongsTo(FormaPago::class, 'formas');
    }
    public function Rcliente()
    {
        return $this->belongsTo(Cliente::class, 'idC');
    }
    public function Rusuario()
    {
        return $this->belongsTo(User::class, 'usuario');
    }
}
