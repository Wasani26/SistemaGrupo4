$(document).ready(function() {
    // Limpiar validaciones al cambiar campos
    $('input, select').on('input change', function() {
        $(this).removeClass('is-invalid');
        if($(this).attr('id') === 'confirmar_contrasena' && $(this).val() === $('#contrasena').val()) {
            $(this).removeClass('is-invalid');
        }
    });

    $("#form_register").submit(function(e) {
        e.preventDefault();
        
        // Resetear validaciones
        $('.is-invalid').removeClass('is-invalid');
        let isValid = true;

        // Validar contraseñas coincidan
        if ($('#contrasena').val() !== $('#confirmar_contrasena').val()) {
            $('#confirmar_contrasena').addClass('is-invalid');
            Swal.fire({
                title: "Error!",
                text: "Las contraseñas no coinciden",
                icon: "error"
            });
            isValid = false;
        }

        // Validar DNI numérico y 8 dígitos
        if (!/^\d{8}$/.test($('#dni').val())) {
            $('#dni').addClass('is-invalid');
            Swal.fire({
                title: "Error!",
                text: "El DNI debe contener exactamente 8 dígitos numéricos",
                icon: "error"
            });
            isValid = false;
        }

        // Validar rol Doctor
        if ($('#rol').val() === 'Doctor' && 
            ($('#especialidad').val() === '' || $('#horario').val() === '')) {
            Swal.fire({
                icon: 'error',
                title: 'Campos requeridos',
                text: 'Para el rol de Doctor, especialidad y horario son obligatorios'
            });
            isValid = false;
        }

        if (!isValid) return false;

        // Crear objeto con los datos
        const formData = {
            Nombre: $('#nombre').val(),
            Apellido: $('#apellido').val(),
            DNI: $('#dni').val(),
            Correo: $('#correo').val(),
            Contrasena: $('#contrasena').val(),
            Telefono: $('#telefono').val(),
            Fecha_Nacimiento: $('#fecha_nacimiento').val(),
            Sexo: $('#sexo').val(),
            Direccion: $('#direccion').val(),
            Rol: $('#rol').val(),
            Estado: 'Activo',
            Especialidad: $('#especialidad').val() || null,
            Horario: $('#horario').val() || null
        };

        // Depuración
        console.log("Datos a enviar:", formData);

        $.ajax({
            url: '/gestion/public/user/',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function(response) {
                console.log("Respuesta:", response);
                // Mostrar mensaje de éxito siempre que llegue aquí
                Swal.fire({
                    title: "¡Registro exitoso!",
                    text: "El usuario ha sido registrado correctamente",
                    icon: "success",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    window.location.href = "/gestion/public/login";
                });
            },
            error: function(xhr) {
                console.error("Error:", xhr.responseText);
                let errorMsg = "Error al registrar el usuario";
                try {
                    const response = JSON.parse(xhr.responseText);
                    errorMsg = response.message || errorMsg;
                    if (response.errors) {
                        errorMsg = Object.values(response.errors).join('<br>');
                    }
                } catch(e) {
                    console.error("Error parseando respuesta:", e);
                }
                Swal.fire({
                    title: "Error!",
                    html: errorMsg,
                    icon: "error"
                });
            }
        });
    });

    // Manejo de campos de doctor
    $('#rol').change(function() {
        if ($(this).val() === 'Doctor') {
            $('.doctor-fields').show();
            $('#especialidad, #horario').prop('required', true);
        } else {
            $('.doctor-fields').hide();
            $('#especialidad, #horario').prop('required', false);
        }
    });
});