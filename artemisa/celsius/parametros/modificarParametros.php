<?php
$pageName = "parametros";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);

require_once "../utils/StringUtils.php";

require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (isset ($submit)) {
	$requestError = "";
	
	$directorio_upload = StringUtils::parseAndValidateDirectory($directorio_upload);
	if (is_a($directorio_upload, "Celsius_Exception"))
		$requestError .= $Mensajes["error.campo_directorio_upload_invalido"]." ".($directorio_upload->getMessage())."<br/>";
		
	$directorio_temporal = StringUtils::parseAndValidateDirectory($directorio_temporal);
	if (is_a($directorio_temporal, "Celsius_Exception"))
		$requestError .= $Mensajes["error.campo_directorio_temporal_invalido"]." ".($directorio_temporal->getMessage())."<br/>";
	
	if (empty ($url_completa))
		$requestError .= $Mensajes["error.campo_url_completa_invalido"]."<br/>";
	if (empty ($mail_contacto))
		$requestError .= $Mensajes["error.campo_mail_contacto_invalido"]."<br/>";
	if (empty ($titulo_sitio))
		$requestError .= $Mensajes["error.campo_titulo_sitio_invalido"]."<br/>";
	
	if (Configuracion::isNTHabilitado()){
		if (empty ($password_directorio))
			$requestError .= $Mensajes["error.campo_password_directorio_invalido"]."<br/>";
		if (empty ($url_directorio))
			$requestError .= $Mensajes["error.campo_url_directorio_invalido"]."<br/>";
	}		
		
	$parametros = array (
		"url_completa" => $url_completa,
		"titulo_sitio" => $titulo_sitio,
		"mail_contacto" => $mail_contacto,
		"directorio_upload" => $directorio_upload,
		"directorio_temporal" => $directorio_temporal,
		"texto" => $texto
	);
	
	if (Configuracion::isNTHabilitado()){
		$parametros["password_directorio"]= $password_directorio;
		$parametros["url_directorio"]= $url_directorio;
	}
	
	if (empty ($requestError)) {
		$res = $servicesFacade->modificarParametros($parametros);
		$res1 = PedidosUtils::guardarURLLocalEnWSDLs($url_completa);
		if (is_a($res1, "Celsius_Exception")){
		$errorMessages[]="Se produjo un error al tratar de modificar los archivos wsdl.\n";
		if (is_a($res1, "DB_Exception"))
			$errorMessages[]="Mysql lanzo el siguiente error: <br/>Numero de error: ".$res1->dbError."<br/>Mensaje de error: ".$res1->dbErrorNo;
		
		return;
	}
		if (is_a($res, "Celsius_Exception")){
			$mensaje_error= $Mensajes["error.modificandoParametros"];
			$excepcion = $res;
			require "../common/mostrar_error.php";
		}
		echo $Mensajes["mensaje.actualizacionExitosa"];
	} else {
		//se muestra el error
		?>
		<div align="center" class="mensaje-error">
			<?= $Mensajes["warning.error"] . ": " . $requestError?>
		</div>
	<?}
}
$parametros = $servicesFacade->getParametros();
?>

<script type="text/javascript">
	function validar(){
 		<?if (Configuracion::isNTHabilitado()){?>
 			if (!document.forms.formParametros.password_directorio.value){
				alert ('<?=$Mensajes["mensaje.faltaCampo"]." ".$Mensajes["campo.passwordDirectorio"];?>');
				return false;
 			}
 			if (!document.forms.formParametros.url_directorio.value){
				alert ('<?=$Mensajes["mensaje.faltaCampo"]." ".$Mensajes["campo.urlDirectorio"];?>');
				return false;
 			}
 		<?}?>
 		if (!document.forms.formParametros.titulo_sitio.value){
			alert ('<?=$Mensajes["mensaje.faltaCampo"]." ".$Mensajes["campo.tituloSitio"];?>');
			return false;
 		}
 		if (!document.forms.formParametros.url_completa.value){
			alert ('<?=$Mensajes["mensaje.faltaCampo"]." ".$Mensajes["campo.url"];?>');
			return false;
 		}
 		if (!document.forms.formParametros.mail_contacto.value){
			alert ('<?=$Mensajes["mensaje.faltaCampo"]." ".$Mensajes["campo.mailContacto"];?>');
			return false;
 		}
 		
 		return true;
	}
