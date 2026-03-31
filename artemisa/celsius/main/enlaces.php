<?
$pageName="enlaces";
require_once "../layouts/top_layout_admin.php";
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

$pidu = $servicesFacade->getPID_LibLink();
	
?>

<blockquote style="text-align:left">
	<span class="style49" ><img src="../images/square-lb.gif" width="8" height="8"> <?=$Mensajes['et-2'];?></span>
</blockquote>

<hr width="740" size="2">

<table width="740" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
<?
if (count($pidu)>0){
    $lastPais= "123456789";
    $lastInstitucion= "123456789";
    
	foreach ($pidu as $regI){
		if ($regI["Nombre_Pais"]!=$lastPais){?>
			<tr>
				<td class="style49"><b><?=$Mensajes["campo.pais"];?>: <?=$regI["Nombre_Pais"];?></b></td>
			</tr>
			
		<?
		$lastPais= $regI["Nombre_Pais"];
		}
		
		if ($regI["Nombre_Institucion"]!=$lastInstitucion){?>
			<tr>
				<td class="style49" style="padding-left:10px"><?=$Mensajes["campo.institucion"];?>: <?=$regI["Nombre_Institucion"];?>
				<?if (!empty($regI["Sitio_Web_Institucion"])){?>
						 -
						<?=$Mensajes["campo.url"];?>: <a target="_blank" href="<?=$regI["Sitio_Web_Institucion"];?>"><?=$regI["Sitio_Web_Institucion"];?></a>
				<?}?> 
				</td>
			</tr>
		<?
		$lastInstitucion= $regI["Nombre_Institucion"];
		}
		
		if (!empty($regI["Nombre_Dependencia"])) {?>
			<tr>
				<td bgcolor="#ECECEC" class="style49" style="padding-left:20px"><div align="left" class="style43"><?=$Mensajes["campo.dependencia"];?>: <?=$regI["Nombre_Dependencia"];?> 
				<? if (!empty($regI["Sitio_Web_Dependencia"])){?>
								 -
						<?=$Mensajes["campo.url"];?>: <a target="_blank" href="<?=$regI["Sitio_Web_Dependencia"];?>"><?=$regI["Sitio_Web_Dependencia"];?></a>
				<?}?>
				</div></td>
			</tr>
				
		<?
		}
	}
}?>
</table>	
<? require_once "../layouts/base_layout_admin.php"; ?>