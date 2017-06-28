<?php
include "AppModel.php";

class PerfilModel extends AppModel{
    
    var $descripcion;
    
    public function __construct($descripcion = ""){
        $this->descripcion = $descripcion;
        
        $this->setTableName("perfil");
        $this->setName("Perfil");
        
        parent::__construct();
    }
    
}