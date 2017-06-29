<?php
    $currentMenu = "Clientes";
    include APP_VIEWS."header.php";
?>
<section class="main_content col-md-offset-1 col-md-10">
    <?php include APP_VIEWS."mensajes.php";?>
    <form action="Clientes.php?action=adminEditCliente&id=<?=$id;?>" id="EditarClienteForm" method="POST" class="col-md-offset-3 col-md-6">
        <input type="hidden" name="Cliente[id]" value="<?=$id;?>">
        <input type="hidden" name="Cliente[usuario_id]" value="<?=$cliente["Cliente"]["usuario_id"];?>">
        <fieldset class="form-group row">
            <label class="control-label col-md-3 col-md-offset-1">RUT:</label>
            <div class="col-md-4">
                <input type="text" name="Usuario[rut]" value="<?=$cliente["Cliente"]["Usuario"]["rut"];?>" class="form-control number rutInput" maxlength="10">
            </div>
            <div class="col-md-2">
                <input type="text" name="Usuario[dv]" class="form-control dvInput" maxlength="1">
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="control-label col-md-3 col-md-offset-1">Contraseña:</label>
            <div class="col-md-6">
                <input type="password" name="Usuario[contrasena]" value="<?=$cliente["Cliente"]["Usuario"]["dv"];?>" class="form-control">
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="control-label col-md-3 col-md-offset-1">Nombre Completo:</label>
            <div class="col-md-6">
                <input type="text" name="Usuario[nombre_completo]" value="<?=$cliente["Cliente"]["Usuario"]["nombre_completo"];?>" class="form-control">
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="control-label col-md-3 col-md-offset-1">Dirección:</label>
            <div class="col-md-6">
                <input type="text" name="Cliente[direccion]" value="<?=$cliente["Cliente"]["direccion"];?>" class="form-control">
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="control-label col-md-3 col-md-offset-1">Teléfono:</label>
            <div class="col-md-6">
                <input type="text" name="Cliente[telefono]" value="<?=$cliente["Cliente"]["telefono"];?>" class="form-control">
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="control-label col-md-3 col-md-offset-1">Tipo Persona:</label>
            <div class="col-md-6">
                <select name="Cliente[tipo_persona_id]" class="form-control">
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
            </div>
        </fieldset>
        <div class="row">
            <a class="btn btn-default col-md-offset-2" href="<?=CONTROLLER_PATH.'Clientes.php?action=adminListadoClientes';?>">Volver</a>
            <button type="submit" class="btn btn-success col-md-offset-2">Guardar</button>
        </div>
    </form>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $('.btn-success').on('click',function(e){
            e.preventDefault();
            var error = 0;
            $('#EditarClienteForm').find('input,select').each(function(){
                if( $(this).val() == "" && $(this).attr('type') != "password" ){
                    if( !$(this).parent().hasClass('has-error') ){
                        $(this).parent().removeClass('has-success');
                        $(this).parent().addClass('has-error');
                    }
                    error++;
                } else {
                    if( $(this).parent().hasClass('has-error') ){
                        $(this).parent().removeClass('has-error');
                    }
                    $(this).parent().addClass('has-success');
                }
            });
            
            if(error == 0){
                $('#EditarClienteForm').submit();
            } else {
                alert('Debe llenar todos los campos');
            }
        });
    });
</script>
<?php include APP_VIEWS."footer.php";?>