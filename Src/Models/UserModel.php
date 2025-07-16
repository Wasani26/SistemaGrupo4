<?php
namespace App\Models;
use App\DB\Sql;
use App\Config\ResponseHTTP;
use App\Config\Security;

class UserModel extends ConnectionDB{
    private static $nombre;
    private static $correo;
    private static $telefono;
    private static $dni;
    private static $fecha_nacimiento;
    private static $nacionalidad;
    private static $nombre_usuario;
    private static $contrasena;
    private static $url_foto;
    private static $rol;
    private static $fecha_creacion;
    private static $activo;

    //constructor
    public function __construct(array $data) {
        self::$nombre = $data['nombre'];
        self::$correo = $data['correo'];
        self::$telefono = $data['telefono'];
        self::$dni = $data['dni'];
        self::$fecha_nacimiento = $data['fecha_nacimiento'];
        self::$nacionalidad = $data['nacionalidad'];
        self::$nombre_usuario = $data['nombre_usuario'];
        self::$contrasena = $data['contrasena']; //password_hash($data['contrasena'], PASSWORD_DEFAULT);
        self::$url_foto = $data['url_foto']; //isset($data['url_foto']) ? $data['url_foto'] : null;
        self::$rol = 'visitante';
        self::$fecha_creacion = date('Y-m-d H:i:s'); //si se pasa a dentro del metodo
        self::$activo = 1;
    }

    //metodos get
    final public static function getnombre(){return self::$nombre;}
    final public static function getcorreo(){return self::$correo;}
    final public static function gettelefono(){return self::$telefono;}
    final public static function getdni(){return self::$dni;}
    final public static function getfecha_nacimiento(){return self::$fecha_nacimiento;}
    final public static function getnacionalidad(){return self::$nacionalidad;}
    final public static function getnombre_usuario(){return self::$nombre_usuario;}
    final public static function getcontrasena(){return self::$contrasena;}
    final public static function geturl_foto(){return self::$url_foto;}
    final public static function getrol(){return self::$rol;}
    final public static function getfecha_creacion(){return self::$fecha_creacion;}
    final public static function getactivo(){return self::$activo;}

    //metodos set
    final public static function setnombre($nombre){self::$nombre = $nombre;}
    final public static function setcorreo($correo){self::$correo = $correo;}
    final public static function settelefono($telefono){self::$telefono = $telefono;}
    final public static function setdni($dni){self::$dni = $dni;}
    final public static function setfecha_nacimiento($fecha_nacimiento){self::$fecha_nacimiento = $fecha_nacimiento;}
    final public static function setnacionalidad($nacionalidad){self::$nacionalidad = $nacionalidad;}
    final public static function setnombre_usuario($nombre_usuario){self::$nombre_usuario = $nombre_usuario;}
    final public static function setcontrasena($contrasena){self::$contrasena = $contrasena;}
    final public static function seturl_foto($url_foto){self::$url_foto = $url_foto;}
    final public static function setrol($rol){self::$rol = $rol;}
    final public static function setfecha_creacion($fecha_creacion){self::$fecha_creacion = $fecha_creacion;}
    final public static function setactivo($activo){self::$activo = $activo;}


    //metodo para crear usuario
    final public static function crear_usuario_completo(){
        
    }

}