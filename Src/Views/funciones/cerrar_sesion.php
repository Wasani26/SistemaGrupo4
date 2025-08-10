<?php
  
$caso = filter_input(INPUT_POST, "caso");

switch ($caso) {
    case "cerrar_sesion":
        cerrar_sesion();
        break;
    default:
        break;
}

function cerrar_sesion(){
      
session_start();

session_unset();
session_destroy();
header("Location: ../auth.php");
exit;

}