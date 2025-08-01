<?php
// Src/Routes/dashboard.php

namespace App\Modelos;

use App\SQL;
use App\ConnectionDB;
use App\Config\ResponseHTTP;
use Appp\Config\Security;

class DashboardModel {
    public function __construct() {
    }

    public function getDashboardMetrics(): array {
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
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $dashboard = new DashboardModel();
        $dashboardData = $dashboard->getDashboardMetrics();
        echo Respuesta HTTP::status200('Datos del dashboard obtenidos con éxito', $dashboardData);
    } catch (Exception $e) {
        echo Respuesta HTTP::status500('Error al obtener datos del dashboard: ' . $e->getMessage());
    }
} else {
    echo Respuesta HTTP::status405();
}
