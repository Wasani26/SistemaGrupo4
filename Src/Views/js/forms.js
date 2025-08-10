
function form_usuarios(){
   
    let caso = "form_usuarios";
    $.ajax({
        url:'../funciones/formularios.php',
        type:'POST',           
        data: {caso:caso},
        success: function(resp) {
            $("#layoutSidenav_content").html(resp);
        }
     });
}