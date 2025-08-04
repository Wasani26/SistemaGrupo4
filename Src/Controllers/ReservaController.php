<?php
namespace App\Controllers; //nombre de espacio//
use App\Config\ResponseHTTP; 
use App\Config\Security;
use App\Models\ReservaModel;
use App\Models\UserModel;

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

   /* 
   //Metodo POST para crear las reservas//
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
*/

final public function crear_reserva($endpoint) {
    if($this->method == 'post' && $endpoint == $this->route) {
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
        if (!preg_match(self::$validar_entero_positivo, $data['cantidad_asistentes']) || $data['cantidad_asistentes'] <= 0) {
            echo json_encode(ResponseHTTP::status400("La cantidad de asistentes debe ser un entero positivo mayor a cero."));
            exit;
        }

        // Validar comentarios si viene
        if (isset($data['comentarios']) && !preg_match(self::$validar_comentario_texto, $data['comentarios'])) {
            echo json_encode(ResponseHTTP::status400("El campo comentarios contiene caracteres inválidos."));
            exit;
        }

        // Validar moneda si viene (si no viene, usaremos LPS por defecto)
        if (isset($data['moneda'])) {
            $monedas_validas = ['LPS', '$'];
            if (!in_array($data['moneda'], $monedas_validas)) {
                echo json_encode(ResponseHTTP::status400("Moneda no válida. Solo se acepta 'LPS' o '$'."));
                exit;
            }
        } else {
            $data['moneda'] = 'LPS'; // Valor por defecto
        }

        // Calcular monto (100 por cada asistente)
        $monto = $data['cantidad_asistentes'] * 100;

        // Asignar valores automáticos para la reserva
        $data['fecha_pago'] = date('Y-m-d H:i:s');
        $data['estado'] = 'pendiente';
        $data['asistencia'] = false;

       /*
            // Crear la reserva
            $reservaModel = new ReservaModel($data);
            $resultado_reserva = $reservaModel->crear_reserva();
            $id_reserva = $resultado_reserva['data']['id_reserva'];
*/
            // Preparar datos para el pago
            $datos_pago = [
                'monto' => $monto,
                'moneda' => $data['moneda'],
                'metodo_pago' => isset($data['metodo_pago']) ? $data['metodo_pago'] : 'en línea',
                'fecha_pago' => date('Y-m-d H:i:s'),
                'id_reserva' => $data ['id_reserva'],
                'estado' => 'pendiente'
            ];

            // Crear el pago asociado
            $reservaModel = new ReservaModel($datos_pago);
            $resultado_pago = $reservaModel->crear_reserva();

            
          exit;

        }
                          echo json_encode("llegastes a post");
        exit;
    }





    //Metodo GET para obtener las reservas//
    final public function obtener_todas_reservas($endpoint){
        echo json_encode("llegastes a get");
        exit;
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