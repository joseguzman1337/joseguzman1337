<?
$pageName="sincronizacion";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);
require "../layouts/top_layout_admin.php";
?>

<table class="table-form" width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8">
			Cola de envios
		</td>
	</tr>
	<tr>
		<td align="center" id="im1">
			<embed  src='../images/simple_countdown.swf' menu='false' quality='high' background='../images/banda.jpg' type='application/x-shockwave-flash'></embed>
		</td>
	</tr>
	<tr>
		<td  align="center" id="im2">
			<b><?=$Mensajes["mensaje.vaciandoCola"];?></b>
		</td>
	</tr>
</table>

<?require "../layouts/base_layout_admin.php";
$eventos_enviados = $servicesFacade->vaciarColaEventosNT();
flush();
?>
<script language="JavaScript" type="text/javascript">
  	document.getElementById("im1").style.visibility="hidden";
  	document.getElementById("im2").style.visibility="hidden";
	<? if (is_a($eventos_enviados, "Celsius_Exception")){?>
		alert('<?=$Mensajes["error.sincronizando"];?>');
		alert("<?=$eventos_enviados->getSafeMessage()?>");
	<?}else {?>
  		alert('<?=$eventos_enviados." ".$Mensajes["mensaje.eventosEnviados"]?>');
  <?}?>
  history.back();
</script>