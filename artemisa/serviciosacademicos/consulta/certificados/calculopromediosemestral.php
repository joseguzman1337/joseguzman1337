<?php
///////////////////////////////////// PROMEDIO SEMESTRAL PERIODO ANTERIORES A PRECIERRE /////////////////
$creditos = 0;
$notatotal = 0;
$indicadorulas = 0;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
mysql_select_db($database_sala, $sala);
// Codogo incluido por orden de Secretaria General 12-03-2007 E.G.R
if ($_GET['tipocertificado'] == "pasadas")
{
	$query_promediosemestralperiodo = "SELECT m.codigoindicadorcredito
	FROM notahistorico n,materia m
	WHERE n.codigoestudiante = '".$codigoestudiante."'
	AND n.notadefinitiva >= m.notaminimaaprobatoria
	AND n.codigomateria = m.codigomateria
	AND n.codigoperiodo = '$periodosemestral'
	AND n.codigoestadonotahistorico LIKE '1%'
	AND n.codigotiponotahistorico not like '11%'";
}
else
{
    $query_promediosemestralperiodo = "SELECT m.codigoindicadorcredito
	FROM notahistorico n,materia m
	WHERE n.codigoestudiante = '".$codigoestudiante."'
	AND n.codigomateria = m.codigomateria
	AND n.codigoperiodo = '$periodosemestral'
	AND n.codigoestadonotahistorico LIKE '1%'
	AND n.codigotiponotahistorico not like '11%'";
}
//echo $query_promediosemestralperiodo;
$res_promediosemestralperiodo = mysql_query($query_promediosemestralperiodo, $sala) or die(mysql_error());
$solicitud_promediosemestralperiodo = mysql_fetch_assoc($res_promediosemestralperiodo);
do
{
    if($solicitud_promediosemestralperiodo['codigoindicadorcredito'] == 200)
    {
        $indicadorulas = 1;
    }
}
while($solicitud_promediosemestralperiodo = mysql_fetch_assoc($res_promediosemestralperiodo));

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
mysql_select_db($database_sala, $sala);
// Codigo incluido por orden de Secretaria General 12-03-2007 E.G.R
if ($_GET['tipocertificado'] == "pasadas")
{
    $query_promediosemestralperiodo = "SELECT n.codigoperiodo, n.codigomateria, n.notadefinitiva, m.numerocreditos, ulasa, ulasb, ulasc, codigoindicadorcredito
	FROM notahistorico n,materia m
	WHERE n.codigoestudiante = '".$codigoestudiante."'
	AND n.notadefinitiva >= m.notaminimaaprobatoria
	AND n.codigomateria = m.codigomateria
	AND n.codigoperiodo = '$periodosemestral'
	AND n.codigoestadonotahistorico LIKE '1%'
	AND n.codigotiponotahistorico not like '11%'
	ORDER BY n.codigoperiodo";
	//echo $query_promediosemestralperiodo,"<br>";
	$res_promediosemestralperiodo = mysql_query($query_promediosemestralperiodo, $sala) or die(mysql_error());
	$solicitud_promediosemestralperiodo = mysql_fetch_assoc($res_promediosemestralperiodo);
}
else
{
    $query_promediosemestralperiodo = "SELECT n.codigoperiodo, n.codigomateria, n.notadefinitiva, m.numerocreditos, ulasa, ulasb, ulasc, codigoindicadorcredito
	FROM notahistorico n,materia m
	WHERE n.codigoestudiante = '".$codigoestudiante."'
	AND n.codigomateria = m.codigomateria
	AND n.codigoperiodo = '$periodosemestral'
	AND n.codigoestadonotahistorico LIKE '1%'
	AND n.codigotiponotahistorico not like '11%'
	ORDER BY n.codigoperiodo";
	//echo $query_promediosemestralperiodo,"<br>";
	$res_promediosemestralperiodo = mysql_query($query_promediosemestralperiodo, $sala) or die(mysql_error());
	$solicitud_promediosemestralperiodo = mysql_fetch_assoc($res_promediosemestralperiodo);

}
if ($solicitud_promediosemestralperiodo <> "")
{
    do
    {
        $notamayorcinco = 0;
        if ($solicitud_promediosemestralperiodo['notadefinitiva'] > 5)
	   {
	       //  $notamayorcinco = number_format(($solicitud_promediosemestralperiodo['notadefinitiva'] / 100),1);
	       $notamayorcinco = $solicitud_promediosemestralperiodo['notadefinitiva'] / 100;
	   }
	   else
	   {
	       $notamayorcinco = $solicitud_promediosemestralperiodo['notadefinitiva'];
	   }

        if($indicadorulas == 1)
        {
            if ($solicitud_promediosemestralperiodo['codigoindicadorcredito'] == 100)
            {
		      $notatotal = $notatotal + ($notamayorcinco * ($solicitud_promediosemestralperiodo['numerocreditos'] * 48)) ;
		      $creditos = $creditos + ($solicitud_promediosemestralperiodo['numerocreditos'] * 48);
		    }
	        else
		    {
                $notatotal = $notatotal + ($notamayorcinco * ($solicitud_promediosemestralperiodo['ulasa'] + $solicitud_promediosemestralperiodo['ulasb'] + $solicitud_promediosemestralperiodo['ulasc']));
		        $creditos = $creditos + ($solicitud_promediosemestralperiodo['ulasa'] + $solicitud_promediosemestralperiodo['ulasb'] + $solicitud_promediosemestralperiodo['ulasc']);
		    }
	      /* if ($periodosemestral == 19952)
		    {
			  $ulasa = $solicitud_promediosemestralperiodo['ulasa'];
			  $ulasb = $solicitud_promediosemestralperiodo['ulasb'];
			  $ulasc = $solicitud_promediosemestralperiodo['ulasc'];
			  echo " $notatotal = $notatotal + ($notamayorcinco * ( $ulasa  + $ulasb + $ulasc )  ---- ";
		      echo " $creditos = $creditos + ( $ulasa  + $ulasb + $ulasc ) <br>";
			} */
        }
        else
        {
            $notatotal = $notatotal + ($notamayorcinco * $solicitud_promediosemestralperiodo['numerocreditos']) ;
	        $creditos = $creditos + $solicitud_promediosemestralperiodo['numerocreditos'];
	     }
    }
    while($solicitud_promediosemestralperiodo = mysql_fetch_assoc($res_promediosemestralperiodo));

    @$promediosemestralperiodo = (round($notatotal/$creditos,2));
    //echo "acumuladosperiodo ->&nbsp;".$promediosemestralperiodo."<br>";
    $promediosemestralperiodo=round($promediosemestralperiodo * 10)/10;
}
?>