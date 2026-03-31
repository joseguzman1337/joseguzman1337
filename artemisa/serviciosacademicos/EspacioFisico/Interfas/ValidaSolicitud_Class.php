<?php
class ValidaSolicitud{
    public function ValidarSolicitudCrear($db,$Grupo,$Sede,$FechaIni,$FechaFin,$Info,$Limit,$CodigoDia,$C_Festivo,$Solicitudes_idS=''){
        /*******************************************************************************************/
        $Resultado = array();
        $Condicion = '';
        
                for($i=0;$i<=$Limit;$i++){
                    for($x=0;$x<count($Info[$CodigoDia[$i]]);$x++){
                    /***************************************************************************************/
                     $FechaFutura_1 = $Info[$CodigoDia[$i]][$x][0];
                     $FechaFutura_2 = $Info[$CodigoDia[$i]][$x][1];
                     
                     $C_FechaData_1  = explode(' ',$FechaFutura_1);
                     $C_FechaData_2  = explode(' ',$FechaFutura_2);
                     
                     $C_DatosDia  = explode('-',$C_FechaData_1[0]);
                        
                     $dia  = $C_DatosDia[2];
                     $mes  = $C_DatosDia[1]; 
                     
                     $Festivo = $C_Festivo->esFestivo($dia,$mes);
                    
                     $Fecha  = $C_FechaData_1[0];
                     $Hora_1 = $C_FechaData_1[1];
                     $Hora_2 = $C_FechaData_2[1];
                         
                        if($Festivo==false){//$Festivo No es Festivo
                            
                            for($l=0;$l<count($Grupo);$l++){
                                /**************************************************************/
                                 $Grupo_id = $Grupo[$l];
                                 
                                 if($Solicitudes_idS){
                                    $Condicion = ' AND s.SolicitudAsignacionEspacioId NOT IN ('.$Solicitudes_idS.')';
                                 }
                                 
                                $SQL='SELECT
                                        	s.SolicitudAsignacionEspacioId AS id,
                                        	s.codigodia,
                                        	d.nombredia,
                                        	s.ClasificacionEspaciosId AS Sede,
                                        	c.Nombre,
                                            a.AsignacionEspaciosId,
                                            a.HoraInicio,
                                            a.HoraFin,
                                            a.FechaAsignacion,
                                            g.nombregrupo
        
                                        FROM
                                        	SolicitudEspacioGrupos sg
                                                                        INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
                                                                        INNER JOIN dia d ON d.codigodia = s.codigodia
                                                                        INNER JOIN ClasificacionEspacios c ON s.ClasificacionEspaciosId = c.ClasificacionEspaciosId
                                                                        INNER JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                                                                        INNER JOIN grupo g ON g.idgrupo=sg.idgrupo
                                        
                                        WHERE
                                        	sg.idgrupo = "'.$Grupo_id.'"
                                            AND s.codigoestado = 100
                                            AND a.HoraInicio="'.$Hora_1.'"
                                            AND a.HoraFin="'.$Hora_2.'"
                                            AND a.FechaAsignacion="'.$Fecha.'"
                                            AND a.codigoestado=100
                                            AND a.EstadoAsignacionEspacio=1
                                            AND s.ClasificacionEspaciosId="'.$Sede[$i].'"'.$Condicion;
                                            
                                       if($Consulta=&$db->Execute($SQL)===false){
                                            $a_vectt['val']			=false;
                                            $a_vectt['descrip']		='Error al Buscar Validacion O Dato..';
                                            echo json_encode($a_vectt);
                                            exit;   
                                       }
                                       
                                       if(!$Consulta->EOF){
                                            $Resultado['val']                        = true;
                                            $Resultado['Grupo'][$i][$x]              = $Consulta->fields['nombregrupo'];
                                            $Resultado['nombredia'][$i][$x]          = $Consulta->fields['nombredia']; 
                                            $Resultado['Sede'][$i][$x]               = $Consulta->fields['Nombre']; 
                                            $Resultado['HoraInicio'][$i][$x]         = $Consulta->fields['HoraInicio'];
                                            $Resultado['HoraFin'][$i][$x]            = $Consulta->fields['HoraFin'];
                                            $Resultado['FechaAsignacion'][$i][$x]    = $Consulta->fields['FechaAsignacion'];
                                       }else{
                                             $Resultado['val']  = false;
                                       }
                                
                                /**************************************************************/
                            }//for
                            
                                 
                         }           
                    /***************************************************************************************/
                    }//for
                }//for
        
        /*******************************************************************************************/
        
        return $Resultado;
    }//public function ValidarSolicitudCrear
    public function ValidaHorario($db,$Grupos,$Info,$Dias,$Limit,$data=''){
        
        $Num_Grupos  = count($Grupos); 
        $Grupos_id = '';
        $C_Resultado = array();
        
        //echo '<pre>';print_r($Grupos);die;
        
        for($l=0;$l<count($Grupos);$l++){
            if($l<1){ 
                $Grupos_id = '"'.$Grupos[$l].'"';
            }else{ 
                $Grupos_id = $Grupos_id.',"'.$Grupos[$l].'"';
            }
        }//for
            
        // echo '<pre>';print_r($Info);die;   
         
        if($data){
            
            //echo '<pre>';print_r($data);die;
            
            $Solicitud_id    = explode('-',$data['Solicitud_id']);
        
            for($s=1;$s<count($Solicitud_id);$s++){
                
                    $Hora_1  =  $data['HoraInicial_'.$Solicitud_id[$s]][0];
                    $Hora_2  =  $data['HoraFin_'.$Solicitud_id[$s]][0];
                    $Dia     =  $data['Dia_'.$Solicitud_id[$s]];
                
                
                 $SQL='SELECT

                                g.idgrupo,
                                g.nombregrupo,
                                d.nombredia
                        
                        FROM
                        
                                horario h INNER JOIN grupo g ON g.idgrupo=h.idgrupo
                                          INNER JOIN dia d ON h.codigodia=d.codigodia
                        
                        WHERE
                        
                                h.codigodia="'.$Dia.'"
                                AND
                                h.idgrupo IN ('.$Grupos_id.')
                                AND
                                h.horainicial="'.$Hora_1.'"
                                AND
                                h.horafinal="'.$Hora_2.'"
                                AND
                                h.codigoestado=100';
                                
                      if($Horarios=&$db->Execute($SQL)===false){
                        $a_vectt['val']			=false;
                        $a_vectt['descrip']		='Error al Buscar Validacion  del Horario...';
                        echo json_encode($a_vectt);
                        exit;   
                      } 
                      
                      if(!$Horarios->EOF){
                      
                          $C_horarios  = $Horarios->GetArray();
                          //echo '<pre>';print_r($C_horarios);die;
                          if($Num_Grupos==count($C_horarios)){
                                $C_Resultado['val']   = true;
                          }else{ 
                                $C_Resultado['val']   = false;
                                for($h=0;$h<count($C_horarios);$h++){ 
                                    $H_Grupos[]=$C_horarios[$h]['idgrupo'];                                    
                                }//for
                                
                              //echo '<pre>';print_r($H_Grupos);
                               // echo '<pre>';print_r($Grupos);
                                
                                 $Resultado_1 = array_diff($H_Grupos,$Grupos);
                                 $Resultado_2 = array_diff($Grupos,$H_Grupos);
                                 $Resultado   = array_merge($Resultado_1,$Resultado_2);
                                 
                                // echo '<pre>';print_r($Resultado);die;
                         
                                 for($j=0;$j<count($Resultado);$j++){
                                    if($j<1){ 
                                        $Grupos_id = '"'.$Resultado[$j].'"';
                                    }else{ 
                                        $Grupos_id = $Grupos_id.',"'.$Resultado[$j].'"';
                                    }
                                 }
                                 
                                 $SQL='SELECT
        
                                                g.idgrupo,
                                                g.nombregrupo,
                                                d.nombredia
                                        
                                        FROM
                                        
                                                horario h INNER JOIN grupo g ON g.idgrupo=h.idgrupo
                                                          INNER JOIN dia d ON h.codigodia=d.codigodia
                                        
                                        WHERE
                                        
                                                h.idgrupo IN ('.$Grupos_id.')
                                                AND
                                                h.codigoestado=100';
                                                
                                      if($HorariosEnviar=&$db->Execute($SQL)===false){
                                        $a_vectt['val']			=false;
                                        $a_vectt['descrip']		='Error al Buscar Validacion  del Horario...';
                                        echo json_encode($a_vectt);
                                        exit;   
                                      } 
                                      
                                      while(!$HorariosEnviar->EOF){
                                        
                                                /**********************************************/
                                                
                                                  $C_Resultado['id_grupo'][$i]     = $HorariosEnviar->fields['idgrupo'];  
                                                  $C_Resultado['nombregrupo'][$i]  = $HorariosEnviar->fields['nombregrupo'];
                                                  $C_Resultado['dia'][$i]          = $HorariosEnviar->fields['nombredia'];
                                              
                                                /**********************************************/
                                          
                                        
                                        $HorariosEnviar->MoveNext();
                                      }
                          } 
                          
                         
                      }else{ 
                            $C_Resultado['Data']   = 'Other';
                            
                            $SQL='SELECT
                                          idgrupo,
                                          nombregrupo
                                  FROM
                                          grupo 
                                  WHERE
                                    
                                          idgrupo IN ('.$Grupos_id.')';
                                          
                                  if($GruposName=&$db->Execute($SQL)===false){
                                    $a_vectt['val']			=false;
                                    $a_vectt['descrip']		='Error al Buscar Validacion  del Horario 2...';
                                    echo json_encode($a_vectt);
                                    exit; 
                                  }       
                                   
                            while(!$GruposName->EOF){ 
                                
                                  $SQL_dia='SELECT

                                                    nombredia
                                            
                                            FROM
                                            
                                                    dia
                                            
                                            WHERE
                                            
                                                    codigodia="'.$Dia.'"';
                                                    
                                          if($DiasName=&$db->Execute($SQL_dia)===false){
                                                $a_vectt['val']			=false;
                                                $a_vectt['descrip']		='Error al Buscar Validacion  del Horario 3...';
                                                echo json_encode($a_vectt);
                                                exit; 
                                          }          
                                
                                    $C_Resultado['id_grupo'][$i][]      = $GruposName->fields['idgrupo'];  
                                    $C_Resultado['nombregrupo'][$i][]   = $GruposName->fields['nombregrupo'];
                                    $C_Resultado['dia'][$i]             = $DiasName->fields['nombredia'];
                                
                                $GruposName->MoveNext();
                            }
                            
                           
                      }         
                    
                      
                 //}
                 $op=0;
                
            }//for
            
        }else{
          
                 
        for($i=0;$i<=$Limit;$i++){
            $op=1;
           $Dias[$i];
           for($x=0;$x<count($Info[$Dias[$i]]);$x++){
           // echo '<br><br>X->'.$x;
            //echo '<pre>';print_r($Info);die;
                 $FechaFutura_1 = $Info[$Dias[$i]][$x][0];
                 $FechaFutura_2 = $Info[$Dias[$i]][$x][1];
                 //echo '<pre>';print_r($FechaFutura_1);
                 $C_FechaData_1  = explode(' ',$FechaFutura_1);
                 $C_FechaData_2  = explode(' ',$FechaFutura_2);
                 
              //if($op==1){   
                    $Hora_1 = $C_FechaData_1[1];
                    $Hora_2 = $C_FechaData_2[1]; 
                    
                     /********************************************************************/
               $SQL='SELECT

                                g.idgrupo,
                                g.nombregrupo,
                                d.nombredia
                        
                        FROM
                        
                                horario h INNER JOIN grupo g ON g.idgrupo=h.idgrupo
                                          INNER JOIN dia d ON h.codigodia=d.codigodia
                        
                        WHERE
                        
                                h.codigodia="'.$Dias[$i].'"
                                AND
                                h.idgrupo IN ('.$Grupos_id.')
                                AND
                                h.horainicial="'.$Hora_1.'"
                                AND
                                h.horafinal="'.$Hora_2.'"
                                AND
                                h.codigoestado=100';
                                
                      if($Horarios=&$db->Execute($SQL)===false){
                        $a_vectt['val']			=false;
                        $a_vectt['descrip']		='Error al Buscar Validacion  del Horario...';
                        echo json_encode($a_vectt);
                        exit;   
                      } 
                      
                      if(!$Horarios->EOF){
                      
                          $C_horarios  = $Horarios->GetArray();
                          //echo '<pre>';print_r($C_horarios);die;
                          if($Num_Grupos==count($C_horarios)){
                                $C_Resultado['val']   = true;
                          }else{ 
                                $C_Resultado['val']   = false;
                                for($h=0;$h<count($C_horarios);$h++){ 
                                    $H_Grupos[]=$C_horarios[$h]['idgrupo'];                                    
                                }//for
                                
                              /*echo '<pre>';print_r($H_Grupos);
                              echo '<pre>';print_r($Grupos);die;*/
                                
                                 $Resultado_1 = array_diff($H_Grupos,$Grupos);
                                 $Resultado_2 = array_diff($Grupos,$H_Grupos);
                                 $Resultado   = array_merge($Resultado_1,$Resultado_2);
                                 
                                // echo '<pre>';print_r($Resultado);die;
                         
                                 for($j=0;$j<count($Resultado);$j++){
                                    if($j<1){ 
                                        $Grupos_id = '"'.$Resultado[$j].'"';
                                    }else{ 
                                        $Grupos_id = $Grupos_id.',"'.$Resultado[$j].'"';
                                    }
                                 }
                                 
                                 $SQL='SELECT
        
                                                g.idgrupo,
                                                g.nombregrupo,
                                                d.nombredia
                                        
                                        FROM
                                        
                                                horario h INNER JOIN grupo g ON g.idgrupo=h.idgrupo
                                                          INNER JOIN dia d ON h.codigodia=d.codigodia
                                        
                                        WHERE
                                        
                                                h.idgrupo IN ('.$Grupos_id.')
                                                AND
                                                h.codigoestado=100';
                                                
                                      if($HorariosEnviar=&$db->Execute($SQL)===false){
                                        $a_vectt['val']			=false;
                                        $a_vectt['descrip']		='Error al Buscar Validacion  del Horario...';
                                        echo json_encode($a_vectt);
                                        exit;   
                                      } 
                                      
                                      while(!$HorariosEnviar->EOF){
                                        
                                                /**********************************************/
                                                
                                                  $C_Resultado['id_grupo'][$i]     = $HorariosEnviar->fields['idgrupo'];  
                                                  $C_Resultado['nombregrupo'][$i]  = $HorariosEnviar->fields['nombregrupo'];
                                                  $C_Resultado['dia'][$i]          = $HorariosEnviar->fields['nombredia'];
                                              
                                                /**********************************************/
                                          
                                        
                                        $HorariosEnviar->MoveNext();
                                      }
                          } 
                          
                          //echo '<pre>';print_r($C_Resultado);
                          
                         return $C_Resultado;
                      }else{ 
                            $C_Resultado['Data']   = 'Other';
                            
                            $SQL='SELECT
                                          idgrupo,
                                          nombregrupo
                                  FROM
                                          grupo 
                                  WHERE
                                    
                                          idgrupo IN ('.$Grupos_id.')';
                                          
                                  if($GruposName=&$db->Execute($SQL)===false){
                                    $a_vectt['val']			=false;
                                    $a_vectt['descrip']		='Error al Buscar Validacion  del Horario 2...';
                                    echo json_encode($a_vectt);
                                    exit; 
                                  }       
                                   
                            while(!$GruposName->EOF){ 
                                
                                  $SQL_dia='SELECT

                                                    nombredia
                                            
                                            FROM
                                            
                                                    dia
                                            
                                            WHERE
                                            
                                                    codigodia="'.$Dias[$i].'"';
                                                    
                                          if($DiasName=&$db->Execute($SQL_dia)===false){
                                                $a_vectt['val']			=false;
                                                $a_vectt['descrip']		='Error al Buscar Validacion  del Horario 3...';
                                                echo json_encode($a_vectt);
                                                exit; 
                                          }          
                                
                                    $C_Resultado['id_grupo'][$i][]      = $GruposName->fields['idgrupo'];  
                                    $C_Resultado['nombregrupo'][$i][]   = $GruposName->fields['nombregrupo'];
                                    $C_Resultado['dia'][$i]             = $DiasName->fields['nombredia'];
                                
                                $GruposName->MoveNext();
                            }
                            
                           
                      }         
                    
                      
                 //}
                 $op=0;
                
                 /********************************************************************/
           }//for
            
        }//for
            
            
        }//if 
     //echo '<pre>';print_r($C_Resultado);
          
        return $C_Resultado;
    }//public function ValidaHorario
}//class
?>