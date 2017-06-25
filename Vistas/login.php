<?php
    $currentMenu = "Ingresar";
    include "header.php";
?>
<section class="main_content">
    <form action="<?=CONTROLLER_PATH."Usuario.php?action=login";?>" method="POST">
        <?php include "mensajes.php"; ?>
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