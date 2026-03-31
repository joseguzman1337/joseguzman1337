<?php
require_once('../../../Connections/sala2.php'); 
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php'); 
require_once('../../../funciones/clases/autenticacion/redirect.php'); 
//mysql_select_db($database_sala, $sala);
session_start();
//require_once('seguridadmateriasgrupos.php');
if(isset($_SESSION['codigofacultad']))
{
	$codigocarrera = $_SESSION['codigofacultad'];
}

$query_planestudios = "select *
from  planestudio p 
where p.codigocarrera = '$codigocarrera'	
and p.codigoestadoplanestudio like '1%'";
//echo $query_planestudios,"<br>"; 
$planestudios = $db->Execute($query_planestudios);
$row_planestudios = $planestudios->FetchRow();
?>

<html>
<head>
<title>Busqueda de Materias y Grupos</title>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; }
-->
</style>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<body>

<div align="center">
<form name="f1" action="pensumseleccionreferencia.php" method="post">
  <p align="center">CRITERIO DE B&Uacute;SQUEDA DE MATERIAS</p>
  <table width="700" border="1" bordercolor="#E9E9E9" cellpadding="1" cellspacing="0">
    <tr>
     <td colspan="4" align="center" class="Estilo1" id="tdtitulogris">Plan de Estudios 
       <select name="planestudioselect">
<?
		do 
		{			
?>
            <option value="<?php echo $row_planestudios['idplanestudio'];?>"<?php if(!(strcmp($row_planestudios['idplanestudio'],$row_dataestudianteplan['idplanestudio']))) {echo "SELECTED";} ?>><?php echo $row_planestudios['nombreplanestudio']?></option>
 <?php				
    	} 
			while ($row_planestudios = $planestudios->FetchRow());
			$totalRows_planestudios  = $planestudios->RecordCount();
			if($totalRows_planestudios > 0)
			{    			
				$row_planestudios = $planestudios->FetchRow();
			}
?>
          </select>
	  </td>
      <td width="72" id="tdtitulogris">Fecha</td>
      <td width="92" align="center" class="Estilo1" ><?php echo $fechahoy=date("Y-m-d");?></td>
    </tr>
    <tr>
		 <td  id="tdtitulogris" colspan="4">Editar Materia
		   <input name="operacion" type="radio" value="1"  checked></td>
		 <td id="tdtitulogris" colspan="2">Agregar o Editar Contenido 
		   <input name="operacion" type="radio" value="2"></td>
    </tr>
	<tr>
      <td colspan="6" align="center" class="Estilo1"><input name="buscar" type="submit" value="Buscar">&nbsp; </td>
    </tr>
  </table>		
</form>
</div>
</body>
</html>