<?php
// Src/Routes/dashboard.php

use App\Config\ResponseHTTP;

// --- Simulación de Base de Datos en Memoria ---
// Estos arrays simulan las tablas de tu base de datos para el proyecto
$users_db = [
    "admin_user" => ["password" => "admin_password", "role" => "admin"],
    "guide_user" => ["password" => "guide_password", "role" => "guide"],
    "regular_user" => ["password" => "user_password", "role" => "user"],
];

$tours_db = [
    ["id" => 1, "name" => "Arte Precolombino", "price" => 25.00, "duration_minutes" => 90],
    ["id" => 2, "name" => "Maestros del Renacimiento", "price" => 30.00, "duration_minutes" => 120],
    ["id" => 3, "name" => "Exposición de Arte Moderno", "price" => 20.00, "duration_minutes" => 60],
    ["id" => 4, "name" => "Historia del Museo", "price" => 15.00, "duration_minutes" => 45],
];

$bookings_db = [
    ["id" => 1, "tour_id" => 1, "user_id" => "regular_user", "purchase_date" => "2025-07-10", "quantity" => 1],
    // ... (rest of your bookings data) ...
];

// --- Funciones de Autenticación y Endpoints del Dashboard ---
// (Aquí irían tus funciones get_kpis, get_sales_by_date, get_popular_tours)
// El código de estas funciones es exactamente el mismo que el de tu programa original.

// --- Enrutador del Dashboard ---
$dashboard_route = $url[1] ?? null;
$request_method = $_SERVER['REQUEST_METHOD'];

if ($dashboard_route === 'kpis' && $request_method === 'GET') {
    get_kpis($users_db, $tours_db, $bookings_db);
} elseif ($dashboard_route === 'sales-by-date' && $request_method === 'GET') {
    get_sales_by_date($users_db, $tours_db, $bookings_db);
} elseif ($dashboard_route === 'popular-tours' && $request_method === 'GET') {
    get_popular_tours($users_db, $tours_db, $bookings_db);
} else {
    echo json_encode(ResponseHTTP::status404('Sub-ruta de dashboard no encontrada'));
}

exit;
?>
