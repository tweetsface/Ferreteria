<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $fillable = [
        'id_usuario',
        'id_sucursal',
        'monto_inicial',
        'monto_final',
        'ventas_efectivo',
        'ventas_tarjeta',
        'ventas_transferencia',
        'estado',
        'fecha_apertura',
        'fecha_cierre',
        'observaciones'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}
