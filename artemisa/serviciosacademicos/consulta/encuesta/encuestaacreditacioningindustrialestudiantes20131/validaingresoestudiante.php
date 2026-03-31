<?php
session_start();
$rutaado = ("../../../funciones/adodb/");

require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");

//echo "<H1>ENTRO</H1>";
//exit();
$formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true');
$objetobase = new BaseDeDatosGeneral($sala);

$condicion = "	AND o.numeroordenpago=d.numeroordenpago
		AND eg.idestudiantegeneral=e.idestudiantegeneral
		AND e.codigoestudiante=pr.codigoestudiante
		AND pr.codigoperiodo='20131'
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal=151
		AND o.codigoperiodo='20131'
		AND o.codigoestadoordenpago LIKE '4%'
		AND c.codigocarrera in (126,8)
	        AND c.codigomodalidadacademica in ('200') ";

if ($datosestudiante = $objetobase->recuperar_datos_tabla("ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr,estudiantegeneral eg", "eg.idestudiantegeneral", $_GET['idusuario'], $condicion, '', 0)) {
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=encuestaestudiante.php?idusuario=".$_GET['idusuario']."&codigocarrera=".$datosestudiante['codigocarrera']."'>";
} else {
	echo "<script type='text/javascript'> window.parent.continuar();</script>";
}
//exit();

?>
