function login(){
    const nombre_usuario = $("#nombre_usuario").val();
    const contrasena = $("#contrasena").val();

    if(!nombre_usuario || !contrasena){
        alert('usuario o contrasena vacios');
        return false;
    }else{
        const url = `http://localhost/sistemaGrupo4/Public/auth/${nombre_usuario}/${contrasena}/`;
        $.ajax({
            url: url,
            type:"GET",
            dataType:"json",
            success:function(resp){
                if(resp){
                    alert('Entra en if');
                }else{
                    alert('Entra en else');
                }
               
                /*const result = JSON.parse(resp);
                window.location.href="../admin.php";*/
            }
        })
    }


}