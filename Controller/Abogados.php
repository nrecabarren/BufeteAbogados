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
    
    public function adminAgregarAbogado(){
        if(!empty($_POST)){
            
            $save = $_POST["Usuario"];
            $save["estado"] = 1;
            $save["contrasena"] = md5($save["contrasena"]);
            
            $UsuarioModel = $this->importModel("UsuarioModel");
            $UsuarioModel->setPrimaryKey("id");
            if( !$UsuarioModel->validaUsuarioExistente($_POST["Usuario"]["rut"]) ){
                if($UsuarioModel->insertaRegistro($save)){
                    
                    $save = $_POST["Abogado"];
                    $save["usuario_id"] = $UsuarioModel->oConexion->objconn->insert_id;
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
                    $save["contrasena"] = md5($_POST["Usuario"]["contrasena"]);
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
    public function secretariaListadoAbogados(){
        $abogados = $this->modelo->buscar('all',array(
            "contain" => array(
                "Usuario",
                "Especialidad"
            )
        ));
        
        $this->render("Secretaria/listado_abogados.php",array(
            "abogados" => $abogados
        ));
    }
    
    
    public function getAbogadosByEspecialidad(){
        if(!empty($_POST)){
            
            $abogados = $this->modelo->buscar('all',array(
                'conditions' => array(
                    'especialidad_id' => $_POST["especialidad"]
                ),
                'contain' => "Usuario"
            ));
            # Si no encuentra abogados en esa especialidad...
            if(empty($abogados)){
                echo '<option value="">No se encontraron abogados</option>';
            } else {
                # Imprimimos las opciones del select
                echo '<option value="">Seleccione</option>';
                foreach($abogados["Abogado"] as $abogado):
                    echo '<option value="'.$abogado["id"].'">'.$abogado["Usuario"]["nombre_completo"].'</option>';
                endforeach;
            }
            
        } else {
            echo '<option value="">Seleccione</option>';
        }
        exit();
    }
    
    public function getValorHora(){
        if(!empty($_POST)){
            $conditions["id"] = $_POST["abogado"];
            $abogado = $this->modelo->buscar('first',array(
                'conditions' => $conditions
            ));
            
            $fechaActual = date('m-d-Y');
            $fechaContratacion = date('m-d-Y',strtotime($abogado["Abogado"]["fecha_contratacion"]));
            if( $fechaActual < $fechaContratacion){
                $fechaComienzo = $fechaContratacion;
            } else {
                $fechaComienzo = $fechaActual;
            }
            
            echo $abogado["Abogado"]["valor_hora"].",".$fechaComienzo;
        }
        exit();
    }

}
$oAbogados = new Abogados($_GET["action"]);