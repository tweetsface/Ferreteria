<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    
protected $table = 'detalle_ventas';
protected $primaryKey = 'id_detalle_venta';

protected $fillable = [

'id_venta',
'id_producto',

'cantidad',
'precio_unitario',
'subtotal',
'iva',
'total',

// 🔹 CAMPOS SAT
'clave_sat',
'clave_unidad_sat',
'unidad_sat',
'descripcion',
'objeto_impuesto'

];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    // Detalle pertenece a una venta
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta', 'id_venta');
    }

    // Detalle pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}