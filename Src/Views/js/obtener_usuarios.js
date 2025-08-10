
function obtener_usuarios(){

 const token = localStorage.getItem("Authorization");

    $.ajax({
        url: `http://localhost/sistemaGrupo4/Public/user/`,
        type: 'GET',
        headers: {
            "Authorization": token,
            "Accept": "application/json"
        },
        success: function(resp) {
            // El selector para el tbody debe ser con el símbolo de almohadilla (#)
            // si es un ID o un punto (.) si es una clase.
            const tbody = $("#body_usuarios");

            // Limpiar el contenido actual de la tabla
            tbody.empty();

            // Verificar si la respuesta y la propiedad 'data' existen y si 'data' es un array no vacío
            if (resp && resp.data && Array.isArray(resp.data) && resp.data.length > 0) {
                // Iterar directamente sobre el array 'data' que contiene los usuarios
                console.log(resp.data);
                resp.data.forEach((info_usuario, index) => {
                    const fila = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${info_usuario.nombre}</td>
                            <td>${info_usuario.correo}</td>
                            <td>${info_usuario.telefono}</td>
                            <td>${info_usuario.dni}</td>
                            <td>${info_usuario.fecha_nacimiento}</td>
                            <td>${info_usuario.naciionalidad}</td>
                            <td>${info_usuario.url_foto}</td>
                            <td>${info_usuario.tipo_rol}</td>
                            <td>${info_usuario.fecha_creacion}</td>
                            <td>${info_usuario.ultimo_acceso}</td>
                        </tr>
                    `;
                    tbody.append(fila);
                });
            } else {
                // Manejar el caso de que no haya usuarios o la respuesta sea inesperada
                tbody.append(`
                    <tr>
                        <td colspan="4" style="text-align: center;">No hay usuarios registrados</td>
                    </tr>
                `);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error al conectar con el servidor:", textStatus, errorThrown);
            const tbody = $("#body_usuarios");
            tbody.empty();
            tbody.append(`
                <tr>
                    <td colspan="4" style="text-align: center;">Error al cargar los usuarios</td>
                </tr>
            `);
        }
    });
 }

 
