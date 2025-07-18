<?php
use App\Controllers\UserController;
use App\Config\ResponseHTTP;
use App\Config;

$method = strtolower($_SERVER['REQUEST_METHOD']); //CAPTURA EL METODO HTTP
$route = $_GET['route']; //CAPTURA TAMBIEN LA RUTA 
$params = explode('/', $route); //explode de la ruta obteniendo un array cuando enviamos user/email/clave
$data = json_decode(file_get_contents("php://input"),true); //contiene data mediante metodos http excepto get
$headers = getallheaders(); //capturando todas las cabeceras que nos envian


$app = new UserController($method,$route,$params,$data,$headers); //instanciación
//llamada al metodo login con la ruta al recurso
//recordemos  que $params[0] contiene la ruta
//estos dos parametros corresponden al email y la contraseña
$app->login("auth/{$params[1]}/{$params[2]}/"); 


echo json_encode(ResponseHTTP::status404()); //ERROR EN CASO DE NO ENCONTRARSE LA RUTA

