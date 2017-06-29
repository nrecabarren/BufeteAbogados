<?php
    $currentMenu = "Ingresar";
    include "header.php";
?>
<section class="main_content col-md-offset-1 col-md-10">
    <form action="<?=CONTROLLER_PATH."Usuario.php?action=login";?>" method="POST" class="col-md-offset-3 col-md-6" id="LoginForm">
        <?php include "mensajes.php"; ?>
        <fieldset class="form-group row">
            <label class="control-label col-md-3 col-md-offset-1">RUT :</label>
            <div class="col-md-4">
                <input type="text" name="rut_usuario" maxlength="10" class="form-control number rutInput">
            </div>
            <div class="col-md-2">
                <input type="text" name="dv_usuario" maxlength="1" class="form-control dvInput">
            </div>
        </fieldset>
        <fieldset class="form-group row">
            <label class="control-label col-md-3 col-md-offset-1">Contraseña:</label>
            <div class="col-md-6">
                <input type="password" name="contrasena_usuario" class="form-control">
            </div>
        </fieldset>
        <fieldset class="form-group row text-right">
            <button type="submit" class="btn btn-success" style="margin-right: 18%;">Enviar</button>
        </fieldset>
    </form>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $('.btn-success').on('click',function(e){
            e.preventDefault();
            var error = 0;
            $('#LoginForm').find('input').each(function(){
                
                if( $(this).val() == "" ){
                    if( !$(this).parent().hasClass('has-error') ){
                        $(this).parent().addClass('has-error');
                    }
                    error++;
                } else {
                    if( $(this).parent().hasClass('has-error') ){
                        $(this).parent().removeClass('has-error');
                    }
                }
            });
            
            if(error == 0){
                $('#LoginForm').submit();
            } else {
                alert("Debe llenar todos los campos.");
            }
        });
    });
</script>