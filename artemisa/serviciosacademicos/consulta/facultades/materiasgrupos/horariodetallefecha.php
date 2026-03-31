<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala); 
session_start();
require_once('seguridadmateriasgrupos.php');
$formulariovalido=1;
if(isset($_REQUEST['idhorario']))
{
	$idhorario=$_REQUEST['idhorario'];
}

// Toca traer el grupo al que pertenece este horario
$query_selgrupo = "select h.idgrupo, year(g.fechainiciogrupo) as fechainiciogrupo, year(g.fechafinalgrupo) as fechafinalgrupo 
from horario h, grupo g
where h.idhorario = '$idhorario'
and h.idgrupo = g.idgrupo";
//echo "<h3>$query_selgrupo</h3>";
$selgrupo = mysql_query($query_selgrupo, $sala) or die("$query_selgrupo");
$totalRows_selgrupo = mysql_num_rows($selgrupo);
$row_selgrupo = mysql_fetch_assoc($selgrupo);
$idgrupo = $row_selgrupo['idgrupo'];

function fechavalida($idhorario, $fechaini, $fechafin, $sala)
{
	$query_selfechagrupo = "select g.fechainiciogrupo, g.fechafinalgrupo 
	from grupo g, horario h
	where h.idgrupo = g.idgrupo
	and h.idhorario = '$idhorario'
	and (g.fechainiciogrupo > '$fechaini'
	or g.fechafinalgrupo < '$fechaini' 
	or g.fechainiciogrupo > '$fechafin'
	or g.fechafinalgrupo < '$fechafin')";
	//echo "<h3>$query_selfechagrupo</h3>";
	$selfechagrupo = mysql_query($query_selfechagrupo, $sala) or die("$query_selfechagrupo");
	$totalRows_selfechagrupo = mysql_num_rows($selfechagrupo);
	$row_selfechagrupo = mysql_fetch_assoc($selfechagrupo);
	if($totalRows_selfechagrupo != "")
	{
		return false;
	}
	return true;
}		

function existefecha($idhorario, $fechaini, $fechafin, $sala)
{
	$query_selfechagrupo = "select hd.fechadesdehorariodetallefecha, hd.fechahastahorariodetallefecha
	from horariodetallefecha hd, horario h
	where h.idhorario = '$idhorario'
	and h.idhorario = hd.idhorario
	and hd.fechahastahorariodetallefecha >= '$fechafin'
	and hd.fechadesdehorariodetallefecha <= '$fechaini'
	and hd.codigoestado like '1%'";
	//echo "<h3>$query_selfechagrupo</h3>";
	$selfechagrupo = mysql_query($query_selfechagrupo, $sala) or die(mysql_error()." $query_selfechagrupo");
	$totalRows_selfechagrupo = mysql_num_rows($selfechagrupo);
	$row_selfechagrupo = mysql_fetch_assoc($selfechagrupo);
	if($totalRows_selfechagrupo == "")
	{
		return false;
	}
	return true;
}	

function existefechasindetalle($idhorario, $idhorariodetallefecha, $fechaini, $fechafin, $sala)
{
	$query_selfechagrupo = "select hd.fechadesdehorariodetallefecha, hd.fechahastahorariodetallefecha
	from horariodetallefecha hd, horario h
	where h.idhorario = '$idhorario'
	and h.idhorario = hd.idhorario
	AND ((hd.fechahastahorariodetallefecha >= '$fechaini' AND hd.fechadesdehorariodetallefecha <= '$fechaini')
	OR  (hd.fechahastahorariodetallefecha >= '$fechafin' AND hd.fechadesdehorariodetallefecha <= '$fechafin')
	OR (hd.fechahastahorariodetallefecha <= '$fechafin' AND hd.fechadesdehorariodetallefecha >= '$fechaini'))
	and hd.codigoestado like '1%'
	and hd.idhorariodetallefecha <> '$idhorariodetallefecha'";
	//echo "<h3>$query_selfechagrupo</h3>";
	$selfechagrupo = mysql_query($query_selfechagrupo, $sala) or die(mysql_error()." $query_selfechagrupo");
	$totalRows_selfechagrupo = mysql_num_rows($selfechagrupo);
	$row_selfechagrupo = mysql_fetch_assoc($selfechagrupo);
	if($totalRows_selfechagrupo == "")
	{
		return false;
	}
	return true;
}	

