<?php
/*
 * Reporte de resultados notas estudiante - calculo del promedio acumulado (pregrado)
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Creado 10 de Octubre de 2017.
 */   
mysql_select_db($database_sala, $sala);
$notatotal = 0;
$creditos = 0;
$conplandeestudio = true;

if(isset($_GET['periodo'])) {
    if($_GET['periodo'] != 0)
        $periodofiltro = " AND n.codigoperiodo <= ".$_GET['periodo']."";
}
if ($_GET['tipocertificado'] == "pasadas")  // Codigo incluido por orden de Secretaria General 12-03-2007 E.G.R
{
    $query_promedioacumulado = "SELECT n.codigomateria,n.notadefinitiva,m.codigoindicadorcredito,p.idplanestudio,
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
            $periodofiltro
	AND n.codigotiponotahistorico not like '11%'
	AND m.codigotipocalificacionmateria not like '2%'
	GROUP BY 1
	HAVING notadefinitiva >= notaminimaaprobatoria 
	ORDER BY n.codigoperiodo";
    $res_promedioacumulado = mysql_query($query_promedioacumulado, $sala) or die("$query_promedioacumulado".mysql_error());
    $solicitud_promedioacumulado = mysql_fetch_assoc($res_promedioacumulado);
}
else {
    $query_promedioacumulado = "SELECT 	n.codigomateria,n.notadefinitiva,m.codigoindicadorcredito,p.idplanestudio
	FROM notahistorico n,materia m,planestudioestudiante p
	WHERE n.codigoestudiante = '".$codigoestudiante."'	
	AND n.codigomateria = m.codigomateria	
	and p.codigoestudiante = n.codigoestudiante								
	AND n.codigoestadonotahistorico LIKE '1%'								$periodofiltro
	and n.codigotiponotahistorico not like '11%'
	and m.codigotipocalificacionmateria not like '2%'
	ORDER BY n.codigoperiodo";
    $res_promedioacumulado = mysql_query($query_promedioacumulado, $sala) or die("$query_promedioacumulado".mysql_error());
    $solicitud_promedioacumulado = mysql_fetch_assoc($res_promedioacumulado);
} 
if(!$solicitud_promedioacumulado) {
    $conplandeestudio = false;
    if ($_GET['tipocertificado'] == "pasadas")  // Codigo incluido por orden de Secretaria General 12-03-2007 E.G.R
    {
        $query_promedioacumulado = "SELECT n.codigomateria,n.notadefinitiva,m.codigoindicadorcredito,
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
		AND n.codigoestadonotahistorico LIKE '1%'							$periodofiltro
		and n.codigotiponotahistorico not like '11%'
		and m.codigotipocalificacionmateria not like '2%'
		GROUP BY 1
	    HAVING notadefinitiva >= notaminimaaprobatoria 
		ORDER BY n.codigoperiodo";
        $res_promedioacumulado = mysql_query($query_promedioacumulado, $sala) or die("$query_promedioacumulado".mysql_error());
        $solicitud_promedioacumulado = mysql_fetch_assoc($res_promedioacumulado);
    }
    else {
        $query_promedioacumulado = "SELECT n.codigomateria,n.notadefinitiva,m.codigoindicadorcredito
		FROM notahistorico n,materia m
		WHERE n.codigoestudiante = '".$codigoestudiante."'	
		AND n.codigomateria = m.codigomateria	
		AND n.codigoestadonotahistorico LIKE '1%'							$periodofiltro
		and n.codigotiponotahistorico not like '11%'
		and m.codigotipocalificacionmateria not like '2%'
		ORDER BY n.codigoperiodo";
        $res_promedioacumulado = mysql_query($query_promedioacumulado, $sala) or die("$query_promedioacumulado".mysql_error());
        $solicitud_promedioacumulado = mysql_fetch_assoc($res_promedioacumulado);
    }
}
do {
    if($conplandeestudio) {
	$query_selequivalencias = "select r.codigomateria
	from referenciaplanestudio r
	where r.idplanestudio = '".$solicitud_promedioacumulado['idplanestudio']."'
	and r.codigomateriareferenciaplanestudio = '".$solicitud_promedioacumulado['codigomateria']."'	
	and r.codigotiporeferenciaplanestudio like '3%'";
	$selequivalencias = mysql_query($query_selequivalencias, $sala) or die(mysql_error());
	$totalRows_selequivalencias = mysql_num_rows($selequivalencias);
	$row_selequivalencias = mysql_fetch_assoc($selequivalencias);
	if($totalRows_selequivalencias != "")
	{
		$codigomateriaequivalentes = $row_selequivalencias['codigomateria'];
		$equivalencia=$codigomateriaequivalentes;
	}
	else
	{
	   $query_selequivalencias = "select r.codigomateria
	   from referenciaplanestudio r
	   where r.idplanestudio = '".$solicitud_promedioacumulado['idplanestudio']."'
 	   and r.codigomateria = '".$solicitud_promedioacumulado['codigomateria']."'								
   	   and r.codigotiporeferenciaplanestudio = '300'";
   	   $selequivalencias = mysql_query($query_selequivalencias, $sala) or die("$query_selequivalencias");
	   $totalRows_selequivalencias = mysql_num_rows($selequivalencias);
	   $row_selequivalencias = mysql_fetch_assoc($selequivalencias); 

 	   $equivalencia=$row_selequivalencias['codigomateria'];
	}
        
        
    global $db;
    // La correspondencia siempre va a ser uno a uno
    $query_selequivalencias = "select r.codigomateriareferenciaplanestudio
    from referenciaplanestudio r
    where r.idplanestudio = '".$solicitud_promedioacumulado['idplanestudio']."'
    and r.codigomateria = '$equivalencia'
    and r.codigotiporeferenciaplanestudio like '3%'";
    //echo "$query_selequivalencias<br>";
    $selequivalencias = $db->Execute($query_selequivalencias);
    $totalRows_selequivalencias = $selequivalencias->RecordCount();
    if($totalRows_selequivalencias != "")
    {
        while($row_selequivalencias = $selequivalencias->FetchRow())
        {
            $codigomateriaequivalente = $row_selequivalencias['codigomateriareferenciaplanestudio'];
            //echo "$codigomateriaequivalente<br>";
            $Arregloequivalencias[] = $codigomateriaequivalente;
        }
        $Arregloequivalencias;
    }

        if ($equivalencia == "") {
            $Arregloequivalencias[] = $solicitud_promedioacumulado['codigomateria'];
        }
        $Arregloequivalencias[] = $equivalencia;

        ////////////////////////////////////

        foreach($Arregloequivalencias as $key3 => $selEquivalencias) {
            $notamayor = 0;
            $query_promedioacumulado1 = "SELECT n.notadefinitiva
			FROM notahistorico n
			WHERE n.codigoestudiante = '".$codigoestudiante."'	
			AND n.codigomateria = '$selEquivalencias'	            
			AND n.codigoestadonotahistorico LIKE '1%'						
			ORDER BY 1 desc";
            $res_promedioacumulado1 = mysql_query($query_promedioacumulado1, $sala) or die(mysql_error()." ".$query_promedioacumulado1);
            $solicitud_promedioacumulado1 = mysql_fetch_assoc($res_promedioacumulado1);

            if($solicitud_promedioacumulado1 <> "") {
                if($solicitud_promedioacumulado1['notadefinitiva'] > 5) {
                    $notamayor =  number_format(($solicitud_promedioacumulado1['notadefinitiva'] / 100),1);
                }
                else {
                    $notamayor = $solicitud_promedioacumulado1['notadefinitiva'];
                }
                $notamateria[$selEquivalencias] = $notamayor;
                $codigomateria = $selEquivalencias;
            }
        }
        @$maxnota = max($notamateria);
        @$res_nota = array_keys ($notamateria, $maxnota);
        // Toma el semestre de la primera posicion indicando que es el priemer semestre de los escogidos
        $notadefinitiva[$res_nota[0]]=$maxnota;
        unset($Arregloequivalencias);
        unset($notamateria);
    }
    else {
        if($solicitud_promedioacumulado['notadefinitiva'] > 5) {
            $notamayor =  number_format(($solicitud_promedioacumulado['notadefinitiva'] / 100),1);
        }
        else {
            $notamayor = $solicitud_promedioacumulado['notadefinitiva'];
        }
        $notadefinitiva[$solicitud_promedioacumulado['codigomateria']] = $notamayor;
    }
}
while($solicitud_promedioacumulado = mysql_fetch_assoc($res_promedioacumulado));

