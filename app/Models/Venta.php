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
        'subtotal',
        'iva',
        'total',
        'id_tipo_pago'
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
}