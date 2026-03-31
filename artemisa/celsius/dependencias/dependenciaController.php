<?
$pageName="dependencias";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);
$es_creacion = empty($idDependencia);


if ((isset($Es_LibLink))&&($Es_LibLink=="on"))
	$Es_LibLink= 1;
else
    $Es_LibLink= 0;
	
if (!$es_creacion){
	if($esCentralizado==1){
		$dep= $servicesFacade->getDependencia($idDependencia);
		$nuevoDependencia= array ("Id"=>$idDependencia, "Codigo_Institucion"=>$dep["Codigo_Institucion"], "Comentarios"=>$comentarios);
	}
	else
		$nuevoDependencia= array ("Id"=>$idDependencia, "Codigo_Institucion"=>$Codigo_Institucion, "Nombre"=>$nombre, "Abreviatura"=>$abreviatura,"Direccion"=> $direccion, "Telefonos"=>$telefonos, "Es_LibLink"=> $Es_LibLink, "Hipervinculo1"=>$sitio_web1, "Hipervinculo2"=>$sitio_web2, "Hipervinculo3"=>$sitio_web3, "Comentarios"=>$comentarios);
	$res= $servicesFacade->modificarDependencia($nuevoDependencia);
}else {	
	$nuevoDependencia= array ("Codigo_Institucion"=>$Codigo_Institucion, "Nombre"=>$nombre, "Direccion"=> $direccion, "Telefonos"=>$telefonos, "Es_LibLink"=> $Es_LibLink, "Hipervinculo1"=>$sitio_web1, "Hipervinculo2"=>$sitio_web2, "Hipervinculo3"=>$sitio_web3, "Comentarios"=>$comentarios);
	$res = $idDependencia = $servicesFacade->agregarDependencia($nuevoDependencia);
}
if (is_a($res,"Celsius_Exception")){
	$mensaje_error= $Mensajes["error.accesoBBDD"];
	$excepcion = $res;
	require "../common/mostrar_error.php";
}



if (empty($popup))
	header('Location:mostrarDependencia.php?idDependencia='.$idDependencia);
else {
	require "../layouts/top_layout_popup.php";
	?>
	<div align="center">
		'<?=$Mensajes["mensaje.dependenciaGuardada1"]." ".$nombre." ".$Mensajes["mensaje.dependenciaGuardada2"];?>'
		<script language="JavaScript" type="text/javascript">
			window.opener.location.reload();
			setTimeout('self.close()',4000);
	  	</script>
		<input type="button" onclick="self.close()" value="<?= $Mensajes["boton.cerrar"];?>"/>
	</div>
	<?
	require "../layouts/base_layout_popup.php";
}?>