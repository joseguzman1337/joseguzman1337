<?
$pageName="header";
require_once "../common/includes.php";
$usuario = SessionHandler::getUsuario();

if (isset ($IdiomaSeteado)) {
	SessionHandler::guardarIdioma($IdiomaSeteado);
}
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title><? echo Configuracion::getTituloSitio(); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="../css/celsiusStyles.css">
<style type="text/css">
<!--
	body {
		background-color: #336699;
	}
	.menu {
		font-family: Tahoma;
		font-size: 10px;
		font-style: normal;
		color: #666666;
		font-weight:bold;
		text-align: center;
		vertical-align: middle;
	}
	.menulogin {
		font-family: Tahoma;
		font-size: 9px;
		font-style: normal;
		color: #666666;
		text-align: right;
		vertical-align: top;
		margin-top: 5px;
	}
	.menudesp {
		font-family: Tahoma;
		font-size: 9px;
		color: #666666;
		margin-top: 5px;
		text-align: left;
	}
-->
</style>

</head>

<body leftmargin="1" topmargin="0" marginwidth="0" marginheight="0">

<table width="780" style="height:100px" border="0" cellpadding="0" cellspacing="0" bgcolor="#E4E4E4">
<tr>
   	<td  width="155">
   		<table border="0" cellspacing="0" cellpadding="0">
       		<tr><td><p><img src="../images/head/head-celsius_01.gif" width="155" height="82" alt=""></p></td></tr>
       		<tr><td><img src="../images/head/head-celsius_11.gif" width="155" height="18"></td></tr>
       	</table>
	</td>
    <td>
    	<table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
        	<td height="65" class="menulogin">
        		<form name='form1' method="get" action="head.php">
        			<? if (empty($usuario)){?>
        				<a target="bottom" href="../sitio_usuario/login_usuario.php"><? echo $Mensajes['st-006'];?></a> |
        			<?}else{?>
        				<a target="bottom" href="../sitio_usuario/login_usuario_submit.php?logout=true" onclick="setTimeout('location.reload()',300);"><? echo $Mensajes["link.salir"];?></a>
        			<?}?>
        			
					<input type='hidden' name='cambiaIdioma' value="1" />
	            	<select name="IdiomaSeteado" class="menudesp" onchange="this.form.submit();">
						<?
						$idiomas = $servicesFacade->getIdiomasDisponibles();
						foreach($idiomas as $idioma){?>
							<option value="<?= $idioma["Id"];?>" <? if ($idioma["Id"]==$IdiomaSitio)  echo " selected"; ?>>
								<? echo $idioma["Nombre"]; ?>
							</option>
						<? } ?>
					</select>
            	</form>
            </td>
		</tr>
		<tr>
			<td background="../images/head/head-celsius_12.gif">
				<table border="0" cellspacing="0" cellpadding="0" align="right" >
				<tr>
	                <td width="107" height="35" background="../images/head/head-celsius_04.gif" class="menu">
	                	<a href="cuerpo.php" target="bottom"><? echo $Mensajes['st-001']; ?></a>
	                </td>
	                <?
	                $rol_usuario = SessionHandler::getRolUsuario();
	                if ($rol_usuario == ROL__ADMINISTADOR){?>
		                <td width="103" background="../images/head/head-celsius_05.gif" class="menu">
		                	<a href="../sitio_usuario/sitio_administrador.php" target="bottom">
		                		<? echo $Mensajes["link.administracion"];?>
		                	</a>
		                </td>
	                <?}
	                if ($usuario["Bibliotecario"] > 0){?>
		                <td width="101" background="../images/head/head-celsius_06.gif" class="menu">
		                	<a href="../sitio_usuario/sitio_bibliotecario.php" target="bottom">
		                		<? echo $Mensajes["link.sitio_usuario"];?>
		                	</a>
		                </td>
		            <?}elseif ($rol_usuario >= ROL__USUARIO){?>
		                <td width="101" background="../images/head/head-celsius_06.gif" class="menu">
		                	<a href="../sitio_usuario/sitio_usuario.php" target="bottom">
		                		<? echo $Mensajes["link.sitio_usuario"];?>
		                	</a>
		                </td>
		            <?}?>
	                <td width="101" background="../images/head/head-celsius_07.gif" class="menu">
	                	<a href="../main/descripcion_servicio.php"  target="bottom"> <? echo $Mensajes['st-002']; ?></a>
	                </td>
	                <td width="101" background="../images/head/head-celsius_08.gif" class="menu">
	                	<a href="../estadisticas/main-estadisticas.php" target="bottom"><? echo $Mensajes['st-005']; ?></a>
					</td>
	                <td width="101" background="../images/head/head-celsius_09.gif" class="menu">
	                	<a href="../main/enlaces.php"  target="bottom"><? echo $Mensajes['st-003']; ?></a>
	                </td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</td>
	<td>
		<table border="0" cellspacing="0" cellpadding="0">
			<tr><td height="65">&nbsp;</td></tr>
        	<tr><td><img src="../images/head/head-celsius_10.gif" width="11" height="35" alt=""></td></tr>
		</table>
	</td>
</tr>
</table>

<? if (!empty($cambiaIdioma)) {?>
	<script language="JavaScript">
		var aux = parent.frames.bottom.location.href;
		parent.frames.bottom.location.href = aux;
	</script>
 <? } ?> 

</body>
</html>