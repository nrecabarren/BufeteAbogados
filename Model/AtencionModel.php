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
        
        $this->setRelationShips(array(
            "Cliente" => array(
                "type" => "belongsTo",
                "className" => "ClienteModel",
                "foreignKey" => "cliente_id"
            ),
            "Abogado" => array(
                "type" => "belongsTo",
                "className" => "AbogadoModel",
                "foreignKey" => "abogado_id"
            ),
            "Estado" => array(
                "type" => "belongsTo",
                "className" => "EstadoModel",
                "foreignKey" => "estado_id"
            )
        ));
        
        $this->setTableName("atencion");
        $this->setName("Atencion");
        parent::__construct();
    }
}