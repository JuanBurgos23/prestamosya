@extends('adminlte::page')

@section('title', 'Registrar Préstamo')

@section('content_header')
    <h1>Registrar Préstamo</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('prestamos.store') }}" method="POST">
                @csrf

                {{-- Buscar cliente --}}
                <div class="form-group">
                    <label for="cliente_id">Cliente</label>
                    <select name="cliente_id" id="cliente_id" class="form-control select2" required>
                        <option value="">Seleccione un cliente</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nombre_completo }} - {{ $cliente->ci }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Monto del préstamo --}}
                <div class="form-group">
                    <label for="monto">Monto del préstamo</label>
                    <input type="number" name="monto" class="form-control" required step="0.01">
                </div>

                {{-- Fecha del préstamo --}}
                <div class="form-group">
                    <label for="fecha_prestamo">Fecha del préstamo</label>
                    <input type="date" name="fecha_prestamo" class="form-control" required>
                </div>

                {{-- Cada cuánto paga el interés --}}
                <div class="form-group">
                    <label for="frecuencia_pago">Frecuencia de pago</label>
                    <select name="frecuencia_pago" class="form-control" required>
                        <option value="diario">Diario</option>
                        <option value="semanal">Semanal</option>
                        <option value="quincenal">Quincenal</option>
                        <option value="mensual">Mensual</option>
                    </select>
                </div>

                {{-- Porcentaje de interés --}}
                <div class="form-group">
                    <label for="interes">Interés (%)</label>
                    <input type="number" name="interes" class="form-control" step="0.01" required>
                </div>

                {{-- Comentario u observación --}}
                <div class="form-group">
                    <label for="observacion">Observación (opcional)</label>
                    <textarea name="observacion" class="form-control" rows="3"></textarea>
                </div>

                {{-- Botón --}}
                <div class="form-group text-end">
                    <button type="submit" class="btn btn-primary">Registrar Préstamo</button>
                </div>

            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2();
    </script>
@stop
