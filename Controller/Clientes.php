<?php
session_start();
include "AppController.php";
include APP_MODELS."ClienteModel.php";

class Clientes extends AppController{
    
    var $modelo;
    
    public function __construct($method){
        $this->modelo = new ClienteModel();
        $this->modelo->setPrimaryKey("id");
        
        $this->$method();
    }
    
    public function adminListadoClientes(){
        $clientes = $this->modelo->buscar('all',array(
            "contain" => array(
                "Usuario",
                "TipoPersona"
            )
        ));
        
        $this->render("Administrador/admin_listado_clientes.php",array(
            "clientes" => $clientes
        ));
    }
    
    public function adminAgregarCliente(){
        if(!empty($_POST)){
            
            $UsuarioModel = $this->importModel("UsuarioModel");
            $UsuarioModel->setPrimaryKey("id");
            if( !$UsuarioModel->validaUsuarioExistente($_POST["Usuario"]["rut"]) ){
                $save = $_POST["Usuario"];
                $save["perfil_id"] = 2;
                $save["contrasena"] = md5($save["contrasena"]);
                
                if($UsuarioModel->insertaRegistro($save)){
                    
                    $save = $_POST["Cliente"];
                    $save["usuario_id"] = $UsuarioModel->oConexion->objconn->insert_id;
                    $save["fecha_incorporacion"] = date("Y-m-d");
                    $this->modelo->insertaRegistro($save);
                    
                    $_SESSION["var_consumibles"]["msg_exito"] = "Cliente guardado correctamente.";
                    $this->redireccionar("Clientes.php?action=adminListadoClientes");
                }
                $_SESSION["var_consumibles"]["msg_error"] = "Ha ocurrido un error al guardar el cliente.";
            } else {
                $_SESSION["var_consumibles"]["msg_error"] = "Rut ya registrado en el sistema.";
            }
        }
        
        $TipoPersonaModel = $this->importModel("TipoPersonaModel");
        $tiposPersonas = $TipoPersonaModel->buscar("all");
        $this->render("Administrador/admin_agregar_cliente.php",array(
            "tiposPersonas" => $tiposPersonas["TipoPersona"]
        ));
    }
    
    public function adminEditCliente(){
        $this->modelo->id = $_GET["id"];
        if(!empty($_POST)){
            $save = array(
                "direccion" => $_POST["Cliente"]["direccion"],
                "telefono" => $_POST["Cliente"]["telefono"],
                "tipo_persona_id" => $_POST["Cliente"]["tipo_persona_id"],
            );
            # Antes de usar el método editar() del modelo, hay que setear el id. ($this->modelo->id).
            if($this->modelo->editar($save)){
                # Importamos el modelo de Usuario para actualizarle un registro.
                $UsuarioModel = $this->importModel("UsuarioModel");
                # Seteamos el id al que está apuntando el modelo.
                $UsuarioModel->id = $_POST["Cliente"]["usuario_id"];
                
                $save = array();
                if(!empty($_POST["Usuario"]["contrasena"])){
                    $save["contrasena"] = md5($_POST["Usuario"]["contrasena"]);
                }
                $save["rut"] = $_POST["Usuario"]["rut"];
                $save["dv"] = $_POST["Usuario"]["dv"];
                $save["nombre_completo"] = $_POST["Usuario"]["nombre_completo"];
                $UsuarioModel->editar($save);
                
                $_SESSION["var_consumibles"]["msg_exito"] = "Cliente guardado correctamente.";
                $this->redireccionar("Clientes.php?action=adminListadoClientes");
            }
            $_SESSION["var_consumibles"]["msg_error"] = "Ha ocurrido un error al intentar guardar el cliente.";
        }
        
        $conditions["id"] = $this->modelo->id;
        $cliente = $this->modelo->buscar("first",array(
            "conditions" => $conditions,
            "contain" => "Usuario"
        ));
        
        $TipoPersonaModel = $this->importModel("TipoPersonaModel");
        $tiposPersonas = $TipoPersonaModel->buscar("all");
        
        $this->render("Administrador/admin_edit_cliente.php",array(
            "id" => $this->modelo->id,
            "cliente" => $cliente,
            "tiposPersonas" => $tiposPersonas["TipoPersona"]
        ));
    }

    public function secretariaListadoClientes(){
        $clientes = $this->modelo->buscar('all',array(
            "contain" => array(
                "Usuario",
                "TipoPersona"
            )
        ));
        
        $this->render("Secretaria/listado_clientes.php",array(
            "clientes" => $clientes
        ));
    }
    public function index(){
        
        $this->render("Cliente/index.php");
    }
    
    public function getNombre(){
        if(!empty($_POST)){
            $conditions['rut'] = $_POST["rut"];
            
            $UsuarioModel = $this->importModel("UsuarioModel");
            $usuario = $UsuarioModel->buscar('first',array(
                'conditions' => $conditions
            ));
            if(empty($usuario)){
				echo "";
				exit();
			}
			
            $conditions = array();
            $conditions['usuario_id'] = $usuario["Usuario"]["id"];
            $cliente = $this->modelo->buscar('count',array(
                'conditions' => $conditions
            ));
            
            echo $cliente ? $usuario['Usuario']['nombre_completo'] : '';
        }
        exit();
    }
    
    public function reportesClientes(){
        $conditions = array();
        if(!empty($_POST)){
            if(!empty($_POST["tipo_persona_id"])){
                $conditions['tipo_persona_id'] = $_POST["tipo_persona_id"];
            }
            
        }
        $clientesAux = $this->modelo->buscar('all',array(
            'conditions' => $conditions,
            'contain' => array(
                'Usuario',
                'TipoPersona'
            )
        ));
        
        $AtencionModel = $this->importModel("AtencionModel");
        $clientes = array();
        foreach($clientesAux["Cliente"] as $key => $cliente){
            $cantidadAtenciones = $AtencionModel->buscar('count',array(
                'conditions' => array(
                    'cliente_id' => $cliente["id"],
                    'estado_id' => 5
                )
            ));
            if(!empty($_POST["cant_atenciones"]) && $cantidadAtenciones != $_POST["cant_atenciones"]){
                continue;
            }
            
            $clientes[$key] = $cliente;
            $clientes[$key]["cant_atenciones"] = $cantidadAtenciones;
        }
        
        $TipoPersonaModel = $this->importModel("TipoPersonaModel");
        $tiposPersona = $TipoPersonaModel->buscar('all');
        
        $this->render("Gerente/reportes_clientes.php",array(
            'clientes' => $clientes,
            'tiposPersona' => $tiposPersona["TipoPersona"]
        ));
    }
    
    public function gerenteListadoClientes(){
        $clientes = $this->modelo->buscar('all',array(
            "contain" => array(
                "Usuario",
                "TipoPersona"
            )
        ));
        
        $this->render("Gerente/gerente_listado_clientes.php",array(
            "clientes" => $clientes
        ));
    }
}
$oCliente = new Clientes($_GET["action"]);