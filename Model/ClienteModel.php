<?php
include "AppModel.php";

class ClienteModel extends AppModel{
    
    var $fechaIncorporacion;
    var $direccion;
    var $telefono;
    var $tipoPersonaId;
    var $usuarioId;
    
    public function __construct(
        $rut = "", $password = "", $nombreCompleto = "", $fechaIncorporacion = "", $direccion = "",
        $telefono = "", $tipoPersonaId = "", $usuarioId = ""){
        
        $this->fechaIncorporacion = $fechaIncorporacion;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->tipoPersonaId = $tipoPersonaId;
        $this->usuarioId = $usuarioId;
        
        $this->setTableName("cliente");
        $this->setName("Cliente");
        
        $this->setRelationShips(array(
            "Usuario" => array(
                "type" => "belongsTo",
                "className" => "UsuarioModel",
                "foreignKey" => "usuario_id"
            ),
            "TipoPersona" => array(
                "type" => "belongsTo",
                "className" => "TipoPersonaModel",
                "foreignKey" => "tipo_persona_id"
            )
        ));
        
        parent::__construct($rut,$password,$nombreCompleto);
    }
}