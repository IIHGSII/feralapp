<?php
    class UserModel extends Model implements IModel{
        
        private $id;
        private $username;
        private $password;
        private $rol;
        private $foto;
        private $nombre;
        
        public function __construct(){
            parent::__construct();
            $this->username = '';
            $this->password = '';
            $this->rol = '';
            $this->foto = '';
            $this->nombre = '';
        }

        public function save(){
            try{
                $query = $this->prepare('INSERT INTO usuario(username, password, rol, foto, nombre) VALUES(:username, :password, :rol, :foto, :nombre)');
                $query->execute([
                    'username' => $this->username,
                    'password' => $this->password,
                    'rol' => $this->rol,
                    'foto' => $this->foto,
                    'nombre' => $this->nombre
                ]);

                return true;
            }catch(PDOException $e){
                error_log('USERMODEL::save->PDOException ' . $e);
                return false;
            }
        }

        public function getAll(){
            $items = [];

        try{
            $query = $this->query('SELECT * FROM usuario');

            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new UserModel();
                $item->setId($p['id']);
                $item->setUsername($p['username']);
                $item->setPassword($p['password'], false);
                $item->setRol($p['rol']);
                $item->setFoto($p['foto']);
                $item->setNombre($p['nombre']);
                

                array_push($items, $item);
            }
            return $items;


        }catch(PDOException $e){
            error_log('USERMODEL::getAll->PDOException ' . $e);
        }
        }

        private function getHashedPassword($password){
            return password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
        }

        public function get($id){
            try{
                $query = $this->prepare('SELECT * FROM usuario WHERE id = :id');
                $query->execute([ 'id' => $id]);
                $user = $query->fetch(PDO::FETCH_ASSOC);
    
                $this->setId($user['id']);
                $this->setUsername($user['username']);
                $this->setPassword($user['password']);
                $this->setRol($user['rol']);
                $this->setFoto($user['foto']);
                $this->setNombre($user['nombre']);
    
                return $this;
            }catch(PDOException $e){
                error_log('USERMODEL::getId->PDOException ' . $e);
            }
        }
        public function delete($id){
            try{
                $query = $this->prepare('DELETE FROM usuario WHERE id = :id');
                $query->execute([ 'id' => $id]);
                return true;
            }catch(PDOException $e){
                error_log('USERMODEL::delete->PDOException ' . $e);
                return false;
            }
        }
        public function update(){
            try{
                $query = $this->prepare('UPDATE usuario SET username = :username, password = :password, foto = :foto, nombre = :nombre WHERE id = :id');
                $query->execute([
                    'id'        => $this->id,
                    'username' => $this->username, 
                    'password' => $this->password,
                    'foto' => $this->foto,
                    'nombre' => $this->nombre
                    ]);
                return true;
            }catch(PDOException $e){
                error_log('USERMODEL::update->PDOException ' . $e);
                return false;
            }
        }
        public function from($array){
            $this->id = $array['id'];
            $this->username = $array['username'];
            $this->password = $array['password'];
            $this->rol = $array['rol'];
            $this->foto = $array['foto'];
            $this->nombre = $array['nombre'];
        }

        public function exists($username){
            try{
                $query = $this->prepare('SELECT username FROM usuario WHERE username = :username');
                $query->execute( ['username' => $username]);
                
                if($query->rowCount() > 0){
                    return true;
                }else{
                    return false;
                }
            }catch(PDOException $e){
                error_log('USERMODEL::exists->PDOException ' . $e);
                return false;
            }
        }

        public function comparePasswords($password, $id){
            try{
                $user = $this->get($id);

                return password_verify($password, $user->getPassword());
            }catch(PDOException $e){
                error_log('USERMODEL::exists->PDOException ' . $e);
                return false;
            }
        }
    

        public function setId($id){        $this->id = $id;}
        public function setUsername($username){        $this->username = $username;}
        public function setPassword($password, $hash = true){ 
            if($hash){
                $this->password = $this->getHashedPassword($password);
            }else{
                $this->password = $password;
            }
        }
        public function setRol($rol){        $this->rol = $rol;}
        public function setFoto($foto){        $this->foto = $foto;}
        public function setNombre($nombre){        $this->nombre = $nombre;}

        public function getId(){        return $this->id;}
        public function getUsername(){        return $this->username;}
        public function getPassword(){        return $this->password;}
        public function getRol(){        return $this->rol;}
        public function getFoto(){        return $this->foto;}
        public function getNombre(){        return $this->nombre;}
    }
?>