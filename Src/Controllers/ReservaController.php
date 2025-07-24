<?php
namespace App\Controllers; //nombre de espacio//
use App\Config\ResponseHTTP; 
use App\Config\Security;
use App\Models\ReservaModel;

class ReservaController {
    private $method; //Propiedad del metodo HTTP//
    private $route; //Propiedad para ruta//
    private $params; //Propiedad para URL//
    private $data; //Propiedad para cuerpo//
    private $headers; //Propiedad para cabecera HTTP//


    //Constructor para iniciar los metodos//
    public function __construct($method,$route,$params,$data,$headers){
        $this ->method = strtolower($method);
        $this ->route = $route;
        $this->params = $params;
        $this->data = $data;
        $this->headers = $headers;
    }

    //Metodo POST para crear reserva//
    final public function crear_reserva ($endpoint){

        //Validacion para el metodo POST//
        if($this->method == 'post' && $endpoint == $this->route){
          $reserva = new ReservaModel($this->data);
          echo json_encode($reserva->crear_reserva());
            exit;
        }
        /*else{
            echo json_encoe(ResposeHTTP::methodNotAllowed());
            exit;
        }*/
    }

    //Metodo GET para obtener las reservas//
    final public function obtener_todas_reservas($endpoint){
        //Validacion para el metodo GET// 
        if($this->method == 'get' && $endpoint == $this->route){
            echo json_encode('Obtener todas las reservas - GET');
            exit;
        }
    }

    //Metodo PUT para actualizar reserva//
    final public function actualizar_reserva ($endpoint){
        //Validacion para el metodo PUT//
        if($this->method == 'put' && strpos($this->route, $endpoint) ===0){
            echo json_encode('Actualizar reserva - PUT');
            exit;
        }
    }

    //Metodo DELETE para eliminar reserva//
    final public function eliminar_reserva($endpoint){
        //Validacion para el metodo DELETE//
        if($this->method == 'delete' && strpos($this->route, $endpoint) === 0){
            echo json_encode('Eliminar reserva - DELETE');
            exit;
        }
    } 
}

?>