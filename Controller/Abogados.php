<?php
session_start();
include "AppController.php";
include APP_MODELS."AbogadoModel.php";

class Abogados extends AppController{
    
    var $modelo;
    
    public function __construct($method){
        $this->modelo = new AbogadoModel();
        $this->modelo->setPrimaryKey("id");
        
        $this->$method();
    }
    
    public function adminListadoAbogados(){
        $clientes = $this->modelo->buscar('all',array(
            "contain" => array(
                "Usuario",
                "TipoEspecialidad"
            )
        ));
        
        $this->render("Administrador/admin_listado_abogados.php",array(
            "abogados" => $abogados
        ));
    }
    
    public function adminAgregarAbogado(){
        if(!empty($_POST)){
            
            $save = $_POST["Usuario"];
            $save["perfil_id"] = 2;
            $UsuarioModel = $this->importModel("UsuarioModel");
            $UsuarioModel->setPrimaryKey("id");
            if($UsuarioModel->insertaRegistro($save)){
                
                $save = $_POST["Abogado"];
                $save["usuario_id"] = mysql_insert_id();
                $save["fecha_contratacion"] = date("Y-m-d");
                $this->modelo->insertaRegistro($save);
                
                $_SESSION["var_consumibles"]["msg_exito"] = "Cliente guardado correctamente.";
                $this->redireccionar("Clientes.php?action=adminListadoClientes");
            }
            $_SESSION["var_consumibles"]["msg_error"] = "Ha ocurrido un error al guardar el cliente.";
        }
        
        $TipoEspecialidadModel = $this->importModel("TipoEspecialidadModel");
        $tiposEspecialidades = $TipoEspecialidadModel->buscar("all");
        $this->render("Administrador/admin_agregar_abogado.php",array(
            "tiposEspecialidades" => $tiposPersonas["TipoEspecialidad"]
        ));
    }
    
    public function adminEditAbogado(){
        $this->modelo->id = $_GET["id"];
        if(!empty($_POST)){
            $save = array(
                "valor_hora" => $_POST["Abogado"]["valor_hora"],
                "especialidad_id" => $_POST["Abogado"]["especialidad_id"],
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
                $this->redireccionar("Abogados.php?action=adminListadoAbogados");
            }
            $_SESSION["var_consumibles"]["msg_error"] = "Ha ocurrido un error al intentar guardar el cliente.";
        }
        
        $conditions["id"] = $this->modelo->id;
        $cliente = $this->modelo->buscar("first",array(
            "conditions" => $conditions,
            "contain" => "Usuario"
        ));
        
        $TipoEspecialidadModel = $this->importModel("TipoEspecialidadModel");
        $tiposEspecialidades = $TipoEspecialidadModel->buscar("all");
        
        $this->render("Administrador/admin_edit_abogado.php",array(
            "id" => $this->modelo->id,
            "cliente" => $cliente,
            "tiposPersonas" => $tiposPersonas["TipoEspecialidad"]
        ));
    }
}
$oCliente = new Clientes($_GET["action"]);