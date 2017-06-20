<?php
include "UsuarioModel.php";

class ClienteModel extends Usuario{
    
    var $fechaIncorporacion;
    var $direccion;
    var $telefono;
    var $tipoPersonaId;
    var $usuarioId;
    
    public function __construct(
        $rut, $password, $nombreCompleto, $fechaIncorporacion, $direccion, $telefono, $tipoPersonaId, $usuarioId){
        
        $this->fechaIncorporacion = $fechaIncorporacion;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->tipoPersonaId = $tipoPersonaId;
        $this->usuarioId = $usuarioId;
        
        $this->setTableName("cliente");
        parent::__construct($rut,$password,$nombreCompleto);
    }
}