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


$query_programa = "SELECT g.idsiq_grupoconvenio,g.codigogrupo,dc.apellidodocente,dc.nombredocente   
                    FROM siq_grupoconvenio g 
                    inner join siq_detalle_convenio d on (g.idsiq_detalle_convenio=d.idsiq_detalle_convenio) inner join siq_convenio c on (d.idsiq_convenio=c.idsiq_convenio) inner join docente dc on (dc.iddocente=g.iddocente) 
                    WHERE g.idsiq_detalle_convenio = '$q' AND g.codigoestado='100'  
                    ORDER BY g.codigogrupo ASC";

//var_dump($query_programa);
$result =$db->Execute($query_programa);
$users = array(); 

while ($row = $result->FetchRow()) {
    
        $res['label']=$row["codigogrupo"]." - ".$row["nombredocente"]." ".$row["apellidodocente"];
        $res['value']=$row["codigogrupo"]." - ".$row["nombredocente"]." ".$row["apellidodocente"];
        $res['id']=$row["idsiq_grupoconvenio"];

        array_push($users,$res); 
}

// return the array as json
echo json_encode($users);
?>