<?php
include "Conexion.php";

class AppModel{
    
    var $oConexion;
    var $_name;
    var $_tableName; # Nombre de la tabla que usará el modelo.
    var $_primaryKey = "id"; # Nombre de la columna que es primary key en la tabla que usará el modelo.
    var $_fields; # Columnas de la tabla que usará el modelo.
    var $id;
    
    public function __construct(){
        
        $this->oConexion = new Conexion();
        $this->oConexion->conectar();
        
        $this->setTableColumns();
    }
    
    public function setName($newModelName){
        $this->_name = $newModelName;
    }
    public function setPrimaryKey($newPrimaryKeyField){
        $this->_primaryKey = $newPrimaryKeyField;
    }
    public function setFields($tableFields = array()){
        $this->_fields = $tableFields;
    }
    public function setTableName($tableName){
        $this->_tableName = $tableName;
    }
    
    /**
     * setTableColumns method
     * Setea el atributo $_fields con los nombres de todos los campos de la tabla.
     *
     * @return void.
     */
    public function setTableColumns(){
        
        # Guardamos la consulta SHOW COLUMNS en $consultaCampos
        $consultaCampos = mysql_query("SHOW COLUMNS FROM ".$this->oConexion->dbName.".".$this->_tableName);
        if(!$consultaCampos){
            die('Ha ocurrido un error al obtener los campos. ' . mysql_error() );
        }
        
        $campos = array();
        if(mysql_num_rows($consultaCampos) > 0){
            # Recorremos cada tupla que haya retornado.
            while( $field = mysql_fetch_assoc($consultaCampos)){
                if($field['Key'] == 'PRI'){
                    $this->setPrimaryKey($field['Field']);
                }
                $campos[] = $field['Field'];
            }
        }
        
        # Guardamos en $_fields el nombre del campo.
        $this->setFields($campos);
    }
    
    public function insertaRegistro($datos){
        
        $cantCampos = count($this->_fields);
        if($cantCampos == 0)
            die('No se han encontrado campos para la tabla '.$this->_tableName);
        
        $fields = $values = '';
        foreach($this->_fields as $key => $fieldName){
            if($fieldName == $this->_primaryKey){
                continue;
            }
            
            # Si no está en el último campo le agregamos una coma para que quede
            # en el estilo de campo1,campo2,campo3
            if($key < ($cantCampos-1) ){
                $fields .= $fieldName.',';
                $values .= "'".$datos[$fieldName]."',";
            } else {
                $fields .= $fieldName;
                $values .= "'".$datos[$fieldName]."'";
            }
        }
        
        # Query para insertar registro.
        $query = 'INSERT INTO '.$this->oConexion->dbName.".".$this->_tableName.'('.$fields.') VALUES ('.$values.');';
        
        return mysql_query($query);
    }
    
    public function buscarPorId($id = null){
        if($id){
            $this->setId($id);
        }
        
        return $this->buscar('first',array(
            'conditions' => array(
                $this->_primaryKey => $this->id
            )
        ));
    }
    
