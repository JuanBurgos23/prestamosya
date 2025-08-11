@extends('adminlte::page')

@section('title', 'Dashboard Prestamista')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="font-weight-bold text-dark m-0">
        <i class="fas fa-hand-holding-usd mr-2"></i> Dashboard del Prestamista
    </h1>
    <span class="badge badge-primary p-2"><i class="fas fa-user-tie mr-1"></i> Panel Prestamista</span>
</div>
@stop

@section('content')
<div class="container-fluid">
    {{-- Tarjetas de métricas --}}
    <div class="row">
        <div class="col-md-3">
            <div class="metric-card">
                <div class="metric-icon bg-primary"><i class="fas fa-users"></i></div>
                <div class="metric-content">
                    <div class="metric-label">Clientes</div>
                    <div class="metric-value">{{ $totalClientes }}</div>
                </div>
                <a href="{{ route('clientes.index') }}" class="metric-link">Ver clientes <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card">
                <div class="metric-icon bg-success"><i class="fas fa-file-invoice-dollar"></i></div>
                <div class="metric-content">
                    <div class="metric-label">Préstamos Activos</div>
                    <div class="metric-value">{{ $prestamosActivos }}</div>
                </div>
                <a href="{{ route('prestamos.index') }}" class="metric-link">Ver préstamos <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card">
                <div class="metric-icon bg-warning"><i class="fas fa-clipboard-list"></i></div>
                <div class="metric-content">
                    <div class="metric-label">Solicitudes Pendientes</div>
                    <div class="metric-value">{{ $solicitudesPend }}</div>
                </div>
                <a href="" class="metric-link">Revisar solicitudes <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card">
                <div class="metric-icon bg-info"><i class="fas fa-coins"></i></div>
                <div class="metric-content">
                    <div class="metric-label">Cobrado / Colocado</div>
                    <div class="metric-value">
                        {{ number_format($montoCobrado,2) }} / {{ number_format($montoColocado,2) }} Bs
                    </div>
                </div>
                <span class="metric-link disabled">Resumen</span>
            </div>
        </div>
    </div>

    {{-- Gráficos --}}
    <div class="row mt-3">
        <div class="col-lg-8">
            <div class="card chart-card">
                <div class="card-header chart-header">
                    <h5 class="m-0"><i class="fas fa-chart-line mr-2"></i>Cobros últimos 12 meses</h5>
                </div>
                <div class="card-body">
                    <canvas id="lineCobros"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-3 mt-lg-0">
            <div class="card chart-card">
                <div class="card-header chart-header">
                    <h5 class="m-0"><i class="fas fa-chart-pie mr-2"></i>Préstamos por estado</h5>
                </div>
                <div class="card-body">
                    <canvas id="pieEstados"></canvas>
                    <div class="legend-min mt-3">
                        @foreach(['activo' => 'Activo', 'pagado' => 'Pagado', 'en_mora' => 'En mora', 'cancelado' => 'Cancelado'] as $k => $label)
                            <div class="legend-item">
                                <span class="legend-dot"></span> {{ $label }}: <strong>{{ $prestamosPorEstado[$k] ?? 0 }}</strong>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Próximos pagos + Listas rápidas --}}
    <div class="row mt-3">
        <div class="col-lg-7">
            <div class="card table-card">
                <div class="card-header table-header">
                    <h5 class="m-0"><i class="fas fa-receipt mr-2"></i>Pagos recientes</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Monto</th>
                                    <th>Interés</th>
                                    <th>Capital</th>
                                    <th>Saldo</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($proximosPagos as $p)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($p->fecha_pago)->format('d/m/Y') }}</td>
                                    <td>{{ $p->prestamo->cliente->nombre_completo ?? '---' }}</td>
                                    <td>{{ number_format($p->monto,2) }} Bs</td>
                                    <td>{{ number_format($p->interes_pagado,2) }} Bs</td>
                                    <td>{{ number_format($p->capital_pagado,2) }} Bs</td>
                                    <td>{{ number_format($p->saldo_restante,2) }} Bs</td>
                                    <td>
                                        <a href="{{ route('prestamos.show', $p->prestamo->id) }}" class="btn btn-sm btn-outline-primary">
                                            Ver préstamo
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="text-center text-muted py-3">Sin pagos recientes</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($proximosPagos->count())
                <div class="card-footer text-right">
                    <a href="{{ route('prestamos.index') }}" class="btn btn-light btn-sm">Ver todos</a>
                </div>
                @endif
            </div>
        </div>

        <div class="col-lg-5 mt-3 mt-lg-0">
            <div class="card list-card mb-3">
                <div class="card-header list-header">
                    <h5 class="m-0"><i class="fas fa-file-invoice-dollar mr-2"></i>Últimos préstamos</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($ultimosPrestamos as $pr)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="font-weight-bold">{{ $pr->cliente->nombre_completo ?? '---' }}</div>
                            <small class="text-muted">
                                {{ number_format($pr->monto_aprobado,2) }} Bs · {{ $pr->plazo }} {{ $pr->tipo_plazo }}
                            </small>
                        </div>
                        <a href="{{ route('prestamos.show', $pr->id) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                    </li>
                    @empty
                    <li class="list-group-item text-muted text-center">Sin registros</li>
                    @endforelse
                </ul>
            </div>

            <div class="card list-card">
                <div class="card-header list-header">
                    <h5 class="m-0"><i class="fas fa-inbox mr-2"></i>Solicitudes pendientes</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($solicitudesRecientes as $s)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="font-weight-bold">{{ $s->cliente->nombre_completo ?? '---' }}</div>
                            <small class="text-muted">{{ number_format($s->monto_solicitado,2) }} Bs · {{ $s->created_at->format('d/m/Y') }}</small>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('prestamos.create', ['cliente_id'=>$s->id_cliente, 'solicitud_id'=>$s->id]) }}"
                               class="btn btn-sm btn-outline-success">Aprobar</a>
                            <a href="{{ route('solicitudes.show', $s->id) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-muted text-center">Sin solicitudes</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
