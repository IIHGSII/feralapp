<?php

require_once 'models/usermodel.php';

class Signup extends SessionController{

    function __construct(){
        parent::__construct();
    }

    function render(){
        error_log('muestra vista signup');
        $this->view->render('login/signup', []);
    }

    function newUser(){
        error_log('entra en la funcion newuser');
        if($this->existPOST(['username', 'password'])){
            
            $username = $this->getPost('username');
            $password = $this->getPost('password');
            
            //validate data
            if($username == '' || empty($username) || $password == '' || empty($password)){
                // error al validar datos
                //$this->errorAtSignup('Campos vacios');
                error_log('Validación de campos vacios');
                $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY]);
            }

            $user = new UserModel();
            $user->setUsername($username);
            $user->setPassword($password);
            $user->setRol('user');
            
            if($user->exists($username)){
                //$this->errorAtSignup('Error al registrar el usuario. Elige un nombre de usuario diferente');
                $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EXISTS]);
                //return;
            }else if($user->save()){
                //$this->view->render('login/index');
                $this->redirect('', ['success' => SuccessMessages::SUCCESS_SIGNUP_NEWUSER]);
            }else{
                /* $this->errorAtSignup('Error al registrar el usuario. Inténtalo más tarde');
                return; */
                $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
            }
        }else{
            // error, cargar vista con errores
            //$this->errorAtSignup('Ingresa nombre de usuario y password');
            $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY]);
        }
    }
}
?>