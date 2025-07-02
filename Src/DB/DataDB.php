<?php

//Este archivo permite preparar los datos para la conexion

use App\Config\Errorlogs;
use App\Config\ResponseHTTP;
use App\DB\ConnectionDB;
use Dotenv\Dotenv;

//activación de configuración de errores
errorlogs::activa_error_logs();

//carga de las variables de entorno de nuestra conexión a la BD
$dotenv = Dotenv::createImmutable(dirname(__DIR__,2));
$dotenv->load();

//arreglo para pasar la cadena de caracteres para la conexión
$data = array(
    "user" => $_ENV['USER'],
    "password" => $_ENV['PASSWORD'],
    "DB" => $_ENV['DB'],
    "IP" => $_ENV['IP'],
    "port" => $_ENV['PORT']
);

//conexión a la base de datos llamando al metodo de la clase que retorna el objeto pdo
$host = 'mysql::host='.$data['IP'].';'.'port='.$data['port'].';'.'dbname='.$data['DB']; 

//se inicializa el objeto conexion
ConnectionDB::inicializar($host, $data['user'], $data['password']);