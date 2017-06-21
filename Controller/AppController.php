<?php
include "../Config/constants.php";

class AppController{
    
    public function redireccionar($path){
        header("Location: ".$path);
        exit();
    }
    
    public function debug($object){
        echo '<pre>';
        print_r($object);
        echo '</pre>';
        exit();
    }
}