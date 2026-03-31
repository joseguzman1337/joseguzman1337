<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
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
<script language="javascript">
function recargar()
{
	window.location.href="horariodetallesitioadmision_listado.php?iddetallesitioadmision=<?php echo $_GET['iddetallesitioadmision']?>";
}
</script>
<?php
$rutaado=("../../../../funciones/adodb/");
require_once('../../../../Connections/salaado-pear.php');
require_once('../../../../funciones/clases/formulario/clase_formulario.php');
require_once('../../../../funciones/clases/motor/motor.php');
?>
<?php
if($_GET['depurar']=='si')
{
	$sala->debug=true;
}
$iddetallesitioadmision=$_GET['iddetallesitioadmision'];
$idadmision=$_GET['idadmision'];
$query="SELECT dsa.iddetallesitioadmision,
dsa.idadmision,
dsa.codigosalon,
hdsa.idhorariodetallesitioadmision,
hdsa.fechainiciohorariodetallesitioadmision,
hdsa.fechafinalhorariodetallesitioadmision,
hdsa.horainicialhorariodetallesitioadmision,
hdsa.horafinalhorariodetallesitioadmision,
hdsa.intervalotiempohorariodetallesitioadmision,
tghdsa.nombretipogeneracionhorariodetallesitioadmision
FROM
detallesitioadmision dsa, horariodetallesitioadmision hdsa, admision a, tipogeneracionhorariodetallesitioadmision tghdsa
WHERE
a.idadmision=dsa.idadmision
AND dsa.iddetallesitioadmision=hdsa.iddetallesitioadmision
AND hdsa.codigotipogeneracionhorariodetallesitioadmision=tghdsa.codigotipogeneracionhorariodetallesitioadmision
AND dsa.iddetallesitioadmision='$iddetallesitioadmision'
AND hdsa.codigoestado='100'
";
//echo $query;
$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
do
{
	$array_interno[]=$row_operacion;
}
while ($row_operacion=$operacion->fetchRow());
$tabla = new matriz($array_interno,'Detalle de salones asignados a sitios de admisiones','detallesitioadmision_listado.php','si','no','detallesitioadmision_listado.php');
$tabla->agregarllave_emergente('idhorariodetallesitioadmision',"horariodetallesitioadmision_listado.php",'horariodetallesitioadmision.php','horariodetallesitioadmision','idhorariodetallesitioadmision','',300,250,200,150,"yes","yes","no","no","no","idadmision","idadmision","Edición de horariositioadmision");
//$tabla->agregarllave_drilldown('idhorariodetallesitioadmision',"horariodetallesitioadmision_listado.php?idadmision=".$_SESSION['idadmision']."",'horariodetallesitioadmision.php','horariodetallesitiadmision','idhorariodetallesitioadmision','','iddetallesitioadmision','','','horarios para el salón(horariodetallesitioadmision)','');
$tabla->mostrar();
?>
<?php
$tabla->MuestraBotonVentanaEmergente('Agregar_Horario','horariodetallesitioadmision.php',"iddetallesitioadmision=$iddetallesitioadmision",300,250,50,50,"yes","yes","no","yes","no");
?>