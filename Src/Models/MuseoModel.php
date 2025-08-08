<?php
namespace App\Models;
use App\DB\ConnectionDB; // Asumiendo que ConnectionDB está en App\DB
use App\Config\ResponseHTTP;
use App\Config\Security; // Si usas Security en el modelo, asegúrate de que esté aquí

class MuseoModel extends ConnectionDB{
    private static $nombre_museo;
    private static $descripcion;
    private static $tipo_de_museo;
    private static $inauguracion;
    private static $horario;
    private static $direccion;
    private static $coordenadas;
    private static $id_ubicacion;
    // No necesitamos una propiedad estática para id_museo si es auto_increment y no se pasa en la creación

    // Constructor
    public function __construct($data = []) {
        if(!empty($data)){
            // Usar el operador ?? null para evitar errores si un campo no está presente
            self::$nombre_museo = $data['nombre_museo'] ?? null;
            self::$descripcion = $data['descripcion'] ?? null;
            self::$tipo_de_museo = $data['tipo_de_museo'] ?? null;
            self::$inauguracion = $data['inauguracion'] ?? null;
            self::$horario = $data['horario'] ?? null;
            self::$direccion = $data['direccion'] ?? null;
            self::$coordenadas = $data['coordenadas'] ?? null;
            self::$id_ubicacion = $data['id_ubicacion'] ?? null;
        }
    }

    // Getters
    final public static function getNombre_Museo(){return self::$nombre_museo;}
    final public static function getDescripcion(){return self::$descripcion;}
    final public static function getTipo_de_Museo(){return self::$tipo_de_museo;}
    final public static function getInauguracion(){return self::$inauguracion;}
    final public static function getHorario(){return self::$horario;}
    final public static function getDireccion(){return self::$direccion;}
    final public static function getCoordenadas(){return self::$coordenadas;}
    final public static function getID_Ubicacion(){return self::$id_ubicacion;}

    // Setters
    final public static function setNombre_Museo($nombre_museo){self::$nombre_museo = $nombre_museo;}
    final public static function setDescripcion($descripcion){self::$descripcion = $descripcion;}
    final public static function setTipo_de_Museo($tipo_de_museo){self::$tipo_de_museo = $tipo_de_museo;}
    final public static function setInauguracion($inauguracion){self::$inauguracion = $inauguracion;}
    final public static function setHorario($horario){self::$horario = $horario;}
    final public static function setDireccion($direccion){self::$direccion = $direccion;}
    final public static function setCoordenadas($coordenadas){self::$coordenadas = $coordenadas;}
    final public static function setID_Ubicacion($id_ubicacion){self::$id_ubicacion = $id_ubicacion;}


