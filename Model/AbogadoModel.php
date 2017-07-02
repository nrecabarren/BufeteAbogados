<?php
include_once "AppModel.php";
include_once "UsuarioModel.php";

class AbogadoModel extends UsuarioModel{
    
    var $fechaContratacion;
    var $valorHora;
    var $especialidadId;
    var $usuarioId;
    
    public function __construct(
        $rut = "", $password = "", $nombreCompleto = "", $fechaContratacion = "", $valorHora = "", $especialidadId = "", $usuarioId = ""){
        parent::__construct($rut,$password,$nombreCompleto);
        
        $this->fechaContratacion = $fechaContratacion;
        $this->valorHora = $valorHora;
        $this->especialidadId = $especialidadId;
        $this->usuarioId = $usuarioId;
        
        $this->setTableName("abogado");
        $this->setName("Abogado");
        $this->setTableColumns();
        
        $this->setRelationShips(array(
            "Usuario" => array(
                "type" => "belongsTo",
                "className" => "UsuarioModel",
                "foreignKey" => "usuario_id"
            ),
            "Especialidad" => array(
                "type" => "belongsTo",
                "className" => "EspecialidadModel",
                "foreignKey" => "especialidad_id"
            )
        ));
    }
    
}