<?php
include "AppModel.php";

class UsuarioModel extends AppModel{
    
    var $rut;
    var $password;
    var $nombreCompleto;
    var $_relationShips = array(
        "Perfil" => array(
            "type" => "belongsTo",
            "className" => "PerfilModel",
            "foreignKey" => "perfil_id"
        )
    );
    
    public function __construct($rut = "", $password = "", $nombreCompleto = ""){
        $this->rut = $rut;
        $this->password = $this->hashPassword($password);
        $this->nombreCompleto = $nombreCompleto;
        
        $this->setTableName("usuario");
        $this->setName("Usuario");
        
        parent::__construct();
    }
    
    public function hashPassword($password){
        $this->password = $password;
    }
    
    public function validaUsuarioExistente($rut){
        
        $existe = $this->buscar('count',array(
            'conditions' => array(
                'rut' => $rut
            )
        ));
        
        return $existe;
    }
}