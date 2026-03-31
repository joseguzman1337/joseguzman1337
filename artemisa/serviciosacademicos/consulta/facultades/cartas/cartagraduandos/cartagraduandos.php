<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
require_once('../../../../Connections/sala2.php');
//require_once('funcionpuesto.php');
session_start();
mysql_select_db($database_sala, $sala);

$codigocarrera = $_SESSION['codigofacultad'];
$codigoperiodo = $_SESSION['codigoperiodosesion'];
$codigoestudiante = $_GET['codigoestudiante'];

$query_datosestudiante = "SELECT eg.idestudiantegeneral, concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) AS nombre,eg.numerodocumento,
p.nombreperiodo, c.nombrecarrera, eg.numerodocumento, eg.expedidodocumento, eg.codigogenero
FROM estudiante e, estudiantegeneral eg, carrera c, periodo p 
WHERE eg.idestudiantegeneral = e.idestudiantegeneral
and c.codigocarrera = e.codigocarrera
and e.codigocarrera = '$codigocarrera'
and e.codigoestudiante = '$codigoestudiante'
and p.codigoperiodo = e.codigoperiodo";
$datosestudiante = mysql_query($query_datosestudiante, $sala) or die("$query_datosestudiante".mysql_error());
$row_datosestudiante = mysql_fetch_assoc($datosestudiante);
$totalRows_datosestudiante = mysql_num_rows($datosestudiante);

$query_periodosestudiante = "SELECT distinct n.codigoperiodo, p.nombreperiodo
FROM notahistorico n, periodo p
WHERE n.codigoestudiante = '$codigoestudiante'
AND p.codigoperiodo = n.codigoperiodo
order by 1 desc";
$periodosestudiante = mysql_query($query_periodosestudiante, $sala) or die("$query_periodosestudiante".mysql_error());
$row_periodosestudiante = mysql_fetch_assoc($periodosestudiante);
$totalRows_periodosestudiante = mysql_num_rows($periodosestudiante);


?>
<html>
<head>
<title>Carta Graduandos</title>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo7 {font-size: xx-small}
-->
</style>
</head>
<body>
<form name="form1" method="post" action="">
  <table width="80%"  border="0" align="center" cellpadding="0">
    <tr>
      <td colspan="7">
	    <p align="justify"><font class="Estilo1"><br>
          Bogotá D.C.,
          <?php 
$ano = substr(date("Y-m-d"),0,4);
$mes = substr(date("Y-m-d"),5,2);
$dia = substr(date("Y-m-d"),8,2);
$day = $dia;
$mesesano = $mes;	
require('convertirnumeros.php'); 
echo "$meses ".date("d")." de ".date("Y");
?>
          <br>
          <br>
          <br>
	  Se&ntilde;or(ita):<br>
	  <?php echo $row_datosestudiante['nombre']; ?></font><br>
	    <font class="Estilo1">Escuela Colombiana de Medicina
          <br>
          Universidad El Bosque<br>
Ciudad<br>
	    </font><font class="Estilo1"><br>
	    Cordial Saludo:<br><br>
		Por medio de la presente se le informa  su situaci&oacute;n acad&eacute;mica actual, con el objetivo de realizar  correctivos necesarios, pagos, documentaci&oacute;n  y otros para evitar inconvenientes al momento de su grado.<br>
	      <br>
          <?php
