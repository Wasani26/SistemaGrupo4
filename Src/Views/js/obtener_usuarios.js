let dataTableInstance; // Mantiene la instancia de Simple-DataTables

function obtener_usuarios() {
    console.log("Función obtener_usuarios ejecutada");

    const token = localStorage.getItem("Authorization");
    $("#loading-message").show();

    // Si ya hay una instancia previa, destruirla y limpiar el tbody
    if (dataTableInstance) {
        dataTableInstance.destroy();
        dataTableInstance = null;
        document.querySelector("#body_usuarios").innerHTML = "";
        console.log("Instancia previa de Simple-DataTables destruida.");
    }

    $.ajax({
        url: "http://localhost/sistemaGrupo4/Public/user/",
        type: "GET",
        headers: {
            "Authorization": token,
            "Accept": "application/json"
        },
        success: function (resp) {
            console.log("Respuesta de la API:", resp);
            $("#loading-message").hide();

            const usuarios = resp.data || [];

            if (usuarios.length === 0) {
                mostrarMensajeVacio("No hay usuarios registrados");
                return;
            }

            const tableData = usuarios.map(info_usuario => [
                info_usuario.nombre,
                info_usuario.correo,
                info_usuario.telefono,
                info_usuario.dni,
                info_usuario.fecha_nacimiento,
                info_usuario.nacionalidad,
                info_usuario.nombre_usuario,
                `<img src="${info_usuario.url_foto || 'assets/img/default.png'}" alt="Foto de usuario" width="50" class="img-thumbnail">`,
                info_usuario.tipo_rol,
                info_usuario.fecha_creacion,
                info_usuario.ultimo_acceso,
                `<button class="btn btn-sm btn-info">Editar</button> 
                 <button class="btn btn-sm btn-danger">Eliminar</button>`
            ]);

            try {
                const datatablesSimple = document.getElementById("datatablesSimple");
                dataTableInstance = new simpleDatatables.DataTable(datatablesSimple, {
                    data: {
                        headings: [
                            "Nombre", "Correo", "Telefono", "Dni", "Nacimiento",
                            "Nacionalidad", "Usuario", "Foto", "Rol",
                            "Creación", "Ultimo Acceso", "Acciones"
                        ],
                        data: tableData
                    }
                });
                console.log("Tabla inicializada correctamente con Simple-DataTables.");
            } catch (error) {
                console.error("Error al inicializar Simple-DataTables:", error);
                mostrarDatosSinDataTable(usuarios);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error al conectar con el servidor:", textStatus, errorThrown);
            $("#loading-message").hide();
            mostrarMensajeVacio("Error al cargar los usuarios");
        }
    });
}

// Muestra un mensaje ocupando toda la fila
function mostrarMensajeVacio(mensaje) {
    $("#body_usuarios").html(`
        <tr>
            <td colspan="12" style="text-align: center;">${mensaje}</td>
        </tr>
    `);
}
