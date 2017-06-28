<?php
include "AppModel.php";

class AbogadoModel extends UsuarioModel{
    
    var $fechaContratacion;
    var $valorHora;
    var $especialidadId;
    var $usuarioId;
    
    public function __construct(
        $rut = "", $password = "", $nombreCompleto = "", $fechaContratacion = "", $valorHora = "", $especialidadId = "", $usuarioId = ""){
        
        $this->fechaContratacion = $fechaContratacion;
        $this->valorHora = $valorHora;
        $this->especialidadId = $especialidadId;
        $this->usuarioId = $usuarioId;
        
       $this->setTableName("abogado");
        $this->setName("Abogado");
        
        $this->setRelationShips(array(
            "Usuario" => array(
                "type" => "belongsTo",
                "className" => "UsuarioModel",
                "foreignKey" => "usuario_id"
            ),
            "TipoEspecialidad" => array(
                "type" => "belongsTo",
                "className" => "TipoEspecialidadModel",
                "foreignKey" => "especialidad_id"
            )
        ));
        
        parent::__construct($rut,$password,$nombreCompleto);
    }
    
}