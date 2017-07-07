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
        
        $this->render("Secretaria/atenciones.php");
    }
    
    public function nuevaAtencion(){
        $EspecialidadModel = $this->importModel("EspecialidadModel");
        $especialidades = $EspecialidadModel->buscar("all");
        
        $this->render("Secretaria/nueva_atencion.php",array(
            'especialidades' => $especialidades["Especialidad"]
        ));
    }
    
}
$oAtenciones = new Atenciones($_GET["action"]);