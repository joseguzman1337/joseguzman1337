<?php 
require_once('../../../Connections/sala2.php');
//require('funcionequivalenciapromedio.php');
require('funcionmateriaaprobada.php');
require('../../../funciones/notas/funcionequivalenciapromedio.php');
require ('../../../funciones/notas/redondeo.php');
require_once('../../../funciones/funcionip.php');
require('funcionvalidafallas.php');

$fechahoy = date("Y-m-d G:i:s",time());
$ip = "SIN DEFINIR";
$ip = tomarip();
session_start(); 
set_time_limit(0);
?>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo3 {
	font-family: tahoma;
	font-size: xx-small;
	font-weight: bold;
}
.Estilo4 {font-size: xx-small}
.Estilo5 {font-family: tahoma; font-size: xx-small; }
-->
</style>
<?php

$usuario   = $_SESSION['MM_Username'];
$carrera   = $_SESSION['codigofacultad'];
$noaplica  = $_SESSION['study'];

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
	   
$periodoactual = $_SESSION['codigoperiodosesion'];
	   
// Valida si ya se envio el cierre
$query_generado = "SELECT distinct n.codigoestudiante 
FROM notahistorico n,estudiante e
WHERE n.codigoestudiante = e.codigoestudiante
AND n.fechaprocesonotahistorico like '".date("Y-m-d")."%'
AND n.codigotiponotahistorico = '100'
AND n.codigoperiodo = '$periodoactual'
AND e.codigocarrera = '$carrera'";
$generado = mysql_query($query_generado, $sala) or die(mysql_error());
$row_generado = mysql_fetch_assoc($generado);
$totalRows_generado = mysql_num_rows($generado);   


