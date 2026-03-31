<?php
    session_start;
	/*include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
	include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Registrar Nuevo Programa",TRUE);

    include("./menu.php");
    writeMenu(2);
?>

    <div id="contenido">
        <h4>Registrar Nuevo Programa de Educación Continuada</h4>
            <?php 
                include("./formRegistrarCurso.php");
                writeForm(FALSE,$db);
             ?>
    </div>  

<?php  writeFooter(); ?>
