<?php
namespace App\Http\Controllers;

use App\Models\Prestamo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function cartera(Request $request)
    {
        $prestamistaId = auth()->id();
        $hoy = Carbon::today();

        // Filtros
        $estadoFiltro = $request->get('estado_cartera'); // 'vigente' | 'mora' | 'todos'
        $desde = $request->get('desde'); // fecha_inicio >=
        $hasta = $request->get('hasta'); // fecha_inicio <=
        $clienteId = $request->get('cliente_id'); // opcional

        $q = Prestamo::with(['cliente', 'pagos'])
            ->where('id_prestamista', $prestamistaId)
            ->whereIn('estado', ['activo', 'en_mora', 'pagado', 'cancelado']); // puedes ajustar

        if ($desde) {
            $q->whereDate('fecha_inicio', '>=', $desde);
        }
        if ($hasta) {
            $q->whereDate('fecha_inicio', '<=', $hasta);
        }
        if ($clienteId) {
            $q->where('id_cliente', $clienteId);
        }

        // Traemos todos y calculamos estado de cartera (vigente/mora) + métricas
        $prestamos = $q->get()->map(function ($p) use ($hoy) {
            $saldo = $p->saldo_pendiente;       // accessor del modelo
            $px = $p->proximo_pago;             // accessor del modelo (date|string)
            $proximo = $px ? \Carbon\Carbon::parse($px) : null;

            $diasAtraso = 0;
            if ($saldo > 0 && $proximo && $hoy->gt($proximo)) {
                $diasAtraso = $proximo->diffInDays($hoy);
            }

            $p->cartera_estado = ($saldo > 0 && $proximo && $hoy->gt($proximo)) ? 'mora' : 'vigente';
            if ($saldo <= 0) {
                $p->cartera_estado = 'pagado';
            }

            $p->dias_atraso = $diasAtraso;
            return $p;
        });

        // Aplicar filtro por estado de cartera (opcional)
        if ($estadoFiltro === 'vigente') {
            $prestamos = $prestamos->where('cartera_estado', 'vigente');
        } elseif ($estadoFiltro === 'mora') {
            $prestamos = $prestamos->where('cartera_estado', 'mora');
        } elseif ($estadoFiltro === 'pagado') {
            $prestamos = $prestamos->where('cartera_estado', 'pagado');
        }

        // Totales
        $totalColocado = $prestamos->sum('monto_aprobado'); // de los filtrados
        $totalSaldo = $prestamos->sum(fn($p) => $p->saldo_pendiente);
        $enMora = $prestamos->where('cartera_estado', 'mora');
        $vigentes = $prestamos->where('cartera_estado', 'vigente');

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
            // filtros para mantener estado del form
            'estadoFiltro'      => $estadoFiltro,
            'desde'             => $desde,
            'hasta'             => $hasta,
            'clienteId'         => $clienteId,
        ]);
    }
}