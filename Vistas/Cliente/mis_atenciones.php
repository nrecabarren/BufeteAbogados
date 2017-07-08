<?php
    $currentMenu = "Mis Atenciones";
    include APP_VIEWS."header.php";
?>
<section class="main_content col-md-offset-1 col-md-10">
    <?php include APP_VIEWS."mensajes.php";?>
    
    <?php if($noConfirmadasFinal): ?>
        <div class="alert alert-warning">
            ¡Atención! Usted posee atenciones en los próximos días y aún no han sido confirmadas.
        </div>
    <?php endif;?>
    <table id="listaAtenciones" class="table table-hover">
        <thead>
            <tr>
                <th></th>
                <th>Código</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Abogado</th>
                <th>Especialidad</th>
                <th>Valor</th>
                <th>Estado</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($atenciones)): ?>
            <?php foreach($atenciones as $atencion): ?>
                <tr>
                    <td>
                        <?php
                        if( $atencion["icon"] == "danger" ){
                            echo '<i class="fa fa-times-circle" style="color: #a94442;" data-toggle="tooltip" title="La atención fue anulada o perdida"></i>';
                        } elseif( $atencion["icon"] == "warning" ){
                            echo '<i class="fa fa-warning" style="color: #8a6d3b;" data-toggle="tooltip" title="Atención no confirmada"></i>';
                        } elseif( in_array($atencion["estado_id"],array(3,5)) ) {
                            echo '<i class="fa fa-check" style="color: #3c763d;" data-toggle="tooltip" title="Atención confirmada y/o realizada"></i>';
                        }
                        ?>
                    </td>
                    <td><?=$atencion["id"];?></td>
                    <td><?=date('d/m/Y',strtotime($atencion["fecha_atencion"]));?></td>
                    <td><?=date('H:i',strtotime($atencion["hora_atencion"]));?></td>
                    <td><?=$atencion["Abogado"]["nombre_completo"];?></td>
                    <td><?=$atencion["Abogado"]["Especialidad"]["nombre"];?></td>
                    <td><?="$".number_format($atencion["Abogado"]["valor_hora"],0,',','.');?></td>
                    <td><?=$atencion["Estado"]["descripcion"];?></td>
                    <td class="text-center">
                        <?php
                            if($atencion["Estado"]["id"] == 1){ ?>
                                <a href="javascript:;" data-toggle="tooltip" title="Confirmar Atención" rel-estado="3" rel-id="<?=$atencion['id'];?>" class="changeEstatus"><i class="fa fa-check"></i></a>&nbsp;
                                <a href="javascript:;" data-toggle="tooltip" title="Anular Atención" rel-estado="2" rel-id="<?=$atencion['id'];?>" class="changeEstatus"><i class="fa fa-ban"></i></a>&nbsp;<?php
                            }elseif($atencion["Estado"]["id"] == 3){ ?>
                                <a href="javascript:;" data-toggle="tooltip" title="Anular Atención" rel-estado="2" rel-id="<?=$atencion['id'];?>" class="changeEstatus"><i class="fa fa-ban"></i></a><?php
                            }
                        ?>
                    </td>
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
                <h4 class="modal-title"><strong>Nueva Atención</strong></h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <a href="javascript:;" class="btn btn-primary agendarSubmit">Agendar</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#listaAtenciones').DataTable({
            "order": [ [1,"desc"],[2,"desc"] ],
                "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se han encontrado registros.",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primera",
                    "last": "Última",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            }
        });
        
        $('body').on('click','.changeEstatus',function(){
            var estado = $(this).attr('rel-estado');
            var atencion = $(this).attr('rel-id');
            
            if(estado == 2){
                var confirma = confirm("¿Está seguro que desea anular esta atención?");
                if(confirma){
                    location.href = "<?=CONTROLLER_PATH;?>Atenciones.php?action=cambiarEstado&atencion="+atencion+"&estado="+estado;
                }
            } else {
                location.href = "<?=CONTROLLER_PATH;?>Atenciones.php?action=cambiarEstado&atencion="+atencion+"&estado="+estado;
            }
        });
        
        $('body').on('click','.nuevaAtencionBtn',function(){
            $.ajax({
                url: "<?=CONTROLLER_PATH.'Atenciones.php?action=nuevaAtencion';?>",
                success: function(response){
                    $('#NuevaAtencionModal').find('.modal-body').html(response);
                    $('#NuevaAtencionModal').modal();
                }
            });
        });
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<?php include APP_VIEWS."footer.php";?>