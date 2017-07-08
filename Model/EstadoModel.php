<?php
include_once "AppModel.php";

class EstadoModel extends AppModel{
    
    var $id;
    var $descripcion;
    
    public function __construct(){
        $this->setTableName("estado");
        $this->setName("Estado");
        
        parent::__construct();
    }
    
}