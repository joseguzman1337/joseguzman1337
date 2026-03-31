<?php

global $db;

include("templates/mainjson.php");

$sql='SELECT 

p.id_docente,
p.id_plandocente,
p.userid,
d.iddocente,
u.idusuario 

FROM 

plandocente  p INNER JOIN docente d ON d.iddocente=p.id_docente
							 INNER JOIN usuario u ON d.numerodocumento=u.numerodocumento

WHERE  

p.userid=15344

GROUP BY p.id_plandocente
ORDER BY u.idusuario';


if($Datos=&$db->Execute($sql)===false){
    echo 'Error en el SQl ..<br><br>'.$sql;
    die;
}

while(!$Datos->EOF){
    
    echo '<br><br>'.$Update='UPDATE    plandocente
    
             SET       userid="'.$Datos->fields['idusuario'].'"
             
             WHERE     id_docente="'.$Datos->fields['id_docente'].'"
                       AND
                       id_plandocente="'.$Datos->fields['id_plandocente'].'"';
                       
           if($Modifica=&$db->Execute($Update)===false){
                echo 'Error en el SQL Modifica...<br><br>'.$Update;
                die;
           }            
    
    $Datos->MoveNext();
}


$SQL_2='SELECT 

a.id_accionesplandocentetemp,
a.docente_id,
a.userid,
d.iddocente,
u.idusuario

FROM 

accionesplandocente_temp  a INNER JOIN docente d ON d.iddocente=a.docente_id
							INNER JOIN usuario u ON u.numerodocumento=d.numerodocumento

WHERE  

a.userid=15344

GROUP BY a.id_accionesplandocentetemp';

 if($Trabajos=&$db->Execute($SQL_2)===false){
    echo 'Error en el SQl de lasacciones...<br><br>'.$SQL_2;
    die;
 }
 
    while(!$Trabajos->EOF){
        
            echo '<br><br>'.$UP='UPDATE  accionesplandocente_temp
            
                 SET     userid="'.$Trabajos->fields['idusuario'].'"   
                 
                 WHERE   id_accionesplandocentetemp="'.$Trabajos->fields['id_accionesplandocentetemp'].'"  
                         AND
                         docente_id="'.$Trabajos->fields['docente_id'].'"  ';
                         
                         
                  if($Up_Tra=&$db->Execute($UP)===false){
                    echo 'Error en el SQl...<br><br>'.$UP;
                    die;
                  }       
        
        $Trabajos->MoveNext();
    }
?>