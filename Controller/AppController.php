<?php
include "../Config/constants.php";

class AppController{
    
    public function __construct(){
        if(empty($_SESSION["user_logueado"]) && $_GET["action"] != "login"){
            $_SESSION["var_consumibles"]["msg_error"] = "Acceso denegado.";
            $this->redireccionar("Usuario.php?action=login");
        }
    }
    
    public function redireccionar($path){
        header("Location: ".$path);
        exit();
    }
    
    public function render($viewPath,$variables = array()){
        if(!empty($variables)){
            foreach($variables as $id_assoc => $valor){
                ${$id_assoc} = $valor;
            }
        }
        
        require_once APP_VIEWS.$viewPath;
        exit();
    }
    
    public function importModel($className){
        include_once APP_MODELS.$className.".php";
        return new $className();
    }
    
    public function debug($object){
        echo '<pre>';
        print_r($object);
        echo '</pre>';
        exit();
    }
}