if ($row_generado <> "")
 {
   echo '<script language="JavaScript">alert("El Cierre Académico en este momento se esta generando, y puede tardar varios minutos"); history.go(-1);</script>';	
   exit();
 }   
	   mysql_select_db($database_sala, $sala);
	   $query_estudiantes = "SELECT DISTINCT e.codigoestudiante,p.semestreprematricula,eg.numerodocumento
	   FROM estudiante e,prematricula p,estudiantegeneral eg,detalleprematricula d
	   WHERE p.codigoestudiante = e.codigoestudiante
	   AND e.idestudiantegeneral = eg.idestudiantegeneral
	   AND p.idprematricula = d.idprematricula							   
	   AND p.codigoperiodo = '$periodoactual'
	   AND p.codigoestadoprematricula LIKE '4%'
	   AND d.codigoestadodetalleprematricula LIKE '3%'
       AND e.codigocarrera = '$carrera'
       ORDER BY 1";	   
	   $estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
	   $row_estudiantes = mysql_fetch_assoc($estudiantes);
	   $totalRows_estudiantes = mysql_num_rows($estudiantes);    
     
		$banderaporcentaje = 0;		    		
		$contadorfaltantes = 1;
		$contadorcierre = 1;
		//echo $contadorfaltantes,"<br>";  
		 do{		     
			  //echo $row_estudiantes['codigoestudiante'],"<br>";
			  $codigoestudiante = $row_estudiantes['codigoestudiante'];		      
			  require('cierresemestreporcentajes.php');			
		      $codigocierre[$contadorcierre]=$codigoestudiante;	
              $semestre1[$contadorcierre] = $row_estudiantes['semestreprematricula'];
			  $numerod[$contadorcierre] = $row_estudiantes['numerodocumento'];
			  $contadorcierre++;
		  }while($row_estudiantes = mysql_fetch_assoc($estudiantes));	
			 //echo $banderaporcentaje,"<br>";
			 // echo $contadorcierre,"///<br>";
			 //exit();
			 //$banderaporcentaje = 0;///////////////////  quitar
			
			if($banderaporcentaje == 1)			 
			 { //
				echo "<div align='center'>";
				echo "<span align='center' class='Estilo2 Estilo23 Estilo27 Estilo1 Estilo3'>LISTA DE ESTUDIANTES QUE FALTAN POR NOTA</span>";
				echo "</div>";
				echo "<br>";
?> 
                <table align="center"  bordercolor="#FF9900" border="1" width="50%">
                 <tr>
                 <td>

<?php				
				echo "<table align='center'>";
				echo "<tr  bgcolor='#C5D5D6'>";
				echo "<td align='center' class='Estilo1 Estilo4'><strong>Documento</strong></td>";
				echo "<td align='center' class='Estilo1 Estilo4'><strong>Estudiante</strong></td>";
				echo "<td align='center' class='Estilo1 Estilo4'><strong>Materia</strong></td>";	
				echo "<td align='center' class='Estilo1 Estilo4'><strong>Nombre Materia</strong></td>";			
				echo "<td align='center' class='Estilo1 Estilo4'><strong>Porcentaje Faltante</strong></td>";			
				echo "</tr>";
				echo "<tr>";
			    for($i=1;$i<$contadorfaltantes;$i++)
				  {
				    echo "<td align='center' class='Estilo1 Estilo4'>".$numerodocumentototal[$i]."</td>";	        
					echo "<td align='center' class='Estilo1 Estilo4'>".$nombretotal[$i]."</td>";
					echo "<td align='center' class='Estilo1 Estilo4'>".$codigomateriatotal[$i]."</td>";
					echo "<td align='center' class='Estilo1 Estilo4'>".$nombremateriatotal[$i]."</td>";
					echo "<td align='center' class='Estilo1 Estilo4'>".$faltante[$i]."</td>";    
				    echo "</tr>";				  
				  }		 
			      echo "</table>";			 
?>
                 </td>
                 </tr>
                </table>
<?php			  
			  } // if($banderaporcentaje == 1)
             else
			   {	// else		

				for($i=1;$i<$contadorcierre;$i++)
				  {
					$codigoestudiante=$codigocierre[$i];				
					//echo $codigoestudiante,"<br>";
					require('cierresemestreestudiante.php');					
				  }	 

				for($i=1;$i<$contadorcierre;$i++)
				{		
  				 $codigoestudiante=$codigocierre[$i];				
				 $numero = $numerod[$i];
				 require('cierresemestreperdidacalidad.php');					
				}

				for($i=1;$i<$contadorcierre;$i++)
				{
 			     $codigoestudiante=$codigocierre[$i];				
  				 if ($semestre1[$i] >= 10 or $carrera == '13')
				  {
				    unset($materiasporver);
				    unset($materiasobligatorias); 
				    require('listadofaltantegraduar.php');	
				  }				
					$codigoestudianteantiguo=$codigocierre[$i];
					$cambiotipo = 20;
				

						$query_historicosituacion = "select * 
						from historicotipoestudiante
						where codigoestudiante = '".$codigoestudianteantiguo."'
						order by 1 desc";
						//echo $query_historicosituacion,"<br><br><br>";
						$historicosituacion = mysql_query($query_historicosituacion, $sala) or die("$query_historicosituacion".mysql_error());
						$row_historicosituacion = mysql_fetch_assoc($historicosituacion);
						$totalRows_historicosituacion = mysql_num_rows($historicosituacion);		

						if($row_historicosituacion['codigotipoestudiante'] <> $cambiotipo)
						 {
							$sql1 = "insert into historicotipoestudiante(idhistoricotipoestudiante,codigoestudiante,codigotipoestudiante,codigoperiodo,fechahistoricotipoestudiante,fechainiciohistoricotipoestudiante,fechafinalhistoricotipoestudiante,usuario,iphistoricotipoestudiante)";
		                    $sql1.= "VALUES('0','".$codigoestudianteantiguo."','$cambiotipo','".$row_periodo['codigoperiodo']."','".$fechahoy."','".$fechahoy."','2999-12-31','".$usuario."','$ip')"; 	
		                    $result1 = mysql_query($sql1,$sala);	
						   // echo $sql1,"<br><br><br>";
					        $query_updest1 = "UPDATE historicotipoestudiante
							 SET fechafinalhistoricotipoestudiante = '".$fechahoy."'
							 WHERE idhistoricotipoestudiante = '".$row_historicosituacion['idhistoricotipoestudiante']."'"; 
							 $updest1 = mysql_query($query_updest1,$sala); 	  
							 //echo  $query_updest1,"<br><br><br>";
  					    }				

						 $base1= "update estudiante set 
					     codigotipoestudiante ='$cambiotipo' 		
						 where  codigoestudiante = '".$codigoestudianteantiguo."'";						  
						 $sol1=mysql_db_query($database_sala,$base1);
						// echo  $base1,"<br><br><br>";    				
					}
               
				    $base8="UPDATE procesoperiodo
					SET codigoestadoprocesoperiodo = '200',
					fecharealizoprocesoperiodo = '".date("Y-m-d G:i:s",time())."'
					WHERE codigoperiodo = '$periodoactual'							
					and codigocarrera = '$carrera'
					and idproceso = '1'"; 
				   //echo $base8,";<br>";	
				   $sol8=mysql_db_query($database_sala,$base8) or die("$base8".mysql_error());

		   echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=cierresemestrelistado.php'>";   

		} // else

?>