<?
$pageName="instituciones";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);    
global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);
$es_creacion = empty($idInstitucion);
	
if ((isset($Participa_Proyecto))&&($Participa_Proyecto=="on"))
	$Participa_Proyecto= 1;
else
    $Participa_Proyecto= 0;

if (($esCentralizado==1)&&(!$es_creacion)){
	$inst= $servicesFacade->getInstitucion($idInstitucion);
	$Codigo_Pais= $inst["Codigo_Pais"];
	$abreviatura= $inst["Abreviatura"];
}

//Chequeo q no exista una institucion del mismo pais con la misma abreviatura
$institucionesPreexistentes = $servicesFacade->getInstituciones(array ("Codigo_Pais" => $Codigo_Pais, "Abreviatura" => $abreviatura));
if ((count($institucionesPreexistentes) > 1) || (!$es_creacion && (count($institucionesPreexistentes) == 1) && $institucionesPreexistentes[0]["Codigo"] != $idInstitucion)){
	//echo $abreviatura." ".$Mensajes["warning.errorAbreviatura"];
	$mensaje_error= $abreviatura." ".$Mensajes["warning.errorAbreviatura"];
	require "../common/mostrar_error.php";
	exit;
}

if (!$es_creacion){
	//es una modificacion
	if($esCentralizado==1)
		$nuevoInstitucion= array ("Codigo"=>$idInstitucion, "Codigo_Pais"=>$Codigo_Pais, "Codigo_Localidad"=> $Codigo_Localidad, "Comentarios"=>$comentarios, "tipo_pedido_nuevo"=>$tipo_pedido_nuevo,"habilitado_crear_pedidos" => $habilitado_crear_pedidos,"habilitado_crear_usuarios" => $habilitado_crear_usuarios);
	else
		$nuevoInstitucion= array ("Codigo"=>$idInstitucion, "Nombre"=>$nombre, "Abreviatura"=> $abreviatura, "Direccion"=> $direccion, "Codigo_Pais"=>$Codigo_Pais , "Codigo_Localidad"=> $Codigo_Localidad, "Participa_Proyecto"=>$Participa_Proyecto, "Telefono"=>$telefono, "Sitio_Web"=>$sitio_web, "Comentarios"=>$comentarios, "tipo_pedido_nuevo"=>$tipo_pedido_nuevo, "habilitado_crear_pedidos" => $habilitado_crear_pedidos, "habilitado_crear_usuarios" => $habilitado_crear_usuarios);
	$res = $servicesFacade->modificarInstitucion($nuevoInstitucion);
}else{	
   	$nuevoInstitucion= array ("Nombre"=>$nombre, "Abreviatura"=> $abreviatura, "Direccion"=> $direccion, "codigo_Pais"=>$Codigo_Pais , "Codigo_Localidad"=> $Codigo_Localidad, "Participa_Proyecto"=>$Participa_Proyecto,  "Telefono"=>$telefono, "Sitio_Web"=>$sitio_web, "Comentarios"=>$comentarios, "Codigo_Pedidos"=>$codigo_pedidos, "tipo_pedido_nuevo"=>$tipo_pedido_nuevo,"habilitado_crear_pedidos" => $habilitado_crear_pedidos,"habilitado_crear_usuarios" => $habilitado_crear_usuarios);
   	$res = $idInstitucion= $servicesFacade->agregarInstitucion($nuevoInstitucion);
}

if (is_a($res,"Celsius_Exception")){
	$mensaje_error= $Mensajes["error.accesoBBDD"];
	$excepcion = $res;
	require "../common/mostrar_error.php";
}

if (empty($popup))
	header('Location:mostrarInstitucion.php?idInstitucion='.$idInstitucion);
else {
	require "../layouts/top_layout_popup.php";
	?>
	<div align="center">
		'<?=$Mensajes["mensaje.institucionGuardada1"]." ".$nombre." ".$Mensajes["mensaje.institucionGuardada2"];?>'
		<script language="JavaScript" type="text/javascript">
			window.opener.location.reload();
			setTimeout('self.close()',4000);
	  	</script>
		<input type="button" onclick="self.close()" value="<?= $Mensajes["boton.cerrar"];?>"/>
	</div>
	<?
	require "../layouts/base_layout_popup.php";
}?>