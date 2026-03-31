
<?php
include('../templates/templateObservatorio.php');
$db =writeHeader("",true);
//include_once ('funciones_datos.php');
  //$db=writeHeaderBD();



require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);


$codigoestudiante = $_GET["codigoestudiante"];
$riesgo = $_GET["posiblesRiesgos"];
$seguimientoPae = $_GET["seguimientoPae"];

$codigoperiodo = $_GET["codigoperiodo"];

$longitud = strlen($codigoperiodo);
$palabras = array();
for($i = 0; $i < $longitud; $i++){
$palabras[$i] = $codigoperiodo{$i};
}
// Las letras estan en $letras[aqui el numero]

?>

<div id="container" style="margin-left: 70px; ">


  <br>
  <table class="CSSTableGenerator" border="1" width="750">
   <caption style="color:#4f4d79; font-size:17px; font-family:'Arial Black', Gadget, sans-serif">Reporte Detallado Alertas Tempranas <br> Entrevista de Admision <br> <?php echo $palabras[0];
  echo  $palabras[1];
  echo  $palabras[2];
 echo   $palabras[3];
  echo  " - ";
  echo  $palabras[4];
   ?></caption>
   
   
   <?php

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


//echo $query_carrera;
   $data_in= $db->Execute($query_persona);

   foreach($data_in as $solicitud){    

    $nombre = $solicitud["nombresestudiantegeneral"];
    $apellido = $solicitud["apellidosestudiantegeneral"];
    $tipodocumento = $solicitud["tipodocumento"];
    $numerodocumento = $solicitud['numerodocumento'];	
    $nombrecarrera = $solicitud["nombrecarrera"];		 
    $telefono = $solicitud["telefonoresidenciaestudiantegeneral"];
    $correo = $solicitud["emailestudiantegeneral"];

  }
  ?>

  <a style="float:right ; padding-bottom:inherit" href="excelReporte2.php?codigoestudiante=<?php echo $codigoestudiante ?>&posiblesRiesgos=<?php echo $riesgo ?>&seguimientoPae=<?php echo $seguimientoPae ?>&codigoperiodo=<?php echo $codigoperiodo ?>" class="submit" tabindex="4" >   Excel   </a>
  
  <a style="float:right ; padding-bottom:inherit"  href="pdfReporte2.php?codigoestudiante=<?php echo $codigoestudiante ?>&posiblesRiesgos=<?php echo $riesgo ?>&seguimientoPae=<?php echo $seguimientoPae ?>&codigoperiodo=<?php echo $codigoperiodo ?>" class="submit" tabindex="4" >   Pdf</a>
  
 

  <tr>
   <th colspan="8" style="color:#19aae9">Datos Personales</th>
 </tr>
 <tr>
  <td width="104" style="font-weight:bold">Nombre Completo:  </td>
  <td colspan="3"><?php echo $nombre." ".$apellido?></td>
  <td width="74" style="font-weight:bold">Documento de Identidad: </td>
  <td colspan="6"><?php echo $tipodocumento." ".$numerodocumento?> </td>
</tr>
<tr>
 <td style="font-weight:bold">Programa Academico: </td>
 <td width="49"><?php echo $nombrecarrera?></td>
 <td width="74" style="font-weight:bold">Jornada: </td>
 <td width="40"><?php echo "Diurna"?></td>
 <td style="font-weight:bold">Email: </td>
 <td width="21"><?php echo $correo?></td>
 <td style="font-weight:bold" width="143">Telefono: </td>
 <td width="26"><?php echo $telefono?></td>
</tr>
</table>
<br>
<?php

if ($riesgo ==1){
  ?>
  <table class="CSSTableGenerator" border="1" width="750">
    
    <caption style="color:#19aae9">A continuacion se encuentran enlistados los riesgos identificados en el proceso de admision y/o la remision a PAE.</caption>
    <br>
    <tr>
      <th colspan="5" style="color:#19aae9">Posibles Riesgos</th>
    </tr>
    <tr align="center">
      <th>Posible Riesgo </th>
      <th>Pregunta</th>
      <th>Nivel</th>
      <th>Puntaje</th>
      <th>Observaciones</th>
    </tr>
    <?php
  //////////////////////////////  ACADEMICO  ///////////////////////////////////////
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
    $academico =0;
    foreach($data_in as $solicitud){    

      $pregunta = $solicitud["pregunta"];
      $nivel = $solicitud["nombretiporiesgo"];
            //$puntaje = $solicitud["tipodocumento"];
      $observacion = $solicitud['descripcion'];	
      
      
      ?>
      
      <tr align="center">

        <td><?php if ($academico==0){ echo 'Académico';}else {echo '';}?></td>
        <td><?php echo $pregunta?></td>
        <td><?php echo $nivel?></td>
        <td>-</td>
        <td><?php echo $observacion?></td>
      </tr>
      <?php
     // $academico =+1;
    } 
    ?>
    
    <?php
    
	     //////////////////////////////  ACADEMICO 2  ///////////////////////////////////////
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
  
  
  ?>
  <tr align="center">
    <td><?php if ($academico==0){ echo 'Académico';}else {echo '';}?></td>
    <td><?php echo $pregunta2?></td>
    <td>-</td>
    <td><?php echo $puntaje2?></td>
    <td><?php echo $observacion2?></td>
  </tr>
  
  <?php
 // $academico =+1;
}  
?>
<?php

	  //////////////////////////////  FINANCIERO 1  ///////////////////////////////////////
