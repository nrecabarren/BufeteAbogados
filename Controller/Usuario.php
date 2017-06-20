<?php
include "AppController.php";
include APP_MODELS."UsuarioModel.php";


class Usuario extends AppController{
    
    var $modelo;
    
    public function __construct(){
        $this->modelo = new UsuarioModel();
        $this->debug($this->modelo);
    }
}

$oUsuario = new Usuario();