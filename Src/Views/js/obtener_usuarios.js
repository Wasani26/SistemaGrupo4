let dataTableInstance; // Variable para mantener la instancia de DataTables

// La función `obtener_usuarios()` ahora procesa el array de datos directamente.
function obtener_usuarios(){
    const token = localStorage.getItem("Authorization");

    $("#body_usuarios").empty(); 
    $("#loading-message").show();

    // Si ya existe una instancia de Simple-DataTables, la destruimos antes de cargar nuevos datos.
    if (dataTableInstance) {
        dataTableInstance.destroy();
        console.log("Instancia de Simple-DataTables destruida.");
    }
    
    $.ajax({
        url: `http://localhost/sistemaGrupo4/Public/user/`,
        type: 'GET',
        headers: {
            "Authorization": token,
            "Accept": "application/json"
        },
        success: function(resp) {
            console.log("Respuesta de la API:", resp);
            
            $("#loading-message").hide();

            const tbody = $("#body_usuarios");
            tbody.empty(); 
            
            if (resp && Array.isArray(resp) && resp.length > 0) {
                // Iterar sobre los datos y construir las filas
                resp.forEach((info_usuario) => {
                    const fila = `
                        <tr>
                            <td>${info_usuario.nombre}</td>
                            <td>${info_usuario.correo}</td>
                            <td>${info_usuario.telefono}</td>
                            <td>${info_usuario.dni}</td>
                            <td>${info_usuario.fecha_nacimiento}</td>
                            <td>${info_usuario.nacionalidad}</td>
                            <td>${info_usuario.nombre_usuario}</td>
                            <td>
                                <img src="${info_usuario.url_foto}" alt="Foto de usuario" width="50" class="img-thumbnail">
                            </td>
                            <td>${info_usuario.tipo_rol}</td>
                            <td>${info_usuario.fecha_creacion}</td>
                            <td>${info_usuario.ultimo_acceso}</td>
                            <td>
                                <button class="btn btn-sm btn-info">Editar</button>
                                <button class="btn btn-sm btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    `;
                    tbody.append(fila);
                });
                
                // Inicializa DataTables con la API correcta, después de cargar los datos.
                try {
                    const datatablesSimple = document.getElementById('datatablesSimple');
                    dataTableInstance = new simpleDatatables.DataTable(datatablesSimple, {
                        // Opciones de configuración (puedes agregarlas aquí)
                    });
                    console.log("Simple-DataTables inicializado con nuevos datos.");
                } catch (e) {
                    console.error("Error al inicializar Simple-DataTables:", e);
                }
                
            } else {
                tbody.append(`
                    <tr>
                        <td colspan="12" style="text-align: center;">No hay usuarios registrados</td>
                    </tr>
                `);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error al conectar con el servidor:", textStatus, errorThrown);
            const tbody = $("#body_usuarios");
            tbody.empty();
            $("#loading-message").hide();
            tbody.append(`
                <tr>
                    <td colspan="12" style="text-align: center;">Error al cargar los usuarios</td>
                </tr>
            `);
        }
    });
}