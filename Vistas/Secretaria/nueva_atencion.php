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
            <input type="text" name="Cliente[nombre]" class="form-control" disabled="disabled" id="NombreCliente">
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
    <fieldset class="form-group row">
        <label class="control-label col-md-3 col-md-offset-1">Valor Hora:</label>
        <div class="col-md-6">
            <input type="text" name="Abogado[valor_hora]" class="form-control number" disabled="disabled" id="ValorHora">
        </div>
    </fieldset>
    <fieldset class="form-group row">
        <label class="control-label col-md-3 col-md-offset-1">Fecha:</label>
        <div class="col-md-6">
            <input type="text" name="Atencion[fecha_atencion]" class="form-control datepicker">
        </div>
    </fieldset>
    <fieldset class="form-group row">
        <label class="control-label col-md-3 col-md-offset-1">Hora:</label>
        <div class="col-md-6"><?php
            $horasAM = array(
                '08:00' => '08:00 - 08:59',
                '09:00' => '09:00 - 09:59',
                '10:00' => '10:00 - 10:59',
                '11:00' => '11:00 - 11:59'
            );
            $horasPM = array(
                '12:00' => '12:00 - 12:59',
                '13:00' => '13:00 - 13:59',
                '14:00' => '14:00 - 14:59',
                '15:00' => '15:00 - 15:59',
                '16:00' => '16:00 - 16:59',
                '17:00' => '17:00 - 17:59',
                '18:00' => '18:00 - 18:59'
            );?>
            <select name="Atencion[hora_atencion]" class="form-control">
                <optgroup label="Mañana">
                    <?php foreach($horasAM as $keyHora => $valueHora): ?>
                        <option value="<?=$keyHora;?>"><?=$valueHora;?></option>
                    <?php endforeach;?>
                </optgroup>
                <optgroup label="Tarde">
                    <?php foreach($horasPM as $keyHora => $valueHora): ?>
                        <option value="<?=$keyHora;?>"><?=$valueHora;?></option>
                    <?php endforeach;?>
                </optgroup>
            </select>
        </div>
    </fieldset>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('.number').maskMoney({
            thousands: '.',
            precision: 0,
            allowZero: true
        });
        
        $('.datepicker').datepicker({
            language: "es"
        });
        
        $('.dvInput, .rutInput').on('change',function(){
            var rut = $('.rutInput').val();
            var dv = getDV( rut.replace(/\./g,'') );
            if( $('.dvInput').val() != "" ){
                if( $('.dvInput').val().toUpperCase() != dv ){
                    if( !$('.rutInput').parent().hasClass('has-error') ){
                        $('.rutInput').parent().addClass('has-error');
                    }
                    $('.dvInput').val("");
                    $('#NombreCliente').val("");
                    alert('El rut ingresado es incorrecto.');
                } else {
                    if( $('.rutInput').parent().hasClass('has-error') ){
                        $('.rutInput').parent().removeClass('has-error');
                        $('.rutInput').parent().addClass('has-success');
                    }
                    $.ajax({
                        url: "<?=CONTROLLER_PATH.'Clientes.php?action=getNombre';?>",
                        data: { rut: $('.rutInput').val() },
                        type: "POST",
                        success: function(response){
                            if( $.trim(response) != "" ){
                                $('#NombreCliente').val( $.trim(response) );
                            } else {
                                $('#NombreCliente').val("");
                                $('.rutInput').val("");
                                $('.dvInput').val("");
                                alert("No se ha encontrado cliente en el sistema con el rut ingresado.");
                            }
                        }
                    });
                }
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
        
        
        // Cuando se seleccione una especialidad, buscamos a los abogados que tengan esa especialidad.
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
        
        $('#AbogadosSelect').on('change',function(){
            var abogado = $(this).val();
            if(abogado != ""){
                $.ajax({
                    url: "<?=CONTROLLER_PATH.'Abogados.php?action=getValorHora';?>",
                    data: { abogado : abogado },
                    type: "POST",
                    success: function(response){
                        console.log(response);
                        $('#ValorHora').val( $.trim(response) );
                    }
                });
            }
        });
        
        $('body').on('click','.agendarSubmit',function(e){
            e.preventDefault();
            var error = 0;
            $('#NuevaAtencion').find('input,select').each(function(){
                if( $(this).val() == "" ){
                    if( !$(this).parent().hasClass('has-error') ){
                        $(this).parent().removeClass('has-success');
                        $(this).parent().addClass('has-error');
                    }
                    error++;
                } else {
                    if( !$(this).parent().hasClass('has-success') ){
                        $(this).parent().removeClass('has-error');
                        $(this).parent().addClass('has-success');
                    }
                }
            });
            if(error == 0){
                $('#NuevaAtencion').submit();
            } else {
                alert("Debe rellenar todos los campos.");
            }
        });
    });
</script>