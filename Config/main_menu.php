<?php
$main_menu = array(
    "default" => array(
        0 => array(
            "name" => "Ingresar",
            "url" => CONTROLLER_PATH."Usuario.php?action=login"
        ),
        1 => array(
            "name" => "Registro",
            "url" => CONTROLLER_PATH."Usuario.php?action=registro"
        )
    ),
    
    # Administrador
    1 => array(
        0 => array(
            "name" => "Clientes",
            "url" => ""
        ),
        1 => array(
            "name" => "Abogados",
            "url" => ""
        ),
        2 => array(
            "name" => "Usuarios",
            "url" => ""
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
            "url" => ""
        ),
        1 => array(
            "name" => "Abogados",
            "url" => ""
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
    
    # Secretaría
    3 => array(
        0 => array(
            "name" => "Clientes",
            "url" => ""
        ),
        1 => array(
            "name" => "Abogados",
            "url" => ""
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