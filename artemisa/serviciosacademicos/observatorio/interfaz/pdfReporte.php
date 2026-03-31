

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


 echo $codigoperiodo=$_REQUEST['periodo'];//

    echo $modalidad=$_REQUEST['modalidad'];//
  
    echo $facultad=$_REQUEST['facultad'];//
  
    echo $nestudiante=$_REQUEST['nestudiante'];//
  
     echo $carrera=$_REQUEST['carrera'];//
  
     $tipo=$_REQUEST['tipo'];//
    $tipo2=$_REQUEST['tipo2'];//
    $vtipo=$_REQUEST['vtipo'];//vacio
    $Utipo=$_REQUEST['Utipo'];//vacio

    $wc=''; $wp=''; $wm=''; $wi='';



    if(!empty($carrera)){
     $wc=" AND e.codigocarrera='".$carrera."' ";
   }

   if(!empty($codigoperiodo)){
     $wp="and ee.codigoperiodo = '".$codigoperiodo."' ";
   }

   if(!empty($modalidad)){
     $wm=" AND c.codigomodalidadacademicasic='".$modalidad."' ";
   }

   if(!empty($nestudiante)){
     $wi=" and  eg.numerodocumento='".$nestudiante."' ";
   }

	
$codigoHTML.='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body>';


$interrogacion = "¿";


