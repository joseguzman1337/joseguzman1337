<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once("../variables.php");
     include($rutaTemplate."templateNumericos.php");
   // $db = writeHeader("Editar Asignación",TRUE,$proyectoNumericos);
    $db = writeHeader("Editar Asignación",TRUE,$proyectoNumericos,"../../","body",$Utils_numericos);

    include("./menu.php");
    writeMenu(0);
?>
        
        <div id="contenido">
            <h2>Editar Asignación de un Indicador</h2>
            <?php 
                include("./form.php"); 
               // var_dump($_REQUEST["id"]);
                writeForm(TRUE,$db,str_replace('row_','',$_REQUEST["id"]));
            ?>
        </div>

<?php writeFooter(); ?>
