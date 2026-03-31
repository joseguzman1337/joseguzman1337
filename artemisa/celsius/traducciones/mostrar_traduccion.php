<?
$pageName = "traducciones";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
?>

<table width="90%" class="table-form">			
	<tr>
		<th><?= $Mensajes["ec-1"];?></th>
		<td><?= $Codigo_Pantalla;?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-2"];?></th>
		<td><?= $Codigo_Elemento; ?></td>
	</tr>
	
	<tr>
		<th><?= $Mensajes["ec-3"];?> </th>
		<td><?= $DescIdioma; ?></td>
	</tr>
	
	<tr>
		<th><?= $Mensajes["ec-4"];?> </th>
		<td><?= $Texto; ?></td>
	</tr>
</table>

<? require "../layouts/base_layout_admin.php";?> 