<?php require_once('../../../Connections/sala2.php');
session_start();
mysql_select_db($database_sala, $sala);


$query_periodo = "select p.codigoperiodo, p.nombreperiodo
from periodo p
ORDER BY p.codigoperiodo DESC";
//echo "$query_periodo<br>";
$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);
?>
<form name="form1" method="post" action="">
<?php

if ($_REQUEST['consultar'])
 {
	$query_semestrecarrera = "SELECT DISTINCT e.idestudiantegeneral,e.codigoestudiante,numerodocumento,
	concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,c.codigocarrera,c.nombrecarrera,
	direccionresidenciaestudiantegeneral,telefonoresidenciaestudiantegeneral,celularestudiantegeneral,emailestudiantegeneral,nombreestadocivil,nombregenero,
	(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad,
	c.codigocentrobeneficio,nombresituacioncarreraestudiante,p.semestreprematricula	
	FROM estudiante e,ordenpago o,prematricula p,fechaordenpago f,estudiantegeneral eg,detalleordenpago do,carrera c,
	estadocivil ec,genero g,situacioncarreraestudiante s
	WHERE e.codigoestudiante   = o.codigoestudiante
	AND ec.idestadocivil       = eg.idestadocivil 
	AND s.codigosituacioncarreraestudiante = e.codigosituacioncarreraestudiante
	AND g.codigogenero         = eg.codigogenero
	AND e.codigocarrera        = c.codigocarrera 
	AND eg.idestudiantegeneral = e.idestudiantegeneral
	AND o.numeroordenpago      = f.numeroordenpago
	AND o.numeroordenpago      = do.numeroordenpago
	AND do.codigoconcepto      = 151
	AND o.idprematricula       = p.idprematricula
	AND o.codigoestadoordenpago LIKE '4%'
	AND (c.codigomodalidadacademica LIKE '2%' OR c.codigomodalidadacademica LIKE '3%')
	AND p.codigoestadoprematricula LIKE '4%'					 
	AND ( e.codigosituacioncarreraestudiante <> 400 AND e.codigosituacioncarreraestudiante <> 104 )	
	AND o.codigoperiodo = '".$_REQUEST['periodo']."'
	ORDER BY c.nombrecarrera,nombre";	
	//echo $query_semestrecarrera,"<br><br>";	//AND e.codigocarrera = '8'
	$semestrecarrera = mysql_query($query_semestrecarrera, $sala) or die("$query_semestrecarrera");
	$row_semestrecarrera = mysql_fetch_assoc($semestrecarrera);
	$totalRows_semestrecarrera = mysql_num_rows($semestrecarrera);

    $cb = ",";
	
	if ($_REQUEST['periodo'] == 20061)
	 {
	  $fecha = "AND ( o.codigoperiodo = '20062' OR  o.codigoperiodo = '20071' OR o.codigoperiodo = '20072')";	
	 }
	else
    if ($_REQUEST['periodo'] == 20062)
	 {	
	  $fecha = "AND ( o.codigoperiodo = '20071' OR o.codigoperiodo = '20072')";
	 }
	else
	if ($_REQUEST['periodo'] == 20071)
	{	
	   $fecha = "AND ( o.codigoperiodo = '20072')";
    }
	
	do{
	
	$query_semestrecarrera1 = "SELECT DISTINCT e.idestudiantegeneral,numerodocumento,concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre
	FROM estudiante e,ordenpago o,prematricula p,fechaordenpago f,estudiantegeneral eg,detalleordenpago do
	WHERE e.codigoestudiante = o.codigoestudiante
	AND eg.idestudiantegeneral = e.idestudiantegeneral
	AND o.numeroordenpago = do.numeroordenpago
	AND do.codigoconcepto = 151
	AND ( e.codigosituacioncarreraestudiante <> 400 and e.codigosituacioncarreraestudiante <> 104 )	
	AND o.numeroordenpago = f.numeroordenpago
	AND o.idprematricula = p.idprematricula	
	AND o.codigoestadoordenpago LIKE '4%'
	AND p.codigoestadoprematricula LIKE '4%'			
	and o.codigoestudiante = '".$row_semestrecarrera['codigoestudiante']."'
	$fecha
	ORDER BY 3";
	// echo  $query_semestrecarrera1,"<br><br>";
	//AND e.codigocarrera = '8'AND ( o.codigoperiodo = '20062' OR  o.codigoperiodo = '20071' OR o.codigoperiodo = '20072')
	$semestrecarrera1 = mysql_query($query_semestrecarrera1, $sala) or die("1");
	$row_semestrecarrera1 = mysql_fetch_assoc($semestrecarrera1);
	$totalRows_semestrecarrera1 = mysql_num_rows($semestrecarrera1);
    
	 if (!$row_semestrecarrera1)
	  {
	    $query_semestrecarrera2 = "SELECT MAX(semestredetalleplanestudio * 1) AS maximo_semestre
		FROM planestudio p,planestudioestudiante pe,detalleplanestudio dp
		WHERE p.idplanestudio = pe.idplanestudio
		AND dp.idplanestudio = pe.idplanestudio
		AND codigoestudiante = '".$row_semestrecarrera['codigoestudiante']."'";
	    //echo  $query_semestrecarrera1,"<br>";AND e.codigocarrera = '8'
	    $semestrecarrera2 = mysql_query($query_semestrecarrera2, $sala) or die("1");
	    $row_semestrecarrera2 = mysql_fetch_assoc($semestrecarrera2);
	    $totalRows_semestrecarrera2 = mysql_num_rows($semestrecarrera2);	
		
		$query_semestrecarrera3 = "SELECT MAX(valordetallecohorte * 1) AS valor
		FROM cohorte c,detallecohorte dc
		WHERE c.idcohorte = dc.idcohorte
		AND codigocarrera = '".$row_semestrecarrera['codigocarrera']."'
		AND codigoperiodo = 20072";
	   // echo  $query_semestrecarrera3,"<br>";
		//AND e.codigocarrera = '8'
	    $semestrecarrera3 = mysql_query($query_semestrecarrera3, $sala) or die("1");
	    $row_semestrecarrera3 = mysql_fetch_assoc($semestrecarrera3);
	    $totalRows_semestrecarrera3 = mysql_num_rows($semestrecarrera3);			
		
		if ($row_semestrecarrera['semestreprematricula'] <> $row_semestrecarrera2['maximo_semestre'])
		  echo $row_semestrecarrera['idestudiantegeneral'],"$cb",$row_semestrecarrera['nombre'],"$cb",$row_semestrecarrera['numerodocumento'],"$cb",$row_semestrecarrera['codigocarrera'],"$cb",$row_semestrecarrera['nombrecarrera'],"$cb",$row_semestrecarrera['direccionresidenciaestudiantegeneral'],"$cb",$row_semestrecarrera['telefonoresidenciaestudiantegeneral'],"$cb",$row_semestrecarrera['emailestudiantegeneral'],"$cb",$row_semestrecarrera['celularestudiantegeneral'],"$cb",$row_semestrecarrera['nombreestadocivil'],"$cb",$row_semestrecarrera['nombregenero'],"$cb",$row_semestrecarrera['edad'],"$cb",$row_semestrecarrera['codigocentrobeneficio'],"$cb",$row_semestrecarrera['nombresituacioncarreraestudiante'],"$cb",$row_semestrecarrera['semestreprematricula'],"$cb",$row_semestrecarrera2['maximo_semestre'],"$cb",$_REQUEST['periodo'],"$cb",$row_semestrecarrera3['valor'],"<br>";
	  
	  }	
	
	}while($row_semestrecarrera = mysql_fetch_assoc($semestrecarrera)); 
 }
?>
Ultimo periodo :

<select name="periodo" >
  <?php
do {  
?>
           <option value="<?php echo $row_periodo['codigoperiodo']?>"<?php if (!(strcmp($row_periodo['codigoperiodo'], $_POST['periodo']))) {echo "SELECTED";} ?>><?php echo $row_periodo['nombreperiodo']?></option>
   <?php
} while ($row_periodo = mysql_fetch_assoc($periodo));
  $rows = mysql_num_rows($periodo);
  if($rows > 0) {
      mysql_data_seek($periodo, 0);
	  $row_periodo = mysql_fetch_assoc($periodo);
  }
?>
</select>

<br>		
<br>	
<br>	
  <input type="submit" name="consultar" value="consultar">
</form>
