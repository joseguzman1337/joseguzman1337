<?php
  
  include("../templates/template.php");
		
  $db = getBD();
  
  
  $SQL='SELECT
	m.MotorSolicitudEspacioId AS id,
	m.SolicitudPadreId AS idSoli,
	m.TipoBuscar,
	m.UsuarioCreacion,
	aso.SolicitudAsignacionEspaciosId,
  a.AsignacionEspaciosId
FROM
	MotorSolicitudEspacio m
INNER JOIN AsociacionSolicitud aso ON aso.SolicitudPadreId = m.SolicitudPadreId
INNER JOIN AsignacionEspacios a ON  a.SolicitudAsignacionEspacioId=aso.SolicitudAsignacionEspaciosId
WHERE
	m.codigoestado = 100
AND m.Estado = 1
AND a.ClasificacionEspaciosId=212
AND a.codigoestado=100

GROUP BY m.SolicitudPadreId';
  
  if($Solicitudes=&$db->GetAll($SQL)===false){
        echo 'Error en el SQL ....'.$SQL;
        die;
  }     
  
  
  //echo '<pre>';print_r($Solicitudes);
  /***************************************/
  echo 'Num->'.$Count = count($Solicitudes);
  
  if($Count>=1){
    
    for($i=0;$i<$Count;$i++){
        echo '<br><br>i->'.$i;
       // echo '<pre>';print_r($Solicitudes[$i]);
        $id         = $Solicitudes[$i]['idSoli'];
        $TipoBuscar = $Solicitudes[$i]['TipoBuscar'];
        $userid     = $Solicitudes[$i]['UsuarioCreacion'];
        
          $SQL='SELECT
                SolicitudAsignacionEspaciosId
                FROM
                AsociacionSolicitud a INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspaciosId
                
                WHERE
                a.SolicitudPadreId="'.$id.'"
                AND
                s.codigoestado=100';
                
          if($SolicitudHijos=&$db->GetAll($SQL)===false){
                echo 'Error en el SQL de Buscar Hijos SOlicitud...<br><br>'.$SQL;
                die;
          }   
          
          for($j=0;$j<count($SolicitudHijos);$j++){
          /*******************************************************/
          $Hijos = $SolicitudHijos[$j]['SolicitudAsignacionEspaciosId'];
               echo '<br><br>Padre->'.$id.'->'.$Hijos;
               
               $SQL_Salon='SELECT
        	                    codigotiposalon
                            FROM
                            	SolicitudAsignacionEspaciostiposalon
                            WHERE
                            	SolicitudAsignacionEspacioId = "'.$Hijos.'"';
                                
                if($Salon=&$db->Execute($SQL_Salon)===false){
                    Echo 'Error en el SQL del Salon....<br><br>'.$SQL_Salon;
                    die;
                } 
                
                $C_Salon = '';
                
                if(!$Salon->EOF){
                    
                    while(!$Salon->EOF){
                            $C_Salon[] = $Salon->fields['codigotiposalon'];
                        $Salon->MoveNext();
                    }//while
                    
                }else{
                    $C_Salon[]=0;
                }
               
                 
                $SQL='SELECT
                    
                            AccesoDiscapacitados,
                            FechaInicio,
                            FechaFinal,
                            ClasificacionEspaciosId AS sede
                        FROM
                        
                            SolicitudAsignacionEspacios
                        
                        WHERE
                        
                            SolicitudAsignacionEspacioId="'.$Hijos.'"
                            AND
                            codigoestado=100';  
                        
               if($Datos=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL de Dotos de la Solicitud....<br><br>'.$SQL;
                    die;
               } 
               
               $Acceso      = $Datos->fields['AccesoDiscapacitados'];       
               $FechaInicio = $Datos->fields['FechaInicio'];
               $FechaFinal  = $Datos->fields['FechaFinal'];
               $Campus      = $Datos->fields['sede'];
               
               /****************Verificar Si tiene Salon**********************/
               $SQL_Asignacion='SELECT
                                	AsignacionEspaciosId AS id,
                                	FechaAsignacion,
                                	HoraInicio,
                                	HoraFin
                                FROM
                                	AsignacionEspacios
                                WHERE
                                	SolicitudAsignacionEspacioId = "'.$Hijos.'"
                                AND ClasificacionEspaciosId = 212
                                AND codigoestado = 100
                                AND EstadoAsignacionEspacio = 1'; 
                                
                      if($Asigancion=&$db->Execute($SQL_Asignacion)===false){
                            echo 'Error en el SQL data Asignacion....<br><br>'.$SQL_Asignacion;
                            die;
                      } 
                if(!$Asigancion->EOF){
                            //echo '<br><br><span style="color: blue;">Solicitud Padre->'.$id.', y Detalle '.$Hijos.' Ya tiene Asigancion</span>';echo '';
                        
                        
                       // echo '<br><br>llego...';
                      
                      $C_Asignacion = $Asigancion->GetArray();
                     /***************Buscar Grupos*************************/
                     
                     $SQL='SELECT
                            	sg.idgrupo,
                            	m.codigocarrera
                            FROM
                            	SolicitudEspacioGrupos sg
                            INNER JOIN grupo g ON g.idgrupo = sg.idgrupo
                            INNER JOIN materia m ON m.codigomateria = g.codigomateria
                            WHERE
                            	SolicitudAsignacionEspacioId = "'.$Hijos.'"
                            AND codigoestado = 100';
        
                        if($Grupos=&$db->Execute($SQL)===false){
                            echo 'Error en el SQL de los Grupos...<br><br>'.$SQL;
                            die;
                        }   
                        
                        $Carrera = $Grupos->fields['codigocarrera'];
                        
                        if(!$Grupos->EOF){
                            $x=1;
                            while(!$Grupos->EOF){
                                    if($x==1){
                                        $C_Grupos = '"'.$Grupos->fields['idgrupo'].'"';   
                                    }else{
                                        $C_Grupos = $C_Grupos.',"'.$Grupos->fields['idgrupo'].'"';
                                    }
                                    $x++;
                                $Grupos->MoveNext();
                            }//while
                        } 
                      /****************Buscar Cupos O Numero de Estudiante*****************/  
                       $SQL='SELECT

                                SUM(g.maximogrupo) AS MaxGrupo
                                
                             FROM
                                	SolicitudEspacioGrupos s INNER JOIN grupo g ON s.idgrupo=g.idgrupo
                             WHERE
                                	s.SolicitudAsignacionEspacioId = "'.$Hijos.'"
                                AND
                                s.codigoestado=100';  
                            
                      if($NumGrupo=&$db->Execute($SQL)===false){
                            echo 'Error en el SQL data de Maxi Grupo...<br>'.$SQL;
                            die;
                        }     
                        
                      $SQL='SELECT
                            	COUNT(codigoestadodetalleprematricula) AS Num
                            FROM
                            	detalleprematricula
                            WHERE
                            	idgrupo IN('.$C_Grupos.') 
                            AND codigoestadodetalleprematricula IN ("10","11","30")';
                            
                            
                      if($Prematriculados=&$db->Execute($SQL)===false){
                            echo 'Error en el SQL data de prematriculados...<br>'.$SQL;
                            die;
                        }
                        
                      $SQL='SELECT
                            	COUNT(codigoestadodetalleprematricula) AS Num
                            FROM
                            	detalleprematricula
                            WHERE
                            	idgrupo IN('.$C_Grupos.')
                            AND codigoestadodetalleprematricula IN ("40","41")';
                            
                            
                      if($Matriculados=&$db->Execute($SQL)===false){
                            echo 'Error en el SQL data de prematriculados...<br>'.$SQL;
                            die;
                        } 
                        
                      if($TipoBuscar==1){
                            $Cupo = $NumGrupo->fields['MaxGrupo'];
                      }else if($TipoBuscar==2){
                            $Cupo = $Matriculados->fields['Num'];
                      }else if($TipoBuscar==3){
                            $Cupo = $Prematriculados->fields['Num'];
                      }else if($TipoBuscar==4){
                            $Cupo = $Matriculados->fields['Num']+$Prematriculados->fields['Num'];
                      }    
                    /*********************Asignacion*********************/ 
                    
                    if(count($C_Asignacion)>=1){
                
                        echo '<br><br>aca....'.$Hijos;
                        AsigancionMaxiva($db,$Acceso,$C_Salon,$Campus,$FechaInicio,$FechaFinal,$C_Asignacion,$Cupo,$Hijos,$Carrera,$id,$userid);
                        
                       echo '<br><br>Cambio Estado->'.$SQL='UPDATE MotorSolicitudEspacio
                              SET    Estado=0
                              WHERE  SolicitudPadreId="'.$id.'"';
                              
                              if($CabiaoEstatus=&$db->Execute($SQL)===false){
                                echo 'Error en el SQL del Cambio Estatus Motor....<br><br>'.$SQL;
                                die;
                              }
                    }  
                    
               }       
          /*******************************************************/
          }//for  Hijos   
    }//for Padre
    
  }//if
  
  

  function AsigancionMaxiva($db,$Acceso,$TipoSalon,$Campus,$FechaInicio,$FechaFinal,$DataAsignacion,$Cupo,$id_Soli,$Carrera,$Padre,$userid){
    
   // echo '<br><br>$Acceso->'.$Acceso.'<br><br>$Campus->'.$Campus.'<br><br>$FechaInicio->'.$FechaInicio.'<br><br>$FechaFinal->'.$FechaFinal.'<br><br>$Cupo->'.$Cupo.'<br><br>$id_Soli->'.$id_Soli;

    include_once('../Solicitud/AsignacionSalon.php'); $C_AsignacionSalon =  new AsignacionSalon();
    include_once('../Solicitud/festivos.php'); $C_Festivo         = new festivos();
    
            $porcentaje = Porcentaje($db);
            
            //echo '<pre>';print_r($DataAsignacion);
            
            //print_r($TipoSalon);
            
            $max  = number_format(($Cupo+(($Cupo*$Porcentaje)/100)));
            $min  = $Cupo;
            
            if($Acceso==1){
                $Condicion = ' AND  x.AccesoDiscapacitados="'.$Acceso.'"';
            }else{
                $Condicion = '';
            }
            
            $SQL='SELECT 

                    idgrupo
                    
                    FROM 
                    
                    SolicitudEspacioGrupos
                    
                    WHERE
                    
                    SolicitudAsignacionEspacioId="'.$id_Soli.'"';
                    
                    if($Grupo=&$db->Execute($SQL)===false){
                        echo 'Error en el SQL del Grupo....<br><br>'.$SQL;
                        die;
                    }
       
            $Grupo   = $Grupo->fields['idgrupo'];
            
            for($i=0;$i<count($DataAsignacion);$i++){
               // echo '<br><br>3...id_soli-->'.$id_Soli;
                
                /*
                [0] => 37708
                [id] => 37708
                [1] => 2015-02-03
                [FechaAsignacion] => 2015-02-03
                [2] => 11:00:00
                [HoraInicio] => 11:00:00
                [3] => 13:00:00
                [HoraFin] => 13:00:00
                */
                
                $C_AulaSize = '';
                $Other_Aula = '';
                $fecha  = $DataAsignacion[$i]['FechaAsignacion'];
                $hora_1 = $DataAsignacion[$i]['HoraInicio'];                
                $hora_2 = $DataAsignacion[$i]['HoraFin'];
                $Sede   = $Campus;
                 
                $Fecha_horaIni = $fecha.' '.$hora_1;
                $fecha_horaFin = $fecha.' '.$hora_2;
                //echo '<pre>';print_r($Data);
                $id = $DataAsignacion[$i]['id'];
                
                $C_Fecha = explode('-',$fecha);
                $dia  = $C_Fecha[2];
                $mes  = $C_Fecha[1];
                $year = $C_Fecha[0];
                $Festivo = $C_Festivo->esFestivo($dia,$mes,$year);  
                if($Festivo==false){
                    
                $FechaQuemada = $C_AsignacionSalon->ValidaFechaQuemada($fecha);
               
               if($FechaQuemada==false){
                
                /******************************************************************/
                $Resultado = $C_AsignacionSalon->ValidacionGrupoEspacio($db,$Grupo,$fecha,$hora_1,$hora_2);
                 //echo '<pre>';print_r($Resultado);
                if($Resultado['val']==true){ 
                   
                 for($l=0;$l<count($TipoSalon);$l++){
                    if($l==0){
                        $C_TipoSalon = '"'.$TipoSalon[$l].'"';
                    }else{
                        $C_TipoSalon = $C_TipoSalon.',"'.$TipoSalon[$l].'"';
                    }
                 }
               
               
                 
               $AulasHistoricas = $C_AsignacionSalon->ConsultaEspacioHistorico($db,$fecha,$hora_1,$hora_2,$Fecha_horaIni,$fecha_horaFin,$Sede,$id_Soli,'',$Padre,$C_TipoSalon);
                
                $Cambio_N = 0;
               // echo '<br>espacio-->'.$AulasHistoricas->fields['ClasificacionEspaciosId'];
                if($AulasHistoricas->fields['ClasificacionEspaciosId']){
                    if(!$AulasHistoricas->EOF){//if Historico..
                  
                        $Cambio_N = 0; 
                           while(!$AulasHistoricas->EOF){ 
                                    /****************************************************************/
                                     $aula_id = $AulasHistoricas->fields['ClasificacionEspaciosId'];
                                     
                                        $Responsable = EspacioResponsable($db,$userid,$id_Soli);
                
                                        if($Responsable){ 
                                            
                                            $Responsable_2 = EspacioResponsable($db,$userid,'',$aula_id);
                                        
                                            if($Responsable_2){
                                        
                                                 $AulaSize = $C_AsignacionSalon->SizeEspacioFisico($db,$aula_id,$min,$max);
                                               
                                                 if($AulaSize['val']==true){
                                                    $Cambio_N=1;
                                                    $AccesoTotal = ValidaTipoSalonFinal($db,$C_TipoSalon,$AulaSize['Data'][0]['ClasificacionEspaciosId']);
                                                    if($AccesoTotal){
                                                        $C_AsignacionSalon->InsertAula($db,$id,$AulaSize['Data'][0]['ClasificacionEspaciosId'],$id_Soli);
                                                    }else{
                                                        $AccesoTotal = false;
                                                    }  
                                                   break;
                                                }
                                            }
                                        }
                                      $AulasHistoricas->MoveNext();      
                                    /****************************************************************/
                              }//while Prioridad Aula
                        
                    }
                }
              
                if($Cambio_N!=1){
                
                $AulasPriorida = $C_AsignacionSalon->ConsultarEspaciosPrivilegio($db,$fecha,$hora_1,$hora_2,$Fecha_horaIni,$fecha_horaFin,$C_TipoSalon,$Sede,$Carrera,$Condicion,1);
                $Cambio = 0;       
                if(!$AulasPriorida->EOF){//if Prioridad Aula   
                   $Cambio = 0;
                      
                             while(!$AulasPriorida->EOF){
                                /****************************************************************/
                                 $aula_id = $AulasPriorida->fields['ClasificacionEspaciosId'];
                                 
                                 $Responsable = EspacioResponsable($db,$userid,$id_Soli);
                
                                    if($Responsable){ 
                                        
                                        $Responsable_2 = EspacioResponsable($db,$userid,'',$aula_id);
                                        
                                        if($Responsable_2){
                                        
                                             $AulaSize = $C_AsignacionSalon->SizeEspacioFisico($db,$aula_id,$min,$max);
                                             
                                                 if($AulaSize['val']==true){ 
                                                    $Cambio=1;
                                                    $AccesoTotal = ValidaTipoSalonFinal($db,$C_TipoSalon,$AulaSize['Data'][0]['ClasificacionEspaciosId']);
                                                    if($AccesoTotal){
                                                        $C_AsignacionSalon->InsertAula($db,$id,$AulaSize['Data'][0]['ClasificacionEspaciosId'],$id_Soli);
                                                    }else{
                                                        $AccesoTotal=false;
                                                    }  
                                                   break;
                                                }
                                        
                                        }                                    
                                    }
                                  $AulasPriorida->MoveNext();      
                                /****************************************************************/
                          }//while Prioridad Aula
                           
                 }else{
                
                 $AulasPrioridaOther = $C_AsignacionSalon->ConsultarEspaciosPrivilegio($db,$fecha,$hora_1,$hora_2,$Fecha_horaIni,$fecha_horaFin,$C_TipoSalon,$Sede,$Carrera,$Condicion,0);
                            
                            if(!$AulasPrioridaOther->EOF){
                               
                                $Cambio = 0;
                                 while(!$AulasPrioridaOther->EOF){
                                /****************************************************************/
                                 $aula_id = $AulasPrioridaOther->fields['ClasificacionEspaciosId'];
                                 
                                 $Responsable = EspacioResponsable($db,$userid,$id_Soli);
                
                                    if($Responsable){ 
                                        
                                        $Responsable_2 = EspacioResponsable($db,$userid,'',$aula_id);
                                        
                                        if($Responsable_2){
                                 
                                             $AulaSize = $C_AsignacionSalon->SizeEspacioFisico($db,$aula_id,$min,$max);
                                                  //echo 'line1115';echo '<pre>';print_r($AulaSize);
                                                 if($AulaSize['val']==true){
                                                     $Cambio = 1;
                                                     $AccesoTotal = ValidaTipoSalonFinal($db,$C_TipoSalon,$AulaSize['Data'][0]['ClasificacionEspaciosId']);
                                                     if($AccesoTotal){
                                                        $C_AsignacionSalon->InsertAula($db,$id,$AulaSize['Data'][0]['ClasificacionEspaciosId'],$id_Soli);
                                                     }else{
                                                        $AccesoTotal=false;
                                                     }  
                                                   break;
                                                }
                                        }
                                    }
                                  $AulasPrioridaOther->MoveNext();      
                                /****************************************************************/
                                }//while Prioridad Aula Other
                               
                            }
                    }            
                    
                    if($Cambio!=1){
                            
                        $OtherAulas = $C_AsignacionSalon->ConsultarEspacios($db,$fecha,$hora_1,$hora_2,$Fecha_horaIni,$fecha_horaFin,$C_TipoSalon,$Sede,$Condicion,'',1);//view activo
                    
                        if(!$OtherAulas->EOF){
                            
                            $Cambio_5 = 0;
                             while(!$OtherAulas->EOF){   
                            /****************************************************************/
                             $aula_id = $OtherAulas->fields['ClasificacionEspaciosId'];
                             
                                $Responsable = EspacioResponsable($db,$userid,$id_Soli);
                
                                    if($Responsable){ 
                                        
                                        $Responsable_2 = EspacioResponsable($db,$userid,'',$aula_id);
                                        
                                        if($Responsable_2){
                                        
                                             $AulaSize = $C_AsignacionSalon->SizeEspacioFisico($db,$aula_id,$min,$max);
                                                //  echo 'line1134';echo '<pre>';print_r($AulaSize);
                                                 if($AulaSize['val']==true){ 
                                                     $Cambio_5 = 1;
                                                     $AccesoTotal = ValidaTipoSalonFinal($db,$C_TipoSalon,$AulaSize['Data'][0]['ClasificacionEspaciosId']);
                                                     if($AccesoTotal){
                                                        $C_AsignacionSalon->InsertAula($db,$id,$AulaSize['Data'][0]['ClasificacionEspaciosId'],$id_Soli);
                                                       }else{
                                                        $AccesoTotal=false;
                                                       }   
                                                   break;
                                                }
                                        }
                                    }
                              $OtherAulas->MoveNext();      
                            /****************************************************************/
                            }//while Aula Other
                            if($Cambio_5!=1){
                                $a_vectt['NoHay']			= true;
                                $a_vectt['Msg']             = 'No Hay Espacios Disponibles...'; 
                            }
                        }else{
                            $OtherAulas = $C_AsignacionSalon->ConsultarEspacios($db,$fecha,$hora_1,$hora_2,$Fecha_horaIni,$fecha_horaFin,$C_TipoSalon,$Sede,$Condicion);//view activo
                    
                            if(!$OtherAulas->EOF){
                               
                                $Cambio_6 = 0;
                                 while(!$OtherAulas->EOF){ 
                                /****************************************************************/
                                 $aula_id = $OtherAulas->fields['ClasificacionEspaciosId'];
                                 
                                 $Responsable = EspacioResponsable($db,$userid,$id_Soli);
                
                                    if($Responsable){ 
                                        $Responsable_2 = EspacioResponsable($db,$userid,'',$aula_id);
                                        if($Responsable_2){
                                            
                                             $AulaSize = $C_AsignacionSalon->SizeEspacioFisico($db,$aula_id,$min,$max);
                                                //  echo 'line1159';echo '<pre>';print_r($AulaSize);
                                                 if($AulaSize['val']==true){  
                                                     $Cambio_6 = 1;
                                                      //echo '<br><br>Other Aulas....4';
                                                     // echo '<br><br>id->'.$id.'->>Aula->'.$AulaSize['Data'][0]['ClasificacionEspaciosId'].'-->>Soli->'.$id_Soli;
                                                     $AccesoTotal = ValidaTipoSalonFinal($db,$C_TipoSalon,$AulaSize['Data'][0]['ClasificacionEspaciosId']);
                                                     if($AccesoTotal){
                                                        $C_AsignacionSalon->InsertAula($db,$id,$AulaSize['Data'][0]['ClasificacionEspaciosId'],$id_Soli);
                                                     }else{
                                                        $AccesoTotal = false;
                                                     }  
                                                   break;
                                                }
                                        }
                                    }
                                  $OtherAulas->MoveNext();      
                                /****************************************************************/
                                }//while Aula Other
                                if($Cambio_6!=1){
                                    $a_vectt['NoHay']			= true;
                                    $a_vectt['Msg']             = 'No Hay Espacios Disponibles...'; 
                                }
                            }
                        }
                    }            
                            
                }
                                                               
                /******************************************************************/
                }else{ //echo '<br><br><span style="color: red;">Sale...</span>';
                    $a_vectt['Existe']			= true;
                    $a_vectt['Msg']             = ' Pero se encontraron Inconsistencias...';
                    $a_vectt['Espacio']			= $Resultado['Nombre'];
                    $a_vectt['Texto'][$id]		= 'Ya Existe una Asigancion para Este Grupo en la fecha '.$Resultado['Fecha'].' y las siguientes horas '.$Resultado['Hora_1'].' -- '.$Resultado['Hora_2'];
                    
                   // echo '<pre>';print_r($a_vectt);
                }//Validacion
               }//Fecha Quemada 
              }//fecha festiva 
            }//for
            
            
            
  }//function AsigancionMaxiva  
  function Porcentaje($db){  
      $SQL='SELECT
                p.codigoperiodo,
                j.Porcentaje
            FROM
                periodo p
                INNER JOIN PorcentajeEspacio j ON j.codigoperiodo = p.codigoperiodo
            WHERE
                p.codigoestadoperiodo = 1
                AND
                j.codigoestado=100';
                
           if($Porcentaje=&$db->Execute($SQL)===false){
                echo 'Error en el SQL ....<br><br>'.$SQL;
                die;
           }    
           
           if(!$Porcentaje->EOF){
                return $Porcentaje->fields['Porcentaje'];
           }else{
                return 0;
           } 
  }   
  
  function EspacioResponsable($db,$userid,$Soli='',$Aula=''){
        if($Soli){
          $SQL='SELECT
                r.CodigoTipoSalon
                FROM
                ResponsableEspacioFisico r INNER JOIN SolicitudAsignacionEspaciostiposalon s ON s.codigotiposalon=r.CodigoTipoSalon
                
                WHERE
                r.UsuarioId="'.$userid.'"
                AND
                r.CodigoEstado=100
                AND
                s.SolicitudAsignacionEspacioId="'.$Soli.'"';
         }else{
            $SQL='SELECT
                r.CodigoTipoSalon
                FROM
                ResponsableEspacioFisico r INNER JOIN ClasificacionEspacios c ON c.codigotiposalon = r.CodigoTipoSalon
                
                WHERE
                r.UsuarioId="'.$userid.'"
                AND
                r.CodigoEstado=100
                AND
                c.ClasificacionEspaciosId="'.$Aula.'"';
         }       
                
         if($Responsable=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de la Responsabilida ...<br><br>'.$SQL;
            die;
         } 
         
         
         if(!$Responsable->EOF){
            return true;
         }else{
            return false;
         }      
  }//function EspacioResponsable 	
  function ValidaTipoSalonFinal($db,$TipoSalon,$Espacio){
    switch($TipoSalon){
            case '"0"' :{
                 $SQL='SELECT
                    codigotiposalon
                    FROM
                    tiposalon
                    WHERE
                    EspaciosFisicosId=5
                    AND
                    codigoestado=100
                    AND
                    codigotiposalon<>"0"';
                    
            if($TiposAulas=&$db->Execute($SQL)===false){
                echo 'Error del Sistema...<br>'.
                die;
            }   
            $OtherAulas = '';
            while(!$TiposAulas->EOF){
                
                if($OtherAulas){
                    $OtherAulas = $OtherAulas.','.'"'.$TiposAulas->fields['codigotiposalon'].'"';
                }else{
                    $OtherAulas = '"'.$TiposAulas->fields['codigotiposalon'].'"';
                }
                
                $TiposAulas->MoveNext();
            }   
            
            $condicion = '  c.codigotiposalon IN ('.$OtherAulas.')';  
            }break;
            default:{
                 $condicion = '  c.codigotiposalon IN ('.$TipoSalon.')';
            }break;
        }
      $SQL='SELECT
                ClasificacionEspaciosId
            FROM
                ClasificacionEspacios c            
            WHERE
            
                c.ClasificacionEspaciosId="'.$Espacio.'"
                AND
                c.codigoestado=100
                AND
                '.$condicion;
                
       if($ValidacionTipoSalon=&$db->Execute($SQL)===false){
         echo 'Error del Sistema ...<br><br>';
         die;
       }    
       
       if(!$ValidacionTipoSalon->EOF){
         return true;
       }else{
        return false;
       }     
  }
?>