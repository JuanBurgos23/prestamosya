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
        'id_tipo_plazo', // Asegúrate que está en $fillable (lo agregué)
        'fecha_inicio',
        'fecha_vencimiento',
        'estado',
        'comentario',
        'interes_total',
        'cuota_estimada',
        'monto_total_pagar'
    ];

    // Relaciones existentes
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
    public function interes()
    {
        return $this->belongsTo(Interes::class, 'id_interes');
    }
    public function tipoPlazo()
    {
        return $this->belongsTo(TipoPlazo::class, 'id_tipo_plazo');
    }

    // Accesor para días de atraso
    public function getDiasAtrasoAttribute()
    {
        if ($this->estado != 'activo' || $this->saldo_pendiente <= 0) {
            return 0;
        }

        $hoy = Carbon::today();
        $fechaVencimiento = Carbon::parse($this->fecha_vencimiento);

        if ($hoy->lessThanOrEqualTo($fechaVencimiento)) {
            return 0;
        }

        return $hoy->diffInDays($fechaVencimiento);
    }

    // Accesor para monto cuota (simple: total a pagar / plazo)
    public function getMontoCuotaAttribute()
    {
        if ($this->plazo <= 0) return 0;

        return $this->monto_total_pagar / $this->plazo;
    }

    // Accesor para próximo pago
    public function getProximoPagoAttribute()
    {
        if ($this->estado != 'activo' || $this->saldo_pendiente <= 0) {
            return 'Completado';
        }

        $hoy = Carbon::today();
        $fechaInicio = Carbon::parse($this->fecha_inicio);
        $fechaVencimiento = Carbon::parse($this->fecha_vencimiento);

        $tipoPlazoNombre = strtolower(optional($this->tipoPlazo)->nombre ?? 'mensual');

        // Cantidad de cuotas pagadas (puedes ajustar según tu modelo de pagos)
        $pagosRealizados = $this->pagos()->count();

        $periodoSiguiente = $pagosRealizados + 1;

        switch ($tipoPlazoNombre) {
            case 'diario':
                $proximoPago = $fechaInicio->copy()->addDays($periodoSiguiente);
                break;
            case 'semanal':
                $proximoPago = $fechaInicio->copy()->addWeeks($periodoSiguiente);
                break;
            case 'quinsenal':
                $proximoPago = $fechaInicio->copy()->addDays($periodoSiguiente * 15);
                break;
            case 'mensual':
                $proximoPago = $fechaInicio->copy()->addMonths($periodoSiguiente);
                break;
            case 'anual':
                $proximoPago = $fechaInicio->copy()->addYears($periodoSiguiente);
                break;
            default:
                $proximoPago = $fechaInicio->copy()->addMonths($periodoSiguiente);
        }

        if ($proximoPago->greaterThan($fechaVencimiento)) {
            return 'Último pago';
        }

        if ($proximoPago->lessThan($hoy)) {
            // El próximo pago está atrasado (puedes devolver la fecha o un mensaje)
            return $proximoPago->format('d/m/Y') . ' (Atrasado)';
        }

        return $proximoPago->format('d/m/Y');
    }
    public function getSaldoPendienteAttribute()
    {
        $pagado = $this->pagos()->sum('monto');
        return max(0, $this->monto_total_pagar - $pagado);
    }
    // Monto pagado (suma de capital + interés pagado)
    public function getMontoPagadoAttribute()
    {
        return $this->pagos()->sum('monto');
    }

    // Interés pagado (suma del campo interes_pagado en pagos)
    public function getInteresPagadoAttribute()
    {
        return $this->pagos()->sum('interes_pagado');
    }

    // Porcentaje pagado basado en monto_total_pagar
    public function getPorcentajePagadoAttribute()
    {
        if ($this->monto_total_pagar <= 0) return 0;
        return round(($this->monto_pagado / $this->monto_total_pagar) * 100, 2);
    }
}