function existefechagrupo($idhorario, $idgrupo, $fechaini, $fechafin, $sala)
{
	$query_selfechagrupo = "select hd.fechadesdehorariodetallefecha, hd.fechahastahorariodetallefecha
	from horariodetallefecha hd, horario h
	where h.idhorario = '$idhorario'
	and h.idgrupo = '$idgrupo'
	and h.idhorario = hd.idhorario
	and hd.fechahastahorariodetallefecha >= '$fechafin'
	and hd.fechadesdehorariodetallefecha <= '$fechaini'
	and hd.codigoestado like '1%'";
	//echo "<h3>$query_selfechagrupo</h3>";
	$selfechagrupo = mysql_query($query_selfechagrupo, $sala) or die(mysql_error()." $query_selfechagrupo");
	$totalRows_selfechagrupo = mysql_num_rows($selfechagrupo);
	$row_selfechagrupo = mysql_fetch_assoc($selfechagrupo);
	if($totalRows_selfechagrupo == "")
	{
		return false;
	}
	return true;
}		

function fechafinalmayor($fechaini, $fechafin)
{
	if(ereg_replace("-","",$fechaini) > ereg_replace("-","",$fechafin))
	{
		return false;
	}
	return true;
}				

function tomaridhorario($idhorariodetallefecha, $sala)
{
	$query_selfechagrupo = "select hd.idhorario
	from horariodetallefecha hd
	where hd.idhorariodetallefecha = '$idhorariodetallefecha'
	and hd.codigoestado like '1%'";
	//echo "<h3>$query_selfechagrupo</h3>";
	$selfechagrupo = mysql_query($query_selfechagrupo, $sala) or die(mysql_error()." $query_selfechagrupo");
	$totalRows_selfechagrupo = mysql_num_rows($selfechagrupo);
	$row_selfechagrupo = mysql_fetch_assoc($selfechagrupo);
	return $row_selfechagrupo['idhorario'];
}
			
if(isset($_REQUEST['masivo']))
{
	foreach($_REQUEST as $key => $value)
	{
		if(ereg("fechaseleccionada",$key))
		{
			$idhorariodetallefecha = $value;
			$fechadesdehorariodetallefecha = $_REQUEST['fechainicial'.$idhorariodetallefecha];
			$fechahastahorariodetallefecha = $_REQUEST['fechafinal'.$idhorariodetallefecha];
			if($fechadesdehorariodetallefecha != "" && $fechahastahorariodetallefecha != "")
			{
				$query_selidhorario = "select h.idhorario
				from horario h
				where h.idgrupo = '$idgrupo'";
				//echo "<h3>$query_selidhorario</h3>";
				$selidhorario = mysql_query($query_selidhorario, $sala) or die("$query_selidhorario");
				$totalRows_selidhorario = mysql_num_rows($selidhorario);
				while($row_selidhorario = mysql_fetch_assoc($selidhorario))
				{
					$idhorariomasivo = $row_selidhorario['idhorario'];
					if(!existefechagrupo($idhorariomasivo, $idgrupo, $fechahastahorariodetallefecha, $fechadesdehorariodetallefecha, $sala))
					{
						// Se puede insertar
						// Inserta una nueva fecha
						// Si la fecha esta fuera de la fecha del grupo no permite insertarla
						// SI la fecha que se quiere insertar ya esta en el rango no permite insertarla
						$query_inshorariodetallefecha = "INSERT INTO horariodetallefecha(idhorariodetallefecha, idhorario, fechadesdehorariodetallefecha, fechahastahorariodetallefecha, codigoestado) 
						VALUES(0, '$idhorariomasivo', '$fechadesdehorariodetallefecha', '$fechahastahorariodetallefecha', '100')";
						//echo "<h3>$query_inshorariodetallefecha</h3>";
						$inshorariodetallefecha = mysql_query($query_inshorariodetallefecha, $sala) or die("$query_inshorariodetallefecha");
						$inserto = true;
					}
				}
				if($inserto)
				{
				?>
<script language="javascript">
	alert("Datos insertados correctamente");
</script>
<?php
				}
			}
		}
	}
}

