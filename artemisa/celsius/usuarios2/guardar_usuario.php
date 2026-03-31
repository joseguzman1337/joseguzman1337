<?php
/**
 * 
 */

$pageName="usuarios2";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__BIBLIOTECARIO);
require "../utils/StringUtils.php";
$rol_usuario = SessionHandler::getRolUsuario();

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);
$usuario = array();

if (!empty($Apellido))
	$usuario["Apellido"]= $Apellido;

if (!empty($Nombres))
	$usuario["Nombres"]= $Nombres;

if (!empty($Login))
	$usuario["Login"]= StringUtils::replace_accents($Login);

if (!empty($Password))
	$usuario["Password"]= StringUtils::replace_accents($Password);



if ($rol_usuario==ROL__BIBLIOTECARIO){
	$usuarioSession = SessionHandler::getUsuario();
	$Codigo_Pais=$usuarioSession['Codigo_Pais'];
	$Codigo_Institucion=$usuarioSession['Codigo_Institucion'];
	if ($usuarioSession['Bibliotecario']>TIPO__BIBLIOTECARIO_INSTITUCION){$Codigo_Dependencia=$usuarioSession['Codigo_Dependencia'];}
	if ($usuarioSession['Bibliotecario']>TIPO__BIBLIOTECARIO_DEPENDENCIA){$Codigo_Unidad=$usuarioSession['Codigo_Unidad'];}
}

if (!empty($Codigo_Pais))
	$usuario["Codigo_Pais"]=$Codigo_Pais;

if (!empty($Codigo_Institucion))
	$usuario["Codigo_Institucion"]=$Codigo_Institucion;
	
if (!empty($Codigo_Dependencia))
	$usuario["Codigo_Dependencia"]=$Codigo_Dependencia;

if (!empty($Codigo_Unidad))
	$usuario["Codigo_Unidad"]=$Codigo_Unidad;

if (!empty($Direccion))
	$usuario["Direccion"]=$Direccion;

if (!empty($Codigo_Localidad))
	$usuario["Codigo_Localidad"]=$Codigo_Localidad;

if (!empty($EMail))
	$usuario["EMail"]=$EMail;

if (!empty($Telefonos))
	$usuario["Telefonos"]=$Telefonos;

if (!empty($Codigo_Categoria))
	$usuario["Codigo_Categoria"]=$Codigo_Categoria;

if (!empty($Codigo_FormaEntrega))
	$usuario["Codigo_FormaEntrega"]=$Codigo_FormaEntrega;

if ($rol_usuario==ROL__ADMINISTADOR){
	$usuario["Personal"]=(!empty($Personal) && ($Personal == "ON"))?1:0;
	$usuario["Staff"]=(!empty($Staff) && ($Staff == "ON"))?1:0;
	$usuario["Orden_Staff"]=($usuario["Staff"])?$Orden_Staff:0;
	$usuario["Cargo"]=($usuario["Staff"])?$Cargo:"";
	$usuario["Bibliotecario"]=(!empty($Bibliotecario))?$Bibliotecario:0;
}

if (!empty($Comentarios))
	$usuario["Comentarios"]=$Comentarios;

$usuario["Fecha_Solicitud"]=$usuario["Fecha_Alta"]=date("Y-m-d");
$usuario["Delay_Atencion"]=0;

$creador = SessionHandler::getUsuario();
$usuario["Codigo_UsuarioAprueba"]=$creador["Id"];

//if error require "modificar_usuario.php"; exit;
if (empty($id_usuario)){
	//es una creacion
	$usuario["Fecha_Alta"]=date("Y-m-d");
	$res = $id_usuario = $servicesFacade->agregarUsuario($usuario);
}else{
	//es una modificacion
	$usuario["Id"]=$id_usuario;
	$res = $servicesFacade->modificarUsuario($usuario);
}

if (is_a($res, "Celsius_Exception")){
	$mensaje_error = $Mensajes["error.accesoBBDD"];
	$excepcion = $res;
	require "../common/mostrar_error.php";
}

header("Location: mostrar_usuario.php?id_usuario=".$id_usuario);
?>