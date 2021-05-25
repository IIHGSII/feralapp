<?php

require_once 'models/serviciomodel.php';
require_once 'models/activomodel.php';


    class Servicio extends SessionController{

        private $user;

        function __construct(){
            parent::__construct();

            $this->user = $this->getUserSessionData();
        }

        function render(){
            $this->view->render('servicio/index', [
                'user' => $this->user
            ]);
        }

        function newServicio(){
            if(!$this->existPOST(['ticket', 'cedula', 'fecha', 'id_activo', 'monto'])){
                $this->redirect('dashboard', []); //TODO: error
                return;
            }

            if($this->user == NULL){
                $this->redirect('dashboard', []); //TODO: error
                return;
            }

            $servicio = new ServicioModel();

            $servicio->setTicket($this->getPost('ticket'));
            $servicio->setCedula($this->getPost('cedula'));
            $servicio->setfecha($this->getPost('fecha'));
            $servicio->setIdActivo($this->getPost('id_activo'));
            $servicio->setMonto($this->getPost('monto'));
            $servicio->setIdUsuario($this->user->getId());

            $servicio->save();
            $this->redirect('dashboard', []); //TODO:: success
        }

        function create(){
            $activo = new ActivoModel();
            $this->view->render('servicio/create',[
                'activo' => $activo->getAll(),
                'user' => $this->user
            ]);
        }

        function getActivosId(){
            $joinModel = new JoinServicioActivoModel();
            $activo = $joinModel->getAll($this->user->getId()); //revisar si no debe ser cedula - SI DEBE SER CEDULA

            $res = [];

            foreach($activo as $act){
                array_push($res, $act->getIdActivo());
            }

            $res = array_values(array_unique($res));

            return $res;
        }

        private function getDateList(){
            $months = [];
            $res = [];
            $joinModel = new JoinServicioActivoModel();
            $servicio = $joinModel->getAll($this->user->getId()); //Otravez debe ser cedula

            foreach($servicios as $servicio){
                array_push($months, substr($servicio->getFecha(), 0, 7));
            }
            $months = array_values(array_unique($months));

            if(count($months) > 3){ //elegimos 3 meses para la grafica en el dashboard
                array_push($res, array_pop($months));
                array_push($res, array_pop($months));
                array_push($res, array_pop($months));
            }

            return $res;
        }

        function getActivoList(){
            $res = [];
            $joinModel = new JoinServicioActivoModel();
            $servicio = $joinModel->getAll($this->user->getId()); //otra vez debe ser cedula

            foreach($servicios as $servicio){
                array_push($res, $servicio->getIdActivo()); //getNameCategory()
            }
            $res = array_values(array_unique($res));

            return $res;
        }

        function getHistoryJSON(){
            header('Content-Type: application/json');
            $res = [];
            $joinModel = new JoinServicioActivoModel();
            $servicio = $joinModel->getAll($this->user->getId()); //otra vez debe ser cedula

            foreach($servicios as $servicio){
                array_push($res, $servicio->toArray());
            }

            echo json_encode($res);
        }

        function getServiciosJSON(){
            header('Content-Type: application/json');

            $res = [];
            $activoIds = $this->getActivosId();
            
            //incompleto #9 min 25

            $months = this->getDateList();

            for($i = 0; $i < count($months); $i++){
                $item = array($months[$i]);
                for($j = 0; $j < count($activoIds); $j++){
                    $total = $this->getTotalByMonthAndActivo($months[$i], $activoIds[$j]); //este metodo no existe
                    array_push($item, $total);
                }
                array_push($res, $item);
            }

            //incompleto #9 min 25
        }

        private function getTotalByMonthAndActivo($fecha, $activoid){
            //incompleto
        }

        public function delete($ticket){
            try{
                $query = $this->prepare('DELETE FROM servicio WHERE ticket = :ticket');
                $query->execute([ 'ticket' => $ticket]);
                return true;
            }catch(PDOException $e){
                echo $e;
                return false;
            }

            if($res){
                $this->redirect('servicio', []); //TODO: success
            }else{
                $this->redirect('servicio', []); //TODO: error
            }
        }
    }
?>