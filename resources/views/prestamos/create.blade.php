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
            border-bottom: 2px solid rgba(0,0,0,.1);
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .info-box-custom {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
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
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
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
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
                                                    <div class="h6 mb-0 text-gray-800">{{ $solicitud->comentario }}</div>
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

                        {{-- === SECCIÓN CAMPOS DEL PRÉSTAMO A REGISTRAR === --}}
                        <div class="mb-4">
                            <h4 class="section-title">Detalles del Préstamo</h4>
                            <input type="hidden" name="id_prestamista" value="{{ auth()->id() }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Monto Aprobado (Bs.)</label>
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
                                            <input type="number" name="interes" step="0.01" class="form-control form-control-custom" required id="tasaInteres">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">Plazo</label>
                                        <div class="input-group">
                                            <input type="number" name="plazo" class="form-control form-control-custom" required id="plazo">
                                            <div class="input-group-append">
                                                <select name="tipo_plazo" class="form-control form-control-custom" required id="tipoPlazo">
                                                    <option value="diario">Días</option>
                                                    <option value="semanal">Semanas</option>
                                                    <option value="mensual">Meses</option>
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
                                                data-target="#fechaInicio" required id="fechaInicioInput"/>
                                            <div class="input-group-append" data-target="#fechaInicio" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">Fecha de Vencimiento</label>
                                        <div class="input-group date" id="fechaVencimiento" data-target-input="nearest">
                                            <input type="text" name="fecha_vencimiento" class="form-control form-control-custom datetimepicker-input" 
                                                data-target="#fechaVencimiento" required id="fechaVencimientoInput" readonly/>
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
                                                    <div class="h4 text-primary" id="montoTotal">0.00 Bs.</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="font-weight-bold text-gray-800">Interés Total</div>
                                                    <div class="h4 text-info" id="interesTotal">0.00 Bs.</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="font-weight-bold text-gray-800">Cuota Estimada</div>
                                                    <div class="h4 text-success" id="cuotaEstimada">0.00 Bs.</div>
                                                </div>
                                            </div>
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
        // Inicializar datepicker
        $('#fechaInicio').datepicker({
            format: 'yyyy-mm-dd',
            language: 'es',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date()
        });

        $('#fechaVencimiento').datepicker({
            format: 'yyyy-mm-dd',
            language: 'es',
            autoclose: true
        });

        // Calcular fecha de vencimiento cuando cambia plazo o fecha de inicio
        $('#plazo, #tipoPlazo, #fechaInicioInput').on('change keyup', function() {
            calcularVencimiento();
            calcularResumen();
        });

        // Calcular resumen cuando cambian montos o intereses
        $('#montoAprobado, #tasaInteres').on('keyup change', function() {
            calcularResumen();
        });

        // Función para calcular fecha de vencimiento
        function calcularVencimiento() {
            const plazo = parseInt($('#plazo').val()) || 0;
            const tipoPlazo = $('#tipoPlazo').val();
            const fechaInicio = $('#fechaInicioInput').val();
            
            if (fechaInicio && plazo > 0) {
                const dateParts = fechaInicio.split('/');
                const startDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
                
                let endDate = new Date(startDate);
                
                switch(tipoPlazo) {
                    case 'diario':
                        endDate.setDate(startDate.getDate() + plazo);
                        break;
                    case 'semanal':
                        endDate.setDate(startDate.getDate() + (plazo * 7));
                        break;
                    case 'mensual':
                        endDate.setMonth(startDate.getMonth() + plazo);
                        break;
                }
                
                const dd = String(endDate.getDate()).padStart(2, '0');
                const mm = String(endDate.getMonth() + 1).padStart(2, '0');
                const yyyy = endDate.getFullYear();
                
                $('#fechaVencimientoInput').val(`${dd}/${mm}/${yyyy}`);
            }
        }

        // Función para calcular resumen del préstamo
        function calcularResumen() {
            const monto = parseFloat($('#montoAprobado').val()) || 0;
            const interes = parseFloat($('#tasaInteres').val()) || 0;
            const plazo = parseInt($('#plazo').val()) || 0;
            
            if (monto > 0 && interes > 0 && plazo > 0) {
                const interesDecimal = interes / 100;
                const interesTotal = monto * interesDecimal;
                const montoTotal = monto + interesTotal;
                const cuotaEstimada = montoTotal / plazo;
                
                $('#interesTotal').text(interesTotal.toFixed(2) + ' Bs.');
                $('#montoTotal').text(montoTotal.toFixed(2) + ' Bs.');
                $('#cuotaEstimada').text(cuotaEstimada.toFixed(2) + ' Bs.');
            } else {
                $('#interesTotal').text('0.00 Bs.');
                $('#montoTotal').text('0.00 Bs.');
                $('#cuotaEstimada').text('0.00 Bs.');
            }
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