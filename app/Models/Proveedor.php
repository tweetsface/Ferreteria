<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{

protected $table = 'proveedores';

protected $primaryKey = 'id_proveedor';

protected $fillable = [
'nombre',
'contacto',
'telefono',
'email',
'rfc',
'direccion',
'activo'

];

 public function productos()
    {
        return $this->belongsToMany(
            Producto::class,
            'producto_proveedor',
            'id_proveedor',
            'id_producto'
        );
    }

}