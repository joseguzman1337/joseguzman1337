<?php
session_start();
if(!isset($_SESSION['MM_Username']))
{
	echo "<h1>Usted no está autorizado para ver esta página</h1>";
	exit();
}
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
//error_reporting(2047);
?>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
</STYLE>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<!--<a href="menu.php">Atrás</a>-->
<?php
$fechahoy=date("Y-m-d H:i:s");
$rutaado=("../../funciones/adodb/");
require_once('../../Connections/salaado-pear.php');
require_once("../../funciones/clases/motorv2/motor.php");
require_once("../../funciones/clases/formulariov2/clase_formulario.php");
require_once("funciones/calendarioSalones.php");
$codigoperiodo=20071;
if($_GET['depurar']=='si')
{
	$depurar=true;
	$sala->debug=true;
}
else
{
	$depurar=false;
}

$fechadesdehorariodetallefecha=$_GET['fechaini'];
$fechahastahorariodetallefecha=$_GET['fechafin'];

if(empty($fechadesdehorariodetallefecha) or empty($fechahastahorariodetallefecha))
{
	echo "<h1>No hay fecha inicio o fecha final. No se puede continuar</h1>";
	exit();
}

$codigosalon=$_GET['codigosalon'];
if(empty($codigosalon))
{
	echo "<h1>No hay codigosalon</h1>";
	exit();
}

$codigoperiodo=$_SESSION['codigoperiodosesion'];
if(empty($codigoperiodo))
{
	echo "<h1>No se ha seleccionado el periodo. No se puede continuar</h1>";
	exit();
}


list($ano_ini,$mes_ini,$dia_ini)=explode("-",$fechadesdehorariodetallefecha);
list($ano_fin,$mes_fin,$dia_fin)=explode("-",$fechahastahorariodetallefecha);

if($ano_ini<>$ano_fin)
{
	echo "El rango de fechas debe estar dentro del mismo año";
	exit();
}

$contador=0;
for($mes = $mes_ini; $mes<=$mes_fin; $mes++)
{
	$ultimodiames=devuelveUltimoDiadelMes($mes,$ano_ini);
	for ($dia = $dia_ini; $dia <= $dia_fin; $dia++)
	{
		if($numerodia==0)
		{
			$timestamp=mktime(0,0,0,$mes,$dia,$ano_ini);
			$fecha=date("Y-m-d",$timestamp);
			$array_fechas[$contador]['fecha']=$fecha;
			$contador++;
		}
	}
}

?>
<body>
<?php 
$contador=0;
$array_rango_horas=generaRangosEstandar();
foreach ($array_rango_horas as $llave_h => $valor_h)
{
	foreach ($array_fechas as $llave_d => $valor_d)
	{
		$horario=obtenerHorarioSalonconHorariodetallefecha($sala,$codigoperiodo,$codigosalon,$valor_d['fecha'],$valor_h['hora_ini'],$valor_h['hora_fin']);
		if(is_array($horario))
		{
			$array_horarios[$contador]['fecha']=$valor_d['fecha'];
			$array_horarios[$contador]['hora_ini']=$valor_h['hora_ini'];
			$array_horarios[$contador]['hora_fin']=$valor_h['hora_fin'];
			$array_horarios_bd[$contador]=$horario;
			$contador++;
		}
	}
}
$array_horarios=SumaArreglosBidimensionalesDelMismoTamano($array_horarios,$array_horarios_bd);
$motor = new matriz($array_horarios,"Horarios Salón $codigosalon desde $fechadesdehorariodetallefecha hasta $fechahastahorariodetallefecha","listado.php?fechaini=$fechadesdehorariodetallefecha&fechafin=$fechahastahorariodetallefecha&codigosalon=$codigosalon","si","si","menu.php","listado.php?fechaini=$fechadesdehorariodetallefecha&fechafin=$fechahastahorariodetallefecha&codigosalon=$codigosalon",false,"si");
$motor->asignarWrap("wrap");
//$motor->asignarCeldasRedimensionables("100px");
$motor->archivo_origen_con_get=true;
$motor->jsVarios();
$motor->mostrar();