</script>

<form name="formParametros" method="POST" onsubmit="return validar();">


<table class="table-form" width="80%" align="center" cellpadding="1" cellspacing="1">
	<caption style="background-color:#006699;text-align:left;padding:4px" class="style18" >
		<img src="../images/square-w.gif" width="8" height="8"/>
		<? echo $Mensajes["titulo.formularioParametros"];?>
	</caption>
	<tr>
		<td colspan="2" style="text-align:center;color:#FF0000">
			<h3><?echo $Mensajes["warning.cartelAtencion"];?></h3>
		</td>
	</tr>
	<tr>
	 	<th><? echo $Mensajes["campo.url"];?></th>
	 	<td><input type="text" name="url_completa" size="40" value="<?echo $parametros["url_completa"]; ?>" /></td>
	</tr>
	<tr>
	 	<th><? echo $Mensajes["campo.tituloSitio"];?></th>
	 	<td><input type="text" name="titulo_sitio" size="40" value="<?echo $parametros["titulo_sitio"]; ?>" /></td>
	</tr>
	<tr>
	 	<th><? echo $Mensajes["campo.mailContacto"];?></th>
	 	<td><input type="text" name="mail_contacto" size="40" value="<?echo $parametros["mail_contacto"]; ?>" /></td>
	</tr>
	<tr>
	 	<th><? echo $Mensajes["campo.directorio_uploads"];?></th>
	 	<td><input type="text" name="directorio_upload" size="40" value="<? echo $parametros["directorio_upload"]; ?>" /></td>
	</tr>
	<tr>
	 	<th><? echo $Mensajes["campo.directorio_temporal"];?></th>
	 	<td><input type="text" name="directorio_temporal" size="40" value="<? echo $parametros["directorio_temporal"]; ?>" /></td>
	</tr>
	<tr>
	 	<th><? echo $Mensajes["campo.texto"];?></th>
	 	<td>
	 		<textarea name="texto" rows="10" cols="37">
	 			<? echo $parametros["texto"]; ?>
	 		</textarea>
	 	</td>
	</tr>
	<?if (Configuracion::isNTHabilitado()){?>
		<tr>
		 	<th>&nbsp;</th>
		 	<td><? echo $Mensajes["mensaje.datosNT"];?></td>
		</tr>
		<tr>
		 	<th><? echo $Mensajes["campo.passwordDirectorio"];?></th>
		 	<td><input type="text" name="password_directorio" size="40" value="<?echo $parametros["password_directorio"]; ?>" /></td>
		</tr>
		<tr>
		 	<th><? echo $Mensajes["campo.urlDirectorio"];?></th>
		 	<td><input type="text" name="url_directorio" size="40" value="<? echo $parametros["url_directorio"]; ?>" /></td>
		</tr>
		
		<tr>
		 	<th><? echo $Mensajes["campo.ultActualizacion"];?></th>
		 	<td><? echo $parametros["ult_actualizacion_directorio"]; ?></td>
		</tr>
	<?}?>
	<tr>
		<th>&nbsp;</th>
		<td colspan="2">
			<input type="submit" name="submit" value="<?echo $Mensajes["boton.modificarParametros"];?>"  />
			<input type="button" name="cancelar" value="<?echo $Mensajes["boton.cancelar"];?>" onClick="location.href = '../sitio_usuario/sitio_administrador.php';" />
		</td>
	</tr>
</table>
</form>

<? require "../layouts/base_layout_admin.php"; ?>