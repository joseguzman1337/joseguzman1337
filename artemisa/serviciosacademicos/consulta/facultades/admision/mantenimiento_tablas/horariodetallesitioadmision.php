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


<script type="text/javascript" src="../../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script><script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>

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
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
$objetobase=new BaseDeDatosGeneral($sala);
$fechahoy=date("Y-m-d H:i:s");
?>
<form name="form1" action="" method="POST">
<input type="hidden" name="AnularOK" value="">
<?php
$formulario = new formulario($sala,'form1','post','',true);
//definicion de tablas con las que el formulario trabajará
$formulario->agregar_tablas('horariodetallesitioadmision','idhorariodetallesitioadmision');
if($_REQUEST['depurar']=="si")
{
	$sala->debug=true;
	$depurar=new SADebug();
	$depurar->trace($formulario,'','');
	$formulario->depurar();
	$debug=true;
}
/*if ($_GET['idhorariodetallesitioadmision']<>"") 
{
	$_SESSION['idhorariodetallesitioadmision']=$_GET['idhorariodetallesitioadmision'];
}
*/
$idhorariodetallesitioadmision=$_GET['idhorariodetallesitioadmision'];
if($idhorariodetallesitioadmision<>"")
{
	$formulario->cargar("idhorariodetallesitioadmision",$idhorariodetallesitioadmision);
	$formulario->cambiar_estado('horariodetallesitioadmision','codigoestado',200,"<script language='javascript'>window.close();</script><script language='javascript'>window.opener.recargar();</script>");
}
?>
<caption align="left"><p>Edición de Horarios para los salones(horariodetallesitioadmision)</p></caption>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('fechainiciohorariodetallesitioadmision','Fecha de inicio','requerido'); ?></td>
		<td><?php $formulario->calendario('fechainiciohorariodetallesitioadmision','horariodetallesitioadmision',8);?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('fechafinalhorariodetallesitioadmision','Fecha final','requerido');?></td>
		<td><?php $formulario->calendario('fechafinalhorariodetallesitioadmision','horariodetallesitioadmision',8);?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('horainicialhorariodetallesitioadmision','Hora de inicio','requerido');?></td>
		<td><?php $formulario->campotexto('horainicialhorariodetallesitioadmision','horariodetallesitioadmision',10);?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('horafinalhorariodetallesitioadmision','Hora final','requerido');?></td>
		<td><?php $formulario->campotexto('horafinalhorariodetallesitioadmision','horariodetallesitioadmision',10);?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('intervalotiempohorariodetallesitioadmision','Intervalo de tiempo','requerido');?></td>
		<td><?php $formulario->campotexto('intervalotiempohorariodetallesitioadmision','horariodetallesitioadmision',5);?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigotipogeneracionhorariodetallesitioadmision','Tipo de generación de horario','requerido');?></td>
		<td><?php $formulario->combo('codigotipogeneracionhorariodetallesitioadmision','horariodetallesitioadmision','post','tipogeneracionhorariodetallesitioadmision','codigotipogeneracionhorariodetallesitioadmision','nombretipogeneracionhorariodetallesitioadmision','','nombretipogeneracionhorariodetallesitioadmision');?></td>
	</tr>
</table>
<input type="submit" name="Enviar" value="Enviar">
<input type="button" name="Regresar" value="Regresar" onClick="regresarGET()">
<input type="submit" name="Agregar" value="Agregar">
<?php
if($_GET['idhorariodetallesitioadmision']<>"") //si hay admision_copia, deberá cargar y mostrar boton verificacion
{
	echo '<input type="button" name="Anular" value="Anular" onclick="Verificacion()">';
}?>
</form>

<?php
//Lógica del formulario
if(isset($_REQUEST['Enviar']))
{


		$tabla="horariodetallesitioadmision";
		$fila['fechainiciohorariodetallesitioadmision']=$_POST['fechainiciohorariodetallesitioadmision'];
		$fila['fechafinalhorariodetallesitioadmision']=$_POST['fechafinalhorariodetallesitioadmision'];
		$fila['horainicialhorariodetallesitioadmision']=$_POST['horainicialhorariodetallesitioadmision'];
		$fila['horafinalhorariodetallesitioadmision']=$_POST['horafinalhorariodetallesitioadmision'];
		$fila['codigoestado']="100";
		$fila['intervalotiempohorariodetallesitioadmision']=$_POST['intervalotiempohorariodetallesitioadmision'];
		$fila['codigotipogeneracionhorariodetallesitioadmision']=$_POST['codigotipogeneracionhorariodetallesitioadmision'];
		$fila['iddetallesitioadmision']=$_GET['iddetallesitioadmision'];
		if(isset($idhorariodetallesitioadmision)&&trim($idhorariodetallesitioadmision)!='')
		$condicionactualiza="idhorariodetallesitioadmision=".$idhorariodetallesitioadmision;		
		//print_r($fila);
		//if($fila['idestudianteadmision']==1966)
			//echo $condicionactualiza."<br>";
		$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);

	/*$formulario->submitir();
	$formulario->valida_formulario();
	$formulario->agregar_datos_formulario('horariodetallesitioadmision','codigoestado',100);
	$formulario->agregar_datos_formulario('horariodetallesitioadmision','iddetallesitioadmision',$_GET['iddetallesitioadmision']);
	$formulario->insertar("<script language='javascript'>window.close();</script><script language='javascript'>window.opener.recargar();</script>","<script language='javascript'>window.close();</script><script language='javascript'>window.opener.recargar();</script>");*/
	echo "<script language='javascript'>window.opener.recargar();</script><script language='javascript'>window.close();</script>","<script language='javascript'>window.opener.recargar();</script><script language='javascript'>window.close();</script>";
}
if(isset($_REQUEST['Agregar']))
{
	echo "<script language='javascript'>window.location.href='horariodetallesitioadmision.php?iddetallesitioadmision=".$_GET['iddetallesitioadmision']."&link_origen=".$_GET['link_origen']."'; </script>";
}
?>
