<?php

include_once(dirname(__FILE__)."/../template.php");
$db = getBD();

$q = strtolower($_GET["term"]);
//var_dump($_REQUEST);

if (!$q) die();

//var_dump($q);
$fechahoy=date("Y-m-d H:i:s"); 
            

$query_programa = "SELECT idmenuopcion, CONCAT(transaccionmenuopcion,' - ',nombremenuopcion) as nombremenuopcion FROM menuopcion 
WHERE nombremenuopcion LIKE '%$q%' OR transaccionmenuopcion LIKE '%$q%' 
ORDER BY nombremenuopcion ASC";
//var_dump($query_programa);
$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    //var_dump($row);
    #$users[$i] = $row["nombres"]." ".$row["apellidos"];
    $res['label']=$row["nombremenuopcion"];
    $res['value']=$row["nombremenuopcion"];
    $res['id']=$row["idmenuopcion"];
    //$res['idFactor']=$row["idFactor"];
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
