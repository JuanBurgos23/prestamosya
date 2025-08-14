@extends('adminlte::page')

@section('title', 'Detalles del Préstamo')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="font-weight-bold text-dark">
        <i class="fas fa-file-invoice-dollar mr-2"></i>
        Detalles del Préstamo #{{ $prestamo->id }}
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
    .loan-detail-card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: none;
        margin-bottom: 25px;
        overflow: hidden;
    }

    .loan-detail-header {
        background: linear-gradient(135deg, #2c3e50, #4a6491);
        color: white;
        padding: 15px 20px;
        border-bottom: none;
    }

    .loan-detail-body {
        padding: 25px;
        background-color: #fff;
    }

    .detail-section {
        margin-bottom: 30px;
    }

    .section-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 10px;
        color: #3498db;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .detail-item {
        padding: 15px;
        border-radius: 6px;
        background-color: #f8f9fa;
    }

    .detail-label {
        font-size: 0.85rem;
        color: #7f8c8d;
        font-weight: 500;
        margin-bottom: 5px;
    }

    .detail-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .detail-value.amount {
        color: #27ae60;
    }

    .progress-thin {
        height: 8px;
        border-radius: 4px;
    }

    .payment-card {
        border-left: 4px solid #3498db;
        border-radius: 6px;
        margin-bottom: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .payment-card-header {
        background-color: #f8f9fa;
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .payment-card-body {
        padding: 15px;
    }

    .payment-status {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 12px;
    }

    .status-completed {
        background-color: rgba(46, 204, 113, 0.2);
        color: #27ae60;
    }

    .comprobante-btn {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .comprobante-btn:hover {
        background-color: #2980b9;
    }

    .btn-print {
        background: linear-gradient(135deg, #2c3e50, #4a6491);
        color: white;
        border: none;
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 6px;
        transition: all 0.3s;
    }

    .btn-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .empty-payments {
        text-align: center;
        padding: 30px;
        color: #7f8c8d;
    }

    .empty-payments i {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: #bdc3c7;
    }

    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="loan-detail-card">
                <div class="loan-detail-header">
                    <h5 class="mb-0">Resumen del Préstamo</h5>
                </div>
                <div class="loan-detail-body">
                    <!-- Información del Cliente -->
                    <div class="detail-section">
                        <h5 class="section-title">
                            <i class="fas fa-user-tie"></i>
                            Información del Cliente
                        </h5>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="text-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; margin: 0 auto 10px; font-size: 1.8rem; font-weight: bold;">
                                        {{ substr($prestamo->cliente->nombre_completo, 0, 1) }}
                                    </div>
                                    <small>ID: {{ $prestamo->cliente->id }}</small>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="detail-item">
                                            <div class="detail-label">Nombre Completo</div>
                                            <div class="detail-value">{{ $prestamo->cliente->nombre_completo }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="detail-item">
                                            <div class="detail-label">Documento de Identidad</div>
                                            <div class="detail-value">{{ $prestamo->cliente->ci }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="detail-item">
                                            <div class="detail-label">Teléfono</div>
                                            <div class="detail-value">{{ $prestamo->cliente->telefono }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detalles del Préstamo -->
                    <div class="detail-section">
                        <h5 class="section-title">
                            <i class="fas fa-hand-holding-usd"></i>
                            Detalles del Préstamo
                        </h5>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Monto Aprobado</div>
                                <div class="detail-value amount">{{ number_format($prestamo->monto_aprobado, 2) }} Bs.</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Tasa de Interés</div>
                                <div class="detail-value">{{ $prestamo->interes->tasa_interes ?? '0' }}%</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Plazo</div>
                                <div class="detail-value">{{ $prestamo->plazo }} {{ $prestamo->tipoPlazo->nombre ?? '' }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Fecha de Inicio</div>
                                <div class="detail-value">{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Fecha de Vencimiento</div>
                                <div class="detail-value">{{ \Carbon\Carbon::parse($prestamo->fecha_vencimiento)->format('d/m/Y') }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Estado</div>
                                <div class="detail-value">
                                    <span class="payment-status status-completed">
                                        {{ ucfirst($prestamo->estado) }}
                                    </span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Saldo Pendiente</div>
                                <div class="detail-value amount">{{ number_format($prestamo->saldo_pendiente, 2) }} Bs.</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Monto Cuota</div>
                                <div class="detail-value amount">{{ number_format($prestamo->monto_cuota, 2) }} Bs.</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Próximo Pago</div>
                                <div class="detail-value">{{ $prestamo->proximo_pago }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Días de Atraso</div>
                                <div class="detail-value">{{ $prestamo->dias_atraso }}</div>
                            </div>
                        </div>
                    </div>


                    <!-- Progreso del Pago -->
                    <div class="detail-section">
                        <h5 class="section-title">
                            <i class="fas fa-chart-line"></i>
                            Progreso del Pago
                        </h5>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Monto Pagado</div>
                                <div class="detail-value amount">{{ number_format($prestamo->monto_pagado ?? 0, 2) }} Bs.</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Interés Pagado</div>
                                <div class="detail-value">{{ number_format($prestamo->interes_pagado ?? 0, 2) }} Bs.</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Saldo Pendiente</div>
                                <div class="detail-value">{{ number_format($prestamo->saldo_pendiente ?? 0, 2) }} Bs.</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Próximo Pago</div>
                                <div class="detail-value">{{ $prestamo->proximo_pago ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <small>Progreso: {{ number_format($prestamo->porcentaje_pagado ?? 0, 1) }}% completado</small>
                                <small>{{ number_format($prestamo->monto_pagado ?? 0, 2) }} Bs. de {{ number_format($prestamo->monto_aprobado ?? 0, 2) }} Bs.</small>
                            </div>
                            <div class="progress progress-thin">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $prestamo->porcentaje_pagado ?? 0 }}%"></div>
                            </div>
                        </div>
                    </div>


                    <!-- Comentarios -->
                    @if($prestamo->comentario)
                    <div class="detail-section">
                        <h5 class="section-title">
                            <i class="fas fa-comment-alt"></i>
                            Comentarios
                        </h5>
                        <div class="alert alert-light">
                            {{ $prestamo->comentario }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Historial de Pagos -->
            <div class="loan-detail-card">
                <div class="loan-detail-header">
                    <h5 class="mb-0">Historial de Pagos</h5>
                </div>
                <div class="loan-detail-body">
                    @if($prestamo->pagos->count() > 0)
                    @foreach($prestamo->pagos as $pago)
                    <div class="payment-card">
                        <div class="payment-card-header">
                            <div>
                                <strong>Pago #{{ $pago->id }}</strong>
                                <small class="text-muted ml-2">{{ $pago->fecha_pago }}</small>
                            </div>
                            <span class="payment-status status-completed">
                                Completado
                            </span>
                        </div>
                        <div class="payment-card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="detail-label">Monto del Pago</div>
                                    <div class="detail-value amount">{{ number_format($pago->monto, 2) }} Bs.</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="detail-label">Capital Pagado</div>
                                    <div class="detail-value">{{ number_format($pago->capital_pagado, 2) }} Bs.</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="detail-label">Interés Pagado</div>
                                    <div class="detail-value">{{ number_format($pago->interes_pagado, 2) }} Bs.</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="detail-label">Saldo Restante</div>
                                    <div class="detail-value">{{ number_format($pago->saldo_restante, 2) }} Bs.</div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="detail-label">Método de Pago</div>
                                    <div class="detail-value">{{ ucfirst($pago->metodo_pago) }}</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="detail-label">Registrado por</div>
                                    <div class="detail-value">{{ $pago->prestamista->name }}</div>
                                </div>
                                <div class="col-md-4">
                                    @if($pago->comprobante)
                                    <button class="comprobante-btn" onclick="viewComprobante('{{ asset('storage/'.$pago->comprobante) }}')">
                                        <i class="fas fa-file-invoice mr-1"></i> Ver Comprobante
                                    </button>
                                    @else
                                    <span class="text-muted">Sin comprobante</span>
                                    @endif
                                </div>
                            </div>
                            @if($pago->comentario)
                            <div class="alert alert-light mt-3 mb-0">
                                <strong><i class="fas fa-comment mr-1"></i> Nota:</strong>
                                {{ $pago->comentario }}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="empty-payments">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <h5>No se han registrado pagos</h5>
                        <p>No hay pagos asociados a este préstamo</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="text-right mt-4">
                <button class="btn-print" onclick="window.print()">
                    <i class="fas fa-print mr-1"></i> Imprimir Detalles
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Comprobante -->
<div class="modal fade" id="comprobanteModal" tabindex="-1" role="dialog" aria-labelledby="comprobanteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comprobanteModalLabel">Comprobante de Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="comprobanteImage" src="" alt="Comprobante de pago" style="max-width: 100%; max-height: 70vh;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <a id="downloadComprobante" href="#" class="btn btn-primary" download>
                    <i class="fas fa-download mr-1"></i> Descargar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script>
    function viewComprobante(imageUrl) {
        $('#comprobanteImage').attr('src', imageUrl);
        $('#downloadComprobante').attr('href', imageUrl);
        $('#comprobanteModal').modal('show');
    }

    $(document).ready(function() {
        // Inicializar tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection