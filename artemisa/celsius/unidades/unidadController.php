<?
$pageName= "unidades1";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
   
global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);


if (!empty($idUnidad)){
	$unidad = $servicesFacade->getUnidad($idUnidad);
	if($unidad["esCentralizado"]==1){
		$nuevoUnidad= array ("Id"=>$idUnidad, "Codigo_Institucion"=>$unidad["Codigo_Institucion"], "Codigo_Dependencia"=>$unidad["Codigo_Dependencia"], "Comentarios"=>$comentarios);}
	else{
		$nuevoUnidad= array ("Id"=>$idUnidad, "Codigo_Institucion"=>$Codigo_Institucion, "Codigo_Dependencia"=>$Codigo_Dependencia, "Nombre"=>$nombre, "Direccion"=> $direccion, "Telefonos"=>$telefonos,  "Hipervinculo1"=>$sitio_web1, "Hipervinculo2"=>$sitio_web2, "Hipervinculo3"=>$sitio_web3, "Comentarios"=>$comentarios);}

	$res= $servicesFacade->modificarUnidad($nuevoUnidad);
}
else {	
	$nuevoUnidad= array ("Codigo_Institucion"=>$Codigo_Institucion, "Codigo_Dependencia"=>$Codigo_Dependencia, "Nombre"=>$nombre, "Direccion"=> $direccion, "Telefonos"=>$telefonos, "Hipervinculo1"=>$sitio_web1, "Hipervinculo2"=>$sitio_web2, "Hipervinculo3"=>$sitio_web3, "Comentarios"=>$comentarios);
	$res = $idUnidad = $servicesFacade->agregarUnidad($nuevoUnidad);
}

if (is_a($res,"Celsius_Exception")){
	$mensaje_error= $Mensajes["error.accesoBBDD"];
	$excepcion = $res;
	require "../common/mostrar_error.php";
}

if (empty($popup))
	header('Location:mostrarUnidad.php?idUnidad='.$idUnidad);
else {
	require "../layouts/top_layout_popup.php";
	?>
	<div align="center">
		'<?=$Mensajes["mensaje.unidadGuardada1"]." ".$nombre." ".$Mensajes["mensaje.unidadGuardada2"];?>'
		<script language="JavaScript" type="text/javascript">
			window.opener.location.reload();
			setTimeout('self.close()',4000);
	  	</script>
		<input type="button" onclick="self.close()" value="<?= $Mensajes["boton.cerrar"];?>"/>
	</div>
	<?
	require "../layouts/base_layout_popup.php";
}?>