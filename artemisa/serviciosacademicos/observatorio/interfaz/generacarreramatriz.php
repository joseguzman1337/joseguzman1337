<?php
include('../templates/templateObservatorio.php');
include_once ('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
//include_once ('funciones_datos.php');
 //  $db=writeHeaderBD();
   $db=writeHeader('Observatorio',true,'');
   $val=$_REQUEST['id'];
   $sin_ind=$_REQUEST['opt'];
   $codigoperiodo=$_REQUEST['periodo'];
   $fecha=$_REQUEST['fecha'];
   $fecha_actu=date('Y-m-d');
  // echo $val.'-->xxx';
   ?>
<script>
     $(document).ready( function () {
				var oTable = $('#customers').dataTable( {
  					"sScrollX": "200%",
                                        "bPaginate": false,
                                        "oColVis": {
                                                "buttonText": "Ver/Ocultar Columns",
                                                 "aiExclude": [ 0 ]
                                          }
				} );
				//new FixedColumns( oTable );
                                
                                //new FixedHeader( oTable, { "bottom": true } );
                                
                                new FixedColumns( oTable, {
                                         "iLeftColumns": 1,
                                         "iLeftWidth": 200
				} );
//                                 var oTableTools = new TableTools( oTable, {
//					"buttons": [
//						"copy",
//						"csv",
//						"xls",
//						"pdf",
//					]
//		         });
                         //$('#demo').before( oTableTools.dom.container );
			} );


function excel(){
               //alert('hola');
  		$("#datos_a_enviar").val( $("<div>").append( $("#customers2").eq(0).clone()).html());
                $("#form_test").submit(); 
  }
</script>
<?php
$query_fecha="select idobs_admisiones_estadisticas,
ma.codigocarrera, interesados, aspirantes, inscritos, meta_inscritos, logros, inscritos_totales,inscripcion_p1_p2,inscritos_no_evaluados,por_inscritos_no_evaluados,
lista_espera,evaluados_no_adminitdos,admitidos_no_matriculados,administos_no_ingresaron,matriculados_nuevos_sala,meta_matriculados,
logros2,matriculados_periodo,matriculados_p1_p2,matriculados_periodo_totales,matriculados_antiguos,matriculados_totales,fecha_crear,
codigoestado,fechacreacion,usuariocreacion,fechamodificacion,usuariomodificacion,ma.codigoperiodo,ma.codigomodalidadacademica,nombrecarrera 
from 
              obs_admisiones_estadisticas as ma
              inner join carrera as c on (c.codigocarrera=ma.codigocarrera)
              where fecha_crear='".$fecha."'";
//echo $query_fecha;
$data_in= $db->Execute($query_fecha);
$F_data1 = $data_in->GetArray();
$F_total1=count($F_data1);

$interesadosT=0; $aspirantesT=0; $inscritosT=0; $metasT=0; $log_porT=0; $inscritos_totT=0; $inscr_porT=0; $InsNoEvaT=0; $inscr_noevaT=0; $LitaEsperaT=0;
$EvaNoAdmiT=0; $AdminNoMatrT=0; $AdminNoIngT=0; $matri_nuevosT=0; $metas_matriT=0; $log_por_matT=0; $total_matriT=0; $total_matri_acT=0; $matvs_porT=0;
$total_matri_anT=0; $matri_antiguoT=0;
$c_Odata=new obtener_datos_matriculas($db,$codigoperiodo);
$periodo_ant=$c_Odata->obtener_periodo_anterior2($codigoperiodo);
//echo $periodo_ant.'-->';
if($F_total1==0){

   $query_carrera = "SELECT nombrecarrera, codigocarrera 
                     FROM carrera 
                     where codigomodalidadacademica='".$val."' and codigocarrera not in (1,2,600,605) and fechavencimientocarrera >= '2013-01-01 00:00:00'
                      order by 1";
   //echo $query_carrera;
   $data_in= $db->Execute($query_carrera);
   $c_Odata=new obtener_datos_matriculas($db,$codigoperiodo);
   
   $c_Odata_ant=new obtener_datos_matriculas($db,$periodo_ant);

    $fecha = date('Y-m-j');
    $nuevafecha = strtotime ( '-1 year' , strtotime ( $fecha ) ) ;
    $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
     $i=0;
    foreach($data_in as $dt){
         $nombre[$i]=$dt['nombrecarrera'];
         $codigocarrera[$i]=$dt['codigocarrera'];  
         
        //INTERESADOS
         $interesados[$i]=$c_Odata->obtener_preinscripcion_estadopreinscripcionestudiante_general($codigocarrera[$i],'conteo');
         $interesadosT=$interesados[$i]+$interesadosT;

        //ASPIRANTES
        $aspirantes[$i]=$c_Odata->ObtenerAspirantesSinmatriculaSinPago($codigocarrera[$i],$codigoperiodo,'conteo');
        $aspirantesT=$aspirantes[$i]+$aspirantesT;

        // INSCRITOS
        $inscritos[$i]=$c_Odata->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($codigoperiodo,$codigocarrera[$i],'','conteo',null);
        $inscritosT=$inscritos[$i]+$inscritosT;

        //METAS INSCRITOS
        $metas[$i]= $c_Odata->ObtenerMetas($codigocarrera[$i],$codigoperiodo,'conteo');
        $metasT=$metas[$i]+$metasT;

        //HEMOS LOGRADO
        $log_por[$i]=0;
        if ($metas[$i]!=0 or $metas[$i]==''){
                $inscr=(int)$inscritos[$i];  $met=(int)$metas[$i];
                $log_por1[$i]=$inscr/$met;
                $log_por[$i]=round($log_por1[$i]*100);
                $log_porT=$log_por[$i]+$log_porT;
                 if ($log_por1[$i] < 0.3 ){  $col[$i]="#C42DC9"; //morado
                 }else if($log_por1[$i]>=0.311111 and $log_por1[$i] < 0.6 ){  $col[$i]="#FF8C00"; //naranja
                 }else if($log_por1[$i]>=0.611111 and $log_por1[$i] < 0.89999999 ){ $col[$i]="#FAFA05"; //amarillo
                 }else if($log_por1[$i]>= 0.9  ){ $col[$i]="#05FA5B"; //verde
                 }else if($log_por1[$i]>= 0.599999999 and $log_por1[$i] < 0.89999999 ){ $col[$i]="#E9E322"; //amarillo
                 }else if($log_por1[$i]>= 0.9 and $log_por1[$i] < 0.9999999 ){ $col[$i]="#FAFA03";//amarillo
                 }else if($log_por1[$i]>= 1  ){  $col[$i]="#08A408"; } //verde
        }
        
        

        //INSCRITOS TOTALES (FECHA DIA)
         $inscritos_tot[$i]=$c_Odata->ObtenerInscritosDia($codigocarrera[$i],$codigoperiodo,'conteo',$nuevafecha);
         $inscritos_totT=$inscritos_tot[$i]+$inscritos_totT;

         //%INSCRIPCION PERIODO_AN/PERIODO_ACT
         $inscr_por[$i]=0;
         if ($inscritos_tot[$i]!=0 or $inscritos_tot[$i]==''){
                $inscr=(int)$inscritos[$i];
                $inscritos_totales1=(int)$inscritos_tot[$i];
                $inscr_pord=$inscr/$inscritos_totales1-1;
                $inscr_por1[$i]=$inscr_pord;
                $inscr_por[$i]=round($inscr_pord*100);
                $inscr_porT=$inscr_por[$i]+$inscr_porT;
                if ($inscr_por1[$i] <= -0.2 ){ $col1[$i]="#C42DC9";
                }else if($inscr_por1[$i]=0 and $inscr_por1[$i] <= -0.1 ){ $col1[$i]="#E1F503";
                }else if($inscr_por1[$i]>=0){ $col1[$i]="#0CB517";
                }else if($inscr_por1[$i]> -0.1 and $inscr_por1[$i] <= -0.2 ){ $col1[$i]="#F5E503"; }
         }     
         
         
         //INSCRITOS NO EVALUADOS
         $InsNoEva[$i]=$c_Odata->ObtenerDatosCuentaOperacionPrincipalInscritosNoEvaluado($codigoperiodo,$codigocarrera[$i],'','conteo');
         $InsNoEvaT=$InsNoEva[$i]+$InsNoEvaT;

         //%INSCRITOS NO EVALUADOS
         $inscr_noeva[$i]=0;
         if ($inscritos[$i]!=0 or $inscritos[$i]==''){
            $inscr=(int)$inscritos[$i];
            $InsNoE=(int)$InsNoEva[$i];
            $inscr_noeva[$i]=round($InsNoE/$inscr*100);
         }
          $inscr_noevaT=$inscr_noeva[$i]+$inscr_noevaT;

       //LISTA EN ESPERA
        $LitaEspera[$i]=$c_Odata->ObtenerDatosListaEnEspera($codigoperiodo,$codigocarrera[$i],'conteo');
        $LitaEsperaT=$LitaEspera[$i]+$LitaEsperaT;
        
      //EVALUADOS NO ADMITIDOS
        $EvaNoAdmi[$i]=$c_Odata->ObtenerDatosCuentaOperacionPrincipalEvaluadosNoAdmitidos($codigoperiodo,$codigocarrera[$i],153,'conteo'); 
        $EvaNoAdmiT=$EvaNoAdmi[$i]+$EvaNoAdmiT;

      //ADMITIDOS NO MATRICULADOS
        $AdminNoMatr[$i]=$c_Odata->seguimiento_inscripcionvsmatriculadosnuevos($codigocarrera[$i],'conteo');
        $AdminNoMatrT=$AdminNoMatr[$i]+$AdminNoMatrT;

      //ADMITIDOS NO INGRESARON
        $AdminNoIng[$i]=$c_Odata->ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron($codigoperiodo,$codigocarrera[$i],153,'conteo',null);;
        $AdminNoIngT=$AdminNoIng[$i]+$AdminNoIngT;	
                
     //MATRICULADOS NUEVOS EN SALA
        $matri_nuevos[$i]=$c_Odata->obtener_datos_estudiantes_matriculados_nuevos($codigocarrera[$i],'conteo');
        $matri_nuevosT=$matri_nuevos[$i]+$matri_nuevosT;	

     //METAS MATRICULADOS
        $metas_matri[$i]=$c_Odata->ObtenerMetasMatri($codigocarrera[$i],$codigoperiodo,'conteo');
        if (empty($metas_matri[$i])) $metas_matri[$i]=0;
        $metas_matriT=$metas_matri[$i]+$metas_matriT;

        //HEMOS LOGRADO METAS MATRICULADOS
        $log_por_mat[$i]=0;
        if ($metas_matri[$i]!=0 or $metas_matri[$i]==''){

             $matnuevo=(int)$matri_nuevos[$i];
             $met_matri=(int)$metas_matri[$i];
             $log_por_mat1[$i]=$matnuevo/$met_matri;
             $log_por_mat[$i]=round($log_por_mat1[$i]*100);
            $log_por_matT=$log_por_mat[$i]+$log_por_matT;
            if ($log_por_mat1[$i] < 0.3 ){  $col2[$i]="#C42DC9";
            }else if($log_por_mat1[$i]>=0.311111 and $log_por_mat1[$i] < 0.6 ){ $col2[$i]="#E4E81F";
            }else if($log_por_mat1[$i]>=0.611111 and $log_por_mat1[$i] < 0.89999999 ){ $col2[$i]="#FAFA05";
            }else if($log_por_mat1[$i]>= 0.9  ){ $col2[$i]="#05FA5B";
            }else if($log_por_mat1[$i]>= 0.599999999 and $log_por_mat1[$i] < 0.89999999 ){ $col2[$i]="#E9E322";
            }else if($log_por_mat1[$i]>= 0.9 and $log_por_mat1[$i] < 0.9999999 ){ $col2[$i]="#FAFA03";
            }else if($log_por_mat1[$i]>= 1  ){ $col2[$i]="#08A408"; }
        }    
        
         

        //MATRICULADOS TOTALES AÑO ATRAS
        $total_matri_ac[$i]=$c_Odata->ObtenerMatriculadosDia($codigocarrera[$i],$codigoperiodo,'conteo',$nuevafecha);
        $total_matri_acT=$total_matri_ac[$i]+$total_matri_acT;   

        //% MATRICULADOS PERIODO_ANT PERIO_ACTUAL
        $matvs[$i]=$matri_nuevos[$i]/$total_matri_ac[$i]-1;
        $matvs_por[$i]=round($matvs[$i]*100);
        $matvs_porT=$matvs_por[$i]+$matvs_porT;

        if ($matvs[$i] <= -0.2 ){ $col3[$i]="#C42DC9";
        }else if($matvs[$i]=0 and $matvs[$i] <= -0.1 ){ $col3[$i]="#E1F503";
        }else if($matvs[$i]>=0){ $col3[$i]="#0CB517";
        }else if($matvs[$i]> -0.1 and $matvs[$i] <= -0.2 ){ $col3[$i]="#F5E503"; }

       // $total_matri_an[$i]=$c_Odata_ant->obtener_total_matriculados($codigocarrera[$i],'conteo');
       //$total_matri_anT=$total_matri_an[$i]+$total_matri_anT;

        //MATRICULADOS ANTIGUOS
        $matri_antiguo[$i]=$c_Odata->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($codigocarrera[$i],20,'conteo');
        $matri_antiguoT=$matri_antiguo[$i]+$matri_antiguoT;

       //MATRICULADOS TOTAL
        $total_matri[$i]=$c_Odata->obtener_total_matriculados_real($codigocarrera[$i],'conteo');
        $total_matriT=$total_matri[$i]+$total_matriT; 

        $i++; 
        }//termina el for
    }else{
        $i=0;

        foreach($F_data1 as $dataF){
           // var_dump($dataF);
             $codigocarrera[$i]=$dataF['codigocarrera'];
	     $nombre[$i]=$dataF['nombrecarrera'];
             $interesados[$i]=$dataF['interesados'];
	     $interesadosT=$interesados[$i]+$interesadosT;
             $aspirantes[$i]=$dataF['aspirantes'];
	     $aspirantesT=$aspirantes[$i]+$aspirantesT;
             $inscritos[$i]=$dataF['inscritos'];
	     $inscritosT=$inscritos[$i]+$inscritosT;
             $metas[$i]=$dataF['meta_inscritos'];
	     $metasT=$metas[$i]+$metasT;
             $log_por[$i]=$dataF['logros'];
             
             $log_por1[$i]=$log_por[$i]/100;

             if ($log_por1[$i] < 0.3 ){  $col[$i]="#C42DC9";
                 }else if($log_por1[$i]>=0.311111 and $log_por1[$i] < 0.6 ){  $col[$i]="#E4E81F";
                 }else if($log_por1[$i]>=0.611111 and $log_por1[$i] < 0.89999999 ){ $col[$i]="#FAFA05";
                 }else if($log_por1[$i]>= 0.9  ){ $col[$i]="#05FA5B";
                 }else if($log_por1[$i]>= 0.599999999 and $log_por1[$i] < 0.89999999 ){ $col[$i]="#E9E322";
                 }else if($log_por1[$i]>= 0.9 and $log_por1[$i] < 0.9999999 ){ $col[$i]="#FAFA03";
                 }else if($log_por1[$i]>= 1  ){  $col[$i]="#08A408"; } 
                 
	     $log_porT=$log_por[$i]+$log_porT;
             $inscritos_tot[$i]=$dataF['inscritos_totales'];
	     $inscritos_totT=$inscritos_tot[$i]+$inscritos_totT;
             $inscr_por[$i]=$dataF['inscripcion_p1_p2'];
             
              $inscr_por1[$i]=$inscr_por[$i]/100;				 
              if ($inscr_por1[$i] <= -0.2 ){ $col1[$i]="#C42DC9";
                }else if($inscr_por1[$i]=0 and $inscr_por1[$i] <= -0.1 ){ $col1[$i]="#E1F503";
                }else if($inscr_por1[$i]>=0){ $col1[$i]="#0CB517";
                }else if($inscr_por1[$i]> -0.1 and $inscr_por1[$i] <= -0.2 ){ $col1[$i]="#F5E503"; }
                
	     $inscr_porT=$inscr_por[$i]+$inscr_porT;
             $InsNoEva[$i]=$dataF['inscritos_no_evaluados'];
	     $InsNoEvaT=$InsNoEva[$i]+$InsNoEvaT;
             $inscr_noeva[$i]=$dataF['por_inscritos_no_evaluados'];
	     $inscr_noevaT=$inscr_noeva[$i]+$inscr_noevaT;
             $LitaEspera[$i]=$dataF['lista_espera'];
             $LitaEsperaT=$LitaEspera[$i]+$LitaEsperaT;
             $EvaNoAdmi[$i]=$dataF['evaluados_no_adminitdos'];
             $EvaNoAdmiT=$EvaNoAdmi[$i]+$EvaNoAdmiT;
             $AdminNoMatr[$i]=$dataF['admitidos_no_matriculados'];
             $AdminNoMatrT=$AdminNoMatr[$i]+$AdminNoMatrT;
             $AdminNoIng[$i]=$dataF['administos_no_ingresaron'];
             $AdminNoIngT=$AdminNoIng[$i]+$AdminNoIngT;
             $matri_nuevos[$i]=$dataF['matriculados_nuevos_sala'];
             $matri_nuevosT=$matri_nuevos[$i]+$matri_nuevosT;
             $metas_matri[$i]=$dataF['meta_matriculados'];
             $metas_matriT=$metas_matri[$i]+$metas_matriT;
             $log_por_mat[$i]=$dataF['logros2'];
             
            $log_por_mat1[$i]=$log_por_mat[$i]/100;
            if ($log_por_mat1[$i] < 0.3 ){  $col2[$i]="#C42DC9";
            }else if($log_por_mat1[$i]>=0.311111 and $log_por_mat1[$i] < 0.6 ){ $col2[$i]="#E4E81F";
            }else if($log_por_mat1[$i]>=0.611111 and $log_por_mat1[$i] < 0.89999999 ){ $col2[$i]="#FAFA05";
            }else if($log_por_mat1[$i]>= 0.9  ){ $col2[$i]="#05FA5B";
            }else if($log_por_mat1[$i]>= 0.599999999 and $log_por_mat1[$i] < 0.89999999 ){ $col2[$i]="#E9E322";
            }else if($log_por_mat1[$i]>= 0.9 and $log_por_mat1[$i] < 0.9999999 ){ $col2[$i]="#FAFA03";
            }else if($log_por_mat1[$i]>= 1  ){ $col2[$i]="#08A408"; }
            
             $log_por_matT=$log_por_mat[$i]+$log_por_matT;
             $total_matri_ac[$i]=$dataF['matriculados_periodo'];
             $total_matri_acT=$total_matri_ac[$i]+$total_matri_acT;              
             $matvs_por[$i]=$dataF['matriculados_p1_p2'];
             
             $matvs[$i]=$matvs_por[$i]/100;			
             if ($matvs[$i] <= -0.2 ){ $col3[$i]="#C42DC9";
                }else if($matvs[$i]=0 and $matvs[$i] <= -0.1 ){ $col3[$i]="#E1F503";
                }else if($matvs[$i]>=0){ $col3[$i]="#0CB517";
                }else if($matvs[$i]> -0.1 and $matvs[$i] <= -0.2 ){ $col3[$i]="#F5E503"; }
        
             $matvs_porT=$matvs_por[$i]+$matvs_porT;
             $matri_antiguo[$i]=$dataF['matriculados_antiguos'];
             $matri_antiguoT=$matri_antiguo[$i]+$matri_antiguoT;
             $total_matri[$i]=$dataF['matriculados_totales'];    
             $total_matriT=$total_matri[$i]+$total_matriT; 
             $i++;
         }
    }
 
   //echo $reg_carrera->GetMenu2('codigocarrera',$data2[0]['codigocarrera'],false,false,1,' '.$onc.' name="codigocarrera"  id="codigocarrera"  style="width:150px;"')
 ?>
<script type="text/javascript">

function popup(){
 link = window.open('grafica_insc_matri.php?codigoperiodo=<?php echo $codigoperiodo ?>&modalidad=<?php echo $val ?>',"Link","toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=0,width=800,height=300,left=80,top=180");

}

</script>
<div id="demo">
<a href="#" class="submit" tabindex="4" onclick='excel()' >Exportar</a>   
&nbsp;&nbsp;
<a href="javascript:popup()" class="submit" tabindex="4" >Grafica Inscritos vs Matriculados</a>
<br><br>
<center><b>Periodo <?php echo $codigoperiodo ?></b></center>
<table cellpadding="0" cellspacing="0" border="1" class="display" id='customers' style=" font-size: 10px" width="100%">
    <thead>
        <th>Programa</th>
        <th>Interesados</th>
        <th>Aspirantes</th>
        <th>Inscritos</th>
        <th>Metas Inscri</th>
        <th>Hemos Logrado</th>
        <th>Inscritos <?php echo $periodo_ant ?> Totales <?php echo $nuevafecha ?></th>
        <th>% Inscripcion <?php echo $codigoperiodo ?>  Vs  <?php echo $periodo_ant ?> </th>
        <th>Inscri No Evaluados</th>
        <th>% de Inscri no Evaluados</th>
        <th>Lista en Espera</th>
        <th>Evaluados no Adminitidos</th>
        <th>Admitidos no matriculados</th>
        <th>Admitidos que no ingresaron</th>
        <th>Matriculados Nuevos SALA</th>
        <th>Meta MAtriculados</th>
        <th>Hemos logrado un %</th>
        <th>Matriculados <?php echo $codigoperiodo ?> Totales <?php echo $nuevafecha ?></th>
        <th>% Matriculados <?php echo $codigoperiodo ?> Vs <?php echo $periodo_ant ?></th>
        <!--<th>Matriculados <?php echo $periodo_ant ?> Totales</th>-->
        <th>Matriculados Antiguos</th>
        <th>Matriculados Total</th>
    </thead>
    <tbody>
    <?php
        $i=0;
        foreach($data_in as $dt){    
            ?>
                <tr>
                    <td><?php echo $nombre[$i]; ?><input type="hidden" name="carrera[<?php echo $i ?>]" id="carrera_<?php echo $i ?>" value="<?php echo $codigocarrera[$i] ?>" ></td>
                    <td><?php echo $interesados[$i]; ?><input type="hidden" name="interesados1[<?php echo $i ?>]" id="interesados1_<?php echo $i ?>" value="<?php echo $interesados[$i] ?>" ></td>
                    <td><?php echo $aspirantes[$i]; ?><input type="hidden" name="aspirante1[<?php echo $i ?>]" id="aspirante1_<?php echo $i ?>" value="<?php echo $aspirantes[$i] ?>" ></td>
                    <td><?php echo $inscritos[$i];?><input type="hidden" name="inscritos1[<?php echo $i ?>]" id="inscritos1_<?php echo $i ?>" value="<?php echo $inscritos[$i] ?>" ></td>
                    <td><?php echo $metas[$i]; ?><input type="hidden" name="metas[<?php echo $i ?>]" id="metas_<?php echo $i ?>" value="<?php echo $metas[$i] ?>" ></td>
                    <td style="background-color: <?php echo $col[$i] ?>"><?php echo $log_por[$i].'%' ?><input type="hidden" name="log_por[<?php echo $i ?>]" id="log_por_<?php echo $i ?>" value="<?php echo $log_por[$i] ?>" ></td>
                    <td><?php echo $inscritos_tot[$i];?><input type="hidden" name="instot[<?php echo $i ?>]" id="instot_<?php echo $i ?>" value="<?php echo $inscritos_tot[$i] ?>" ></td>
                    <td style="background-color: <?php echo $col1[$i]?>"><?php echo $inscr_por[$i].'%' ?><input type="hidden" name="inspor[<?php echo $i ?>]" id="inspor_<?php echo $i ?>" value="<?php echo $inscr_por[$i] ?>" ></td>
                    <td><?php echo $InsNoEva[$i]; ?><input type="hidden" name="insnoeva[<?php echo $i ?>]" id="insnoeva_<?php echo $i ?>" value="<?php echo $InsNoEva[$i] ?>" ></td>
                    <td><?php echo $inscr_noeva[$i].'%' ?><input type="hidden" name="ins_noeva[<?php echo $i ?>]" id="ins_noeva_<?php echo $i ?>" value="<?php echo $inscr_noeva[$i] ?>" ></td>
                    <td><?php echo $LitaEspera[$i]; ?><input type="hidden" name="litaespera[<?php echo $i ?>]" id="litaespara_<?php echo $i ?>" value="<?php echo $LitaEspera[$i] ?>"></td>
                    <td><?php echo $EvaNoAdmi[$i]; ?><input type="hidden" name="evanoadmin[<?php echo $i ?>]" id="evanoadmin_<?php echo $i ?>" value="<?php echo $EvaNoAdmi[$i] ?>" ></td>
                    <td><?php echo $AdminNoMatr[$i]; ?><input type="hidden" name="adminnomatr[<?php echo $i ?>]" id="adminnomatr_<?php echo $i ?>" value="<?php echo $AdminNoMatr[$i] ?>" ></td>
                    <td><?php echo $AdminNoIng[$i]; ?><input type="hidden" name="adminnoing[<?php echo $i ?>]" id="adminnoing_<?php echo $i ?>" value="<?php echo $AdminNoIng[$i] ?>" ></td>
                    <td><?php echo $matri_nuevos[$i];?><input type="hidden" name="matri_nuevos[<?php echo $i ?>]" id="matri_nuevos<?php echo $i ?>" value="<?php echo $matri_nuevos[$i] ?>" ></td>
                    <td><?php echo $metas_matri[$i]; ?><input type="hidden" name="metas_matri[<?php echo $i ?>]" id="metas_matri<?php echo $i ?>" value="<?php echo $metas_matri[$i] ?>" ></td>
                    <td style="background-color: <?php echo $col2[$i]?>"><?php echo $log_por_mat[$i].'%' ?><input type="hidden" name="log_por_mat[<?php echo $i ?>]" id="log_por_mat<?php echo $i ?>" value="<?php echo $log_por_mat[$i] ?>" ></td>
                    <td><?php echo $total_matri_ac[$i]; ?><input type="hidden" name="total_matri_ac[<?php echo $i ?>]" id="total_matri_ac<?php echo $i ?>" value="<?php echo $total_matri_ac[$i] ?>" ></td>
                    <td style="background-color: <?php echo $col3[$i]?>"><?php echo $matvs_por[$i].'%' ?><input type="hidden" name="matvs_por[<?php echo $i ?>]" id="matvs_por<?php echo $i ?>" value="<?php echo $matvs_por[$i] ?>" ></td>
              <!--  <td><?php// echo $total_matri_an[$i]; ?><input type="hidden" name="total_matri_an[<?php echo $i ?>]" id="total_matri_an<?php echo $i ?>" value="<?php echo $total_matri_an[$i] ?>" ></td>-->
                    <td><?php echo $matri_antiguo[$i];?><input type="hidden" name="matri_anti[<?php echo $i ?>]" id="matri_anti<?php echo $i ?>" value="<?php echo $matri_antiguo[$i] ?>" ></td>
                    <td><?php echo $total_matri[$i]; ?><input type="hidden" name="total_matri[<?php echo $i ?>]" id="total_matri<?php echo $i ?>" value="<?php echo $total_matri[$i] ?>" ></td>
                </tr>
            <?php
            $i++;
        }
    ?>
    <tr>
        <td><b><center>TOTAL</center></b></td>
        <td><b><center><?php echo $interesadosT?></center></b></td>
        <td><b><center><?php echo $aspirantesT?></center></b></td>
        <td><b><center><?php echo $inscritosT?></center></b></td>
        <td><b><center><?php echo $metasT?></center></b></td>
        <td><b><center><?php echo $log_porT?></center></b></td>
        <td><b><center><?php echo $inscritos_totT?></center></b></td>
        <td><b><center><?php echo $inscr_porT?></center></b></td>
        <td><b><center><?php echo $InsNoEvaT?></center></b></td>
        <td><b><center><?php echo $inscr_noevaT?></center></b></td>
        <td><b><center><?php echo $LitaEsperaT?></center></b></td>
        <td><b><center><?php echo $EvaNoAdmiT?></center></b></td>
        <td><b><center><?php echo $AdminNoMatrT?></center></b></td>
        <td><b><center><?php echo $AdminNoIngT?></center></b></td>
        <td><b><center><?php echo $matri_nuevosT?></center></b></td>
        <td><b><center><?php echo $metas_matriT?></center></b></td>
        <td><b><center><?php echo $log_por_matT?></center></b></td>
        <td><b><center><?php echo $total_matri_acT ?></center></b></td>
        <td><b><center><?php echo $matvs_porT ?></center></b></td>
        <!--<td><b><center><?php echo $total_matri_anT ?></center></b></td>-->
        <td><b><center><?php echo $matri_antiguoT ?></center></b></td>
        <td><b><center><?php echo $total_matriT?></center></b></td>
    </tr>
    </tbody>
</table></div>
<div id="demo2" style=" display: none">
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
<table cellpadding="0" cellspacing="0" border="1" class="display" id='customers2' style=" font-size: 10px" width="100%">
    <tr>
        <td>Programa</td>
        <td>Interesados</td>
        <td>Aspirantes</td>
        <td>Inscritos</td>
        <td>Metas Inscritos <?php echo $codigoperiodo ?></td>
        <td>Hemos Logrado</td>
        <td>Inscritos <?php echo $periodo_ant ?> Totales <?php echo $nuevafecha ?></td>
        <td>% Inscripcion <?php echo $codigoperiodo ?>  Vs  <?php echo $periodo_ant ?> </td>
        <td>Inscritos No Evaluados</td>
        <td>% de Inscritos no Evaluados</td>
        <td>Lista en Espera</td>
        <td>Evaluados no Adminitidos</td>
        <td>Admitidos no matriculados</td>
        <td>Admitidos que no ingresaron</td>
        <td>Matriculados Nuevos SALA</td>
        <td>Meta MAtriculados <?php echo $codigoperiodo ?></td>
        <td>Hemos logrado un %</td>
        <td>Matriculados <?php echo $codigoperiodo ?> Totales <?php echo $nuevafecha ?></td>
        <td>% Matriculados <?php echo $codigoperiodo ?> Vs <?php echo $periodo_ant ?></td>
        <!--<td>Matriculados <?php echo $periodo_ant ?> Totales</td>-->
        <td>Matriculados Antiguos</td>
        <td>Matriculados Total</td>
    </t>
    <tbody>
    <?php
        $i=0;
        foreach($data_in as $dt){    
            ?>
                <tr>
                    <td><?php echo $nombre[$i]; ?></td>
                    <td><?php echo $interesados[$i]; ?></td>
                    <td><?php echo $aspirantes[$i]; ?></td>
                    <td><?php echo $inscritos[$i];?></td>
                    <td><?php echo $metas[$i]; ?></td>
                    <td style="background-color: <?php echo $col[$i] ?>"><?php echo $log_por[$i].'%' ?></td>
                    <td><?php echo $inscritos_tot[$i];?></td>
                    <td style="background-color: <?php echo $col1[$i]?>"><?php echo $inscr_por[$i].'%' ?></td>
                    <td><?php echo $InsNoEva[$i]; ?></td>
                    <td><?php echo $inscr_noeva[$i].'%' ?></td>
                    <td><?php echo $LitaEspera[$i]; ?></td>
                    <td><?php echo $EvaNoAdmi[$i]; ?></td>
                    <td><?php echo $AdminNoMatr[$i]; ?></td>
                    <td><?php echo $AdminNoIng[$i]; ?></td>
                    <td><?php echo $matri_nuevos[$i];?></td>
                    <td><?php echo $metas_matri[$i]; ?></td>
                    <td style="background-color: <?php echo $col2[$i]?>"><?php echo $log_por_mat[$i].'%' ?></td>
                    <td><?php echo $total_matri_ac[$i]; ?></td>
                    <td style="background-color: <?php echo $col3[$i]?>"><?php echo $matvs_por[$i].'%' ?></td>
              <!--  <td><?php// echo $total_matri_an[$i]; ?></td>-->
                    <td><?php echo $matri_antiguo[$i];?></td>
                    <td><?php echo $total_matri[$i]; ?></td>
                </tr>
            <?php
            $i++;
        }
    ?>
    <tr>
        <td><b><center>TOTAL</center></b></td>
        <td><b><center><?php echo $interesadosT?></center></b></td>
        <td><b><center><?php echo $aspirantesT?></center></b></td>
        <td><b><center><?php echo $inscritosT?></center></b></td>
        <td><b><center><?php echo $metasT?></center></b></td>
        <td><b><center><?php echo $log_porT?></center></b></td>
        <td><b><center><?php echo $inscritos_totT?></center></b></td>
        <td><b><center><?php echo $inscr_porT?></center></b></td>
        <td><b><center><?php echo $InsNoEvaT?></center></b></td>
        <td><b><center><?php echo $inscr_noevaT?></center></b></td>
        <td><b><center><?php echo $LitaEsperaT?></center></b></td>
        <td><b><center><?php echo $EvaNoAdmiT?></center></b></td>
        <td><b><center><?php echo $AdminNoMatrT?></center></b></td>
        <td><b><center><?php echo $AdminNoIngT?></center></b></td>
        <td><b><center><?php echo $matri_nuevosT?></center></b></td>
        <td><b><center><?php echo $metas_matriT?></center></b></td>
        <td><b><center><?php echo $log_por_matT?></center></b></td>
        <td><b><center><?php echo $total_matri_acT ?></center></b></td>
        <td><b><center><?php echo $matvs_porT ?></center></b></td>
        <!--<td><b><center><?php echo $total_matri_anT ?></center></b></td>-->
        <td><b><center><?php echo $matri_antiguoT ?></center></b></td>
        <td><b><center><?php echo $total_matriT?></center></b></td>
    </tr>
    </tbody>
</table></div>

