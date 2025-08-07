$("#loginForm").submit(function () {
    let user = $("#nombre_usuario").val();
    let clave = $("#contrasena").val();
    var caso = "login";
    if(user != "" && clave != ""){
        $.ajax({
            url: `http://localhost/sistemaGrupo4/Public/auth/${user}/${clave}/`,
            type: 'get',
            dataType: 'json',
            success: function (resp) {

               const token = resp.token;
               localStorage.setItem("Authorization", "Bearer " + token);
               
                alert (token);

                $.ajax({
                    url:"./funciones/sesion.php",
                    type: "POST",
                    contentType: "application/json",
                    headers: {"Authorization": "Bearer" + resp.token, "Accept": "application/json"},

                    data: JSON.stringify({
                        usuario: resp.usuario,
                        rol: resp.rol,
                        token: resp.token
                    }),
                    success: function(respuesta){
                        const resultado = JSON.parse(respuesta);
                        alert (resultado.data);

                        if(resultado.success){
                              alert("Usuario logueado exitosamente")
                            if(resp.rol == "visitante"){;
                              window.location.href = "./menu.php";
                             }else{
                              window.location.href = "admin.php";
                            } // validar todos los roles siendo primero el administrador
                             //más tarde darle vuelta al acceso segun rol siendo primero admin, guia y por ultimo (else) el de menu.php
                        }else{
                            alert('Error de sesión!');
                        }
                      
                    }
        
                })
               // alert(resp);
                var json = JSON.parse(resp);
               // alert(json.access);

                           
            },
            error: function (resp){
                alert ("Usuario o contraseña incorrectas");
            } 
        });
    }else{
        Swal.fire({
            title: "Debes llenar todos los campos!",
            text: " ",
            icon: "warning"
        });
    }
    return false;
});
