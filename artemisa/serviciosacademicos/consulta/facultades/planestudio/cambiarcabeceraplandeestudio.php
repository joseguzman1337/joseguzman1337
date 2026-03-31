<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
include (realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));

require_once("../../../funciones/validacion.php");
require_once("../../../funciones/errores_plandeestudio.php");

require_once('seguridadplandeestudio.php');

// Validacion de la cantidad de electivas
if(isset($_POST['petipoelectivas']))
{
	if($_POST['petipoelectivas'] == 100)
	{
		if($_POST['pecantidad']/100 > 1 || $_POST['pecantidad'] == "")
		{
?>
<script language="javascript">
	alert("La Cantidad debe ser un Porcentaje, de 1% a 100%");
	history.go(-1);
</script>
<?php
		}
	}
}

if(isset($_GET['planestudio']))
{
	$idplanestudio = $_GET['planestudio'];
}
else
{
	$idplanestudio = 0;
}

$query_planestudio = "select p.idplanestudio, p.nombreplanestudio, p.fechacreacionplanestudio,
p.responsableplanestudio, p.cargoresponsableplanestudio, p.cantidadsemestresplanestudio,
c.nombrecarrera, p.numeroautorizacionplanestudio, t.nombretipocantidadelectivalibre, c.codigocarrera,
p.codigotipocantidadelectivalibre, p.cantidadelectivalibre, p.fechainioplanestudio, p.fechavencimientoplanestudio
from planestudio p, carrera c, tipocantidadelectivalibre t
where p.codigocarrera = c.codigocarrera
and p.codigotipocantidadelectivalibre = t.codigotipocantidadelectivalibre
and p.idplanestudio = '$idplanestudio'";
//echo "$query_planestudio<br>";
$planestudio = $db->GetRow($query_planestudio);
$row_planestudio = $planestudio;
$totalRows_planestudio = count($planestudio);
if($totalRows_planestudio != "")
{
	$formulariovalido = 1;

	/********* COMBO TIPO DE ELECTIVAS **************/
	$query_tipoelectiva = "SELECT codigotipocantidadelectivalibre, nombretipocantidadelectivalibre FROM tipocantidadelectivalibre";
	$tipoelectiva = $db->GetAll($query_tipoelectiva);
	$row_tipoelectiva = $tipoelectiva;
	$totalRows_tipoelectiva = count($tipoelectiva);
?>
<html>
<head>
<title>Cambiar cabecera plan de estudio</title>
</head>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
}
.Estilo2 {
	font-family: Tahoma;
	font-size: 9px;
}
.Estilo3 {
	font-family: Tahoma;
	font-size: 9px;
	width: 15px
}
-->
</style>
<body>
<div align="center">
<form name="f1" method="post" action="cambiarcabeceraplandeestudio.php?planestudio=<?php echo $idplanestudio;?>">
<p class="Estilo1" align="center"><strong>PLAN DE ESTUDIO</strong></p>
<table width="710" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
  	<td align="center" bgcolor="#C5D5D6"><strong>Nº Plan Estudio</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Nombre</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Fecha</strong></td>
  </tr>
  <tr>
	<td align="center"><?php echo $row_planestudio['idplanestudio'];?></td>
	<td align="center"><input name="penombre" type="text" size="20" value="<?php if(isset($_POST['penombre'])) echo $_POST['penombre']; else echo $row_planestudio['nombreplanestudio'];?>" >
	 <font color="#FF0000" size="-1">
<?php
		if(isset($_POST['penombre']))
		{
			$nombre = $_POST['penombre'];
			$imprimir = true;
			$nombrerequerido = validar($nombre,"requerido",$error1,$imprimir);
			$formulariovalido = $formulariovalido*$nombrerequerido;
		}
?>
	  </font></td>
	<td align="center"><?php echo preg_replace("/[0-9]+:[0-9]+:[0-9]+/","",$row_planestudio['fechacreacionplanestudio']);?></td>
  </tr>
  <tr>
  	<td align="center" colspan="2" bgcolor="#C5D5D6"><strong>Nombre Encargado</strong></td>
  	<td align="center" bgcolor="#C5D5D6"><strong>Cargo</strong></td>
  </tr>
  <tr>
	<td align="center" colspan="2"><input name="penombreencargado" type="text" size="20" value="<?php if(isset($_POST['penombreencargado'])) echo $_POST['penombreencargado']; else echo $row_planestudio['responsableplanestudio'];?>">
	<font color="#FF0000" size="-1">
<?php
		if(isset($_POST['penombreencargado']))
		{
			$nombreencargado = $_POST['penombreencargado'];
			$imprimir = true;
			$nombreencargadorequerido = validar($nombreencargado,"requerido",$error1,$imprimir);
			$formulariovalido = $formulariovalido*$nombreencargadorequerido;
		}
