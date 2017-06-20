<?php
include "UsuarioModel.php";

class AbogadoModel extends UsuarioModel{
    
    var $fechaContratacion;
    var $valorHora;
    var $especialidadId;
    var $usuarioId;
    
    public function __construct(
        $rut = "", $password = "", $nombreCompleto = "", $fechaContratacion, $valorHora, $especialidadId, $usuarioId){
        
        $this->fechaContratacion = $fechaContratacion;
        $this->valorHora = $valorHora;
        $this->especialidadId = $especialidadId;
        $this->usuarioId = $usuarioId;
        
        parent::__construct($rut,$password,$nombreCompleto);
    }
    
}