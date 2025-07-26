<?php

namespace App\Controllers;
use App\Config\ResponseHTTP;
use App\Config\Security;
use App\Models\TourModel;

class TourController{
     private $method;
    private $route;
    private $params;
    private $data;
    private $headers;

    
    public function __construct($method,$route,$params,$data,$headers){
        $this->method = $method;
        $this->route = $route;
        $this->params = $params;
        $this->data = $data;
        $this->headers = $headers;
    }

    final public function crear_tour($endpoint){
         if ($this->method === 'post' && $this->route === $endpoint) {
            $model = new TourModel();
            $response = $model->createTour($this->data);

            echo json_encode($response);
            exit;
        }

    }

    final public function leer_tour($endpoint){
        if ($this->method === 'get' && $this->params[0] === trim($endpoint, '/')) {
            $model = new TourModel();
            
            // Si se quiere un tour específico por ID
            if (isset($this->params[1])) {
                $response = $model->getTour($this->params[1]);
            } else {
                // Si no se pasa ID, lista todos
                $response = $model->getAllTours();
            }

            echo json_encode($response);
            exit;
        }

    }

    final public function actualizar_tour($endpoint){
         if ($this->method === 'put' && $this->params[0] === trim($endpoint, '/')) {
            if (isset($this->params[1])) {
                $model = new TourModel();
                $response = $model->updateTour($this->params[1], $this->data);

                echo json_encode($response);
                exit;
            }
        }

    }

    final public function eliminar_tour($endpoint){
        if ($this->method === 'delete' && $this->params[0] === trim($endpoint, '/')) {
            if (isset($this->params[1])) {
                $model = new TourModel();
                $response = $model->deleteTour($this->params[1]);

                echo json_encode($response);
                exit;
            }
        }

    }

    final public function cambiar_fecha($endpoint){
        if ($this->method === 'patch' && $this->route === $endpoint) {
            if (isset($this->params[1])) {
                $model = new TourModel();
                $response = $model->updateFecha($this->params[1], $this->data);

                echo json_encode($response);
                exit;
            }
        }

    }

    final public function cambiar_cupo($endpoint){
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