<?php
    
include_once("../variables.php");
    include($rutaTemplate."templateNumericos.php");
    $db = writeHeader("Editar Valor Indicador",TRUE,$proyectoNumericos);

    include("./menu.php");
    writeMenu(0);
?>
        
        <div id="contenido">
            <h2>Editar Función</h2>
            <?php 
                include("./form.php");
                writeForm(TRUE,str_replace('row_','',$_REQUEST["id"]));
            ?>
        </div>

<?php writeFooter(); ?>
