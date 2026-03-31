<?php
include('../templates/templateObservatorio.php');
include_once ('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
//include_once ('funciones_datos.php');
 //  $db=writeHeaderBD();
// print_r($_SESSION);

   $db=writeHeader('Observatorio',true,'');
   $val=200;
   $codigomodalidadacademica=200;
  // $codigoperiodo=$_REQUEST['periodo'];
   $fecha=date('Y-m-d');
   $fecha_actu=date('Y-m-d');
  // echo $val.'-->xxx';
   $query_periodo="select * from periodo where codigoestadoperiodo in (1,3) order by codigoestadoperiodo ";
   $data_P= $db->Execute($query_periodo);
   $P_data1 = $data_P->GetArray();
   $P_total1=count($P_data1);
   
   if($P_total1>1){
       $codigoperiodo=$P_data1[1]['codigoperiodo'];
   }else{
       $codigoperiodo=$P_data1[0]['codigoperiodo'];
   }
   
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

if($F_total1==0){

   $query_carrera = "SELECT nombrecarrera, codigocarrera 
                     FROM carrera 
                     where codigomodalidadacademica='".$val."' and codigocarrera not in (1,2) and fechavencimientocarrera >= '2013-01-01 00:00:00'
                      order by 1";
   //echo $query_carrera;
   $data_in= $db->Execute($query_carrera);
   $c_Odata=new obtener_datos_matriculas($db,$codigoperiodo);
   $periodo_ant=$c_Odata->obtener_periodo_anterior2($codigoperiodo);
   $c_Odata_ant=new obtener_datos_matriculas($db,$periodo_ant);

    $fecha = date('Y-m-j');
    $nuevafecha = strtotime ( '-1 year' , strtotime ( $fecha ) ) ;
    $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
     $i=0;
    foreach($data_in as $dt){
        $interesados[$i]=0; 
$aspirantes[$i]=0;
$inscritos[$i]=0; 
$metas[$i]=0;
$log_por[$i]=0;
$inscritos_tot[$i]=0;
$inscr_por[$i]=0;
$InsNoEva[$i]=0;
$inscr_noeva[$i]=0;
$LitaEspera[$i]=0;
$EvaNoAdmi[$i]=0;
$AdminNoMatr[$i]=0;
$AdminNoIng[$i]=0; 
$matri_nuevos[$i]=0;
$metas_matri[$i]=0;
$log_por_mat[$i]=0; 
$matvs_por[$i]=0;
$matvs_por[$i]=0;
$total_matri_ac[$i]=0;
$matri_antiguo[$i]=0; 
$total_matri[$i]=0;

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
                 if ($log_por1[$i] < 0.3 ){  $col[$i]="#C42DC9";
                 }else if($log_por1[$i]>=0.311111 and $log_por1[$i] < 0.6 ){  $col[$i]="#E4E81F";
                 }else if($log_por1[$i]>=0.611111 and $log_por1[$i] < 0.89999999 ){ $col[$i]="#FAFA05";
                 }else if($log_por1[$i]>= 0.9  ){ $col[$i]="#05FA5B";
                 }else if($log_por1[$i]>= 0.599999999 and $log_por1[$i] < 0.89999999 ){ $col[$i]="#E9E322";
                 }else if($log_por1[$i]>= 0.9 and $log_por1[$i] < 0.9999999 ){ $col[$i]="#FAFA03";
                 }else if($log_por1[$i]>= 1  ){  $col[$i]="#08A408"; } 
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

           $fechacreacion = date('Y-m-d H:m:s');
           $usuariocreacion = '4186';
           $fechamodificacion = date('Y-m-d H:m:s');
           $usuariomodificacion = '4186';
           $codigoestado=100;
           $fecha_crear=date('Y-m-d');
                 
            $sql_insert="INSERT INTO `obs_admisiones_estadisticas`
                (`idobs_admisiones_estadisticas`, `codigocarrera`, `interesados`,
                `aspirantes`,`inscritos`,`meta_inscritos`,`logros`,
                `inscritos_totales`,`inscripcion_p1_p2`,`inscritos_no_evaluados`,
                `por_inscritos_no_evaluados`,`lista_espera`,`evaluados_no_adminitdos`,
                `admitidos_no_matriculados`,`administos_no_ingresaron`,`matriculados_nuevos_sala`,
                `meta_matriculados`,`logros2`,`matriculados_periodo`,`matriculados_p1_p2`,
                `matriculados_periodo_totales`,`matriculados_antiguos`,`matriculados_totales`,
                `fecha_crear`,`codigoestado`,`fechacreacion`,`usuariocreacion`,`fechamodificacion`,
                `usuariomodificacion`,`codigoperiodo`,`codigomodalidadacademica`)
                VALUES
                (
                '', ".$codigocarrera[$i].", ".$interesados[$i].", 
                ".$aspirantes[$i].",".$inscritos[$i].", ".$metas[$i].",".$log_por[$i].",
                ".$inscritos_tot[$i].",".$inscr_por[$i].",".$InsNoEva[$i].",
                ".$inscr_noeva[$i].",".$LitaEspera[$i].",".$EvaNoAdmi[$i].",
                ".$AdminNoMatr[$i].",".$AdminNoIng[$i].", ".$matri_nuevos[$i].",
                ".$metas_matri[$i].",".$log_por_mat[$i].", ".$matvs_por[$i].",".$matvs_por[$i].",
                ".$total_matri_ac[$i].",".$matri_antiguo[$i].", ".$total_matri[$i].",
                '".$fecha_crear."',".$codigoestado.",'".$fechacreacion."','".$usuariocreacion."','".$fechamodificacion."',
                '".$usuariomodificacion."','".$codigoperiodo."',".$codigomodalidadacademica.")";
               // $data_ins= $db->Execute($sql_insert);
                if($inserta= &$db->Execute($sql_insert)===false){
                                    echo 'Error En el SQL Insert O Consulta....'.$sql_insert.'<br>';   
                }
               // echo $sql_insert;
                
        $i++; 
        
        }//termina el for
    }
  ?>