$query_premainicial1 = "SELECT d.codigomateria, m.nombremateria, d.codigomateriaelectiva
FROM detalleprematricula d, prematricula p, materia m, estudiante e
where d.codigomateria = m.codigomateria 
and d.idprematricula = p.idprematricula
and p.codigoestudiante = e.codigoestudiante
and e.codigoestudiante = '$codigoestudiante'
and p.codigoestadoprematricula like '4%'
and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula = '23')
and p.codigoperiodo = '$codigoperiodo'";
//echo "$query_premainicial1<br>";
$premainicial1=mysql_query($query_premainicial1, $sala) or die("$query_premainicial1");
$totalRows_premainicial1 = mysql_num_rows($premainicial1);
$tieneprema = false;
$quitaparacartas = "";
if($totalRows_premainicial1 != "")
{
?>
        </font><span class="Estilo2">Asignaturas  cursadas actualmente:</span>
	   
	    <div align="justify">
          <table height='5' border='0' align='left' cellpadding='2' cellspacing='1' width="80%">
          <tr bgcolor="" class="Estilo1"> 
  	        <td bgcolor="" align="left"><span class="Estilo7">C&oacute;digo Asignatura</span></td>
            <td bgcolor="" align="left"><span class="Estilo7">Nombre Asignatura</span></td>
          </tr>	
        <?php	
	while($row_premainicial1 = mysql_fetch_array($premainicial1))
	{
		if($row_premainicial1['codigomateriaelectiva'] != "")
		{
			$quitaparacartas = "$quitaparacartas and d.codigomateria <> ".$row_premainicial1['codigomateriaelectiva']."";
		}
		else
		{
			$quitaparacartas = "$quitaparacartas and d.codigomateria <> ".$row_premainicial1['codigomateria']."";
		}
?>
	        <tr class="Estilo1"> 
            <td><div align="left" class="Estilo7"><?php echo $row_premainicial1['codigomateria'];?></div></td>
            <td><div align="left" class="Estilo7"><?php echo $row_premainicial1['nombremateria'];?></div></td>
	        </tr>
        <?php		
	}
?>
          </table>
          </font>
  
        <br>
          <br>
          <?php
}
?>
        </div></td>
</tr>
<tr>
<td colspan="7">
<?php
require_once("../../../prematricula/funcionmateriaaprobada.php");
require_once("../../../prematricula/generarcargaestudiante.php");

if(isset($materiasporver))
{
?>
<div align="justify">
	  <span class="Estilo2">Asignaturas por cursar:</span><br>
	  <table height='5' border='0' align='left' cellpadding='2' cellspacing='1' width="80%">
      <tr bgcolor="" class="Estilo1"> 
  	    <td bgcolor="" align="left"><span class="Estilo7">C&oacute;digo Asignatura</span></td>
        <td bgcolor="" align="left"><span class="Estilo7">Nombre Asignatura</span></td>
      </tr>	
    <?php	
	foreach($materiasporver as $llave => $valor)
	{
?>
	    <tr class="Estilo1"> 
        <td><div align="left" class="Estilo7"><?php echo $valor['codigomateria'];?></div></td>
        <td><div align="left" class="Estilo7"><?php echo $valor['nombremateria'];?></div></td>
	    </tr>
    <?php		
	}
?>
      </table>
	  </font>
      <br>
      <br>
      <br>
      <?php
}
?>
</div></td>
</tr>
<tr>
<td colspan="7">
	
