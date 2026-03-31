<?php

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Editar un Tipo de Alerta",TRUE,$proyectoMonitoreo);

    include("./menu.php");
    writeMenu(0);
?>
        
        <div id="contenido">
            <h2>Editar Tipo de Alerta</h2>
            <?php 
                include("./form.php");             
                writeForm(TRUE,str_replace('row_','',$_REQUEST["id"]),$db);
            ?>
        </div>

<?php writeFooter(); ?>
