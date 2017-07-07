<form name="NuevaAtencion" id="NuevaAtencion" action="Atenciones.php?action=nuevaAtencion" method="post">
    <fieldset class="form-group row">
        <label class="control-label col-md-3 col-md-offset-1">RUT Cliente:</label>
        <div class="col-md-4">
            <input type="text" name="Cliente[rut]" class="form-control number rutInput" maxlength="10">
        </div>
        <div class="col-md-2">
            <input type="text" name="Cliente[dv]" class="form-control dvInput" maxlength="1">
        </div>
    </fieldset>
    <fieldset class="form-group row">
        <label class="control-label col-md-3 col-md-offset-1">Nombre Cliente:</label>
        <div class="col-md-6">
            <input type="text" name="Cliente[nombre]" class="form-control">
        </div>
    </fieldset>
    <fieldset class="form-group row">
        <label class="control-label col-md-3 col-md-offset-1">Especialidad:</label>
        <div class="col-md-6">
            <select name="Abogado[especialidad]" id="AbogadoEspecilidad" class="form-control">
                <option value="">Seleccione</option>
                <?php foreach($especialidades as $especialidad): ?>
                    <option value="<?=$especialidad["id"];?>">
                        <?=utf8_encode($especialidad["nombre"]);?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </fieldset>
    <fieldset class="form-group row">
        <label class="control-label col-md-3 col-md-offset-1">Abogado:</label>
        <div class="col-md-6">
            <select name="Abogado[id]" id="AbogadosSelect" disabled="disabled" class="form-control">
                <option value="">Seleccione especialidad</option>
            </select>
        </div>
    </fieldset>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('#AbogadoEspecilidad').on('change',function(){
            var especialidad = $(this).val();
            if( especialidad != ""){
                $.ajax({
                    url: "<?=CONTROLLER_PATH."Abogados.php?action=getAbogadosByEspecialidad";?>",
                    data:{ especialidad: especialidad },
                    type: "POST",
                    success: function(response){
                        $('#AbogadosSelect').html(response);
                        $("#AbogadosSelect").removeAttr('disabled');
                    }
                });
            } else {
                $('#AbogadosSelect').html('<option value="">Seleccione especialidad</option>');
            }
        });
    });
</script>