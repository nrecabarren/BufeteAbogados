<?php include APP_CONFIG."main_menu.php"; ?>
<ul>
    <?php
    session_start();
    
    $menu = $main_menu["default"];
    if(!empty($_SESSION["user_logueado"])){
        
        $perfil_id = $_SESSION["user_logueado"]["perfil_id"];
        $menu = $main_menu["administrador"][$perfil_id];
    }
    
    foreach($menu as $key => $datosMenu):
        $url = !empty($datosMenu["url"]) ? $datosMenu["url"] : "javascript:;"; ?>
        
        <li>
            <a href="<?=$url;?>">
                <?=$datosMenu["name"];?>
            </a>
        </li><?php
    endforeach; ?>
</ul>