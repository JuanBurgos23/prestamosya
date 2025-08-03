<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $fillable = [
        'id_cliente',
        'id_prestamista',
        'id_solicitud',
        'monto_aprobado',
        'interes',
        'plazo',
        'tipo_plazo',
        'fecha_inicio',
        'fecha_vencimiento',
        'estado',
        'comentario'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function prestamista()
    {
        return $this->belongsTo(User::class, 'id_prestamista');
    }


    public function solicitud()
    {
        return $this->belongsTo(SolicitudPrestamo::class, 'id_solicitud');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_prestamo');
    }

    // Métodos para calcular atributos dinámicos
    public function getMontoPagadoAttribute()
    {
        return $this->pagos()->sum('monto');
    }

    public function getInteresPagadoAttribute()
    {
        return $this->pagos()->sum('interes_pagado');
    }

    public function getSaldoPendienteAttribute()
    {
        return $this->monto_aprobado - $this->pagos()->sum('capital_pagado');
    }

    public function getPorcentajePagadoAttribute()
    {
        if ($this->monto_aprobado == 0) return 0;
        return round(($this->pagos()->sum('capital_pagado') / $this->monto_aprobado) * 100, 2);
    }

    public function getProximoPagoAttribute()
    {
        // Lógica para calcular la fecha del próximo pago
        // Esto depende de tu sistema de amortización
        // Ejemplo básico:
        if ($this->pagos()->count() == 0) {
            return $this->fecha_inicio;
        }
        return Carbon::parse($this->pagos()->latest()->first()->fecha_pago)->addMonth();
    }

    public function getMontoCuotaAttribute()
    {
        // Lógica para calcular el monto de la cuota
        // Esto depende de tu sistema de amortización
        // Ejemplo básico:
        return $this->monto_aprobado * ($this->interes / 100 / 12) /
            (1 - pow(1 + ($this->interes / 100 / 12), -$this->plazo));
    }
}
