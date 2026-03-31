<?php
$pageName = "mails";
 require_once "../common/includes.php";
 SessionHandler::validar_nivel_acceso(ROL__USUARIO); 
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

$rol_usuario = SessionHandler::getRolUsuario();
if ($rol_usuario != ROL__ADMINISTADOR || empty($id_usuario)){
	$usuario = SessionHandler::getUsuario();
	$id_usuario = $usuario["Id"];
}
 
$conditions=array("Codigo_Usuario"=>$id_usuario);
$numfilas=$servicesFacade->getCount("mail",$conditions);
     
$mails=$servicesFacade->getMails($conditions);
?>
<table class="table-form">
    <tr>
    	<td  class="table-form-top-blue"><?=$numfilas; ?>&nbsp;<?=$Mensajes["tf-4"];?></td>
    </tr>
    <tr>
    	<td>
			<? foreach($mails as $mail){ ?>
				<table class="table-form">
					<tr>
						<th><?=$Mensajes["ec-1"]?></th>
						<td><?=$mail['Direccion']?></td>
					</tr>
				    <tr>
						<th><?=$Mensajes["ec-2"];?></th>
				        <td><?=$mail['Asunto']?></td>
					</tr>
				    <tr>
						<th><?echo $Mensajes["ec-3"];?></th>
				        <td><?=$mail['Fecha']?></td>
				    </tr>
				    <tr>
				    	<th><?echo $Mensajes["ec-4"];?></th>
				        <td><?=$mail['Hora']?></td>
				    </tr>
				    <tr>
				    	<td colspan="2"><textarea name="textarea" cols="90" rows="6"><?=$mail['Texto']?></textarea></td>
				    </tr>
				</table>
				<hr>
			<?}?>
		</td>
	</tr>
</table> 
<? require "../layouts/base_layout_admin.php";?>