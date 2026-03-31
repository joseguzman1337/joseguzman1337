<?php

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Registro de un Nuevo Indicador", TRUE,$proyectoMonitoreo);
    
    include("./menu.php");
    writeMenu(2);
?>   
        
        <div id="contenido">
            <h2>Registrar Nuevo Indicador</h2>
            <?php 
                include("./form.php");
                writeForm(FALSE, "", $db);
             ?>
        </div>  

<?php writeFooter(); ?>
