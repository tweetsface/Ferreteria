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
        'precio_base',
        'precio_venta',

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
    return $this->precio_base - $this->costo;
}

public function getMargenAttribute()
{
    if ($this->costo <= 0) return 0;
    return (($this->precio_base - $this->costo) / $this->costo) * 100;
}
}