/* Cards métricas */
.metric-card{
    background:#fff;border-radius:12px;box-shadow:0 8px 20px rgba(0,0,0,.06);
    padding:16px;position:relative;overflow:hidden;display:flex;align-items:center;margin-bottom:16px
}
.metric-icon{width:48px;height:48px;border-radius:10px;color:#fff;display:flex;align-items:center;justify-content:center;margin-right:12px}
.metric-content .metric-label{font-size:.85rem;color:#7f8c8d}
.metric-content .metric-value{font-size:1.25rem;font-weight:700;color:#2c3e50}
.metric-link{position:absolute;right:12px;bottom:8px;font-size:.85rem}
.metric-link.disabled{pointer-events:none;color:#aaa}

/* Gráficos */
.chart-card{border:none;border-radius:12px;box-shadow:0 8px 20px rgba(0,0,0,.06);overflow:hidden}
.chart-header{background:linear-gradient(135deg,#2c3e50,#4a6491);color:#fff;border:none}

/* Tablas / Listas */
.table-card,.list-card{border:none;border-radius:12px;box-shadow:0 8px 20px rgba(0,0,0,.06);overflow:hidden}
.table-header,.list-header{background:#f8f9fa}

/* Leyenda mini */
.legend-min .legend-item{display:flex;align-items:center;font-size:.9rem;margin-bottom:6px}
.legend-min .legend-dot{width:10px;height:10px;border-radius:50%;background:#3498db;display:inline-block;margin-right:6px}

/* Responsivo */
@media(max-width:768px){
  .metric-card{flex-direction:row}
}
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Datos desde PHP
    const labelsMeses = @json($labelsMeses);
    const cobrosPorMes = @json($cobrosPorMes);
    const estados = @json(array_values($prestamosPorEstado)); // [activo, pagado, en_mora, cancelado]

    // Línea: cobros por mes
    const ctxLine = document.getElementById('lineCobros').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: labelsMeses,
            datasets: [{
                label: 'Cobros (Bs)',
                data: cobrosPorMes,
                borderWidth: 2,
                fill: false,
                tension: .25
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Pie: estados préstamos
    const ctxPie = document.getElementById('pieEstados').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Activo','Pagado','En mora','Cancelado'],
            datasets: [{
                data: estados,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
});
</script>
@stop
