<?php

    class ActivoModel extends Model implements IModel{

        private $id;
        private $marca;
        private $modelo;

        public function __construct(){
            parent::__construct();
        }

        public function save(){
            try{
                $query = $this->prepare('INSERT INTO activo (id, marca, modelo) VALUES (:id, :marca, :modelo)');
                $query->execute([
                    'id' => $this->id,
                    'marca' => $this->marca,
                    'modelo' => $this->modelo
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
                $query = $this->query('SELECT * FROM activo');

                while($p = $query->fetch(PDO::FETCH_ASSOC)){
                    $item = new ActivoModel();
                    $item->from($p);

                    array_push($items, $item);
                }

                return $items;
            }catch(PDOException $e){
                return NULL;
            }
        }
        public function get($id){
            try{
                $query = $this->prepare('SELECT * FROM activo WHERE id = :id');
                $query->execute(['id' => $id]);
                $activo = $query->fetch(PDO::FETCH_ASSOC);
                
                $this->from($activo);
                return $this;
                
            }catch(PDOException $e){
                return NULL;
            }
        }
        public function delete($id){
            try{
                $query = $this->prepare('DELETE FROM activo WHERE id = :id');
                $query->execute(['id' => $id]);
                
                return true;
                
            }catch(PDOException $e){
                return false;
            }
        }
        public function update(){
            try{
                $query = $this->prepare('UPDATE activo SET id = :id, marca = :marca, modelo = :modelo WHERE id = :id');
                $query->execute([
                    'id' => $this->$id,
                    'marca' => $this->$marca,
                    'modelo' => $this->$modelo
                    ]);
                $activo = $query->fetch(PDO::FETCH_ASSOC);
                return true;
                
            }catch(PDOException $e){
                return false;
            }
        }
        public function from($array){
            $this->id = $array['id'];
            $this->marca = $array['marca'];
            $this->modelo = $array['modelo'];
        }

        public function exists($id){
            try{
                $query = $this->prepare('SELECT id FROM activo WHERE id = :id');
                $query->execute([
                    'id' => $this->id
                ]);

                if($query->rowCount()){
                    return true;
                }

                return false;
            }catch(PDOException $e){
                return false;
            }
        }

        public function setId($id){ $this->id = $id; }
        public function setMarca($marca){ $this->marca = $marca; }
        public function setModelo($modelo){ $this->modelo = $modelo; }

        public function getId(){ return $this->id;}
        public function getMarca(){ return $this->marca;}
        public function getModelo(){ return $this->modelo;}
    }

?>