<?
$pageName="mensajes";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);  


if (!isset($enviado)){?>
	<script language="JavaScript" type="text/javascript">
		function validar_mensaje(){
			if (document.getElementsByName("texto").item(0).value == ""){
				alert("<?=$Mensajes['error.campo_texto_incompleto'];?>");
				return false;
			}
			return true;
		}
  	</script>
  
	<form onsubmit="return validar_mensaje();">
		<input type='hidden' name='id_usuario' value="<?=$id_usuario;?>">
		<input type='hidden' name='enviado' value='1'>
		
	<table class="table-form" cellspacing="1" cellpadding="2" align="center" width="60%">		
		<tr>
	    	<td colspan="2" class="table-form-top-blue">&nbsp;</td>
	    </tr>
		<tr>
			<th><?=$Mensajes['et-001'];?></th>
			<td><?=$datos_usuario?></td>
		</tr>
	    <tr>
	        <th><?=$Mensajes["campo.mensaje"];?></th>
	    	<td><textarea name='texto' rows='7' cols='45'></textarea></td>
	    </tr> 
		<tr>
			<th>&nbsp;</th>
			<td>
				<input type='submit' value="<?=$Mensajes['bot-1'];?>">
			</td>
		</tr>
	</table>
	</form>
	
<?}else{
	$usuarioSesion = SessionHandler::getUsuario();
	$mensajes_usuarios=array();
	$mensajes_usuarios['idUsuario']=$id_usuario;
	$mensajes_usuarios['idUsuarioFrom']=$usuarioSesion["Id"];
	$mensajes_usuarios['fecha_creado']=date("Y-m-d H:i:s");
	$mensajes_usuarios['texto']=$texto;
	$res = $servicesFacade->agregarMensaje_Usuario($mensajes_usuarios);
	?>
    <center class="style29">
	    <?=$Mensajes['et-002'] ?>
	    <br/>        
		<input type="button" onclick="location.href='seleccionar_usuario.php?popup=0&url_destino=usuarios2/nuevo_mensaje.php';" value="<?=$Mensajes['h-002']?>" />
	</center> 
<?}

require "../layouts/base_layout_admin.php";?>  