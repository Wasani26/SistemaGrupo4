<?php
namespace App\Models;
use App\DB\Sql;
use App\DB\ConnectionDB;
use App\Config\ResponseHTTP;
use App\Config\Security;
use App\Models\UserModel;

class ReservaModel extends ConnectionDB{
    private $id_reserva;
    private $asistencia;
    private $comentarios;
    private $cantidad_asistentes;
    private $id_usuario;
    private $id_tour;
    private $monto;
    private $moneda;
    private $metodo_pago; 
    private $fecha_pago;
    private $estado;   

    //constructor
    public function __construct(array $data) {

        if (isset($data['id_reserva'])) {
            $this->id_reserva =$data['id_reserva'];
        }
        $this->asistencia =$data['asistencia'];
        $this->comentarios =$data['comentarios'];
        $this->cantidad_asistentes =$data['cantidad_asistentes'];
        $this->id_usuario =$data['id_usuario'];
        $this->id_tour = $data['id_tour'];
        $this->monto = $data['monto'];
        $this->moneda = $data['moneda'];
        $this->metodo_pago = $data['metodo_pago'];
        $this->fecha_pago = $data['fecha_pago'];
        $this->estado = $data['estado'];
    }

    //metodos get
    final public function getId_reserva(){return $this->id_reserva;}
    final public function getAsistencia(){return $this->asistencia;}
    final public function getComentarios(){return $this->comentarios;}
    final public function getCantidad_asistentes(){return $this->cantidad_asistentes;}
    final public function getId_usuario(){return $this->id_usuario;}
    final public function getId_tour(){return $this->id_tour;}
    final public function getMonto(){return $this->monto;}
    final public function getMoneda(){return $this->moneda;}
    final public function getMetodo_pago(){return $this->metodo_pago;}
    final public function getFecha_pago(){return $this->fecha_pago;}
    final public function getEstado(){return $this->estado;}

    //metodos set
    final public function setId_reserva($id_reserva){$this->id_reserva= $id_reserva;}
    final public function setAsistencia($asistencia){$this->asistencia = $asistencia;}
    final public function setComentarios($comentarios){$this->comentarios= $comentarios;}
    final public function setCantidad_asistentes($cantidad_asistentes){$this->cantidad_asistentes= $cantidad_asistentes;}
    final public function setId_usuario($id_usuario){$this->id_usuario= $id_usuario;}
    final public function setId_tour($id_tour){$this->id_tour= $id_tour;}
    final public function setMonto($monto){$this->monto= $monto;}
    final public function setMoneda($moneda){$this->moneda= $moneda;}
    final public function setMetodo_pago($metodo_pago){$this->metodo_pago=$metodo_pago;}
    final public function setfecha_pago($fecha_pago){$this->fecha_pago= $fecha_pago;}
    final public function setEstado($estado){$this->estado=$estado;}

    final public function crear_reserva() {
    // Captura de datos
    $id_tour       = $this->getId_tour();
    $id_usuario    = $this->getId_usuario();

    try {
        $con = self::getConnection();

        // Validación de duplicado por procedimiento almacenado
        $stmt_verificar = $con->prepare("CALL verificar_reserva( :id_usuario, :id_tour)");
        $stmt_verificar->execute([
           /* ':id_usuario'    => $id_usuario,
            ':id_tour'       => $id_tour */
            ':id_usuario' => $this->getId_usuario(),
            ':id_tour' => $this->getId_tour()
        ]);

        $resultado = $stmt_verificar->fetch(\PDO::FETCH_ASSOC);
        // Cierre del cursor para evitar el error 2014
        $stmt_verificar->closeCursor();

        if ($resultado && isset($resultado['existe']) && $resultado['existe'] > 0) {
            return ResponseHTTP::status400("Ya existe una reserva para este usuario, tour y fecha.");
        }

        // Si no existe, crear reserva
        $stmt_crear = $con->prepare("CALL crear_reserva(
           :asistencia, :comentarios, :cantidad_asistentes, :id_usuario, :id_tour
        )");

        $stmt_crear->execute([
        /*   ':asistencia'           => $this->getAsistencia(),
            ':comentarios'          => $this->getComentarios(),
            ':cantidad_asistentes'  => $this->getCantidad_asistentes(),
            ':id_usuario'           => $id_usuario,
            ':id_tour'              => $id_tour, */
            ':asistencia' => $this->getAsistencia(),
            ':comentarios' => $this->getComentarios(),
            ':cantidad_asistentes' => $this->getCantidad_asistentes(),
            ':id_usuario' => $this->getId_usuario(),
            ':id_tour' => $this->getId_tour(),
            ':monto' => $this->getMonto(),
            ':moneda' => $this->getMoneda(),
            ':metodo_pago' => $this->getMetodo_pago(),
            ':fecha_pago' => $this->getFecha_pago(),
            ':estado' => $this->getEstado()
        ]);

        if ($stmt_crear->rowCount() > 0) {
            return ResponseHTTP::status201('La reserva ha sido creada exitosamente.');
        } else {
            return ResponseHTTP::status400('No se pudo crear la reserva. Verifique los datos.');
        }

    } catch (\PDOException $e) {
        error_log("Error en crear_reserva: " . $e);
        return ResponseHTTP::status500();
    }
   }

  }

