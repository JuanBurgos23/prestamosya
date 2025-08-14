@extends('adminlte::page')

@section('title', 'Registrar Préstamo')

@section('content_header')
<h1 class="font-weight-bold text-primary">
    <i class="fas fa-hand-holding-usd mr-2"></i>
    Registrar Préstamo
    @if($cliente)
    <span class="text-muted">para {{ $cliente->nombre_completo }}</span>
    @endif
</h1>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<style>
    .card-header-custom {
        border-bottom: 2px solid rgba(0, 0, 0, .1);
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .info-box-custom {
        box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
        border-radius: 0.375rem;
        background-color: #fff;
        display: flex;
        margin-bottom: 1rem;
        min-height: 80px;
        padding: 0.5rem;
        position: relative;
        width: 100%;
    }

    .info-box-icon-custom {
        align-items: center;
        display: flex;
        font-size: 1.875rem;
        justify-content: center;
        text-align: center;
        width: 70px;
        color: #6c757d;
    }

    .info-box-content-custom {
        display: flex;
        flex-direction: column;
        justify-content: center;
        line-height: 1.4;
        padding: 0 10px;
        width: calc(100% - 70px);
    }

    .info-box-text-custom {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 0.875rem;
        color: #6c757d;
    }

    .info-box-number-custom {
        display: block;
        font-weight: 600;
        font-size: 1.125rem;
        color: #343a40;
    }

    .form-control-custom {
        border-radius: 0.375rem;
        border: 1px solid #ced4da;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control-custom:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
    }

    .btn-submit {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        border: none;
        font-weight: 600;
        letter-spacing: 0.5px;
        padding: 10px 25px;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #27ae60, #219653);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        position: relative;
        padding-left: 15px;
        margin-bottom: 20px;
    }

    .section-title:before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: linear-gradient(to bottom, #3498db, #2c3e50);
        border-radius: 4px;
    }

    .client-detail-item {
        margin-bottom: 8px;
        padding-bottom: 8px;
        border-bottom: 1px dashed #eee;
    }

    .client-detail-label {
        font-weight: 600;
        color: #7f8c8d;
        font-size: 0.85rem;
    }

    .client-detail-value {
        color: #2c3e50;
        font-size: 0.95rem;
    }
</style>
@endsection

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('prestamos.store') }}" method="POST" id="prestamoForm">
                        @csrf

                        {{-- === SECCIÓN DATOS DEL CLIENTE === --}}
                        @if($cliente)
                        <div class="mb-4">
                            <h4 class="section-title">Información del Cliente</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="info-box-custom">
                                        <span class="info-box-icon-custom bg-info"><i class="fas fa-user"></i></span>
                                        <div class="info-box-content-custom">
                                            <span class="info-box-text-custom">Nombre Completo</span>
                                            <span class="info-box-number-custom">{{ $cliente->nombre_completo }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box-custom">
                                        <span class="info-box-icon-custom bg-warning"><i class="fas fa-id-card"></i></span>
                                        <div class="info-box-content-custom">
                                            <span class="info-box-text-custom">Documento de Identidad</span>
                                            <span class="info-box-number-custom">{{ $cliente->ci }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box-custom">
                                        <span class="info-box-icon-custom bg-success"><i class="fas fa-phone"></i></span>
                                        <div class="info-box-content-custom">
                                            <span class="info-box-text-custom">Teléfono</span>
                                            <span class="info-box-number-custom">{{ $cliente->telefono }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-none">
                                        <div class="card-body p-0">
                                            <div class="client-detail-item">
                                                <div class="client-detail-label">Nacionalidad</div>
                                                <div class="client-detail-value">{{ $cliente->nacionalidad }}</div>
                                            </div>
                                            <div class="client-detail-item">
                                                <div class="client-detail-label">Fecha de Nacimiento</div>
                                                <div class="client-detail-value">{{ $cliente->fecha_nacimiento }}</div>
                                            </div>
                                            <div class="client-detail-item">
                                                <div class="client-detail-label">Ocupación</div>
                                                <div class="client-detail-value">{{ $cliente->ocupacion }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-none">
                                        <div class="card-body p-0">
                                            <div class="client-detail-item">
                                                <div class="client-detail-label">Dirección</div>
                                                <div class="client-detail-value">{{ $cliente->direccion }}</div>
                                            </div>
                                            <div class="client-detail-item">
                                                <div class="client-detail-label">Email</div>
                                                <div class="client-detail-value">{{ $cliente->email }}</div>
                                            </div>
                                            <div class="client-detail-item">
                                                <div class="client-detail-label">Estado Civil</div>
                                                <div class="client-detail-value">{{ $cliente->estado_civil }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id_cliente" value="{{ $cliente->id }}">
                        @endif

                        {{-- === SECCIÓN DATOS DE LA SOLICITUD === --}}
                        @if(($solicitud))
                        <div class="mb-4">
                            <h4 class="section-title">Detalles de la Solicitud</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card border-left-primary shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Monto Solicitado</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($solicitud->monto_solicitado, 2) }} Bs.</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-left-info shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                        Fecha de Solicitud</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $solicitud->created_at->format('d/m/Y') }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-left-warning shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                        Motivo</div>
                                                    <div class="h6 mb-0 text-gray-800">{{ $solicitud->destino_prestamo }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-comment-alt fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id_solicitud" value="{{ $solicitud->id }}">
                        @endif
                        {{-- === SECCIÓN DOCUMENTOS ADJUNTOS === --}}
                        @php
                        // Mapeo para mostrar nombre bonito según tu ID (ajústalo si cambia)
                        $tiposDoc = [
                        1 => 'Documento de Identidad',
                        2 => 'Comprobante de Ingresos',
                        3 => 'Comprobante de Domicilio',
                        4 => 'Otros Documentos'
                        ];
                        @endphp

                        @if($solicitud && $solicitud->detallesDocumentos && count($solicitud->detallesDocumentos))
                        <div class="mb-4">
                            <h4 class="section-title">Documentos Adjuntos</h4>
                            <div class="row">
                                @foreach($solicitud->detallesDocumentos as $doc)
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="card shadow-sm border-0 text-center h-100" style="min-height:140px;">
                                        <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                                            <div class="mb-2">
                                                @php
                                                $ext = strtolower(pathinfo($doc->ruta, PATHINFO_EXTENSION));
                                                @endphp
                                                @if(in_array($ext, ['jpg','jpeg','png']))
                                                <a href="{{ asset('storage/' . $doc->ruta) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $doc->ruta) }}" alt="{{ $tiposDoc[$doc->id_documento] ?? 'Documento' }}"
                                                        style="width:48px; height:48px; object-fit:cover; border-radius:8px; border:1px solid #ddd;">
                                                </a>
                                                @elseif($ext == 'pdf')
                                                <a href="{{ asset('storage/' . $doc->ruta) }}" target="_blank">
                                                    <i class="far fa-file-pdf fa-3x text-danger"></i>
                                                </a>
                                                @else
                                                <a href="{{ asset('storage/' . $doc->ruta) }}" target="_blank">
                                                    <i class="far fa-file-alt fa-3x text-secondary"></i>
                                                </a>
                                                @endif
                                            </div>
                                            <div style="font-size:0.95rem; font-weight:500;" class="text-dark mb-1">
                                                {{ $tiposDoc[$doc->id_documento] ?? 'Documento' }}
                                            </div>
                                            @if($doc->id_documento == 4)
                                            <div style="font-size:0.80rem;">{{ basename($doc->ruta) }}</div>
                                            @endif
                                            <div>
                                                <a href="{{ asset('storage/' . $doc->ruta) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <h4 class="section-title">Firma del Solicitante</h4>
                            <div class="row mb-3">
                                <div class="col-md-3 col-6">
                                    <div class="card shadow-sm border-0 text-center h-100" style="min-height:140px;">
                                        <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                                            @if($solicitud->firma_digital)
                                            <a href="{{ asset('storage/' . $solicitud->firma_digital) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $solicitud->firma_digital) }}"
                                                    alt="Firma"
                                                    style="width:100%; max-height:120px; object-fit:contain; border-radius:8px; border:1px solid #ddd;">
                                            </a>
                                            @else
                                            <span class="text-muted">Sin firma registrada</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        {{-- === SECCIÓN CAMPOS DEL PRÉSTAMO A REGISTRAR === --}}
                        <div class="mb-4">
                            <h4 class="section-title">Detalles del Préstamo</h4>
                            <input type="hidden" name="id_prestamista" value="{{ auth()->id() }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Monto Solicitado (Bs.)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                            </div>
                                            <input type="number" name="monto_aprobado" step="0.01" class="form-control form-control-custom" required
                                                value="{{ isset($solicitud) ? $solicitud->monto_solicitado : old('monto_aprobado') }}" id="montoAprobado">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">Tasa de Interés (%)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                            </div>
                                            <input type="number" name="interes" step="0.01" class="form-control form-control-custom"
                                                required id="tasaInteres"
                                                value="{{ isset($solicitud) && $solicitud->tipoPlazo && $solicitud->tipoPlazo->interesActivo 
                                                ? $solicitud->tipoPlazo->interesActivo->tasa_interes 
                                                : old('interes') }}"
                                                readonly>
                                            <input type="hidden" name="id_interes" id="idInteresHidden" value="{{ $interes->id ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">Plazo</label>
                                        <div class="input-group">
                                            <input type="number" name="plazo" class="form-control form-control-custom" required id="plazo"
                                                value="{{ isset($solicitud) ? $solicitud->cantidad_plazo : old('plazo') }}">
                                            <div class="input-group-append">
                                                <select name="id_tipo_plazo" class="form-control form-control-custom" required id="tipoPlazo">
                                                    @foreach ($tiposPlazo as $tipo)
                                                    <option value="{{ $tipo->id }}"
                                                        data-nombre="{{ $tipo->nombre }}"
                                                        data-tasa="{{ $tipo->interesActivo->tasa_interes ?? 0 }}"
                                                        data-id-interes="{{ $tipo->interesActivo->id ?? '' }}"
                                                        {{ (old('id_tipo_plazo') ?? ($solicitud->id_tipo_plazo ?? '')) == $tipo->id ? 'selected' : '' }}>
                                                        {{ ucfirst($tipo->nombre) }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Fecha de Inicio</label>
                                        <div class="input-group date" id="fechaInicio" data-target-input="nearest">
                                            <input type="text" name="fecha_inicio" class="form-control form-control-custom datetimepicker-input"
                                                data-target="#fechaInicio" required id="fechaInicioInput"
                                                value="{{ isset($solicitud) ? $solicitud->created_at->format('d/m/Y') : old('fecha_inicio') }}" />
                                            <div class="input-group-append" data-target="#fechaInicio" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">Fecha de Vencimiento</label>
                                        <div class="input-group date" id="fechaVencimiento" data-target-input="nearest">
                                            <input type="text" name="fecha_vencimiento" class="form-control form-control-custom datetimepicker-input"
                                                data-target="#fechaVencimiento" required id="fechaVencimientoInput" readonly>
                                            <div class="input-group-append" data-target="#fechaVencimiento" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">Comentarios Adicionales</label>
                                        <textarea name="comentario" class="form-control form-control-custom" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="card border-left-success shadow-sm">
                                        <div class="card-body">
                                            <h5 class="font-weight-bold text-success"><i class="fas fa-calculator mr-2"></i>Resumen del Préstamo</h5>
                                            <div class="row text-center">
                                                <div class="col-md-4">
                                                    <div class="font-weight-bold text-gray-800">Monto Total a Pagar</div>
                                                    <div class="h4 text-primary" name="monto_total_pagar" id="montoTotal">0.00 Bs.</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="font-weight-bold text-gray-800">Interés Total</div>
                                                    <div class="h4 text-info" name="interes_total" id="interesTotal">0.00 Bs.</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="font-weight-bold text-gray-800">Cuota Estimada</div>
                                                    <div class="h5 text-success" id="cuotaCapitalDetalle">capital = 0.00 Bs.</div>
                                                    <div class="h5 text-info" id="cuotaInteresDetalle">interés = 0.00 Bs.</div>
                                                    <div class="h4 text-primary" name="cuota_estimada" id="cuotaTotalDetalle">total = 0.00 Bs./mensual</div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="monto_total_pagar" id="montoTotalInput" value="0">
                                            <input type="hidden" name="interes_total" id="interesTotalInput" value="0">
                                            <input type="hidden" name="cuota_estimada" id="cuotaEstimadaInput" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-light mr-2">
                                <i class="fas fa-arrow-left mr-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-submit">
                                <i class="fas fa-save mr-2"></i>Registrar Préstamo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.es.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    $(document).ready(function() {
        // Inicializar datepickers en los inputs
        $('#fechaInicioInput').datepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date()
        });

        $('#fechaVencimientoInput').datepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            autoclose: true
        });

        // Al cambiar fecha inicio, plazo o tipo plazo, recalcular vencimiento y resumen
        $('#plazo, #tipoPlazo, #fechaInicioInput').on('change keyup', function() {
            calcularVencimiento();
            calcularResumen();
        });

        // Recalcular resumen cuando cambian monto o tasa
        $('#montoAprobado, #tasaInteres').on('keyup change', function() {
            calcularResumen();
        });

        // Actualizar tasa al cambiar tipo plazo
        // Al cambiar tipo plazo
        $('#tipoPlazo').on('change', function() {
            const opcionSeleccionada = $(this).find('option:selected');
            const idInteres = opcionSeleccionada.data('id-interes') || '';
            const tasa = opcionSeleccionada.data('tasa') || 0;
            const nombreTipo = opcionSeleccionada.data('nombre') || '';

            $('#idInteresHidden').val(idInteres);
            $('#tasaInteres').val(tasa.toFixed(2));

            calcularResumen();
        });


        // Inicializa tasa al cargar
        const tasaInicial = $('#tipoPlazo').find('option:selected').data('tasa') || 0;
        $('#tasaInteres').val(tasaInicial.toFixed(2));

        // Calcular resumen y vencimiento inicial
        calcularVencimiento();
        calcularResumen();

        // Función calcular fecha vencimiento
        function calcularVencimiento() {
            const plazo = parseInt($('#plazo').val()) || 0;
            const tipoPlazo = ($('#tipoPlazo option:selected').data('nombre') || '').toLowerCase();
            const fechaInicio = $('#fechaInicioInput').val();

            if (!fechaInicio || plazo <= 0) {
                $('#fechaVencimientoInput').val('');
                return;
            }

            const partes = fechaInicio.split('/');
            if (partes.length !== 3) {
                $('#fechaVencimientoInput').val('');
                return;
            }

            const startDate = new Date(partes[2], partes[1] - 1, partes[0]);
            let endDate = new Date(startDate);

            switch (tipoPlazo) {
                case 'diario':
                    endDate.setDate(endDate.getDate() + plazo);
                    break;
                case 'semanal':
                    endDate.setDate(endDate.getDate() + plazo * 7);
                    break;
                case 'quincenal':
                    endDate.setDate(endDate.getDate() + plazo * 15);
                    break;
                case 'mensual':
                    endDate.setMonth(endDate.getMonth() + plazo);
                    break;
                case 'anual':
                    endDate.setFullYear(endDate.getFullYear() + plazo);
                    break;
                default:
                    // Por defecto mensual
                    endDate.setMonth(endDate.getMonth() + plazo);
            }

            const dd = String(endDate.getDate()).padStart(2, '0');
            const mm = String(endDate.getMonth() + 1).padStart(2, '0');
            const yyyy = endDate.getFullYear();

            $('#fechaVencimientoInput').val(`${dd}/${mm}/${yyyy}`);
        }

        // Función para convertir fecha a formato MySQL antes de enviar formulario
        $('form').on('submit', function() {
            const fechaInicio = $('#fechaInicioInput').val();
            const fechaVencimiento = $('#fechaVencimientoInput').val();

            $('#fechaInicioInput').val(convertirFechaAFormatoMySQL(fechaInicio));
            $('#fechaVencimientoInput').val(convertirFechaAFormatoMySQL(fechaVencimiento));
        });

        function convertirFechaAFormatoMySQL(fecha) {
            const partes = fecha.split('/');
            if (partes.length !== 3) return fecha;
            return `${partes[2]}-${partes[1]}-${partes[0]}`;
        }

        // Antes de enviar el formulario, convertir fechas a formato MySQL
        $('form').on('submit', function() {
            let fechaInicio = $('#fechaInicioInput').val();
            let fechaVencimiento = $('#fechaVencimientoInput').val();

            $('#fechaInicioInput').val(convertirFechaAFormatoMySQL(fechaInicio));
            $('#fechaVencimientoInput').val(convertirFechaAFormatoMySQL(fechaVencimiento));
        });

        $(document).ready(function() {
            // Inicializa con el valor correcto la tasa (por si viene seleccionado)
            const opcionSeleccionada = $('#tipoPlazo').find('option:selected');
            const tasaInicial = opcionSeleccionada.data('tasa') || 0;
            const idInteresInicial = opcionSeleccionada.data('id-interes') || '';

            $('#tasaInteres').val(tasaInicial.toFixed(2));
            $('#idInteresHidden').val(idInteresInicial);

            // Recalcular resumen al cargar la página
            calcularResumen();

            // El resto de eventos para recalcular...
        });

        function calcularResumen() {
            const monto = parseFloat($('#montoAprobado').val()) || 0;
            const tasaInteresMensual = parseFloat($('#tasaInteres').val()) || 0;
            const plazo = parseInt($('#plazo').val()) || 1;
            const tipoPlazo = ($('#tipoPlazo option:selected').data('nombre') || '').toLowerCase();

            let mesesEquivalentes = 0;
            switch (tipoPlazo) {
                case 'diario':
                    mesesEquivalentes = plazo / 30;
                    break;
                case 'semanal':
                    mesesEquivalentes = plazo / 4.3;
                    break;
                case 'quincenal':
                    mesesEquivalentes = plazo / 2;
                    break;
                case 'mensual':
                    mesesEquivalentes = plazo;
                    break;
                case 'anual':
                    mesesEquivalentes = plazo * 12;
                    break;
                default:
                    mesesEquivalentes = plazo;
            }
            if (mesesEquivalentes === 0) mesesEquivalentes = 1;

            const capitalMensual = monto / mesesEquivalentes;
            const interesMensual = monto * (tasaInteresMensual / 100);
            const cuotaMensual = capitalMensual + interesMensual;

            let cuotaCapital = 0,
                cuotaInteres = 0,
                cuotaTotal = 0;

            switch (tipoPlazo) {
                case 'diario':
                    cuotaCapital = capitalMensual / 30;
                    cuotaInteres = interesMensual / 30;
                    cuotaTotal = cuotaCapital + cuotaInteres;
                    break;
                case 'semanal':
                    cuotaCapital = capitalMensual / 4.3;
                    cuotaInteres = interesMensual / 4.3;
                    cuotaTotal = cuotaCapital + cuotaInteres;
                    break;
                case 'quincenal':
                    cuotaCapital = capitalMensual / 2;
                    cuotaInteres = interesMensual / 2;
                    cuotaTotal = cuotaCapital + cuotaInteres;
                    break;
                case 'mensual':
                    cuotaCapital = capitalMensual;
                    cuotaInteres = interesMensual;
                    cuotaTotal = cuotaCapital + cuotaInteres;
                    break;
                case 'anual':
                    cuotaCapital = capitalMensual * 12;
                    cuotaInteres = interesMensual * 12;
                    cuotaTotal = cuotaCapital + cuotaInteres;
                    break;
                default:
                    cuotaCapital = capitalMensual;
                    cuotaInteres = interesMensual;
                    cuotaTotal = cuotaCapital + cuotaInteres;
            }

            const totalPagar = cuotaTotal * plazo;
            const interesTotal = interesMensual * mesesEquivalentes;

            $('#interesTotal').text(interesTotal.toFixed(2) + ' Bs.');
            $('#montoTotal').text(totalPagar.toFixed(2) + ' Bs.');
            $('#cuotaCapital').text(cuotaCapital.toFixed(2) + ' Bs./' + tipoPlazo);
            $('#cuotaInteres').text(cuotaInteres.toFixed(2) + ' Bs./' + tipoPlazo);
            $('#cuotaEstimada').text(cuotaTotal.toFixed(2) + ' Bs./' + tipoPlazo);
            // Capital cuota estimada
            $('#cuotaCapitalDetalle').text('capital = ' + cuotaCapital.toFixed(2) + ' Bs.');
            // Interés cuota estimada
            $('#cuotaInteresDetalle').text('interés = ' + cuotaInteres.toFixed(2) + ' Bs.');
            // Cuota total estimada
            $('#cuotaTotalDetalle').text('total = ' + cuotaTotal.toFixed(2) + ' Bs./' + tipoPlazo);

            $('#montoTotalInput').val(totalPagar.toFixed(2));
            $('#interesTotalInput').val(interesTotal.toFixed(2));
            $('#cuotaEstimadaInput').val(cuotaTotal.toFixed(2));
        }

        // Formatear inputs numéricos
        $('[name="monto_aprobado"], [name="interes"]').on('blur', function() {
            if (this.value) {
                this.value = parseFloat(this.value).toFixed(2);
            }
        });

        // Validación del formulario
        $('#prestamoForm').on('submit', function(e) {
            let isValid = true;

            // Validar campos requeridos
            $('[required]').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Campos requeridos',
                    text: 'Por favor complete todos los campos obligatorios',
                });
            }
        });
    });
</script>
@endsection