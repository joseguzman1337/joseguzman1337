<?
$pageName= "localidades";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);


if (empty($idLocalidad)){
	$mensaje_error= $Mensajes["error.faltaIdLocalidad"];
	$excepcion = new Application_Exception($mensaje_error);
	require "../common/mostrar_error.php";
}

$localidad= $servicesFacade->getLocalidad($idLocalidad);
$pais= $servicesFacade->getPais($localidad["Codigo_Pais"]);
?>

<table width="50%" class="table-form" align="center" cellpadding="1">	
	<tr>
		<td colspan="2" class="table-form-top-blue">&nbsp;</td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-1"];?></td>
		<td><?= $pais['Nombre'];?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.localidad"];?></td>
		<td><?= $localidad['Nombre'];?></td>
	</tr>
	<tr>
	   	<td>&nbsp;</td>
		<td >
			<input type="button" value="<?= $Mensajes["botc-2"]; ?>" onclick="location.href='modificarOAgregarLocalidad.php?idLocalidad=<?=$idLocalidad?>'"/>
			<input type="button" value="<?= $Mensajes["boton.listar_localidades_pais"]; ?>" onclick="location.href='seleccionar_localidad.php?Pais=<?=$localidad["Codigo_Pais"]?>'"/>
       	</td>
	</tr>	
</table>
	
				
<?require "../layouts/base_layout_admin.php";?>