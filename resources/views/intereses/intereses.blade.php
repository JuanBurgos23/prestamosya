@extends('adminlte::page')

@section('title', 'Gestión de Plazos e Intereses')

@section('content_header')
<h1 class="text-dark">Gestión de Plazos e Intereses</h1>
@stop

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<div class="row">
    <!-- Card para Tipos de Plazo -->
    <div class="col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-alt mr-2"></i>Tipos de Plazo
                </h3>
            </div>
            <div class="card-body">
                <form id="plazoForm" action="{{ route('plazos.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre del Plazo</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select class="form-control" id="estado" name="estado">
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Guardar Plazo
                    </button>
                </form>

                <hr>

                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="plazosTable">
                        <thead class="bg-primary">
                            <tr>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plazos as $plazo)
                            <tr>
                                <td>{{ $plazo->nombre }}</td>

                                <td>
                                    <span class="badge badge-{{ $plazo->estado ? 'success' : 'danger' }}">
                                        {{ $plazo->estado ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-plazo" data-id="{{ $plazo->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-plazo" data-id="{{ $plazo->id }}">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $plazos->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Card para Intereses -->
    <div class="col-md-6">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-percentage mr-2"></i>Tasas de Interés
                </h3>
            </div>
            <div class="card-body">
                <form id="interesForm" action="{{ route('intereses.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="tipo_plazo_id">Tipo de Plazo</label>
                        <select class="form-control" id="tipo_plazo_id" name="tipo_plazo_id" required>
                            <option value="">Seleccione un plazo</option>
                            @foreach($plazos as $plazo)
                            <option value="{{ $plazo->id }}">{{ $plazo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tasa">Tasa de Interés (%)</label>
                        <input type="number" step="0.01" class="form-control" id="tasa" name="tasa" required>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select class="form-control" id="estado" name="estado">
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-1"></i> Guardar Interés
                    </button>
                </form>

                <hr>

                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="interesesTable">
                        <thead class="bg-success">
                            <tr>
                                <th>Plazo</th>
                                <th>Tasa %</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($intereses as $interes)
                            <tr>
                                <td>{{ $interes->tipoPlazo->nombre ?? 'no hay'}}</td>
                                <td>{{ number_format($interes->tasa_interes, 2) }}%</td>
                                <td>
                                    <span class="badge badge-{{ $interes->estado ? 'success' : 'danger' }}">
                                        {{ $interes->estado ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-interes" data-id="{{ $interes->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-interes" data-id="{{ $interes->id }}">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $intereses->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para edición -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Contenido dinámico -->
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- jQuery -->


<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function() {
        // Mostrar mensaje si existe en sessionStorage
        if (sessionStorage.getItem('toastMessage')) {
            const type = sessionStorage.getItem('toastType') || 'success';
            const message = sessionStorage.getItem('toastMessage');
            toastr[type](message);
            sessionStorage.removeItem('toastMessage');
            sessionStorage.removeItem('toastType');
        }

        // Editar plazo
        $(document).on('submit', '#editPlazoForm', function() {
            sessionStorage.setItem('toastMessage', 'Plazo actualizado correctamente');
            sessionStorage.setItem('toastType', 'success');
        });

        // Editar interés
        $(document).on('submit', '#editInteresForm', function() {
            sessionStorage.setItem('toastMessage', 'Interés actualizado correctamente');
            sessionStorage.setItem('toastType', 'success');
        });

        // Editar plazo
        $('.edit-plazo').click(function() {
            let id = $(this).data('id');
            $.get(`/plazos/${id}/edit`, function(data) {
                $('#modalContent').html(`
                <form id="editPlazoForm" method="POST" action="/plazos/${id}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="${data.nombre}" required>
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <select name="estado" class="form-control">
                            <option value="activo" ${data.estado ? 'selected' : ''}>Activo</option>
                            <option value="inactivo" ${!data.estado ? 'selected' : ''}>Inactivo</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            `);
                $('#editModal').modal('show');
            }).fail(function() {
                toastr.error("Error al cargar el plazo");
            });
        });

        // Editar interés
        $('.edit-interes').click(function() {
            let id = $(this).data('id');
            $.get(`/intereses/${id}/edit`, function(data) {
                let plazosOptions = '';
                @foreach($plazos as $plazo)
                plazosOptions += `<option value="{{ $plazo->id }}" ${data.tipo_plazo_id == {{ $plazo->id }} ? 'selected' : ''}>{{ $plazo->nombre }}</option>`;
                @endforeach

                $('#modalContent').html(`
                <form id="editInteresForm" method="POST" action="/intereses/${id}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Tipo de Plazo</label>
                        <select name="tipo_plazo_id" class="form-control" required>
                            <option value="">Seleccione</option>
                            ${plazosOptions}
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tasa %</label>
                        <input type="number" step="0.01" name="tasa_interes" class="form-control" value="${data.tasa_interes}" required>
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <select name="estado" class="form-control">
                            <option value="activo" ${data.estado ? 'selected' : ''}>Activo</option>
                            <option value="inactivo" ${!data.estado ? 'selected' : ''}>Inactivo</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            `);
                $('#editModal').modal('show');
            }).fail(function() {
                toastr.error("Error al cargar el interés");
            });
        });

        // Anular plazo
        $('.delete-plazo').click(function() {
            let id = $(this).data('id');
            if (confirm('¿Cambiar estado de este plazo?')) {
                $.ajax({
                    url: `/plazos/${id}/toggle-status`,
                    method: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        sessionStorage.setItem('toastMessage', 'Estado del plazo actualizado');
                        sessionStorage.setItem('toastType', 'success');
                        location.reload();
                    },
                    error: function() {
                        toastr.error("Error al cambiar el estado del plazo");
                    }
                });
            }
        });

        // Anular interés
        $('.delete-interes').click(function() {
            let id = $(this).data('id');
            if (confirm('¿Cambiar estado de esta tasa de interés?')) {
                $.ajax({
                    url: `/intereses/${id}/toggle-status`,
                    method: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        sessionStorage.setItem('toastMessage', 'Estado del interés actualizado');
                        sessionStorage.setItem('toastType', 'success');
                        location.reload();
                    },
                    error: function() {
                        toastr.error("Error al cambiar el estado del interés");
                    }
                });
            }
        });
    });
    @if(session('success'))
    toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
    toastr.error("{{ session('error') }}");
    @endif

    @if($errors -> any())
    toastr.error("Hay errores en el formulario. Por favor verifique.");
    @endif
</script>
@stop