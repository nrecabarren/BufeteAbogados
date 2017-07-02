<?php
include_once "AppModel.php";

class EspecialidadModel extends AppModel{
    
    var $id;
    var $nombre;
    
    public function __construct(){
        $this->setTableName("especialidad");
        $this->setName("Especialidad");
        
        parent::__construct();
    }
    
}