if(isset($_REQUEST['eliminar']))
{
	$query_updhorariodetallefecha = "UPDATE horariodetallefecha 
    SET codigoestado='200'
    WHERE idhorariodetallefecha = '".$_REQUEST['eliminar']."'";
	//echo "<h3>$query_updhorariodetallefecha</h3>";
	$updhorariodetallefecha = mysql_query($query_updhorariodetallefecha, $sala) or die("$query_updhorariodetallefecha");
}
if(isset($_REQUEST['nuevafecha']))
{
	if($_REQUEST['fechaini'] != "" && $_REQUEST['fechafin'] != "")
	{
		if(fechafinalmayor($_REQUEST['fechaini'], $_REQUEST['fechafin']))
		{
			if(fechavalida($idhorario, $_REQUEST['fechaini'], $_REQUEST['fechafin'], $sala))
			{
				if(!existefecha($idhorario, $_REQUEST['fechaini'], $_REQUEST['fechafin'], $sala))
				{
					$inserto = true;
					// Inserta una nueva fecha
					$query_inshorariodetallefecha = "INSERT INTO horariodetallefecha(idhorariodetallefecha, idhorario, fechadesdehorariodetallefecha, fechahastahorariodetallefecha, codigoestado) 
					VALUES(0, '$idhorario', '".$_REQUEST['fechaini']."', '".$_REQUEST['fechafin']."', '100')";
					//echo "<h3>$query_inshorariodetallefecha</h3>";
					$inshorariodetallefecha = mysql_query($query_inshorariodetallefecha, $sala) or die("$query_inshorariodetallefecha");
				}
			}
		}
	}
	if(!$inserto)
	{
?>
<script language="javascript">
	alert("No se inserto el registro")
</script>
<?php
	}
}
if(isset($_REQUEST['aceptar']))
{
	// Todo lo que halla lo modifica
	
	foreach($_REQUEST as $key => $value)
	{
		if(ereg("fechainicial",$key))
		{
			$fechadesdehorariodetallefecha = $value;
			$idhorariodetallefecha = ereg_replace("fechainicial","",$key);
			$fechahastahorariodetallefecha = $_REQUEST['fechafinal'.$idhorariodetallefecha];
			if(fechafinalmayor($fechadesdehorariodetallefecha, $fechahastahorariodetallefecha))
			{
				// >Tomar idhorario pasandole el idhorariodetallefecha
				$idhorario = tomaridhorario($idhorariodetallefecha, $sala);
				if(fechavalida($idhorario, $fechadesdehorariodetallefecha, $fechahastahorariodetallefecha, $sala))
				{
					if(!existefechasindetalle($idhorario, $idhorariodetallefecha, $fechadesdehorariodetallefecha, $fechahastahorariodetallefecha, $sala))
					{
						$inserto = true;
						// Inserta una nueva fecha
						$query_updhorariodetallefecha = "UPDATE horariodetallefecha 
						SET fechadesdehorariodetallefecha='$fechadesdehorariodetallefecha', fechahastahorariodetallefecha='$fechahastahorariodetallefecha'
						WHERE idhorariodetallefecha = '$idhorariodetallefecha'";
						//echo "<h3>$query_updhorariodetallefecha</h3>";
						$updhorariodetallefecha = mysql_query($query_updhorariodetallefecha, $sala) or die("$query_updhorariodetallefecha");
					}
				}
			}
		}
	}
}

/********* Datos de fecha del horario **************/
$query_horariodetallefecha = "SELECT idhorariodetallefecha, idhorario, fechadesdehorariodetallefecha, 
fechahastahorariodetallefecha, codigoestado 
FROM horariodetallefecha
where idhorario = '$idhorario'
and codigoestado like '1%'";
//echo "<h3>$query_horariodetallefecha</h3>";
$horariodetallefecha = mysql_query($query_horariodetallefecha, $sala) or die("$query_horariodetallefecha");
$totalRows_horariodetallefecha = mysql_num_rows($horariodetallefecha);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Detalle Horario</title>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold; }
-->
</style>
<style type="text/css">
@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);
.Estilo4 {
	font-size: 12px;
	color: #FF9900;
}
</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
</head>
<body>
<p align="center" class="Estilo3">EDITAR FECHAS HORARIO</p>
<div align="center">
<form name="f1" action="horariodetallefecha.php?idhorario=<?php echo $idhorario;?>" method="post">
<font size="2" face="Tahoma">
<input type="hidden" name="grupo1" value="<?php echo $grupo ?>">
<input type="hidden" name="idgrupo1" value="<?php echo $idgrupo ?>">
<input type="hidden" name="numerohorassemanales1" value="<?php echo $numerohorassemanales ?>">
</font> 
<table border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td align="center" bgcolor="#C5D5D6"><span class="Estilo2">Selección</span></td>
	<td align="center" bgcolor="#C5D5D6"><span class="Estilo2">Fecha Inicial</span></td>
	<td align="center" bgcolor="#C5D5D6"><span class="Estilo2">Fecha Final</span></td>
	<td align="center" bgcolor="#C5D5D6"><span class="Estilo2">Acción</span></td>
  </tr>
