$("#loginForm").submit(function () {
    let user = $("#nombre_usuario").val();
    let clave = $("#contrasena").val();
    var caso = "login";
    if(user != "" && clave != ""){
        $.ajax({
            url: 'login',
            type: 'get',
            data: {usuario:user, clave:clave, caso:caso},
            success: function (resp) {
                //alert(resp);
                var json = JSON.parse(resp);
                //alert(json.access);
                if(json.access == 1){
                    window.location.href = "menu";
                }else{
                    window.location.href = "login";
                }                
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
