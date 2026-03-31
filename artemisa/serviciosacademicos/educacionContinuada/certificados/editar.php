<?php

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Editar Firma",TRUE);

    include("./menu.php");
    writeMenu(0);
?>
        
        <div id="contenido">
            <h2>Editar Firma</h2>
            <?php 
                include("./formFirma.php");
                //var_dump($_REQUEST["id"]);                
                writeForm(TRUE,$db,str_replace('row_','',$_REQUEST["id"]));
            ?>
        </div>

<?php writeFooter(); ?>
