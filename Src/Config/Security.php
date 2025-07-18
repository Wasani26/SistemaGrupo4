<?php

namespace App\Config;
use Dotenv\Dotenv;
use Firebase\JWT\JWT; //para generar el JWT


class Security{
    final public static function secretKey(){
            
        $dotenv = Dotenv::createImmutable(dirname(__DIR__,2));

        $dotenv->load(); //carga las variables de entorno.
        return $_ENV['SECRET_KEY'];//crea la variable de entorno secret key.
    }

    final public static function createPassword(string $pass){
        $pass = password_hash($pass, PASSWORD_DEFAULT); //metodo para encriptar
        //pass_hash como metodo recibe dos parametros, primero la contraseña sin encriptar y luego la encriptada.

        return $pass;
    }

    final public static function validatePassword(string $pw , string $pwh){
        if(password_verify($pw, $pwh)){
            return true;
        }else{
            error_log('La contraseña no coincide');
            return false;
        }
    }

    final public static function createTokenJwt(string $key , array $data){
        $payload = array (
            "iat" => time(), //almacena esta clave el tiempo en que creamos el JWT
            "exp" => time() + (60*60*6), //60 define el tiempo en que expira el JWT
            "data" => $data //almacena la data encriptada
        );

        //crea el JWT que recibe sobre todo los parametros payload y la key en el metodo encode de JWT
        $jwt = JWT::encode($payload,$key);
        return $jwt;
    }

    final public static function validateTokenJwt(array $token, string $key){
    if(!isset($token['Authorization'])){
        die(json_encode(ResponseHTTP::status400('Para proceder el token de acceso es requerido')));
        exit;
    }
    try{
        $jwt = explode(" ", $token['Authorization']);
        $data = JWT::decode($jwt[1], $key, array('HS256'));

        self::$jwt_data = $data;
        return $data;
    } catch (Exception $e){
        error_log('El Token es invalido o expiro' .$e);
        die(json_encode(ResponseHTTP::status401('Token es invalido o ha expirado')));
    }
}


    final public static function getDataJwt(){
        $jwt_decoded_array = json_decode(json_encode(self::$jwt_data),true);
        return $jwt_decoded_array['data'];
        exit;
    }
}