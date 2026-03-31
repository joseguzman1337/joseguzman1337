<?php
/**
 * @param int id_usuario
 */
 $pageName="usuarios2";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__BIBLIOTECARIO);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);  

$usuario = $servicesFacade->getUsuarioCompleto($id_usuario);
$rol_usuario = SessionHandler::getRolUsuario();
?>
<script language="JavaScript" type="text/javascript">
  function enviarMail(idUsuario){
  	location.href ='../mail/enviar_mail2.php?id_usuario='+idUsuario; 
  }
</script>

<table width="85%"  border="0" align="center" cellpadding="3" cellspacing="1" class="table-form">
	<tr>
		<td colspan="2" class="table-form-top-blue">&nbsp;	</td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-1"]?></th>
		<td><?=$usuario["Apellido"]?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-2"]?></th>
		<td><?=$usuario["Nombres"]?></td>
	</tr>
	<?if ($rol_usuario==ROL__ADMINISTADOR){?>	
		<tr>
			<th><?= $Mensajes["campo.login"];?></th>
			<td><?=$usuario["Login"]?></td>
			</tr>
				<tr>
			<th><?= $Mensajes["campo.password"];?></th>
		<td><?=$usuario["Password"]?></td>
	</tr>
	<? } ?>
	<tr>
		<th><?=$Mensajes["et-4"]?></th>
		<td><?=$usuario["Nombre_Pais"]?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-5"]?></th>
		<td><?=$usuario["Nombre_Institucion"]?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-6"]?></th>
		<td><?=$usuario["Nombre_Dependencia"]?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-11"]?></th>
		<td><?=$usuario["Nombre_Unidad"]?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-7"]?></th>
		<td><?=$usuario["Direccion"]?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.localidad"]?></th>
		<td><?=$usuario["Nombre_Localidad"]?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-3"]?></th>
		<td><?=$usuario["EMail"]?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-8"]?></th>
		<td><?=$usuario["Telefonos"]?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-9"]?></th>
		<td><?=$usuario["Nombre_Categoria"]?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.formaDeEntrega"]?></th>
		<td><?=$usuario["Nombre_FormaEntrega"]?></td>
	</tr>
	<?if ($rol_usuario==ROL__ADMINISTADOR){?>
		<tr>
			<th><?= $Mensajes["campo.administracion"];?></th>
			<td><input type="checkbox" <? if ($usuario["Personal"]==1) { echo "checked"; } ?> disabled="true"></td>
		</tr>
		<tr>
			<th><?= $Mensajes["campo.nivelBibliotecario"];?></th>
			<td>
				<? if ($usuario["Bibliotecario"]==0)
					echo $Mensajes["opcion.ninguno"];
				else
					echo $VectorIdioma["Perfil_Biblio_".$usuario["Bibliotecario"]];
				?>
			</td>
		</tr>
		<tr>
			<th><?= $Mensajes["campo.staff"];?></th>
			<td><input type="checkbox" <? if ($usuario["Staff"]==1) { echo "checked"; } ?> disabled="true"></td>
		</tr>
		<tr>
			<th><?= $Mensajes["campo.ordenStaff"];?></th>
			<td><?=$usuario["Orden_Staff"]?></td>
		</tr>
		<tr>
			<th><?= $Mensajes["campo.cargo"];?></th>
			<td><?=$usuario["Cargo"]?></td>
		</tr>
	<?}?>
	<tr>
		<th><?= $Mensajes["campo.fechaAlta"];?></th>
		<td><?=$usuario["Fecha_Alta"]?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.comentarios"];?></th>
		<td><?=$usuario["Comentarios"]?></td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td>
		<?if ($rol_usuario==ROL__ADMINISTADOR){?>
			<input type="button" name="name"  onclick="location.href='modificar_usuario.php?id_usuario=<?=$id_usuario?>';" value="<?= $Mensajes["boton.editarUsuario"];?>"/>
			<input type="button" name="name"  onclick="enviarMail('<?=$id_usuario?>');" value="<?= $Mensajes["boton.enviarMail"];?>"/>
		<?}else{?>
		    <input type="button" name="name"  onclick="location.href='modificar_usuario_bibliotecario.php?id_usuario=<?=$id_usuario?>';" value="<?= $Mensajes["boton.editarUsuario"];?>"/>
		<?}?>	
       </td>
	</tr>
</table>

<br/>

<? require "../layouts/base_layout_admin.php" ?>