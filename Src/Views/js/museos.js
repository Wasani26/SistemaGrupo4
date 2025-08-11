// Esperar a que el DOM esté completamente cargado
$(document).ready(function() {

    // Escuchar el evento de envío del formulario
    $("#form_museos").submit(function(e) {
        e.preventDefault(); // Prevenir el envío tradicional del formulario

        // Resetear validaciones visuales de Bootstrap
        $('.is-invalid').removeClass('is-invalid');
        
        // -----------------
        // VALIDACIONES FRONTEND SINCRONIZADAS CON EL BACKEND
        // -----------------

        // Expresiones regulares adaptadas de la lógica del controlador
        const validarTexto = /^[\p{L}\p{N}\s,.'-]{2,255}$/u; // Asume un regex para texto general
        const validarNumero = /^\d+$/; // Acepta solo números

        // Obtenemos los valores de los inputs
        const nombreMuseoVal = $('#nombre_museo').val().trim();
        const descripcionVal = $('#descripcion').val().trim();
        const tipoDeMuseoVal = $('#tipo_de_museo').val().trim();
        const inauguracionVal = $('#inauguracion').val().trim();
        const horarioVal = $('#horario').val().trim();
        const direccionVal = $('#direccion').val().trim();
        const coordenadasVal = $('#coordenadas').val().trim();
        const idUbicacionVal = $('#id_ubicacion').val().trim();
        
        // Objeto para almacenar los campos vacíos
        const camposVacios = {};
        
        // Validaciones de campos requeridos (simula el bucle del controlador)
        if (nombreMuseoVal === '') { camposVacios.nombre_museo = 'nombre_museo'; }
        if (descripcionVal === '') { camposVacios.descripcion = 'descripcion'; }
        if (tipoDeMuseoVal === '') { camposVacios.tipo_de_museo = 'tipo_de_museo'; }
        if (inauguracionVal === '') { camposVacios.inauguracion = 'inauguracion'; }
        if (horarioVal === '') { camposVacios.horario = 'horario'; }
        if (direccionVal === '') { camposVacios.direccion = 'direccion'; }
        if (coordenadasVal === '') { camposVacios.coordenadas = 'coordenadas'; }
        if (idUbicacionVal === '') { camposVacios.id_ubicacion = 'id_ubicacion'; }
        
        // Si hay campos vacíos, mostramos una alerta y marcamos los inputs
        if (Object.keys(camposVacios).length > 0) {
            Swal.fire({
                title: "Error!",
                text: "Por favor, completa todos los campos obligatorios.",
                icon: "error"
            });
            for (const campo in camposVacios) {
                $(`#${campo}`).addClass('is-invalid');
            }
            return false;
        }

        // Validaciones de formato (simulando los `preg_match` del controlador)
        if (!validarTexto.test(nombreMuseoVal)) {
            $('#nombre_museo').addClass('is-invalid');
            Swal.fire({ title: "Error!", text: "Nombre del museo inválido.", icon: "error" });
            return false;
        }

        if (!validarTexto.test(descripcionVal)) {
            $('#descripcion').addClass('is-invalid');
            Swal.fire({ title: "Error!", text: "Descripción del museo inválida.", icon: "error" });
            return false;
        }

        if (!validarTexto.test(tipoDeMuseoVal)) {
            $('#tipo_de_museo').addClass('is-invalid');
            Swal.fire({ title: "Error!", text: "Tipo de museo inválido.", icon: "error" });
            return false;
        }
        
        if (!validarTexto.test(inauguracionVal)) {
            $('#inauguracion').addClass('is-invalid');
            Swal.fire({ title: "Error!", text: "Fecha de inauguración inválida.", icon: "error" });
            return false;
        }

        if (horarioVal === '') {
        $('#horario').addClass('is-invalid');
        Swal.fire({ title: "Error!", text: "El horario es obligatorio.", icon: "error" });
        return false;
        }
        
        if (!validarTexto.test(direccionVal)) {
            $('#direccion').addClass('is-invalid');
            Swal.fire({ title: "Error!", text: "Dirección inválida.", icon: "error" });
            return false;
        }

        if (!validarTexto.test(coordenadasVal)) {
            $('#coordenadas').addClass('is-invalid');
            Swal.fire({ title: "Error!", text: "Coordenadas inválidas.", icon: "error" });
            return false;
        }

        if (!validarNumero.test(idUbicacionVal) || idUbicacionVal <= 0) {
            $('#id_ubicacion').addClass('is-invalid');
            Swal.fire({ title: "Error!", text: "ID de ubicación inválido. Debe ser un número positivo.", icon: "error" });
            return false;
        }
        
        // --- Preparar datos para el envío ---
        const formData = {
            nombre_museo: nombreMuseoVal,
            descripcion: descripcionVal,
            tipo_de_museo: tipoDeMuseoVal,
            inauguracion: inauguracionVal,
            horario: horarioVal,
            direccion: direccionVal,
            coordenadas: coordenadasVal,
            id_ubicacion: idUbicacionVal
        };

        // ... El resto de la llamada AJAX ...
        Swal.fire({
            title: 'Cargando...',
            text: 'Guardando el nuevo museo, por favor espera.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: 'http://localhost/sistemaGrupo4/Public/museo/',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function(response) {
                Swal.fire({
                    title: "¡Éxito!",
                    text: "El museo ha sido registrado correctamente.",
                    icon: "success",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    window.location.reload(); 
                });
            },
            error: function(xhr) {
                let errorMsg = "Ocurrió un error al intentar registrar el museo.";
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