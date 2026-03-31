<?php

include('../templates/templateObservatorio.php');
    //include_once ('funciones_datos.php');
$db=writeHeaderBD();
    //$db=writeHeader('Observatorio',true,'');
	//$db =writeHeader("",true,"",1,'');
require_once("dompdf/dompdf_config.inc.php");
    //class AlertasRiesgo{}
require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);


$codigoestudiante = $_GET["codigoestudiante"];

$riesgo = $_GET['posiblesRiesgos'];
$seguimientoPae = $_GET["seguimientoPae"];

$codigoperiodo = $_GET["codigoperiodo"];
$longitud = strlen($codigoperiodo);
$palabras = array();
for($i = 0; $i < $longitud; $i++){
$palabras[$i] = $codigoperiodo{$i};
}


$codigoHTML='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body>';




$codigoHTML.='
<table  border="1" style="font-size:12px" width="550">

<caption style=" font-size:17px; ">Reporte Detallado Alertas Tempranas <br> Entrevista de Admision <br> '.$palabras[0].''.$palabras[1].''.$palabras[2].''.$palabras[3].' - '.$palabras[4].'</caption>';



$query_persona = "SELECT ee.codigoestudiante, ee.codigoperiodo,   
eg.nombresestudiantegeneral,  eg.apellidosestudiantegeneral, 
(SELECT nombrecortodocumento FROM documento where documento.tipodocumento=eg.tipodocumento) as tipodocumento,
eg.numerodocumento, c.nombrecarrera, eg.telefonoresidenciaestudiantegeneral, eg.emailestudiantegeneral
FROM obs_admitidos_cab_entrevista ee
INNER JOIN estudiante e ON e.codigoestudiante=ee.codigoestudiante
INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral=eg.idestudiantegeneral 
INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad) 
INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
where ee.codigoestado like '1%' and  ee.codigoestudiante=$codigoestudiante;";


$data_in= $db->Execute($query_persona);

foreach($data_in as $solicitud){    





$codigoHTML.='
<tr>
<th colspan="8">Datos Personales</th>
</tr>
<tr>
<td style="font-weight:bold">Nombre Completo:  </td>
<td colspan="3">'.utf8_decode($solicitud["nombresestudiantegeneral"])." ".utf8_decode($solicitud["apellidosestudiantegeneral"]).'</td>
<td style="font-weight:bold">Documento de Identidad: </td>
<td colspan="3">'.$solicitud["tipodocumento"]." ".$solicitud['numerodocumento'].' </td>
</tr>
<tr>
<td style="font-weight:bold">Programa Academico: </td>
<td>'.utf8_decode($solicitud["nombrecarrera"]).'</td>
<td style="font-weight:bold">Jornada: </td>
<td>Diurna</td>
<td style="font-weight:bold">Email: </td>
<td>'.$solicitud["emailestudiantegeneral"].'</td>
<td style="font-weight:bold">Telefono: </td>
<td width="7">'.$solicitud["telefonoresidenciaestudiantegeneral"].'</td>
</tr>
</table>
<br>'; 

}

