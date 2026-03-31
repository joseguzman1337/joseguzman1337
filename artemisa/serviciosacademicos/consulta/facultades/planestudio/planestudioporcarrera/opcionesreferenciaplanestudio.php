<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../../Connections/sala2.php');
require_once("../../../../funciones/validacion.php");
require_once("../../../../funciones/errores_plandeestudio.php");
mysql_select_db($database_sala, $sala);
session_start();
require_once('../seguridadplandeestudio.php');
if(isset($_GET['planestudio']))
{
	$idplanestudio = $_GET['planestudio'];
	$materiaAreferenciar = $_GET['codigodemateria'];
	$limite = $_GET['limitesemestre'];
	$tipomateria = $_GET['tipomateriaenplan'];
	$idlineaenfasis = $_GET['lineaenfasis'];
	if($tipomateria == 5)
	{
		$query_selidlinea= "select idlineaenfasisplanestudio
		from detallelineaenfasisplanestudio
		where idplanestudio = '$idplanestudio'
		and codigomateriadetallelineaenfasisplanestudio = '$materiaAreferenciar'
		and codigotipomateria = '5'";
		$selidlinea = mysql_query($query_selidlinea, $sala) or die("$query_selidlinea");
		$totalRows_selidlinea = mysql_num_rows($selidlinea);
		$row_selidlinea = mysql_fetch_assoc($selidlinea);
		$idlineamodificar = $row_selidlinea['idlineaenfasisplanestudio'];
	}
	else
	{
		$idlineamodificar = 1;
	}
}
if(isset($_POST['modificargrupo']))
{
	echo "<script language='javascript'>
	window.opener.recargar2('?codigomateria1=$materiaAreferenciar&carrera1=".$_SESSION['codigofacultad']."');
	window.opener.focus();
	window.close();
  </script>";
}

$query_datomateria = "select nombremateria
from materia
where codigomateria = '".$_GET['codigodemateria']."'";
$datomateria = mysql_query($query_datomateria, $sala) or die("$query_datomateria");
$totalRows_datomateria = mysql_num_rows($datomateria);
$row_datomateria = mysql_fetch_assoc($datomateria);

if(isset($_GET['visualizado']))
{
	$visual = "&visualizado";
}
?>
<html>
<head>
<title>Opciones de Referencia Plan de Estudio</title>
<link rel="stylesheet" href="../../../../estilos/sala.css" type="text/css">
</head>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
}
.Estilo3 {color: #800000}
-->
</style>
<body>
<div align="center">
<form name="f1" method="post" action="opcionesreferenciaplanestudio.php<?php echo "?planestudio=$idplanestudio&codigodemateria=$materiaAreferenciar&limitesemestre=$limite&tipomateriaenplan=$tipomateria&lineaenfasis=$idlineaenfasis.$visual";?>">
<p  align="center"><strong>REFERENCIAR A <?php echo $row_datomateria['nombremateria'];?></strong></p>
<?php
$query_tiporeferencia= "select codigotiporeferenciaplanestudio, nombretiporeferenciaplanestudio
from tiporeferenciaplanestudio";
$tiporeferencia = mysql_query($query_tiporeferencia, $sala) or die("$query_detalleplanestudio");
$totalRows_tiporeferencia = mysql_num_rows($tiporeferencia);
$row_tiporeferencia = mysql_fetch_assoc($tiporeferencia);
$formulariovalido = 1;
?>
<table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
  	    <td align="center" bgcolor="#C5D5D6"><strong>Selecionar Tipo de Referencia</strong></td>
  </tr>
  <tr>
  	<td align="center" id="tdtitulogris">
	<select name="petiporeferencia">
        <option value="0" <?php if (!(strcmp(0, $_POST['petiporeferencia']))) {echo "SELECTED";} ?>>Seleccionar</option>
        <?php
		do
		{
?>
        <option value="<?php echo $row_tiporeferencia['codigotiporeferenciaplanestudio']?>"<?php if (!(strcmp($row_tiporeferencia['codigotiporeferenciaplanestudio'], $_POST['petiporeferencia']))) {echo "SELECTED";} ?>><?php echo $row_tiporeferencia['nombretiporeferenciaplanestudio']?></option>
        <?php
		}
		while ($row_tiporeferencia = mysql_fetch_assoc($tiporeferencia));
		$row_tiporeferencia = mysql_num_rows($tiporeferencia);
		if($row_tiporeferencia > 0)
		{
			mysql_data_seek($tiporeferencia, 0);
			$row_tiporeferencia = mysql_fetch_assoc($tiporeferencia);
		}
?>
      </select>


<?php
		if(isset($_POST['petiporeferencia']))
		{
			$validartiporeferencia = $_POST['petiporeferencia'];
			$imprimir = true;
			$tiporeferenciarequerido = validar($validartiporeferencia,"combo",$error1,$imprimir);
			$formulariovalido = $formulariovalido*$tiporeferenciarequerido;
		}
?>

	</td>
  </tr>
  <tr id="trtitulogris">
  	<td align="center" id="tdtitulogris">
  <input type="submit" value="Visualizar" name="aceptartiporeferencia" style="width: 70px">
    </td>
  </tr>
 <tr id="trtitulogris">
   <td align="center" id="tdtitulogris">
    <input type="button" value="Cerrar" onClick="window.close()" style="width: 70px">

   </td>
 </tr>
</table>
<label onClick="window.open('<?php echo "listadoreferencias.php?planestudio=$idplanestudio&codigodemateria=$materiaAreferenciar&lineaenfasis=$idlineaenfasis&lineamodificar=$idlineamodificar&tipomateriaenplan=$tipomateria','otraventana','width=300,height=500,left=350,top=350,scrollbars=yes"?>')" style="cursor: pointer"><span class="Estilo3">VISUALIZAR LISTA DE REFERENCIAS</span></label>
<!-- <p class="Estilo1" align="center"><strong>OTRAS OPCIONES</strong></p>
<table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
  	    <td align="center" bgcolor="#C5D5D6"><strong>Selecione la opción que desee</strong></td>
  </tr>
  <tr>
  	<td align="center"><input type="button" value="Grupo y Horarios Académicos"  name="aceptartiporeferencia" onClick="window.location.href='../materiasgrupos/materiasgrupos.php'">
        </td>
  </tr>
 <tr>
   <td align="center">
    <input type="button" value="Cerrar" onClick="window.close()" style="width: 60px">
   </td>
 </tr>
</table>
 -->
</form>
<?php
if(isset($_POST['aceptartiporeferencia']) && $formulariovalido)
{
	if($_POST['aceptartiporeferencia'] == "Editar")
	{
		echo "<script language='javascript'>
		window.opener.recargar('planestudio=".$idplanestudio."&codigodemateria=".$materiaAreferenciar."&tipodereferencia=".$validartiporeferencia."&editar=".$limite."&lineaenfasis=".$idlineaenfasis."&lineamodificar=".$idlineamodificar."');
		window.opener.focus();
		window.close();
		</script>";
	}
	if($_POST['aceptartiporeferencia'] == "Visualizar")
	{
		echo "<script language='javascript'>
		window.opener.recargar('planestudio=".$idplanestudio."&codigodemateria=".$materiaAreferenciar."&tipodereferencia=".$validartiporeferencia."&visualizar=".$limite."&lineaenfasis=".$idlineaenfasis."&lineamodificar=".$idlineamodificar."$visual');
		window.opener.focus();
		window.close();
		</script>";
	}
}
?>
</div>
</body>
</html>
