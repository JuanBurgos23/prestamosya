<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Préstamos | Registro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #2980b9;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --transition: all 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: var(--dark-color);
        }

        .register-container {
            width: 100%;
            max-width: 1200px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            min-height: 700px;
            position: relative;
        }

        .register-form-container {
            width: 50%;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            z-index: 2;
        }

        .register-hero {
            width: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 40px;
        }

        .logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo img {
            height: 60px;
            margin-bottom: 15px;
        }

        .logo h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .logo p {
            color: #7f8c8d;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
            color: var(--dark-color);
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            transition: var(--transition);
        }

        .input-group:focus-within {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.2);
        }

        .input-group i {
            padding: 0 15px;
            color: #7f8c8d;
            font-size: 18px;
        }

        .input-group input,
        .input-group select {
            flex: 1;
            padding: 15px;
            border: none;
            outline: none;
            font-size: 16px;
            background: transparent;
        }

        .toggle-password {
            padding: 0 15px;
            cursor: pointer;
            color: #7f8c8d;
            font-size: 18px;
            border-left: 1px solid #ddd;
            height: 100%;
            display: flex;
            align-items: center;
            transition: var(--transition);
        }

        .toggle-password:hover {
            color: var(--secondary-color);
        }

        .row {
            display: flex;
            gap: 20px;
        }

        .col {
            flex: 1;
        }

        .user-type-selector {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .user-type-option {
            flex: 1;
            position: relative;
        }

        .user-type-option input {
            position: absolute;
            opacity: 0;
        }

        .user-type-option label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            cursor: pointer;
            transition: var(--transition);
            height: 100%;
            text-align: center;
        }

        .user-type-option input:checked+label {
            border-color: var(--secondary-color);
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--secondary-color);
        }

        .user-type-option i {
            font-size: 24px;
            margin-bottom: 10px;
            color: inherit;
        }

        .terms-check {
            margin: 25px 0;
            display: flex;
            align-items: flex-start;
        }

        .terms-check input {
            margin-right: 10px;
            margin-top: 3px;
            accent-color: var(--secondary-color);
        }

        .terms-check label {
            font-size: 14px;
            line-height: 1.5;
        }

        .terms-check a {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .terms-check a:hover {
            text-decoration: underline;
        }

        .btn-register {
            width: 100%;
            padding: 16px;
            background: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-register:hover {
            background: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-register i {
            font-size: 18px;
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
        }

        .login-link a {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .hero-content {
            max-width: 80%;
            z-index: 2;
        }

        .hero-content h2 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.3;
        }

        .hero-content p {
            margin-bottom: 30px;
            opacity: 0.9;
            line-height: 1.6;
        }

        .features {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .feature i {
            font-size: 24px;
            color: rgba(255, 255, 255, 0.8);
        }

        .feature span {
            font-size: 16px;
            opacity: 0.9;
        }

        .decorative-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }

        .circle-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            right: -100px;
        }

        .circle-2 {
            width: 200px;
            height: 200px;
            bottom: -50px;
            left: -50px;
        }

        .circle-3 {
            width: 150px;
            height: 150px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            border-radius: 15px;
            width: 90%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
            padding: 30px;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #7f8c8d;
            transition: var(--transition);
        }

        .close-modal:hover {
            color: var(--danger-color);
        }

        .modal-body {
            line-height: 1.6;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .register-container {
                flex-direction: column;
                max-width: 600px;
            }

            .register-form-container,
            .register-hero {
                width: 100%;
            }

            .register-hero {
                padding: 40px 20px;
                order: -1;
            }

            .register-form-container {
                padding: 40px;
            }

            .hero-content {
                max-width: 100%;
                text-align: center;
            }

            .features {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
            }

            .feature {
                flex: 0 0 calc(50% - 10px);
            }
        }

        @media (max-width: 768px) {
            .row {
                flex-direction: column;
                gap: 0;
            }

            .user-type-selector {
                flex-direction: column;
            }
        }

        @media (max-width: 576px) {
            .register-container {
                border-radius: 10px;
            }

            .register-form-container {
                padding: 30px 20px;
            }

            .logo img {
                height: 50px;
            }

            .logo h1 {
                font-size: 24px;
            }

            .feature {
                flex: 0 0 100%;
            }

            .hero-content h2 {
                font-size: 26px;
            }
        }

        /* Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-form-container">
            <div class="logo">
                <img src="{{ asset('img/logo/tuxson1.jpg') }}" alt="Logo" class="floating">
                <h1>Sistema de Préstamos</h1>
                <p>Acceso seguro al panel de gestión</p>
            </div>

            <style>
                .logo {
                    text-align: center;
                    margin-bottom: 40px;
                }

                .logo img {
                    height: 120px;
                    /* Tamaño aumentado a 120px */
                    width: auto;
                    /* Mantiene proporción original */
                    max-width: 300px;
                    /* Ancho máximo para controlar dimensiones */
                    margin-bottom: 20px;
                    object-fit: contain;
                    /* Asegura que la imagen no se distorsione */
                    /* Quité border-radius para mantener formato rectangular */
                    border: none;
                    /* Eliminé el borde blanco */
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                    /* Sombra sutil opcional */
                }

                .logo h1 {
                    font-size: 28px;
                    font-weight: 700;
                    color: var(--primary-color);
                    margin-bottom: 5px;
                    margin-top: 10px;
                }

                .logo p {
                    color: #7f8c8d;
                    font-size: 14px;
                    margin-top: 5px;
                }

                /* Ajustes responsivos */
                @media (max-width: 768px) {
                    .logo img {
                        height: 100px;
                        /* Reducción para móviles */
                        max-width: 250px;
                    }

                    .logo h1 {
                        font-size: 24px;
                    }
                }

                @media (max-width: 576px) {
                    .logo img {
                        height: 80px;
                        max-width: 200px;
                    }
                }
            </style>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="firstName">Nombre Completo</label>
                            <div class="input-group">
                                <i class="fas fa-user"></i>
                                <input type="text" id="firstName" name="name" placeholder="Juan" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="tu@email.com" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <div class="input-group">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="password" name="password" placeholder="••••••••" required>
                                <span class="toggle-password" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="confirmPassword">Confirmar Contraseña</label>
                            <div class="input-group">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="confirmPassword" name="password_confirmation" placeholder="••••••••" required>
                                <span class="toggle-password" onclick="togglePassword('confirmPassword')">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Teléfono</label>
                    <div class="input-group">
                        <i class="fas fa-phone"></i>
                        <input type="tel" id="phone" placeholder="+1234567890" required>
                    </div>
                </div>

                <div class="terms-check">
                    <input type="checkbox" id="terms" required>
                    <label for="terms">Acepto los <a href="#" id="showTerms">Términos y Condiciones</a> y la <a href="#">Política de Privacidad</a></label>
                </div>

                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus"></i> Registrarse
                </button>
            </form>

            <div class="login-link">
                ¿Ya tiene una cuenta? <a href="{{ route('login') }}">Iniciar Sesión</a>
            </div>
        </div>

        <div class="register-hero">
            <div class="decorative-circle circle-1"></div>
            <div class="decorative-circle circle-2"></div>
            <div class="decorative-circle circle-3"></div>

            <div class="hero-content">
                <h2>Únase a nuestra plataforma</h2>
                <p>La solución más completa para la gestión de préstamos personales y empresariales con las más altas normas de seguridad.</p>

                <div class="features">
                    <div class="feature">
                        <i class="fas fa-shield-alt"></i>
                        <span>Encriptación de nivel bancario</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-chart-pie"></i>
                        <span>Reportes detallados y análisis</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-bell"></i>
                        <span>Alertas y notificaciones</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-headset"></i>
                        <span>Soporte técnico 24/7</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Términos y Condiciones -->
    <div class="modal" id="termsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Términos y Condiciones</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4>1. Aceptación de los Términos</h4>
                <p>Al registrarse en nuestro sistema de gestión de préstamos, usted acepta cumplir con estos términos y condiciones en su totalidad.</p>

                <h4>2. Uso del Servicio</h4>
                <p>El sistema está diseñado para facilitar la gestión de préstamos entre particulares y empresas. Usted se compromete a usar el servicio únicamente para fines legales y de acuerdo con estas condiciones.</p>

                <h4>3. Responsabilidades del Usuario</h4>
                <p>Es su responsabilidad mantener la confidencialidad de su cuenta y contraseña, así como restringir el acceso a su dispositivo. Usted acepta ser responsable de todas las actividades que ocurran bajo su cuenta o contraseña.</p>

                <h4>4. Privacidad y Protección de Datos</h4>
                <p>Nos comprometemos a proteger su información personal de acuerdo con nuestra Política de Privacidad. Todos los datos se almacenan de forma segura y solo se utilizan para los fines establecidos.</p>

                <h4>5. Limitación de Responsabilidad</h4>
                <p>No nos hacemos responsables por pérdidas indirectas, consecuentes o especiales que resulten del uso o la imposibilidad de uso de nuestro servicio.</p>

                <h4>6. Modificaciones</h4>
                <p>Nos reservamos el derecho de modificar estos términos en cualquier momento. Las modificaciones entrarán en vigor inmediatamente después de su publicación en el sitio.</p>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeIcon = passwordInput.nextElementSibling.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        // Modal functionality
        const modal = document.getElementById('termsModal');
        const showTermsBtn = document.getElementById('showTerms');
        const closeModalBtn = document.querySelector('.close-modal');

        showTermsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });

        closeModalBtn.addEventListener('click', function() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });

        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });

        // Form validation and submission
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form values
            const firstName = document.getElementById('firstName').value;
            const lastName = document.getElementById('lastName').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const phone = document.getElementById('phone').value;
            const userType = document.querySelector('input[name="userType"]:checked').value;
            const termsAccepted = document.getElementById('terms').checked;

            // Validate passwords match
            if (password !== confirmPassword) {
                alert('Las contraseñas no coinciden');
                return;
            }

            // Validate terms accepted
            if (!termsAccepted) {
                alert('Debe aceptar los términos y condiciones para registrarse');
                return;
            }

            // Simulate registration process
            console.log('Registration data:', {
                firstName,
                lastName,
                email,
                password,
                phone,
                userType
            });

            // Show success message (in a real app, you would redirect or show a proper message)
            alert('Registro exitoso (simulado)\nBienvenido/a ' + firstName + ' ' + lastName);

            // In a real app, you would submit the form to your backend
            // this.submit();
        });

        // Add floating animation to decorative elements
        const circles = document.querySelectorAll('.decorative-circle');
        circles.forEach((circle, index) => {
            circle.style.animation = `float ${6 + index * 2}s ease-in-out infinite ${index * 0.5}s`;
        });
    </script>
</body>

</html>