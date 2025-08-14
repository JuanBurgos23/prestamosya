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
                                    <option value="mensual" selected>Mensual</option>
                                    <option value="quincenal">Quincenal</option>
                                    <option value="semanal">Semanal</option>
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
                            <span class="summary-value" id="resumenInteres">12.5% anual</span>
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
    document.addEventListener('DOMContentLoaded', function () {
        // Helpers de existencia para evitar que el script se rompa si no cargaste librerías
        const hasjQuery = typeof window.$ === 'function';
        const hasDatepicker = hasjQuery && typeof $.fn.datepicker === 'function';
        const hasSwal = typeof window.Swal === 'object';
        const hasSignaturePadLib = typeof window.SignaturePad === 'function';
    
        // ====== DATEPICKER (si está disponible) ======
        if (hasDatepicker) {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                language: 'es',
                autoclose: true,
                endDate: '0d'
            });
        }
    
        // ====== BINDINGS PARA CALCULAR RESUMEN ======
        function bindResumenListeners() {
            const monto = document.getElementById('montoSolicitado');
            const plazoValue = document.getElementById('plazoValue');
            const tipoPlazo = document.querySelector('[name="tipo_plazo"]');
    
            if (monto) monto.addEventListener('input', actualizarResumen);
            if (plazoValue) {
                plazoValue.addEventListener('input', actualizarResumen);
                plazoValue.addEventListener('change', actualizarResumen);
            }
            if (tipoPlazo) tipoPlazo.addEventListener('change', actualizarResumen);
    
            // slider ↔ number
            const plazoRange = document.getElementById('plazoRange');
            if (plazoRange && plazoValue) {
                plazoRange.addEventListener('input', function () {
                    plazoValue.value = this.value;
                    actualizarResumen();
                });
                plazoValue.addEventListener('input', function () {
                    plazoRange.value = this.value;
                    actualizarResumen();
                });
            }
        }
    
        // ====== SUBIDA DE ARCHIVOS (no rompe si no existen) ======
        function bindFileLabels() {
            const map = [
                ['documentoIdentidad', 'documentoIdentidadName'],
                ['comprobanteDomicilio', 'comprobanteDomicilioName'],
                ['comprobanteIngresos', 'comprobanteIngresosName'],
            ];
            map.forEach(([inputId, labelId]) => {
                const input = document.getElementById(inputId);
                const label = document.getElementById(labelId);
                if (input && label) {
                    input.addEventListener('change', function () {
                        label.textContent = this.files[0] ? this.files[0].name : 'No se ha seleccionado archivo';
                    });
                }
            });
    
            const otros = document.getElementById('otrosDocumentos');
            const otrosName = document.getElementById('otrosDocumentosName');
            if (otros && otrosName) {
                otros.addEventListener('change', function () {
                    if (this.files.length > 0) {
                        otrosName.textContent = Array.from(this.files).map(f => f.name).join(', ');
                    } else {
                        otrosName.textContent = 'No se ha seleccionado archivo';
                    }
                });
            }
        }
    
        // ====== SIGNATURE PAD (solo si existe canvas y librería cargada) ======
        let signaturePad = null;
        (function initSignature() {
            const canvas = document.getElementById('signaturePad');
            if (canvas && hasSignaturePadLib) {
                signaturePad = new SignaturePad(canvas, {
                    backgroundColor: 'rgb(255,255,255)',
                    penColor: 'rgb(0,0,0)'
                });
                const clearBtn = document.getElementById('clearSignature');
                if (clearBtn) clearBtn.addEventListener('click', () => signaturePad.clear());
            }
        })();
    
        // ====== SUBMIT FORM: valida firma solo si hay canvas y se requiere ======
        (function bindSubmit() {
            const form = document.getElementById('loanApplicationForm');
            if (!form) return;
            form.addEventListener('submit', function (e) {
                const firmaInput = document.getElementById('firmaElectronica');
                const requiereFirma = !!document.getElementById('signaturePad'); // si hay canvas, pedimos firma
                if (requiereFirma && signaturePad && signaturePad.isEmpty()) {
                    e.preventDefault();
                    if (hasSwal) {
                        Swal.fire({ icon: 'error', title: 'Firma requerida', text: 'Por favor proporcione su firma electrónica' });
                    } else {
                        alert('Por favor proporcione su firma electrónica');
                    }
                    return false;
                }
                if (firmaInput && signaturePad && !signaturePad.isEmpty()) {
                    firmaInput.value = signaturePad.toDataURL();
                }
            });
        })();
    
        // ====== NAVEGACIÓN DE PASOS (usa Swal solo si está) ======
        window.nextStep = function (current, next) {
            // Valida campos requeridos del paso actual
            const step = document.getElementById(`step${current}`);
            if (step) {
                let valid = true;
                step.querySelectorAll('[required]').forEach(el => {
                    if (!el.value) {
                        el.classList.add('is-invalid');
                        valid = false;
                    } else {
                        el.classList.remove('is-invalid');
                    }
                });
                if (!valid) {
                    if (hasSwal) {
                        Swal.fire({ icon: 'error', title: 'Campos requeridos', text: 'Complete los campos obligatorios antes de continuar' });
                    } else {
                        alert('Complete los campos obligatorios antes de continuar');
                    }
                    return;
                }
            }
    
            if (next === 4) updateConfirmation();
    
            const cur = document.getElementById(`step${current}`);
            const nxt = document.getElementById(`step${next}`);
            if (cur && nxt) {
                cur.style.display = 'none';
                nxt.style.display = '';
            }
    
            document.querySelectorAll('.step').forEach((el, idx) => {
                el.classList.remove('active', 'completed');
                if (idx + 1 < next) el.classList.add('completed');
                if (idx + 1 === next) el.classList.add('active');
            });
        };
    
        window.prevStep = function (current, prev) {
            const cur = document.getElementById(`step${current}`);
            const prv = document.getElementById(`step${prev}`);
            if (cur && prv) {
                cur.style.display = 'none';
                prv.style.display = '';
            }
            document.querySelectorAll('.step').forEach((el, idx) => {
                el.classList.remove('active', 'completed');
                if (idx + 1 < prev) el.classList.add('completed');
                if (idx + 1 === prev) el.classList.add('active');
            });
        };
    
        // ====== CÁLCULO DEL RESUMEN (ARREGLADO) ======
        function actualizarResumen() {
            const monto = parseFloat((document.getElementById('montoSolicitado')?.value || '0').replace(',', '.')) || 0;
            const plazo = parseInt(document.getElementById('plazoValue')?.value || '0', 10) || 0;
            const tipoPlazo = document.querySelector('[name="tipo_plazo"]')?.value || 'mensual';
    
            // Tasa ejemplo (ajústala si quieres)
            let tasaAnual = 12.5;
            if (monto > 80000) tasaAnual = 9.0;
            else if (monto > 50000) tasaAnual = 10.5;
    
            // Solo calculamos con esquema mensual. Si es quincenal/semanal, puedes convertir a "meses equivalentes".
            const interesMensual = (tasaAnual / 12) / 100;
    
            let cuota = 0, totalPagar = 0;
            if (monto > 0 && plazo > 0 && interesMensual > 0) {
                // Fórmula de amortización francesa
                const factor = Math.pow(1 + interesMensual, plazo);
                cuota = monto * (interesMensual * factor) / (factor - 1);
                totalPagar = cuota * plazo;
            } else if (monto > 0 && plazo > 0) {
                // sin interés (raro, pero evitamos NaN)
                cuota = monto / plazo;
                totalPagar = monto;
            }
    
            // Texto de periodo
            const lblPeriodo = (tipoPlazo === 'mensual') ? 'mes' : (tipoPlazo === 'quincenal') ? 'quincena' : 'semana';
            const lblPlazo = (tipoPlazo === 'mensual') ? 'meses' : (tipoPlazo === 'quincenal') ? 'quincenas' : 'semanas';
    
            // Pintar UI (ojo: construir string y pasarlo a .textContent)
            const resumenMonto = document.getElementById('resumenMonto');
            const resumenInteres = document.getElementById('resumenInteres');
            const resumenPlazo = document.getElementById('resumenPlazo');
            const resumenCuota = document.getElementById('resumenCuota');
            const resumenTotal = document.getElementById('resumenTotal');
    
            if (resumenMonto) resumenMonto.textContent = monto.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' Bs.';
            if (resumenInteres) resumenInteres.textContent = tasaAnual.toFixed(1) + '% anual';
            if (resumenPlazo) resumenPlazo.textContent = `${plazo} ${lblPlazo}`;
            if (resumenCuota) resumenCuota.textContent = (isNaN(cuota) ? '0,00' : cuota.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 })) + ` Bs./${lblPeriodo}`;
            if (resumenTotal) resumenTotal.textContent = (isNaN(totalPagar) ? '0,00' : totalPagar.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 })) + ' Bs.';
        }
    
        // ====== CONFIRMACIÓN (usa lo ya calculado) ======
        function updateConfirmation() {
            const tipoPrestamoText = document.querySelector('[name="tipo_prestamo"] option:checked')?.textContent || '-';
            const montoText = document.getElementById('resumenMonto')?.textContent || '-';
            const plazoText = document.getElementById('resumenPlazo')?.textContent || '-';
            const cuotaText = document.getElementById('resumenCuota')?.textContent || '-';
    
            const nombre = (document.querySelector('[name="nombres"]')?.value || '') + ' ' + (document.querySelector('[name="apellidos"]')?.value || '');
            const docTipo = document.querySelector('[name="tipo_documento"] option:checked')?.textContent || '';
            const docNum = document.querySelector('[name="numero_documento"]')?.value || '';
            const tel = document.querySelector('[name="telefono"]')?.value || '';
            const email = document.querySelector('[name="email"]')?.value || '';
    
            const setText = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };
            setText('confirmTipoPrestamo', tipoPrestamoText);
            setText('confirmMonto', montoText);
            setText('confirmPlazo', plazoText);
            setText('confirmCuota', cuotaText);
            setText('confirmNombre', nombre.trim() || '-');
            setText('confirmDocumento', (docTipo && docNum) ? `${docTipo}: ${docNum}` : '-');
            setText('confirmTelefono', tel || '-');
            setText('confirmEmail', email || '-');
        }
    
        // Exponer funciones globales si las usas en HTML
        window.actualizarResumen = actualizarResumen;
        window.updatePlazoValue = function (value) {
            const plazoValue = document.getElementById('plazoValue');
            if (plazoValue) plazoValue.value = value;
            actualizarResumen();
        };
        window.updatePlazoRange = function (value) {
            const plazoRange = document.getElementById('plazoRange');
            if (plazoRange) plazoRange.value = value;
            actualizarResumen();
        };
        window.updateConfirmation = updateConfirmation;
    
        // Inicializaciones
        bindResumenListeners();
        bindFileLabels();
        actualizarResumen(); // primer cálculo
    });
    </script>
    
@endsection