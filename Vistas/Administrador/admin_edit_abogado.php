<?php
    $currentMenu = "Abogados";
    include APP_VIEWS."header.php";
?>
<section class="main_content">
    <?php include APP_VIEWS."mensajes.php";?>
    <form action="Abogados.php?action=adminEditAbogado&id=<?=$id;?>" id="" method="POST">
        <input type="hidden" name="Abogado[id]" value="<?=$id;?>">
        <input type="hidden" name="Abogado[usuario_id]" value="<?=$abogado["Abogado"]["usuario_id"];?>">
        <fieldset>
            <label>RUT:</label>
            <input type="text" name="Usuario[rut]" value="<?=$abogado["Abogado"]["Usuario"]["rut"];?>">
        </fieldset>
        <fieldset>
            <label>Contraseña:</label>
            <input type="password" name="Usuario[contrasena]" value="">
        </fieldset>
        <fieldset>
            <label>Nombre Completo:</label>
            <input type="text" name="Usuario[nombre_completo]" value="<?=$abogado["Abogado"]["Usuario"]["nombre_completo"];?>">
        </fieldset>
        <fieldset>
            <label>Valor Hora:</label>
            <input type="text" name="Abogado[valor_hora]" value="<?=$abogado["Abogado"]["valor_hora"];?>">
        </fieldset>
        <fieldset>
            <label>Especialidad:</label>
            <select name="Abogado[especialidad_id]">
                <option value="">Seleccione</option>
                <?php
                    foreach($tiposEspecialidad as $key => $dato):
                        $selected = ($dato["id"] == $abogado["Abogado"]["especialidad_id"]) ? 'selected="selected"' : '';
                        echo '<option value="'.$dato["id"].'" '.$selected.'>';
                        echo utf8_encode($dato["nombre"]);
                        echo '</option>';
                    
                    endforeach;
                ?>
            </select>
        </fieldset>
        <input type="submit" value="Guardar">
    </form>
</section>
<?php include APP_VIEWS."footer.php";?>