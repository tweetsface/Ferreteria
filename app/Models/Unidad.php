<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    // 🔹 Nombre de la tabla
    protected $table = 'unidades';

    // 🔹 Clave primaria personalizada
    protected $primaryKey = 'id_unidad';

    // 🔹 Laravel usa timestamps
    public $timestamps = true;

    // 🔹 Campos asignables
    protected $fillable = [
        'nombre',
        'abreviatura'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    // 🔹 Productos que usan esta unidad
    public function productos()
    {
        return $this->hasMany(
            Producto::class,
            'id_unidad',
            'id_unidad'
        );
    }
}