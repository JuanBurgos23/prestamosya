@extends('adminlte::page')

@section('title', 'Mis Préstamos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-primary">
            <i class="fas fa-file-invoice-dollar mr-2"></i>
            Mis Préstamos
        </h1>
        <div class="badge badge-primary p-2">
            <i class="fas fa-user-shield mr-1"></i>
            Área Cliente
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <style>
        .loan-card {
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
            border: none;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .loan-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }
        .loan-card-header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding: 15px 20px;
            border-bottom: none;
            position: relative;
        }
        .loan-card-header .status-badge {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 20px;
        }
        .loan-card-body {
            padding: 20px;
            background-color: #fff;
        }
        .loan-summary {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }
        .loan-summary-item {
            flex: 1;
            min-width: 150px;
            margin-bottom: 10px;
            padding: 0 10px;
        }
        .loan-summary-label {
            font-size: 0.8rem;
            color: #7f8c8d;
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
            font-size: 1.3rem;
        }
        .loan-progress-container {
            margin: 20px 0;
        }
        .loan-progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 0.85rem;
        }
        .loan-progress-bar {
            height: 8px;
            border-radius: 4px;
            background-color: #ecf0f1;
            overflow: hidden;
        }
        .loan-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #2ecc71, #27ae60);
            border-radius: 4px;
            transition: width 0.6s ease;
        }
        .loan-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 15px;
            gap: 10px;
        }
        .btn-loan-action {
            border-radius: 4px;
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
        }
        .btn-pay {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
            border: none;
        }
        .btn-pay:hover {
            background: linear-gradient(135deg, #27ae60, #219653);
            transform: translateY(-2px);
        }
        .loan-stats-card {
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        .loan-stats-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .loan-stats-label {
            font-size: 0.9rem;
            color: #7f8c8d;
        }
        .section-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f0f0f0;
        }
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-top: 20px;
        }
        .empty-state-icon {
            font-size: 3rem;
            color: #bdc3c7;
            margin-bottom: 15px;
        }
        .empty-state-text {
            font-size: 1.1rem;
            color: #7f8c8d;
            margin-bottom: 20px;
        }
        .tab-content {
            padding: 20px 0;
        }
        .nav-tabs .nav-link {
            font-weight: 600;
            color: #7f8c8d;
            border: none;
            padding: 12px 20px;
        }
        .nav-tabs .nav-link.active {
            color: #3498db;
            border-bottom: 3px solid #3498db;
            background-color: transparent;
        }
        .loan-detail-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed #eee;
        }
        .loan-detail-label {
            font-weight: 500;
            color: #7f8c8d;
        }
        .loan-detail-value {
            font-weight: 600;
            color: #2c3e50;
        }
        .status-active {
            background-color: rgba(46, 204, 113, 0.2);
            color: #27ae60;
        }
        .status-pending {
            background-color: rgba(241, 196, 15, 0.2);
            color: #f39c12;
        }
        .status-completed {
            background-color: rgba(52, 152, 219, 0.2);
            color: #2980b9;
        }
        .status-default {
            background-color: rgba(189, 195, 199, 0.2);
            color: #7f8c8d;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .loan-summary-item {
                min-width: 100%;
                margin-bottom: 15px;
            }
            .loan-actions {
                flex-direction: column;
            }
            .btn-loan-action {
                width: 100%;
                margin-bottom: 10px;
            }
            .loan-stats-card {
                margin-bottom: 15px;
            }
            .loan-stats-value {
                font-size: 1.5rem;
            }
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Estadísticas Resumen -->
        <div class="col-md-4">
            <div class="loan-stats-card">
                <div class="loan-stats-value">{{ number_format($totalPendiente, 2) }} Bs.</div>
                <div class="loan-stats-label">Total Pendiente</div>
                <div class="progress mt-2" style="height: 4px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $porcentajePendiente }}%"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="loan-stats-card">
                <div class="loan-stats-value">{{ number_format($totalPagado, 2) }} Bs.</div>
                <div class="loan-stats-label">Total Pagado</div>
                <div class="progress mt-2" style="height: 4px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $porcentajePagado }}%"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="loan-stats-card">
                <div class="loan-stats-value">{{ $totalPrestamos }}</div>
                <div class="loan-stats-label">Préstamos Totales</div>
                <div class="progress mt-2" style="height: 4px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="loanTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active" role="tab">Activos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab">Finalizados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab">Pendientes</a>
                </li>
            </ul>

            <div class="tab-content" id="loanTabsContent">
                <!-- Préstamos Activos -->
                <div class="tab-pane fade show active" id="active" role="tabpanel">
                    @if($prestamosActivos->count() > 0)
                        @foreach($prestamosActivos as $prestamo)
                            <div class="card loan-card">
                                <div class="card-header loan-card-header">
                                    <h5 class="mb-0">Préstamo #{{ $prestamo->id }}</h5>
                                    <span class="status-badge status-active">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Activo
                                    </span>
                                </div>
                                <div class="card-body loan-card-body">
                                    <div class="loan-summary">
                                        <div class="loan-summary-item">
                                            <div class="loan-summary-label">Monto Total</div>
                                            <div class="loan-summary-value amount">{{ number_format($prestamo->monto_aprobado, 2) }} Bs.</div>
                                        </div>
                                        <div class="loan-summary-item">
                                            <div class="loan-summary-label">Saldo Pendiente</div>
                                            <div class="loan-summary-value">{{ number_format($prestamo->saldo_pendiente, 2) }} Bs.</div>
                                        </div>
                                        <div class="loan-summary-item">
                                            <div class="loan-summary-label">Tasa de Interés</div>
                                            <div class="loan-summary-value">{{ $prestamo->interes }}%</div>
                                        </div>
                                        <div class="loan-summary-item">
                                            <div class="loan-summary-label">Próximo Pago</div>
                                            <div class="loan-summary-value">{{ $prestamo->proximo_pago ? $prestamo->proximo_pago->format('d/m/Y') : 'N/A' }}</div>
                                        </div>
                                    </div>

                                    <div class="loan-progress-container">
                                        <div class="loan-progress-label">
                                            <span>Pagado: {{ number_format($prestamo->porcentaje_pagado, 0) }}%</span>
                                            <span>{{ number_format($prestamo->monto_pagado, 2) }} Bs. de {{ number_format($prestamo->monto_aprobado, 2) }} Bs.</span>
                                        </div>
                                        <div class="loan-progress-bar">
                                            <div class="loan-progress-fill" style="width: {{ $prestamo->porcentaje_pagado }}%"></div>
                                        </div>
                                    </div>

                                    <div class="loan-actions">
                                        <button class="btn btn-loan-action btn-details" data-toggle="modal" data-target="#loanDetailsModal" 
                                            data-loan="{{ json_encode($prestamo) }}">
                                            <i class="fas fa-eye mr-1"></i> Ver Detalles
                                        </button>
                                        <a href="{{ route('pagos.create', ['prestamo_id' => $prestamo->id]) }}" class="btn btn-loan-action btn-pay">
                                            <i class="fas fa-money-bill-wave mr-1"></i> Realizar Pago
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <h4 class="empty-state-text">No tienes préstamos activos</h4>
                            <a href="{{ route('solicitud.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-1"></i> Solicitar Préstamo
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Préstamos Finalizados -->
                <div class="tab-pane fade" id="completed" role="tabpanel">
                    @if($prestamosFinalizados->count() > 0)
                        @foreach($prestamosFinalizados as $prestamo)
                            <div class="card loan-card">
                                <div class="card-header loan-card-header">
                                    <h5 class="mb-0">Préstamo #{{ $prestamo->id }}</h5>
                                    <span class="status-badge status-completed">
                                        <i class="fas fa-flag-checkered mr-1"></i>
                                        Finalizado
                                    </span>
                                </div>
                                <div class="card-body loan-card-body">
                                    <div class="loan-summary">
                                        <div class="loan-summary-item">
                                            <div class="loan-summary-label">Monto Total</div>
                                            <div class="loan-summary-value amount">{{ number_format($prestamo->monto_aprobado, 2) }} Bs.</div>
                                        </div>
                                        <div class="loan-summary-item">
                                            <div class="loan-summary-label">Interés Pagado</div>
                                            <div class="loan-summary-value">{{ number_format($prestamo->interes_pagado, 2) }} Bs.</div>
                                        </div>
                                        <div class="loan-summary-item">
                                            <div class="loan-summary-label">Fecha Finalización</div>
                                            <div class="loan-summary-value">{{ $prestamo->fecha_finalizacion->format('d/m/Y') }}</div>
                                        </div>
                                        <div class="loan-summary-item">
                                            <div class="loan-summary-label">Estado</div>
                                            <div class="loan-summary-value">Completado</div>
                                        </div>
                                    </div>

                                    <div class="loan-progress-container">
                                        <div class="loan-progress-label">
                                            <span>Pagado: 100%</span>
                                            <span>{{ number_format($prestamo->monto_aprobado, 2) }} Bs. de {{ number_format($prestamo->monto_aprobado, 2) }} Bs.</span>
                                        </div>
                                        <div class="loan-progress-bar">
                                            <div class="loan-progress-fill" style="width: 100%"></div>
                                        </div>
                                    </div>

                                    <div class="loan-actions">
                                        <button class="btn btn-loan-action btn-details" data-toggle="modal" data-target="#loanDetailsModal" 
                                            data-loan="{{ json_encode($prestamo) }}">
                                            <i class="fas fa-eye mr-1"></i> Ver Detalles
                                        </button>
                                        <button class="btn btn-loan-action btn-secondary">
                                            <i class="fas fa-file-download mr-1"></i> Descargar Certificado
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-flag-checkered"></i>
                            </div>
                            <h4 class="empty-state-text">No tienes préstamos finalizados</h4>
                        </div>
                    @endif
                </div>

                <!-- Préstamos Pendientes -->
                <div class="tab-pane fade" id="pending" role="tabpanel">
                    @if($prestamosPendientes->count() > 0)
                        @foreach($prestamosPendientes as $prestamo)
                            <div class="card loan-card">
                                <div class="card-header loan-card-header">
                                    <h5 class="mb-0">Solicitud #{{ $prestamo->id }}</h5>
                                    <span class="status-badge status-pending">
                                        <i class="fas fa-clock mr-1"></i>
                                        En Revisión
                                    </span>
                                </div>
                                <div class="card-body loan-card-body">
                                    <div class="loan-summary">
                                        <div class="loan-summary-item">
                                            <div class="loan-summary-label">Monto Solicitado</div>
                                            <div class="loan-summary-value amount">{{ number_format($prestamo->monto_solicitado, 2) }} Bs.</div>
                                        </div>
                                        <div class="loan-summary-item">
                                            <div class="loan-summary-label">Fecha Solicitud</div>
                                            <div class="loan-summary-value">{{ $prestamo->created_at->format('d/m/Y') }}</div>
                                        </div>
                                        <div class="loan-summary-item">
                                            <div class="loan-summary-label">Estado</div>
                                            <div class="loan-summary-value">En Proceso</div>
                                        </div>
                                        <div class="loan-summary-item">
                                            <div class="loan-summary-label">Tiempo Estimado</div>
                                            <div class="loan-summary-value">2-3 días hábiles</div>
                                        </div>
                                    </div>

                                    <div class="loan-actions">
                                        <button class="btn btn-loan-action btn-details" data-toggle="modal" data-target="#loanDetailsModal" 
                                            data-loan="{{ json_encode($prestamo) }}">
                                            <i class="fas fa-eye mr-1"></i> Ver Detalles
                                        </button>
                                        <button class="btn btn-loan-action btn-secondary">
                                            <i class="fas fa-envelope mr-1"></i> Contactar Soporte
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h4 class="empty-state-text">No tienes préstamos pendientes</h4>
                            <a href="{{ route('solicitud.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-1"></i> Solicitar Préstamo
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detalles del Préstamo -->
<div class="modal fade" id="loanDetailsModal" tabindex="-1" role="dialog" aria-labelledby="loanDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loanDetailsModalLabel">Detalles del Préstamo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="loanDetailsContent">
                <!-- Contenido dinámico se cargará aquí -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="printLoanDetails">
                    <i class="fas fa-print mr-1"></i> Imprimir
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.es.min.js"></script>
<script>
    $(document).ready(function() {
        // Cargar detalles del préstamo en el modal
        $('#loanDetailsModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var loanData = JSON.parse(button.data('loan'));
            var modal = $(this);
            
            // Configurar título
            modal.find('.modal-title').text('Detalles del ' + (loanData.fecha_finalizacion ? 'Préstamo' : 'Solicitud') + ' #' + loanData.id);
            
            // Construir contenido del modal
            var content = `
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="font-weight-bold mb-3">Información Básica</h5>
                        <div class="loan-detail-item">
                            <span class="loan-detail-label">Estado:</span>
                            <span class="loan-detail-value">
                                ${getStatusBadge(loanData.estado || (loanData.fecha_finalizacion ? 'completado' : 'activo'))}
                            </span>
                        </div>
                        <div class="loan-detail-item">
                            <span class="loan-detail-label">Monto ${loanData.fecha_finalizacion ? 'Aprobado' : 'Solicitado'}:</span>
                            <span class="loan-detail-value">${formatCurrency(loanData.monto_aprobado || loanData.monto_solicitado)} Bs.</span>
                        </div>
                        ${loanData.interes ? `
                        <div class="loan-detail-item">
                            <span class="loan-detail-label">Tasa de Interés:</span>
                            <span class="loan-detail-value">${loanData.interes}%</span>
                        </div>
                        ` : ''}
                        <div class="loan-detail-item">
                            <span class="loan-detail-label">Fecha ${loanData.fecha_inicio ? 'Inicio' : 'Solicitud'}:</span>
                            <span class="loan-detail-value">${formatDate(loanData.fecha_inicio || loanData.created_at)}</span>
                        </div>
                        ${loanData.fecha_vencimiento ? `
                        <div class="loan-detail-item">
                            <span class="loan-detail-label">Fecha Vencimiento:</span>
                            <span class="loan-detail-value">${formatDate(loanData.fecha_vencimiento)}</span>
                        </div>
                        ` : ''}
                        ${loanData.fecha_finalizacion ? `
                        <div class="loan-detail-item">
                            <span class="loan-detail-label">Fecha Finalización:</span>
                            <span class="loan-detail-value">${formatDate(loanData.fecha_finalizacion)}</span>
                        </div>
                        ` : ''}
                    </div>
                    <div class="col-md-6">
                        <h5 class="font-weight-bold mb-3">Detalles de Pago</h5>
                        ${loanData.saldo_pendiente ? `
                        <div class="loan-detail-item">
                            <span class="loan-detail-label">Saldo Pendiente:</span>
                            <span class="loan-detail-value">${formatCurrency(loanData.saldo_pendiente)} Bs.</span>
                        </div>
                        ` : ''}
                        ${loanData.monto_pagado ? `
                        <div class="loan-detail-item">
                            <span class="loan-detail-label">Monto Pagado:</span>
                            <span class="loan-detail-value">${formatCurrency(loanData.monto_pagado)} Bs.</span>
                        </div>
                        ` : ''}
                        ${loanData.interes_pagado ? `
                        <div class="loan-detail-item">
                            <span class="loan-detail-label">Interés Pagado:</span>
                            <span class="loan-detail-value">${formatCurrency(loanData.interes_pagado)} Bs.</span>
                        </div>
                        ` : ''}
                        ${loanData.proximo_pago ? `
                        <div class="loan-detail-item">
                            <span class="loan-detail-label">Próximo Pago:</span>
                            <span class="loan-detail-value">${formatDate(loanData.proximo_pago)}</span>
                        </div>
                        <div class="loan-detail-item">
                            <span class="loan-detail-label">Monto Próximo Pago:</span>
                            <span class="loan-detail-value">${formatCurrency(loanData.monto_cuota)} Bs.</span>
                        </div>
                        ` : ''}
                        ${loanData.porcentaje_pagado ? `
                        <div class="loan-detail-item">
                            <span class="loan-detail-label">Progreso:</span>
                            <span class="loan-detail-value">
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: ${loanData.porcentaje_pagado}%"></div>
                                </div>
                                <small>${loanData.porcentaje_pagado}% completado</small>
                            </span>
                        </div>
                        ` : ''}
                    </div>
                </div>
                ${loanData.comentario || loanData.destino_prestamo ? `
                <div class="row mt-3">
                    <div class="col-md-12">
                        <h5 class="font-weight-bold mb-3">${loanData.comentario ? 'Comentarios' : 'Destino del Préstamo'}</h5>
                        <div class="alert alert-light">
                            ${loanData.comentario || loanData.destino_prestamo}
                        </div>
                    </div>
                </div>
                ` : ''}
            `;
            
            modal.find('#loanDetailsContent').html(content);
        });
        
        // Función para formatear moneda
        function formatCurrency(amount) {
            return parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        
        // Función para formatear fecha
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('es-ES');
        }
        
        // Función para obtener el badge de estado
        function getStatusBadge(status) {
            const statusMap = {
                'activo': {class: 'status-active', icon: 'check-circle', text: 'Activo'},
                'pendiente': {class: 'status-pending', icon: 'clock', text: 'Pendiente'},
                'completado': {class: 'status-completed', icon: 'flag-checkered', text: 'Completado'},
                'default': {class: 'status-default', icon: 'info-circle', text: 'Desconocido'}
            };
            
            const statusInfo = statusMap[status] || statusMap['default'];
            return `<span class="badge ${statusInfo.class} p-1">
                <i class="fas fa-${statusInfo.icon} mr-1"></i>
                ${statusInfo.text}
            </span>`;
        }
        
        // Imprimir detalles del préstamo
        $('#printLoanDetails').click(function() {
            var printContent = document.getElementById('loanDetailsContent').innerHTML;
            var originalContent = document.body.innerHTML;
            
            document.body.innerHTML = `
                <h3 class="text-center mb-4">${document.getElementById('loanDetailsModalLabel').innerText}</h3>
                ${printContent}
                <div class="text-center mt-4 text-muted">
                    <small>Generado el ${new Date().toLocaleDateString('es-ES')}</small>
                </div>
            `;
            
            window.print();
            document.body.innerHTML = originalContent;
            $('#loanDetailsModal').modal('show');
        });
        
        // Actualizar pestañas activas en localStorage
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            localStorage.setItem('lastLoanTab', $(e.target).attr('href'));
        });
        
        // Recuperar última pestaña activa
        var lastTab = localStorage.getItem('lastLoanTab');
        if (lastTab) {
            $('[href="' + lastTab + '"]').tab('show');
        }
    });
</script>
@endsection