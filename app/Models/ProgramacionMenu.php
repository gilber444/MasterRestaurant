<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramacionMenu extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = ['producto', 'stock', 'fecha'];

    public function RProductoMenu()
    {
        return $this->belongsTo(ProductoMenu::class, 'producto');
    }
}
