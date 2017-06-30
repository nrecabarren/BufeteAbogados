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
                    <td class="text-center">
                        <a href="<?=CONTROLLER_PATH."Usuario.php?action=adminEditarUsuario&id=".$usuario["id"];?>"><i class="fa fa-edit"></i></a>
                        <a href="javascript:;"><i class="fa fa-ban"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php include APP_VIEWS."footer.php";?>