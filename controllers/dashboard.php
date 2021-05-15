<?php
class Dashboard extends SessionController{
    function __construct(){
        parent::__construct();
        $this->user = $this->getUserSessionData();
        error_log('Dashboard::construct-> inicio de Dashboard');
    }

    function render(){
        error_log('Dashboard::render-> Carga el index de dashboard');
        $servicioModel = new ServicioModel();
        $servicios = $this->getServicio(5);
        $totalThisMonth = $servicioModel->getTotalAmountThisMonth($this->user->getId()); //Verificar si no debe ser cedula
        $this->view->render('dashboard/index',[
            'user' => $this->user,
            'servicio' => $servicios,
            'totalAmountThisMonth' => $totalThisMonth
        ]);
    }

    private function getServicio($n = 0){
        if($n < 0) return NULL;

        $servicios = new ServicioModel();
        return $servicioModel;
    }

    public function getActivo(){

    }

    public function getPersonal(){

    }

}
?>