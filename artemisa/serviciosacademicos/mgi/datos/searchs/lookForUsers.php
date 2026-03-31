<?php
/****
 * Look for users base on name and last_name  
 ****/
include("../templates/template.php");
$db = getBD();

$q = strtolower($_GET["term"]);
//var_dump($_REQUEST);
if (!$q) die();
 
//solo administradores por lo que los demas pueden repetir
$sql = "select u.idusuario
		FROM siq_gestionPermisosMGI gp 
                      INNER JOIN usuario u on gp.usuario=u.usuario or u.idusuario=gp.idUsuario
				WHERE gp.codigoestado='100' AND idRol='1'";

$query_programa = "SELECT idusuario, CONCAT(nombres,' ',apellidos) as nombre_completo, u.usuario FROM usuario u 
    inner join tipousuario t ON t.codigotipousuario=u.codigotipousuario AND t.codigoestado='100' 
	AND t.codigotipousuario NOT IN (500,600,610,620,630,640,650,660,670,900) 
 WHERE (CONCAT(nombres,' ',apellidos) LIKE '%$q%' OR u.usuario LIKE '%$q%') AND u.usuario!='admintecnologia' 
 AND u.idusuario NOT IN ($sql) 
 ORDER BY nombre_completo ASC LIMIT 0, 50";
//var_dump($query_programa);
$result =$db->Execute($query_programa);
$users = array();

while ($row = $result->FetchRow()) {
    $res['label']=$row["nombre_completo"]." (".$row["usuario"].")";
    $res['value']=$row["nombre_completo"]." (".$row["usuario"].")";
    $res['id']=$row["idusuario"];
    array_push($users,$res);
   
}

// return the array as json
echo json_encode($users);
?>