if ($riesgo ==1){
  $codigoHTML.='
  <table  border="1" style="font-size:12px" width="550" >
  
  <caption>A continuacion se encuentran enlistados los riesgos identificados en el proceso de admision y/o la remision a PAE.</caption>
  
  <tr>
  <th colspan="5">Posibles Riesgos</th>
  </tr>
  <tr>
  <th>Posible Riesgo </th>
  <th>Pregunta</th>
  <th>Nivel</th>
  <th>Puntaje</th>
  <th>Observaciones</th>
  </tr>';
  $query_academico1 = "SELECT idobs_admitidos_entrevista_conte,  codigoestudiante,  idobs_admitidos_contextoP ,
  (SELECT  nombre FROM obs_admitidos_contexto where idobs_admitidos_contexto= idobs_admitidos_contextoP) as pregunta, 
  nombretiporiesgo,obs_admitidos_entrevista_conte.idobs_tiporiesgo, descripcion 
  FROM  obs_admitidos_entrevista_conte 
  inner join obs_admitidos_contexto
  on obs_admitidos_entrevista_conte.idobs_admitidos_contexto =obs_admitidos_contexto.idobs_admitidos_contexto
  inner join obs_tiporiesgo
  on obs_admitidos_contexto.idobs_tiporiesgo = obs_tiporiesgo.idobs_tiporiesgo
  where (obs_admitidos_entrevista_conte.idobs_tiporiesgo = 1 or obs_admitidos_entrevista_conte.idobs_tiporiesgo=2) 
  and (idobs_admitidos_contextoP=3 or idobs_admitidos_contextoP=5 or idobs_admitidos_contextoP=6)
  and (codigoestudiante =$codigoestudiante);";



  $data_in= $db->Execute($query_academico1);
 
  foreach($data_in as $solicitud){    
$academico =0;
  
    
    $codigoHTML.='
    <tr>

    <td>'; if ($academico==0){ $codigoHTML.='Acad&eacute;mico'; }else { $codigoHTML.=' ';} $codigoHTML.='</td>
    <td>'.utf8_decode($solicitud["pregunta"]).'</td>
    <td>'.$solicitud["nombretiporiesgo"].'</td>
    <td>-</td>
    <td>'.utf8_decode($solicitud['descripcion']).'</td>
    </tr>';
    //$academico =+1;
  }
  $query_academico2 = "SELECT obs_admitidos_entrevista.idobs_admitidos_entrevista , nombre, obs_admitidos_entrevista.idobs_admitidos_campos_evaluar, 
  codigoestudiante, puntaje ,  descripcion
  FROM salaoees.obs_admitidos_entrevista inner join obs_admitidos_campos_evaluar 
  on  obs_admitidos_entrevista.idobs_admitidos_campos_evaluar = obs_admitidos_campos_evaluar.idobs_admitidos_campos_evaluar 
  where(puntaje = 0 or puntaje = 1) 
  and (obs_admitidos_entrevista.idobs_admitidos_campos_evaluar = 2 
    or obs_admitidos_entrevista.idobs_admitidos_campos_evaluar = 6 
    or obs_admitidos_entrevista.idobs_admitidos_campos_evaluar = 10)
and (codigoestudiante =$codigoestudiante);";

$data_in= $db->Execute($query_academico2);

foreach($data_in as $solicitud){    

  $pregunta2 = $solicitud["nombre"];
			//$nivel2 = $solicitud["apellidosestudiantegeneral"];
  $puntaje2 = $solicitud["puntaje"];
  $observacion2 = $solicitud['descripcion'];	
  
  
  $codigoHTML.='
  <tr>
  <td>'; if ($academico==0){ $codigoHTML.='Acad&eacute;mico'; }else {$codigoHTML.=' ';}$codigoHTML.='</td>
  <td>'.utf8_decode($pregunta2).'</td>
  <td>-</td>
  <td>'.$puntaje2.'</td>
  <td>'.utf8_decode($observacion2).'</td>
  </tr>';
 // $academico =+1;
}
$query_Financiero1 = "SELECT idobs_admitidos_entrevista_conte,  codigoestudiante,  idobs_admitidos_contextoP ,
(SELECT  nombre FROM obs_admitidos_contexto where idobs_admitidos_contexto= idobs_admitidos_contextoP) as pregunta, 
nombretiporiesgo,obs_admitidos_entrevista_conte.idobs_tiporiesgo, descripcion 
FROM  obs_admitidos_entrevista_conte 
inner join obs_admitidos_contexto
on obs_admitidos_entrevista_conte.idobs_admitidos_contexto =obs_admitidos_contexto.idobs_admitidos_contexto
inner join obs_tiporiesgo
on obs_admitidos_contexto.idobs_tiporiesgo = obs_tiporiesgo.idobs_tiporiesgo
where (obs_admitidos_entrevista_conte.idobs_tiporiesgo = 1 or obs_admitidos_entrevista_conte.idobs_tiporiesgo=2) 
and (idobs_admitidos_contextoP=7 or idobs_admitidos_contextoP=14)
and (codigoestudiante =$codigoestudiante);

";
$data_in= $db->Execute($query_Financiero1);

foreach($data_in as $solicitud){    
$financiero =0;
  $pregunta3 = $solicitud["pregunta"];
  $nivel3 = $solicitud["nombretiporiesgo"];
//            $puntaje3 = $solicitud["tipodocumento"];
  $observacion3 = $solicitud['descripcion'];	
  
  
  $codigoHTML.= '
  
  <tr>
  <td>';if ($financiero==0){ $codigoHTML.= 'Financiero';}else {$codigoHTML.= '-';}$codigoHTML.= '</td>
  <td>'.utf8_decode($pregunta3).'</td>
  <td>'.$nivel3.'</td>
  <td>-</td>
  <td>'.utf8_decode($observacion3).'</td>
  </tr>';
 // $financiero=+1;
}
$query_Financiero2 = "SELECT obs_admitidos_entrevista.idobs_admitidos_entrevista , nombre, obs_admitidos_entrevista.idobs_admitidos_campos_evaluar, 
codigoestudiante, puntaje ,  descripcion
FROM salaoees.obs_admitidos_entrevista inner join obs_admitidos_campos_evaluar 
on  obs_admitidos_entrevista.idobs_admitidos_campos_evaluar = obs_admitidos_campos_evaluar.idobs_admitidos_campos_evaluar 
where (puntaje = 0 or puntaje = 1) 
and (obs_admitidos_entrevista.idobs_admitidos_campos_evaluar = 5)
and (codigoestudiante=$codigoestudiante);";


//echo $query_carrera;
$data_in= $db->Execute($query_Financiero2);

foreach($data_in as $solicitud){    

  $pregunta4 = $solicitud["nombre"];
			//$nivel4 = $solicitud["apellidosestudiantegeneral"];
  $puntaje4 = $solicitud["puntaje"];
  $observacion4 = $solicitud['descripcion'];	
  
  
  $codigoHTML.='
  
  <tr>
  <td>';if ($financiero==0){ $codigoHTML.= 'Financiero';}else {$codigoHTML.= '-';}$codigoHTML.= '</td>
  <td>'.utf8_decode($pregunta4).'</td>
  <td>-</td>
  <td>'.$puntaje4.'</td>
  <td>'.utf8_decode($observacion4).'</td>
  </tr> ';
 // $financiero=+1;
}

$query_psicosocial = "SELECT idobs_admitidos_entrevista_conte,  codigoestudiante,  idobs_admitidos_contextoP ,
(SELECT  nombre FROM obs_admitidos_contexto where idobs_admitidos_contexto= idobs_admitidos_contextoP) as pregunta, 
nombretiporiesgo,obs_admitidos_entrevista_conte.idobs_tiporiesgo, descripcion 
FROM  obs_admitidos_entrevista_conte 
inner join obs_admitidos_contexto
on obs_admitidos_entrevista_conte.idobs_admitidos_contexto =obs_admitidos_contexto.idobs_admitidos_contexto
inner join obs_tiporiesgo
on obs_admitidos_contexto.idobs_tiporiesgo = obs_tiporiesgo.idobs_tiporiesgo

where (obs_admitidos_entrevista_conte.idobs_tiporiesgo = 1 or obs_admitidos_entrevista_conte.idobs_tiporiesgo=2) 
and (idobs_admitidos_contextoP=1 or idobs_admitidos_contextoP=2 or idobs_admitidos_contextoP=4)
and (codigoestudiante =$codigoestudiante);";

$data_in= $db->Execute($query_psicosocial);
$psicosocial=0;
foreach($data_in as $solicitud){    
  $pregunta5 = $solicitud["pregunta"];
  $nivel5 = $solicitud["nombretiporiesgo"];
            //$puntaje5 = $solicitud["tipodocumento"];
  $observacion5 = $solicitud['descripcion'];	
  
  
  $codigoHTML.='
  <tr>
  <td>';
  if ($psicosocial==0){ $codigoHTML.= 'Psicosocial';}else { $codigoHTML.= '';} $codigoHTML.= '</td>
  <td>'.utf8_decode($pregunta5).'</td>
  <td>'.$nivel5.'</td>
  <td>-</td>
  <td>'.utf8_decode($observacion5).'</td>
  </tr>';
 // $psicosocial=+1;
}
$codigoHTML.='
</table>';


}  




if ($seguimientoPae ==1){
	$interrogacion = "¿";
  
  $codigoHTML.='
    <br>
  <table  border="1" style="font-size:12px" width="550">
  <tr>
  <th colspan="2">'.utf8_decode($interrogacion).'Seguimiento PAE?</th>
  </tr>
  <tr>';
  $queri_PAE="SELECT recomienda_seguimiento 
  FROM obs_admitidos_cab_entrevista where seguimiento = 1
  and  codigoestudiante =$codigoestudiante;";
  $data_in= $db->Execute($queri_PAE);
  
  $codigoHTML.='
  
  <td height="50" style="font-weight:bold" >Justificacion: </td>';
  
  foreach($data_in as $dt){  
   $pae = $dt["recomienda_seguimiento"];
 }
 $codigoHTML.='
 <td>'.utf8_decode($pae).'</td>
 </tr>
 </table>
 <br>
 <br>
  ';
}
mysql_close($sala);	



$codigoHTML.='

</body>
</html>';
$codigoHTML=utf8_encode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("Reporte_Detallado_Riesgo.pdf");
?>