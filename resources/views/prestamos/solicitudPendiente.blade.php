@extends('adminlte::page')

@section('title', 'Solicitar Préstamo')

@section('content_header')
<div class="container">
    <h3>Solicitudes de Préstamo Pendientes</h3>

    @if($solicitudes->isEmpty())
    <div class="alert alert-info">No hay solicitudes pendientes.</div>
    @else
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Monto Solicitado</th>
                <th>Comentario</th>
                <th>Fecha</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($solicitudes as $solicitud)
            <tr>
                <td>{{ $solicitud->cliente->user->name ?? '---' }}</td>
                <td>Bs {{ number_format($solicitud->monto_solicitado, 2) }}</td>
                <td>{{ $solicitud->comentario ?? 'Sin comentario' }}</td>
                <td>{{ $solicitud->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('prestamos.create', ['cliente_id' => $solicitud->cliente->id]) }}" class="btn btn-sm btn-primary">
                        Registrar Préstamo
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection