<?php
session_start();
include "AppController.php";
include APP_MODELS."ClienteModel.php";

class Clientes extends AppController{
    
    var $modelo;
    
    public function __construct($method){
        $this->modelo = new ClienteModel();
        $this->modelo->setPrimaryKey("id");
        
        $this->$method();
    }
    
    public function adminListadoClientes(){
        $clientes = $this->modelo->buscar('all',array(
            "contain" => array(
                "Usuario",
                "TipoPersona"
            )
        ));
        
        $this->render("Administrador/admin_listado_clientes.php",array(
            "clientes" => $clientes
        ));
    }
    
    public function adminAgregarCliente(){
        if(!empty($_POST)){
            
            $UsuarioModel = $this->importModel("UsuarioModel");
            $UsuarioModel->setPrimaryKey("id");
            if( !$UsuarioModel->validaUsuarioExistente($_POST["Usuario"]["rut"]) ){
                $save = $_POST["Usuario"];
                $save["perfil_id"] = 2;
                
                if($UsuarioModel->insertaRegistro($save)){
                    
                    $save = $_POST["Cliente"];
                    $save["usuario_id"] = mysql_insert_id();
                    $save["fecha_incorporacion"] = date("Y-m-d");
                    $this->modelo->insertaRegistro($save);
                    
                    $_SESSION["var_consumibles"]["msg_exito"] = "Cliente guardado correctamente.";
                    $this->redireccionar("Clientes.php?action=adminListadoClientes");
                }
                $_SESSION["var_consumibles"]["msg_error"] = "Ha ocurrido un error al guardar el cliente.";
            } else {
                $_SESSION["var_consumibles"]["msg_error"] = "Rut ya registrado en el sistema.";
            }
        }
        
        $TipoPersonaModel = $this->importModel("TipoPersonaModel");
        $tiposPersonas = $TipoPersonaModel->buscar("all");
        $this->render("Administrador/admin_agregar_cliente.php",array(
            "tiposPersonas" => $tiposPersonas["TipoPersona"]
        ));
    }
    
    public function adminEditCliente(){
        $this->modelo->id = $_GET["id"];
        if(!empty($_POST)){
            $save = array(
                "direccion" => $_POST["Cliente"]["direccion"],
                "telefono" => $_POST["Cliente"]["telefono"],
                "tipo_persona_id" => $_POST["Cliente"]["tipo_persona_id"],
            );
            # Antes de usar el método editar() del modelo, hay que setear el id. ($this->modelo->id).
            if($this->modelo->editar($save)){
                # Importamos el modelo de Usuario para actualizarle un registro.
                $UsuarioModel = $this->importModel("UsuarioModel");
                # Seteamos el id al que está apuntando el modelo.
                $UsuarioModel->id = $_POST["Cliente"]["usuario_id"];
                
                $save = array();
                if(!empty($_POST["Usuario"]["contrasena"])){
                    $save["contrasena"] = $_POST["Usuario"]["contrasena"];
                }
                $save["rut"] = $_POST["Usuario"]["rut"];
                $save["nombre_completo"] = $_POST["Usuario"]["nombre_completo"];
                $UsuarioModel->editar($save);
                
                $_SESSION["var_consumibles"]["msg_exito"] = "Cliente guardado correctamente.";
                $this->redireccionar("Clientes.php?action=adminListadoClientes");
            }
            $_SESSION["var_consumibles"]["msg_error"] = "Ha ocurrido un error al intentar guardar el cliente.";
        }
        
        $conditions["id"] = $this->modelo->id;
        $cliente = $this->modelo->buscar("first",array(
            "conditions" => $conditions,
            "contain" => "Usuario"
        ));
        
        $TipoPersonaModel = $this->importModel("TipoPersonaModel");
        $tiposPersonas = $TipoPersonaModel->buscar("all");
        
        $this->render("Administrador/admin_edit_cliente.php",array(
            "id" => $this->modelo->id,
            "cliente" => $cliente,
            "tiposPersonas" => $tiposPersonas["TipoPersona"]
        ));
    }
}
$oCliente = new Clientes($_GET["action"]);