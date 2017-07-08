<?php
session_start();
include "AppController.php";
include APP_MODELS."AtencionModel.php";

class Atenciones extends AppController{
    
    public function __construct($method){
        $this->modelo = new AtencionModel();
        $this->modelo->setPrimaryKey("id");
        
        $this->$method();
    }
    
    /**
     * atenciones method
     * Función de Rol de Secretaria. Muestra un calendario con las fechas de las atenciones.
     */
    public function atenciones(){
        $atenciones = array();
        $atencionesAux = $this->modelo->buscar('all',array(
            'contain' => 'Estado'
        ));
        
        if(!empty($atencionesAux)):
            $UsuarioModel = $this->importModel("UsuarioModel");
            $ClienteModel = $this->importModel("ClienteModel");
            $AbogadoModel = $this->importModel("AbogadoModel");
            
            foreach($atencionesAux["Atencion"] as $key => $atencion):
                $atenciones["Atencion"][$key] = $atencion;
                
                # Buscamos los datos del abogado
                $abogado = $AbogadoModel->buscar('first',array(
                    'conditions' => array('id' => $atencion["abogado_id"]),
                    'fields' => 'id,valor_hora,usuario_id,especialidad_id',
                    'contain' => 'Especialidad'
                ));
                $abogado["Abogado"]["nombre_completo"] = $UsuarioModel->buscar('first',array(
                    'conditions' => array('id' => $abogado["Abogado"]["usuario_id"]),
                    'fields' => 'nombre_completo'
                ))["Usuario"]["nombre_completo"];
                
                # Buscamos los datos del cliente
                $cliente = $ClienteModel->buscar('first',array(
                    'conditions' => array('id' => $atencion["cliente_id"]),
                    'fields' => 'usuario_id'
                ));
                $cliente["Cliente"]["nombre_completo"] = $UsuarioModel->buscar('first',array(
                    'conditions' => array('id' => $cliente["Cliente"]["usuario_id"]),
                    'fields' => 'nombre_completo'
                ))["Usuario"]["nombre_completo"];
                
                $atenciones["Atencion"][$key]["Cliente"] = $cliente["Cliente"];
                $atenciones["Atencion"][$key]["Abogado"] = $abogado["Abogado"];
                
            endforeach;
        endif;
        $this->render("Secretaria/atenciones.php",array(
            'atenciones' => $atenciones
        ));
    }
    
    public function nuevaAtencion(){
        if(!empty($_POST)){
            
            # Primero buscamos el ID del usuario, para así después obtener el ID del cliente.
            $conditions["rut"] = $_POST["Cliente"]["rut"];
            
            $UsuarioModel = $this->importModel("UsuarioModel");
            $usuario = $UsuarioModel->buscar('first',array(
                'conditions' => $conditions,
                'fields' => 'id'
            ));
            
            # Buscamos ahora el ID del cliente.
            $conditionsCliente["usuario_id"] = $usuario["Usuario"]["id"];
            $ClienteModel = $this->importModel("ClienteModel");
            $cliente = $ClienteModel->buscar('first',array(
                'conditions' => $conditionsCliente,
                'fields' => 'id'
            ));
            
            $save = array(
                'fecha_atencion' => date('Y-m-d',strtotime($_POST["Atencion"]["fecha_atencion"])),
                'hora_atencion' => $_POST["Atencion"]["hora_atencion"],
                'cliente_id' => $cliente["Cliente"]["id"],
                'abogado_id' => $_POST["Abogado"]["id"],
                'estado_id' => 1
            );
            
            if( $this->modelo->insertaRegistro($save) ){
                $_SESSION["var_consumibles"]["msg_exito"] = "Atención agendada correctamente.";
            } else {
                $_SESSION["var_consumibles"]["msg_error"] = "No se pudo agendar la atención, intente nuevamente.";
            }
            $this->redireccionar("Atenciones.php?action=atenciones");
        }
        
        
        $EspecialidadModel = $this->importModel("EspecialidadModel");
        $especialidades = $EspecialidadModel->buscar("all");
        
        $this->render("Secretaria/nueva_atencion.php",array(
            'especialidades' => $especialidades["Especialidad"]
        ));
    }
    
    public function cambiarEstado(){
        $atencion = $this->modelo->buscar('first',array(
            'conditions' => array('id' => $_GET["atencion"]),
            'fields' => 'id'
        ));
        
        $this->modelo->id = $atencion["Atencion"]["id"];
        $save = array(
            'estado_id' => $_GET["estado"]
        );
        if($this->modelo->editar($save)){
            $_SESSION["var_consumibles"]["msg_exito"] = "Atención actualizada correctamente.";
        } else {
            $_SESSION["var_consumibles"]["msg_error"] = "Ha ocurrido un error al actualizar la atención.";
        }
        
        $this->redireccionar("Atenciones.php?action=atenciones");
    }
    
}
$oAtenciones = new Atenciones($_GET["action"]);