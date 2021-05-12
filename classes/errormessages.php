<?php
class ErrorMessages{
    // ERROR_CONTROLLER_METHOD_ACTION
    const ERROR_ADMIN_NEWCATEGORY_EXISTS = "c74163200ec1e78de1223179774c0318";

    private $errorList = [];

    public function __construct(){
        $this->errorList = [
            ErrorMessages::ERROR_ADMIN_NEWCATEGORY_EXISTS => 'El nombre de la categoría ya existe'
        ];
    }

    public function get($hash){
        return $this->errorList[$hash];
    }

    public function existsKey($key){
        if(array_key_exists($key, $this->errorList)){
            return true;
        }else{
            return false;
        }
    }
}
?>