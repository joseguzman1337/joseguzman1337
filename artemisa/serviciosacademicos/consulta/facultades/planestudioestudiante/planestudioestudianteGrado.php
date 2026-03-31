<?php
session_start();
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);



$txtValidaMateria = $_POST["validarMateria"];
if( $txtValidaMateria != "1" ){


$nombrearchivo = 'planestudio';
require_once('../../../Connections/sala2.php');
$conimagen = true;
if(isset($_REQUEST['formato']))
{
	$conimagen = false;
	$formato = $_REQUEST['formato'];
	$formato = 'doc';
	switch ($formato)
	{
		case 'xls' :
			$strType = 'application/msexcel';
			$strName = $nombrearchivo.".xls";
			break;
		case 'doc' :
			$strType = 'application/msword';
			$strName = $nombrearchivo.".doc";
			break;
		case 'txt' :
			$strType = 'text/plain';
			$strName = $nombrearchivo.".txt";
			break;
		case 'csv' :
			$strType = 'text/plain';
			$strName = $nombrearchivo.".csv";
			break;
		case 'xml' :
			$strType = 'text/plain';
			$strName = $nombrearchivo.".xml";
			break;
		default :
			$strType = 'application/msexcel';
			$strName = $nombrearchivo.".xls";
			break;
	}
	header("Content-Type: $strType");
	header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	//header("Cache-Control: no-store, no-cache");
	header("Pragma: public");
}

$rutaado = "../../../funciones/adodb/";
require_once('../../../funciones/sala/nota/nota.php');
require_once('../../../funciones/sala/estudiante/generarCarga.php');
//$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php');

/* Llamado a las clases necesarias */
require_once('../../../funciones/sala/planestudio/planestudio.php');
require_once('../../../funciones/sala/planestudio/planestudioestudiante.php');
require_once('../../../funciones/sala/planestudio/detalleplanestudio.php');
require_once('../../../funciones/datosestudiante.php');

//print_r($_REQUEST);
$codigoestudiante = $_REQUEST['codigoestudiante'];
$planestudioestudiante = new planestudioestudiante($codigoestudiante);
$planestudio = new planestudio($planestudioestudiante->idplanestudio);
$materiascarga = generarCarga($codigoestudiante);
//echo "3<br/>";print_r($_REQUEST);
if(isset($materiascarga['aprobadas']))
{
	foreach($materiascarga['aprobadas'] as $materia)
	{
		$notadefinitiva = obtenerNota($codigoestudiante, $materia['codigomateria'], $planestudioestudiante->idplanestudio);
		$materiasaprobadas[$materia['codigomateria']] = $notadefinitiva;
	}
}
if(isset($materiascarga['cargapropuesta']))
{
	foreach($materiascarga['cargapropuesta'] as $materia)
	{
		$notadefinitiva = obtenerNota($codigoestudiante, $materia['codigomateria'], $planestudioestudiante->idplanestudio);
		$materiaspropuestas[$materia['codigomateria']] = $notadefinitiva;
	}
}
if(isset($materiascarga['cargaobligatoria']))
{
	foreach($materiascarga['cargaobligatoria'] as $indice => $codigomateria)
	{
		$notadefinitiva = obtenerNota($codigoestudiante, $codigomateria, $planestudioestudiante->idplanestudio);
		$materiasobligatorias[$codigomateria] = $notadefinitiva;
	}
}
//echo "6<br/>";print_r($_REQUEST);
$materiasfinal['aprobadas'] = $materiasaprobadas;
$materiasfinal['cargapropuesta'] = $materiaspropuestas;
$materiasfinal['cargaobligatoria'] = $materiasobligatorias;
//echo "<pre>"; print_r($materiasfinal); echo "</pre>";
//print_r($materiafinal);
//exit();
?>
<html>
<head>
<title>Plan Estudio del Estudiante</title>
<?php
if(isset($_REQUEST['debug']))
	$db->debug = true;

if(!isset($_REQUEST['formato']))
{
?>
 <link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php
}
?>
<script type="text/javascript" src="../../../funciones/sala/js/overlib/overlib.js"></script>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<?php
datosestudiante($codigoestudiante,$sala,$database_sala,"../../../../imagenes/estudiantes/");
//$planestudio->mostrarPlanEstudio();
?>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="100%">
<tr align="center">
<?php
// Aca debe mostrar los semestres del plan de estudios
$cuentasemestre = 1;
$filas = 0;
while ($planestudio->cantidadsemestresplanestudio >= $cuentasemestre) :
	$query_cojematerias = "select d.codigomateria, m.nombremateria, m.numerohorassemanales, d.numerocreditosdetalleplanestudio, d.codigotipomateria
	from detalleplanestudio d, materia m
	where d.idplanestudio = '$planestudio->idplanestudio'
	and d.semestredetalleplanestudio = '$cuentasemestre'
	and m.codigomateria = d.codigomateria
	and m.codigotipomateria != 4
	and d.codigotipomateria != 4";
	$cojematerias = $db->Execute($query_cojematerias);
	$totalRows_cojematerias = $cojematerias->RecordCount();
	$maximonuevo = 0;
	while($row_cojematerias = $cojematerias->FetchRow())
	{
		if($row_cojematerias['codigotipomateria'] != 5)
		{
			$detalleplanestudio[$cuentasemestre][] = new detalleplanestudio($planestudio->idplanestudio, $row_cojematerias['codigomateria']);
			$maximonuevo++;
		}
		else
		{
			//$db->debug = true;
			$query_materiahija = "select d.idlineaenfasisplanestudio, d.codigomateriadetallelineaenfasisplanestudio as codigomateria,
			m.nombremateria, d.numerocreditosdetallelineaenfasisplanestudio, d.codigotipomateria,
			m.numerohorassemanales, d.semestredetallelineaenfasisplanestudio
			from detallelineaenfasisplanestudio d, materia m
			where d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria
			and d.idlineaenfasisplanestudio = '$planestudioestudiante->idlineaenfasisplanestudio'
			and d.idplanestudio = '$planestudio->idplanestudio'
			and d.codigomateria = '".$row_cojematerias['codigomateria']."'";
			$materiahija = $db->Execute($query_materiahija);
			$totalRows_materiahija = $materiahija->RecordCount();
			if($totalRows_materiahija != "")
			{
				while($row_materiahija = $materiahija->FetchRow())
				{
					$detalleplanestudio[$cuentasemestre][] = new detalleplanestudio($planestudio->idplanestudio, $row_materiahija['codigomateria'], $row_materiahija['idlineaenfasisplanestudio']);
					$maximonuevo++;
				}
			}
			else
			{
				$detalleplanestudio[$cuentasemestre][] = new detalleplanestudio($planestudio->idplanestudio, $row_cojematerias['codigomateria']);
				$maximonuevo++;
			}
		}
	}
	if($filas < $maximonuevo)
		$filas = $maximonuevo;
?>
<td><?php echo $cuentasemestre; ?></td>
<?php
	$cuentasemestre++;
endwhile;
?>
</tr>
<?php
// Funcion que llama los horarios para cada materia
require_once('horarios.php');

// Ubica una materia de cada semestre en la fila correspondiente
$cuentafilas = 1;
for($cuentafilas = 1; $cuentafilas <= $filas; $cuentafilas++):
?>
<tr>
<?php
	$cuentasemestre = 1;
	//$notafinal[$cuentasemestre] = 0;
	//$cuentamateriassemestre[$cuentasemestre] = 0;
	$acumulacreditos = 0;
	while($planestudio->cantidadsemestresplanestudio >= $cuentasemestre) :
		$nota = "";
		$credito = "";
?>
<td valign="top">
<?php
		if(isset($detalleplanestudio[$cuentasemestre][$cuentafilas - 1]))
		{
			// Selecciona los horarios y los mete en el mensaje
			if(isset($_SESSION['codigoperiodosesion']))
				$mensajemateria = getHorario($detalleplanestudio[$cuentasemestre][$cuentafilas - 1]->codigomateria, $_SESSION['codigoperiodosesion'], $_SESSION['codigo']);

			$detalleplanestudio[$cuentasemestre][$cuentafilas - 1]->mostrarDetallePlanEstudioEstudiante($materiasfinal, $conimagen);
			//echo "$nota - $credito";
			if($nota != "" && $credito != "")
			{
				$creditos[$cuentasemestre] += $credito;
				//$notas[$cuentasemestre] += $nota;
				$notafinal[$cuentasemestre] += $nota*$credito;
				$cuentamateriassemestre[$cuentasemestre]++;
			}
		}
		else
		{
			echo "&nbsp;";
		}
		$cuentasemestre++;
?>
</td>
<?php
	endwhile;
?>
</tr>
<?php
endfor;
?>
<tr>
<?php
$cuentasemestre = 1;
while($planestudio->cantidadsemestresplanestudio >= $cuentasemestre) :
?>
<td valign="top">
<?php
    $notaf = 0;
    $acumf = 0;
	if($creditos[$cuentasemestre] != 0)
	{
		$acumulacreditos += $creditos[$cuentasemestre];
		$acumulanotas += $notafinal[$cuentasemestre];
        $notaf = $notafinal[$cuentasemestre]/$creditos[$cuentasemestre];
        $arrayNotaf = explode(".",$notaf);
        $arrayNotaf[1] = substr($arrayNotaf[1],0,2);
        $acumf = $acumulanotas/$acumulacreditos;
        $arrayAcumf = explode(".",$acumf);
        $arrayAcumf[1] = substr($arrayAcumf[1],0,2);
?>
	<table border="1" cellpadding="1" cellspacing="0" style="font-size: 8px;" height="30px" width="100%">
        <tr id="trtitulogirs" bgcolor="#000000" style="color: #FFFFFF">
          <td width="34%"><?php echo $arrayNotaf[0].".".$arrayNotaf[1]; ?></td>
          <td width="33%" align="center"><?php echo $creditos[$cuentasemestre];?></td>
          <td width="33%" align="right"><?php echo $cuentamateriassemestre[$cuentasemestre];?></td>
	    </tr>
        <tr style="font: bold;">
          <td colspan="3" align="center"><label><?php echo $arrayAcumf[0].".".$arrayAcumf[1];?></label>
          &nbsp;
          </td>
        </tr>
    </table>
<?php
	}
	else
		echo "&nbsp;";
	$cuentasemestre++;
?>
</td>
<?php
endwhile;

//echo "<b>sdasd".round(3.94,1);
?>
</tr>
<tr>
<td colspan="2">
<table border="1" cellpadding="1" cellspacing="0" style="font-size: 8px;" height="30px" width="20%">
        <tr id="trtitulogirs" bgcolor="#000000" style="color: #FFFFFF">
          <td width="34%">Promedio Ponderado semestral</td>
          <td width="33%" align="center">Nº de Créditos vistos</td>
          <td width="33%" align="right">Materias Vistas</td>
	    </tr>
        <tr style="font: bold;">
          <td colspan="3" align="center">Promedio Ponderado Acumulado
          &nbsp;
          </td>
        </tr>
    </table>
</td>

<?php
require_once('../registro_graduados/carta_egresados/functionsElectivasPendientes.php');
$query = getQueryMateriasElectivasCPEstudiante($_REQUEST['codigoestudiante']);
$materias = mysql_query($query, $sala) or die(mysql_error());
$totalRows = mysql_num_rows($materias);
$creditosVistos = 0;
if($totalRows > 0) {
	while($row_materias=mysql_fetch_assoc($materias)) 
		$creditosVistos+=$row_materias['numerocreditos'];
}
		//$creditosVistos=2;

$query_creditoselectivos = getCreditosElectivasPlanEstudio($_REQUEST['codigoestudiante'],null,true);
$creditosPlanEstudio = mysql_query($query_creditoselectivos, $sala) or die(mysql_error());
if(mysql_num_rows($creditosPlanEstudio) > 0) {
	$creditosPlanEstudio=mysql_fetch_assoc($creditosPlanEstudio);
	$creditosPlanEstudio=$creditosPlanEstudio["creditos"];
} else {
	$creditosPlanEstudio = 0;
}

$sobreacreditacion=0;
if($creditosPlanEstudio==NULL) {
	$creditosFaltantes=0;
} elseif($creditosPlanEstudio<$creditosVistos) {
	$creditosFaltantes=0;
	$sobreacreditacion=$creditosVistos-$creditosPlanEstudio;
} else {
	$creditosFaltantes=$creditosPlanEstudio-$creditosVistos;
}
?>
<td colspan="3">
    <table border="1" cellpadding="1" cellspacing="0" style="font-size: 12px;" height="30px" width="60%" align="center">
        <tr>
          <td width="80%" bgcolor="#000000" style="color: #FFFFFF">Cr&eacute;ditos de electivas libres vistos</td>
          <td width="20%" align="center"><?php echo ($creditosVistos==0)?$creditosVistos:"<a href='materiaselectivasplanestudioestudiante.php?cod_estudiante=".$_REQUEST['codigoestudiante']."&solomaterias=true' target='_blank' onClick=\"window.open(this.href, this.target, 'width=800,height=300'); return false;\">".$creditosVistos."</a>"?></td>
	</tr>
        <tr>
          <td width="80%" bgcolor="#000000" style="color: #FFFFFF">Cr&eacute;ditos de electivas libres faltantes</td>
          <td width="20%" align="center"><?php echo $creditosFaltantes?></td>
	</tr>
<?php
	if($sobreacreditacion>0) {
?>
		<tr>
		  <td width="80%" bgcolor="#000000" style="color: #FFFFFF">Sobreacreditaci&oacute;n de electivas</td>
		  <td width="20%" align="center"><?php echo $sobreacreditacion?></td>
		</tr>
<?php
	}
?>
    </table>
</td>

<td colspan="5">
<table border="0" cellpadding="1" cellspacing="0" style="font-size: 8px;" height="30px" width="20%">
        <tr id="trtitulogirs" bgcolor="#4a9339" style="color: #FFFFFF">
          <td>Aprobada</td>
          <td></td>
          <td align="right">A <?php if($conimagen) { ?><img src="aprobada.png" width="10px" heigth="10px"> <?php } ?></td>
	    </tr>
        <tr id="trtitulogirs" bgcolor="#d25400" style="color: #FFFFFF">
          <td>En Curso</td>
          <td></td>
          <td align="right">C <?php if($conimagen) { ?><img src="cursada.png" width="10px" heigth="10px"> <?php } ?></td>
	    </tr>
	    <tr id="trtitulogirs" bgcolor="#ac0000" style="color: #FFFFFF">
          <td>Pendiente</td>
          <td></td>
          <td align="right">P <?php if($conimagen) { ?><img src="pendiente.png" width="10px" heigth="10px"> <?php } ?></td>
	    </tr>
	    <tr id="trtitulogirs" bgcolor="#858200" style="color: #FFFFFF">
          <td>Por Matricula</td>
          <td></td>
          <td align="right">M <?php if($conimagen) { ?><img src="matriculada.png" width="10px" heigth="10px"> <?php } ?></td>
	    </tr>
    </table>
 </td>
</tr>
</table>
<?php
if(!isset($_REQUEST['formato']))
{
?>
	<input type="submit" name="formato" value="Exportar Doc">
	<input type="button" name="ver_materias" value="Syllabus y contenido materias electivas" OnClick="window.open('materiaselectivasplanestudioestudiante.php?cod_estudiante=<?php echo $codigoestudiante?>','_blank','resizable=no,width=800,height=300,scrollbars=YES')">
	<input type="button" name="Imprimir" value="Imprimir" onclick="window.print()">
<?php
}
?>
</form>
</body>
</html>
<?php 
}else{ ?>
	<div align="center">
		<br />
		<span><strong>El estudiante ha completado todo su plan de estudio</strong></span>
	</div>
<?php }
?>