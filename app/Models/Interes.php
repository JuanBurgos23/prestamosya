<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interes extends Model
{
    protected $table = 'interes';
    protected $fillable = [
        'tasa_interes',
        'estado',
        'id_tipo_plazo'
    ];
    public function tipoPlazo()
    {
        return $this->belongsTo(TipoPlazo::class, 'id_tipo_plazo');
    }
}
