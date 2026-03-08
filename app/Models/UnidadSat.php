<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadSat extends Model
{

protected $table = 'unidades_sat';

protected $primaryKey = 'id_unidad_sat';

protected $fillable = [
    'clave',
    'nombre',
    'descripcion'
];

}