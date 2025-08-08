<?php
// Este archivo sería tu enrutador principal, por ejemplo, index.php o router.php

// Importa las clases de controladores y configuración necesarias
use App\Config\ResponseHTTP;
use App\Controllers\DashboardController;
// Si tienes otros controladores, impórtalos aquí también, por ejemplo:
// use App\Controllers\ReservaController;
// use App\Controllers\UserController;
// use App\Controllers\TourController;
// use App\Controllers\BookingController;


$method = strtolower($_SERVER['REQUEST_METHOD']);
$route = $_GET['route'] ?? '';
$params = explode('/', $route);
$data = json_decode(file_get_contents("php://input"), true);
$headers = getallheaders();

// --- Lógica de Enrutamiento Principal ---

// Verifica si la primera parte de la ruta es 'dashboard'
if (isset($params[0]) && $params[0] === 'dashboard') {
    // Instancia el DashboardController, pasándole los datos de la solicitud
    $dashboardApp = new DashboardController($method, $route, $params, $data, $headers);

    // Rutas GET para obtener métricas del dashboard
    if ($method === 'get') {
        // Ruta para obtener todas las métricas combinadas
        // Ejemplo de URL: GET /dashboard/metrics
        if ($route === 'dashboard/metrics') {
            $dashboardApp->getMetrics();
        }
        // Ruta para obtener el total de usuarios registrados
        // Ejemplo de URL: GET /dashboard/users
        elseif ($route === 'dashboard/users') {
            $dashboardApp->getTotalUsers();
        }
        // Ruta para obtener los ingresos mensuales de tours
        // Ejemplo de URL: GET /dashboard/revenue o GET /dashboard/revenue?months=12
        elseif ($route === 'dashboard/revenue') {
            $dashboardApp->getMonthlyRevenue();
        }
        // Ruta para obtener el conteo mensual de tours registrados
        // Ejemplo de URL: GET /dashboard/tours-count o GET /dashboard/tours-count?months=3
        elseif ($route === 'dashboard/tours-count') {
            $dashboardApp->getMonthlyToursCount();
        }
        // Si la ruta 'dashboard' existe pero no coincide con ninguna sub-ruta GET definida
        else {
            echo json_encode(ResponseHTTP::status404()); // Recurso no encontrado dentro de dashboard
        }
    }
    // Si el método HTTP no es GET para una ruta de dashboard
    else {
        echo json_encode(ResponseHTTP::status405()); // Método no permitido
    }
}

// Si ninguna de las rutas principales coincide, devuelve un error 404
else {
    echo json_encode(ResponseHTTP::status404());
}
?>
