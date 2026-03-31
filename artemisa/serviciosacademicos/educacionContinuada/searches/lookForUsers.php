<?php
/****
 * Look for users base on name and last_name  
 ****/
include_once("../variables.php");
include($rutaTemplate."template.php");
$db = getBD();
//$utils = Utils::getInstance(); 
//$idPadres = $utils->getIDMenuEC($db);

$q = strtolower($_GET["term"]);
//var_dump($_REQUEST);
if (!$q) die();
 
//var_dump($db);
/*$sql = "select u.idusuario
				from menuopcion m, permisousuariomenuopcion pum, detallepermisomenuopcion dpum, usuario u 
				where pum.idpermisomenuopcion = dpum.idpermisomenuopcion
				and pum.codigoestado like '1%'
				and m.codigoestadomenuopcion like '01%'
				and dpum.codigoestado like '1%'
				and m.idmenuopcion = dpum.idmenuopcion
				and m.idmenuopcion = '".$idPadres[0]."' AND u.idusuario=pum.idusuario";*/
$sql = "select m.idusuario
				from usuarioEducacionContinuadaRol m
				where m.codigoestado='100'";

$query_programa = "SELECT idusuario, CONCAT(nombres,' ',apellidos) as nombre_completo, u.usuario FROM usuario u 
    inner join tipousuario t ON t.codigotipousuario=u.codigotipousuario AND t.codigoestado='100' 
	AND t.codigotipousuario NOT IN (500,600,610,620,630,640,650,660,670) 
 WHERE (CONCAT(nombres,' ',apellidos) LIKE '%$q%' OR u.usuario LIKE '%$q%') AND u.usuario!='admintecnologia' 
 AND u.idusuario NOT IN ($sql) 
 ORDER BY nombre_completo ASC LIMIT 0, 200";
//echo $query_programa;
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
