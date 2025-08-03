@extends('adminlte::page')

@section('title', 'Solicitud de Préstamo')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">
            <i class="fas fa-file-invoice-dollar mr-2"></i>
            Solicitud de Préstamo
        </h1>
        <div class="badge badge-primary p-2">
            <i class="fas fa-lock mr-1"></i>
            Conexión segura
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <style>
        /* Estilos base */
        .loan-header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            border-radius: 8px 8px 0 0;
            padding: 15px;
        }
        
        /* Pasos del proceso - Responsive */
        .loan-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            position: relative;
            flex-wrap: wrap;
        }
        .loan-steps:before {
            content: "";
            position: absolute;
            top: 20px;
            left: 10%;
            right: 10%;
            height: 2px;
            background: #e0e0e0;
            z-index: 1;
        }
        .step {
            text-align: center;
            position: relative;
            z-index: 2;
            flex: 1;
            min-width: 70px;
            margin-bottom: 15px;
        }
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e0e0e0;
            color: #757575;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 5px;
            font-weight: bold;
            font-size: 0.9rem;
        }
        .step.active .step-number {
            background: #3498db;
            color: white;
        }
        .step.completed .step-number {
            background: #2ecc71;
            color: white;
        }
        .step-label {
            font-size: 0.75rem;
            color: #757575;
            font-weight: 500;
            display: block;
        }
        .step.active .step-label {
            color: #3498db;
            font-weight: 600;
        }
        .step.completed .step-label {
            color: #2ecc71;
        }
        
        /* Secciones del formulario */
        .form-section {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .section-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            font-size: 1rem;
        }
        .section-title i {
            margin-right: 8px;
            color: #3498db;
            font-size: 1rem;
        }
        
        /* Formularios */
        .form-label {
            font-weight: 500;
            color: #5a5a5a;
            margin-bottom: 5px;
            font-size: 0.85rem;
        }
        .form-control-bank {
            border: 1px solid #d0d0d0;
            border-radius: 4px;
            padding: 8px 12px;
            transition: all 0.3s;
            font-size: 0.9rem;
            height: auto;
        }
        .form-control-bank:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        /* Selector de montos - Responsive */
        .amount-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 15px;
        }
        .amount-option {
            flex: 1 0 calc(50% - 8px);
            min-width: 0;
        }
        .amount-option label {
            display: block;
            padding: 10px 5px;
            text-align: center;
            border: 1px solid #d0d0d0;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
            font-size: 0.8rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Selector de plazo - Responsive */
        .form-range {
            width: 100%;
            padding: 0;
        }
        
        /* Botones */
        .btn-bank-primary {
            background: linear-gradient(135deg, #3498db, #2c3e50);
            border: none;
            padding: 10px 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: white;
            border-radius: 4px;
            transition: all 0.3s;
            font-size: 0.9rem;
            width: 100%;
            margin-bottom: 10px;
        }
        .btn-bank-secondary {
            background: white;
            border: 1px solid #d0d0d0;
            padding: 10px 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: #5a5a5a;
            border-radius: 4px;
            transition: all 0.3s;
            font-size: 0.9rem;
            width: 100%;
            margin-bottom: 10px;
        }
        
        /* Tarjetas de resumen */
        .summary-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            background: #f9f9f9;
            margin-bottom: 15px;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px dashed #e0e0e0;
            font-size: 0.85rem;
        }
        
        /* Subida de archivos */
        .custom-file-upload {
            border: 1px dashed #d0d0d0;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .file-name {
            margin-top: 5px;
            font-size: 0.75rem;
            color: #3498db;
            word-break: break-all;
        }
        
        /* Firma electrónica */
        #signaturePad {
            width: 100%;
            height: 80px;
        }
        
        /* Alertas */
        .alert {
            font-size: 0.85rem;
            padding: 10px 15px;
        }
        
        /* Ajustes para móviles pequeños */
        @media (max-width: 576px) {
            .loan-header {
                padding: 10px;
            }
            .loan-steps:before {
                left: 15%;
                right: 15%;
            }
            .step {
                min-width: 60px;
            }
            .step-number {
                width: 30px;
                height: 30px;
                font-size: 0.8rem;
            }
            .section-title {
                font-size: 0.95rem;
            }
            .form-section {
                padding: 10px;
            }
            .amount-option {
                flex: 1 0 calc(100% - 8px);
            }
        }
        
        /* Ajustes para tablets */
        @media (min-width: 576px) and (max-width: 992px) {
            .amount-option {
                flex: 1 0 calc(33% - 8px);
            }
            .btn-bank-primary, .btn-bank-secondary {
                width: auto;
                display: inline-block;
                margin-right: 10px;
                margin-bottom: 0;
            }
        }
        
        /* Ajustes para desktop */
        @media (min-width: 992px) {
            .loan-header {
                padding: 20px;
            }
            .form-section {
                padding: 25px;
            }
            .amount-option {
                flex: 1 0 calc(25% - 10px);
                min-width: 100px;
            }
            .amount-option label {
                padding: 15px 10px;
                font-size: 0.9rem;
            }
            .btn-bank-primary, .btn-bank-secondary {
                width: auto;
                padding: 12px 30px;
            }
            .section-title {
                font-size: 1.1rem;
            }
        }
        
        /* Ajustes específicos para la firma en móviles */
        @media (max-width: 768px) {
            #signaturePad {
                height: 60px;
            }
        }
        .loan-header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            border-radius: 8px 8px 0 0;
            padding: 20px;
        }
        .loan-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }
        .loan-steps:before {
            content: "";
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 2px;
            background: #e0e0e0;
            z-index: 1;
        }
        .step {
            text-align: center;
            position: relative;
            z-index: 2;
        }
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e0e0e0;
            color: #757575;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: bold;
        }
        .step.active .step-number {
            background: #3498db;
            color: white;
        }
        .step.completed .step-number {
            background: #2ecc71;
            color: white;
        }
        .step-label {
            font-size: 0.85rem;
            color: #757575;
            font-weight: 500;
        }
        .step.active .step-label {
            color: #3498db;
            font-weight: 600;
        }
        .step.completed .step-label {
            color: #2ecc71;
        }
        .form-section {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .section-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
        }
        .section-title i {
            margin-right: 10px;
            color: #3498db;
        }
        .form-label {
            font-weight: 500;
            color: #5a5a5a;
            margin-bottom: 8px;
        }
        .form-control-bank {
            border: 1px solid #d0d0d0;
            border-radius: 4px;
            padding: 10px 15px;
            transition: all 0.3s;
        }
        .form-control-bank:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        .amount-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .amount-option {
            flex: 1 0 calc(25% - 10px);
            min-width: 100px;
        }
        .amount-option input {
            display: none;
        }
        .amount-option label {
            display: block;
            padding: 15px 10px;
            text-align: center;
            border: 1px solid #d0d0d0;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }
        .amount-option input:checked + label {
            border-color: #3498db;
            background-color: #f0f8ff;
            color: #3498db;
            font-weight: 600;
        }
        .btn-bank-primary {
            background: linear-gradient(135deg, #3498db, #2c3e50);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: white;
            border-radius: 4px;
            transition: all 0.3s;
        }
        .btn-bank-primary:hover {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .btn-bank-secondary {
            background: white;
            border: 1px solid #d0d0d0;
            padding: 12px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: #5a5a5a;
            border-radius: 4px;
            transition: all 0.3s;
        }
        .btn-bank-secondary:hover {
            background: #f8f8f8;
            border-color: #b0b0b0;
        }
        .summary-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            background: #f9f9f9;
            margin-bottom: 20px;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #e0e0e0;
        }
        .summary-label {
            color: #7f8c8d;
            font-weight: 500;
        }
        .summary-value {
            font-weight: 600;
            color: #2c3e50;
        }
        .summary-total {
            font-size: 1.1rem;
            color: #27ae60;
            font-weight: 700;
        }
        .tooltip-icon {
            color: #3498db;
            margin-left: 5px;
            cursor: pointer;
        }
        .custom-file-upload {
            border: 1px dashed #d0d0d0;
            border-radius: 4px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .custom-file-upload:hover {
            border-color: #3498db;
            background: #f8faff;
        }
        .file-name {
            margin-top: 10px;
            font-size: 0.85rem;
            color: #3498db;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="loan-header mb-4">
                <h3 class="font-weight-bold mb-2">Complete su solicitud de préstamo</h3>
                <p class="mb-0">Por favor complete todos los campos requeridos para evaluar su solicitud</p>
            </div>

            <div class="loan-steps">
                <div class="step active">
                    <div class="step-number">1</div>
                    <div class="step-label">Datos del Préstamo</div>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-label">Información Personal</div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-label">Documentación</div>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-label">Confirmación</div>
                </div>
            </div>

            <form id="loanApplicationForm" method="POST" action="{{ route('solicitudes.store') }}" enctype="multipart/form-data">
                @csrf
            
                <!-- Paso 1: Datos del Préstamo -->
                <div class="form-section" id="step1">
                    <h4 class="section-title">
                        <i class="fas fa-hand-holding-usd"></i>
                        Datos del Préstamo
                    </h4>
            
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Monto Solicitado (Bs.)</label>
                                <input type="number" class="form-control" name="monto_solicitado" 
                                    min="100" step="10" required>
                            </div>
                        </div>
            
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Comentario</label>
                                <textarea class="form-control" name="comentario" rows="2" placeholder="Opcional"></textarea>
                            </div>
                        </div>
                    </div>
            
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" onclick="nextStep(1, 2)">
                            Siguiente <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            
                <!-- Paso 2: Confirmación -->
                <div class="form-section" id="step2" style="display: none;">
                    <h4 class="section-title">
                        <i class="fas fa-user-check"></i>
                        Confirmación de Datos del Cliente
                    </h4>
            
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre Completo</label>
                                <input type="text" class="form-control" value="{{ $cliente->nombre_completo }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>CI</label>
                                <input type="text" class="form-control" value="{{ $cliente->ci }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text" class="form-control" value="{{ $cliente->telefono }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Correo</label>
                                <input type="text" class="form-control" value="{{ $cliente->email }}" disabled>
                            </div>
                        </div>
            
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ocupación</label>
                                <input type="text" class="form-control" value="{{ $cliente->ocupacion }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Estado Civil</label>
                                <input type="text" class="form-control" value="{{ $cliente->estado_civil }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Dirección</label>
                                <input type="text" class="form-control" value="{{ $cliente->direccion }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Nacionalidad</label>
                                <input type="text" class="form-control" value="{{ $cliente->nacionalidad }}" disabled>
                            </div>
                        </div>
                    </div>
            
                    <div class="text-right">
                        <button type="button" class="btn btn-secondary mr-2" onclick="prevStep(2, 1)">
                            <i class="fas fa-arrow-left mr-2"></i> Anterior
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-paper-plane mr-2"></i> Enviar Solicitud
                        </button>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>

<!-- Modal Términos y Condiciones -->
<div class="modal fade" id="terminosModal" tabindex="-1" role="dialog" aria-labelledby="terminosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="terminosModalLabel">Términos y Condiciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Contenido de términos y condiciones -->
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget ultricies nisl nisl eget nisl.</p>
                <p>Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget ultricies nisl nisl eget nisl.</p>
                <!-- Agregar más contenido según sea necesario -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-bank-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Política de Privacidad -->
<div class="modal fade" id="privacidadModal" tabindex="-1" role="dialog" aria-labelledby="privacidadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="privacidadModalLabel">Política de Privacidad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Contenido de política de privacidad -->
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget ultricies nisl nisl eget nisl.</p>
                <p>Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget ultricies nisl nisl eget nisl.</p>
                <!-- Agregar más contenido según sea necesario -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-bank-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.es.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script>
    $(document).ready(function() {
        // Inicializar datepicker
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            autoclose: true,
            endDate: '0d'
        });

        // Actualizar resumen cuando cambian los valores
        $('#montoSolicitado, #plazoValue, [name="tipo_plazo"]').on('change keyup', function() {
            actualizarResumen();
        });

        // Inicializar el resumen
        actualizarResumen();

        // Manejar la subida de archivos
        $('#documentoIdentidad').change(function() {
            $('#documentoIdentidadName').text(this.files[0] ? this.files[0].name : 'No se ha seleccionado archivo');
        });
        // ... (otros manejadores de archivos)

        // Inicializar el pad de firma
        var canvas = document.getElementById('signaturePad');
        if(canvas) {
            var signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(0, 0, 0)'
            });

            $('#clearSignature').click(function() {
                signaturePad.clear();
            });

            // Ajustar canvas en redimensionamiento
            function resizeCanvas() {
                var ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear(); // Limpiar en resize
            }
            
            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();
        }

        // Guardar la firma cuando se envíe el formulario
        $('#loanApplicationForm').submit(function() {
            if(signaturePad && signaturePad.isEmpty()) {
                Swal.fire({
                    icon: 'error',
                    title: 'Firma requerida',
                    text: 'Por favor proporcione su firma electrónica'
                });
                return false;
            } else if(signaturePad) {
                $('#firmaElectronica').val(signaturePad.toDataURL());
            }
        });
    });

    // Función para actualizar el resumen del préstamo
    function actualizarResumen() {
        const monto = parseFloat($('#montoSolicitado').val()) || 0;
        const plazo = $('#plazoValue').val();
        const tipoPlazo = $('[name="tipo_plazo"]').val();
        
        // Calcular interés y cuotas (esto es solo un ejemplo)
        let tasaInteres = 12.5; // Tasa de interés anual base
        if (monto > 50000) tasaInteres = 10.5;
        if (monto > 80000) tasaInteres = 9.0;
        
        const interesMensual = tasaInteres / 12 / 100;
        const cuota = monto * (interesMensual * Math.pow(1 + interesMensual, plazo)) / 
                      (Math.pow(1 + interesMensual, plazo) - 1);
        const totalPagar = cuota * plazo;
        
        // Actualizar la UI
        $('#resumenMonto').text(monto.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' Bs.');
        $('#resumenInteres').text(tasaInteres.toFixed(1) + '% anual');
        $('#resumenPlazo').text(plazo + ' ' + (tipoPlazo === 'mensual' ? 'meses' : tipoPlazo === 'quincenal' ? 'quincenas' : 'semanas'));
        $('#resumenCuota').text(isNaN(cuota) ? '0.00' : cuota.toFixed(2)) + ' Bs./' + (tipoPlazo === 'mensual' ? 'mes' : tipoPlazo === 'quincenal' ? 'quincena' : 'semana');
        $('#resumenTotal').text(isNaN(totalPagar) ? '0.00' : totalPagar.toFixed(2)) + ' Bs.';
    }

    // Función para sincronizar el rango y el valor numérico del plazo
    function updatePlazoValue(value) {
        $('#plazoValue').val(value);
        actualizarResumen();
    }

    function updatePlazoRange(value) {
        $('#plazoRange').val(value);
        actualizarResumen();
    }

    // Funciones para navegar entre pasos
    function nextStep(current, next) {
        // Validar campos requeridos del paso actual
        let isValid = true;
        $(`#step${current} [required]`).each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Campos requeridos',
                text: 'Por favor complete todos los campos obligatorios antes de continuar',
            });
            return;
        }

        // Si es el último paso, actualizar la confirmación
        if (next === 4) {
            updateConfirmation();
        }

        // Cambiar de paso
        $(`#step${current}`).hide();
        $(`#step${next}`).show();
        
        // Actualizar indicador de pasos
        $(`.step`).removeClass('active completed');
        $(`.step`).each(function(index) {
            if (index + 1 < next) {
                $(this).addClass('completed');
            } else if (index + 1 === next) {
                $(this).addClass('active');
            }
        });
        
        // Actualizar indicador móvil
        $('#current-step-mobile').text(next);
        $('#step-progress').css('width', (next * 25) + '%');
        
        // Desplazar al inicio del formulario en móviles
        if($(window).width() < 768) {
            $('html, body').animate({
                scrollTop: $('.loan-header').offset().top - 20
            }, 300);
        }
    }

    function prevStep(current, prev) {
        $(`#step${current}`).hide();
        $(`#step${prev}`).show();
        
        // Actualizar indicador de pasos
        $(`.step`).removeClass('active completed');
        $(`.step`).each(function(index) {
            if (index + 1 < prev) {
                $(this).addClass('completed');
            } else if (index + 1 === prev) {
                $(this).addClass('active');
            }
        });
        
        // Actualizar indicador móvil
        $('#current-step-mobile').text(prev);
        $('#step-progress').css('width', (prev * 25) + '%');
    }

    // Actualizar la sección de confirmación con los datos ingresados
    function updateConfirmation() {
        $('#confirmTipoPrestamo').text($('[name="tipo_prestamo"] option:selected').text());
        $('#confirmMonto').text($('#montoSolicitado').val() ? parseFloat($('#montoSolicitado').val()).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' Bs.' : '-');
        $('#confirmPlazo').text($('#plazoValue').val() + ' ' + ($('[name="tipo_plazo"] option:selected').val() === 'mensual' ? 'meses' : $('[name="tipo_plazo"] option:selected').val() === 'quincenal' ? 'quincenas' : 'semanas'));
        $('#confirmCuota').text($('#resumenCuota').text());
        $('#confirmNombre').text($('[name="nombres"]').val() + ' ' + $('[name="apellidos"]').val());
        $('#confirmDocumento').text($('[name="tipo_documento"] option:selected').text() + ': ' + $('[name="numero_documento"]').val());
        $('#confirmTelefono').text($('[name="telefono"]').val());
        $('#confirmEmail').text($('[name="email"]').val());
    }
    
    // Manejar redimensionamiento de la pantalla
    $(window).resize(function() {
        // Ajustar elementos específicos si es necesario
    });

    $(document).ready(function() {
        // Inicializar datepicker
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            autoclose: true,
            endDate: '0d'
        });

        // Actualizar resumen cuando cambian los valores
        $('#montoSolicitado, #plazoValue, [name="tipo_plazo"]').on('change keyup', function() {
            actualizarResumen();
        });

        // Inicializar el resumen
        actualizarResumen();

        // Manejar la subida de archivos
        $('#documentoIdentidad').change(function() {
            $('#documentoIdentidadName').text(this.files[0] ? this.files[0].name : 'No se ha seleccionado archivo');
        });
        $('#comprobanteDomicilio').change(function() {
            $('#comprobanteDomicilioName').text(this.files[0] ? this.files[0].name : 'No se ha seleccionado archivo');
        });
        $('#comprobanteIngresos').change(function() {
            $('#comprobanteIngresosName').text(this.files[0] ? this.files[0].name : 'No se ha seleccionado archivo');
        });
        $('#otrosDocumentos').change(function() {
            if (this.files.length > 0) {
                $('#otrosDocumentosName').text(this.files.length + ' archivo(s) seleccionado(s)');
            } else {
                $('#otrosDocumentosName').text('No se ha seleccionado archivo');
            }
        });

        // Inicializar el pad de firma
        var canvas = document.getElementById('signaturePad');
        var signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)',
            penColor: 'rgb(0, 0, 0)'
        });

        $('#clearSignature').click(function() {
            signaturePad.clear();
        });

        // Guardar la firma cuando se envíe el formulario
        $('#loanApplicationForm').submit(function() {
            if (signaturePad.isEmpty()) {
                alert('Por favor proporcione su firma electrónica');
                return false;
            } else {
                $('#firmaElectronica').val(signaturePad.toDataURL());
            }
        });
    });

    // Función para actualizar el resumen del préstamo
    function actualizarResumen() {
        const monto = parseFloat($('#montoSolicitado').val()) || 0;
        const plazo = $('#plazoValue').val();
        const tipoPlazo = $('[name="tipo_plazo"]').val();
        
        // Calcular interés y cuotas (esto es solo un ejemplo)
        let tasaInteres = 12.5; // Tasa de interés anual base
        if (monto > 50000) tasaInteres = 10.5;
        if (monto > 80000) tasaInteres = 9.0;
        
        const interesMensual = tasaInteres / 12 / 100;
        const cuota = monto * (interesMensual * Math.pow(1 + interesMensual, plazo)) / 
                      (Math.pow(1 + interesMensual, plazo) - 1);
        const totalPagar = cuota * plazo;
        
        // Actualizar la UI
        $('#resumenMonto').text(monto.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' Bs.');
        $('#resumenInteres').text(tasaInteres.toFixed(1) + '% anual');
        $('#resumenPlazo').text(plazo + ' ' + (tipoPlazo === 'mensual' ? 'meses' : tipoPlazo === 'quincenal' ? 'quincenas' : 'semanas'));
        $('#resumenCuota').text(isNaN(cuota) ? '0.00' : cuota.toFixed(2)) + ' Bs./' + (tipoPlazo === 'mensual' ? 'mes' : tipoPlazo === 'quincenal' ? 'quincena' : 'semana');
        $('#resumenTotal').text(isNaN(totalPagar) ? '0.00' : totalPagar.toFixed(2)) + ' Bs.';
    }

    // Función para sincronizar el rango y el valor numérico del plazo
    function updatePlazoValue(value) {
        $('#plazoValue').val(value);
        actualizarResumen();
    }

    function updatePlazoRange(value) {
        $('#plazoRange').val(value);
        actualizarResumen();
    }

    // Funciones para navegar entre pasos
    function nextStep(current, next) {
        // Validar campos requeridos del paso actual
        let isValid = true;
        $(`#step${current} [required]`).each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Campos requeridos',
                text: 'Por favor complete todos los campos obligatorios antes de continuar',
            });
            return;
        }

        // Si es el último paso, actualizar la confirmación
        if (next === 4) {
            updateConfirmation();
        }

        // Cambiar de paso
        $(`#step${current}`).hide();
        $(`#step${next}`).show();
        
        // Actualizar indicador de pasos
        $(`.step`).removeClass('active completed');
        $(`.step`).each(function(index) {
            if (index + 1 < next) {
                $(this).addClass('completed');
            } else if (index + 1 === next) {
                $(this).addClass('active');
            }
        });
    }

    function prevStep(current, prev) {
        $(`#step${current}`).hide();
        $(`#step${prev}`).show();
        
        // Actualizar indicador de pasos
        $(`.step`).removeClass('active completed');
        $(`.step`).each(function(index) {
            if (index + 1 < prev) {
                $(this).addClass('completed');
            } else if (index + 1 === prev) {
                $(this).addClass('active');
            }
        });
    }

    // Actualizar la sección de confirmación con los datos ingresados
    function updateConfirmation() {
        $('#confirmTipoPrestamo').text($('[name="tipo_prestamo"] option:selected').text());
        $('#confirmMonto').text($('#montoSolicitado').val() ? parseFloat($('#montoSolicitado').val()).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' Bs.' : '-');
        $('#confirmPlazo').text($('#plazoValue').val() + ' ' + ($('[name="tipo_plazo"] option:selected').val() === 'mensual' ? 'meses' : $('[name="tipo_plazo"] option:selected').val() === 'quincenal' ? 'quincenas' : 'semanas'));
        $('#confirmCuota').text($('#resumenCuota').text());
        $('#confirmNombre').text($('[name="nombres"]').val() + ' ' + $('[name="apellidos"]').val());
        $('#confirmDocumento').text($('[name="tipo_documento"] option:selected').text() + ': ' + $('[name="numero_documento"]').val());
        $('#confirmTelefono').text($('[name="telefono"]').val());
        $('#confirmEmail').text($('[name="email"]').val());
    }
</script>
@endsection