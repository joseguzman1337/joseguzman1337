<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Registro de una Alerta por Evento", TRUE,$proyectoMonitoreo);
    
    include("./menu.php");
    writeMenu(2);
?>   
        
        <div id="contenido">
            <h2>Registrar Alerta por Evento</h2>
            <?php 
                include("./form.php");
                writeForm(FALSE, "", $db);
             ?>
        </div>  

<?php writeFooter(); ?>