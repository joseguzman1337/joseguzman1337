<?php

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Editar Plantilla",TRUE);

    include("./menuPlantillas.php");
    writeMenu(0);
?>
        
        <div id="contenido">
            <h2>Editar Plantilla Documento</h2>
            <?php 
                include("./formPlantilla.php");
                //var_dump($_REQUEST["id"]);                
                writeForm(TRUE,$db,str_replace('row_','',$_REQUEST["id"]));
            ?>
        </div>

<?php writeFooter(); ?>
