@extends('adminlte::page')

@section('title', 'Registrar Cliente')
@section('content_header')
    <h1>Registro de Clientes</h1>
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/cliente.css') }}">
<div class="container">
    <form action="{{ route('clientes.store') }}" method="POST" enctype="multipart/form-data" id="clientForm" class="client-form">
        @csrf
        <div class="form-grid">

            {{-- Sección Información Personal --}}
            <div class="form-section">
                <h2><i class="fas fa-user-tie"></i> Información Personal</h2>
                <div class="form-group">
                    <label>Nombres*</label>
                    <input type="text" name="nombre_completo" required>
                </div>
                <div class="form-group">
                    <label>DNI / CI*</label>
                    <input type="text" name="ci" required>
                </div>
                <div class="form-group">
                    <label>Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento">
                </div>
                <div class="form-group">
                    <label>Nacionalidad</label>
                    <input type="text" name="nacionalidad">
                </div>
            </div>

            {{-- Sección Contacto --}}
            <div class="form-section">
                <h2><i class="fas fa-address-book"></i> Información de Contacto</h2>
                <div class="form-group">
                    <label>Email*</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Teléfono*</label>
                    <input type="tel" name="telefono" required>
                </div>
                <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" name="direccion">
                </div>
                <div class="form-group">
                    <label>Contraseña*</label>
                    <input type="password" name="password" required>
                </div>
            </div>

            {{-- Sección Empresarial --}}
            <div class="form-section">
                <h2><i class="fas fa-briefcase"></i> Trabajo y Referencia</h2>
                <div class="form-group">
                    <label>Ocupación</label>
                    <input type="text" name="ocupacion">
                </div>
                <div class="form-group">
                    <label>Egresos Mensuales</label>
                    <input type="number" step="0.01" name="egresos_mensuales">
                </div>
                <div class="form-group">
                    <label>Lugar de trabajo</label>
                    <input type="text" name="lugar_trabajo">
                </div>
                <div class="form-group">
                    <label>Referencia Nombre</label>
                    <input type="text" name="referencia_nombre">
                </div>
                <div class="form-group">
                    <label>Referencia CI</label>
                    <input type="text" name="referencia_ci">
                </div>
                <div class="form-group">
                    <label>Referencia Teléfono</label>
                    <input type="text" name="referencia_telefono">
                </div>
            </div>

            {{-- Extras --}}
            <div class="form-section">
                <h2><i class="fas fa-user-circle"></i> Otros Datos</h2>
                <div class="form-group">
                    <label>Estado Civil</label>
                    <select name="estado_civil">
                        <option value="">Seleccionar</option>
                        <option value="Soltero">Soltero</option>
                        <option value="Casado">Casado</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Género</label>
                    <select name="genero">
                        <option value="">Seleccionar</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Foto del cliente</label>
                    <input type="file" name="foto" id="foto" accept="image/*">
                    <div style="margin-top: 10px;">
                        <img id="previewImage" src="#" alt="Vista previa" style="max-width: 200px; display: none; border-radius: 8px;">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-footer">
            <button type="reset" class="btn btn-secondary">Limpiar</button>
            <button type="submit" class="btn btn-primary">Registrar Cliente</button>
        </div>
    </form>
</div>
@endsection

@section('js')
<script src="{{ asset('js/cliente.js') }}"></script>
@endsection
