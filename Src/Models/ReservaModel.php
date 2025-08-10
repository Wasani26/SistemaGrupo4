<?php
namespace App\Models;
use App\DB\ConnectionDB;
use App\Config\ResponseHTTP;
use App\Config\Security;

class ReservaModel extends ConnectionDB{
    private $id_reserva;
    private $fechar_reserva; 
    private $asistencia;
    private $comentarios;
    private $cantidad_asistentes;
    private $id_usuario;
    private $id_tour;
    private $monto;
    private $moneda;
    private $metodo_pago;
    private $fecha_pago;


    // Constructor refactorizado para asignar propiedades de instancia de forma segura
    public function __construct(array $data) {
        $this->id_reserva = $data['id_reserva'] ?? null;
        $this->fechar_reserva = $data['fechar_reserva'] ?? null;
        $this->asistencia = $data['asistencia'] ?? false;
        $this->comentarios = $data['comentarios'] ?? null;
        $this->cantidad_asistentes = $data['cantidad_asistentes'] ?? null;
        $this->id_usuario = $data['id_usuario'] ?? null;
        $this->id_tour = $data['id_tour'] ?? null;
        // Propiedades de pago
        $this->monto = $data['monto'] ?? null;
        $this->moneda = $data['moneda'] ?? null;
        $this->metodo_pago = $data['metodo_pago'] ?? null;
        $this->fecha_pago = $data['fecha_pago'] ?? null;
    }

    // Getters
    final public function getId_reserva(){return $this->id_reserva;}
    final public function getFechar_reserva(){return $this->fechar_reserva;}
    final public function getAsistencia(){return $this->asistencia;}
    final public function getComentarios(){return $this->comentarios;}
    final public function getCantidad_asistentes(){return $this->cantidad_asistentes;}
    final public function getId_usuario(){return $this->id_usuario;}
    final public function getId_tour(){return $this->id_tour;}
    final public function getMonto(){return $this->monto;}
    final public function getMoneda(){return $this->moneda;}
    final public function getMetodo_pago(){return $this->metodo_pago;}
    final public function getFecha_pago(){return $this->fecha_pago;}

    // Setters
    final public function setId_reserva($id_reserva){$this->id_reserva = $id_reserva;}
    final public function setFechar_reserva($fechar_reserva){$this->fechar_reserva = $fechar_reserva;}
    final public function setAsistencia($asistencia){$this->asistencia = $asistencia;}
    final public function setComentarios($comentarios){$this->comentarios = $comentarios;}
    final public function setCantidad_asistentes($cantidad_asistentes){$this->cantidad_asistentes = $cantidad_asistentes;}
    final public function setId_usuario($id_usuario){$this->id_usuario = $id_usuario;}
    final public function setId_tour($id_tour){$this->id_tour = $id_tour;}
    final public function setMonto($monto){$this->monto = $monto;}
    final public function setMoneda($moneda){$this->moneda = $moneda;}
    final public function setMetodo_pago($metodo_pago){$this->metodo_pago = $metodo_pago;}
    final public function setFecha_pago($fecha_pago){$this->fecha_pago = $fecha_pago;}


    //fusiono tablas resrerva y pago para caso de uso realizar pago de un tour
  
    final public function crear_reserva_y_pago() {
        $con = self::getConnection();
        $con->beginTransaction();

        try {
            // ... (código para verificar_reserva y crear_reserva_sp) ...

            $id_reserva_creada = $con->lastInsertId();

            // 3. Insertar en la tabla 'pagos'
            $query_pago_sql = "CALL crear_pago(
                :monto, :moneda, :metodo_pago, :fecha_pago, :id_reserva
            )";

            // Parámetros que se ejecutarán
            $params_pago = [
                ':monto'         => $this->getMonto(),
                ':moneda'        => $this->getMoneda(),
                ':metodo_pago'   => $this->getMetodo_pago(),
                ':fecha_pago'    => $this->getFecha_pago(),
                ':id_reserva'    => $id_reserva_creada
            ];

            // --- ¡AÑADE ESTAS LÍNEAS PARA DEPURACIÓN! ---
            error_log("DEBUG: Query para pago: " . $query_pago_sql);
            error_log("DEBUG: Parámetros para pago: " . print_r($params_pago, true));
            // ---------------------------------------------

            $stmt_pago = $con->prepare($query_pago_sql);
            $stmt_pago->execute($params_pago); // Esta es la línea 92 que da error

            if ($stmt_pago->rowCount() == 0) {
                $con->rollBack();
                return ResponseHTTP::status400('No se pudo crear el pago asociado a la reserva.');
            }

            $con->commit();

            return ResponseHTTP::status201('La reserva y el pago asociado han sido creados exitosamente.');

        } catch (\PDOException $e) {
            $con->rollBack();
            error_log("Error en crear_reserva_y_pago: " . $e->getMessage());
            return ResponseHTTP::status500('Error en la base de datos al crear la reserva y el pago: ' . $e->getMessage());
        }
    }


    
    final public static function obtener_todas_reservas(){ /* ... Implementar lógica para JOIN */ } // Debería hacer un JOIN de reservas y pagos
    final public function actualizar_reserva(){ /* ... */ }
    final public function eliminar_reserva(){ /* ... */ }
}


