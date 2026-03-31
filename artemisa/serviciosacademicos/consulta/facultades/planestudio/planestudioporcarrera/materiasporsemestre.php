<?php
require('../../../../Connections/sala2.php');
require_once("../../../../funciones/validacion.php");
require_once("../../../../funciones/errores_plandeestudio.php");
require("../funcionesequivalencias.php");
require("./funciones.php");

mysql_select_db($database_sala, $sala);
session_start();
//require_once('seguridadplandeestudio.php');
if(isset($_GET['planestudio']))
{
	$idplanestudio = $_GET['planestudio'];
	// Para las materias que no son lineas de enfasis
	$idlineaenfasis = 1;
	$estaEnenfasis = "no";
	$idlineamodificar = 1;
}
$formulariovalido = 1;
?>
<html>
<head>
<title>Materias por semestre</title>
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
.Estilo3 {
	font-family: sans-serif;
	font-size: 9px;
	width: 9px;
}
-->
</style>
<?php
echo'<script language="javascript">
function recargar2(dir)
{
	//alert("Va a hacer algo");
	window.location.href="../../materiasgrupos/detallesmateria.php"+dir+"&planestudio='.$idplanestudio.'&visualizado";
}
</script>';
?>
<script language="javascript">
function recargar(dir)
{
	window.location.href="materiasporsemestre.php?"+dir;
	//history.go();
}
</script>
<body>
<div align="center">
<form name="f1" method="post" action="materiasporsemestre.php?planestudio=<?php echo "$idplanestudio";?>">
<?php
// Selecciona toda la informacion del plan de estudio
$query_planestudio = getQueryPlanEstudio($idplanestudio);
$planestudio = mysql_query($query_planestudio, $sala) or die("$query_planestudio");
$row_planestudio = mysql_fetch_assoc($planestudio);
$totalRows_planestudio = mysql_num_rows($planestudio);
if(!isset($_GET['tipodereferencia']) && !isset($_POST['tipodereferencia']))
{
	require_once("pensumseleccionreferencia.php");
}
if(isset($_GET['tipodereferencia']) || isset($_POST['tipodereferencia']))
{
	if(isset($_GET['tipodereferencia']))
	{
		$Vartipodereferencia = $_GET['tipodereferencia'];
		if(!isset($_GET['codigodemateriaanterior']))
		{
			$Varcodigodemateria = $_GET['codigodemateria'];
		}
		else
		{
			$Varcodigodemateria = $_GET['codigodemateriaanterior'];
		}
	}
	if(isset($_POST['tipodereferencia']))
	{
		$Vartipodereferencia = $_POST['tipodereferencia'];
		if(!isset($_POST['codigodemateriaanterior']))
		{
			$Varcodigodemateria = $_POST['codigodemateria'];
		}
		else
		{
			$Varcodigodemateria = $_POST['codigodemateriaanterior'];
		}
	}
	$query_referenciasmateria = "select m.nombremateria
	from materia m
	where m.codigomateria = '$Varcodigodemateria'";
	$referenciasmateria = mysql_query($query_referenciasmateria, $sala) or die("$query_referenciasmateria");
	$row_referenciasmateria = mysql_fetch_assoc($referenciasmateria);
	$totalRows_referenciasmateria = mysql_num_rows($referenciasmateria);

	if($Vartipodereferencia == 100)
	{
		$query_selprerequisitos = "select codigomateriareferenciaplanestudio, fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio
		from referenciaplanestudio
		where idplanestudio = '$idplanestudio'
		and codigomateria = '$Varcodigodemateria'
		and idlineaenfasisplanestudio = '$idlineaenfasis'
		and codigotiporeferenciaplanestudio = '100'";
		$selprerequisitos = mysql_query($query_selprerequisitos, $sala) or die("$query_selprerequisitos");
		$totalRows_selprerequisitos = mysql_num_rows($selprerequisitos);
		//$row_selprerequisitos = mysql_fetch_assoc($selprerequisitos);
		if($totalRows_selprerequisitos != "")
		{
			while($row_selprerequisitos = mysql_fetch_assoc($selprerequisitos))
			{
				$Arregloprerequisitos[] = $row_selprerequisitos;
				$fechainicio = $row_selprerequisitos['fechainicioreferenciaplanestudio'];
				$fechavencimiento = $row_selprerequisitos['fechavencimientoreferenciaplanestudio'];
			}
		}
		else
		{
			$fechainicio = "";
			$fechavencimiento = "";
		}
		if(isset($_GET['editar']) || isset($_POST['editar']))
		{
			if(isset($_GET['editar']))
			{
				$limite = $_GET['editar'];
			}
			if(isset($_POST['editar']))
			{
				$limite = $_POST['editar'];
			}
			require_once("../pensumprerequisitoseditar.php");
		}
		if(isset($_GET['visualizar']) || isset($_POST['visualizar']))
		{
			if(isset($_GET['visualizar']))
			{
				$limite = $_GET['visualizar'];
			}
			if(isset($_POST['visualizar']))
			{
				$limite = $_POST['visualizar'];
			}
			require_once("pensumprerequisitosvisualizar.php");
		}
	}
	// Estos son co-requisitos dobles
	if($Vartipodereferencia == 200)
	{
		// Selecciono los corequisitos que pertenecen a esta materia <=> = Co-requisito
		// Cuando el co-requisito es doble y pertenece a mas de una materia tiene las siguientes propiedades
		// conmutativo a <=> b, a <=> c entonces b <=> c
		// y reflectivo a <=> a, a <=> b, b <=> a

		// Seleccion de los corequisitos cuando la materia es papa
		$query_selcorequisitos = "select codigomateriareferenciaplanestudio, fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio
		from referenciaplanestudio
		where idplanestudio = '$idplanestudio'
		and codigomateria = '$Varcodigodemateria'
		and idlineaenfasisplanestudio = '$idlineaenfasis'
		and codigotiporeferenciaplanestudio = '200'";
		$selcorequisitos = mysql_query($query_selcorequisitos, $sala) or die("$query_selcorequisitos");
		$totalRows_selcorequisitos = mysql_num_rows($selcorequisitos);
		if($totalRows_selcorequisitos != "")
		{
			while($row_selcorequisitos = mysql_fetch_assoc($selcorequisitos))
			{
				$Arreglocorequisitos[] = $row_selcorequisitos;
				$fechainicio = $row_selcorequisitos['fechainicioreferenciaplanestudio'];
				$fechavencimiento = $row_selcorequisitos['fechavencimientoreferenciaplanestudio'];
			}
		}
		else
		{
			$fechainicio = "";
			$fechavencimiento = "";
		}
		// Seleccion de los corequisitos cuando la materia es hija
		// Seleccion de la materia que es papa de esta y de sus respectivos hijos
		$query_selcorequisitopapa = "select codigomateria, fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio
		from referenciaplanestudio
		where idplanestudio = '$idplanestudio'
		and codigomateriareferenciaplanestudio = '$Varcodigodemateria'
		and idlineaenfasisplanestudio = '$idlineaenfasis'
		and codigotiporeferenciaplanestudio = '200'";
		$selcorequisitopapa = mysql_query($query_selcorequisitopapa, $sala) or die("$query_selcorequisitopapa");
		$totalRows_selcorequisitopapa = mysql_num_rows($selcorequisitopapa);

		// Selecciona los corequisitos de los papas y los hace suyos
		// Usa la materia papa para los cambios y se referencia como si fuera ella
		$Varcodigodemateriaanterior = $Varcodigodemateria;
		while($row_selcorequisitopapa = mysql_fetch_assoc($selcorequisitopapa))
		{
			$codigomateriapapa = $row_selcorequisitopapa['codigomateria'];
			$query_selcorequisitos = "select codigomateriareferenciaplanestudio, fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio
			from referenciaplanestudio
			where idplanestudio = '$idplanestudio'
			and codigomateria = '$codigomateriapapa'
			and idlineaenfasisplanestudio = '$idlineaenfasis'
			and codigotiporeferenciaplanestudio = '200'";
			$selcorequisitos = mysql_query($query_selcorequisitos, $sala) or die("$query_selcorequisitos");
			$totalRows_selcorequisitos = mysql_num_rows($selcorequisitos);
			$Varcodigodemateria = $codigomateriapapa;

			if($totalRows_selcorequisitos != "")
			{
				while($row_selcorequisitos = mysql_fetch_assoc($selcorequisitos))
				{
					$Arreglocorequisitos[] = $row_selcorequisitos;
					$fechainicio = $row_selcorequisitos['fechainicioreferenciaplanestudio'];
					$fechavencimiento = $row_selcorequisitos['fechavencimientoreferenciaplanestudio'];
				}
			}
			else
			{
				$fechainicio = "";
				$fechavencimiento = "";
			}
		}
		//$row_selprerequisitos = mysql_fetch_assoc($selprerequisitos);

		if(isset($_GET['editar']) || isset($_POST['editar']))
		{
			if(isset($_GET['editar']))
			{
				$limite = $_GET['editar'];
			}
			if(isset($_POST['editar']))
			{
				$limite = $_POST['editar'];
			}
			require_once("../pensumcorequisitoseditar.php");
		}
		if(isset($_GET['visualizar']) || isset($_POST['visualizar']))
		{
			if(isset($_GET['visualizar']))
			{
				$limite = $_GET['visualizar'];
			}
			if(isset($_POST['visualizar']))
			{
				$limite = $_POST['visualizar'];
			}
			require_once("pensumcorequisitosvisualizar.php");
		}
	}
	if($Vartipodereferencia == 201)
	{
		$query_selcorequisitosencillo = "select codigomateriareferenciaplanestudio, fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio
		from referenciaplanestudio
		where idplanestudio = '$idplanestudio'
		and codigomateria = '$Varcodigodemateria'
		and idlineaenfasisplanestudio = '$idlineaenfasis'
		and codigotiporeferenciaplanestudio = '201'";
		$selcorequisitosencillo = mysql_query($query_selcorequisitosencillo, $sala) or die("$query_selcorequisitosencillo");
		$totalRows_selcorequisitosencillo = mysql_num_rows($selcorequisitosencillo);
		//$row_selprerequisitos = mysql_fetch_assoc($selprerequisitos);
		if($totalRows_selcorequisitosencillo != "")
		{
			while($row_selcorequisitosencillo = mysql_fetch_assoc($selcorequisitosencillo))
			{
				$Arreglocorequisitosencillo[] = $row_selcorequisitosencillo;
				$fechainicio = $row_selcorequisitosencillo['fechainicioreferenciaplanestudio'];
				$fechavencimiento = $row_selcorequisitosencillo['fechavencimientoreferenciaplanestudio'];
			}
		}
		else
		{
			$fechainicio = "";
			$fechavencimiento = "";
		}
		// Seleccion de los corequisitos cuando la materia es hija
		// Seleccion de la materia que es papa de esta y de sus respectivos hijos
		$query_selcorequisitopapa = "select codigomateria, fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio
		from referenciaplanestudio
		where idplanestudio = '$idplanestudio'
		and codigomateriareferenciaplanestudio = '$Varcodigodemateria'
		and idlineaenfasisplanestudio = '$idlineaenfasis'
		and codigotiporeferenciaplanestudio = '201'";
		$selcorequisitopapa = mysql_query($query_selcorequisitopapa, $sala) or die("$query_selcorequisitopapa");
		$totalRows_selcorequisitopapa = mysql_num_rows($selcorequisitopapa);

		// Selecciona los corequisitos de los papas y los hace suyos
		// Usa la materia papa para los cambios y se referencia como si fuera ella
		$Varcodigodemateriaanterior = $Varcodigodemateria;
		while($row_selcorequisitopapa = mysql_fetch_assoc($selcorequisitopapa))
		{
			$codigomateriapapa = $row_selcorequisitopapa['codigomateria'];
			$query_selcorequisitosencillo = "select codigomateriareferenciaplanestudio, fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio
			from referenciaplanestudio
			where idplanestudio = '$idplanestudio'
			and codigomateria = '$codigomateriapapa'
			and idlineaenfasisplanestudio = '$idlineaenfasis'
			and codigotiporeferenciaplanestudio = '201'";
			$selcorequisitosencillo = mysql_query($query_selcorequisitosencillo, $sala) or die("$query_selcorequisitosencillo");
			$totalRows_selcorequisitosencillo = mysql_num_rows($selcorequisitosencillo);
			$Varcodigodemateria = $codigomateriapapa;

			if($totalRows_selcorequisitosencillo != "")
			{
				while($row_selcorequisitosencillo = mysql_fetch_assoc($selcorequisitosencillo))
				{
					$Arreglocorequisitosencillo[] = $row_selcorequisitosencillo;
					$fechainicio = $row_selcorequisitosencillo['fechainicioreferenciaplanestudio'];
					$fechavencimiento = $row_selcorequisitosencillo['fechavencimientoreferenciaplanestudio'];
				}
			}
			else
			{
				$fechainicio = "";
				$fechavencimiento = "";
			}
		}
		if(isset($_GET['editar']) || isset($_POST['editar']))
		{
			if(isset($_GET['editar']))
			{
				$limite = $_GET['editar'];
			}
			if(isset($_POST['editar']))
			{
				$limite = $_POST['editar'];
			}
			require_once("../pensumcorequisitosencilloeditar.php");
		}
		if(isset($_GET['visualizar']) || isset($_POST['visualizar']))
		{
			if(isset($_GET['visualizar']))
			{
				$limite = $_GET['visualizar'];
			}
			if(isset($_POST['visualizar']))
			{
				$limite = $_POST['visualizar'];
			}
			require_once("pensumcorequisitosencillovisualizar.php");
		}
	}
	// Nuevas equivalencias
	//echo "entro aca";
	if($Vartipodereferencia == 300)
	{
		//unset($Arregloequivalencias);
		$query_selequivalencias = "select codigomateriareferenciaplanestudio, fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio
		from referenciaplanestudio
		where idplanestudio = '$idplanestudio'
		and codigomateria = '$Varcodigodemateria'
		and idlineaenfasisplanestudio = '$idlineaenfasis'
		and codigotiporeferenciaplanestudio = '300'";
		$selequivalencias = mysql_query($query_selequivalencias, $sala) or die("$query_selequivalencias");
		$totalRows_selequivalencias = mysql_num_rows($selequivalencias);
		//echo "$query_selequivalencias<br>";
		//$row_selequivalencias = mysql_fetch_assoc($selequivalencias);
		if($totalRows_selequivalencias != "")
		{
			while($row_selequivalencias = mysql_fetch_assoc($selequivalencias))
			{
				//echo "$query_selequivalencias<br>";
				$Arregloequivalencias[] = $row_selequivalencias['codigomateriareferenciaplanestudio'];
				$fechainicio = $row_selequivalencias['fechainicioreferenciaplanestudio'];
				$fechavencimiento = $row_selequivalencias['fechavencimientoreferenciaplanestudio'];
			}
		}
		else
		{
			$fechainicio = "";
			$fechavencimiento = "";
		}
		if(isset($_GET['editar']) || isset($_POST['editar']))
		{
			if(isset($_GET['editar']))
			{
				$limite = $_GET['editar'];
			}
			if(isset($_POST['editar']))
			{
				$limite = $_POST['editar'];
			}
			require_once("../pensumequivalenciaseditar.php");
		}
		if(isset($_GET['visualizar']) || isset($_POST['visualizar']))
		{
			if(isset($_GET['visualizar']))
			{
				$limite = $_GET['visualizar'];
			}
			if(isset($_POST['visualizar']))
			{
				$limite = $_POST['visualizar'];
			}
			require_once("pensumequivalenciasvisualizar.php");
		}
	}
}

