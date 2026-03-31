<?php 
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
function seleccionarequivalencias1($codigomateria,$idplanestudio,$sala)
{	
	$query_selequivalencias = "select r.codigomateria, r.fechainicioreferenciaplanestudio, r.fechavencimientoreferenciaplanestudio
	from referenciaplanestudio r
	where r.idplanestudio = '$idplanestudio'
	and r.codigomateriareferenciaplanestudio = '$codigomateria'	
	and r.codigotiporeferenciaplanestudio like '3%'";
    //echo "$query_selequivalencias<br>";//and r.idlineaenfasisplanestudio = '$idlineaenfasis'
	$selequivalencias = mysql_query($query_selequivalencias, $sala) or die(mysql_error());
	$totalRows_selequivalencias = mysql_num_rows($selequivalencias);
	$row_selequivalencias = mysql_fetch_assoc($selequivalencias);
	if($totalRows_selequivalencias != "")
	{
     	//echo $row_selequivalencias['codigomateria'],"hola<br>";
		$codigomateriaequivalentes = $row_selequivalencias['codigomateria'];
		//echo $codigomateriaequivalente;		
		return $codigomateriaequivalentes;
	}
	else
	{	
	///echo "hola3<br>";
	   $query_selequivalencias = "select r.codigomateria, r.fechainicioreferenciaplanestudio, r.fechavencimientoreferenciaplanestudio
	   from referenciaplanestudio r
	   where r.idplanestudio = '$idplanestudio'
 	   and r.codigomateria = '$codigomateria'								
   	   and r.codigotiporeferenciaplanestudio = '300'";
   	   //echo "$query_selequivalencias<br>";
   	   $selequivalencias = mysql_query($query_selequivalencias, $sala) or die("$query_selequivalencias");
	   $totalRows_selequivalencias = mysql_num_rows($selequivalencias);
	   $row_selequivalencias = mysql_fetch_assoc($selequivalencias); 

 	   return $row_selequivalencias['codigomateria'];  
	}
}

function seleccionarequivalencias($codigomateria, $idplanestudio, $sala)
{
	//echo "$codigomateria<br>";	
	// La correspondencia siempre va a ser uno a uno
	$query_selequivalencias = "select r.codigomateriareferenciaplanestudio, r.fechainicioreferenciaplanestudio, r.fechavencimientoreferenciaplanestudio
	from referenciaplanestudio r
	where r.idplanestudio = '$idplanestudio'
	and r.codigomateria = '$codigomateria'	
	and r.codigotiporeferenciaplanestudio like '3%'";
	//echo "$query_selequivalencias<br>";
	$selequivalencias = mysql_query($query_selequivalencias, $sala) or die("$query_selequivalencias");
	$totalRows_selequivalencias = mysql_num_rows($selequivalencias);
	if($totalRows_selequivalencias != "")
	{
		while($row_selequivalencias = mysql_fetch_assoc($selequivalencias))
		{
			$codigomateriaequivalente = $row_selequivalencias['codigomateriareferenciaplanestudio'];		
			//echo "$codigomateriaequivalente<br>";
			$Arregloequivalencias[] = $codigomateriaequivalente;
		}
		return $Arregloequivalencias;
	}
	else
	{
		return;
	}
}

// Esta función retorna la materia papa equivalente de una materia
function seleccionarequivalenciapapa($codigomateria,$codigoestudiante,$sala)
{	
	$query_selequivalencias = "select r.codigomateria, r.fechainicioreferenciaplanestudio, r.fechavencimientoreferenciaplanestudio
	from referenciaplanestudio r, planestudioestudiante pee
	where r.idplanestudio = pee.idplanestudio
	and pee.codigoestudiante = '$codigoestudiante'
	and pee.codigoestadoplanestudioestudiante like '1%'
	and r.codigomateriareferenciaplanestudio = '$codigomateria'	
	and r.codigotiporeferenciaplanestudio like '3%'";
    //echo "$query_selequivalencias<br>";//and r.idlineaenfasisplanestudio = '$idlineaenfasis'
	$selequivalencias = mysql_query($query_selequivalencias, $sala) or die(mysql_error());
	$totalRows_selequivalencias = mysql_num_rows($selequivalencias);
	$row_selequivalencias = mysql_fetch_assoc($selequivalencias);

	if($totalRows_selequivalencias != "")
	{
     	//echo $row_selequivalencias['codigomateria'],"hola<br>";
		$codigomateriaequivalentes = $row_selequivalencias['codigomateria'];
		//echo $codigomateriaequivalente;		
		return $codigomateriaequivalentes;
	}
	else
	{	
		///echo "hola3<br>";
		   
	   	$query_selequivalencias = "select r.codigomateria, r.fechainicioreferenciaplanestudio, r.fechavencimientoreferenciaplanestudio
		from referenciaplanestudio r, planestudioestudiante pee
		where r.idplanestudio = pee.idplanestudio 
		and r.codigomateria = '$codigomateria'								
		and r.codigotiporeferenciaplanestudio = '300'
		and pee.codigoestudiante = '$codigoestudiante'
		and pee.codigoestadoplanestudioestudiante like '1%'";
		//echo "$query_selequivalencias<br>";
		$selequivalencias = mysql_query($query_selequivalencias, $sala) or die("$query_selequivalencias".mysql_error());
		$totalRows_selequivalencias = mysql_num_rows($selequivalencias);
		$row_selequivalencias = mysql_fetch_assoc($selequivalencias); 

	  	return $row_selequivalencias['codigomateria'];  
	}
}

