<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nombre_usuario',
        'nombre_completo',
        'email',
        'password',
        'rol',
        'id_sucursal',
        'activo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}