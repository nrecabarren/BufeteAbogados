<?php
    $currentMenu = "Clientes";
    include APP_VIEWS."header.php";
?>
<section class="main_content col-md-offset-1 col-md-10">
    <?php include APP_VIEWS."mensajes.php";?>
    <div style="margin-top: 20px; margin-bottom: 40px;">
        <a href="<?=CONTROLLER_PATH."Clientes.php?action=adminAgregarCliente";?>" class="btn btn-primary">
            <i class="fa fa-plus"></i> Agregar Cliente
        </a>
    </div>
    <table id="listadoClientes" class="table table-hover table-responsive dataTable">
        <thead>
            <tr>
                <th>Cod.</th>
                <th>Nombre</th>
                <th>RUT</th>
                <th>Fecha Incorporación</th>
                <th>Tipo Persona</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($clientes["Cliente"] as $key => $cliente): ?>
                <tr>
                    <td><?=$cliente["id"];?></td>
                    <td><?=utf8_encode($cliente["Usuario"]["nombre_completo"]);?></td>
                    <td><?=$cliente["Usuario"]["rut"].'-'.$cliente["Usuario"]["dv"];?></td>
                    <td><?=date("d/m/Y",strtotime($cliente["fecha_incorporacion"]));?></td>
                    <td><?=utf8_encode($cliente["TipoPersona"]["descripcion"]);?></td>
                    <td class="text-center">
                        <a href="<?=CONTROLLER_PATH."Clientes.php?action=adminEditCliente&id=".$cliente["id"];?>"><i class="fa fa-edit"></i></a>
                        <a href="javascript:;"><i class="fa fa-ban"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php include APP_VIEWS."footer.php";?>