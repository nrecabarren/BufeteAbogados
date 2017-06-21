<?php
    include "../Config/constants.php";
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Language" content="es">
        <title>DURALEX | Ingresar</title>
        <link href="<?='../webroot/css/style.css';?>" rel="stylesheet" type="text/css">
    </head>
    <body>
        <header>
            <div class="enterprise_name">
                <h2>DURALEX ltda.</h2>
            </div>
            <div class="main_menu">
                <?php require("main_menu.php");?>
            </div>
        </header>
        <section class="main_content">
            <form action="<?=CONTROLLER_PATH."Usuario.php?action=login";?>" method="POST">
                <?php if(!empty($_SESSION["var_consumibles"]["msg_error"])){ ?>
                    <div class="msg msg-error">
                        <?php
                            echo $_SESSION["var_consumibles"]["msg_error"];
                            $_SESSION["var_consumibles"]["msg_error"] = "";
                        ?>
                    </div>
                <?php } ?>
                <fieldset>
                    <label>RUT:</label>
                    <input type="text" name="rut_usuario" maxlength="8">
                </fieldset>
                <fieldset>
                    <label>Contraseña:</label>
                    <input type="password" name="contrasena_usuario">
                </fieldset>
                <input type="submit" value="Enviar">
            </form>
        </section>
    </body>
</html>