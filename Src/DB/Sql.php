<?php
namespace App\DB;

class Sql extends ConnectionDB{

    //metodo que permite verificar si existe un registro en una bd ciertos parametros y condiciones
    public static function verificar_registro($sql, $condicion, $params){
        try{
            //abrimos una conexión 
            $con = self::getConnection(); 
            $query = $con->prepare($sql); //preparamos la consulta que viene el parametro $sql
            $query->execute([
                $condicion=>$params  //pasamos la condicion de la consulta y los parametros correspondientes a traves de un array asociativo
            ]);

            //ahora recorremos y contamos los datos retornados
            $res = ($query->rowCount() == 0) ? false : true; 
            return $res; //retorna una palabra
        } catch (\PDOException $e) {
            error_log("sql::verificar_registro -> ".$e);
            //retorna un error apropiado
            die(json_encode(ResponseHTTP::status500()));
        }
    }
}