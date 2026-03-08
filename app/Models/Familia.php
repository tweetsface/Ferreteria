<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{

    protected $primaryKey = 'id_familia';

    protected $fillable = [
        'id_familia',
        'nombre',
    ];


    public function categorias()
{
    return $this->hasMany(Categoria::class,'id_familia');
}
}
