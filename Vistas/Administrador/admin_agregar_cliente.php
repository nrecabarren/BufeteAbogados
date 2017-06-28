<?php
    $currentMenu = "Clientes";
    include APP_VIEWS."header.php";
?>
<section class="main_content">
    <?php include APP_VIEWS."mensajes.php";?>
    <form action="Clientes.php?action=adminAgregarCliente" id="" method="POST">
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
            <label>Dirección:</label>
            <input type="text" name="Cliente[direccion]">
        </fieldset>
        <fieldset>
            <label>Teléfono:</label>
            <input type="text" name="Cliente[telefono]">
        </fieldset>
        <fieldset>
            <label>Tipo Persona:</label>
            <select name="Cliente[tipo_persona_id]">
                <option value="">Seleccione</option>
                <?php foreach($tiposPersonas as $key => $dato): ?>
                    <option value="<?=$dato["id"];?>">
                        <?=utf8_encode($dato["descripcion"]);?>
                    </option>
                <?php endforeach; ?>
            </select>
        </fieldset>
        <input type="submit" value="Guardar">
    </form>
</section>
<?php include APP_VIEWS."footer.php";?>