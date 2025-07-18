<?php

require dirname(__DIR__).'/vendor/autoload.php';
use App\Config\Errorlogs;
use App\Config\ResponseHTTP;
use App\Config\Security;

Errorlogs::activa_error_logs();
if(isset($_GET['route'])){
$url = explode('/',$_GET['route']); 
$lista = ['auth', 'user','reserva']; // lista de rutas permitidas
$file = dirname(__DIR__) . '/Src/Routes/' . $url[0] . '.php'; 

//require_once __DIR__ . '/../src/Routes/reserva.php'; //ajusta la ruta para encontrarla//

if(!in_array($url[0], $lista)){
		echo json_encode(ResponseHTTP::status404('La ruta no existe'));
         error_log('Esto es una prueba de error');
        exit; //finaliza 
	}

//validamos que el archivo exista y que es legible
    if(!file_exists($file) || !is_readable($file)){
        echo json_encode(ResponseHTTP::status404('El archivo no existe o no es legible'));
    }else{
        require $file;
        exit;
    }

    }else{
       echo json_encode(ResponseHTTP::status404());
    }

