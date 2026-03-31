<?
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
$errorAgregando=0;
 
if (empty($NumeroPedidos)){
	$NumeroPedidos = 0;
}

if (empty($IdColeccion)){
	   $coleccion= array ( "Nombre"=>$titulo_coleccion, "Abreviado"=>$abreviatura_coleccion ,  "ISSN"=>$issn_coleccion,  "Responsable"=>$Responsable ,"Volumenes" =>$Volumenes , "Frecuencia"=>$Frecuencia); 
	   $res = $servicesFacade->agregarTituloColeccion($coleccion);
	   $IdColeccion= $res;
}else{
	   $coleccion= array ("Id"=>$IdColeccion, "Nombre"=>$titulo_coleccion, " Abreviado"=>$abreviatura_coleccion, "ISSN"=>$issn_coleccion,  "Responsable"=>$Responsable, " Volumenes" =>$Volumenes, "Frecuencia"=>$Frecuencia );
	   $res= $servicesFacade->modificarTituloColeccion($coleccion);
}

if (!empty($por_ajax)){
	//es una solicitud hecha por ajax que espera solo el id de la coleccion creada
	if(is_a($res,"Celsius_Exception"))
		echo '0';
	else
		echo "$IdColeccion";
	exit;
}elseif(is_a($res,"Celsius_Exception")){
	$mensaje_error = $Mensajes["error.agregarColeccion"];
	$excepcion = new Celsius_Exception($mensaje_error);
	require "../common/mostrar_error.php";
}else
	header('Location:mostrarColeccion.php?IdColeccion='.$IdColeccion);

?>