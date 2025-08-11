<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pago;
use App\Models\Prestamo;
use App\Models\SolicitudPrestamo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $prestamistaId = Auth::id();

        // Métricas principales
        $totalClientes = Cliente::where('id_user_prestamista', $prestamistaId)->count();
        $prestamosActivos = Prestamo::where('id_prestamista', $prestamistaId)->where('estado', 'activo')->count();
        $solicitudesPend = SolicitudPrestamo::where('id_prestamista', $prestamistaId)->where('estado', 'pendiente')->count();

        $montoColocado = Prestamo::where('id_prestamista', $prestamistaId)->sum('monto_aprobado');
        $montoCobrado = Pago::whereHas('prestamo', function($q) use ($prestamistaId) {
            $q->where('id_prestamista', $prestamistaId);
        })->sum('monto');

        // Distribución por estado de préstamos
        $estados = ['activo', 'pagado', 'en_mora', 'cancelado'];
        $prestamosPorEstado = [];
        foreach ($estados as $estado) {
            $prestamosPorEstado[$estado] = Prestamo::where('id_prestamista', $prestamistaId)->where('estado', $estado)->count();
        }

        // Cobros últimos 12 meses (línea)
        $labelsMeses = [];
        $cobrosPorMes = [];
        for ($i = 11; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $labelsMeses[] = $mes->format('M Y');
            $cobrosPorMes[] = Pago::whereHas('prestamo', function($q) use ($prestamistaId) {
                    $q->where('id_prestamista', $prestamistaId);
                })
                ->whereYear('fecha_pago', $mes->year)
                ->whereMonth('fecha_pago', $mes->month)
                ->sum('monto');
        }

        // Próximos pagos (los próximos 10 por fecha de pago futura o inmediata)
        $proximosPagos = Pago::with(['prestamo.cliente'])
            ->whereHas('prestamo', function($q) use ($prestamistaId) {
                $q->where('id_prestamista', $prestamistaId);
            })
            ->orderBy('fecha_pago', 'desc') // si manejas "plan de pagos", aquí usarías la tabla de cuotas planificadas
            ->take(10)
            ->get();

        // Últimos préstamos
        $ultimosPrestamos = Prestamo::with('cliente')
            ->where('id_prestamista', $prestamistaId)
            ->latest()
            ->take(8)
            ->get();

        // Solicitudes recientes pendientes
        $solicitudesRecientes = SolicitudPrestamo::with('cliente')
            ->where('id_prestamista', $prestamistaId)
            ->where('estado', 'pendiente')
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact(
            'totalClientes',
            'prestamosActivos',
            'solicitudesPend',
            'montoColocado',
            'montoCobrado',
            'prestamosPorEstado',
            'labelsMeses',
            'cobrosPorMes',
            'proximosPagos',
            'ultimosPrestamos',
            'solicitudesRecientes'
        ));
    }
}