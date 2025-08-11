<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPlazo extends Model
{
    protected $table = 'tipo_plazo';

    protected $fillable = [
        'nombre',
        'estado',
    ];
    public function intereses()
    {
        return $this->hasMany(Interes::class, 'tipo_plazo_id');
    }
}
