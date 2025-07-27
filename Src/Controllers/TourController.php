<?php

namespace App\Controllers;

use App\Config\ResponseHTTP;
use App\Config\Security;
use App\Models\TourModel;

class TourController {
    private $method;
    private $route;
    private $params;
    private $data;
    private $headers;

    private static $validar_texto = '/^[\wÁÉÍÓÚáéíóúñÑ\s]{2,255}$/';
    private static $validar_precio = '/^\d+(\.\d{1,2})?$/';
    private static $validar_fecha = '/^\d{4}-\d{2}-\d{2}$/';
    private static $validar_hora = '/^\d{2}:\d{2}$/';
    private static $validar_numero = '/^\d+$/';

    public function __construct($method, $route, $params, $data, $headers) {
        $this->method = $method;
        $this->route = $route;
        $this->params = $params;
        $this->data = $data;
        $this->headers = $headers;
    }

    // Crear tour con validaciones
    final public function crear_tour($endpoint) {
        if ($this->method === 'post' && $this->route === $endpoint) {
            $data = $this->data;

            $campos_requeridos = ['nombre', 'descripcion', 'precio', 'fecha', 'hora_salida', 'cupo', 'id_idioma'];

            foreach ($campos_requeridos as $campo) {
                if (!isset($data[$campo]) || empty($data[$campo])) {
                    echo json_encode(ResponseHTTP::status400("El campo '$campo' es obligatorio."));
                    exit;
                }
            }

            // Validaciones de contenido
            if (!preg_match(self::$validar_texto, $data['nombre'])) {
                echo json_encode(ResponseHTTP::status400('Nombre inválido.'));
                exit;
            }

            if (!preg_match(self::$validar_texto, $data['descripcion'])) {
                echo json_encode(ResponseHTTP::status400('Descripción inválida.'));
                exit;
            }

            if (!preg_match(self::$validar_precio, $data['precio'])) {
                echo json_encode(ResponseHTTP::status400('Precio inválido.'));
                exit;
            }

            if (!preg_match(self::$validar_fecha, $data['fecha'])) {
                echo json_encode(ResponseHTTP::status400('Fecha inválida. Formato correcto: YYYY-MM-DD'));
                exit;
            }

            if (!preg_match(self::$validar_hora, $data['hora_salida'])) {
                echo json_encode(ResponseHTTP::status400('Hora inválida. Formato correcto: HH:MM'));
                exit;
            }

            if (!preg_match(self::$validar_numero, $data['cupo'])) {
                echo json_encode(ResponseHTTP::status400('Cupo inválido.'));
                exit;
            }

            if (!preg_match(self::$validar_numero, $data['id_idioma'])) {
                echo json_encode(ResponseHTTP::status400('ID de idioma inválido.'));
                exit;
            }

            // Crear el tour
            new TourModel($this->data);
            echo json_encode(TourModel::creartour());
            exit;
        }
    }

    final public function leer_tour($endpoint) {
        if ($this->method === 'get' && $this->params[0] === trim($endpoint, '/')) {
            $model = new TourModel();

            if (isset($this->params[1])) {
                $response = $model->getTour($this->params[1]);
            } else {
                $response = $model->getAllTours();
            }

            echo json_encode($response);
            exit;
        }
    }

    final public function actualizar_tour($endpoint) {
        if ($this->method === 'put' && $this->params[0] === trim($endpoint, '/')) {
            if (isset($this->params[1])) {
                $model = new TourModel();
                $response = $model->updateTour($this->params[1], $this->data);
                echo json_encode($response);
                exit;
            }
        }
    }

    final public function eliminar_tour($endpoint) {
        if ($this->method === 'delete' && $this->params[0] === trim($endpoint, '/')) {
            if (isset($this->params[1])) {
                $model = new TourModel();
                $response = $model->deleteTour($this->params[1]);
                echo json_encode($response);
                exit;
            }
        }
    }

    final public function cambiar_fecha($endpoint) {
        if ($this->method === 'patch' && $this->route === $endpoint) {
            if (isset($this->params[1])) {
                $model = new TourModel();
                $response = $model->updateFecha($this->params[1], $this->data);
                echo json_encode($response);
                exit;
            }
        }
    }

    final public function cambiar_cupo($endpoint) {
        if ($this->method === 'patch' && $this->route === $endpoint) {
            if (isset($this->params[1])) {
                $model = new TourModel();
                $response = $model->updateCupo($this->params[1], $this->data);
                echo json_encode($response);
                exit;
            }
        }
    }
}