<?php
class CambioEstadoSolicitud{
    public function BuscarSolicitudes($db,$userid){
        
        $SQL='SELECT
                    	s.SolicitudAsignacionEspacioId AS id,
                    	t.nombretiposalon,
                    	c.Nombre,
                    	sg.idgrupo,
                    	s.FechaCreacion,
                    	s.FechaInicio,
                    	s.FechaFinal,
                    	s.AccesoDiscapacitados,
                    	s.Estatus,
                    	p.periodicidad,
                    	d.nombredia,
                    	CASE s.Estatus 
                    WHEN 1 THEN
                    	"Pendiente"
                    WHEN 2 THEN
                    	"Parcial"
                    WHEN 3 THEN
                    	"Atendida"
                    END AS Estadotext
                    
            FROM
            
            	SolicitudAsignacionEspacios s
                                                INNER JOIN siq_periodicidad p ON p.idsiq_periodicidad = s.idsiq_periodicidad
                                                INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = s.ClasificacionEspaciosId
                                                INNER JOIN dia d ON d.codigodia = s.codigodia
                                                INNER JOIN SolicitudEspacioGrupos sg ON s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
                                                INNER JOIN SolicitudAsignacionEspaciostiposalon st ON s.SolicitudAsignacionEspacioId=st.SolicitudAsignacionEspacioId
                                                INNER JOIN tiposalon t ON t.codigotiposalon=st.codigotiposalon
                                                
            WHERE
                    	s.codigoestado = 100
                    AND t.codigoestado = 100
                    AND p.codigoestado = 100
                    AND s.Estatus<>3
                    
            
                        
            ORDER BY s.SolicitudAsignacionEspacioId'; 
            
            
          if($Solicitud=&$db->Execute($SQL)===false){
                echo 'Error Al Buscar Data...<br><br>'.$SQL;
                die;
          }   
          
          while(!$Solicitud->EOF){
            /********************************************************/
            $id_Solicitud  = $Solicitud->fields['id'];
            //echo '<br><br><span style="color: red;">'.$id_Solicitud.'</span>'; 
                $this->BuscarAsigancion($db,$id_Solicitud,$userid);
                         
            /********************************************************/
            $Solicitud->MoveNext();
          }//while           
    }//public function BuscarSolicitudes
    public function BuscarAsigancion($db,$id,$userid){
          /*********************************************/
          $NumPositivo = $this->ConsultaAsigancion($db,$id,0,'Numero');
          /*********************************************/
          $NumNegativo = $this->ConsultaAsigancion($db,$id,1,'Numero');
          
        
          /*********************************************/
          if($NumNegativo==0 || $NumNegativo=='0'){
            //Cambiar Estado aprobado 3
            //echo '<br><br><span style="color: blue;">Cambio a 3</span>';
           // $Data = $this->ConsultaAsigancion($db,$id,0,'Arreglo');
            $this->CambiarEstado($db,$id,3,$userid);
          }else{
            
            $Resultado = $NumPositivo-$NumNegativo;
            
            //$Data = $this->ConsultaAsigancion($db,$id,0,'Arreglo');
            
            if($Resultado>0 || $Resultado>'0'){
                //echo '<br><br><span style="color: green;">Cambio a 2</span>';
               $this->CambiarEstado($db,$id,2,$userid);
            }
          }
    }//public function BuscarAsigancion
    public function ConsultaAsigancion($db,$id,$op,$Data){
        if($op==1){
            $Condicion = ' AND a.ClasificacionEspaciosId=212';
        }else{
            $Condicion = '';
        }
        
        if($Data=='Arreglo'){
            $Group = ' GROUP BY s.SolicitudAsignacionEspacioId';
        }else{
            $Group = '';
        }
        
             $SQL='SELECT 
                    
                    s.FechaInicio,
                    s.FechaFinal,
                    sg.idgrupo
                    
                    FROM
                    
                    SolicitudAsignacionEspacios s INNER JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                    
                    WHERE
                    
                    s.SolicitudAsignacionEspacioId="'.$id.'"
                    AND
                    s.codigoestado=100';
                    
                  
                    
              if($DataUno=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de Datas Uno...<br><br>'.$SQL;
                die;
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
                        	SolicitudEspacioGrupos sg
                        INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
                        INNER JOIN dia d ON d.codigodia = s.codigodia
                        INNER JOIN ClasificacionEspacios c ON s.ClasificacionEspaciosId = c.ClasificacionEspaciosId
                        INNER JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                        INNER JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId=a.ClasificacionEspaciosId

                        
                        WHERE 
                        
                        s.codigoestado=100
                        AND
                        s.SolicitudAsignacionEspacioId="'.$id.'"'.$Condicion.$Group;
                        
                if($DataDos=&$db->Execute($SQL)===false){
                    echo'Error en el SQL data Dos...<br><br>'.$SQL;
                    die;
                }
                
            
                    $Data_Num = $DataDos->GetArray();
                
                 
            
            if($Data=='Numero'){
                return count($Data_Num);    
            }else if($Data=='Arreglo'){
                return $Data_Num;
            }
            
            
    }//public function ConsultaAsigancion
    public function CambiarEstado($db,$id,$Estado,$userid){
        
            
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
        
    }//public function CambiarEstado
}//class CambioEstadoSolicitud
?>