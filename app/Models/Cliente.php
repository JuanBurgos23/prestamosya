<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'user_id',
        'nombre_completo',
        'ci',
        'fecha_nacimiento',
        'nacionalidad',
        'telefono',
        'direccion',
        'email',
        'ocupacion',
        'egresos_mensuales',
        'referencia_nombre',
        'referencia_ci',
        'referencia_telefono',
        'lugar_trabajo',
        'estado_civil',
        'genero',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
