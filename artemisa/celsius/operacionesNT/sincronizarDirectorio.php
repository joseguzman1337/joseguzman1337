<?
$pageName="sincronizacion";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);

require_once ('../soap-directorio/ProxyDirectorio.php');


global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

require "../layouts/top_layout_admin.php";
?>

<table class="table-form" width="100%">
	<tr>
		<td colspan="0" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8">
			<?=$Mensajes["titulo.sincronizacion"];?>
		</td>
	</tr>
</table>
<table width="90%"  border="0" align="center" cellpadding="1" cellspacing="1" class="table-form">
	<tr>
		<td width="100%" align="center" name="im1" id="im1">
			<embed  src='../images/simple_countdown.swf' menu='false' quality='high' background='../images/banda.jpg' type='application/x-shockwave-flash'></embed>
		</td>
	</tr>
	<tr>
		<td width="100%" align="center" name="im2" id="im2">
			<b><?=$Mensajes["mensaje.sincronizando"];?></b>
			<br/>
	  		<img src='../images/diskette.gif'></b>
		</td>
	</tr>
</table>

<?require "../layouts/base_layout_admin.php";

$proxy = ProxyDirectorio::getInstance($servicesFacade);
if (is_a($proxy,"Celsius_Exception"))
	$resul=$proxy;
else
	$resul = $proxy->updateDirectory();	

flush();
?>
<script language="JavaScript" type="text/javascript">
  	document.getElementById("im1").style.visibility="hidden";
  	document.getElementById("im2").style.visibility="hidden";
	<?if (is_a($resul, "WS_Exception")){?>
			alert('<?=$Mensajes["error.sincronizando"];?>');
			alert("<?=$resul->getSafeMessage()?>");
	<?}else {?>
		alert('<?=$Mensajes["mensaje.sincronizacionExitosa"];?>');
	<?}?>
  	history.back();
  </script>