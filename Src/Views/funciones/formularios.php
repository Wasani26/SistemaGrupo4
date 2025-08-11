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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
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
                            </tr>
                        </tfoot>
                        <tbody id="body_tours">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                         <td>
                     <a href="#">Editar</a> | <a href="#">Eliminar</a>
                     </td>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <div class="tour-form-container">
       <div class="tour-form-container">
    <h2>Crear Nuevo Tour</h2>
    <form id="form_tours" action="#" method="post">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="4"></textarea>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha (DD-MM-AAAA)</label>
            <input type="text" id="fecha" name="fecha" required placeholder="Ej: 27-10-2025">
        </div>
        <div class="form-group">
            <label for="hora_inicio">Hora de inicio (HH:MM)</label>
            <input type="text" id="hora_inicio" name="hora_inicio" required placeholder="Ej: 14:30">
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
            <label for="idioma_tour">ID del Idioma</label>
            <input type="number" id="idioma_tour" name="idioma_tour" required>
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
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="../js/tours.js"></script>
    ';

    echo $html;
}

function form_museos(){
    $html = '';
    $html = '
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Museos</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .museo-form-container { margin-top: 40px; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        .museo-form-container h2 { margin-top: 0; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .form-group button { padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .form-group button:hover { background-color: #0056b3; }
        .spinner-border { width: 3rem; height: 3rem; }
    </style>
</head>
<body>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Gestión de Museos</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="admin.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Museos</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <p>Módulo de Museos</p>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla de Museos
            </div>
            <div class="card-body">
                <div id="loading-message" class="text-center" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p>Cargando datos de Museos...</p>
                </div>
                
                <table id="datatablesSimple" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Inauguración</th>
                            <th>Horario</th>
                            <th>Dirección</th>
                            <th>Coordenadas</th>
                            <th>Ubicación ID</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="body_museos">
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<div class="museo-form-container">
    <h2>Crear Nuevo Museo</h2>
    <form id="form_museos" action="#" method="post">
        <div class="form-group">
            <label for="nombre_museo">Nombre del Museo</label>
            <input type="text" id="nombre_museo" name="nombre_museo" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="4"></textarea>
        </div>
        <div class="form-group">
            <label for="tipo_de_museo">Tipo de Museo</label>
            <input type="text" id="tipo_de_museo" name="tipo_de_museo">
        </div>
        <div class="form-group">
            <label for="inauguracion">Inauguración</label>
            <input type="text" id="inauguracion" name="inauguracion" placeholder="Ej: AAAA">
        </div>
        <div class="form-group">
            <label for="horario">Horario</label>
            <input type="text" id="horario" name="horario">
        </div>
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <textarea id="direccion" name="direccion" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="coordenadas">Coordenadas</label>
            <input type="text" id="coordenadas" name="coordenadas">
        </div>
        <div class="form-group">
            <label for="id_ubicacion">ID de Ubicación</label>
            <input type="number" id="id_ubicacion" name="id_ubicacion" required>
        </div>
        <div class="form-group">
            <button type="submit">Guardar Museo</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/museos.js"></script>
</body>
        
    ';

    echo $html;
}


