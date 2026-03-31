<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
require(realpath(dirname(__FILE__)).'/../../Connections/sala2.php');
require_once(realpath(dirname(__FILE__)).'/../../funciones/calendario/calendario.php');
require_once(realpath(dirname(__FILE__)).'/../../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../../funciones/erroresjs.php');
session_start();
mysql_select_db($database_sala, $sala);
$codigocarrera = $_SESSION['codigofacultad'];

if(isset($_GET['editar']))
{
	$_POST['editar'] = $_GET['editar'];
	$_POST['listauno'][0] = $_GET['lugareditar'];
}

if(isset($_GET['adicionar']))
{
	$_POST['adicionar'] = $_GET['adicionar'];
}

if(isset($_POST['codmateria']))
{
	$_GET['codmateria'] = $_POST['codmateria'];
	$_GET['idhistorico'] = $_POST['idhistorico'];
	$_GET['periodo'] = $_POST['periodo'];
	$_GET['codigoestudiante'] = $_POST['codigoestudiante'];
}
$direccion = "?periodo=".$_GET['periodo']."&codigoestudiante=".$_GET['codigoestudiante']."";
$codigomateria = $_GET['codmateria'];
$idnotahistorico = $_GET['idhistorico'];
//echo "<h1>$codigomateria : $idnotahistorico</h1>";
// Quita las materias que ya esten en referencia
$query_selmateria = "select * from materia where codigomateria = '$codigomateria'";
//echo "$query_selmateria<br>";
$selmateria = mysql_query($query_selmateria, $sala) or die("$query_selmateria");
$row_selmateria = mysql_fetch_assoc($selmateria);
$totalRows_selmateria = mysql_num_rows($selmateria);

