<?php
    $currentMenu = "Atenciones";
    include APP_VIEWS."header.php";
?>
<section class="main_content col-md-offset-1 col-md-10">
    <?php include APP_VIEWS."mensajes.php";?>
    <div style="margin-top: 20px; margin-bottom: 40px;">
        <a href="javascript:;" class="btn btn-primary nuevaAtencionBtn">
            <i class="fa fa-plus"></i> Nueva Atención
        </a>
    </div>
    <table class="table table-hover dataTable">
        <thead>
            <tr>
                <th>Código</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Cliente</th>
                <th>Abogado</th>
                <th>Especialidad</th>
                <th>Valor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($atenciones)): ?>
            <?php foreach($atenciones as $atencion): ?>
                <tr>
                    <td><?=$atencion["id"];?></td>
                    <td><?=date('d/m/Y',strtotime($atencion["fecha_atencion"]));?></td>
                    <td><?=date('H:i',strtotime($atencion["hora-atencion"]));?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endforeach;?>
            <?php endif; ?>
        </tbody>
    </table>
</section>
<div id="NuevaAtencionModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Nueva Atención</h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <a href="javascript:;" class="btn btn-primary">Guardar</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('body').on('click','.nuevaAtencionBtn',function(){
            $.ajax({
                url: "<?=CONTROLLER_PATH.'Atenciones.php?action=nuevaAtencion';?>",
                success: function(response){
                    $('#NuevaAtencionModal').find('.modal-body').html(response);
                    $('#NuevaAtencionModal').modal();
                }
            });
        });
    });
</script>
<?php include APP_VIEWS."footer.php";?>