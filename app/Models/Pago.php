<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'id_prestamo',
        'monto',
        'fecha_pago',
        'interes_pagado',
        'capital_pagado',
        'saldo_restante',
        'metodo_pago',
        'comprobante',
        'comentario',
        'id_prestamista'
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class, 'id_prestamo');
    }

    public function prestamista()
    {
        return $this->belongsTo(User::class, 'id_prestamista');
    }
}
