<?
$pageName= "sugerencias";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";
global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);


if($operacion == "borrar"){
	$res = $servicesFacade->eliminarSugerencia($id_sugerencia);
	if (is_a($res,"Celsius_Exception")){
		$mensaje_error = $Mensajes["error.eliminarSugerencia"];
		$excepcion = $res;
		require "../common/mostrar_error.php";
	}
	header('Location:listar_sugerencias.php');
	exit;
}
$sugerencia = array("Titulo"=>$Titulo, "Comentario"=>$Comentario);

if($operacion == "modificar"){
	$sugerencia["Id"]= $id_sugerencia;
	$res = $servicesFacade->modificarSugerencia($sugerencia);
}else{
	$id_sugerencia=$res= $servicesFacade->agregarSugerencia($sugerencia);
}

if (is_a($res,"Celsius_Exception")){
	$mensaje_error = $Mensajes["error.accesoBBDD"];
	$excepcion = $res;
	require "../common/mostrar_error.php";
}

header('Location:mostrar_sugerencia.php?id_sugerencia='.$id_sugerencia);
?>