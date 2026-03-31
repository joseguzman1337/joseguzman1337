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
	$debug=true;
	$sala->debug=true;
}

$query="SELECT
s.codigosalon, 
s.nombresalon,
s.cupomaximosalon,
ts.nombretiposalon,
se.nombresede
FROM
salon s, sede se, tiposalon ts
WHERE
s.codigosede=se.codigosede
AND s.codigotiposalon=ts.codigotiposalon
";
$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
do
{
	$array_interno[]=$row_operacion;
}
while ($row_operacion=$operacion->fetchRow());

$tabla = new matriz($array_interno,"Listado General de Salones",'admision_listado.php','si','no','menu.php');

$tabla->agregarllave_drilldown('codigosalon','salon_listado.php','salon.php','detallesalon','codigosalon','','','','','Edición de Salones','');
$tabla->mostrar();
$tabla->MuestraBotonVentanaEmergente('Agregar_Salon','salon.php',"",800,400,50,50,"yes","yes","no","yes","no");
?>
<?php
//echo $PHP_SELF,"<br><br>";
//echo $REQUEST_URI,"<br><br>";
//echo $arg,"<br><br>";
//print_r($HTTP_GET_VARS); echo "<br>";
//print_r($HTTP_POST_VARS);echo "<br>";
?>
