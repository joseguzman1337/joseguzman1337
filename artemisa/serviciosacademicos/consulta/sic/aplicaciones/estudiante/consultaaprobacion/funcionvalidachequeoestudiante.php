<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
//valida si el formulario pertenece al estudiante o a la facultad 
function validapertenenciaformulario($objetobase,$idformulario){
$condiciontipousuario="and f.codigotipousuario = '600'";
if(isset($_SESSION["codigofacultad"])||trim($_SESSION["codigofacultad"])!='')
$condiciontipousuario="and f.codigotipousuario in ('600','700')";

$condicion="and f.codigoestado like '1%'
	".$condiciontipousuario."
	and f.idformulario <> '1'
	order by f.pesoformulario
	 ";
if($objetobase->recuperar_datos_tabla("formulario f","f.idformulario",$idformulario,$condicion,"",0)){
	return 0;
}
return 0;

}

?>