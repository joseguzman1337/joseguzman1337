<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
/** USA LAS SIGUIENTES VARIABLES DE SESION
	GENERALES:
	$_SESSION['carrera']
*/
require_once('../../../../Connections/sala2.php' );
require_once('../../../../funciones/validacion.php' );
require_once('../../../../funciones/errores_plandeestudio.php' );
mysql_select_db($database_sala, $sala);
session_start();
require_once('../seguridadplandeestudio.php');
$codigocarrera = $_SESSION['codigofacultad'];
$formulariovalido = 1;
?>
<html>
<head>
<title>Asignación de Planes de Estudio</title>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
}
-->
</style>
</head>
<?php
echo '
<script language="javascript">
function cambia_tipo()
{
    //tomo el valor del select del tipo elegido
    var tipo
    tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value
    //miro a ver si el tipo está definido
    if (tipo == 1)
	{
		window.location.href="asignacionplanestudio.php?busqueda=estudiante&planestudio='.$_GET['planestudio'].'";
	}
    if (tipo == 2)
	{
		window.location.href="asignacionplanestudio.php?busqueda=semestre&planestudio='.$_GET['planestudio'].'";
    }
	if (tipo == 3)
	{
		window.location.href="asignacionplanestudio.php?busqueda=carrera&planestudio='.$_GET['planestudio'].'";
    }
	if (tipo == 4)
	{
		window.location.href="asignacionplanestudio.php?busqueda=rango&planestudio='.$_GET['planestudio'].'";
    }
}

function buscar()
{
    //tomo el valor del select del tipo elegido
    var busca
    busca = document.f1.busqueda[document.f1.busqueda.selectedIndex].value
    //miro a ver si el tipo está definido
    if (busca != 0)
	{
		window.location.href="asignacionplanestudio.php?buscar="+busca;
	}
}
</script>';
?>
<body>
<div align="center">
<p class="Estilo1"><strong>ASIGNACIÓN DEL PLAN DE ESTUDIO</strong></p>
<form name="f1" action="asignacionplanestudio.php?planestudio=<?php echo $_GET['planestudio']; ?>" method="get">
<?php
if(!isset($_GET['buscar']) || !isset($_GET['debebuscar']))
{
?>
  <p class="Estilo1"><strong>CRITERIO DEASIGNACION</strong></p>
  <table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td width="250" class="Estilo1">
	<strong>Búsqueda por:</strong>	<select name="tipo" onChange="cambia_tipo()">
		<option value="0">Asignar por:</option>
		<option value="1">Estudiante</option>
		<option value="2">Semestre</option>
		<option value="3">Carrera</option>
		<option value="4">Rango de Códigos</option>
	</select>
	&nbsp;
	</td>
	<td class="Estilo1">&nbsp;
<?php
	if(isset($_GET['busqueda']))
	{
		if($_GET['busqueda']=="estudiante")
		{
			echo '<script language="javascript">
			window.location.href="asignacionplanestudioestudiante.php?planestudio='.$_GET['planestudio'].'"
			</script>';
		}
		if($_GET['busqueda']=="semestre")
		{
			echo "<strong>Digite el Semestre:</strong> <input name='busqueda_semestre' type='text'>
			<input type='hidden' name='planestudio' value='".$_GET['planestudio']."'>";
		}
		if($_GET['busqueda']=="carrera")
		{
			echo "<strong>Asignarlo a la carrera</strong>
			<input type='hidden' name='planestudio' value='".$_GET['planestudio']."'>";
		}
		if($_GET['busqueda']=="rango")
		{
			echo "<table align='center'>
			<tr><td class='Estilo1'><strong>Código Inicial:</strong></td><td class='Estilo1' align='center'><input name='codigoinicial' type='text'></td></tr>
			<tr><td class='Estilo1'><strong>Código Final:</strong></td><td class='Estilo1' align='center'><input name='codigofinal' type='text'></td></tr>
			</table>
			<input type='hidden' name='planestudio' value='".$_GET['planestudio']."'>";
		}
	}
?>
	</td>
    <td class="Estilo1"><strong>Fecha: </strong></td>
    <td class="Estilo1"><?php echo $fechahoy=date("Y-m-d");?>&nbsp;</td>
  </tr>
<?php
	if(isset($_GET['busqueda']))
	{
		if($_GET['busqueda'] == "carrera")
		{
?>
  <tr>
  	<td align="center" class="Estilo1" colspan="2"><strong>Fecha de Inicio</strong></td>
	<td align="center" class="Estilo1" colspan="2"><strong>Fecha de Vencimiento</strong></td>
  </tr>
  <tr>
  <td align="center" colspan="2">
  	<input name="pefechainicio" type="text" size="10" value="aaaa-mm-dd" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)">
	<input type="hidden" name="planestudio" value="<?php echo $_GET['planestudio'];?>">
      <font size="1" face="Tahoma"><font color="#FF0000">
      </font></font></td>
	<td align="center" colspan="2"><input name="pefechavencimiento" type="text" size="10" value="2999-12-31" onBlur="iniciarvencimiento(this)" onFocus="limpiarvencimiento(this)">
      <font size="1" face="Tahoma"><font color="#FF0000">
      </font></font></td>
  </tr>
  <tr>
  	<td colspan="4" align="center" class="Estilo1"><input name="buscar" type="submit" value="Aceptar">&nbsp;</td>
  </tr>
<?php
		}
		else
		{
?>
  <tr>
  	<td colspan="4" align="center" class="Estilo1"><input name="buscar" type="submit" value="Buscar">&nbsp;</td>
  </tr>
<?php
		}
	}
