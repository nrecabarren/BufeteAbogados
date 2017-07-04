<?php
$main_menu = array(
    "default" => array(
        0 => array(
            "name" => "Ingresar",
            "url" => CONTROLLER_PATH."Usuario.php?action=login"
        ),
        /*1 => array(
            "name" => "Registro",
            "url" => CONTROLLER_PATH."Usuario.php?action=registro"
        )*/
    ),
    
    # Administrador
    1 => array(
        0 => array(
            "name" => "Clientes",
            "url" => CONTROLLER_PATH."Clientes.php?action=adminListadoClientes"
        ),
        1 => array(
            "name" => "Abogados",
            "url" => CONTROLLER_PATH."Abogados.php?action=adminListadoAbogados"
        ),
        2 => array(
            "name" => "Usuarios",
            "url" => CONTROLLER_PATH."Usuario.php?action=adminListadoUsuarios"
        ),
        3 => array(
            "name" => "Salir",
            "url" => CONTROLLER_PATH."Usuario.php?action=logout"
        )
    ),
    
    # Gerente
    2 => array(
        0 => array(
            "name" => "Clientes",
            "url" => CONTROLLER_PATH."Clientes.php?action=gerenteListadoClientes"
        ),
        1 => array(
            "name" => "Abogados",
            "url" => CONTROLLER_PATH."Abogados.php?action=gerenteListadoAbogados"
        ),
        2 => array(
            "name" => "Atenciones",
            "url" => ""
        ),
        3 => array(
            "name" => "Salir",
            "url" => CONTROLLER_PATH."Usuario.php?action=logout"
        )
    ),
    
    # Secretaria
    3 => array(
        0 => array(
            "name" => "Clientes",
            "url" => CONTROLLER_PATH."Clientes.php?action=secretariaListadoClientes"
        ),
        1 => array(
            "name" => "Abogados",
            "url" => CONTROLLER_PATH."Abogados.php?action=secretariaListadoAbogados"
        ),
        2 => array(
            "name" => "Atenciones",
            "url" => ""
        ),
        3 => array(
            "name" => "Salir",
            "url" => CONTROLLER_PATH."Usuario.php?action=logout"
        )
    ),
    
    # Cliente
    4 => array(
        0 => array(
            "name" => "Mis Atenciones",
            "url" => ""
        ),
        1 => array(
            "name" => "Salir",
            "url" => CONTROLLER_PATH."Usuario.php?action=logout"
        )
    )
);