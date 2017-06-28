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
                <input type="text" name="rut_usuario" maxlength="10" class="form-control number">
            </div>
            <div class="col-md-2">
                <input type="text" name="dv_usuario" maxlength="1" class="form-control" disabled="disabled">
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
        $('.number').maskMoney({
            thousands: '.',
            precision: 0,
            allowZero: true
        });
        
        $('.number').on('change',function(){
            var rut = $(this).val();
            var dv = getDV( rut.replace(/\./g,'') );
            $('input[name="dv_usuario"]').val(dv);
        });
        
        $('.btn-success').on('click',function(e){
            e.preventDefault();
            var error = 0;
            if( $('input[name="rut_usuario"]').val() == ""){
                $('input[name="rut_usuario"]').parent().addClass('has-error');
                error++;
            } else {
                if( $('input[name="rut_usuario"]').parent().hasClass('has-error') ){
                    $('input[name="rut_usuario"]').parent().removeClass('has-error');
                }
            }
            if( $('input[name="contrasena_usuario"]').val() == ""){
                $('input[name="contrasena_usuario"]').parent().addClass('has-error');
                error++;
            } else {
                if( $('input[name="contrasena_usuario"]').parent().hasClass('has-error') ){
                    $('input[name="contrasena_usuario"]').parent().removeClass('has-error');
                }
            }
            
            if(error == 0){
                $('#LoginForm').submit();
            } else {
                alert("Debe llenar todos los campos.");
            }
        });
        
        function getDV(numero) {
            nuevo_numero = numero.toString().split("").reverse().join("");
            for(i=0,j=2,suma=0; i < nuevo_numero.length; i++, ((j==7) ? j=2 : j++)) {
                suma += (parseInt(nuevo_numero.charAt(i)) * j); 
            }
            n_dv = 11 - (suma % 11);
            return ((n_dv == 11) ? 0 : ((n_dv == 10) ? "K" : n_dv));
        }
        
    });
</script>