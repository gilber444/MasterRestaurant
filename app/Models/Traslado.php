<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Traslado extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'sorigen',
        'sdestino',
        'correlativo',
        'fecha',
        'detalle',
        'solicitante',
        'autorizacion',
        'fechaautorizado',
        'estado'
    ];

    public function Rorigen(){
        return $this->belongsTo(Sucursales::class,'sorigen');
    }
    public function Rdestino(){
        return $this->belongsTo(Sucursales::class,'sdestino');
    }
    
    public function Rsolicitante(){
        return $this->belongsTo(User::class,'solicitante');
    }
    public function Rautorizacion(){
        return $this->belongsTo(User::class,'autorizacion');
    }
}
