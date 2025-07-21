$(document).ready(function() {
    $("#loginForm").submit(function(event) {
        event.preventDefault(); // Previene el envío del formulario por defecto

        let username = $("#yourUsername").val();
        let password = $("#yourPassword").val();
        var caso = "auth"; // Asumiendo que "caso" sigue siendo relevante para tu backend

        // Eliminar las clases de validación previas
        $("#yourUsername").removeClass("is-invalid is-valid");
        $("#yourPassword").removeClass("is-invalid is-valid");
        $(".invalid-feedback").hide();

        if (username !== "" && password !== "") {
            $.ajax({
                url: 'auth', // Asegúrate de que esta URL sea correcta para tu backend
                type: 'get', // Podrías considerar usar 'post' para credenciales por seguridad
                data: {
                    username: username,
                    password: password,
                    caso: caso
                },
                success: function(resp) {
                    Swal.fire({
                        title: "¡Buen trabajo!",
                        text: "Inicio de sesión exitoso.", // Cambiado para ser más descriptivo
                        icon: "success"
                    }).then(() => {
                        // Redirigir al usuario al menú después de un inicio de sesión exitoso
                        window.location.href = "http://localhost/sistemaGrupo4/Public/menu"; // Asegúrate de que "menu" sea la URL correcta
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: "Error al iniciar sesión",
                        text: "Hubo un problema al iniciar sesión. Por favor, verifica tus credenciales e inténtalo de nuevo.",
                        icon: "error"
                    });
                }
            });
        } else {
            // Mostrar mensajes de validación si los campos están vacíos
            if (username === "") {
                $("#yourUsername").addClass("is-invalid");
                $("#yourUsername").next(".invalid-feedback").text("Por favor, introduce tu nombre de usuario.").show();
            }
            if (password === "") {
                $("#yourPassword").addClass("is-invalid");
                $("#yourPassword").next(".invalid-feedback").text("¡Por favor, introduce tu contraseña!").show();
            }
            Swal.fire({
                title: "Campos incompletos",
                text: "Debes llenar todos los campos para iniciar sesión.",
                icon: "warning"
            });
        }
    });
});