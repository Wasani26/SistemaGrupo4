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
               
               //ACA COMENTADO SE MUESTRA UN ALERT CON EL TOKEN
               /* Swal.fire({ 
                                 title: "¡Éxito!",
                                 text:"Usuario logueado exitosamente",
                                 icon: "success"
                              })*/

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
                        /*alert (resultado.data);*/

                        if(resultado.success){
                              Swal.fire({
                                 title: "¡Éxito!",
                                 text:"Usuario logueado exitosamente",
                                 icon: "success"
                              });
                            if(resp.rol == "visitante"){;
                              window.location.href = "./funciones/dashboard.php";
                             }else{
                              window.location.href = "./funciones/dashboard.php";
                            } // validar todos los roles siendo primero el administrador
                             //más tarde darle vuelta al acceso segun rol siendo primero admin, guia y por ultimo (else) el de menu.php
                        }else{
                            alert('Error de sesión!');
                        }
                      
                    }
        
                })
               //alert(resp);
                var json = JSON.parse(resp);
               

                           
            },
            error: function (resp){
                Swal.fire({
                   title: "Usuario o contraseña incorrectas",
                   text: " ",
                   icon: "warning"
                 });
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

//función para cerrar mis sesiones
   function cerrar_sesion(){
    let caso = "cerrar_sesion";
    $.ajax({
        url:'../funciones/cerrar_sesion.php',
        type:'POST',           
        data: {caso:caso},
        success: function(resp) {
           
         window.location.href = "../auth.php";
        }
     });
   }

