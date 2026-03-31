<?php

include("../templates/template.php");
		
$db = getBD();

$SQL='SELECT c.ClasificacionEspaciosId, b.FechaInicioVigencia, b.FechaFinVigencia FROM ClasificacionEspacios c INNER JOIN BorrarDetalleClasificacionEspacios b 
ON c.ClasificacionEspaciosId=b.ClasificacionEspaciosId  WHERE codigoestado=100';

if($Datos=&$db->Execute($SQL)===false){
    echo 'Error en el SQL de Los Datos...<br><br>'.$SQL;
    die;
}

while(!$Datos->EOF){
    /************************************/
    $Update='UPDATE ClasificacionEspacios
             SET    FechaInicioVigencia="'.$Datos->fields['FechaInicioVigencia'].'",
                    FechaFinVigencia="'.$Datos->fields['FechaFinVigencia'].'"
                    
             WHERE  ClasificacionEspaciosId="'.$Datos->fields['ClasificacionEspaciosId'].'"';  
             
             if($Cambio=&$db->Execute($Update)===false){
                echo 'Error en el SQL Cambio....<br><br>'.$Update;
                die;
             }  
    /************************************/
    $Datos->MoveNext();
}//while

?>