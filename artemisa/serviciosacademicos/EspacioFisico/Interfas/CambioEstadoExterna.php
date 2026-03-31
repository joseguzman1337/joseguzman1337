<?php

	include("../templates/template.php");
	
    include_once('InterfazSolicitud_class.php'); $C_InterfazSolicitud = new InterfazSolicitud();
        
    	
	$db = getBD();
    
    $userid = '4186';
    
    $Fechas = $C_InterfazSolicitud->FechasPeriodo($db);
    
    if($Fechas['val']==true){
            $C_fecha = explode('-',$Fechas['FechaFin']);
           if($C_fecha[1]==06 || $C_fecha[1]=='06'){
                $Fechaini_2 = $C_fecha[0].'-07-01';
                $Fechafin_2 = $C_fecha[0].'-12-31';
            }if($C_fecha[1]==12 || $C_fecha[1]=='12'){
                $year       = $C_fecha[0]+1;
                $Fechaini_2 = $year.'-01-01';
                $Fechafin_2 = $year.'-06-30';
            }
             $CondicionFecha = ' AND (FechaInicio>="'.$Fechas['FechaIni'].'" )';//AND s.FechaFinal<="'.$Fechas['FechaFin'].'"  OR  s.FechaInicio>="'.$Fechaini_2.'" AND s.FechaFinal<="'.$Fechafin_2.'"
             //$CondicionFecha = '';
        }else{
            $CondicionFecha = '';
    }
    
    $SQL='SELECT

            SolicitudAsignacionEspacioId AS id
            
          FROM
            SolicitudAsignacionEspacios 
          WHERE
            codigoestado=100
            AND
            codigomodalidadacademica<>001
            '.$CondicionFecha.'
            AND
            Estatus=1';
            
            
     if($Solicitudes_id=&$db->Execute($SQL)===false){
        echo 'Error en el SQL de las Solicitudes Externas....<br><br>'.$SQL;
        die;
     } 
     $i=1;
     while(!$Solicitudes_id->EOF){
        /*****************************************************************/
            $id = $Solicitudes_id->fields['id'];
           
              BuscarAsigancion($db,$id,$userid);
        /*****************************************************************/
        $i++;
        $Solicitudes_id->MoveNext();
     }      
 function BuscarAsigancion($db,$id,$userid){
    /*********************************************/
         $NumPositivo = ConsultaAsigancion($db,$id,0);
          /*********************************************/
         $NumNegativo = ConsultaAsigancion($db,$id,1);
        
          /*********************************************/
          if($NumNegativo==0 || $NumNegativo=='0'){
            //Cambiar Estado aprobado 3
            CambiarEstado($db,$id,3,$userid);
          }else{
            
            $Resultado = $NumPositivo-$NumNegativo;
            
            if($Resultado>0 || $Resultado>'0'){
               CambiarEstado($db,$id,2,$userid);
            }
          }
 }//function BuscarAsigancion
 function ConsultaAsigancion($db,$id,$op){
        if($op==1){
            $Condicion = ' AND a.ClasificacionEspaciosId=212';
        }else{
            $Condicion = '';
        }
          
                   $SQL='SELECT
                            s.SolicitudAsignacionEspacioId AS id,
                            s.codigodia,
                            d.nombredia,
                            s.ClasificacionEspaciosId AS Sede,
                            c.Nombre,
                            a.AsignacionEspaciosId,
                            a.ClasificacionEspaciosId,
                            cc.Nombre
                            
                            FROM
                             SolicitudAsignacionEspacios s 
                            INNER JOIN dia d ON d.codigodia = s.codigodia
                            INNER JOIN ClasificacionEspacios c ON s.ClasificacionEspaciosId = c.ClasificacionEspaciosId
                            INNER JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                            INNER JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId=a.ClasificacionEspaciosId
    
                            
                            WHERE 
                            s.codigoestado=100
                            AND
                            s.SolicitudAsignacionEspacioId="'.$id.'"'.$Condicion;
                        
                        if($DataDos=&$db->Execute($SQL)===false){
                            echo'Error en el SQL data Dos...<br><br>'.$SQL;
                            die;
                        }
                
                $Data_Num = $DataDos->GetArray();
                 
            
                return count($Data_Num);    
           
            
            
    }// function ConsultaAsigancion
     function CambiarEstado($db,$id,$Estado,$userid){
            
          $SQL='UPDATE SolicitudAsignacionEspacios
                   SET    Estatus="'.$Estado.'",
                          UsuarioUltimaModificacion="'.$userid.'",
                          FechaUltimaModificacion=NOW()
                   WHERE  codigoestado=100 AND SolicitudAsignacionEspacioId="'.$id.'"';
                  
                   if($Cambio=&$db->Execute($SQL)===false){
                        echo 'Error en el Cambio de Estado....<br><br>'.$SQL;
                        die;
                   }
            /************************************************/
            
    }// function CambiarEstado

?>