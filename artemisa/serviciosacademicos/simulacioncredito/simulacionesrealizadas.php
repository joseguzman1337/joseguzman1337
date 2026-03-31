<?php
session_start();

$rutaado = "../../funciones/adodb/";
require_once('../../Connections/sala2.php' );
require_once('../../Connections/salaado.php' );
require_once('../../funciones/simulacioncredito/clasesimulacioncredito.php' );
require_once('../../funciones/CalcDate.php' );

$codigoestudiante = $_SESSION['codigo'];
$codigoperiodo = $_SESSION['codigoperiodosesion'];

//echo $db;
// Creación de la clase simulacion credito
//$db->debug = true; 
@$sc = new clasesimulaciocredito($db,$seldataestudiante->fields['nombre'],$codigoestudiante);
// Inicializar valores de condición crédito
$sc->inicializarcondicioncredito($codigoperiodo);

$query_selsimulacioncredito = "SELECT idsimulacioncredito, codigoestudiante, fechasimulacioncredito, 
valorsimulacioncredito, fechadesdesimulacioncredito, fechahastasimulacioncredito, numerocuotassimulacioncredito, 
observacionsimulacioncredito, codigoestado, idcondicioncredito 
FROM simulacioncredito
where codigoestudiante = '$codigoestudiante'
and codigoestado like '1%'";
$selsimulacioncredito = $db->Execute($query_selsimulacioncredito); 
$totalRows_selsimulacioncredito = $selsimulacioncredito->RecordCount();
?>
<html>
<head>
<title>Seleccionar o crear simulación</title>
</head>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold; }
-->
</style>
<body>
<div align="center">
<form name="form1" method="get" action="">
<?php 
//echo $selsimulacioncredito->fields['idsimulacioncredito'];
if(!isset($_GET['idsimulacioncredito']))
{
?>
<p><strong>SIMULACIONES REALIZADAS</strong><br><br>
<table border="1" align="center" cellpadding="1" cellspacing="1" width="80%">
   <tr bgcolor="#C5D5D6"> 
      <td class="Estilo2" align="center">Id</td>
	  <td class="Estilo2" align="center">Fecha</td>
	  <td class="Estilo2" align="center">Valor</td>
	  <td class="Estilo2" align="center">Fecha Inicial</td>
	  <td class="Estilo2" align="center">Fecha Final</td>
	  <td class="Estilo2" align="center">Cuotas</td>
    </tr>
<?php
	while(!$selsimulacioncredito->EOF)
	{
?>
   <tr> 
      <td class="Estilo1" align="center"><a href="simulacionesrealizadas.php?idsimulacioncredito=<?php echo $selsimulacioncredito->fields['idsimulacioncredito']; ?>"><?php echo $selsimulacioncredito->fields['idsimulacioncredito']; ?></a></td>
	  <td class="Estilo1" align="center"><?php echo $selsimulacioncredito->fields['fechasimulacioncredito']; ?></td>
	  <td class="Estilo1" align="center"><?php echo $selsimulacioncredito->fields['valorsimulacioncredito']; ?></td>
	  <td class="Estilo1" align="center"><?php echo $selsimulacioncredito->fields['fechadesdesimulacioncredito']; ?></td>
	  <td class="Estilo1" align="center"><?php echo $selsimulacioncredito->fields['fechahastasimulacioncredito']; ?></td>
	  <td class="Estilo1" align="center"><?php echo $selsimulacioncredito->fields['numerocuotassimulacioncredito']; ?></td>
    </tr>
<?php
		$selsimulacioncredito->MoveNext();
	}
?>
</table>
<br><br>
<input type="button" onClick="location.href='simulacioncredito.php';" value="Simulación"><input type="button" value="Regresar" onClick="window.location.reload('../prematricula/matriculaautomaticaordenmatricula.php')">
<?php
}
else if($_GET['idsimulacioncredito'] != 0)
{
	$sc->formulariosimulacion("../../funciones/simulacioncredito/",$_GET['idsimulacioncredito']);
?>
 <br><br>
 <input type="button" value="Regresar" onClick="window.location.reload('simulacionesrealizadas.php')"><input type="button" value="Imprimir" onClick="window.open('formularioimpresionsimulacion.php?idsimulacioncredito=<?php echo $idsimulacioncredito;?>','miventana','width=800,height=600,left=100,top=50,scrollbars=yes')">
<?php
}
?>
</form>
</div>
</body>
</html>
