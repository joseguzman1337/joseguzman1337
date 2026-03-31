<?
$pageName= "campos";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

/*obtengo todos los tipos de materiales (idTipoMaterial, descripcion)*/
$tiposMateriales= $servicesFacade->getTiposMateriales(); 
/*se le agrega por separado el tipo de material 0 --> para obtener los campos comunes a todos los demas tipos*/
array_unshift($tiposMateriales, array( "idTipoMaterial" => 00, "descripcion" => "Campos comunes a todos los materiales"));
?>

<table width="100%" class="table-form" border="0">
<?foreach ($tiposMateriales as $tiposMaterial){?>
	<tr>
		<th colspan='4' style='text-align:center !important' >
			<h3><? echo $tiposMaterial["descripcion"];?></h3>
		</th>
	</tr>
	<tr>
		<th style='text-align:left !important' ><?= $Mensajes["campo.codigo"];?></th>
		<th><?= $Mensajes["campo.obligatorio"];?></th>
		<th><?= $Mensajes["campo.tipoExpRegular"];?></th>
		<th>&nbsp;</th>
	</tr>
	<?
	$filas= $servicesFacade->getAllCamposPedidos($tiposMaterial["idTipoMaterial"]);
	foreach($filas as $fila){?>
	<tr>
  		<td><?echo $fila["codigo"];?></td>
  		<td><?if ($fila["obligatorio"]==1)echo $Mensajes["mensaje.afirmacion"]; else echo $Mensajes["mensaje.negacion"]; ?></td>
  		<td><?echo $fila["tipo_regexp"];?></td>
  		<td><a href="<?echo 'modificar_campo.php?idCampo='.$fila["id"];?>"><?echo $Mensajes["link.modificarCampo"];?></a></td>
  	</tr>
	<?}?>
	
	<tr>
		<td  colspan="4" >&nbsp;</td>
	</tr>
<? }?>
</table>
<?require "../layouts/base_layout_admin.php";?>