    // Método para crear un museo
    final public static function crear_museo ($data) {
        try {
            $con = self::getConnection();

            // Validaciones de campos requeridos (redundantes si el controlador ya los valida, pero buena práctica)
            if (
                empty($data['nombre_museo']) || empty($data['descripcion']) || empty($data['tipo_de_museo']) ||
                empty($data['inauguracion']) || empty($data['horario']) || empty($data['direccion']) ||
                empty($data['coordenadas']) || empty($data['id_ubicacion'])
            ) {
                return ResponseHTTP::status400('Faltan campos obligatorios en el modelo para crear el museo.');
            }

            // Llamada al procedimiento almacenado para crear el museo
            $query = "CALL crear_museo(
                :nombre_museo, :descripcion, :tipo_de_museo, :inauguracion,
                :horario, :direccion, :coordenadas, :id_ubicacion
            )";

            $stmt = $con->prepare($query);
            $stmt->execute([
                ':nombre_museo'   => $data['nombre_museo'],
                ':descripcion'    => $data['descripcion'],
                ':tipo_de_museo'  => $data['tipo_de_museo'],
                ':inauguracion'   => $data['inauguracion'],
                ':horario'        => $data['horario'],
                ':direccion'      => $data['direccion'],
                ':coordenadas'    => $data['coordenadas'],
                ':id_ubicacion'   => $data['id_ubicacion']
            ]);

            // rowCount() > 0 indica que se insertó al menos una fila
            if ($stmt->rowCount() > 0) {
                return ResponseHTTP::status201('Museo creado exitosamente.');
            } else {
                return ResponseHTTP::status500('No se pudo crear el museo.');
            }

        } catch (\PDOException $e) {
            error_log('MuseoModel::crear_museo -> ' . $e);
            return ResponseHTTP::status500();
        }
    }


    //metodo para un museo especifico
     final public static function leer_museo ($id_museo) {
        try {
            $con = self::getConnection();

            // Llamada al procedimiento almacenado para obtener un museo por ID
            $query = "CALL leer_museo(:id_museo)";

            $stmt = $con->prepare($query);
            $stmt->execute([':id_museo' => $id_museo]);
            
            $museo = $stmt->fetch(\PDO::FETCH_ASSOC); // Obtener una sola fila

            if ($museo) {
                // Si se encuentra el museo, devolver una respuesta OK con los datos
                return ResponseHTTP::status200('Museo obtenido exitosamente.', $museo);
            } else {
                // Si no se encuentra el museo, devolver un 404
                return ResponseHTTP::status404('No se encontró el museo con el ID proporcionado.');
            }

        } catch (\PDOException $e) {
            error_log('MuseoModel::leer_museo -> ' . $e->getMessage());
            return ResponseHTTP::status500('Error en la base de datos al leer el museo.');
        }
    }


     //metodo ver_museos
      final public static function ver_museos () {
        try {
            $con = self::getConnection();

            // Llamada al procedimiento almacenado para obtener todos los museos activos
            // Si la tabla 'museos' no tiene columna 'activo', quita el 'WHERE activo = 1'
            $query = "CALL ver_museos()";

            $stmt = $con->prepare($query);
            $stmt->execute();
            
            $museos = $stmt->fetchAll(\PDO::FETCH_ASSOC); // Obtener todas las filas

            if ($museos) {
                // Si se encuentran museos, devolver una respuesta OK con los datos
                return ResponseHTTP::status200('Lista de museos obtenida exitosamente.', $museos);
            } else {
                // Si no se encuentran museos activos, devolver un 404
                return ResponseHTTP::status404('No se encontraron museos activos.');
            }

        } catch (\PDOException $e) {
            error_log('MuseoModel::ver_museos -> ' . $e);
            return ResponseHTTP::status500('Error en la base de datos al obtener los museos.');
        }
    }


    
    // Método para actualizar un museo
    final public static function actualizar_museo ($id_museo, $data) {
        try {
            $con = self::getConnection();

            // Validaciones de campos requeridos (capa de seguridad adicional)
            if (
                empty($data['nombre_museo']) || empty($data['descripcion']) || empty($data['tipo_de_museo']) ||
                empty($data['inauguracion']) || empty($data['horario']) || empty($data['direccion']) ||
                empty($data['coordenadas']) || empty($data['id_ubicacion'])
            ) {
                return ResponseHTTP::status400('Faltan campos obligatorios en el modelo para actualizar el museo.');
            }

            // Llamada al procedimiento almacenado para actualizar el museo
            $query = "CALL actualizar_museo(
                :id_museo, :nombre_museo, :descripcion, :tipo_de_museo, :inauguracion,
                :horario, :direccion, :coordenadas, :id_ubicacion
            )";

            $stmt = $con->prepare($query);
            $stmt->execute([
                ':id_museo'       => $id_museo,
                ':nombre_museo'   => $data['nombre_museo'],
                ':descripcion'    => $data['descripcion'],
                ':tipo_de_museo'  => $data['tipo_de_museo'],
                ':inauguracion'   => $data['inauguracion'],
                ':horario'        => $data['horario'],
                ':direccion'      => $data['direccion'],
                ':coordenadas'    => $data['coordenadas'],
                ':id_ubicacion'   => $data['id_ubicacion']
            ]);

            if ($stmt->rowCount() > 0) {
                return ResponseHTTP::status200('Museo actualizado exitosamente.');
            } else {
                // Si rowCount es 0, puede ser que el ID no exista o no hubo cambios
                return ResponseHTTP::status404('No se pudo actualizar el museo. ID no encontrado o no hubo cambios.');
            }

        } catch (\PDOException $e) {
            error_log('MuseoModel::actualizar_museo -> ' . $e);
            return ResponseHTTP::status500();
        }
    }


    // Método para marcar un museo como inactivo (Soft Delete)
    final public static function eliminar_museo ($id_museo) {
        try {
            $con = self::getConnection();

            // Usamos el procedimiento almacenado 'eliminar_museo_sp' para realizar un "soft delete"
            $query = "CALL eliminar_museo(:id_museo)";
            $stmt = $con->prepare($query);
            $stmt->execute([':id_museo' => $id_museo]);

            if ($stmt->rowCount() > 0) {
                // Si rowCount es > 0, significa que se actualizó al menos una fila.
                return ResponseHTTP::status200('Museo marcado como inactivo correctamente.');
            } else {
                // Si rowCount es 0, puede ser que el ID no exista o ya estuviera inactivo.
                return ResponseHTTP::status404('No se encontró el museo para marcar como inactivo o ya estaba inactivo.');
            }

        } catch (\PDOException $e) {
            error_log('MuseoModel::eliminar_museo -> ' . $e);
            return ResponseHTTP::status500('Error en la base de datos al marcar el museo como inactivo: ' . $e);
        }
    }
}
