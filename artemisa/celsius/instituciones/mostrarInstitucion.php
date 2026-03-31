<?
$pageName="instituciones2";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName, $IdiomaSitio);


if (empty($idInstitucion)){
	$mensaje_error= $Mensajes["error.faltaIdInstitucion"];
	$excepcion = new Application_Exception($mensaje_error);
	require "../common/mostrar_error.php";
}

$institucion= $servicesFacade->getInstitucion($idInstitucion);
$pais= $servicesFacade->getPais($institucion["Codigo_Pais"]);

if (!empty($institucion["Codigo_Localidad"]))
	$localidad= $servicesFacade->getLocalidad($institucion["Codigo_Localidad"]);
?>

<table width="70%" class="table-form" cellpadding="2" cellspacing="1" align="center">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8">
			&nbsp;
		</td>
	</tr>	
    <tr>
		<th><?= $Mensajes["et-3"];?>&nbsp;</th>
	   	<td><?= $institucion["Nombre"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-4"];?>&nbsp;</th>
	   	<td><?= $institucion["Abreviatura"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-9"];?>&nbsp;</th>
		<td ><?= $institucion["Direccion"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-1"];?>&nbsp;</th>
		<td><?if (isset($pais)) echo $pais["Nombre"];?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-2"];?>&nbsp;</th>
		<td><?if (isset($localidad)) echo $localidad["Nombre"];?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-5"];?>&nbsp;</th>
		<td>
			<?if ($institucion["Participa_Proyecto"]==1)
				 echo $Mensajes["mensaje.afirmacion"];
			  else 
			  	 echo $Mensajes["mensaje.negacion"];
			?>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-10"];?>&nbsp;</th>
		<td ><?= $institucion["Telefono"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-11"];?>&nbsp;</th>
	   	<td ><?= $institucion["Sitio_Web"]; ?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.creacionPedidosHabilitada"];?></th>
		<td>
			<? if ($institucion["habilitado_crear_pedidos"] == 1) 
				echo $Mensajes["mensaje.afirmacion"];
			else
				echo $Mensajes["mensaje.negacion"];
			?>
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.creacionUsuariosHabilitada"];?></th>
		<td>
			<? if ($institucion["habilitado_crear_usuarios"] == 1) 
				echo $Mensajes["mensaje.afirmacion"];
			else
				echo $Mensajes["mensaje.negacion"];
			?>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-13"];?>&nbsp;</th>
		<td ><?= $institucion["Comentarios"]; ?></td>
	</tr>
	<tr>
	   	<td>&nbsp;</td>
		<td >
			<input type="button" value="<?= $Mensajes["botc-2"]; ?>" onclick="location.href='modificarOAgregarInstitucion.php?idInstitucion=<?=$idInstitucion?>'"/>
			<input type="button" value="<?= $Mensajes["link.listaInstituciones"]; ?>" onclick="location.href='listadoInstituciones.php?Pais=<?=$institucion["Codigo_Pais"]?>'"/>
       	</td>
	</tr>	
</table>
				
<?require "../layouts/base_layout_admin.php";?>