<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsoCfdi extends Model
{

    protected $primaryKey = 'id_uso_cfdi';

    protected $table = 'usos_cfdi';

    public function regimenes()
    {
        return $this->belongsToMany(
            RegimenFiscal::class,
            'uso_cfdi_regimen',
            'id_uso_cfdi',
            'id_regimen'
        );
    }

}
