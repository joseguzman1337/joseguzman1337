<?
/**
 * $idDependencia
 */
$pageName= "dependencias";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

require "../layouts/top_layout_admin.php";
if (empty($idDependencia)) {
	$mensaje_error= $Mensajes["error.faltaIdDependencia"];
	$excepcion = new Application_Exception($mensaje_error);
	require "../common/mostrar_error.php";
}

$dependencia = $servicesFacade->getDependencia($idDependencia);
$institucion = $servicesFacade->getInstitucion($dependencia["Codigo_Institucion"]);
?>

<table width="70%" class="table-form" align="center" cellpadding="3" cellspacing="1">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8">
			<?=$Mensajes["ec-1"]; ?>
		</td>
	</tr>
	
	<tr>
		<th><?= $Mensajes["tf-3"];?></th>
		<td><?= $dependencia["Nombre"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-12"];?></th>
		<td><?= $dependencia["Abreviatura"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-4"];?></th>
		<td><?= $dependencia["Direccion"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-2"];?></th>
		<td><?if (isset($institucion)) echo $institucion["Nombre"];?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-11"];?></th>
		<td><?if ($dependencia["Es_LibLink"]==1) echo $Mensajes["mensaje.afirmacion"]; else echo $Mensajes["mensaje.negacion"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-9"];?></th>
		<td><?= $dependencia["Telefonos"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-6"];?></th>
		<td><?= $dependencia["Hipervinculo1"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-7"];?></th>
		<td><?= $dependencia["Hipervinculo2"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-8"];?></th>
		<td><?= $dependencia["Hipervinculo3"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-10"];?></th>
		<td><?= $dependencia["Comentarios"]; ?></td>
	</tr>
					
	<tr>
		<td>&nbsp;</td>
        <td>		
        	<input type="button" name="bModificar" value="<?= $Mensajes["bot-2"]; ?>" 
        		onclick="location.href='modificarOAgregarDependencia.php?idDependencia=<?= $idDependencia; ?>'" />
        		
        	<input type="button" name="bListar" value="<?= $Mensajes["h-2"]; ?>" 
        		onclick="location.href='listadoDependencias.php?Codigo_Pais=<?= $institucion ["Codigo_Pais"]?>&Codigo_Institucion=<?= $institucion ["Codigo"]?>'" />
		</td>
	</tr>	
</table>

<? require "../layouts/base_layout_admin.php";?> 