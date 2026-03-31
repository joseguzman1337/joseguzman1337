<?
$pageName="login_usuario";
require_once "../common/includes.php";
$rolUsuarioExistente = SessionHandler::getRolUsuario();
if(!empty($rolUsuarioExistente) && ($rolUsuarioExistente > ROL__INVITADO)){
	if($rolUsuarioExistente == ROL__ADMINISTADOR)
		header("Location: sitio_administrador.php");
	elseif($rolUsuarioExistente == ROL__BIBLIOTECARIO)
		header("Location: sitio_bibliotecario.php");
	else
		header("Location: sitio_usuario.php");
	return;
}

require_once "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
?>

<table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
	<tr bgcolor="#EFEFEF">
		<td bgcolor="#E4E4E4" align="center">
			<!-- TABLA 3 -->
			<table width="97%" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<!-- TABLA 4 -->
						<table>
						<tr>
							<td>
								<a href="../archivos_varios/manual_usuario.pdf" target="_blank"><img border="0" src="../images/files/pdf.gif"></a>
							</td>
							<td align="right" class="style30">
								<a href="../archivos_varios/manual_usuario.pdf" target="_blank"><b style="font-family: verdana; font-size: 10px; color:#006699"><?= $Mensajes["st-1"]?></b></a>
							</td>
						</tr>
						</table>
						<!-- CIERRA TABLA 4 -->
					</td>
				</tr>
				<tr>
					<td bgcolor="#E4E4E4" align="left">
						<blockquote class="style30">
							<?
							$sugerencias = $servicesFacade->getAllObjects("sugerencias",array(),"Titulo,Comentario");
							foreach($sugerencias as $sugerencia){?>
								<p align="left" style="margin-top:0; margin-bottom:0; font-family: verdana; font-size: 10px;">
									<img border="0" src="../images/square-lb.gif" width="8" height="8" />
									<font color="#006699"> <?= $sugerencia["Titulo"];?></font>
									<?= $sugerencia["Comentario"]; ?> 
								</p>
							<?}?>
                		</blockquote>
					</td>
				</tr>
			</table>
			<!-- CIERRA TABLA 3 -->
		</td>
		<td width="150" valign="top" bgcolor="#E4E4E4" class="style11">

<!-- <script type="text/javascript" src="../js/desmd5.js"></script> -->
<!-- FORMULARIO DE LOGIN DE USUARIOS -->
<form name='form1' method="POST" action="../sitio_usuario/login_usuario_submit.php">
	<input type="hidden" name="comunidad_login" value="1">
	
<table width="129" border="0" class="login-form" align="center" cellspacing="1" cellpadding="0">
	<tr>
    	<td class="login-form-top" colspan="2">
        	<? echo $Mensajes['st-2']; ?>
        </td>
	</tr>
	<tr>
    	<th><?= $Mensajes['st-3'] ?></th>
        <td><input name="Login" id='Login' type="text" size="19"></td>
	</tr>
    <tr>
    	<th><?= $Mensajes['st-4'] ?></th>
    	<td><input name="Password" id='Password' type="password" size="19"></td>
	</tr>
    <tr>
    	<th>&nbsp;</th>
    	<td nowrap>
			<input name="B1" type="submit" value="<?= $Mensajes['bot-1'] ?>" />
            <input type="reset" value="<?= $Mensajes['bot-2'] ?>" />
		</td>
	</tr>
	
    <tr>
    	<td colspan="2" class="login-form-base">
    		<a href="olvide_contrasenia.php"><?= $Mensajes['st-5']; ?></a>
		</td>
	</tr>
	<tr>
    	<td colspan="2" class="login-form-base" >
    		<a href="../candidatos/agregar_candidato.php"><?= $Mensajes['st-6'] ?></a>
		</td>
	</tr>
</table>
</form>

<!-- FIN FORMULARIO DE LOGIN DE USUARIOS -->

		</td>
	</tr>
</table>


<? require_once "../layouts/base_layout_admin.php" ?>