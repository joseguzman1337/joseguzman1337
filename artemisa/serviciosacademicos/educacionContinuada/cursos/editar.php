<?php

    session_start;
	/*include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
	include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Editar Programa",TRUE);

    include("./menu.php");
    writeMenu(0);
?>
        
        <div id="contenido">
            <h2>Editar Programa</h2>
            <?php 
                include("./formRegistrarCurso.php");
                //var_dump($_REQUEST["id"]);                
                writeForm(TRUE,$db,str_replace('row_','',$_REQUEST["id"]));
            ?>
        </div>

<?php writeFooter(); ?>
