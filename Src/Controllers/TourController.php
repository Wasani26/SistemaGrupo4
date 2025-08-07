<?php

namespace App\Controllers; // Asegúrate de que tu namespace sea correcto
use App\Models\TourModel; // Asegúrate de que tu namespace sea correcto
use App\Config\ResponseHTTP; // Asegúrate de que tu namespace sea correcto
use App\Config\Security;

class TourController {
    private static $validar_texto = '/^[\p{L}\p{N}\s\.,;:!?-]{2,255}$/u';
    private static $validar_fecha = '/^\d{2}-\d{2}-\d{4}$/';
    private static $validar_hora = '/^\d{2}:\d{2}$/';
    private static $validar_numero = '/^\d+$/';

    private $method;
    private $route;
    private $params;
    private $data;
    private $headers;

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

            // Eliminamos 'id_guia' y nos aseguramos de que 'id_usuario' esté presente
            $campos_requeridos = [
                'nombre', 'descripcion', 'fecha', 'hora_inicio', 'duracion',
                'cupo_maximo', 'idioma_tour', 'punto_encuentro', 'comentario',
                'id_museo', 'id_usuario' // 'id_guia' ha sido eliminado
            ];

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

            if (!preg_match(self::$validar_fecha, $data['fecha'])) {
                echo json_encode(ResponseHTTP::status400('Fecha inválida.'));
                exit;
            }

            if (!preg_match(self::$validar_hora, $data['hora_inicio'])) {
                echo json_encode(ResponseHTTP::status400('Hora de inicio inválida.'));
                exit;
            }

            if (!preg_match(self::$validar_numero, $data['duracion'])) {
                echo json_encode(ResponseHTTP::status400('Duración inválida.'));
                exit;
            }

            if (!preg_match(self::$validar_numero, $data['cupo_maximo'])) {
                echo json_encode(ResponseHTTP::status400('Cupo máximo inválido.'));
                exit;
            }

            if (!preg_match(self::$validar_numero, $data['idioma_tour'])) {
                echo json_encode(ResponseHTTP::status400('ID de idioma inválido.'));
                exit;
            }

            if (!preg_match(self::$validar_texto, $data['punto_encuentro'])) {
                echo json_encode(ResponseHTTP::status400('Punto de encuentro inválido.'));
                exit;
            }

            // El comentario puede ser texto, pero si permites que sea opcional, no lo valides con empty()
            // Si es obligatorio, la validación de campos_requeridos ya lo cubre.
            // Si es opcional, puedes quitarlo de campos_requeridos y no validar su contenido si está vacío.
            // Aquí se asume que es obligatorio y se valida como texto.
            if (!preg_match(self::$validar_texto, $data['comentario'])) {
                echo json_encode(ResponseHTTP::status400('Comentario inválido.'));
                exit;
            }

            if (!preg_match(self::$validar_numero, $data['id_museo'])) {
                echo json_encode(ResponseHTTP::status400('ID de museo inválido.'));
                exit;
            }

            // Validamos 'id_usuario'
            if (!preg_match(self::$validar_numero, $data['id_usuario'])) {
                echo json_encode(ResponseHTTP::status400('ID de usuario inválido.'));
                exit;
            }

            // Crear el tour
            new TourModel($this->data);
            echo json_encode(TourModel::creartour());
            exit;
        }
    }

    final public function leer_tour($endpoint) {
    if ($this->method == 'get' && $endpoint == $this->route) {
       Security::validateTokenjwt($this->headers, Security::secretKey());
       $id_tour = $this->params[1] ?? null;
        if (!$id_tour) {
           echo json_encode(ResponseHTTP::status400('Debe ingresar un registro válido!'));
        } else {
            echo json_encode(TourModel::leer_tour($id_tour));
            exit;
        } 
     }
    }

    final public function actualizar_tour($endpoint) {
        if ($this->method === 'put' && $this->params[0] === trim($endpoint, '/')) {
            if (isset($this->params[1])) {
                $model = new TourModel();
                $response = $model->actualizarTour($this->params[1], $this->data);
                echo json_encode($response);
                exit;
            }
        }
    }

     //permite ver todos los tour
    final public function obtener_tour($endpoint){
    // validamos el método y el endpoint
    if($this->method == 'get' && $endpoint == $this->route){
       //Security::validateTokenJwt($this->headers, Security::secretKey());
       echo json_encode(tourModel::obtener_tour());
        exit;
      }
    }

    final public function eliminar_tour($endpoint) {
        if ($this->method === 'delete' && $this->params[0] === trim($endpoint, '/')) {
            if (isset($this->params[1])) {
                $model = new TourModel();
                $response = $model->eliminarTour($this->params[1]);
                echo json_encode($response);
                exit;
            }
        }
    }

    final public function cambiar_fecha($endpoint) {
        if ($this->method === 'patch' && $this->route === $endpoint) {
            if (isset($this->params[1])) {
                $model = new TourModel();
                $response = $model->cambiarFecha($this->params[1], $this->data);
                echo json_encode($response);
                exit;
            }
        }
    }

    final public function cambiar_cupo($endpoint) {
        if ($this->method === 'patch' && $this->route === $endpoint) {
            if (isset($this->params[1])) {
                $model = new TourModel();
                $response = $model->cambiarCupo($this->params[1], $this->data);
                echo json_encode($response);
                exit;
            }
        }
    }
}