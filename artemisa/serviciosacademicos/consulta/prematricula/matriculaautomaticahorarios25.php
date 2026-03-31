<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//session_start();

require_once('../../Connections/sala2.php' );
require_once("../../funciones/validacion.php");
require_once("../../funciones/errores_plandeestudio.php");
require_once("../../funciones/funciontiempo.php");
require_once("../../funciones/funcionip.php");
require_once("asignahorarios/funciones/funcionesvalidacupo.php");
//require_once('../../funciones/clases/autenticacion/redirect.php' );
 //echo "<pre>";
//print_r($_SESSION["materiascorrequisitosesion"]);
//echo "</pre>";
mysql_select_db($database_sala, $sala);
require_once('seguridadprematricula.php');
$materiasunserial = unserialize(stripcslashes($_GET['materiassinhorarios']));
// Esta variable se usa en el resto de la aplicación en el archivo calculocreditossemestre
$materiaselegidas = $materiasunserial;
$materiasserial = serialize($materiasunserial);
$codigoestudiante = $_SESSION['codigo'];
/*foreach($materiasunserial as $llave => $codigomateria)
{
	echo "$llave => $codigomateria<br>";
}
exit();*/
/*echo "POST<pre>";
print_r($_POST);
echo "</pre>";

echo "GET<pre>";
print_r($_GET);
echo "</pre>";

echo "MATERIAUNSERIAL<pre>";
print_r($materiasunserial);
echo "</pre>";
 exit();*/
?>
<html>
<head>
</head>
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
<body>
<?php
if(!isset($_SESSION['codigo']))
{
?><script language="javascript">
	alert("Por seguridad su sesion ha sido cerrada, por favor reinicie.");
</script>
<?php
}
$codigoestudiante = $_SESSION['codigo'];
// Selecciona el periodo activo
$codigoperiodo = $_SESSION['codigoperiodosesion'];
if(isset($_GET['tieneenfasis']))
{
	$getenfasis = "tieneenfasis";
}
// Estos datos se usaran en toda la aplicación

// Seleccionar los datos del estudiante

// El primer query genera resultados si el estudiante tiene plan de estudios.
$cuentaconplandeestudio = true;
$query_datosestudiante = "select concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, e.codigocarrera,
e.numerocohorte, e.codigotipoestudiante, e.codigosituacioncarreraestudiante, e.codigojornada, e.codigoperiodo, pe.cantidadsemestresplanestudio,
t.codigoreferenciatipoestudiante, c.codigoreferenciacobromatriculacarrera, e.idestudiantegeneral, c.codigomodalidadacademica, e.semestre,
c.codigoindicadortipocarrera, c.codigoreferenciacobromatriculacarrera
from estudiante e, estudiantegeneral eg, tipoestudiante t, carrera c, modalidadacademica m, planestudioestudiante pee, planestudio pe
where e.codigoestudiante = '$codigoestudiante'
and eg.idestudiantegeneral = e.idestudiantegeneral
and e.codigotipoestudiante = t.codigotipoestudiante
and e.codigocarrera = c.codigocarrera
and c.codigomodalidadacademica = m.codigomodalidadacademica
and pee.codigoestudiante = e.codigoestudiante
and pee.codigoestadoplanestudioestudiante like '1%'
and pe.idplanestudio = pee.idplanestudio
and pe.codigoestadoplanestudio like '1%'";
//echo "$query_datosestudiante<br>";
$datosestudiante = mysql_db_query($database_sala,$query_datosestudiante) or die("$query_datosestudiante".mysql_error());
$totalRows_datosestudiante = mysql_num_rows($datosestudiante);
if($totalRows_datosestudiante == "")
{
	$cuentaconplandeestudio = false;
	// El segundo query genera resultados si el estudiante no tiene plan de estudios.
	$query_datosestudiante = "select concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, e.codigocarrera,
	e.numerocohorte, e.codigotipoestudiante, e.codigosituacioncarreraestudiante, e.codigojornada, e.codigoperiodo, c.codigoindicadorplanestudio,
	t.codigoreferenciatipoestudiante, c.codigoreferenciacobromatriculacarrera, e.idestudiantegeneral, c.codigomodalidadacademica, e.semestre,
	c.codigoindicadortipocarrera, c.codigoreferenciacobromatriculacarrera
	from estudiante e, estudiantegeneral eg, tipoestudiante t, carrera c, modalidadacademica m
	where e.codigoestudiante = '$codigoestudiante'
	and eg.idestudiantegeneral = e.idestudiantegeneral
	and e.codigotipoestudiante = t.codigotipoestudiante
	and e.codigocarrera = c.codigocarrera
	and c.codigomodalidadacademica = m.codigomodalidadacademica";
	//echo "$query_datosestudiante<br>";
	$datosestudiante = mysql_db_query($database_sala,$query_datosestudiante) or die("$query_datosestudiante".mysql_error());
	$totalRows_datosestudiante = mysql_num_rows($datosestudiante);
}
$row_datosestudiante = mysql_fetch_array($datosestudiante);
$codigocarrera = $row_datosestudiante['codigocarrera'];
$codigotipoestudiante = $row_datosestudiante['codigotipoestudiante'];
$codigojornada = $row_datosestudiante['codigojornada'];
$codigosituacioncarreraestudiante = $row_datosestudiante['codigosituacioncarreraestudiante'];
$codigoperiodoestudiante = $row_datosestudiante['codigoperiodo'];
$codigoreferenciatipoestudiante = $row_datosestudiante['codigoreferenciatipoestudiante'];
$codigoreferenciacobromatriculacarrera = $row_datosestudiante['codigoreferenciacobromatriculacarrera'];
$idestudiantegeneral = $row_datosestudiante['idestudiantegeneral'];
$codigomodalidadacademica = $row_datosestudiante['codigomodalidadacademica'];
$semestredelestudiante = $row_datosestudiante['semestre'];
$cantidadsemestreplanestudio = $row_datosestudiante['cantidadsemestreplanestudio'];
$codigoindicadortipocarrera = $row_datosestudiante['codigoindicadortipocarrera'];

$generarordenes100 = false;
$generarprematricula = true;
if(!$cuentaconplandeestudio)
{
	if(!ereg("^1.+$",$row_datosestudiante['codigoindicadorplanestudio']))
	{
		// Para los estudiantes que no tengan plan de estudios no se le pueden inscribir asignaturas
		// y la generación de ordenes de pago va a ser por el 100%
		$generarordenes100 = true;
		$generarprematricula = false;
		$cuentaconplandeestudio = true;
	}
}
//$codigotipoestudiante = $row_datosestudiante['codigotipoestudiante'];

