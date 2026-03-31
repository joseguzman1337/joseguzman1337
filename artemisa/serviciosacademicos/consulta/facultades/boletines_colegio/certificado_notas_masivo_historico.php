<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
session_start();
//print_r($_SESSION);
error_reporting(2047);
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
require_once("funciones/imprimir_arrays_bidimensionales.php"); 
require_once("datos_basicos_historico.php");
//$sala->debug = true;
?>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
</STYLE>
<link rel="stylesheet" type="text/css" href="estilos/sala.css">
<script type="text/javascript" src="funciones_javascript.js"></script>
<?php
if($_GET['codigoestudiante']=="")
{
	$query_estudiante="select e.codigoestudiante,eg.apellidosestudiantegeneral
	from
	estudiante e, estudiantegeneral eg,prematricula pr
	where
	pr.semestreprematricula='".$_GET['semestre']."'
	and e.idestudiantegeneral=eg.idestudiantegeneral
	and pr.codigoestudiante=e.codigoestudiante
	and e.codigocarrera='98'
	and pr.codigoperiodo='".$_SESSION['codigoperiodosesion']."'
	order by eg.apellidosestudiantegeneral asc
	";
}
else
{
	$query_estudiante="select e.codigoestudiante,eg.apellidosestudiantegeneral
	from
	estudiante e, estudiantegeneral eg,prematricula prrrrr
	where
	e.idestudiantegeneral=eg.idestudiantegeneral
	and pr.codigoestudiante=e.codigoestudiante
	and e.codigocarrera='98'
	and pr.codigoperiodo='".$_SESSION['codigoperiodosesion']."'
	and e.codigoestudiante='".$_GET['codigoestudiante']."'
	order by eg.apellidosestudiantegeneral asc
	";
}
//echo $query_estudiante,"<br>";
$estudiante=$sala->query($query_estudiante);
$row_estudiante=$estudiante->fetchRow();
$periodo=$_SESSION['codigoperiodosesion'];
//$numerocorte=$_GET['numerocorte'];
$numerocorte= '1';
do
{
	boletin($row_estudiante['codigoestudiante'],$periodo,$numerocorte,$sala);	
}
while($row_estudiante=$estudiante->fetchRow());

