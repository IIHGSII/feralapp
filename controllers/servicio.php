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

        function getActivoId(){
            $joinModel = new JoinServicioActivoModel();
            $activo = $joinModel->getAll($this->user->getId()); //revisar si no debe ser cedula

            $res = [];

            foreach($activo as $act){
                array_push($res, $act->getActivoId());
            }

            $res = array_values(array_unique($res));

            return $res;
        }

        private function getDateList(){
            $months = [];
            $res = [];
            $joinModel = new JoinServicioActivoModel();
            $servicio = $joinModel->getAll($this->user->getId());

            foreach($servicios as $servicio){
                array_push($months, substr($servicio->getDate(), 0, 7));
            }
            $months = array_values(array_unique($months));

            if(count($months) > 3){
                array_push($res, array_pop($months));
                array_push($res, array_pop($months));
                array_push($res, array_pop($months));
            }

            return $res;
        }

        function getActivoList(){
            $res = [];
            $joinModel = new JoinServicioActivoModel();
            $servicio = $joinModel->getAll($this->user->getId());

            foreach($servicios as $servicio){
                array_push($res, $servicio->getActivoId()); //getNameCategory()
            }
            $res = array_values(array_unique($res));

            return $res;
        }

        function getHistoryJSON(){
            header('Content-Type: application/json');
            $res = [];
            $joinModel = new JoinServicioActivoModel();
            $servicio = $joinModel->getAll($this->user->getId());

            foreach($servicios as $servicio){
                array_push($res, $servicio->toArray();
            }

            echo json_encode($res);
        }

        function getServiciosJSON(){
            header('Content-Type: application/json');

            $res = [];
            $activoIds = $this->getActivoId();
            

        }
    }
?>