<?php
namespace App\Models;
use App\DB\Sql;
use App\DB\ConnectionDB;
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
    public function __construct($data = []) {
        if(!empty($data)){
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
    }

    //metodos get
    final public static function getNombre(){return self::$nombre;}
    final public static function getCorreo(){return self::$correo;}
    final public static function getTelefono(){return self::$telefono;}
    final public static function getDni(){return self::$dni;}
    final public static function getFechaNacimiento(){return self::$fecha_nacimiento;}
    final public static function getNacionalidad(){return self::$nacionalidad;}
    final public static function getNombreUsuario(){return self::$nombre_usuario;}
    final public static function getContrasena(){return self::$contrasena;}
    final public static function getUrlFoto(){return self::$url_foto;}
    final public static function getRol(){return self::$rol;}
    final public static function getFechaCreacion(){return self::$fecha_creacion;}
    final public static function getActivo(){return self::$activo;}

    //metodos set
    final public static function setNombre($nombre){self::$nombre = $nombre;}
    final public static function setCorreo($correo){self::$correo = $correo;}
    final public static function setTelefono($telefono){self::$telefono = $telefono;}
    final public static function setDni($dni){self::$dni = $dni;}
    final public static function setFechaNacimiento($fecha_nacimiento){self::$fecha_nacimiento = $fecha_nacimiento;}
    final public static function setNacionalidad($nacionalidad){self::$nacionalidad = $nacionalidad;}
    final public static function setNombreUsuario($nombre_usuario){self::$nombre_usuario = $nombre_usuario;}
    final public static function setContrasena($contrasena){self::$contrasena = $contrasena;}
    final public static function setUrlFoto($url_foto){self::$url_foto = $url_foto;}
    final public static function setRol($rol){self::$rol = $rol;}
    final public static function setFechaCreacion($fecha_creacion){self::$fecha_creacion = $fecha_creacion;}
    final public static function setActivo($activo){self::$activo = $activo;}


    //metodo para crear usuario
    final public static function crear_usuario_completo(){
        // Validar que nombre_usuario y correo no estén registrados
    if (Sql::verificar_registro("CALL verificar_usuario(:usuario)", ':usuario', self::getNombreUsuario())) {
        return responseHTTP::status400('El nombre de usuario ya está registrado en la base de datos.');
    }

    if (Sql::verificar_registro("CALL verificar_correo(:correo)", ':correo', self::getCorreo())) {
        return responseHTTP::status400('El correo electrónico ya está registrado en la base de datos.');
    }

    // Generar fecha de creación y token (si lo usarás)
    self::setFechaCreacion(date('Y-m-d H:i:s'));

    // Opcional: podrías generar un token, por ejemplo, para validar cuenta
    // self::setIDToken(hash('sha512', self::getCorreo().time()));

    try {
        $con = self::getConnection();

        // Llamado a procedimiento almacenado para insertar en personas y usuarios
        $query = "CALL crear_usuario_completo(
            :nombre, :correo, :telefono, :dni, :fecha_nacimiento, :nacionalidad,
            :nombre_usuario, :contrasena, :url_foto, :fecha_creacion, :activo, :rol
        )";

        $stmt = $con->prepare($query);
        $stmt->execute([
            ':nombre'           => self::getNombre(),
            ':correo'           => self::getCorreo(),
            ':telefono'         => self::getTelefono(),
            ':dni'              => self::getDni(),
            ':fecha_nacimiento' => date('Y-m-d', strtotime(str_replace('-', '/', self::getFechaNacimiento()))),
            ':nacionalidad'     => self::getNacionalidad(),
            ':nombre_usuario'          => self::getNombreUsuario(),
            ':contrasena'            => password_hash(self::getContrasena(), PASSWORD_DEFAULT),
            ':url_foto'             => self::getUrlFoto(),
            ':fecha_creacion'   => self::getFechaCreacion(),
            ':activo'           => self::getActivo(),
            ':rol'              => self::getRol()
        ]);

        if ($stmt->rowCount() > 0) {
            return responseHTTP::status201('El usuario ha sido registrado exitosamente.');
        } else {
            return responseHTTP::status400('No se pudo registrar el usuario.');
        }

    } catch (\PDOException $e) {
        error_log('userModel::crear_usuario_completo -> ' . $e);
        die(json_encode(responseHTTP::status500()));
    }

  }

  //metodo para ingresar al sistema
  final public static function login()
{
    try {
        $con = self::getConnection(); // Abrimos conexión

        // Llamamos al procedimiento almacenado para buscar al usuario
        $query = "CALL login_usuario(:usuario)";
        $stmt = $con->prepare($query);
        $stmt->execute([
            ':usuario' => self::getNombreUsuario()
        ]);

        if ($stmt->rowCount() == 0) {
            return responseHTTP::status400('Usuario o contraseña incorrectos');
        } else {
            foreach ($stmt as $val) {
                // Validamos la contraseña comparando la ingresada con el hash de la BD
                if (Security::validatePassword(self::getContrasena(), $val['contrasena'])) {

                    // Construimos el payload para el JWT
                    $payload = [
                        'idUsuario' => $val['id_usuario'], // o cualquier identificador único
                        'rol' => $val['tipo_rol'],
                        'usuario' => $val['nombre_usuario']
                    ];

                    // Generamos el token
                    $token = Security::createTokenJwt(Security::secretKey(), $payload);

                    // Información de respuesta para el cliente
                    $data = [
                        'usuario' => $val['nombre_usuario'],
                        'rol' => $val['tipo_rol'],
                        'token' => $token
                    ];

                    return $data;
                }
            }

            // Si llega aquí, la contraseña era incorrecta
            return responseHTTP::status400('Usuario o contraseña incorrectos');
        }
    } catch (\PDOException $e) {
        error_log("userModel::login -> " . $e);
        return responseHTTP::status500('');
    }
}

