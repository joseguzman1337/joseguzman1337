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
			background-color: #006699;
			margin:0px;
			margin-left: 10px;
			
		}
		select.menu-negro{
			color:#0099CC;
			text-align: left;
		} 
		.menu-blanco {
			font-family: Verdana;
			font-size: 11px;
			color:#FFFFFF ;
			text-align: right;
			
		}
		.menu-negro {
			font-family: Arial;
			font-size: 10px;
			color:#FFFFFF;
			text-align: right;
			margin: 0px;
			margin-right: 20px;
		}
		.style1 {
			font-family: Arial;
			font-size: 11px;
			color: #FFFFFF;
		}
		-->
	</style>
</head>

<body>
<table width="780" style="height:100px" border="0" cellpadding="0" cellspacing="0" bgcolor="#0099CC">
<tr>
    <td height="22" colspan="2" style="background: url(../images/head2/head-nt_01.gif)" class="menu-negro">
    	<form name='form1' method="get" action="head.php" style="margin:0px;">
        	<? if (empty($usuario)){?>
        		<a target="bottom" class="menu-blanco" href="../sitio_usuario/login_usuario.php"><? echo $Mensajes['st-006'];?></a> |
        	<?}else{?>
        		<a target="bottom" class="menu-blanco" href="../sitio_usuario/login_usuario_submit.php?logout=true" onclick="setTimeout('location.reload()',300);"><? echo $Mensajes["link.salir"];?></a>
        	<?}?>
        	
			<input type='hidden' name='cambiaIdioma' value="1" />
	       	<select name="IdiomaSeteado" class="menu-negro" onchange="this.form.submit();">
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
<tr style="background: url(../images/head2/head-nt_03.gif)">
    <td><img src="../images/head2/head-nt_02.gif" width="203" height="58" alt="" border="0"></td>
    <td >
    	<div align="right">
    	<a class="menu-negro" href="http://www.unlp.edu.ar" target="_blank"><img src="../images/head2/logo_universidad_67x58.gif" width="59" height="50" border="0"></a>
    		</div>
    </td>
</tr>
<tr>
    <td height="20" colspan="2" bgcolor="#0099CC">
    	<div align="center" class="menu-blanco" style="margin: 0px;margin-right: 20px;">
    				<a href="cuerpo.php" class="menu-blanco" target="bottom"><? echo $Mensajes['st-001']; ?></a>
	                
	                <?
	                $rol_usuario = SessionHandler::getRolUsuario();
	                if ($rol_usuario == ROL__ADMINISTADOR){?>
		                | <a href="../sitio_usuario/sitio_administrador.php" class="menu-blanco" target="bottom">
		                		<? echo $Mensajes["link.administracion"];?>
		                </a>
	                <?}
	                if ($usuario["Bibliotecario"] > 0){?>
		                | <a href="../sitio_usuario/sitio_bibliotecario.php" class="menu-blanco" target="bottom">
		                	<? echo $Mensajes["link.sitio_usuario"];?>
		                </a>
		            <?}elseif ($rol_usuario >= ROL__USUARIO){?>
		                | <a href="../sitio_usuario/sitio_usuario.php" class="menu-blanco" target="bottom">
		                	<? echo $Mensajes["link.sitio_usuario"];?>
		                </a>
		            <?}?>
	                | <a href="../main/descripcion_servicio.php" class="menu-blanco"  target="bottom"> <? echo $Mensajes['st-002']; ?></a>
	                | <a href="../estadisticas/main-estadisticas.php" class="menu-blanco" target="bottom"><? echo $Mensajes['st-005']; ?></a>
					| <a href="../main/enlaces.php" class="menu-blanco"  target="bottom"><? echo $Mensajes['st-003']; ?></a>
    	</div>
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