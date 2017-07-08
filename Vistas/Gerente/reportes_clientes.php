<?php
    $currentMenu = "Reportes Clientes";
    include APP_VIEWS."header.php";
?>
<section class="main_content col-md-offset-1 col-md-10">
    <?php include APP_VIEWS."mensajes.php";?>
    <h3>Filtrar Por:</h3>
    <form class="form-inline" name="FiltrarClientes" action="<?=CONTROLLER_PATH.'Clientes.php?action=reportesClientes';?>" method="POST">
        <div class="form-group">
            <label>Antiguedad (Meses): </label>
            <input type="number" class="form-control number" name="antiguedad">
        </div>
        <div class="form-group">
            <label>Número de Atenciones (Recibidas): </label>
            <input type="number" class="form-control number" name="cant_atenciones" value="<?=!empty($_POST['cant_atenciones']) ? $_POST['cant_atenciones'] : '';?>">
        </div>
        <div class="form-group">
            <label>Tipo Persona: </label>
            <select name="tipo_persona_id" class="form-control">
                <option value="">Seleccione</option>
                <?php foreach($tiposPersona as $value): ?>
                    <option value="<?=$value['id'];?>" <?=!empty($_POST["tipo_persona_id"]) && $_POST["tipo_persona_id"] == $value["id"] ? 'selected="selected"' : '';?>>
                        <?=utf8_encode($value['descripcion']);?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Filtrar</button>
    </form>
    <br /><br /><br />
    <table class="table table-hover dataTable">
        <thead>
            <tr>
                <th>Rut</th>
                <th>Nombre Completo</th>
                <th>Tipo Persona</th>
                <th>Fecha de Incorporación</th>
                <th>Atenciones Recibidas</th>
            </tr>
        </thead>
        <tbody><?php
        if(!empty($clientes)):
            foreach($clientes as $cliente): ?>
            
                <tr>
                    <td><?=$cliente["Usuario"]["rut"].'-'.$cliente["Usuario"]["dv"];?></td>
                    <td><?=utf8_encode($cliente["Usuario"]["nombre_completo"]);?></td>
                    <td><?=utf8_encode($cliente["TipoPersona"]["descripcion"]);?></td>
                    <td><?=date('d/m/Y',strtotime($cliente["fecha_incorporacion"]));?></td>
                    <td><?=$cliente["cant_atenciones"];?></td>
                </tr><?php
            endforeach;
        endif; ?>
        </tbody>
    </table>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        
    });
</script>
<?php include APP_VIEWS."footer.php";?>