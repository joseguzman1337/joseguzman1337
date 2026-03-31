<?php 
 require_once('../../Connections/sala2.php' );
   mysql_select_db($database_sala, $sala);	
  $query_periodomatriculados = "SELECT DISTINCT eg.numerodocumento,p.codigoperiodo
  FROM estudiante e,ordenpago o,prematricula p,fechaordenpago f,estudiantegeneral eg
  WHERE e.codigoestudiante = o.codigoestudiante
  AND eg.idestudiantegeneral = e.idestudiantegeneral
  AND o.numeroordenpago = f.numeroordenpago
  AND o.idprematricula = p.idprematricula
  AND o.codigoestadoordenpago LIKE '4%'
  AND p.codigoestadoprematricula LIKE '4%'
  AND e.codigocarrera = '13'
  AND (o.codigoperiodo = '20052' or o.codigoperiodo = '20051' or o.codigoperiodo = '20061') 										   
";	
//echo $query_nuevos,"<br>";
 $periodomatriculados = mysql_query($query_periodomatriculados, $sala) or die(mysql_error());
 $row_periodomatriculados = mysql_fetch_assoc($periodomatriculados);
 $totalRows_periodomatriculados = mysql_num_rows($periodomatriculados);

 do{
      $query_periodomatriculados1= "SELECT DISTINCT eg.numerodocumento,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,c.nombrecarrera
	  FROM estudiante e,ordenpago o,prematricula p,fechaordenpago f,estudiantegeneral eg,carrera c
	  WHERE e.codigoestudiante = o.codigoestudiante
	  AND eg.idestudiantegeneral = e.idestudiantegeneral
	  and c.codigocarrera = e.codigocarrera
	  AND o.numeroordenpago = f.numeroordenpago	 
	  AND o.idprematricula = p.idprematricula
	  AND (o.codigoestadoordenpago LIKE '4%') 
	  AND (p.codigoestadoprematricula LIKE '4%')
	  AND p.idprematricula = o.idprematricula 
	  AND o.codigoperiodo = '20062'										   
	  and eg.numerodocumento = '".$row_periodomatriculados['numerodocumento']."'";	
    // echo  $query_periodomatriculados1,"<br><br><br><br><br>";
     $periodomatriculados1 = mysql_query($query_periodomatriculados1, $sala) or die(mysql_error());
     $row_periodomatriculados1 = mysql_fetch_assoc($periodomatriculados1);
     $totalRows_periodomatriculados1 = mysql_num_rows($periodomatriculados1);

     if ($row_periodomatriculados1 <> "")
	  {
	    echo $row_periodomatriculados1['numerodocumento'],",&nbsp;",$row_periodomatriculados1['apellidosestudiantegeneral'],"&nbsp;",$row_periodomatriculados1['nombresestudiantegeneral'],",&nbsp;",$row_periodomatriculados1['nombrecarrera'],",&nbsp;",$row_periodomatriculados['codigoperiodo'],"<br>";
	  }

 }while($row_periodomatriculados = mysql_fetch_assoc($periodomatriculados));


?>