<?php
// Selecciona los documentos para la facultad que posee un estudiante
$query_documentos = "SELECT d.nombredocumentacion, d.iddocumentacion
from documentacion d,documentacionfacultad df
where d.iddocumentacion = df.iddocumentacion
and df.codigocarrera = '$codigocarrera'
and df.fechainiciodocumentacionfacultad <= '".date("Y-m-d")."'
and df.fechavencimientodocumentacionfacultad >= '".date("Y-m-d")."'
AND (df.codigogenerodocumento = '300' 
OR df.codigogenerodocumento = '".$row_datosestudiante['codigogenero']."')";
//echo $query_documentos;
//exit();
$documentos = mysql_query($query_documentos, $sala) or die(mysql_error());
$totalRows_documentos = mysql_num_rows($documentos);
if($totalRows_documentos != "")
{
?>
	<br>
	<p align="justify" class="Estilo1"> Luego de revisar la documentaci&oacute;n requerida para su graduaci&oacute;n, me permito comunicarle que a la fecha, usted tiene PENDIENTE la entrega de los documentos que se encuentran relacionados:</p>
	<div align="justify">
	  <table width="100%">
    <?php
	while($row_documentos = mysql_fetch_assoc($documentos))
	{
		// Selecciona los documentos para la facultad que posee un estudiante
		$query_documentosestudiante = "SELECT d.codigotipodocumentovencimiento
		FROM documentacionestudiante d,documentacionfacultad df,tipovencimientodocumento t
	    where d.codigoestudiante = '".$codigoestudiante."'
		and d.iddocumentacion = '".$row_documentos['iddocumentacion']."'
		AND d.codigotipodocumentovencimiento = '100' 
		and d.iddocumentacion = df.iddocumentacion
		AND d.codigotipodocumentovencimiento = t.codigotipovencimientodocumento";
		$documentosestudiante = mysql_query($query_documentosestudiante, $sala) or die("$query_documentosestudiante".mysql_error());
		$totalRows_documentosestudiante = mysql_num_rows($documentosestudiante);
		$row_documentosestudiante = mysql_fetch_assoc($documentosestudiante);
		if($totalRows_documentosestudiante == "")
		{
			$pendiente = true;
		}
		else if($row_documentosestudiante['codigotipodocumentovencimiento'] == '100')
		{
			$pendiente = false;
			continue;
		}
		else
		{
			$pendiente = true;
		}
?>
	    <tr>
          <td align="left" class="Estilo1">- <?php echo $row_documentos['nombredocumentacion']; ?></td>
        </tr>
    <?php
	}
?>
	    </table>
	  <?php
}
?>
	  <br> 
	  <span class="Estilo1">Adicionalmente, debe anexar (1) fotocopia de la cédula
      <?php
if($row_datosestudiante['codigogenero'] == '200')
{
?>
	  , (1) fotocopia de la Libreta Militar
	    <?php
}
?>
	    y  (1) fotograf&iacute;a tama&ntilde;o documento.
        </p>
    </span>	</div>	<p align="justify">
	  <span class="Estilo1">Los derechos de grado tienen un  costo  de TRESCIENTOS VEINTINUEVE MIL PESOS
    ($329.000,oo), los cuales debe cancelar en la Caja de la Universidad. El recibo  de  este  pago junto  con los demás documentos, 
	deben ser  entregados en la  Secretaría Académica  de  la Facultad  a más tardar el día 17 de Mayo de 2006. </span></brp>
	<p align="justify" class="Estilo1"> Así mismo le recuerdo que para recibir su título de Médico Cirujano, usted debe estar al día con su trabajo de investigación y estar a paz y salvo con todas las dependecias acad&eacute;micas y administrativas.</p>
	<p align="justify" class="Estilo1"> La ceremonia  de  graduación  se  celebrará  el d&iacute;a 15 de Junio de 2006   a las 6:00 p.m., en el  auditorio  de la Universidad, sede B. </p>
	<p align="justify"><span class="Estilo1">
	  Cordialmente,</span><br>
	  <br>
	  <br>
      <?php 
	$query_responsable = "SELECT * 
	FROM directivo d,directivocertificado di,certificado c
	WHERE d.codigocarrera = '".$codigocarrera."'
	AND d.iddirectivo = di.iddirectivo
	AND di.idcertificado = c.idcertificado
	AND di.fechainiciodirectivocertificado <='".date("Y-m-d")."'
	AND di.fechavencimientodirectivocertificado >= '".date("Y-m-d")."'";	
	//echo $query_responsable; 
	$responsable = mysql_query($query_responsable, $sala) or die(mysql_error());
	$row_responsable = mysql_fetch_assoc($responsable);
	$totalRows_responsable = mysql_num_rows($responsable);
?>
	  <span class="Estilo2"><a style='cursor: pointer' onClick='JavaScript:window.print()' ><?php echo $row_responsable['nombresdirectivo'],"&nbsp;",$row_responsable['apellidosdirectivo'];?></a><br>
      <?php 
	echo $row_responsable['cargodirectivo'];
?>	
	  <br>
	  Universidad El Bosque</span><strong>
	
</strong>&nbsp;</p>
</font>
	</td>
</tr>	  
  </table>
</form>
<?php
//}
?>
</body>
</html>
