<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
require_once('../../../../funciones/clases/autenticacion/redirect.php' );
//ini_set('memory_limit', '64M');
//ini_set('max_execution_time','90');
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>
<script language="javascript">
function enviar()
{
	document.form1.submit()
}
</script>
<script LANGUAGE="JavaScript">
function quitarFrame()
{
	if (self.parent.frames.length != 0)
	self.parent.location=document.location.href="../../../../aspirantes/aspirantes.php";

}
function regresarGET()
{
	document.location.href="<?php echo $_GET['link_origen']?>";
}
function Verificacion()
{
	if(confirm('Seleccionó anular el registro. ¿Desea continuar?'))
	{
		document.form1.AnularOK.value="OK";
		document.form1.submit();
	}
}
</script>

<?php
$rutaado=("../../../../funciones/adodb/");
require_once('../../../../Connections/salaado-pear.php');
require_once('../../../../funciones/clases/formulario/clase_formulario.php');
require_once('../../../../funciones/clases/debug/SADebug.php');
$fechahoy=date("Y-m-d H:i:s");
?>
<form name="form1" action="" method="POST">
<input type="hidden" name="AnularOK" value="">
<?php
$formulario = new formulario($sala,'form1','post','',true);
//definicion de tablas con las que el formulario trabajará
$formulario->agregar_tablas('salon','codigosalon');
if($_REQUEST['depurar']=="si")
{
	$sala->debug=true;
	$depurar=new SADebug();
	$depurar->trace($formulario,'','');
	$formulario->depurar();
	$debug=true;
}
if ($_GET['codigosalon']<>"") 
{
	$_SESSION['codigosalon']=$_GET['codigosalon'];
}
$codigosalon=$_SESSION['codigosalon'];
if($_SESSION['codigosalon']<>"")
{
	$formulario->cargar("'codigosalon'",$_SESSION['codigosalon']);
	//$formulario->cambiar_estado('admision_copia','codigoestado',200,"<script language='javascript'>window.location.reload('".$_GET['link_origen']."')</script>");
}
?>
<caption align="left"><p>Edición de Admisiones</p></caption>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigosalon','Código del salón','requerido');?></td>
		<td><?php $formulario->campotexto('codigosalon','salon',10);?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('nombresalon','Nombre del salón','requerido');?></td>
		<td><?php $formulario->campotexto('nombresalon','salon',20);?></td>
	</tr>	
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('cupomaximosalon','Capacidad salón','numero');?></td>
		<td><?php $formulario->campotexto('cupomaximosalon','salon',5);?></td>
	</tr>	
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigotiposalon','Tipo de salón','requerido');?></td>
		<td><?php $formulario->combo('codigotiposalon','salon','post','tiposalon','codigotiposalon','nombretiposalon','','nombretiposalon');?></td>
	</tr>	
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigosede','Sede','requerido');?></td>
		<td><?php $formulario->combo('codigosede','salon','post','sede','codigosede','nombresede','','nombresede');?></td>
	</tr>	
	</table>
<input type="submit" name="Enviar" value="Enviar">
<input type="button" name="Regresar" value="Regresar" onClick="regresarGET()">
</form>

<?php
//Lógica del formulario
if(isset($_REQUEST['Enviar']))
{
	$formulario->submitir();
	$formulario->valida_formulario();
	$formulario->insertar("<script language='javascript'>window.location.reload('".$_GET['link_origen']."')</script>","<script language='javascript'>window.location.reload('".$_GET['link_origen']."')</script>");
}
?>