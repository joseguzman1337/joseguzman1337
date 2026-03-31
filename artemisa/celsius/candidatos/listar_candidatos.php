<?php
$pageName = "candidatos";

require "../layouts/top_layout_admin.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);

$conditions = array();
if (empty($rechazados))
	$conditions["rechazados"]=0;//lista los pendientes
elseif ($rechazados == 1)
	$conditions["rechazados"]=1;//lista los aceptados
else
	$conditions["rechazados"]=2;//lista los rechazados

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
?>


<table width="70%" class="table-list" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td class="table-list-top" colspan="5">
  			<?= $Mensajes["et-1"];?>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-1"]; ?></th>
		<th><?= $Mensajes["campo.fechaInscripcion"]; ?></th>
		<th><?= $Mensajes["ec-7"]; ?></th>
	</tr>
	<?
	$candidatosPendientes = $servicesFacade->getCandidatos($conditions);
	foreach($candidatosPendientes as $candidato){?>
		<tr>
			<td><?= $candidato["Apellido"].", ".$candidato["Nombres"] ?></td>
			<td><?= $candidato["Fecha_Registro"] ?></td>
			<td>
				<input type="button" onclick="location.href='mostrar_candidato.php?id_candidato=<?= $candidato["Id"]?>';" value="<?= $Mensajes["bot-1"]?>"/>
			</td>
		</tr> 
	<? } ?>

</table>
			  
<? require "../layouts/base_layout_admin.php" ?>