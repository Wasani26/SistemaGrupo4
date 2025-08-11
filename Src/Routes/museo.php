<?php
use App\Config\ResponseHTTP;
use App\Config;
use App\Controllers\MuseoController;

//error_log(">> Entrando a MUSEO.php <<");

$method = strtolower($_SERVER['REQUEST_METHOD']); //CAPTURA EL METODO HTTP
$route = $_GET['route']; //CAPTURA TAMBIEN LA RUTA 
$params = explode('/', $route); //explode de la ruta obteniendo un array cuando enviamos user/email/clave
$data = json_decode(file_get_contents("php://input"),true); //contiene data mediante metodos http excepto get
$headers = getallheaders(); //capturando todas las cabeceras que nos envian


$app = new MuseoController($method,$route,$params,$data,$headers); //instanciación
$app->crear_museo("museo/"); //llamada a metodo post con la ruta/endpoint al recurso
$app->leer_museo("museo/"); //metodo para ver a todos los usuarios
$app->ver_museos("museo/"); //trae información de un solo usuario
$app->actualizar_museo("museo/");//metodo para actualizar la contraseñacambiar_contrasena
$app->eliminar_museo("museo/");

echo json_encode(ResponseHTTP::status404()); //ERROR EN CASO DE NO ENCONTRARSE LA RUTA