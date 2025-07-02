<?php

namespace App\DB;
use App\Config\ResponseHTTP;
use PDO; //uso objeto pdo para interactuar con la bd

require __DIR__.'/DataDB.php';

class ConnectionDB{
    private static $host = '';
    private static $user = '';
    private static $pass = '';

    final public static function inicializar($host, $user, $pass){
        //this or self
        //self hace referencia a la clase para asi mandar llamar funciones estaticas
        //this hace referencia a un objeto ya instanciado para mandar a llamar las funciones de cualquier tipo 
        self::$host = $host;
        self::$user = $user;
        self::$pass = $pass;
    }

    //metodo que retorna la conexion 
    final public static function getConnection(){
        try{
            //opciones de conexion
            $opt = [\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC];
            $pdo = new PDO(self::$host,self::$user,self::$pass, $opt);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            error_log("conexión es exitosa");
            return $pdo;

        }catch(\PDOException $e){
            error_log("Error en la conexión a la BD! ERROR: ".$e);
            die(json_encode(ResponseHTTP::status500()));
        }
    }
}