?>
	  </font></td>
	<td align="center"><input name="pecargo" type="text" size="15" value="<?php if(isset($_POST['pecargo'])) echo $_POST['pecargo']; else echo $row_planestudio['cargoresponsableplanestudio'];?>">
	<font color="#FF0000" size="-1">
<?php
		if(isset($_POST['pecargo']))
		{
			$cargo = $_POST['pecargo'];
			$imprimir = true;
			$cargorequerido = validar($cargo,"requerido",$error1,$imprimir);
			$formulariovalido = $formulariovalido*$cargorequerido;
		}
?>
	  </font></td>
  </tr>
  <tr>
  	<td align="center" bgcolor="#C5D5D6"><strong>Nº Semestres</strong></td>
  	<td align="center" bgcolor="#C5D5D6"><strong>Carrera</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Autorización Nº</strong></td>
  </tr>
  <tr>
  	<td align="center">
	<table>
	<tr>
		<td rowspan="2">
		<input name="pesemestre" maxlength="2" type="text" size="2" value="<?php if(isset($_POST['pesemestre'])) echo $_POST['pesemestre']; else echo $row_planestudio['cantidadsemestresplanestudio'];?>" style="width: 20px " onBlur="limitesemestre(this)">
		</td>
	</tr>
	<tr>
		<td><input type="button" value="+" onClick="contadorsemestre(1)" class="Estilo3"><br>
	<input type="button" value="-" onClick="contadorsemestre(2)" class="Estilo3"></td>
	</tr>
	</table>
	<font color="#FF0000" size="-1">
<?php
		if(isset($_POST['pesemestre']))
		{
			$semestre = $_POST['pesemestre'];
			$imprimir = true;
			$semestrenumero = validar($semestre,"numero",$error2,$imprimir);
			$semestrerequerido = validar($semestre,"requerido",$error1,$imprimir);
			$formulariovalido = $formulariovalido*$semestrerequerido*$semestrenumero;
		}
?>
      </font>
	</td>
	<td align="center"><?php echo $row_planestudio['nombrecarrera']; ?></td>
	<td align="center"><input name="peautorizacion" type="text" size="20" value="<?php if(isset($_POST['peautorizacion'])) echo $_POST['peautorizacion']; else echo $row_planestudio['numeroautorizacionplanestudio'];?>">
	<font color="#FF0000" size="-1">
<?php
		if(isset($_POST['peautorizacion']))
		{
			$autorizacion = $_POST['peautorizacion'];
			$imprimir = true;
			$autorizacionrequerido = validar($autorizacion,"requerido",$error1,$imprimir);
			$formulariovalido = $formulariovalido*$autorizacionrequerido;
		}
?>
	  </font></td>
  </tr>
 <tr>
  	<!-- <td align="center"><strong>Tipo de Electivas</strong></td>
	<td align="center"><strong>Cantidad</strong></td> -->
	<td align="center" bgcolor="#C5D5D6"><strong>Fecha de Inicio</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Fecha de Vencimiento</strong></td>
	<td rowspan="2">&nbsp;</td>
  </tr>
  <tr>
  	<!-- <td align="center"><font size="1" face="Tahoma">
  	  <select name="petipoelectivas">
       <option value="<?php echo $row_planestudio['codigotipocantidadelectivalibre']; ?>" SELECTED><?php echo $row_planestudio['nombretipocantidadelectivalibre']; ?></option>
		<?php

			if($row_planestudio['codigotipocantidadelectivalibre'] != $row_tipoelectiva['codigotipocantidadelectivalibre']) {
                ?>
        <option value="<?php echo $row_tipoelectiva['codigotipocantidadelectivalibre'] ?>"<?php if (!(strcmp($row_tipoelectiva['codigotipocantidadelectivalibre'], $_POST['petipoelectivas']))) {
                    echo "SELECTED";
                } ?>><?php echo $row_tipoelectiva['nombretipocantidadelectivalibre'] ?></option>
<?php
            }
		$row_tipoelectiva = count($tipoelectiva);
		if($row_tipoelectiva > 0)
		{
			$row_tipoelectiva = $tipoelectiva;
		}
?>
      </select>
	  </font>
      <font color="#FF0000" size="-1">
<?php
		if(isset($_POST['petipoelectivas']))
		{
			$tipoelectivas = $_POST['petipoelectivas'];
			$imprimir = true;
			$tipoelectivasrequerido = validar($tipoelectivas,"combo",$error1,$imprimir);
			$formulariovalido = $formulariovalido*$tipoelectivasrequerido;
		}
?>
      </font>
	</td>
	<td align="center">
	<input name="pecantidad" type="text" size="3" maxlength="3" value="<?php if(isset($_POST['pecantidad'])) echo $_POST['pecantidad']; else echo $row_planestudio['cantidadelectivalibre'];?>">
	<font color="#FF0000" size="-1">
