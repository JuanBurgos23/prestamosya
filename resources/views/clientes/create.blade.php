@extends('adminlte::page')

@section('title', 'Registrar Cliente')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="font-weight-bold text-primary">
        <i class="fas fa-user-plus mr-2"></i>
        Registro de Clientes
    </h1>
    <div class="badge badge-primary p-2">
        <i class="fas fa-id-card mr-1"></i>
        Nuevo Cliente
    </div>
</div>
@endsection

@section('css')
<style>
    .client-form-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 25px;
        margin-bottom: 30px;
    }
    
    .form-section-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
        position: relative;
    }
    
    .form-section-title i {
        margin-right: 10px;
        color: #3498db;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        font-weight: 500;
        color: #5a5a5a;
        margin-bottom: 8px;
    }
    
    .form-group input:not([type="file"]),
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #d0d0d0;
        border-radius: 6px;
        transition: all 0.3s;
        font-size: 0.95rem;
    }
    
    .form-group input:focus,
    .form-group select:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        outline: none;
    }
    
    .required-field::after {
        content: " *";
        color: #e74c3c;
    }
    
    .photo-upload-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 15px;
    }
    
    .photo-preview {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background-color: #f8f9fa;
        border: 2px dashed #d0d0d0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-bottom: 15px;
        position: relative;
        transition: all 0.3s;
    }
    
    .photo-preview:hover {
        border-color: #3498db;
    }
    
    .photo-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
    }
    
    .photo-placeholder {
        text-align: center;
        color: #7f8c8d;
    }
    
    .photo-placeholder i {
        font-size: 2.5rem;
        margin-bottom: 10px;
        color: #bdc3c7;
    }
    
    .photo-upload-btn {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 500;
    }
    
    .photo-upload-btn:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
    }
    
    .form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #f0f0f0;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #3498db, #2c3e50);
        border: none;
        padding: 10px 25px;
        font-weight: 600;
        color: white;
        border-radius: 6px;
        transition: all 0.3s;
    }
    
    .btn-submit:hover {
        background: linear-gradient(135deg, #2c3e50, #3498db);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .btn-reset {
        background-color: #f8f9fa;
        border: 1px solid #d0d0d0;
        padding: 10px 25px;
        font-weight: 500;
        color: #5a5a5a;
        border-radius: 6px;
        transition: all 0.3s;
    }
    
    .btn-reset:hover {
        background-color: #e9ecef;
    }
    
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="client-form-container">
        <form action="{{ route('clientes.store') }}" method="POST" enctype="multipart/form-data" id="clientForm">
            @csrf
            <div class="form-grid">

                {{-- Sección Información Personal --}}
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-user-tie"></i>
                        Información Personal
                    </h3>
                    <div class="form-group">
                        <label class="required-field">Nombres Completos</label>
                        <input type="text" name="nombre_completo" required>
                    </div>
                    <div class="form-group">
                        <label class="required-field">DNI / CI</label>
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
                    <h3 class="form-section-title">
                        <i class="fas fa-address-book"></i>
                        Información de Contacto
                    </h3>
                    <div class="form-group">
                        <label class="required-field">Email</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label class="required-field">Teléfono</label>
                        <input type="tel" name="telefono" required>
                    </div>
                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" name="direccion">
                    </div>
                    <div class="form-group">
                        <label class="required-field">Contraseña</label>
                        <input type="password" name="password" required>
                    </div>
                </div>

                {{-- Sección Empresarial --}}
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-briefcase"></i>
                        Información Laboral
                    </h3>
                    <div class="form-group">
                        <label>Ocupación</label>
                        <input type="text" name="ocupacion">
                    </div>
                    <div class="form-group">
                        <label>Egresos Mensuales (Bs.)</label>
                        <input type="number" step="0.01" name="egresos_mensuales">
                    </div>
                    <div class="form-group">
                        <label>Lugar de Trabajo</label>
                        <input type="text" name="lugar_trabajo">
                    </div>
                </div>

                {{-- Sección Foto y Otros Datos --}}
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-user-circle"></i>
                        Foto y Otros Datos
                    </h3>
                    <div class="form-group">
                        <label>Estado Civil</label>
                        <select name="estado_civil" class="form-control">
                            <option value="">Seleccionar</option>
                            <option value="Soltero">Soltero</option>
                            <option value="Casado">Casado</option>
                            <option value="Divorciado">Divorciado</option>
                            <option value="Viudo">Viudo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Género</label>
                        <select name="genero" class="form-control">
                            <option value="">Seleccionar</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Foto del Cliente</label>
                        <div class="photo-upload-container">
                            <div class="photo-preview" id="photoPreview">
                                <div class="photo-placeholder">
                                    <i class="fas fa-user"></i>
                                    <div>Foto del cliente</div>
                                </div>
                                <img id="previewImage" src="#" alt="Vista previa">
                            </div>
                            <input type="file" name="foto" id="foto" accept="image/*" style="display: none;">
                            <button type="button" class="photo-upload-btn" onclick="document.getElementById('foto').click()">
                                <i class="fas fa-cloud-upload-alt mr-1"></i> Seleccionar Foto
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Sección Referencias --}}
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-users"></i>
                        Referencias Personales
                    </h3>
                    <div class="form-group">
                        <label>Nombre de Referencia</label>
                        <input type="text" name="referencia_nombre">
                    </div>
                    <div class="form-group">
                        <label>CI de Referencia</label>
                        <input type="text" name="referencia_ci">
                    </div>
                    <div class="form-group">
                        <label>Teléfono de Referencia</label>
                        <input type="text" name="referencia_telefono">
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <button type="reset" class="btn-reset">
                    <i class="fas fa-eraser mr-1"></i> Limpiar Formulario
                </button>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save mr-1"></i> Registrar Cliente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Previsualización de la foto
        const photoInput = document.getElementById('foto');
        const photoPreview = document.getElementById('photoPreview');
        const previewImage = document.getElementById('previewImage');
        const placeholder = photoPreview.querySelector('.photo-placeholder');
        
        photoInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                    placeholder.style.display = 'none';
                }
                
                reader.readAsDataURL(file);
            }
        });
        
        // Validación del formulario
        const form = document.getElementById('clientForm');
        form.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Validar campos requeridos
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = '#e74c3c';
                    isValid = false;
                } else {
                    field.style.borderColor = '#d0d0d0';
                }
            });
            
            if (!isValid) {
                event.preventDefault();
                alert('Por favor complete todos los campos requeridos');
            }
        });
    });
</script>
@endsection