function seleccionarequivalenciasrow($codigomateria, $codigoestudiante, $formatocadena, $sala)
{
	//echo "$codigomateria<br>";	
	// La correspondencia siempre va a ser uno a uno
	$query_selequivalencias = "select r.codigomateriareferenciaplanestudio, r.fechainicioreferenciaplanestudio, r.fechavencimientoreferenciaplanestudio,pee.idplanestudio
	from referenciaplanestudio r, planestudioestudiante pee
	where r.idplanestudio = pee.idplanestudio
	and r.codigomateria = '$codigomateria'
	and r.codigotiporeferenciaplanestudio like '3%'
	and pee.codigoestudiante = '$codigoestudiante'	
	and pee.codigoestadoplanestudioestudiante like '1%'";
	//echo "$query_selequivalencias<br>";
	$selequivalencias = mysql_query($query_selequivalencias, $sala) or die("$query_selequivalencias".mysql_error());
	$totalRows_selequivalencias = mysql_num_rows($selequivalencias);
	if($totalRows_selequivalencias != "")
	{
		$cadena = "";
		$cadena = $cadena.$formatocadena."'".$codigomateria."' or";
		$Arregloequivalencias[] = $codigomateria;
		while($row_selequivalencias = mysql_fetch_assoc($selequivalencias))
		{
			$idplan = $row_selequivalencias['idplanestudio'];
			$codigomateriaequivalente = $row_selequivalencias['codigomateriareferenciaplanestudio'];		
			$cadena = $cadena.$formatocadena."'".$codigomateriaequivalente."' or";
			//echo "$codigomateriaequivalente<br>";
			$Arregloequivalencias[] = $codigomateriaequivalente;
		}
		$cadena = $cadena."fin";
		$cadequivalencias = ereg_replace("orfin","",$cadena);
	
		//echo "$cadequivalencias <br><br>";
		//exit();	

  	    $query_mejornota = "select n.codigomateria, n.notadefinitiva, case n.notadefinitiva > '5'
		when 0 then n.notadefinitiva
		when 1 then n.notadefinitiva / 100
		end as nota, n.codigoperiodo, m.nombremateria,codigomateriaelectiva as semestre 
		from notahistorico n, materia m
		where n.codigoestudiante = '$codigoestudiante' 
		and n.codigomateria = m.codigomateria
		and ($cadequivalencias) order by 3 desc ";
		$mejornota = mysql_query($query_mejornota, $sala) or die("$query_mejornota ".mysql_error());
		$totalRows_mejornota = mysql_num_rows($mejornota);
		$row_mejornota = mysql_fetch_assoc($mejornota);
		
		$row_mejornota['semestre'] = "";
		
		$query_semestremateria = "select semestredetalleplanestudio
	    from detalleplanestudio
	    where idplanestudio = '$idplan' 
	    and codigomateria like  '$codigomateria'";
        $semestremateria  = mysql_query($query_semestremateria , $sala) or die(mysql_error());
        $totalRows_semestremateria  = mysql_num_rows($semestremateria );
	    $row_semestremateria  = mysql_fetch_assoc($semestremateria );
		
		if ($row_semestremateria  <> "")
		 {
		  $row_mejornota['semestre'] = $row_semestremateria['semestredetalleplanestudio']; 
		 }
		else
		 {
		   $row_mejornota['semestre'] = $row_mejornota['codigoperiodo'];
		 }
		return $row_mejornota;
	}
	else
	{
		return;
	}
}
?>