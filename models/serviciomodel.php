<?php

    class ServicioModel extends Model implements IModel{
        private $ticket;
        private $cedula;
        private $fecha;
        private $activoid;
        private $usuarioid;
        private $monto;

        public function setTicket($ticket){ $this->ticket = $ticket; }
        public function setCedula($cedula){ $this->cedula = $cedula; }
        public function setFecha($fecha){ $this->fecha = $fecha; }
        public function setActivoId($activoid){ $this->activoid = $activoid; }
        public function setUsuarioId($usuarioid){ $this->usuarioid = $usuarioid; }
        public function setMonto($monto){ $this->monto = $monto; }

        public function getTicket(){ return $this->ticket;}
        public function getCedula(){ return $this->cedula;}
        public function getFecha(){ return $this->fecha;}
        public function getActivoId(){ return $this->activoid;}
        public function getUsuarioId(){ return $this->usuarioid;}
        public function getMonto(){ return $this->monto;}

        public function __construct(){
            parent::__construct();
        }

        public function save(){
            try{
                $query = $this->prepare('INSERT INTO servicio (ticket, cedula, fecha, id_activo, id_usuario, monto) VALUES (:ticket, :cedula, :fecha, :activo, :usuario, :monto)');
                $query->execute([
                    'ticket' => $this->ticket,
                    'cedula' => $this->cedula,
                    'fecha' => $this->fecha,
                    'activo' => $this->activoid,
                    'usuario' => $this->usuarioid,
                    'monto' => $this->monto
                ]);
                if($query->rowCount()) return true;
                return false;
            }catch(PDOException $e){
                return false;
            }
        }
        public function getAll(){
            $items = [];
            try{
                $query = $this->query('SELECT * FROM servicio');

                while($p = $query->fetch(PDO::FETCH_ASSOC)){
                    $item = new ServcioModel();
                    $item->from($p);

                    array_push($items, $item);
                }

                return $items;
               
            }catch(PDOException $e){
                return false;
            }
        }
        public function get($ticket){
            try{
                $query = $this->prepare('SELECT * FROM servicio WHERE ticket = :ticket');
                $query->execute([
                    'ticket' => $ticket
                ]);
                $servicio = $query->fetch(PDO::FETCH_ASSOC);

                $this->from($servicio);

                return $this;

            }catch(PDOException $e){
                return false;
            }
        }
        public function delete($ticket){
            try{
                $query = $this->prepare('DELETE FROM servicio WHERE ticket = :ticket');
                $query->execute([
                    'ticket' => $ticket
                ]);
                return true;

            }catch(PDOException $e){
                return false;
            }
        }
        public function update(){
            try{
                $query = $this->prepare('UPDATE servicio SET ticket = :ticket, cedula = :cedula, fecha = :fecha, id_activo = :activo, id_usuario = :usuario, monto = :monto WHERE ticket = :ticket');
                $query->execute([
                    'ticket' => $this->ticket,
                    'cedula' => $this->cedula,
                    'fecha' => $this->fecha,
                    'activo' => $this->activoid,
                    'usuario' => $this->usuarioid,
                    'monto' => $this->monto
                ]);
                if($query->rowCount()) return true;
                return false;
            }catch(PDOException $e){
                return false;
            }
        }

        public function from($array){
            $this->ticket = $array['ticket'];
            $this->cedula = $array['cedula'];
            $this->fecha = $array['fecha'];
            $this->activoid = $array['id_activo'];
            $this->usuarioid = $array['id_usuario'];
            $this->monto = $array['monto'];
        }

        public function getAllByCedula($cedula){
            $items = [];
            try{
                $query = $this->prepare('SELECT * FROM servicio WHERE cedula = :cedula  ');
                $query->execute([
                    'cedula' => $cedula
                ]);
                
                while($p = $query->fetch(PDO::FETCH_ASSOC)){
                    $item = new ServcioModel();
                    $item->from($p);

                    array_push($items, $item);
                }

                return $items;

            }catch(PDOException $e){
                return [];
            }
        }

        public function getTotalAmountThisMonth($cedula){
            
            try{
                $year = date('Y');
                $month = date('m');
                $query = $this->prepare('SELECT SUM(monto) AS total FROM servicio WHERE YEAR(date) = :year AND MONTH(date) = :month AND cedula = :cedula');
                $query->execute([
                    'cedula' => $cedula,
                    'year' => $year,
                    'month' => $month
                ]);
                
                $total = $query->fetch(PDO::FETCH_ASSOC)['total'];

                if($total == NULL) $total = 0;

                return $total;

            }catch(PDOException $e){
                return NULL;
            }
        }

        public function getNumberOfServicesByActivoThisMonth($activoid, $cedula){
            
            try{
                $total = 0;
                $year = date('Y');
                $month = date('m');
                $query = $this->prepare('SELECT COUNT(monto) AS total FROM servicio WHERE id_activo = :activoid AND YEAR(date) = :year AND MONTH(date) = :month AND cedula = :cedula');
                $query->execute([
                    'cedula' => $cedula,
                    'year' => $year,
                    'month' => $month,
                    'activoid' => $activoid
                ]);
                
                $total = $query->fetch(PDO::FETCH_ASSOC)['total'];

                if($total == NULL) $total = 0;

                return $total;

            }catch(PDOException $e){
                return NULL;
            }
        }
    }

?>