<?php require_once('../../../Connections/sala2.php');
  //@session_start();
   mysql_select_db($database_sala, $sala);
  $query_periodo = "SELECT * FROM periodo
  where codigoestadoperiodo = 1";
  $periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
  $row_periodo= mysql_fetch_assoc($periodo);
  $totalRows_periodo = mysql_num_rows($periodo); 
 $periodo =  $row_periodo['codigoperiodo'];
 
  $fecha = date("Y-m-d G:i:s",time());
 
?>
<form name="form1" method="post" action="listadogeneralmatriculados.php">
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Listado General</title>
<style type="text/css">
<!--
.Estilo1 {
	font-family: tahoma;
	font-weight: bold;
	font-size: small;
}
.Estilo2 {font-family: tahoma}
.Estilo3 {font-size: xx-small}
.Estilo5 {font-size: x-small}
.Estilo6 {font-family: tahoma; font-size: x-small; }
.Estilo7 {font-family: tahoma; font-size: x-small; font-weight: bold; }
.Estilo8 {font-family: tahoma; font-size: xx-small; }
-->
</style>
</head>
<body>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo3 {font-size: xx-small}
.Estilo13 {
	font-size: 14px;
	font-weight: bold;
}
.Estilo14 {font-size: 12px}
-->
</style>
<?php
  $query_modalidad = "SELECT * FROM modalidadacademica 
  where codigomodalidadacademica not like '5%'
  order by 1 desc";
  $modalidad = mysql_query($query_modalidad, $sala) or die(mysql_error());
  $row_modalidad = mysql_fetch_assoc($modalidad);
  $totalRows_modalidad = mysql_num_rows($modalidad); 


  $query_car = "SELECT distinct nombrecarrera,codigocarrera,codigomodalidadacademica
  FROM carrera
  WHERE fechavencimientocarrera > '".$fecha."'
  and codigomodalidadacademica = '".$_POST['modalidad']."'	
  order by 1 ";		
 // echo $query_car;
  $car = mysql_query($query_car, $sala) or die(mysql_error());
  $row_car = mysql_fetch_assoc($car);
  $totalRows_car = mysql_num_rows($car);
  
  if ($_POST['buscar'] or $_POST['detalle'])
   { // buscar

	 if ($_POST['modalidad'] == 0) 
	  { // modalidad 0
	    if ($_POST['estudiante'] == 0) 
		 { // estudiante
		    if ($_POST['procedencia'] == 1)
              {	// procedencia	
				if ($_POST['listadocolegios'] <> 0)
				 {				
					$query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,estudiante e,ordenpago o,prematricula p,estudianteestudio ee
					WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					AND e.codigoestudiante = o.codigoestudiante
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND ee.idinstitucioneducativa = '".$_POST['listadocolegios']."'
					AND p.idprematricula = o.idprematricula
					AND p.semestreprematricula = 1
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					UNION 
					SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND ee.idinstitucioneducativa = '".$_POST['listadocolegios']."'
					AND (i.codigosituacioncarreraestudiante = 300 or i.codigosituacioncarreraestudiante = 107)
					AND i.codigoperiodo = '$periodo'
					AND i.codigoestado LIKE '1%'
					ORDER BY 2";		
					 //echo $query_estudiantes,"&nbsp;1";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
		        }
			   else
			    {
				  $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,estudiante e,ordenpago o,prematricula p,estudianteestudio ee
					WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					AND e.codigoestudiante = o.codigoestudiante
					AND ee.idestudiantegeneral = eg.idestudiantegeneral					
					AND p.idprematricula = o.idprematricula
					AND p.semestreprematricula = 1
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					UNION 
					SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral					
					AND (i.codigosituacioncarreraestudiante = 300 or i.codigosituacioncarreraestudiante = 107)
					AND i.codigoperiodo = '$periodo'
					AND i.codigoestado LIKE '1%'
					ORDER BY 2";		
					// echo $query_estudiantes,"&nbsp;1";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
				
				}
			 }
			else
			 {
			  
			   if ($_POST['departamento'] <> "todos")
				 {		
					echo "entro";
					$query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e
					WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ee.idestudiantegeneral = eg.idestudiantegeneral 
					AND p.codigoestudiante = e.codigoestudiante
					AND e.idestudiantegeneral = eg.idestudiantegeneral
					AND o.idprematricula = p.idprematricula
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					AND p.semestreprematricula = 1
					AND i.departamentoinstitucioneducativa = '".$_POST['departamento']."'
					UNION
					SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND (i.codigosituacioncarreraestudiante = 300 or i.codigosituacioncarreraestudiante = 107)
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ie.departamentoinstitucioneducativa = '".$_POST['departamento']."'
					AND i.codigoperiodo = '$periodo'
					AND i.codigoestado LIKE '1%'
					ORDER BY 2";		
					//echo $query_estudiantes ,"&nbsp;2.1";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
			    }
			  else
			    {
				  $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e
					WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ee.idestudiantegeneral = eg.idestudiantegeneral 
					AND p.codigoestudiante = e.codigoestudiante
					AND e.idestudiantegeneral = eg.idestudiantegeneral
					AND o.idprematricula = p.idprematricula
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					AND p.semestreprematricula = 1					
					UNION
					SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND (i.codigosituacioncarreraestudiante = 300 or i.codigosituacioncarreraestudiante = 107)
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa					
					AND i.codigoperiodo = '$periodo'
					AND i.codigoestado LIKE '1%'
					ORDER BY 2";		
					//echo $query_estudiantes ,"&nbsp;2.2";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
				
				}
			 
			 } // procedencia			 
		 }	// estudiante
		else
		if ($_POST['estudiante'] == 1) 		 
		 {
		    if ($_POST['procedencia'] == 1)
              {	// procedencia	
				
				if ($_POST['listadocolegios'] <> 0)
				{			 
					
			        $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND (i.codigosituacioncarreraestudiante = 107 or i.codigosituacioncarreraestudiante = 300)
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa					
					AND ee.idinstitucioneducativa = '".$_POST['listadocolegios']."'
					AND i.codigoestado LIKE '1%'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2
					";		
					 //echo $query_estudiantes,"&nbsp;prueba1";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);		
				
				}
				else
				{
				   $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND (i.codigosituacioncarreraestudiante = 107 or i.codigosituacioncarreraestudiante = 300)
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa					
					AND i.codigoestado LIKE '1%'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2
					";		
					// echo $query_estudiantes,"&nbsp;prueba2";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);					
				}
				
				
				 $conestos = "";						
				 do{
				     
					  if ($_POST['listadocolegios'] <> 0)
				      {	
					    $query_estudiantes1 = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
						FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e,carrera c
						WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
						AND ee.idestudiantegeneral = eg.idestudiantegeneral 
						AND p.codigoestudiante = e.codigoestudiante
						AND e.idestudiantegeneral = eg.idestudiantegeneral
						AND o.idprematricula = p.idprematricula
						AND e.codigocarrera = c.codigocarrera						
						AND o.codigoestadoordenpago LIKE '4%'
						AND p.codigoestadoprematricula LIKE '4%'
						AND o.codigoperiodo = '$periodo'
						AND p.semestreprematricula = 1
						AND ee.idinstitucioneducativa = '".$_POST['listadocolegios']."'
						and eg.numerodocumento = '".$row_estudiantes['numerodocumento']."'
						";		
						///echo $query_estudiantes1,"&nbsp;10<br>";
						$estudiantes1 = mysql_query($query_estudiantes1, $sala) or die(mysql_error());
						$row_estudiantes1 = mysql_fetch_assoc($estudiantes1);
						$totalRows_estudiantes1 = mysql_num_rows($estudiantes1);	
					  }
					  else
					   {
					     $query_estudiantes1 = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
						FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e,carrera c
						WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
						AND ee.idestudiantegeneral = eg.idestudiantegeneral 
						AND p.codigoestudiante = e.codigoestudiante
						AND e.idestudiantegeneral = eg.idestudiantegeneral
						AND o.idprematricula = p.idprematricula
						AND e.codigocarrera = c.codigocarrera						
						AND o.codigoestadoordenpago LIKE '4%'
						AND p.codigoestadoprematricula LIKE '4%'
						AND o.codigoperiodo = '$periodo'
						AND p.semestreprematricula = 1						
						and eg.numerodocumento = '".$row_estudiantes['numerodocumento']."'
						";		
						 //echo $query_estudiantes1,"&nbsp;10<br>";
						$estudiantes1 = mysql_query($query_estudiantes1, $sala) or die(mysql_error());
						$row_estudiantes1 = mysql_fetch_assoc($estudiantes1);
						$totalRows_estudiantes1 = mysql_num_rows($estudiantes1);	
					   
					   }  
						if (! $row_estudiantes1)
						 {
						      if ($conestos <> "")
							   {							  
							    $conestos = $conestos . " or eg.numerodocumento =" . $row_estudiantes['numerodocumento']; 
							   }
							  else
							   {
							    $conestos = "eg.numerodocumento =" . $row_estudiantes['numerodocumento']; 
							   }
							$contador++;
					       //echo $contador,"<br>";
						  }
					
				 }while($row_estudiantes = mysql_fetch_assoc($estudiantes));
			    
			  
			     if ($_POST['listadocolegios'] <> 0)
				 {	
					 $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral					
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa					
					AND ee.idinstitucioneducativa = '".$_POST['listadocolegios']."'
					and ($conestos)
					AND i.codigoestado LIKE '1%'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2
					";						 
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);			
			     }
				else
				 {
				  
				    $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral					
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa									
					and ($conestos)
					AND i.codigoestado LIKE '1%'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2
					";		
					// echo $query_estudiantes,"&nbsp;<br><br><br>";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);			
				 } 		
				
				
			 }			
			else
			 {
			   if ($_POST['departamento'] <> "todos")
				 {	
			  
					 $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND (i.codigosituacioncarreraestudiante = 107 or i.codigosituacioncarreraestudiante = 300)
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa					
					AND ie.departamentoinstitucioneducativa = '".$_POST['departamento']."'
					AND i.codigoestado LIKE '1%'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2
					";		
					// echo $query_estudiantes,"&nbsp;prueba";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);		
				
				}
				else
				{
				   $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND (i.codigosituacioncarreraestudiante = 107 or i.codigosituacioncarreraestudiante = 300)
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa					
					AND i.codigoestado LIKE '1%'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2
					";		
					// echo $query_estudiantes,"&nbsp;prueba";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);					
				}
				
				
				 $conestos = "";				
				 do{
				     
					  if ($_POST['departamento'] <> "todos")
				      {	
					    $query_estudiantes1 = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
						FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e,carrera c
						WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
						AND ee.idestudiantegeneral = eg.idestudiantegeneral 
						AND p.codigoestudiante = e.codigoestudiante
						AND e.idestudiantegeneral = eg.idestudiantegeneral
						AND o.idprematricula = p.idprematricula
						AND e.codigocarrera = c.codigocarrera						
						AND o.codigoestadoordenpago LIKE '4%'
						AND p.codigoestadoprematricula LIKE '4%'
						AND o.codigoperiodo = '$periodo'
						AND p.semestreprematricula = 1
						AND i.departamentoinstitucioneducativa = '".$_POST['departamento']."'
						and eg.numerodocumento = '".$row_estudiantes['numerodocumento']."'
						";		
						 //echo $query_estudiantes1,"&nbsp;10<br>";
						$estudiantes1 = mysql_query($query_estudiantes1, $sala) or die(mysql_error());
						$row_estudiantes1 = mysql_fetch_assoc($estudiantes1);
						$totalRows_estudiantes1 = mysql_num_rows($estudiantes1);	
					  }
					  else
					   {
					     $query_estudiantes1 = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
						FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e,carrera c
						WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
						AND ee.idestudiantegeneral = eg.idestudiantegeneral 
						AND p.codigoestudiante = e.codigoestudiante
						AND e.idestudiantegeneral = eg.idestudiantegeneral
						AND o.idprematricula = p.idprematricula
						AND e.codigocarrera = c.codigocarrera						
						AND o.codigoestadoordenpago LIKE '4%'
						AND p.codigoestadoprematricula LIKE '4%'
						AND o.codigoperiodo = '$periodo'
						AND p.semestreprematricula = 1						
						and eg.numerodocumento = '".$row_estudiantes['numerodocumento']."'
						";		
						 //echo $query_estudiantes1,"&nbsp;10<br>";
						$estudiantes1 = mysql_query($query_estudiantes1, $sala) or die(mysql_error());
						$row_estudiantes1 = mysql_fetch_assoc($estudiantes1);
						$totalRows_estudiantes1 = mysql_num_rows($estudiantes1);	
					   
					   }  
						if (! $row_estudiantes1)
						 {
						      if ($conestos <> "")
							   {							  
							    $conestos = $conestos . " or eg.numerodocumento =" . $row_estudiantes['numerodocumento']; 
							   }
							  else
							   {
							    $conestos = "eg.numerodocumento =" . $row_estudiantes['numerodocumento']; 
							   }
							$contador++;
					        //*echo $contador,"<br>";
						  }
					
				 }while($row_estudiantes = mysql_fetch_assoc($estudiantes));
			    
			  
			    if ($_POST['departamento'] <> "todos")
				 {	
					 $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral					
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa					
					AND ie.departamentoinstitucioneducativa = '".$_POST['departamento']."'
					and ($conestos)
					AND i.codigoestado LIKE '1%'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2
					";						 
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);			
			     }
				else
				 {
				  
				    $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral					
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa							
					and ($conestos)
					AND i.codigoestado LIKE '1%'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2
					";		
					// echo $query_estudiantes,"&nbsp;<br><br><br>";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);			
				 } 
			
			
			 } // procedencia	
			 
		 }	// estudiante
        else
		if ($_POST['estudiante'] == 2) 		 
		 {
		    if ($_POST['procedencia'] == 1)
              {	// procedencia	
				
				if ($_POST['listadocolegios'] <> 0)
				{		
					$query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,estudiante e,ordenpago o,prematricula p,estudianteestudio ee
					WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					AND e.codigoestudiante = o.codigoestudiante
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND ee.idinstitucioneducativa = '".$_POST['listadocolegios']."'
					AND p.idprematricula = o.idprematricula
					AND p.semestreprematricula = 1
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					";		
					//echo $query_estudiantes,"&nbsp;5";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
		       }
			  else
			   {
			     $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,estudiante e,ordenpago o,prematricula p,estudianteestudio ee
					WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					AND e.codigoestudiante = o.codigoestudiante
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND p.idprematricula = o.idprematricula
					AND p.semestreprematricula = 1
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					";		
					//echo $query_estudiantes,"&nbsp;5";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
			   }
			 }
			else
			 {
			    if ($_POST['departamento'] <> "todos")
				 {	
					$query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e
					WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ee.idestudiantegeneral = eg.idestudiantegeneral 
					AND p.codigoestudiante = e.codigoestudiante
					AND e.idestudiantegeneral = eg.idestudiantegeneral
					AND o.idprematricula = p.idprematricula
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					AND p.semestreprematricula = 1
					AND i.departamentoinstitucioneducativa = '".$_POST['departamento']."'";		
					// echo $query_estudiantes,"&nbsp;6";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
			     }
				 else
				  {
				    $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e
					WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ee.idestudiantegeneral = eg.idestudiantegeneral 
					AND p.codigoestudiante = e.codigoestudiante
					AND e.idestudiantegeneral = eg.idestudiantegeneral
					AND o.idprematricula = p.idprematricula
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					AND p.semestreprematricula = 1
					";		
					//echo $query_estudiantes,"&nbsp;6";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
				  
				  }
			 } // procedencia	
			 
		 }	// estudiante
		 
	  } // modalidad 0  
     else
	   { // else modalidad
	    if ($_POST['carrera'] == 0)
		 { // carrera = 0
	       if ($_POST['estudiante'] == 0) 
		   { // estudiante
		    if ($_POST['procedencia'] == 1)
              {	// procedencia	
				
				if ($_POST['listadocolegios'] <> 0)
				{	
					$query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,estudiante e,ordenpago o,prematricula p,estudianteestudio ee,carrera c
					WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					AND e.codigoestudiante = o.codigoestudiante
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND ee.idinstitucioneducativa = '".$_POST['listadocolegios']."'
					AND e.codigocarrera = c.codigocarrera
					AND c.codigomodalidadacademica = '".$_POST['modalidad']."'
					AND p.idprematricula = o.idprematricula
					AND p.semestreprematricula = 1
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					UNION 
					SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND ee.idinstitucioneducativa = '".$_POST['listadocolegios']."'
					AND i.codigomodalidadacademica = '".$_POST['modalidad']."'
					AND (i.codigosituacioncarreraestudiante = 300 or i.codigosituacioncarreraestudiante = 107)
					AND i.codigoperiodo = '$periodo'
					AND i.codigoestado LIKE '1%'
					ORDER BY 2";		
					 //echo $query_estudiantes,"&nbsp;7";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
		       }
			  else
			   {
			     $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,estudiante e,ordenpago o,prematricula p,estudianteestudio ee,carrera c
					WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					AND e.codigoestudiante = o.codigoestudiante
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND e.codigocarrera = c.codigocarrera
					AND c.codigomodalidadacademica = '".$_POST['modalidad']."'
					AND p.idprematricula = o.idprematricula
					AND p.semestreprematricula = 1
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					UNION 
					SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND i.codigomodalidadacademica = '".$_POST['modalidad']."'
					AND (i.codigosituacioncarreraestudiante = 300 or i.codigosituacioncarreraestudiante = 107)
					AND i.codigoperiodo = '$periodo'
					AND i.codigoestado LIKE '1%'
					ORDER BY 2";		
					 //echo $query_estudiantes,"&nbsp;7";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
			   
			   }
			 }
			else
			 {
			    if ($_POST['departamento'] <> "todos")
				 {	
					$query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e,carrera c
					WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ee.idestudiantegeneral = eg.idestudiantegeneral 
					AND p.codigoestudiante = e.codigoestudiante
					AND e.idestudiantegeneral = eg.idestudiantegeneral
					AND o.idprematricula = p.idprematricula
					AND e.codigocarrera = c.codigocarrera
					AND c.codigomodalidadacademica = '".$_POST['modalidad']."'
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					AND p.semestreprematricula = 1
					AND i.departamentoinstitucioneducativa = '".$_POST['departamento']."'
					UNION
					SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND (i.codigosituacioncarreraestudiante = 300 OR i.codigosituacioncarreraestudiante = 107)
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa
					AND i.codigomodalidadacademica = '".$_POST['modalidad']."'
					AND ie.departamentoinstitucioneducativa = '".$_POST['departamento']."'
					AND i.codigoestado LIKE '1%'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2";		
					// echo $query_estudiantes,"&nbsp;8";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
			     }
				else
				{
				  $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e,carrera c
					WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ee.idestudiantegeneral = eg.idestudiantegeneral 
					AND p.codigoestudiante = e.codigoestudiante
					AND e.idestudiantegeneral = eg.idestudiantegeneral
					AND o.idprematricula = p.idprematricula
					AND e.codigocarrera = c.codigocarrera
					AND c.codigomodalidadacademica = '".$_POST['modalidad']."'
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					AND p.semestreprematricula = 1					
					UNION
					SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND (i.codigosituacioncarreraestudiante = 300 OR i.codigosituacioncarreraestudiante = 107)
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa
					AND i.codigomodalidadacademica = '".$_POST['modalidad']."'					
					AND i.codigoestado LIKE '1%'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2";		
					// echo $query_estudiantes,"&nbsp;8";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
				
				}
			 } // procedencia	
			 
		 }	// estudiante
		else
		if ($_POST['estudiante'] == 1) 		 
		 {		
			if ($_POST['procedencia'] == 1)
              {	// procedencia	
				
				if ($_POST['listadocolegios'] <> 0)
				{	
					
			        $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND (i.codigosituacioncarreraestudiante = 107 or i.codigosituacioncarreraestudiante = 300)
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa
					AND i.codigomodalidadacademica = '".$_POST['modalidad']."'
					AND ee.idinstitucioneducativa = '".$_POST['listadocolegios']."'
					AND i.codigoestado LIKE '1%'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2
					";		
					 //echo $query_estudiantes,"&nbsp;prueba1";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);		
				
				}
				else
				{
				   $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND (i.codigosituacioncarreraestudiante = 107 or i.codigosituacioncarreraestudiante = 300)
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa
					AND i.codigomodalidadacademica = '".$_POST['modalidad']."'
					AND i.codigoestado LIKE '1%'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2
					";		
					// echo $query_estudiantes,"&nbsp;prueba2";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);					
				}
				
				
				 $conestos = "";		
				 $contador = "";		
				 do{
				     
					  if ($_POST['listadocolegios'] <> 0)
				      {	
					    $query_estudiantes1 = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
						FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e,carrera c
						WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
						AND ee.idestudiantegeneral = eg.idestudiantegeneral 
						AND p.codigoestudiante = e.codigoestudiante
						AND e.idestudiantegeneral = eg.idestudiantegeneral
						AND o.idprematricula = p.idprematricula
						AND e.codigocarrera = c.codigocarrera
						AND c.codigomodalidadacademica = '".$_POST['modalidad']."'
						AND o.codigoestadoordenpago LIKE '4%'
						AND p.codigoestadoprematricula LIKE '4%'
						AND o.codigoperiodo = '$periodo'
						AND p.semestreprematricula = 1
						AND ee.idinstitucioneducativa = '".$_POST['listadocolegios']."'
						and eg.numerodocumento = '".$row_estudiantes['numerodocumento']."'
						";		
						///echo $query_estudiantes1,"&nbsp;10<br>";
						$estudiantes1 = mysql_query($query_estudiantes1, $sala) or die(mysql_error());
						$row_estudiantes1 = mysql_fetch_assoc($estudiantes1);
						$totalRows_estudiantes1 = mysql_num_rows($estudiantes1);	
					  }
					  else
					   {
					     $query_estudiantes1 = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
						FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e,carrera c
						WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
						AND ee.idestudiantegeneral = eg.idestudiantegeneral 
						AND p.codigoestudiante = e.codigoestudiante
						AND e.idestudiantegeneral = eg.idestudiantegeneral
						AND o.idprematricula = p.idprematricula
						AND e.codigocarrera = c.codigocarrera
						AND c.codigomodalidadacademica = '".$_POST['modalidad']."'
						AND o.codigoestadoordenpago LIKE '4%'
						AND p.codigoestadoprematricula LIKE '4%'
						AND o.codigoperiodo = '$periodo'
						AND p.semestreprematricula = 1						
						and eg.numerodocumento = '".$row_estudiantes['numerodocumento']."'
						";		
						 //echo $query_estudiantes1,"&nbsp;10<br>";
						$estudiantes1 = mysql_query($query_estudiantes1, $sala) or die(mysql_error());
						$row_estudiantes1 = mysql_fetch_assoc($estudiantes1);
						$totalRows_estudiantes1 = mysql_num_rows($estudiantes1);	
					   
					   }  
						if (! $row_estudiantes1)
						 {
						      if ($conestos <> "")
							   {							  
							    $conestos = $conestos . " or eg.numerodocumento =" . $row_estudiantes['numerodocumento']; 
							   }
							  else
							   {
							    $conestos = "eg.numerodocumento =" . $row_estudiantes['numerodocumento']; 
							   }
							$contador++;
					       //echo $contador,"<br>";
						  }
					
				 }while($row_estudiantes = mysql_fetch_assoc($estudiantes));
			    
			  
			     if ($_POST['listadocolegios'] <> 0)
				 {	
					 $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral					
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa
					AND i.codigomodalidadacademica = '".$_POST['modalidad']."'
					AND ee.idinstitucioneducativa = '".$_POST['listadocolegios']."'
					and ($conestos)
					AND i.codigoestado LIKE '1%'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2
					";						 
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);			
			     }
				else
				 {
				  
				    $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral					
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa
					AND i.codigomodalidadacademica = '".$_POST['modalidad']."'					
					and ($conestos)
					AND i.codigoestado LIKE '1%'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2
					";		
					// echo $query_estudiantes,"&nbsp;<br><br><br>";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);			
				 } 		
				
				
			 }
			else
			 {			  
			  if ($_POST['departamento'] <> "todos")
				 {	
			  
					 $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND (i.codigosituacioncarreraestudiante = 107 or i.codigosituacioncarreraestudiante = 300)
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa
					AND i.codigomodalidadacademica = '".$_POST['modalidad']."'
					AND ie.departamentoinstitucioneducativa = '".$_POST['departamento']."'
					AND i.codigoestado LIKE '1%'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2
					";		
					// echo $query_estudiantes,"&nbsp;prueba";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);		
				
				}
				else
				{
				   $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND (i.codigosituacioncarreraestudiante = 107 or i.codigosituacioncarreraestudiante = 300)
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa
					AND i.codigomodalidadacademica = '".$_POST['modalidad']."'
					AND i.codigoestado LIKE '1%'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2
					";		
					// echo $query_estudiantes,"&nbsp;prueba";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);					
				}
				
				
				 $conestos = "";				
				 do{
				     
					  if ($_POST['departamento'] <> "todos")
				      {	
					    $query_estudiantes1 = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
						FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e,carrera c
						WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
						AND ee.idestudiantegeneral = eg.idestudiantegeneral 
						AND p.codigoestudiante = e.codigoestudiante
						AND e.idestudiantegeneral = eg.idestudiantegeneral
						AND o.idprematricula = p.idprematricula
						AND e.codigocarrera = c.codigocarrera
						AND c.codigomodalidadacademica = '".$_POST['modalidad']."'
						AND o.codigoestadoordenpago LIKE '4%'
						AND p.codigoestadoprematricula LIKE '4%'
						AND o.codigoperiodo = '$periodo'
						AND p.semestreprematricula = 1
						AND i.departamentoinstitucioneducativa = '".$_POST['departamento']."'
						and eg.numerodocumento = '".$row_estudiantes['numerodocumento']."'
						";		
						 //echo $query_estudiantes1,"&nbsp;10<br>";
						$estudiantes1 = mysql_query($query_estudiantes1, $sala) or die(mysql_error());
						$row_estudiantes1 = mysql_fetch_assoc($estudiantes1);
						$totalRows_estudiantes1 = mysql_num_rows($estudiantes1);	
					  }
					  else
					   {
					     $query_estudiantes1 = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
						FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e,carrera c
						WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
						AND ee.idestudiantegeneral = eg.idestudiantegeneral 
						AND p.codigoestudiante = e.codigoestudiante
						AND e.idestudiantegeneral = eg.idestudiantegeneral
						AND o.idprematricula = p.idprematricula
						AND e.codigocarrera = c.codigocarrera
						AND c.codigomodalidadacademica = '".$_POST['modalidad']."'
						AND o.codigoestadoordenpago LIKE '4%'
						AND p.codigoestadoprematricula LIKE '4%'
						AND o.codigoperiodo = '$periodo'
						AND p.semestreprematricula = 1						
						and eg.numerodocumento = '".$row_estudiantes['numerodocumento']."'
						";		
						 //echo $query_estudiantes1,"&nbsp;10<br>";
						$estudiantes1 = mysql_query($query_estudiantes1, $sala) or die(mysql_error());
						$row_estudiantes1 = mysql_fetch_assoc($estudiantes1);
						$totalRows_estudiantes1 = mysql_num_rows($estudiantes1);	
					   
					   }  
						if (! $row_estudiantes1)
						 {
						      if ($conestos <> "")
							   {							  
							    $conestos = $conestos . " or eg.numerodocumento =" . $row_estudiantes['numerodocumento']; 
							   }
							  else
							   {
							    $conestos = "eg.numerodocumento =" . $row_estudiantes['numerodocumento']; 
							   }
							$contador++;
					        //*echo $contador,"<br>";
						  }
					
				 }while($row_estudiantes = mysql_fetch_assoc($estudiantes));
			    
			  
			    if ($_POST['departamento'] <> "todos")
				 {	
					 $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral					
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa
					AND i.codigomodalidadacademica = '".$_POST['modalidad']."'
					AND ie.departamentoinstitucioneducativa = '".$_POST['departamento']."'
					and ($conestos)
					AND i.codigoestado LIKE '1%'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2
					";						 
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);			
			     }
				else
				 {
				  
				    $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral					
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa
					AND i.codigomodalidadacademica = '".$_POST['modalidad']."'					
					and ($conestos)
					AND i.codigoestado LIKE '1%'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2
					";		
					// echo $query_estudiantes,"&nbsp;<br><br><br>";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);			
				 } 
			 } // procedencia	
			 
		 }	// estudiante
        else
		if ($_POST['estudiante'] == 2) 		 
		 {
		    if ($_POST['procedencia'] == 1)
              {	// procedencia	
				if ($_POST['listadocolegios'] <> 0)
				{	
					$query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,estudiante e,ordenpago o,prematricula p,estudianteestudio ee,carrera c
					WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					AND e.codigoestudiante = o.codigoestudiante
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND ee.idinstitucioneducativa = '".$_POST['listadocolegios']."'
					AND e.codigocarrera = c.codigocarrera
					AND c.codigomodalidadacademica = '".$_POST['modalidad']."'
					AND p.idprematricula = o.idprematricula
					AND p.semestreprematricula = 1
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					";		
					 //echo $query_estudiantes,"&nbsp;11";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
		        }
			  else
			   {
			     $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,estudiante e,ordenpago o,prematricula p,estudianteestudio ee,carrera c
					WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					AND e.codigoestudiante = o.codigoestudiante
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND e.codigocarrera = c.codigocarrera
					AND c.codigomodalidadacademica = '".$_POST['modalidad']."'
					AND p.idprematricula = o.idprematricula
					AND p.semestreprematricula = 1
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					";		
					 //echo $query_estudiantes,"&nbsp;11";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
			   
			   }
			 }
			else
			 {
			    if ($_POST['departamento'] <> "todos")
				 {	
			  
					$query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e,carrera c
					WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ee.idestudiantegeneral = eg.idestudiantegeneral 
					AND p.codigoestudiante = e.codigoestudiante
					AND e.idestudiantegeneral = eg.idestudiantegeneral
					AND o.idprematricula = p.idprematricula
					AND e.codigocarrera = c.codigocarrera				
					AND c.codigomodalidadacademica = '".$_POST['modalidad']."'
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					AND p.semestreprematricula = 1
					AND i.departamentoinstitucioneducativa = '".$_POST['departamento']."'";		
					// echo $query_estudiantes,"&nbsp;12";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
			     }
				 else
				  {
				    $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e,carrera c
					WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ee.idestudiantegeneral = eg.idestudiantegeneral 
					AND p.codigoestudiante = e.codigoestudiante
					AND e.idestudiantegeneral = eg.idestudiantegeneral
					AND o.idprematricula = p.idprematricula
					AND e.codigocarrera = c.codigocarrera				
					AND c.codigomodalidadacademica = '".$_POST['modalidad']."'
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					AND p.semestreprematricula = 1
					";		
					// echo $query_estudiantes,"&nbsp;12";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
				  
				  }
			 } // procedencia	
			 
		  }	// estudiante
  
	     } // carrera = 0
	   else
	    { // else carrera = 0		
		  if ($_POST['estudiante'] == 0) 
		   { // estudiante
		    if ($_POST['procedencia'] == 1)
              {	// procedencia	
				if ($_POST['listadocolegios'] <> 0)
				{	
					$query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,estudiante e,ordenpago o,prematricula p,estudianteestudio ee,carrera c
					WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					AND e.codigoestudiante = o.codigoestudiante
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND ee.idinstitucioneducativa = '".$_POST['listadocolegios']."'
					AND e.codigocarrera = c.codigocarrera
					AND e.codigocarrera = '".$_POST['carrera']."'
					AND p.idprematricula = o.idprematricula
					AND p.semestreprematricula = 1
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					UNION 
					SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,estudiantecarrerainscripcion ec
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral				
					AND ee.idinstitucioneducativa = '".$_POST['listadocolegios']."'				
					AND ec.idinscripcion = i.idinscripcion             
					AND ec.codigocarrera = '".$_POST['carrera']."'
					AND ec.idnumeroopcion = 1
					AND i.codigoestado LIKE '1%'
					AND (i.codigosituacioncarreraestudiante = 300 or i.codigosituacioncarreraestudiante = 107)
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2";		
					// echo $query_estudiantes,"&nbsp;13";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
		        }
			   else
			    {
				  $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,estudiante e,ordenpago o,prematricula p,estudianteestudio ee,carrera c
					WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					AND e.codigoestudiante = o.codigoestudiante
					AND ee.idestudiantegeneral = eg.idestudiantegeneral					
					AND e.codigocarrera = c.codigocarrera
					AND e.codigocarrera = '".$_POST['carrera']."'
					AND p.idprematricula = o.idprematricula
					AND p.semestreprematricula = 1
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					UNION 
					SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,estudiantecarrerainscripcion ec
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral								
					AND ec.idinscripcion = i.idinscripcion             
					AND ec.codigocarrera = '".$_POST['carrera']."'
					AND ec.idnumeroopcion = 1
					AND i.codigoestado LIKE '1%'
					AND (i.codigosituacioncarreraestudiante = 300 or i.codigosituacioncarreraestudiante = 107)
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2";		
					// echo $query_estudiantes,"&nbsp;13";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
				
				}
			 }
			else
			 {
			   
			   if ($_POST['departamento'] <> "todos")
				 {	
					$query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e,carrera c
					WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ee.idestudiantegeneral = eg.idestudiantegeneral 
					AND p.codigoestudiante = e.codigoestudiante
					AND e.idestudiantegeneral = eg.idestudiantegeneral
					AND o.idprematricula = p.idprematricula
					AND e.codigocarrera = c.codigocarrera
					AND e.codigocarrera = '".$_POST['carrera']."'
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					AND p.semestreprematricula = 1
					AND i.departamentoinstitucioneducativa = '".$_POST['departamento']."'
					UNION
					SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie,estudiantecarrerainscripcion ec
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND (i.codigosituacioncarreraestudiante = 300 OR i.codigosituacioncarreraestudiante = 107)
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ec.idinscripcion = i.idinscripcion             
					AND ec.codigocarrera = '".$_POST['carrera']."'
					AND ec.idnumeroopcion = 1
					AND i.codigoestado LIKE '1%'
					AND ie.departamentoinstitucioneducativa = '".$_POST['departamento']."'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2";		
					// echo $query_estudiantes,"&nbsp;14";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
			     }
				 else
				 {
				   $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e,carrera c
					WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ee.idestudiantegeneral = eg.idestudiantegeneral 
					AND p.codigoestudiante = e.codigoestudiante
					AND e.idestudiantegeneral = eg.idestudiantegeneral
					AND o.idprematricula = p.idprematricula
					AND e.codigocarrera = c.codigocarrera
					AND e.codigocarrera = '".$_POST['carrera']."'
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					AND p.semestreprematricula = 1					
					UNION
					SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie,estudiantecarrerainscripcion ec
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND (i.codigosituacioncarreraestudiante = 300 OR i.codigosituacioncarreraestudiante = 107)
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ec.idinscripcion = i.idinscripcion             
					AND ec.codigocarrera = '".$_POST['carrera']."'
					AND ec.idnumeroopcion = 1
					AND i.codigoestado LIKE '1%'					
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2";		
					// echo $query_estudiantes,"&nbsp;14";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
				 
				 }
			 } // procedencia	
			 
		 }	// estudiante
		else
		if ($_POST['estudiante'] == 1) 		 
		 {
		    if ($_POST['procedencia'] == 1)
              {	// procedencia	
				if ($_POST['listadocolegios'] <> 0)
				{	
					$query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,estudiante e,ordenpago o,prematricula p,estudianteestudio ee,carrera c
					WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					AND e.codigoestudiante = o.codigoestudiante
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND ee.idinstitucioneducativa = '".$_POST['listadocolegios']."'
					AND e.codigocarrera = c.codigocarrera
					AND e.codigocarrera = '".$_POST['carrera']."'
					AND p.idprematricula = o.idprematricula
					AND p.semestreprematricula = 1
					AND o.codigoestadoordenpago LIKE '1%'
					AND p.codigoestadoprematricula LIKE '1%'
					AND o.codigoperiodo = '$periodo'
					UNION 
					SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,estudiantecarrerainscripcion ec
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND ec.idinscripcion = i.idinscripcion             
					AND ec.codigocarrera = '".$_POST['carrera']."'
					AND ec.idnumeroopcion = 1
					AND i.codigoestado LIKE '1%'
					AND ee.idinstitucioneducativa = '".$_POST['listadocolegios']."'
					AND (i.codigosituacioncarreraestudiante = 107)
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2";		
					// echo $query_estudiantes,"&nbsp;15";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
		        }
			  else
			    {
				   $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,estudiante e,ordenpago o,prematricula p,estudianteestudio ee,carrera c
					WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					AND e.codigoestudiante = o.codigoestudiante
					AND ee.idestudiantegeneral = eg.idestudiantegeneral					
					AND e.codigocarrera = c.codigocarrera
					AND e.codigocarrera = '".$_POST['carrera']."'
					AND p.idprematricula = o.idprematricula
					AND p.semestreprematricula = 1
					AND o.codigoestadoordenpago LIKE '1%'
					AND p.codigoestadoprematricula LIKE '1%'
					AND o.codigoperiodo = '$periodo'
					UNION 
					SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,estudiantecarrerainscripcion ec
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND ec.idinscripcion = i.idinscripcion             
					AND ec.codigocarrera = '".$_POST['carrera']."'
					AND ec.idnumeroopcion = 1
					AND i.codigoestado LIKE '1%'					
					AND (i.codigosituacioncarreraestudiante = 107)
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2";		
					// echo $query_estudiantes,"&nbsp;15";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
				}			 
			 }
			else
			 {
			     if ($_POST['departamento'] <> "todos")
				 {	
					$query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e,carrera c
					WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ee.idestudiantegeneral = eg.idestudiantegeneral 
					AND p.codigoestudiante = e.codigoestudiante
					AND e.idestudiantegeneral = eg.idestudiantegeneral
					AND o.idprematricula = p.idprematricula
					AND e.codigocarrera = c.codigocarrera
					AND e.codigocarrera = '".$_POST['carrera']."'
					AND o.codigoestadoordenpago LIKE '1%'
					AND p.codigoestadoprematricula LIKE '1%'
					AND o.codigoperiodo = '$periodo'
					AND p.semestreprematricula = 1
					AND i.departamentoinstitucioneducativa = '".$_POST['departamento']."'
					UNION
					SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie,estudiantecarrerainscripcion ec
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND (i.codigosituacioncarreraestudiante = 107)
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ec.idinscripcion = i.idinscripcion             
					AND ec.codigocarrera = '".$_POST['carrera']."'
					AND ec.idnumeroopcion = 1
					AND i.codigoestado LIKE '1%'
					AND ie.departamentoinstitucioneducativa = '".$_POST['departamento']."'
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2";		
					//echo $query_estudiantes,"&nbsp;16";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
			    }
				else
				{
				  $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e,carrera c
					WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ee.idestudiantegeneral = eg.idestudiantegeneral 
					AND p.codigoestudiante = e.codigoestudiante
					AND e.idestudiantegeneral = eg.idestudiantegeneral
					AND o.idprematricula = p.idprematricula
					AND e.codigocarrera = c.codigocarrera
					AND e.codigocarrera = '".$_POST['carrera']."'
					AND o.codigoestadoordenpago LIKE '1%'
					AND p.codigoestadoprematricula LIKE '1%'
					AND o.codigoperiodo = '$periodo'
					AND p.semestreprematricula = 1					
					UNION
					SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,inscripcion i,estudianteestudio ee,institucioneducativa ie,estudiantecarrerainscripcion ec
					WHERE eg.idestudiantegeneral = i.idestudiantegeneral
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND (i.codigosituacioncarreraestudiante = 107)
					AND ie.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ec.idinscripcion = i.idinscripcion             
					AND ec.codigocarrera = '".$_POST['carrera']."'
					AND ec.idnumeroopcion = 1
					AND i.codigoestado LIKE '1%'					
					AND i.codigoperiodo = '$periodo'
					ORDER BY 2";		
					// echo $query_estudiantes,"&nbsp;16";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
				
				}
			 } // procedencia	
			 
		 }	// estudiante
        else
		if ($_POST['estudiante'] == 2) 		 
		 {
		    if ($_POST['procedencia'] == 1)
              {	// procedencia	
				if ($_POST['listadocolegios'] <> 0)
				{	
					$query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,estudiante e,ordenpago o,prematricula p,estudianteestudio ee,carrera c
					WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					AND e.codigoestudiante = o.codigoestudiante
					AND ee.idestudiantegeneral = eg.idestudiantegeneral
					AND ee.idinstitucioneducativa = '".$_POST['listadocolegios']."'
					AND e.codigocarrera = c.codigocarrera
					AND e.codigocarrera = '".$_POST['carrera']."'
					AND p.idprematricula = o.idprematricula
					AND p.semestreprematricula = 1
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'";		
					// echo $query_estudiantes,"&nbsp;17";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
		        }
			   else
			    {
				  $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM estudiantegeneral eg,estudiante e,ordenpago o,prematricula p,estudianteestudio ee,carrera c
					WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					AND e.codigoestudiante = o.codigoestudiante
					AND ee.idestudiantegeneral = eg.idestudiantegeneral					
					AND e.codigocarrera = c.codigocarrera
					AND e.codigocarrera = '".$_POST['carrera']."'
					AND p.idprematricula = o.idprematricula
					AND p.semestreprematricula = 1
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'";		
					// echo $query_estudiantes,"&nbsp;17";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
				}
			 }
			else
			 {
			    if ($_POST['departamento'] <> "todos")
				 {	
					$query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e,carrera c
					WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ee.idestudiantegeneral = eg.idestudiantegeneral 
					AND p.codigoestudiante = e.codigoestudiante
					AND e.idestudiantegeneral = eg.idestudiantegeneral
					AND o.idprematricula = p.idprematricula
					AND e.codigocarrera = c.codigocarrera
					AND e.codigocarrera = '".$_POST['carrera']."'
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					AND p.semestreprematricula = 1
					AND i.departamentoinstitucioneducativa = '".$_POST['departamento']."'";		
					 //echo $query_estudiantes,"&nbsp;18";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
			     }
				else
				 {
				   $query_estudiantes = "SELECT DISTINCT eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
					FROM institucioneducativa i,estudianteestudio ee,prematricula p,ordenpago o,estudiantegeneral eg,estudiante e,carrera c
					WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
					AND ee.idestudiantegeneral = eg.idestudiantegeneral 
					AND p.codigoestudiante = e.codigoestudiante
					AND e.idestudiantegeneral = eg.idestudiantegeneral
					AND o.idprematricula = p.idprematricula
					AND e.codigocarrera = c.codigocarrera
					AND e.codigocarrera = '".$_POST['carrera']."'
					AND o.codigoestadoordenpago LIKE '4%'
					AND p.codigoestadoprematricula LIKE '4%'
					AND o.codigoperiodo = '$periodo'
					AND p.semestreprematricula = 1
					";		
					//echo $query_estudiantes,"&nbsp;18";
					$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
					$row_estudiantes = mysql_fetch_assoc($estudiantes);
					$totalRows_estudiantes = mysql_num_rows($estudiantes);
				 }
			 } // procedencia			 
		  }	// estudiante		
		} // else carrera = 0 	 
	   }  // else modalidad    
 
 if ($_POST['modalidad'] == 0)
  {
    $namemodalidad = "TODAS LAS MODALIDADES";  
  }
 else
  {
     $query_modalidadseleccion = "SELECT nombremodalidadacademica
	 FROM modalidadacademica 
     where codigomodalidadacademica = '".$_POST['modalidad']."' 
     ";
     $modalidadseleccion = mysql_query($query_modalidadseleccion, $sala) or die(mysql_error());
     $row_modalidadseleccion = mysql_fetch_assoc($modalidadseleccion);
     $totalRows_modalidadseleccion = mysql_num_rows($modalidadseleccion); 
     
	  $namemodalidad =strtoupper($row_modalidadseleccion['nombremodalidadacademica']);   
  } 
  if ($_POST['carrera'] == 0)
   {
      $namecarrera = "TODOS LOS PROGRAMAS";
   }
  else
   {
     $query_carreraseleccion = "SELECT nombrecarrera
	 FROM carrera 
     where codigocarrera = '".$_POST['carrera']."' 
     ";
     $carreraseleccion = mysql_query($query_carreraseleccion, $sala) or die(mysql_error());
     $row_carreraseleccion = mysql_fetch_assoc($carreraseleccion);
     $totalRows_carreraseleccion = mysql_num_rows($carreraseleccion); 
     
	  $namecarrera = strtoupper($row_carreraseleccion['nombrecarrera']); 
   } 
   
   if ($_POST['estudiante'] == 0)
   {	
	 $nameestudiante = "TODOS";
   }
  else
   if ($_POST['estudiante'] == 1)
   {
    $nameestudiante = "INSCRITOS";   
   }
  else
   if ($_POST['estudiante'] == 2)
   {
     $nameestudiante = "MATRICULADOS";   
   }
   
   if ($_POST['procedencia'] == 1)
	   {
	     $nameprocedencia = "COLEGIO";
	   }
	  else
	  if ($_POST['procedencia'] == 2)
	   {
	     $nameprocedencia = "DEPARTAMENTO";
	   } 
 
     if ($_POST['departamento'] <> "")
	  {
	 
	  if ($_POST['departamento'] <> "todos")
	   {
	      $namefiltro = $_POST['departamento'];	     
	   } 
	  else
	  if ($_POST['departamento'] == "todos")
	   {
	     $namefiltro = "TODOS LOS DEPARTAMENTOS";	     
	   }
	  }
	   
	  if ($_POST['listadocolegios'] <> "")
	   { 
		   if ($_POST['listadocolegios'] == 0)
			{
			  $namefiltro = "TODOS LOS COLEGIOS";
			}
		 else
		   if ($_POST['listadocolegios'] <> 0 or $_POST['listadocolegios'] <> "")
		   {
			 $query_filtro = "SELECT nombreinstitucioneducativa
			 FROM institucioneducativa 
			 where idinstitucioneducativa = '".$_POST['listadocolegios']."' 
			 ";
		   //  echo $query_filtro;
			 $filtro = mysql_query($query_filtro, $sala) or die(mysql_error());
			 $row_filtro = mysql_fetch_assoc($filtro);
			 $totalRows_filtro = mysql_num_rows($filtro); 
			
			 $namefiltro = $row_filtro['nombreinstitucioneducativa']; 
		   }
		 }
	   
 ?>   	
	<input name="modalidad"  type="hidden"  value="<?php echo $_POST['modalidad'];?>">
	<input name="carrera"    type="hidden"  value="<?php echo $_POST['carrera'];?>">
	<input name="estudiante" type="hidden"  value="<?php echo $_POST['estudiante'];?>">
	<input name="procedencia" type="hidden"  value="<?php echo $_POST['procedencia'];?>">
	<input name="departamento" type="hidden"  value="<?php echo $_POST['departamento'];?>">
	<input name="listadocolegios" type="hidden"  value="<?php echo $_POST['listadocolegios'];?>">
	
