<?
/**
 * @param string id_pedido El id del pedido a modificar (solo si es una modificacion)
 * @param string id_usuario? El id del usuario q  solicita el pedido, solo si es una creacion y el operador es un administrador
 * @param string todos los campos de pedidos opcionales.
 */

$pageName = "pedidos";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);
$usuario = SessionHandler::getUsuario();

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

$id_creador = $usuario["Id"];
$colsToUpdate = array();
switch ($Tipo_Material) {
	case TIPO_MATERIAL__REVISTA:
		$colsToUpdate["Titulo_Revista"]=$Titulo_Revista;
		$colsToUpdate["Titulo_Articulo"]=$Titulo_Articulo;
		$colsToUpdate["Volumen_Revista"]=$Volumen_Revista;
		$colsToUpdate["Numero_Revista"]=$Numero_Revista;
		$colsToUpdate["Anio_Revista"]=$Anio_Revista;
		$colsToUpdate["Codigo_Titulo_Revista"]=$Codigo_Titulo_Revista;
		
		$colsToUpdate["Autor_Detalle1"]=$Autor_Detalle1;
		$colsToUpdate["Autor_Detalle2"]=$Autor_Detalle2;
		$colsToUpdate["Autor_Detalle3"]=$Autor_Detalle3;
		$colsToUpdate["Pagina_Desde"]=$Pagina_Desde;
		$colsToUpdate["Pagina_Hasta"]=$Pagina_Hasta;
		
		break;
	case TIPO_MATERIAL__LIBRO:
		$colsToUpdate["Titulo_Libro"]=$Titulo_Libro;
		$colsToUpdate["Anio_Libro"]=$Anio_Libro;
		$colsToUpdate["Autor_Libro"]=$Autor_Libro;
		$colsToUpdate["Editor_Libro"]=$Editor_Libro;
		$colsToUpdate["Capitulo_Libro"]=$Capitulo_Libro;

		$Desea_Indice = (isset ($Desea_Indice) && $Desea_Indice == "true")?1:0;
		$colsToUpdate["Desea_Indice"]=$Desea_Indice;
		
		$colsToUpdate["Autor_Detalle1"]=$Autor_Detalle1;
		$colsToUpdate["Autor_Detalle2"]=$Autor_Detalle2;
		$colsToUpdate["Autor_Detalle3"]=$Autor_Detalle3;
		$colsToUpdate["Pagina_Desde"]=$Pagina_Desde;
		$colsToUpdate["Pagina_Hasta"]=$Pagina_Hasta;
		break;
	case TIPO_MATERIAL__PATENTE:
		$colsToUpdate["Autor_Detalle1"]=$Autor_Patente;
		$colsToUpdate["Codigo_Pais_Patente"]=$Codigo_Pais_Patente;
		$colsToUpdate["Pais_Patente"]=$Pais_Patente;
		$colsToUpdate["Anio_Patente"]=$Anio_Patente;
		$colsToUpdate["Numero_Patente"]=$Numero_Patente;
		break;
	case TIPO_MATERIAL__TESIS:
		$colsToUpdate["TituloTesis"]=$TituloTesis;
		$colsToUpdate["AutorTesis"]=$AutorTesis;
		$colsToUpdate["DirectorTesis"]=$DirectorTesis;
		$colsToUpdate["GradoAccede"]=$GradoAccede;
		$colsToUpdate["Anio_Tesis"]=$Anio_Tesis;
		$colsToUpdate["PagCapitulo"]=$PagCapitulo;
		$colsToUpdate["Codigo_Pais_Tesis"]=$Codigo_Pais_Tesis;
		$colsToUpdate["Otro_Pais_Tesis"]=$Otro_Pais_Tesis;
		$colsToUpdate["Codigo_Institucion_Tesis"]=$Codigo_Institucion_Tesis;
		$colsToUpdate["Otra_Institucion_Tesis"]=$Otra_Institucion_Tesis;
		$colsToUpdate["Codigo_Dependencia_Tesis"]=$Codigo_Dependencia_Tesis;
		$colsToUpdate["Otra_Dependencia_Tesis"]=$Otra_Dependencia_Tesis;
		break;
	case TIPO_MATERIAL__CONGRESO:
		$colsToUpdate["TituloCongreso"]=$TituloCongreso;
		$colsToUpdate["Organizador"]=$Organizador;
		$colsToUpdate["Autor_Detalle1"]=$AutorPonencia;
		$colsToUpdate["NumeroLugar"]=$NumeroLugar;
		$colsToUpdate["Anio_Congreso"]=$Anio_Congreso;
		$colsToUpdate["PaginaCapitulo"]=$PaginaCapitulo;
		$colsToUpdate["PonenciaActa"]=$PonenciaActa;
		$colsToUpdate["Codigo_Pais_Congreso"]=$Codigo_Pais_Congreso;
		$colsToUpdate["Otro_Pais_Congreso"]=$Otro_Pais_Congreso;
		break;
	default:
		die("El tipo de material '$TipoMaterial' no existe");
		break;
}

