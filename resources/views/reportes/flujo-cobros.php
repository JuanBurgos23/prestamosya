@extends('adminlte::page')

@section('title', 'Reporte de Flujo de Cobros')

@section('content_header')
    <h1>Reporte de Flujo de Cobros</h1>
@stop

@section('content')
    <canvas id="flujoCobrosChart" height="100"></canvas>
@stop


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json(array_merge($historico->pluck('mes')->toArray(), array_keys($proyeccion)));
    const historicoData = @json($historico->pluck('total')->toArray());
    const proyeccionData = @json(array_values($proyeccion));

    new Chart(document.getElementById('flujoCobrosChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Cobros Reales',
                    data: historicoData,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)'
                },
                {
                    label: 'Cobros Proyectados',
                    data: proyeccionData,
                    type: 'line',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>

