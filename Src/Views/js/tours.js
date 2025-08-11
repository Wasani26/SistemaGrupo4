// Esperar a que el DOM esté completamente cargado
$(document).ready(function() {

    // Escuchar el evento de envío del formulario
    $("#form_tours").submit(function(e) {
        e.preventDefault(); // Prevenir el envío tradicional del formulario

        // Resetear validaciones visuales de Bootstrap
        $('.is-invalid').removeClass('is-invalid');
        let isValid = true;

        // -----------------
        // VALIDACIONES FRONTEND SINCRONIZADAS CON EL BACKEND
        // -----------------

        // Expresiones regulares adaptadas de la lógica del controlador
        const validarTexto = /^[\p{L}\p{N}\s,.'-]{2,255}$/u; // Acepta letras, números, espacios y signos de puntuación básicos.
        const validarNumero = /^\d+$/; // Acepta solo números.
        const validarFecha = /^\d{2}-\d{2}-\d{4}$/; // Formato DD-MM-AAAA.
        const validarHora = /^\d{2}:\d{2}$/; // Formato HH:MM.
        const validarNombre = /^[a-zA-ZÁÉÍÓÚáéíóúñÑ\s]{2,100}$/;

        // Obtenemos los valores de los inputs
        const nombreVal = $('#nombre').val().trim();
        const descripcionVal = $('#descripcion').val().trim();
        const fechaVal = $('#fecha').val().trim();
        const horaInicioVal = $('#hora_inicio').val().trim();
        const duracionVal = $('#duracion').val().trim();
        const cupoMaximoVal = $('#cupo_maximo').val().trim();
        const idiomaTourVal = $('#idioma_tour').val().trim();
        const puntoEncuentroVal = $('#punto_encuentro').val().trim();
        const comentarioVal = $('#comentario').val().trim();
        const idMuseoVal = $('#id_museo').val().trim();
        const idUsuarioVal = $('#id_usuario').val().trim();

        // Validaciones de campos requeridos (simula el bucle del controlador)
        if (nombreVal === '') { $('#nombre').addClass('is-invalid'); isValid = false; }
        if (descripcionVal === '') { $('#descripcion').addClass('is-invalid'); isValid = false; }
        if (fechaVal === '') { $('#fecha').addClass('is-invalid'); isValid = false; }
        if (horaInicioVal === '') { $('#hora_inicio').addClass('is-invalid'); isValid = false; }
        if (duracionVal === '') { $('#duracion').addClass('is-invalid'); isValid = false; }
        if (cupoMaximoVal === '') { $('#cupo_maximo').addClass('is-invalid'); isValid = false; }
        if (idiomaTourVal === '') { $('#idioma_tour').addClass('is-invalid'); isValid = false; }
        if (puntoEncuentroVal === '') { $('#punto_encuentro').addClass('is-invalid'); isValid = false; }
        if (comentarioVal === '') { $('#comentario').addClass('is-invalid'); isValid = false; }
        if (idMuseoVal === '') { $('#id_museo').addClass('is-invalid'); isValid = false; }
        if (idUsuarioVal === '') { $('#id_usuario').addClass('is-invalid'); isValid = false; }
        
        // Si hay campos vacíos, mostramos una alerta genérica y salimos
        if (!isValid) {
            Swal.fire({
                title: "Error!",
                text: "Por favor, completa todos los campos obligatorios.",
                icon: "error"
            });
            return false;
        }

        // Validaciones de formato (simulando los `preg_match` del controlador)
        if (!validarNombre.test(nombreVal)) {
            $('#nombre').addClass('is-invalid');
            Swal.fire({ title: "Error!", text: "Nombre inválido.", icon: "error" });
            return false;
        }

        if (!validarTexto.test(descripcionVal)) {
            $('#descripcion').addClass('is-invalid');
            Swal.fire({ title: "Error!", text: "Descripción inválida.", icon: "error" });
            return false;
        }

        // ** AHORA SE VALIDA EL FORMATO DD-MM-AAAA **
        if (!validarFecha.test(fechaVal)) {
            $('#fecha').addClass('is-invalid');
            Swal.fire({ title: "Error!", text: "Fecha inválida. Usa el formato DD-MM-AAAA.", icon: "error" });
            return false;
        }

        if (!validarHora.test(horaInicioVal)) {
            $('#hora_inicio').addClass('is-invalid');
            Swal.fire({ title: "Error!", text: "Hora de inicio inválida. Usa el formato HH:MM.", icon: "error" });
            return false;
        }

        if (!validarNumero.test(duracionVal) || duracionVal <= 0) {
            $('#duracion').addClass('is-invalid');
            Swal.fire({ title: "Error!", text: "Duración inválida. Debe ser un número positivo.", icon: "error" });
            return false;
        }

        if (!validarNumero.test(cupoMaximoVal) || cupoMaximoVal <= 0) {
            $('#cupo_maximo').addClass('is-invalid');
            Swal.fire({ title: "Error!", text: "Cupo máximo inválido. Debe ser un número positivo.", icon: "error" });
            return false;
        }

        if (!validarNumero.test(idiomaTourVal) || idiomaTourVal <= 0) {
            $('#idioma_tour').addClass('is-invalid');
            Swal.fire({ title: "Error!", text: "ID de idioma inválido. Debe ser un número positivo.", icon: "error" });
            return false;
        }

        if (!validarTexto.test(puntoEncuentroVal)) {
            $('#punto_encuentro').addClass('is-invalid');
            Swal.fire({ title: "Error!", text: "Punto de encuentro inválido.", icon: "error" });
            return false;
        }

        if (!validarTexto.test(comentarioVal)) {
            $('#comentario').addClass('is-invalid');
            Swal.fire({ title: "Error!", text: "Comentario inválido.", icon: "error" });
            return false;
        }

        if (!validarNumero.test(idMuseoVal) || idMuseoVal <= 0) {
            $('#id_museo').addClass('is-invalid');
            Swal.fire({ title: "Error!", text: "ID de museo inválido. Debe ser un número positivo.", icon: "error" });
            return false;
        }

        if (!validarNumero.test(idUsuarioVal) || idUsuarioVal <= 0) {
            $('#id_usuario').addClass('is-invalid');
            Swal.fire({ title: "Error!", text: "ID de usuario inválido. Debe ser un número positivo.", icon: "error" });
            return false;
        }

        // --- Preparar datos para el envío ---
        const formData = {
            nombre: nombreVal,
            descripcion: descripcionVal,
            fecha: fechaVal,
            hora_inicio: horaInicioVal,
            duracion: duracionVal,
            cupo_maximo: cupoMaximoVal,
            idioma_tour: idiomaTourVal,
            punto_encuentro: puntoEncuentroVal,
            comentario: comentarioVal,
            id_museo: idMuseoVal,
            id_usuario: idUsuarioVal
        };

        // ... El resto de la llamada AJAX es el mismo ...
        Swal.fire({
            title: 'Cargando...',
            text: 'Guardando el nuevo tour, por favor espera.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: 'http://localhost/sistemaGrupo4/Public/tour/',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function(response) {
                Swal.fire({
                    title: "¡Éxito!",
                    text: "El tour ha sido registrado correctamente.",
                    icon: "success",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    window.location.reload(); 
                });
            },
            error: function(xhr) {
                let errorMsg = "Ocurrió un error al intentar registrar el tour.";
                try {
                    const response = JSON.parse(xhr.responseText);
                    errorMsg = response.message || errorMsg;
                } catch(e) {
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
});