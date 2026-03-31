<?php
/**
 * @param int $id_candidato
 */
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__BIBLIOTECARIO);
require "../utils/StringUtils.php";
$pageName="candidatos1";
$Mensajes = Comienzo ($pageName,$IdiomaSitio);
$candidato = $servicesFacade->getCandidato($id_candidato);

$usuario = array();
$usuario["Apellido"]=$candidato["Apellido"];
$usuario["Nombres"]=$candidato["Nombres"];
$usuario["Login"]=StringUtils::replace_accents($_REQUEST["Login"]);
$usuario["Password"]=StringUtils::replace_accents($_REQUEST["Password"]);
$usuario["Codigo_Pais"]=$candidato["Codigo_Pais"];
$usuario["Codigo_Institucion"]=$candidato["Codigo_Institucion"];
$usuario["Codigo_Dependencia"]=$candidato["Codigo_Dependencia"];
$usuario["Codigo_Unidad"]=$candidato["Codigo_Unidad"];
$usuario["Direccion"]=$candidato["Direccion"];
$usuario["Codigo_Localidad"]=$candidato["Codigo_Localidad"];
$usuario["EMail"]=$candidato["EMail"];
$usuario["Telefonos"]=$candidato["Telefonos"];
$usuario["Codigo_Categoria"]=$candidato["Codigo_Categoria"];
$usuario["Codigo_FormaEntrega"]=$_REQUEST["Codigo_FormaEntrega"];
$usuario["Personal"]=0;
$usuario["Staff"]=0;
$usuario["Orden_Staff"]=0;
$usuario["Cargo"]="";
$usuario["Bibliotecario"]=$_REQUEST["Bibliotecario"];
$usuario["Comentarios"]=$candidato["Comentarios"];
$usuario["Fecha_Alta"]=date("Y-m-d");
$usuario["Fecha_Solicitud"]=$candidato["Fecha_Registro"];
$usuario["Delay_Atencion"]=calcular_dias($usuario["Fecha_Solicitud"],$usuario["Fecha_Alta"]);
$creador = SessionHandler::getUsuario();
$usuario["Codigo_UsuarioAprueba"]=$creador["Id"];


$error = (empty($usuario["Codigo_Pais"])||empty($usuario["Codigo_Institucion"])||empty($usuario["Codigo_Dependencia"])||
		  empty($usuario["Apellido"])||empty($usuario["Nombres"])||empty($usuario["Login"])||empty($usuario["Password"])||
		  empty($usuario["Telefonos"])||empty($usuario["EMail"])||empty($usuario["Codigo_Categoria"])||empty($usuario["Codigo_FormaEntrega"]));
		  
if($error){
	$mensaje_error = "Faltan datos obligatorios";
	$excepcion = new Celsius_Exception($mensaje_error);
	require "../common/mostrar_error.php";
}

$existe= $servicesFacade->existeLoginUsuario($usuario["Login"]);
if (!$existe){
	$res = $id_usuario = $servicesFacade->agregarUsuario($usuario);
	if (is_a($res, "Celsius_Exception")){
		$mensaje_error = $Mensajes["errorCreacion"];
		$excepcion = $res;
		require "../common/mostrar_error.php";
	}
	$res = $servicesFacade->modificarCandidato(array("Id" => $id_candidato, "rechazados" => 1));
	if (is_a($res, "Celsius_Exception")){
		$mensaje_error = $Mensajes["errorActualizacion"];
		$excepcion = $res;
		require "../common/mostrar_error.php";
	}
	$plantilla = $servicesFacade->getPlantilla(array("Cuando_Usa" => 100));
	header("Location: ../mail/enviar_mail2.php?id_usuario=".$id_usuario."&id_plantilla=".$plantilla["Id"]."&url_origen=candidatos/listar_candidatos.php");
}else{
	 header("Location: mostrar_candidato.php?id_candidato=".$id_candidato."&error=1");
	 exit;
}
?>