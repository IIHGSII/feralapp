<?php
class SuccessMessages{

    const SUCCESS_ADMIN_NEWCATEGORY_EXISTS = "c74163200ec1e78de1223179774c0318";

    private $successList = [];

    public function __construct(){
        $this->successList = [
            SuccessMessages::SUCCESS_ADMIN_NEWCATEGORY_EXISTS => 'Este es un mensaje de exito'
        ];
    }

    public function get($hash){
        return $this->successList[$hash];
    }

    public function existsKey($key){
        if(array_key_exists($key, $this->successList)){
            return true;
        }else{
            return false;
        }
    }
}
?>