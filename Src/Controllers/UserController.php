<?php

namespace App\Controllers;
use App\Config\ResponseHTTP;
use App\Config\Security;
use App\Models\UserModel;
use Firebase\JWT\ExpiredException; // Importa la excepción de JWT
use Firebase\JWT\SignatureInvalidException; // Importa otras excepciones comunes de JWT
use Firebase\JWT\BeforeValidException;

class UserController{
    private $method;
    private $route;
    private $params;
    private $data;
    private $headers;

    // Expresiones regulares datos de usuario y persona (uno solo)
       private static $validar_nombre        = '/^[a-zA-ZÁÉÍÓÚáéíóúñÑ\s]{2,100}$/';
       private static $validar_telefono      = '/^\d{4}-\d{4}$/';
       private static $validar_dni           = '/^\d{4}-\d{4}-\d{5}$/';
       private static $validar_fecha         = '/^\d{2}-\d{2}-\d{4}$/';
       private static $validar_texto         = '/^[a-zA-ZÁÉÍÓÚáéíóúñÑ\s]{2,50}$/';
       private static $validar_usuario       = '/^[a-zA-Z0-9_]{4,20}$/';
       private static $validar_url           = '/^.+\.(jpg|jpeg|png|gif)$/i';


    public function __construct($method,$route,$params,$data,$headers){
        $this->method = $method;
        $this->route = $route;
        $this->params = $params;
        $this->data = $data;
        $this->headers = $headers;
    }

    
    //metodo que recibe un endpoint (ruta a un recurso)
    final public function crear_usuario_completo($endpoint){
        //validamos el method y el endpoint
        if($this->method == 'post' && $endpoint == $this->route){
             
            Security::validateTokenJwt($this->headers, Security::secretKey());

        $data = $this->data;


        // Validar existencia de campos
        $campos_requeridos = ['nombre', 'correo', 'telefono', 'dni', 'fecha_nacimiento', 'nacionalidad', 'nombre_usuario', 'contrasena', 'confirmar_contrasena'];

        foreach ($campos_requeridos as $campo) {
            if (!isset($data[$campo]) || empty($data[$campo])) {
                echo json_encode(ResponseHTTP::status400("El campo '$campo' es obligatorio."));
                exit;
            }
        }

        // Validaciones de contenido
        if (!preg_match(self::$validar_nombre, $data['nombre'])) {
            echo json_encode(ResponseHTTP::status400('Nombre inválido'));
            exit;
        }

        if (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            echo json_encode(ResponseHTTP::status400('Correo inválido'));
            exit;
        }

        if (!preg_match(self::$validar_telefono, $data['telefono'])) {
            echo json_encode(ResponseHTTP::status400('Teléfono inválido'));
            exit;
        }

        if (!preg_match(self::$validar_dni, $data['dni'])) {
            echo json_encode(ResponseHTTP::status400('DNI inválido'));
            exit;
        }

        if (!preg_match(self::$validar_fecha, $data['fecha_nacimiento'])) {
            echo json_encode(ResponseHTTP::status400('Fecha de nacimiento inválida'));
            exit;
        }

        if (!preg_match(self::$validar_texto, $data['nacionalidad'])) {
            echo json_encode(ResponseHTTP::status400('Nacionalidad inválida'));
            exit;
        }

        if (!preg_match(self::$validar_usuario, $data['nombre_usuario'])) {
            echo json_encode(ResponseHTTP::status400('Nombre de usuario inválido'));
            exit;
        }

        if (empty($data['contrasena']) || $data['contrasena'] !== $data['confirmar_contrasena']) {
            echo json_encode(ResponseHTTP::status400('Las contraseñas no coinciden o están vacías'));
            exit;
        }

        // Validar URL de foto si viene (opcional)
        if (!empty($data['url_foto']) && !preg_match(self::$validar_url, $data['url_foto'])) {
            echo json_encode(ResponseHTTP::status400('URL de foto no válida'));
            exit;
        }

        // Asignar campos automáticos
        $fecha_creacion = date('Y-m-d H:i:s');
        $tipo_rol = 'visitante'; // por defecto
        $activo = 1; // por defecto

          new UserModel($this->data);
          echo json_encode(UserModel::crear_usuario_completo());
       
            exit;
        }
    }

    //ingresar al sistema 
    final public function login($endpoint){
        //validacion del metodo y endpoint/ruta
        if($this->method == 'get' && $endpoint == $this->route){
            $usuario = strtolower($this->params[1]); //se pasa el correo
            $pass = $this->params[2]; //se pasa la contraseña

            //validaciones
            if(empty($usuario) || empty($pass)){
                echo json_encode(ResponseHTTP::status400('Todos los campos son requeridos, por favor proceda a llenarlos.'));
            }else{
                UserModel::setNombreUsuario($usuario);
                UserModel::setContrasena($pass);
                echo json_encode(UserModel::login());
            }
        exit;
    }
  }
 
