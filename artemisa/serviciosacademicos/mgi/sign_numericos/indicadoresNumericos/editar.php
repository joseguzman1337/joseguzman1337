<?php
    
include_once("../variables.php");
    include($rutaTemplate."templateNumericos.php");
    $db = writeHeader("Editar Valor Indicador",TRUE,$proyectoNumericos,"../../","body",$Utils_numericos);

    include("./menu.php");
 //   writeMenu(0);
?>
        
        <div id="contenido">
            <h2>Editar Valor Indicador</h2>
            <?php 
                include("./form.php");
                 //var_dump($_REQUEST["id"]);
                writeForm(TRUE,str_replace('row_','',$_REQUEST["id"]), $db);
            ?>
        </div>

<?php writeFooter(); ?>
