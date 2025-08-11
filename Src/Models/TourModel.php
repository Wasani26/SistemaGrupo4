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
        private static $id_usuario; // 

        public function __construct($data = []) {
        if (!empty($data)) {
            self::$id = $data['id'] ?? null;
            self::$nombre = $data['nombre'] ?? null;
            self::$descripcion = $data['descripcion'] ?? null;
            self::$fecha = $data['fecha'] ?? null;
            self::$inicio = $data['hora_inicio'] ?? null;
            self::$duracion = $data['duracion'] ?? null;
            self::$cupo = $data['cupo_maximo'] ?? null;
            self::$idioma = $data['idioma_tour'] ?? null;
            self::$encuentro = $data['punto_encuentro'] ?? null;
            self::$comentario = $data['comentario'] ?? null;
            self::$museo = $data['id_museo'] ?? null;
            self::$id_usuario = $data['id_usuario'] ?? null;
        }
    }

        // Getters
        public static function getId() { return self::$id; }
        public static function getNombre() { return self::$nombre; }
        public static function getDescripcion() { return self::$nombre; } // Error: debería ser self::$descripcion
        public static function getFecha() { return self::$fecha; }
        public static function getInicio() { return self::$inicio; }
        public static function getDuracion() { return self::$duracion; }
        public static function getCupo() { return self::$cupo; }
        public static function getIdioma() { return self::$idioma; }
        public static function getEncuentro() { return self::$encuentro; }
        public static function getComentario() { return self::$comentario; }
        public static function getMuseo() { return self::$museo; }
        public static function getIdUsuario() { return self::$id_usuario; } // ¡Nuevo Getter!

        // Setters (añadir setIdUsuario si es necesario)
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
        public static function setIdUsuario($id_usuario) { self::$id_usuario = $id_usuario; } // ¡Nuevo Setter!


        // Crear un tour
        public static function creartour() {
        try {
            $con = self::getConnection();

            // Validar campos obligatorios
            if (
                empty(self::$nombre) || empty(self::$descripcion) || empty(self::$fecha) ||
                empty(self::$cupo) || empty(self::$inicio) || empty(self::$duracion) ||
                empty(self::$idioma) || empty(self::$encuentro) || empty(self::$comentario) ||
                empty(self::$museo) || empty(self::$id_usuario)
            ) {
                return ResponseHTTP::status400('Faltan campos obligatorios en el modelo.');
            }

            // --- ¡Aquí está la corrección para el formato de la fecha! ---
            // Convertir la fecha de DD-MM-AAAA a AAAA-MM-DD
            $fecha_para_db = \DateTime::createFromFormat('d-m-Y', self::$fecha);
            if (!$fecha_para_db) {
                // Si la conversión falla (aunque el controlador ya validó el formato,
                // es buena práctica tener un fallback o un error más específico aquí)
                return ResponseHTTP::status400('Formato de fecha inválido para la base de datos.');
            }
            $fecha_formateada = $fecha_para_db->format('Y-m-d');
            // -----------------------------------------------------------

            $query = "CALL crear_tour(
                :titulo, :descripcion, :fecha, :inicio, :duracion, :cupo, :idioma, :encuentro, :comentario, :museo, :id_usuario
            )";

            $stmt = $con->prepare($query);
            $stmt->execute([
                ':titulo'      => self::$nombre,
                ':descripcion' => self::$descripcion,
                ':fecha'       => $fecha_formateada, 
                ':inicio'      => self::$inicio,
                ':duracion'    => self::$duracion,
                ':cupo'        => self::$cupo,
                ':idioma'      => self::$idioma,
                ':encuentro'   => self::$encuentro,
                ':comentario'  => self::$comentario,
                ':museo'       => self::$museo,
                ':id_usuario'  => self::$id_usuario
            ]);

            if ($stmt->rowCount() > 0) {
                return ResponseHTTP::status201('Tour creado exitosamente.');
            } else {
                return ResponseHTTP::status500('No se pudo crear el tour.');
            }

        } catch (\PDOException $e) {
            error_log('TourModel::creartour -> '.$e);
            return ResponseHTTP::status500();
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

  public static function obtener_tour() {
        try {
            $con = self::getConnection();
            // ¡IMPORTANTE!: Solo selecciona tours donde 'activo' es 1
            $sql = "CALL obtener_tour()";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $tours = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if ($tours) {
                return ResponseHTTP::status200('Tours obtenidos exitosamente.', $tours);
            } else {
                return ResponseHTTP::status404('No se encontraron tours activos.');
            }
        } catch (\PDOException $e) {
            error_log('TourModel::obtener_tour -> ' . $e);
            return ResponseHTTP::status500('Error en la base de datos.');
        }
    }


    // Obtener tour por id
    public static function leer_Tour($id) {
    try {
       $con = self::getConnection();
        $query = "CALL leer_tour(:id)";
        $stmt = $con->prepare($query);
        $stmt->execute([
            ':id' => $id
        ]);

       if($stmt->rowCount() > 0){
            $res['data'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $res;
        } else {
            return ResponseHTTP::status400('No existe registro de este tour!');
        }
    } catch(\PDOException $e){
        error_log("TourModel::leer_tour -> ".$e);
        die(json_encode(ResponseHTTP::status500()));
    }
}

    // Actualizar tour
 public static function actualizar_tour($id_tour, $data) {
        try {
            $con = self::getConnection();

            // Validaciones de campos requeridos (usando los nombres correctos del JSON)
            // Estas validaciones son redundantes si el controlador ya las hace,
            // pero sirven como una capa de seguridad adicional.
            if (
                empty($data['nombre']) || empty($data['descripcion']) || empty($data['fecha']) ||
                empty($data['hora_inicio']) || empty($data['duracion']) || empty($data['cupo_maximo']) ||
                empty($data['idioma_tour']) || empty($data['punto_encuentro']) || empty($data['comentario']) ||
                empty($data['id_museo']) || empty($data['id_usuario']) // ¡Corregido a id_usuario!
            ) {
                return ResponseHTTP::status400('Faltan campos obligatorios para la actualización.');
            }

            // --- Conversión de formato de fecha (DD-MM-AAAA a AAAA-MM-DD) ---
            $fecha_para_db = \DateTime::createFromFormat('d-m-Y', $data['fecha']);
            if (!$fecha_para_db) {
                return ResponseHTTP::status400('Formato de fecha inválido para la base de datos.');
            }
            $fecha_formateada = $fecha_para_db->format('Y-m-d');

            // --- Conversión de formato de hora (HH:MM a HH:MM:SS si es necesario) ---
            // MySQL suele aceptar HH:MM para columnas TIME, pero si hay problemas,
            // se puede usar: $hora_para_db = \DateTime::createFromFormat('H:i', $data['hora_inicio'])->format('H:i:s');
            $hora_formateada = $data['hora_inicio']; // Asumimos que HH:MM es suficiente para TIME

            $sql = "CALL actualizar_tour(
                :id_tour, :titulo, :descripcion, :fecha, :inicio, :duracion,
                :cupo, :idioma, :encuentro, :comentario, :museo, :id_usuario
            )";

            $stmt = $con->prepare($sql);
            $stmt->execute([
                ':id_tour'     => $id_tour, // El ID del tour a actualizar
                ':titulo'      => $data['nombre'],
                ':descripcion' => $data['descripcion'],
                ':fecha'       => $fecha_formateada, // ¡Usar la fecha formateada!
                ':inicio'      => $hora_formateada,  // Usar la hora (formateada si se hizo)
                ':duracion'    => $data['duracion'],
                ':cupo'        => $data['cupo_maximo'], // ¡Corregido a cupo_maximo!
                ':idioma'      => $data['idioma_tour'], // ¡Corregido a idioma_tour!
                ':encuentro'   => $data['punto_encuentro'], // ¡Corregido a punto_encuentro!
                ':comentario'  => $data['comentario'],
                ':museo'       => $data['id_museo'], // ¡Corregido a id_museo!
                ':id_usuario'  => $data['id_usuario'] // ¡Corregido a id_usuario!
            ]);

            if ($stmt->rowCount() > 0) {
                return ResponseHTTP::status200('Tour actualizado correctamente.');
            } else {
                // Si rowCount es 0, puede ser que el ID no exista o los datos sean los mismos
                return ResponseHTTP::status404('No se pudo actualizar el tour. ID no encontrado o no hubo cambios.');
            }
        } catch (\PDOException $e) {
            error_log('TourModel::actualizar_tour -> ' . $e->getMessage());
            return ResponseHTTP::status500('Error en la base de datos.');
        }
    }

    
    // Método para marcar un tour como inactivo (Soft Delete)
    public static function eliminarTour($id) {
        try {
            $con = self::getConnection();

            // Usamos el procedimiento almacenado 'borrartour' para realizar un "soft delete"
            $sql = "CALL eliminar_tour(:id)";
            $stmt = $con->prepare($sql);
            $stmt->execute([':id' => $id]);

            if ($stmt->rowCount() > 0) {
                return ResponseHTTP::status200('Tour marcado como inactivo correctamente.');
            } else {
                // Si rowCount es 0, puede ser que el ID no exista o ya estuviera inactivo
                return ResponseHTTP::status404('No se encontró el tour para marcar como inactivo o ya estaba inactivo.');
            }
        } catch (\PDOException $e) {
            error_log('TourModel::eliminar_tour -> ' . $e->getMessage());
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
public function getAllTours() {
    return self::obtenerTodosLosTours();
}

public function getTour($id) {
    return self::obtener_Tour($id);
}
}