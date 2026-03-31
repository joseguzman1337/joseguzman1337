<?php
/*
 * Caso 90158
 * @modified Luis Dario Gualteros C
 * <castroluisd@unbosque.edu.co>
 * Se modifica la variable session_start por la session_start( ) ya que es la funcion la que contiene el valor de la variable $_SESSION.
 * @since Mayo 18 de 2017
*/
session_start( );
//End Caso  90158

include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
   $ValidarSesion = new ValidarSesion();
   $ValidarSesion->Validar($_SESSION);
	
require_once(realpath(dirname(__FILE__)).'/../Connections/sala2.php');

	mysql_select_db($database_sala, $sala);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Encuestas de Egresados</title>
<link rel="stylesheet" type="text/css" href="../estilos/sala.css"></link>
<script type="text/javascript" src="js/jquery.js"></script>
<style>
    button, input[type="submit"], input[type="reset"], input[type="button"], .button {
    background-color: #ECF1F4;
    background-image: url("../../../../index.php?entryPoint=getImage&themeName=Sugar5&imageName=bgBtn.gif");
    border-color: #ABC3D7;
    color: #000000;
}
</style>
</head>


<body>
<table align="center" width="50%" style="" >
    <tr><td colspan="3">Modulo Gestión de Egresados <hr></td></tr>
    <tr>
        <td width="33%" align="center"><a href="campo_evaluacion_egresado.php" title="Campos Evaluacion de Egresados"><img src= "img/icon_Fields.gif" title="Campos Evaluacion de Egresados"/></a><div>Administracion de Formulario</div></td>
        <td width="33%" align="center"><a href="consulta_egresado.php" title="Campos Evaluacion de Egresados"><img src= "img/icon_Leads_32.gif" title="Resultados Evaluacion de Egresados" width="48px" height="48px" /></a><div>Encuesta Egresados</div></td>
        <td width="33%" align="center"><a href="reporte_egresado.php" title="Campos Evaluacion de Egresados"><img src= "img/icon_Layouts.gif" title="Reportes de seguimiento Egresados" /></a><div>Reportes</div></td>
    </tr>
    <tr>
    <td></td>
    <td></td>
    <td></td>
    </tr>
</table>
</body>
</html>