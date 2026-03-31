<?
$pageName= "ayuda_pedidos";
require "../layouts/top_layout_popup.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

$ayuda = $servicesFacade->getCampoPedidos($IdiomaSitio, $id_campo);

if (empty($ayuda)){?>
	<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#E4E4E4">
		<tr align="left" valign="middle" bgcolor="#CCCCCC">
			<td height="20" colspan="2" align="center">
				<?= $Mensajes["tf-1"] ?>
			</td>
		</tr>
	</table>
	
<? }else{ ?>

	<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#E4E4E4">
		<tr align="left" valign="middle" bgcolor="#CCCCCC">
			<td height="20" colspan="2" align="center">
				<img src="../images/square-lb.gif" width="8" height="8">
				<?= $ayuda["texto"] ?>
				<img src="../images/square-lb.gif" width="8" height="8">
			</td>
		</tr>
		<tr align="left" valign="middle">
			<td colspan="2">
				<table width="480"  border="0" align="center" cellpadding="0" cellspacing="0">
				<tr valign="middle">
					<td width="30" align="center">
						<img src="../images/help.gif" width="22" height="22">
					</td>
	        		<td width="450" align="left"><?= $ayuda["mensaje_ayuda"] ?></td>
				</tr>
				</table>
				<hr/>
			</td>
		</tr>
		<tr>
			<td width="470">&nbsp;</td>
			<td width="30" align="center">
				<a href="javascript:window.print();"><img border="0" src="../images/printer.gif" width="32" height="33"></a>
			</td>
		</tr>
	</table>
<?
}
require "../layouts/base_layout_popup.php"; 
?>