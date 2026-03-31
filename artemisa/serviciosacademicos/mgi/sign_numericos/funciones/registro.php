<?php
    include_once("../variables.php");
   // include($rutaTemplate."templateNumericos.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Registro de una nueva Función",TRUE,$proyectoNumericos,"../../","body",$Utils_numericos);

    include("./menu.php");
    writeMenu(2);
?>
        
        <div id="contenido">
            <h2>Registrar Nueva Función</h2>
            <?php 
                include("./form.php");
                writeForm(FALSE);
            ?>
        </div>

<?php writeFooter(); ?>
 