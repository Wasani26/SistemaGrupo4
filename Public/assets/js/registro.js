$(document).ready(function() {
    // Limpiar validaciones al cambiar campos
    $('input, select').on('input change', function() {
        $(this).removeClass('is-invalid');
        // También limpia 'is-invalid' si las contraseñas coinciden después de un cambio
        if($('#contrasena').val() === $('#confirmar_contrasena').val()) {
            $('#contrasena').removeClass('is-invalid');
            $('#confirmar_contrasena').removeClass('is-invalid');
        }
    });

    $("#form_register").submit(function(e) {
        e.preventDefault(); // Prevenir el envío tradicional del formulario

        // Resetear validaciones visuales de Bootstrap
        $('.is-invalid').removeClass('is-invalid');
        let isValid = true;

        // --- Validaciones Frontend ---

        // Validar Nombre
        if ($('#nombre').val().trim() === '') {
            $('#nombre').addClass('is-invalid');
            Swal.fire({
                title: "Error!",
                text: "El campo Nombre es obligatorio.",
                icon: "error"
            });
            isValid = false;
        }

        // Validar DNI numérico y 8 dígitos
        const dniVal = $('#dni').val().trim();
        if (!/^\d{8}$/.test(dniVal)) {
            $('#dni').addClass('is-invalid');
            Swal.fire({
                title: "Error!",
                text: "El DNI debe contener exactamente 8 dígitos numéricos.",
                icon: "error"
            });
            isValid = false;
        }

        // Validar Correo electrónico
        const emailVal = $('#correo').val().trim();
        if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(emailVal)) { // Simple regex para email
            $('#correo').addClass('is-invalid');
            Swal.fire({
                title: "Error!",
                text: "Por favor, introduzca una dirección de correo electrónico válida.",
                icon: "error"
            });
            isValid = false;
        }

        // Validar Teléfono
        const telefonoVal = $('#telefono').val().trim();
        if (telefonoVal === '' || !/^\d+$/.test(telefonoVal)) { // Asumiendo solo números
            $('#telefono').addClass('is-invalid');
            Swal.fire({
                title: "Error!",
                text: "El campo Teléfono es obligatorio y debe contener solo números.",
                icon: "error"
            });
            isValid = false;
        }

        // Validar Fecha de Nacimiento
        if ($('#fecha_nacimiento').val().trim() === '') {
            $('#fecha_nacimiento').addClass('is-invalid');
            Swal.fire({
                title: "Error!",
                text: "El campo Fecha de Nacimiento es obligatorio.",
                icon: "error"
            });
            isValid = false;
        }

        // Validar Nacionalidad
        if ($('#nacionalidad').val().trim() === '') {
            $('#nacionalidad').addClass('is-invalid');
            Swal.fire({
                title: "Error!",
                text: "El campo Nacionalidad es obligatorio.",
                icon: "error"
            });
            isValid = false;
        }

        // Validar Nombre de Usuario
        if ($('#nombre_usuario').val().trim() === '') {
            $('#nombre_usuario').addClass('is-invalid');
            Swal.fire({
                title: "Error!",
                text: "El campo Nombre de Usuario es obligatorio.",
                icon: "error"
            });
            isValid = false;
        }

        // Validar Contraseña y Confirmar Contraseña
        const contrasena = $('#contrasena').val();
        const confirmarContrasena = $('#confirmar_contrasena').val();
        if (contrasena === '') {
            $('#contrasena').addClass('is-invalid');
            Swal.fire({
                title: "Error!",
                text: "El campo Contraseña es obligatorio.",
                icon: "error"
            });
            isValid = false;
        } else if (contrasena !== confirmarContrasena) {
            $('#confirmar_contrasena').addClass('is-invalid');
            $('#contrasena').addClass('is-invalid'); // También marcar la primera contraseña si no coinciden
            Swal.fire({
                title: "Error!",
                text: "Las contraseñas no coinciden.",
                icon: "error"
            });
            isValid = false;
        }

        // Validar Términos y Condiciones
        if (!$('#acceptTerms').is(':checked')) {
            $('#acceptTerms').addClass('is-invalid'); // Esto podría no funcionar visualmente bien en checkbox, considera un mensaje diferente.
            Swal.fire({
                title: "Error!",
                text: "Debe aceptar los términos y condiciones.",
                icon: "error"
            });
            isValid = false;
        }

        // Si alguna validación falló, detener el proceso
        if (!isValid) {
            return false;
        }

        // --- Preparar datos para el envío ---
        const formData = {
            nombre: $('#nombre').val(),
            dni: dniVal,
            correo: emailVal,
            telefono: telefonoVal,
            fecha_nacimiento: $('#fecha_nacimiento').val(),
            nacionalidad: $('#nacionalidad').val(),
            nombre_usuario: $('#nombre_usuario').val(),
            contrasena: contrasena,
            confirmar_contrasena: confirmarContrasena,
            // url_foto: null se envía por defecto ya que el manejo de archivos requiere un enfoque diferente (FormData)
            url_foto: null, // Si no hay un input de archivo real o no lo procesas aquí.
            // Campos que el backend espera y que no se ingresan directamente por el usuario en este formulario
            tipo_rol: 'visitante', // Rol fijo para este formulario de registro
            activo: 1, // Estado por defecto (activo = 1)
            // Especialidad y Horario no aplican para rol 'visitante'
            especialidad: null,
            horario: null
        };

        // Depuración
        console.log("Datos a enviar:", formData);

        // --- Solicitud AJAX ---
        $.ajax({
            url: 'http://localhost/sistemaGrupo4/Public/user/', // URL del endpoint de tu backend
            type: 'POST',
            contentType: 'application/json', // Importante para enviar JSON
            data: JSON.stringify(formData), // Convertir el objeto a una cadena JSON
            success: function(response) {
                console.log("Respuesta:", response);
                Swal.fire({
                    title: "¡Registro exitoso!",
                    text: "El usuario ha sido registrado correctamente.",
                    icon: "success",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    // Redirigir al usuario a la página de login después del registro
                    window.location.href = "http://localhost/sistemaGrupo4/Public/auth"; // URL de redirección actualizada
                });
            },
            error: function(xhr) {
                console.error("Error completo de AJAX:", xhr);
                let errorMsg = "Ocurrió un error al intentar registrar el usuario.";
                try {
                    // Intenta parsear la respuesta del servidor para un mensaje de error más específico
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMsg = response.message;
                    } else if (response.errors) {
                        // Si el backend devuelve múltiples errores de validación
                        errorMsg = Object.values(response.errors).join('<br>');
                    }
                } catch(e) {
                    console.error("Error al parsear la respuesta de error del servidor:", e);
                    // Si la respuesta no es JSON, usa el estado de texto
                    errorMsg = xhr.statusText || errorMsg;
                }

                Swal.fire({
                    title: "Error!",
                    html: errorMsg, // Usar 'html' para permitir <br> en el mensaje
                    icon: "error"
                });
            }
        });
    });

    // Removimos la lógica de 'Doctor-fields' ya que este es un formulario de registro de visitante.
});

   