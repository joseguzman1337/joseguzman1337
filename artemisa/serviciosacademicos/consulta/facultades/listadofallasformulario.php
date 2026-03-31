<?php require_once('../../Connections/sala2.php');
session_start();	

$codigocarrera = $_SESSION['codigofacultad'];
$banderaimprime = 0;
?>
<p align="center"><span class="Estilo3">LISTADO DE FALLAS</span></p>
 <table width="45%"  border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
<tr>
<td width='3%' colspan="12"><div align='center' class='Estilo3'>
FT = Falla 


Te&oacute;rica <br>
FP = Falla Practica <br>
TFT = Total Fallas 


Te&oacute;ricas <br>
TFP = Total Fallas Practicas <br>
</div>
</td>
</tr>

<?php
mysql_select_db($database_sala, $sala);
$query_periodo = "SELECT * FROM periodo where codigoestadoperiodo = '3'";
$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

if ($row_periodo <> "")
  {
   $periodoactual = $row_periodo['codigoperiodo'];
  } 
else
  {
    mysql_select_db($database_sala, $sala);
	$query_periodo = "SELECT * FROM periodo where codigoestadoperiodo = '1'";
	$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
	$row_periodo = mysql_fetch_assoc($periodo);
	$totalRows_periodo = mysql_num_rows($periodo);

    $periodoactual = $row_periodo['codigoperiodo'];
  } 
		
if (isset($_POST['busqueda_semestre']))
{ // if (isset($_POST['busqueda_semestre']))
	mysql_select_db($database_sala, $sala);
	$query_materiascarrera = "SELECT eg.apellidosestudiantegeneral, e.codigoestudiante
	    FROM estudiante e, prematricula p,estudiantegeneral eg
		WHERE e.codigoestudiante = p.codigoestudiante
		and eg.idestudiantegeneral = e.idestudiantegeneral
		AND p.codigoperiodo = '".$periodoactual."'		
		AND e.codigocarrera = '$codigocarrera'
		AND p.codigoestadoprematricula LIKE '4%'		
		AND p.semestreprematricula = '".$_POST['busqueda_semestre']."'	
		ORDER BY 1";	
	//echo $query_materiascarrera;
	$materiascarrera = mysql_query($query_materiascarrera, $sala) or die("$query_promedioestudiante");
	$total_materiascarrera = mysql_num_rows($materiascarrera);
	$row_materiascarrera = mysql_fetch_assoc($materiascarrera);
	if($total_materiascarrera != "")
	{ // 	
      do{
	    $codigoestudiante = $row_materiascarrera['codigoestudiante'];
	    require('listadofallasoperacion.php');	   
	  }while($row_materiascarrera = mysql_fetch_assoc($materiascarrera));	
	}	 
} //if (isset($_POST['busqueda_semestre']))
else 
 if (isset($_POST['busqueda_codigo']))
  {
	       $documento = $_POST['busqueda_codigo'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
				c.nombrecarrera, eg.numerodocumento, est.codigoperiodo
				FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, documento d, carrera c 
				WHERE ed.numerodocumento LIKE '$documento%'				
				and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
				and eg.idestudiantegeneral = est.idestudiantegeneral
				and ed.idestudiantegeneral = eg.idestudiantegeneral
				and c.codigocarrera = est.codigocarrera
				and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
				and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
				ORDER BY 3, est.codigoperiodo";				
		$res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud");
	    $solicitud = mysql_fetch_assoc($res_solicitud);	 
	 
	 $codigoestudiante = $solicitud ['codigoestudiante'];
	 require('listadofallasoperacion.php');
 }
 ?>
 </table>
<br><br> 
 <div align="center">
   <input type='button' onClick='history.go(-1)' value='Regresar'>
 </div>
