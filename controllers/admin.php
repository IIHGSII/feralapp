<?php

class Admin extends SessionController{

    function __construct()
    {
        parent::__construct();
    }

    function render(){
        $stats = $this->getStadistics();

        $this->view->render('admin/index', [
            'stats' => $stats
        ]);
    }

    function createActivo(){
        $this->view->render('admin/create-activo');
    }

    function newActivo(){
        if($this->existPOST(['id', 'marca', 'modelo'])){
            $id = $this->getPost('id');
            $marca = $this->getPost('marca');
            $modelo = $this->getPost('modelo');

            $activoModel = new ActivoModel();

            if(!$activoModel->exists($id)){
                $activoModel->setId($id);
                $activoModel->setMarca($marca);
                $activoModel->setModelo($modelo);
                $activoModel->save();

                $this->redirect('admin', []); //TODO: success
            }else{
                $this->redirect('admin', []); //TODO: error
            }
        }
    }

    private function getMaxAmount($servicios){
        $max = 0;
        foreach ($servicios as $servicio) {
            $max = max($max, $servicios->getMonto());
        }

        return $max;
    }
    private function getMinAmount($servicios){
        $min = $this->getMaxAmount($servicios);
        foreach ($servicios as $servicio) {
            $min = min($min, $servicio->getAmount());
        }

        return $min;
    }

    private function getActivoMostUsed($servicios){
        $repeat = [];

        foreach($servicios as $servicio){
            if(!array_key_exists($servicio->getActivoId(), $repeat)){
                $repeat[$servicio->getActivoId()] = 0;
            }
            $repeat[$servicio->getActivoId()]++;
        }

        $activoMostUsed = max($repeat);
        $activoModel = new ActivoModel();
        $activoModel->get($activoMostUsed);

        $activo = $activoModel->getId();

        return $activo;
    }

    private function getActivoLessUsed($servicios){
        $repeat = [];

        foreach($servicios as $servicio){
            if(!array_key_exists($servicio->getActivoId(), $repeat)){
                $repeat[$servicio->getActivoId()] = 0;
            }
            $repeat[$servicio->getActivoId()]++;
        }

        $activoMostUsed = min($repeat);
        $activoModel = new ActivoModel();
        $activoModel->get($activoMostUsed);

        $activo = $activoModel->getId();

        return $activo;
    }

    function getStadistics(){
        $res = [];

        $userModel = new UserModel();
        $users = $userModel->getAll();
        
        $servicioModel = new servicioModel();
        $servicios = $servicioModel->getAll();

        $activoModel = new activoModel();
        $activos = $activosModel->getAll();

        $res['count-users'] = count($users);
        $res['count-servicios'] = count($servicios);
        $res['max-servicios'] = $this->getMaxAmount($servicios);
        $res['min-servicios'] = $this->getMinAmount($servicios);
        $res['count-categories'] = count($activo);
        $res['mostused-activo'] = $this->getActivoMostUsed($servicios);
        $res['lessused-activo'] = $this->getActivoLessUsed($servicios);
        return $res;
    }
}

?>