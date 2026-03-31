<?php

class FuncionesSolicitudEspacios{
  
    public function Eliminar($userid,$id,$ruta='../'){
         include_once($ruta."templates/template.php");
         
         $db = getBD(); 
         
         $SQL='SELECT
                        SolicitudPadreId,
                        SolicitudAsignacionEspaciosId AS id
                FROM
                        AsociacionSolicitud 
                WHERE
                        SolicitudPadreId="'.$id.'"';
                        
                   
                if($DatosDetalle=&$db->GetAll($SQL)===false){
                    echo 'Error en el Sistema...';
                    die;
                }   
 
           $DatosModificarGrupo      = array();
           $DatoCondicionGrupo       = array();     
           $DatosModificarAsignacion = array();
           $DatoCondicionAsignacion  = array();
           $datosModificarSolicitud  = array();
           $DatoCondicionSolicitud   = array();     
           
           for($i=0;$i<count($DatosDetalle);$i++){
                $Detalle_id = $DatosDetalle[$i]['id'];
                $DatosModificarGrupo      = '';
                $DatoCondicionGrupo       = '';
                $DatosModificarAsignacion = '';
                $DatoCondicionAsignacion  = '';
                $datosModificarSolicitud  = '';
                $DatoCondicionSolicitud   = '';
                //***Elimina Grupos***//
                 $DatosModificarGrupo['campo'][] = 'codigoestado';
                 $DatosModificarGrupo['valor'][] = '200';
                 $DatoCondicionGrupo['campo'][]  = 'SolicitudAsignacionEspacioId';
                 $DatoCondicionGrupo['valor'][]  = $Detalle_id;

                 $this->UpdateSolicitudesAll($db,'SolicitudEspacioGrupos',$DatosModificarGrupo,$DatoCondicionGrupo);                 
               //***Elimina Fechas y Salones Asignados***// 
                 $DatosModificarAsignacion['campo'][] = 'codigoestado';
                 $DatosModificarAsignacion['valor'][] = '200';
                 $DatosModificarAsignacion['campo'][] = 'ClasificacionEspaciosId';
                 $DatosModificarAsignacion['valor'][] = '212';
                 $DatosModificarAsignacion['campo'][] = 'UsuarioUltimaModificacion';
                 $DatosModificarAsignacion['valor'][] = $userid;
                 $DatosModificarAsignacion['campo'][] = 'FechaultimaModificacion';
                 $DatosModificarAsignacion['valor'][] = date('Y-m-d H:i:s');
                 $DatoCondicionAsignacion['campo'][]  = 'SolicitudAsignacionEspacioId';
                 $DatoCondicionAsignacion['valor'][]  = $Detalle_id;
                 
                 $this->UpdateSolicitudesAll($db,'AsignacionEspacios',$DatosModificarAsignacion,$DatoCondicionAsignacion); 
              //***Elimina Solicitud Espacios Detalle 󠈩jos***//
                 $datosModificarSolicitud['campo'][] = 'codigoestado';
                 $datosModificarSolicitud['valor'][] = '200';
                 $datosModificarSolicitud['campo'][] = 'UsuarioUltimaModificacion';
                 $datosModificarSolicitud['valor'][] = $userid;
                 $datosModificarSolicitud['campo'][] = 'FechaUltimaModificacion';
                 $datosModificarSolicitud['valor'][] = date('Y-m-d H:i:s');
                 $DatoCondicionSolicitud['campo'][]  = 'SolicitudAsignacionEspacioId';
                 $DatoCondicionSolicitud['valor'][]  = $Detalle_id;
                 $this->UpdateSolicitudesAll($db,'SolicitudAsignacionEspacios',$datosModificarSolicitud,$DatoCondicionSolicitud);                                        
           }//for         
                        
         //***Elimina Solicitud Padre***//
         $DatosModificarPadre['campo'][]  = 'CodigoEstado';
         $DatosModificarPadre['valor'][]  = '200';
         $DatosModificarPadre['campo'][] = 'UsuarioUltimaModificacion';
         $DatosModificarPadre['valor'][] = $userid;
         $DatosModificarPadre['campo'][] = 'FechaUltimaModificacion';
         $DatosModificarPadre['valor'][] = date('Y-m-d H:i:s');
         $DatosCondicionPadre['campo'][]  = 'SolicitudPadreId';
         $DatosCondicionPadre['valor'][]  = $id;
         $this->UpdateSolicitudesAll($db,'SolicitudPadre',$DatosModificarPadre,$DatosCondicionPadre);
    }//public function Eliminar
    function UpdateSolicitudesAll($db,$Tabla,$Modificar,$Condicion,$View=false){ 
        
        for($i=0;$i<count($Modificar['campo']);$i++){
            if($i>=1){
                $Cambios = $Cambios.','.$Modificar['campo'][$i].'="'.$Modificar['valor'][$i].'"';   
            }else{
                $Cambios = $Modificar['campo'][$i].'="'.$Modificar['valor'][$i].'"';    
            }            
        }//for
        
        for($j=0;$j<count($Condicion['campo']);$j++){
            if($j>=1){
                if($Condicion['campo'][$j]){
                    $Where = $Where.' AND '.$Condicion['campo'][$j].'="'.$Condicion['valor'][$j].'"'; 
                }  
            }else{
                $Where = $Condicion['campo'][$j].'="'.$Condicion['valor'][$j].'"';    
            }            
        }//for
        
          $SQL='UPDATE '.$Tabla.'
                SET    '.$Cambios.'
                WHERE  '.$Where;
          
          if($View==true){
            echo '<br><br>'.$SQL;
            //die;
          }
                
        if($Modifica=&$db->Execute($SQL)===false){
            echo 'Error en el Sistema ...1';
            die;
         }  
    }//function UpdateSolicitudGrupo
    function InsertAllData($db,$Tabla,$Datos,$View=false){
       
         for($i=0;$i<count($Datos['campo']);$i++){
            if($i>=1){
                $Campos = $Campos.','.$Datos['campo'][$i];    
                $Valor  = $Valor.',"'.$Datos['valor'][$i].'"';
            }else{
                $Campos = $Datos['campo'][$i];    
                $Valor  = '"'.$Datos['valor'][$i].'"';
            }            
        }//for
        
        $Insert='INSERT INTO '.$Tabla.' ('.$Campos.') VALUES ('.$Valor.')';
        
        if($View==true){
            echo '<br><br>'.$Insert;
           // die;
          }
                
        if($Inserta=&$db->Execute($Insert)===false){
            echo 'Error en el Sistema ...2';
            die;
         } 
         
        return $Last_id=$db->Insert_ID();
    }//function InsertAllData
    function EditarHorario($userid,$hijo,$hora_1,$hora_2,$Dia,$tipoSalon,$ruta='../'){
        include_once($ruta."templates/template.php");
        $db = getBD(); 
        include_once($ruta.'Solicitud/SolicitudEspacio_class.php');   $C_SolicitudEspacio = new SolicitudEspacio();
        include_once($ruta.'Solicitud/festivos.php');                 $C_Festivo          = new festivos();
        include_once('../Solicitud/AsignacionSalon.php');                           $C_AsignacionSalon = new AsignacionSalon();
        
          $SQL='SELECT
                	s.SolicitudAsignacionEspacioId AS id,
                	s.codigodia,
                	a.HoraInicio,
                	a.HoraFin,
                    s.FechaInicio,
                    s.FechaFinal
                FROM
                	SolicitudAsignacionEspacios s
                INNER JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                WHERE
                	s.SolicitudAsignacionEspacioId = "'.$hijo.'"
                AND s.codigoestado = 100
                AND a.codigoestado = 100
                LIMIT 1';
                
           if($Data=&$db->Execute($SQL)===false){
             echo 'Error en el SQL del sistema ...';
             die;
           }     
           
           if(!$Data->EOF){
                //****Valida Dia***//                
                if($Data->fields['codigodia']!=$Dia){
                    //***Cambia Dia***//
                    $Modificar['campo'][] = 'codigodia';
                    $Modificar['valor'][] = $Dia;
                    $Condicion['campo'][] = 'SolicitudAsignacionEspacioId';
                    $Condicion['valor'][] = $hijo;
                    $Condicion['campo'][] = 'codigoestado';
                    $Condicion['valor'][] = '100';
                    $this->UpdateSolicitudesAll($db,'SolicitudAsignacionEspacios',$Modificar,$Condicion);
                    
                    //*****Cambiar Fechas ***//
                    $C_Dia[] = $Dia;
                    
                    $FechasNew = $C_SolicitudEspacio->FechasFuturas('35',$Data->fields['FechaInicio'],$Data->fields['FechaFinal'],$C_Dia);
                    
                    $ModificarEstado['campo'][] = 'codigoestado';
                    $ModificarEstado['valor'][] = '200';
                    $ModificarEstado['campo'][] = 'ClasificacionEspaciosId';
                    $ModificarEstado['valor'][] = '212';
                    $CondicionEstado['campo'][] = 'SolicitudAsignacionEspacioId';
                    $CondicionEstado['valor'][] = $hijo;
                    
                    $this->UpdateSolicitudesAll($db,'AsignacionEspacios',$ModificarEstado,$CondicionEstado);
                    
                    $SQL_A='SELECT
                            	AsignacionEspaciosId,
                                FechaAsignacion
                            FROM
                            	AsignacionEspacios
                            WHERE
                            	SolicitudAsignacionEspacioId = "'.$hijo.'"';
                                
                     if($FechasOld=&$db->GetArray($SQL_A)===false){
                        echo 'Error en el sistema...';
                        die;
                     }    
                    
                     if(count($FechasOld)>=count($FechasNew[0])){
                        $Num = count($FechasOld);
                     }else{
                        $Num = count($FechasNew[0]);
                     }
                    
                     for($i=0;$i<$Num;$i++){
                        if($FechasOld[$i]['AsignacionEspaciosId'] && $FechasNew[0][$i]){
                           //***Modifica fecha y activa a 100**//   
                            $C_DatosDia  = explode('-',$FechasNew[0][$i]);
                            
                            $dia   = $C_DatosDia[2];
                            $mes   = $C_DatosDia[1];
                            $year  = $C_DatosDia[0];
                            
                            $Festivo = $C_Festivo->esFestivo($dia,$mes,$year);
                            $DomingoTrue = $C_AsignacionSalon->DiasSemana($FechasNew[0][$i]);
                            if($Festivo==false){//$Festivo No es Festivo
                                if(($DomingoTrue!=7) || ($DomingoTrue!='7')){
                                
                                $ModificarFecha['campo'][] = 'codigoestado';
                                $ModificarFecha['valor'][] = '100';
                                $ModificarFecha['campo'][] = 'FechaAsignacion';
                                $ModificarFecha['valor'][] = $FechasNew[0][$i];
                                $ModificarFecha['campo'][] = 'FechaAsignacionAntigua';
                                $ModificarFecha['valor'][] = $FechasOld[$i]['FechaAsignacion'];
                                $ModificarFecha['campo'][] = 'UsuarioUltimaModificacion';
                                $ModificarFecha['valor'][] = $userid;
                                $ModificarFecha['campo'][] = 'FechaultimaModificacion';
                                $ModificarFecha['valor'][] = date('Y-m-d H:i:s');
                                $CondicionFecha['campo'][] = 'SolicitudAsignacionEspacioId';
                                $CondicionFecha['valor'][] = $hijo;
                                $CondicionFecha['campo'][] = 'AsignacionEspaciosId';
                                $CondicionFecha['valor'][] = $FechasOld[$i]['AsignacionEspaciosId'];
                                
                                $this->UpdateSolicitudesAll($db,'AsignacionEspacios',$ModificarFecha,$CondicionFecha);
                                }//diferente de domingo
                            }
                        }else{
                            if((!$FechasOld[$i]['AsignacionEspaciosId'] || $FechasOld[$i]['AsignacionEspaciosId']='') && $FechasNew[0][$i]){
                               //****Inserta en Asignacion nueva fecha***//  
                               $C_DatosDia  = explode('-',$FechasNew[0][$i]);
                                
                               $dia   = $C_DatosDia[2];
                               $mes   = $C_DatosDia[1];
                               $year  = $C_DatosDia[0]; 
                               
                                $Festivo = $C_Festivo->esFestivo($dia,$mes,$year);
                                $DomingoTrue = $C_AsignacionSalon->DiasSemana($FechasNew[0][$i]);
                               if($Festivo==false){//$Festivo No es Festivo
                                   if(($DomingoTrue!=7) || ($DomingoTrue!='7')){
                                       $NuevoRegistroAsigancion['campo'][]  = 'FechaAsignacion';
                                       $NuevoRegistroAsigancion['valor'][]  = $FechasNew[0][$i];
                                       $NuevoRegistroAsigancion['campo'][]  = 'SolicitudAsignacionEspacioId';
                                       $NuevoRegistroAsigancion['valor'][]  = $hijo;
                                       $NuevoRegistroAsigancion['campo'][]  = 'UsuarioCreacion';
                                       $NuevoRegistroAsigancion['valor'][]  = $userid;
                                       $NuevoRegistroAsigancion['campo'][]  = 'UsuarioUltimaModificacion';
                                       $NuevoRegistroAsigancion['valor'][]  = $userid;
                                       $NuevoRegistroAsigancion['campo'][]  = 'FechaCreacion';
                                       $NuevoRegistroAsigancion['valor'][]  = date('Y-m-d H:i:s');
                                       $NuevoRegistroAsigancion['campo'][]  = 'FechaultimaModificacion';
                                       $NuevoRegistroAsigancion['valor'][]  = date('Y-m-d H:i:s');
                                       $NuevoRegistroAsigancion['campo'][]  = 'ClasificacionEspaciosId';
                                       $NuevoRegistroAsigancion['valor'][]  = '212';
                                       $NuevoRegistroAsigancion['campo'][]  = 'HoraInicio';
                                       $NuevoRegistroAsigancion['valor'][]  = $hora_1;
                                       $NuevoRegistroAsigancion['campo'][]  = 'HoraFin';
                                       $NuevoRegistroAsigancion['valor'][]  = $hora_2;
                                       $this->InsertAllData($db,'AsignacionEspacios',$NuevoRegistroAsigancion);
                                    }//diferente de domingo   
                               }
                            }                            
                        }
                        
                     }//for   
                       
                }
                
                $SQL_H='SELECT
                        	s.SolicitudAsignacionEspacioId AS id,
                        	s.codigodia,
                        	a.HoraInicio,
                        	a.HoraFin
                        FROM
                        	SolicitudAsignacionEspacios s
                        INNER JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                        WHERE
                        	s.SolicitudAsignacionEspacioId = "'.$hijo.'"
                        AND s.codigoestado = 100
                        AND a.codigoestado = 100
                        AND a.HoraInicio="'.$hora_1.'"
                        AND a.HoraFin="'.$hora_2.'"
                        LIMIT 1';
                        
                       if($DataHora=&$db->Execute($SQL_H)===false){
                         echo 'Error en el Sistema...';
                         die;
                       } 
                       
                  if($DataHora->EOF){
                    //***Cambio de Hora**//
                    $ModificarHora['campo'][] = 'HoraInicio';
                    $ModificarHora['valor'][] = $hora_1;
                    $ModificarHora['campo'][] = 'HoraFin';
                    $ModificarHora['valor'][] = $hora_2;
                    $ModificarHora['campo'][] = 'ClasificacionEspaciosId';
                    $ModificarHora['valor'][] = '212';
                    $ModificarHora['campo'][] = 'UsuarioUltimaModificacion';
                    $ModificarHora['valor'][] = $userid;
                    $ModificarHora['campo'][] = 'FechaultimaModificacion';
                    $ModificarHora['valor'][] = date('Y-m-d H:i:s');
                    $CondicionHora['campo'][] = 'SolicitudAsignacionEspacioId';
                    $CondicionHora['valor'][] = $hijo;
                    $CondicionHora['campo'][] = 'codigoestado';
                    $CondicionHora['valor'][] = '100';
                    $this->UpdateSolicitudesAll($db,'AsignacionEspacios',$ModificarHora,$CondicionHora);
                  }
                    if(strlen($tipoSalon)==1){
                         $tipoSalon = '0'.$tipoSalon;
                    }
               
                    $SQL_T='SELECT
                            	*
                            FROM
                            	SolicitudAsignacionEspaciostiposalon
                            WHERE
                            	SolicitudAsignacionEspacioId = "'.$hijo.'"
                            AND codigotiposalon ="'.$tipoSalon.'"';    
                            
                    if($DataSalon=&$db->Execute($SQL_T)===false){
                        echo 'Error en el Sistema...';
                        die;
                    }    
                    
                    if($DataSalon->EOF){
                        //***Cambio de Salon por tipo***//
                      
                        $CambioTipoSalon['campo'][] = 'codigotiposalon';
                        $CambioTipoSalon['valor'][] = $tipoSalon;
                        $CondicionCambioTipoSalon['campo'][] = 'SolicitudAsignacionEspacioId';
                        $CondicionCambioTipoSalon['valor'][] = $hijo;
                        $this->UpdateSolicitudesAll($db,'SolicitudAsignacionEspaciostiposalon',$CambioTipoSalon,$CondicionCambioTipoSalon);
                        
                        $ModificarTipoSalon['campo'][] = 'ClasificacionEspaciosId';
                        $ModificarTipoSalon['valor'][] = '212';
                        $ModificarTipoSalon['campo'][] = 'UsuarioUltimaModificacion';
                        $ModificarTipoSalon['valor'][] = $userid;
                        $ModificarTipoSalon['campo'][] = 'FechaultimaModificacion';
                        $ModificarTipoSalon['valor'][] = date('Y-m-d H:i:s');
                        $CondicionTipoSalon['campo'][] = 'SolicitudAsignacionEspacioId';
                        $CondicionTipoSalon['valor'][] = $hijo;
                        $CondicionTipoSalon['campo'][] = 'codigoestado';
                        $CondicionTipoSalon['valor'][] = '100';
                        $this->UpdateSolicitudesAll($db,'AsignacionEspacios',$ModificarTipoSalon,$CondicionTipoSalon);
                    }     
                
           }
    }//function EditarHorario    
    function DiaAdd($userid,$Padre,$hora_1,$hora_2,$Dia,$tipoSalon,$ruta='../'){
        include_once($ruta."templates/template.php");
        $db = getBD(); 
        include_once($ruta.'Solicitud/SolicitudEspacio_class.php');   $C_SolicitudEspacio = new SolicitudEspacio();
        include_once($ruta.'Solicitud/festivos.php');                 $C_Festivo          = new festivos();
         include_once('../Solicitud/AsignacionSalon.php');                           $C_AsignacionSalon = new AsignacionSalon();
        
          $SQL='SELECT
                	s.AccesoDiscapacitados,
                	s.FechaInicio,
                	s.FechaFinal,
                	s.ClasificacionEspaciosId,
                	s.codigomodalidadacademica,
                	s.codigocarrera
                FROM
                	AsociacionSolicitud a
                INNER JOIN SolicitudAsignacionEspacios s ON a.SolicitudAsignacionEspaciosId = s.SolicitudAsignacionEspacioId
                WHERE
                	a.SolicitudPadreId = "'.$Padre.'"
                AND s.codigoestado = 100
                GROUP BY
                	a.SolicitudPadreId';
                    
             if($Datos=&$db->GetAll($SQL)===false){
                echo 'Error en el Sistema...';
                die;
             }       
        //****SolicitudEspacioFisico****//
        $Solicitud['campo'][] = 'AccesoDiscapacitados';
        $Solicitud['valor'][] = $Datos[0]['AccesoDiscapacitados'];
        $Solicitud['campo'][] = 'FechaInicio';
        $Solicitud['valor'][] = $Datos[0]['FechaInicio'];
        $Solicitud['campo'][] = 'FechaFinal';
        $Solicitud['valor'][] = $Datos[0]['FechaFinal'];
        $Solicitud['campo'][] = 'idsiq_periodicidad';
        $Solicitud['valor'][] = '35';
        $Solicitud['campo'][] = 'ClasificacionEspaciosId';
        $Solicitud['valor'][] = $Datos[0]['ClasificacionEspaciosId'];
        $Solicitud['campo'][] = 'codigoestado';
        $Solicitud['valor'][] = '100';
        $Solicitud['campo'][] = 'UsuarioCreacion';
        $Solicitud['valor'][] = $userid;
        $Solicitud['campo'][] = 'UsuarioUltimaModificacion';
        $Solicitud['valor'][] = $userid;
        $Solicitud['campo'][] = 'FechaCreacion';
        $Solicitud['valor'][] = date('Y-m-d H:i:s');
        $Solicitud['campo'][] = 'FechaUltimaModificacion';
        $Solicitud['valor'][] = date('Y-m-d H:i:s');;
        $Solicitud['campo'][] = 'codigodia';
        $Solicitud['valor'][] = $Dia;
        $Solicitud['campo'][] = 'codigomodalidadacademica';
        $Solicitud['valor'][] = $Datos[0]['codigomodalidadacademica'];
        $Solicitud['campo'][] = 'codigocarrera';
        $Solicitud['valor'][] = $Datos[0]['codigocarrera'];
        
        $Last_idSolicitud = $this->InsertAllData($db,'SolicitudAsignacionEspacios',$Solicitud);
        //****AsociacionSolicitud****//
        $Asociacion['campo'][] = 'SolicitudAsignacionEspaciosId';
        $Asociacion['valor'][] = $Last_idSolicitud;
        $Asociacion['campo'][] = 'SolicitudPadreId';
        $Asociacion['valor'][] = $Padre;
        
        $this->InsertAllData($db,'AsociacionSolicitud',$Asociacion);
        //****AsigancionEspacio****//
        $C_Dia[] = $Dia;
                    
        $FechasNew = $C_SolicitudEspacio->FechasFuturas('35',$Datos[0]['FechaInicio'],$Datos[0]['FechaFinal'],$C_Dia);
        
        for($i=0;$i<count($FechasNew[0]);$i++){
            $C_DatosDia  = explode('-',$FechasNew[0][$i]);
                                
            $dia   = $C_DatosDia[2];
            $mes   = $C_DatosDia[1];
            $year  = $C_DatosDia[0];
            
            $Festivo = $C_Festivo->esFestivo($dia,$mes,$year);
            $DomingoTrue = $C_AsignacionSalon->DiasSemana($FechasNew[0][$i]);     
            if($Festivo==false){//$Festivo No es Festivo
                if(($DomingoTrue!=7) || ($DomingoTrue!='7')){
                $Asigancion['campo'][]  = 'FechaAsignacion';
                $Asigancion['valor'][]  = $FechasNew[0][$i];
                $Asigancion['campo'][]  = 'SolicitudAsignacionEspacioId';
                $Asigancion['valor'][]  = $Last_idSolicitud;
                $Asigancion['campo'][]  = 'UsuarioCreacion';
                $Asigancion['valor'][]  = $userid;
                $Asigancion['campo'][]  = 'UsuarioUltimaModificacion';
                $Asigancion['valor'][]  = $userid;
                $Asigancion['campo'][]  = 'FechaCreacion';
                $Asigancion['valor'][]  = date('Y-m-d H:i:s');
                $Asigancion['campo'][]  = 'FechaultimaModificacion';
                $Asigancion['valor'][]  = date('Y-m-d H:i:s');
                $Asigancion['campo'][]  = 'ClasificacionEspaciosId';
                $Asigancion['valor'][]  = '212';
                $Asigancion['campo'][]  = 'HoraInicio';
                $Asigancion['valor'][]  = $hora_1;
                $Asigancion['campo'][]  = 'HoraFin';
                $Asigancion['valor'][]  = $hora_2;
                
                $this->InsertAllData($db,'AsignacionEspacios',$Asigancion);
                }//difernete de domingo    
            }
        }//for
        //****SolicitudTipoSalon****//
        if(strlen($tipoSalon)==1){
             $tipoSalon = '0'.$tipoSalon;
        }
        
        $SolicitudTipoSalon['campo'][] = 'SolicitudAsignacionEspacioId';
        $SolicitudTipoSalon['valor'][] = $Last_idSolicitud;
        $SolicitudTipoSalon['campo'][] = 'codigotiposalon';
        $SolicitudTipoSalon['valor'][] = $tipoSalon;
        
        $this->InsertAllData($db,'SolicitudAsignacionEspaciostiposalon',$SolicitudTipoSalon);
        //****SolicitudGrupo****//
        $SQL_G='SELECT
                	g.idgrupo
                FROM
                	AsociacionSolicitud a
                INNER JOIN SolicitudEspacioGrupos g ON g.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId
                WHERE
                	g.codigoestado = 100
                AND a.SolicitudPadreId = "'.$Padre.'"
                GROUP BY
                	g.idgrupo ';
                    
           if($DataGrupo=&$db->Execute($SQL_G)===false){
             echo 'Error en el Sistema ...3';
             die;
           }         
        
        while(!$DataGrupo->EOF){
            //************************************************//
              $GrupoSolicitud['campo'][] = 'SolicitudAsignacionEspacioId';
              $GrupoSolicitud['valor'][] = $Last_idSolicitud;
              $GrupoSolicitud['campo'][] = 'idgrupo';
              $GrupoSolicitud['valor'][] = $DataGrupo->fields['idgrupo']; 
              $GrupoSolicitud['campo'][] = 'codigoestado';
              $GrupoSolicitud['valor'][] = '100';   
              
              $this->InsertAllData($db,'SolicitudEspacioGrupos',$GrupoSolicitud);
            //************************************************//
            $DataGrupo->MoveNext();
        }//while
    }//function DiaAdd
    function EditFechas($userid,$Padre,$Tipohorario,$Fecha_1,$Fecha_2,$ruta='../'){ 
        
        include_once($ruta."templates/template.php");
        
        $db = getBD(); 
        
        include_once($ruta.'Solicitud/SolicitudEspacio_class.php');   $C_SolicitudEspacio = new SolicitudEspacio();
        include_once($ruta.'Solicitud/festivos.php');                 $C_Festivo          = new festivos();
        include_once('../Solicitud/AsignacionSalon.php');                           $C_AsignacionSalon = new AsignacionSalon();
        
        if($Tipohorario=='100' || $Tipohorario==100){//Se puede editar
        
            $SQL='SELECT
                    	s.SolicitudAsignacionEspacioId AS id,
                    	s.codigodia
                    FROM
                    	SolicitudPadre p
                    INNER JOIN AsociacionSolicitud a ON a.SolicitudPadreId = p.SolicitudPadreId
                    INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId
                    WHERE
                    	p.CodigoEstado = 100
                    AND s.codigoestado = 100
                    AND p.SolicitudPadreId ="'.$Padre.'"';
                    
                if($Solicitudes=&$db->GetArray($SQL)===false){
                    echo 'Error en el Sistema...';
                    die;
                }  
                  
            //****Cambia Fechas Solicitud****//
            for($j=0;$j<count($Solicitudes);$j++){
                $SQL_F='SELECT
                        	*
                        FROM
                        	SolicitudAsignacionEspacios s
                        WHERE
                        	s.SolicitudAsignacionEspacioId = "'.$Solicitudes[$j]['id'].'"
                        AND s.codigoestado = 100
                        AND s.FechaInicio = "'.$Fecha_1.'"
                        AND s.FechaFinal = "'.$Fecha_2.'"';
                        
                    if($ValidaCambio=&$db->Execute($SQL_F)===false){
                        echo 'Error en el Sistema...';
                        die;
                    } 
                    ;
                    if($ValidaCambio->EOF){ 
                        $SolicitudData = array();
                        $SolicitudCondicion = array();
                        $C_Dia = array();
                        $ModificarEstado = array();
                        $$CondicionEstado = array();
                         //***Cabio fechas inicial y final ***//
                            $SolicitudData['campo'][]       = 'FechaInicio';
                            $SolicitudData['valor'][]       = $Fecha_1;
                            $SolicitudData['campo'][]       = 'FechaFinal';
                            $SolicitudData['valor'][]       = $Fecha_2;
                            $SolicitudCondicion['campo'][]  = 'SolicitudAsignacionEspacioId';
                            $SolicitudCondicion['valor'][]  = $Solicitudes[$j]['id'];
                            $SolicitudCondicion['campo'][]  = 'codigoestado';
                            $SolicitudCondicion['valor'][]  = '100';
                            
                            $this->UpdateSolicitudesAll($db,'SolicitudAsignacionEspacios',$SolicitudData,$SolicitudCondicion,true);
                            
                            //****Asigna o Quita Fechas de Asignacion****//
                            $C_Dia[] = $Solicitudes[$i]['codigodia'];
                            
                            $FechasNew = $C_SolicitudEspacio->FechasFuturas('35',$Fecha_1,$Fecha_2,$C_Dia);
                            
                            $ModificarEstado['campo'][] = 'codigoestado';
                            $ModificarEstado['valor'][] = '200';
                            $ModificarEstado['campo'][] = 'ClasificacionEspaciosId';
                            $ModificarEstado['valor'][] = '212';
                            $CondicionEstado['campo'][] = 'SolicitudAsignacionEspacioId';
                            $CondicionEstado['valor'][] = $Solicitudes[$j]['id'];
                            
                            $this->UpdateSolicitudesAll($db,'AsignacionEspacios',$ModificarEstado,$CondicionEstado,true);
                            
                            $SQL_A='SELECT
                                    	AsignacionEspaciosId,
                                        FechaAsignacion,
                                        HoraInicio,
                                        HoraFin
                                    FROM
                                    	AsignacionEspacios
                                    WHERE
                                    	SolicitudAsignacionEspacioId = "'.$Solicitudes[$j]['id'].'"';
                                
                             if($FechasOld=&$db->GetArray($SQL_A)===false){
                                echo 'Error en el sistema...';
                                die;
                             }    
                             $hora_1 = $FechasOld[0]['HoraInicio'];
                             $hora_2 = $FechasOld[0]['HoraFin'];
                             
                             if(count($FechasOld)>=count($FechasNew[0])){
                                $Num = count($FechasOld);
                             }else{
                                $Num = count($FechasNew[0]);
                             }
                            
                             for($i=0;$i<$Num;$i++){
                                if($FechasOld[$i]['AsignacionEspaciosId'] && $FechasNew[0][$i]){
                                   //***Modifica fecha y activa a 100**//   
                                    $C_DatosDia  = explode('-',$FechasNew[0][$i]);
                                    
                                    $dia   = $C_DatosDia[2];
                                    $mes   = $C_DatosDia[1];
                                    $year  = $C_DatosDia[0];
                                    
                                    $Festivo = $C_Festivo->esFestivo($dia,$mes,$year);
                                    $DomingoTrue = $C_AsignacionSalon->DiasSemana($FechasNew[0][$i]);     
                                    if($Festivo==false){//$Festivo No es Festivo
                                        if(($DomingoTrue!=7) || ($DomingoTrue!='7')){
                                        $ModificarFecha = array();
                                        $CondicionFecha = array();
                                        $ModificarFecha['campo'][] = 'codigoestado';
                                        $ModificarFecha['valor'][] = '100';
                                        $ModificarFecha['campo'][] = 'FechaAsignacion';
                                        $ModificarFecha['valor'][] = $FechasNew[0][$i];
                                        $ModificarFecha['campo'][] = 'FechaAsignacionAntigua';
                                        $ModificarFecha['valor'][] = $FechasOld[$i]['FechaAsignacion'];
                                        $ModificarFecha['campo'][] = 'UsuarioUltimaModificacion';
                                        $ModificarFecha['valor'][] = $userid;
                                        $ModificarFecha['campo'][] = 'FechaultimaModificacion';
                                        $ModificarFecha['valor'][] = date('Y-m-d H:i:s');
                                        $CondicionFecha['campo'][] = 'SolicitudAsignacionEspacioId';
                                        $CondicionFecha['valor'][] = $Solicitudes[$j]['id'];
                                        $CondicionFecha['campo'][] = 'AsignacionEspaciosId';
                                        $CondicionFecha['valor'][] = $FechasOld[$i]['AsignacionEspaciosId'];
                                        
                                        $this->UpdateSolicitudesAll($db,'AsignacionEspacios',$ModificarFecha,$CondicionFecha,true);
                                        }//diferente de domingo    
                                    }
                                }else{
                                    if((!$FechasOld[$i]['AsignacionEspaciosId'] || $FechasOld[$i]['AsignacionEspaciosId']='') && $FechasNew[0][$i]){
                                       //****Inserta en Asignacion nueva fecha***//  
                                       $C_DatosDia  = explode('-',$FechasNew[0][$i]);
                                        
                                       $dia   = $C_DatosDia[2];
                                       $mes   = $C_DatosDia[1];
                                       $year  = $C_DatosDia[0]; 
                                       
                                       $Festivo = $C_Festivo->esFestivo($dia,$mes,$year);
                                       $DomingoTrue = $C_AsignacionSalon->DiasSemana($FechasNew[0][$i]);     
                                       if($Festivo==false){//$Festivo No es Festivo
                                           if(($DomingoTrue!=7) || ($DomingoTrue!='7')){
                                           $NuevoRegistroAsigancion = array(); 
                                           $NuevoRegistroAsigancion['campo'][]  = 'FechaAsignacion';
                                           $NuevoRegistroAsigancion['valor'][]  = $FechasNew[0][$i];
                                           $NuevoRegistroAsigancion['campo'][]  = 'SolicitudAsignacionEspacioId';
                                           $NuevoRegistroAsigancion['valor'][]  = $Solicitudes[$j]['id'];
                                           $NuevoRegistroAsigancion['campo'][]  = 'UsuarioCreacion';
                                           $NuevoRegistroAsigancion['valor'][]  = $userid;
                                           $NuevoRegistroAsigancion['campo'][]  = 'UsuarioUltimaModificacion';
                                           $NuevoRegistroAsigancion['valor'][]  = $userid;
                                           $NuevoRegistroAsigancion['campo'][]  = 'FechaCreacion';
                                           $NuevoRegistroAsigancion['valor'][]  = date('Y-m-d H:i:s');
                                           $NuevoRegistroAsigancion['campo'][]  = 'FechaultimaModificacion';
                                           $NuevoRegistroAsigancion['valor'][]  = date('Y-m-d H:i:s');
                                           $NuevoRegistroAsigancion['campo'][]  = 'ClasificacionEspaciosId';
                                           $NuevoRegistroAsigancion['valor'][]  = '212';
                                           $NuevoRegistroAsigancion['campo'][]  = 'HoraInicio';
                                           $NuevoRegistroAsigancion['valor'][]  = $hora_1;
                                           $NuevoRegistroAsigancion['campo'][]  = 'HoraFin';
                                           $NuevoRegistroAsigancion['valor'][]  = $hora_2;
                                           $this->InsertAllData($db,'AsignacionEspacios',$NuevoRegistroAsigancion,true);
                                            }//diferente de domingo       
                                       }
                                    }                            
                                }
                                
                             }//for   
                    }   
            }//for
            
        }else{//Se elmina la solicitud
            $this->Eliminar($db,$userid,$Padre);
        }
    }//function EditFechas
    function EliminarDia($userid,$hijo,$dia,$url='../'){
       include_once($ruta."templates/template.php");
       $db = getBD();
       
          $SQL='SELECT
                    s.SolicitudAsignacionEspacioId
                FROM
                    SolicitudAsignacionEspacios s 
                WHERE
                    s.SolicitudAsignacionEspacioId="'.$hijo.'"
                    AND
                    s.codigodia="'.$dia.'"
                    AND
                    s.codigoestado=100';   
                    
            if($Dato=&$db->Execute($SQL)===false){
                echo 'Error en el Sistema...';
                die;
            }      
            
            if(!$Dato->EOF){
                
                $SQL_P='SELECT
                        	SolicitudPadreId
                         FROM
                        	AsociacionSolicitud
                         WHERE
                        	SolicitudAsignacionEspaciosId = "'.$hijo.'"';
                            
                  if($DatoPadre=&$db->Execute($SQL_P)===false){
                     echo 'Error en el Sistema...';
                     die;
                  }   
                  
                  $SQL_Num='SELECT
                            	COUNT(SolicitudPadreId) AS num
                            FROM
                            	AsociacionSolicitud a
                            INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId
                            WHERE
                            	a.SolicitudPadreId = "'.$DatoPadre->fields['SolicitudPadreId'].'"
                            AND s.codigoestado = 100';   
                            
                  if($DatoNum=&$db->Execute($SQL_Num)===false){
                     echo 'Error en el Sistema...';
                     die;
                  }  
                  
                  if($DatoNum->fields['num']==1){
                     //***Elimina Solicitud Padre***//
                     $DatosModificarPadre['campo'][]  = 'CodigoEstado';
                     $DatosModificarPadre['valor'][]  = '200';
                     $DatosModificarPadre['campo'][]  = 'UsuarioUltimaModificacion';
                     $DatosModificarPadre['valor'][]  = $userid;
                     $DatosModificarPadre['campo'][]  = 'FechaUltimaModificacion';
                     $DatosModificarPadre['valor'][]  = date('Y-m-d H:i:s');
                     $DatosCondicionPadre['campo'][]  = 'SolicitudPadreId';
                     $DatosCondicionPadre['valor'][]  = $DatoPadre->fields['SolicitudPadreId'];
                     $this->UpdateSolicitudesAll($db,'SolicitudPadre',$DatosModificarPadre,$DatosCondicionPadre);
                  }             
                    //***Elimina Grupos***//
                    $DatosModificarGrupo['campo'][] = 'codigoestado';
                    $DatosModificarGrupo['valor'][] = '200';
                    $DatoCondicionGrupo['campo'][]  = 'SolicitudAsignacionEspacioId';
                    $DatoCondicionGrupo['valor'][]  = $hijo;
                    
                    $this->UpdateSolicitudesAll($db,'SolicitudEspacioGrupos',$DatosModificarGrupo,$DatoCondicionGrupo);                 
                    //***Elimina Fechas y Salones Asignados***// 
                    $DatosModificarAsignacion['campo'][] = 'codigoestado';
                    $DatosModificarAsignacion['valor'][] = '200';
                    $DatosModificarAsignacion['campo'][] = 'ClasificacionEspaciosId';
                    $DatosModificarAsignacion['valor'][] = '212';
                    $DatosModificarAsignacion['campo'][] = 'UsuarioUltimaModificacion';
                    $DatosModificarAsignacion['valor'][] = $userid;
                    $DatosModificarAsignacion['campo'][] = 'FechaultimaModificacion';
                    $DatosModificarAsignacion['valor'][] = date('Y-m-d H:i:s');
                    $DatoCondicionAsignacion['campo'][]  = 'SolicitudAsignacionEspacioId';
                    $DatoCondicionAsignacion['valor'][]  = $hijo;
                    
                    $this->UpdateSolicitudesAll($db,'AsignacionEspacios',$DatosModificarAsignacion,$DatoCondicionAsignacion); 
                    //***Elimina Solicitud Espacios Detalle 󠈩jos***//
                    $datosModificarSolicitud['campo'][] = 'codigoestado';
                    $datosModificarSolicitud['valor'][] = '200';
                    $datosModificarSolicitud['campo'][] = 'UsuarioUltimaModificacion';
                    $datosModificarSolicitud['valor'][] = $userid;
                    $datosModificarSolicitud['campo'][] = 'FechaUltimaModificacion';
                    $datosModificarSolicitud['valor'][] = date('Y-m-d H:i:s');
                    $DatoCondicionSolicitud['campo'][]  = 'SolicitudAsignacionEspacioId';
                    $DatoCondicionSolicitud['valor'][]  = $hijo;
                    $this->UpdateSolicitudesAll($db,'SolicitudAsignacionEspacios',$datosModificarSolicitud,$DatoCondicionSolicitud);
            }   
    }//function EliminarDia
    function ValidarFechasCambio($fecha_1,$fecha_2,$padre,$ruta='../'){
         include_once($ruta."templates/template.php");
         
         $db = getBD(); 
         
          $SQL='SELECT
                        SolicitudPadreId,
                        SolicitudAsignacionEspaciosId AS id
                FROM
                        AsociacionSolicitud 
                WHERE
                        SolicitudPadreId="'.$padre.'"';
                        
                   
                if($DatosDetalle=&$db->GetAll($SQL)===false){
                    echo 'Error en el Sistema...';
                    die;
                }  
        $Num = count($DatosDetalle);
        
        $C = 0;
        
        for($i=0;$i<$Num;$i++){
                
           $SQL_Validacion='SELECT
                            	SolicitudAsignacionEspacioId
                            FROM
                            	SolicitudAsignacionEspacios
                            WHERE
                            	SolicitudAsignacionEspacioId = "'.$DatosDetalle[$i]['id'].'"
                            AND FechaInicio = "'.$fecha_1.'"
                            AND FechaFinal = "'.$fecha_2.'"';
                            
            if($Valida=&$db->Execute($SQL_Validacion)===false){
                echo 'Erroe en el Sistema...';die;
            }                
            
            if($Valida->EOF){
                $C = $C+1; 
            }
                            
         }// for
         
         if($C>=1){
            return true;
         }else{
            return false;
         }                         
    }//function ValidarFechasCambio
}//class

?>