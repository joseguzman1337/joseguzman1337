<?
/**
 * $idUnidad
 */
$pageName= "unidades1";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";
    
global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

if (empty($idUnidad)){
	$mensaje_error= $Mensajes["error.faltaIdUnidad"];
	$excepcion = new Application_Exception($mensaje_error);
	require "../common/mostrar_error.php";
}

$unidad= $servicesFacade->getUnidad($idUnidad);
$dependencia= $servicesFacade->getDependencia($unidad["Codigo_Dependencia"]);
$institucion= $servicesFacade->getInstitucion($dependencia["Codigo_Institucion"]);
$pais= $servicesFacade->getPais($institucion["Codigo_Pais"]);
?>
<table width="70%" class="table-form" align="center" cellpadding="3" cellspacing="1">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			&nbsp;
		</td>
	</tr>	
	<tr>
		<th><?= $Mensajes["et-1"];?></td>
	   	<td><?if (isset($pais)) echo $pais["Nombre"];?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-2"];?></td>
	   	<td><?if (isset($institucion)) echo $institucion["Nombre"];?></td>
	</tr>
	<tr>
	   	<th><?= $Mensajes["et-3"];?></td>
		<td><?if (isset($dependencia)) echo $dependencia["Nombre"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-4"];?></td>
	   	<td><?= $unidad["Nombre"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-5"];?></td>
		<td><?= $unidad["Direccion"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-6"];?></td>
		<td><?= $unidad["Telefonos"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-8"];?></td>
		<td><?= $unidad["Hipervinculo1"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-9"];?></td>
		<td><?= $unidad["Hipervinculo2"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-10"];?></td>
		<td><?= $unidad["Hipervinculo3"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-11"];?></td>
		<td><?= $unidad["Comentarios"]; ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
		   	<input type="button" name="bModificar" value="<?= $Mensajes["boton.modificar_unidad"]; ?>" 
	    		onclick="location.href='modificarOAgregarUnidad.php?idUnidad=<?=$idUnidad?>';"/>
	    		
	    	<input type="button" name="bListar" value="<?= $Mensajes["boton.listar_unidades"]; ?>" 
	    		onclick="location.href='listadoUnidades.php?Codigo_Pais=<?=$institucion["Codigo_Pais"]?>&Codigo_Institucion=<?=$dependencia["Codigo_Institucion"]?>&Codigo_Dependencia=<?=$unidad["Codigo_Dependencia"]?>';"/>
		</td>
	</tr>		
</table>

<? require "../layouts/base_layout_admin.php";?> 