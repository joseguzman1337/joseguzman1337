<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
//ini_set('memory_limit', '64M');
//ini_set('max_execution_time','90');
//echo "<h1>ABRASE</h1>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<script language="Javascript">
function recargar()
{
	window.location.reload("detalleadmision_listado.php");
}
</script>
</head>
<body>
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
$formulario->agregar_tablas('detallesitioadmision','iddetallesitioadmision');
if($_REQUEST['depurar']=="si")
{
	$depurar=new SADebug();
	$depurar->trace($formulario,'','');
	$formulario->depurar();
	$debug=true;
}
if($_GET['idadmision']<>"")
{
	$formulario->cargar('iddetallesitioadmision',$_GET['iddetallesitioadmision']);
	$formulario->cambiar_estado('detallesitioadmision','codigoestado',200,"<script language='javascript'>window.close();</script><script language='javascript'>window.opener.recargar();</script>");
}
$query_detalle_admision="SELECT da.iddetalleadmision,tda.nombretipodetalleadmision FROM
detalleadmision da, tipodetalleadmision tda
WHERE
da.idadmision='".$_GET['idadmision']."'
AND da.codigoestado='100'
AND da.codigotipodetalleadmision=tda.codigotipodetalleadmision
";

$operacion_detalle_admision=$sala->query($query_detalle_admision);
$row_detalle_admision=$operacion_detalle_admision->fetchRow();
do{
	if(!empty($row_detalle_admision)){
		$array_detalleadmision[]=$row_detalle_admision;
	}
}
while ($row_detalle_admision=$operacion_detalle_admision->fetchRow());

$query_detalle_rotacion="SELECT LugarRotacionCarreraID,lugarRotacionBase FROM LugarRotacionCarrera
							WHERE codigocarrera='".$_SESSION['admisiones_codigocarrera']."' AND codigoestado='100'";

$operacion_detalle_admision=$sala->query($query_detalle_rotacion);
$row_detalle_rotacion=$operacion_detalle_admision->fetchRow();
do{
	if(!empty($row_detalle_rotacion)){
		$array_rotacion[]=$row_detalle_rotacion;
	}
}
while ($row_detalle_rotacion=$operacion_detalle_admision->fetchRow());
/*echo '<pre>';
print_r($array_detalleadmision);
echo '</pre>';*/
?>
<caption align="left"><p>Edición de pruebas</p></caption>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="640">
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigosalon','Salón','requerido');?></td>
		<td><?php $formulario->combo('codigosalon','detallesitioadmision','post','salon','codigosalon','codigosalon','','codigosalon');?></td>
	</tr>	
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('prioridaddetallesitioadmision','Orden de asignación','numero');?></td>
		<td><?php $formulario->campotexto('prioridaddetallesitioadmision','detallesitioadmision',5);?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('LugarRotacionCarreraID','Rotación','');?></td>
		<td><?php $formulario->combo_array('lugarrotacioncarreraid','detallesitioadmision','post',$array_rotacion,'LugarRotacionCarreraID','lugarRotacionBase','','');?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('iddetalleadmision','Prueba(detalleadmision)','requerido');?></td>
		<td><?php $formulario->combo_array('iddetalleadmision','detallesitioadmision','post',$array_detalleadmision,'iddetalleadmision','nombretipodetalleadmision','','requerido');?></td>
	</tr>		
</table>
	
<input type="submit" name="Enviar" value="Enviar">
<!--<input type="button" name="Regresar" value="Regresar" onClick="regresarGET()">-->
<?php
if($_GET['iddetallesitioadmision']<>"") //si hay detallesitioadmision, deberá cargar y mostrar boton verificacion
{
	echo '<input type="button" name="Anular" value="Anular" onclick="Verificacion()">';
}
?>
</form>
<?php
//Lógica del formulario
if(isset($_REQUEST['Enviar']))
{
	if($formulario->array_datos_formulario[2]["valor"]==""){
		$formulario->array_datos_formulario[2]["valor"]=null;
	}
	$formulario->submitir();
	$formulario->valida_formulario();
	$formulario->agregar_datos_formulario('detallesitioadmision','codigoestado',100);
	$formulario->agregar_datos_formulario('detallesitioadmision','idadmision',$_GET['idadmision']);
	$formulario->insertar("<script language='javascript'>window.close();</script><script language='javascript'>window.opener.recargar();</script>","<script language='javascript'>window.close();</script><script language='javascript'>window.opener.recargar();</script>");
}
?>
    </body>
</html>
