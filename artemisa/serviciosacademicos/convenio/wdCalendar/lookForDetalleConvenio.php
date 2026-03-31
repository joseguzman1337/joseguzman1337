<?php
/****
 * Look for users base on name and last_name  
 ****/

require_once('../../Connections/salasiq.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');

$q = $_REQUEST["convenio"];
if (!$q){ $q = $_GET["convenio"];}
if (!$q) die();


$query_programa = "SELECT c.dato_carrera,c.idsiq_detalle_convenio   
                    FROM siq_detalle_convenio c WHERE 
                    c.idsiq_convenio = '$q' AND c.codigoestado='100'  
                    ORDER BY c.dato_carrera ASC";

//var_dump($query_programa);
$result =$db->Execute($query_programa);
$users = array(); 

while ($row = $result->FetchRow()) {
    
        $res['label']=$row["dato_carrera"];
        $res['value']=$row["dato_carrera"];
        $res['id']=$row["idsiq_detalle_convenio"];

        array_push($users,$res); 
}

// return the array as json
echo json_encode($users);
?>