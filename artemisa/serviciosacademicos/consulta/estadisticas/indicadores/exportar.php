<?php
session_start();
$formato="xls";
$nombrearchivo="matriz";
$nombrearchivo=trim($nombrearchivo);
$strType = 'application/msexcel';
$strName = "estadisticoindicador estudiante.xls";
error_reporting(0);
header("Content-Type: $strType charset=ASCII");
header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Pragma: public");
echo "<table cellpadding='0'cellspacing='0' border='1'>";
echo "<tr>";
echo "<td align='right' valign='bottom' width='480'>";
//TITULOS HORIZONTALES DE TITULOS VERTICALES
//echo $_SESSION["estadisticosesion"]["titulohorizontalvertical"];
echo "TITULO";
echo "</td>";
echo "<td align='left' valign='bottom'>";
//TITULOS HORIZONTALES
	echo $_SESSION["estadisticosesion"]["titulohorizontal"];
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td valign='top' align='right'>";
//TITULOS VERTICALES
	echo $_SESSION["estadisticosesion"]["titulovertical"];
echo "</td>";
echo "<td valign='top'>";
//AREA PRINCIPAL
	echo $_SESSION["estadisticosesion"]["areaprincipal"];
echo "</td>";
echo "</tr>";
echo "</table>";

?>