<?php     
	 
	  if (! $row_estudiantes)
	   {
	    echo '<script language="JavaScript">alert("No se produjo ningun resultado"); history.go(-1);</script>';		   
	   }  
	  else
	   {
?>	     
		<p align="center" class="Estilo13 Estilo1">RESULTADO DE LA B&Uacute;SQUEDA</p> 
		<table width="707" border="1" align="center" bordercolor="#003333">
		 <tr bgcolor="#C6CFD0">
		   <td width="99"><div align="center" class="Estilo7">Modalidad</div></td>
		   <td width="74"><div align="center" class="Estilo7">Carrera</div></td>
		   <td width="110"><div align="center" class="Estilo7">Filtrado Por</div></td>
		   <td width="92"><div align="center" class="Estilo7">Ubicación</div></td>
		   <td width="186"><div align="center" class="Estilo7">Institución / Procedencia</div></td>
		   <td width="106"><div align="center" class="Estilo7">Total</div></td>
		 </tr>
		 <tr>
		   <td><div align="center"><span class="Estilo8"><?php echo $namemodalidad;?>
           </span>
             </div>
	        <div align="center" class="Estilo8"></div></td>
		   <td><div align="center"><span class="Estilo8"><?php echo $namecarrera;?>
           </span>
             </div>
	        <div align="center" class="Estilo8"></div></td>
		   <td><div align="center"><span class="Estilo8"><?php echo $nameestudiante;?>
           </span>
             </div>
	        <div align="center" class="Estilo8"></div></td>
		   <td><div align="center"><span class="Estilo8"><?php echo $nameprocedencia;?>
           </span>
             </div>
	        <div align="center" class="Estilo8"></div></td>
		   <td><div align="center"><span class="Estilo8"><?php echo $namefiltro;?>
           </span>
             </div>
	        <div align="center" class="Estilo8"></div></td>
		   <td><div align="center"><span class="Estilo8"><?php echo $totalRows_estudiantes;?>
           </span>
             </div>
	        <div align="center" class="Estilo8"></div></td>
		 </tr>	
		<tr>
		 <td colspan="6"> <div align="center">
			   <input name="detalle" type="submit" value="Detalles">&nbsp;<input name="regresar" type="button" value="Regresar" onClick="history.go(-1)">&nbsp; <input name="Imprimir" type="button" value="Imprimir" onClick="window.print()">
		 </div></td>		  
		</tr>
		</table>

<?php
		 if ($_POST['detalle'])
		  {
		    
?>
     <table width="707" border="1" align="center" bordercolor="#003333">
       <tr bgcolor="#C6CFD0">
         <td><div align="center"><strong><span class="Estilo8">Documento</span></strong></div></td>
         <td><div align="center"><strong><span class="Estilo8">Nombre</span></strong></div></td>
         <td><div align="center"><strong><span class="Estilo8">Ciudad Nacimiento</span></strong></div></td>
          <td><div align="center"><strong><span class="Estilo8">Edad</span></strong></div></td>
         <td><div align="center"><strong><span class="Estilo8">Colegio</span></strong></div></td>
         <td><div align="center"><strong><span class="Estilo8">Procedencia</span></strong></div></td>
         <td><div align="center"><strong><span class="Estilo8">Carrera</span></strong></div></td>
         <td><div align="center"><strong><span class="Estilo8">Medio Comunicación</span></strong></div></td>
       </tr>
       <?php			
			do{
?>
			   <tr>
                               <?php
				   $query_col = "SELECT i.idinstitucioneducativa, i.nombreinstitucioneducativa, i.departamentoinstitucioneducativa, ee.otrainstitucioneducativaestudianteestudio, i.municipioinstitucioneducativa, c.nombreciudad
                                       FROM institucioneducativa i,estudianteestudio ee,estudiantegeneral eg, ciudad c
                                   WHERE i.idinstitucioneducativa = ee.idinstitucioneducativa
                                   AND i.codigomodalidadacademica = 100
                                   AND ee.idestudiantegeneral = eg.idestudiantegeneral
                                   and eg.idciudadnacimiento=c.idciudad
                                   AND eg.numerodocumento = '".$row_estudiantes['numerodocumento']."'";
                                   $col = mysql_query($query_col, $sala) or die(mysql_error());
                                   $row_col = mysql_fetch_assoc($col);
                                   $totalRows_col = mysql_num_rows($col);

                               ?>
				 <td><div align="center"><span class="Estilo8"><?php echo $row_estudiantes['numerodocumento'];?> </span></div></td>
				 <td><div align="center"><span class="Estilo8"><?php echo $row_estudiantes['apellidosestudiantegeneral'];?>  <?php echo $row_estudiantes['nombresestudiantegeneral'];?></span></div></td>
                                 <td><div align="center"><span class="Estilo8"><?php echo $row_col['nombreciudad'];?> </span></div></td>
                                  <td><div align="center"><span class="Estilo8"><?php echo $row_estudiantes['edad'];?>&nbsp;</span> </div></td>
				 <td><div align="center"><span class="Estilo8">&nbsp;
				 <?php

                                  if($row_col['idinstitucioneducativa']!=1){
                                        echo $row_col['nombreinstitucioneducativa'];
                                  }
				  else
                                  {
                                      echo $row_col['nombreinstitucioneducativa']."<BR>(".$row_col['otrainstitucioneducativaestudianteestudio'].")";
                                  }
				 ?> </span> </div></td>				
				 <td><div align="center"><span class="Estilo8"><?php echo $row_col['municipioinstitucioneducativa'];?>&nbsp;</span> </div></td>
				 <td><div align="center"><span class="Estilo8">				 
				   <?php 
                   if ($_POST['carrera'] <> 0)
					{
					   $query_carreraescogida = "SELECT nombrecarrera
					   FROM carrera
					   WHERE codigocarrera = '".$_POST['carrera']."'";
					   //echo $query_carreraescogida,"<br>"; 
					   $carreraescogida = mysql_query($query_carreraescogida, $sala) or die(mysql_error());
					   $row_carreraescogida = mysql_fetch_assoc($carreraescogida);
					   $totalRows_carreraescogida = mysql_num_rows($carreraescogida); 
					}
				   else
				    {  			   
				   
					   $query_carreraescogida = "SELECT nombrecarrera
						FROM estudiante e,estudiantegeneral eg,prematricula p,ordenpago o,carrera c
						WHERE e.idestudiantegeneral = eg.idestudiantegeneral
						AND p.codigoestudiante = e.codigoestudiante
						AND c.codigocarrera = e.codigocarrera
						AND o.idprematricula = p.idprematricula
						AND o.codigoestadoordenpago LIKE '4%'
						AND p.codigoestadoprematricula LIKE '4%'
						AND o.codigoperiodo = '$periodo'
						AND p.semestreprematricula = 1
						AND eg.numerodocumento = '".$row_estudiantes['numerodocumento']."'";
					   //echo $query_carreraescogida,"<br>"; 
					   $carreraescogida = mysql_query($query_carreraescogida, $sala) or die(mysql_error());
					   $row_carreraescogida = mysql_fetch_assoc($carreraescogida);
					   $totalRows_carreraescogida = mysql_num_rows($carreraescogida); 
				    
				   if (! $row_carreraescogida)
				    {
					   $query_carreraescogida = "SELECT nombrecarrera	
						FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion ec, carrera c
						WHERE eg.idestudiantegeneral = i.idestudiantegeneral				
						AND (i.codigosituacioncarreraestudiante = 300 or i.codigosituacioncarreraestudiante = 107)
						AND ec.idinscripcion = i.idinscripcion 		
						AND ec.codigocarrera = c.codigocarrera
						AND ec.idnumeroopcion = 1
						AND i.codigoestado LIKE '1%'
						AND i.codigoperiodo = '$periodo'
						AND eg.numerodocumento = '".$row_estudiantes['numerodocumento']."'";
					   $carreraescogida = mysql_query($query_carreraescogida, $sala) or die(mysql_error());
					   $row_carreraescogida = mysql_fetch_assoc($carreraescogida);
					   $totalRows_carreraescogida = mysql_num_rows($carreraescogida); 
					}				 
				  
				}
				  echo $row_carreraescogida['nombrecarrera'];
				 ?>
			     &nbsp;</span> </div>
				 </td>
				 <td><div align="center"><span class="Estilo8">
				 <?php 
				  $query_medio = "SELECT nombremediocomunicacion
	               FROM estudiantemediocomunicacion ee,estudiantegeneral eg,mediocomunicacion m 
                   WHERE ee.codigomediocomunicacion = m.codigomediocomunicacion
				   AND ee.codigoestadoestudiantemediocomunicacion LIKE '1%'
                   AND ee.idestudiantegeneral = eg.idestudiantegeneral
                   AND eg.numerodocumento = '".$row_estudiantes['numerodocumento']."'
                   and m.codigoestado like '1%'
                   group by ee.codigomediocomunicacion";
                   $medio = mysql_query($query_medio, $sala) or die(mysql_error());
                   $row_medio = mysql_fetch_assoc($medio);
                   $totalRows_medio = mysql_num_rows($medio); 
				   
				  do{
				     echo $row_medio['nombremediocomunicacion'],"<br>";
				   } while($row_medio = mysql_fetch_assoc($medio));
				 ?> </span> </div></td>
			   </tr>
 <?	         }while($row_estudiantes = mysql_fetch_assoc($estudiantes));

?>
       <tr>
         <td colspan="8"><div align="center">
             <input name="Imprimir" type="button" value="Imprimir" onClick="window.print()">
         </div></td>
       </tr>
     </table>
     <?php	  
		  }
	   } 
 
 exit();  
   }// buscar
