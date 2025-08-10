<?php

$caso = filter_input(INPUT_POST, "caso");
switch ($caso) {
    case "form_usuarios":
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
    // El HTML se genera directamente aquí.
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
    $html = '
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Gestión de Tours</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="admin.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Tours</li>
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
                        <p>Cargando datos de tours...</p>
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
                        <tbody id="body_tours">
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
        
    ';

    echo $html;
}

function form_museos(){
    // El HTML se genera directamente aquí.
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


