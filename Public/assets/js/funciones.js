$("#form_login").submit(function () {
    let correo = $("#correo").val();
    let contrasena = $("#contrasena").val();
    var caso = "login";
    if(correo != "" && contrasena != ""){
        $.ajax({
            url: 'login',
            type: 'get',
            data: {correo: correo, contrasena: contrasena, caso: caso},
            success: function (resp) {
                Swal.fire({
                    title: "Buen trabajo!",
                    text: "DATA: " + resp,
                    icon: "success"
                });
                // Redirigir al usuario al menú después de un inicio de sesión exitoso
                window.location.href = "menu";
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    title: "Error!",
                    text: "Hubo un problema al iniciar sesión. Por favor, inténtalo de nuevo.",
                    icon: "error"
                });
            }
        });
    } else {
        Swal.fire({
            title: "Debes llenar todos los campos!",
            text: " ",
            icon: "warning"
        });
    }
    return false;
});