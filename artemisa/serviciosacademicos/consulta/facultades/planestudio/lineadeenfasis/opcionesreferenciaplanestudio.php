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
if(isset($_GET['visualizado']))
{
	$visual = "&visualizado";
}
$query_datomateria = "select nombremateria
from materia
where codigomateria = '".$_GET['codigodemateria']."'";
$datomateria = mysql_query($query_datomateria, $sala) or die("$query_datomateria");
$totalRows_datomateria = mysql_num_rows($datomateria);
$row_datomateria = mysql_fetch_assoc($datomateria);

?>
<html>
<head>
<title>Opciones de Referencia Plan de Estudio</title>
</head>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
}
.Estilo2 {
	font-family: sans-serif;
	font-size: 9px;
	text-align: center;
}
-->
</style>
<body>
<div align="center">
<form name="f1" method="post" action="opcionesreferenciaplanestudio.php<?php echo "?planestudio=$idplanestudio&codigodemateria=$materiaAreferenciar&limitesemestre=$limite&tipomateriaenplan=$tipomateria&lineaenfasis=$idlineaenfasis.$visual";?>">
<p class="Estilo1" align="center"><strong>REFERENCIAR A <?php echo $row_datomateria['nombremateria'];?></strong></p>
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
  	<td align="center">
	<font size="1" face="Tahoma"><select name="petiporeferencia">
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
    </font>
	<font color="#FF0000" size="-1">
<?php
		if(isset($_POST['petiporeferencia']))
		{
			$validartiporeferencia = $_POST['petiporeferencia'];
			$imprimir = true;
			$tiporeferenciarequerido = validar($validartiporeferencia,"combo",$error1,&$imprimir);
			$formulariovalido = $formulariovalido*$tiporeferenciarequerido;
		}
?>
    </font>
	</td>
  </tr>
  <tr>
  	<td align="center">
<?php
if(!isset($_GET['visualizado']))
{
?>
	<input type="submit" value="Editar"  name="aceptartiporeferencia" style="width: 70px">
<?php
}
?>
          <input type="submit" value="Visualizar" name="aceptartiporeferencia" style="width: 70px">
        </td>
  </tr>
 <tr>
   <td align="center">
    <input type="button" value="Cerrar" onClick="window.close()" style="width: 115px">
	<?php
if(isset($_GET['visualizado']))
{
	//Si la materia esta a cargo de la facultad le permite acceder al boton
	$query_materiasacargo = "SELECT m.codigomateria, m.nombremateria
	FROM materia m
	WHERE m.codigomateria = '$materiaAreferenciar'
	and m.codigocarrera = '".$_SESSION['codigofacultad']."'";
	//echo "$query_materiasacargo";
	$materiasacargo = mysql_db_query($database_sala,$query_materiasacargo) or die("$query_materiasacargo");
	$totalRows_materiasacargo = mysql_num_rows($materiasacargo);
	if($totalRows_materiasacargo != "")
	{
?>
	<input type="submit" value="Grupos y Horarios"  name="modificargrupo" style="width: 120px">
<?php
	}
}
?>
   </td>
 </tr>
</table>
<!--
* Caso 
* @modified Luis Dario Gualteros 
* <castroluisd@unbosque.edu.co>
* Se elimina la palabra VISUALIZAR ya que estaba repetida.
* @since Abril 6 de 2017
-->
<label onClick="window.open('<?php echo "../listadoreferencias.php?planestudio=$idplanestudio&codigodemateria=$materiaAreferenciar&lineaenfasis=$idlineaenfasis&lineamodificar=$idlineamodificar&tipomateriaenplan=$tipomateria','otraventana','width=300,height=500,left=350,top=350,scrollbars=yes"?>')" style="cursor: pointer"><span class="Estilo3">VISUALIZAR LISTA DE REFERENCIAS</span></label>
<!--End Caso -->    
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
 --></form>
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
