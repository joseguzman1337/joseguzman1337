<?
/**
 * @param int $Codigo_Pais?
 */
$pageName = "localidades";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

require "../layouts/top_layout_admin.php";

if (empty($Codigo_Pais))
	$Codigo_Pais = 0;

//eliminacion
if (!empty ($eliminar)) {
	$instituciones = $servicesFacade->getInstituciones(array (
		"Codigo_Localidad" => $idLocalidad
	));
	$usuarios = $servicesFacade->getUsuarios(array (
		"Codigo_Localidad" => $idLocalidad
	));
	$candidatos = $servicesFacade->getCandidatos(array (
		"Codigo_Localidad" => $idLocalidad
	));
	if ((sizeof($instituciones) + sizeof($usuarios) + sizeof($candidatos)) == 0) {
		$res = $servicesFacade->eliminarLocalidad($idLocalidad);
		if (is_a($res, "Celsius_Exception")) {
			$mensaje_error= $Mensajes["error.accesoBBDD"];
			$excepcion = $res;
			require "../common/mostrar_error.php";
		}
	} else {?>
		<script>
			alert('<?=$Mensajes["warning.errorEliminacion"];?>');
		</script>
	<?}
}
?>

<script language="JavaScript">

	function confirmar_borrado(idLocalidad){
		if (confirm("<?= $Mensajes["mensaje.confirmar_borrado"]; ?>")){
 			location.href="seleccionar_localidad.php?eliminar=1&idLocalidad="+idLocalidad+"&Codigo_Pais=<?= $Codigo_Pais; ?>";
 		}
	}
</script>

<form method="get" action="seleccionar_localidad.php" >

<table width="70%" class="table-form" align="center" cellpadding="1" cellpsacing="1">   
	<tr>
    	<td class="table-form-top-blue" colspan="2">
    		<img src="../images/square-w.gif" width="8" height="8">
    		<?=$Mensajes["et-1"];?>
        </td>
    </tr>
	<tr>
    	<th><?=$Mensajes["et-1"]?></th>
        <td>
        	<select size="1" name="Codigo_Pais" >             
				<?
				$paises = $servicesFacade->getPaises();
				foreach ($paises as $pais) {?>
					<option value="<?= $pais["Id"]; ?>" <? if($Codigo_Pais == $pais["Id"]) echo "selected"?>>
						<?= $pais["Nombre"]; ?>
					</option>
				<?}?>
			</select>
        </td>
    </tr>
    <tr>
    	<th>&nbsp;</th>
        <td>
        	<input type="submit"  value="<?=$Mensajes["boton.listar_localidades_pais"];?>" name="B1"/>
        </td>
    </tr>
</table>
</form>

<? 
//mustro las localidades del pais si corresponde
if (!empty($Codigo_Pais)){ ?>    
	<table width="70%"  border="0" align="center" cellpadding="1" cellspacing="1" class="table-list">
		<tr>
			<td colspan="3" class="table-list-top">
				<img src="../images/square-lb.gif" width="8" height="8"/>
				&nbsp;
				<?= $Mensajes["et-1"]; ?>	
			</td>
		</tr>
		<tr>
			<th><?=$Mensajes["ec-1"]; ?></th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
		<?
		$conditions = array ("Codigo_Pais" => $Codigo_Pais);
		$localidades = $servicesFacade->getLocalidades($conditions);
		foreach ($localidades as $localidad) {?>
			<tr>
				<td ><?= $localidad["Nombre"]; ?></td>
		        <td>
		        	<a href="modificarOAgregarLocalidad.php?idLocalidad=<?= $localidad["Id"]; ?>">
		        		<?= $Mensajes["botc-2"]; ?>
		        	</a>
		        </td>
		        <td>
		        	<a href="javascript:confirmar_borrado(<?=$localidad["Id"]?>);"><?= $Mensajes["boton.borrar_localidad"]; ?></a>
				</td>
			</tr>
		<?}?>
	</table>
<? }
require "../layouts/base_layout_admin.php";?>