<?php
    $currentMenu = "Reportes Atenciones";
    include APP_VIEWS."header.php";
?>
<section class="main_content col-md-offset-1 col-md-10">
    <?php include APP_VIEWS."mensajes.php";?>
    <h3>Filtrar Por:</h3>
    <form class="form-inline" name="FiltrarAtenciones" action="<?=CONTROLLER_PATH.'Atenciones.php?action=reportesAtenciones';?>" method="POST">
        <div class="form-group">
            <label>Especialidad</label>
            <select name="especialidad_id" class="form-control">
                <option value="">Seleccione</option>
                <?php foreach($especialidades as $value): ?>
                    <option value="<?=$value['id'];?>" <?=!empty($_POST["especialidad_id"]) && $_POST["especialidad_id"] == $value["id"] ? 'selected="selected"' : '';?>>
                        <?=utf8_encode($value['nombre']);?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Abogado</label>
            <select name="abogado_id" class="form-control">
                <option value="">Seleccione</option>
                <?php foreach($abogados as $key => $value): ?>
                    <option value="<?=$key;?>" <?=!empty($_POST["abogado_id"]) && $_POST["abogado_id"] == $key ? 'selected="selected"' : '';?>>
                        <?=utf8_encode($value);?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Estado</label>
            <select name="estado_id" class="form-control">
                <option value="">Seleccione</option>
                <?php foreach($estados as $value): ?>
                    <option value="<?=$value['id'];?>" <?=!empty($_POST["estado_id"]) && $_POST["estado_id"] == $value["id"] ? 'selected="selected"' : '';?>>
                        <?=$value['descripcion'];?>
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
                <th>Cantidad de Atenciones Realizadas</th>
                <th>Valorización de las Atenciones</th>
                <th>Abogado</th>
                <th>Especialidad</th>
            </tr>
        </thead>
        <tbody><?php
        if(!empty($atenciones)):
            $cantidad = $valorizacion = 0;
            $abogado = $especialidad = 'Todos(as)';
            foreach($atenciones["Atencion"] as $atencion):
                $cantidad++;
                $valorizacion += $atencion['Abogado']['valor_hora'];
                
                if(!empty($_POST["abogado_id"])){
                    $abogado = $abogados[$_POST['abogado_id']];
                }
            endforeach;?>
                <tr>
                    <td><?=$cantidad;?></td>
                    <td><?="$".number_format($valorizacion,0,',','.');?></td>
                    <td><?=utf8_encode($abogado);?></td>
                    <td><?=$especialidad;?></td>
                </tr><?php
        endif; ?>
        </tbody>
    </table>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        
    });
</script>
<?php include APP_VIEWS."footer.php";?>