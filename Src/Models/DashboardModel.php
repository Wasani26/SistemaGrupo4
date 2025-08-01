<?php
// Src/Routes/dashboard.php

function getDashboardData() {
    $months = [];
    $userRegistrations = [];
    $tourRevenue = [];
    $monthlyTours = [];

    for ($i = 5; $i >= 0; $i--) {
        $month = date('M Y', strtotime("-$i months"));
        $months[] = $month;
        $userRegistrations[] = rand(50 + $i * 10, 150 + $i * 20);
        $tourRevenue[] = rand(1000 + $i * 200, 5000 + $i * 500);
        $monthlyTours[] = rand(5 + $i * 1, 20 + $i * 2);
    }

    $data = [
        'userRegistrations' => [
            'labels' => $months,
            'data' => $userRegistrations
        ],
        'tourRevenue' => [
            'labels' => $months,
            'data' => $tourRevenue
        ],
        'monthlyTours' => [
            'labels' => $months,
            'data' => $monthlyTours
        ]
    ];

    return $data;
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $dashboardData = getDashboardData();
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'Datos del dashboard obtenidos con éxito',
            'data' => $dashboardData
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error al obtener datos del dashboard: ' . $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
}
