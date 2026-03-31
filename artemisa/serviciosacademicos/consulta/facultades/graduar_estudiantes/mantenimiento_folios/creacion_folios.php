<?php
session_start();
print_r($_POST);
?>
<link rel="stylesheet" type="text/css" href="funciones/sala.css">
<script type="text/javascript" src="funciones/funciones_javascript.js"></script>
<script type="text/javascript" src="../../../../funciones/gui/globo.js"></script>
<?php
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/clases/motor/motor.php");
require_once("../../../../funciones/clases/tablas/tablas.php");
require_once("funciones/obtener_datos.php");
$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados\n';
$validaciongeneral=true;
$formulario=new formulario("form1",'post',"",true,$mensajegeneral);
?>

<form name="form" method="post" action="">
  <table width="200" border="1" cellpadding="2" cellspacing="1">
    <tr>
      <td>N&uacute;mero de folio </td>
      <td><?php $formulario->campotexto('idregistrograduadofolio',10,'numero','Numero de folio',"No puede digitar un número de folio existente; en ese caso, debe entrar al menú editar folio existente");?>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input name="Enviar" type="submit" id="Enviar" value="Enviar">
      </div></td>
    </tr>
  </table>
<?php
if(isset($_POST['Enviar']))
{
	$validaformulario=$formulario->valida_formulario();
	if($validaformulario==true)
	{
		$registrograduadofolio->Load("idregistrograduadofolio='".$_POST['idregistrograduadofolio']."'");
		if($registrograduadofolio->idregistrograduadofolio!=0)
		{
			$validaciongeneral=false;
			echo "<script language=javascript>alert('Ya existe ese número de folio')</script>";
		}
		if($validaciongeneral==true)
		{
			$folio=new folio($sala);
			$tabla=new tablas();
			$array_datos=$folio->obtener_registrograduado();
			$tabla->tabla_chulitos($array_datos,'idregistrograduado','post',"","");
		}
	}
}
?>
</form>