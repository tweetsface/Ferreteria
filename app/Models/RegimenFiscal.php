<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegimenFiscal extends Model
{
    protected $primaryKey = 'id_regimen';

    protected $table = 'regimenes_fiscales';

    public function usosCfdi()
    {
        return $this->belongsToMany(
            UsoCfdi::class,
            'uso_cfdi_regimen',
            'id_regimen',
            'id_uso_cfdi'
        );
    }
}