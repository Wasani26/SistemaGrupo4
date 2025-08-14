<?php
namespace App\Controllers;
use App\Config\ResponseHTTP;
use App\Config\Security;
use App\Models\ReservaModel;
use App\Models\UserModel;

class ReservaController {
    private $method;
    private $route;
    private $params;
    private $data;
    private $headers;
    
     //expresiones regulares para validacion de los campos ingresados por el usuario.
    private static $validar_entero_positivo = '/^\d+$/';
    private static $validar_comentario_texto = '/^[\p{L}\p{N}\s.,!?()\-]{0,100}$/u'; // texto opcional, hasta 100 caracteres

    public function __construct($method,$route,$params,$data,$headers){
        $this->method = strtolower($method);
        $this->route = $route;
        $this->params = $params;
        $this->data = $data;
        $this->headers = $headers;
    }

    final public function crear_reserva($endpoint) {
            if($this->method == 'post' && trim($this->route, '/') === trim($endpoint, '/')) {
                $data = $this->data;

                $campos_requeridos = ['cantidad_asistentes', 'id_usuario', 'id_tour'];

<<<<<<< HEAD
        // Campos requeridos para la reserva
        $campos_requeridos = ['cantidad_asistentes', 'id_usuario', 'id_tour', 'moneda', 'comentarios'];

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
        if (!in_array($data['moneda'], ['LPS', '$'])) {
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
    }


    //Metodo GET para obtener las reservas//
    final public function obtener_todas_reservas($endpoint){
        //Validacion para el metodo GET// 
        if($this->method == 'get' && $endpoint == $this->route){
            echo json_encode('Obtener todas las reservas - GET');
=======
                foreach ($campos_requeridos as $campo) {
                    if (!isset($data[$campo]) || empty($data[$campo])) {
                        echo json_encode(ResponseHTTP::status400("El campo '$campo' es obligatorio."));
                        exit; 
                    }
                }

                if (!preg_match(self::$validar_entero_positivo, $data['cantidad_asistentes']) || (int)$data['cantidad_asistentes'] <= 0) {
                    echo json_encode(ResponseHTTP::status400("La cantidad de asistentes debe ser un entero positivo mayor a cero."));
                    exit; 
                }

                if (isset($data['comentarios']) && !empty($data['comentarios']) && !preg_match(self::$validar_comentario_texto, $data['comentarios'])) {
                    echo json_encode(ResponseHTTP::status400("El campo comentarios contiene caracteres inválidos."));
                    exit;
                }
                $data['comentarios'] = $data['comentarios'] ?? null;

                $monedas_validas = ['LPS', 'USD'];
                if (isset($data['moneda'])) {
                    if (!in_array($data['moneda'], $monedas_validas)) {
                        echo json_encode(ResponseHTTP::status400("Moneda no válida. Solo se acepta 'LPS' o 'USD'."));
                        exit; 
                    }
                } else {
                    $data['moneda'] = 'LPS';
                }

                $monto = (int)$data['cantidad_asistentes'] * 100;

                $data['fechar_reserva'] = date('Y-m-d');
                $data['asistencia'] = false;
                $data['monto'] = $monto;
                $data['metodo_pago'] = isset($data['metodo_pago']) && !empty($data['metodo_pago']) ? $data['metodo_pago'] : 'en línea';
                $data['fecha_pago'] = date('Y-m-d H:i:s');

                $reservaModel = new ReservaModel($data);
                $resultado = $reservaModel->crear_reserva_y_pago();

                echo json_encode($resultado);
                exit; 
            }
        }

    //Metodo GET para obtener las reservas//
    final public function obtener_todas_reservas($endpoint){
        if($this->method == 'get' && trim($this->route, '/') === trim($endpoint, '/')){
            $response = ReservaModel::obtener_todas_reservas();
            echo json_encode($response);
>>>>>>> 3017b4317219bec55287523fb03b2b8e849a3f6f
            exit;
        }
    }

    //Metodo PUT para actualizar reserva//
    final public function actualizar_reserva ($endpoint){
        if(
            $this->method == 'put' &&
            $this->params[0] === trim($endpoint, '/') &&
            isset($this->params[1]) &&
            !empty($this->params[1])
        ){
            echo json_encode(ResponseHTTP::status200('Lógica de actualización pendiente para ID: ' . $this->params[1]));
            return;
        }
    }

    //Metodo DELETE para eliminar reserva//
    final public function eliminar_reserva($endpoint){
        if(
            $this->method == 'delete' &&
            $this->params[0] === trim($endpoint, '/') &&
            isset($this->params[1]) &&
            !empty($this->params[1])
        ){
            echo json_encode(ResponseHTTP::status200('Lógica de eliminación suave pendiente para ID: ' . $this->params[1]));
            return;
        }
    }
}


