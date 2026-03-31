<?php
/****
 * Look for users base on name and last_name  
 ****/

require_once('../../Connections/salasiq.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');

$q = strtolower($_GET["term"]);

if (!$q) die();


$query_programa = "SELECT c.idsiq_convenio,c.nombreconvenio,i.nombreinstitucion   
                    FROM siq_convenio c, siq_institucionconvenio i WHERE 
                    c.nombreconvenio LIKE '%$q%' AND c.codigoestado='100' AND c.idsiq_institucionconvenio=i.idsiq_institucionconvenio AND i.codigoestado='100' 
                    ORDER BY c.nombreconvenio ASC";

//var_dump($query_programa);
$result =$db->Execute($query_programa);
$users = array(); 

while ($row = $result->FetchRow()) {
    
        $res['label']=$row["nombreconvenio"];
        $res['value']=$row["nombreconvenio"];
        $res['id']=$row["idsiq_convenio"];
        $res['institucion']=$row["nombreinstitucion"];

        array_push($users,$res); 
}

// return the array as json
echo json_encode($users);
?>