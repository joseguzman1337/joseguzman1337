<?php

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Registrar Plantilla",TRUE);
    
    include("./menuPlantillas.php");
    writeMenu(2);
?>   
        
        <div id="contenido">
            <h2>Registrar Plantilla Documento</h2>
            <?php 
                include("./formPlantilla.php");
                writeForm(FALSE, $db);
             ?>
        </div>  

<?php writeFooter(); ?>