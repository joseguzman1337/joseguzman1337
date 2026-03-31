<?php 
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php'); 
require_once('../../../funciones/clases/motorv2/motor.php');
$db->SetFetchMode(ADODB_FETCH_ASSOC);
session_start();
$carrera = $_SESSION['codigofacultad'];

?>
<style type="text/css">
<!--
.Estilo1 {
	font-family: tahoma;
	font-size: xx-small;
}
.Estilo2 {font-size: xx-small}
.Estilo3 {font-size: x-small}
-->
</style>
<?php
mysql_select_db($database_sala, $sala);
$query_periodo = "SELECT * 
FROM periodo p,carreraperiodo cp 
WHERE codigoestadoperiodo = '3'
AND cp.codigoperiodo = p.codigoperiodo
AND cp.codigocarrera = '$carrera'";
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
	$query_periodo = "SELECT * 
	FROM periodo p,carreraperiodo cp 
	WHERE codigoestadoperiodo = '1'
	AND cp.codigoperiodo = p.codigoperiodo
	AND cp.codigocarrera = '$carrera'";
	$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
	$row_periodo = mysql_fetch_assoc($periodo);
	$totalRows_periodo = mysql_num_rows($periodo);

    $periodoactual = $row_periodo['codigoperiodo'];
  }  

mysql_select_db($database_sala,$sala);

$query_confirma ="SELECT e.codigoestudiante,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,n.codigomateria,
m.nombremateria,n.notadefinitiva,e.semestre,eg.numerodocumento,tn.nombretiponotahistorico
FROM notahistorico n,estudiante e,materia m,estudiantegeneral eg,tiponotahistorico tn
WHERE n.codigoestudiante = e.codigoestudiante
AND eg.idestudiantegeneral = e.idestudiantegeneral
AND tn.codigotiponotahistorico = n.codigotiponotahistorico
AND n.codigomateria = m.codigomateria
AND n.codigoperiodo = '".$periodoactual."' 
AND n.codigoestadonotahistorico like '1%'
AND (n.codigotiponotahistorico = '100' or n.codigotiponotahistorico = '102')
AND e.codigocarrera = '".$carrera."' 
ORDER BY 7,2";
//echo $query_confirma,"</br>";
$confirma = mysql_query($query_confirma, $sala) or die(mysql_error());
$row_confirma = mysql_fetch_assoc($confirma);
do{
  $Array_interno[] = $row_confirma;
}while($row_confirma = mysql_fetch_assoc($confirma));

$query_cierre = "SELECT	*
	FROM procesoperiodo
	WHERE codigoperiodo = '$periodoactual'
    and codigocarrera = '$carrera'
	and idproceso = '1'
	and codigoestadoprocesoperiodo = '200'";
    //echo $query_cierre,"<br>"; die;
	//exit();
	$cierre = mysql_query($query_cierre, $sala) or die(mysql_error());
    $row_cierre = mysql_fetch_assoc($cierre)
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Listado Egresados</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="../../../sala.css">
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">

</head>
<body>
<p>REPORTE DE CIERRE ACADÉMICO PERIODO <?php echo $periodoactual; ?></p>
<p>El Cierre Acad&eacute;mico Ya Fue Realizado en la Fecha: <?php echo  $row_cierre['fecharealizoprocesoperiodo']?></p>
<p>Fecha Generación Reporte: <?php echo date("Y-m-d H:i:s"); ?></p>
<?php 

$motor = new matriz($Array_interno,"REPORTE DE CIERRE ACADEMICO","cierresemestrelistado.php","si","si","","","","","../../../");
$motor->botonRecargar = false;
$motor->botonRegresar = false;
$motor->mostrar();
?>
<!-- 
/* $document = "";
if ($row_confirma <> "")
 {
        echo "<div align='center'>";
		echo "<span align='center' class='Estilo2 Estilo23 Estilo27 Estilo1 Estilo3'>LISTADO DE CIERRE GENERADO</span>";
		echo "</div>";
		echo "<br>";
?> 
       <table align="center"  bordercolor="#FF9900" border="1" width="70%">
         <tr>
          <td>

<?php			
		/*echo "<table align='center'>";
		echo "<tr  bgcolor='#C5D5D6'>";
		echo "<td align='center' class='Estilo1 Estilo4'><strong>Documento</strong></td>";
		echo "<td align='center' class='Estilo1 Estilo4'><strong>Estudiante</strong></td>";
		echo "<td align='center' class='Estilo1 Estilo4'><strong>Materia</strong></td>";	
		echo "<td align='center' class='Estilo1 Estilo4'><strong>Nombre Materia</strong></td>";			
		echo "<td align='center' class='Estilo1 Estilo4'><strong>Nota Definitiva</strong></td>";			
		echo "</tr>";
		
      do{
	      if ($document <> $row_confirma['numerodocumento'])
		   {
		    echo "<tr>"; 
			echo "<td><hr color='#FFFFFF'></td>";
		    echo "</tr>"; 
		   }
		 echo "<tr>"; 
		 echo "<td align='center' class='Estilo1 Estilo4'>".$row_confirma['numerodocumento']."</td>";	        
		 echo "<td align='center' class='Estilo1 Estilo4'>".$row_confirma['apellidosestudiantegeneral']."&nbsp;".$row_confirma['nombresestudiantegeneral']."</td>";
		 echo "<td align='center' class='Estilo1 Estilo4'>".$row_confirma['codigomateria']."</td>";
		 echo "<td align='center' class='Estilo1 Estilo4'>".$row_confirma['nombremateria']."</td>";
		 echo "<td align='center' class='Estilo1 Estilo4'>".$row_confirma['notadefinitiva']."</td>";    
		 echo "</tr>";   
	      $document = $row_confirma['numerodocumento'];
	   }while($row_confirma = mysql_fetch_assoc($confirma));
       echo "</table>";	
  }*/

?>
</td>
</tr>
</table> */ -->
</body>
</html>