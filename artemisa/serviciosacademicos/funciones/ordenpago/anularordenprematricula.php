<?php
require_once(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));
Factory::validateSession($variables);
global $db;

$pos = strpos($Configuration->getEntorno(), "local");
if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"||$pos!==false){
	require_once(PATH_ROOT.'/kint/Kint.class.php');
	/*ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);*/
}

$ruta="../";
require_once('claseordenpago.php');
require_once('Cimpresionescyc.php');
mysql_select_db($database_sala, $sala);

$orden = new Ordenpago($sala, $_GET['codigoestudiante'], $_GET['codigoperiodo'], $_GET['numeroordenpago']);
$Query= "SELECT eg.numerodocumento,o.numeroordenpago  ".
" FROM ordenpago o ".
" INNER JOIN prematricula pr on pr.idprematricula=o.idprematricula ".
" INNER JOIN detalleprematricula dpr on dpr.idprematricula=pr.idprematricula ".
" INNER JOIN estudiante e on e.codigoestudiante=o.codigoestudiante ".
" INNER JOIN carrera c on c.codigocarrera=e.codigocarrera ".
" INNER JOIN estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral ".
" INNER JOIN detalleordenpago do on do.numeroordenpago=o.numeroordenpago and do.valorconcepto>0 ".
" INNER JOIN fechaordenpago f on f.numeroordenpago = do.numeroordenpago ".
" WHERE o.numeroordenpago IN ('".$_GET['numeroordenpago']."' ) AND codigoestadoordenpago not like '2%' ".
" GROUP BY eg.numerodocumento";
$row = $db->GetRow($Query);
$p = realpath ( dirname(__FILE__).'/../../consulta/interfacespeople/ordenesdepago/anularordenespagosala.php' );
if(count($row)>0 && $row!=false){
	//proceso de anulacion en people
	include_once(dirname(__FILE__).'/../../consulta/interfacespeople/ordenesdepago/anularordenespagosala.php');
} else {
	//la orden esta en ceros
	$result['ERRNUM']=0;
}

//si el errornum es diferente a 0 o igual a 1 o vacio y si la descripcion de diferente a la factura no existe
if($result['ERRNUM']!=0 || $result['ERRNUM']==='' || $result['ERRNUM']==1
&& strpos($result['DESCRLONG'],'La FACTURA no existe')!== false){
	echo "<script>alert('La orden numero '+".$_GET['numeroordenpago']."+' no pudo ser anulada. Por favor tome nota de este numero y contactese con la universidad para recibir ayuda en este proceso. Gracias.')</script>";
}else{
	$orden->anular_ordenpago(2);
}

if(isset($_SESSION['modulosesion']) && $_SESSION['modulosesion'] == "inscripcion"
	|| isset($_SESSION['nombreprograma']) && $_SESSION['nombreprograma'] == "ingresopreinscripcion.php"){
	$dir = "../../../aspirantes/enlineacentral.php?documentoingreso=".$_GET['documentoingreso']."&logincorrecto";
} else {
	$dir = "../../consulta/prematricula/matriculaautomaticaordenmatricula.php";
}

echo "<script language='javascript'>
	 window.opener.recargar('".$dir."');
	 window.opener.focus();
	 window.close();
	 </script>";
?>
