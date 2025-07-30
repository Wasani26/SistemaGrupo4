<?php

namespace App\Controllers;
use App\Config\ResponseHTTP;
use App\Config\Security;
use App\Models\MuseoModel; 

Class MuseoController {
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
    final public  function crear_museo ($endpoint) {
    if($this->method == 'post' && $endpoint == $this->route){}
             
    }
     final public  function leer_museo ($endpoint) {
        if($this->method == 'get' && $endpoint == $this->route){}
             
    }
      final public  function ver_museos ($endpoint) {
        if($this->method == 'get' && $endpoint == $this->route){}
             
    }
    final public  function actualizar_museo ($endpoint) {
        if($this->method == 'put' && $endpoint == $this->route){}
             
    }
   final public  function eliminar_museo ($endpoint) {
        if($this->method == 'delete' && $endpoint == $this->route){}
             
    }
}
