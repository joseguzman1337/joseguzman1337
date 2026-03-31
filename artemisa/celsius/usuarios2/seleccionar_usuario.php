<?
/**
 * @param bool popup indica si la pag de seleccion de usuarios se vera en un popup o en una pag normal. 
 * En el 1º caso se esperan los parametros $input_id_usuario y $input_datos_usuario. EN el 2º se espera 
 * el parametro $url_destino. Por default , popup = true
 * @param string $url_destino?
 * @param string $input_id_usuario?
 * @param string $input_datos_usuario?
 */
$pageName= "usuarios1";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);
if (isset($popup) && $popup == 0)
	$popup = 0;
else
	$popup = 1;

if ($popup)
	require_once "../layouts/top_layout_popup.php";
else
	require_once "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);  
?>

<script language="JavaScript">
	
	function recargo(Letra){   
		document.getElementsByName("datos_usuario").item(0).value=Letra;
		document.getElementById("formBusquedaUsuarios").submit();
	}
	
	function retornaCon(datos_usuario,id_usuario){
		
		<? if ($popup) {?>
			//var input_id_usuario = document.getElementsByName(input_id_usuario).item(0).value;
			window.opener.document.getElementsByName("<?= $input_id_usuario?>")[0].value= id_usuario;
			
			//var input_datos_usuario = document.getElementsByName(datos_usuarios).item(0).value;
			window.opener.document.getElementsByName("<?= $input_datos_usuario ?>")[0].value= datos_usuario;
			
			self.close();
		<? } else{?>
			
			location.href="../<?=$url_destino?><?=(strpos($url_destino,"?") === FALSE)?"?":"&" ?>datos_usuario=" + datos_usuario + "&id_usuario=" + id_usuario; 
		<? } ?>
		     
	}
	
</script>    
<br/>

<form method="post" id="formBusquedaUsuarios" action="seleccionar_usuario.php">
	<? if ($popup) {?>
		<input type="hidden" name="input_id_usuario" value="<?= $input_id_usuario ?>"/>
		<input type="hidden" name="input_datos_usuario" value="<?= $input_datos_usuario ?>"/>
	<? } else{?>
		 <input type="hidden" name="url_destino" value="<?= $url_destino ?>"/>
	<? } ?>
	<input type="hidden" name="popup" value="<?= $popup ?>"/>

<table width="95%" border="0" align="center" cellpadding="1" cellspacing="0" class="table-form">
<tr>
	<td class="table-form-top-blue" colspan="2"><?= $Mensajes["mensaje.listadoUsuarios"]; ?></td>
</tr>
<tr>
	<td>
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" class="table-form">
		<tr>
			<td class="texto-color-celeste"><? echo $Mensajes["tf-2"]; ?></td>
			<td><input type="text" name="datos_usuario" size="20"/></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			   	<input type="submit" value="<? echo $Mensajes["bot-2"]; ?>" name="Enviar"/>
			</td>
		</tr>
		</table>
	</td>
	
	<td align="left">
		<table width="260" border="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111">
           	<tr>
	           	<? for($c = 'A'; $c <= 'M'; $c = chr(ord($c)+1)){?>
	           		<td class="texto-color-celeste" width="20" align="center"><a href="javascript:recargo('<?=$c?>')"><?=$c?></a></td>
	           	<? } ?>
           	</tr>
           	<tr>
	           	<? for($c = 'N'; $c <= 'Z'; $c = chr(ord($c)+1)){?>
	           		<td class="texto-color-celeste" width="20" align="center"><a href="javascript:recargo('<?=$c?>')"><?=$c?></a></td>
	           	<? } ?>
           	</tr>
		</table>
	</td>
</tr>  		
</table>

</form>
<br/>
<?  
if (empty($datos_usuario))
	$datos_usuario ="A";

$conditions=array();
if (strpos($datos_usuario, ",") === FALSE){
	$conditions['Apellido'] = trim($datos_usuario);
}else{
	$u = split(",",$datos_usuario);
	$conditions['Apellido'] = trim($u[0]);
	$conditions['Nombres']=trim($u[1]);
}
if (SessionHandler::getRolUsuario() == ROL__BIBLIOTECARIO){
	$usuario = SessionHandler::getUsuario();
	switch ($usuario["Bibliotecario"]) {
		case TIPO__BIBLIOTECARIO_INSTITUCION:
			$conditions["Codigo_Institucion"] = $usuario["Codigo_Institucion"];
			break;
		case TIPO__BIBLIOTECARIO_DEPENDENCIA:
			$conditions["Codigo_Dependencia"] = $usuario["Codigo_Dependencia"];
			break;
		case TIPO__BIBLIOTECARIO_UNIDAD:
			$conditions["Codigo_Unidad"] = $usuario["Codigo_Unidad"];
			break;	
	}
} 

$usuarios = $servicesFacade->getAllUsuarios($conditions);

?>
<table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" class="table-list">
	<tr>
		<td colspan="3" class="table-list-top">
			<img src="../images/square-lb.gif" width="8" height="8">
			<? echo $Mensajes["tf-1"]; ?><b><?= $datos_usuario; ?></b>
		</td>
	</tr>
	<?
	foreach ($usuarios as $usuarioI){
		if ($usuarioI['Personal']==1)
			$color = "#DFE9EC";
		elseif ($usuarioI['Bibliotecario']>=1)
			$color = "#C4D5DB";
		else
			$color = "inherit";
		?>
		<tr style="background-color:<?=$color?>;">
			<td width="30%">
				<strong>    
			<? if (($usuarioI['habilitado_crear_pedidos']==1)||(empty($generarPedido))){?>
				<a href="javascript: retornaCon('<?= $usuarioI['Apellido']. ', '. $usuarioI['Nombres'];?>','<?= $usuarioI['Id'] ?>');">
							<?=$usuarioI['Apellido'].", ".$usuarioI['Nombres']; ?>
				</a>
			<? } ?>	
			
			</strong>
			</td>
			<td><?= $usuarioI['Nombre_Institucion']." - ".$usuarioI['Nombre_Dependencia']." - ".$usuarioI['Nombre_Unidad']; ?></td>
			<td>
				<a href="mostrar_usuario.php?id_usuario=<?= $usuarioI['Id'] ?>">
						<img border="0" src="../images/action_forward.gif">
				</a>
			</td>
		</tr>
	<? } ?>
</table>

<br/>

<center>
	<input type="button" value="<?= $Mensajes["boton.cancelar"];?>" onclick="javascript:<?= ($popup)?"self.close()":"history.back()"?>;" />
</center>

<? 
if ($popup)
	require_once "../layouts/base_layout_popup.php";
else
	require_once "../layouts/base_layout_admin.php";
?>
