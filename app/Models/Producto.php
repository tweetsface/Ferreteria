<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // 🔹 Clave primaria personalizada
    protected $primaryKey = 'id_producto';

    // 🔹 Laravel usa timestamps
    public $timestamps = true;

    // 🔹 Campos asignables masivamente
    protected $fillable = [
        'codigo',
        'nombre',
        'id_categoria',

        'costo',
        'precio',

        'stock',
        'stock_minimo',

        'unidad',
        'marca',

        'descripcion',
        'imagen',
        'activo',
    ];

    // 🔗 Relación con Categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔥 ACCESOR OPCIONAL (Recomendado)
    |--------------------------------------------------------------------------
    | Calcula utilidad automáticamente
    */
    public function getUtilidadAttribute()
    {
        if ($this->costo !== null) {
            return $this->precio - $this->costo;
        }
        return null;
    }
}