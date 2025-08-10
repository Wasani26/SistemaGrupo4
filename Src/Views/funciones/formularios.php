<?php

 $caso = filter_input(INPUT_POST, "caso");

 switch ($caso) {
    case "form_usuarios":
        form_usuarios();        
        break;
    default:
        break;
}

function form_usuarios(){
    $html = '';
    
    $html = '
     <script>
            $(document).ready(function () {
                obtener_usuarios();
            });
        </script>
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Tables</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the
                                <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>
                                .
                            </div>
                        </div>
    <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Table Usuario
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
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