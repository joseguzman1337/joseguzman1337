<?php  
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
///////////////////////////////////// PROMEDIO SEMESTRAL PERIODO ANTERIORES A PRECIERRE /////////////////
$creditos = 0;
$notatotal = 0;
$indicadorulas = 0;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
mysql_select_db($database_sala, $sala);
$query_promediosemestralperiodo = "SELECT m.codigoindicadorcredito	
									FROM notahistorico n,materia m
									WHERE n.codigoestudiante = '".$codigoestudiante."'	
									AND n.codigomateria = m.codigomateria	
									and n.codigoperiodo = '$periodosemestral'	            
									AND n.codigoestadonotahistorico LIKE '1%'									
";				
$res_promediosemestralperiodo = mysql_query($query_promediosemestralperiodo, $sala) or die(mysql_error());
$solicitud_promediosemestralperiodo = mysql_fetch_assoc($res_promediosemestralperiodo);	

do{
  if($solicitud_promediosemestralperiodo['codigoindicadorcredito'] == 200)
   {
    $indicadorulas = 1;	
   }
}while($solicitud_promediosemestralperiodo = mysql_fetch_assoc($res_promediosemestralperiodo));
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
mysql_select_db($database_sala, $sala);
$query_promediosemestralperiodo = "SELECT n.codigoperiodo,n.codigomateria,n.notadefinitiva,m.numerocreditos,ulasa,ulasb,ulasc,codigoindicadorcredito	
									FROM notahistorico n,materia m
									WHERE n.codigoestudiante = '".$codigoestudiante."'	
									AND n.codigomateria = m.codigomateria	
									and n.codigoperiodo = '$periodosemestral'            
									AND n.codigoestadonotahistorico LIKE '1%'									   
									ORDER BY n.codigoperiodo
";
//echo $query_promediosemestralperiodo,"<br>";
$res_promediosemestralperiodo = mysql_query($query_promediosemestralperiodo, $sala) or die(mysql_error());
$solicitud_promediosemestralperiodo = mysql_fetch_assoc($res_promediosemestralperiodo);	
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
		   $notatotal = $notatotal + ($solicitud_promediosemestralperiodo['notadefinitiva'] * ($solicitud_promediosemestralperiodo['ulasa'] + $solicitud_promediosemestralperiodo['ulasb'] + $solicitud_promediosemestralperiodo['ulasc'])) ;
		   $creditos = $creditos + ($solicitud_promediosemestralperiodo['ulasa'] + $solicitud_promediosemestralperiodo['ulasb'] + $solicitud_promediosemestralperiodo['ulasc']); 
		}
     }
	else
	 {
	   
		   $notatotal = $notatotal + ($solicitud_promediosemestralperiodo['notadefinitiva'] * $solicitud_promediosemestralperiodo['numerocreditos']) ;
		   $creditos = $creditos + $solicitud_promediosemestralperiodo['numerocreditos'];
			 
	 }
}while($solicitud_promediosemestralperiodo = mysql_fetch_assoc($res_promediosemestralperiodo));

$promediosemestralperiodo = (number_format($notatotal/$creditos,2));   
//echo "acumuladosperiodo ->&nbsp;".$promediosemestralperiodo."<br>";
}
?>