<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
include_once ('../../../../EspacioFisico/templates/template.php');
$db = getBD();

require_once('../educacionContinuada/Excel/reader.php');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>cargue convenios</title>
        <link rel="stylesheet" type="text/css" href="../mgi/css/styleOrdenes.css" media="screen" />
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
		<script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <link type="text/css" href="../educacionContinuada/css/normalize.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="../educacionContinuada/css/style.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="css/style.css" rel="stylesheet"> 
    </head>
    <script>
        function validardatos()
        {
            
        } 
    </script>
    <body class="body">
    <div id="pageContainer">
        <div id="container" class="wrapper" align="center">
			<h4>Cargue Rotaciones</h4>   	
            <form name="f1" action="../rotaciones/CargueRotaciones.php" method="POST" enctype="multipart/form-data">
                <label>Archivo Rotaciones:</label>
                <input type="file" class="required" value="" name="file" id="file" /><br/><br/>                  
                <input name="buscar" type="submit" value="Cargar Datos" />
            </form>
        </div>
   </div>
   </body>
</html>