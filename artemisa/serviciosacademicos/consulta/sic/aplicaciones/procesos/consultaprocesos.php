<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$rutaado=("../../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/validaciones/validaciongenerica.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once(realpath(dirname(__FILE__)).'/../../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once(realpath(dirname(__FILE__)).'/../../../../funciones/sala_genericas/FuncionesMatematica.php');
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
$rutaJS="../../../../funciones/sala_genericas/ajax/jquery/";
$objetobase=new BaseDeDatosGeneral($sala);
$condicion=" and i.codigoestado like '1%'
		and ic.codigoestado like '1%'
		and i.iditemsic=ic.iditemsic
		and ic.iditemsiccarrera=ica.iditemsiccarrera
		and ic.codigocarrera='156'
		and i.iditemsic='361' 
		and ica.nombreitemsiccarreraadjunto like '%mapadeprocesos1%'";
$datositemsicadjunto = $objetobase->recuperar_datos_tabla("itemsic i,itemsiccarrera  ic,itemsiccarreraadjunto ica","ica.codigoestado","100",$condicion,"",0);
$url="index.php?dir=../../adjuntos/".$datositemsicadjunto["nombreitemsiccarreraadjunto"];

echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$url."'>";
?>