<?php
		if(isset($_POST['pecantidad']))
		{
			$cantidad = $_POST['pecantidad'];
			$imprimir = true;
			$cantidadnumero = validar($cantidad,"numero",$error2,$imprimir);
			$cantidadrequerido = validar($semestre,"requerido",$error1,$imprimir);
			$formulariovalido = $formulariovalido*$cantidadnumero*$cantidadrequerido;
		}
?>
	</font>	</td> -->
	<td align="center"><input name="pefechainicio" type="text" size="10" value="<?php if(isset($_POST['pefechainicio'])) echo $_POST['pefechainicio']; else echo ereg_replace(" [0-9]+:[0-9]+:[0-9]+","",$row_planestudio['fechainioplanestudio']);?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)">
      <font size="1" face="Tahoma"><font color="#FF0000">
<?php
		if(isset($_POST['pefechainicio']))
		{
			$fechainicio = $_POST['pefechainicio'];
			$imprimir = true;
			$fechainiciofecha = validar($fechainicio,"fecha",$error3,$imprimir);
			//echo "asda".$pefechainiciofecha;
			$formulariovalido = $formulariovalido*$fechainiciofecha;
			if($formulariovalido == 1)
			{
                $inicio = new DateTime($_POST['pefechainicio']);
				$vencimiento = new DateTime($_POST['pefechavencimiento']);

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
	<td align="center"><input name="pefechavencimiento" type="text" size="10" value="<?php if(isset($_POST['pefechavencimiento'])) echo $_POST['pefechavencimiento']; else echo ereg_replace(" [0-9]+:[0-9]+:[0-9]+","",$row_planestudio['fechavencimientoplanestudio']);?>" onBlur="iniciarvencimiento(this)" onFocus="limpiarvencimiento(this)">
      <font size="1" face="Tahoma"><font color="#FF0000">
      <?php
		if(isset($_POST['pefechavencimiento']))
		{
			$fechavencimiento = $_POST['pefechavencimiento'];
			$imprimir = true;
			$fechavencimientofecha = validar($fechavencimiento,"fecha",$error3,$imprimir);
			$formulariovalido = $formulariovalido*$fechavencimientofecha;
			if($formulariovalido == 1)
			{
                $inicio = new DateTime($_POST['pefechainicio']);
                $vencimiento = new DateTime($_POST['pefechavencimiento']);
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
  <tr>
  	<td colspan="3" align="center"><br><input type="submit" value="Aceptar" name="aceptarcabecera"><input type="button" value="Regresar" name="cancelarcabecera" onClick="window.location.href='visualizarplandeestudio.php?planestudio=<?php echo $idplanestudio;?>'"></td>
  </tr>
</table>
<?php
if(isset($_POST['aceptarcabecera']))
{
	if($formulariovalido)
	{
		$query_tienemateriasenmestre = "select distinct d.semestredetalleplanestudio*1 as semestre
		from detalleplanestudio d
		where d.idplanestudio = '$idplanestudio'
		order by 1 desc";
		//echo "$query_planestudio<br>";
		$tienemateriasenmestre = $db->GetRow($query_tienemateriasenmestre);
		$row_tienemateriasenmestre = $tienemateriasenmestre;
		$totalRows_tienemateriasenmestre = count($tienemateriasenmestre);
		if($row_tienemateriasenmestre['semestre'] > $semestre)
		{
?>
<script language="javascript">
	alert("No puede cambiar el semestre, debido a que tiene materias registradas en un semestre superior");
	history.go(-1);
</script>
<?php
		}
		// Validacion de la cantidad de electivas
		if(isset($_POST['petipoelectivas']))
		{
			if($_POST['petipoelectivas'] == 100)
			{
				if($_POST['pecantidad']/100 > 1 || $_POST['pecantidad'] == "")
				{
?>
<script language="javascript">
	alert("La Cantidad debe ser un Porcentaje, de 1% a 100%");
	history.go(-1);
</script>
<?php
				}
			}
		}
		$query_updplanestudio = "UPDATE planestudio
		SET nombreplanestudio='$nombre', codigocarrera='".$row_planestudio['codigocarrera']."', responsableplanestudio='$nombreencargado', cargoresponsableplanestudio='$cargo', numeroautorizacionplanestudio='$autorizacion', cantidadsemestresplanestudio='$semestre', fechainioplanestudio='$fechainicio', fechavencimientoplanestudio='$fechavencimiento', codigoestadoplanestudio='101'
		WHERE idplanestudio = '$idplanestudio'";
		$updplanestudio = $db->Execute($query_updplanestudio);

		//exit();
		echo '<script language="javascript">
		window.location.href="visualizarplandeestudio.php?planestudio='.$idplanestudio.'";
		</script>';
	}
}
?>
</form>
</div>
</body>
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
<?php
}
?>