if(isset($_POST['aceptaredicion']) || isset($_POST['aceptaradicion']))
{
	//exit();
	// Hace las validaciones respectivas
	//echo "ENtro <br>".$HTTP_SERVER_VARS['HTTP_REFERER'];
	$grabar = true;
	if(isset($_POST['aceptaredicion']))
	{
		$accion = "editar";
	}
	if(isset($_POST['aceptaradicion']))
	{
		$accion = "adicionar";
	}
	if(!validar($_POST['nombrelugar'],"requerido"))
	{
		atras_validar("El nombre del lugar es un ".$error1,$HTTP_SERVER_VARS['HTTP_REFERER']."$direccion&codmateria=$codigomateria&idhistorico=$idnotahistorico&lugareditar=".$_POST['idlugarorigeneditar']."&$accion");
		$grabar = false;
	}
	if(!validar($_POST['tipolugar'],"combo"))
	{
		atras_validar("La tipo del lugar es un ".$error1,$HTTP_SERVER_VARS['HTTP_REFERER']."$direccion&codmateria=$codigomateria&idhistorico=$idnotahistorico&lugareditar=".$_POST['idlugarorigeneditar']."&$accion");
		$grabar = false;
	}
	/*if(!validar($_POST['direccionlugar'],"requerido"))
	{
		atras_validar("La direccion del lugar es un ".$error1,$HTTP_SERVER_VARS['HTTP_REFERER']."$direccion&codmateria=$codigomateria&idhistorico=$idnotahistorico&lugareditar=".$_POST['idlugarorigeneditar']."&$accion");
		$grabar = false;
	}
	if(!validar($_POST['telefonolugar'],"requerido"))
	{
		atras_validar("El telefono es un ".$error1,$HTTP_SERVER_VARS['HTTP_REFERER']."$direccion&codmateria=$codigomateria&idhistorico=$idnotahistorico&lugareditar=".$_POST['idlugarorigeneditar']."&$accion");
		$grabar = false;
	}
	if(!validar($_POST['telefonolugar'],"numero"))
	{
		atras_validar("El telefono debe ser un ".$error2,$HTTP_SERVER_VARS['HTTP_REFERER']."$direccion&codmateria=$codigomateria&idhistorico=$idnotahistorico&lugareditar=".$_POST['idlugarorigeneditar']."&$accion");
		$grabar = false;
	}
	if(!validar($_POST['contactolugar'],"requerido"))
	{
		atras_validar("El contacto es un ".$error1,$HTTP_SERVER_VARS['HTTP_REFERER']."$direccion&codmateria=$codigomateria&idhistorico=$idnotahistorico&lugareditar=".$_POST['idlugarorigeneditar']."&$accion");
		$grabar = false;
	}
	if(!validar($_POST['emaillugar'],"requerido"))
	{
		atras_validar("El email es un ".error1,$HTTP_SERVER_VARS['HTTP_REFERER']."$direccion&codmateria=$codigomateria&idhistorico=$idnotahistorico&lugareditar=".$_POST['idlugarorigeneditar']."&$accion");
		$grabar = false;
	}
	*/
	if(!validar($_POST['fechaini'],"requerido"))
	{
		atras_validar("La fecha es un ".error1,$HTTP_SERVER_VARS['HTTP_REFERER']."$direccion&codmateria=$codigomateria&idhistorico=$idnotahistorico&lugareditar=".$_POST['idlugarorigeneditar']."&$accion");
		$grabar = false;
	}
	if(!validar($_POST['fechafin'],"requerido"))
	{
		atras_validar("La fecha es un ".error1,$HTTP_SERVER_VARS['HTTP_REFERER']."$direccion&codmateria=$codigomateria&idhistorico=$idnotahistorico&lugareditar=".$_POST['idlugarorigeneditar']."&$accion");
		$grabar = false;
	}
	if($grabar)
	{
		if(isset($_POST['aceptaredicion']))
		{
			//echo "Puede grabar<br>";
			$query_updlugarotacion = "UPDATE tmplugarorigennota 
			SET nombrelugarorigennota='".$_POST['nombrelugar']."', direccionlugarorigennota='".$_POST['direccionlugar']."', telefonolugarorigennota='".$_POST['telefonolugar']."', emaillugarorigennota='".$_POST['emaillugar']."', contactolugarorigennota='".$_POST['contactolugar']."', fechainiciolugarorigennota='".$_POST['fechaini']."', fechafinallugarorigennota='".$_POST['fechafin']."', idtipolugarorigennota=".$_POST['tipolugar']." 
			WHERE idlugarorigennota = '".$_POST['idlugarorigeneditar']."'"; 
			//echo "$query_updlugarotacion";
			//exit();
			$updlugarotacion = mysql_query($query_updlugarotacion,$sala) or die("$query_updlugarotacion ".mysql_error());
		}
		if(isset($_POST['aceptaradicion']))
		{
			//echo "Puede grabar<br>";
			$query_inslugarotacion = "INSERT INTO tmplugarorigennota(idlugarorigennota, nombrelugarorigennota, direccionlugarorigennota, telefonolugarorigennota, emaillugarorigennota, contactolugarorigennota, fechainiciolugarorigennota, fechafinallugarorigennota, idtipolugarorigennota, indicadorcargareal) 
			VALUES(0, '".$_POST['nombrelugar']."', '".$_POST['direccionlugar']."', '".$_POST['telefonolugar']."', '".$_POST['emaillugar']."', '".$_POST['contactolugar']."', '".$_POST['fechaini']."', '".$_POST['fechafin']."', ".$_POST['tipolugar'].", '200')"; 
			//echo "$query_updlugarotacion";
			//exit();
			$inslugarotacion = mysql_query($query_inslugarotacion,$sala) or die("$query_inslugarotacion ".mysql_error());
		}			
	}
?>
	<script language="javascript">
		window.location.reload("<?php echo $HTTP_SERVER_VARS['HTTP_REFERER']."$direccion&codmateria=$codigomateria&idhistorico=$idnotahistorico";?>")
	</script>
<?php
}
if(isset($_POST['aceptar']))
{
	// Guardar en la tabla detalleplanestudio, primero elimina lo que halla en la tabla
	if(isset($_POST['listados']))
	{
		$listalugares = $_POST['listados'];
		
		// Mira los lugares que se encuentran en la materia y si no se encuentran en la listados las elimina
		$query_lugaresexistentes = "select l.idlugarorigennota, l.nombrelugarorigennota
		from tmplugarorigennota l, tmprotacionnotahistorico r, tmpnotahistorico n
		where l.fechainiciolugarorigennota <= '".date("Y-m-d H:m:s",time())."'
		and l.fechafinallugarorigennota >= '".date("Y-m-d H:m:s",time())."'
		and r.idnotahistorico = '$idnotahistorico'
		and r.idlugarorigennota = l.idlugarorigennota
		and n.codigomateria = '$codigomateria'
		and n.idnotahistorico = r.idnotahistorico
		order by 2, 1";
		//echo "$query_lugaresexistentes<br>";
		//exit();
		$lugaresexistentes = mysql_query($query_lugaresexistentes, $sala) or die("$query_lugaresexistentes".mysql_error());
		$totalRows_lugaresexistentes = mysql_num_rows($lugaresexistentes);
		if($totalRows_lugaresexistentes != "")
		{
			while($row_lugaresexistentes = mysql_fetch_assoc($lugaresexistentes))
			{
				$idlugarorigennota = $row_lugaresexistentes['idlugarorigennota'];
				$entro = false;
				foreach($listalugares as $key1 => $codigo1)
				{
					//echo "$idlugarorigennota == $codigo1<br>";
					if($idlugarorigennota == $codigo1)
					{
						$entro = true; 
					}
				}
				//exit();
				if(!$entro)
				{
					$query_eliminarlugarnota = "DELETE FROM tmprotacionnotahistorico 
					WHERE idnotahistorico = '$idnotahistorico' 
					and idlugarorigennota = '$idlugarorigennota'";
					$eliminarlugarnota = mysql_query($query_eliminarlugarnota, $sala) or die("$query_eliminarlugarnota");
					//echo "<br>$query_eliminarlugarnota";
					//exit();
				}
			}
		}
		// Mira si los lugares que vienen de la listados es diferente
		// En caso que sea asi la inserta en rotacionnotahistorico
		$cuentalistadodos = 0;
		foreach($listalugares as $key => $idlugar)
		{
			$cuentalistadodos++;
			// Este if se hiso debido a que listados para que exista posee un vacio
			if($idlugar != 0)
			{
				$query_lugaresexistentes = "select l.idlugarorigennota, l.nombrelugarorigennota
				from tmplugarorigennota l, tmprotacionnotahistorico r, tmpnotahistorico n
				where l.fechainiciolugarorigennota <= '".date("Y-m-d H:m:s",time())."'
				and l.fechafinallugarorigennota >= '".date("Y-m-d H:m:s",time())."'
				and r.idnotahistorico = '$idnotahistorico'
				and r.idlugarorigennota = '$idlugar'
				and r.idlugarorigennota = l.idlugarorigennota
				and n.codigomateria = '$codigomateria'
				and n.idnotahistorico = r.idnotahistorico
				order by 2, 1";
				$lugaresexistentes = mysql_query($query_lugaresexistentes, $sala) or die("$query_lugaresexistentes");
				$totalRows_lugaresexistentes = mysql_num_rows($lugaresexistentes);
				//echo "<br>$query_lugaresexistentes";
				//exit();
				if($totalRows_lugaresexistentes == "")
				{
					$query_insertarrotacion = "INSERT INTO tmprotacionnotahistorico(idrotacionnotahistorico, idnotahistorico, idlugarorigennota) 
				    VALUES(0, '$idnotahistorico', '$idlugar')";
					$insertarrotacion = mysql_query($query_insertarrotacion, $sala) or die("$query_insertarrotacion");
				}
			}
			/*else
			{
				echo "VACIA";
				exit();
			}*/
		}
		echo "<script language='javascript'>
		window.opener.recargar('".$direccion."');
		window.opener.focus();
		window.close();
		</script>";		
	}
}
?>
<html>
<head>
<title>Lugar de Rotación</title>
<script language="JavaScript" src="../../funciones/calendario/javascripts.js"></script>
</head>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; }
-->
</style>
<body>
<form method="post" name="f1" action="modificahistoricorotacion.php">
<input type="hidden" value="<?php echo  $codigomateria; ?>" name="codmateria">
<input type="hidden" value="<?php echo  $idnotahistorico;?>" name="idhistorico">
<input type="hidden" value="<?php echo  $_GET['periodo']; ?>" name="periodo">
<input type="hidden" value="<?php echo  $_GET['codigoestudiante'];?>" name="codigoestudiante">
<div align="center">
<?php
if(isset($_POST['editar']))
{
	if(isset($_POST['listauno'][0]))
	{
		$idlugarorigennota = $_POST['listauno'][0];
	}
	if(isset($_POST['listados'][0]))
	{
		$idlugarorigennota = $_POST['listados'][0];
	}
	if($idlugarorigennota == "")
	{
?>
<script language="javascript">
	alert("Debe seleccionar alguno de los lugares de rotación de uno de los paneles");
	history.go(-1);
</script>
<?php	
	}
	$query_lugarrotacion = "SELECT l.idlugarorigennota, l.nombrelugarorigennota, l.direccionlugarorigennota, 
	l.telefonolugarorigennota, l.emaillugarorigennota, l.contactolugarorigennota, l.fechainiciolugarorigennota, 
	l.fechafinallugarorigennota, l.idtipolugarorigennota, t.nombretipolugarorigennota 
	FROM tmplugarorigennota l, tipolugarorigennota t
	where l.idlugarorigennota = '$idlugarorigennota'
	and l.idtipolugarorigennota = t.idtipolugarorigennota";
	$lugarrotacion = mysql_query($query_lugarrotacion, $sala) or die("query_lugarrotacion".mysql_error());
	$row_lugarrotacion = mysql_fetch_assoc($lugarrotacion);
	$totalRows_lugarrotacion = mysql_num_rows($lugarrotacion);
	
	$query_combolugarrotacion = "SELECT t.idtipolugarorigennota, t.nombretipolugarorigennota 
	FROM tipolugarorigennota t";
	$combolugarrotacion = mysql_query($query_combolugarrotacion, $sala) or die("query_combolugarrotacion".mysql_error());
	$row_combolugarrotacion = mysql_fetch_assoc($combolugarrotacion);
	$totalRows_combolugarrotacion = mysql_num_rows($combolugarrotacion);
	
?>
<p class="Estilo3" align="center"><strong>EDICIÓN DE LUGARES DE ROTACIÓN</strong>
</p>
<input type="hidden" value="editardos" name="editar">
<input type="hidden" value="<?php echo $idlugarorigennota;?>" name="idlugarorigeneditar">
<table width="650" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6" class="Estilo2">
	<td width="50%" align="center" class="Estilo1"><strong>Lugar de Rotación</strong></td>
	<td width="50%" align="center" class="Estilo1"><strong>Tipo de Lugar </strong></td>
  </tr>
  <tr class="Estilo1">
	<td align="center" class="Estilo1"><input type="text" value="<?php echo $row_lugarrotacion['nombrelugarorigennota']; ?>" name="nombrelugar"></td>
	<td align="center" class="Estilo1"><select name="tipolugar">
      <option value="<?php echo $row_lugarrotacion['idtipolugarorigennota'] ?>" selected><?php echo $row_lugarrotacion['nombretipolugarorigennota']?></option>
      <?php
	do 
	{
		if($row_lugarrotacion['idtipolugarorigennota'] != $row_combolugarrotacion['idtipolugarorigennota'])
		{  
?>
      <option value="<?php echo $row_combolugarrotacion['idtipolugarorigennota']?>"<?php if (!(strcmp($row_combolugarrotacion['idtipolugarorigennota'], $_POST['tipolugar']))) {echo "SELECTED";} ?>><?php echo $row_combolugarrotacion['nombretipolugarorigennota']?></option>
      <?php
		}
	} 
	while($row_combolugarrotacion = mysql_fetch_assoc($combolugarrotacion));
	$totalRows_lugarrotacion = mysql_num_rows($combolugarrotacion);
	if($totalRows_lugarrotacion > 0)
	{
		mysql_data_seek($combolugarrotacion, 0);
		$row_combolugarrotacion = mysql_fetch_assoc($combolugarrotacion);
	}
?>
    </select></td>
  </tr>
  <tr bgcolor="#C5D5D6" class="Estilo2">
  	<td align="center"><strong>Dirección</strong></td>
	<td align="center"><strong>Tel&eacute;fono</strong></td>
  </tr>
  <tr class="Estilo1">
	<td align="center"><input type="text" value="<?php echo $row_lugarrotacion['direccionlugarorigennota']; ?>" name="direccionlugar"></td>
	<td align="center"><input type="text" value="<?php echo $row_lugarrotacion['telefonolugarorigennota']; ?>" name="telefonolugar"></td>
  </tr>
  <tr bgcolor="#C5D5D6" class="Estilo2">
  	<td align="center"><span class="Estilo1"><strong>Contacto</strong></span></td>
	<td align="center"><strong>Email</strong></td>
  </tr>
  <tr class="Estilo1">
	<td align="center"><input type="text" value="<?php echo $row_lugarrotacion['contactolugarorigennota']; ?>" name="contactolugar"></td>
	<td align="center"><input type="text" value="<?php echo $row_lugarrotacion['emaillugarorigennota']; ?>" name="emaillugar"> </td>
  </tr>
  <tr bgcolor="#C5D5D6" class="Estilo2">
  	<td align="center"><strong>Fecha Inicio</strong></td>
	<td align="center"><strong>Fecha Vencimiento</strong></td>
  </tr>
  <tr class="Estilo1">
	<td align="center"><?php escribe_formulario_fecha_vacio("fechaini","f1","../../funciones/",$row_lugarrotacion['fechainiciolugarorigennota']); ?></td>
	<td align="center"><?php escribe_formulario_fecha_vacio("fechafin","f1","../../funciones/",$row_lugarrotacion['fechafinallugarorigennota']); ?></td>
  </tr>
  <tr>
	<td align="center" colspan="2"><input type="submit" name="aceptaredicion" value="Aceptar"><input type="button" name="cancelar" value="Regresar" onClick="window.location.reload('<?php echo $HTTP_SERVER_VARS['HTTP_REFERER']."$direccion&codmateria=$codigomateria&idhistorico=$idnotahistorico"; ?>')"></td>
  </tr>
</table>

<?php
//echo $HTTP_SERVER_VARS['HTTP_REFERER']; 
require("modificarhistoricopie.php");
exit();
}
if(isset($_POST['adicionar']))
{
	$query_combolugarrotacion = "SELECT t.idtipolugarorigennota, t.nombretipolugarorigennota 
	FROM tipolugarorigennota t";
	$combolugarrotacion = mysql_query($query_combolugarrotacion, $sala) or die("query_combolugarrotacion".mysql_error());
	$row_combolugarrotacion = mysql_fetch_assoc($combolugarrotacion);
	$totalRows_combolugarrotacion = mysql_num_rows($combolugarrotacion);
	
?>
<p class="Estilo3" align="center"><strong>ADICI&Oacute;N DE LUGARES DE ROTACIÓN</strong>
</p>
<input type="hidden" value="editardos" name="modificar">
<input type="hidden" value="<?php echo $idlugarorigennota;?>" name="idlugarorigeneditar">
<table width="650" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6" class="Estilo2">
	<td width="50%" align="center" class="Estilo1"><strong>Lugar de Rotación</strong></td>
	<td width="50%" align="center" class="Estilo1"><strong>Tipo de Lugar </strong></td>
  </tr>
  <tr class="Estilo1">
	<td align="center" class="Estilo1"><input type="text" name="nombrelugar"></td>
	<td align="center" class="Estilo1"><select name="tipolugar">
	<option value="0">Seleccionar</option>
      <?php
	do 
	{		  
?>
      <option value="<?php echo $row_combolugarrotacion['idtipolugarorigennota']?>"<?php if (!(strcmp($row_combolugarrotacion['idtipolugarorigennota'], $_POST['tipolugar']))) {echo "SELECTED";} ?>><?php echo $row_combolugarrotacion['nombretipolugarorigennota']?></option>
<?php
	} 
	while($row_combolugarrotacion = mysql_fetch_assoc($combolugarrotacion));
	$totalRows_lugarrotacion = mysql_num_rows($combolugarrotacion);
	if($totalRows_lugarrotacion > 0)
	{
		mysql_data_seek($combolugarrotacion, 0);
		$row_combolugarrotacion = mysql_fetch_assoc($combolugarrotacion);
	}
?>
    </select></td>
  </tr>
  <tr bgcolor="#C5D5D6" class="Estilo2">
  	<td align="center"><strong>Dirección</strong></td>
	<td align="center"><strong>Tel&eacute;fono</strong></td>
  </tr>
  <tr class="Estilo1">
	<td align="center"><input type="text" name="direccionlugar"></td>
	<td align="center"><input type="text" name="telefonolugar"></td>
  </tr>
  <tr bgcolor="#C5D5D6" class="Estilo2">
  	<td align="center"><span class="Estilo1"><strong>Contacto</strong></span></td>
	<td align="center"><strong>Email</strong></td>
  </tr>
  <tr class="Estilo1">
	<td align="center"><input type="text" name="contactolugar"></td>
	<td align="center"><input type="text" name="emaillugar"> </td>
  </tr>
  <tr bgcolor="#C5D5D6" class="Estilo2">
  	<td align="center"><strong>Fecha Inicio</strong></td>
	<td align="center"><strong>Fecha Vencimiento</strong></td>
  </tr>
  <tr class="Estilo1">
	<td align="center"><?php escribe_formulario_fecha_vacio("fechaini","f1","../../funciones/"); ?></td>
	<td align="center"><?php escribe_formulario_fecha_vacio("fechafin","f1","../../funciones/"); ?></td>
  </tr>
  <tr>
	<td align="center" colspan="2"><input type="submit" name="aceptaradicion" value="Aceptar"><input type="button" name="cancelar" value="Regresar" onClick="window.location.reload('<?php echo $HTTP_SERVER_VARS['HTTP_REFERER']."$direccion&codmateria=$codigomateria&idhistorico=$idnotahistorico"; ?>')"></td>
  </tr>
</table>

<?php
	//echo $HTTP_SERVER_VARS['HTTP_REFERER']; 
	require("modificarhistoricopie.php");
	exit();
}
?>
<p class="Estilo3" align="center"><strong>ASIGNACIÓN DE LUGARES DE ROTACIÓN</strong>
</p>
<table width="650" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6" class="Estilo2">
	<td width="50%" align="center" class="Estilo1"><strong>Nombre Materia</strong></td>
	<td width="50%" align="center" class="Estilo1"><strong>Codigo Materia</strong></td>
  </tr>
  <tr class="Estilo1">
	<td align="center" class="Estilo1"><?php echo $row_selmateria['nombremateria']; ?></td>
	<td align="center" class="Estilo1"><?php echo $codigomateria; ?></td>
  </tr>
