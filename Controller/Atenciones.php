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
            
            $noConfirmadasFinal = false;$diaActual = date('d');
            foreach($atencionesAux["Atencion"] as $key => $atencion):
                $noConfirmadas = false;
                
                # Verificamos si hay atenciones que aún no han sido confirmadas.
                $diaFechaAtencion = explode("-",$atencion["fecha_atencion"])[2];
                $diasFaltantes = ($diaFechaAtencion - $diaActual);
                if( $diasFaltantes <= 2  && $atencion["estado_id"] == 1){
                    $noConfirmadas = true;
                    $noConfirmadasFinal = true;
                }
                $atenciones["Atencion"][$key] = $atencion;
                
                # Si la atención no ha sido confirmada faltando sólo 2 días:
                if($atencion["estado_id"] == 1 && $noConfirmadas && $diasFaltantes == 2){
                    $atenciones["Atencion"][$key]["icon"] = "warning";
                
                # Si la atención fue anulada o perdió la atención
                } elseif( in_array($atencion["estado_id"],array(2,4)) ){
                    $atenciones["Atencion"][$key]["icon"] = "danger";
                
                # Si faltando un día para la atención esta aún no ha sido confirmada
                }elseif($atencion["estado_id"] == 1 && $diasFaltantes == 1){
                    $atenciones["Atencion"][$key]["icon"] = "info";
                
                # Si la atención fue confirmada y no se marcó como realizada
                }elseif( $atencion["estado_id"] == 3 && $diasFaltantes <= -1){
                    $atenciones["Atencion"][$key]["icon"] = "info-danger";
                
                # Si se realizó la atención o fue confirmada a tiempo
                } else{
                    $atenciones["Atencion"][$key]["icon"] = "success";
                }
                
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
            'atenciones' => $atenciones,
            'noConfirmadasFinal' => $noConfirmadasFinal
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
        
        if( $_SESSION["user_logueado"]["perfil_id"] == 2){
            $this->redireccionar("Atenciones.php?action=misAtenciones");
        } else {
            $this->redireccionar("Atenciones.php?action=atenciones");
        }
    }
    
    public function misAtenciones(){
        $ClienteModel = $this->importModel("ClienteModel");
        
        $cliente = $ClienteModel->buscar('first',array(
            'conditions' => array('usuario_id' => $_SESSION["user_logueado"]["id"]),
            'fields' => 'id'
        ));
        
        $atenciones = array();
        $atencionesAux = $this->modelo->buscar('all',array(
            'contain' => 'Estado',
            'conditions' => array(
                'cliente_id' => $cliente["Cliente"]["id"]
            )
        ));
        
        if(!empty($atencionesAux)):
            $UsuarioModel = $this->importModel("UsuarioModel");
            $AbogadoModel = $this->importModel("AbogadoModel");
            
            $noConfirmadasFinal = false; $diaActual = date('d');
            foreach($atencionesAux["Atencion"] as $key => $atencion):
                $noConfirmadas = false;
                
                $diaFechaAtencion = explode("-",$atencion["fecha_atencion"])[2];
                $diasFaltantes = ($diaFechaAtencion - $diaActual);
                if( $diasFaltantes <= 2  && $atencion["estado_id"] == 1){
                    $noConfirmadas = true;
                    $noConfirmadasFinal = true;
                }
                
                $atenciones["Atencion"][$key] = $atencion;
                
                if($atencion["estado_id"] == 1 && $noConfirmadas){
                    $atenciones["Atencion"][$key]["icon"] = "warning";
                } elseif( in_array($atencion["estado_id"],array(2,4)) ){
                    $atenciones["Atencion"][$key]["icon"] = "danger";
                } else{
                    $atenciones["Atencion"][$key]["icon"] = "success";
                }
                
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
                
                $atenciones["Atencion"][$key]["Abogado"] = $abogado["Abogado"];
                
            endforeach;
        endif;
        $this->render("Cliente/mis_atenciones.php",array(
            'atenciones' => $atenciones["Atencion"],
            'noConfirmadasFinal' => $noConfirmadasFinal
        ));
    }
    
    public function reportesAtenciones(){
        $atenciones = array();
        if(!empty($_POST)){
            $conditions = array();
            if(!empty($_POST["abogado_id"])){
                $conditions['abogado_id'] = $_POST["abogado_id"];
            }
            if(!empty($_POST["estado_id"])){
                $conditions['estado_id'] = $_POST["estado_id"];
            }
            
            $atenciones = $this->modelo->buscar('all',array(
                'conditions' => $conditions,
                'contain' => 'Abogado'
            ));
        }
        
        $AbogadoModel = $this->importModel("AbogadoModel");
        $EspecialidadModel = $this->importModel("EspecialidadModel");
        $EstadoModel = $this->importModel("EstadoModel");
        
        $abogadosAux = $AbogadoModel->buscar('all',array(
            'fields' => 'id,usuario_id',
            'contain' => 'Usuario'
        ));
        $abogados = array();
        foreach($abogadosAux["Abogado"] as $abogado){
            $key = $abogado["id"];
            $value = $abogado["Usuario"]["nombre_completo"];
            $abogados[$key] = $value;
        }
        
        
        $especialidades = $EspecialidadModel->buscar('all');
        $estados = $EstadoModel->buscar('all');
        
        $this->render("Gerente/reportes_atenciones.php",array(
            'atenciones' => $atenciones,
            'abogados' => $abogados,
            'especialidades' => $especialidades["Especialidad"],
            'estados' => $estados["Estado"]
        ));
    }
}
$oAtenciones = new Atenciones($_GET["action"]);