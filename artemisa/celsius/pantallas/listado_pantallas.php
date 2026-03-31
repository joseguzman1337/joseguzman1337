<?  
$pageName= "pantallas1";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

require "../layouts/top_layout_admin.php";	

?>
<table width="60%" align="center" class="table-list" cellpadding="1" cellspacing="1">
	<tr>
    	<td colspan="2" class="table-list-top">
    		<img src="../images/square-w.gif" width="8" height="8" /> 
    		<?= $Mensajes["tit-1"]; ?>
        </td>
    </tr>
    <tr>
    	<th><?=$Mensajes["campo.nombrePagina"];?></th>
    	<th>&nbsp;</th>
    </tr>	
	<? 
	
	$pantallas = $servicesFacade->getPantallas();
	foreach ($pantallas as $pantalla ) {?>
		<tr>
			<td><?= $pantalla["Id"];?></td>
			<td>
				<a href="agregarOModificarPantalla.php?id_pantalla=<?= $pantalla["Id"]; ?>"><?= $Mensajes["ec-1"];?></a>
			</td>
		</tr>	
	<?}?>                       
</table>
<? require "../layouts/base_layout_admin.php";?>						