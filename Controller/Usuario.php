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
        if(!empty($_SESSION["user_logueado"])){
            switch($_SESSION["user_logueado"]["perfil_id"]):
                case "1": # Administrador
                    $this->redireccionar("Clientes.php?action=adminListadoClientes");
                    break;
                case "2": # Cliente
                    
                    break;
                case "3": # Gerente
                    
                    break;
                case "4": # Secretaria
                    
                    break;
            endswitch;
        }
        
        $this->render("login.php");
    }
    
    public function logout(){
        $_SESSION["user_logueado"] = array();
        $_SESSION["var_consumibles"]["msg_exito"] = "Haz cerrado sesión con éxito.";
        
        $this->redireccionar("Usuario.php?action=login");
    }
    
    public function adminListadoUsuarios(){
        $usuarios = $this->modelo->buscar('all',array(
            'conditions' => array(
                'perfil_id' => array(1,3,4)
            ),
            'contain' => 'Perfil'
        ));
        
        $this->render("Administrador/admin_listado_usuarios.php",array(
            "usuarios" => $usuarios
        ));
    }
    
    public function adminAgregarUsuario(){
        if(!empty($_POST)){
            
            if( !$this->modelo->validaUsuarioExistente($_POST["Usuario"]["rut"]) ){
                $save = array(
                    "rut" => $_POST["Usuario"]["rut"],
                    "contrasena" => $_POST["Usuario"]["contrasena"],
                    "nombre_completo" => $_POST["Usuario"]["nombre_completo"],
                    "perfil_id" => $_POST["Usuario"]["perfil_id"]
                );
                
                if($this->modelo->insertaRegistro($save)){
                    $_SESSION["var_consumibles"]["msg_exito"] = "Usuario guardado correctamente.";
                    $this->redireccionar("Usuario.php?action=adminListadoUsuarios");
                }
                $_SESSION["var_consumibles"]["msg_error"] = "Ha ocurrido un error al guardar el usuario.";
            } else {
                $_SESSION["var_consumibles"]["msg_error"] = "Rut ya registrado en el sistema.";
            }
        }
        
        $PerfilModel = $this->importModel("PerfilModel");
        $perfiles = $PerfilModel->buscar("all");
        $this->render("Administrador/admin_agregar_usuario.php",array(
            "perfiles" => $perfiles["Perfil"]
        ));
    }
    
    public function adminEditarUsuario(){
        $this->modelo->id = $_GET["id"];
        
        if(!empty($_POST)){
            $save = array(
                "rut" => $_POST["Usuario"]["rut"],
                "nombre_completo" => $_POST["Usuario"]["nombre_completo"],
                "perfil_id" => $_POST["Usuario"]["perfil_id"]
            );
            
            if(!empty($_POST["Usuario"]["contrasena"])){
                $save["contrasena"] = $_POST["Usuario"]["contrasena"];
            }
            
            if($this->modelo->editar($save)){
                $_SESSION["var_consumibles"]["msg_exito"] = "Usuario guardado correctamente.";
                $this->redireccionar("Usuario.php?action=adminListadoUsuarios");
            }
            $_SESSION["var_consumibles"]["msg_error"] = "Ha ocurrido un error al guardar el usuario.";
        }
        
        $conditions["id"] = $this->modelo->id;
        $usuario = $this->modelo->buscar("first",array(
            "conditions" => $conditions,
            "contain" => "Perfil"
        ));
        
        $PerfilModel = $this->importModel("PerfilModel");
        $perfiles = $PerfilModel->buscar("all");
        $this->render("Administrador/admin_editar_usuario.php",array(
            "id" => $this->modelo->id,
            "perfiles" => $perfiles["Perfil"],
            "usuario" => $usuario
        ));
    }
}

$oUsuario = new Usuario($_GET["action"]);