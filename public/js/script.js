// Función para manejar la validación en tiempo real
function handleInputValidation(inputElement, messageElement, maxLength, messageForTooLong, messageForCorrect, borderColor) {
    inputElement.addEventListener('input', function() {
        // Si el campo está vacío, eliminamos el mensaje y el borde de color
        if (this.value === '') {
            messageElement.textContent = '';
            inputElement.style.borderColor = '';
            return;
        }

        // Validación de longitud
        if (this.value.length > maxLength) {
            messageElement.textContent = messageForTooLong;
            messageElement.style.color = 'red';
            inputElement.style.borderColor = 'red';
        } else {
            messageElement.textContent = messageForCorrect;
            messageElement.style.color = 'green';
            inputElement.style.borderColor = 'green';
        }
    });
}

// Validación del nombre (máximo 50 caracteres)
handleInputValidation(
    document.getElementById('nombres'),
    document.getElementById('nameMessage'),
    50,
    "El nombre no puede superar los 50 caracteres.",
    "¡Correcto!",
    'green'
);

// Validación de apellidos (máximo 50 caracteres)
handleInputValidation(
    document.getElementById('apellidos'),
    document.getElementById('lastnameMessage'),
    50,
    "Los apellidos no pueden superar los 50 caracteres.",
    "¡Correcto!",
    'green'
);

// Validación del teléfono (máximo 10 caracteres)
handleInputValidation(
    document.getElementById('telefono'),
    document.getElementById('phoneMessage'),
    10,
    "El teléfono no puede superar los 10 caracteres.",
    "¡Correcto!",
    'green'
);

// Validación de la foto (solo formatos png y jpg)
document.getElementById('foto').addEventListener('change', function() {
    const photoInput = this;
    const photoMessage = document.getElementById('photoMessage');
    const preview = document.getElementById('preview');
    const file = photoInput.files[0];

    // Si no hay archivo seleccionado, eliminamos el mensaje y la previsualización
    if (!file) {
        photoMessage.textContent = '';
        preview.style.display = 'none';
        return;
    }

    const fileType = file.type;
    if (fileType === 'image/png' || fileType === 'image/jpeg') {
        photoMessage.textContent = "Formato correcto.";
        photoMessage.style.color = "green";
        // Mostrar previsualización de la imagen
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = "block";
        };
        reader.readAsDataURL(file);
    } else {
        photoMessage.textContent = "Solo se permiten imágenes en formato PNG o JPG.";
        photoMessage.style.color = "red";
        preview.style.display = "none";
    }
});

// Función para manejar los cambios de validación (para todos los campos)
function handleInputValidationOnChange(input, messageElement, maxLength, errorMessage, successMessage, successColor, previousValue) {
    input.addEventListener('input', function() {
        if (input.value !== previousValue) {
            previousValue = input.value;
            // Validación de longitud
            if (input.value.length > maxLength) {
                messageElement.textContent = errorMessage;
                messageElement.style.color = 'red';
            } else if (input.value.length > 0) {
                messageElement.textContent = successMessage;
                messageElement.style.color = successColor;
            } else {
                messageElement.textContent = '';
            }
        }
    });
}

// Cuando el modal de "Agregar Usuario" se abre
document.getElementById('addUserModal').addEventListener('show.bs.modal', function() {
    handleInputValidationOnChange(
        document.querySelector('#addUserModal #nombres'),
        document.querySelector('#addUserModal #nameMessage'),
        50,
        "El nombre no puede superar los 50 caracteres.",
        "¡Correcto!",
        'green',
        document.querySelector('#addUserModal #nombres').value
    );
    handleInputValidationOnChange(
        document.querySelector('#addUserModal #apellidos'),
        document.querySelector('#addUserModal #lastnameMessage'),
        50,
        "El apellido no puede superar los 50 caracteres.",
        "¡Correcto!",
        'green',
        document.querySelector('#addUserModal #apellidos').value
    );
    handleInputValidationOnChange(
        document.querySelector('#addUserModal #telefono'),
        document.querySelector('#addUserModal #phoneMessage'),
        10,
        "El teléfono no puede superar los 10 caracteres.",
        "¡Correcto!",
        'green',
        document.querySelector('#addUserModal #telefono').value
    );
});

// Cuando el modal de "Editar Usuario" se abre
document.getElementById('editModal').addEventListener('show.bs.modal', function() {
    handleInputValidationOnChange(
        document.querySelector('#editModal #nombres'),
        document.querySelector('#editModal #nameMessage'),
        50,
        "El nombre no puede superar los 50 caracteres.",
        "¡Correcto!",
        'green',
        document.querySelector('#editModal #nombres').value
    );
    handleInputValidationOnChange(
        document.querySelector('#editModal #apellidos'),
        document.querySelector('#editModal #lastnameMessage'),
        50,
        "El apellido no puede superar los 50 caracteres.",
        "¡Correcto!",
        'green',
        document.querySelector('#editModal #apellidos').value
    );
    handleInputValidationOnChange(
        document.querySelector('#editModal #telefono'),
        document.querySelector('#editModal #phoneMessage'),
        10,
        "El teléfono no puede superar los 10 caracteres.",
        "¡Correcto!",
        'green',
        document.querySelector('#editModal #telefono').value
    );
});
