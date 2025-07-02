<?php

namespace App\Config;
date_default_timezone_set('America/Tegucigalpa'); //agregamos la zona horaria
class Errorlogs{
    public static function activa_error_logs(){
        error_reporting(E_ALL); //es la activación de los errores en php

        ini_set('ignore_repeated_errors', TRUE);
        ini_set('display_errors', FALSE);
        ini_set('log_errors', TRUE);
        ini_set('error_log', dirname(__DIR__).'/Logs/php-error.log');
    }
}

