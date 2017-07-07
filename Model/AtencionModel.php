<?php
include "AppModel.php";

class AtencionModel extends AppModel{
    
    var $fechaAtencion;
    var $horaAtencion;
    var $clienteId;
    var $abogadoId;
    var $estadoId;
    
    public function __construct($fechaAtencion = "", $horaAtencion = "", $clienteId = "", $abogadoId = "", $estadoId = ""){
        $this->fechaAtencion = $fechaAtencion;
        $this->horaAtencion = $horaAtencion;
        $this->clienteId = $clienteId;
        $this->abogadoId = $abogadoId;
        $this->estadoId = $estadoId;
        
        
        $this->setTableName("atencion");
        parent::__construct();
    }
}