<?php
if($totalRows_horariodetallefecha != "")
{
	while($row_horariodetallefecha = mysql_fetch_assoc($horariodetallefecha))
	{
		$idhorariodetallefecha = $row_horariodetallefecha['idhorariodetallefecha'];
		$idhorario = $row_horariodetallefecha['idhorario'];
		$fechadesdehorariodetallefecha = $row_horariodetallefecha['fechadesdehorariodetallefecha'];
		$fechahastahorariodetallefecha = $row_horariodetallefecha['fechahastahorariodetallefecha'];
		$codigoestado = $row_horariodetallefecha['codigoestado'];
?>
  <tr>
    <td align="center"><span class="Estilo1">
      <input type="checkbox" name="fechaseleccionada<?php echo $idhorariodetallefecha; ?>" value="<?php echo $idhorariodetallefecha; ?>">
    </span></td>
	<td align="center"><span class="Estilo1">
      <input type="text" name="fechainicial<?php echo $idhorariodetallefecha; ?>" style="font-size:9px" size="8" maxlength="10" readonly="true" value="<?php echo $fechadesdehorariodetallefecha; ?>">
    </span></td>
	<td align="center"><span class="Estilo1">
	  <input type="text" name="fechafinal<?php echo $idhorariodetallefecha; ?>" style="font-size:9px" size="8" maxlength="10" readonly="true" value="<?php echo $fechahastahorariodetallefecha; ?>">
	</span></td>
	<td align="center"><input type="button" value="Eliminar" onClick="eliminar(<?php echo "$idhorariodetallefecha, $idhorario";?>)"></td>
  </tr>
<script type="text/javascript">
	Calendar.setup(
	{ inputField : "fechainicial<?php echo $idhorariodetallefecha; ?>", // ID of the input field
		ifFormat : "%Y-%m-%d", // the date format
		text : "fecha", // ID of the button
		range : [<?php echo $row_selgrupo['fechainiciogrupo'];?>,<?php echo $row_selgrupo['fechafinalgrupo'];?>]
	});
</script>
<script type="text/javascript">
	Calendar.setup(
	{ inputField : "fechafinal<?php echo $idhorariodetallefecha; ?>", // ID of the input field
		ifFormat : "%Y-%m-%d", // the date format
		text : "fecha" // ID of the button
	});
</script>
<?php
	}
}
?>  
  <tr>
  <td>&nbsp;</td>
  	    <td align="center" colspan="1"><span class="Estilo1">
  	      <input type="text" name="fechaini" style="font-size:9px" size="8" maxlength="10" readonly="true">
</span></td>
  	    <td align="center" colspan="1"><span class="Estilo1"><input type="text" name="fechafin" style="font-size:9px" size="8" maxlength="10" readonly="true">
        </span></td>
		<td align="center"><input type="submit" name="nuevafecha" value="Insertar"></td>
  </tr>
  <tr>
  <td align="center" colspan="4"><input type="submit" value="Aceptar Modificaciones" name="aceptar"><input type="button" onClick="window.close()" value="Cerrar"></td>
  </tr>
</table>
<P align="center"><strong>Si desea aplicar alguna de las fechas de este horario en los demás horarios, seleccionela y oprima el botón</strong>
<br><input type="submit" name="masivo" value="Aplicar Fecha a Los Otros Horarios"></P>
</form>
<font face="Tahoma">
</font></div>
</body>
<?php
echo '
<script language="JavaScript">
function cancelarhorario()
{
	window.location.reload("editarhorario.php'.$dirini.'&grupo1='.$grupo.'&numerohorassemanales1='.$numerohorassemanales.'&idgrupo1='.$idgrupo.'");
}
</script>';
?>
</html>
<script type="text/javascript">
	Calendar.setup(
	{ inputField : "fechaini", // ID of the input field
		ifFormat : "%Y-%m-%d", // the date format
		text : "fecha", // ID of the button
		range : [<?php echo $row_selgrupo['fechainiciogrupo'];?>,<?php echo $row_selgrupo['fechafinalgrupo'];?>]
	});
</script>
<script type="text/javascript">
	Calendar.setup(
	{ inputField : "fechafin", // ID of the input field
		ifFormat : "%Y-%m-%d", // the date format
		text : "fecha", // ID of the button
		range : [<?php echo $row_selgrupo['fechainiciogrupo'];?>,<?php echo $row_selgrupo['fechafinalgrupo'];?>]
	});
	//Calendar.setRange(<?php echo $row_selgrupo['fechainiciogrupo'];?>, <?php echo $row_selgrupo['fechafinalgrupo'];?>);
</script>
<script language="javascript">
	function eliminar(idhorariodetallefecha, idhorario)
	{
		if(confirm("¿Está seguro de eliminar el registro?"))
		{
			window.location.href="horariodetallefecha.php?idhorario="+idhorario+"&eliminar="+idhorariodetallefecha;
		}
	}
</script>