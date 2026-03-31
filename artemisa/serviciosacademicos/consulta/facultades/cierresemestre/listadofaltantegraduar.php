<?php require_once('../../../Connections/sala2.php');
session_start();
$codigocarrera = $_SESSION['codigofacultad'];
//require('funcionmateriaaprobada.php'); //quitar

mysql_select_db($database_sala, $sala);
$query_semestrecarrera = "SELECT nombrecarrera,MAX(semestredetalleplanestudio * 1) AS mayor
						FROM planestudio p,detalleplanestudio d,carrera c
						WHERE p.idplanestudio = d.idplanestudio
						AND c.codigocarrera = p.codigocarrera
						AND p.codigoestadoplanestudio LIKE '1%'
						and p.codigocarrera = '$codigocarrera' 
						GROUP by 1						                         
	";	
//echo $query_semestrecarrera,"<br>";
$semestrecarrera = mysql_query($query_semestrecarrera, $sala) or die(mysql_error());
$row_semestrecarrera = mysql_fetch_assoc($semestrecarrera);
$totalRows_semestrecarrera = mysql_num_rows($semestrecarrera);


unset($materiaspropuestas);
//unset($codigoestudiante);
unset($totalmaterias);
unset($semestre);
$cuentamateriaspendientes = 0;

require('generarcargaestudiante.php'); 
 if ($materiaspropuestas <> "")
   {
		foreach($materiaspropuestas as $k => $v)
		 {   
		  //echo $v['codigomateria'],"&nbsp;",$codigoestudiante,"propuestas<br>";
		  $totalmaterias[] = $v['codigomateria'];
		 }
   }
 if ($materiasobligatorias <> "")
   {
		foreach($materiasobligatorias as $k1 => $v1)
		 {   
		  //echo $v1['codigomateria'],"&nbsp;",$codigoestudiante,"aca<br>";
		  $totalmaterias[] = $v1['codigomateria'];
		 }
    }
/*
 if ($totalmaterias == "")
  {
    echo "No hay materias pendientes";
  }
 else
  {
    foreach($totalmaterias as $k1 => $v1)
		 {   
		  echo $v1['codigomateria'],"&nbsp;",$codigoestudiante,"aca<br>";
		  //$totalmaterias[] = $v1['codigomateria'];
		 }
  }
*/
if ($totalmaterias == "")
 {
     $cambiosituacion = 104;
								
   $query_historicosituacion = "select * 
	from historicosituacionestudiante
	where codigoestudiante = '".$codigoestudiante."'
	order by 1 desc
	";
	$historicosituacion = mysql_query($query_historicosituacion, $sala) or die("$query_historicosituacion".mysql_error());
	$row_historicosituacion = mysql_fetch_assoc($historicosituacion);
	$totalRows_historicosituacion = mysql_num_rows($historicosituacion);		
								 
	 if($row_historicosituacion['codigosituacioncarreraestudiante'] <> $cambiosituacion)
	 {
		$sql = "insert into historicosituacionestudiante(idhistoricosituacionestudiante,codigoestudiante,codigosituacioncarreraestudiante,codigoperiodo,fechahistoricosituacionestudiante,fechainiciohistoricosituacionestudiante,fechafinalhistoricosituacionestudiante,usuario)";
		$sql.= "VALUES('0','".$codigoestudiante."','$cambiosituacion','".$periodoactual."','".$fechahoy."','".$fechahoy."','2999-12-31','".$usuario."')"; 	
	   //echo $sql,"<br>";
		 $result = mysql_query($sql,$sala);		
	     $query_updest1 = "UPDATE historicosituacionestudiante
	     SET fechafinalhistoricosituacionestudiante = '".$fechahoy."'
	     WHERE idhistoricosituacionestudiante = '".$row_historicosituacion['idhistoricosituacionestudiante']."'"; 
	     $updest1 = mysql_query($query_updest1,$sala);	  
	} 
								
	$query_updest1= "update estudiante set 
	codigosituacioncarreraestudiante ='$cambiosituacion' 		
	where  codigoestudiante = '".$codigoestudiante."'";     
	//echo $query_updest1,"<br><br><br>";
	$updest1 = mysql_query($query_updest1,$sala);				    
 } 
unset($materiaspropuestas);
unset($codigoestudiante);
unset($value1);
unset($key3);
unset($value3);
?>

 