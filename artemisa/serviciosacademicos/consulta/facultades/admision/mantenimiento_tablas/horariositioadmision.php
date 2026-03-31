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
<?php
$rutaado=("../../../../funciones/adodb/");
require_once('../../../../Connections/salaado-pear.php');
require_once("funciones/ObtenerDatos.php");
?>
<?php
$nombresitioadmision="Universidad El Bosque";
$direccionsitioadmision="Transversal 9A Bis No. 132-55";
$telefonositioadmision="6331368";
$nombreresponsablesitioadmision="UNIVERSIDAD";
$codigoestado=100;
$capacidadsitioadmision=100;

$fechainiciohorariositioadmision='2006-10-17';
$fechafinalhorariositioadmision='2006-12-31';
$horainicialhorariositioadmision='10:00';
$horafinalhorariositioadmision='16:00';
$intervalotiempohorariositioadmision='1:00';
$codigoestado=100;
$codigotipogeneracionhorariositioadmosion=200;

$sitioadmision = new TablasAdmisiones($sala);
$array_carreras=$sitioadmision->LeerCarreras("todos","todos");
if($_GET['depurar'])
{
	$sitioadmision->DibujarTabla($array_carreras);
}
foreach ($array_carreras as $llave => $valor)
{
	$array_subperiodo=$sitioadmision->LeerSubperiodos($valor['codigocarrera']);
	if($array_subperiodo['idsubperiodo']=="")
	{
		$array_nosubperiodo[]=array('codigocarrera'=>$valor['codigocarrera'],'nombrecarrera'=>$valor['nombrecarrera']);
	}
	else
	{
		$query_seleccion=
		"SELECT c.codigocarrera,sa.idsitioadmision
		FROM
		sitioadmision sa, carrera c
		WHERE
		sa.codigocarrera='".$valor['codigocarrera']."'
		AND sa.codigocarrera=c.codigocarrera
		";
		$sala->debug=true;
		$operacion=$sala->query($query_seleccion);
		$sala->debug=false;
		$row_seleccion=$operacion->fetchRow();

		$query_inserta_horarios="
		INSERT INTO horariositioadmision
		(idsitioadmision, 
		fechainiciohorariositioadmision, fechafinalhorariositioadmision, 
		horainicialhorariositioadmision, horafinalhorariositioadmision, 
		intervalotiempohorariositioadmision, codigoestado, 
		codigotipogeneracionhorariositioadmision
		)
		VALUES('".$row_seleccion['idsitioadmision']."',$fechainiciohorariositioadmision,$fechafinalhorariositioadmision,'$horainicialhorariositioadmision','$horafinalhorariositioadmision','$intervalotiempohorariositioadmision','$codigoestado','$codigotipogeneracionhorariositioadmosion')
		";
		$sala->debug=true;
		$inserccion=$sala->query($query_inserta_horarios);
		$sala->debug=false;
	}
}
$sitioadmision->DibujarTabla($array_nosubperiodo,'Carreras sin carreraperiodo o subperiodo');
?>