<?php
session_start();
include "AppController.php";
include APP_MODELS."UsuarioModel.php";

class Usuario extends AppController{
    
    var $modelo;
    
    public function __construct($method){
        $this->modelo = new UsuarioModel();
        $this->modelo->setPrimaryKey("id");
        
        $this->$method();
    }
    
    public function login(){
        if(!empty($_POST)){
            
            $usuario = $this->modelo->buscar('first',array(
                "conditions" => array(
                    "rut" => $_POST["rut_usuario"],
                    "contrasena" => $_POST["contrasena_usuario"]
                )
            ));
            
            if(!empty($usuario)){
                
                $_SESSION["user_logueado"] = $usuario["Usuario"];
                $_SESSION["var_consumibles"]["msg_exito"] = "Bienvenido, ".$usuario["Usuario"]["nombre_completo"];
                if($usuario["Usuario"]["perfil_id"] == 1){
                    $this->redireccionar("Clientes.php?action=adminListadoClientes");
                }
            }
            
            $_SESSION["var_consumibles"]["msg_error"] = "Nombre de usuario o contraseña incorrectos.";
        }
        $this->render("login.php");
    }
    
    public function logout(){
        $_SESSION["user_logueado"] = array();
        $_SESSION["var_consumibles"]["msg_exito"] = "Haz cerrado sesión con éxito.";
        
        $this->redireccionar("Usuario.php?action=login");
    }
}

$oUsuario = new Usuario($_GET["action"]);