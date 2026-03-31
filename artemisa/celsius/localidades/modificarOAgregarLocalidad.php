<?
$pageName="localidades";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";
   
global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

if (!empty($idLocalidad)){	
	$localidad= $servicesFacade->getLocalidad($idLocalidad);
}else{
	$localidad = array("Id" => "", "Nombre"=> "","Codigo_Pais" => 0 );
}
?>
<script language="JavaScript" type="text/javascript">
  	function validar_localidad(){
  		
		if (!document.getElementsByName("Codigo_pais").item(0).value){
			alert("<?=$Mensajes["error.campo_pais_incompleto"]?>");
			return false;
		}
		if (!document.getElementsByName("Nombre").item(0).value){
			alert("<?=$Mensajes["error.campo_nombre_incompleto"]?>");
			return false;
		}
		
		document.getElementsByName('B1').item(0).disabled=true;
		return true;
	}
</script>
  
<form method="post" action="localidadController.php" onsubmit="return validar_localidad();">
	<input type="hidden" name="idLocalidad" value="<?= $localidad["Id"];?>">
	
<table class="table-form" width="60%" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td class="table-form-top-blue" colspan="2">
			<img src="../images/square-w.gif" width="8" height="8">
			<?= $Mensajes["et-1"]?>
		</td>
	</tr>
	<tr>
		<th><? echo $Mensajes["ec-1"]; ?></th>
		<td>
			<select size="1" name="Codigo_pais" >									
				<? 
				$paises= $servicesFacade->getPaises();
			  	foreach($paises as $pais){?>
					<option value="<?= $pais["Id"];?>" <? if ($pais["Id"]==$localidad["Codigo_Pais"]) echo "selected"?>>
						<?= $pais["Nombre"];?>
					</option>
				<?}?> 
			</select>	    								  								  
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-2"];?></th>
		<td>
			<input type="text"  name="Nombre" value="<?=$localidad["Nombre"]; ?>" size="41">
		</td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td>
			<input type="submit" value="<? if (empty($idLocalidad)) echo $Mensajes["botc-1"];  else echo $Mensajes["botc-2"]; ?>" name="B1">
			<input type="reset" value="<? echo $Mensajes["bot-2"]; ?>" >
		</td>
	</tr>
</table>
</form>
<? require "../layouts/base_layout_admin.php";?>