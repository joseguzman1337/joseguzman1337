<?php
/**
 * 
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title><?=TOP_LAYOUT_TITULO ?></title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link rel="stylesheet" type="text/css" href="../css/celsiusStyles.css">
	<link rel="stylesheet" type="text/css" href="instaladorStyles.css">
	
  
</head>
<body>

<table width="640" height="80%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="130">
			<img src="../images/instalador/head-celsius.jpg" width="640" height="130">
		</td>
	</tr>
	<? if (!empty($paso_numero)){?>
		<tr>
			<td align="left" bgcolor="#FFFFFF" >
				<blockquote>
					<p style="font-weight: bold; color: #006699; font-family: Tahoma;font-size: 9px;">Instalaci&oacute;n | Fase <?=$paso_numero?> de 8</p>
				</blockquote>
			</td>
		</tr>
	<? } ?>
	<tr>
		<td align="center" valign="middle" bgcolor="#FFFFFF" width="640" style="padding-left:20px;padding-right:20px">
			<?
			
			//muestra los mensajes de error si corresponde
			if (!empty($_REQUEST["errorMessage"]))
				$errorMessages = $_REQUEST["errorMessage"];
			if (!empty($errorMessages)){?>
				<div class="usermsg">
					<div class="error-icon">
						</p>
				<? foreach ((array)$errorMessages as $errorMessage){?>
					<p class="error"><?=$errorMessage?></p>
				<?}?>
					</div>
				</div>
			<? } 
			//muestra los mensajes de success si corresponde
			if (!empty($_REQUEST["successMessage"]))
				$successMessages = $_REQUEST["successMessage"];
			if (!empty($successMessages)){?>
				<div class="usermsg">
					<div class="success-icon">
						<? foreach ((array)$successMessages as $successMessage){?>
							<p class="success"><?=$successMessage?></p>
						<?}?>
					</div>
				</div>
			<? }?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle" bgcolor="#FFFFFF" width="640" style="padding-left:20px;padding-right:20px">
		