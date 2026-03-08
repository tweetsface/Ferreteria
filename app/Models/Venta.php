<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $primaryKey = 'id_venta';
    public $incrementing = true;
    protected $keyType = 'int';

  protected $fillable = [
    'id_usuario',
    'id_caja',
    'folio',
    'subtotal',
    'iva',
    'total',
    'id_tipo_pago',
    'uuid_factura',
    'facturama_id',
    'status_factura',
    'fecha_facturacion'
];

    // Relaciones

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'id_caja', 'id_caja');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta', 'id_venta');
    }

    public function producto()
{
return $this->belongsTo(Producto::class,'id_producto');
}

    public function cliente()
{
    return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
}
}