@extends('adminlte::page')

@section('title', 'Solicitar Préstamo')

@section('content_header')
<h1>Solicitar Préstamo</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('solicitudes.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="monto_solicitado" class="form-label">Monto solicitado</label>
                <input type="number" name="monto_solicitado" class="form-control" required step="0.01" min="0">
            </div>

            <div class="mb-3">
                <label for="comentario" class="form-label">Comentario (opcional)</label>
                <textarea name="comentario" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Enviar solicitud</button>
        </form>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
@stop