$("#form_register").submit(function(e) {
    e.preventDefault(); // Prevenir el envío tradicional del formulario

    // Resetear validaciones visuales de Bootstrap
    $('.is-invalid').removeClass('is-invalid');
    let isValid = true;

    // --- Validaciones Frontend (sincronizadas con el backend) ---

    // Validar Nombre: No vacío y solo letras y espacios.
    const nombreVal = $('#nombre').val().trim();
    if (nombreVal === '' || !/^[a-zA-ZÁÉÍÓÚáéíóúñÑ\s]{2,100}$/.test(nombreVal)) {
        $('#nombre').addClass('is-invalid');
        Swal.fire({
            title: "Error!",
            text: "El campo Nombre es obligatorio y solo debe contener letras y espacios.",
            icon: "error"
        });
        isValid = false;
    }

    // Validar DNI: Exactamente 8 dígitos numéricos.
    const dniVal = $('#dni').val().trim();
    if (!/^\d{4}-\d{4}-\d{5}$/.test(dniVal)) {
        $('#dni').addClass('is-invalid');
        Swal.fire({
            title: "Error!",
            text: "El DNI debe contener un formato de 4-4-5 dígitos.",
            icon: "error"
        });
        isValid = false;
    }

    // Validar Correo electrónico: Formato de email válido.
    const emailVal = $('#correo').val().trim();
    if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(emailVal)) {
        $('#correo').addClass('is-invalid');
        Swal.fire({
            title: "Error!",
            text: "Por favor, introduzca una dirección de correo electrónico válida.",
            icon: "error"
        });
        isValid = false;
    }

    // Validar Teléfono: No vacío y con formato 4-4.
    const telefonoVal = $('#telefono').val().trim();
    if (telefonoVal === '' || !/^\d{4}-\d{4}$/.test(telefonoVal)) {
        $('#telefono').addClass('is-invalid');
        Swal.fire({
            title: "Error!",
            text: "El campo Teléfono es obligatorio y debe tener un formato de 4-4 dígitos.",
            icon: "error"
        });
        isValid = false;
    }

   
   const fechaNacimientoVal = $('#fecha_nacimiento').val().trim();
   
    if (fechaNacimientoVal === '' || !/^\d{2}-\d{2}-\d{4}$/.test(fechaNacimientoVal)) {
    $('#fecha_nacimiento').addClass('is-invalid');
    Swal.fire({
        title: "Error!",
        text: "El campo Fecha de Nacimiento es obligatorio y debe tener un formato válido (DD-MM-AAAA).",
        icon: "error"
    });
    isValid = false;
    }

    // Validar Nacionalidad: No vacío y solo letras y espacios.
    const nacionalidadVal = $('#nacionalidad').val().trim();
    if (nacionalidadVal === '' || !/^[a-zA-ZÁÉÍÓÚáéíóúñÑ\s]{2,50}$/.test(nacionalidadVal)) {
        $('#nacionalidad').addClass('is-invalid');
        Swal.fire({
            title: "Error!",
            text: "El campo Nacionalidad es obligatorio y solo debe contener letras.",
            icon: "error"
        });
        isValid = false;
    }

    // Validar Nombre de Usuario: No vacío, solo letras, números y guiones bajos.
    const nombreUsuarioVal = $('#nombre_usuario').val().trim();
    if (nombreUsuarioVal === '' || !/^[a-zA-Z0-9_]{4,20}$/.test(nombreUsuarioVal)) {
        $('#nombre_usuario').addClass('is-invalid');
        Swal.fire({
            title: "Error!",
            text: "El campo Nombre de Usuario es obligatorio y solo puede contener letras, números y guiones bajos.",
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
        $('#contrasena').addClass('is-invalid');
        Swal.fire({
            title: "Error!",
            text: "Las contraseñas no coinciden.",
            icon: "error"
        });
        isValid = false;
    }

    // Validar Términos y Condiciones
    if (!$('#acceptTerms').is(':checked')) {
        $('#acceptTerms').addClass('is-invalid');
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
        nombre: nombreVal,
        dni: dniVal,
        correo: emailVal,
        telefono: telefonoVal,
        fecha_nacimiento: fechaNacimientoVal,
        nacionalidad: nacionalidadVal,
        nombre_usuario: nombreUsuarioVal,
        contrasena: contrasena,
        confirmar_contrasena: confirmarContrasena,
        url_foto: null,
        tipo_rol: 'visitante',
        activo: 1,
        especialidad: null,
        horario: null
    };

    console.log("Datos a enviar:", formData);

    // --- Solicitud AJAX ---
    $.ajax({
        url: 'http://localhost/sistemaGrupo4/Public/user/',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(formData),
        success: function(response) {
            console.log("Respuesta:", response);
            Swal.fire({
                title: "¡Registro exitoso!",
                text: "El usuario ha sido registrado correctamente.",
                icon: "success",
                confirmButtonText: "Aceptar"
            }).then(() => {
                window.location.href = "http://localhost/SistemaGrupo4/Src/Views/auth.php";
            });
        },
        error: function(xhr) {
            console.error("Error completo de AJAX:", xhr);
            let errorMsg = "Ocurrió un error al intentar registrar el usuario.";
            try {
                const response = JSON.parse(xhr.responseText);
                if (response.message) {
                    errorMsg = response.message;
                } else if (response.errors) {
                    errorMsg = Object.values(response.errors).join('<br>');
                }
            } catch(e) {
                console.error("Error al parsear la respuesta de error del servidor:", e);
                errorMsg = xhr.statusText || errorMsg;
            }

            Swal.fire({
                title: "Error!",
                html: errorMsg,
                icon: "error"
            });
        }
    });
});