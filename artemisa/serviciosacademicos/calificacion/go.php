<?php
    // Recibimos la ID del vinculo desde la URL
    $id = $_REQUEST['id'];
    $idcl_servicio = $_REQUEST['idcl_servicio'];
    $identificacion = $_REQUEST['identificacion'];    
    $observacion = $_REQUEST['comentario'];
    $idcl_evaluacion2 = $_REQUEST['idevaluacion'];
    $idcl_evaluacion = 0;
    include 'db/db.inc';
    $dbconnect = db_connect() or trigger_error("SQL", E_USER_ERROR);    
    // Incrementamos en 1 el contador del link con la ID especificada en la url        
    $SELECT = "SELECT idcl_evaluacion FROM cl_evaluacion WHERE idcl_opcion_evaluacion='$id' AND idcl_servicio = '$idcl_servicio' AND fecha_evaluacion = CURDATE();";
    $result = mysql_query($SELECT, $dbconnect) or trigger_error("SQL", E_USER_ERROR);
    $num_rows = mysql_num_rows($result);
    if($_REQUEST['id']){
        if($num_rows>0){
            $row = mysql_fetch_array($result);
            $update = "UPDATE cl_evaluacion SET clicks=(clicks + 1)
            WHERE idcl_opcion_evaluacion='$id' AND idcl_servicio = '$idcl_servicio' AND fecha_evaluacion = CURDATE();";
            mysql_query($update, $dbconnect) or trigger_error("SQL", E_USER_ERROR);
            echo $idcl_evaluacion = $row['idcl_evaluacion'];
        }else{
            $INSERT = "INSERT INTO cl_evaluacion VALUES (NULL,'$id',1,'$idcl_servicio',CURDATE());";
            mysql_query($INSERT, $dbconnect) or trigger_error("SQL", E_USER_ERROR);
            $idcl_evaluacion = mysql_insert_id();
            echo $idcl_evaluacion;
        }    
    }
    if($_REQUEST['comentario']){        
        $INSERT = "INSERT INTO cl_observacion VALUES (NULL,'$observacion','$identificacion',NULL,NULL,NULL,'$idcl_evaluacion2');";
        mysql_query($INSERT, $dbconnect) or trigger_error("SQL", E_USER_ERROR);         
    }    
?>	
