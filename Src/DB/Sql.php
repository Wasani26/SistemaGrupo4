<?php
namespace App\DB;
use App\Config\ResponseHTTP;
use App\DB\ConnectionDB;

class Sql extends ConnectionDB {

    // Método que permite verificar si existe un registro en la BD
    public static function verificar_registro($sql, $condicion, $params) {
        try {
            $con = self::getConnection();
            $query = $con->prepare($sql);
            $query->execute([
                $condicion => $params
            ]);

            $resultado = $query->fetch(\PDO::FETCH_ASSOC);

            // Validamos que la columna 'existe' venga en el resultado
            if ($resultado && isset($resultado['existe']) && $resultado['existe'] > 0) {
                return true; // El registro sí existe
            }

            return false; // El registro no existe

        } catch (\PDOException $e) {
            error_log("sql::verificar_registro -> " . $e);
            die(json_encode(ResponseHTTP::status500()));
        }
    }
}
