<?php
class ConsolaNotificaciones{
    public function InfoConsola($db){
          $SQL='SELECT

                a.SolicitudAsignacionEspacioId AS id,
                a.FechaultimaModificacion,
                a.FechaAsignacion,
                s.codigocarrera,
                s.ClasificacionEspaciosId,
                c.nombrecarrera,
                CONCAT(g.nombregrupo," :: ",g.idgrupo) AS InfoGrupo,
                m.nombremateria,
                cc.Nombre AS Sede  
                
                FROM
                
                AsignacionEspacios a INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspacioId
                                     INNER JOIN carrera c ON c.codigocarrera=s.codigocarrera
                                     INNER JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId=s.ClasificacionEspaciosId
                                     LEFT JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                                     LEFT JOIN grupo g ON g.idgrupo=sg.idgrupo
                                     LEFT JOIN materia m ON m.codigomateria=g.codigomateria
                
                WHERE
                
                a.Modificado = 1
                AND
                a.Enviado=0
                AND
                DATE(a.FechaultimaModificacion)>=CURDATE()
                AND
                s.codigoestado=100
                AND (sg.codigoestado=100 OR sg.codigoestado IS NULL)
		AND  s.codigomodalidadacademica=001
                
                GROUP BY a.SolicitudAsignacionEspacioId';
                
                if($Info=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL de Informacion de Notificaciones....<br><BR>'.$SQL;
                    die;
                }
                
            $Data = $Info->GetArray();
            
            return $Data;    
    }//public function InfoConsola
}//class
?>
