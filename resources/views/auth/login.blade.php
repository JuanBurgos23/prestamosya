<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Préstamos | Login</title>
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

        .login-container {
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

        .login-form-container {
            width: 50%;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            z-index: 2;
        }

        .login-hero {
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
            margin-bottom: 25px;
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

        .input-group input {
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

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me input {
            margin-right: 8px;
            accent-color: var(--secondary-color);
        }

        .forgot-password {
            color: var(--secondary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn-login {
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

        .btn-login:hover {
            background: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-login i {
            font-size: 18px;
        }

        .register-link {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
        }

        .register-link a {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .register-link a:hover {
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

        /* Responsive Design */
        @media (max-width: 992px) {
            .login-container {
                flex-direction: column;
                max-width: 600px;
            }

            .login-form-container,
            .login-hero {
                width: 100%;
            }

            .login-hero {
                padding: 40px 20px;
                order: -1;
            }

            .login-form-container {
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

        @media (max-width: 576px) {
            .login-container {
                border-radius: 10px;
            }

            .login-form-container {
                padding: 30px 20px;
            }

            .logo img {
                height: 50px;
            }

            .logo h1 {
                font-size: 24px;
            }

            .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
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
    <div class="login-container">
        <div class="login-form-container">
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

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="tu@email.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                        <span class="toggle-password" onclick="togglePassword()">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember">
                        <label for="remember">Recordar sesión</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="forgot-password">¿Olvidó su contraseña?</a>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </button>
            </form>

            <div class="register-link">
                ¿No tiene una cuenta? <a href="{{ route('register') }}">Regístrese aquí</a>
            </div>
        </div>

        <div class="login-hero">
            <div class="decorative-circle circle-1"></div>
            <div class="decorative-circle circle-2"></div>
            <div class="decorative-circle circle-3"></div>

            <div class="hero-content">
                <h2>Gestión Inteligente de Préstamos</h2>
                <p>La plataforma más avanzada para administración y control de préstamos financieros con tecnología de última generación.</p>

                <div class="features">
                    <div class="feature">
                        <i class="fas fa-shield-alt"></i>
                        <span>Seguridad bancaria nivel enterprise</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-chart-line"></i>
                        <span>Reportes y análisis en tiempo real</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-mobile-alt"></i>
                        <span>Acceso desde cualquier dispositivo</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span>Gestión integral de préstamos</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.querySelector('.toggle-password i');

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

        // Form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Simulate login process
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            console.log('Login attempt with:', {
                email,
                password
            });

            // Here you would typically make an AJAX request to your backend
            // For demo purposes, we'll just show an alert
            alert('Inicio de sesión exitoso (simulado)\nRedirigiendo al dashboard...');

            // In a real app, you would redirect after successful login
            // window.location.href = '/dashboard';
        });

        // Add floating animation to decorative elements
        const circles = document.querySelectorAll('.decorative-circle');
        circles.forEach((circle, index) => {
            circle.style.animation = `float ${6 + index * 2}s ease-in-out infinite ${index * 0.5}s`;
        });
    </script>
</body>

</html>