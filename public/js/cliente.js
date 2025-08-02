document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('clientForm');
    const resetBtn = document.getElementById('resetBtn');
    const modal = document.getElementById('successModal');
    const modalCloseBtn = document.getElementById('modalCloseBtn');
    const closeModal = document.querySelector('.close-modal');

    // Validación en tiempo real
    form.addEventListener('input', function(e) {
        const input = e.target;
        if (input.required && !input.value) {
            showError(input, 'Este campo es requerido');
        } else {
            clearError(input);
        }

        // Validaciones específicas
        if (input.id === 'email' && input.value) {
            validateEmail(input);
        }

        if (input.id === 'phone' && input.value) {
            validatePhone(input);
        }

        if (input.id === 'dni' && input.value) {
            validateDNI(input);
        }
    });

    // Envío del formulario
    form.addEventListener('submit', function(e) {
        
        
        if (validateForm()) {
            // Simular envío a servidor
            //e.preventDefault();
            setTimeout(() => {
                modal.style.display = 'flex';
                form.reset();
            }, 500);
        }
    });

    // Botón de reset
    resetBtn.addEventListener('click', function() {
        form.reset();
        clearAllErrors();
    });

    // Cerrar modal
    modalCloseBtn.addEventListener('click', closeModalHandler);
    closeModal.addEventListener('click', closeModalHandler);
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModalHandler();
        }
    });

    // Funciones de ayuda
    function validateForm() {
        let isValid = true;
        const requiredInputs = form.querySelectorAll('[required]');
        
        requiredInputs.forEach(input => {
            if (!input.value) {
                showError(input, 'Este campo es requerido');
                isValid = false;
            }
        });

        // Validar email si tiene valor
        const emailInput = document.getElementById('email');
        if (emailInput.value && !validateEmail(emailInput)) {
            isValid = false;
        }

        // Validar teléfono si tiene valor
        const phoneInput = document.getElementById('phone');
        if (phoneInput.value && !validatePhone(phoneInput)) {
            isValid = false;
        }

        // Validar DNI si tiene valor
        const dniInput = document.getElementById('dni');
        if (dniInput.value && !validateDNI(dniInput)) {
            isValid = false;
        }

        return isValid;
    }

    function validateEmail(input) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(input.value)) {
            showError(input, 'Ingrese un correo electrónico válido');
            return false;
        }
        clearError(input);
        return true;
    }

    function validatePhone(input) {
        const phoneRegex = /^[0-9\s+-]{8,15}$/;
        if (!phoneRegex.test(input.value)) {
            showError(input, 'Ingrese un número de teléfono válido');
            return false;
        }
        clearError(input);
        return true;
    }

    function validateDNI(input) {
        const dniRegex = /^[0-9]{8,12}$/;
        if (!dniRegex.test(input.value)) {
            showError(input, 'Ingrese un DNI/Cédula válido');
            return false;
        }
        clearError(input);
        return true;
    }

    function showError(input, message) {
        const formGroup = input.closest('.form-group');
        const errorElement = formGroup.querySelector('.error-message');
        input.style.borderColor = 'var(--error-color)';
        errorElement.textContent = message;
    }

    function clearError(input) {
        const formGroup = input.closest('.form-group');
        const errorElement = formGroup.querySelector('.error-message');
        input.style.borderColor = '';
        errorElement.textContent = '';
    }

    function clearAllErrors() {
        const errorElements = form.querySelectorAll('.error-message');
        const inputs = form.querySelectorAll('input, select');
        
        errorElements.forEach(element => {
            element.textContent = '';
        });
        
        inputs.forEach(input => {
            input.style.borderColor = '';
        });
    }

    function closeModalHandler() {
        modal.style.display = 'none';
    }

    // Máscara para teléfono
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0) {
            value = value.match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            value = !value[2] ? value[1] : '(' + value[1] + ') ' + value[2] + (value[3] ? '-' + value[3] : '');
        }
        e.target.value = value;
    });
});
document.getElementById('foto').addEventListener('change', function(e) {
    const input = e.target;
    const preview = document.getElementById('previewImage');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = "#";
        preview.style.display = 'none';
    }
});