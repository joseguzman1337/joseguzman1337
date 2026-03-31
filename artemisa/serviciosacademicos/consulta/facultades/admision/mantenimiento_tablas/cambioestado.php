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
function enviar(){
document.form1.submit();
}
</script>


<?php
$rutaado=("../../../../funciones/adodb/");
require_once('../../../../Connections/salaado-pear.php');
require_once('../../../../funciones/clases/formulario/clase_formulario.php');
require_once('../../../../funciones/clases/debug/SADebug.php');
require_once('funciones/ObtenerDatos.php');

$fechahoy=date("Y-m-d H:i:s");
?>
<form name="form1" action="" method="POST">
<input type="hidden" name="AnularOK" value="">
<?php
if($_REQUEST['depurar']=="si")
{
	$sala->debug=true;
	$depurar=new SADebug();
	$depurar->trace($formulario,'','');
	$formulario->depurar();
	$debug=true;
}
$formulario = new formulario($sala,'form1','post','',true);
$admisiones_consulta=new TablasAdmisiones($sala,$debug);

$idadmision=$admisiones_consulta->LeerIdadmision($_GET['codigocarrera'],$_GET['idsubperiodo']);
//echo "idadmision=".$idadmision."codigocarrera=".$_GET['codigocarrera']."idsubperiodo=".$_GET['idsubperiodo'];
?>
<caption align="left"><p>EDICION ESTADO ADMISION<br><?php echo $row_nombre_est['nombre']?></p></caption>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('detalleadmision','Nuevo Estado','requerido');?></td>
		<td><?php $admisiones_consulta->DibujarMenuSituacion($idadmision,$_POST['situacioncarreraestudiante'],"onchange=enviar();") ?></td>
	</tr>
</table>
<input type="submit" name="Enviar" value="Enviar">
<input type="hidden" name="inscripcion" value="<?php echo $_GET['idinscripcion'] ?>">
<input type="button" name="Regresar" value="Regresar" onClick="regresarGET()">
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
	//$formulario->submitir();
	if(isset($_POST['situacioncarreraestudiante'])&&$_POST['situacioncarreraestudiante']!=""){
		$admisiones_consulta->ActualizarSituacionInscripcion($_POST['situacioncarreraestudiante'],$_GET['idinscripcion']);
		echo "<script language='javascript'>window.close()</script><script language='javascript'>window.opener.recargar();</script>";
	}
}
?>
