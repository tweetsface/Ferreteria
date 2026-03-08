<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsoCfdiRegimen extends Model
{
    protected $table = 'uso_cfdi_regimen';

    protected $primaryKey = 'id_uso_cfdi_regimen';

    public $timestamps = false;

    protected $fillable = [
        'regimen_fiscal',
        'uso_cfdi'
    ];

    public function usoCfdi()
    {
        return $this->belongsTo(UsoCfdi::class,'uso_cfdi','clave');
    }

    public function regimenFiscal()
    {
        return $this->belongsTo(RegimenFiscal::class,'regimen_fiscal','clave');
    }
}