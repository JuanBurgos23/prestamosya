@extends('adminlte::page')

@section('title', 'Editar Perfil')

@section('content_header')
<h1 class="m-0 text-dark">Editar Perfil Empresarial</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-3">
        <!-- Tarjeta de perfil -->
        <form id="profileForm" method="POST" action="{{ route('perfil.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card card-primary card-outline">

                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{ auth()->user()->foto ? asset('storage/'.auth()->user()->foto) : asset('vendor/adminlte/dist/img/emo.png') }}"
                            alt="Foto de perfil" id="profileImage">
                    </div>
                    <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>
                    <p class="text-muted text-center">{{ auth()->user()->role ?? 'Usuario' }}</p>
                    <div class="text-center mt-4 mb-3">
                        <button type="button" class="btn btn-sm btn-primary" id="changePhotoBtn">
                            <i class="fas fa-camera mr-1"></i> Cambiar Foto
                        </button>
                        <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display: none;">
                    </div>

                    <!-- QR Section -->
                    <div class="border-top mt-3 pt-3 text-center">
                        <h5 class="text-muted">QR de Pagos</h5>
                        <img src="{{ auth()->user()->qr ? asset('storage/'.auth()->user()->qr) : asset('vendor/adminlte/dist/img/qr.png') }}"
                            alt="QR de pagos"
                            class="img-fluid border p-1 mb-2"
                            id="qrImage">
                        <div>
                            <button type="button" class="btn btn-sm btn-success" id="changeQrBtn">
                                <i class="fas fa-qrcode mr-1"></i> Subir QR
                            </button>
                            <input type="file" name="qr" id="qrInput" accept="image/*" style="display: none;">
                        </div>
                        <small class="text-muted">Sube tu código QR para recibir pagos</small>
                    </div>
                </div>
            </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información del Perfil</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nombre Completo</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name', auth()->user()->name) }}"
                                placeholder="Ingrese su nombre completo">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                placeholder="Ingrese su correo electrónico">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                id="phone" name="phone" value="{{ old('phone', auth()->user()->telefono) }}"
                                placeholder="Ingrese su número de teléfono">
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Nueva Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password"
                                placeholder="Ingrese nueva contraseña (opcional)">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                            <input type="password" class="form-control"
                                id="password_confirmation" name="password_confirmation"
                                placeholder="Confirme la nueva contraseña">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Guardar Cambios
                </button>
                <a href="{{ route('home') }}" class="btn btn-default float-right">
                    <i class="fas fa-times mr-1"></i> Cancelar
                </a>
            </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .profile-user-img {
        border: 3px solid #adb5bd;
        margin: 0 auto;
        width: 150px;
        height: 150px;
        object-fit: cover;
    }

    #qrImage {
        max-width: 200px;
        height: auto;
        background: white;
    }

    .card-primary.card-outline {
        border-top: 3px solid #007bff;
    }

    .box-profile {
        padding: 25px;
    }

    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }
</style>
@stop

@section('js')
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- jQuery (si no lo tienes ya) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function() {
        // Manejar cambio de foto de perfil
        $('#changePhotoBtn').click(function() {
            $('#avatarInput').click();
        });

        $('#avatarInput').change(function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();

                reader.onload = function(event) {
                    $('#profileImage').attr('src', event.target.result);
                };

                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Manejar cambio de QR
        $('#changeQrBtn').click(function() {
            $('#qrInput').click();
        });

        $('#qrInput').change(function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();

                reader.onload = function(event) {
                    $('#qrImage').attr('src', event.target.result);
                };

                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Validación del formulario
        $('#profileForm').submit(function(e) {
            let isValid = true;

            // Validar email
            const email = $('#email').val();
            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                $('#email').addClass('is-invalid');
                isValid = false;
            } else {
                $('#email').removeClass('is-invalid');
            }

            // Validar contraseñas coinciden (si se ingresaron)
            const password = $('#password').val();
            const passwordConfirmation = $('#password_confirmation').val();

            if (password && password !== passwordConfirmation) {
                $('#password').addClass('is-invalid');
                $('#password_confirmation').addClass('is-invalid');
                isValid = false;
            } else {
                $('#password').removeClass('is-invalid');
                $('#password_confirmation').removeClass('is-invalid');
            }

            if (!isValid) {
                e.preventDefault();
                toastr.error('Por favor corrija los errores en el formulario.');
            }
        });

        // Mostrar notificaciones
        @if(session('success'))
        toastr.success("{{ session('success') }}");
        @endif

        @if($errors -> any())
        toastr.error("Hay errores en el formulario. Por favor verifique.");
        @endif
    });
</script>
@stop