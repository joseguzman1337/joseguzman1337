<?php 
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');

$query_periodo1 = "SELECT * 
FROM periodo 
ORDER BY 1 desc";
$periodo1 = $db->Execute($query_periodo1);
$totalRows_periodo1 = $periodo1->RecordCount();
$row_periodo1 = $periodo1->FetchRow();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="../../../sala.css">
</head>
<body>
<form action=""  method="post" name="f1" >
<p>GENERACION ARCHIVOS SPADIES</p>
<table border="1">
 <tr>
  <td id="titulogris">Primiparos</td>    
  <td><input name="radiobutton" type="radio" value="1"></td>
 </tr>
 <tr>
  <td id="titulogris">Matriculados</td>   
  <td><input name="radiobutton" type="radio" value="2"></td>
 </tr>
 <tr>
  <td id="titulogris">Graduados </td>    
  <td><input name="radiobutton" type="radio" value="3"></td>
 </tr>
 <tr>
  <td id="titulogris">Retiros Forzosos </td>    
  <td><input name="radiobutton" type="radio" value="4"></td>
 </tr>
  <tr>
  <td id="titulogris">periodo </td>       
  <td><select name="fecha1" id="fecha1"> 
<?php
do 
{
?>
    <option value="<?php echo $row_periodo1['codigoperiodo']?>" <?php if (!(strcmp($row_periodo1['codigoperiodo'], $_POST['fecha1']))) {echo "SELECTED";} ?>><?php echo $row_periodo1['codigoperiodo']?></option>
<?php
}
while($row_periodo1 = $periodo1->FetchRow());
?>
  </select></td>  
 <tr>
  <td id="titulogris" colspan="2"><input type="submit" name="Submit" value="Generar"></td>     
 </tr>
</table>
<?php 
 $nombre_temp = tempnam("","FOO");
 $gestor = fopen($nombre_temp, "r+b");
 $periodoactual = $_POST['fecha1'];
 
switch ($_POST['radiobutton'])
 {
  case 1:
  {
	$numu = "primiparos";
	break;
  }
  case 2:
  {
	$numu = "matriculados";
	break;
  }
  case 3:
  {
	$numu = "graduados";
	break;
  }
  case 4:
  {
	$numu = "retirosForzosos";
	break;
  }
 }

$primero = substr($periodoactual,0,4);
$segundo = substr($periodoactual,4,5);
$nombrearchivo = "$primero-$segundo-$numu.csv";
 

