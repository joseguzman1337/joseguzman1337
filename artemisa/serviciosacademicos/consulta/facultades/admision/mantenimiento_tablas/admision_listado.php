<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 
ini_set('memory_limit', '64M');
ini_set('max_execution_time','90');
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
<script language="Javascript">
function recargar()
{
	window.location.reload("admision_listado.php");
}
function reCarga(pagina){
	document.location.href=pagina;
}

</script>
<?php
$rutaado=("../../../../funciones/adodb/");
require_once('../../../../Connections/salaado-pear.php');
require_once('../../../../funciones/clases/formulario/clase_formulario.php');
require_once('funciones/ObtenerDatos.php');
require_once('../../../../funciones/clases/motor/motor.php');
?>
<?php
if($_GET['depurar']==si)
{
	$sala->debug=true;
}
$codigoperiodo=$_SESSION['codigoperiodo_seleccionado'];
$codigoperiodo=$_GET['codigoperiodo'];
$datos=new TablasAdmisiones($sala);
//$_GET['codigomodalidadacademica']=$_SESSION['codigomodalidadacademica'];
//$_GET['codigocarrera']=$_SESSION['codigocarrera'];
/*echo "<pre>";
print_r($_GET);
echo "</pre>";*/

/*If($_REQUEST['codigomodalidadacademica']!=$_SESSION['codigomodalidadacademica']&&(trim($_REQUEST['codigomodalidadacademica'])!=''))
$_SESSION['codigomodalidadacademica']=$_REQUEST['codigomodalidadacademica'];

If($_REQUEST['codigocarrera']!=$_SESSION['codigocarrera']&&(trim($_REQUEST['codigocarrera'])!=''))
$_SESSION['codigocarrera']=$_REQUEST['codigocarrera'];
*/

$array_carreras=$datos->LeerCarreras($_GET['codigomodalidadacademica'],$_GET['codigocarrera']);
foreach ($array_carreras as $llave => $valor)
{
	$query="SELECT a.idadmision,
	a.nombreadmision,
	a.idsubperiodo,
	cp.codigoperiodo,
	c.nombrecarrera,
	a.direccionsitioadmision,
	a.telefonositioadmision,
	a.telefono2sitioadmision,
	a.emailsitioadmision,
	a.nombreresponsablesitioadmision,
	a.cantidadseleccionadoadmision
	FROM admision a, carrera c, carreraperiodo cp, subperiodo s
	WHERE a.codigoestado=100
	AND a.codigocarrera=c.codigocarrera
	AND c.codigocarrera=cp.codigocarrera
	AND cp.codigoperiodo='$codigoperiodo'
	AND s.idsubperiodo=a.idsubperiodo
	AND s.idcarreraperiodo=cp.idcarreraperiodo
	AND c.codigocarrera='".$valor['codigocarrera']."'
	";
	
	$operacion=$sala->query($query);
	$row_operacion=$operacion->fetchRow();
	do
	{
		if($row_operacion['idadmision']<>"")
		{
			$array_interno[]=$row_operacion;
		}
	}
	while ($row_operacion=$operacion->fetchRow());
}

?>

<?php
$tabla = new matriz($array_interno,"Listado de admisiones periodo $codigoperiodo",'admision_listado.php','si','no','menuparametrizacionadmisiones.php');
$tabla->agregarllave_drilldown('idadmision','admision_listado.php','admision.php','detalle','idadmision','','','','','Edición de admisiones','');
$tabla->mostrar();
//$tabla->MuestraBotonVentanaEmergente('Agregar_Admision','admision.php',"",800,400,50,50,"yes","yes","no","yes","no");
?>
<?php
/*echo $PHP_SELF,"<br><br>";
echo $REQUEST_URI,"<br><br>";
echo $arg,"<br><br>";
print_r($HTTP_GET_VARS); echo "<br>";
print_r($HTTP_POST_VARS);echo "<br>";
echo "*";*/
?>
<form name="form1" method="post" action="">
<input type="submit" name="Agregar_Admision" value="Agregar_Admision">
</form>
<?php
if(isset($_POST['Agregar_Admision']))
{
	unset($_SESSION['idadmision']);
	echo '<script language="javascript">abrir("admision.php","admision","width=800,height=400,top=50,left=50,scrollbars=yes,toolbar=no,resizable=yes,status=yes,menu=no")</script>';
}
?>
