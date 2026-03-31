<?php
global $db;

include("templates/mainjson.php");

  $SQL_Plan='SELECT 

            id_accionesplandocentetemp AS id,
            materia_id,            
            docente_id
            
            FROM 
            
            accionesplandocente_temp';
            
     if($Planes=&$db->Execute($SQL_Plan)===false){
        echo 'Error en el SQl de los pLanes a Modificar...<br><br>'.$SQL_Plan;
        die;
     }  
     
     while(!$Planes->EOF){
        /********************************************/
        $Materia_id  = $Planes->fields['materia_id'];
        $Docente_id  = $Planes->fields['docente_id'];
        
        $SQL_D='SELECT d.numerodocumento, u.idusuario FROM docente d INNER JOIN usuario u ON u.numerodocumento=d.numerodocumento AND u.codigorol=2 WHERE d.iddocente="'.$Docente_id.'"';
        
        if($DocenteData=&$db->Execute($SQL_D)===false){
            echo 'Error en el SQl de Docente....<br><br>'.$SQL_D;
            die;
        }
       
       $NumeroDocumento = $DocenteData->fields['numerodocumento'];
       $User_id         = $DocenteData->fields['idusuario']; 
        
        $SQL_G='SELECT idgrupo FROM grupo WHERE  numerodocumento="'.$DocenteData->fields['numerodocumento'].'" AND codigomateria="'.$Materia_id.'" AND codigoperiodo=20132 LIMIT 1';
        
        if($Grupo=&$db->Execute($SQL_G)===false){
            echo 'Error en el SQL Grupo...<br><br>'.$SQL_G;
            die;
        }
        
        $Grupo_id   = $Grupo->fields['idgrupo'];
        
        $Update='UPDATE  accionesplandocente_temp
                 SET     grupo_id="'.$Grupo_id.'",
                         userid  ="'.$User_id.'"
                 WHERE
                         id_accionesplandocentetemp="'.$Planes->fields['id'].'" AND docente_id="'.$Docente_id.'" AND materia_id="'.$Materia_id.'" AND codigoestado=100';
                         
                if($UpdatePlan=&$db->Execute($Update)===false){
                    echo 'Error en el Update De los Planes...<br>'.$Update;
                    die;
                }        
        /********************************************/
        $Planes->MoveNext();
     }     

?>