?>
 <tr>
  <td colspan="4" align="center"><input type="button" name="cancelar" value="Cancelar" onClick="window.location.href='../plandeestudioinicial.php'"></td>
  </tr>
<?php
  	if(isset($_GET['buscar']))
  	{
		if($_GET['buscar'] == "Buscar")
		{
  ?>
  <tr>
  	<td align="center" class="Estilo1" colspan="2"><strong>Fecha de Inicio</strong></td>
	<td align="center" class="Estilo1" colspan="2"><strong>Fecha de Vencimiento</strong></td>
  </tr>
  <tr>
  <td align="center" colspan="2">
  	<input name="pefechainicio" type="text" size="10" value="aaaa-mm-dd" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)">
	<input type="hidden" name="planestudio" value="<?php echo $_GET['planestudio'];?>">
      <font size="1" face="Tahoma"><font color="#FF0000">
      </font></font></td>
	<td align="center" colspan="2"><input name="pefechavencimiento" type="text" size="10" value="2999-12-31" onBlur="iniciarvencimiento(this)" onFocus="limpiarvencimiento(this)">
      <font size="1" face="Tahoma"><font color="#FF0000">
      </font></font></td>
  </tr>
<?php
		}
		if($_GET['buscar'] == "Asignar" || $_GET['buscar'] == "Aceptar")
		{
  ?>
  <tr>
  	<td align="center" class="Estilo1" colspan="2"><strong>Fecha de Inicio</strong></td>
	<td align="center" class="Estilo1" colspan="2"><strong>Fecha de Vencimiento</strong></td>
  </tr>
  <tr>
  	<td align="center" colspan="2"><?php echo $_GET['pefechainicio']; ?><font size="1" face="Tahoma"><font color="#FF0000">
  	  <?php
			if(isset($_GET['pefechainicio']))
			{
				$fechainicio = $_GET['pefechainicio'];
				$imprimir = true;
				$fechainiciofecha = validar($fechainicio,"fecha",$error3,&$imprimir);
				//echo "asda".$pefechainiciofecha;
				$formulariovalido = $formulariovalido*$fechainiciofecha;
				if($formulariovalido == 1)
				{
					$inicio = ereg_replace("-","",$_GET['pefechainicio']);
					$vencimiento = ereg_replace("-","",$_GET['pefechavencimiento']);
					if($inicio > $vencimiento)
					{
						echo "La Fecha de Inicio debe ser menor que la Fecha de Vencimiento";
						$formulariovalido = 0;
					}
					if($inicio == $vencimiento)
					{
						echo "La Fecha de Inicio debe ser diferente que la Fecha de Vencimiento";
						$formulariovalido = 0;
					}
				}
			}
?>
  	</font></font></td>
	<td align="center" colspan="2"><?php echo $_GET['pefechavencimiento']; ?><font size="1" face="Tahoma"><font color="#FF0000">
	  <?php
			if(isset($_GET['pefechavencimiento']))
			{
				$fechavencimiento = $_GET['pefechavencimiento'];
				$imprimir = true;
				$fechavencimientofecha = validar($fechavencimiento,"fecha",$error3,&$imprimir);
				$formulariovalido = $formulariovalido*$fechavencimientofecha;
				if($formulariovalido == 1)
				{
					$inicio = ereg_replace("-","",$_GET['pefechainicio']);
					$vencimiento = ereg_replace("-","",$_GET['pefechavencimiento']);
					if($inicio > $vencimiento)
					{
						echo "La Fecha de Vencimiento debe ser mayor que la Fecha de Vencimiento";
						$formulariovalido = 0;
					}
					if($inicio == $vencimiento)
					{
						echo "La Fecha de Vencimiento debe ser diferente que la Fecha de Inicio";
						$formulariovalido = 0;
					}
				}
			}
?>
	</font></font></td>
  </tr>
<?php
		}
