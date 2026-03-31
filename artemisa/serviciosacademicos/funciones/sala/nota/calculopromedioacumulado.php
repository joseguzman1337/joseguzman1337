<?php // require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
//require('funcionesequivalencias.php');
//$codigoestudiante = '981102';
$notatotal = 0;
$creditos = 0;
$conplandeestudio = true;
if ($_GET['tipocertificado'] == "pasadas")  // Codigo incluido por orden de Secretaria General 12-03-2007 E.G.R
 {
	$query_promedioacumulado = "SELECT n.idnotahistorico,n.codigoperiodo,n.codigomateria,n.notadefinitiva,m.numerocreditos,m.ulasa,m.ulasb,m.ulasc,m.codigoindicadorcredito,p.idplanestudio,
	CASE n.notadefinitiva > '5' 
	WHEN 0 THEN n.notadefinitiva
	WHEN 1 THEN n.notadefinitiva / 100 * 1
	END AS notadefinitiva,
	CASE m.notaminimaaprobatoria > '5' 
	WHEN 0 THEN m.notaminimaaprobatoria
    WHEN 1 THEN m.notaminimaaprobatoria / 100 * 1
    END AS notaminimaaprobatoria	
	FROM notahistorico n,materia m,planestudioestudiante p
	WHERE n.codigoestudiante = '".$codigoestudiante."'	
	AND n.codigomateria = m.codigomateria	
	AND p.codigoestudiante = n.codigoestudiante		
	AND n.codigoestadonotahistorico LIKE '1%'																					   
	AND n.codigotiponotahistorico not like '11%'
	AND m.codigotipocalificacionmateria not like '2%'
	GROUP BY 1
	HAVING notadefinitiva >= notaminimaaprobatoria 
	ORDER BY n.codigoperiodo";
	//echo $query_promedioacumulado;
	$res_promedioacumulado = mysql_query($query_promedioacumulado, $sala) or die("$query_promedioacumulado".mysql_error());
	$solicitud_promedioacumulado = mysql_fetch_assoc($res_promedioacumulado);	
}
else
{ 
	$query_promedioacumulado = "SELECT 	n.codigoperiodo,n.codigomateria,n.notadefinitiva,m.numerocreditos,m.ulasa,m.ulasb,m.ulasc,m.codigoindicadorcredito,p.idplanestudio	
	FROM notahistorico n,materia m,planestudioestudiante p
	WHERE n.codigoestudiante = '".$codigoestudiante."'	
	AND n.codigomateria = m.codigomateria	
	and p.codigoestudiante = n.codigoestudiante								
	AND n.codigoestadonotahistorico LIKE '1%'																					   
	and n.codigotiponotahistorico not like '11%'
	and m.codigotipocalificacionmateria not like '2%'
	ORDER BY n.codigoperiodo";
   // echo $query_promedioacumulado;
	$res_promedioacumulado = mysql_query($query_promedioacumulado, $sala) or die("$query_promedioacumulado".mysql_error());
	$solicitud_promedioacumulado = mysql_fetch_assoc($res_promedioacumulado);  
} 
if(!$solicitud_promedioacumulado)
{
	$conplandeestudio = false;
  if ($_GET['tipocertificado'] == "pasadas")  // Codigo incluido por orden de Secretaria General 12-03-2007 E.G.R
   {
		$query_promedioacumulado = "SELECT n.idnotahistorico,n.codigoperiodo,n.codigomateria,n.notadefinitiva,m.numerocreditos,m.ulasa,m.ulasb,m.ulasc,m.codigoindicadorcredito,
		CASE n.notadefinitiva > '5' 
		WHEN 0 THEN n.notadefinitiva
		WHEN 1 THEN n.notadefinitiva / 100 * 1
		END AS notadefinitiva,
		CASE m.notaminimaaprobatoria > '5' 
		WHEN 0 THEN m.notaminimaaprobatoria
		WHEN 1 THEN m.notaminimaaprobatoria / 100 * 1
		END AS notaminimaaprobatoria	
		FROM notahistorico n,materia m
		WHERE n.codigoestudiante = '".$codigoestudiante."'	
		AND n.codigomateria = m.codigomateria		
		AND n.codigoestadonotahistorico LIKE '1%'																					   
		and n.codigotiponotahistorico not like '11%'
		and m.codigotipocalificacionmateria not like '2%'
		GROUP BY 1
	    HAVING notadefinitiva >= notaminimaaprobatoria 
		ORDER BY n.codigoperiodo";
		$res_promedioacumulado = mysql_query($query_promedioacumulado, $sala) or die("$query_promedioacumulado".mysql_error());
		$solicitud_promedioacumulado = mysql_fetch_assoc($res_promedioacumulado);  
	}
	else
	{ 
		$query_promedioacumulado = "SELECT n.codigoperiodo,n.codigomateria,n.notadefinitiva,m.numerocreditos,m.ulasa,m.ulasb,m.ulasc,m.codigoindicadorcredito	
		FROM notahistorico n,materia m
		WHERE n.codigoestudiante = '".$codigoestudiante."'	
		AND n.codigomateria = m.codigomateria	
		AND n.codigoestadonotahistorico LIKE '1%'																					   
		and n.codigotiponotahistorico not like '11%'
		and m.codigotipocalificacionmateria not like '2%'
		ORDER BY n.codigoperiodo";
		$res_promedioacumulado = mysql_query($query_promedioacumulado, $sala) or die("$query_promedioacumulado".mysql_error());
		$solicitud_promedioacumulado = mysql_fetch_assoc($res_promedioacumulado);  
	}
}
do
{
   if($conplandeestudio)
   {
	   // echo $sala;
	   // echo $solicitud_promedioacumulado['codigomateria'],"&nbsp;",$solicitud_promedioacumulado['idplanestudio'];
	   $equivalencia = seleccionarequivalencias1($solicitud_promedioacumulado['codigomateria'],$solicitud_promedioacumulado['idplanestudio'],$sala);
	   //echo $equivalencia,"<br>";
	   $Arregloequivalencias = seleccionarequivalencias($equivalencia,$solicitud_promedioacumulado['idplanestudio'],$sala); 

	   if ($equivalencia == "")
	    {
		 $Arregloequivalencias[] = $solicitud_promedioacumulado['codigomateria'];
		}
	   $Arregloequivalencias[] = $equivalencia;

 		//////////////////////////////////// 

 		//echo "<h2>",$equivalencia,"</h2><br>"; 
 		foreach($Arregloequivalencias as $key3 => $selEquivalencias)
		{	
			$notamayor = 0;
			//echo "$key3 => $selEquivalencias<br>";
			$query_promedioacumulado1 = "SELECT n.notadefinitiva                            
			FROM notahistorico n
			WHERE n.codigoestudiante = '".$codigoestudiante."'	
			AND n.codigomateria = '$selEquivalencias'	            
			AND n.codigoestadonotahistorico LIKE '1%'						
			ORDER BY 1 desc";												
			//echo $query_promedioacumulado1,"<br>";
			$res_promedioacumulado1 = mysql_query($query_promedioacumulado1, $sala) or die(mysql_error());
			$solicitud_promedioacumulado1 = mysql_fetch_assoc($res_promedioacumulado1);											

       		if($solicitud_promedioacumulado1 <> "")
	    	{
				if($solicitud_promedioacumulado1['notadefinitiva'] > 5)
			 	{		   
			  		$notamayor =  number_format(($solicitud_promedioacumulado1['notadefinitiva'] / 100),1);	       
			 	}
				else
			 	{
			  		$notamayor = $solicitud_promedioacumulado1['notadefinitiva'];
			 	}
				//echo $notamayor,"<br>";
				$notamateria[$selEquivalencias] = $notamayor;
				$codigomateria = $selEquivalencias;		
       		}
		}
		@$maxnota = max($notamateria);	
		@$res_nota = array_keys ($notamateria, $maxnota);
		// Toma el semestre de la primera posicion indicando que es el priemer semestre de los escogidos 
		//echo $res_nota[0],"mayor $maxnota";
		$notadefinitiva[$res_nota[0]]=$maxnota;
		unset($Arregloequivalencias);
		unset($notamateria);
	}
	else
	{
		if($solicitud_promedioacumulado['notadefinitiva'] > 5)
		{		   
			$notamayor =  number_format(($solicitud_promedioacumulado['notadefinitiva'] / 100),1);	       
		}
		else
		{
			$notamayor = $solicitud_promedioacumulado['notadefinitiva'];
		}
		$notadefinitiva[$solicitud_promedioacumulado['codigomateria']] = $notamayor;
		//echo "$notamateria [".$solicitud_promedioacumulado['codigomateria']."] = $notamayor;<br>";
	}
}
while($solicitud_promedioacumulado = mysql_fetch_assoc($res_promedioacumulado));

