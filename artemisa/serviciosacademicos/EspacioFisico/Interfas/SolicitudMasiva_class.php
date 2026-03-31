<?php
class SolicitudMasiva{
    public function Inicio($db,$userid,$periodo){
        if($_SESSION['codigofacultad']==1 || $_SESSION['codigofacultad']==156){
             $a_vectt['val'] = false;
             $a_vectt['descrip'] = 'Por favor selecionar o indicar una carrera o programa académico.';
             echo json_encode($a_vectt);
             exit; 
        }else{
            $this->Continuar($db,$userid,$periodo,$_SESSION['codigofacultad']);
        }
    }//public function Inicio
    public function Continuar($db,$userid,$periodo,$carrera){
          $Grupos = $this->GruposAll($db,$periodo,$carrera);
          
          for($i=0;$i<count($Grupos);$i++){
            /****************************************************/
            $Grupo_id     = $Grupos[$i]['idgrupo'];
            $Fecha_1      = $Grupos[$i]['fechainiciogrupo'];
            $Fecha_2      = $Grupos[$i]['fechafinalgrupo'];
            $Estudiantes  = $Grupos[$i]['maximogrupo'];
                        
            $ExisteSolicitud = $this->GrupoSolicitud($db,$Grupo_id,$periodo);
            
            if($ExisteSolicitud){
                $Info = $this->HorarioGrupo($db,$Grupo_id);
                
                if($Info['val']){ 
                    $Resultado['Grupo_id'][] = $Grupo_id;
                    $Resultado['Carrera']   =  $carrera;
                    $Resultado[$Grupo_id] = $this->InsertarSolicitud($db,$Grupo_id,$Info,$Fecha_1,$Fecha_2,$Estudiantes,$carrera,$userid);
                }
            }
            /****************************************************/
          }//for 
          //echo '<pre>';print_r($Resultado);
          $this->PintarResultado($db,$Resultado);
    }//public function Continuar
    public function GruposAll($db,$periodo,$carrera){
          $SQL='SELECT 
                g.idgrupo,
                m.codigomateria,
                c.codigocarrera,
                g.codigoperiodo,
                g.fechainiciogrupo,
				g.fechafinalgrupo,
                g.maximogrupo
                
                FROM grupo g 
                INNER JOIN materia m ON g.codigomateria=m.codigomateria
                INNER JOIN carrera c ON c.codigocarrera=m.codigocarrera  
                AND g.codigoperiodo="'.$periodo.'" 
                AND c.codigocarrera="'.$carrera.'" 
                AND g.codigoestadogrupo=10';
                
           if($Grupos=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de Buscar Grupos Periodo Carrera...<br><br>'.$SQL;
                die;
           }    
           
           $C_Grupos = $Grupos->GetArray();
           
           Return $C_Grupos; 
    }//public function GruposAll
    public function GrupoSolicitud($db,$Grupo_id,$periodo){
          $SQL='SELECT 
                g.idgrupo,
                sg.SolicitudAsignacionEspacioId AS id
                
                FROM grupo g 
                INNER JOIN SolicitudEspacioGrupos sg ON sg.idgrupo=g.idgrupo 
                INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=sg.SolicitudAsignacionEspacioId 
                AND s.codigoestado=100
                AND sg.codigoestado=100 
                AND g.idgrupo="'.$Grupo_id.'" 
                AND g.codigoestadogrupo=10 
                AND g.codigoperiodo="'.$periodo.'"';
                
          if($Existe=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de Buscar Grupos Periodo Solicitud...<br><br>'.$SQL;
                die;
           }
           
          if(!$Existe->EOF){
               Return false; 
          }else{
               Return true;
          }         
    }//public function GrupoSolicitud
    public function HorarioGrupo($db,$Grupo_id){
          $SQL='SELECT
                	codigodia,
                	horainicial,
                	horafinal,
                	codigotiposalon
                FROM
                	horario
                WHERE
                	idgrupo ="'.$Grupo_id.'"
                AND codigoestado = 100';
          
          if($Horario=&$db->Execute($SQL)===false){
                echo 'Error en el SQL del Horario del Grupo...<br><br>'.$SQL;
                die;
          }      
          
          if(!$Horario->EOF){
               $Resultado['val']    = true;
               while(!$Horario->EOF){
                
                   $Resultado['Dia'][]    = $Horario->fields['codigodia'];
                   $Resultado['Hora_1'][] = $Horario->fields['horainicial'];
                   $Resultado['Hora_2'][] = $Horario->fields['horafinal'];
                   $Resultado['Salon'][]  = $Horario->fields['codigotiposalon'];
                    
                $Horario->MoveNext();
               }
          }else{
               $Resultado['val']    = false;
          }      
          
          return $Resultado;
    }//public function HorarioGrupo
    public function InsertarSolicitud($db,$Grupo_id,$Info,$Fecha_1,$Fecha_2,$Estudiantes,$carrera,$userid){
        
        include_once('../Solicitud/AsignacionSalon.php');   $C_AsignacionSalon = new AsignacionSalon();
        include_once('../Solicitud/festivos.php');          $C_Festivo         = new festivos();
        include_once('ValidaSolicitud_Class.php');          $C_ValidaSolicitud = new ValidaSolicitud();
        include_once('../Solicitud/SolicitudEspacio_class.php'); $C_SolicitudEspacio = new SolicitudEspacio();
        
        $C_Resultado = array();
        
        $C_Info['Grupo_id']   =  $Grupo_id;
        $C_Info['NumEstudiantes'] =  $Estudiantes;
        $C_Info['FechaIni'] =  $Fecha_1;
        $C_Info['FechaFin'] =  $Fecha_2;
        for($i=0;$i<count($Info['Salon']);$i++){
            $C_Info['TipoSalon'][]      =  $Info['Salon'][$i];
            $C_Info['DiaSemana'][]      =  $Info['Dia'][$i];  
            $C_Info['Campus'][]         =  4;          
            $C_Info['HoraInicial'][]    =  $Info['Hora_1'][$i];
            $C_Info['HoraFin'][]        =  $Info['Hora_2'][$i];
        }//for
        $Acceso = 0;
        /************************************************************************/   
      
        $Result = $C_SolicitudEspacio->FechasFuturas('35',$Fecha_1,$Fecha_2,$C_Info['DiaSemana']);
        
        /*************************Inser Solicitu Padre***************************/
       $SQL_InsertPadre='INSERT INTO SolicitudPadre(UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaUltimaModificacion)VALUES("'.$userid.'","'.$userid.'",NOW(),NOW())';
            
           if($InsertPadre=&$db->Execute($SQL_InsertPadre)===false){
                echo 'Error en el sql del Padre id Solicud...<br><BR>'.$SQL_InsertPadre;
                die;
            }              
       

       $SolicituPadre = $Last_id=$db->Insert_ID();
       
       $C_Resultado['SolicitudPadre']   =  $SolicituPadre;
       
       for($j=0;$j<count($C_Info['DiaSemana']);$j++){
       
           $SQL_Insert='INSERT INTO SolicitudAsignacionEspacios(AccesoDiscapacitados,FechaInicio,FechaFinal,idsiq_periodicidad,ClasificacionEspaciosId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaUltimaModificacion,codigodia,observaciones,codigocarrera)VALUES("'.$Acceso.'","'.$Fecha_1.'","'.$Fecha_2.'","35","'.$C_Info['Campus'][$j].'","'.$userid.'","'.$userid.'",NOW(),NOW(),"'.$C_Info['DiaSemana'][$j].'","","'.$carrera.'")';
            
            if($InsertSolicituNew=&$db->Execute($SQL_Insert)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error al Insertar Solicitud..';
                echo json_encode($a_vectt);
                exit;
            }
            
            ##########################
            $Last_id=$db->Insert_ID();
            ##########################
            
            $C_Resultado['Hijo'][$SolicituPadre][]      =  $Last_id;
            $C_Resultado['Fecha_1'][$SolicituPadre][]   = $Fecha_1;
            $C_Resultado['Fecha_2'][$SolicituPadre][]   = $Fecha_2;
            $C_Resultado['Campus'][$SolicituPadre][]    = $C_Info['Campus'][$j];
            $C_Resultado['DiaSemana'][$SolicituPadre][] = $C_Info['DiaSemana'][$j];
            $C_Resultado['Hora_1'][$SolicituPadre][] = $C_Info['HoraInicial'][$j];
            $C_Resultado['Hora_2'][$SolicituPadre][] = $C_Info['HoraFin'][$j];
            
            /**********************Insert Asociacion Solicitud**********************/
             $SQL='SELECT * FROM AsociacionSolicitud WHERE SolicitudAsignacionEspaciosId="'.$Last_id.'"';   
                            
              if($Valida=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de la Validacion ....<br><br>'.$SQL;
                die;
              }  
                    
             if($Valida->EOF){
                $SQL_InsertAsociacion='INSERT INTO AsociacionSolicitud(SolicitudPadreId,SolicitudAsignacionEspaciosId)VALUES("'.$SolicituPadre.'","'.$Last_id.'")';
                                
                if($InsertAsociacion=&$db->Execute($SQL_InsertAsociacion)===false){
                    echo 'Error en el SQL de la Asociacion....<br><br>'.$SQL_InsertAsociacion;
                    die;
                 }
             }//VALIDAR   
             
             $InserGrupo='INSERT INTO SolicitudEspacioGrupos(SolicitudAsignacionEspacioId,idgrupo)VALUES("'.$Last_id.'","'.$Grupo_id.'")';  
                 
             if($GrupoSolicitud=&$db->Execute($InserGrupo)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error al Insertar Solicitud Grupo..';
                echo json_encode($a_vectt);
                exit;
             }  
             
             $SQL_TipoSalon='INSERT INTO SolicitudAsignacionEspaciostiposalon(SolicitudAsignacionEspacioId,codigotiposalon)VALUES("'.$Last_id.'","'.$C_Info['TipoSalon'][$j].'")';
         
             if($SolicitudTipoSalon=&$db->Execute($SQL_TipoSalon)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error al Insertar Solicitud Tipo Salon..';
                echo json_encode($a_vectt);
                exit;
             }
             
             /**********************Asignacion Fechas**********************************/
             
             for($x=0;$x<count($Result[$j]);$x++){
                /*******************************************************/
                 $C_DatosDia  = explode('-',$Result[$j][$x]);
                    
                 $dia   = $C_DatosDia[2];
                 $mes   = $C_DatosDia[1];
                 $year  = $C_DatosDia[0];                
                
                 $Festivo = $C_Festivo->esFestivo($dia,$mes,$year);
                 $DomingoTrue = $C_AsignacionSalon->DiasSemana($Fecha);
                 if($Festivo==false){//$Festivo No es Festivo
                    if(($DomingoTrue!=7) || ($DomingoTrue!='7')){
                    $Fecha  = $Result[$j][$x];
                    $Hora_1 = $C_Info['HoraInicial'][$j];
                    $Hora_2 = $C_Info['HoraFin'][$j]; 
                    
                    $Asignacion='INSERT INTO AsignacionEspacios(FechaAsignacion,SolicitudAsignacionEspacioId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion,ClasificacionEspaciosId,HoraInicio,HoraFin)VALUES("'.$Fecha.'","'.$Last_id.'","'.$userid.'","'.$userid.'",NOW(),NOW(),"212","'.$Hora_1.'","'.$Hora_2.'")';
                
                       if($InsertAsignar=&$db->Execute($Asignacion)===false){
                            $a_vectt['val']			=false;
                            $a_vectt['descrip']		='Error al Insertar Asignacion del Espacio..';
                            echo json_encode($a_vectt);
                            exit;
                        }
                    }//Diferente de domingo
                 }
                /*******************************************************/
             }//for
            
       }//for    
        
        return $C_Resultado;
    }//public function InsertarSolicitud
    public function PintarResultado($db,$Resultado){
        ?>
        <table border=1 align="center">
            <thead>
                <tr>
                    <th colspan="7">Programa Académico o Carrera</th>
                </tr>
                <tr>
                    <th colspan="7"><?PHP echo $NombreCarrera  = $this->Carrera($db,$Resultado['Carrera']);?></th>
                </tr>
            </thead>
            <tbody>
                <?PHP 
                for($i=0;$i<count($Resultado['Grupo_id']);$i++){
                    $C_Grupo = $this->GrupoName($db,$Resultado['Grupo_id'][$i]);
                    ?>
                    <tr>
                        <td>Grupo</td>
                        <td colspan="2"><?PHP echo $C_Grupo['Grupo'];?></td>
                        <td>Materia</td>
                        <td colspan="3"><?PHP echo $C_Grupo['Materia'];?></td>
                    </tr>
                    <?PHP
                    if($i==0 || $i<1){ 
                    ?>
                    <tr>
                        <td>Solicitud ID</td>
                        <td>Solicitud Detalle</td>
                        <td>Fecha Inicial</td>
                        <td>Fecha Final</td>
                        <td>Dia Semana</td>
                        <td>Hora Inicial</td>
                        <td>Hora Final</td>
                    </tr>
                    <?PHP
                    }
                    //echo '<pre>';print_r($Resultado[$Resultado['Grupo_id'][$i]]['Hijo'][$Resultado[$Resultado['Grupo_id'][$i]]['SolicitudPadre']]);die;
                    for($j=0;$j<count($Resultado[$Resultado['Grupo_id'][$i]]['Hijo'][$Resultado[$Resultado['Grupo_id'][$i]]['SolicitudPadre']]);$j++){
                        $Padre    = $Resultado[$Resultado['Grupo_id'][$i]]['SolicitudPadre'];
                        $Hijo     = $Resultado[$Resultado['Grupo_id'][$i]]['Hijo'][$Padre][$j];
                        $Fecha_1  = $Resultado[$Resultado['Grupo_id'][$i]]['Fecha_1'][$Padre][$j];
                        $Fecha_2  = $Resultado[$Resultado['Grupo_id'][$i]]['Fecha_2'][$Padre][$j];
                        $Dia      = $Resultado[$Resultado['Grupo_id'][$i]]['DiaSemana'][$Padre][$j];
                        $Hora_1   = $Resultado[$Resultado['Grupo_id'][$i]]['Hora_1'][$Padre][$j];
                        $Hora_2   = $Resultado[$Resultado['Grupo_id'][$i]]['Hora_2'][$Padre][$j];
                        ?>
                        <tr>
                            <td><?PHP echo $Padre?></td>
                            <td><?PHP echo $Hijo?></td>
                            <td><?PHP echo $Fecha_1?></td>
                            <td><?PHP echo $Fecha_2?></td>
                            <td><?PHP echo $NombreDia = $this->DiaNombre($db,$Dia);?></td>
                            <td><?PHP echo $Hora_1?></td>
                            <td><?PHP echo $Hora_2?></td>
                        </tr>
                        <?PHP
                    }//for
                }//for
                ?>
            </tbody>
        </table>
        
        <?PHP
    }//public function PintarResultado
    public function DiaNombre($db,$dia){
        $SQL='SELECT codigodia, nombredia FROM dia WHERE codigodia="'.$dia.'"';
        
        if($Dia=&$db->Execute($SQL)===false){
            echo 'Error en el SQL del Dia...<br><br>'.$SQL;
            die;
        }
        
        Return $Dia->fields['nombredia'];
    }//public function DiaNombre
    public function Carrera($db,$carrera){
          $SQL='SELECT
                	codigocarrera,
                	nombrecarrera
                FROM
                	carrera
                WHERE
                	codigocarrera ="'.$carrera.'"';
        
        if($CarreraData=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de la Info carrera...<br>'.$SQL;
            die;
        }
        
        return $CarreraData->fields['codigocarrera'].' :: '.$CarreraData->fields['nombrecarrera'];
    }//public function Carrera
    public function GrupoName($db,$Grupo_id){
        $SQL='SELECT
              CONCAT(g.idgrupo," :: ",g.nombregrupo) AS GrupoName,
              CONCAT(m.codigomateria," :: ",m.nombremateria) AS MateriaName
              FROM
              grupo g INNER JOIN materia m ON m.codigomateria= g.codigomateria
            
              WHERE
            
              g.idgrupo="'.$Grupo_id.'"';
        
        if($GrupoName=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Grupo Info...<br>'.$SQL;
            die;
        }
        
        $C_Grupo['Grupo']     =  $GrupoName->fields['GrupoName'];
        $C_Grupo['Materia']   =  $GrupoName->fields['MateriaName'];
        
        return $C_Grupo;
    }//public function GrupoName
}//calss

?>