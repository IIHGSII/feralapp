<?php

require_once 'models/usermodel.php';

class LoginModel extends Model{

    public function __construct(){
        parent::__construct();
    }

    public function login($username, $password){
        // insertar datos en la BD
        error_log("login: inicio");
        try{
            //$query = $this->db->connect()->prepare('SELECT * FROM users WHERE username = :username');
            $query = $this->prepare('SELECT * FROM usuario WHERE username = :username');
            $query->execute(['username' => $username]);
            
            if($query->rowCount() == 1){
                $item = $query->fetch(PDO::FETCH_ASSOC); 

                $user = new UserModel();
                $user->from($item);

                error_log('login: user id '.$user->getId());

                if(password_verify($password, $user->getPassword())){
                    error_log('LoginModel::login: success');
                    //return ['id' => $item['id'], 'username' => $item['username'], 'role' => $item['role']];
                    return $user;
                    //return $user->getId();
                }else{
                    error_log('LoginModel::login: PASSWORD NO ES IGUAL');
                    return NULL;
                }
            }
        }catch(PDOException $e){
            error_log('LoginModel::login->exception ' . $e);
            return NULL;
        }

    }

         

}

?>