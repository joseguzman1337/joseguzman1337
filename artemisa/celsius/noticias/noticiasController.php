<?
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
$year = substr($Fecha, 6,4);
$month = substr($Fecha, 3, 2);
$day = substr($Fecha, 0, 2);
$Fecha = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year)); 

$nuevaNoticia= array("Fecha"=>$Fecha, "Titulo"=>$Titulo, "Texto_Noticia"=>$Texto, "Codigo_Idioma"=>$Codigo_Idioma);

if (empty($idNoticia)){
	$idNoticia=$res= $servicesFacade->agregarNoticia($nuevaNoticia);
}else{
	$nuevaNoticia["Id"]= $idNoticia;
	$res = $servicesFacade->modificarNoticia($nuevaNoticia);
}
 
if (is_a($res,"Celsius_Exception")){
	return $res;
	exit;	
}
	header('Location:mostrarNoticia.php?idNoticia='.$idNoticia);
?>