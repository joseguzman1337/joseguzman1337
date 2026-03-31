<?php

/****QUERY PARA OBTENER LOS PROMEDIOS****/
function obtenerEstudiantes($db,$codigoperiodo,$carrera){
    $datos_estadistica=new obtener_datos_matriculas($db,$codigoperiodo);
    //echo "<pre>"; print_r($datos_estadistica);
    $array_matnuevo=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos($carrera,'arreglo');
    return $array_matnuevo;
}

function obtenerMaxSemestreCarrera($db,$carrera,$periodo){
    $sql = "SELECT max(dp.semestredetalleplanestudio+0) as maxSemestre, c.nombrecarrera FROM carrera c 
        inner join periodo p ON p.codigoperiodo='$periodo' 
    inner join planestudio pe on pe.codigocarrera=c.codigocarrera AND pe.codigoestadoplanestudio!=200 
    AND pe.fechainioplanestudio<=p.fechainicioperiodo AND pe.fechavencimientoplanestudio>=p.fechavencimientoperiodo
    inner join detalleplanestudio dp on dp.idplanestudio=pe.idplanestudio 
    where c.codigocarrera=".$carrera;
    //echo "<pre>"; print_r($sql); echo "<br/><br/>";
    $row = $db->GetRow($sql);
    $max = 0;
    if($row!=null&&count($row)>0){
        $max = $row["maxSemestre"];
    }
    return array("carrera"=>$row["nombrecarrera"],"semestre"=>$max);
}

function obtenerMaxSemestreEstudiante($db,$codigoestudiante){
    $sql = "SELECT max(dp.semestredetalleplanestudio+0) as maxSemestre, c.nombrecarrera FROM carrera c 
        inner join planestudioestudiante pee ON pee.codigoestudiante='$codigoestudiante' 
    inner join planestudio pe on pe.idplanestudio=pee.idplanestudio 
    inner join detalleplanestudio dp on dp.idplanestudio=pe.idplanestudio";
    
    $row = $db->GetRow($sql);
    $max = 0;
    if($row!=null&&count($row)>0){
        $max = $row["maxSemestre"];
    }
    return array("carrera"=>$row["nombrecarrera"],"semestre"=>$max);
}

function obtenerPromedioEstudiantes($db,$codigoestudiante,$carrera,$semestre,$database_sala, $sala, $ruta='../../../../../'){
    $sql = "SELECT p.codigoperiodo from prematricula p
        INNER JOIN estudiante e ON e.codigoestudiante=p.codigoestudiante AND e.codigocarrera='$carrera' 
        where p.codigoestudiante='$codigoestudiante' AND p.codigoestadoprematricula IN (40,41,10) 
            AND p.semestreprematricula='$semestre' GROUP BY p.codigoperiodo";
    $rows = $db->GetAll($sql);
    //echo "<pre>"; print_r($row); echo "<br/><br/>";
    $periodosemestral = false;
    $nota = 0;
    if($rows!=null&&count($rows)>0){
        foreach($rows as $row){
            $periodosemestral = $row["codigoperiodo"];
            if($periodosemestral!=false){
                require($ruta.'funciones/notas/calculopromediosemestral.php');
                $nota += $promediosemestralperiodo;
                //echo "<pre>"; print_r($nota); echo "<br/><br/>";
            }
        }
        $nota = $nota/count($rows);
    }
    return $nota;
}

?>
