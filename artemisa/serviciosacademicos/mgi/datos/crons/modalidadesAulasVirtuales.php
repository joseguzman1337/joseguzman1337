<?php
    //Para correr 1 vez al día tipo 1am en /serviciosacademicos/mgi/datos/crons/modalidadesAulasVirtuales.php
    session_start(); 
    $_SESSION['MM_Username'] = 'estudiante';

    include("../templates/template.php");
    $databases = getBDMoodle();

    $dbSala = $databases[0];
    $dbMoodle = $databases[1];
    $dbMoodle2 = $databases[2];
    
    $utils = new Utils_datos();
    
    $table = "moodle_modalidadAcademica";
    
    //compara los arreglos
    function compareArrays($v1,$v2)
    {
        return strcasecmp($v1['id'] , $v2['id']);
    }
    
    //buscar modalidades para agregar
    $query = "SELECT id,name from mdl_course_categories WHERE parent = 0";
    $modalidades = $dbMoodle->GetAll($query); 
    
    $querySala = "SELECT idmoodle as id from siq_moodle_modalidadAcademica WHERE idmoodle!=idmoodle2 OR idmoodle2 IS NULL";
    $modalidadesSala = $dbSala->GetAll($querySala); 

    if(count($modalidadesSala)>0){
        //encuentro las modalidades que se repiten en el arreglo
        $result = array_uintersect($modalidades, $modalidadesSala,"compareArrays");

        //saco las modalidades que se repiten
        $result = array_udiff($modalidades, $result, "compareArrays");
    } else {
        $result = $modalidades;
    }
    
     //var_dump($modalidades); 
     //echo "<br/><br/>"; 
     //var_dump($result); 
     
    $action = "save";    
    foreach ($result as $key => $row){
        
        $fields = array();
        $fields["idmoodle"] = intval($row["id"]);
        $fields["nombre"] = $row["name"];
        
        //var_dump($fields); 
        //echo "<br/><br/>"; 
        
        $utils->processData($action, $table, $fields, false);
    }  
    
    
    //buscar modalidades para activar
    $querySala = "SELECT idmoodle as id, idsiq_moodle_modalidadAcademica FROM siq_moodle_modalidadAcademica WHERE codigoestado=200 AND (idmoodle!=idmoodle2 OR idmoodle2 IS NULL)";
    $modalidadesSala = $dbSala->GetAll($querySala); 
    
    
    //encuentro las modalidades que se repiten en el arreglo
    $result = array_uintersect($modalidadesSala, $modalidades,"compareArrays");
    $action = "update";    
    foreach ($result as $key => $row){
        
        $fields = array();
        $fields["idmoodle"] = intval($row["id"]);
        $fields["idsiq_moodle_modalidadAcademica"] = intval($row["idsiq_moodle_modalidadAcademica"]);
        $fields["codigoestado"] = 100;
        
        //var_dump($row); 
        //echo "<br/><br/>"; 
        //var_dump($fields); 
        //echo "<br/><br/>"; 
        
        $utils->processData($action, $table, $fields, false);
    }
    
    
    //buscar modalidades para inactivar
    $querySala = "SELECT idmoodle as id, idsiq_moodle_modalidadAcademica from siq_moodle_modalidadAcademica WHERE codigoestado = 100 AND (idmoodle!=idmoodle2 OR idmoodle2 IS NULL)";
    $modalidadesSala = $dbSala->GetAll($querySala); 
    
    if(count($modalidades)>0){
        //encuentro las modalidades que se repiten en el arreglo
        $result = array_uintersect($modalidades, $modalidadesSala,"compareArrays");

        //saco las modalidades que se repiten
        $result = array_udiff($modalidadesSala, $result, "compareArrays");
    } else {
        $result = $modalidadesSala;
    }
    $action = "inactivate";    
    foreach ($result as $key => $row){
        
        $fields = array();
        $fields["idsiq_moodle_modalidadAcademica"] = $row["idsiq_moodle_modalidadAcademica"];
        
        //var_dump($fields); 
        //echo "<br/><br/>"; 
        
        $utils->processData($action, $table, $fields, false);
    }
    
    /**************************************************************************
     * BASE DE DATOS NUEVA/ACTUAL
     *************************************************************************/
    
    $table = "moodle_modalidadAcademica";
        
    //buscar modalidades para agregar
    $query = "SELECT id,name from mdl_course_categories WHERE parent = 0";
    $modalidades = $dbMoodle2->GetAll($query); 
    
    $querySala = "SELECT idmoodle2 as id from siq_moodle_modalidadAcademica WHERE idmoodle2 IS NOT NULL ";
    $modalidadesSala = $dbSala->GetAll($querySala); 
    
    if(count($modalidadesSala)>0){
        //encuentro las modalidades que se repiten en el arreglo
        $result = array_uintersect($modalidades, $modalidadesSala,"compareArrays");

        //saco las modalidades que se repiten
        $result = array_udiff($modalidades, $result, "compareArrays");
    } else {
        $result = $modalidades;
    }
    
     /*var_dump($modalidades); 
     echo "<br/><br/>"; 
     var_dump($result); 
     echo "<br/><br/>"; 
     var_dump($modalidadesSala); */
     
    $action = "save";    
    foreach ($result as $key => $row){
        
        $fields = array();
        $fields["idmoodle"] = intval($row["id"]);
        $fields["idmoodle2"] = intval($row["id"]);
        $fields["nombre"] = $row["name"];
        
        //var_dump($fields); 
        //echo "<br/><br/>"; 
        
        $utils->processData($action, $table, $fields, false);
    }    
    

    //buscar modalidades para activar
    $querySala = "SELECT idmoodle2 as id, idmoodle, idsiq_moodle_modalidadAcademica FROM siq_moodle_modalidadAcademica WHERE codigoestado=200 AND idmoodle2 IS NOT NULL ";
    $modalidadesSala = $dbSala->GetAll($querySala); 
        
    //encuentro las modalidades que se repiten en el arreglo
    $result = array_uintersect($modalidadesSala, $modalidades,"compareArrays");
    $action = "update";    
    foreach ($result as $key => $row){
        
        $fields = array();
        if(intval($row["id"])==intval($row["idmoodle"])){
            $fields["idmoodle"] = intval($row["id"]);
        }
        $fields["idmoodle2"] = intval($row["id"]);
        $fields["idsiq_moodle_modalidadAcademica"] = intval($row["idsiq_moodle_modalidadAcademica"]);
        $fields["codigoestado"] = 100;
        
        //var_dump($row); 
        //echo "<br/><br/>"; 
        //var_dump($fields); 
        //echo "<br/><br/>"; 
        
        $utils->processData($action, $table, $fields, false);
    }
    
    
    //buscar modalidades para inactivar
    $querySala = "SELECT idmoodle2 as id, idsiq_moodle_modalidadAcademica from siq_moodle_modalidadAcademica WHERE codigoestado = 100 AND idmoodle2 IS NOT NULL ";
    $modalidadesSala = $dbSala->GetAll($querySala); 
    
    if(count($modalidades)>0){
        //encuentro las modalidades que se repiten en el arreglo
        $result = array_uintersect($modalidades, $modalidadesSala,"compareArrays");

        //saco las modalidades que se repiten
        $result = array_udiff($modalidadesSala, $result, "compareArrays");
    } else {
        $result = $modalidadesSala;
    }
    $action = "inactivate";    
    foreach ($result as $key => $row){
        
        $fields = array();
        $fields["idsiq_moodle_modalidadAcademica"] = $row["idsiq_moodle_modalidadAcademica"];
        
        //var_dump($fields); 
        //echo "<br/><br/>"; 
        
        $utils->processData($action, $table, $fields, false);
    }
?>
