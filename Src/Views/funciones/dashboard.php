<?php

 use App\Config\Errorlogs;

 session_start();
 
if(isset($_SESSION['usuario']) === TRUE && isset($_SESSION['tiempo']) === TRUE && $_SESSION['usuario'] != "" && $_SESSION['tiempo'] != ""){
    error_log('entro al primer if');
    if(!((time() - $_SESSION['tiempo'])>900)){ 
            include_once './estructura.php';
            encabezado();
            body();
            footer(); 
 }else{
    error_log('entro al primer else');
    session_destroy();
        header('Location: ../auth.php');
   exit();
 }
}else{
    error_log('entro al segundo else');
    session_destroy();
        header('Location: ../auth.php');
   exit();
}