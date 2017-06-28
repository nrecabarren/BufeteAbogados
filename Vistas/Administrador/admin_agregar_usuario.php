<?php
    $currentMenu = "Usuarios";
    include APP_VIEWS."header.php";
?>
<section class="main_content col-md-offset-1 col-md-10">
    <?php include APP_VIEWS."mensajes.php";?>
    <form action="Usuario.php?action=adminAgregarUsuario" id="" method="POST" class="col-md-offset-3 col-md-6">
        <fieldset class="form-group row">
            <label class="control-label col-md-3 col-md-offset-1">RUT :</label>
            <div class="col-md-4">
                <input type="text" name="Usuario[rut]" class="form-control number" maxlength="10">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" disabled="disabled" name="Usuario[dv]">
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
                <input type="text" name="Usuario[nombre_completo]" class="form-control">
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
            <a class="btn btn-default col-md-offset-2" href="<?=CONTROLLER_PATH.'Usuario.php?action=adminListadoUsuarios';?>">Volver</a>
            <button type="submit" class="btn btn-success col-md-offset-2">Guardar</button>
        </div>
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
            $('input[name="Usuario[dv]"]').val(dv);
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
<?php include APP_VIEWS."footer.php";?>