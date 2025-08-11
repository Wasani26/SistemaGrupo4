<?php

namespace App\Controllers;
use App\Config\ResponseHTTP;
use App\Config\Security;
use App\Models\MuseoModel;

Class MuseoController {


    // Expresiones regulares para validación
   private static $validar_texto = '/^[\p{L}\p{N}\s\p{P}\p{S}]{2,255}$/u';
   private static $validar_numero = '/^\d+$/';

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

    // Método para crear un museo
    final public function crear_museo ($endpoint) {
        // Validar método HTTP y endpoint
        if($this->method == 'post' && $endpoint == $this->route){ // Ajuste para que 'museo/' coincida con 'museo'
           
            $data = $this->data;

            // Campos requeridos para crear un museo
            $campos_requeridos = [
                'nombre_museo', 'descripcion', 'tipo_de_museo', 'inauguracion',
                'horario', 'direccion', 'coordenadas', 'id_ubicacion'
            ];

            // Verificar que todos los campos requeridos estén presentes y no vacíos
            foreach ($campos_requeridos as $campo) {
                if (!isset($data[$campo]) || empty($data[$campo])) {
                    echo json_encode(ResponseHTTP::status400("El campo '$campo' es obligatorio."));
                    exit;
                }
            }
             
            // Validaciones de contenido usando expresiones regulares
            if (!preg_match(self::$validar_texto, $data['nombre_museo'])) {
                echo json_encode(ResponseHTTP::status400('Nombre del museo inválido.'));
                exit;
            }

            if (!preg_match(self::$validar_texto, $data['descripcion'])) {
                echo json_encode(ResponseHTTP::status400('Descripción del museo inválida.'));
                exit;
            }

            if (!preg_match(self::$validar_texto, $data['tipo_de_museo'])) {
                echo json_encode(ResponseHTTP::status400('Tipo de museo inválido.'));
                exit;
            }

            // Asumiendo que 'inauguracion' es un texto o un año. Si es un año específico (YYYY), ajustar regex.
            if (!preg_match(self::$validar_texto, $data['inauguracion'])) {
                echo json_encode(ResponseHTTP::status400('Fecha de inauguración inválida.'));
                exit;
            }

            if (!preg_match(self::$validar_texto, $data['horario'])) {
                echo json_encode(ResponseHTTP::status400('Horario inválido.'));
                exit;
            }

            if (!preg_match(self::$validar_texto, $data['direccion'])) {
                echo json_encode(ResponseHTTP::status400('Dirección inválida.'));
                exit;
            }

            // Para coordenadas, si esperas un formato específico (ej. "lat,lon"), ajusta la regex.
            // Por ahora, se valida como texto general.
            if (!preg_match(self::$validar_texto, $data['coordenadas'])) {
                echo json_encode(ResponseHTTP::status400('Coordenadas inválidas.'));
                exit;
            }

            if (!preg_match(self::$validar_numero, $data['id_ubicacion'])) {
                echo json_encode(ResponseHTTP::status400('ID de ubicación inválido.'));
                exit;
            }

            // Si todas las validaciones pasan, instanciar el modelo y llamar al método de creación
            $response = MuseoModel::crear_museo($this->data);
            echo json_encode($response);
            exit;
        }
    }

    
     final public function ver_museos ($endpoint) {
        // Condición: GET, la ruta COMPLETA coincide con el endpoint base (normalizado),
        // Y NO hay un ID o parámetro adicional en la URL.
        if(
            $this->method === 'get' &&
            trim($this->route, '/') === trim($endpoint, '/') && // Normalizamos ambas partes
            (!isset($this->params[1]) || empty($this->params[1])) // Asegura que no hay un segundo parámetro
        ){
            $response = MuseoModel::ver_museos();
            echo json_encode($response);
            exit;
        }
    }


     // Método para leer un museo específico
    final public function leer_museo ($endpoint) {
        if(
            $this->method === 'get' &&
            $this->params[0] === trim($endpoint, '/') &&
            isset($this->params[1]) && // Asegura que el segundo parámetro existe
            !empty($this->params[1]) // Asegura que el segundo parámetro no esté vacío
        ){
            if (!preg_match(self::$validar_numero, $this->params[1])) {
                echo json_encode(ResponseHTTP::status400('ID de museo inválido en la URL.'));
                exit;
            }

            $id_museo = $this->params[1];

            $response = MuseoModel::leer_museo($id_museo);
            echo json_encode($response);
            exit;
        }
    }

    // Método para actualizar un museo
    final public function actualizar_museo ($endpoint) {
        if(
            $this->method === 'put' &&
            $this->params[0] === trim($endpoint, '/') &&
            isset($this->params[1]) &&
            !empty($this->params[1])
        ){
            // Validar que el ID del museo en la URL sea numérico
            if (!preg_match(self::$validar_numero, $this->params[1])) {
                echo json_encode(ResponseHTTP::status400('ID de museo inválido o no proporcionado en la URL para actualizar.'));
                exit;
            }

            $id_museo = $this->params[1]; // Captura el ID del museo de la URL
            $data = $this->data; // Datos del cuerpo de la solicitud JSON

            // Campos requeridos para la actualización (todos los que se pueden modificar)
            $campos_requeridos = [
                'nombre_museo', 'descripcion', 'tipo_de_museo', 'inauguracion',
                'horario', 'direccion', 'coordenadas', 'id_ubicacion'
            ];

            // Verificar que todos los campos requeridos estén presentes y no vacíos en los datos recibidos
            foreach ($campos_requeridos as $campo) {
                if (!isset($data[$campo]) || empty($data[$campo])) {
                    echo json_encode(ResponseHTTP::status400("El campo '$campo' es obligatorio para la actualización."));
                    exit;
                }
            }

            // Validaciones de contenido para cada campo
            if (!preg_match(self::$validar_texto, $data['nombre_museo'])) {
                echo json_encode(ResponseHTTP::status400('Nombre del museo inválido.'));
                exit;
            }
            if (!preg_match(self::$validar_texto, $data['descripcion'])) {
                echo json_encode(ResponseHTTP::status400('Descripción del museo inválida.'));
                exit;
            }
            if (!preg_match(self::$validar_texto, $data['tipo_de_museo'])) {
                echo json_encode(ResponseHTTP::status400('Tipo de museo inválido.'));
                exit;
            }
            if (!preg_match(self::$validar_texto, $data['inauguracion'])) {
                echo json_encode(ResponseHTTP::status400('Fecha de inauguración inválida.'));
                exit;
            }
            if (!preg_match(self::$validar_texto, $data['horario'])) {
                echo json_encode(ResponseHTTP::status400('Horario inválido.'));
                exit;
            }
            if (!preg_match(self::$validar_texto, $data['direccion'])) {
                echo json_encode(ResponseHTTP::status400('Dirección inválida.'));
                exit;
            }
            if (!preg_match(self::$validar_texto, $data['coordenadas'])) {
                echo json_encode(ResponseHTTP::status400('Coordenadas inválidas.'));
                exit;
            }
            if (!preg_match(self::$validar_numero, $data['id_ubicacion'])) {
                echo json_encode(ResponseHTTP::status400('ID de ubicación inválido.'));
                exit;
            }

            // Si todas las validaciones pasan, se llama al modelo para actualizar
            $response = MuseoModel::actualizar_museo($id_museo, $data);
            echo json_encode($response);
            exit;
        }
    }


     final public function eliminar_museo ($endpoint) {
        if(
            $this->method === 'delete' &&
            $this->params[0] === trim($endpoint, '/') &&
            isset($this->params[1]) &&
            !empty($this->params[1])
        ){
            // Validar que el ID del museo en la URL sea numérico
            if (!preg_match(self::$validar_numero, $this->params[1])) {
                echo json_encode(ResponseHTTP::status400('ID de museo inválido o no proporcionado en la URL para eliminar.'));
                exit;
            }

            $id_museo = $this->params[1]; // Captura el ID del museo de la URL

            // Llama al método estático del modelo para "eliminar" (marcar como inactivo)
            $response = MuseoModel::eliminar_museo($id_museo);
            echo json_encode($response);
            exit;
        }
    }
}