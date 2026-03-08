<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaveProductoSat extends Model
{

protected $table = 'claves_productos_sat';

protected $primaryKey = 'id_clave_sat';

protected $fillable = [
    'clave',
    'descripcion'
];

}
