<?php
/****
 * Look for users base on name and last_name  
 ****/
include("../templates/template.php");
$db = getBD();
$ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
            $ruta = $ruta."../";
    }
    require_once($ruta.'/consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');

$q = strtolower($_REQUEST["carrera"]);
$periodo = strtolower($_REQUEST["periodo"]);
//var_dump($_REQUEST);

if (!$q || !$periodo) die();

$datos_estadistica=new obtener_datos_matriculas($db,$periodo);
$array_matnuevo=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos($q,'arreglo');
$users = array();

foreach($array_matnuevo as $row){ 
    $query_programa = "SELECT CONCAT(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre from estudiante e             
        INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral = eg.idestudiantegeneral 
        where e.codigoestudiante='".$row["codigoestudiante"]."' AND e.codigosituacioncarreraestudiante=400";

    $result =$db->GetRow($query_programa);
    if(count($result)>0){
        //var_dump($row);
        #$users[$i] = $row["nombres"]." ".$row["apellidos"];
        $res['label']=$result["nombre"];
        $res['value']=$row["codigoestudiante"];

        array_push($users,$res);
    }
   
}

// return the array as json
echo json_encode($users);
?>