// Selecciona el subperiodo activo del estudiante
$query_selsubperiodoestudiante = "select s.idsubperiodo, s.codigoestadosubperiodo
from subperiodo s, carreraperiodo c
where c.codigocarrera = '$codigocarrera'
and c.idcarreraperiodo = s.idcarreraperiodo
and c.codigoperiodo = '$codigoperiodo'
and s.codigoestadosubperiodo not like '2%'
order by 2 desc";
//echo "$query_selsubperiodoestudiante<br>";
$selsubperiodoestudiante = mysql_db_query($database_sala,$query_selsubperiodoestudiante) or die("$query_selsubperiodoestudiante");
$totalRows_selsubperiodoestudiante = mysql_num_rows($selsubperiodoestudiante);
$row_selsubperiodoestudiante = mysql_fetch_array($selsubperiodoestudiante);
$idsubperiodo = $row_selsubperiodoestudiante['idsubperiodo'];
//echo $idsubperiodo;
//exit();

// Selecciona las carreras del estudiante
$query_selcarrerasestudiante = "select e.codigoestudiante
from estudiante e
where e.idestudiantegeneral = '$idestudiantegeneral'";
//echo "$query_datocohorte<br>";
$selcarrerasestudiante = mysql_db_query($database_sala,$query_selcarrerasestudiante) or die("$query_selcarrerasestudiante");
$totalRows_selcarrerasestudiante = mysql_num_rows($selcarrerasestudiante);

// Selecciona la cohorte del estudiante
$query_datocohorte = "select numerocohorte, codigoperiodoinicial, codigoperiodofinal
from cohorte
where codigocarrera = '$codigocarrera'
and codigoperiodo = '$codigoperiodo'
and codigojornada = '$codigojornada'
and '$codigoperiodoestudiante'*1 between codigoperiodoinicial*1 and codigoperiodofinal*1";
//echo "$query_datocohorte<br>";
$datocohorte = mysql_db_query($database_sala,$query_datocohorte) or die("$query_datocohorte");
$totalRows_datocohorte = mysql_num_rows($datocohorte);
$row_datocohorte = mysql_fetch_array($datocohorte);
$numerocohorte = $row_datocohorte['numerocohorte'];
//echo "aja $numerocohorte<br>";

/*if(!isset($numerocohorte)||
        trim($numerocohorte)==''){
echo "<script language='javascript'>
alert('No se encuentra cohorte \\nrevise cohorte para la configuracion \\n".
"carrera=".$codigocarrera.", periodo=".$codigoperiodo.",jornada=".$codigojornada."');
</script>";
        }*/

// Seleccion de los grupos con horario
$query_horarioinicial = "SELECT h.idgrupo, d.codigomateria
FROM horario h, grupo g, detalleprematricula d, estudiante e, prematricula p
where h.idgrupo = d.idgrupo
and e.codigoestudiante = p.codigoestudiante
and p.idprematricula = d.idprematricula
and p.codigoperiodo = '$codigoperiodo'
and g.codigoperiodo = p.codigoperiodo
and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%')
and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
and e.codigoestudiante = '$codigoestudiante'
and g.codigoestadogrupo like '1%'
and g.codigoindicadorhorario like '1%'
and d.idgrupo = g.idgrupo";
//echo "$query_horarioinicial<br>";
$horarioinicial=mysql_db_query($database_sala,$query_horarioinicial);
$totalRows_premainicial1 = mysql_num_rows($horarioinicial);
$tienehorario = false;
$tiene_prema = false;
while($row_horarioinicial = mysql_fetch_array($horarioinicial))
{
	$grupo_inicial[] = $row_horarioinicial['idgrupo'];
	$materia_inicial[] = $row_horarioinicial['codigomateria'];
	//echo $row_horarioinicial['idgrupo']."<br>";
	$tienehorario = true;
	$tiene_prema = true;
}
// Seleccion de los grupos sin horario
$query_horarioinicial = "SELECT g.idgrupo, d.codigomateria
FROM grupo g, detalleprematricula d, estudiante e, prematricula p
where e.codigoestudiante = p.codigoestudiante
and p.idprematricula = d.idprematricula
and p.codigoperiodo = '$codigoperiodo'
and g.codigoperiodo = p.codigoperiodo
and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%')
and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
and e.codigoestudiante = '$codigoestudiante'
and g.codigoestadogrupo like '1%'
and g.codigoindicadorhorario like '2%'
and d.idgrupo = g.idgrupo";
//echo "$query_horarioinicial<br>";
$horarioinicial=mysql_db_query($database_sala,$query_horarioinicial);
$totalRows_premainicial1 = mysql_num_rows($horarioinicial);
$tienehorario = false;
while($row_horarioinicial = mysql_fetch_array($horarioinicial))
{
	$grupo_inicial[] = $row_horarioinicial['idgrupo'];
	$materia_inicial[] = $row_horarioinicial['codigomateria'];
	$tiene_prema = true;
	//echo $row_horarioinicial['idgrupo']."<br>";
	//$tienehorario = true;
}
?>
<form name="form1" method="post" action='matriculaautomaticahorarios.php?documentoingreso=<?php echo $_GET['documentoingreso']."&materiassinhorarios=$materiasserial&$getenfasis&lineaunica=".$_GET['lineaunica']."&semestrerep=".$_GET['semestrerep'];?>'>
<?php
//echo
$ffechapago = 1;
if($codigomodalidadacademica == 100 && !$tiene_prema)
{
?>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<tr>
<td colspan="2"><label id="labelresaltado">Seleccione el tipo de orden que quiere generar</label></td>
</tr>
<tr>
<td><strong>Orden de Matricula</strong>
  <input type="radio" name="tipoorden" value="0"  checked></td>
<!--<td>
<strong>Orden de Pensión</strong><input type="radio" name="tipoorden" value="1">
</td>-->
</tr>
</table>
<?php
}

