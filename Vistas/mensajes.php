<?php if(!empty($_SESSION["var_consumibles"]["msg_error"])){ ?>
    <div class="msg msg-error">
        <?php
            echo $_SESSION["var_consumibles"]["msg_error"];
            $_SESSION["var_consumibles"]["msg_error"] = "";
        ?>
    </div>
<?php } elseif(!empty($_SESSION["var_consumibles"]["msg_exito"])) { ?>
    <div class="msg msg-success">
        <?php
            echo $_SESSION["var_consumibles"]["msg_exito"];
            $_SESSION["var_consumibles"]["msg_exito"] = "";
        ?>
    </div>
<?php } ?>