function boletin($codigoestudiante,$codigoperiodo,$numerocorte,$conexion)
{

$fechahoy=date("Y-m-d H:i:s");
//error_reporting(2047);
setlocale(LC_ALL,'es_ES');
$estudiante = new estudiante;
//$estudiante->depurar();
$numerocorte=$numerocorte;
$codigoestudiante=$codigoestudiante;
$codigoperiodo=$codigoperiodo;
$row_datos_basicos=$estudiante->obtener_datos_basicos_estudiante($codigoestudiante,$codigoperiodo,$numerocorte,$conexion);
$row_materias_estudiante=$estudiante->obtener_materias_estudiante();
$row_areas_materias=$estudiante->obtener_areas_materias();
$row_datos_corte=$estudiante->obtener_datos_corte();
$row_notasestudiante=$estudiante->obtener_notas_estudiante();
$row_universidad=$estudiante->datos_universidad();
$semestre_estudiante=$estudiante->obtener_semestre_estudiante();
$curso_estudiante=$estudiante->obtener_curso_estudiante();
//print_r($semestre_estudiante);
//$definitivas=$estudiante->calcular_definitivas($numerocorte);
$row_equivalencias=$estudiante->obtener_equivalencias_notas();

$contador=0;
foreach($row_materias_estudiante as $clave => $valor)
{
	$array_datos[$contador]['CODIGO']=strtoupper($valor['codigomateria']);
	$array_datos[$contador]['AREA']=ucfirst(strtolower($row_areas_materias[$contador]['nombreareaacademica']));
	$array_datos[$contador]['ASIGNATURA']=ucfirst(strtolower($valor['nombremateria']));
	$array_datos[$contador]['NOTA']=$row_equivalencias[$contador]['nombrenotaequivalencia'];
	$array_datos[$contador]['IHS']=$valor['numerohorassemanales'];
	if ($valor['codigotiponotahistorico'] == 201)
	$array_datos[$contador]['R']= 'R';
	else
	$array_datos[$contador]['R']= '';
	$contador++;
}
?>
<style type="text/css">
<!--
.Estilo6 {font-family: Tahoma}
.Estilo9 {font-size: x-small}
.Estilo11 {font-family: Tahoma; font-size: small; }
.Estilo14 {font-family: Tahoma; font-size: medium; }
.Estilo16 {font-family: Tahoma; font-size: xx-small; }
-->
</style>
<body>
<form name="form1" method="post" action="">
<table width="100%" border="0" align="center">
  <tr>
    <td><div align="center">       
          <p>
             <span class="Estilo14"><strong>COLEGIO BILING&Uuml;E DE LA UNIVERSIDAD EL BOSQUE</strong></span></p>
             <p class="Estilo16">Resolución 1076 del 19 de Marzo de 1999 S.E.D.<br>
             Resolución 3369 del 03 de Mayo de 2001 S.E.D.<br>
             Resolución 8479 del 16 de Noviembre de 2001 S.E.D.

</p>
          <p class="Estilo11">Los suscritos Director y Secretaria <br>del Colegio Biling&uuml;e de la Universidad El Bosque </p>
          <P class="Estilo6 Estilo9 Estilo6">CERTIFICAN QUE:</P> 
      <span class="Estilo6"><br>
      <br>
      <br>
      </span>
    </div></td>
  </tr>
</table>

<br>
<table width="100%"  border="1" align="center" style="border-width:0.1px" cellpadding="2" cellspacing="1" bordercolor="#000000" onClick="print()">
  <tr>
    <td><table width="100%"  border="0" cellspacing="0" >
      <tr class="Estilo6">
        <td width="14%" nowrap class="Estilo9"><strong>Nombre Alumno (a):</strong></td>
        <td width="32%" class="Estilo9"><?php echo strtoupper($row_datos_basicos['nombre'])?></td>
        <td width="7%" class="Estilo9"><strong>C&oacute;digo :</strong></td>
        <td width="17%" class="Estilo9"><?php echo $row_datos_basicos['numerodocumento']?></td>
        <td width="6%" class="Estilo9"><strong>Periodo:</strong></td>
        <td width="24%" class="Estilo9"><?php echo $codigoperiodo?></td>
      </tr>
      <tr class="Estilo6">
        <td colspan="6" class="Estilo9">Cursó Y Aprobó el 
	<?php 
		if ($semestre_estudiante == '1' or $semestre_estudiante == '3') 
		{
		  echo 'I';
		} 
		else 
		 if ($semestre_estudiante == '2' or $semestre_estudiante == '4') 
		{
		   echo 'II';
		}
	?> Semestre de grado 
          <?php if ($semestre_estudiante < 3){ echo '10';} else {echo '11';}?>
          &ordm; de Educación Media durante el a&ntilde;o <?php echo substr($codigoperiodo,0,4);?> y  Obtuvo las Siguientes Calificaciones: </td>
        </tr>
    </table></td>
  </tr>
</table>
</form>
<?php 
$ano = substr(date("Y-m-d"),0,4);
$mes = substr(date("Y-m-d"),5,2);
$dia = substr(date("Y-m-d"),8,2);		


listar($array_datos,"","","no");
//unset($array_datos);?>
<br>
<br>
<br>
<br>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" style="border-width:0.1px">
   <tr>
    <td><span class="Estilo9">Dado en Bogot&aacute; D.C., a los
<?php  
	$day = $dia;
	$mesesano = $mes;	
	require('../certificados/convertirnumeros.php'); 
	echo $dias;
?> 
(<?php echo $dia;?>) d&iacute;as del mes de <?php echo $meses;?> (<?php echo $mes;?>) del a&ntilde;o dos mil
<?php $day = substr($ano,3,4); require('../certificados/convertirnumeros.php'); echo $dias; ?> 
(<?php echo $ano;?>). </span><br>
    &nbsp;</td>
  </tr>
  <tr>
    <td><span class="Estilo9">Equivalencia Cualitativa: </span><br>
    &nbsp;</td>
  </tr>
  <tr>
    <td> <span class="Estilo9"><span class="Estilo16"><strong>EXCELENTE :</strong> 5.0 - 4.5   <strong>SOBRESALIENTE :</strong> 4.4 - 4.0   <strong>ACEPTABLE :</strong> 3.9 - 3.0    <strong>INSUFICIENTE :</strong> 2.9 - 2.0    <strong>DEFICIENTE :</strong> 1.9 - 0.0<br>
    </span><br>
    <span class="Estilo16"><strong>R :</strong> Recuperación</span></span></td>
  </tr> 
</table>
<br>
<br>

<br>
<br>
<br>
<br>

<table width="100%"  border="0">
  <tr class="Estilo1">
    <td>__________________________________________________<br>EUCLIDES VALENCIA CEPEDA<BR>Director </td>
    <td>__________________________________________________<br>BERTHA GARCIA<BR>Secretaria</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>
</table>
<?php 
//listar($row_materias_estudiante,"Materias");
//listar($row_notasestudiante,"Notas Originales");
//listar($definitivas,"Promedio");
//listar($row_equivalencias,"Equivalencias");
	if($_GET['codigoestudiante']=="")
	{
		echo "<H1 class=SaltoDePagina> </H1>";
	}
?>
<?php 
}
?>

