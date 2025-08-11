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
        'id_interes',
        'monto_aprobado',
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

        if ($this->pagos()->count() == 0) {
            return $this->fecha_inicio;
        }
        return Carbon::parse($this->pagos()->latest()->first()->fecha_pago)->addMonth();
    }

    public function getMontoCuotaAttribute()
    {
        // Obtener tasa de interes desde relación (verifica que exista)
        $tasaInteres = $this->interes ? $this->interes->tasa_interes : 0;

        // Validar para evitar división por cero
        if ($tasaInteres <= 0 || $this->plazo <= 0) {
            return 0; // O lo que tenga sentido si no hay interés o plazo
        }

        $interesMensual = $tasaInteres / 100 / 12;

        return $this->monto_aprobado * $interesMensual /
            (1 - pow(1 + $interesMensual, -$this->plazo));
    }
    public function interes()
    {
        return $this->belongsTo(Interes::class, 'id_interes');
    }
}