?>
<?php
function devuelveUltimoDiadelMes($mes,$ano)
{
	$ultimo_dia=28;
	while (checkdate($mes,$ultimo_dia + 1,$ano))
	{
		$ultimo_dia++;
	}
	return $ultimo_dia;
}
function generaRangosEstandar()
{
	$array_rangos[]=array('hora_ini'=>'07:00:00','hora_fin'=>'08:00:00');
	$array_rangos[]=array('hora_ini'=>'08:00:00','hora_fin'=>'09:00:00');
	$array_rangos[]=array('hora_ini'=>'09:00:00','hora_fin'=>'10:00:00');
	$array_rangos[]=array('hora_ini'=>'10:00:00','hora_fin'=>'11:00:00');
	$array_rangos[]=array('hora_ini'=>'11:00:00','hora_fin'=>'12:00:00');
	$array_rangos[]=array('hora_ini'=>'12:00:00','hora_fin'=>'13:00:00');
	$array_rangos[]=array('hora_ini'=>'13:00:00','hora_fin'=>'14:00:00');
	$array_rangos[]=array('hora_ini'=>'14:00:00','hora_fin'=>'15:00:00');
	$array_rangos[]=array('hora_ini'=>'15:00:00','hora_fin'=>'16:00:00');
	$array_rangos[]=array('hora_ini'=>'16:00:00','hora_fin'=>'17:00:00');
	$array_rangos[]=array('hora_ini'=>'17:00:00','hora_fin'=>'18:00:00');
	$array_rangos[]=array('hora_ini'=>'18:00:00','hora_fin'=>'19:00:00');
	$array_rangos[]=array('hora_ini'=>'19:00:00','hora_fin'=>'20:00:00');
	$array_rangos[]=array('hora_ini'=>'20:00:00','hora_fin'=>'21:00:00');
	$array_rangos[]=array('hora_ini'=>'21:00:00','hora_fin'=>'22:00:00');
	return $array_rangos;
}
function obtenerHorarioSalonconHorariodetallefecha(&$conexion,$codigoperiodo,$codigosalon,$fecha,$hora_ini,$hora_fin)
{
	list($ano,$mes,$dia)=explode("-",$fecha);

	$codigodia_calendario=devuelveNumeroDiadelaSemana($dia,$mes,$ano);

	$codigodia_bd=$codigodia_calendario+1;

	$query="SELECT
		g.codigoperiodo,	
		h.codigosalon,
		c.nombrecarrera,
		m.nombremateria,
		h.idhorario,
		hdf.idhorariodetallefecha,
		h.idgrupo,
		h.codigodia,
		d.nombredia,
		DATE_FORMAT(hdf.fechadesdehorariodetallefecha,'%Y-%c-%e') AS fechadesdehorariodetallefecha,
		DATE_FORMAT(hdf.fechahastahorariodetallefecha,'%Y-%c-%e') AS fechahastahorariodetallefecha,
		h.horainicial,
		h.horafinal,
		ts.nombretiposalon,
		s.codigotiposalon,
		se.nombresede,
		se.codigosede,
		h.codigoestado,
		g.idgrupo,
		m.codigomateria,
		m.codigocarrera
		FROM
		horario h, dia d, grupo g, materia m, horariodetallefecha hdf, salon s, sede se, tiposalon ts, carrera c
		WHERE
		h.codigosalon='$codigosalon'
		AND g.codigoperiodo='$codigoperiodo'
		AND h.codigodia=d.codigodia
		AND h.codigoestado='100'
		AND h.idgrupo=g.idgrupo
		AND g.codigomateria=m.codigomateria
		AND hdf.idhorario=h.idhorario
		AND h.codigosalon=s.codigosalon
		AND s.codigosede=se.codigosede
		AND s.codigotiposalon=ts.codigotiposalon
		AND m.codigocarrera=c.codigocarrera
		AND hdf.codigoestado='100'
		AND '$fecha' >= hdf.fechadesdehorariodetallefecha  
		AND '$fecha' <= hdf.fechahastahorariodetallefecha
		AND '$hora_ini' >= h.horainicial
		AND '$hora_fin' <= h.horafinal
		AND h.codigodia='$codigodia_bd'
		";

	$operacion=$conexion->query($query);
	$row_operacion=$operacion->fetchRow();
	if($this->depurar==true)
	{
		echo $query,"<br><br>";
		print_r($row_operacion);
		echo "<br><br>";
	}
	if(!empty($row_operacion))
	{
		return $row_operacion;
	}
	else
	{
		return false;
	}
}
function devuelveNumeroDiadelaSemana($dia,$mes,$ano)
{
	$numerodiasemana = @date('w', mktime(0,0,0,$mes,$dia,$ano));
	if ($numerodiasemana == 0)
	$numerodiasemana = 6;
	else
	$numerodiasemana--;
	return $numerodiasemana;
}
function SumaArreglosBidimensionalesDelMismoTamano($arreglo1,$arreglo2)
{
	if(count($arreglo1)==count($arreglo2))
	{
		for($i=0; $i<count($arreglo1);$i++)
		{
			$array_sumado[]=$arreglo1[$i] + $arreglo2[$i];
		}
		return $array_sumado;
	}
}
?>
