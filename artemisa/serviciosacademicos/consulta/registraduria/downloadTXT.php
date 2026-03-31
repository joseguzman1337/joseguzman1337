<?php

header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=\"plano.txt\"");
header("Pragma: no-cache");
header("Expires: 0");

    $page_print = "";
/*if(count($_REQUEST)>0){
    $estudiantes = $_REQUEST["datos_a_enviar"];
    $estudiantes = unserialize(base64_decode($estudiantes));
} else {*/
    $ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    } 
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    include_once("./functions.php");
    $estudiantes = getEstudiantesJurados(unserialize(base64_decode($_REQUEST["modalidad"])),$_REQUEST["codigoperiodo"],$db);
    $estudiantes = $estudiantes["data"];
//}
    foreach($estudiantes as $row){

        $page_print .= $row["numerodocumento"] . "\t" . utf8_decode($row["nombresestudiantegeneral"]) . "\t" . utf8_decode($row["apellidosestudiantegeneral"]) . "\t" . $row["nivel"] 
            . "\t" . utf8_decode($row["partido"]). "\t" . utf8_decode($row["direccionresidenciaestudiantegeneral"]). "\t" . $row["telefonoresidenciaestudiantegeneral"]. "\t" 
			. $row["celularestudiantegeneral"]. "\t" . $row["emailestudiantegeneral"]. "\t" . $row["emailestudiantegeneral"]. "\t" .$row["nombrecortodocumento"]. "\t" 
			.utf8_decode($row["expedidodocumento"])
			. "\t" .$row["celularestudiantegeneral"]. "\t" .$row["nombrecarrera"]. "\t" .$row["edad"]. PHP_EOL;
    }

    echo $page_print;
?>							