?>
</table>
<?php
		if($_GET['buscar'] == "Buscar")
		{
?>
<p align="center" class="Estilo1"><strong>Lista de estudiantes a los que les va a asignar el plan de estudios : </strong></p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td align="center" class="Estilo1"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Cédula</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Código</strong>&nbsp;</td>
  </tr>
<?php
			$vacio = false;
			if(isset($_GET['codigoinicial']))
			{
				$codigoini = $_GET['codigoinicial'];
				$codigofin = $_GET['codigofinal'];
				$query_solicitud = "SELECT est.*
				FROM estudiante est
				WHERE est.nombresestudiante LIKE '$nombre%'
				AND est.codigocarrera = '$codigocarrera'
				and est.codigosituacioncarreraestudiante not like '1%'
				and est.codigosituacioncarreraestudiante not like '5%'
				and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
				and est.codigoestudiante between '$codigoini' and '$codigofin'
				ORDER BY est.apellidosestudiante";
				$res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud");
				if($_GET['codigoinicial'] == "" || $_GET['codigofinal'] == "")
					$vacio = true;
			}
			if(isset($_GET['busqueda_semestre']))
			{
				$semestre = $_GET['busqueda_semestre'];
				$query_solicitud = "SELECT est.*
				FROM estudiante est
				WHERE est.semestre = '$semestre'
				AND est.codigocarrera = '$codigocarrera'
				and est.codigosituacioncarreraestudiante not like '1%'
				and est.codigosituacioncarreraestudiante not like '5%'
				and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
				ORDER BY est.apellidosestudiante";
				//AND est.codigocarrera = '$codigocarrera'
				//echo "$query_solicitud<br>";
				$res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud");
				if($_GET['busqueda_semestre'] == "")
					$vacio = true;
			}
			if(!$vacio)
			{
				while($solicitud = mysql_fetch_assoc($res_solicitud))
				{
					$est = $solicitud["apellidosestudiante"]." ".$solicitud["nombresestudiante"];
					$cc = $solicitud["numerodocumento"];
					$cod = $solicitud["codigoestudiante"];
					$codigos[] = $cod;
					echo "<tr>
						<td>$est&nbsp;</td>
						<td>$cc&nbsp;</td>
						<td>$cod&nbsp;</td>
						</tr>";
				}
				if(isset($_GET['codigofinal']))
				{
					echo "<tr>
					<td colspan='3' align='center'>
					<input type='submit' name='buscar' value='Asignar'>
					<input name='codigoinicial' type='hidden' value='$codigoini'>
					<input name='codigofinal' type='hidden' value='$codigofin'>
					</td>
					</tr>";
				}
				if(isset($_GET['busqueda_semestre']))
				{
					echo "<tr>
					<td colspan='3' align='center'>
					<input type='submit' name='buscar' value='Asignar'>
					<input name='busqueda_semestre' type='hidden' value='$semestre'>
					</td>
					</tr>";
				}
			}
?>
</table>
<?php
		}
		if($_GET['buscar'] == "Asignar"  || $_GET['buscar'] == "Aceptar")
		{
			if($formulariovalido)
			{
				//echo "$formulariovalido";
?>
<p align="center" class="Estilo1"><strong>Lista de estudiantes a los que se les asignó el plan de estudios : </strong></p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td align="center" class="Estilo1"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Cédula</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Código</strong>&nbsp;</td>
  </tr>
<?php
				$vacio = false;
				if(isset($_GET['codigoinicial']))
				{
					$codigoini = $_GET['codigoinicial'];
					$codigofin = $_GET['codigofinal'];

					$query_solicitud = "SELECT est.*
					FROM estudiante est
					WHERE est.nombresestudiante LIKE '$nombre%'
					AND est.codigocarrera = '$codigocarrera'
					and est.codigosituacioncarreraestudiante not like '1%'
					and est.codigosituacioncarreraestudiante not like '5%'
					and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
					and est.codigoestudiante between '$codigoini' and '$codigofin'
					ORDER BY est.codigoestudiante";
					$res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud");
					if($_GET['codigoinicial'] == "" || $_GET['codigofinal'] == "")
						$vacio = true;
				}
				if(isset($_GET['busqueda_semestre']))
				{
					$semestre = $_GET['busqueda_semestre'];
					$query_solicitud = "SELECT est.*
					FROM estudiante est
					WHERE est.semestre = '$semestre'
					AND est.codigocarrera = '$codigocarrera'
					and est.codigosituacioncarreraestudiante not like '1%'
					and est.codigosituacioncarreraestudiante not like '5%'
					and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
					ORDER BY est.apellidosestudiante";
					//AND est.codigocarrera = '$codigocarrera'
					//echo "$query_solicitud<br>";
					$res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud");
					if($_GET['busqueda_semestre'] == "")
						$vacio = true;
				}
				if($_GET['buscar'] == "Aceptar")
				{
					$query_solicitud = "SELECT est.*
					FROM estudiante est
					WHERE est.codigocarrera = '$codigocarrera'
					and est.codigosituacioncarreraestudiante not like '1%'
					and est.codigosituacioncarreraestudiante not like '5%'
					and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
					ORDER BY est.apellidosestudiante";
					//AND est.codigocarrera = '$codigocarrera'
					//echo "$query_solicitud<br>";
					$res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud");
					if($codigocarrera == "")
						$vacio = true;
				}
				if(!$vacio)
				{
					while($solicitud = mysql_fetch_assoc($res_solicitud))
					{
						$est = $solicitud["apellidosestudiante"]." ".$solicitud["nombresestudiante"];
						$cc = $solicitud["numerodocumento"];
						$cod = $solicitud["codigoestudiante"];

						$query_planesestudioestudiante = "select p.idplanestudio
						from planestudioestudiante p
						where p.codigoestudiante = '$cod'
						and p.codigoestadoplanestudioestudiante = '101'";
						$planesestudioestudiante = mysql_query($query_planesestudioestudiante, $sala) or die("$query_planesestudioestudiante");
						$totalRows_planesestudioestudiante = mysql_num_rows($planesestudioestudiante);
						if($totalRows_planesestudioestudiante == "")
						{
							$query_insplan = "INSERT INTO planestudioestudiante(idplanestudio, codigoestudiante, fechaasignacionplanestudioestudiante, fechainicioplanestudioestudiante, fechavencimientoplanestudioestudiante, codigoestadoplanestudioestudiante)
							VALUES('".$_GET['planestudio']."', '$cod', '".date("Y-m-d",time())."', '$fechainicio', '$fechavencimiento', '101')";
							//echo "$query_insplan";
							$insplan = mysql_query($query_insplan, $sala) or die("$query_insplan");
						}
						else
						{
							$query_updplan = "UPDATE planestudioestudiante
							SET idplanestudio='".$_GET['planestudio']."', fechaasignacionplanestudioestudiante='".date("Y-m-d",time())."', fechainicioplanestudioestudiante='$fechainicio', fechavencimientoplanestudioestudiante='$fechavencimiento'
							WHERE codigoestudiante = '$cod'";
							//echo "$query_updplan";
							$updplan = mysql_query($query_updplan, $sala) or die("$query_updplan");
						}
						echo "<tr>
						<td>$est&nbsp;</td>
						<td>$cc&nbsp;</td>
						<td>$cod&nbsp;</td>
						</tr>";
					}
					echo "<tr>
					<td colspan='3' align='center'>
					<input type='button' value='Imprimir' onClick='print()'>
					<input type='button' value='Salir' onClick='salir()'>
					</td>
					</tr>";
				}
			}
			else
			{
?>
<script language="javascript">
	alert("Tiene un error en las fechas digitadas");
	history.go(-1);
</script>
<?php
			}
		}
?>
</table>
<?php
	}
}
?>
</form>
</div>
</body>
<script language="javascript">
function salir()
{
	window.location.href="../plandeestudioinicial.php";
}
</script>
<script language="javascript">
function limpiarinicio(texto)
{
	if(texto.value == "aaaa-mm-dd")
		texto.value = "";
}

function limpiarvencimiento(texto)
{
	if(texto.value == "2999-12-31")
		texto.value = "";
}

function iniciarinicio(texto)
{
	if(texto.value == "")
		texto.value = "aaaa-mm-dd";
}

function iniciarvencimiento(texto)
{
	if(texto.value == "")
		texto.value = "2999-12-31";
}

function contadorsemestre(accion)
{
	var cont;
	cont = document.f1.pesemestre.value;
	if(accion == 1)
	{
		if(cont == 12)
		{
			return;
		}
		cont++;
	}
	if(accion == 2)
	{
		if(cont == 1)
		{
			return;
		}
		cont--;
	}
	document.f1.pesemestre.value = cont;
}

function limitesemestre(texto)
{
	if(texto.value > 12)
	{
		texto.value = 12;
		return;
	}
}
</script>
</html>
