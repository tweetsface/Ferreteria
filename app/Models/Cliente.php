<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $primaryKey="id_cliente";
    protected $fillable = [
    'nombre',
    'telefono',
    'email',
    'rfc',
    'razon_social',
    'codigo_postal',
    'regimen_fiscal',
    'uso_cfdi',
    'direccion'
];



}
