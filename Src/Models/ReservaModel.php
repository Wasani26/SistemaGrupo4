<?php
namespace App\Models;
use App\DB\Sql;
use App\DB\ConnectionDB;
use App\Config\ResponseHTTP;
use App\Config\Security;

class ReservaModel extends ConnectionDB{
    private $id_reserva;
    private $fecha_reserva;
    private $estado_reserva;
    private $pagada;
    private $asistencia;
    private $comentarios;
    private $cantidad_asistentes;
    private $id_usuario;
    private $id_tour;

    //constructor
    public function __construct(array $data) {

        if (isset($data['id_reserva'])) {
            $this->id_reserva =$data['id_reserva'];
        }
        $this->fecha_reserva =$data['fecha_reserva'];
        $this->estado_reserva =$data['estado_reserva'];
        $this->pagada =$data['pagada'];
        $this->asistencia =$data['asistencia '];
        $this->comentarios =$data['comentarios'];
        $this->cantidad_asistentes =$data['cantidad_asistentes'];
        $this->id_usuario =$data['id_usuario'];
        $this->id_tour = $data['id_tour'];
    }

    //metodos get
    final public function getId_reserva(){return $this->id_reserva;}
    final public function getFecha_reserva(){return $this->fecha_reserva;}
    final public function getEstado_reserva (){return $this->estado_reserva;}
    final public function getPagada(){return $this->pagada;}
    final public function getAsistencia(){return $this->asistencia;}
    final public function getComentarios(){return $this->comentarios;}
    final public function getCantidad_asistentes(){return $this->cantidad_asistentes;}
    final public function getId_usuario(){return $this->id_usuario;}
    final public function getId_tour(){return $this->id_tour;}

    //metodos set
    final public function setFecha_reserva($fecha_reserva){$this->fecha_reserva = $fecha_reserva;}
    final public function setEstado_reserva($estado_reserva){$this->estado_reserva = $estado_reserva;}
    final public function setPagada($pagada){$this->pagada = $pagada;}
    final public function setAsistencia($asistencia){$this->asistencia = $asistencia;}
    final public function setComentarios($comentarios){$this->comentarios= $comentarios;}
    final public function setCantidad_asistentes($cantidad_asistentes){$this->cantidad_asistentes= $cantidad_asistentes;}
    final public function setId_usuario($id_usuario){$this->id_usuario= $id_usuario;}
    final public function setId_tour($id_tour){$this->id_tour= $id_tour;}


       final public function crear_reserva(){
        // Validar que la reserva no exista previamente verificando fecha, tour y usuario//
        if (Sql::verificar_registro(
            "CALL verificar_reserva(:fecha_reserva, :id_tour, :id_usuario)", //Parámetros para verificar la creacion//
            [
                ':fecha_reserva' => $this->getFecha_reserva(),
                ':id_tour' => $this->getId_tour(),
                ':id_usuario' => $this->getId_usuario()
            ]
        )) {
            //El mensaje debería indicar que ya existe/
            return ResponseHTTP::status400('Ya existe una reserva con estos criterios.');
            }
    
    
        try {
            $con = self::getConnection();
            // Llamado a procedimiento almacenado para insertar la reserva//
            $query = "CALL crear_reserva(
                :fecha_reserva, :estado_reserva, :pagada, :asistencia, :comentarios, :cantidad_asistentes, :id_usuario, :id_tour
            )"; //Parámetros para id_usuario y id_tour//

            $stmt = $con->prepare($query);
            $stmt->execute([
                ':fecha_reserva'        => $this->getFecha_reserva(),
                ':estado_reserva'       => $this->getEstado_reserva(),
                ':pagada'               => $this->getPagada(),
                ':asistencia'           => $this->getAsistencia(),
                ':comentarios'          => $this->getComentarios(),
                ':cantidad_asistentes'  => $this->getCantidad_asistentes(),
                ':id_usuario'           => $this->getId_usuario(),
                ':id_tour'              => $this->getId_tour(),
            ]);

            if ($stmt->rowCount() > 0) {
                return ResponseHTTP::status201('La reserva ha sido creada exitosamente.');
            } else {
                return ResponseHTTP::status400('No se pudo crear la reserva. Verifique los datos.');
            }

        } 
        
        catch (\PDOException $e) { //Captura de excepciones PDO para errores de DB//
            error_log("Error al crear reserva: " . $e->getMessage());
            return ResponseHTTP::status500('Error interno del servidor al crear la reserva.');
        }
    
    }

}