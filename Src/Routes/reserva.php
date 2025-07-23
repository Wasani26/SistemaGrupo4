<?php
use App\Controllers\ReservaController;
use App\Config\ResponseHTTP;

$method = strtolower($_SERVER['REQUEST_METHOD']); //CAPTURA EL METODO HTTP
$route = $_GET['route']; //CAPTURA TAMBIEN LA RUTA 
$params = explode('/', $route); //explode de la ruta obteniendo un array cuando enviamos user/email/clave
$data = json_decode(file_get_contents("php://input"),true); //contiene data mediante metodos http excepto get
$headers = getallheaders(); //capturando todas las cabeceras que nos envian

$app = new reservaController($method,$route,$params,$data,$headers); //instanciación
//ruta para crear reserva con POST// 
$app->post('/reserva', function() use ($reservaController){
    $reservaController->crear_reserva('/reserva');
}); 
//ruta para obtener las reservas con GET//
$app->get('/reserva', function() use ($reservaController){
    $reservaController->obtener_todas_reservas('/reserva');
});
//ruta para actualizar reservas con PUT//
$app->put('/reserva', function() use ($reservaController){
    $reservaController->actualizar_reserva('/reserva');
});
//ruta para eliminar reserva con DELETE//
$app->delete('/reserva', function() use ($reservaController){
    $reservaController->eliminar_reserva('/reserva');
});

echo json_encode(ResponseHTTP::status404()); //ERROR EN CASO DE NO ENCONTRARSE LA RUTA
?>