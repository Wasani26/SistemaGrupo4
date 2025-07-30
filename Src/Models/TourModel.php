<?php
namespace App\Models;
use App\DB\Sql;
use App\DB\ConnectionDB;
use App\Config\ResponseHTTP;
use App\Config\Security;

class TourModel extends ConnectionDB {
    private static $id;
    private static $nombre;
    private static $descripcion;
    private static $fecha;
    private static $inicio;
    private static $duracion;
    private static $cupo;
    private static $idioma;
    private static $encuentro;
    private static $comentario;
    private static $museo;
    private static $guia;

    public function __construct($data = []) {
        if (!empty($data)) {
            self::$id = $data['id'] ?? null;
            self::$nombre = $data['nombre'] ?? null;
            self::$descripcion = $data['descripcion'] ?? null;
            self::$fecha = $data['fecha'] ?? null;
            self::$inicio = $data['inicio'] ?? null;
            self::$duracion = $data['duracion'] ?? null;
            self::$cupo = $data['cupo'] ?? null;
            self::$idioma = $data['idioma'] ?? null;
            self::$encuentro = $data['encuentro'] ?? null;
            self::$comentario = $data['comentario'] ?? null;
            self::$museo = $data['museo'] ?? null;
            self::$guia = $data['guia'] ?? null;
        }
    }

    // Getters
    public static function getId() { return self::$id; }
    public static function getNombre() { return self::$nombre; }
    public static function getDescripcion() { return self::$descripcion; }
    public static function getFecha() { return self::$fecha; }
    public static function getInicio() { return self::$inicio; }
    public static function getDuracion() { return self::$duracion; }
    public static function getCupo() { return self::$cupo; }
    public static function getIdioma() { return self::$idioma; }
    public static function getEncuentro() { return self::$encuentro; }
    public static function getComentario() { return self::$comentario; }
    public static function getMuseo() { return self::$museo; }
    public static function getGuia() { return self::$guia; }

    // Setters
    public static function setId($id) { self::$id = $id; }
    public static function setNombre($nombre) { self::$nombre = $nombre; }
    public static function setDescripcion($descripcion) { self::$descripcion = $descripcion; }
    public static function setFecha($fecha) { self::$fecha = $fecha; }
    public static function setInicio($inicio) { self::$inicio = $inicio; }
    public static function setDuracion($duracion) { self::$duracion = $duracion; }
    public static function setCupo($cupo) { self::$cupo = $cupo; }
    public static function setIdioma($idioma) { self::$idioma = $idioma; }
    public static function setEncuentro($encuentro) { self::$encuentro = $encuentro; }
    public static function setComentario($comentario) { self::$comentario = $comentario; }
    public static function setMuseo($museo) { self::$museo = $museo; }
    public static function setGuia($guia) { self::$guia = $guia; }

    // Crear un tour
    public static function creartour() {
    try {
        $con = self::getConnection();

        // Validar campos obligatorios (ajusta los nombres según lo que recibas)
        if (
            empty(self::$nombre) || empty(self::$descripcion) || empty(self::$fecha) ||
            empty(self::$cupo) || empty(self::$inicio) || empty(self::$duracion) ||
            empty(self::$idioma) || empty(self::$encuentro) || empty(self::$comentario) ||
            empty(self::$museo) || empty(self::$guia)
        ) {
            return ResponseHTTP::status400('Faltan campos obligatorios.');
        }

        $query = "CALL creartour(
            :titulo, :descripcion, :fecha, :inicio, :duracion, :cupo, :idioma, :encuentro, :comentario, :museo, :guia
        )";

        $stmt = $con->prepare($query);
        $stmt->execute([
            ':titulo'     => self::$nombre,
            ':descripcion'=> self::$descripcion,
            ':fecha'      => self::$fecha,
            ':inicio'     => self::$inicio,
            ':duracion'   => self::$duracion,
            ':cupo'       => self::$cupo,
            ':idioma'     => self::$idioma,
            ':encuentro'  => self::$encuentro,
            ':comentario' => self::$comentario,
            ':museo'      => self::$museo,
            ':guia'       => self::$guia
        ]);

        if ($stmt->rowCount() > 0) {
            return ResponseHTTP::status201('Tour creado exitosamente.');
        } else {
            return ResponseHTTP::status500('No se pudo crear el tour.');
        }

    } catch (\PDOException $e) {
        error_log('TourModel::creartour -> '.$e->getMessage());
        return ResponseHTTP::status500('Error en la base de datos.');
    }
}

    // Obtener todos los tours
   public static function obtenerTodosLosTours() {
    try {
        $con = self::getConnection();
        $sql = "CALL leertours()";
        $stmt = $con->query($sql);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return ResponseHTTP::status200(json_encode($data));
    } catch (\PDOException $e) {
        error_log('TourModel::obtenerTodosLosTours -> ' . $e->getMessage());
        return ResponseHTTP::status500('Error en la base de datos.');
    }
}

    // Obtener tour por id
    public static function obtenerTour($id) {
    try {
        $con = self::getConnection();
        $sql = "CALL leertour(:id)";
        $stmt = $con->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($data) {
            return ResponseHTTP::status200($data);
        } else {
            return ResponseHTTP::status404('Tour no encontrado.');
        }
    } catch (\PDOException $e) {
        error_log('TourModel::obtenerTour -> ' . $e->getMessage());
        return ResponseHTTP::status500('Error en la base de datos.');
    }
}

    // Actualizar tour
