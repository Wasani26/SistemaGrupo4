<?php
 session_start();
 
 if($_SERVER ['REQUEST_METHOD'] === 'POST') {
    $entrada = file_get_contents('php://input');
    $data = json_decode($entrada, true);
      if(isset($data['usuario'], $data['rol'], $data['token'])){
         $_SESSION['usuario'] = $data['usuario'];
         $_SESSION['rol'] = $data['rol'];
         $_SESSION['token'] = $data['token'];
         $_SESSION['tiempo'] = time();
       echo json_encode(['success'=> true,'message' => 'Sesión iniciada']);

      }else{
         echo json_encode(['success'=> false,'message' => 'Acceso denegado, prueba de nuevo', 'data' => $data]);
      }
 }else{
     echo json_encode(['success'=> false,'message' => 'Método no permitido.']);
}
  