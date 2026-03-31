<?php
include ('Desercion_class.php');  $C_Desercion = new Desercion();

global $db;
MainJson();

$CodigoPeriodo  = $_REQUEST['CodigoPeriodo'];

$CodigoCarrera  = $_REQUEST['CodigoCarrera'];

$Periodo_Actual = $C_Desercion->Periodo('Actual','','');

$C_Periodos = $C_Desercion->Periodo('Cadena',$CodigoPeriodo,$Periodo_Actual);

//echo '<pre>';print_r($C_Periodos);

$Periodos   = array();

for($i=0;$i<count($C_Periodos);$i++){
    /**********************************************/
        $Periodos['Periodo'][]=$C_Periodos[$i]['codigoperiodo'];
    /**********************************************/
}//for

include_once('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');

//echo '<pre>';print_r($Periodos);

$C_Respuesta = array();

for($i=0;$i<count($Periodos['Periodo']);$i++){
    /****************************************************/
    $datos_estadistica      = new obtener_datos_matriculas($db,$Periodos['Periodo'][$i]);
    
    $C_MatriculadosInicio   = $datos_estadistica->obtener_total_matriculados($CodigoCarrera,'arreglo');
    
    $C_Semestre             = $C_Desercion->SemestreCarrera($C_MatriculadosInicio,$Periodos['Periodo'][$i]);
    
    
   #echo '<pre>';print_r($C_Semestre['codigoestudiante_Ocho']);   
    $C_Estrato_Cero     = $C_Desercion->EstratoEstudiantes($C_Semestre['codigoestudiante_Cero'],1);
    $C_Estrato_Uno      = $C_Desercion->EstratoEstudiantes($C_Semestre['codigoestudiante_Uno'],1);
    $C_Estrato_Dos      = $C_Desercion->EstratoEstudiantes($C_Semestre['codigoestudiante_Dos'],1);
    $C_Estrato_Tres     = $C_Desercion->EstratoEstudiantes($C_Semestre['codigoestudiante_Tres'],1);
    $C_Estrato_Cuatro   = $C_Desercion->EstratoEstudiantes($C_Semestre['codigoestudiante_Cuatro'],1);
    $C_Estrato_Cinco    = $C_Desercion->EstratoEstudiantes($C_Semestre['codigoestudiante_Cinco'],1);
    $C_Estrato_Seis     = $C_Desercion->EstratoEstudiantes($C_Semestre['codigoestudiante_Seis'],1);
    $C_Estrato_Siete    = $C_Desercion->EstratoEstudiantes($C_Semestre['codigoestudiante_Siete'],1);
    $C_Estrato_Ocho     = $C_Desercion->EstratoEstudiantes($C_Semestre['codigoestudiante_Ocho'],1);
    $C_Estrato_Nueve    = $C_Desercion->EstratoEstudiantes($C_Semestre['codigoestudiante_Nueve'],1);
    $C_Estrato_Diez     = $C_Desercion->EstratoEstudiantes($C_Semestre['codigoestudiante_Diez'],1);
    $C_Estrato_Once     = $C_Desercion->EstratoEstudiantes($C_Semestre['codigoestudiante_Once'],1);
    $C_Estrato_Doce     = $C_Desercion->EstratoEstudiantes($C_Semestre['codigoestudiante_Doce'],1);
    
    /****************************************************/
    
    /****************************************************/
    $C_Respuesta[$Periodos['Periodo'][$i]]          =$C_Semestre;
    $C_Respuesta[$Periodos['Periodo'][$i]]['Cero']  =$C_Estrato_Cero;
    $C_Respuesta[$Periodos['Periodo'][$i]]['Uno']   =$C_Estrato_Uno;
    $C_Respuesta[$Periodos['Periodo'][$i]]['Dos']   =$C_Estrato_Dos;
    $C_Respuesta[$Periodos['Periodo'][$i]]['Cuatro']=$C_Estrato_Cuatro;
    $C_Respuesta[$Periodos['Periodo'][$i]]['Cinco'] =$C_Estrato_Cinco;
    $C_Respuesta[$Periodos['Periodo'][$i]]['Seis']  =$C_Estrato_Seis;
    $C_Respuesta[$Periodos['Periodo'][$i]]['Siete'] =$C_Estrato_Siete;
    $C_Respuesta[$Periodos['Periodo'][$i]]['Ocho']  =$C_Estrato_Ocho;
    $C_Respuesta[$Periodos['Periodo'][$i]]['Nueve'] =$C_Estrato_Nueve;
    $C_Respuesta[$Periodos['Periodo'][$i]]['Diez']  =$C_Estrato_Diez;
    $C_Respuesta[$Periodos['Periodo'][$i]]['Once']  =$C_Estrato_Once;
    $C_Respuesta[$Periodos['Periodo'][$i]]['Doce']  =$C_Estrato_Doce;
    $C_Respuesta[$Periodos['Periodo'][$i]]['Total'] =count($C_MatriculadosInicio);
    
    
    
    /****************************************************/
}//for


$C_Estrato = $C_Desercion->Estrato();

          
$C_Promedio = PromedioSemestre($C_Respuesta,$Periodos['Periodo']);


if($_REQUEST['VerEstudiantes']==1){
   VerEstudiantes($C_Respuesta,$CodigoPeriodo,$_REQUEST['Semestre']);exit();
}
     
//echo '<pre>';print_r($C_Respuesta);  

?>
<script type="text/javascript" language="javascript" src="Desercion.js"></script> 
<style type="text/css" title="currentStyle">
                @import "../data/media/css/demo_page.css";
                @import "../data/media/css/demo_table_jui.css";
                @import "../data/media/css/ColVis.css";
                @import "../data/media/css/TableTools.css";
                @import "../data/media/css/ColReorder.css";
                @import "../data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                @import "../data/media/css/jquery.modal.css";
                
    </style>
    
    <script type="text/javascript" language="javascript" src="../data/media/js/jquery.js"></script>
    <script type="text/javascript" charset="utf-8" src="../jquery/js/jquery-3.6.0.js"></script>
    <script type="text/javascript" language="javascript" src="../data/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8" src="../data/media/js/ColVis.js"></script>
    <script type="text/javascript" charset="utf-8" src="../data/media/js/ZeroClipboard.js"></script>
    <script type="text/javascript" charset="utf-8" src="../data/media/js/TableTools.js"></script>
    <script type="text/javascript" charset="utf-8" src="../data/media/js/FixedColumns.js"></script>
    <script type="text/javascript" charset="utf-8" src="../data/media/js/ColReorder.js"></script>
    <script type="text/javascript" language="javascript">
        
        $(document).ready( function () {//"sDom": '<Cfrltip>',
				var oTable = $('#example_1').dataTable( {
				    
  					"sScrollX": "100%",
					"sScrollXInner": "100,1%",
					"bScrollCollapse": true,
                    "bPaginate": true,
                    "aLengthMenu": [[50], [50,  "All"]],
                     "iDisplayLength": 50,
                    "sPaginationType": "full_numbers",
					"oColReorder": {
						"iFixedColumns": 1
					},
                    "oColVis": {
                            "buttonText": "Ver/Ocultar Columns",
                             "aiExclude": [ 0 ]
                      }
                    
                    
					
				} );
				//new FixedColumns( oTable );
                                
                                new FixedColumns( oTable, {
                                         "iLeftColumns": 2,
                                         "iLeftWidth": 550
				} );
                                
                                 var oTableTools = new TableTools( oTable, {
					"buttons": [
						"copy",
						"csv",
						"xls",
						"pdf",
					]
		         });
                         $('#demo').before( oTableTools.dom.container );
			} ); 
        /* $(document).ready(function() {
            	$('#Ejemplo').dataTable();
            } );  */ 
    </script>
