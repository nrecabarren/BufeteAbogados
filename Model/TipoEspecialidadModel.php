<?php
include_once "AppModel.php";

class TipoEspecialidadModel extends AppModel{
    
    var $id;
    var $nombre;
    
    public function __construct(){
        $this->setTableName("especialidad");
        $this->setName("TipoEspecialidad");
        
        parent::__construct();
    }
    
}