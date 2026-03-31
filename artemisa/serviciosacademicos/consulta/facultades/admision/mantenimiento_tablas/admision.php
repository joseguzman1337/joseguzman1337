<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
//session_start();
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
function reCarga(pagina){
	document.location.href=pagina;
}
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
	document.location.href="<?php echo 'admision_listado.php' ?>";
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
$formulario->agregar_tablas('admision','idadmision');
if($_REQUEST['depurar']=="si")
{
	$depurar=new SADebug();
	$depurar->trace($formulario,'','');
	$formulario->depurar();
	$debug=true;
}
if ($_GET['idadmision']<>"") 
{
	$_SESSION['idadmision']=$_GET['idadmision'];
}
$idadmision=$_SESSION['idadmision'];
if($_SESSION['idadmision']<>"")
{
	$formulario->cargar('idadmision',$_SESSION['idadmision']);
	$formulario->cambiar_estado('admision','codigoestado',200,"<script language='javascript'>window.location.reload('".$_GET['link_origen']."')</script>");
}
?>
<caption align="left"><p>Edición de Admisiones</p></caption>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigoperiodo','Periodo','requerido');?></td>
		<td><?php $formulario->combo('codigoperiodo','','post','periodo','codigoperiodo','codigoperiodo',"codigoestadoperiodo like '1%' or codigoestadoperiodo like '4%'",'codigoperiodo desc','onChange=enviar()');?></td>
	</tr>	

	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('nombreadmision','Nombre Admisión','requerido');?></td>
		<td><?php $formulario->campotexto('nombreadmision','admision',20);?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigomodalidadacademica','Modalidad académica','');?></td>	
		<td><?php $formulario->combo('codigomodalidadacademica','admision','post','modalidadacademica','codigomodalidadacademica','nombremodalidadacademica','codigoestado=100','nombremodalidadacademica','onChange=enviar()');?></td>
	</tr>
		<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigocarrera','Carrera','requerido');?></td>
		<td><?php 
		if($_POST['codigomodalidadacademica']<>""){
			$formulario->combo('codigocarrera','admision','post','carrera','codigocarrera','nombrecarrera',"'$fechahoy' between fechainiciocarrera and fechavencimientocarrera and codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'",'nombrecarrera');
		}
		else {
			$formulario->combo('codigocarrera','admision','post','carrera','codigocarrera','nombrecarrera',"'$fechahoy' between fechainiciocarrera and fechavencimientocarrera",'nombrecarrera');
		}
		?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('direccionsitioadmision','Dirección sitio de admisión','requerido');?></td>
		<td><?php $formulario->campotexto('direccionsitioadmision','admision',40);?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('telefonositioadmision','Teléfono primario sitio de admisión','requerido');?></td>
		<td><?php $formulario->campotexto('telefonositioadmision','admision',10);?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('telefono2sitioadmision','Teléfono secundario sitio de admisión','');?></td>
		<td><?php $formulario->campotexto('telefono2sitioadmision','admision',10);?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('emailsitioadmision','Email sitio de admisión','email');?></td>
		<td><?php $formulario->campotexto('emailsitioadmision','admision',40);?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('nombreresponsablesitioadmision','Responsable sitio de admisión','requerido');?></td>
		<td><?php $formulario->campotexto('nombreresponsablesitioadmision','admision',40);?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('cantidadseleccionadoadmision','Capacidad sitio de admisión','numero');?></td>
		<td><?php $formulario->campotexto('cantidadseleccionadoadmision','admision',5);?></td>
	</tr>

</table>

<input type="submit" name="Enviar" value="Enviar">
<input type="button" name="Regresar" value="Regresar" onClick="regresarGET()">
<?php
if($_SESSION['idadmision']<>"") //si hay admision, deberá cargar y mostrar boton verificacion
{
	echo '<input type="button" name="Anular" value="Anular" onclick="Verificacion()">';
}
?>
</form>

<?php
//Lógica del formulario
if(isset($_REQUEST['Enviar']))
{
	$formulario->submitir();
	$formulario->valida_formulario();
	//obtener el subperiodo para el periodo seleccionado para la carrera, coje el subperiodo activo
	$query_subperiodo="SELECT sp.idsubperiodo
	FROM subperiodo sp, carreraperiodo cp
	WHERE
	cp.codigoperiodo='".$_POST['codigoperiodo']."'
	AND sp.codigoestadosubperiodo like '1%'
	AND sp.idcarreraperiodo=cp.idcarreraperiodo
	AND cp.codigocarrera='".$_POST['codigocarrera']."'
	";
	$operacion_subperiodo=$sala->query($query_subperiodo);
	$row_subperiodo=$operacion_subperiodo->fetchRow();
	$idsubperiodo=$row_subperiodo['idsubperiodo'];
	if($idsubperiodo<>"")
	{
		if($debug==true)
		{
			echo "Subperiodo: ".$idsubperiodo."<br>";
		}
		$formulario->agregar_datos_formulario('admision','idsubperiodo',$idsubperiodo);
		$formulario->agregar_datos_formulario('admision','codigoestado',100);
		$formulario->agregar_datos_formulario('admision','codigoestado',100);
	}
	else
	{
		echo "<script language='javascript'>alert('No se encontró subperiodo, falta parametrizar periodo, carreraperiodo, o subperiodo')</script>";
		exit();
	}
	$formulario->insertar("<script language='javascript'>window.close();</script><script language='javascript'>window.opener.recargar();</script>","<script language='javascript'>window.close();</script><script language='javascript'>window.opener.recargar();</script>");
}
if($formulario->array_datos_cargados['admision']->idadmision<>"")
{?>
	<!--<a href="detalleadmision_listado.php?link_origen=admision.php&idadmision=<?php echo $_SESSION['idadmision']?>">Detalle de pruebas de admisión(detalleadmision)</a><br>
	<a href="detallesitioadmision_listado.php?link_origen=admision.php&idadmision=<?php echo $_SESSION['idadmision']?>&codigocarrera=<?php echo $formulario->array_datos_cargados['admision']->codigocarrera?>">Listado de salones asignados(detallesitioadmision)</a><br>-->
<?php
//$formulario->boton_ventana_emergente('Salones','detallesitioadmision.php',"idadmision=$idadmision",640,480,50,50,'yes','yes','yes','yes','yes');
}
?>