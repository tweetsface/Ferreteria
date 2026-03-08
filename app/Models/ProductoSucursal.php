<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoSucursal extends Model
{
    protected $table = 'producto_sucursal';

    protected $primaryKey = 'id_producto_sucursal';

    protected $fillable = [
        'id_producto',
        'id_sucursal',
        'existencia',
        'stock_minimo',
        'stock_maximo'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }
}