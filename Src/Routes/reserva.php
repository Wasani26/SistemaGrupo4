<?php
use App\Controllers\ReservaController;
use App\Config\ResponseHTTP;

$method = strtolower($_SERVER['REQUEST_METHOD']); //CAPTURA EL METODO HTTP
$route = $_GET['route']; //CAPTURA TAMBIEN LA RUTA 
$params = explode('/', $route); //explode de la ruta obteniendo un array cuando enviamos user/email/clave
$data = json_decode(file_get_contents("php://input"),true); //contiene data mediante metodos http excepto get
$headers = getallheaders(); //capturando todas las cabeceras que nos envian


$app = new ReservaController($method,$route,$params,$data,$headers); //instanciación

/*
//ruta para crear reserva con POST// 
$app->post('/reserva', function() use ($reservaController){
    $ReservaController->crear_reserva('/reserva');
}); 
//ruta para obtener las reservas con GET//
$app->get('/reserva', function() use ($reservaController){
    $ReservaController->obtener_todas_reservas('/reserva');
});
//ruta para actualizar reservas con PUT//
$app->put('/reserva', function() use ($reservaController){
    $ReservaController->actualizar_reserva('/reserva');
});
//ruta para eliminar reserva con DELETE//
$app->delete('/reserva', function() use ($reservaController){
    $ReservaController->eliminar_reserva('/reserva');
});*/



//Métodos llamados directamente según el recurso
$app->crear_reserva('reserva/');
/*
$app->obtener_todas_reservas('reserva/');
$app->actualizar_reserva("reserva/{$params[1]}/"); 
$app->eliminar_reserva("reserva/{$params[1]}/");
*/
echo json_encode(ResponseHTTP::status404()); //ERROR EN CASO DE NO ENCONTRARSE LA RUTA
?>