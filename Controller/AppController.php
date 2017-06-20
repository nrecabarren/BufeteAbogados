<?php
include "../Config/constants.php";

class AppController{
    
    public function debug($object){
        echo '<pre>';
        print_r($object);
        echo '</pre>';
        exit();
    }
}