    /**
     * buscar method
     * Busca uno o varios registros en la tabla de la bd.
     *
     * @param string $tipoBusqueda Tipo de búsqueda a realizar, puede ser: (count,all,first).
     * @param array $params Parámetros que servirán a llenar la búsqueda.
     * @return resource mysql_query.
     */
    public function buscar($tipoBusqueda = 'all',$params = array()){
        
        $condiciones = $limit = $campos = '';
        
        if(!empty($params)){
            
            if(isset($params['fields'])){
                if(!is_array($params['fields'])){
                    $campos = $params['fields'];
                } else {
                    # Eliminamos campos duplicados
                    $uniqueArrayFields = array_unique($params['fields']);
                    
                    # Ponemos una coma entre los campos.
                    $campos = implode(',',$uniqueArrayFields);
                }
            }
            
            # Si dentro de $params hay condiciones...
            if(isset($params['conditions'])){
                if(!is_array($params['conditions'])){
                    $condiciones = $params['conditions'];
                } else {
                    
                    $aux = $params['conditions'];
                    end($aux);
                    $ultimoKey = key($aux);
                    foreach($params['conditions'] as $field => $valorABuscar){
                        if($ultimoKey == $field){
                            $condiciones .= $field." = '".$valorABuscar."'";
                        } else {
                            $condiciones .= $field." = '".$valorABuscar."' AND ";
                        }
                    }
                }
            }
            
            # Seteamos la cantidad de registros a traer.
            if(isset($params['limit'])){
                $limit = $params['limit'];
            }
            
        }
        
        $query = 'SELECT ';
        # Si busca un count.
        if($tipoBusqueda == 'count'){
            $query .= 'COUNT(*)';
            
        } elseif(!empty($campos)){
            $query .= $campos;
            
        } else {
            $query .= '*';
        }
        
        # Concatenamos el nombre de la tabla.
        $query .= ' FROM '.$this->oConexion->dbName.".".$this->_tableName;
        
        # Concatenamos las condiciones
        if(!empty($condiciones)){
            $query .= ' WHERE '.$condiciones;
        }
        
        # Concatenamos el límite.
        if($tipoBusqueda == 'first'){
            $query .= ' LIMIT 1';
        } elseif(!empty($limit)){
            $query .= ' LIMIT '.$limit;
        }
        
        $query .= ';';
        //$this->debug($query);
        
        $resultados = mysql_query($query);
        
        if(!$resultados){
            die('Consulta invalida. '.mysql_error());
        }
        
        $arrayResultados = $this->convertirResultadosArray($resultados,$tipoBusqueda);
        
        /*if(isset($params) && isset($params['contain']) && !empty($params['contain'])){
            
            $arrayResultadosCopia = $arrayResultados;
            # si no es array(es string), lo convertimos a array para seguir con el proceso normalmente.
            if(!is_array($params['contain'])){
                $params['contain'] = array($params['contain']);
            }
            
            # Recorremos los modelos en los que quiere unir el resultado.
            foreach($params['contain'] as $nombreModeloRelacion){
                
                # Recorremos los resultados para agregarles al array los nuevos resultados con las relaciones.
                foreach($arrayResultadosCopia as $nombreModeloResultados => $campos){
                    
                    $atributosRelacion = $this->_relationShips[$nombreModeloRelacion];
                    
                    # importamos el archivo con la clase.
                    include_once( $atributosRelacion['className'].'.php' );
                    $modelo = new $atributosRelacion['className']( $atributosRelacion['table'] );
                    
                    if($atributosRelacion['type'] == 'belongsTo'){
                        
                        $consulta = $modelo->buscar('first',array(
                            'conditions' => array(
                                'id' => $arrayResultadosCopia[$nombreModeloResultados][$atributosRelacion['foreignKey']]
                            )
                        ));
                        
                        if(empty($consulta)){
                            $arrayResultadosCopia[$nombreModeloRelacion] = $consulta;
                        } else {
                            $arrayResultadosCopia[$nombreModeloRelacion] = $consulta[$nombreModeloRelacion];
                        }
                    }
                }
            }
            $arrayResultados = $arrayResultadosCopia;
        }*/
        
        
        return $arrayResultados;
    }
    
    /**
     * convertirResultadosArray method
     * Convierte los resultados de una consulta mysql a Array.
     * 
     * @param mysql_query $resultados Resultados devueltos por la consulta de mysql_query.
     * @param string $tipoBusqueda Tipo de búsqueda que se realiza, para devolver una mejor estructura de array.
     * @return array Array con los resultados encontrados.
     */
    public function convertirResultadosArray($resultados, $tipoBusqueda){
        
        $arrayToReturn = array();
        if(mysql_num_rows($resultados) == 0){
            return $arrayToReturn;
        }
        
        while( $fila = mysql_fetch_assoc($resultados) ){
            if($tipoBusqueda == 'first'){
                $arrayToReturn[$this->_name] = $fila;
            } elseif($tipoBusqueda == 'all') {
                $arrayToReturn[$this->_name][] = $fila;
            } elseif($tipoBusqueda == 'list'){
                $arrayToReturn[reset($fila)] = end($fila);
            }
        }
        mysql_free_result($resultados);
        
        return $arrayToReturn;
    }

    public function debug($object){
        echo '<pre>';
        print_r($object);
        echo '</pre>';
        exit();
    }
}