$codigoHTML.='
 <table width="550" height="53" class="CSSTableGenerator" id="tabladocs2" border="1" style="font-size:10px">
 <tr>
 <th style="font-weight:bold" colspan="9" style="font-size:13px">                                  Reporte Alertas Tempranas </th>
 </tr>
 <br>
    <tr>

      <th style="font-weight:bold">Tipo Identificacion </th>
      <th style="font-weight:bold">Numero Identificacion </th>
      <th style="font-weight:bold">Nombre</th>
      <th style="font-weight:bold">Apellido</th>
      <th style="font-weight:bold">Programa</th>
      <th style="font-weight:bold">Facultad</th>
      <th style="font-weight:bold">Puntaje (Max. 30)</th>
      <th style="font-weight:bold"> '.utf8_decode($interrogacion).'Solicitud seguimiento PAE?</th>
      <th style="font-weight:bold">Posibles Riesgos</th>
     
    </tr>';
 $query_datos = "SELECT ee.codigoestudiante, ee.codigoperiodo, e.codigocarrera,  eg.idestudiantegeneral,
   eg.nombresestudiantegeneral,  eg.apellidosestudiantegeneral,
   (SELECT nombredocumento FROM documento where documento.tipodocumento=eg.tipodocumento) as tipodocumento,
   eg.numerodocumento, c.nombrecarrera, m.nombremodalidadacademica, 
   fa.nombrefacultad, ee.puntaje, ee.seguimiento
   FROM obs_admitidos_cab_entrevista ee
   INNER JOIN estudiante e ON e.codigoestudiante=ee.codigoestudiante
   INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral=eg.idestudiantegeneral 
   INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
   INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad) 
   INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
   where ee.codigoestado like '1%'
   ".$wc." ".$wp." ".$wm." ".$wi." ";


  
   $data_in= $db->Execute($query_datos);
    foreach($data_in as $dt){    
      



      

      $codigoEstudiante = $dt['codigoestudiante'];
      $seguimiento = $dt['seguimiento'];
      $queri_PAE="SELECT idobs_tiporiesgo FROM  obs_admitidos_entrevista_conte where (idobs_tiporiesgo = 1 or idobs_tiporiesgo=2) 
      and (idobs_admitidos_contextoP=3 or idobs_admitidos_contextoP=5 or idobs_admitidos_contextoP=6)
      and (codigoestudiante = $codigoEstudiante)";
      $data_in= $db->Execute($queri_PAE); 
      foreach($data_in as $solicitud){    
        $nivel = $solicitud["idobs_tiporiesgo"];
      }
      $queri_PAE2="SELECT  puntaje FROM obs_admitidos_entrevista  where(puntaje = 0 or puntaje = 1) 
      and (idobs_admitidos_campos_evaluar = 2 or idobs_admitidos_campos_evaluar = 6 or idobs_admitidos_campos_evaluar = 10)
      and (codigoestudiante= = $codigoEstudiante)";
      $data_in= $db->Execute($queri_PAE2); 
      foreach($data_in as $solicitud){    
        $nivel2 = $solicitud["puntaje"];
      }
      $queri_PAE3="SELECT idobs_tiporiesgo FROM  obs_admitidos_entrevista_conte  where (idobs_tiporiesgo = 1 or idobs_tiporiesgo=2) 
      and (idobs_admitidos_contextoP=7 or idobs_admitidos_contextoP=14) and (codigoestudiante = $codigoEstudiante)";
      $data_in= $db->Execute($queri_PAE3); 
      foreach($data_in as $solicitud){    
        $nivel3 = $solicitud["idobs_tiporiesgo"];
      }
      $queri_PAE4="SELECT puntaje FROM salaoees.obs_admitidos_entrevista where (puntaje = 0 or puntaje = 1) 
      and (obs_admitidos_entrevista.idobs_admitidos_campos_evaluar = 5) and (codigoestudiante = $codigoEstudiante)";
      $data_in= $db->Execute($queri_PAE4); 
      foreach($data_in as $solicitud){    
        $nivel4 = $solicitud["puntaje"];
      }
      $queri_PAE5="SELECT idobs_tiporiesgo FROM  obs_admitidos_entrevista_conte where (idobs_tiporiesgo = 1 or idobs_tiporiesgo=2) 
      and (idobs_admitidos_contextoP=1 or idobs_admitidos_contextoP=2 or idobs_admitidos_contextoP=4)
      and (codigoestudiante = $codigoEstudiante)";
      $data_in= $db->Execute($queri_PAE5); 
      foreach($data_in as $solicitud){    
        $nivel5 = $solicitud["idobs_tiporiesgo"];
      }
      if( !empty($nivel) || !empty($nivel2)  || !empty($nive3) || !empty($nivel4) || !empty($nive5)|| $seguimiento == 1){     
        
     
       
       $codigoHTML.='
        <tr>
          <td>'.utf8_decode($dt['tipodocumento']).'</td>
          <td>'.$dt['numerodocumento'].'</td>
          <td>'.utf8_decode($dt['nombresestudiantegeneral']).'</td>
          <td>'.utf8_decode($dt['apellidosestudiantegeneral']).'</td>
          <td>'.utf8_decode($dt['nombrecarrera']).'</td>
          <td>'.$dt['nombrefacultad'].' </td>
		  <td>'.$dt['puntaje'].'</td>
          <td>	';	 
		  if ($dt['seguimiento']==1){ 
		  $codigoHTML.='
		  Si';
		  } else { 
		  $codigoHTML.='
		  No';
		  }
		  $codigoHTML.='
		  </td>
          <td>';
		  if ( (!empty($nivel) || !empty($nivel2) ) && (!empty($nive3) || !empty($nivel4)) && (!empty($nive5)) ){ $codigoHTML.= 'Acad&eacute;mico  Financiero - Psicosocial';}
          else if ((!empty($nivel3) || !empty($nivel4)) && (!empty($nive5))){  $codigoHTML.='Financiero  Psicosocial';}	
          else  if ((!empty($nivel) || !empty($nivel2)) && (!empty($nive5))){  $codigoHTML.='Acad&eacute;mico  Psicosocial';}	
          else  if ((!empty($nivel) || !empty($nivel2)) && (!empty($nive3) || !empty($nivel4))){ $codigoHTML.='Acad&eacute;mico  Financiero';}
          else  if (!empty($nivel5)){  $codigoHTML.='Psicosocial';}
          else  if (!empty($nivel3) || !empty($nivel4)){  $codigoHTML.='Financiero';}
          else if (!empty($nivel) || !empty($nivel2) ) {  $codigoHTML.='Acad&eacute;mico';}
          
		  
		  $codigoHTML.='
          </td>
       
      </tr> ';
      
    }
  }
  	mysql_close($sala);	
 



$codigoHTML.='
</table>
</body>
</html>';
$codigoHTML=utf8_encode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("Reporte_alertas_tempranas.pdf");
?>