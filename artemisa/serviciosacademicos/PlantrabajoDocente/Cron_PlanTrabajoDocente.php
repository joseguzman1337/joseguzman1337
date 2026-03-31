<?php

global $db;

include("templates/mainjson.php");


  $SQL='SELECT 
        
                id_accionesplandocentetemp as id,
                docente_id,
                userid
        
        FROM 
        
                accionesplandocente_temp 
        
        WHERE
        
                codigoestado=100
                AND
                materia_id<>""';
                
          if($Datos=&$db->Execute($SQL)===false){
            echo 'Error en el SQl ...<br><br>'.$SQL;
            die;
          }     
          
          while(!$Datos->EOF){
            /***************************************************/
            $PlanTrabajo    = $Datos->fields['id'];
            $Docente_id     = $Datos->fields['docente_id'];
            $User_id        = $Datos->fields['userid']; 
            
           echo '<br><br>'.$sql_P='SELECT
                    
                            id_plandocente,
                            plantrabajo_id
                    
                    FROM
                    
                            plandocente
                    
                    WHERE
                    
                            plantrabajo_id="'.$PlanTrabajo.'"
                            AND
                            codigoestado=100
                            AND
                            id_vocacion=1';
                            
                    if($Plan_Existe=&$db->Execute($sql_P)===false){
                        echo 'Error en el SQL de los planes Existentes....<br><br>'.$sql_P;
                        die;
                    }       
                    
             if(!$Plan_Existe->EOF){
                /*************************************/
                $PlanDocente=$Plan_Existe->fields['id_plandocente'];
                /*************************************/
                echo '<br><br>'.$Update='UPDATE   plandocente
                
                         SET      id_docente="'.$Docente_id.'",
                                  plantrabajo_id="'.$PlanTrabajo.'",
                                  userid="'.$User_id.'"
                                  
                         WHERE
                                  plantrabajo_id="'.$PlanTrabajo.'"
                                  AND
                                  codigoestado=100
                                  AND
                                  id_vocacion=1
                                  AND
                                  id_plandocente="'.$PlanDocente.'"';
                                  
                      if($UpdatePlan=&$db->Execute($Update)===false){
                        echo 'Error en el Update...<br><br>'.$Update;
                        die;
                      }            
                /*************************************/
             }else{
                /*******************************************/
                echo '<br><br>'.$Insert= 'INSERT INTO plandocente(id_docente,id_vocacion,plantrabajo_id,codigoperiodo,entrydate,userid)VALUES("'.$Docente_id.'","1","'.$PlanTrabajo.'","20132",NOW(),"'.$User_id.'")';
                
                if($Inserto=&$db->Execute($Insert)===false){
                    echo 'Error en el SQL ...<br><br>'.$Insert;
                    die;
                }
                /*******************************************/
             }        
            /***************************************************/
            $Datos->MoveNext();
          } 

?>