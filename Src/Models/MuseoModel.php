<?php
namespace App\Models;
use App\DB\Sql;
use App\DB\ConnectionDB;
use App\Config\ResponseHTTP;
use App\Config\Security;


class MuseoModel extends ConnectionDB{
    private static $nombre_museo;
    private static $descripcion;
    private static $tipo_de_museo;
    private static $inauguracion;
    private static $horario;
    private static $direccion;
    private static $coordenadas;
    private static $id_ubicacion;
    

    //constructor
    public function __construct($data = []) {
        if(!empty($data)){
        self::$nombre_museo = $data['nombre_museo'];
        self::$descripcion = $data['descripcion'];
        self::$tipo_de_museo = $data['tipo_de_museo'];
        self::$inauguracion = $data['inauguracion'];
        self::$horario = $data['horario'];
        self::$direccion = $data['direccion'];
        self::$coordenadas = $data['coordenadas'];
        self::$id_ubicacion = $data['id_ubicacion']; //password_hash($data['contrasena'], PASSWORD_DEFAULT);
     }

    }

    //metodos get
    final public static function getNombre_Museo(){return self::$nombre_museo;}
    final public static function getDescripcion(){return self::$descripcion;}
    final public static function getTipo_de_Museo(){return self::$tipo_de_museo;}
    final public static function getInauguracion(){return self::$inauguracion;}
    final public static function getHorario(){return self::$horario;}
    final public static function getDireccion(){return self::$direccion;}
    final public static function getCoordenadas(){return self::$coordenadas;}
    final public static function getID_Ubicacion(){return self::$id_ubicacion;}
    

    //metodos set
    final public static function setNombre_Museo($nombre_museo){self::$nombre_museo = $nombre_museo;}
    final public static function setDescripcion($descripcion){self::$descripcion = $descripcion;}
    final public static function setTipo_de_Museo($tipo_de_museo){self::$tipo_de_museo = $tipo_de_museo;}
    final public static function setInauguracion($inauguracion){self::$inauguracion = $inauguracion;}
    final public static function setHorario($horario){self::$horario = $horario;}
    final public static function setDireccion($direccion){self::$direccion = $direccion;}
    final public static function setCoordenadas($coordenadas){self::$coordenadas = $coordenadas;}
    final public static function setID_Ubicacion($id_ubicacion){self::$id_ubicacion = $id_ubicacion;}


    final public static function crear_museo () {

    }
     final public static function leer_museo () {
        
    }
      final public static function ver_museos () {
        
    }
    final public static function actualizar_museo () {
        
    }
   final public static function eliminar_museo () {
        
    }
}
