<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Language" content="es">
        <title>DURALEX | Ingresar</title>
        <link href="<?=BASE_URL;?>webroot/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?=BASE_URL;?>webroot/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
        <link href="<?=BASE_URL;?>webroot/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
        <link href="<?=BASE_URL;?>webroot/css/datatables.min.css" rel="stylesheet" type="text/css">
        <link href="<?=BASE_URL;?>webroot/css/jquery-ui.min.css" rel="stylesheet" type="text/css">
        <link href="<?=BASE_URL;?>webroot/css/font_awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?=BASE_URL;?>webroot/css/style.css" rel="stylesheet" type="text/css">
        <link href="<?=BASE_URL;?>webroot/css/jquery-ui.multidatespicker.css" type="text/css">
        <script src="<?=BASE_URL;?>webroot/js/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="<?=BASE_URL;?>webroot/js/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?=BASE_URL;?>webroot/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?=BASE_URL;?>webroot/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="<?=BASE_URL;?>webroot/js/jquery-ui.multidatespicker.js" type="text/javascript"></script>
        <script src="<?=BASE_URL;?>webroot/js/datatables.min.js" type="text/javascript"></script>
        <script src="<?=BASE_URL;?>webroot/js/jquery.maskMoney.min.js" type="text/javascript"></script>
        <script src="<?=BASE_URL;?>webroot/js/funciones.js" type="text/javascript"></script>
    </head>
    <body>
        <header>
            <div class="enterprise_name">
                <h2>DURALEX ltda.</h2>
            </div>
            <div class="main_menu">
                <?php include APP_CONFIG."main_menu.php"; ?>
                <ul>
                    <?php
                    $menu = $main_menu["default"];
                    if(!empty($_SESSION["user_logueado"])){
                        
                        $perfil_id = $_SESSION["user_logueado"]["perfil_id"];
                        $menu = $main_menu[$perfil_id];
                    }
                    
                    foreach($menu as $key => $datosMenu):
                        $url = !empty($datosMenu["url"]) ? $datosMenu["url"] : "javascript:;";
                        $active = !empty($currentMenu) && $currentMenu == $datosMenu["name"] ? "active" : "";
                        ?>
                        
                        <li>
                            <a href="<?=$url;?>" class="<?=$active;?>">
                                <?=$datosMenu["name"];?>
                            </a>
                        </li><?php
                    endforeach; ?>
                </ul>
            </div>
        </header>