<?php

    session_start;
	include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
	
	include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Editar Datos Docente",TRUE);

    include("./menu.php");
    writeMenu(0);
?>
        
        <div id="contenido">
            <h2>Editar Datos Docente</h2>
            <?php 
                include("./form.php");
                //var_dump($_REQUEST["id"]);                
                writeForm(TRUE,str_replace('row_','',$_REQUEST["id"]),$db);
            ?>
        </div>

<?php writeFooter(); ?>
