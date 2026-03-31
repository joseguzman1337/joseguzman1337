<?php
/****
 * Look for users base on name and last_name  
 ****/
include_once("../variables.php");
include($rutaTemplate."template.php");
$db = getBD();

$q = strtolower($_REQUEST["carrera"]);
//var_dump($_REQUEST);

if (!$q) die();

//var_dump($q);
$fechahoy=date("Y-m-d H:i:s"); 
$periodoSelectSql="select * from periodo where '$fechahoy' between fechainicioperiodo and fechavencimientoperiodo;";
$peridoSelectRow = $db->GetRow($periodoSelectSql);
$idPeriodo=$peridoSelectRow['codigoperiodo'];
   
  if(isset($_REQUEST["grupo"])){
	$sacarGrupoSql="select g.idgrupo from grupo g inner join materia m on (g.codigomateria=m.codigomateria) where idgrupo='".$_REQUEST["grupo"]."'";
} else {
	$sacarGrupoSql="select g.idgrupo from grupo g inner join materia m on (g.codigomateria=m.codigomateria) where g.fechafinalgrupo>='$date' and m.codigocarrera='$carrera' ORDER BY g.fechainiciogrupo DESC;";
}
$sacarGrupoSqlRow = $db->GetRow($sacarGrupoSql);
	
if($sacarGrupoSqlRow!=NULL && count($sacarGrupoSqlRow)>0){

	$idgrupo=$sacarGrupoSqlRow['idgrupo'];
	$sacarTipoGrupoSql="select tipo from detalleGrupoCursoEducacionContinuada where idgrupo='$idgrupo'";
	$sacarTipoGrupoSqlRow = $db->GetRow($sacarTipoGrupoSql);
	if((count($sacarTipoGrupoSqlRow)>0 && $sacarTipoGrupoSqlRow["tipo"]==2)){
		$esAbierto = false;
		$mensaje = "Todo bien.";
	} else {
		$esAbierto = true;
		$mensaje = "El curso es abierto.";
	}
} else {
	$esAbierto = false;
	$mensaje = "El curso no tiene fechas de inscripcion activas.";
}

//var_dump($existe);
// return the array as json
echo json_encode(array("result"=>$esAbierto,"mensaje"=>$mensaje));
?>
