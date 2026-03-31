<?php
/**
 * Formulario para recuperar el password en caso de que el usuario se lo haya olvidado.
 */
$pageName= "password";
require_once "../layouts/top_layout_admin.php";

global  $IdiomaSitio ; 
$Mensajes = Comienzo ($pageName,$IdiomaSitio);  
?>
<table width="95%" border="0" >
<tr>
	<td valign="top" align="center">
	<? if (empty($enviar) || empty($direccion_mail)) { ?>
		<!-- FORM contraseña -->
		<form name='form1' action="olvide_contrasenia.php" method="POST">
		<table width="80%" border="0" align="center" class="table-form" cellpadding="2" cellspacing="2">
		<tr>
			<td class="table-form-top-blue" colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2"><? echo $Mensajes['txt-1']; ?></td>
		</tr>
		<tr>
		   	<td width="15%" style="text-align:right !important"><? echo $Mensajes["ec-1"]?></td>
		   	<td><input name="direccion_mail" id="direccion_mail" type="text" class="style22" size="40" /></td>
		</tr>
		<tr>
		   	<td width="15%">&nbsp;</td>
		   	<td><input name="enviar" type="submit" value="<?= $Mensajes["bot-1"]?>" /></td>
		</tr>
		<tr>
		   	<td colspan="2"><img src="../images/password.gif" width="32" height="32"></td>
		</tr>
		</table>
		</form>
		<!-- FORM contraseña -->		
			
	<? } else {?>
		<blockquote class="style22">
  	<?
		//recupero los usuarios con la direccion de email que me ingresaron
		$usuarios = $servicesFacade->getUsuarios(array("EMail" => $direccion_mail));
	
		//no hay usuarios con ese mail
		if (count($usuarios) == 0) {
			echo $Mensajes['txt-3']; 
		}elseif (count($usuarios) > 1) {
			echo $Mensajes["warning.mailExistente"]; 
		}else{
			$usuario = array_pop($usuarios);
						
			// Se usa el codigo 100 para indicar el envío de un e-mail de clave
			$plantilla = $servicesFacade->getPlantilla(array("Cuando_Usa" => 100));
			$subject = $plantilla["Denominacion"];
			$texto_mail = $servicesFacade->reemplazar_variables_plantilla($plantilla["Texto"], $usuario);
					
			$mail_enviado = $servicesFacade->enviar_mail($direccion_mail,$subject,$texto_mail, $usuario["Id"],0);
			if ($mail_enviado === false || is_a($mail_enviado, "Celsius_Exception")){
				$err_msg= $Mensajes["warning.error"]; 
				if (is_a($mail_enviado, "Celsius_Exception")){
					$mensaje_error = $err_msg;
					$excepcion = $res;
					require "../common/mostrar_error.php";
				}
				else{
					echo $err_msg."<br/>";	
					var_dump($mail_enviado);
				}
				echo "<br/> <a href=javascript:window.history.back()> Volver </a>";
			}
			else{
				//se envio bien
				echo $Mensajes['txt-2'];
			}
					
		}?>
		</blockquote>
  	<?}?>
	</td>
	<td width="150" valign="top" bgcolor="#E4E4E4" align="center" class="style11" >
		<img src="../images/email.jpg" width="150" height="113" border="0" />
	</td>
</tr>
</table>
<?
$pageName = "password";
require_once "../layouts/base_layout_admin.php";
?>