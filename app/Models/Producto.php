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
    'id_familia',

    'costo',
    'precio_base',
    'precio_venta',

    'id_unidad',
    'id_clave_sat',
    'id_unidad_sat',
    'objeto_impuesto',

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

public function sucursales()
{
    return $this->belongsToMany(
        Sucursal::class,
        'producto_sucursal',
        'id_producto',
        'id_sucursal'
    )->withPivot('existencia','stock_minimo','stock_maximo');
}

public function claveSat()
{
    return $this->belongsTo(ClaveProductoSat::class,'id_clave_sat','id_clave_sat');
}

public function unidadSat()
{
    return $this->belongsTo(UnidadSat::class,'id_unidad_sat','id_unidad_sat');
}

public function unidad()
{
    return $this->belongsTo(
        Unidad::class,
        'id_unidad',
        'id_unidad'
    );
}
}