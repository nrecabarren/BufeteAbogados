<?php
include "AppController.php";
include APP_MODELS."UsuarioModel.php";
session_start();

class Usuario extends AppController{
    
    var $modelo;
    
    public function __construct($method){
        $this->modelo = new UsuarioModel();
        $this->modelo->setPrimaryKey("id");
        
        $this->$method();
    }
    
    public function login(){
        
        $_SESSION["var_consumibles"] = array();
        $_SESSION["var_consumibles"]["msg_error"] = "";
        $_SESSION["var_consumibles"]["msg_exito"] = "";
        
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
                    $this->redireccionar(VIEWS_PATH."Administrador/listado_clientes.php");
                }
            }
            
            $_SESSION["var_consumibles"]["msg_error"] = "Nombre de usuario o contraseña incorrectos.";
            $this->redireccionar(VIEWS_PATH."login.php");
        }
        
        $_SESSION["var_consumibles"]["msg_error"] = "Error al recibir los datos.";
    }
    
    public function logout(){
        $_SESSION["user_logueado"] = array();
        $_SESSION["var_consumibles"]["msg_exito"] = "Haz cerrado sesión con éxito.";
        
        $this->redireccionar(VIEWS_PATH."login.php");
    }
}

$oUsuario = new Usuario($_GET["action"]);