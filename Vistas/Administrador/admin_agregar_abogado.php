<?php
    $currentMenu = "Abogados";
    include APP_VIEWS."header.php";
?>
<section class="main_content col-md-offset-1 col-md-10">
    <?php include APP_VIEWS."mensajes.php";?>
    <form action="Abogados.php?action=adminAgregarAbogado" id="AdminAgregarAbogado" method="POST" class="col-md-offset-3 col-md-6">
        <fieldset class="form-group row">
            <label class="control-label col-md-3 col-md-offset-1">RUT :</label>
            <div class="col-md-4">
                <input type="text" name="Usuario[rut]" class="form-control number rutInput" maxlength="10">
            </div>
            <div class="col-md-2">
                <input type="text" name="Usuario[dv]" class="form-control dvInput" maxlength="1">
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="control-label col-md-3 col-md-offset-1">Contraseña:</label>
            <div class="col-md-6">
                <input type="password" name="Usuario[contrasena]" value="" class="form-control">
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="control-label col-md-3 col-md-offset-1">Nombre Completo:</label>
            <div class="col-md-6">
                <input type="text" name="Usuario[nombre_completo]" class="form-control soloLetras">
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="control-label col-md-3 col-md-offset-1">Valor Hora:</label>
            <div class="col-md-6">
                <input type="text" name="Abogado[valor_hora]" class="form-control number">
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="control-label col-md-3 col-md-offset-1">Fecha de Contratación:</label>
            <div class="col-md-6">
                <input type="text" name="Abogado[fecha_contratacion]" class="form-control datepicker" readonly="readonly">
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="control-label col-md-3 col-md-offset-1">Especialidad:</label>
            <div class="col-md-6">
                <select name="Abogado[especialidad_id]" class="form-control">
                    <option value="">Seleccione</option>
                    <?php foreach($especialidades as $key => $dato):?>
                        <option value="<?=$dato["id"];?>">
                            <?=utf8_encode($dato["nombre"]);?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="control-label col-md-3 col-md-offset-1">Perfil:</label>
            <div class="col-md-6">
                <select name="Usuario[perfil_id]" class="form-control">
                    <option value="">Seleccione</option>
                    <?php foreach($perfiles as $key => $dato):
                        if($dato['id'] == 2){ continue; } ?>
                        
                        <option value="<?=$dato["id"];?>">
                            <?=utf8_encode($dato["descripcion"]);?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </fieldset>
        <div class="row">
            <a class="btn btn-default col-md-offset-2" href="<?=CONTROLLER_PATH.'Abogados.php?action=adminListadoAbogados';?>">Volver</a>
            <button type="submit" class="btn btn-success col-md-offset-2">Guardar</button>
        </div>
    </form>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $('.btn-success').on('click',function(e){
            e.preventDefault();
            var error = 0;
            $('#AdminAgregarAbogado').find('input,select').each(function(){
                if( $(this).val() == "" ){
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
                $('#AdminAgregarAbogado').submit();
            } else {
                alert('Debe llenar todos los campos');
            }
        });
    });
</script>
<?php include APP_VIEWS."footer.php";?>