<?php
/**
 * @ param int $id_candidato
 */
$pageName="candidatos1";
require_once "../common/includes.php";
global  $IdiomaSitio ;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);
  
$candidato = array("Apellido" => $Apellido, "Nombres" => $Nombres, "EMail" => $EMail, "Codigo_pais" => $Codigo_Pais,
	"Otro_pais" => $Otro_Pais, "Codigo_Institucion" => $Codigo_Institucion, "Otra_Institucion" => $Otra_Institucion,
	"Codigo_Dependencia" => $Codigo_Dependencia, "Otra_Dependencia" => $Otra_Dependencia, "Codigo_Unidad" => $Codigo_Unidad,
	"Otra_Unidad" => $Otra_Unidad, "Codigo_Localidad" => $Codigo_Localidad, "Otra_Localidad" => $Otra_Localidad,
	"Codigo_Categoria" => $Codigo_Categoria, "Otra_Categoria" => $Otra_Categoria, "Direccion" => $Direccion,
	"Telefonos" => $Telefonos,  "Comentarios" => $Comentarios);

$error= (empty($Apellido)||empty($Nombres)||empty($EMail)||empty($Telefonos));

if(!$error){
	$error= (empty($Codigo_Pais)and empty($Otro_Pais))||
			(empty($Codigo_Institucion)and empty($Otra_Institucion))||
			(empty($Codigo_Dependencia)and empty($Otra_Dependencia))||
			(empty($Codigo_Categoria)and empty($Otra_Categoria));
}

if ($error){
	$mensaje_error = "Faltan datos obligatorios";
	$excepcion = new Celsius_Exception($mensaje_error);
	require "../common/mostrar_error.php";
}

if (empty($id_candidato)){
	//es una creacion
	$candidato["Fecha_Registro"] = date("Y-m-d H:i:s");
	$res = $id_usuario = $servicesFacade->agregarCandidato($candidato);
}else{
	//es una modificacion
	SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
	
	$candidato["Id"]=$id_candidato;
	$res = $servicesFacade->modificarCandidato($candidato);
	
	header("Location: mostrar_candidato.php?id_candidato=$id_candidato");
	exit;
}

require "../layouts/top_layout_admin.php";
echo "<blockquote>";
if (is_a($res, "Celsius_Exception")){
	$mensaje_error = $Mensajes['txt-2'];
	$excepcion = $res;
	require "../common/mostrar_error.php";
}else{
	$contacto = Configuracion::getMailContacto();
	echo $Mensajes['txt-1']." <a href='mailto:".$contacto."'>".$contacto."</a>";
}
echo "</blockquote>";
require "../layouts/base_layout_admin.php";
?>