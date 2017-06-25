<?php
include_once "AppModel.php";

class TipoPersonaModel extends AppModel{
    
    var $id;
    var $descripcion;
    
    public function __construct(){
        $this->setTableName("tipo_persona");
        $this->setName("TipoPersona");
        
        parent::__construct();
    }
    
}