    final public function cambiar_contrasena($endpoint) {
    // La ruta esperada ahora es "user/password"
    if ($this->method == 'patch' && $endpoint == $this->route) {
        //error_log(">> Entrando a cambiar_contrasena. Route: " . $this->route);
        //error_log(">> Comparando contra: " . $endpoint); // Muestra la ruta esperada

        try {
            // 1. Validar token
            // Captura las excepciones específicas de JWT
            $userData = Security::validateTokenJwt($this->headers, Security::secretKey());
            error_log("Datos del JWT decodificados: " . print_r($userData, true));
        } catch (ExpiredException $e) {
            ResponseHTTP::status401('Token expirado. Por favor, inicia sesión de nuevo.');
            exit; // Importante para detener la ejecución
        } catch (SignatureInvalidException $e) {
            ResponseHTTP::status401('Firma de token inválida. Acceso denegado.');
            exit;
        } catch (BeforeValidException $e) {
            ResponseHTTP::status401('Token aún no válido. Inténtalo de nuevo más tarde.');
            exit;
        } catch (\Exception $e) { // Captura cualquier otra excepción general de JWT o de validación
            ResponseHTTP::status401('Token inválido o error de autenticación: ' . $e->getMessage());
            exit;
        }


        // 2. Validar campos necesarios
        if (!isset($this->data['contrasena_actual'], $this->data['nueva_contrasena'], $this->data['confirmar_contrasena'])) {
            ResponseHTTP::status400('Faltan campos requeridos: contrasena_actual, nueva_contrasena, confirmar_contrasena.');
            exit; // Importante para detener la ejecución
        }

        $contrasenaActual = $this->data['contrasena_actual'];
        $nuevaContrasena = $this->data['nueva_contrasena'];
        $confirmarContrasena = $this->data['confirmar_contrasena'];

        if ($nuevaContrasena !== $confirmarContrasena) {
            ResponseHTTP::status400('La nueva contraseña y la confirmación no coinciden.');
            exit; // Importante para detener la ejecución
        }

        // 3. Obtener usuario por ID desde el token
       // $userId = $userData->id;
        //$usuarioModel = new UserModel();
        $db_connection = ConnectionDB::getConnection(); // Llama al método estático para obtener la instancia PDO
         $usuarioModel = new UserModel($db_connection);
        // CORRECCIÓN AQUÍ: Usar el nombre de método correcto del modelo
        $userId = $userData->data->idUsuario;
        $usuario = $usuarioModel->obtener_usuario_id($userId);

        if (!$usuario) {
            ResponseHTTP::sttaus404('Usuario no encontrado.');
            exit; // Importante para detener la ejecución
        }

        // 4. Verificar contraseña actual
        // Asegúrate de que $usuario['clave'] contenga el hash de la contraseña de la DB
        if (!password_verify($contrasenaActual, $usuario['clave'])) {
            ResponseHTTP::status401('La contraseña actual es incorrecta.');
            exit; // Importante para detener la ejecución
        }

        // 5. Hashear nueva contraseña y actualizar
        $hash = password_hash($nuevaContrasena, PASSWORD_BCRYPT);
        $resultado = $usuarioModel->updatePassword($userId, $hash);

        if ($resultado) {
            ResponseHTTP::status200('Contraseña actualizada correctamente.');
        } else {
            ResponseHTTP::status500('Error al actualizar la contraseña.');
        }

        exit; // Finaliza la ejecución después de enviar la respuesta
    }
}


    
    final public function actualizar_usuario($endpoint){
    // validamos el método y el endpoint
    if($this->method == 'put' && $endpoint == $this->route){
        echo json_encode('put');
        exit;
       }
    }

   final public function leer_usuario($endpoint){
    if($this->method == 'get' && $endpoint == $this->route){
        Security::validateTokenJwt($this->headers, Security::secretKey());
        $usuario = $this->params[1] ?? null;
        if(!$usuario){
            echo json_encode(ResponseHTTP::status400('Debe ingresar un nombre de usuario!'));
        } else {
            echo json_encode(UserModel::leer_usuario($usuario));
            exit;
        }
    }
   }

  
    
    //permite ver todos los usuarios
    final public function obtener_usuarios($endpoint){
    // validamos el método y el endpoint
    if($this->method == 'get' && $endpoint == $this->route){
       Security::validateTokenJwt($this->headers, Security::secretKey());
       echo json_encode(UserModel::obtener_usuarios());
        exit;
      }
    }
   
    


}