$colsToUpdate["isbn_issn"]=$isbn_issn;
$colsToUpdate["Observaciones"]=$Observaciones;
$colsToUpdate["Biblioteca_Sugerida"]=$Biblioteca;
if (!empty($Tipo_Pedido)){
	$colsToUpdate["Tipo_Pedido"]=$Tipo_Pedido;
}else{
	$colsToUpdate["Tipo_Pedido"]=$servicesFacade->tipo_pedido_x_defecto($Codigo_Usuario);
    
}

$creacion = empty($id_pedido);
if ($creacion){
	// "es una creacion";

	$colsToUpdate["Usuario_Creador"]=$id_creador;
	$rol = SessionHandler::getRolUsuario();
	$colsToUpdate["Tipo_Usuario_Crea"]=$rol;
	if ($rol == ROL__USUARIO)
		$colsToUpdate["Codigo_Usuario"]=$id_creador;
	else{
		if (empty($Codigo_Usuario))
			die("debe seleccionar un usuario");
		$colsToUpdate["Codigo_Usuario"]=$Codigo_Usuario;
	}
	$colsToUpdate["Tipo_Material"]=$Tipo_Material;
		
	$res = $id_pedido = $servicesFacade->crearPedido_OrigenLocal($colsToUpdate);
}else{
	//es una modificacion
	$res =$servicesFacade->modificarPedido($id_pedido,$colsToUpdate);
}
if (is_a($res, "Celsius_Exception")){
	$mensaje_error = "Error al tratar de guardar el pedido. Datos del pedido: ". var_export($colsToUpdate, true);
	$excepcion = $id_pedido;
	require "../common/mostrar_error.php";
}

if ($creacion){ ?>
	<? require "../layouts/top_layout_admin.php"; ?>
	<center><?=$Mensajes["mensaje.pedidoGuardado1"]." ".$id_pedido." ".$Mensajes["mensaje.pedidoGuardado2"];?>
	<br>
	<input type="button" onclick="location.href='mostrar_pedido.php?id_pedido=<?=$id_pedido?>'" value="<?=$Mensajes["boton.verPedido"];?>"/>
	<input type="button" onclick="location.href='seleccionar_tipo_material.php?id_usuario=<?=$colsToUpdate["Codigo_Usuario"]?>'" value="<?=$Mensajes["boton.agregarMasPedidos"];?>"/>
	</center>
	<? require "../layouts/base_layout_admin.php"; ?>
<?}else{?>
	<? require "../layouts/top_layout_popup.php"; ?>
	<center><?=$Mensajes["mensaje.pedidoGuardado1"]." ".$id_pedido." ".$Mensajes["mensaje.pedidoGuardado2"];?>
	</center>
	<script language="JavaScript" type="text/javascript">
		window.opener.location.reload();
		setTimeout('self.close()',5000)
	</script>
	<input type="button" onclick="self.close()" value="<?=$Mensajes["boton.cerrar"];?>"/>
	<? require "../layouts/base_layout_popup.php"; ?>
<?}?>