<?php
include "AppModel.php";

class UsuarioModel extends AppModel{
    
    var $rut;
    var $password;
    var $nombreCompleto;
    
    public function __construct($rut = "", $password = "", $nombreCompleto = ""){
        $this->rut = $rut;
        $this->password = $this->hashPassword($password);
        $this->nombreCompleto = $nombreCompleto;
        
        $this->setTableName("usuario");
        
        parent::__construct();
    }
    
    private function hashPassword($password){
        $this->password = $password;
    }
}