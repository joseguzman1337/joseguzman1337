<?php
$fechahoy=date("Y-m-d H:i:s");
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
//require_once("../../funciones/phpmailer/class.phpmailer.php");
require_once("funcionesreclamos.php");
session_start();

/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/
unset ($_SESSION['session_sqr']);
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
    </head>
    <BODY>
        <form name="form1" id="form1"  method="POST" action="">
            <?php
            inforequerimiento ($_REQUEST['idsolicitudquejareclamo']);
            ?>

        </form>
    </BODY>
</html>