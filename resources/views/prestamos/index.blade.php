@extends('adminlte::page')

@section('title', 'Panel Prestamista - Mis Préstamos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="font-weight-bold text-dark">
        <i class="fas fa-hand-holding-usd mr-2"></i>
        Mis Préstamos Activos
    </h1>
    <div class="badge badge-primary p-2">
        <i class="fas fa-user-tie mr-1"></i>
        Área Prestamista
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<style>
    .prestamista-card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: none;
        margin-bottom: 25px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .prestamista-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .prestamista-card-header {
        background: linear-gradient(135deg, #2c3e50, #4a6491);
        color: white;
        padding: 15px 20px;
        border-bottom: none;
        position: relative;
    }

    .prestamista-card-header .status-badge {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
    }

    .prestamista-card-body {
        padding: 20px;
        background-color: #fff;
    }

    .loan-summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .loan-summary-item {
        padding: 12px;
        border-radius: 6px;
        background-color: #f8f9fa;
    }

    .loan-summary-label {
        font-size: 0.8rem;
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 5px;
    }

    .loan-summary-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .loan-summary-value.amount {
        color: #27ae60;
        font-size: 1.2rem;
    }

    .client-info {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .client-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #3498db;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
        margin-right: 15px;
    }

    .client-details {
        flex: 1;
    }

    .client-name {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 3px;
    }

    .client-meta {
        font-size: 0.85rem;
        color: #7f8c8d;
    }

    .progress-thin {
        height: 6px;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-prestamista {
        border-radius: 6px;
        padding: 8px 15px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s;
    }

    .btn-details {
        background-color: #3498db;
        color: white;
        border: none;
    }

    .btn-details:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(41, 128, 185, 0.2);
    }

    .btn-payments {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        color: white;
        border: none;
    }

    .btn-payments:hover {
        background: linear-gradient(135deg, #27ae60, #219653);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(39, 174, 96, 0.2);
    }

    .btn-alert {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
        border: none;
    }

    .btn-alert:hover {
        background: linear-gradient(135deg, #c0392b, #a53125);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(231, 76, 60, 0.2);
    }

    .stats-card {
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        background-color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .stats-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .stats-label {
        font-size: 0.9rem;
        color: #7f8c8d;
    }

    .status-active {
        background-color: rgba(46, 204, 113, 0.2);
        color: #27ae60;
    }

    .status-delayed {
        background-color: rgba(241, 196, 15, 0.2);
        color: #f39c12;
    }

    .status-default {
        background-color: rgba(189, 195, 199, 0.2);
        color: #7f8c8d;
    }

    .table-custom {
        border-radius: 8px;
        overflow: hidden;
    }

    .table-custom thead th {
        background-color: #2c3e50;
        color: white;
        border: none;
    }

    .section-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .loan-summary-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-prestamista {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Estadísticas Rápidas -->
    <div class="row">
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-value">{{ number_format($totalPrestamosActivos, 2) }} Bs.</div>
                <div class="stats-label">Capital en Préstamos</div>
                <div class="progress progress-thin mt-2">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $porcentajeActivos }}%"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-value">{{ number_format($totalRecuperado, 2) }} Bs.</div>
                <div class="stats-label">Capital Recuperado</div>
                <div class="progress progress-thin mt-2">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $porcentajeRecuperado }}%"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-value">{{ $totalClientes }}</div>
                <div class="stats-label">Clientes Activos</div>
                <div class="progress progress-thin mt-2">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros y Búsqueda -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card prestamista-card">
                <div class="card-body">
                    <form id="filtersForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <select class="form-control" name="estado">
                                        <option value="">Todos</option>
                                        <option value="activo">Activos</option>
                                        <option value="atrasado">Atrasados</option>
                                        <option value="finalizado">Finalizados</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha Desde</label>
                                    <input type="date" class="form-control" name="fecha_desde">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha Hasta</label>
                                    <input type="date" class="form-control" name="fecha_hasta">
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-filter mr-1"></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Listado de Préstamos -->
    <div class="row">
        <div class="col-md-12">
            <div class="card prestamista-card">
                <div class="card-header prestamista-card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Préstamos Activos</h5>
                    <div class="badge badge-light">
                        Mostrando {{ $prestamos->count() }} de {{ $totalPrestamos }} préstamos
                    </div>
                </div>
                <div class="card-body prestamista-card-body">
                    @if($prestamos->count() > 0)
                    @foreach($prestamos as $prestamo)
                    <div class="loan-item mb-4 pb-4 border-bottom">
                        <div class="client-info">
                            <div class="client-avatar">
                                {{ substr($prestamo->cliente->nombre_completo ?? 'S', 0, 1) }}
                            </div>
                            <div class="client-details">
                                <div class="client-name">{{ $prestamo->cliente->nombre_completo ?? 'Sin nombre' }}</div>
                                <div class="client-meta">
                                    <span class="mr-3"><i class="fas fa-id-card mr-1"></i> {{ $prestamo->cliente->ci ?? '-' }}</span>
                                    <span><i class="fas fa-phone mr-1"></i> {{ $prestamo->cliente->telefono ?? '-' }}</span>
                                </div>
                            </div>
                            <span class="status-badge {{ $prestamo->esta_atrasado ? 'status-delayed' : 'status-active' }}">
                                <i class="fas {{ $prestamo->esta_atrasado ? 'fa-exclamation-triangle' : 'fa-check-circle' }} mr-1"></i>
                                {{ $prestamo->esta_atrasado ? 'Atrasado' : 'Activo' }}
                            </span>
                        </div>

                        <div class="loan-summary-grid">
                            <div class="loan-summary-item">
                                <div class="loan-summary-label">Monto del Préstamo</div>
                                <div class="loan-summary-value amount">{{ number_format($prestamo->monto_aprobado, 2) }} Bs.</div>
                            </div>
                            <div class="loan-summary-item">
                                <div class="loan-summary-label">Saldo Pendiente</div>
                                <div class="loan-summary-value">{{ number_format($prestamo->saldo_pendiente, 2) }} Bs.</div>
                            </div>
                            <div class="loan-summary-item">
                                <div class="loan-summary-label">Tasa de Interés</div>
                                <div class="loan-summary-value">{{ $prestamo->interes->tasa_interes ?? 0 }}%</div>
                            </div>
                            <div class="loan-summary-item">
                                <div class="loan-summary-label">Próximo Pago</div>
                                <div class="loan-summary-value">{{ $prestamo->proximo_pago }}</div>
                            </div>
                            <div class="loan-summary-item">
                                <div class="loan-summary-label">Monto Cuota</div>
                                <div class="loan-summary-value">{{ number_format($prestamo->monto_cuota, 2) }} Bs.</div>
                            </div>
                            <div class="loan-summary-item">
                                <div class="loan-summary-label">Días Atraso</div>
                                <div class="loan-summary-value">{{ $prestamo->dias_atraso ?? '0' }}</div>
                            </div>
                        </div>

                        <div class="progress-thin mb-2">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $prestamo->porcentaje_pagado ?? 0 }}%"></div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <small>Pagado: {{ number_format($prestamo->porcentaje_pagado ?? 0, 1) }}% ({{ number_format($prestamo->monto_pagado ?? 0, 2) }} Bs.)</small>
                            <small>Pendiente: {{ number_format(100 - ($prestamo->porcentaje_pagado ?? 0), 1) }}% ({{ number_format($prestamo->saldo_pendiente, 2) }} Bs.)</small>
                        </div>
                    </div>


                    <div class="action-buttons">
                        <a href="{{ route('prestamos.show', $prestamo->id) }}" class="btn btn-details">
                            <i class="fas fa-file-invoice mr-1"></i> Ver Detalles
                        </a>
                        <a href="{{ route('pagos.create', ['prestamo_id' => $prestamo->id]) }}" class="btn btn-payments">
                            <i class="fas fa-money-bill-wave mr-1"></i> Registrar Pago
                        </a>
                        @if($prestamo->esta_atrasado)
                        <button class="btn btn-alert">
                            <i class="fas fa-bell mr-1"></i> Notificar Cliente
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach

                <div class="d-flex justify-content-center mt-4">
                    {{ $prestamos->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No se encontraron préstamos</h4>
                    <p class="text-muted">No hay préstamos que coincidan con los criterios de búsqueda</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        // Inicializar tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // Filtros de búsqueda
        $('#filtersForm').submit(function(e) {
            e.preventDefault();
            // Aquí iría la lógica para filtrar los préstamos
            // Puede ser una llamada AJAX o recargar la página con parámetros
            console.log('Filtrar préstamos:', $(this).serialize());
            // Ejemplo con recarga de página:
            const params = new URLSearchParams($(this).serialize());
            window.location.href = window.location.pathname + '?' + params.toString();
        });

        // Mostrar/ocultar detalles adicionales
        $('.toggle-details').click(function() {
            $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
            $(this).closest('.loan-item').find('.additional-details').slideToggle();
        });

        // Inicializar DataTable (si decides usar tablas)
        // $('#loansTable').DataTable({
        //     language: {
        //         url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
        //     },
        //     order: [[3, 'asc']] // Ordenar por fecha de próximo pago
        // });
    });
</script>
@endsection