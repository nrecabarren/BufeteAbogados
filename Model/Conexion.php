<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Conexion{
    var $objconn;
    
    /*Metodo de conexión*/
    var $dbUser = "root";
    var $dbPassword = "";
    var $dbHost = "localhost";
    var $dbName = "bufete";
    
    public function conectar(){
        $this->objconn = new mysqli($this->dbHost,$this->dbUser,$this->dbPassword,$this->dbName);
         
        if ($this->objconn->connect_errno) {
            return "Error al conectar a MySQL: (" . $this->objconn->connect_errno . ") " . $this->objconn->connect_error;
        }
        return true;  
    }
}