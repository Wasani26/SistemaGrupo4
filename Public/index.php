<?php

require dirname(__DIR__).'/vendor/autoload.php';
use App\Config\Errorlogs;
use App\Config\ResponseHTTP;
use App\Config\Security;

Errorlogs::activa_error_logs();

if(isset($_GET['route'])){
    $url = explode('/',$_GET['route']);
    
    // --- INICIO DE CAMBIO CLAVE ---
    // Limpiamos el segmento de la ruta: removemos la extensión .php si está presente
    $requested_route_segment = $url[0];
    if (str_ends_with($requested_route_segment, '.php')) {
        $requested_route_segment = str_replace('.php', '', $requested_route_segment);
    }
    // --- FIN DE CAMBIO CLAVE ---

    // Lista de rutas permitidas, ahora incluyendo 'registro_usuario'
    $lista = ['auth', 'user', 'reserva', 'registro_usuario']; 

    // Define paths for both API routes and direct view files
    // Usamos $requested_route_segment para los nombres de archivo
    $file_route = dirname(__DIR__) . '/Src/Routes/' . $requested_route_segment . '.php'; // Para rutas de API
    $file_view_public = dirname(__DIR__) . '/Public/' . $requested_route_segment . '.php'; // Para vistas directas en Public

    // Primero, verifica si la ruta solicitada (limpia y sin .php) está en nuestra lista de permitidas
    if(!in_array($requested_route_segment, $lista)){
        echo json_encode(ResponseHTTP::status404('La ruta no existe.'));
        error_log('Error: Ruta no permitida solicitada: ' . $_GET['route']); // Log completo de la ruta para depuración
        exit;
    }

    // Si la ruta limpia es 'registro_usuario', la manejamos como una vista HTML directamente desde Public/
    if ($requested_route_segment === 'registro_usuario') {
        // Aseguramos que estamos buscando el nombre real del archivo con la extensión .php
        $actual_file_to_require = dirname(__DIR__) . '/Public/registro_usuario.php'; 
        if (file_exists($actual_file_to_require) && is_readable($actual_file_to_require)) {
            require $actual_file_to_require; // Incluye el archivo HTML/PHP de la vista
            exit; // Importante: salir después de servir la vista
        } else {
            // Si el archivo registro_usuario.php no se encuentra en Public/
            echo json_encode(ResponseHTTP::status404('El archivo de vista registro_usuario.php no existe o no es legible en Public/.'));
            error_log('Error: Archivo de vista registro_usuario.php no encontrado o no legible en Public/.'); 
            exit;
        }
    }
    // Si no es 'registro_usuario', entonces lo manejamos como una ruta de API normal
    else {
        if(!file_exists($file_route) || !is_readable($file_route)){
            echo json_encode(ResponseHTTP::status404('El archivo de ruta de API no existe o no es legible.'));
            error_log('Error: Archivo de ruta de API no encontrado o no legible: ' . $file_route); 
        } else {
            require $file_route; 
        }
        exit; 
    }

} else {
    echo json_encode(ResponseHTTP::status404('Ruta no especificada.'));
    error_log('Error: No se especificó ninguna ruta en la URL.'); 
}