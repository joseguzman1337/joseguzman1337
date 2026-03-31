<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php');
require('../../../funciones/notas/funcionequivalenciapromedio.php');
require ('../../../funciones/notas/redondeo.php');
require ('../../../funciones/notas/funcionesMaterias.php');
session_start();
/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/
//require('funcionequivalenciapromedio.php');
$codigocarrera = $_SESSION['codigofacultad'];
 if ($_GET['periodo'] <> "")
 {
    $periodoactual = $_GET['periodo']; 
 }
 else
 {   
    $periodoactual = $_SESSION['codigoperiodosesion'];
 }

mysql_select_db($database_sala, $sala);
$query_responsable = "SELECT * 
FROM directivo d,directivocertificado di,certificado c
WHERE d.codigocarrera = '".$codigocarrera."'
AND d.iddirectivo = di.iddirectivo
AND di.idcertificado = c.idcertificado
AND di.fechainiciodirectivocertificado <='".date("Y-m-d")."'
AND di.fechavencimientodirectivocertificado >= '".date("Y-m-d")."'
AND c.idcertificado = '1'
ORDER BY fechainiciodirectivo";	
//echo $query_responsable;
//exit(); 
$responsable = mysql_query($query_responsable, $sala) or die(mysql_error());
$row_responsable = mysql_fetch_assoc($responsable);
$totalRows_responsable = mysql_num_rows($responsable);

if (isset($_GET['busqueda_semestre']) and $_GET['busqueda_semestre'] <> "" )
{ // if (isset($_POST['busqueda_semestre']))
	mysql_select_db($database_sala, $sala);
	$query_materiascarrera = "SELECT distinct eg.numerodocumento
	FROM detalleprematricula dp,estudiante e, prematricula p,materia m,grupo g,estudiantegeneral eg
	WHERE e.idestudiantegeneral = eg.idestudiantegeneral 
	AND p.idprematricula = dp.idprematricula		
	AND dp.codigomateria= m.codigomateria	
	AND dp.idgrupo = g.idgrupo	
	AND e.codigoestudiante = p.codigoestudiante
	AND g.codigoperiodo = '".$periodoactual."'
	AND m.codigoestadomateria = '01'
	AND e.codigocarrera = '$codigocarrera'
	AND p.codigoestadoprematricula LIKE '4%'
	AND dp.codigoestadodetalleprematricula  LIKE '3%'
	AND p.semestreprematricula = '".$_GET['busqueda_semestre']."'	
	ORDER BY 1";	
	//echo $query_materiascarrera;
	$materiascarrera = mysql_query($query_materiascarrera, $sala) or die("$query_promedioestudiante");
	$total_materiascarrera = mysql_num_rows($materiascarrera);
	$row_materiascarrera = mysql_fetch_assoc($materiascarrera);
	if($total_materiascarrera != "")
	{ // 	
	  do{    
		$codigoestudiante = $row_materiascarrera['numerodocumento'];
	    require('consultaboletinoperacion.php'); 	   
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";		
	  }while($row_materiascarrera = mysql_fetch_assoc($materiascarrera));
	}	 
} //if (isset($_POST['busqueda_semestre']))
else 
 if (isset($_GET['busqueda_codigo']) and $_GET['busqueda_codigo'] <> "")
  {	
	 $codigoestudiante = $_GET['busqueda_codigo'];
	 require('consultaboletinoperacion.php');
 }
?>
<div align="center" class="Estilo5" style="width:600px;margin: 0 auto;">
<span style="display:inline-block;margin:5px auto 10px;font-size:0.9em;">
* Registra las calificaciones obtenidas en el <?php echo substr($periodoactual, 0, -1)."-".substr($periodoactual,strlen($periodoactual)-1); ?>.<br/>
* El promedio ponderado semestral es calculado con las calificaciones obtenidas en el <?php echo substr($periodoactual, 0, -1)."-".substr($periodoactual,strlen($periodoactual)-1); ?>.</span>
 <p style="margin: 10px 0;"><?php echo $row_universidad['direccionuniversidad'];?> - P B X <?php echo $row_universidad['telefonouniversidad'];?> 
 - FAX: <?php echo $row_universidad['faxuniversidad'];?><br> <?php echo $row_universidad['paginawebuniversidad'];?> 
 - <?php echo $row_universidad['nombreciudad'];?> <?php echo $row_universidad['nombrepais'];?></p> 
</div>