if(ereg("^1.+",$codigoreferenciatipoestudiante) && !ereg("^3.+$",$codigoindicadortipocarrera))
{
	if(ereg("estudiante",$_SESSION["MM_Username"]))
	{
		$readonly = "readonly='true'";
		$_POST['fechapago']=calcularfechafutura(5, $sala);
	}
	// Si entra es por que para este tipo de estudiante debe solicitar fecha de vencimiento de la orden
?>
<br>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <tr>
	<td colspan="2"><p>Fecha de plazo de pago de la orden para estudiantes nuevos. <br>
	Esta fecha aplica en caso de generarse una nueva orden de pago.</p>
	</td>
	</tr>
	<tr>
      <td><strong>Fecha</strong></td>
      <td><input type="text" name="fechapago" value="<?php if(isset($_POST['fechapago'])) { echo $_POST['fechapago']; }?>" <?php echo $readonly ?>> aaaa-mm-dd
	  <?php
				if(isset($_POST['fechapago']))
				{
					//echo "entro";
					$fechapago = $_POST['fechapago'];
					$imprimir = true;
					$ffechapago = validar($fechapago,"fecha",$error3,&$imprimir);
					if($ffechapago != 0)
					{
						require('insertarfecha.php');
					}
					else
					{
						$ffechapago = 0;
						echo "La fecha digitada no es correcta<br>";
					}
				}

?>
  	  </td>
    </tr>
<?php
	if(!$cuentaconplandeestudio && !isset($_POST['grabar']))
	{
?>
  <tr>
	<td colspan="2">
<form name="form1" method="post" action="matriculaautomaticahorarios.php?documentoingreso=<?php echo $_GET['documentoingreso']."&materiassinhorarios=$materiasserial&$getenfasis&lineaunica=".$_GET['lineaunica']."&semestrerep=".$_GET['semestrerep'];?>">
	<input name="grabar" type="submit" id="grabar" value="Grabar">
</form>
	</td>
  </tr>
<?php
	}
?>
</table>
<?php
	// Actualmente a los estudiantes a los que se les solicite fecha y que no tengan plan de estudio se les debe generar la orden al 100%
	if(!$cuentaconplandeestudio && !isset($_POST['grabar']))
	{
		// SI la carrera requiere plan de estudio y el estudiante no lo tiene sale
		exit();
	}
}
if(isset($_SESSION['cursosvacacionalessesion']))
{
?>

<p>Seleccione el concepto con el cual desea generar la orden por créditos académicos</p>
<select name="conceptocobroxcreditos">
<?php
	// Muestra los conceptos que requieren cobro por creditos
	$query_selconceptocobroxcreditos = "select c.codigoconcepto, c.nombreconcepto, c.codigoindicadorconceptoprematricula, c.codigoindicadoraplicacobrocreditosacademicos
	from concepto c
	where c.codigoindicadoraplicacobrocreditosacademicos like '1%'
	and c.codigoestado like '1%'";
	//echo "$query_selconceptocobroxcreditos<br>";
	$selconceptocobroxcreditos=mysql_query($query_selconceptocobroxcreditos, $sala) or die("$query_selconceptocobroxcreditos");
	$totalRows_selconceptocobroxcreditos = mysql_num_rows($selconceptocobroxcreditos);
	while($row_selconceptocobroxcreditos = mysql_fetch_array($selconceptocobroxcreditos))
	{
?>
<option value="<?php echo $row_selconceptocobroxcreditos['codigoconcepto'];?>"><?php echo $row_selconceptocobroxcreditos['nombreconcepto'];?></option>
<?php
	}
?>
</select>

<?php
}
// entra cuando se le pide la fecha
if(!$cuentaconplandeestudio && isset($_POST['grabar']))
{
	// Entra aca cuando se le esta pidiendo fecha
	$permisograbar = true;
	if($permisograbar)
	{
		if(isset($_GET['tieneenfasis']))
		{
			$calcularcreditosenfasis = true;
			//echo "CALCULARA CREDITOS<br>";
		}
		else
		{
			$calcularcreditosenfasis = false;
		}
		//exit();
		$procesoautomatico = false;
		if(isset($_GET['lineaunica']))
		{
			$lineaescogida = $_GET['lineaunica'];
		}
		else
		{
			$lineaescogida = "";
		}
		//echo "sdadas<br>linea".$_GET['lineaunica']."<br>enfasis".$_POST['tieneenfasis']."$calcularcreditosenfasis<br>";
		//exit();
		$ip = tomarip();
		$procesoautomaticotodos = false;
		/*foreach($materiaselegidas as $key => $value)
		{
			echo "<br> $key => $value <br>";
		}*/
		//exit();
		//$usarcondetalleprematricula = false;

		$ruta="../../funciones/";
		require_once("../../funciones/ordenpago/claseordenpago.php");
		$orden = new Ordenpago($sala, $codigoestudiante, $codigoperiodo);
		if(!$orden->valida_ordenmatricula())
		{
			//exit();
		?>
			<script language="javascript">
				history.go(-3);
			</script>
<?php
		}
		else
		{
			//require_once('../../Connections/sap.php' );
?>

<?php			require("matriculaautomaticaguardar.php");
			//	saprfc_close($rfc);
?>

<?php
		}
		exit();
	}
}
if(!isset($_POST['grabar']) && !$cuentaconplandeestudio)
{
	// Entra aca cuando se le esta pidiendo fecha
	$permisograbar = true;
	if(!$ffechapago)
	{
		$permisograbar = false;
	}
	if($permisograbar)
	{
		//echo "Tiene permiso<br> $fechapago";
		//exit();
		if(isset($_GET['tieneenfasis']))
		{
			$calcularcreditosenfasis = true;
			//echo "CALCULARA CREDITOS<br>";
		}
		else
		{
			$calcularcreditosenfasis = false;
		}
		//exit();
		$procesoautomatico = false;
		if(isset($_GET['lineaunica']))
		{
			$lineaescogida = $_GET['lineaunica'];
		}
		else
		{
			$lineaescogida = "";
		}
		echo "<br>linea".$_GET['lineaunica']."<br>enfasis".$_POST['tieneenfasis']."$calcularcreditosenfasis<br>";
		//exit();
		$ip = tomarip();
		$procesoautomaticotodos = false;
		/*foreach($materiaselegidas as $key => $value)
		{
			echo "<br> $key => $value <br>";
		}*/
		//exit();
		//$usarcondetalleprematricula = false;

		$ruta="../../funciones/";
		require_once("../../funciones/ordenpago/claseordenpago.php");
		$orden = new Ordenpago($sala, $codigoestudiante, $codigoperiodo);
		if(!$orden->valida_ordenmatricula())
		{
			//exit();
		?>
			<script language="javascript">
				history.go(-3);
			</script>
<?php
		}
		else
		{
			//require_once('../../Connections/sap.php' );
?>

<?php		require("matriculaautomaticaguardar.php");
			//saprfc_close($rfc);
?>

<?php
		}
		exit();
	}
}
?>

  <p>HORARIOS</p>
  <p>
    <?php
