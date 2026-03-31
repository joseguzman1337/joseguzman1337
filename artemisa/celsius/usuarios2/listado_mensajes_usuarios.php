<?php
/**
 * @param int $id_usuario
 * @param string $datos_usuario
 */
 $pageName="mensajes";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__USUARIO);
require "../layouts/top_layout_admin.php";
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (empty($opcion))
	$opcion = 3;
?>

<form name="datosUser">
	<input type='hidden' name='id_usuario' value='<?=$id_usuario?>' />
	<input type='hidden' name='datos_usuario' value='<?=$datos_usuario?>' />

<table class="table-form" width="50%" border="0" cellpadding="1" cellspacing="1" align="center">
<tr>
   	<td class="table-form-top-blue">
   		<?=$Mensajes['et-001']?>: <?=$datos_usuario?>
   	</td>
</tr>
<tr>
	<td td style='text-align:center'>
		<input type='radio' name='opcion' value='1' <? if ($opcion == 1) echo "checked";?>>
		<?=$Mensajes['li-1']?>
		<input type='radio' name='opcion' value='2' <? if ($opcion == 2) echo "checked";?>>
		<?=$Mensajes['li-2']?>   
		<input type='radio' name='opcion' value='3' <? if ($opcion == 3) echo "checked";?>>
		<?=$Mensajes['li-3']?>
	</td>
</tr>
<tr align="center">
	<td style='text-align:center'>
		<input type='submit' value='<?=$Mensajes["boton.enviar"];?>'>
	</td>
</tr>
</table>
</form>

<?
$conditions = array ();
$conditions["idUsuario"] = $id_usuario;
?>
<br/>

<table class="table-form" width="70%" border="0" cellpadding="1" cellspacing="1" align="center">
	<tr>
		<td class="table-form-top-blue">
			<?
			if ($opcion == 1) {
				$conditions["leido"] = 1;
				echo $Mensajes['txt-1'];
			}elseif ($opcion == 2) {
				$conditions["leido"] = 0;
				echo $Mensajes['txt-2'];
			}else {
				echo $Mensajes['txt-3'];
			}
			?>
		</td>
	</tr>

	<?
	$mensajes = $servicesFacade->getMensajes_Usuarios($conditions);
	foreach ($mensajes as $mensaje) {?>
        <tr>
			<td> 
				<table class="table-form" width="95%"  style="table-layout:fixed;" border="0" cellpadding="1" cellspacing="1" align="center"> 
			  		<tr>
						<th width="20%"><?=$Mensajes['et-004']?></th> 
	                    <td width="75%" ><?=$mensaje["fecha_creado"]?></td> 
					</tr>
					<tr> 
						<th width="20%"><?=$Mensajes['et-005']?></th>
						<td style="word-wrap: break-word;"><?=$mensaje['texto']?></td>
					</tr>
					<tr>
						<?if ($mensaje['leido'] == 1) { ?>
			           		<th width="20%"><?=$Mensajes['et-007']?></th>
			           		<td width="75%"><?=$mensaje['fecha_leido']?></td>
			           	<?}else{?>
							<th width="20%"><?=$Mensajes['et-006']?></th>
							<td width="75%">&nbsp;</td>
							
						<?}?>
	     			</tr>
	  			</table>
			</td>
		</tr>
		<tr><td><hr width="100%" size="1"></td></tr>
	<?}?>
</table>

<? require "../layouts/base_layout_admin.php";?> 