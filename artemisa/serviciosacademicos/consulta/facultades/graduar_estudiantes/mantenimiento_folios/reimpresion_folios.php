<link rel="stylesheet" type="text/css" href="../estilos/sala.css">
<script type="text/javascript" src="../../../../funciones/clases/formulario/globo.js"></script>
<?php
setlocale(LC_ALL,'es_ES');
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/fpdf/fpdf.php");
define('FPDF_FONTPATH','../../../../funciones/clases/fpdf/font/');
require_once("funciones/foliacion_automatica.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados\n';
$validaciongeneral=true;
$formulario = new formulario(&$sala,"form1","post","",true,"");
?>
<form name="form1" method="post" action="">
  <p>Reimpresi&oacute;n de folios</p>
  <table width="200" border="1">
    <tr>
      <td colspan="4"><div align="center">Rango de folios</div></td>
    </tr>
    <tr>
      <td>Desde:</td>
      <td><div align="center"><?php $formulario->campotexto('foliodesde',10,'numero','folio desde','El folio inicial incluído el número digitado');?></div></td>
      <td>Hasta:</td>
      <td><div align="center"><?php $formulario->campotexto('foliohasta',10,'numero','folio desde','El folio final incluído el número digitado');?></div></td>
    </tr>
    <tr>
      <td colspan="4"><div align="center">
        <input name="Enviar" type="submit" id="Enviar" value="Enviar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="Regresar" type="submit" id="Regresar" value="Regresar">
</div></td>
    </tr>
  </table>
</form>
<?php
if(isset($_POST['Enviar']))
{
	$validaformulario=$formulario->valida_formulario();
	if($validaformulario==true)
	{
		echo "<script language='javascript'>window.open('mostrar_folios.php?link_origen=menu.php&accion=reimpresion&foliodesde=".$_POST['foliodesde']."&foliohasta=".$_POST['foliohasta']."')</script>";
	}	
}
?>
<?php if(isset($_POST['Regresar'])){ ?>
<script language="javascript">window.location.reload('menu.php')</script>
<?php }?>