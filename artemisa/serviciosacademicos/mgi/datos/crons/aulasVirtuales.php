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
    
    $yesterday = strtotime("yesterday");
    $yesterdayDate = date("Y-m-d", $yesterday);
    //var_dump(date('Y-m-d H:i:s',$yesterday));
    
    //compara los arreglos
    function compareArrays($v1,$v2)
    {
        if(strcasecmp($v1['id'] , $v2['id'])==0){
            return strcasecmp($v1['codigomateria'] , $v2['codigomateria']);
        } else {
            return strcasecmp($v1['id'] , $v2['id']);
        }
    }
    
    //buscar aulas virtuales cuya fecha de inicio sea >= a ayer (creadas nuevas)
    $query = "SELECT a.id, a.fullname, a.shortname, p.name as category1, p.id as idCat, p.parent, a.startdate, a.idnumber as codigomateria FROM mdl_course a 
        inner join mdl_course_categories p ON p.id = a.category WHERE a.timemodified >= '".$yesterday."' ORDER BY a.startdate DESC";
    $cursosAulasVirtuales = $dbMoodle->GetAll($query); 
    
    //var_dump(count($cursosAulasVirtuales)); 
    //echo "<br/><br/>"; 
    
    //buscar aulas virtuales en sala >= 
    $querySala = "SELECT idmoodle as id, codigomateria from siq_moodle_aulaVirtual WHERE codigoestado = '100' AND bdMoodle='1' ";
    $cursosSala = $dbSala->GetAll($querySala); 
    
    //var_dump(count($cursosSala)); 
    //echo "<br/><br/>"; 
    
    if(count($cursosSala)>0){
        //encuentro las modalidades que se repiten en el arreglo
        $result = array_uintersect($cursosAulasVirtuales, $cursosSala,"compareArrays");

        //var_dump($result); 
        //echo "<br/><br/>"; 

        //saco las modalidades que se repiten y no tienen cambio en la materia
        $result = array_udiff($cursosAulasVirtuales, $result, "compareArrays");
    } else {
        $result = $cursosAulasVirtuales;
    }
    
    //var_dump(count($result)); 
    //echo "<br/><br/>"; 
    
    $table = "moodle_aulaVirtual";
    
    foreach ($result as $key => $row){
        $fields = array();
        $action = "save";
        
        $queryRow = "SELECT idsiq_moodle_aulaVirtual FROM siq_moodle_aulaVirtual p WHERE p.idmoodle = '".$row["id"]."' AND bdMoodle='1'";
        $aula = $dbSala->GetRow($queryRow); 
        
        //si lo encuentra en sala
        if(count($aula)>0){
            $action = "update";
            $fields["idsiq_moodle_aulaVirtual"] = $aula["idsiq_moodle_aulaVirtual"];
        } 
        
        $parent = intval($row["parent"]);
        
        $fields["idmoodle"] = $row["id"];
        $fields["asignatura"] = addslashes($row["fullname"]);
        $fields["asignatura_short"] = addslashes($row["shortname"]);
        $fields["categorias"] = $row["category1"];
        if(is_numeric($row["codigomateria"])) {
            $fields["codigomateria"] = intval($row["codigomateria"]);
        }
        $fields["fecha_inicio"] = date('Y-m-d', $row["startdate"]);
        //$row["numCategories"] = 1;
        $id = $row["idCat"];
        while($parent!=0){
            $queryRow = "SELECT p.id as idCat, p.name, p.parent FROM mdl_course_categories p WHERE p.id = '".$parent."'";
            $category = $dbMoodle->GetRow($queryRow); 
            $parent = intval($category["parent"]);
            $fields["categorias"] = $fields["categorias"].";".$category["name"];
            $id = $category["idCat"];
            //$row["numCategories"] = $row["numCategories"] + 1;
            //$row["category" . $row["numCategories"]] = $category["name"];
        }
        
        $fields["categorias"] = addslashes($fields["categorias"]);
        $querySala = "SELECT idsiq_moodle_modalidadAcademica as id from siq_moodle_modalidadAcademica WHERE idmoodle = '".$id."' ";
        $modalidad = $dbSala->GetRow($querySala);         
        
        $fields["codigomodalidadacademica"] = $modalidad["id"];
        
        //var_dump($fields); 
        //echo "<br/><br/>"; 
        $utils->processData($action, $table, $fields, false);
    }
    
    /* 
     *  PARA INACTIVAR LOS ELIMINADOS
     */
    
    //buscar aulas virtuales 
    $query = "SELECT a.id, a.fullname, a.shortname, p.name as category1, p.id as idCat, p.parent, a.startdate, a.idnumber FROM mdl_course a 
        inner join mdl_course_categories p ON p.id = a.category ";
    $cursosAulasVirtuales = $dbMoodle->GetAll($query); 
    
    //var_dump(count($cursosAulasVirtuales)); 
    //echo "<br/><br/>"; 
    
    //buscar aulas virtuales en sala 
    $querySala = "SELECT idmoodle as id, idsiq_moodle_aulaVirtual from siq_moodle_aulaVirtual WHERE codigoestado = '100' AND bdMoodle='1'";
    $cursosSala = $dbSala->GetAll($querySala); 
    //var_dump($cursosAulasVirtuales); 
    
    //encuentro los cursos que se repiten en el arreglo
    $result = array_uintersect($cursosAulasVirtuales, $cursosSala,"compareArrays");
    
    if($result!=NULL){
        //var_dump($result);
        //var_dump("<br/><br/>");

        //saco los cursos que se repiten, cosa que solo me queden los que no estan en moodle pero si en sala
        $result = array_udiff($cursosSala, $result, "compareArrays");

        //var_dump($result);
        //var_dump("<br/><br/>");
    } else {
        $result = $cursosSala;
    }
    //var_dump($result);
    
    $action = "inactivate";
    foreach ($result as $key => $row){
        $fields = array();
        $parent = intval($row["parent"]);
        
        $fields["idmoodle"] = $row["id"];
        $fields["idsiq_moodle_aulaVirtual"] = $row["idsiq_moodle_aulaVirtual"];
        
        //var_dump($fields); 
        //echo "<br/><br/>"; 
        $utils->processData($action, $table, $fields, false);
    }
    
    /**************************************************************************
     * BASE DE DATOS NUEVA/ACTUAL
     *************************************************************************/
    
    //buscar aulas virtuales cuya fecha de inicio sea >= a ayer (creadas nuevas)
    $query = "SELECT a.id, a.fullname, a.shortname, p.name as category1, p.id as idCat, p.parent, a.startdate, a.idnumber as codigomateria FROM mdl_course a 
        inner join mdl_course_categories p ON p.id = a.category WHERE a.timemodified >= '".$yesterday."' ORDER BY a.startdate DESC";
    $cursosAulasVirtuales = $dbMoodle2->GetAll($query); 
    
    //var_dump(count($cursosAulasVirtuales)); 
    //echo "<br/><br/>"; 
    
    //buscar aulas virtuales en sala >= 
    $querySala = "SELECT idmoodle as id, codigomateria from siq_moodle_aulaVirtual WHERE codigoestado = '100' AND bdMoodle='2'";
    $cursosSala = $dbSala->GetAll($querySala); 
    
    //var_dump(count($cursosSala)); 
    //echo "<br/><br/>"; 
    
    if(count($cursosSala)>0){
        //encuentro las modalidades que se repiten en el arreglo
        $result = array_uintersect($cursosAulasVirtuales, $cursosSala,"compareArrays");

        //var_dump($result); 
        //echo "<br/><br/>"; 

        //saco las modalidades que se repiten y no tienen cambio en la materia
        $result = array_udiff($cursosAulasVirtuales, $result, "compareArrays");
    } else {
        $result = $cursosAulasVirtuales;
    }
    
    //var_dump(count($result)); 
    //echo "<br/><br/>"; 
    
    $table = "moodle_aulaVirtual";
    
    foreach ($result as $key => $row){
        $fields = array();
        $action = "save";
        
        $queryRow = "SELECT idsiq_moodle_aulaVirtual FROM siq_moodle_aulaVirtual p WHERE p.idmoodle = '".$row["id"]."' AND bdMoodle='2'";
        $aula = $dbSala->GetRow($queryRow); 
        
        //si lo encuentra en sala
        if(count($aula)>0){
            $action = "update";
            $fields["idsiq_moodle_aulaVirtual"] = $aula["idsiq_moodle_aulaVirtual"];
        } 
        
        $parent = intval($row["parent"]);
        
        $fields["idmoodle"] = $row["id"];
        $fields["asignatura"] = addslashes($row["fullname"]);
        $fields["asignatura_short"] = addslashes($row["shortname"]);
        $fields["categorias"] = $row["category1"];
        $fields["bdMoodle"] = 2;

        if(is_numeric($row["codigomateria"])) {
            $fields["codigomateria"] = intval($row["codigomateria"]);
        }
        $fields["fecha_inicio"] = date('Y-m-d', $row["startdate"]);

        $id = $row["idCat"];
        while($parent!=0){
            $queryRow = "SELECT p.id as idCat, p.name, p.parent FROM mdl_course_categories p WHERE p.id = '".$parent."'";
            $category = $dbMoodle2->GetRow($queryRow); 
            $parent = intval($category["parent"]);
            $fields["categorias"] = $fields["categorias"].";".$category["name"];
            $id = $category["idCat"];
            //$row["numCategories"] = $row["numCategories"] + 1;
            //$row["category" . $row["numCategories"]] = $category["name"];
        }
        
        $fields["categorias"] = addslashes($fields["categorias"]);
        $querySala = "SELECT idsiq_moodle_modalidadAcademica as id from siq_moodle_modalidadAcademica WHERE idmoodle2 = '".$id."'";
        $modalidad = $dbSala->GetRow($querySala);     

        
        $fields["codigomodalidadacademica"] = $modalidad["id"];
        
        //var_dump($fields); 
        //echo "<br/><br/>"; 
        $utils->processData($action, $table, $fields, false);
    }
    
    /* 
     *  PARA INACTIVAR LOS ELIMINADOS
     */
    
    //buscar aulas virtuales 
    $query = "SELECT a.id, a.fullname, a.shortname, p.name as category1, p.id as idCat, p.parent, a.startdate, a.idnumber FROM mdl_course a 
        inner join mdl_course_categories p ON p.id = a.category ";
    $cursosAulasVirtuales = $dbMoodle2->GetAll($query); 
    
    //var_dump(count($cursosAulasVirtuales)); 
    //echo "<br/><br/>"; 
    
    //buscar aulas virtuales en sala 
    $querySala = "SELECT idmoodle as id, idsiq_moodle_aulaVirtual from siq_moodle_aulaVirtual WHERE codigoestado = '100' AND bdMoodle='2'";
    $cursosSala = $dbSala->GetAll($querySala); 
    //var_dump($cursosAulasVirtuales); 
    
    //encuentro los cursos que se repiten en el arreglo
    $result = array_uintersect($cursosAulasVirtuales, $cursosSala,"compareArrays");
    
    if($result!=NULL){
        //var_dump($result);
        //var_dump("<br/><br/>");

        //saco los cursos que se repiten, cosa que solo me queden los que no estan en moodle pero si en sala
        $result = array_udiff($cursosSala, $result, "compareArrays");

        //var_dump($result);
        //var_dump("<br/><br/>");
    } else {
        $result = $cursosSala;
    }
    //var_dump($result);
    
    $action = "inactivate";
    foreach ($result as $key => $row){
        $fields = array();
        $parent = intval($row["parent"]);
        
        $fields["idmoodle"] = $row["id"];
        $fields["bdMoodle"] = 2;
        $fields["idsiq_moodle_aulaVirtual"] = $row["idsiq_moodle_aulaVirtual"];
        
        //var_dump($fields); 
        //echo "<br/><br/>"; 
        $utils->processData($action, $table, $fields, false);
    }
    
?>
