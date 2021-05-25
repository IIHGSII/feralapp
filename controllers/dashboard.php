<?php
class Dashboard extends SessionController{

    private $user;

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
        $activos = $this->getActivos();
        $this->view->render('dashboard/index',[
            'user' => $this->user,
            'servicio' => $servicios,
            'totalAmountThisMonth' => $totalThisMonth,
            'activos' => $activos
        ]);
    }

    private function getServicio($n = 0){
        if($n < 0) return NULL;

        $servicios = new ServicioModel();
        return $servicios->getByUserIdAndLimit($this->user->getId(), $n); //metodo aun no creado
    }

    public function getActivos(){
        $res = [];
        $activoModel = new ActivoModel();
        $servicioModel = new ServicioModel();

        $activos = $activoModel->getAll();

        foreach($activos as $activo){
            $activoArray = [];

            $total = $servicioModel->getTotalByActivoThisMonth($activo->getId(), $this->user->getId());
            $numberOfServicios = $servicioModel->getNumberOfServicesByActivoThisMonth($activo->getId(), $this->user->getId()); //el segundo parametro debe ser cedula

            if($numberOfServicios > 0){
                $activoArray['total'] = $total;
                $activoArray['count'] = $numberOfServicios;
                $activoArray['activo'] = $activo;
                array_push($res, $activoArray);
            }
        }
        return $res;
    }

    public function getPersonal(){

    }

}
?>