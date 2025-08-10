let dataTableInstance; // Mantiene la instancia de DataTables

function obtener_usuarios() {
    console.log("Función obtener_usuarios ejecutada");

    const token = localStorage.getItem("Authorization");
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
        success: function (resp) {
            console.log("Respuesta de la API:", resp);
            $("#loading-message").hide();

            // Detecta si los datos están en resp.data o en resp
            let usuarios = {};
            if (resp && Array.isArray(resp.data)) {
                usuarios = resp.data;
            } else if (Array.isArray(resp)) {
                usuarios = resp;
            }

            if (usuarios.length > 0) {
                // Prepara los datos para Simple-DataTables
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

                // Limpia el tbody antes de inicializar la tabla
                $("#body_usuarios").empty();

                try {
                    const datatablesSimple = document.getElementById('datatablesSimple');
                    dataTableInstance = new simpleDatatables.DataTable(datatablesSimple, {
                        data: {
                            headings: ["Nombre", "Correo", "Telefono", "Dni", "Nacimiento", "Nacionalidad", "Usuario", "Foto", "Rol", "Creación", "Ultimo Acceso", "Acciones"],
                            data: tableData
                        }
                    });
                    console.log("Simple-DataTables inicializado con nuevos datos.");
                } catch (e) {
                    console.error("Error al inicializar Simple-DataTables:", e);
                    mostrarDatosSinDataTable(usuarios);
                }

            } else {
                $("#body_usuarios").html(`
                    <tr>
                        <td colspan="12" style="text-align: center;">No hay usuarios registrados</td>
                    </tr>
                `);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error al conectar con el servidor:", textStatus, errorThrown);
            $("#loading-message").hide();
            $("#body_usuarios").html(`
                <tr>
                    <td colspan="12" style="text-align: center;">Error al cargar los usuarios</td>
                </tr>
            `);
        }
    });
}

// Función de respaldo si Simple-DataTables falla
function mostrarDatosSinDataTable(data) {
    const tbody = $("#body_usuarios");
    tbody.empty();
    data.forEach(info_usuario => {
        const fila = `
            <tr>
                <td>${info_usuario.nombre}</td>
                <td>${info_usuario.correo}</td>
                <td>${info_usuario.telefono}</td>
                <td>${info_usuario.dni}</td>
                <td>${info_usuario.fecha_nacimiento}</td>
                <td>${info_usuario.nacionalidad}</td>
                <td>${info_usuario.nombre_usuario}</td>
                <td><img src="${info_usuario.url_foto || 'assets/img/default.png'}" alt="Foto de usuario" width="50" class="img-thumbnail"></td>
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
    console.log("Datos mostrados manualmente (fallo en la inicialización de Simple-DataTables).");
}
