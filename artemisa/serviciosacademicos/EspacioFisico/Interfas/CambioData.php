<?php

include("../templates/template.php");
		
$db = getBD();

$SQL='SELECT
        z.*,
        x.codigodia,
        x.FechaInicio,
        x.FechaFinal
        FROM
        
        SolicitudAsignacionEspacios x INNER JOIN AsignacionEspacios z ON z.SolicitudAsignacionEspacioId=x.SolicitudAsignacionEspacioId
        
        where
        
        x.codigoestado=100
        AND
        x.codigodia=5
        AND
        z.FechaAsignacion="2015-04-10"
        AND
        z.codigoestado=100
        AND
        x.codigomodalidadacademica=001
        AND
        z.SolicitudAsignacionEspacioId NOT IN (
        SELECT
        s.SolicitudAsignacionEspacioId AS id
        FROM
        SolicitudAsignacionEspacios s INNER JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
        
        WHERE
        
        s.codigoestado=100
        AND
        s.codigodia=5
        AND
        a.FechaAsignacion="2015-04-17"
        AND
        a.codigoestado=100)
        AND
        x.FechaFinal>="2015-04-17"';
        
       if($Data=&$db->Execute($SQL)===false){
            echo 'Error en el SQL .....<br><br>'.$SQL;
            die;
       } 
       
       $C_Data = $Data->GetArray();
       
       //echo '<pre>';print_r($C_Data);
       /*
       [0] => Array
        (
            [0] => 189
            [AsignacionEspaciosId] => 189
            [1] => 2015-03-17
            [FechaAsignacion] => 2015-03-17
            [2] => 18
            [SolicitudAsignacionEspacioId] => 18
            [3] => 100
            [codigoestado] => 100
            [4] => 2114
            [UsuarioCreacion] => 2114
            [5] => 32957
            [UsuarioUltimaModificacion] => 32957
            [6] => 2014-11-12 11:37:53
            [FechaCreacion] => 2014-11-12 11:37:53
            [7] => 2015-01-14 17:43:19
            [FechaultimaModificacion] => 2015-01-14 17:43:19
            [8] => 176
            [ClasificacionEspaciosId] => 176
            [9] => 07:00:00
            [HoraInicio] => 07:00:00
            [10] => 09:00:00
            [HoraFin] => 09:00:00
            [11] => 1
            [EstadoAsignacionEspacio] => 1
            [12] => 
            [Observaciones] => 
            [13] => 0
            [Modificado] => 0
            [14] => 0
            [Enviado] => 0
            [15] => 
            [FechaAsignacionAntigua] => 
            [16] => 2
            [codigodia] => 2
            [17] => 2015-01-19
            [FechaInicio] => 2015-01-19
            [18] => 2015-06-04
            [FechaFinal] => 2015-06-04
        )
       */
       
       for($i=0;$i<count($C_Data);$i++){
        
        $FechaAsignacion                   = '2015-04-17';
        $SolicitudAsignacionEspacioId      = $C_Data[$i]['SolicitudAsignacionEspacioId'];
        $UsuarioCreacion                   = $C_Data[$i]['UsuarioCreacion'];
        $UsuarioUltimaModificacion         = $C_Data[$i]['UsuarioUltimaModificacion'];
        $FechaCreacion                     = $C_Data[$i]['FechaCreacion'];
        $FechaultimaModificacion           = $C_Data[$i]['FechaultimaModificacion'];
        $ClasificacionEspaciosId           = $C_Data[$i]['ClasificacionEspaciosId'];
        $HoraInicio                        = $C_Data[$i]['HoraInicio'];
        $HoraFin                           = $C_Data[$i]['HoraFin'];
        $EstadoAsignacionEspacio           = $C_Data[$i]['EstadoAsignacionEspacio'];
        $Observaciones                     = $C_Data[$i]['Observaciones'];
        $Modificado                        = $C_Data[$i]['Modificado'];
        $Enviado                           = $C_Data[$i]['Enviado'];
        
        $Asignacion='INSERT INTO AsignacionEspacios(FechaAsignacion,SolicitudAsignacionEspacioId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion,ClasificacionEspaciosId,HoraInicio,HoraFin,EstadoAsignacionEspacio,Observaciones,Modificado,Enviado)VALUES("'.$FechaAsignacion.'","'.$SolicitudAsignacionEspacioId.'","'.$UsuarioCreacion.'","'.$UsuarioUltimaModificacion.'","'.$FechaCreacion.'","'.$FechaultimaModificacion.'","'.$ClasificacionEspaciosId.'","'.$HoraInicio.'","'.$HoraFin.'","'.$EstadoAsignacionEspacio.'","'.$Observaciones.'","'.$Modificado.'","'.$Enviado.'")';
        
        if($EjecutarCambio=&$db->Execute($Asignacion)===false){
            echo 'Error en el SQL ...<br><br>'.$Asignacion;
            die;
        }
        
       }//for
       
       
       
 $SQL='SELECT
        z.*,
        x.codigodia,
        x.FechaInicio,
        x.FechaFinal
        FROM
        
        SolicitudAsignacionEspacios x INNER JOIN AsignacionEspacios z ON z.SolicitudAsignacionEspacioId=x.SolicitudAsignacionEspacioId
        
        where
        
        x.codigoestado=100
        AND
        x.codigodia=6
        AND
        z.FechaAsignacion="2015-04-11"
        AND
        z.codigoestado=100
        AND
        x.codigomodalidadacademica=001
        AND
        z.SolicitudAsignacionEspacioId NOT IN (
        SELECT
        s.SolicitudAsignacionEspacioId AS id
        FROM
        SolicitudAsignacionEspacios s INNER JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
        
        WHERE
        
        s.codigoestado=100
        AND
        s.codigodia=6
        AND
        a.FechaAsignacion="2015-04-18"
        AND
        a.codigoestado=100)
        AND
        x.FechaFinal>="2015-04-18"';
        
       if($Data=&$db->Execute($SQL)===false){
            echo 'Error en el SQL .....<br><br>'.$SQL;
            die;
       } 
       
       $C_Data = $Data->GetArray();
       
       //echo '<pre>';print_r($C_Data);
       /*
       [0] => Array
        (
            [0] => 189
            [AsignacionEspaciosId] => 189
            [1] => 2015-03-17
            [FechaAsignacion] => 2015-03-17
            [2] => 18
            [SolicitudAsignacionEspacioId] => 18
            [3] => 100
            [codigoestado] => 100
            [4] => 2114
            [UsuarioCreacion] => 2114
            [5] => 32957
            [UsuarioUltimaModificacion] => 32957
            [6] => 2014-11-12 11:37:53
            [FechaCreacion] => 2014-11-12 11:37:53
            [7] => 2015-01-14 17:43:19
            [FechaultimaModificacion] => 2015-01-14 17:43:19
            [8] => 176
            [ClasificacionEspaciosId] => 176
            [9] => 07:00:00
            [HoraInicio] => 07:00:00
            [10] => 09:00:00
            [HoraFin] => 09:00:00
            [11] => 1
            [EstadoAsignacionEspacio] => 1
            [12] => 
            [Observaciones] => 
            [13] => 0
            [Modificado] => 0
            [14] => 0
            [Enviado] => 0
            [15] => 
            [FechaAsignacionAntigua] => 
            [16] => 2
            [codigodia] => 2
            [17] => 2015-01-19
            [FechaInicio] => 2015-01-19
            [18] => 2015-06-04
            [FechaFinal] => 2015-06-04
        )
       */
       
       for($i=0;$i<count($C_Data);$i++){
        
        $FechaAsignacion                   = '2015-04-18';
        $SolicitudAsignacionEspacioId      = $C_Data[$i]['SolicitudAsignacionEspacioId'];
        $UsuarioCreacion                   = $C_Data[$i]['UsuarioCreacion'];
        $UsuarioUltimaModificacion         = $C_Data[$i]['UsuarioUltimaModificacion'];
        $FechaCreacion                     = $C_Data[$i]['FechaCreacion'];
        $FechaultimaModificacion           = $C_Data[$i]['FechaultimaModificacion'];
        $ClasificacionEspaciosId           = $C_Data[$i]['ClasificacionEspaciosId'];
        $HoraInicio                        = $C_Data[$i]['HoraInicio'];
        $HoraFin                           = $C_Data[$i]['HoraFin'];
        $EstadoAsignacionEspacio           = $C_Data[$i]['EstadoAsignacionEspacio'];
        $Observaciones                     = $C_Data[$i]['Observaciones'];
        $Modificado                        = $C_Data[$i]['Modificado'];
        $Enviado                           = $C_Data[$i]['Enviado'];
        
        $Asignacion='INSERT INTO AsignacionEspacios(FechaAsignacion,SolicitudAsignacionEspacioId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion,ClasificacionEspaciosId,HoraInicio,HoraFin,EstadoAsignacionEspacio,Observaciones,Modificado,Enviado)VALUES("'.$FechaAsignacion.'","'.$SolicitudAsignacionEspacioId.'","'.$UsuarioCreacion.'","'.$UsuarioUltimaModificacion.'","'.$FechaCreacion.'","'.$FechaultimaModificacion.'","'.$ClasificacionEspaciosId.'","'.$HoraInicio.'","'.$HoraFin.'","'.$EstadoAsignacionEspacio.'","'.$Observaciones.'","'.$Modificado.'","'.$Enviado.'")';
        
        if($EjecutarCambio=&$db->Execute($Asignacion)===false){
            echo 'Error en el SQL ...<br><br>'.$Asignacion;
            die;
        }
        
       }//for      
   
   echo 'Termino....';    
       
?>