<div id="demo">    
<table cellpadding="0" cellspacing="0" border="1" class="display" id="example_1">
    <thead>
        <tr>
            <th rowspan="3" class="bl bt">N&deg;</th> 
            <th rowspan="3" class="bl bt">Semestre</th>
            <?PHP 
                    
            $C_Carrera  = $C_Desercion->Carreras($CodigoCarrera);
           
            for($i=0;$i<count($Periodos['Periodo']);$i++){
                
                    /***************************************/
                    $arrayP = str_split($Periodos['Periodo'][$i], strlen($Periodos['Periodo'][$i])-1);
                    
                    $P_Periodo=$arrayP[0]."-".$arrayP[1];
                    
                    /***************************************/

                ?>
                <th colspan="30" class="bl br bt" ><?PHP echo $P_Periodo?>  <?PHP echo $C_Carrera[0]['nombrecarrera']?></th>
                
           <?PHP
            }//for
           ?>
       </tr>
       <tr>
       <?PHP
       
        
        for($i=0;$i<count($Periodos['Periodo']);$i++){
            ?>
            <th colspan="15" class="bl br bt" >Distribuci&oacute;n por Estratos de la Poblaci&oacute;n Total</th>
            <th colspan="15" class="bl br bt" >Caracterizaci&oacute;n del Promedio Acumulado por Semestres y su relaci&oacute;n con Estratos en cada Periordo</th>
            <?PHP
            }
       ?>
            
       </tr>
       <tr>
            <?PHP 
            for($i=0;$i<count($Periodos['Periodo']);$i++){
                /***************************************/
                    $arrayP = str_split($Periodos['Periodo'][$i], strlen($Periodos['Periodo'][$i])-1);
                    
                    $P_Periodo=$arrayP[0]."-".$arrayP[1];
                    
                    /***************************************/
                ?>
                <th class="bl">Poblaci&oacute;n total<br /><?PHP echo $P_Periodo?></th>
                <?PHP
                for($E=0;$E<count($C_Estrato['Nombre']);$E++){
                    /*******************************/
                    ?>
                    <th class="br">Estrato <?PHP echo $C_Estrato['Nombre'][$E]?></th>
                    <th class="br">Estrato <?PHP echo $C_Estrato['Nombre'][$E]?> <strong>%</strong></th>
                    <?PHP
                    /*******************************/
                }//for estrato
                ?>
                <th class="bl">Promedio Acumulado (PAGS)<br /><?PHP echo $P_Periodo?></th>
                <?PHP
                for($E=0;$E<count($C_Estrato['Nombre']);$E++){
                    /*******************************/
                    ?>
                    <th class="br">Estrato <?PHP echo $C_Estrato['Nombre'][$E]?></th>
                    <th class="br">Estrato <?PHP echo $C_Estrato['Nombre'][$E]?> <strong>%</strong></th>
                    <?PHP
                    /*******************************/
                }//for estrato
            }
            ?>
        </tr>
    </thead>
    
    <body>
        <?PHP 
        $S_Estrato = array();
            for($t=0;$t<=12;$t++){
               /***********************************************************/
               ?>
               <tr>
                    <td><?PHP echo $t+1?></td>
                    <td align="center"><?PHP echo $t?></td>
                    <?PHP 
                      for($i=0;$i<count($Periodos['Periodo']);$i++){
                            if($t==0){
                               $Semestre = 'Semestre_Cero';
                               $Estrato_Seemstre = 'Cero';
                               $PAGS    = 'Total_Cero';
                               $CodigoEstudiante  = 'codigoestudiante_Cero';
                            }else if($t==1){
                               $Semestre = 'Semestre_Uno';
                               $Estrato_Seemstre = 'Uno';
                               $PAGS    = 'Total_Uno';
                               $CodigoEstudiante  = 'codigoestudiante_Uno';
                            }else if($t==2){
                               $Semestre = 'Semestre_Dos';
                               $Estrato_Seemstre = 'Dos';
                               $PAGS    = 'Total_Dos';
                               $CodigoEstudiante  = 'codigoestudiante_Dos';
                            }else if($t==3){
                               $Semestre = 'Semestre_Tres';
                               $Estrato_Seemstre = 'Tres';
                               $PAGS    = 'Total_Tres';
                               $CodigoEstudiante  = 'codigoestudiante_Tres';
                            }else if($t==4){
                               $Semestre = 'Semestre_Cuatro';
                               $Estrato_Seemstre = 'Cuatro';
                               $PAGS    = 'Total_Cuatro';
                               $CodigoEstudiante  = 'codigoestudiante_Cuatro';
                            }else if($t==5){
                               $Semestre = 'Semestre_Cinco';
                               $Estrato_Seemstre = 'Cinco';
                               $PAGS    = 'Total_Cinco';
                               $CodigoEstudiante  = 'codigoestudiante_Cinco';
                            }else if($t==6){
                               $Semestre = 'Semestre_Seis';
                               $Estrato_Seemstre = 'Seis';
                               $PAGS    = 'Total_Seis';
                               $CodigoEstudiante  = 'codigoestudiante_Seis';
                            }else if($t==7){
                               $Semestre = 'Semestre_Siete';
                               $Estrato_Seemstre = 'Siete';
                               $PAGS    = 'Total_Siete';
                               $CodigoEstudiante  = 'codigoestudiante_Siete';
                            }else if($t==8){
                               $Semestre = 'Semestre_Ocho';
                               $Estrato_Seemstre = 'Ocho';
                               $PAGS    = 'Total_Ocho';
                               $CodigoEstudiante  = 'codigoestudiante_Ocho';
                            }else if($t==9){
                               $Semestre = 'Semestre_Nueve';
                               $Estrato_Seemstre = 'Nueve';
                               $PAGS    = 'Total_Nueve';
                               $CodigoEstudiante  = 'codigoestudiante_Nueve';
                            }else if($t==10){
                               $Semestre = 'Semestre_Diez';
                               $Estrato_Seemstre = 'Diez';
                               $PAGS    = 'Total_Diez';
                               $CodigoEstudiante  = 'codigoestudiante_Diez';
                            }else if($t==11){
                               $Semestre = 'Semestre_Once';
                               $Estrato_Seemstre = 'Once';
                               $PAGS    = 'Total_Once';
                               $CodigoEstudiante  = 'codigoestudiante_Once';
                            }else if($t==12){
                               $Semestre = 'Semestre_Doce';
                               $Estrato_Seemstre = 'Doce';
                               $PAGS    = 'Total_Doce';
                               $CodigoEstudiante  = 'codigoestudiante_Doce';
                            }
                            
                            $Estrato_No     = count($C_Respuesta[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['No_Aplica']['Estrato']);
                            $Estrato_Uno    = count($C_Respuesta[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['Uno']['Estrato']);
                            $Estrato_Dos    = count($C_Respuesta[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['Dos']['Estrato']);
                            $Estrato_Tres   = count($C_Respuesta[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['Tres']['Estrato']);
                            $Estrato_Cuatro = count($C_Respuesta[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['Cuatro']['Estrato']);
                            $Estrato_Cinco  = count($C_Respuesta[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['Cinco']['Estrato']);
                            $Estrato_Seis   = count($C_Respuesta[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['Seis']['Estrato']);
                            /*****************************************************************************************************/
                            $S_Estrato[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['No_Aplica']=$Estrato_No;
                            $S_Estrato[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['Uno']=$Estrato_Uno;
                            $S_Estrato[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['Dos']=$Estrato_Dos;
                            $S_Estrato[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['Tres']=$Estrato_Tres;
                            $S_Estrato[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['Cuatro']=$Estrato_Cuatro;
                            $S_Estrato[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['Cinco']=$Estrato_Cinco;
                            $S_Estrato[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['Seis']=$Estrato_Seis;
                            /*****************************************************************************************************/
                            $E_Promedio_No = PromedioSemestreEstrato($C_Respuesta[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['No_Aplica']['CodigoEstudiante'],$Periodos['Periodo']);
                            
                            $E_Promedio_Uno = PromedioSemestreEstrato($C_Respuesta[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['Uno']['CodigoEstudiante'],$Periodos['Periodo']);
                            
                            $E_Promedio_Dos = PromedioSemestreEstrato($C_Respuesta[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['Dos']['CodigoEstudiante'],$Periodos['Periodo']);
                            
                            $E_Promedio_Tres = PromedioSemestreEstrato($C_Respuesta[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['Tres']['CodigoEstudiante'],$Periodos['Periodo']);
                            
                            $E_Promedio_Cuatro = PromedioSemestreEstrato($C_Respuesta[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['Cuatro']['CodigoEstudiante'],$Periodos['Periodo']);
                            
                            $E_Promedio_Cinco = PromedioSemestreEstrato($C_Respuesta[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['Cinco']['CodigoEstudiante'],$Periodos['Periodo']);
                            
                            $E_Promedio_Seis = PromedioSemestreEstrato($C_Respuesta[$Periodos['Periodo'][$i]][$Estrato_Seemstre]['Seis']['CodigoEstudiante'],$Periodos['Periodo']);
                            /*****************************************************************************************************/
                            
                            $Por_No     = (($Estrato_No/count($C_Respuesta[$Periodos['Periodo'][$i]][$Semestre]))*100);
                            $Por_Uno    = (($Estrato_Uno/count($C_Respuesta[$Periodos['Periodo'][$i]][$Semestre]))*100);
                            $Por_Dos    = (($Estrato_Dos/count($C_Respuesta[$Periodos['Periodo'][$i]][$Semestre]))*100);
                            $Por_Tres   = (($Estrato_Tres/count($C_Respuesta[$Periodos['Periodo'][$i]][$Semestre]))*100);
                            $Por_Cuatro = (($Estrato_Cuatro/count($C_Respuesta[$Periodos['Periodo'][$i]][$Semestre]))*100);
                            $Por_Cinco  = (($Estrato_Cinco/count($C_Respuesta[$Periodos['Periodo'][$i]][$Semestre]))*100);
                            $Por_Seis   = (($Estrato_Seis/count($C_Respuesta[$Periodos['Periodo'][$i]][$Semestre]))*100);
                            
                               ?>
                               <td align="center"><a style="cursor: pointer;" onclick="VerEstudiantes('<?PHP echo $Periodos['Periodo'][$i]?>','<?PHP echo $CodigoCarrera?>','<?PHP echo $CodigoEstudiante?>')"><?PHP echo count($C_Respuesta[$Periodos['Periodo'][$i]][$Semestre])?></a></td>
                               <td align="center"><?PHP echo $Estrato_No?></td>
                               <td align="center"><?PHP echo number_format($Por_No,'2',',','.')?>%</td>
                               <td align="center"><?PHP echo $Estrato_Uno?></td>
                               <td align="center"><?PHP echo number_format($Por_Uno,'2',',','.')?>%</td>
                               <td align="center"><?PHP echo $Estrato_Dos?></td>
                               <td align="center"><?PHP echo number_format($Por_Dos,'2',',','.')?>%</td>
                               <td align="center"><?PHP echo $Estrato_Tres?></td>
                               <td align="center"><?PHP echo number_format($Por_Tres,'2',',','.')?>%</td>
                               <td align="center"><?PHP echo $Estrato_Cuatro?></td>
                               <td align="center"><?PHP echo number_format($Por_Cuatro,'2',',','.')?>%</td>
                               <td align="center"><?PHP echo $Estrato_Cinco?></td>
                               <td align="center"><?PHP echo number_format($Por_Cinco,'2',',','.')?>%</td>
                               <td align="center"><?PHP echo $Estrato_Seis?></td>
                               <td align="center"><?PHP echo number_format($Por_Seis,'2',',','.')?>%</td>
                               <!--Nuevo-->
                               <td align="center"><?PHP echo $C_Promedio[$Periodos['Periodo'][$i]][$PAGS]?></td>
                               <td align="center"><?PHP echo $E_Promedio_No[$Periodos['Periodo'][$i]]?></td>
                               <?PHP 
                               $Por_Pags_No = (($E_Promedio_No[$Periodos['Periodo'][$i]]/$C_Promedio[$Periodos['Periodo'][$i]][$PAGS])*100);
                               ?>
                               <td align="center"><?PHP echo number_format($Por_Pags_No,'2','.','.')?>%</td>
                               <td align="center"><?PHP echo $E_Promedio_Uno[$Periodos['Periodo'][$i]]?></td>
                               <?PHP 
                               $Por_Pags_Uno = (($E_Promedio_Uno[$Periodos['Periodo'][$i]]/$C_Promedio[$Periodos['Periodo'][$i]][$PAGS])*100);
                               ?>
                               <td align="center"><?PHP echo number_format($Por_Pags_Uno,'2','.','.')?>%</td>
                               <td align="center"><?PHP echo $E_Promedio_Dos[$Periodos['Periodo'][$i]]?></td>
                               <?PHP 
                               $Por_Pags_Dos = (($E_Promedio_Dos[$Periodos['Periodo'][$i]]/$C_Promedio[$Periodos['Periodo'][$i]][$PAGS])*100);
                               ?>
                               <td align="center"><?PHP echo number_format($Por_Pags_Dos,'2','.','.')?>%</td>
                               <td align="center"><?PHP echo $E_Promedio_Tres[$Periodos['Periodo'][$i]]?></td>
                               <?PHP 
                               $Por_Pags_Tres = (($E_Promedio_Tres[$Periodos['Periodo'][$i]]/$C_Promedio[$Periodos['Periodo'][$i]][$PAGS])*100);
                               ?>
                               <td align="center"><?PHP echo number_format($Por_Pags_Tres,'2','.','.')?>%</td>
                               <td align="center"><?PHP echo $E_Promedio_Cuatro[$Periodos['Periodo'][$i]]?></td>
                               <?PHP 
                               $Por_Pags_Cuatro = (($E_Promedio_Cuatro[$Periodos['Periodo'][$i]]/$C_Promedio[$Periodos['Periodo'][$i]][$PAGS])*100);
                               ?>
                               <td align="center"><?PHP echo number_format($Por_Pags_Cuatro,'2','.','.')?>%</td>
                               <td align="center"><?PHP echo $E_Promedio_Cinco[$Periodos['Periodo'][$i]]?></td>
                               <?PHP 
                               $Por_Pags_Cinco = (($E_Promedio_Cinco[$Periodos['Periodo'][$i]]/$C_Promedio[$Periodos['Periodo'][$i]][$PAGS])*100);
                               ?>
                               <td align="center"><?PHP echo number_format($Por_Pags_Cinco,'2','.','.')?>%</td>
                               <td align="center"><?PHP echo $E_Promedio_Seis[$Periodos['Periodo'][$i]]?></td>
                               <?PHP 
                               $Por_Pags_Seis = (($E_Promedio_Seis[$Periodos['Periodo'][$i]]/$C_Promedio[$Periodos['Periodo'][$i]][$PAGS])*100);
                               ?>
                               <td align="center"><?PHP echo number_format($Por_Pags_Seis,'2','.','.')?>%</td>
                               <?PHP 
                            
                        } 
                    ?>
                    
               </tr>
               <?PHP
               /***********************************************************/ 
            }//for
        ?>
        <tr>
            <td><?PHP echo $t+1?></td>
            <td>TotalGeneral</td>
            <?PHP 
           
            for($i=0;$i<count($Periodos['Periodo']);$i++){
                $Suma_No=0;
                $Suma_No = $Suma_No+$S_Estrato[$Periodos['Periodo'][$i]]['Cero']['No_Aplica'];
                $Suma_No = $Suma_No+$S_Estrato[$Periodos['Periodo'][$i]]['Uno']['No_Aplica'];
                $Suma_No = $Suma_No+$S_Estrato[$Periodos['Periodo'][$i]]['Dos']['No_Aplica'];
                $Suma_No = $Suma_No+$S_Estrato[$Periodos['Periodo'][$i]]['Tres']['No_Aplica'];
                $Suma_No = $Suma_No+$S_Estrato[$Periodos['Periodo'][$i]]['Cuatro']['No_Aplica'];
                $Suma_No = $Suma_No+$S_Estrato[$Periodos['Periodo'][$i]]['Cinco']['No_Aplica'];
                $Suma_No = $Suma_No+$S_Estrato[$Periodos['Periodo'][$i]]['Seis']['No_Aplica'];
                $Suma_No = $Suma_No+$S_Estrato[$Periodos['Periodo'][$i]]['Siete']['No_Aplica'];
                $Suma_No = $Suma_No+$S_Estrato[$Periodos['Periodo'][$i]]['Ocho']['No_Aplica'];
                $Suma_No = $Suma_No+$S_Estrato[$Periodos['Periodo'][$i]]['Nueve']['No_Aplica'];
                $Suma_No = $Suma_No+$S_Estrato[$Periodos['Periodo'][$i]]['Diez']['No_Aplica'];
                $Suma_No = $Suma_No+$S_Estrato[$Periodos['Periodo'][$i]]['Once']['No_Aplica'];
                $Suma_No = $Suma_No+$S_Estrato[$Periodos['Periodo'][$i]]['Doce']['No_Aplica'];
                /***********************************************************************************************/
                $Suma_Uno=0;
                $Suma_Uno = $Suma_Uno+$S_Estrato[$Periodos['Periodo'][$i]]['Cero']['Uno'];
                $Suma_Uno = $Suma_Uno+$S_Estrato[$Periodos['Periodo'][$i]]['Uno']['Uno'];
                $Suma_Uno = $Suma_Uno+$S_Estrato[$Periodos['Periodo'][$i]]['Dos']['Uno'];
                $Suma_Uno = $Suma_Uno+$S_Estrato[$Periodos['Periodo'][$i]]['Tres']['Uno'];
                $Suma_Uno = $Suma_Uno+$S_Estrato[$Periodos['Periodo'][$i]]['Cuatro']['Uno'];
                $Suma_Uno = $Suma_Uno+$S_Estrato[$Periodos['Periodo'][$i]]['Cinco']['Uno'];
                $Suma_Uno = $Suma_Uno+$S_Estrato[$Periodos['Periodo'][$i]]['Seis']['Uno'];
                $Suma_Uno = $Suma_Uno+$S_Estrato[$Periodos['Periodo'][$i]]['Siete']['Uno'];
                $Suma_Uno = $Suma_Uno+$S_Estrato[$Periodos['Periodo'][$i]]['Ocho']['Uno'];
                $Suma_Uno = $Suma_Uno+$S_Estrato[$Periodos['Periodo'][$i]]['Nueve']['Uno'];
                $Suma_Uno = $Suma_Uno+$S_Estrato[$Periodos['Periodo'][$i]]['Diez']['Uno'];
                $Suma_Uno = $Suma_Uno+$S_Estrato[$Periodos['Periodo'][$i]]['Once']['Uno'];
                $Suma_Uno = $Suma_Uno+$S_Estrato[$Periodos['Periodo'][$i]]['Doce']['Uno'];
                /***********************************************************************************************/
                $Suma_Dos=0;
                $Suma_Dos = $Suma_Dos+$S_Estrato[$Periodos['Periodo'][$i]]['Cero']['Dos'];
                $Suma_Dos = $Suma_Dos+$S_Estrato[$Periodos['Periodo'][$i]]['Uno']['Dos'];
                $Suma_Dos = $Suma_Dos+$S_Estrato[$Periodos['Periodo'][$i]]['Dos']['Dos'];
                $Suma_Dos = $Suma_Dos+$S_Estrato[$Periodos['Periodo'][$i]]['Tres']['Dos'];
                $Suma_Dos = $Suma_Dos+$S_Estrato[$Periodos['Periodo'][$i]]['Cuatro']['Dos'];
                $Suma_Dos = $Suma_Dos+$S_Estrato[$Periodos['Periodo'][$i]]['Cinco']['Dos'];
                $Suma_Dos = $Suma_Dos+$S_Estrato[$Periodos['Periodo'][$i]]['Seis']['Dos'];
                $Suma_Dos = $Suma_Dos+$S_Estrato[$Periodos['Periodo'][$i]]['Siete']['Dos'];
                $Suma_Dos = $Suma_Dos+$S_Estrato[$Periodos['Periodo'][$i]]['Ocho']['Dos'];
                $Suma_Dos = $Suma_Dos+$S_Estrato[$Periodos['Periodo'][$i]]['Nueve']['Dos'];
                $Suma_Dos = $Suma_Dos+$S_Estrato[$Periodos['Periodo'][$i]]['Diez']['Dos'];
                $Suma_Dos = $Suma_Dos+$S_Estrato[$Periodos['Periodo'][$i]]['Once']['Dos'];
                $Suma_Dos = $Suma_Dos+$S_Estrato[$Periodos['Periodo'][$i]]['Doce']['Dos'];
                /***********************************************************************************************/
                $Suma_Tres=0;
                $Suma_Tres = $Suma_Tres+$S_Estrato[$Periodos['Periodo'][$i]]['Cero']['Tres'];
                $Suma_Tres = $Suma_Tres+$S_Estrato[$Periodos['Periodo'][$i]]['Uno']['Tres'];
                $Suma_Tres = $Suma_Tres+$S_Estrato[$Periodos['Periodo'][$i]]['Dos']['Tres'];
                $Suma_Tres = $Suma_Tres+$S_Estrato[$Periodos['Periodo'][$i]]['Tres']['Tres'];
                $Suma_Tres = $Suma_Tres+$S_Estrato[$Periodos['Periodo'][$i]]['Cuatro']['Tres'];
                $Suma_Tres = $Suma_Tres+$S_Estrato[$Periodos['Periodo'][$i]]['Cinco']['Tres'];
                $Suma_Tres = $Suma_Tres+$S_Estrato[$Periodos['Periodo'][$i]]['Seis']['Tres'];
                $Suma_Tres = $Suma_Tres+$S_Estrato[$Periodos['Periodo'][$i]]['Siete']['Tres'];
                $Suma_Tres = $Suma_Tres+$S_Estrato[$Periodos['Periodo'][$i]]['Ocho']['Tres'];
                $Suma_Tres = $Suma_Tres+$S_Estrato[$Periodos['Periodo'][$i]]['Nueve']['Tres'];
                $Suma_Tres = $Suma_Tres+$S_Estrato[$Periodos['Periodo'][$i]]['Diez']['Tres'];
                $Suma_Tres = $Suma_Tres+$S_Estrato[$Periodos['Periodo'][$i]]['Once']['Tres'];
                $Suma_Tres = $Suma_Tres+$S_Estrato[$Periodos['Periodo'][$i]]['Doce']['Tres'];
                /***********************************************************************************************/
                $Suma_Cuatro=0;
                $Suma_Cuatro = $Suma_Cuatro+$S_Estrato[$Periodos['Periodo'][$i]]['Cero']['Cuatro'];
                $Suma_Cuatro = $Suma_Cuatro+$S_Estrato[$Periodos['Periodo'][$i]]['Uno']['Cuatro'];
                $Suma_Cuatro = $Suma_Cuatro+$S_Estrato[$Periodos['Periodo'][$i]]['Dos']['Cuatro'];
                $Suma_Cuatro = $Suma_Cuatro+$S_Estrato[$Periodos['Periodo'][$i]]['Tres']['Cuatro'];
                $Suma_Cuatro = $Suma_Cuatro+$S_Estrato[$Periodos['Periodo'][$i]]['Cuatro']['Cuatro'];
                $Suma_Cuatro = $Suma_Cuatro+$S_Estrato[$Periodos['Periodo'][$i]]['Cinco']['Cuatro'];
                $Suma_Cuatro = $Suma_Cuatro+$S_Estrato[$Periodos['Periodo'][$i]]['Seis']['Cuatro'];
                $Suma_Cuatro = $Suma_Cuatro+$S_Estrato[$Periodos['Periodo'][$i]]['Siete']['Cuatro'];
                $Suma_Cuatro = $Suma_Cuatro+$S_Estrato[$Periodos['Periodo'][$i]]['Ocho']['Cuatro'];
                $Suma_Cuatro = $Suma_Cuatro+$S_Estrato[$Periodos['Periodo'][$i]]['Nueve']['Cuatro'];
                $Suma_Cuatro = $Suma_Cuatro+$S_Estrato[$Periodos['Periodo'][$i]]['Diez']['Cuatro'];
                $Suma_Cuatro = $Suma_Cuatro+$S_Estrato[$Periodos['Periodo'][$i]]['Once']['Cuatro'];
                $Suma_Cuatro = $Suma_Cuatro+$S_Estrato[$Periodos['Periodo'][$i]]['Doce']['Cuatro'];
                /***********************************************************************************************/
                $Suma_Cinco=0;
                $Suma_Cinco = $Suma_Cinco+$S_Estrato[$Periodos['Periodo'][$i]]['Cero']['Cinco'];
                $Suma_Cinco = $Suma_Cinco+$S_Estrato[$Periodos['Periodo'][$i]]['Uno']['Cinco'];
                $Suma_Cinco = $Suma_Cinco+$S_Estrato[$Periodos['Periodo'][$i]]['Dos']['Cinco'];
                $Suma_Cinco = $Suma_Cinco+$S_Estrato[$Periodos['Periodo'][$i]]['Tres']['Cinco'];
                $Suma_Cinco = $Suma_Cinco+$S_Estrato[$Periodos['Periodo'][$i]]['Cuatro']['Cinco'];
                $Suma_Cinco = $Suma_Cinco+$S_Estrato[$Periodos['Periodo'][$i]]['Cinco']['Cinco'];
                $Suma_Cinco = $Suma_Cinco+$S_Estrato[$Periodos['Periodo'][$i]]['Seis']['Cinco'];
                $Suma_Cinco = $Suma_Cinco+$S_Estrato[$Periodos['Periodo'][$i]]['Siete']['Cinco'];
                $Suma_Cinco = $Suma_Cinco+$S_Estrato[$Periodos['Periodo'][$i]]['Ocho']['Cinco'];
                $Suma_Cinco = $Suma_Cinco+$S_Estrato[$Periodos['Periodo'][$i]]['Nueve']['Cinco'];
                $Suma_Cinco = $Suma_Cinco+$S_Estrato[$Periodos['Periodo'][$i]]['Diez']['Cinco'];
                $Suma_Cinco = $Suma_Cinco+$S_Estrato[$Periodos['Periodo'][$i]]['Once']['Cinco'];
                $Suma_Cinco = $Suma_Cinco+$S_Estrato[$Periodos['Periodo'][$i]]['Doce']['Cinco'];
                /***********************************************************************************************/
                $Suma_Seis=0;
                $Suma_Seis = $Suma_Seis+$S_Estrato[$Periodos['Periodo'][$i]]['Cero']['Seis'];
                $Suma_Seis = $Suma_Seis+$S_Estrato[$Periodos['Periodo'][$i]]['Uno']['Seis'];
                $Suma_Seis = $Suma_Seis+$S_Estrato[$Periodos['Periodo'][$i]]['Dos']['Seis'];
                $Suma_Seis = $Suma_Seis+$S_Estrato[$Periodos['Periodo'][$i]]['Tres']['Seis'];
                $Suma_Seis = $Suma_Seis+$S_Estrato[$Periodos['Periodo'][$i]]['Cuatro']['Seis'];
                $Suma_Seis = $Suma_Seis+$S_Estrato[$Periodos['Periodo'][$i]]['Cinco']['Seis'];
                $Suma_Seis = $Suma_Seis+$S_Estrato[$Periodos['Periodo'][$i]]['Seis']['Seis'];
                $Suma_Seis = $Suma_Seis+$S_Estrato[$Periodos['Periodo'][$i]]['Siete']['Seis'];
                $Suma_Seis = $Suma_Seis+$S_Estrato[$Periodos['Periodo'][$i]]['Ocho']['Seis'];
                $Suma_Seis = $Suma_Seis+$S_Estrato[$Periodos['Periodo'][$i]]['Nueve']['Seis'];
                $Suma_Seis = $Suma_Seis+$S_Estrato[$Periodos['Periodo'][$i]]['Diez']['Seis'];
                $Suma_Seis = $Suma_Seis+$S_Estrato[$Periodos['Periodo'][$i]]['Once']['Seis'];
                $Suma_Seis = $Suma_Seis+$S_Estrato[$Periodos['Periodo'][$i]]['Doce']['Seis'];
                /***********************************************************************************************/
                
                ?>
                <td align="center"><?PHP echo $C_Respuesta[$Periodos['Periodo'][$i]]['Total']?></td>
                <?PHP 
                $T_No = (($Suma_No/$C_Respuesta[$Periodos['Periodo'][$i]]['Total'])*100);    
                ?>
                <td align="center"><?PHP echo $Suma_No?></td>
                <td align="center"><?PHP echo number_format($T_No,'2',',','.')?>%</td>
                <?PHP 
                $T_Uno = (($Suma_Uno/$C_Respuesta[$Periodos['Periodo'][$i]]['Total'])*100);    
                ?>
                <td align="center"><?PHP echo $Suma_Uno?></td>
                <td align="center"><?PHP echo number_format($T_Uno,'2',',','.')?>%</td>
                <?PHP 
                $T_Dos = (($Suma_Dos/$C_Respuesta[$Periodos['Periodo'][$i]]['Total'])*100);    
                ?>
                <td align="center"><?PHP echo $Suma_Dos?></td>
                <td align="center"><?PHP echo number_format($T_Dos,'2',',','.')?>%</td>
                <?PHP 
                $T_Tres = (($Suma_Tres/$C_Respuesta[$Periodos['Periodo'][$i]]['Total'])*100);    
                ?>
                <td align="center"><?PHP echo $Suma_Tres?></td>
                <td align="center"><?PHP echo number_format($T_Tres,'2',',','.')?>%</td>
                <?PHP 
                $T_Cuatro = (($Suma_Cuatro/$C_Respuesta[$Periodos['Periodo'][$i]]['Total'])*100);    
                ?>
                <td align="center"><?PHP echo $Suma_Cuatro?></td>
                <td align="center"><?PHP echo number_format($T_Cuatro,'2',',','.')?>%</td>
                <?PHP 
                $T_Cinco = (($Suma_Cinco/$C_Respuesta[$Periodos['Periodo'][$i]]['Total'])*100);    
                ?>
                <td align="center"><?PHP echo $Suma_Cinco?></td>
                <td align="center"><?PHP echo number_format($T_Cinco,'2',',','.')?>%</td>
                <?PHP 
                $T_Seis = (($Suma_Seis/$C_Respuesta[$Periodos['Periodo'][$i]]['Total'])*100);    
                ?>
                <td align="center"><?PHP echo $Suma_Seis?></td>
                <td align="center"><?PHP echo number_format($T_Seis,'2',',','.')?>%</td>
                <!---->
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <?PHP
            }
            ?>
        </tr>
    </body>
</table>
</div>
<?PHP    
function MainJson(){
	
	global $db,$userid;
	
	include ('../templates/mainjson.php');
	
	
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
	
}
function PromedioSemestre($Arreglo,$Periodo){
    global $db;
    /***********************************************/
    
    $C_Resultado = array();
    $D_Resultado = array();
    
for($t=0;$t<count($Periodo);$t++){
    
    
    $CodigoPeriodo = $Periodo[$t];
   
    
    for($i=0;$i<count($Arreglo[$CodigoPeriodo]['codigoestudiante_Cero']);$i++){
        
        /************************************/
        $CodigoEstudiante = $Arreglo[$CodigoPeriodo]['codigoestudiante_Cero'][$i];
        /************************************/
        
        $SQL='SELECT 

                SUM(dp.numerocreditosdetalleplanestudio) as T_Creditos,
                SUM((h.notadefinitiva*dp.numerocreditosdetalleplanestudio)) as T_Notas
                
                FROM 
                
                planestudioestudiante pe INNER JOIN estudiante e  ON  e.codigoestudiante=pe.codigoestudiante
                INNER JOIN detalleplanestudio dp ON pe.idplanestudio=dp.idplanestudio
                INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
                INNER JOIN detalleprematricula  prd ON prd.idprematricula=p.idprematricula
                INNER JOIN notahistorico h ON h.codigoestudiante=e.codigoestudiante AND h.codigomateria=prd.codigomateria AND h.codigoperiodo="'.$CodigoPeriodo.'"
                
                WHERE
                
                e.codigoestudiante="'.$CodigoEstudiante.'"
                AND
                prd.codigomateria
                AND
                p.codigoperiodo="'.$CodigoPeriodo.'"
                AND
                prd.codigoestadodetalleprematricula=30
                AND
                dp.codigomateria=prd.codigomateria';
                
           if($Consulta=&$db->Execute($SQL)===false){
             echo 'Error en el SQl de Los Promedios...<br><br>'.$SQL;
             die;
           }     
        
        $Final = number_format($Consulta->fields['T_Notas']/$Consulta->fields['T_Creditos'],'1','.','.');
        
        $C_Resultado['Cero'][]=$Final;
        
    }//for
    
    $Suma_Cero = 0;
    
    for($Q=0;$Q<count($C_Resultado['Cero']);$Q++){
        $Suma_Cero = $Suma_Cero+$C_Resultado['Cero'][$Q];
    }//for 
    $D_Resultado[$CodigoPeriodo]['Total_Cero']=number_format(($Suma_Cero/count($C_Resultado['Cero'])),'1','.','.');
    /*********************************************************************************************/
    for($i=0;$i<count($Arreglo[$CodigoPeriodo]['codigoestudiante_Uno']);$i++){
        
        /************************************/
        $CodigoEstudiante = $Arreglo[$CodigoPeriodo]['codigoestudiante_Uno'][$i];
        /************************************/
        
        $SQL='SELECT 

                SUM(dp.numerocreditosdetalleplanestudio) as T_Creditos,
                SUM((h.notadefinitiva*dp.numerocreditosdetalleplanestudio)) as T_Notas
                
                FROM 
                
                planestudioestudiante pe INNER JOIN estudiante e  ON  e.codigoestudiante=pe.codigoestudiante
                INNER JOIN detalleplanestudio dp ON pe.idplanestudio=dp.idplanestudio
                INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
                INNER JOIN detalleprematricula  prd ON prd.idprematricula=p.idprematricula
                INNER JOIN notahistorico h ON h.codigoestudiante=e.codigoestudiante AND h.codigomateria=prd.codigomateria AND h.codigoperiodo="'.$CodigoPeriodo.'"
                
                WHERE
                
                e.codigoestudiante="'.$CodigoEstudiante.'"
                AND
                prd.codigomateria
                AND
                p.codigoperiodo="'.$CodigoPeriodo.'"
                AND
                prd.codigoestadodetalleprematricula=30
                AND
                dp.codigomateria=prd.codigomateria';
                
           if($Consulta=&$db->Execute($SQL)===false){
             echo 'Error en el SQl de Los Promedios...<br><br>'.$SQL;
             die;
           }     
        
        $Final = number_format($Consulta->fields['T_Notas']/$Consulta->fields['T_Creditos'],'1','.','.');
        
        $C_Resultado['Uno'][]=$Final;
        
    }//for
    
    $Suma_Uno = 0;
    
    for($Q=0;$Q<count($C_Resultado['Uno']);$Q++){
       // echo '<br>'.$C_Resultado['Uno'][$Q];
        $Suma_Uno = $Suma_Uno+$C_Resultado['Uno'][$Q];
    }//for
   // echo '<br>Suma_UNo->'.$Suma_Uno;
    $D_Resultado[$CodigoPeriodo]['Total_Uno']=number_format(($Suma_Uno/count($C_Resultado['Uno'])),'1','.','.');
    /*************************************************************************************************/
    for($i=0;$i<count($Arreglo[$CodigoPeriodo]['codigoestudiante_Dos']);$i++){
        
        /************************************/
        $CodigoEstudiante = $Arreglo[$CodigoPeriodo]['codigoestudiante_Dos'][$i];
        /************************************/
        
        $SQL='SELECT 

                SUM(dp.numerocreditosdetalleplanestudio) as T_Creditos,
                SUM((h.notadefinitiva*dp.numerocreditosdetalleplanestudio)) as T_Notas
                
                FROM 
                
                planestudioestudiante pe INNER JOIN estudiante e  ON  e.codigoestudiante=pe.codigoestudiante
                INNER JOIN detalleplanestudio dp ON pe.idplanestudio=dp.idplanestudio
                INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
                INNER JOIN detalleprematricula  prd ON prd.idprematricula=p.idprematricula
                INNER JOIN notahistorico h ON h.codigoestudiante=e.codigoestudiante AND h.codigomateria=prd.codigomateria AND h.codigoperiodo="'.$CodigoPeriodo.'"
                
                WHERE
                
                e.codigoestudiante="'.$CodigoEstudiante.'"
                AND
                prd.codigomateria
                AND
                p.codigoperiodo="'.$CodigoPeriodo.'"
                AND
                prd.codigoestadodetalleprematricula=30
                AND
                dp.codigomateria=prd.codigomateria';
                
           if($Consulta=&$db->Execute($SQL)===false){
             echo 'Error en el SQl de Los Promedios...<br><br>'.$SQL;
             die;
           }     
        
        $Final = number_format($Consulta->fields['T_Notas']/$Consulta->fields['T_Creditos'],'1','.','.');
        
        $C_Resultado['Dos'][]=$Final;
        
    }//for
    
    $Suma_Dos = 0;
    
    for($Q=0;$Q<count($C_Resultado['Dos']);$Q++){
        $Suma_Dos = $Suma_Dos+$C_Resultado['Dos'][$Q];
    }//for
    $D_Resultado[$CodigoPeriodo]['Total_Dos']=number_format(($Suma_Dos/count($C_Resultado['Dos'])),'1','.','.');
    /*************************************************************************************************/
    for($i=0;$i<count($Arreglo[$CodigoPeriodo]['codigoestudiante_Tres']);$i++){
        
        /************************************/
        $CodigoEstudiante = $Arreglo[$CodigoPeriodo]['codigoestudiante_Tres'][$i];
        /************************************/
        
        $SQL='SELECT 

                SUM(dp.numerocreditosdetalleplanestudio) as T_Creditos,
                SUM((h.notadefinitiva*dp.numerocreditosdetalleplanestudio)) as T_Notas
                
                FROM 
                
                planestudioestudiante pe INNER JOIN estudiante e  ON  e.codigoestudiante=pe.codigoestudiante
                INNER JOIN detalleplanestudio dp ON pe.idplanestudio=dp.idplanestudio
                INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
                INNER JOIN detalleprematricula  prd ON prd.idprematricula=p.idprematricula
                INNER JOIN notahistorico h ON h.codigoestudiante=e.codigoestudiante AND h.codigomateria=prd.codigomateria AND h.codigoperiodo="'.$CodigoPeriodo.'"
                
                WHERE
                
                e.codigoestudiante="'.$CodigoEstudiante.'"
                AND
                prd.codigomateria
                AND
                p.codigoperiodo="'.$CodigoPeriodo.'"
                AND
                prd.codigoestadodetalleprematricula=30
                AND
                dp.codigomateria=prd.codigomateria';
                
           if($Consulta=&$db->Execute($SQL)===false){
             echo 'Error en el SQl de Los Promedios...<br><br>'.$SQL;
             die;
           }     
        
        $Final = number_format($Consulta->fields['T_Notas']/$Consulta->fields['T_Creditos'],'1','.','.');
        
        $C_Resultado['Tres'][]=$Final;
        
    }//for
    
    $Suma_Tres = 0;
    
    for($Q=0;$Q<count($C_Resultado['Tres']);$Q++){
        $Suma_Tres = $Suma_Tres+$C_Resultado['Tres'][$Q];
    }//for
    $D_Resultado[$CodigoPeriodo]['Total_Tres']=number_format(($Suma_Tres/count($C_Resultado['Tres'])),'1','.','.');
    /*************************************************************************************************/
    for($i=0;$i<count($Arreglo[$CodigoPeriodo]['codigoestudiante_Cuatro']);$i++){
        
        /************************************/
        $CodigoEstudiante = $Arreglo[$CodigoPeriodo]['codigoestudiante_Cuatro'][$i];
        /************************************/
        
        $SQL='SELECT 

                SUM(dp.numerocreditosdetalleplanestudio) as T_Creditos,
                SUM((h.notadefinitiva*dp.numerocreditosdetalleplanestudio)) as T_Notas
                
                FROM 
                
                planestudioestudiante pe INNER JOIN estudiante e  ON  e.codigoestudiante=pe.codigoestudiante
                INNER JOIN detalleplanestudio dp ON pe.idplanestudio=dp.idplanestudio
                INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
                INNER JOIN detalleprematricula  prd ON prd.idprematricula=p.idprematricula
                INNER JOIN notahistorico h ON h.codigoestudiante=e.codigoestudiante AND h.codigomateria=prd.codigomateria AND h.codigoperiodo="'.$CodigoPeriodo.'"
                
                WHERE
                
                e.codigoestudiante="'.$CodigoEstudiante.'"
                AND
                prd.codigomateria
                AND
                p.codigoperiodo="'.$CodigoPeriodo.'"
                AND
                prd.codigoestadodetalleprematricula=30
                AND
                dp.codigomateria=prd.codigomateria';
                
           if($Consulta=&$db->Execute($SQL)===false){
             echo 'Error en el SQl de Los Promedios...<br><br>'.$SQL;
             die;
           }     
        
        $Final = number_format($Consulta->fields['T_Notas']/$Consulta->fields['T_Creditos'],'1','.','.');
        
        $C_Resultado['Cuatro'][]=$Final;
        
    }//for
    
    $Suma_Cuatro = 0;
    
    for($Q=0;$Q<count($C_Resultado['Cuatro']);$Q++){
        $Suma_Cuatro = $Suma_Cuatro+$C_Resultado['Cuatro'][$Q];
    }//for
    $D_Resultado[$CodigoPeriodo]['Total_Cuatro']=number_format(($Suma_Cuatro/count($C_Resultado['Cuatro'])),'1','.','.');
    /*************************************************************************************************/
     for($i=0;$i<count($Arreglo[$CodigoPeriodo]['codigoestudiante_Cinco']);$i++){
        
        /************************************/
        $CodigoEstudiante = $Arreglo[$CodigoPeriodo]['codigoestudiante_Cinco'][$i];
        /************************************/
        
        $SQL='SELECT 

                SUM(dp.numerocreditosdetalleplanestudio) as T_Creditos,
                SUM((h.notadefinitiva*dp.numerocreditosdetalleplanestudio)) as T_Notas
                
                FROM 
                
                planestudioestudiante pe INNER JOIN estudiante e  ON  e.codigoestudiante=pe.codigoestudiante
                INNER JOIN detalleplanestudio dp ON pe.idplanestudio=dp.idplanestudio
                INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
                INNER JOIN detalleprematricula  prd ON prd.idprematricula=p.idprematricula
                INNER JOIN notahistorico h ON h.codigoestudiante=e.codigoestudiante AND h.codigomateria=prd.codigomateria AND h.codigoperiodo="'.$CodigoPeriodo.'"
                
                WHERE
                
                e.codigoestudiante="'.$CodigoEstudiante.'"
                AND
                prd.codigomateria
                AND
                p.codigoperiodo="'.$CodigoPeriodo.'"
                AND
                prd.codigoestadodetalleprematricula=30
                AND
                dp.codigomateria=prd.codigomateria';
                
           if($Consulta=&$db->Execute($SQL)===false){
             echo 'Error en el SQl de Los Promedios...<br><br>'.$SQL;
             die;
           }     
        
        $Final = number_format($Consulta->fields['T_Notas']/$Consulta->fields['T_Creditos'],'1','.','.');
        
        $C_Resultado['Cinco'][]=$Final;
        
    }//for
    
    $Suma_Cinco = 0;
    
    for($Q=0;$Q<count($C_Resultado['Cinco']);$Q++){
        $Suma_Cinco = $Suma_Cinco+$C_Resultado['Cinco'][$Q];
    }//for
    $D_Resultado[$CodigoPeriodo]['Total_Cinco']=number_format(($Suma_Cinco/count($C_Resultado['Cinco'])),'1','.','.');
    /*************************************************************************************************/
     for($i=0;$i<count($Arreglo[$CodigoPeriodo]['codigoestudiante_Seis']);$i++){
        
        /************************************/
        $CodigoEstudiante = $Arreglo[$CodigoPeriodo]['codigoestudiante_Seis'][$i];
        /************************************/
        
        $SQL='SELECT 

                SUM(dp.numerocreditosdetalleplanestudio) as T_Creditos,
                SUM((h.notadefinitiva*dp.numerocreditosdetalleplanestudio)) as T_Notas
                
                FROM 
                
                planestudioestudiante pe INNER JOIN estudiante e  ON  e.codigoestudiante=pe.codigoestudiante
                INNER JOIN detalleplanestudio dp ON pe.idplanestudio=dp.idplanestudio
                INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
                INNER JOIN detalleprematricula  prd ON prd.idprematricula=p.idprematricula
                INNER JOIN notahistorico h ON h.codigoestudiante=e.codigoestudiante AND h.codigomateria=prd.codigomateria AND h.codigoperiodo="'.$CodigoPeriodo.'"
                
                WHERE
                
                e.codigoestudiante="'.$CodigoEstudiante.'"
                AND
                prd.codigomateria
                AND
                p.codigoperiodo="'.$CodigoPeriodo.'"
                AND
                prd.codigoestadodetalleprematricula=30
                AND
                dp.codigomateria=prd.codigomateria';
                
           if($Consulta=&$db->Execute($SQL)===false){
             echo 'Error en el SQl de Los Promedios...<br><br>'.$SQL;
             die;
           }     
        
        $Final = number_format($Consulta->fields['T_Notas']/$Consulta->fields['T_Creditos'],'1','.','.');
        
        $C_Resultado['Seis'][]=$Final;
        
    }//for
    
    $Suma_Seis = 0;
    
    for($Q=0;$Q<count($C_Resultado['Seis']);$Q++){
        $Suma_Seis = $Suma_Seis+$C_Resultado['Seis'][$Q];
    }//for
    $D_Resultado[$CodigoPeriodo]['Total_Seis']=number_format(($Suma_Seis/count($C_Resultado['Seis'])),'1','.','.');
    /*************************************************************************************************/
     for($i=0;$i<count($Arreglo[$CodigoPeriodo]['codigoestudiante_Siete']);$i++){
        
        /************************************/
        $CodigoEstudiante = $Arreglo[$CodigoPeriodo]['codigoestudiante_Siete'][$i];
        /************************************/
        
        $SQL='SELECT 

                SUM(dp.numerocreditosdetalleplanestudio) as T_Creditos,
                SUM((h.notadefinitiva*dp.numerocreditosdetalleplanestudio)) as T_Notas
                
                FROM 
                
                planestudioestudiante pe INNER JOIN estudiante e  ON  e.codigoestudiante=pe.codigoestudiante
                INNER JOIN detalleplanestudio dp ON pe.idplanestudio=dp.idplanestudio
                INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
                INNER JOIN detalleprematricula  prd ON prd.idprematricula=p.idprematricula
                INNER JOIN notahistorico h ON h.codigoestudiante=e.codigoestudiante AND h.codigomateria=prd.codigomateria AND h.codigoperiodo="'.$CodigoPeriodo.'"
                
                WHERE
                
                e.codigoestudiante="'.$CodigoEstudiante.'"
                AND
                prd.codigomateria
                AND
                p.codigoperiodo="'.$CodigoPeriodo.'"
                AND
                prd.codigoestadodetalleprematricula=30
                AND
                dp.codigomateria=prd.codigomateria';
                
           if($Consulta=&$db->Execute($SQL)===false){
             echo 'Error en el SQl de Los Promedios...<br><br>'.$SQL;
             die;
           }     
        
        $Final = number_format($Consulta->fields['T_Notas']/$Consulta->fields['T_Creditos'],'1','.','.');
        
        $C_Resultado['Siete'][]=$Final;
        
    }//for
    
    $Suma_Siete = 0;
    
    for($Q=0;$Q<count($C_Resultado['Siete']);$Q++){
        $Suma_Siete = $Suma_Siete+$C_Resultado['Siete'][$Q];
    }//for
    $D_Resultado[$CodigoPeriodo]['Total_Siete']=number_format(($Suma_Siete/count($C_Resultado['Siete'])),'1','.','.');
    /*************************************************************************************************/
     for($i=0;$i<count($Arreglo[$CodigoPeriodo]['codigoestudiante_Ocho']);$i++){
        
        /************************************/
        $CodigoEstudiante = $Arreglo[$CodigoPeriodo]['codigoestudiante_Ocho'][$i];
        /************************************/
        
        $SQL='SELECT 

                SUM(dp.numerocreditosdetalleplanestudio) as T_Creditos,
                SUM((h.notadefinitiva*dp.numerocreditosdetalleplanestudio)) as T_Notas
                
                FROM 
                
                planestudioestudiante pe INNER JOIN estudiante e  ON  e.codigoestudiante=pe.codigoestudiante
                INNER JOIN detalleplanestudio dp ON pe.idplanestudio=dp.idplanestudio
                INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
                INNER JOIN detalleprematricula  prd ON prd.idprematricula=p.idprematricula
                INNER JOIN notahistorico h ON h.codigoestudiante=e.codigoestudiante AND h.codigomateria=prd.codigomateria AND h.codigoperiodo="'.$CodigoPeriodo.'"
                
                WHERE
                
                e.codigoestudiante="'.$CodigoEstudiante.'"
                AND
                prd.codigomateria
                AND
                p.codigoperiodo="'.$CodigoPeriodo.'"
                AND
                prd.codigoestadodetalleprematricula=30
                AND
                dp.codigomateria=prd.codigomateria';
                
           if($Consulta=&$db->Execute($SQL)===false){
             echo 'Error en el SQl de Los Promedios...<br><br>'.$SQL;
             die;
           }     
        
        $Final = number_format($Consulta->fields['T_Notas']/$Consulta->fields['T_Creditos'],'1','.','.');
        
        $C_Resultado['Ocho'][]=$Final;
        
    }//for
    
    $Suma_Ocho = 0;
    
    for($Q=0;$Q<count($C_Resultado['Ocho']);$Q++){
        $Suma_Ocho = $Suma_Ocho+$C_Resultado['Ocho'][$Q];
    }//for
    $D_Resultado[$CodigoPeriodo]['Total_Ocho']=number_format(($Suma_Ocho/count($C_Resultado['Ocho'])),'1','.','.');
    /*************************************************************************************************/
    for($i=0;$i<count($Arreglo[$CodigoPeriodo]['codigoestudiante_Nueve']);$i++){
        
        /************************************/
        $CodigoEstudiante = $Arreglo[$CodigoPeriodo]['codigoestudiante_Nueve'][$i];
        /************************************/
        
        $SQL='SELECT 

                SUM(dp.numerocreditosdetalleplanestudio) as T_Creditos,
                SUM((h.notadefinitiva*dp.numerocreditosdetalleplanestudio)) as T_Notas
                
                FROM 
                
                planestudioestudiante pe INNER JOIN estudiante e  ON  e.codigoestudiante=pe.codigoestudiante
                INNER JOIN detalleplanestudio dp ON pe.idplanestudio=dp.idplanestudio
                INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
                INNER JOIN detalleprematricula  prd ON prd.idprematricula=p.idprematricula
                INNER JOIN notahistorico h ON h.codigoestudiante=e.codigoestudiante AND h.codigomateria=prd.codigomateria AND h.codigoperiodo="'.$CodigoPeriodo.'"
                
                WHERE
                
                e.codigoestudiante="'.$CodigoEstudiante.'"
                AND
                prd.codigomateria
                AND
                p.codigoperiodo="'.$CodigoPeriodo.'"
                AND
                prd.codigoestadodetalleprematricula=30
                AND
                dp.codigomateria=prd.codigomateria';
                
           if($Consulta=&$db->Execute($SQL)===false){
             echo 'Error en el SQl de Los Promedios...<br><br>'.$SQL;
             die;
           }     
        
        $Final = number_format($Consulta->fields['T_Notas']/$Consulta->fields['T_Creditos'],'1','.','.');
        
        $C_Resultado['Nueve'][]=$Final;
        
    }//for
    
    $Suma_Nueve = 0;
    
    for($Q=0;$Q<count($C_Resultado['Nueve']);$Q++){
        $Suma_Nueve = $Suma_Nueve+$C_Resultado['Nueve'][$Q];
    }//for
    $D_Resultado[$CodigoPeriodo]['Total_Nueve']=number_format(($Suma_Nueve/count($C_Resultado['Nueve'])),'1','.','.');
    /*************************************************************************************************/
    for($i=0;$i<count($Arreglo[$CodigoPeriodo]['codigoestudiante_Diez']);$i++){
        
        /************************************/
        $CodigoEstudiante = $Arreglo[$CodigoPeriodo]['codigoestudiante_Diez'][$i];
        /************************************/
        
        $SQL='SELECT 

                SUM(dp.numerocreditosdetalleplanestudio) as T_Creditos,
                SUM((h.notadefinitiva*dp.numerocreditosdetalleplanestudio)) as T_Notas
                
                FROM 
                
                planestudioestudiante pe INNER JOIN estudiante e  ON  e.codigoestudiante=pe.codigoestudiante
                INNER JOIN detalleplanestudio dp ON pe.idplanestudio=dp.idplanestudio
                INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
                INNER JOIN detalleprematricula  prd ON prd.idprematricula=p.idprematricula
                INNER JOIN notahistorico h ON h.codigoestudiante=e.codigoestudiante AND h.codigomateria=prd.codigomateria AND h.codigoperiodo="'.$CodigoPeriodo.'"
                
                WHERE
                
                e.codigoestudiante="'.$CodigoEstudiante.'"
                AND
                prd.codigomateria
                AND
                p.codigoperiodo="'.$CodigoPeriodo.'"
                AND
                prd.codigoestadodetalleprematricula=30
                AND
                dp.codigomateria=prd.codigomateria';
                
           if($Consulta=&$db->Execute($SQL)===false){
             echo 'Error en el SQl de Los Promedios...<br><br>'.$SQL;
             die;
           }     
        
        $Final = number_format($Consulta->fields['T_Notas']/$Consulta->fields['T_Creditos'],'1','.','.');
        
        $C_Resultado['Diez'][]=$Final;
        
    }//for
    
    $Suma_Diez = 0;
    
    for($Q=0;$Q<count($C_Resultado['Diez']);$Q++){
        $Suma_Diez = $Suma_Diez+$C_Resultado['Diez'][$Q];
    }//for
    $D_Resultado[$CodigoPeriodo]['Total_Diez']=number_format(($Suma_Diez/count($C_Resultado['Diez'])),'1','.','.');
    /*************************************************************************************************/
     for($i=0;$i<count($Arreglo[$CodigoPeriodo]['codigoestudiante_Once']);$i++){
        
        /************************************/
        $CodigoEstudiante = $Arreglo[$CodigoPeriodo]['codigoestudiante_Once'][$i];
        /************************************/
        
        $SQL='SELECT 

                SUM(dp.numerocreditosdetalleplanestudio) as T_Creditos,
                SUM((h.notadefinitiva*dp.numerocreditosdetalleplanestudio)) as T_Notas
                
                FROM 
                
                planestudioestudiante pe INNER JOIN estudiante e  ON  e.codigoestudiante=pe.codigoestudiante
                INNER JOIN detalleplanestudio dp ON pe.idplanestudio=dp.idplanestudio
                INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
                INNER JOIN detalleprematricula  prd ON prd.idprematricula=p.idprematricula
                INNER JOIN notahistorico h ON h.codigoestudiante=e.codigoestudiante AND h.codigomateria=prd.codigomateria AND h.codigoperiodo="'.$CodigoPeriodo.'"
                
                WHERE
                
                e.codigoestudiante="'.$CodigoEstudiante.'"
                AND
                prd.codigomateria
                AND
                p.codigoperiodo="'.$CodigoPeriodo.'"
                AND
                prd.codigoestadodetalleprematricula=30
                AND
                dp.codigomateria=prd.codigomateria';
                
           if($Consulta=&$db->Execute($SQL)===false){
             echo 'Error en el SQl de Los Promedios...<br><br>'.$SQL;
             die;
           }     
        
        $Final = number_format($Consulta->fields['T_Notas']/$Consulta->fields['T_Creditos'],'1','.','.');
        
        $C_Resultado['Once'][]=$Final;
        
    }//for
    
    $Suma_Once = 0;
    
    for($Q=0;$Q<count($C_Resultado['Once']);$Q++){
        $Suma_Once = $Suma_Once+$C_Resultado['Once'][$Q];
    }//for
    $D_Resultado[$CodigoPeriodo]['Total_Once']=number_format(($Suma_Once/count($C_Resultado['Once'])),'1','.','.');
    /*************************************************************************************************/
     for($i=0;$i<count($Arreglo[$CodigoPeriodo]['codigoestudiante_Doce']);$i++){
        
        /************************************/
        $CodigoEstudiante = $Arreglo[$CodigoPeriodo]['codigoestudiante_Doce'][$i];
        /************************************/
        
        $SQL='SELECT 

                SUM(dp.numerocreditosdetalleplanestudio) as T_Creditos,
                SUM((h.notadefinitiva*dp.numerocreditosdetalleplanestudio)) as T_Notas
                
                FROM 
                
                planestudioestudiante pe INNER JOIN estudiante e  ON  e.codigoestudiante=pe.codigoestudiante
                INNER JOIN detalleplanestudio dp ON pe.idplanestudio=dp.idplanestudio
                INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
                INNER JOIN detalleprematricula  prd ON prd.idprematricula=p.idprematricula
                INNER JOIN notahistorico h ON h.codigoestudiante=e.codigoestudiante AND h.codigomateria=prd.codigomateria AND h.codigoperiodo="'.$CodigoPeriodo.'"
                
                WHERE
                
                e.codigoestudiante="'.$CodigoEstudiante.'"
                AND
                prd.codigomateria
                AND
                p.codigoperiodo="'.$CodigoPeriodo.'"
                AND
                prd.codigoestadodetalleprematricula=30
                AND
                dp.codigomateria=prd.codigomateria';
                
           if($Consulta=&$db->Execute($SQL)===false){
             echo 'Error en el SQl de Los Promedios...<br><br>'.$SQL;
             die;
           }     
        
        $Final = number_format($Consulta->fields['T_Notas']/$Consulta->fields['T_Creditos'],'1','.','.');
        
        $C_Resultado['Doce'][]=$Final;
        
    }//for
    
    $Suma_Doce = 0;
    
    for($Q=0;$Q<count($C_Resultado['Doce']);$Q++){
        $Suma_Doce = $Suma_Doce+$C_Resultado['Doce'][$Q];
    }//for
    $D_Resultado[$CodigoPeriodo]['Total_Doce']=number_format(($Suma_Doce/count($C_Resultado['Doce'])),'1','.','.');
    /*************************************************************************************************/
    //echo '<br>$CodigoPeriodo->'.$CodigoPeriodo;
    ##########################################
   // echo '<pre>';print_r($C_Resultado);
 }//for 
   //echo '<pre>';print_r($D_Resultado);
    return $D_Resultado;
}//function PromedioSemestr
function PromedioSemestreEstrato($Arreglo,$Periodo){
    /************************************************/
    global $db;
    
    
    
    $C_Retunr = array();
    $T_Return = array();
    
    for($i=0;$i<count($Periodo);$i++){
        /*************************************************/
        for($j=0;$j<count($Arreglo);$j++){
            /*********************************************/
            /************************************/
            $CodigoPeriodo    = $Periodo[$i];
            $CodigoEstudiante = $Arreglo[$j];
            /************************************/
            
              $SQL='SELECT 
    
                    SUM(dp.numerocreditosdetalleplanestudio) as T_Creditos,
                    SUM((h.notadefinitiva*dp.numerocreditosdetalleplanestudio)) as T_Notas
                    
                    FROM 
                    
                    planestudioestudiante pe INNER JOIN estudiante e  ON  e.codigoestudiante=pe.codigoestudiante
                    INNER JOIN detalleplanestudio dp ON pe.idplanestudio=dp.idplanestudio
                    INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
                    INNER JOIN detalleprematricula  prd ON prd.idprematricula=p.idprematricula
                    INNER JOIN notahistorico h ON h.codigoestudiante=e.codigoestudiante AND h.codigomateria=prd.codigomateria AND h.codigoperiodo="'.$CodigoPeriodo.'"
                    
                    WHERE
                    
                    e.codigoestudiante="'.$CodigoEstudiante.'"
                    AND
                    prd.codigomateria
                    AND
                    p.codigoperiodo="'.$CodigoPeriodo.'"
                    AND
                    prd.codigoestadodetalleprematricula=30
                    AND
                    dp.codigomateria=prd.codigomateria'; 
                   
                    
               if($Consulta=&$db->Execute($SQL)===false){
                 echo 'Error en el SQl de Los Promedios...<br><br>'.$SQL;
                 die;
               }     
               
             $Final = number_format($Consulta->fields['T_Notas']/$Consulta->fields['T_Creditos'],'1','.','.');
             
             $C_Retunr[$CodigoPeriodo][]= $Final;  
            /*********************************************/
        }//for
        $Suma = 0;
        for($Q=0;$Q<count($C_Retunr[$CodigoPeriodo]);$Q++){
            
            $Suma = $Suma+$C_Retunr[$CodigoPeriodo][$Q];
            
        }//for
        
        $T_Return[$CodigoPeriodo]=number_format(($Suma/count($C_Retunr[$CodigoPeriodo])),'1','.','.');
        /*************************************************/
    }//for
    
    return $T_Return;
    /************************************************/
}//function PromedioSemestreEstrato
function VerEstudiantes($C_Respuesta,$Periodo,$Semestre){
    global $db;
     
    //echo '<pre>';print_r($C_Respuesta[$Periodo][$Semestre]);
    
    $D_Estudiante  = DatosEstudiante($C_Respuesta[$Periodo][$Semestre]);
    
    //echo '<pre>';Print_r($D_Estudiante);
    
    ?>
    <table cellpadding="0" cellspacing="0" border="1" class="display" align="center">
        <thead>
            <tr>
                <th>N&deg;</th>
                <th>Codigo Estudiante</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Num Documento</th>
            </tr>
        </thead>
        <tbody>
            <?PHP 
            for($i=0;$i<count($D_Estudiante);$i++){
               /******************************************************/
               ?>
               <tr>
                    <th><?PHP echo $i+1?></th>
                    <td align="center"><?PHP echo $D_Estudiante[$i]['CodigoEstudiante']?></td>
                    <td><?PHP echo $D_Estudiante[$i]['Nombre']?></td>
                    <td><?PHP echo $D_Estudiante[$i]['Apellido']?></td>
                    <td><?PHP echo $D_Estudiante[$i]['Documento']?></td>
               </tr>
               <?PHP 
               /******************************************************/ 
            }//for
            ?>
        </tbody>
    </table>
    <?PHP
    
}//function VerEstudiantes
function DatosEstudiante($Arreglo){
    global $db;
    
    $C_Estudiante  = array();
    
    for($i=0;$i<count($Arreglo);$i++){
        /*****************************************/
        $CodigoEstudiante = $Arreglo[$i];
        /*****************************************/
        $SQL='SELECT 
            
            g.nombresestudiantegeneral ,
            g.apellidosestudiantegeneral,
            g.numerodocumento
            
            FROM 
            
            estudiante e INNER JOIN estudiantegeneral g ON e.idestudiantegeneral=g.idestudiantegeneral 
            AND 
            e.codigoestudiante="'.$CodigoEstudiante.'"';
            
         if($Estudiante=&$db->Execute($SQL)===false){
            echo 'Error en el SQL Estudiante...<br><br>'.$SQL;
            die;
         }   
        /*****************************************/
        $C_Estudiante[$i]['CodigoEstudiante']=$CodigoEstudiante;
        $C_Estudiante[$i]['Nombre']=$Estudiante->fields['nombresestudiantegeneral'];
        $C_Estudiante[$i]['Apellido']=$Estudiante->fields['apellidosestudiantegeneral'];
        $C_Estudiante[$i]['Documento']=$Estudiante->fields['numerodocumento'];
        /*****************************************/
    }//for
    
    return $C_Estudiante;  
}//function DatosEstudiante
?>