?>
<p align="center" class="Estilo13 Estilo1">CRITERIO DE B&Uacute;SQUEDA</p>
<table width="707" border="1" align="center" bordercolor="#003333">
 <tr>
    <td width="303" bgcolor="#C6CFD0"><div align="center" class="Estilo14 Estilo2 Estilo5"> <strong>Modalidad :</strong>&nbsp;</div></td>
	<td width="388"><span class="Estilo2 Estilo5">
	  <select name="modalidad" id="modalidad" onChange="enviar()">
        <option value="0" <?php if (!(strcmp("0", $_POST['modalidad']))) {echo "SELECTED";} ?>>Seleccionar</option>
        <option value="0" <?php if (!(strcmp("0", $_POST['modalidad']))) {echo "SELECTED";} ?>>Todas las Modalidades</option>
        <?php
	  do { 
?>
        <option value="<?php echo $row_modalidad['codigomodalidadacademica']?>"<?php if (!(strcmp($row_modalidad['codigomodalidadacademica'], $_POST['modalidad']))) {echo "SELECTED";} ?>><?php echo $row_modalidad['nombremodalidadacademica']?></option>

<?php
	   
	  } while ($row_modalidad = mysql_fetch_assoc($modalidad));
		  $rows = mysql_num_rows($modalidad);
		  
		  if($rows > 0) 
		  {
			  mysql_data_seek($car, 0);
			  $row_modalidad = mysql_fetch_assoc($modalidad);
		  }
