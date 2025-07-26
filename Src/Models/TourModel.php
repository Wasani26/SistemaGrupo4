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
    private static $cupo;

    // Constructor recibe array con datos
    public function __construct($data = []) {
        if (!empty($data)) {
            self::$id = $data['id'] ?? null;
            self::$nombre = $data['nombre'] ?? null;
            self::$descripcion = $data['descripcion'] ?? null;
            self::$fecha = $data['fecha'] ?? null;
            self::$cupo = $data['cupo'] ?? null;
        }
    }

    // Getters
    public static function getId() { return self::$id; }
    public static function getNombre() { return self::$nombre; }
    public static function getDescripcion() { return self::$descripcion; }
    public static function getFecha() { return self::$fecha; }
    public static function getCupo() { return self::$cupo; }

    // Setters
    public static function setId($id) { self::$id = $id; }
    public static function setNombre($nombre) { self::$nombre = $nombre; }
    public static function setDescripcion($descripcion) { self::$descripcion = $descripcion; }
    public static function setFecha($fecha) { self::$fecha = $fecha; }
    public static function setCupo($cupo) { self::$cupo = $cupo; }

    // Crear un tour
    public static function createTour() {
        try {
            $con = self::getConnection();

            // Validar campos obligatorios
            if (empty(self::$nombre) || empty(self::$descripcion) || empty(self::$fecha) || self::$cupo === null) {
                return ResponseHTTP::status400('Faltan campos obligatorios.');
            }

            $sql = "INSERT INTO tours (nombre, descripcion, fecha, cupo) VALUES (:nombre, :descripcion, :fecha, :cupo)";
            $stmt = $con->prepare($sql);
            $stmt->execute([
                ':nombre' => self::$nombre,
                ':descripcion' => self::$descripcion,
                ':fecha' => self::$fecha,
                ':cupo' => self::$cupo
            ]);

            if ($stmt->rowCount() > 0) {
                return ResponseHTTP::status201('Tour creado exitosamente.');
            } else {
                return ResponseHTTP::status500('No se pudo crear el tour.');
            }
        } catch (\PDOException $e) {
            error_log('TourModel::createTour -> '.$e->getMessage());
            return ResponseHTTP::status500('Error en la base de datos.');
        }
    }

    // Obtener todos los tours
    public static function getAllTours() {
        try {
            $con = self::getConnection();
            $sql = "SELECT * FROM tours";
            $stmt = $con->query($sql);
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return ResponseHTTP::status200(json_encode($data));
        } catch (\PDOException $e) {
            error_log('TourModel::getAllTours -> '.$e->getMessage());
            return ResponseHTTP::status500('Error en la base de datos.');
        }
    }

    // Obtener tour por id
    public static function getTour($id) {
        try {
            $con = self::getConnection();
            $sql = "SELECT * FROM tours WHERE id = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute([':id' => $id]);
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($data) {
                return ResponseHTTP::status200($data);
            } else {
                return ResponseHTTP::status404('Tour no encontrado.');
            }
        } catch (\PDOException $e) {
            error_log('TourModel::getTour -> '.$e->getMessage());
            return ResponseHTTP::status500('Error en la base de datos.');
        }
    }

    // Actualizar tour
    public static function updateTour($id, $data) {
        try {
            $con = self::getConnection();

            // Validar campos mínimos
            if (empty($data['nombre']) || empty($data['descripcion']) || empty($data['fecha']) || !isset($data['cupo'])) {
                return ResponseHTTP::status400('Faltan campos obligatorios para actualización.');
            }

            $sql = "UPDATE tours SET nombre = :nombre, descripcion = :descripcion, fecha = :fecha, cupo = :cupo WHERE id = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute([
                ':nombre' => $data['nombre'],
                ':descripcion' => $data['descripcion'],
                ':fecha' => $data['fecha'],
                ':cupo' => $data['cupo'],
                ':id' => $id
            ]);

            if ($stmt->rowCount() > 0) {
                return ResponseHTTP::status200('Tour actualizado correctamente.');
            } else {
                return ResponseHTTP::status400('No se pudo actualizar el tour o no hubo cambios.');
            }
        } catch (\PDOException $e) {
            error_log('TourModel::updateTour -> '.$e->getMessage());
            return ResponseHTTP::status500('Error en la base de datos.');
        }
    }

    // Eliminar tour
    public static function deleteTour($id) {
        try {
            $con = self::getConnection();
            $sql = "DELETE FROM tours WHERE id = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute([':id' => $id]);

            if ($stmt->rowCount() > 0) {
                return ResponseHTTP::status200('Tour eliminado correctamente.');
            } else {
                return ResponseHTTP::status404('No se encontró el tour para eliminar.');
            }
        } catch (\PDOException $e) {
            error_log('TourModel::deleteTour -> '.$e->getMessage());
            return ResponseHTTP::status500('Error en la base de datos.');
        }
    }

    // Cambiar fecha tour
    public static function updateFecha($id, $data) {
        try {
            if (empty($data['fecha'])) {
                return ResponseHTTP::status400('Fecha es obligatoria.');
            }

            $con = self::getConnection();
            $sql = "UPDATE tours SET fecha = :fecha WHERE id = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute([
                ':fecha' => $data['fecha'],
                ':id' => $id
            ]);

            if ($stmt->rowCount() > 0) {
                return ResponseHTTP::status200('Fecha actualizada correctamente.');
            } else {
                return ResponseHTTP::status400('No se pudo actualizar la fecha o no hubo cambios.');
            }
        } catch (\PDOException $e) {
            error_log('TourModel::updateFecha -> '.$e->getMessage());
            return ResponseHTTP::status500('Error en la base de datos.');
        }
    }

    // Cambiar cupo tour
    public static function updateCupo($id, $data) {
        try {
            if (!isset($data['cupo'])) {
                return ResponseHTTP::status400('Cupo es obligatorio.');
            }

            $con = self::getConnection();
            $sql = "UPDATE tours SET cupo = :cupo WHERE id = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute([
                ':cupo' => $data['cupo'],
                ':id' => $id
            ]);

            if ($stmt->rowCount() > 0) {
                return ResponseHTTP::status200('Cupo actualizado correctamente.');
            } else {
                return ResponseHTTP::status400('No se pudo actualizar el cupo o no hubo cambios.');
            }
        } catch (\PDOException $e) {
            error_log('TourModel::updateCupo -> '.$e->getMessage());
            return ResponseHTTP::status500('Error en la base de datos.');
        }
    }
}