<?php

 include('../templates/templateObservatorio.php');
    //include_once ('funciones_datos.php');
	include("funciones.php");
include("../class/toolsFormClass.php");
$fun = new Observatorio();
$tipo=$_REQUEST['tipo'];
     //  $db=writeHeaderBD();
    $db=writeHeader('Observatorio',true,'');


require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);



     $codigoperiodo=$_REQUEST['periodo'];//

     $modalidad=$_REQUEST['modalidad'];//
	
     $facultad=$_REQUEST['facultad'];//
	
     $nestudiante=$_REQUEST['nestudiante'];//
	
      $carrera=$_REQUEST['carrera'];//
	
     $tipo=$_REQUEST['tipo'];//
    $tipo2=$_REQUEST['tipo2'];//
    $vtipo=$_REQUEST['vtipo'];//vacio
    $Utipo=$_REQUEST['Utipo'];//vacio





    $wc=''; $wp=''; $wm=''; $wi='';
    /*foreach($data_in as $dt){    
    }*/
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


   $query_datos ="SELECT ee.codigoestudiante, ee.codigoperiodo, e.codigocarrera,  eg.idestudiantegeneral,
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


    //echo $query_carrera;
   $data_in= $db->Execute($query_datos);
//   $data_in = mysql_query($query_datos, $sala);
   


   ?>

  
    <!--button id="btnExcel" name="btnExcel">Excel</button-->
   <a style="float:right ; padding-bottom:inherit" href="excelReporte.php?carrera=<?php echo $carrera ?>&periodo=<?php echo $codigoperiodo ?>&modalidad=<?php echo $modalidad ?>" class="submit" tabindex="4">Excel</a>
  
   <a style="float:right ; padding-bottom:inherit" href="pdfReporte.php?carrera=<?php echo $carrera ?>&periodo=<?php echo $codigoperiodo ?>&modalidad=<?php echo $modalidad ?>" class="submit" tabindex="4">Pdf</a>
   
   <br> <br>

    <script>
                 $(document).ready( function () {
                                            var oTable = $('#customers').dataTable( {
                                                    "sDom": '<"H"Cfrltip>',
                                                    "bJQueryUI": false,
                                                    "bProcessing": true,
                                                    "bScrollCollapse": true,
                                                    "bPaginate": true,
                                                    "sPaginationType": "full_numbers", 
                                                    "oColReorder": {
                                                            "iFixedColumns": 1
                                                    },
                                                    "oColVis": {
                                                            "buttonText": "Ver/Ocultar Columns",
                                                             "aiExclude": [ 0 ]
                                                      }

                                            } );
                                             var oTableTools = new TableTools( oTable, {
					"buttons": [
						"copy",
						"csv",
						"xls",
						"pdf",
						{ "type": "print", "buttonText": "Print me!" }
					]
		         });
                         
                         $('#demo').before( oTableTools.dom.container );

            //<
 
                });


            </script>
  <table  cellpadding="0" cellspacing="0" border="1" class="display" id='customers' style=" font-size: 10px;  " width="1000">
       <thead style=" background: #eff0f0; text-align: center">

      <th>Tipo de documento </th>
      <th>Número de documento </th>
      <th>Nombre</th>
      <th>Apellido</th>
      <th>Programa</th>
      <th>Facultad</th>
      <th>Puntaje (Max. 30)</th>
      <th>¿Solicitud seguimiento PAE?</th>
      <th>Posibles Riesgos</th>
      <th>Detalle</th>
    </thead>
      <tbody>
    <?php
   foreach($data_in as $dt){  





    $codigoEstudiante = $dt['codigoestudiante'];
    $seguimiento = $dt['seguimiento'];
    $queri_PAE="SELECT count(idobs_tiporiesgo) as riesgo FROM  obs_admitidos_entrevista_conte where (idobs_tiporiesgo = 1 or idobs_tiporiesgo=2) 
    and (idobs_admitidos_contextoP=3 or idobs_admitidos_contextoP=5 or idobs_admitidos_contextoP=6)
    and (codigoestudiante = $codigoEstudiante)";

    $data_in2 = $db->Execute($queri_PAE); 
     foreach($data_in2 as $solicitud){ 
      $nivel = $solicitud['riesgo'];
    }



    $queri_PAE2="SELECT  count(puntaje) as riesgo1 FROM obs_admitidos_entrevista  where(puntaje = 0 or puntaje = 1) 
    and (idobs_admitidos_campos_evaluar = 2 or idobs_admitidos_campos_evaluar = 6 or idobs_admitidos_campos_evaluar = 10)
    and (codigoestudiante= $codigoEstudiante)";
    $data_in3 =  $db->Execute($queri_PAE2); 
    foreach($data_in3 as $solicitud1){ 
      $nivel2 = $solicitud1['riesgo1'];
    }


    $queri_PAE3="SELECT count(idobs_tiporiesgo) as riesgo2 FROM  obs_admitidos_entrevista_conte  where (idobs_tiporiesgo = 1 or idobs_tiporiesgo=2) 
    and (idobs_admitidos_contextoP=7 or idobs_admitidos_contextoP=14) and (codigoestudiante = $codigoEstudiante)";
    $data_in4 =  $db->Execute($queri_PAE3);  
     foreach($data_in4 as $solicitud2){ 
      $nivel3 = $solicitud2['riesgo2'];
    }
    $queri_PAE4="SELECT count(puntaje)  as riesgo3 FROM salaoees.obs_admitidos_entrevista where (puntaje = 0 or puntaje = 1) 
    and (obs_admitidos_entrevista.idobs_admitidos_campos_evaluar = 5) and (codigoestudiante = $codigoEstudiante)";
    $data_in5 = $db->Execute($queri_PAE4); 
     foreach($data_in5 as $solicitud3){  
      $nivel4 = $solicitud3['riesgo3'];
    }
    $queri_PAE5="SELECT count(idobs_tiporiesgo) as riesgo4 FROM  obs_admitidos_entrevista_conte where (idobs_tiporiesgo = 1 or idobs_tiporiesgo=2) 
    and (idobs_admitidos_contextoP=1 or idobs_admitidos_contextoP=2 or idobs_admitidos_contextoP=4)
    and (codigoestudiante = $codigoEstudiante)";
    $data_in6 =  $db->Execute($queri_PAE5);
     foreach($data_in6 as $solicitud4){ 
      $nivel5 = $solicitud4['riesgo4'];
    }

    if( ($nivel!=0) || ($nivel2!=0)  || ($nivel3!=0) || ($nivel4!=0) || ($nivel5!=0)|| $seguimiento !=0){ 
	
     if ($seguimiento!=0){ $res= 'Si';} else { $res= 'No';}
     if ( (($nivel !=0) || ($nivel2!=0) ) && (($nivel3!=0) || ($nivel4!=0)) && ($nivel5!=0) ){ $puntaj= 'Académico  Económico Psicosocial';}
      else if ((($nivel3!=0) || ($nivel4!=0)) && ($nivel5!=0)) { $puntaj= 'Económico  Psicosocial';}	
      else  if ((($nivel!=0) || ($nivel2!=0)) && ($nivel5!=0)) { $puntaj= 'Académico  Psicosocial';}	
      else  if ((($nivel!=0) || ($nivel2!=0)) && (($nivel3!=0) || ($nivel4==1))) { $puntaj= 'Académico  Económico';}
      else  if ($nivel5!=0){ $puntaj ='Psicosocial';}
      else  if (($nivel3!=0) || ($nivel4==1)){ $puntaj= 'Económico';}
      else if (($nivel!=0) || ($nivel2==1) ) { $puntaj= 'Académico';}
      else {$puntaj= '-';}
?>
     <tr>
          <td><?php echo $dt['tipodocumento'] ?></td>
          <td><?php echo $dt['numerodocumento'] ?></td>
          <td><?php echo $dt['nombresestudiantegeneral'] ?></td>
          <td><?php echo $dt['apellidosestudiantegeneral'] ?></td>
          <td><?php echo $dt['nombrecarrera'] ?></td>
          <td><?php echo $dt['nombrefacultad'] ?></td>
          <td><?php echo $dt['puntaje'] ?></td>
		  <td><?php if ($dt['seguimiento']==1){ echo 'Si';} else { echo 'No';} ?></td>
          <td><?php echo $puntaj ?>      </td>
    
 <?php
        if ( ($nivel!=0) || ($nivel2!=0)  || ($nivel3!=0) || ($nivel4!=0) || ($nivel5!=0)){ 
          $riesgos=1;
        }else {
          $riesgos=0;
        }
        ?>
        
<!--        <td> <span class="formInfo"><a href="detalles_Alerta_Temprana.php?codigoestudiante=<?php echo $dt['codigoestudiante'] ?>&posiblesRiesgos=<?php echo $riesgos?>&seguimientoPae=<?php echo $dt['seguimiento'] ?>&codigoperiodo=<?php echo $codigoperiodo?>"  id="span"  target="_blank" ><img src="../img/lupa.png" height="20" width="20"   /></a></span></td>-->

<td> <span class="formInfo"><a href="javascript:abrir('detalles_Alerta_Temprana.php?codigoestudiante=<?php echo $dt['codigoestudiante'] ?>&posiblesRiesgos=<?php echo $riesgos?>&seguimientoPae=<?php echo $dt['seguimiento'] ?>&codigoperiodo=<?php echo $codigoperiodo?>')"  id="span" ><img src="../img/lupa.png" height="20" width="20"   /></a></span></td>
      </tr> 
      <?php

    }//if

  }//while
  	//mysql_close($sala);	
mysql_close($sala);	
  ?>
    </tbody>
</table>
<script> 
function abrir(url) { 
open(url,'','top=100,left=100,width=900,height=500,status=no,directories=no,menubar=no,toolbar=no,location=no,resizable=no,titlebar=no,scrollbars=yes') ; 
} 
</script>

<!--<script>
$(document).ready(function(){

        $("#btnExcel").click(function (){
    var excel_data = $('#tabladocs2').html();
	var page = 'excel.php?data='+excel_data;
	window.location=page;
        }); 
    });
						  
</script> -->
<br>