</table>
<?php
$vacio = false;
?>
<?php
$query_solicitud = "select idlugarorigennota, nombrelugarorigennota
from tmplugarorigennota
where fechainiciolugarorigennota <= '".date("Y-m-d H:m:s",time())."'
and fechafinallugarorigennota >= '".date("Y-m-d H:m:s",time())."'
order by 2, 1";
//echo "$query_solicitud<br>";
$solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
$totalRows_solicitud = mysql_num_rows($solicitud);
?>
<table width="650" border="1" cellpadding="2" cellspacing="1" bordercolor="#D76B00">
  <tr>
	<td width="298">
      <select  multiple name="listauno[]" size="10" style="width:296px" class="Estilo1">
        <?php
//<select  multiple name="listauno[]" size="10" style="font-size:9px" style="width:300px">
if($totalRows_solicitud != "")
{
	while($row_solicitud = mysql_fetch_assoc($solicitud)) 
	{
		$nombrelugarorigennota = $row_solicitud['nombrelugarorigennota'];
		$idlugarorigennota = $row_solicitud['idlugarorigennota'];
		
		$query_solicitud3 = "select l.idlugarorigennota, l.nombrelugarorigennota
		from tmplugarorigennota l, tmprotacionnotahistorico r, tmpnotahistorico n
		where l.fechainiciolugarorigennota <= '".date("Y-m-d H:m:s",time())."'
		and l.fechafinallugarorigennota >= '".date("Y-m-d H:m:s",time())."'
		and r.idnotahistorico = '$idnotahistorico'
		and r.idlugarorigennota = '$idlugarorigennota'
		and r.idlugarorigennota = l.idlugarorigennota
		and n.codigomateria = '$codigomateria'
		and n.idnotahistorico = r.idnotahistorico
		order by 2, 1";
		//echo "$query_solicitud3";
		$solicitud3 = mysql_query($query_solicitud3, $sala) or die(mysql_error());
		$totalRows_solicitud3 = mysql_num_rows($solicitud3);
		if($totalRows_solicitud3 != "")
		{
			continue;
		}
?>
        <option value="<?php echo $idlugarorigennota; ?>"><?php echo "$nombrelugarorigennota"; ?></option>
        <?php
	}
}
else
{
?>
        <option value="0"><strong>No hay lugares de rotación</strong></option>
        <?php
}
?>
      </select></td>
    <td width="42" align="center"> 
	<input type="button" name="derecha" 
	onClick="moverOpciones(this.form.elements['listauno[]'],this.form.elements['listados[]'])" value=">>"> 
	<br>
	<input type="button" name="izquierda" 
   	onClick="moverOpciones(this.form.elements['listados[]'],this.form.elements['listauno[]'])" value="<<">
  	</td>
	<td width="298">
	<select multiple name="listados[]" size="10" style="width:296" class="Estilo1">
