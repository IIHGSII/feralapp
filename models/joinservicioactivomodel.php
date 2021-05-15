<?php

class JoinServicioActivoModel extends Model{

    private $ticket;
    private $cedula;
    private $monto;
    private $activoid;
    private $fecha;
    private $usuarioid;
    private $marca;
    private $modelo;

    public function __construct(){
        parent::__construct();
    }

    public function getAll($cedula){
        $items = [];

        try{
            $query = $this->prepare('SELECT servicio.ticket AS servicio_id, id_activo, monto, fecha, id_usuario, activo.id, marca, modelo FROM servicio INNER JOIN activo WHERE servicio.id_activo = activo.id AND servicio.cedula = :cedula ORDER BY fecha');
            $query->execute([
                'cedula' => $cedula
            ]);

            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new JoinServicioActivoModdel();
                $item->from($p);
                array_push($items, $item);
            }

            return $items;
        }catch(PDOException $e){
            return NULL;
        }
    }

    public function from($array){
        $this->ticket = $array['ticket'];
        $this->cedula = $array['cedula'];
        $this->monto = $array['monto'];
        $this->activoid = $array['id_activo'];
        $this->fecha = $array['fecha'];
        $this->usuarioid = $array['id_usuario'];
        $this->marca = $array['marca'];
        $this->modelo = $array['modelo'];
    }

    public function toArray(){
        $array = [];
        $array['ticket'] = $this->ticket;
        $array['cedula'] = $this->cedula;
        $array['monto'] = $this->monto;
        $array['id_activo'] = $this->activoid;
        $array['fecha'] = $this->fecha;
        $array['id_usuario'] = $this->usuarioid;
        $array['marca'] = $this->marca;
        $array['modelo'] = $this->modelo;

        return $array;
    }

    public function getTicket(){ return $this->ticket; }
    public function getCedula(){ return $this->cedula; }
    public function getMonto(){ return $this->monto; }
    public function getIdActivo(){ return $this->activoid; }
    public function getFecha(){ return $this->fecha; }
    public function getIdUsuario(){ return $this->usuarioid; }
    public function getMarca(){ return $this->marca; }
    public function getModelo(){ return $this->modelo; }

    public function setTicket($value){ $this->ticket = $value; }
    public function setCedula($value){ $this->cedula = $value; }
    public function setMonto($value){ $this->monto = $value; }
    public function setIdActivo($value){ $this->activoid = $value; }
    public function setFecha($value){ $this->fecha = $value; }
    public function setIdUsuario($value){ $this->usuarioid = $value; }
    public function setMarca($value){ $this->marca = $value; }
    public function setModelo($value){ $this->modelo = $value; }
}

?>