<?php

    require_once 'classes/session.php';

    class SessionController extends Controller{
        private $userSession;
        private $username;
        private $userid;

        private $session;
        private $sites;

        private $user;

        function __construct(){
            parent::__construct();
            $this->init();
        }

        function init(){
            $this->session = new Session();

            $json = $this->getJSONFileConfig();

            $this->sites = $json['sites'];
            $this->defaultSites = $json['default-sites'];

            $this->validateSession();
        }

        private function getJSONFileConfig(){
            $string = file_get_contents("config/access.json");
            $json = json_decode($string, true);

            return $json;
        }

        public function validateSession(){
            error_log('SESSIONCONTROLLER::validateSession');

            //Si existe la sesión
        if($this->existsSession()){
            $rol = $this->getUserSessionData()->getRol();

            error_log("sessionController::validateSession(): username:" . $this->user->getUsername() . " - rol: " . $this->user->getRol());
            //si la pagina a entrar es publica
            if($this->isPublic()){
                $this->redirectDefaultSiteByRole($rol);
                error_log( "SessionController::validateSession() => sitio público, redirige al main de cada rol" );
            }else{
                if($this->isAuthorized($rol)){
                    error_log( "SessionController::validateSession() => autorizado, lo deja pasar" );
                    //si el usuario está en una página de acuerdo
                    // a sus permisos termina el flujo
                }else{
                    error_log( "SessionController::validateSession() => no autorizado, redirige al main de cada rol" );
                    // si el usuario no tiene permiso para estar en
                    // esa página lo redirije a la página de inicio
                    $this->redirectDefaultSiteByRole($rol);
                }
            }
        }else{
            //No existe ninguna sesión
            //se valida si el acceso es público o no
            if($this->isPublic()){
                error_log('SessionController::validateSession() public page');
                //la pagina es publica
                //no pasa nada
            }else{
                //la página no es pública
                //redirect al login
                error_log('SessionController::validateSession() redirect al login');
                header('Location: '. constant('URL') . '');
            }
        }

        }

        function existsSession(){
            if(!$this->session->exists()) return false;
            if($this->session->getCurrentUser() == NULL) return false;
    
            $userid = $this->session->getCurrentUser();
    
            if($userid) return true;
    
            return false;
        }

        function getUserSessionData(){
            $id = $this->userid;
            $this->user = new UserModel();
            $this->user->get($id);
            error_log('SESSIONCONTROLLER::getUserSessionData(): ' . $this->user->getUsername());
            return $this->user;
        }

        private function isPublic(){
            $currentURL = $this->getCurrentPage();
            
            $currentURL = preg_replace( "/\?.*/", "", $currentURL); //omitir get info
            for($i = 0; $i < sizeof($this->sites); $i++){
                if($currentURL == $this->sites[$i]['site'] && $this->sites[$i]['access'] == 'public'){
                    return true;
                }
            }
            return false;
        }

        private function getCurrentPage(){
        
            $actualLink = trim("$_SERVER[REQUEST_URI]");
            $url = explode('/', $actualLink);
            error_log('sessionController::getCurrentPage(): ' . $url[2]);
            return $url[2];
        }

        private function redirectDefaultSiteByRole($rol){
            $url = '';
            for($i = 0; $i < sizeof($this->sites); $i++){
                if($this->sites[$i]['rol'] == $rol){
                    $url = '/feralapp/'.$this->sites[$i]['site'];
                break;
                }
            }
            header('location:' . $url);
            
        }

        private function isAuthorized($rol){
            $currentURL = $this->getCurrentPage();
            $currentURL = preg_replace( "/\?.*/", "", $currentURL); //omitir get info
            
            for($i = 0; $i < sizeof($this->sites); $i++){
                if($currentURL === $this->sites[$i]['site'] && $this->sites[$i]['rol'] === $rol){
                    return true;
                }
            }
            return false;
        }

        public function initialize($user){
            error_log("sessionController::initialize(): user: " . $user->getUsername());
            $this->session->setCurrentUser($user->getId());
            $this->authorizeAccess($user->getRol());
        }

        function authorizeAccess($rol){
            error_log("sessionController::authorizeAccess(): rol: $rol");
            switch($rol){
                case 'user':
                    $this->redirect($this->defaultSites['user'], []);
                break;
                case 'admin':
                    $this->redirect($this->defaultSites['admin'], []);
                break;
            }
        }

        function logout(){
            $this->session->closeSession();
        }
    }
?>