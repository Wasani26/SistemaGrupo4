function form_usuarios(){
    let caso = "form_usuarios";
    $.ajax({
        url:'../funciones/formularios.php',
        type:'POST',
        data: {caso:caso},
        success: function(resp) {
            $("#layoutSidenav_content").html(resp);
            obtener_usuarios(); // ← aquí llamas después de insertar el HTML
        }
    });
}

function form_tours(){
    let caso = "form_tours";
    $.ajax({
        url:'../funciones/formularios.php',
        type:'POST',
        data: {caso:caso},
        success: function(resp) {
            $("#layoutSidenav_content").html(resp);
            //obtener_usuarios(); 
        }
    });
}

function form_museos(){
    let caso = "form_museos";
    $.ajax({
        url:'../funciones/formularios.php',
        type:'POST',
        data: {caso:caso},
        success: function(resp) {
            $("#layoutSidenav_content").html(resp);
            //obtener_usuarios(); 
        }
    });
}
