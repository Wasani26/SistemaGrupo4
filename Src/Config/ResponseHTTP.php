<?php

namespace App\Config; // Nombre de espacio para Config

class ResponseHTTP {

    /**
     * Devuelve una respuesta HTTP 200 (OK).
     * Permite un mensaje personalizado y adjuntar datos.
     *
     * @param string $message Mensaje de la respuesta. Por defecto: 'La solicitud se ha procesado correctamente!'.
     * @param mixed $data Datos adicionales a incluir en la respuesta. Por defecto: null.
     * @return array
     */
    final public static function status200(string $message = 'La solicitud se ha procesado correctamente!', $data = null): array {
        http_response_code(200);
        return [
            'status' => 'OK',
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * Devuelve una respuesta HTTP 201 (Created).
     * Permite un mensaje personalizado y adjuntar datos.
     *
     * @param string $message Mensaje de la respuesta. Por defecto: 'Recurso creado exitosamente!'.
     * @param mixed $data Datos adicionales a incluir en la respuesta. Por defecto: null.
     * @return array
     */
    final public static function status201(string $message = 'Recurso creado exitosamente!', $data = null): array {
        http_response_code(201);
        return [
            'status' => 'OK',
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * Devuelve una respuesta HTTP 400 (Bad Request).
     * Permite un mensaje personalizado y adjuntar datos.
     *
     * @param string $message Mensaje de la respuesta. Por defecto: 'El servidor no pudo entender la solicitud debido a un error del cliente.'.
     * @param mixed $data Datos adicionales a incluir en la respuesta. Por defecto: null.
     * @return array
     */
    final public static function status400(string $message = 'El servidor no pudo entender la solicitud debido a un error del cliente.', $data = null): array {
        http_response_code(400);
        return [
            'status' => 'ERROR',
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * Devuelve una respuesta HTTP 401 (Unauthorized).
     * Permite un mensaje personalizado y adjuntar datos.
     *
     * @param string $message Mensaje de la respuesta. Por defecto: 'No tiene privilegios para acceder al recurso!'.
     * @param mixed $data Datos adicionales a incluir en la respuesta. Por defecto: null.
     * @return array
     */
    final public static function status401(string $message = 'No tiene privilegios para acceder al recurso!', $data = null): array {
        http_response_code(401);
        return [
            'status' => 'ERROR',
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * Devuelve una respuesta HTTP 404 (Not Found).
     * Permite un mensaje personalizado y adjuntar datos.
     *
     * @param string $message Mensaje de la respuesta. Por defecto: 'No existe el recurso solicitado!'.
     * @param mixed $data Datos adicionales a incluir en la respuesta. Por defecto: null.
     * @return array
     */
    final public static function status404(string $message = 'No existe el recurso solicitado!', $data = null): array {
        http_response_code(404);
        return [
            'status' => 'ERROR',
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * Devuelve una respuesta HTTP 500 (Internal Server Error).
     * Permite un mensaje personalizado y adjuntar datos.
     *
     * @param string $message Mensaje de la respuesta. Por defecto: 'Se ha producido un error en el servidor!'.
     * @param mixed $data Datos adicionales a incluir en la respuesta. Por defecto: null.
     * @return array
     */
    final public static function status500(string $message = 'Se ha producido un error en el servidor!', $data = null): array {
        http_response_code(500);
        return [
            'status' => 'ERROR',
            'message' => $message,
            'data' => $data
        ];
    }
}