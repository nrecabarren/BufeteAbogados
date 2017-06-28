<?php
    $currentMenu = "Abogados";
    include APP_VIEWS."header.php";
?>
<section class="main_content">
    <?php include APP_VIEWS."mensajes.php";?>
    <form action="Abogados.php?action=adminAgregarAbogado" id="" method="POST">
        <fieldset>
            <label>RUT:</label>
            <input type="text" name="Usuario[rut]">
        </fieldset>
        <fieldset>
            <label>Contraseña:</label>
            <input type="password" name="Usuario[contrasena]">
        </fieldset>
        <fieldset>
            <label>Nombre Completo:</label>
            <input type="text" name="Usuario[nombre_completo]">
        </fieldset>
        <fieldset>
            <label>Valor Hora:</label>
            <input type="text" name="Abogado[valor_hora]">
        </fieldset>
        <fieldset>
            <label>Especialidad:</label>
            <select name="Abogado[especialidad_id]">
                <option value="">Seleccione</option>
                <?php foreach($tiposEspecialidades as $key => $dato): ?>
                    <option value="<?=$dato["id"];?>">
                        <?=utf8_encode($dato["nombre"]);?>
                    </option>
                <?php endforeach; ?>
            </select>
        </fieldset>
        <input type="submit" value="Guardar">
    </form>
</section>
<?php include APP_VIEWS."footer.php";?>