if ($_POST['Submit'])
 {
	if ($_POST['radiobutton'] == 1)
	 {		
		$query_primiparos = "SELECT DISTINCT e.codigoestudiante,eg.numerodocumento, eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
		e.codigocarrera,c.nombrecarrera,eg.fechanacimientoestudiantegeneral,codigogenero,eg.tipodocumento
		FROM estudiante e,prematricula p,carrera c,ordenpago o,estudiantegeneral eg,documento d
		WHERE e.codigoestudiante = p.codigoestudiante
		AND e.idestudiantegeneral = eg.idestudiantegeneral
		AND d.tipodocumento = eg.tipodocumento
		AND c.codigocarrera = e.codigocarrera 
		AND o.idprematricula = p.idprematricula
		AND p.codigoestadoprematricula LIKE '4%'
		AND o.codigoestadoordenpago LIKE '4%'
		AND c.codigomodalidadacademica = '200'
		AND e.codigoperiodo = '$periodoactual'
		AND p.codigoperiodo = '$periodoactual'
		ORDER BY nombrecarrera,apellidosestudiantegeneral";		
		$primiparos = $db->Execute($query_primiparos);
		$totalRows_primiparos = $primiparos->RecordCount();
		$row_primiparos = $primiparos->FetchRow();   
	   
	   fwrite($gestor,"apellidos;nombres;tipoDocumento;documento;nombrePrograma;codigoEstudiante;sexo;fechaNacimiento;codigoSNIESprograma\n");
	 
	   do{
		 
		 if ($row_primiparos['fechanacimientoestudiantegeneral'] < '1950-12-31')
		  {
		   $row_primiparos['fechanacimientoestudiantegeneral'] = "";
		  }
		 $genero   = tipogenero($row_primiparos['codigogenero']);
		 $tipodocumento = tipodocumentos($row_primiparos['tipodocumento']); 
		 $codsnies = codesniescarrera($row_primiparos['codigocarrera'],$db);	
		 
		 fwrite($gestor,"".$row_primiparos['apellidosestudiantegeneral'].";".$row_primiparos['nombresestudiantegeneral'].";".$tipodocumento.";'".$row_primiparos['numerodocumento'].";".$row_primiparos['nombrecarrera'].";".$row_primiparos['codigoestudiante'].";".$genero.";".substr($row_primiparos['fechanacimientoestudiantegeneral'],0,10).";'".$codsnies."\n");
	   }while($row_primiparos = $primiparos->FetchRow());	  
	 }
	else
	if ($_POST['radiobutton'] == 2)
	 {
	    $query_primiparos = "SELECT DISTINCT e.codigoestudiante,eg.numerodocumento, eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
		e.codigocarrera,c.nombrecarrera,eg.fechanacimientoestudiantegeneral,codigogenero,eg.tipodocumento
		FROM estudiante e,prematricula p,carrera c,ordenpago o,estudiantegeneral eg,documento d
		WHERE e.codigoestudiante = p.codigoestudiante
		AND e.idestudiantegeneral = eg.idestudiantegeneral
		AND d.tipodocumento = eg.tipodocumento
		AND c.codigocarrera = e.codigocarrera 
		AND o.idprematricula = p.idprematricula
		AND p.codigoestadoprematricula LIKE '4%'
		AND o.codigoestadoordenpago LIKE '4%'
		AND c.codigomodalidadacademica = '200'
		AND p.codigoperiodo = '$periodoactual'
		ORDER BY nombrecarrera,apellidosestudiantegeneral";		
		$primiparos = $db->Execute($query_primiparos);
		$totalRows_primiparos = $primiparos->RecordCount();
		$row_primiparos = $primiparos->FetchRow();    
	    
	   
	   fwrite($gestor,"apellidos;nombres;tipoDocumento;documento;nombrePrograma;materiasTomadas;materiasAprobadas\n");
	 
	   do{		 
		
		 $query_materiastomadas = "SELECT d.codigomateria,notaminimaaprobatoria
		 FROM ordenpago o,detalleprematricula d,materia m 
		 WHERE o.numeroordenpago = d.numeroordenpago
		 AND m.codigomateria = d.codigomateria
		 AND o.codigoestudiante =  '".$row_primiparos['codigoestudiante']."' 		 
		 AND o.codigoperiodo = '$periodoactual'
		 AND o.codigoestadoordenpago LIKE '4%'
		 AND d.codigoestadodetalleprematricula LIKE '3%'";		
		 $materiastomadas = $db->Execute($query_materiastomadas);
		 $totalRows_materiastomadas = $materiastomadas->RecordCount();
		 $row_materiastomadas = $materiastomadas->FetchRow();   
		 $cuentapasadas = ""; 
		 if ($row_materiastomadas <> "")
		  {
		  do{
		     $query_notahistorico = "SELECT notadefinitiva
			 FROM notahistorico 
			 WHERE codigoestadonotahistorico like '1%' 
			 AND codigoestudiante = '".$row_primiparos['codigoestudiante']."'
			 AND codigomateria = '".$row_materiastomadas['codigomateria']."'
			 AND notadefinitiva >= '".$row_materiastomadas['notaminimaaprobatoria']."'
			 AND codigoperiodo = '$periodoactual'";				 
			 //echo "$query_notahistorico <br><br><br>";
			 $notahistorico = $db->Execute($query_notahistorico);
			 $totalRows_notahistorico = $notahistorico->RecordCount();
			 $row_notahistorico = $notahistorico->FetchRow();   
		     if ($row_notahistorico <> "")
			  {
			   $cuentapasadas++;			  
			  }				
		  
		  }while($row_materiastomadas = $materiastomadas->FetchRow());			 
		 }
		 $tipodocumento = tipodocumentos($row_primiparos['tipodocumento']); 		 
		 
		 fwrite($gestor,"".$row_primiparos['apellidosestudiantegeneral'].";".$row_primiparos['nombresestudiantegeneral'].";".$tipodocumento.";'".$row_primiparos['numerodocumento'].";".$row_primiparos['nombrecarrera'].";".$totalRows_materiastomadas.";".$cuentapasadas.";\n");
	   }while($row_primiparos = $primiparos->FetchRow());	
	 
	 }
	else
	if ($_POST['radiobutton'] == 3)
	 {
	    $query_primiparos = "SELECT DISTINCT e.codigoestudiante,eg.numerodocumento, eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
		e.codigocarrera,c.nombrecarrera,eg.fechanacimientoestudiantegeneral,codigogenero,eg.tipodocumento
		FROM estudiante e,prematricula p,carrera c,ordenpago o,estudiantegeneral eg,documento d
		WHERE e.codigoestudiante = p.codigoestudiante
		AND e.idestudiantegeneral = eg.idestudiantegeneral
		AND d.tipodocumento = eg.tipodocumento
		AND c.codigocarrera = e.codigocarrera 
		AND o.idprematricula = p.idprematricula
		AND p.codigoestadoprematricula LIKE '4%'
		AND o.codigoestadoordenpago LIKE '4%'
		AND c.codigomodalidadacademica = '200'
		AND e.codigosituacioncarreraestudiante = '400'		
		AND p.codigoperiodo = '$periodoactual'
		ORDER BY nombrecarrera,apellidosestudiantegeneral";		
		//echo $query_primiparos; exit;
		$primiparos = $db->Execute($query_primiparos);
		$totalRows_primiparos = $primiparos->RecordCount();
		$row_primiparos = $primiparos->FetchRow();   
	   
	   fwrite($gestor,"apellidos;nombres;tipoDocumento;documento;nombrePrograma\n");
	 
	   do{	
		  $tipodocumento = tipodocumentos($row_primiparos['tipodocumento']); 
  	      fwrite($gestor,"".$row_primiparos['apellidosestudiantegeneral'].";".$row_primiparos['nombresestudiantegeneral'].";".$tipodocumento.";'".$row_primiparos['numerodocumento'].";".$row_primiparos['nombrecarrera']."\n");
	   }while($row_primiparos = $primiparos->FetchRow());	  
	 }
	else
	if ($_POST['radiobutton'] == 4)
	 {
	    $query_primiparos = "SELECT DISTINCT e.codigoestudiante,eg.numerodocumento, eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
		e.codigocarrera,c.nombrecarrera,eg.fechanacimientoestudiantegeneral,codigogenero,eg.tipodocumento
		FROM estudiante e,prematricula p,carrera c,ordenpago o,estudiantegeneral eg,documento d
		WHERE e.codigoestudiante = p.codigoestudiante
		AND e.idestudiantegeneral = eg.idestudiantegeneral
		AND d.tipodocumento = eg.tipodocumento
		AND c.codigocarrera = e.codigocarrera 
		AND o.idprematricula = p.idprematricula
		AND p.codigoestadoprematricula LIKE '4%'
		AND o.codigoestadoordenpago LIKE '4%'
		AND c.codigomodalidadacademica = '200'
		AND (e.codigosituacioncarreraestudiante = '100' or e.codigosituacioncarreraestudiante = '101' or e.codigosituacioncarreraestudiante = '102')		
		AND p.codigoperiodo = '$periodoactual'
		ORDER BY nombrecarrera,apellidosestudiantegeneral";		
		//echo $query_primiparos; exit;
		$primiparos = $db->Execute($query_primiparos);
		$totalRows_primiparos = $primiparos->RecordCount();
		$row_primiparos = $primiparos->FetchRow();   
	   
	   fwrite($gestor,"apellidos;nombres;tipoDocumento;documento;nombrePrograma\n");
	 
	   do{	
		  $tipodocumento = tipodocumentos($row_primiparos['tipodocumento']); 
  	      fwrite($gestor,"".$row_primiparos['apellidosestudiantegeneral'].";".$row_primiparos['nombresestudiantegeneral'].";".$tipodocumento.";'".$row_primiparos['numerodocumento'].";".$row_primiparos['nombrecarrera']."\n");
	   }while($row_primiparos = $primiparos->FetchRow());	  
	 }
 
	
	 fclose($gestor);
	 readfile($nombre_temp);
	 $archivo_fuente=$nombre_temp;
	 $archivo_destino="/var/tmp/spadies.txt";
	
	 unlink($archivo_destino);  
	 rename("$archivo_fuente", "$archivo_destino");  
	
	 echo '<script language="javascript">window.location.reload("descarga.php?archivo='.$nombrearchivo.'")</script>';
}

