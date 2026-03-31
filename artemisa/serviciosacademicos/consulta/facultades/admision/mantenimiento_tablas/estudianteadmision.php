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
$fechahoy=date("Y-m-d H:i:s");
?>
<form name="form1" action="" method="POST">
<input type="hidden" name="AnularOK" value="">
<?php
$formulario = new formulario($sala,'form1','post','',true);
//definicion de tablas con las que el formulario trabajará
$formulario->agregar_tablas('estudianteadmision','idestudianteadmision');
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
$codigotipodetalleadmision=$_GET['codigotipodetalleadmision'];
$codigoestudiante=$_GET['codigoestudiante'];
$idadmision=$_GET['idadmision'];

$query_nombre_est="SELECT concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre
FROM
estudiante e, estudiantegeneral eg
WHERE
e.codigoestudiante='$codigoestudiante'
AND e.idestudiantegeneral=eg.idestudiantegeneral
";
$operacion_nombre=$sala->query($query_nombre_est);
$row_nombre_est=$operacion_nombre->fetchRow();

$query_iddetalleestudianteadmision="SELECT
ea.idestudianteadmision
FROM
estudianteadmision ea, detalleestudianteadmision dea, detalleadmision da, detallesitioadmision dsa, horariodetallesitioadmision hdsa, admision a
WHERE
ea.idadmision='$idadmision'
AND ea.idadmision = ea.idadmision
AND ea.idestudianteadmision = dea.idestudianteadmision
AND dea.iddetalleadmision=da.iddetalleadmision
AND ea.codigoestudiante='$codigoestudiante'
AND a.idadmision=ea.idadmision
AND a.idadmision=dsa.idadmision
AND dsa.iddetallesitioadmision=hdsa.iddetallesitioadmision
AND ea.codigoestado=100
AND dea.codigoestado=100
AND da.codigoestado=100
";
//echo $query_iddetalleestudianteadmision,"<br>";
$operacion_iddetallleestudianteadmision=$sala->query($query_iddetalleestudianteadmision);
$row_operacion_iddetallleestudianteadmision=$operacion_iddetallleestudianteadmision->fetchRow();
//print_r($row_operacion_iddetallleestudianteadmision);
$iddetalleestudianteadmision=$row_operacion_iddetallleestudianteadmision['iddetalleestudianteadmision'];
//echo "<h1>$iddetalleestudianteadmision</h1>";
$idestudianteadmision=$row_operacion_iddetallleestudianteadmision['idestudianteadmision'];
$iddetalleadmision=$row_operacion_iddetallleestudianteadmision['iddetalleadmision'];
$idhorariodetallesitioadmision=$row_operacion_iddetallleestudianteadmision['idhorariodetallesitioadmision'];
//echo "<h1>".$idestudianteadmision,"</h1>";
if($idestudianteadmision<>"")
{
	$formulario->cargar("idestudianteadmision",$idestudianteadmision);
	//$formulario->cambiar_estado('iddetalleestudianteadmision','codigoestado',200,"<script language='javascript'>window.close()</script>");
}
?>
<caption align="left"><p>EDICION ESTADO ADMISION<br><?php echo $row_nombre_est['nombre']?></p></caption>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigoestadoestudianteadmision','Estado admisión','requerido');?></td>
		<td><?php $formulario->combo('codigoestadoestudianteadmision','estudianteadmision','post','estadoestudianteadmision','codigoestadoestudianteadmision','nombreestadoestudianteadmision','','nombreestadoestudianteadmision');?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php ?></td>
		<td><?php ?></td>
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
	$formulario->submitir();
	$formulario->valida_formulario();
	$formulario->insertar("<script language='javascript'>window.close()</script><script language='javascript'>window.opener.recargar();</script>","<script language='javascript'>window.close()</script><script language='javascript'>window.opener.recargar();</script>");
}
?>
