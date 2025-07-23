<?php
use App\Controllers\UserController;
use App\Config\ResponseHTTP;
use App\Config;
//(">> Entrando a user.php <<");

$method = strtolower($_SERVER['REQUEST_METHOD']); //CAPTURA EL METODO HTTP
$route = $_GET['route']; //CAPTURA TAMBIEN LA RUTA 
$params = explode('/', $route); //explode de la ruta obteniendo un array cuando enviamos user/email/clave
$data = json_decode(file_get_contents("php://input"),true); //contiene data mediante metodos http excepto get
$headers = getallheaders(); //capturando todas las cabeceras que nos envian


$app = new UserController($method,$route,$params,$data,$headers); //instanciación
$app->crear_usuario_completo('user/'); //llamada a metodo post con la ruta/endpoint al recurso
$app->obtener_usuarios('user/'); //metodo para ver a todos los usuarios
$app->leer_usuario("user/{$params[1]}/"); //trae información de un solo usuario
$app->cambiar_contrasena("user/contrasena/");//metodo para actualizar la contraseñacambiar_contrasena

echo json_encode(ResponseHTTP::status404()); //ERROR EN CASO DE NO ENCONTRARSE LA RUTA