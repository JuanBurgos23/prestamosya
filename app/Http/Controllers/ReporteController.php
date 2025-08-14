<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pago;
use App\Models\Prestamo;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function cartera(Request $request)
    {
        $prestamistaId = auth()->id();
        $hoy = Carbon::today();

        // Filtros
        $estadoFiltro = $request->get('estado_cartera'); // 'vigente' | 'mora' | 'todos'
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');
        $clienteId = $request->get('cliente_id');

        $q = Prestamo::with(['cliente', 'pagos'])
            ->where('id_prestamista', $prestamistaId)
            ->whereIn('estado', ['activo', 'en_mora', 'pagado', 'cancelado']);

        if ($desde) {
            $q->whereDate('fecha_inicio', '>=', $desde);
        }
        if ($hasta) {
            $q->whereDate('fecha_inicio', '<=', $hasta);
        }
        if ($clienteId) {
            $q->where('id_cliente', $clienteId);
        }

        $prestamos = $q->get()->map(function ($p) use ($hoy) {
            $saldo = $p->saldo_pendiente;

            // Obtener valor del accesor
            $px = $p->proximo_pago;
            $proximo = null;

            // Evitar parsear textos como "Completado" o "Último pago"
            if ($px instanceof \Carbon\CarbonInterface) {
                $proximo = $px;
            } elseif (is_string($px) && preg_match('/^\d{2}\/\d{2}\/\d{4}/', $px, $m)) {
                try {
                    $proximo = Carbon::createFromFormat('d/m/Y', $m[0]);
                } catch (\Exception $e) {
                    $proximo = null;
                }
            }

            $diasAtraso = 0;
            if ($saldo > 0 && $proximo && $hoy->gt($proximo)) {
                $diasAtraso = $proximo->diffInDays($hoy);
            }

            // Determinar estado de cartera
            if ($saldo <= 0) {
                $p->cartera_estado = 'pagado';
            } elseif ($proximo && $hoy->gt($proximo)) {
                $p->cartera_estado = 'mora';
            } else {
                $p->cartera_estado = 'vigente';
            }

            $p->dias_atraso = $diasAtraso;
            return $p;
        });

        // Filtros por estado
        if ($estadoFiltro === 'vigente') {
            $prestamos = $prestamos->where('cartera_estado', 'vigente');
        } elseif ($estadoFiltro === 'mora') {
            $prestamos = $prestamos->where('cartera_estado', 'mora');
        } elseif ($estadoFiltro === 'pagado') {
            $prestamos = $prestamos->where('cartera_estado', 'pagado');
        }

        // Totales
        $totalColocado = $prestamos->sum('monto_aprobado');
        $totalSaldo = $prestamos->sum(fn($p) => $p->saldo_pendiente);
        $enMora = $prestamos->where('cartera_estado', 'mora');

        $totalMoraSaldo = $enMora->sum(fn($p) => $p->saldo_pendiente);
        $clientesEnMora = $enMora->pluck('id_cliente')->unique()->count();
        $cantidadPrestamos = $prestamos->count();

        $porcentajeMora = $totalSaldo > 0 ? round(($totalMoraSaldo / $totalSaldo) * 100, 2) : 0;

        return view('reportes.cartera', [
            'prestamos'         => $prestamos,
            'totalColocado'     => $totalColocado,
            'totalSaldo'        => $totalSaldo,
            'totalMoraSaldo'    => $totalMoraSaldo,
            'clientesEnMora'    => $clientesEnMora,
            'cantidadPrestamos' => $cantidadPrestamos,
            'porcentajeMora'    => $porcentajeMora,
            'estadoFiltro'      => $estadoFiltro,
            'desde'             => $desde,
            'hasta'             => $hasta,
            'clienteId'         => $clienteId,
        ]);
    }


    public function flujoCobros()
    {
        $historico = Pago::selectRaw("DATE_FORMAT(fecha_pago, '%Y-%m') as mes, SUM(monto) as total, COUNT(*) as cantidad")
            ->whereHas('prestamo', fn($q) => $q->where('id_prestamista', auth()->id()))
            ->where('fecha_pago', '>=', now()->subMonths(12))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $proyeccion = [];
        $prestamosActivos = Prestamo::where('id_prestamista', auth()->id())
            ->where('estado', 'activo')
            ->get();

        foreach ($prestamosActivos as $prestamo) {
            $fecha = now();
            while ($fecha <= $prestamo->fecha_vencimiento && $fecha <= now()->addMonths(6)) {
                $mes = $fecha->format('Y-m');
                if (!isset($proyeccion[$mes])) {
                    $proyeccion[$mes] = 0;
                }
                $proyeccion[$mes] += $prestamo->monto_cuota;
                $fecha->addMonth();
            }
        }

        return view('reportes.flujo-cobros', compact('historico', 'proyeccion'));
    }
}