$query_Financiero1 = "SELECT idobs_admitidos_entrevista_conte,  codigoestudiante,  idobs_admitidos_contextoP,
(SELECT  nombre FROM obs_admitidos_contexto where idobs_admitidos_contexto= idobs_admitidos_contextoP) as pregunta, 
nombretiporiesgo,obs_admitidos_entrevista_conte.idobs_tiporiesgo, descripcion 
FROM  obs_admitidos_entrevista_conte 
inner join obs_admitidos_contexto
on obs_admitidos_entrevista_conte.idobs_admitidos_contexto =obs_admitidos_contexto.idobs_admitidos_contexto
inner join obs_tiporiesgo
on obs_admitidos_contexto.idobs_tiporiesgo = obs_tiporiesgo.idobs_tiporiesgo
where (obs_admitidos_entrevista_conte.idobs_tiporiesgo = 1 or obs_admitidos_entrevista_conte.idobs_tiporiesgo=2) 
and (idobs_admitidos_contextoP=7 or idobs_admitidos_contextoP=14)
and (codigoestudiante =$codigoestudiante);";

$data_in= $db->Execute($query_Financiero1);
$financiero =0;
foreach($data_in as $solicitud){    

  $pregunta3 = $solicitud["pregunta"];
  $nivel3 = $solicitud["nombretiporiesgo"];
//            $puntaje3 = $solicitud["tipodocumento"];
  $observacion3 = $solicitud['descripcion'];	
  
  
  ?>
  <tr align="center">
    <td><?php if ($financiero==0){ echo 'Económico';}else {echo '';}?></td>
    <td><?php echo $pregunta3?></td>
    <td><?php echo $nivel3?></td>
    <td>-</td>
    <td><?php echo $observacion3?></td>
  </tr>
  <?php
 // $financiero=+1;
}
?>
<?php

		 //////////////////////////////  FINANCIERO 2  ///////////////////////////////////////
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
  
  
  ?>
  <tr align="center">
    <td><?php if ($financiero==0){ echo 'Económico';}else {echo '';}?></td>
    <td><?php echo $pregunta4?></td>
    <td>-</td>
    <td><?php echo $puntaje4?></td>
    <td><?php echo $observacion4?></td>
  </tr>
  <?php
 // $financiero=+1;
}
?>

<?php

	  //////////////////////////////  PSICOSOCIAL  ///////////////////////////////////////
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
  
  
  ?>
  <tr align="center">
    <td><?php if ($psicosocial==0){ echo 'Psicosocial';}else {echo '';}?></td>
    <td><?php echo $pregunta5?></td>
    <td><?php echo $nivel5?></td>
    <td>-</td>
    <td><?php echo $observacion5?></td>
  </tr>
  <?php
 // $psicosocial=+1;
}
?>

</table>
<?php
}//foreach
if ($seguimientoPae ==1){
  ?>
  <br>


  <table width="750" class="CSSTableGenerator" border="1">
    <tr>
      <th colspan="2" style="color:#19aae9">Seguimiento PAE</th>
    </tr>
    <tr>
      <?php
      $queri_PAE="SELECT recomienda_seguimiento 
      FROM obs_admitidos_cab_entrevista where seguimiento = 1
      and  codigoestudiante =$codigoestudiante";
      $data_in= $db->Execute($queri_PAE);
      ?>
      <th width="89" height="43">Justificacion: </th>
      <?php
      foreach($data_in as $dt){  
       $pae = $dt["recomienda_seguimiento"];
     }
     ?> 
     <td width="589"> <?php echo $pae ?></td>
   </tr>
 </table>
 <br>
 <br>
</div>



<?php   
}
mysql_close($sala);	

?>  

