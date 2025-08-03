@extends('adminlte::page')

@section('title', 'Solicitudes de Préstamo')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="font-weight-bold text-dark">
        <i class="fas fa-file-signature mr-2"></i>
        Solicitudes de Préstamo
    </h1>
    <div class="badge badge-primary p-2">
        <i class="fas fa-user-tie mr-1"></i>
        Panel Prestamista
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<style>
    .solicitud-card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: none;
        margin-bottom: 25px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }
    .solicitud-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }
    .solicitud-header {
        background: linear-gradient(135deg, #4a6491, #2c3e50);
        color: white;
        padding: 15px 20px;
        border-bottom: none;
        position: relative;
    }
    .solicitud-body {
        padding: 20px;
        background-color: #fff;
    }
    .solicitud-status {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
    }
    .solicitud-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
    }
    .solicitud-item {
        padding: 12px;
        border-radius: 6px;
        background-color: #f8f9fa;
    }
    .solicitud-label {
        font-size: 0.8rem;
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 5px;
    }
    .solicitud-value {
        font-size: 1rem;
        font-weight: 600;
        color: #2c3e50;
    }
    .solicitud-value.amount {
        color: #3498db;
        font-size: 1.1rem;
    }
    .client-info-container {
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
    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }
    .btn-solicitud {
        border-radius: 6px;
        padding: 8px 15px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s;
        border: none;
    }
    .btn-approve {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        color: white;
    }
    .btn-approve:hover {
        background: linear-gradient(135deg, #27ae60, #219653);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(39, 174, 96, 0.2);
    }
    .btn-deny {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
    }
    .btn-deny:hover {
        background: linear-gradient(135deg, #c0392b, #a53125);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(231, 76, 60, 0.2);
    }
    .btn-details {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
    }
    .btn-details:hover {
        background: linear-gradient(135deg, #2980b9, #2472a4);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(41, 128, 185, 0.2);
    }
    .status-pending {
        background-color: rgba(241, 196, 15, 0.2);
        color: #f39c12;
    }
    .status-approved {
        background-color: rgba(46, 204, 113, 0.2);
        color: #27ae60;
    }
    .status-denied {
        background-color: rgba(231, 76, 60, 0.2);
        color: #e74c3c;
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
    .filter-card {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }
    .empty-state-icon {
        font-size: 3rem;
        color: #bdc3c7;
        margin-bottom: 15px;
    }
    .empty-state-text {
        color: #7f8c8d;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .solicitud-grid {
            grid-template-columns: 1fr;
        }
        .action-buttons {
            flex-direction: column;
        }
        .btn-solicitud {
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
                <div class="stats-value">{{ $totalSolicitudes }}</div>
                <div class="stats-label">Total Solicitudes</div>
                <div class="progress mt-2" style="height: 4px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-value">{{ $solicitudesPendientes }}</div>
                <div class="stats-label">Pendientes de Revisión</div>
                <div class="progress mt-2" style="height: 4px;">
                    <div class="progress-bar bg-warning" role="progressbar" 
                         style="width: {{ $totalSolicitudes > 0 ? round(($solicitudesPendientes/$totalSolicitudes)*100) : 0 }}%"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-value">{{ number_format($montoTotalSolicitado, 2) }} Bs.</div>
                <div class="stats-label">Monto Total Solicitado</div>
                <div class="progress mt-2" style="height: 4px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="row">
        <div class="col-md-12">
            <div class="card filter-card">
                <div class="card-body">
                    <form id="filtersForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <select class="form-control" name="estado">
                                        <option value="">Todos</option>
                                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendientes</option>
                                        <option value="aprobado" {{ request('estado') == 'aprobado' ? 'selected' : '' }}>Aprobados</option>
                                        <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazados</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha Desde</label>
                                    <input type="date" class="form-control" name="fecha_desde" value="{{ request('fecha_desde') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha Hasta</label>
                                    <input type="date" class="form-control" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
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

    <!-- Listado de Solicitudes -->
    <div class="row">
        <div class="col-md-12">
            @if($solicitudes->count() > 0)
                @foreach($solicitudes as $solicitud)
                <div class="card solicitud-card mb-4">
                    <div class="card-header solicitud-header">
                        <h5 class="mb-0">Solicitud #{{ $solicitud->id }}</h5>
                        <span class="solicitud-status {{ 
                            $solicitud->estado == 'pendiente' ? 'status-pending' : 
                            ($solicitud->estado == 'aprobado' ? 'status-approved' : 'status-denied') 
                        }}">
                            <i class="fas {{ 
                                $solicitud->estado == 'pendiente' ? 'fa-clock' : 
                                ($solicitud->estado == 'aprobado' ? 'fa-check-circle' : 'fa-times-circle') 
                            }} mr-1"></i>
                            {{ ucfirst($solicitud->estado) }}
                        </span>
                    </div>
                    <div class="card-body solicitud-body">
                        <div class="client-info-container">
                            <div class="client-avatar">
                                {{ substr($solicitud->cliente->nombre_completo, 0, 1) }}
                            </div>
                            <div class="client-details">
                                <div class="client-name">{{ $solicitud->cliente->nombre_completo }}</div>
                                <div class="client-meta">
                                    <span class="mr-3"><i class="fas fa-id-card mr-1"></i> {{ $solicitud->cliente->ci }}</span>
                                    <span><i class="fas fa-phone mr-1"></i> {{ $solicitud->cliente->telefono }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="solicitud-grid">
                            <div class="solicitud-item">
                                <div class="solicitud-label">Monto Solicitado</div>
                                <div class="solicitud-value amount">{{ number_format($solicitud->monto_solicitado, 2) }} Bs.</div>
                            </div>
                            <div class="solicitud-item">
                                <div class="solicitud-label">Fecha Solicitud</div>
                                <div class="solicitud-value">{{ $solicitud->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            <div class="solicitud-item">
                                <div class="solicitud-label">Estado</div>
                                <div class="solicitud-value">{{ ucfirst($solicitud->estado) }}</div>
                            </div>
                            <div class="solicitud-item">
                                <div class="solicitud-label">Revisado por</div>
                                <div class="solicitud-value">{{ $solicitud->prestamista ? $solicitud->prestamista->name : 'N/A' }}</div>
                            </div>
                        </div>

                        @if($solicitud->comentario)
                        <div class="alert alert-light mt-3 mb-0">
                            <strong><i class="fas fa-comment mr-2"></i>Comentario:</strong>
                            {{ $solicitud->comentario }}
                        </div>
                        @endif

                        <div class="action-buttons">
                            <a href="{{ route('solicitudes.show', $solicitud->id) }}" class="btn btn-details">
                                <i class="fas fa-eye mr-1"></i> Ver Detalles
                            </a>
                            
                            @if($solicitud->estado == 'pendiente')
                            <form action="{{ route('solicitudes.aprobar', $solicitud->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-approve">
                                    <i class="fas fa-check mr-1"></i> Aprobar
                                </button>
                            </form>
                            <button type="button" class="btn btn-deny" data-toggle="modal" 
                                    data-target="#denyModal" data-id="{{ $solicitud->id }}">
                                <i class="fas fa-times mr-1"></i> Rechazar
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="d-flex justify-content-center mt-4">
                    {{ $solicitudes->links() }}
                </div>
            @else
                <div class="card solicitud-card">
                    <div class="card-body">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h4 class="empty-state-text">No se encontraron solicitudes</h4>
                            <p class="text-muted">No hay solicitudes que coincidan con los criterios de búsqueda</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para Rechazar Solicitud -->
<div class="modal fade" id="denyModal" tabindex="-1" role="dialog" aria-labelledby="denyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="denyModalLabel">Rechazar Solicitud</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="denyForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="denyReason">Motivo del rechazo</label>
                        <textarea class="form-control" id="denyReason" name="comentario" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Confirmar Rechazo</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        // Configurar el modal de rechazo
        $('#denyModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var solicitudId = button.data('id');
            var form = $('#denyForm');
            form.attr('action', '/solicitudes/' + solicitudId + '/rechazar');
        });

        // Inicializar DataTables (opcional)
        // $('#solicitudesTable').DataTable({
        //     language: {
        //         url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
        //     },
        //     order: [[1, 'desc']] // Ordenar por fecha más reciente
        // });

        // Filtros
        $('#filtersForm').submit(function(e) {
            e.preventDefault();
            const params = new URLSearchParams($(this).serialize());
            window.location.href = window.location.pathname + '?' + params.toString();
        });
    });
</script>
@endsection