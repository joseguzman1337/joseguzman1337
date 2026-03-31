<?php

    include_once("../variables.php");
    include($rutaTemplate."templateNumericos.php");
    $db = writeHeader("Registrar Valor Indicador",TRUE,$proyectoNumericos,"../../","body",$Utils_numericos);
    
    
    include("./menu.php");
  //  writeMenu(2);
?>   
        
        <div id="contenido">
            <h2>Registrar Valor Indicador</h2>
            <?php 
                include("./formTipo2.php");
                writeForm(false,str_replace('row_','',$_REQUEST["id"]), $db);
              // var_dump($_REQUEST["id"]);
                die();
             ?>
        </div>  

<?php writeFooter(); ?>
