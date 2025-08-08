<?php
// Src/Controllers/DashboardController.php

namespace App\Controllers;

use App\Config\ResponseHTTP;
use App\Config\Security;
use App\Modelos\DashboardModel;
use PDO;

class DashboardController
{
    private $dashboardModel;
    private $method;
    private $route;
    private $params;
    private $data;
    private $headers;

    /**
     * Constructor del DashboardController.
     * Inicializa el modelo y captura los datos de la solicitud HTTP.
     *
     * @param string $method El método HTTP de la solicitud (GET, POST, etc.).
     * @param string $route La ruta de la solicitud (ej. 'dashboard/metrics').
     * @param array $params Los parámetros de la ruta.
     * @param array|null $data Los datos enviados en el cuerpo de la solicitud (para POST/PUT).
     * @param array $headers Las cabeceras de la solicitud.
     */
    public function __construct($method, $route, $params, $data, $headers)
    {
        $this->method = $method;
        $this->route = $route;
        $this->params = $params;
        $this->data = $data;
        $this->headers = $headers;

        $this->dashboardModel = new DashboardModel();
    }

    /**
     * Obtiene todas las métricas del dashboard (usuarios, ingresos, tours).
     * Corresponde a la ruta GET /dashboard/metrics.
     * Permite especificar el número de meses con un parámetro de consulta 'months'.
     * Ejemplo: GET /dashboard/metrics?months=12
     */
    public function getMetrics()
    {
        if ($this->method === 'get') {
            try {
                $monthsCount = isset($_GET['months']) ? (int)$_GET['months'] : 6;
                if ($monthsCount <= 0) {
                    $monthsCount = 6;
                }

                $metrics = $this->dashboardModel->getDashboardMetrics();

                ResponseHTTP::status200($metrics);
            } catch (\Exception $e) {
                error_log("Error en DashboardController::getMetrics: " . $e->getMessage());
                ResponseHTTP::status500();
            }
        } else {
            ResponseHTTP::status405();
        }
    }

    /**
     * Obtiene el total de usuarios registrados.
     * Corresponde a la ruta GET /dashboard/users.
     */
    public function getTotalUsers()
    {
        if ($this->method === 'get') {
            try {
                $totalUsers = $this->dashboardModel->getTotalRegisteredUsers();
                ResponseHTTP::status200(['total_users' => $totalUsers]);
            } catch (\Exception $e) {
                error_log("Error en DashboardController::getTotalUsers: " . $e->getMessage());
                ResponseHTTP::status500();
            }
        } else {
            ResponseHTTP::status405();
        }
    }

    /**
     * Obtiene los ingresos mensuales por tours.
     * Corresponde a la ruta GET /dashboard/revenue.
     * Permite especificar el número de meses con un parámetro de consulta 'months'.
     * Ejemplo: GET /dashboard/revenue?months=12
     */
    public function getMonthlyRevenue()
    {
        if ($this->method === 'get') {
            try {
                $monthsCount = isset($_GET['months']) ? (int)$_GET['months'] : 6;
                if ($monthsCount <= 0) {
                    $monthsCount = 6;
                }

                $revenueData = $this->dashboardModel->getMonthlyTourRevenue($monthsCount);
                ResponseHTTP::status200($revenueData);
            } catch (\Exception $e) {
                error_log("Error en DashboardController::getMonthlyRevenue: " . $e->getMessage());
                ResponseHTTP::status500();
            }
        } else {
            ResponseHTTP::status405();
        }
    }

    /**
     * Obtiene el conteo mensual de tours registrados.
     * Corresponde a la ruta GET /dashboard/tours-count.
     * Permite especificar el número de meses con un parámetro de consulta 'months'.
     * Ejemplo: GET /dashboard/tours-count?months=12
     */
    public function getMonthlyToursCount()
    {
        if ($this->method === 'get') {
            try {
                $monthsCount = isset($_GET['months']) ? (int)$_GET['months'] : 6;
                if ($monthsCount <= 0) {
                    $monthsCount = 6;
                }

                $toursData = $this->dashboardModel->getMonthlyRegisteredTours($monthsCount);
                ResponseHTTP::status200($toursData);
            } catch (\Exception $e) {
                error_log("Error en DashboardController::getMonthlyToursCount: " . $e->getMessage());
                ResponseHTTP::status500();
            }
        } else {
            ResponseHTTP::status405();
        }
    }
}
