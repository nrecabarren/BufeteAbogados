<?php
    $currentMenu = "Clientes";
    include APP_VIEWS."header.php";
?>
<section class="main_content">
    <?php include APP_VIEWS."mensajes.php";?>
    <form action="Clientes.php?action=adminEditCliente&id=<?=$id;?>" id="" method="POST">
        <input type="hidden" name="Cliente[id]" value="<?=$id;?>">
        <input type="hidden" name="Cliente[usuario_id]" value="<?=$cliente["Cliente"]["usuario_id"];?>">
        <fieldset>
            <label>RUT:</label>
            <input type="text" name="Usuario[rut]" value="<?=$cliente["Cliente"]["Usuario"]["rut"];?>">
        </fieldset>
        <fieldset>
            <label>Contraseña:</label>
            <input type="password" name="Usuario[contrasena]" value="">
        </fieldset>
        <fieldset>
            <label>Nombre Completo:</label>
            <input type="text" name="Usuario[nombre_completo]" value="<?=$cliente["Cliente"]["Usuario"]["nombre_completo"];?>">
        </fieldset>
        <fieldset>
            <label>Dirección:</label>
            <input type="text" name="Cliente[direccion]" value="<?=$cliente["Cliente"]["direccion"];?>">
        </fieldset>
        <fieldset>
            <label>Teléfono:</label>
            <input type="text" name="Cliente[telefono]" value="<?=$cliente["Cliente"]["telefono"];?>">
        </fieldset>
        <fieldset>
            <label>Tipo Persona:</label>
            <select name="Cliente[tipo_persona_id]">
                <option value="">Seleccione</option>
                <?php
                    foreach($tiposPersonas as $key => $dato):
                        $selected = ($dato["id"] == $cliente["Cliente"]["tipo_persona_id"]) ? 'selected="selected"' : '';
                        echo '<option value="'.$dato["id"].'" '.$selected.'>';
                        echo utf8_encode($dato["descripcion"]);
                        echo '</option>';
                    
                    endforeach;
                ?>
            </select>
        </fieldset>
        <input type="submit" value="Guardar">
    </form>
</section>
<?php include APP_VIEWS."footer.php";?>