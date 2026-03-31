<?php

    function getSelectMonitoresVoluntariado($db,$periodo){
        /****BUSCO LAS OPCIONES PARA EL PERIODO ELEGIDO***/
        $respuesta = "<option value='-1'> Elegir tipo de monitor</option>";
        $SQL='SELECT 
					id_voluntareadobienestar as id,
					nombrevoluntareado as Nombre,
					nombrecorto
					
					FROM 
					
					voluntareadobienestar 
					
					WHERE
					
					monitor=1
					AND
					codigoestado=100
					AND
					cancel=0 AND periodoInicial<='.$periodo.' 
                                            AND (periodoFinal>='.$periodo.' OR periodoFinal IS NULL)';
                      
					if($Consulta=&$db->Execute($SQL)===false){
							echo 'Error en el SQL ...<br><br>'.$SQL;
							die;
						}	
		/*****************ARMO EL SELECT*****************/
             while(!$Consulta->EOF){ 
                    $respuesta .= "<option value='".$Consulta->fields['id']."'>".$Consulta->fields['Nombre']."</option>";
                       $Consulta->MoveNext(); 
                }//while                                   
                                                
		return $respuesta;
    }
?>