foreach($notadefinitiva as $key3 => $selEquivalencias) {// foreach
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    mysql_select_db($database_sala, $sala);
    $query_promedioacumulado = "SELECT m.codigoindicadorcredito
	FROM notahistorico n,materia m
	WHERE n.codigoestudiante = '".$codigoestudiante."'							
    AND n.codigomateria = '$key3'		            
	AND n.codigoestadonotahistorico LIKE '1%'									   
	and n.codigomateria = m.codigomateria
	ORDER BY 1";
    $res_promedioacumulado = mysql_query($query_promedioacumulado, $sala) or die(mysql_error()." ".$query_promedioacumulado);
    $solicitud_promedioacumulado = mysql_fetch_assoc($res_promedioacumulado);
    do {
        if($solicitud_promedioacumulado['codigoindicadorcredito'] == 200) {
            $indicadorulas = 1;
        }
    }

    while($solicitud_promedioacumulado = mysql_fetch_assoc($res_promedioacumulado));

    $query_promedioacumulado2 = "SELECT 
	m.numerocreditos,ulasa,ulasb,ulasc,codigoindicadorcredito	
	FROM notahistorico n,materia m
	WHERE n.codigoestudiante = '".$codigoestudiante."'							
	AND n.codigomateria = '$key3'		            
    AND n.codigoestadonotahistorico LIKE '1%'									   
	and n.codigomateria = m.codigomateria  
	ORDER BY 1";
    $res_promedioacumulado2 = mysql_query($query_promedioacumulado2, $sala) or die(mysql_error()." ".$query_promedioacumulado2);
    $solicitud_promedioacumulado2 = mysql_fetch_assoc($res_promedioacumulado2);

    if($solicitud_promedioacumulado2 <> "") {
        if($indicadorulas == 1) {
            if($solicitud_promedioacumulado2['codigoindicadorcredito'] == 100) {
                $notatotal = $notatotal + ($selEquivalencias * ($solicitud_promedioacumulado2['numerocreditos'] * 48)) ;
                $creditos = $creditos + ($solicitud_promedioacumulado2['numerocreditos'] * 48);
            }
            else {
                $notatotal = $notatotal + ($selEquivalencias * ($solicitud_promedioacumulado2['ulasa'] + $solicitud_promedioacumulado2['ulasb'] + $solicitud_promedioacumulado2['ulasc'])) ;
                $creditos = $creditos + ($solicitud_promedioacumulado2['ulasa'] + $solicitud_promedioacumulado2['ulasb'] + $solicitud_promedioacumulado2['ulasc']);
            }
        }
        else {
            $notatotal = $notatotal + ($selEquivalencias * $solicitud_promedioacumulado2['numerocreditos']) ;
            $creditos = $creditos + $solicitud_promedioacumulado2['numerocreditos'];
        }
    }
}
if($creditos != "") {
    $tpromedioacumulado = $notatotal/$creditos;
    if($redondeo == 0){
        $promedioacumulado = number_format($tpromedioacumulado,2);
    }else if($redondeo == 3){
        $promedioacumulado = number_format($tpromedioacumulado,3);
    }else{
        $promedioacumulado = number_format($tpromedioacumulado,1);
    }
}   
unset($Arregloequivalencias);
unset($notamateria);
unset($notadefinitiva);
unset($maxnota);
unset($res_nota);
//end
?>
