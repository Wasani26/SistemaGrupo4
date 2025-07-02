<?php
use App\Config\Security;
 
 echo json_encode(Security::secretKey());
 echo json_encode(Security::createPassword("hola"));

 //valida contraseña
 $pass = Security::createPassword("hola");
 if(Security::validatePassword("hola", $pass)){
    echo json_encode("Contraseña correcta");
 }else{
    echo json_encode("Contraseña incorrecta");
 }


 echo (json_encode(Security::createTokenjwt(Security::secretKey(),["hola"])));

 //prueba de la conexión a la BD
 use App\DB\ConnectionDB;
 ConnectionDB::getConnection();