if(isset($_POST['aceptarprerequisitos']) && $formulariovalido == 1)
{
	$tieneprerequisitos = false;
	//echo  $_POST['codigoprerequisito']."sda<br>";

	// Lee las materias que vienen por el post
	foreach($_POST as $key => $materiareferencia)
	{
		if(ereg("^prerequisito",$key))
		{
			$prerequisitosescogidos[] = $materiareferencia;
			/*echo "$key => $valor <br>";
			$idmateria = ereg_replace("prerequisito","",$materiareferencia);
			echo $idmateria."<br>";*/
			$tieneprerequisitos = true;
		}
		//echo "<br>$key => $materiareferencia <br>";
	}
	if(!$tieneprerequisitos)
	{
?>
	<script language="javascript">
	if(!confirm("¿Desea dejar sin prerequisitos a la materia?"))
	{
		history.go(-1);
	}
	</script>
<?php
	}
	// Elimina todas las materias prerequisitos de $_POST['codigodemateria'].
	$query_delreferenciaplanestudio = "DELETE FROM referenciaplanestudio
	WHERE idplanestudio = '$idplanestudio'
	and idlineaenfasisplanestudio = '$idlineaenfasis'
	and codigomateria = '".$_POST['codigodemateria']."'
	and codigotiporeferenciaplanestudio like '1%'";
	$delreferenciaplanestudio = mysql_query($query_delreferenciaplanestudio, $sala) or die("$query_delreferenciaplanestudio");

	//Inserta las materias que vienen por el post que son prerequisitos de $_POST['codigodemateria']
	if($tieneprerequisitos)
	{
		foreach($prerequisitosescogidos as $key => $materiareferencia2)
		{
			$query_insreferenciaplanestudio = "INSERT INTO referenciaplanestudio(idplanestudio, idlineaenfasisplanestudio, codigomateria, codigomateriareferenciaplanestudio, codigotiporeferenciaplanestudio, fechacreacionreferenciaplanestudio, fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio, codigoestadoreferenciaplanestudio)
			VALUES('$idplanestudio', '$idlineaenfasis', '".$_POST['codigodemateria']."', '$materiareferencia2', '100', '".date("Y-m-d")."', '".$_POST['finicioprerequisito']."', '".$_POST['fvencimientoprerequisito']."', '101')";
			$insreferenciaplanestudio = mysql_query($query_insreferenciaplanestudio, $sala) or die("$query_insreferenciaplanestudio");
		}
	}
	echo '<script language="javascript">
	window.location.href="materiasporsemestre.php?planestudio='.$idplanestudio.'&codigodemateria='.$Varcodigodemateria.'&tipodereferencia='.$Vartipodereferencia.'&visualizar='.$limite.'&lineaenfasis='.$idlineaenfasis.'";
	</script>';
}
if(isset($_POST['aceptarcorequisitos']) && $formulariovalido == 1)
{
	$tienecorequisitos = false;
	//echo  $_POST['codigoprerequisito']."sda<br>";

	// Lee las materias que vienen por el post
	foreach($_POST as $key => $materiareferencia)
	{
		if(ereg("^corequisito",$key))
		{
			$corequisitosescogidos[] = $materiareferencia;
			/*echo "$key => $valor <br>";
			$idmateria = ereg_replace("prerequisito","",$materiareferencia);
			echo $idmateria."<br>";*/
			$tienecorequisitos = true;
		}
		//echo "<br>$key => $materiareferencia <br>";
	}
	if(!$tienecorequisitos)
	{
?>
	<script language="javascript">
	if(!confirm("¿Desea dejar sin corequisitos a la materia?"))
	{
		history.go(-1);
	}
	</script>
<?php
	}
	// Elimina todas las materias corequisitos de $_POST['codigodemateria'].
	$query_delreferenciaplanestudio = "DELETE FROM referenciaplanestudio
	WHERE idplanestudio = '$idplanestudio'
	and idlineaenfasisplanestudio = '$idlineaenfasis'
	and codigomateria = '".$_POST['codigodemateria']."'
	and codigotiporeferenciaplanestudio like '200%'";
	$delreferenciaplanestudio = mysql_query($query_delreferenciaplanestudio, $sala) or die("$query_delreferenciaplanestudio");

	//Inserta las materias que vienen por el post que son prerequisitos de $_POST['codigodemateria']
	if($tienecorequisitos)
	{
		foreach($corequisitosescogidos as $key => $materiareferencia2)
		{
			$query_insreferenciaplanestudio = "INSERT INTO referenciaplanestudio(idplanestudio, idlineaenfasisplanestudio, codigomateria, codigomateriareferenciaplanestudio, codigotiporeferenciaplanestudio, fechacreacionreferenciaplanestudio, fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio, codigoestadoreferenciaplanestudio)
			VALUES('$idplanestudio', '$idlineaenfasis', '".$_POST['codigodemateria']."', '$materiareferencia2', '200', '".date("Y-m-d")."', '".$_POST['finiciocorequisito']."', '".$_POST['fvencimientocorequisito']."', '101')";
			$insreferenciaplanestudio = mysql_query($query_insreferenciaplanestudio, $sala) or die("$query_insreferenciaplanestudio");
		}
	}
	echo '<script language="javascript">
	window.location.href="materiasporsemestre.php?planestudio='.$idplanestudio.'&codigodemateria='.$_POST['codigodemateriaanterior'].'&tipodereferencia='.$Vartipodereferencia.'&visualizar='.$limite.'&lineaenfasis='.$idlineaenfasis.'";
	</script>';
}
if(isset($_POST['aceptarcorequisitosencillo']) && $formulariovalido == 1)
{
	$tienecorequisitosencillo = false;
	//echo  $_POST['codigoprerequisito']."sda<br>";

	// Lee las materias que vienen por el post
	foreach($_POST as $key => $materiareferencia)
	{
		if(ereg("^cosencillo",$key))
		{
			$corequisitosescogidosencillo[] = $materiareferencia;
			/*echo "$key => $valor <br>";
			$idmateria = ereg_replace("prerequisito","",$materiareferencia);
			echo $idmateria."<br>";*/
			$tienecorequisitosencillo = true;
		}
		//echo "<br>$key => $materiareferencia <br>";
	}
	if(!$tienecorequisitosencillo)
	{
?>
	<script language="javascript">
	if(!confirm("¿Desea dejar sin corequisitos sencillos a la materia?"))
	{
		history.go(-1);
	}
	</script>
<?php
	}
	// Elimina todas las materias corequisitos de $_POST['codigodemateria'].
	$query_delreferenciaplanestudio = "DELETE FROM referenciaplanestudio
	WHERE idplanestudio = '$idplanestudio'
	and idlineaenfasisplanestudio = '$idlineaenfasis'
	and codigomateria = '".$_POST['codigodemateria']."'
	and codigotiporeferenciaplanestudio like '201%'";
	$delreferenciaplanestudio = mysql_query($query_delreferenciaplanestudio, $sala) or die("$query_delreferenciaplanestudio");

	//Inserta las materias que vienen por el post que son prerequisitos de $_POST['codigodemateria']
	if($tienecorequisitosencillo)
	{
		foreach($corequisitosescogidosencillo as $key => $materiareferencia2)
		{
			$query_insreferenciaplanestudio = "INSERT INTO referenciaplanestudio(idplanestudio, idlineaenfasisplanestudio, codigomateria, codigomateriareferenciaplanestudio, codigotiporeferenciaplanestudio, fechacreacionreferenciaplanestudio, fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio, codigoestadoreferenciaplanestudio)
			VALUES('$idplanestudio', '$idlineaenfasis', '".$_POST['codigodemateria']."', '$materiareferencia2', '201', '".date("Y-m-d")."', '".$_POST['finiciocorequisito']."', '".$_POST['fvencimientocorequisito']."', '101')";
			$insreferenciaplanestudio = mysql_query($query_insreferenciaplanestudio, $sala) or die("$query_insreferenciaplanestudio");
		}
	}
	echo '<script language="javascript">
	window.location.href="materiasporsemestre.php?planestudio='.$idplanestudio.'&codigodemateria='.$Varcodigodemateria.'&tipodereferencia='.$Vartipodereferencia.'&visualizar='.$limite.'&lineaenfasis='.$idlineaenfasis.'";
	</script>';
}
if(isset($_POST['aceptarequivalencias']) && $formulariovalido == 1)
{
	$tieneequivalencias = false;
	//echo  $_POST['codigoprerequisito']."sda<br>";

	// Lee las materias que vienen por el post
	// Lee las materias que vienen por el post
	if(isset($_POST['equivalencia']))
	{
		foreach($_POST['equivalencia'] as $key => $materiareferencia)
		{

			$equivalenciasescogidas[] = $materiareferencia;
			/*echo "$key => $valor <br>";
			$idmateria = ereg_replace("prerequisito","",$materiareferencia);
			echo $idmateria."<br>";*/
			$tieneequivalencias = true;
		}
	}
	if(!$tieneequivalencias)
	{
?>
	<script language="javascript">
	if(!confirm("¿Desea dejar sin equivalencias a la materia?"))
	{
		history.go(-1);
	}
	</script>
<?php
	}
	// Elimina todas las materias equivalentes
	$query_delreferenciaplanestudio = "DELETE FROM referenciaplanestudio
	WHERE idplanestudio = '$idplanestudio'
	and idlineaenfasisplanestudio = '$idlineaenfasis'
	and codigomateria = '".$_POST['codigodemateria']."'
	and codigotiporeferenciaplanestudio like '3%'";
	$delreferenciaplanestudio = mysql_query($query_delreferenciaplanestudio, $sala) or die("$query_delreferenciaplanestudio");

	//Inserta las materias que vienen por el post que son equivalentes de $_POST['codigodemateria']
	if($tieneequivalencias)
	{
		foreach($equivalenciasescogidas as $key => $materiareferencia2)
		{
			$query_insreferenciaplanestudio = "INSERT INTO referenciaplanestudio(idplanestudio, idlineaenfasisplanestudio, codigomateria, codigomateriareferenciaplanestudio, codigotiporeferenciaplanestudio, fechacreacionreferenciaplanestudio, fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio, codigoestadoreferenciaplanestudio)
			VALUES('$idplanestudio', '$idlineaenfasis', '".$_POST['codigodemateria']."', '$materiareferencia2', '300', '".date("Y-m-d")."', '".$_POST['finiciocorequisito']."', '".$_POST['fvencimientocorequisito']."', '101')";
			$insreferenciaplanestudio = mysql_query($query_insreferenciaplanestudio, $sala) or die("$query_insreferenciaplanestudio");
		}
	}
	echo '<script language="javascript">
	window.location.href="materiasporsemestre.php?planestudio='.$idplanestudio.'&codigodemateria='.$Varcodigodemateria.'&tipodereferencia='.$Vartipodereferencia.'&visualizar='.$limite.'&lineaenfasis='.$idlineaenfasis.'";
	</script>';
}
?>
</form>
</div>
</body>
<?php
echo '<script language="javascript">
	function cancelarfiltro()
	{
		window.location.href="../visualizarplandeestudio.php?planestudio='.$idplanestudio.'";
	}
	</script>';
?>
<script language="javascript">
//Mueve las opciones seleccionadas en listaFuente a listaDestino
function regresarinicio()
{
	window.location.href="planestudiomodalidad.php"
}

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
		f1.habilita.disabled = false;
	}
}
</script>
</html>
