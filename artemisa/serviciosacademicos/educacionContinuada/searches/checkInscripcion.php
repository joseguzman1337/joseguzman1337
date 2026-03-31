<?php
/****
 * Mira si la carrera esta disponible para inscripciones o no 
 ****/
include_once("../variables.php");
include($rutaTemplate."template.php");
$db = getBD();

$q = strtolower($_REQUEST["carrera"]);
//var_dump($_REQUEST);

if (!$q) die();

//var_dump($q);
$fechahoy=date("Y-m-d H:i:s"); 
            

$query_programa = "SELECT DISTINCT c.nombrecarrera, c.codigocarrera, cp.codigoperiodo 
				FROM carrera c, carreragrupofechainscripcion cf, carreraperiodo cp, 
				subperiodo sp WHERE c.codigomodalidadacademica = '400' 
				AND c.fechavencimientocarrera > now() 
				AND c.codigocarrera = cf.codigocarrera 
				AND cf.fechahastacarreragrupofechainscripcion >= now() 
				AND cf.idsubperiodo = sp.idsubperiodo 
				AND sp.idcarreraperiodo = cp.idcarreraperiodo 
				AND c.codigocarrera='$q' 
				order by c.nombrecarrera ";
//echo $query_programa;
$result =$db->GetRow($query_programa);

$existe = false;
$mensaje="Nota: este curso NO está abierto para inscripciones.";
if (count($result)>0) {
    $existe = true;   
    $mensaje = "";   
}
//var_dump($existe);
// return the array as json
echo json_encode(array("success"=>!$existe,"mensaje"=>$mensaje));
?>