<?php
$query_solicitud2 = "select l.idlugarorigennota, l.nombrelugarorigennota
from tmplugarorigennota l, tmprotacionnotahistorico r, tmpnotahistorico n
where l.fechainiciolugarorigennota <= '".date("Y-m-d H:m:s",time())."'
and l.fechafinallugarorigennota >= '".date("Y-m-d H:m:s",time())."'
and r.idnotahistorico = '$idnotahistorico'
and r.idlugarorigennota = l.idlugarorigennota
and n.codigomateria = '$codigomateria'
and n.idnotahistorico = r.idnotahistorico
order by 2, 1";
$solicitud2 = mysql_query($query_solicitud2, $sala) or die(mysql_error());
$totalRows_solicitud2 = mysql_num_rows($solicitud2);
if($totalRows_solicitud2 != "")
{
	while($row_solicitud2 = mysql_fetch_assoc($solicitud2)) 
	{
		$nombrelugarorigennota2 = $row_solicitud2['nombrelugarorigennota'];
		$idlugarorigennota2 = $row_solicitud2['idlugarorigennota'];
?>
	<option value="<?php echo $idlugarorigennota2; ?>"><?php echo "$nombrelugarorigennota2 &nbsp;&nbsp;"; ?></option>
<?php
	}
}
?>
		<option value="0"></option>
      </select>
	</td>
  <tr>
    <td colspan="3" align="center">
	  <input type="submit" name="aceptar" value="Aceptar" onClick="activarLista(this.form.elements['listados[]'])">
      <input type="button" name="button" onClick="window.close()" value="Cancelar">
	</td>
  </tr>
  <tr></tr>
  <tr></tr>
  <tr></tr>
  <tr></tr>
  <tr></tr>
  <tr></tr>
  <tr bgcolor="#C5D5D6">
    <td colspan="3" align="center"><font size="-1" class="Estilo2"><strong>BOTONES PARA LA  EDICIÓN, ELIMINACIÓN Y ADICIÓN DE LUGARES DE ROTACIÓN</strong></font></td>
  </tr>
  <tr>
    <td colspan="3" align="center">
	  <input type="submit" name="editar" value="Editar" style="width: 80px">
      <input type="submit" name="adicionar" value="Adicionar" style="width: 80px">
	</td>
  </tr>
</table>
<?php
require("modificarhistoricopie.php");
exit();
?>