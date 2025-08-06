<?php
use App\Controllers\TourController;
use App\Config\ResponseHTTP;

error_log(">> Entrando a tour.php <<");

$method = strtolower($_SERVER['REQUEST_METHOD']); //CAPTURA EL METODO HTTP
$route = $_GET['route']; //CAPTURA TAMBIEN LA RUTA 
$params = explode('/', $route); //explode de la ruta obteniendo un array cuando enviamos user/email/clave
$data = json_decode(file_get_contents("php://input"),true); //contiene data mediante metodos http excepto get
var_dump($data);
exit;
$headers = getallheaders(); //capturando todas las cabeceras que nos envian


$app = new TourController($method,$route,$params,$data,$headers); //instanciación
$app->crear_tour('tour/'); //llamada a metodo post con la ruta/endpoint al recurso
$app->obtener_tour('tour/'); //metodo para ver a todos los usuarios
$app->leer_tour("tour/{$params[1]}/"); //trae información de un solo usuario
$app->actualizar_tour("tour/{$params[1]}/");
$app->eliminar_tour("tour/{$params[1]}/");
$app->cambiar_fecha("tour/{$params[1]}/");
$app->cambiar_cupo("tour/{$params[1]}/");


echo json_encode(ResponseHTTP::status404()); //ERROR EN CASO DE NO ENCONTRARSE LA RUTA