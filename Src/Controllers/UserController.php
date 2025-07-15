<?php

namespace App\Controllers;

class UserController{
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

    //metodo que recibe un endpoint (ruta a un recurso)
    final public function crear_usuario($endpoint){
        //validamos el method y el endpoint
        if($this->method == 'post' && $endpoint == $this->route){
            echo json_encode('post');
            exit;
        }
    }

    
    final public function cambiar_contrasena($endpoint){
    // validamos el método y el endpoint
    if($this->method == 'patch' && $endpoint == $this->route){
        echo json_encode('patch');
        exit;
       }
    }

    
    final public function actualizar_usuario($endpoint){
    // validamos el método y el endpoint
    if($this->method == 'put' && $endpoint == $this->route){
        echo json_encode('put');
        exit;
       }
    }

    // lee un usuario solo
    final public function leer_usuario($endpoint){
    // validamos el método y el endpoint
    if($this->method == 'get' && $endpoint == $this->route){
        echo json_encode('get');
        exit;
      }
    }
  
    
    //permite ver todos los usuarios
    final public function obtener_usuario($endpoint){
    // validamos el método y el endpoint
    if($this->method == 'get' && $endpoint == $this->route){
        echo json_encode('get');
        exit;
      }
    }
   
    


}