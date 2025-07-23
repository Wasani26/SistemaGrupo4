<?php

namespace App\Config;
use Dotenv\Dotenv;
use Firebase\JWT\JWT; //para generar el JWT


class Security{
    private static $jwt_data;

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

    final public static function createTokenJwt(string $key, array $data, int $expSeconds = 900) {
    $payload = array(
        "iat" => time(),
        "exp" => time() + $expSeconds,
        "data" => $data
    );
    return JWT::encode($payload, $key);
    }


 final public static function validateTokenJwt(array $token, string $key){
    // Compatibilidad con capitalización: Authorization / authorization
    $authHeader = $token['Authorization'] ?? $token['authorization'] ?? null;

    if (!$authHeader) {
        die(json_encode(ResponseHTTP::status400('Para proceder el token de acceso es requerido')));
    }

    try {
        // Separar esquema 'Bearer' del token
        $jwtParts = explode(" ", $authHeader);
        if (count($jwtParts) !== 2 || strtolower($jwtParts[0]) !== 'bearer') {
            die(json_encode(ResponseHTTP::status400('Formato del token no válido')));
        }

        // Decodificar el JWT
        //$data = JWT::decode($jwtParts[1], $key, array('HS256'));
        $data = (array) JWT::decode($jwtParts[1], $key, array('HS256'));
        //error_log('Token decodificado: ' . print_r($data, true));

        // Guardar los datos decodificados si los usarás en otras partes
        self::$jwt_data = $data;
        return $data;
    } catch (Exception $e) {
        error_log('El Token es inválido o expiró: ' . $e);
        die(json_encode(ResponseHTTP::status401('Token es inválido o ha expirado')));
    }
}



    final public static function getDataJwt(){
        $jwt_decoded_array = json_decode(json_encode(self::$jwt_data),true);
        return $jwt_decoded_array['data'];
        exit;
    }
}