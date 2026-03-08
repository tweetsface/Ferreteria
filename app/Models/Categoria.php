<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{

    protected $primaryKey = 'id_categoria';

    protected $fillable = [
        'nombre',
        'id_familia',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    // Una categoría tiene muchos productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria', 'id_categoria');
    }

    public function familia()
{
    return $this->belongsTo(Familia::class,'id_familia');
}
}