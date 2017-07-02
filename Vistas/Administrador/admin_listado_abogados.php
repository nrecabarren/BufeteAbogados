<?php
    $currentMenu = "Abogados";
    include APP_VIEWS."header.php";
?>
<section class="main_content col-md-offset-1 col-md-10">
    <?php include APP_VIEWS."mensajes.php";?>
    <div style="margin-top: 20px; margin-bottom: 40px;">
        <a href="<?=CONTROLLER_PATH."Abogados.php?action=adminAgregarAbogado";?>" class="btn btn-primary">
            <i class="fa fa-plus"></i> Agregar Abogado
        </a>
    </div>
    <table id="listadoAbogados" class="table table-hover table-responsive dataTable">
        <thead>
            <tr>
                <th>Cod.</th>
                <th>Nombre</th>
                <th>RUT</th>
                <th>Fecha Contratación</th>
                <th>Valor Hora</th>
                <th>Especialidad</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($abogados)): ?>
            <?php foreach($abogados["Abogado"] as $key => $abogado): ?>
                <tr>
                    <td><?=$abogado["id"];?></td>
                    <td><?=utf8_encode($abogado["Usuario"]["nombre_completo"]);?></td>
                    <td><?=$abogado["Usuario"]["rut"].'-'.$abogado["Usuario"]["dv"];?></td>
                    <td><?=date("d/m/Y",strtotime($abogado["fecha_contratacion"]));?></td>
                    <td>$ <?=number_format($abogado["valor_hora"],0,'.',',');?></td>
                    <td><?=utf8_encode($abogado["Especialidad"]["nombre"]);?></td>
                    <td class="text-center">
                        <a href="<?=CONTROLLER_PATH."Abogados.php?action=adminEditAbogado&id=".$abogado["id"];?>"><i class="fa fa-edit"></i></a>
                        <a href="javascript:;"><i class="fa fa-ban"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php endif;?>
        </tbody>
    </table>
</section>
<?php include APP_VIEWS."footer.php";?>