foreach($notadefinitiva as $key3 => $selEquivalencias)
{// foreach 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	mysql_select_db($database_sala, $sala);
	$query_promedioacumulado = "SELECT *
	FROM notahistorico n,materia m
	WHERE n.codigoestudiante = '".$codigoestudiante."'							
    AND n.codigomateria = '$key3'		            
	AND n.codigoestadonotahistorico LIKE '1%'									   
	and n.codigomateria = m.codigomateria
	ORDER BY 1";
	$res_promedioacumulado = mysql_query($query_promedioacumulado, $sala) or die(mysql_error());
	$solicitud_promedioacumulado = mysql_fetch_assoc($res_promedioacumulado);													
	do
	{
   		if($solicitud_promedioacumulado['codigoindicadorcredito'] == 200)
		{
	    	$indicadorulas = 1;	
		}
	}

	while($solicitud_promedioacumulado = mysql_fetch_assoc($res_promedioacumulado));

	$query_promedioacumulado2 = "SELECT n.codigomateria,n.notadefinitiva,
	m.numerocreditos,ulasa,ulasb,ulasc,codigoindicadorcredito	
	FROM notahistorico n,materia m
	WHERE n.codigoestudiante = '".$codigoestudiante."'							
	AND n.codigomateria = '$key3'		            
    AND n.codigoestadonotahistorico LIKE '1%'									   
	and n.codigomateria = m.codigomateria  
	ORDER BY 1";
	$res_promedioacumulado2 = mysql_query($query_promedioacumulado2, $sala) or die(mysql_error());
	$solicitud_promedioacumulado2 = mysql_fetch_assoc($res_promedioacumulado2);

	if($solicitud_promedioacumulado2 <> "")
	{
		if($indicadorulas == 1)
		{ 
  			if($solicitud_promedioacumulado2['codigoindicadorcredito'] == 100)
	 		{
	   			$notatotal = $notatotal + ($selEquivalencias * ($solicitud_promedioacumulado2['numerocreditos'] * 48)) ;
	   			$creditos = $creditos + ($solicitud_promedioacumulado2['numerocreditos'] * 48);
			}
  			else
			{
			   $notatotal = $notatotal + ($selEquivalencias * ($solicitud_promedioacumulado2['ulasa'] + $solicitud_promedioacumulado2['ulasb'] + $solicitud_promedioacumulado2['ulasc'])) ;
			   $creditos = $creditos + ($solicitud_promedioacumulado2['ulasa'] + $solicitud_promedioacumulado2['ulasb'] + $solicitud_promedioacumulado2['ulasc']);		 
			}
   		}
		else
 		{	   
	    	$notatotal = $notatotal + ($selEquivalencias * $solicitud_promedioacumulado2['numerocreditos']) ;
	   		$creditos = $creditos + $solicitud_promedioacumulado2['numerocreditos'];			 
 		}
	}
}
if($creditos != "")
{
	//$promedioacumulado = (number_format($notatotal/$creditos,1));
	$promedioacumulado = $notatotal/$creditos;
	$promedioacumulado = redondeo ($promedioacumulado);	
	
}

$query_est1 = "select b.valorbasesalario, b.porcentajeincrementobasesalario
from basesalario b
where b.valorbasesalario = '$codigoestudiante'";
$est1 = mysql_query($query_est1, $sala) or die("$query_est1".mysql_error());
$row_est1 = mysql_fetch_assoc($est1);
if($row_est1 == "")
{
	// Debe insertar el ppa
	$query_insest1 = "INSERT INTO basesalario(idbasesalario, nombrebasesalario, fechainiciobasesalario, fechafinalbasesalario, valorbasesalario, porcentajeincrementobasesalario) 
	VALUES(0, 'SALA', now(), now(), '$codigoestudiante', '$promedioacumulado')";
	$insest1 = mysql_query($query_insest1, $sala) or die("$query_insest1".mysql_error());
}
else
{
	// Debe hacerle update al ppa
	$query_updest1 = "update basesalario b
	set b.porcentajeincrementobasesalario = '$promedioacumulado'
	where b.valorbasesalario = '$codigoestudiante'";
	$updest1 = mysql_query($query_updest1, $sala) or die("$query_updest1".mysql_error());
}
unset($Arregloequivalencias);
unset($notamateria);
unset($notadefinitiva);
unset($maxnota);
unset($res_nota);
?>