?>
      </select>	
	
	  </span></td>
  </tr>
<?php
 
 if(isset($_POST['modalidad']))
  {			
    $query_modalidades = "SELECT *
    FROM carrera
    WHERE fechavencimientocarrera > '".$fecha."'
    and codigomodalidadacademica = '".$_POST['modalidad']."'	
    order by 1 ";		
     // echo $query_car;
    $modalidades = mysql_query($query_modalidades, $sala) or die(mysql_error());
    $row_modalidades = mysql_fetch_assoc($modalidades);
    $totalRows_modalidades = mysql_num_rows($modalidades);
?>
  <tr>
    <td align="center" bgcolor="#C6CFD0"><span class="Estilo14 Estilo2 Estilo5"><strong>Carrera :</strong> &nbsp;&nbsp;</span></td>
    <td align="left">            
      <span class="Estilo6">
<select name="carrera" id="carrera">

<?php 	  
     if ($totalRows_modalidades > 1 or $_POST['modalidad'] == 0)
	  {
?>
	    <option value="0" <?php if (!(strcmp(0,$_POST['carrera']))) {echo "SELECTED";} ?>>Todos los Programas</option>
<?php 	  
      }
      while ($row_car = mysql_fetch_assoc($car))
	   {  
      
?>
        <option value="<?php echo $row_car['codigocarrera']?>"<?php if (!(strcmp($row_car['codigocarrera'],$_POST['carrera']))) {echo "SELECTED";} ?>><?php echo $row_car['nombrecarrera']?></option>
 <?php
	   } 
	   
	
		$rows = mysql_num_rows($car);
		  if($rows > 0) 
		   {
		     mysql_data_seek($car, 0);
			 $row_car = mysql_fetch_assoc($car);
		   }
?>
   </select>	 

 &nbsp;</span></td>
  </tr>
  <tr>
   <td align="center" bgcolor="#C6CFD0"><span class="Estilo14 Estilo2 Estilo5"><strong>Filtrado Por :</strong> &nbsp;&nbsp;</span></td>
    <td align="left"><span class="Estilo6">
<select name="estudiante">
  <option value="0" <?php if (!(strcmp("0", $_POST['estudiante']))) {echo "SELECTED";} ?>>Todos</option>
  <option value="1" <?php if (!(strcmp("1", $_POST['estudiante']))) {echo "SELECTED";} ?>>Inscritos</option>
  <option value="2" <?php if (!(strcmp("2", $_POST['estudiante']))) {echo "SELECTED";} ?>>Matriculados</option>
</select>

	
    </span> </td>
  </tr>
   <tr>
   <td align="center" bgcolor="#C6CFD0"><span class="Estilo14 Estilo2 Estilo5"><strong>Ubicaci&oacute;n :</strong> &nbsp;&nbsp;</span></td>
    <td align="left"><span class="Estilo6">
      <select name="procedencia" onChange="enviar()">
	     <option value="0" <?php if (!(strcmp("0", $_POST['procedencia']))) {echo "SELECTED";} ?>>Seleccionar</option>
         <option value="1" <?php if (!(strcmp("1", $_POST['procedencia']))) {echo "SELECTED";} ?>>Colegio</option>
         <option value="2" <?php if (!(strcmp("2", $_POST['procedencia']))) {echo "SELECTED";} ?>>Procedencia</option>  
	  </select>
  
	</span> </td>
  </tr>
<?php 
 if ($_POST['procedencia'] <> 0)
  { // if 1
?>  
  <tr>
   <td align="center" bgcolor="#C6CFD0"><span class="Estilo14 Estilo2 Estilo5"><strong>Instituci&oacute;n / Procedencia:</strong> &nbsp;&nbsp;</span></td>
    <td align="left"><span class="Estilo6">
 <?php if ($_POST['procedencia'] == 1)
	  { //if 2

        $query_colegio = "SELECT DISTINCT idinstitucioneducativa,nombreinstitucioneducativa,municipioinstitucioneducativa
		FROM institucioneducativa
		WHERE codigomodalidadacademica = 100
		ORDER BY nombreinstitucioneducativa";		
        // echo $query_car;
        $colegio = mysql_query($query_colegio, $sala) or die(mysql_error());
        //$row_colegio = mysql_fetch_assoc($colegio);
        $totalRows_colegio = mysql_num_rows($colegio);	
?>
	
      <select name="listadocolegios">
        <option value="0" <?php if (!(strcmp(0,$_POST['listadocolegios']))) {echo "SELECTED";} ?>>Todos los Colegios</option>
<?php        
        while ($row_colegio = mysql_fetch_assoc($colegio))
	     {  
?>
           <option value="<?php echo $row_colegio['idinstitucioneducativa']?>"<?php if (!(strcmp($row_colegio['idinstitucioneducativa'],$_POST['listadocolegios']))) {echo "SELECTED";} ?>><?php echo $row_colegio['nombreinstitucioneducativa']?>---<?php echo $row_colegio['municipioinstitucioneducativa']?></option>
 <?php
	     } 
	     
		  $rows = mysql_num_rows($colegio);
		  if($rows > 0) 
		   {
		     mysql_data_seek($colegio, 0);
			 $row_colegio = mysql_fetch_assoc($colegio);
		   }
?>
   </select>
<?php 
     } //if 2
   else
    {
	  $query_Recordset1 = "SELECT DISTINCT departamentoinstitucioneducativa
	  from institucioneducativa
	  order by 1";
      $Recordset1 = mysql_query($query_Recordset1, $sala) or die(mysql_error());
      $row_Recordset1 = mysql_fetch_assoc($Recordset1);
      $totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>	
	<select name="departamento">
  <option value="todos" <?php if (!(strcmp(0,$_POST['departamento']))) {echo "SELECTED";} ?>>Todos los Departamentos</option>
<?php
do {  
?>
          <option value="<?php echo $row_Recordset1['departamentoinstitucioneducativa']?>"<?php if (!(strcmp($row_Recordset1['departamentoinstitucioneducativa'], $_POST['departamento']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['departamentoinstitucioneducativa']?></option>
<?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }

?>
      </select>

</span> </td>
  </tr>  
<?php	
	} 
  }  // if 1
?>  
 <tr>
  	<td colspan="2" align="center"><span class="Estilo3">
  	  <input name="buscar" type="submit" value="Consultar">&nbsp;</span></td>
  </tr>
<?php
  }
  ?>
</table>
</form>
</body>
</html>
<script language="javascript">

function enviar()
{
 document.form1.submit();
}
</script>