function tipodocumentos($numero)
 {  
    if ($numero == '01')
	 {
	   $numdoc = "C";	 
   	  }
	else
	if ($numero == '02')
	  {
	   $numdoc = "T";		
   	  }	
	else 
	if ($numero == '03')
	  {
	    $numdoc = "E";	   
   	  }	
	else  
	if ($numero == '04')
	  {
	    $numdoc = "R";		
   	  }	
	else
      {
	   $numdoc = "";	   
	  }
	return $numdoc;
  
 }
 
 function tipogenero($sex)
  {   
	if ($sex == 100)
	  {
	    $sexo = "F";	   
   	  }	
	 else
	 if ($sex == 200)
	  {
	    $sexo = "M";		
   	  }	
	 else
      {
	   $sexo = "";	  
	  }
    return $sexo;
 } 
 
 function codesniescarrera($cod,$db)
  {
    $query_carrerass = "select numeroregistrocarreraregistro
	from carreraregistro
    where codigocarrera = '$cod'";
	//echo $query_carrerass;
	$carrerass = $db->Execute($query_carrerass);
	$totalRows_carrerass = $carrerass->RecordCount();
	$row_carrerass = $carrerass->FetchRow();    
    
	if (!$row_carrerass)
	 {
	  $codigosnies = "";
	 }
	else
	 {
	   $codigosnies = $row_carrerass['numeroregistrocarreraregistro'];
	 }   
    return $codigosnies;
  
  }
?>
</form>
</body>
</html>
