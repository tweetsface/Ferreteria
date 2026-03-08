<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
     protected $primaryKey = 'id_sucursal';

    // 🔹 Laravel usa timestamps
    public $timestamps = true;

    // 🔹 Campos asignables
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'activo'
    ];

    public function productos()
{
    return $this->belongsToMany(
        Producto::class,
        'producto_sucursal',
        'id_sucursal',
        'id_producto'
    )->withPivot('existencia','stock_minimo','stock_maximo');
}

    public function usuarios()
    {
        return $this->hasMany(Usuario::class,'id_sucursal','id_sucursal');
    }
}
