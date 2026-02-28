<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPago extends Model
{
    protected $table = 'tipos_pago';

    protected $primaryKey = 'id_tipo_pago';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'nombre',
        'comision',
        'activo'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_tipo_pago', 'id_tipo_pago');
    }
}