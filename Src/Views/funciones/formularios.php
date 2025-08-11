<?php

$caso = filter_input(INPUT_POST, "caso");
switch ($caso) {
    case 'form_usuarios':
        form_usuarios();
        break;
    case "form_tours":
        form_tours();
        break;
    case "form_museos":
        form_museos();
        break;
    default:
        break;
}



function form_usuarios(){
    $html = '';
    $html = '
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Gestión de Usuarios</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="admin.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Usuarios</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                    DataTables es un plugin de terceros que se utiliza para generar la tabla de demostración a continuación. Para obtener más información sobre DataTables, visite la
                    <a target="_blank" href="https://datatables.net/">documentación oficial de DataTables</a>
                    .
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Table Usuarios
                </div>
                <div class="card-body">
                    <div id="loading-message" class="text-center" style="display:none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p>Cargando datos de usuarios...</p>
                    </div>
                    
                    <table id="datatablesSimple" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                                <th>Dni</th>
                                <th>Nacimiento</th>
                                <th>Nacionalidad</th>
                                <th>Usuario</th>
                                <th>Foto</th>
                                <th>Rol</th>
                                <th>Creación</th>
                                <th>Ultimo Acceso</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                                <th>Dni</th>
                                <th>Nacimiento</th>
                                <th>Nacionalidad</th>
                                <th>Usuario</th>
                                <th>Foto</th>
                                <th>Rol</th>
                                <th>Creación</th>
                                <th>Ultimo Acceso</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                        <tbody id="body_usuarios">
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
        
    ';

    echo $html;
}

function form_tours(){
    // El HTML se genera directamente aquí.
    $html = '';
    $html = '
       <head> <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .tour-form-container { margin-top: 40px; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        .tour-form-container h2 { margin-top: 0; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .form-group button { padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .form-group button:hover { background-color: #0056b3; }
    </style></head>
    <body>
  <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Gestión de Tours</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="admin.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Tours</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                   <p>Modulo de Tours<p>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Table Usuarios
                </div>
                <div class="card-body">
                    <div id="loading-message" class="text-center" style="display:none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p>Cargando datos de Tours...</p>
                    </div>
                    
                    <table id="datatablesSimple" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                               <th>Nombre</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Hora_inicio</th>
                <th>Duracion</th>
                <th>Cupos</th>
                <th>Idioma</th>
                <th>Acciones</th>
                <th>Punto Encuentro</th>
                <th>Comentario</th>
                <th>Museo</th>
                <th>Usuario</th>
                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                               <th>Nombre</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Hora_inicio</th>
                <th>Duracion</th>
                <th>Cupos</th>
                <th>Idioma</th>
                <th>Acciones</th>
                <th>Punto Encuentro</th>
                <th>Comentario</th>
                <th>Museo</th>
                <th>Usuario</th>
                <th>Acciones</th>
                   <td>
                    <a href="#">Editar</a> | <a href="#">Eliminar</a>
                </td>
                            </tr>
                        </tfoot>
                        <tbody id="body_usuarios">
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <div class="tour-form-container">
        <h2>Crear Nuevo Tour</h2>
        <form action="#" method="post">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="hora_inicio">Hora de inicio</label>
                <input type="time" id="hora_inicio" name="hora_inicio" required>
            </div>
            <div class="form-group">
                <label for="duracion">Duración (en minutos)</label>
                <input type="number" id="duracion" name="duracion" required>
            </div>
            <div class="form-group">
                <label for="cupo_maximo">Cupo máximo</label>
                <input type="number" id="cupo_maximo" name="cupo_maximo" required>
            </div>
            <div class="form-group">
                <label for="idioma_tour">Idioma del tour</label>
                <input type="text" id="idioma_tour" name="idioma_tour" required>
            </div>
            <div class="form-group">
                <label for="punto_encuentro">Punto de encuentro</label>
                <input type="text" id="punto_encuentro" name="punto_encuentro" required>
            </div>
            <div class="form-group">
                <label for="comentario">Comentario</label>
                <textarea id="comentario" name="comentario" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="id_museo">ID del Museo</label>
                <input type="number" id="id_museo" name="id_museo" required>
            </div>
            <div class="form-group">
                <label for="id_usuario">ID del Usuario</label>
                <input type="number" id="id_usuario" name="id_usuario" required>
            </div>
            <div class="form-group">
                <button type="submit">Guardar Tour</button>
            </div>
        </form>
    </div>
    </body>
      <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        
    ';

    echo $html;
}

function form_museos(){
    $html = '';
    $html = '
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Gestión de Museos</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="admin.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Museos</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                    DataTables es un plugin de terceros que se utiliza para generar la tabla de demostración a continuación. Para obtener más información sobre DataTables, visite la
                    <a target="_blank" href="https://datatables.net/">documentación oficial de DataTables</a>
                    .
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Table Usuarios
                </div>
                <div class="card-body">
                    <div id="loading-message" class="text-center" style="display:none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p>Cargando datos de usuarios...</p>
                    </div>
                    
                    <table id="datatablesSimple" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                                <th>Dni</th>
                                <th>Nacimiento</th>
                                <th>Nacionalidad</th>
                                <th>Usuario</th>
                                <th>Foto</th>
                                <th>Rol</th>
                                <th>Creación</th>
                                <th>Ultimo Acceso</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                                <th>Dni</th>
                                <th>Nacimiento</th>
                                <th>Nacionalidad</th>
                                <th>Usuario</th>
                                <th>Foto</th>
                                <th>Rol</th>
                                <th>Creación</th>
                                <th>Ultimo Acceso</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                        <tbody id="body_museos">
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
        
    ';

    echo $html;
}


