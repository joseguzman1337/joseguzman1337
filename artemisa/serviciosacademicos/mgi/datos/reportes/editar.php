<?php

    include("../templates/template.php");
    $db = writeHeader("Editar Reporte",TRUE);

    include("./menu.php");
    writeMenu(0);
    
    $utils = new Utils_datos();
    $id = str_replace('row_','',$_REQUEST["id"]);
    $reporte = $utils->getDataEntity("reporte",$id);
    
?>
        
        <div id="contenido">
            <h2>Editar Reporte</h2>
            <?php 
                include("./form.php");             
                writeForm(TRUE,$db,$id);
            ?>
        </div>

<?php writeFooter(); ?>
