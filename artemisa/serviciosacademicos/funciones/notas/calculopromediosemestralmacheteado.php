<?php
///////////////////////////////////// PROMEDIO SEMESTRAL PERIODO ANTERIORES A PRECIERRE /////////////////
$creditos = 0;
$notatotal = 0;
$indicadorulas = 0;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

mysql_select_db($database_sala, $sala);
//echo $_GET['tipocertificado'],"aca";
 if ($_GET['tipocertificado'] == "pasadas")  // Codigo incluido por orden de Secretaria General 12-03-2007 E.G.R
 {
	$query_promediosemestralperiodo = "SELECT n.idnotahistorico,m.codigoindicadorcredito,
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
	AND n.codigoperiodo = '$periodosemestral'
	AND n.codigoestadonotahistorico LIKE '1%'
	AND n.codigotiponotahistorico not like '11%'
	AND m.codigotipocalificacionmateria not like '2%'
	GROUP BY 1
	HAVING notadefinitiva >= notaminimaaprobatoria ";
	$res_promediosemestralperiodo = mysql_query($query_promediosemestralperiodo, $sala) or die("$query_promediosemestralperiodo".mysql_error());
	$solicitud_promediosemestralperiodo = mysql_fetch_assoc($res_promediosemestralperiodo);
 }
else
 {
    $query_promediosemestralperiodo = "SELECT m.codigoindicadorcredito
	FROM notahistorico n,materia m
	WHERE n.codigoestudiante = '".$codigoestudiante."'
	AND n.codigomateria = m.codigomateria
	and n.codigoperiodo = '$periodosemestral'
	AND n.codigoestadonotahistorico LIKE '1%'
	and n.codigotiponotahistorico not like '11%'
	and m.codigotipocalificacionmateria not like '2%'";
	$res_promediosemestralperiodo = mysql_query($query_promediosemestralperiodo, $sala) or die("$query_promediosemestralperiodo".mysql_error());
	$solicitud_promediosemestralperiodo = mysql_fetch_assoc($res_promediosemestralperiodo);
 }


do{
  if($solicitud_promediosemestralperiodo['codigoindicadorcredito'] == 200)
   {
    $indicadorulas = 1;
   }
}while($solicitud_promediosemestralperiodo = mysql_fetch_assoc($res_promediosemestralperiodo));

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
mysql_select_db($database_sala, $sala);

if ($_GET['tipocertificado'] == "pasadas")  // Codigo incluido por orden de Secretaria General 12-03-2007 E.G.R
 {
	$query_promediosemestralperiodo = "SELECT n.idnotahistorico,n.codigoperiodo,n.codigomateria,n.notadefinitiva,m.numerocreditos,ulasa,ulasb,ulasc,codigoindicadorcredito,
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
	AND n.codigoperiodo = '$periodosemestral'
	AND n.codigoestadonotahistorico LIKE '1%'
	AND n.codigotiponotahistorico not like '11%'
	AND m.codigotipocalificacionmateria not like '2%'
	AND ($cadenamateria)
	GROUP BY 1
	HAVING notadefinitiva >= notaminimaaprobatoria
	ORDER BY n.codigoperiodo";
    $res_promediosemestralperiodo = mysql_query($query_promediosemestralperiodo, $sala) or die("$query_promediosemestralperiodo".mysql_error());
	$solicitud_promediosemestralperiodo = mysql_fetch_assoc($res_promediosemestralperiodo);
  }
 else
 {

    $query_promediosemestralperiodo = "SELECT n.codigoperiodo,n.codigomateria,n.notadefinitiva,m.numerocreditos,ulasa,ulasb,ulasc,codigoindicadorcredito
	FROM notahistorico n,materia m
	WHERE n.codigoestudiante = '".$codigoestudiante."'
	AND n.codigomateria = m.codigomateria
	and n.codigoperiodo = '$periodosemestral'
	AND n.codigoestadonotahistorico LIKE '1%'
	and n.codigotiponotahistorico not like '11%'
	and m.codigotipocalificacionmateria not like '2%'
	and ($cadenamateria)
	ORDER BY n.codigoperiodo";
	//echo $query_promediosemestralperiodo,"<br>";
	$res_promediosemestralperiodo = mysql_query($query_promediosemestralperiodo, $sala) or die("$query_promediosemestralperiodo".mysql_error());
	$solicitud_promediosemestralperiodo = mysql_fetch_assoc($res_promediosemestralperiodo);
 }
//echo $query_promediosemestralperiodo,"<br>"; //

if ($solicitud_promediosemestralperiodo <> "")
{

do {
  if($indicadorulas == 1)
    {
	  if ($solicitud_promediosemestralperiodo['codigoindicadorcredito'] == 100)
		 {
		   $notatotal = $notatotal + ($solicitud_promediosemestralperiodo['notadefinitiva'] * ($solicitud_promediosemestralperiodo['numerocreditos'] * 48)) ;
		   $creditos = $creditos + ($solicitud_promediosemestralperiodo['numerocreditos'] * 48);
 	     }
	  else
		{
		   if ($solicitud_promediosemestralperiodo['notadefinitiva'] > 5)
		   {
		    $solicitud_promediosemestralperiodo['notadefinitiva'] = $solicitud_promediosemestralperiodo['notadefinitiva'] / 100;
		   }
		   $notatotal = $notatotal + ($solicitud_promediosemestralperiodo['notadefinitiva'] * ($solicitud_promediosemestralperiodo['ulasa'] + $solicitud_promediosemestralperiodo['ulasb'] + $solicitud_promediosemestralperiodo['ulasc'])) ;
		   $creditos  = $creditos  + ($solicitud_promediosemestralperiodo['ulasa'] + $solicitud_promediosemestralperiodo['ulasb'] + $solicitud_promediosemestralperiodo['ulasc']);
		  /*  echo "entro";
		    if ($periodosemestral == 19971)
		    {
			  $notamayorcinco = $solicitud_promediosemestralperiodo['notadefinitiva'];
			  $ulasa = $solicitud_promediosemestralperiodo['ulasa'];
			  $ulasb = $solicitud_promediosemestralperiodo['ulasb'];
			  $ulasc = $solicitud_promediosemestralperiodo['ulasc'];
			  echo " $notatotal = $notatotal + ($notamayorcinco * ( $ulasa  + $ulasb + $ulasc )  ---- ";
		      echo " $creditos = $creditos + ( $ulasa  + $ulasb + $ulasc ) <br>";
			}  */
		}
     }
	else
	 {
		   $notatotal = $notatotal + ($solicitud_promediosemestralperiodo['notadefinitiva'] * $solicitud_promediosemestralperiodo['numerocreditos']) ;
		   $creditos  = $creditos + $solicitud_promediosemestralperiodo['numerocreditos'];
	 }

}while($solicitud_promediosemestralperiodo = mysql_fetch_assoc($res_promediosemestralperiodo));


if($creditos != "")
 {
	/* $promediosemestralperiodo = (number_format($notatotal/$creditos,2));
    $promediosemestralperiodo = round($promediosemestralperiodo * 10)/10;  */
    $promediosemestralperiodo = $notatotal/$creditos;
    if($redondeo == 0)
    $promediosemestralperiodo = redondeo2 ($promediosemestralperiodo);
    else
        $promediosemestralperiodo = redondeo ($promediosemestralperiodo);
 }
//echo "acumuladosperiodo ->&nbsp;".$promediosemestralperiodo."<br>";
}
?>