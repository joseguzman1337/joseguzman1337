<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

   require_once('../../../Connections/sala2.php');
  mysql_select_db($database_sala, $sala);
  $query_dataestudiante = "SELECT  COUNT(*) AS cuenta ,pe.idplanestudio,pe.codigoestudiante,c.nombrecarrera,eg.numerodocumento
  FROM planestudioestudiante pe,estudiante e,carrera c,estudiantegeneral eg
  WHERE pe.codigoestudiante =  e.codigoestudiante
  AND c.codigocarrera = e.codigocarrera
  AND eg.idestudiantegeneral = e.idestudiantegeneral 
  AND pe.codigoestadoplanestudioestudiante LIKE '1%'
  GROUP by 3
  HAVING cuenta >= 2 
  ORDER BY 4 DESC";
  $dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
  $row_dataestudiante = mysql_fetch_assoc($dataestudiante);
  $totalRows_dataestudiante = mysql_num_rows($dataestudiante);

   do{	
	  $query_dataestudiante1 = "SELECT *
	  FROM planestudioestudiante pe,estudiante e,carrera c,estudiantegeneral eg
	  WHERE pe.codigoestudiante =  e.codigoestudiante
	  AND c.codigocarrera = e.codigocarrera
	  AND eg.idestudiantegeneral = e.idestudiantegeneral 
	  AND pe.codigoestadoplanestudioestudiante LIKE '1%'
	  and e.codigoestudiante = '".$row_dataestudiante['codigoestudiante']."'";
	  $dataestudiante1 = mysql_query($query_dataestudiante1, $sala) or die("$query_dataestudiante1".mysql_error());
	  $row_dataestudiante1 = mysql_fetch_assoc($dataestudiante1);
	  $totalRows_dataestudiante1 = mysql_num_rows($dataestudiante1);
	 
	  if ($totalRows_dataestudiante1 >= 2)
	   {
		 do{
			 if ($row_dataestudiante1['idplanestudio'] == 1)
			  {			
			     $base8="UPDATE planestudioestudiante
				 SET codigoestadoplanestudioestudiante = '200'				 
				 WHERE codigoestudiante = '".$row_dataestudiante1['codigoestudiante']."'				 
				 and idplanestudio = '1'"; 
				 echo $base8,"<br>";	
				 $sol8=mysql_db_query($database_sala,$base8) or die("$base8".mysql_error());
				
				//echo $row_dataestudiante1['codigoestudiante']."&nbsp;&nbsp;". $row_dataestudiante1['idplanestudio'],"<br>";
		      }		
		}while( $row_dataestudiante1 = mysql_fetch_assoc($dataestudiante1)); 
	   }
 }while($row_dataestudiante = mysql_fetch_assoc($dataestudiante)); 
?>