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
   
    //expresiones regulares para validacion de los campos ingresados por el usuario.
    private static $validar_entero_positivo = '/^\d+$/';
    private static $validar_comentario_texto = '/^[\p{L}\p{N}\s.,!?()\-]{0,100}$/u'; // texto opcional, hasta 100 caracteres

    //Constructor para iniciar los metodos//
    public function __construct($method,$route,$params,$data,$headers){
        $this->method = strtolower($method);
        $this->route = $route;
        $this->params = $params;
        $this->data = $data;
        $this->headers = $headers;
    }

    

   final public function crear_reserva($endpoint){
    if($this->method == 'post' && $endpoint == $this->route){
        $data = $this->data;

        // Campos requeridos para la reserva
        $campos_requeridos = ['cantidad_asistentes', 'id_usuario', 'id_tour'];

        foreach ($campos_requeridos as $campo) {
            if (!isset($data[$campo]) || empty($data[$campo])) {
                echo json_encode(ResponseHTTP::status400("El campo '$campo' es obligatorio."));
                exit;
            }
        }

        // Validar cantidad_asistentes
        if (!preg_match(self::$validar_entero_positivo, $data['cantidad_asistentes'])) {
            echo json_encode(ResponseHTTP::status400("La cantidad de asistentes debe ser un entero positivo."));
            exit;
        }

        // Validar comentarios si viene
        if (isset($data['comentarios']) && !preg_match(self::$validar_comentario_texto, $data['comentarios'])) {
            echo json_encode(ResponseHTTP::status400("El campo comentarios contiene caracteres inválidos."));
            exit;
        }

        // Asignar valores automáticos
        $data['fecha_reserva'] = date('Y-m-d H:i:s');
        $data['estado_reserva'] = 'pendiente';
        $data['pagada'] = false;
        $data['asistencia'] = false;

        $reserva = new ReservaModel($data);
        echo json_encode($reserva->crear_reserva());
        exit;
    }
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