final public static function obtener_usuarios(){
    try {
        $con = self::getConnection(); // conexión
        $stmt = $con->prepare("CALL obtener_usuarios()");
        $stmt->execute();
        $res['data'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $res;
    } catch (\PDOException $e) {
        error_log("UserModel::obtener_usuarios ->" . $e);
        die(json_encode(ResponseHTTP::status500()));
    }
}

final public static function leer_usuario($usuario){
    try{
        $con = self::getConnection();
        $query = "CALL leer_usuario(:usuario)";
        $stmt = $con->prepare($query);
        $stmt->execute([
            ':usuario' => $usuario
        ]);

        if($stmt->rowCount() > 0){
            $res['data'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $res;
        } else {
            return ResponseHTTP::status400('No existe registro con este nombre de usuario.');
        }
    } catch(\PDOException $e){
        error_log("UserModel::leer_usuario -> ".$e);
        die(json_encode(ResponseHTTP::status500()));
    }
}

final public function obtener_id($id) {
    try {
        $con = self::getConnection();
        $sql = "CALL obtener_id(:id_usuario)";
        $stmt = $con->prepare($sql);

        $stmt->execute([
            ':id_usuario' => $id
        ]);

        if ($stmt->rowCount() > 0) {
            $res['data'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $res;
        } else {
            return ResponseHTTP::status400('No existe registro con este id');
        }

    } catch(\PDOException $e) {
        error_log("UserModel::obtener_id -> ".$e);
        die(json_encode(ResponseHTTP::status500()));
    }
}


public function cambiar_contrasena($idUsuario, $nuevaContrasenaHash) {
    try {
        $con = self::getConnection();
        $query = "CALL cambiar_contrasena(:id_usuario, :nueva_contrasena)";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':id_usuario', $idUsuario, \PDO::PARAM_INT);
        $stmt->bindParam(':nueva_contrasena', $nuevaContrasenaHash, \PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true; // Éxito
        } else {
            error_log("Error al ejecutar el procedimiento almacenado cambiar_contrasena.");
            return false;
        }
    } catch (\PDOException $e) {
        error_log("Excepción al cambiar contraseña: " . $e);
        return false;
    }
}

// metodo actualizar un usuario en su mayoria
final public function actualizar_usuario($id_usuario, $data) {
    try {
        $con = self::getConnection();

        $sql = "CALL actualizar_usuario(
                    :id_usuario,
                    :nombre,
                    :correo,
                    :telefono,
                    :dni,
                    :fecha_nacimiento,
                    :nacionalidad,
                    :nombre_usuario,
                    :url_foto
                )";

        $stmt = $con->prepare($sql);

        $stmt->bindParam(':id_usuario', $id_usuario, \PDO::PARAM_INT);
        $stmt->bindParam(':nombre', self::$nombre, \PDO::PARAM_STR);
        $stmt->bindParam(':correo', self::$correo, \PDO::PARAM_STR);
        $stmt->bindParam(':telefono', self::$telefono, \PDO::PARAM_STR);
        $stmt->bindParam(':dni', self::$dni, \PDO::PARAM_STR);
        $stmt->bindParam(':fecha_nacimiento', self::$fecha_nacimiento, \PDO::PARAM_STR);
        $stmt->bindParam(':nacionalidad', self::$nacionalidad, \PDO::PARAM_STR);
        $stmt->bindParam(':nombre_usuario', self::$nombre_usuario, \PDO::PARAM_STR);
        $stmt->bindParam(':url_foto', self::$url_foto, \PDO::PARAM_STR);

        if ($stmt->execute()) {
            return ResponseHTTP::status200('Usuario actualizado correctamente');
        } else {
            return ResponseHTTP::status500('No se pudo actualizar el usuario');
        }

    } catch (\PDOException $e) {
        error_log("UserModel::actualizar_usuario -> " . $e->getMessage());
        return ResponseHTTP::status500('Error interno del servidor');
    }
}


}



