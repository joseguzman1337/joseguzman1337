<?PHP 
include("../templates/template.php");
		
		$db = getBD();

  $SQL='SELECT
        s.SolicitudAsignacionEspacioId,
        s.FechaInicio,
        s.FechaFinal,
        g.idgrupo,
        s.codigodia,
        s.UsuarioCreacion
        FROM
        SolicitudAsignacionEspacios s INNER JOIN SolicitudEspacioGrupos g ON g.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
        WHERE
        s.FechaInicio >= "2015-07-01"
        AND s.codigomodalidadacademica = 001
        AND s.codigoestado = 100';
        
   if($Info=&$db->Execute($SQL)===false){
        echo 'Error en el SQL ....<br>'.$SQL;
        die;
   }  
   $i = 0;
   while(!$Info->EOF){
            
            $Solicitud_id = $Info->fields['SolicitudAsignacionEspacioId'];
            
            
            $SQL_X='SELECT
                    a.ClasificacionEspaciosId
                    FROM
                    AsignacionEspacios a
                    
                    WHERE  a.codigoestado=100 and a.SolicitudAsignacionEspacioId="'.$Solicitud_id.'"';
                    
                    if($Info2=&$db->Execute($SQL_X)===false){
                        echo 'Error al Calcular Atendidas...<br><br>'.$SQL_X;
                        die;
                    }
                $O=0;
                $N=0;    
                $Z=0;  
              while(!$Info2->EOF){
                /************************************/
                if($Info2->fields['ClasificacionEspaciosId']!=212){
                    $O= $O+1;
                }else{
                    $N=$N+1;
                }
                /************************************/
                $Info2->MoveNext();
              }   
            
            /*****************************************/
            $Z = $N+$O;
            if($Z<=1){
                $Resultado[$i]['Soli']         = $Solicitud_id;
                $Resultado[$i]['FechaInicio']  = $Info->fields['FechaInicio'];
                $Resultado[$i]['FechaFinal']   = $Info->fields['FechaFinal'];
                $Resultado[$i]['idgrupo']      = $Info->fields['idgrupo'];
                $Resultado[$i]['codigodia']    = $Info->fields['codigodia'];
                $Resultado[$i]['UsuarioCreacion']    = $Info->fields['UsuarioCreacion'];
                $Resultado[$i]['Num_Atendida'] = $O;
                $Resultado[$i]['Total']        = $Z; 
                $i++;
            }
        $Info->MoveNext();
        
     }//while   
     
     for($x=0;$x<count($Resultado);$x++){
           $id    = $Resultado[$x]['Soli'];
           $dia   = $Resultado[$x]['codigodia'];
           $Grupo = $Resultado[$x]['idgrupo'];
           $Fecha_1 = $Resultado[$x]['FechaInicio'];
           $Fecha_2 = $Resultado[$x]['FechaFinal'];
           $userid  = $Resultado[$x]['UsuarioCreacion'];
           
           if($id){
              
               $SalonTrue = TieneSalon($db,$id,$dia,$Grupo);
               
               if($SalonTrue==1){
                
                    InsertFechas($db,$id,$dia,$Grupo,$Fecha_1,$Fecha_2,$userid);
               }
           }
     }//for
     
     function TieneSalon($db,$id,$dia,$Grupo){
          $SQL='SELECT
                *
                FROM
                SolicitudAsignacionEspaciostiposalon
                WHERE
                SolicitudAsignacionEspacioId="'.$id.'"';
                
         if($Validacion=&$db->execute($SQL)===false){
            Echo 'Error en el SQL de Salon Valida...<br><br>'.$SQL;
            die;
         }  
         
         if($Validacion->EOF){
            $Val = QueSalon($db,$dia,$Grupo,$id);
            return $Val;
         }else{
            Return 1;
         }     
     }//function TieneSalon
   function QueSalon($db,$dia,$Grupo,$id){
      $SQL='SELECT
                codigosalon,
                horainicial,
                horafinal
            FROM
                horario
            WHERE
                codigodia="'.$dia.'"
                AND
                idgrupo="'.$Grupo.'"
                AND
                codigoestado=100';
                
        if($QueSalon=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Que Salon Toca...<br><br>'.$SQL;
            die;
        }     
        
         
        
        if(!$QueSalon->EOF){
            if($QueSalon->fields['codigosalon']>=1 && $QueSalon->fields['codigosalon']<=9){
                $TipoSalon = '0'.$QueSalon->fields['codigosalon'];
            }else{
                $TipoSalon = $QueSalon->fields['codigosalon'];
            }
        }else{
            $TipoSalon = 0;
        }
        
         $SQL_TipoSalon='INSERT INTO SolicitudAsignacionEspaciostiposalon(SolicitudAsignacionEspacioId,codigotiposalon)VALUES("'.$id.'","'.$TipoSalon.'")';
         
            if($SolicitudTipoSalon=&$db->Execute($SQL_TipoSalon)===false){
                Echo 'Error en el SQL del Insert SAlon.....<br><br>'.$SQL_TipoSalon;
                die;
             }
             
        return 1;     
           
   }//function QueSalon  
   function InsertFechas($db,$id,$dia,$Grupo,$Fecha_1,$Fecha_2,$userid){ 
       include_once('../Solicitud/festivos.php');                 $C_Festivo                  = new festivos();
       include_once('../Solicitud/SolicitudEspacio_class.php');   $C_SolicitudEspacio         = new SolicitudEspacio();
       
       
       $SQL='SELECT
                codigosalon,
                horainicial,
                horafinal
            FROM
                horario
            WHERE
                codigodia="'.$dia.'"
                AND
                idgrupo="'.$Grupo.'"
                AND
                codigoestado=100';
                
        if($QueSalon=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Que Salon Toca...<br><br>'.$SQL;
            die;
        }    
        
        $C_DIA[0] = $dia;
       
        $FechasInfo =$C_SolicitudEspacio->FechasFuturas('35',$Fecha_1,$Fecha_2,$C_DIA);
        
        for($x=0;$x<count($C_DIA);$x++){
            for($l=0;$l<count($FechasInfo[$x]);$l++){
                $FechaFinal = explode('-',$FechasInfo[$x][$l]);
                
                $Es_Festivo = $C_Festivo->esFestivo($FechaFinal[2],$FechaFinal[1],$FechaFinal[0]);
                
                if($Es_Festivo===FALSE){
                    $Fecha  = $FechasInfo[$x][$l];
                    $Hora_1 = $QueSalon->fields['horainicial'];
                    $Hora_2 = $QueSalon->fields['horafinal'];
                    
                       $SQL_Asignacion='SELECT
                                        AsignacionEspaciosId
                                        FROM
                                        AsignacionEspacios
                                        WHERE
                                        FechaAsignacion="'.$Fecha.'"
                                        AND
                                        SolicitudAsignacionEspacioId="'.$id.'"
                                        AND
                                        codigoestado=100
                                        AND
                                        HoraInicio="'.$Hora_1.'"
                                        AND
                                        HoraFin="'.$Hora_2.'"';
                                        
                       if($ConsultaAsignacion=&$db->Execute($SQL_Asignacion)===false){
                            echo 'Error en el SQL de la Asignacion valida....<br><br>'.$SQL_Asignacion;
                            die;
                       }                 
                    
                    if($ConsultaAsignacion->EOF){
                     
                       $Asignacion='INSERT INTO AsignacionEspacios(FechaAsignacion,SolicitudAsignacionEspacioId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion,ClasificacionEspaciosId,HoraInicio,HoraFin)VALUES("'.$Fecha.'","'.$id.'","'.$userid.'","'.$userid.'",NOW(),NOW(),"212","'.$Hora_1.'","'.$Hora_2.'")';
                
                       if($InsertAsignar=&$db->Execute($Asignacion)===false){
                           Echo 'Error en el SQL de Insert Fechas...<br><br>'.$Asignacion;
                           die;
                        }
                    }
                }
            }//for
        }//for
   }//function InsertFechas 
?>