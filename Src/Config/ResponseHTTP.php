<?php

namespace App\Config; //nombre de espacio para Config


class ResponseHTTP{

    public static $mensaje = array(
        'status' => '',
        'message' => '',
        'data' => ''
    );

    //aca van los códigos de estado más relevantes

      final public static function status200(string $res){
        $res = 'La solicitud se ha procesado correctamente!';
        http_response_code(200); //funcion de php que permite cambiar el codigo de estado http
        self::$mensaje['status'] = 'OK';
        self::$mensaje['message'] = $res; //la variable res es el mensaje/respuesta que proviene del usuario
        return self::$mensaje;
    }

    final public static function status201(){
        $res = 'Recurso creado exitosamente!';
        http_response_code(201);
        self::$mensaje['status'] = 'OK';
        self::$mensaje['message'] = $res; //la variable res es el mensaje
        return self::$mensaje;
    }

    final public static function status400(string $res){
        $res = 'El servidor no pudo entender la solicitud debido a un error del cliente';
        http_response_code(400);
        self::$mensaje['status'] = 'ERROR';
        self::$mensaje['message'] = $res; //la variable res es el mensaje
        return self::$mensaje;
    }

    final public static function status401(){
        $res = 'No tiene privilegios para acceder al recurso! '.$str;
        http_response_code(401);
        self::$mensaje['status'] = 'ERROR';
        self::$mensaje['message'] = $res; //la variable res es el mensaje
        return self::$mensaje;
    }

    final public static function status404(){
        $res = 'No existe el recurso solicitado!';
        http_response_code(404);
        self::$mensaje['status'] = 'ERROR';
        self::$mensaje['message'] = $res; //la variable res es el mensaje
        return self::$mensaje;
    }

    final public static function status500(){
        $res = 'Se ha producido un error en el servidor!';
        http_response_code(500);
        self::$mensaje['status'] = 'ERROR';
        self::$mensaje['message'] = $res; //la variable res es el mensaje
        return self::$mensaje;
    }


}