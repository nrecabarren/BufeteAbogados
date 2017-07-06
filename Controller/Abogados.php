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
        $abogados = $this->modelo->buscar('all',array(
            "contain" => array(
                "Usuario",
                "Especialidad"
            )
        ));
        
        $this->render("Administrador/admin_listado_abogados.php",array(
            "abogados" => $abogados
        ));
    }
    public function gerenteListadoAbogados(){
        $abogados = $this->modelo->buscar('all',array(
            "contain" => array(
                "Usuario",
                "Especialidad"
            )
        ));
        
        $this->render("Administrador/gerente_listado_abogados.php",array(
            "abogados" => $abogados
        ));
    }
	
    public function adminAgregarAbogado(){
        if(!empty($_POST)){
            
            $UsuarioModel = $this->importModel("UsuarioModel");
            $UsuarioModel->setPrimaryKey("id");
            if( !$UsuarioModel->validaUsuarioExistente($_POST["Usuario"]["rut"]) ){
				$save = $_POST["Usuario"];
                $save["perfil_id"] = 2;
				$save["estado"] = 1;
				
				$id="";
                if($id=$UsuarioModel->insertaRegistroId($save)){
                    
                    $save = $_POST["Abogado"];
                    $save["usuario_id"] = $id;
                    $save["fecha_contratacion"] = date('Y-m-d',strtotime($_POST["Abogado"]["fecha_contratacion"]));
                    $save["valor_hora"] = str_replace('.','',$_POST["Abogado"]["valor_hora"]);
                    
                    if($this->modelo->insertaRegistro($save)){
                        $_SESSION["var_consumibles"]["msg_exito"] = "Abogado guardado correctamente.";
                    } else {
                        $_SESSION["var_consumibles"]["msg_exito"] = "Error al guardar el abogado.";
                    }
                    
                    $_SESSION["var_consumibles"]["msg_exito"] .= "Usuario guardado correctamente.";
                    $this->redireccionar("Abogados.php?action=adminListadoAbogados");
                }
                $_SESSION["var_consumibles"]["msg_error"] = "Ha ocurrido un error al guardar el abogado.";
            } else {
                $_SESSION["var_consumibles"]["msg_error"] = "Rut ya registrado en el sistema.";
            }
        }
        
        $EspecialidadModel = $this->importModel("EspecialidadModel");
        $especialidades = $EspecialidadModel->buscar("all");
        
        $PerfilModel = $this->importModel("PerfilModel");
        $perfiles = $PerfilModel->buscar('all');
        
        $this->render("Administrador/admin_agregar_abogado.php",array(
            "especialidades" => $especialidades["Especialidad"],
            "perfiles" => $perfiles["Perfil"]
        ));
    }
    
    public function adminEditAbogado(){
        $this->modelo->id = $_GET["id"];
        if(!empty($_POST)){
            $save = array(
                "fecha_contratacion" => date('Y-m-d',strtotime($_POST["Abogado"]["fecha_contratacion"])),
                "valor_hora" => str_replace('.','',$_POST["Abogado"]["valor_hora"]),
                "especialidad_id" => $_POST["Abogado"]["especialidad_id"],
            );
            # Antes de usar el método editar() del modelo, hay que setear el id. ($this->modelo->id).
            if($this->modelo->editar($save)){
                # Importamos el modelo de Usuario para actualizarle un registro.
                $UsuarioModel = $this->importModel("UsuarioModel");
                # Seteamos el id al que está apuntando el modelo.
                $UsuarioModel->id = $_POST["Abogado"]["usuario_id"];
                
                $save = array();
                if(!empty($_POST["Usuario"]["contrasena"])){
                    $save["contrasena"] = $_POST["Usuario"]["contrasena"];
                }
                $save["rut"] = $_POST["Usuario"]["rut"];
                $save["nombre_completo"] = $_POST["Usuario"]["nombre_completo"];
                $UsuarioModel->editar($save);
                
                $_SESSION["var_consumibles"]["msg_exito"] = "Abogado guardado correctamente.";
                $this->redireccionar("Abogados.php?action=adminListadoAbogados");
            }
            $_SESSION["var_consumibles"]["msg_error"] = "Ha ocurrido un error al intentar guardar el abogado.";
        }
        
        $conditions["id"] = $this->modelo->id;
        $abogado = $this->modelo->buscar("first",array(
            "conditions" => $conditions,
            "contain" => "Usuario"
        ));
        
        $EspecialidadModel = $this->importModel("EspecialidadModel");
        $especialidades = $EspecialidadModel->buscar("all");
        
        $PerfilModel = $this->importModel("PerfilModel");
        $perfiles = $PerfilModel->buscar('all');
        
        $this->render("Administrador/admin_edit_abogado.php",array(
            "id" => $this->modelo->id,
            "abogado" => $abogado,
            "especialidades" => $especialidades["Especialidad"],
            "perfiles" => $perfiles["Perfil"]
        ));
    }
}
$oAbogados = new Abogados($_GET["action"]);