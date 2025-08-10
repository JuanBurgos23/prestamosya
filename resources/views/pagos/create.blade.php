@extends('adminlte::page')

@section('title', 'Realizar Pago')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="font-weight-bold text-primary">
        <i class="fas fa-money-bill-wave mr-2"></i>
        Realizar Pago
    </h1>
    <div class="badge badge-primary p-2">
        <i class="fas fa-calendar-day mr-1"></i>
        {{ now()->format('d/m/Y') }}
    </div>
</div>
@endsection

@section('css')
<style>
    .payment-card {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: none;
        overflow: hidden;
    }

    .payment-header {
        background: linear-gradient(135deg, #2c3e50, #3498db);
        color: white;
        padding: 15px 20px;
        border-bottom: none;
    }

    .payment-body {
        padding: 25px;
        background-color: #fff;
    }

    .payment-summary-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px dashed #eee;
    }

    .payment-summary-label {
        font-weight: 500;
        color: #7f8c8d;
    }

    .payment-summary-value {
        font-weight: 600;
        color: #2c3e50;
    }

    .payment-summary-value.amount {
        color: #27ae60;
        font-size: 1.1rem;
    }

    .payment-form-label {
        font-weight: 500;
        color: #5a5a5a;
        margin-bottom: 8px;
    }

    .payment-form-control {
        border: 1px solid #d0d0d0;
        border-radius: 4px;
        padding: 10px 15px;
        transition: all 0.3s;
    }

    .payment-form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    .btn-payment-submit {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        letter-spacing: 0.5px;
        color: white;
        border-radius: 4px;
        transition: all 0.3s;
    }

    .btn-payment-submit:hover {
        background: linear-gradient(135deg, #27ae60, #219653);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .file-upload-container {
        border: 2px dashed #d0d0d0;
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .file-upload-container:hover {
        border-color: #3498db;
        background-color: #f8faff;
    }

    .file-name {
        margin-top: 10px;
        font-size: 0.85rem;
        color: #3498db;
    }

    @media (max-width: 768px) {
        .payment-body {
            padding: 15px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card payment-card mb-4">
                <div class="card-header payment-header">
                    <h5 class="mb-0">Préstamo #{{ $prestamo->id }}</h5>
                </div>
                <div class="card-body payment-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="payment-summary-item">
                                <span class="payment-summary-label">Monto Total:</span>
                                <span class="payment-summary-value amount">{{ number_format($prestamo->monto_aprobado, 2) }} Bs.</span>
                            </div>
                            <div class="payment-summary-item">
                                <span class="payment-summary-label">Saldo Pendiente:</span>
                                <span class="payment-summary-value">{{ number_format($prestamo->saldo_pendiente, 2) }} Bs.</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="payment-summary-item">
                                <span class="payment-summary-label">Próximo Pago:</span>
                                <span class="payment-summary-value">{{ $prestamo->proximo_pago }}</span>
                            </div>
                            <div class="payment-summary-item">
                                <span class="payment-summary-label">Cuota Estimada:</span>
                                <span class="payment-summary-value">{{ number_format($prestamo->monto_cuota, 2) }} Bs.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card payment-card">
                <div class="card-header payment-header">
                    <h5 class="mb-0">Registrar Pago</h5>
                </div>
                <div class="card-body payment-body">
                    <form action="{{ route('pagos.store') }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                        @csrf
                        <input type="hidden" name="id_prestamo" value="{{ $prestamo->id }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="payment-form-label">Monto del Pago (Bs.)</label>
                                    <input type="number" class="payment-form-control" name="monto" required>
                                </div>

                                <div class="form-group">
                                    <label class="payment-form-label">Fecha de Pago</label>
                                    <input type="date" class="payment-form-control" name="fecha_pago"
                                        value="{{ now()->format('Y-m-d') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="payment-form-label">Método de Pago</label>
                                    <select class="payment-form-control" name="metodo_pago" required>
                                        <option value="transferencia">Transferencia Bancaria</option>
                                        <option value="efectivo">Efectivo</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="payment-form-label">Comprobante (Opcional)</label>
                                    <div class="file-upload-container" onclick="document.getElementById('comprobante').click()">
                                        <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                        <div>Haga clic para subir comprobante</div>
                                        <div class="file-name" id="fileName">No se ha seleccionado archivo</div>
                                        <input type="file" id="comprobante" name="comprobante"
                                            accept=".pdf,.jpg,.jpeg,.png" style="display: none;"
                                            onchange="document.getElementById('fileName').textContent = this.files[0] ? this.files[0].name : 'No se ha seleccionado archivo'">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="payment-form-label">Comentarios (Opcional)</label>
                            <textarea class="payment-form-control" name="comentario" rows="2"></textarea>
                        </div>

                        <div class="alert alert-info mt-4">
                            <i class="fas fa-info-circle mr-2"></i>
                            Al realizar este pago, el saldo pendiente de su préstamo será actualizado automáticamente.
                        </div>
                        <div class="col-md-6">
                            <!-- Sección QR -->
                            <div class="qr-payment-section text-center p-4">
                                @if($prestamo->prestamista->qr)
                                <h6 class="mb-3">Pagar con QR</h6>
                                <img src="{{ asset('storage/' . $prestamo->prestamista->qr) }}"
                                    alt="QR para pagos"
                                    class="img-fluid qr-image mb-2"
                                    style="max-width: 180px;">
                                <p class="text-muted small">
                                    Escanee este código para pagar directamente<br>
                                    al prestamista {{ $prestamo->prestamista->name }}
                                </p>
                                @else
                                <div class="alert alert-warning small mb-0">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    QR de pago no disponible
                                </div>
                                @endif
                            </div>
                        </div>
                </div>
                <div class="text-right mt-4">
                    <a href="{{ route('prestamos.mis-prestamos') }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left mr-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-payment-submit">
                        <i class="fas fa-check-circle mr-1"></i> Registrar Pago
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación del monto
        document.getElementById('montoPago').addEventListener('change', function() {
            const maxAmount = parseFloat({
                {
                    $prestamo - > saldo_pendiente
                }
            });
            const enteredAmount = parseFloat(this.value);

            if (enteredAmount > maxAmount) {
                alert('El monto ingresado no puede ser mayor al saldo pendiente: ' + maxAmount.toFixed(2) + ' Bs.');
                this.value = maxAmount.toFixed(2);
            }
        });

        // Validación del formulario
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            const monto = parseFloat(document.getElementById('montoPago').value);
            if (monto <= 0) {
                e.preventDefault();
                alert('El monto del pago debe ser mayor a cero');
                return false;
            }
            return true;
        });
    });
</script>
@endsection