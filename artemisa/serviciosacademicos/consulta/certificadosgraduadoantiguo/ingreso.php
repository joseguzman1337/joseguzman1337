<?php
session_start();
include_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);   

$fechahoy=date("Y-m-d H:i:s");
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
//require_once("../../funciones/phpmailer/class.phpmailer.php");
require_once("funcionescertificado.php");

$codigoestudiante=$_GET['codigoestudiante'];
//session_start();
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/
//unset ($_SESSION['session_sqr']);
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
        <style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
        <script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
        <script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
        <script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
    </head>
    <BODY>
        <form name="form1" id="form1"  method="POST" action="">
            <?php
                ingreso ($codigoestudiante);
            ?>
            
        </form>
    </BODY>
</html>