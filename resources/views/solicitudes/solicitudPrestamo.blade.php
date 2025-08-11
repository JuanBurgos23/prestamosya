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
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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

    .amount-option input:checked+label {
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
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
                                <label class="form-label">Tipo de Préstamo</label>
                                <select class="form-control form-control-bank" name="tipo_prestamo" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="personal">Préstamo Personal</option>
                                    <option value="negocio">Préstamo para Negocios</option>
                                    <option value="educacion">Préstamo Educativo</option>
                                    <option value="vivienda">Préstamo para Vivienda</option>
                                    <option value="vehiculo">Préstamo para Vehículo</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Monto Solicitado (Bs.)
                                    <i class="fas fa-info-circle tooltip-icon" title="Monto mínimo: 1,000 Bs. - Monto máximo: 100,000 Bs."></i>
                                </label>
                                <input type="number" class="form-control form-control-bank" name="monto_solicitado"
                                    min="1000" max="100000" step="100" required id="montoSolicitado">

                                <div class="amount-selector mt-2">
                                    <div class="amount-option">
                                        <input type="radio" name="monto_rapido" id="monto1000" value="1000" onclick="document.getElementById('montoSolicitado').value = this.value">
                                        <label for="monto1000">1,000 Bs.</label>
                                    </div>
                                    <div class="amount-option">
                                        <input type="radio" name="monto_rapido" id="monto5000" value="5000" onclick="document.getElementById('montoSolicitado').value = this.value">
                                        <label for="monto5000">5,000 Bs.</label>
                                    </div>
                                    <div class="amount-option">
                                        <input type="radio" name="monto_rapido" id="monto10000" value="10000" onclick="document.getElementById('montoSolicitado').value = this.value">
                                        <label for="monto10000">10,000 Bs.</label>
                                    </div>
                                    <div class="amount-option">
                                        <input type="radio" name="monto_rapido" id="monto20000" value="20000" onclick="document.getElementById('montoSolicitado').value = this.value">
                                        <label for="monto20000">20,000 Bs.</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Plazo de Pago</label>
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="range" class="form-control-range custom-range" min="1" max="60"
                                            value="12" id="plazoRange" oninput="updatePlazoValue(this.value)">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control form-control-bank text-center"
                                            name="plazo" id="plazoValue" value="12" min="1" max="60"
                                            onchange="updatePlazoRange(this.value)" required>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <small>1 mes</small>
                                    <small>60 meses</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Tipo de Plazo</label>
                                <select class="form-control form-control-bank" name="tipo_plazo" required>
                                    <option value="diario">Diario</option>
                                    <option value="semanal">Semanal</option>
                                    <option value="mensual" selected>Mensual</option>
                                    <option value="anual">Anual</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Destino del Préstamo</label>
                                <textarea class="form-control form-control-bank" name="destino_prestamo"
                                    rows="2" placeholder="Describa el uso que dará al préstamo" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="summary-card">
                        <h5 class="font-weight-bold mb-3">Resumen Estimado</h5>
                        <div class="summary-item">
                            <span class="summary-label">Monto solicitado:</span>
                            <span class="summary-value" id="resumenMonto">0.00 Bs.</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Tasa de interés estimada:</span>
                            <span class="summary-value" id="resumenInteres"></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Plazo:</span>
                            <span class="summary-value" id="resumenPlazo">12 meses</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Cuota estimada:</span>
                            <span class="summary-value" id="resumenCuota">0.00 Bs./mes</span>
                        </div>
                        <div class="summary-item summary-total">
                            <span>Total a pagar:</span>
                            <span id="resumenTotal">0.00 Bs.</span>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="button" class="btn btn-bank-primary" onclick="nextStep(1, 2)">
                            Siguiente <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Paso 2: Información Personal -->
                <div class="form-section" id="step2" style="display: none;">
                    <h4 class="section-title">
                        <i class="fas fa-user-tie"></i>
                        Información Personal
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

                    <div class="text-right mt-3">
                        <button type="button" class="btn btn-bank-secondary mr-2" onclick="prevStep(2, 1)">
                            <i class="fas fa-arrow-left mr-2"></i> Anterior
                        </button>
                        <button type="button" class="btn btn-bank-primary" onclick="nextStep(2, 3)">
                            Siguiente <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Paso 3: Documentación -->
                <div class="form-section" id="step3" style="display: none;">
                    <h4 class="section-title">
                        <i class="fas fa-file-upload"></i>
                        Documentación Requerida
                    </h4>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        Por favor adjunte los documentos solicitados en formato PDF, JPG o PNG (Tamaño máximo: 5MB cada archivo)
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ $documentos[1]->nombre }}</label>
                                <label for="documentoIdentidad" class="custom-file-upload">
                                    <i class="fas fa-id-card fa-2x mb-2"></i>
                                    <div>Haga clic para subir archivo</div>
                                    <div class="file-name" id="documentoIdentidadName">No se ha seleccionado archivo</div>
                                </label>
                                <input type="file" id="documentoIdentidad" name="documento_identidad"
                                    accept=".pdf,.jpg,.jpeg,.png" style="display: none;" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">{{ $documentos[3]->nombre }}</label>
                                <label for="comprobanteDomicilio" class="custom-file-upload">
                                    <i class="fas fa-home fa-2x mb-2"></i>
                                    <div>Haga clic para subir archivo</div>
                                    <div class="file-name" id="comprobanteDomicilioName">No se ha seleccionado archivo</div>
                                </label>
                                <input type="file" id="comprobanteDomicilio" name="comprobante_domicilio"
                                    accept=".pdf,.jpg,.jpeg,.png" style="display: none;" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ $documentos[2]->nombre }}</label>
                                <label for="comprobanteIngresos" class="custom-file-upload">
                                    <i class="fas fa-file-invoice-dollar fa-2x mb-2"></i>
                                    <div>Haga clic para subir archivo</div>
                                    <div class="file-name" id="comprobanteIngresosName">No se ha seleccionado archivo</div>
                                </label>
                                <input type="file" id="comprobanteIngresos" name="comprobante_ingresos"
                                    accept=".pdf,.jpg,.jpeg,.png" style="display: none;" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">{{ $documentos[4]->nombre }}</label>
                                <label for="otrosDocumentos" class="custom-file-upload">
                                    <i class="fas fa-file-alt fa-2x mb-2"></i>
                                    <div>Haga clic para subir archivo</div>
                                    <div class="file-name" id="otrosDocumentosName">No se ha seleccionado archivo</div>
                                </label>
                                <input type="file" id="otrosDocumentos" name="otros_documentos"
                                    accept=".pdf,.jpg,.jpeg,.png" style="display: none;" multiple>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terminosCondiciones" required>
                            <label class="form-check-label" for="terminosCondiciones">
                                Acepto los <a href="#" data-toggle="modal" data-target="#terminosModal">Términos y Condiciones</a>
                                y la <a href="#" data-toggle="modal" data-target="#privacidadModal">Política de Privacidad</a>
                            </label>
                        </div>
                    </div>

                    <div class="text-right mt-3">
                        <button type="button" class="btn btn-bank-secondary mr-2" onclick="prevStep(3, 2)">
                            <i class="fas fa-arrow-left mr-2"></i> Anterior
                        </button>
                        <button type="button" class="btn btn-bank-primary" onclick="nextStep(3, 4)">
                            Siguiente <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Paso 4: Confirmación -->
                <div class="form-section" id="step4" style="display: none;">
                    <h4 class="section-title">
                        <i class="fas fa-clipboard-check"></i>
                        Confirmación de Solicitud
                    </h4>

                    <div class="alert alert-success">
                        <i class="fas fa-check-circle mr-2"></i>
                        ¡Estás a un paso de completar tu solicitud de préstamo! Por favor revisa cuidadosamente la información proporcionada.
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="summary-card">
                                <h5 class="font-weight-bold mb-3">Resumen del Préstamo</h5>
                                <div class="summary-item">
                                    <span class="summary-label">Tipo de préstamo:</span>
                                    <span class="summary-value" id="confirmTipoPrestamo">-</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Monto solicitado:</span>
                                    <span class="summary-value" id="confirmMonto">-</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Plazo:</span>
                                    <span class="summary-value" id="confirmPlazo">-</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Cuota estimada:</span>
                                    <span class="summary-value" id="confirmCuota">-</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="summary-card">
                                <h5 class="font-weight-bold mb-3">Información Personal</h5>
                                <div class="summary-item">
                                    <span class="summary-label">Nombre completo:</span>
                                    <span class="summary-value" id="confirmNombre">{{ $cliente->nombre_completo }}</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Documento:</span>
                                    <span class="summary-value" id="confirmDocumento">{{ $cliente->ci }}</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Teléfono:</span>
                                    <span class="summary-value" id="confirmTelefono">{{ $cliente->telefono }}</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Correo electrónico:</span>
                                    <span class="summary-value" id="confirmEmail">{{ $cliente->correo }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <label class="form-label">Firma Electrónica</label>
                        <div class="border rounded p-3 text-center" style="height: 100px; background: #f8f9fa;">
                            <canvas id="signaturePad" width="400" height="80"></canvas>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="clearSignature">
                                <i class="fas fa-eraser mr-1"></i> Limpiar
                            </button>
                        </div>
                        <small class="text-muted">Por favor dibuje su firma en el área superior</small>
                        <input type="hidden" name="firma_electronica" id="firmaElectronica">
                    </div>

                    <div class="text-right mt-4">
                        <button type="button" class="btn btn-bank-secondary mr-2" onclick="prevStep(4, 3)">
                            <i class="fas fa-arrow-left mr-2"></i> Anterior
                        </button>
                        <button type="submit" class="btn btn-bank-primary">
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
        $('#comprobanteDomicilio').change(function() {
            $('#comprobanteDomicilioName').text(this.files[0] ? this.files[0].name : 'No se ha seleccionado archivo');
        });
        $('#comprobanteIngresos').change(function() {
            $('#comprobanteIngresosName').text(this.files[0] ? this.files[0].name : 'No se ha seleccionado archivo');
        });
        $('#otrosDocumentos').change(function() {
            if (this.files.length > 0) {
                const names = Array.from(this.files).map(f => f.name).join(', ');
                $('#otrosDocumentosName').text(names);
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
        const plazo = parseInt($('#plazoValue').val()) || 1;
        const tipoPlazo = $('[name="tipo_plazo"]').val();

        // Tasa de interés según el tipo de plazo (puedes ajustarlo según tu BD)
        let tasaInteres = Number("{{ $interes->tasa_interes ?? 0 }}"); // 10 significa 10% por el plazo seleccionado
        if (monto > 50000) tasaInteres = 10.5;
        if (monto > 80000) tasaInteres = 9.0;

        // Interés por cada cuota según tipo de plazo
        const interesPorCuota = monto * (tasaInteres / 100);

        // Cada cuota = capital por cuota + interés por cuota
        const cuotaCapital = monto / plazo;
        const cuota = cuotaCapital + interesPorCuota;
        const totalPagar = cuota * plazo;

        // Texto de la unidad
        let unidad = '';
        switch (tipoPlazo) {
            case 'diario':
                unidad = 'día';
                break;
            case 'semanal':
                unidad = 'semana';
                break;
            case 'quincenal':
                unidad = 'quincena';
                break;
            case 'mensual':
                unidad = 'mes';
                break;
            case 'anual':
                unidad = 'año';
                break;
        }

        // Actualizar UI
        $('#resumenMonto').text(monto.toLocaleString('es-ES', {
            minimumFractionDigits: 2
        }) + ' Bs.');
        $('#resumenInteres').text(tasaInteres.toFixed(1) + ' % ' + unidad);
        $('#resumenPlazo').text(plazo + ' ' + (unidad + (plazo > 1 ? 's' : '')));
        $('#resumenCuota').text(cuota.toFixed(2) + ' Bs./' + unidad);
        $('#resumenTotal').text(totalPagar.toFixed(2) + ' Bs.');
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
        $('#confirmMonto').text($('#montoSolicitado').val() ? parseFloat($('#montoSolicitado').val()).toLocaleString('es-ES', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }) + ' Bs.' : '-');
        $('#confirmPlazo').text($('#plazoValue').val() + ' ' + ($('[name="tipo_plazo"] option:selected').val() === 'mensual' ? 'meses' : $('[name="tipo_plazo"] option:selected').val() === 'quincenal' ? 'quincenas' : 'semanas'));
        $('#confirmCuota').text($('#resumenCuota').text());
        $('#confirmNombre').text($('[name="nombres"]').val() + ' ' + $('[name="apellidos"]').val());
        $('#confirmDocumento').text($('[name="tipo_documento"] option:selected').text() + ': ' + $('[name="numero_documento"]').val());
        $('#confirmTelefono').text($('[name="telefono"]').val());
        $('#confirmEmail').text($('[name="email"]').val());
    }
</script>
@endsection