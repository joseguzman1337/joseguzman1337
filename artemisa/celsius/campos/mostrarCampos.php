<?
$pageName= "campos";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

$datosCampo= $servicesFacade->getCampoPedido($id);
$descripcionesTipoDeMaterial= PedidosUtils::getTiposMateriales($VectorIdioma);

$idiomas= $servicesFacade->getIdiomasDisponibles();
$cantIdiomas= sizeof($idiomas);

/*trae los campos cargados en la tabla camposTraducidos para cargarlos en el formulario*/
$camposTraducidos= $servicesFacade->getAllCamposPedidosTraducidos($id);
foreach ($camposTraducidos as $campo){
	$aux= "texto".$campo["id_idioma"];
	$dato[$aux]=$campo["texto"];
	$aux= "abreviatura".$campo["id_idioma"];
	$dato[$aux]=$campo["abreviatura"];
	$aux= "ayuda".$campo["id_idioma"];
	$dato[$aux]=$campo["mensaje_ayuda"];
	$aux= "error".$campo["id_idioma"];
	$dato[$aux]=$campo["mensaje_error"];
}
?>

<table class="table-form" width="75%" >
	<tr>
		<th style='text-align:left !important' colspan=2><?echo $Mensajes["titulo.campoPedido"];?></th>
	</tr>
	<tr>
		<td><?echo $Mensajes["campo.tipoMaterial"];?></td>
		<td>
		<? if (isset($descripcionesTipoDeMaterial["0".$datosCampo["tipo_material"]])) echo $descripcionesTipoDeMaterial["0".$datosCampo["tipo_material"]];
			   else echo $Mensajes["titulo.camposComunes"];?>
		</td>
	</tr>
	<tr>
		<td><?echo $Mensajes["campo.codigo"];?></td>
		<td><?echo $datosCampo["codigo"];?></td>
	</tr>
	<tr>
		<td><?echo $Mensajes["campo.obligatorio"];?></td>
		<td><?if (isset($datosCampo["obligatorio"]))
					if($datosCampo["obligatorio"]==0)
							echo $Mensajes["mensaje.negacion"];
					else
							echo $Mensajes["mensaje.afirmacion"];
			?>
		 </td>
    </tr>
	<tr>
		<td><?echo $Mensajes["mensaje.expresionRegular"];?></td>
		<td><?echo $datosCampo["tipo_regexp"];?></td>
	</tr>
</table>
<br>
<?
foreach($idiomas as $idioma){
?>
<table border="0" class="table-list" width="75%">
	<tr>
		<th colspan=2 style='text-align:left !important'><?echo $idioma["Nombre"];?></th>
	</tr>
	<tr>
		<td><?echo $Mensajes["campo.texto"];?></td><td><?if(isset($dato['texto'.$idioma["Id"]])) echo $dato['texto'.$idioma["Id"]];?></td>
	</tr>
	<tr>
		<td><?echo $Mensajes["campo.abreviatura"];?></td><td><?if (isset($dato['abreviatura'.$idioma["Id"]])) echo $dato['abreviatura'.$idioma["Id"]];?></td>
	</tr>
	<tr>
		<td><?echo $Mensajes["campo.ayuda"];?></td><td><?if (isset($dato['ayuda'.$idioma["Id"]])) echo $dato['ayuda'.$idioma["Id"]];?></td>
	</tr>
	<tr>
		<td><?echo $Mensajes["campo.error"];?></td><td><?if (isset($dato['error'.$idioma["Id"]])) echo $dato['error'.$idioma["Id"]];?></td>
	</tr>
	<tr>
		<td  colspan=2 >&nbsp;</td>
	</tr>
</table>
<?}?>
<a href='modificar_campo.php?idCampo=<?echo $id;?>'><?echo $Mensajes["link.modificarCampo"];?></a>
<a href='listado_campos.php'><?echo $Mensajes["link.listadoCampos"];?></a>
<?require "../layouts/base_layout_admin.php";?>