// Selecciona los datos de la materia y los horarios para las materias que tiene el estudiante
if(is_array($materiasunserial))
{
	foreach($materiasunserial as $llave => $codigomateria)
	{
		$deshabilitasincupo=0;

		//echo "$llave => $codigomateria";
		// Selecciona los datos de las materias para aquellas que no son electivas, de acuerdo al plan de estudio
		$query_datosmateria = "select m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio
		from materia m, detalleplanestudio dpe, planestudioestudiante pee
		where m.codigomateria = '$codigomateria'
		and pee.codigoestudiante = '$codigoestudiante'
		and m.codigomateria = dpe.codigomateria
		and pee.idplanestudio = dpe.idplanestudio
		and pee.codigoestadoplanestudioestudiante like '1%'";
		// Otro query para selecciona los datos de las materias cuando el anterior es vacio para las demás materias
		// Tanto enfasis como electivas libres
		$datosmateria=mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
		$totalRows_datosmateria = mysql_num_rows($datosmateria);
		if($totalRows_datosmateria == "")
		{
			// Toma los datos de la materia si es enfasis
			$query_datosmateria = "select m.nombremateria, m.codigomateria, dle.semestredetallelineaenfasisplanestudio as semestredetalleplanestudio
			from materia m, detallelineaenfasisplanestudio dle, lineaenfasisestudiante lee
			where m.codigomateria = '$codigomateria'
			and lee.codigoestudiante = '$codigoestudiante'
			and m.codigomateria = dle.codigomateriadetallelineaenfasisplanestudio
			and lee.idplanestudio = dle.idplanestudio
			and lee.idlineaenfasisplanestudio = dle.idlineaenfasisplanestudio
			and dle.codigoestadodetallelineaenfasisplanestudio like '1%'
			and  (NOW() between lee.fechainiciolineaenfasisestudiante and lee.fechavencimientolineaenfasisestudiante)";
			// Otro query para selecciona los datos de las materias cuando el anterior es vacio para las demás materias
			// Tanto enfasis como electivas libres
			$datosmateria=mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
			$totalRows_datosmateria = mysql_num_rows($datosmateria);
			// Si se trata de una electiva
		}
		if($totalRows_datosmateria == "")
		{

			$query_datosmateria = "select m.nombremateria, m.codigomateria
			from materia m
			where m.codigomateria = '$codigomateria'
			and m.codigoestadomateria = '01'";
			//and m.codigotipomateria = '4'";
			$datosmateria=mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
			$totalRows_datosmateria = mysql_num_rows($datosmateria);
			if(ereg("grupo[0-9]+",$llave))
			{
				// Si la llave esta en materia la coje y la manda como codigomateriaelectiva
				$query_materiapapa = "select m.nombremateria, m.codigomateria
				from materia m
				where m.codigomateria = '".ereg_replace("grupo","",$llave)."'
				and m.codigoestadomateria = '01'";
				//echo "<br>$query_materiapapa";
				$materiapapa=mysql_query($query_materiapapa, $sala) or die("$query_materiapapa");
				$totalRows_materiapapa = mysql_num_rows($materiapapa);
				if($totalRows_materiapapa != "")
				{
					$mpapa = $llave;
				}
			}
			else if(ereg("electiva[0-9]+",$llave))
			{
				// Al tratarse de una electiva selecciona la electiva del plan de estudios para el estudiante
				$query_materiapapa = "select m.nombremateria, m.codigomateria
				from materia m
				where m.codigomateria = '".ereg_replace("electiva","",$llave)."'
				and m.codigoestadomateria = '01'";
				//echo "<br>$query_materiapapa";
				$materiapapa=mysql_query($query_materiapapa, $sala) or die("$query_materiapapa");
				$totalRows_materiapapa = mysql_num_rows($materiapapa);
				if($totalRows_materiapapa != "")
				{
					$mpapa = $llave;
				}
			}
		}
		if($totalRows_datosmateria != "")
		{
			while($row_datosmateria = mysql_fetch_array($datosmateria))
			{
				// Arreglo que guarda el nombre de las materias
				$nombresmateria[$codigomateria] = $row_datosmateria['nombremateria'];
?>
  </p>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">

    <tr>
      <td colspan="9" style="border-bottom-color:#000000 "><label id="labelresaltado"><?php echo $row_datosmateria['nombremateria'];?></label></td>
      <td id="tdtitulogris" style="border-top-color:#000000; border-left-color:#000000; border-bottom-color:#000000">C&oacute;digo</td>
      <td style="border-top-color:#000000; border-right-color:#000000; border-bottom-color:#000000"><?php echo $row_datosmateria['codigomateria'];?></td>
    </tr>

<?php

				//Selecciona los datos de los grupos para una materia
				$query_datosgrupos = "select g.idgrupo, concat(d.nombredocente,' ',d.apellidodocente) as nombre,
				g.maximogrupo,  g.maximogrupoelectiva, g.matriculadosgrupo, g.matriculadosgrupoelectiva,
				g.codigoindicadorhorario, g.nombregrupo, g.fechainiciogrupo, g.fechafinalgrupo
				from grupo g, docente d
				where g.numerodocumento = d.numerodocumento
				and g.codigomateria = '$codigomateria'
				and g.codigoperiodo = '$codigoperiodo'
				and g.codigoestadogrupo = '10'";
				$datosgrupos=mysql_query($query_datosgrupos, $sala) or die("$query_datosgrupos");
				$totalRows_datosgrupos = mysql_num_rows($datosgrupos);

				$chequear = "";
				$desabilitar = "";

				$poseemateria = false;
				$vieneporelpost = false;
				if(isset($materia_inicial))
				{
					foreach($materia_inicial as $llave => $codigomateriaprema)
					{
						if($codigomateriaprema == $codigomateria)
						{
							$chequear = "";
							$desabilitar = "";
							$poseemateria = true;
							$desabilitardemas = true;
							break;
						}
					}
				}
				if(!$poseemateria)
				{
					// Arreglo que va a guardar el menor semestre para las materias seleccionadas de más
					$semestrematerias[] = $row_datosmateria['semestredetalleplanestudio'];
				}
				if($totalRows_datosgrupos != "")
				{
					$tieneprimergrupoconhorarios = 0;
					$grupoencontrado = false;
					unset($desabilitardesabilitar);

					while($row_datosgrupos = mysql_fetch_array($datosgrupos))
					{
						// Selecciona los datos de los horarios
						$query_datoshorarios = "select h.codigodia, h.horainicial, h.horafinal, s.nombresalon, s.codigosalon, d.nombredia,h.idhorario
						from horario h, dia d, salon s
						where h.codigodia = d.codigodia
						and h.codigosalon = s.codigosalon
						and h.idgrupo = '".$row_datosgrupos['idgrupo']."'
						order by 1,2,3";
						$datoshorarios=mysql_query($query_datoshorarios, $sala) or die("$query_datoshorarios");
						//echo "$query_datoshorarios<br>";
						$totalRows_datoshorarios = mysql_num_rows($datoshorarios);

						if($desabilitardemas)
						{
							$desabilitar = "disabled";
							$chequear = "";
						}
						if($totalRows_datoshorarios == "")
						{
							// Si el grupo no tiene horarios desabilita
							//$chequear = "checked";
							$desabilitar = "disabled";
						}
						if(ereg("^2+",$row_datosgrupos['codigoindicadorhorario']))
						{
							// Si el grupo no requiere horarios lo habilita
							$desabilitar = "";
							$chequear = "checked";
							$tieneprimergrupoconhorarios++;
						}
						//echo "<br>if(".$row_datosgrupos['idgrupo']." == ".$_POST[$grupopost].")";
						if(!$vieneporelpost)
						{
							if($row_datosgrupos['idgrupo'] == $_POST[$grupopost])
							{
								$chequear = "checked";
								$vieneporelpost = true;
							}
						}
						else
						{
							$chequear = "";
						}
						if($tieneprimergrupoconhorarios == 0)
						{
							// Si el grupo que entra tiene horario o no requiere lo chequea
							$chequear = "checked";
						}
						if(ereg("^1+",$row_datosgrupos['codigoindicadorhorario']) || $desabilitardemas)
						{
							// Si el grupo requiere horarios lo desabilita
							$desabilitar = "disabled";
							$tieneprimergrupoconhorarios++;
						}
						if(!$poseemateria)
						{
							//echo "eche";
							$desabilitar = "";
							//$chequear = "checked";
						}

						//$desabilitar == "disabled";
						$grupopost = "grupo".$row_datosmateria['codigomateria'];

						// Si la materia pertenece a la carrera del estudiante se hace esto
						// Primero se cuentan el total y se mira si tine cupo la materia en el total
						// Si no se mira que la materia tenga cupo como electiva
						// Selecciona los datos de los horarios
						$query_pertenecemateria = "select codigomateria
						from materia
						where codigomateria = '$codigomateria'
						and codigocarrera = '$codigocarrera'";
						$pertenecemateria=mysql_query($query_pertenecemateria, $sala) or die("$query_pertenecemateria");
						//echo "$query_pertenecemateria<br>";
						$totalRows_pertenecemateria = mysql_num_rows($pertenecemateria);
						$sincupo = false;
						if($totalRows_pertenecemateria != "")
						{
							$grupoencontrado = true;
							if(($row_datosgrupos['matriculadosgrupo'] + $row_datosgrupos['matriculadosgrupoelectiva']) >= $row_datosgrupos['maximogrupo'])
							{
								$desabilitar = "disabled";
								$chequear = "";
								$sincupo = true;
							}
							//echo "".$row_datosgrupos['matriculadosgrupo']." + ".$row_datosgrupos['matriculadosgrupoelectiva']."aca <br>";
						}
						else
						{
							if(($row_datosgrupos['matriculadosgrupo'] + $row_datosgrupos['matriculadosgrupoelectiva']) >= $row_datosgrupos['maximogrupo'])
							{
								$grupoencontrado = true;
								$desabilitar = "disabled";
								$chequear = "";
								$sincupo = true;
							}
							else if($row_datosgrupos['maximogrupoelectiva'] != 0)
							{
								 $sincupo = true;
								//echo $sincupo,"aca";
								//echo "".$row_datosgrupos['matriculadosgrupo']." + ".$row_datosgrupos['matriculadosgrupoelectiva']."<br>";
								if($row_datosgrupos['maximogrupoelectiva'] <= $row_datosgrupos['matriculadosgrupoelectiva'])
								{
									//$sincupo;
									/*$grupoencontrado = true;
									$desabilitar = "disabled";
									$chequear = "";
									$sincupo = true;
									*/
									continue;
								}
								else
								{
									$grupoencontrado = true;
								}
							}
							else
							{
								$grupoencontrado = true;
							}
						}
						if($desabilitardemas)
						{
							$chequear = "";
						}
						if(isset($grupo_inicial))
						{
							foreach($grupo_inicial as $llave => $idgrupoprematricula)
							{
								//echo $row_datosgrupos['idgrupo']." == $idgrupoprematricula $llave => $idgrupoprematricula <br>";
								if($row_datosgrupos['idgrupo'] == $idgrupoprematricula)
								{
									$desabilitardemas = true;
									$desabilitar = "disabled";
									$chequear = "checked";
									//echo "ENTRO";
									//exit();}
									//echo "grupoprema=".$row_datosgrupos['idgrupo'];
									$deshabilitasincupo=1;
									break;
								}
							}
						}
						if($totalRows_pertenecemateria != 0)
						$pertenecemateriaestudiante=1;
						else
						$pertenecemateriaestudiante=0;
						$sincupo=validacupoelectiva($row_datosgrupos,$pertenecemateriaestudiante);
						//echo "DESA: $desabilitar";
?>
    <tr>
      <td id="tdtitulogris" style="border-top-color:#000000">Grupo</td>
      <td style="border-top-color:#000000"><?php echo $row_datosgrupos['idgrupo'];?></td>
      <td id="tdtitulogris" style="border-top-color:#000000">Docente</td>
      <td style="border-top-color:#000000"><?php echo $row_datosgrupos['nombre'];?></td>
      <td id="tdtitulogris" style="border-top-color:#000000">Nombre Grupo</td>
      <td style="border-top-color:#000000"><?php echo $row_datosgrupos['nombregrupo'];?></td>
	  <td id="tdtitulogris" style="border-top-color:#000000">Max. Grupo</td>
      <td style="border-top-color:#000000"><?php echo $row_datosgrupos['maximogrupo'];?></td>
      <td id="tdtitulogris" style="border-top-color:#000000">Matri./Prematri.</td>
      <td style="border-top-color:#000000"><?php echo $row_datosgrupos['matriculadosgrupo'] + $row_datosgrupos['matriculadosgrupoelectiva'];?></td>
	  <td style="border-top-color:#000000">
<?php
						if($totalRows_materiapapa != "")
						{ //echo "papa".$row_datosmateria['codigomateria']."$mpapa";
?>
		<input type="hidden" name="<?php echo "papa".$row_datosmateria['codigomateria']; ?>" id="<?php echo "papa".$row_datosmateria['codigomateria']; ?>" value="<?php echo $mpapa ?>">
<?php
						}
						if($chequear=="checked"&&$desabilitar=="disabled"){
								$desabilitardesabilitar=1;
						}




						if(ereg("^1+",$row_datosgrupos['codigoindicadorhorario']))
						{
							if($totalRows_datoshorarios == "")
							{
								$desabilitar="disabled";
								$type="checkbox";
							}
						}


						if($sincupo)
						{
						//$desabilitar="disabled";
							if($poseemateria){
								$type="radio";
								$desabilitardesabilitar=1;
							}
							else{
								$type="checkbox";
								$desabilitar="disabled";
								$chequear="";
							}

							if(isset($_POST["check".$codigomateria])){
								$desabilitar="disabled";
								if(!$poseemateria)
								$chequear="";
								//$id="inhabilita";
							}
							//echo "deshabilitasincupo=".$deshabilitasincupo;
							if(!$deshabilitasincupo)
								$sincupo="sincupo";
							else
								$sincupo="habilita";

		?>
		<label id="labelresaltado">Sin cupo</label>
		<input name="<?php echo "grupo".$row_datosmateria['codigomateria']; ?>" type="<?php echo $type ?>" id='<?php echo $sincupo ?>' value="<?php echo $row_datosgrupos['idgrupo']; ?>" <?php echo "$chequear $desabilitar"; ?>>
		<?php
						}
						else
						{
							if(isset($_POST["check".$codigomateria])){
								$desabilitar="disabled";
								$chequear="";
								//$id="inhabilita";
							}

		?>
		<input name="<?php echo "grupo".$row_datosmateria['codigomateria']; ?>" type="radio" id='habilita' value="<?php echo $row_datosgrupos['idgrupo']; ?>" <?php echo "$chequear $desabilitar"; ?>>
		<?php
						}
		?>
		</td>
    </tr>
	<tr>
	<td colspan="11">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="100%">
      <td><strong>Fecha de Inicio</strong></td>
      <td><?php echo $row_datosgrupos['fechainiciogrupo'];?></td>
	  <td><strong>Fecha de Vencimiento</strong></td>
      <td><?php echo $row_datosgrupos['fechafinalgrupo'];?></td>
	  <!-- </table>
	  </td>
    </tr> -->
<?php
						if(ereg("^1+",$row_datosgrupos['codigoindicadorhorario']))
						{
							if($totalRows_datoshorarios != "")
							{
								$tieneprimergrupoconhorarios++;
?>
	 <!-- <tr>
	 <td colspan="11">
	  <table border="0" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="100%"> -->
	    <tr id="trtitulogris">
		  <td>D&iacute;a</td>
		  <td>Hora Inicial</td>
		  <td>Hora Final</td>
		  <td>Sal&oacute;n</td>
 	    </tr>
<?php
								while($row_datoshorarios = mysql_fetch_array($datoshorarios))
								{
									$tieneprimergrupoconhorarios++;
?>
	    <tr>
		  <td><?php echo $row_datoshorarios['nombredia'];

		       /*  $query_detallefecha = "select * from horariodetallefecha
				where idhorario = '".$row_datoshorarios['idhorario']."'";
			    //echo "$query_detallefecha <br> <br>";
			    $detallefecha=mysql_query($query_detallefecha, $sala) or die("$query_detallefecha");
			    $totalRows_detallefecha = mysql_num_rows($detallefecha);
				$row_detallefecha = mysql_fetch_array($detallefecha);
				echo $row_detallefecha['fechadesdehorariodetallefecha'],"----",$row_detallefecha['fechahastahorariodetallefecha'];
		   */
		  ?></td>
		  <td><?php echo $row_datoshorarios['horainicial'];?></td>
		  <td><?php echo $row_datoshorarios['horafinal'];?></td>
		  <td><?php echo $row_datoshorarios['codigosalon'];?></td>
	    </tr>
<?php
								}
							}
							else
							{
								$horariorequerido = true;
								$desabilitardesabilitar=1;
								echo "totalRows_datoshorarios=".$totalRows_datoshorarios;
								echo " row_datosgrupos[codigoindicadorhorario]".$row_datosgrupos['codigoindicadorhorario']."<BR>";

?>
	<tr>
	  <td colspan="11"><label id="labelresaltado">Este grupo requiere horario, dirijase a su facultad para informarlo.</label></td>
	</tr>
<?php
							}
						}
						else
						{
							//continue;
?>
	<tr>
	  <td colspan="11"><label id="labelresaltado">Este grupo no necesita horario.</label></td>
	</tr>
<?php
						}
?>
</table>
</td>
</tr>
<?php
					}
					if(!$grupoencontrado)
					{
						foreach($materiaselegidas as $key => $value)
						{
							if($value != $codigomateria)
							{
								$materiasseleccionadastemp[] = $value;
							}
							else
							{
								//echo $codigomateria;
							}
						}
						unset($materiaselegidas);
						$materiaselegidas = $materiasseleccionadastemp;
						unset($materiasseleccionadastemp);
?>
<tr>
  <td colspan="11"><label id="labelresaltado">Esta materia no tiene grupos, informelo a la facultad. Regrese y deseleccione la materia, o si continua no le ser&aacute; adicionada la materia.</label></td>
</tr>
<?php
					}
				}
				else
				{
					foreach($materiaselegidas as $key => $llave)
					{
						if($llave != $codigomateria)
						{
							$materiasseleccionadastemp[] = $llave;
						}
						else
						{
							//echo $codigomateria;
						}
					}
					unset($materiaselegidas);
					$materiaselegidas = $materiasseleccionadastemp;
					unset($materiasseleccionadastemp);
					//echo "CUENTA: ".count($materiaselegidas)."<br>";
					//exit();
?>
<tr>
  <td colspan="11"><label id="labelresaltado">Esta materia no tiene grupos, informelo a la facultad. Regrese y deseleccione la materia, o si continua no le ser&aacute; adicionada la materia.</label></td>
</tr>
<?php
				}
?>
<tr><td colspan="11">&nbsp;</td></tr>
<?php
if(!$desabilitardesabilitar)
{
	if(isset($_POST["check".$codigomateria]))
		$checkeddesabilitar="checked";
?>
<tr>
  <td colspan="11"  align="right" id="tdtitulogris">Deshabilitar
    <input name="check<?php echo $codigomateria  ?>" value="check<?php echo $codigomateria  ?>" type="checkbox"  <?php echo $checkeddesabilitar." ".$desabilitar ?> onClick="desabilitarmateria('<?php echo  "grupo".$codigomateria  ?>',this,'<?php echo $codigomateria ?>');"></td></tr>
<?php
}
?>

</table>
<?php
			}
		}
	}
}
?>
</p>
<p>
    <input name="grabar" type="submit" id="grabar" value="Grabar"  onClick="habilitar(this.form.habilita)">
