@extends('adminlte::page')

@section('title', 'Reporte: Cartera Vigente y en Mora')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0"><i class="fas fa-balance-scale mr-2"></i> Cartera Vigente y en Mora</h1>
    <a href="{{ route('prestamista.dashboard') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Volver al Dashboard
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">

    {{-- KPIs --}}
    <div class="row">
        <div class="col-md-3">
            <div class="kpi-card">
                <div class="kpi-label">Colocado (filtrado)</div>
                <div class="kpi-value">{{ number_format($totalColocado,2) }} Bs</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kpi-card">
                <div class="kpi-label">Saldo Total</div>
                <div class="kpi-value">{{ number_format($totalSaldo,2) }} Bs</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kpi-card">
                <div class="kpi-label">Saldo en Mora</div>
                <div class="kpi-value text-danger">{{ number_format($totalMoraSaldo,2) }} Bs</div>
                <small class="text-muted">{{ $porcentajeMora }}% del saldo</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kpi-card">
                <div class="kpi-label">Clientes en Mora</div>
                <div class="kpi-value">{{ $clientesEnMora }}</div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="card mt-2 mb-3">
        <div class="card-body">
            <form class="row">
                <div class="col-md-3">
                    <label>Estado cartera</label>
                    <select name="estado_cartera" class="form-control">
                        <option value="" {{ $estadoFiltro==='' ? 'selected' : '' }}>Todos</option>
                        <option value="vigente" {{ $estadoFiltro==='vigente' ? 'selected' : '' }}>Vigente</option>
                        <option value="mora" {{ $estadoFiltro==='mora' ? 'selected' : '' }}>En mora</option>
                        <option value="pagado" {{ $estadoFiltro==='pagado' ? 'selected' : '' }}>Pagado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Desde (fecha inicio)</label>
                    <input type="date" name="desde" value="{{ $desde }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Hasta (fecha inicio)</label>
                    <input type="date" name="hasta" value="{{ $hasta }}" class="form-control">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary mr-2"><i class="fas fa-filter mr-1"></i> Filtrar</button>
                    <button type="button" class="btn btn-outline-secondary" id="btnExportCsv">
                        <i class="fas fa-file-export mr-1"></i> CSV
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0" id="tablaCartera">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Monto Aprobado</th>
                            <th>Monto Pagado</th>
                            <th>Saldo Pendiente</th>
                            <th>Próximo Pago</th>
                            <th>Días Atraso</th>
                            <th>Estado Cartera</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestamos as $p)
                        @php
                            $saldo = $p->saldo_pendiente;
                            $proximo = $p->proximo_pago ? \Carbon\Carbon::parse($p->proximo_pago)->format('d/m/Y') : '—';
                        @endphp
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->cliente->nombre_completo ?? '—' }}</td>
                            <td>{{ number_format($p->monto_aprobado,2) }}</td>
                            <td>{{ number_format($p->monto_pagado,2) }}</td>
                            <td class="{{ $p->cartera_estado==='mora' ? 'text-danger font-weight-bold' : '' }}">
                                {{ number_format($saldo,2) }}
                            </td>
                            <td>{{ $proximo }}</td>
                            <td>{{ $p->dias_atraso }}</td>
                            <td>
                                <span class="badge {{ $p->cartera_estado==='mora' ? 'badge-danger' : ($p->cartera_estado==='vigente' ? 'badge-success' : 'badge-secondary') }}">
                                    {{ strtoupper($p->cartera_estado) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('prestamos.show', $p->id) }}" class="btn btn-sm btn-outline-primary">
                                    Ver
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center text-muted py-4">No hay resultados</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@stop

@section('css')
<style>
.kpi-card{background:#fff;border-radius:12px;box-shadow:0 8px 20px rgba(0,0,0,.06);padding:16px;margin-bottom:12px}
.kpi-label{font-size:.85rem;color:#7f8c8d}
.kpi-value{font-size:1.25rem;font-weight:700;color:#2c3e50}
</style>
@stop

@section('js')
<script>
// Exportar CSV rápido desde la tabla
document.getElementById('btnExportCsv').addEventListener('click', () => {
    const table = document.getElementById('tablaCartera');
    let csv = [];
    for (let r = 0; r < table.rows.length; r++) {
        let row = [], cols = table.rows[r].querySelectorAll('th, td');
        for (let c = 0; c < cols.length; c++) {
            // Evitar la última columna de acciones en export
            if (r === 0) { // header
                if (c === cols.length - 1) continue;
            } else {
                if (c === cols.length - 1) continue;
            }
            let text = cols[c].innerText.replace(/\s+/g,' ').trim().replace(/"/g,'""');
            row.push(`"${text}"`);
        }
        csv.push(row.join(','));
    }
    const blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url; a.download = 'reporte_cartera.csv';
    document.body.appendChild(a); a.click(); document.body.removeChild(a);
});
</script>
@stop
