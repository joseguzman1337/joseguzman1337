<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
//error_reporting(0);
@session_start();
require_once("../../../../funciones/conexion/conexionpear.php");
require_once("funciones/imprimir_arrays_bidimensionales.php");
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
$periodo=$_SESSION['codigoperiodosesion'];
$query_estudiante="select e.codigoestudiante,eg.apellidosestudiantegeneral
from
estudiante e, estudiantegeneral eg,prematricula pr
where
e.idestudiantegeneral=eg.idestudiantegeneral
and pr.codigoestudiante=e.codigoestudiante
and e.codigocarrera=98
and pr.codigoperiodo='$codigoperiodo'
order by eg.apellidosestudiantegeneral asc
";
//echo $query_estudiante;
$estudiante=$sala->query($query_estudiante);
$row_estudiante=$estudiante->fetchRow();

$numerocorte=$_GET['numerocorte'];
do
{	//
	boletin($row_estudiante['codigoestudiante'],$periodo,$numerocorte,$sala);	
}
while($row_estudiante=$estudiante->fetchRow());
?>
<?php function boletin($codigoestudiante,$codigoperiodo,$numerocorte,$conexion){?>

<?php
$fechahoy=date("Y-m-d H:i:s");
require_once("datos_basicos.php");
//error_reporting(2047);
setlocale(LC_ALL,'es_ES');
$estudiante = new estudiante;
$numerocorte=$numerocorte;
$codigoestudiante=$codigoestudiante;
$codigoperiodo=$codigoperiodo;
$row_datos_basicos=$estudiante->obtener_datos_basicos_estudiante($codigoestudiante,$codigoperiodo,$numerocorte,$conexion);
$row_materias_estudiante=$estudiante->obtener_materias_estudiante();
print_r($row_materias_estudiante);echo "<br>";
$row_areas_materias=$estudiante->obtener_areas_materias();
$row_datos_corte=$estudiante->obtener_datos_corte();
$row_notasestudiante=$estudiante->obtener_notas_estudiante();
$row_equivalencias=$estudiante->obtener_equivalencias_notas();
$row_universidad=$estudiante->datos_universidad();
$semestre_estudiante=$estudiante->obtener_semestre_estudiante();
$curso_estudiante=$estudiante->obtener_curso_estudiante();
?>
<?php
$contador=0;
foreach($row_materias_estudiante as $clave => $valor)
{
	$array_datos[$contador]['CODIGO']=strtoupper($valor['codigomateria']);
	$array_datos[$contador]['AREA']=$row_areas_materias[$contador]['nombreareaacademica'];
	$array_datos[$contador]['ASIGNATURA']=strtoupper($valor['nombremateria']);
	$array_datos[$contador]['NOTA']=$row_equivalencias[$contador]['nombrenotaequivalencia'];
	$array_datos[$contador]['FALLAS']=$row_notasestudiante[$contador]['numerofallasteoria'];
	$contador++;
}
?>
<body>
<form name="form1" method="post" action="">
<table width="100%" border="0" align="center">
  <tr>
    <td><div align="center"><FONT face=Arial size=2>
      <H2 style="MARGIN: 0cm 0cm 0pt"><SPAN lang=ES-CO 
style="mso-ansi-language: ES-CO"><FONT face=Tahoma><FONT size=2><br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        COLEGIO BILING&Uuml;E DE LA UNIVERSIDAD EL BOSQUE<o:p></o:p></FONT></FONT></SPAN></H2>
      <P class=MsoNormal style="MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: center" 
align=center><SPAN lang=ES-CO 
style="FONT-SIZE: 10pt; mso-bidi-font-size: 12.0pt"><FONT 
face="Times New Roman">Resoluci&oacute;n 1076 del 19 de Marzo de 1999 S.E.D.<o:p></o:p></FONT></SPAN></P>
    </FONT><br>
    <FONT face=Arial size=2>
    <P class=MsoNormal style="MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: center" 
align=center><SPAN lang=ES-CO></SPAN><SPAN lang=ES-CO 
style="FONT-SIZE: 11pt; mso-bidi-font-size: 12.0pt"><FONT 
face="Times New Roman"><FONT size=1>BOLET&Iacute;N DE CRITERIOS DE EVALUACI&Oacute;N POR CORTE<o:p></o:p></FONT></FONT></SPAN></P>
    </FONT> <br>
    <br>
    <br>
    </div></td>
  </tr>
</table>

<br>
<table width="100%"  border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#000000" onClick="print()">
  <tr>
    <td><table width="100%"  border="0">
      <tr class="Estilo6">
        <td width="14%" nowrap>NOMBRE DEL ALUMNO:</td>
        <td width="32%"><?php echo strtoupper($row_datos_basicos['nombre'])?></td>
        <td width="7%">CODIGO:</td>
        <td width="17%"><?php echo $row_datos_basicos['numerodocumento']?></td>
        <td width="6%">PERIODO:</td>
        <td width="24%"><?php echo $codigoperiodo?></td>
      </tr>
      <tr class="Estilo6">
        <td>CURSO:</td>
        <td><?php echo $curso_estudiante;?></td>
        <td>SEMESTRE:</td>
        <td><?php echo $semestre_estudiante?></td>
        <td>CORTE:</td>
        <td><?php echo $numerocorte?></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<?php 
listar($array_datos,"","","no");
unset($array_datos);?>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<table width="100%"  border="1" onClick="print()">
  <tr>
    <td>OBSERVACIONES:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<table width="100%"  border="0">
  <tr class="Estilo1">
    <td>FIRMA DIRECTOR DE CURSO: </td>
    <td>FIRMA PADRES DE FAMILIA : </td>
  </tr>
  <tr>
    <td>__________________________________________________</td>
    <td>__________________________________________________</td>
  </tr>
</table>
<?php echo "<H1 class=SaltoDePagina> </H1>";?>
<?php } ?>
