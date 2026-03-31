<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$rutaado=("../../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../..//funciones/sala_genericas/FuncionesFecha.php");
unset($_SESSION['tmptipovotante']);
$fechahoy=date("Y-m-d H:i:s");
$objetobase=new BaseDeDatosGeneral($sala);

	header('Expires: Fri, 25 Dec 1980 00:00:00 GMT'); // time in the past
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
	header('Cache-Control: no-cache, must-revalidate');
	header('Pragma: no-cache');
	// generate the output in XML format
	header('Content-type: text/xml');
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<data>';
	$condicion=" and f.codigotipousuario='500' and f.idformulario not in ( 
		select fd.idformulario from formulariodocente fd,docente d where
		fd.iddocente=d.iddocente  and
		d.numerodocumento='".$_GET['numerodocumento']."'
		and fd.codigoestado = '100'
		and fd.codigoestadodiligenciamiento='200'
		and now() between fd.fechaformulariodocente and fd.fechafinalformulariodocente)
		and f.idformulario not in (select idformulariopadre  from formulario f where codigoestado= '100'  and f.codigotipousuario='500')
		and f.idformulario<>'3'
		";
	if($datosformularios=$objetobase->recuperar_datos_tabla("formulario f","codigoestado","100",$condicion,"",0)){
		echo "<continua>NO</continua>";
	}
	else
	{
		echo "<continua>SI</continua>";
	}
		
	echo '</data>';


?>