<?php

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Registrar Firma",TRUE);
    
    include("./menu.php");
    writeMenu(2);
?>   
        
        <div id="contenido">
            <h2>Registrar Firma</h2>
            <?php 
                include("./formFirma.php");
                writeForm(FALSE, $db);
             ?>
        </div>  

<?php writeFooter(); ?>