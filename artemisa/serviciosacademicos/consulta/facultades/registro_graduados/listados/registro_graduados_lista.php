<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    if (empty($_SESSION['MM_Username'])){
        echo "<h1>Usted no está autorizado para ver esta página</h1>";
	    exit();
    }

    $rutaado=("../../../../funciones/adodb/");
    require_once("../../../../funciones/clases/debug/SADebug.php");
    require_once("../../../../Connections/salaado-pear.php");
    require_once("../funciones/obtener_datos.php");
    require_once("../../../../funciones/clases/motor/motor.php");
    require_once('../../../../funciones/clases/autenticacion/redirect.php' );
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<?php
	$datos = new datos_registro_graduados($sala,false);
	$datos->obtener_carreras($_SESSION['codigomodalidadacademica'],$_SESSION['codigocarrera']);
	$array_egresados=$datos->obtener_datos_listado($_SESSION['incentivos'],$_SESSION['codigocarrera']);
    $_SESSION['get']=$_GET;
?>
<script type="text/javascript" src="funciones/funciones_javascript.js"></script>
<?php
	$informe=new matriz($array_egresados,"Informe de registros de grado","registro_graduados_lista.php","si","no","menu.php"); 
	if($_GET['incentivos'] == 'no'){
		$informe->agregarllave_drilldown('nombre','listados/registro_graduados_lista.php','../registro_graduados.php','registros','codigoestudiante','','','','','','');
	}
	$informe->mostrar();
?>