&nbsp;
<?php
if($_GET['documentoingreso'])
{
?>
<input type="hidden" value="<?php echo $_GET['documentoingreso'];?>" name="documentoingreso">
<input name="regresar" type="button" id="regresar" value="Regresar" onClick="window.location.href='matriculaautomatica.php?documentoingreso=<?php echo $_GET['documentoingreso'];?>'">
<?php
//exit();
}
else
{
?>
<input name="regresar" type="button" id="regresar" value="Regresar" onClick="window.location.href='matriculaautomatica.php?programausadopor=<?php echo $_GET['programausadopor'];?>'">
<?php
}
?>
</p>

</form>

<?php
$permisograbar = true;
if(isset($_POST['grabar']))
{
/*echo "<pre>";
print_r($_POST);
echo "</pre>";
echo "<pre>";
print_r($_GET);
echo "</pre>";
exit();*/
	foreach($_POST as $llavepost => $valorpost)
	{
		if(ereg("grupo",$llavepost))
		{
			$codmat = ereg_replace("grupo","",$llavepost);
			$materiasescogidaspost[] = $codmat;
		}
	}
	/*echo "<pre>";
	print_r($materiasescogidaspost);
	echo "</pre>";*/

			$materiasprerequisitosesion=$_SESSION["materiascorrequisitosesion"];
	/*echo "<pre>";
	print_r($materiasprerequisitosesion["materiapapa"]);
	echo "</pre>";*/

			for($conprereq=0;$conprereq<count($materiasprerequisitosesion["materiapapa"]);$conprereq++){
				//echo "if(".$materiasprerequisitosesion["estado"][$conprereq]."==200)){<br>";
				$seguir=0;
				if(in_array($materiasprerequisitosesion["materiahija"][$conprereq], $materiasprerequisitosesion["materiapapa"])){
							if(in_array($materiasprerequisitosesion["materiapapa"][$conprereq], $materiasprerequisitosesion["materiapapa"])){
							$seguir=1;
							}
				}
				if($seguir)
				if($materiasprerequisitosesion["estado"][$conprereq]=="200"){
					//echo "if(!in_array(".$materiasprerequisitosesion["materiapapa"][$conprereq].", $materiasescogidaspost)){<br>";
					if(!in_array($materiasprerequisitosesion["materiapapa"][$conprereq], $materiasescogidaspost)){
								echo '<script language="javascript">
								alert("La materia '.$materiasprerequisitosesion["materiapapa"][$conprereq].' debe seleccionarse ya que tiene seleccionado un corequisito doble");
								//window.location.href="matriculaautomatica.php?programausadopor='.$_GET['programausadopor'].'";
								</script>';
								exit();

					}
					//echo "if(!in_array(".$materiasprerequisitosesion["materiahija"][$conprereq].", $materiasescogidaspost)){<br>";
					if(!in_array($materiasprerequisitosesion["materiahija"][$conprereq], $materiasescogidaspost)){
							echo '<script language="javascript">
							alert("La materia '.$materiasprerequisitosesion["materiahija"][$conprereq].' debe seleccionarse ya que tiene seleccionado un corequisito doble");
							//window.location.href="matriculaautomatica.php?programausadopor='.$_GET['programausadopor'].'";
							</script>';
							exit();
					}
				}
				if($seguir)
				if($materiasprerequisitosesion["estado"][$conprereq]=="201"){
					//echo "if(!in_array(".$materiasprerequisitosesion["materiahija"][$conprereq].", $materiasescogidaspost)){";
					if(in_array($materiasprerequisitosesion["materiahija"][$conprereq], $materiasescogidaspost)){
						if(!in_array($materiasprerequisitosesion["materiapapa"][$conprereq], $materiasescogidaspost)){
							echo '<script language="javascript">
							alert("La materia '.$materiasprerequisitosesion["materiapapa"][$conprereq].' debe seleccionarse ya que tiene como corequisito sencillo a '.$materiasprerequisitosesion["materiahija"][$conprereq].'");
							//window.location.href="matriculaautomatica.php?programausadopor='.$_GET['programausadopor'].'";
							</script>';
							exit();
						}
					}
				}
			}
			//exit();
unset($_SESSION["materiascorrequisitosesion"]);

	if(!$ffechapago)
	{
		$permisograbar = false;
	}

	foreach($_POST as $llavepost => $valorpost)
	{
		if(ereg("grupo",$llavepost))
		{
			//echo "$llavepost => $valorpost<br>";
			$codmat = ereg_replace("grupo","",$llavepost);
			$codmatpapa = $_POST['papa'.$codmat.''];
			//echo "papa: $codmatpapa hija: $codmat<br><br>";
			// Se guardan el codigo del grupo para una materia
			$materiascongrupo[$codmat] = $valorpost;
			$materiaspapa[$codmat] = $codmatpapa;
			// $valorpost lleva el idgrupo
			$query_horarioselegidos = "select d.codigodia, d.nombredia, h.horainicial, h.horafinal, s.nombresalon, s.codigosalon,h.idhorario,fechainiciogrupo,fechafinalgrupo
			from horario h, dia d, salon s, grupo g
			where h.codigodia = d.codigodia
			and h.codigosalon = s.codigosalon
			and h.idgrupo = '$valorpost'
			and g.idgrupo = h.idgrupo
			and g.codigoindicadorhorario like '1%'
			order by 1,3,4";
			//echo "$query_horarioselegidos <br> <br>";
			$horarioselegidos=mysql_query($query_horarioselegidos, $sala) or die("$query_horarioselegidos");
			$totalRows_horarioselegidos = mysql_num_rows($horarioselegidos);

			while($row_horarioselegidos = mysql_fetch_array($horarioselegidos))
			{
			  //*** Validacion por horario  E.G.R 2007-06-04  ***//

				/* $query_detallefecha = "select * from horariodetallefecha
				where idhorario = '".$row_horarioselegidos['idhorario']."'";
			    //echo "$query_detallefecha <br> <br>";
			    $detallefecha=mysql_query($query_detallefecha, $sala) or die("$query_detallefecha");
			    $totalRows_detallefecha = mysql_num_rows($detallefecha);
				$row_detallefecha = mysql_fetch_array($detallefecha);
				 if ($row_detallefecha <> "")
				  {
					$iniciogrupo[] = $row_detallefecha['fechadesdehorariodetallefecha'];
					$fingrupo[] =  $row_detallefecha['fechahastahorariodetallefecha'];
				  }
				 else
				  {
				    $iniciogrupo[] = 0;
					$fingrupo[] = 0;
				  } */
				$iniciogrupo[] = $row_horarioselegidos['fechainiciogrupo'];
				$fingrupo[] =  $row_horarioselegidos['fechafinalgrupo'];
			 //*** Validacion por horario FIN E.G.R 2007-06-04 ***//
				$codigomateriahorarios[] = ereg_replace("grupo","",$llavepost);
				$diahorarios[] = $row_horarioselegidos['codigodia'];
				$horainicialhorarios[] = $row_horarioselegidos['horainicial'];
				$horafinalhorarios[] = $row_horarioselegidos['horafinal'];
			}
		}
	}
	//exit();
	// Este for lo va a hacer mientras halla horarios
	/*eecho "<br>codigomateriahorarios <br>";
	print_r($codigomateriahorarios);
	cho "<br>diahorarios <br>";
	print_r($diahorarios);
	echo "<br>horainicialhorarios <br>";

	echo "<pre>";
	print_r($fingrupo);
	print_r($horafinalhorarios);*/
	//echo "<br>horafinalhorarios <br>";
	//print_r($horafinalhorarios);
	//echo "</pre>";
	//echo "<br>";/**/

	$maximohorarios = count($codigomateriahorarios)-1;
	//echo "<br><br>$maximohorarios = count($codigomateriahorarios)-1;<br>";
	for($llavehorario1 = 0; $llavehorario1 <= $maximohorarios; $llavehorario1++)
  	{
   		for($llavehorario2 = 0; $llavehorario2 <= $maximohorarios; $llavehorario2++)
     	{
	  		//echo "if($diahorarios[$llavehorario1] == $diahorarios[$llavehorario2] and $llavehorario1 != $llavehorario2)<br>";
			if($diahorarios[$llavehorario1] == $diahorarios[$llavehorario2] and $llavehorario1 != $llavehorario2)
	    	{
		  		//echo "if((date('H-i-s',strtotime($horainicialhorarios[$llavehorario1])) >= date('H-i-s',strtotime($horainicialhorarios[$llavehorario2])))and(date('H-i-s',strtotime($horainicialhorarios[$llavehorario1])) < date('H-i-s',strtotime($horafinalhorarios[$llavehorario2]))))<br>";
				if((date("H-i-s",strtotime($horainicialhorarios[$llavehorario1])) >= date("H-i-s",strtotime($horainicialhorarios[$llavehorario2])))and(date("H-i-s",strtotime($horainicialhorarios[$llavehorario1])) < date("H-i-s",strtotime($horafinalhorarios[$llavehorario2]))))
		      	{
					//echo $iniciogrupo[$llavehorario1],">=", $iniciogrupo[$llavehorario2],"and",$iniciogrupo[$llavehorario1],"<",$fingrupo[$llavehorario2],"<br>";
					if( (($iniciogrupo[$llavehorario1] >= $iniciogrupo[$llavehorario2])and($iniciogrupo[$llavehorario1] < $fingrupo[$llavehorario2])) or  (($iniciogrupo[$llavehorario2] >= $iniciogrupo[$llavehorario1])and($iniciogrupo[$llavehorario2] < $fingrupo[$llavehorario1])))
					//if(($iniciogrupo[$llavehorario1] >= $iniciogrupo[$llavehorario2])and($iniciogrupo[$llavehorario1] < $fingrupo[$llavehorario2]))
					{
					  //echo $iniciogrupo[$llavehorario1],">=", $iniciogrupo[$llavehorario2],"and",$iniciogrupo[$llavehorario1],"<",$fingrupo[$llavehorario2],"<br>";
					  $permisograbar = false;
						echo '<script language="JavaScript">
							alert("FAVOR VERIFICAR HORARIOS SELECCIONADOS PRESENTA CRUCE ENTRE '.$nombresmateria[$codigomateriahorarios[$llavehorario1]].' Y  '.$nombresmateria[$codigomateriahorarios[$llavehorario2]].'");
						</script>';

				 	$llavehorario1 = $maximohorarios+1;
				 	$llavehorario2 = $maximohorarios+1;
				    }

				}
		   	}
		}
	}
	//exit();
	if($permisograbar)
	{
		//echo "Tiene permiso<br> $fechapago";
		//exit();
		if(isset($_GET['tieneenfasis']))
		{
			$calcularcreditosenfasis = true;
			//echo "CALCULARA CREDITOS<br>";
		}
		else
		{
			$calcularcreditosenfasis = false;
		}
		//exit();
		$procesoautomatico = false;
		if(isset($_GET['lineaunica']))
		{
			$lineaescogida = $_GET['lineaunica'];
		}
		else
		{
			$lineaescogida = "";
		}
		echo "<br>linea".$_GET['lineaunica']."<br>enfasis".$_POST['tieneenfasis']."$calcularcreditosenfasis<br>";
		//exit();
		$ip = tomarip();
		$procesoautomaticotodos = false;
		/*foreach($materiaselegidas as $key => $value)
		{
			echo "<br> $key => $value <br>";
		}*/
		//exit();
		//$usarcondetalleprematricula = false;
		$ruta="../../funciones/";
		require_once("../../funciones/ordenpago/claseordenpago.php");
		$orden = new Ordenpago($sala, $codigoestudiante, $codigoperiodo);
		// Si la generación de la orden se hace para los de pregrado o igual a ellos
		if(ereg("^1.+$",$codigoindicadortipocarrera))
		{
			if(!$orden->valida_ordenmatricula())
			{
				//exit();
		?>
			<script language="javascript">
				history.go(-3);
			</script>
<?php
			}
			else
			{
				//require_once('../../Connections/sap.php' );
				// Si la orden es generada para pregrados se hace lo siguiente

				require("matriculaautomaticaguardar.php");
				//saprfc_close($rfc);
			}
		}
		// Si la generación de la orden se hace para los cursos certificados
		if(ereg("^2.+$",$codigoindicadortipocarrera) && ereg("^1.+$",$row_datosestudiante['codigoreferenciacobromatriculacarrera']))
		{
			if(!$orden->valida_ordenmatriculacursoscertificados())
			{
				//exit();
		?>
			<script language="javascript">
				//alert('Entro');
				history.go(-3);
			</script>
<?php
			}
			else
			{
				//require_once('../../Connections/sap.php' );
				// Si la orden es generada como se hace para pregrados se hace lo siguiente
				echo "No lo encuentra";
				require("matriculaautomaticaguardar.php");
				//saprfc_close($rfc);
			}
		}
		// Si la generación de la orden se hace para los cursos libres
		if(ereg("^3.+$",$codigoindicadortipocarrera))
		{
			if(!$orden->valida_ordenmatriculacursoslibres($materiascongrupo))
			{
				//exit();
		?>
			<script language="javascript">
				history.go(-3);
			</script>
<?php
			}
			else
			{
				//require_once('../../Connections/sap.php' );
				// Si la orden es generada para pregrados se hace lo siguiente
				require("matriculaautomaticaguardar.php");
				//saprfc_close($rfc);
			}
		}
	}
}
?>

<script language="javascript">
function habilitar(campo)
{
	var entro = false;
	for (i = 0; i < campo.length; i++)
	{
		campo[i].disabled = false;
		entro = true;
	}
	if(!entro)
	{
		form1.habilita.disabled = false;
	}
}
var desabilitado=true;
function desabilitarmateria(botonradio,obj,codigomateria){

//document.getElementById(idcampo);
var campo=form1.habilita;
var campomateriapapa=document.getElementById("papa"+codigomateria);
//alert("papa"+codigomateria+" Estado="+campomateriapapa);

var totalcampos=campo.length;
	for (i = 0; i < totalcampos; i++)
	{
		if(campo[i].name==botonradio){
			if(obj.checked){
				campo[i].disabled = true;
				campo[i].checked = false;
				if(campomateriapapa!=null)
				campomateriapapa.disabled=true;
			}
			else{
				//campo[i].checked=true;
				campo[i].disabled = false;
				if(campomateriapapa!=null){
				campomateriapapa.disabled=false;
				campo[i].type = "radio";

				}

			}
			//if(campo[i].checked)

			//else
				//campo[i].checked = true;

		}

	}
//if(campo[i].name==botonradio){

	//}


}

</script>
</body>
</html>
