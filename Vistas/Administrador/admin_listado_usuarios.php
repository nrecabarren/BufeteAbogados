<?php
    $currentMenu = "Usuarios";
    include APP_VIEWS."header.php";
?>
<section class="main_content col-md-offset-1 col-md-10">
    <?php include APP_VIEWS."mensajes.php";?>
    <div style="margin-top: 20px; margin-bottom: 40px;">
        <a href="<?=CONTROLLER_PATH."Usuario.php?action=adminAgregarUsuario";?>" class="btn btn-primary">
            <i class="fa fa-plus"></i> Agregar Usuario
        </a>
    </div>
    <table id="listadoUsuarios" class="table table-hover table-responsive dataTable">
        <thead>
            <tr>
                <th>Cod.</th>
                <th>RUT</th>
                <th>Nombre Completo</th>
                <th>Perfil</th>
                <th>Estado</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($usuarios["Usuario"] as $key => $usuario): ?>
                <tr>
                    <td><?=$usuario["id"];?></td>
                    <td><?=$usuario["rut"].'-'.$usuario["dv"];?></td>
                    <td><?=utf8_encode($usuario["nombre_completo"]);?></td>
                    <td><?=$usuario["Perfil"]["descripcion"];?></td>
                    <td><?=$usuario["estado"] ? 'Habilitado' : 'Inhabilitado';?></td>
                    <td class="text-center">
                        <a href="<?=CONTROLLER_PATH."Usuario.php?action=adminEditarUsuario&id=".$usuario["id"];?>"><i class="fa fa-edit"></i></a>
                        <?php if($usuario["estado"]){ ?>
                            <a href="javascript:;" class="cambiar_estado" rel-estado="0" rel-id="<?=$usuario["id"];?>"><i class="fa fa-ban"></i></a>
                        <?php } else { ?>
                            <a href="javascript:;" class="cambiar_estado" rel-estado="1" rel-id="<?=$usuario["id"];?>"><i class="fa fa-check"></i></a>
                        <?php }?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $('.cambiar_estado').on('click',function(e){
            var estado = $(this).attr('rel-estado');
            var usuario = $(this).attr('rel-id');
            $.ajax({
                url: "<?=CONTROLLER_PATH."Usuario.php?action=adminDarBajaUsuario";?>",
                type: "POST",
                data: { usuario: usuario, estado: estado },
                success: function(response){
                    location.reload(); 
                }
            });
        });
    });
</script>
<?php include APP_VIEWS."footer.php";?>