public static function actualizarTour($id, $data) {
    try {
        $con = self::getConnection();

        // Validación de campos requeridos
        if (
            empty($data['nombre']) || empty($data['descripcion']) || empty($data['fecha']) ||
            empty($data['inicio']) || empty($data['duracion']) || empty($data['cupo']) ||
            empty($data['idioma']) || empty($data['encuentro']) || empty($data['comentario']) ||
            empty($data['museo']) || empty($data['guia'])
        ) {
            return ResponseHTTP::status400('Faltan campos obligatorios para la actualización.');
        }

        $sql = "CALL actualizartour(
            :id, :titulo, :descripcion, :fecha, :inicio, :duracion,
            :cupo, :idioma, :encuentro, :comentario, :museo, :guia
        )";

        $stmt = $con->prepare($sql);
        $stmt->execute([
            ':id'          => $id,
            ':titulo'      => $data['nombre'],
            ':descripcion' => $data['descripcion'],
            ':fecha'       => $data['fecha'],
            ':inicio'      => $data['inicio'],
            ':duracion'    => $data['duracion'],
            ':cupo'        => $data['cupo'],
            ':idioma'      => $data['idioma'],
            ':encuentro'   => $data['encuentro'],
            ':comentario'  => $data['comentario'],
            ':museo'       => $data['museo'],
            ':guia'        => $data['guia']
        ]);

        if ($stmt->rowCount() > 0) {
            return ResponseHTTP::status200('Tour actualizado correctamente.');
        } else {
            return ResponseHTTP::status400('No se pudo actualizar el tour o no hubo cambios.');
        }
    } catch (\PDOException $e) {
        error_log('TourModel::actualizarTour -> ' . $e->getMessage());
        return ResponseHTTP::status500('Error en la base de datos.');
    }
}

    // Eliminar tour
public static function eliminarTour($id) {
    try {
        $con = self::getConnection();

        // Usamos el procedimiento almacenado 'borrartour'
        $sql = "CALL borrartour(:id)";
        $stmt = $con->prepare($sql);
        $stmt->execute([':id' => $id]);

        if ($stmt->rowCount() > 0) {
            return ResponseHTTP::status200('Tour eliminado correctamente.');
        } else {
            return ResponseHTTP::status404('No se encontró el tour para eliminar.');
        }
    } catch (\PDOException $e) {
        error_log('TourModel::eliminarTour -> ' . $e->getMessage());
        return ResponseHTTP::status500('Error en la base de datos.');
    }
}

    // Cambiar fecha tour
public static function cambiarFecha($id, $data) {
    try {
        if (empty($data['fecha'])) {
            return ResponseHTTP::status400('La fecha es obligatoria.');
        }

        $con = self::getConnection();

        // Usamos el procedimiento almacenado 'actualizarfecha'
        $sql = "CALL actualizarfecha(:id, :fecha)";
        $stmt = $con->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':fecha' => $data['fecha']
        ]);

        if ($stmt->rowCount() > 0) {
            return ResponseHTTP::status200('Fecha actualizada correctamente.');
        } else {
            return ResponseHTTP::status400('No se pudo actualizar la fecha o no hubo cambios.');
        }
    } catch (\PDOException $e) {
        error_log('TourModel::cambiarFecha -> ' . $e->getMessage());
        return ResponseHTTP::status500('Error en la base de datos.');
    }
}

    // Cambiar cupo tour
public static function cambiarCupo($id, $data) {
    try {
        if (!isset($data['cupo'])) {
            return ResponseHTTP::status400('El cupo es obligatorio.');
        }

        $con = self::getConnection();
        $sql = "CALL actualizarcupo(:id, :cupo)";
        $stmt = $con->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':cupo' => $data['cupo']
        ]);

        if ($stmt->rowCount() > 0) {
            return ResponseHTTP::status200('Cupo actualizado correctamente.');
        } else {
            return ResponseHTTP::status400('No se pudo actualizar el cupo o no hubo cambios.');
        }
    } catch (\PDOException $e) {
        error_log('TourModel::cambiarCupo -> ' . $e->getMessage());
        return ResponseHTTP::status500('Error en la base de datos.');
    }
}
}