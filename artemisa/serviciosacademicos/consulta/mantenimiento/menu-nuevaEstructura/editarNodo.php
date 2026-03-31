<?php
header('Content-Type: text/html; charset=UTF-8');
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulariov2/clase_formulario.php");
require_once('../../../funciones/clases/autenticacion/redirect.php');
$formulario = new formulario(&$sala,"form1",'post','',false,'editarNodo.php');
$formulario->agregar_tablas('menuopcion','idmenuopcion');
$formulario->cargar('idmenuopcion',$_GET['idmenuopcion']);
?>
<form name="formularioEdicion" method="POST" action="#">
<input type="hidden" name="codigoestadomenuopcion" value="01">
<input type="hidden" name="idmenuopcion" value="<?php echo $_GET['idmenuopcion']?>">
<input type="hidden" name="nivelmenuopcion" value="1">
<input type="hidden" name="posicionmenuopcion" value="1">
<input type="hidden" name="codigogerarquiarol" value="01">
<input type="hidden" name="idpadremenuopcion" value="null">
<input type="hidden" name="framedestinomenuopcion" value="contenidocentral">
<p>Menú <?php echo $_GET['idmenuopcion']?></p>
<table border="1" cellpadding="1" cellspacing="1">
<?php $formulario->celdaHorizontalCampoTextoDHTML('nombremenuopcion','Nombre menú','menuopcion',40,'','','','','required','','','','',1)?>
<?php $formulario->celdaHorizontalCampoTextoDHTML('linkmenuopcion','Link menú','menuopcion',40,'','','','','','','','','',1)?>
<?php $formulario->celdaHorizontalCampoTextoDHTML('transaccionmenuopcion','Código transacción','menuopcion',40,'','','','','required','','','','',1)?>
<tr>
<td colspan="3">
	<input type="button" id="Enviar" class="formButton" value="Enviar" onclick="formEdicion.submit();">
	<input type="reset" class="formButton" value="Borrar">
</td>
</tr>
</table>
</form>