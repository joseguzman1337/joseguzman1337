<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
//require_once('../../../funciones/clases/autenticacion/redirect.php' ); 
//$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";
exit();*/
$rutaado=("../../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once(realpath(dirname(__FILE__)).'/../../../../funciones/sala_genericas/FuncionesSeguridad.php');

require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__)).'/../../../../funciones/clases/autenticacion/redirect.php');
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script type="text/javascript" src="../../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../../funciones/clases/formulario/globo.js"></script>
    <link rel="stylesheet" href="../../../../funciones/sala_genericas/ajax/tab/css/tab-view.css" type="text/css" media="screen">
    <script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/tab/js/ajax.js"></script>

<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/tab/js/tab-view.js"></script>

  </head>
  <body>
<?php

if(isset($_GET["iditem"])&&trim($_GET["iditem"])!=''){
$tabla="itemsic";
$nombreidtabla="iditemsic";
$idtabla=$_GET["iditem"];
$datositemsic=$objetobase->recuperar_datos_tabla($tabla,$nombreidtabla,$idtabla,"","",0);
$nombreitemsic=$datositemsic["nombreitemsic"];
$descripcionitemsic=$datositemsic["descripcionitemsic"];
$longituddescripcionitemsic=$datositemsic["longituddescripcionitemsic"];
$codigotipoitemsic=$datositemsic["codigotipoitemsic"];
$pesoitemsic=$datositemsic["pesoitemsic"];
$enlaceitemsic=$datositemsic["enlaceitemsic"];
$enlaceconsultaitemsic=$datositemsic["enlaceconsultaitemsic"];
$codigoestadoitemsic=$datositemsic["codigoestadoitemsic"];
$cantidadadjuntositemsic=$datositemsic["cantidadadjuntositemsic"];


}
else
{
$nombreitemsic=$_POST["nombreitemsic"];
$descripcionitemsic=$_POST["descripcionitemsic"];
$longituddescripcionitemsic=$_POST["longituddescripcionitemsic"];
$codigotipoitemsic=$_POST["codigotipoitemsic"];
$pesoitemsic=$_POST["pesoitemsic"];
$enlaceitemsic=$_POST["enlaceitemsic"];
$enlaceconsultaitemsic=$_POST["enlaceconsultaitemsic"];
$codigoestadoitemsic=$_POST["codigoestadoitemsic"];
$cantidadadjuntositemsic=$_POST["cantidadadjuntositemsic"];
}
echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
	$formulario->dibujar_fila_titulo('ADMINISTRACION ITEM','labelresaltado',"2","align='center'");echo "</table>";
echo "	<form id=\"form1\" name=\"form1\" action=\"\" method=\"post\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">";
echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";

$parametrobotonenviar="'nombreitemsic','nombreitemsic',40,4,'','','',''";
$boton='memo';
$formulario->dibujar_campo($boton,$parametrobotonenviar,"Nombre Item","tdtitulogris",'nombreitemsic','requerido');
$formulario->cambiar_valor_campo('nombreitemsic',$nombreitemsic);

$parametrobotonenviar="'descripcionitemsic','descripcionitemsic',40,4,'','','',''";
$boton='memo';
$formulario->dibujar_campo($boton,$parametrobotonenviar,"Descripcion Item","tdtitulogris",'descripcionitemsic','');
$formulario->cambiar_valor_campo('descripcionitemsic',$descripcionitemsic);

$parametrobotonenviar="'text','longituddescripcionitemsic','".$longituddescripcionitemsic."','size=5'";
$boton='boton_tipo';
$formulario->dibujar_campo($boton,$parametrobotonenviar,"Longitud de descripción","tdtitulogris","longituddescripcionitemsic","requerido");

$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipoitemsic","codigotipoitemsic","nombretipoitemsic"," codigoestado like '1%'");
$formulario->filatmp[""]="Seleccionar";
$menu="menu_fila";
$parametrosmenu="'codigotipoitemsic','".$codigotipoitemsic."',''";
$formulario->dibujar_campo($menu,$parametrosmenu,"Tipo de Item","tdtitulogris","codigotipoitemsic","requerido");

$parametrobotonenviar="'text','pesoitemsic','".$pesoitemsic."','size=5'";
$boton='boton_tipo';
$formulario->dibujar_campo($boton,$parametrobotonenviar,"Peso de Item","tdtitulogris","pesoitemsic","requerido");

$parametrobotonenviar="'text','cantidadadjuntositemsic','".$cantidadadjuntositemsic."','size=5'";
$boton='boton_tipo';
$formulario->dibujar_campo($boton,$parametrobotonenviar,"Cantidad Adjuntos","tdtitulogris","cantidadadjuntositemsic","");


$parametrobotonenviar="'text','enlaceitemsic','".$enlaceitemsic."',''";
$boton='boton_tipo';
$formulario->dibujar_campo($boton,$parametrobotonenviar,"Enlace programa de ingreso","tdtitulogris","enlaceitemsic","");

$parametrobotonenviar="'text','enlaceconsultaitemsic','".$enlaceconsultaitemsic."',''";
$boton='boton_tipo';
$formulario->dibujar_campo($boton,$parametrobotonenviar,"Enlace programa de consulta","tdtitulogris","enlaceconsultaitemsic","");

$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estadoitemsic","codigoestadoitemsic","nombreestadoitemsic","");
$formulario->filatmp[""]="Seleccionar";
$menu="menu_fila";
$parametrosmenu="'codigoestadoitemsic','".$codigoestadoitemsic."',''";
$formulario->dibujar_campo($menu,$parametrosmenu,"Estado de Item","tdtitulogris","codigoestadoitemsic","requerido");

unset($parametrobotonenviar);
unset($boton);
if(isset($_GET["iditem"])&&trim($_GET["iditem"])!=''){
$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Modificar','Modificar'";
	$boton[$conboton]='boton_tipo';
	$conboton++;
}
else{
$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
	$boton[$conboton]='boton_tipo';
	$conboton++;
}
	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','',0);




echo  "</table>";
echo  "</form>";	      

echo  "</table>";


if(isset($_REQUEST["Modificar"])){
if($formulario->valida_formulario()){
	$tabla="itemsic";
	$fila["nombreitemsic"]=$_POST["nombreitemsic"];
	$fila["descripcionitemsic"]=$_POST["descripcionitemsic"];
	$fila["longituddescripcionitemsic"]=$_POST["longituddescripcionitemsic"];
	$fila["codigotipoitemsic"]=$_POST["codigotipoitemsic"];
	$fila["pesoitemsic"]=$_POST["pesoitemsic"];
	$fila["enlaceitemsic"]=$_POST["enlaceitemsic"];
	$fila["enlaceconsultaitemsic"]=$_POST["enlaceconsultaitemsic"];
	$fila["codigoestadoitemsic"]=$_POST["codigoestadoitemsic"];
	$fila["cantidadadjuntositemsic"]=$_POST["cantidadadjuntositemsic"];
	$condicionactualiza=" iditemsic=".$_GET["iditem"];
	//echo "<pre>";
	$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
	//echo "</pre>";
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
}
}
if(isset($_REQUEST["Enviar"])){
if($formulario->valida_formulario()){
	$tabla="itemsic";
	$fila["nombreitemsic"]=$_POST["nombreitemsic"];
	$fila["descripcionitemsic"]=$_POST["descripcionitemsic"];
	$fila["longituddescripcionitemsic"]=$_POST["longituddescripcionitemsic"];
	$fila["iditemsicpadre"]="1";
	$fila["codigoestado"]="100";
	$fila["codigotipoitemsic"]=$_POST["codigotipoitemsic"];
	$fila["pesoitemsic"]=$_POST["pesoitemsic"];
	$fila["enlaceitemsic"]=$_POST["enlaceitemsic"];
	$fila["enlaceconsultaitemsic"]=$_POST["enlaceconsultaitemsic"];
	$fila["codigoestadoitemsic"]=$_POST["codigoestadoitemsic"];
	$fila["cantidadadjuntositemsic"]=$_POST["cantidadadjuntositemsic"];

	//$condicionactualiza=" nombreitemsic=".$_GET["iditem"];
	$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
	
	echo "<script type='text/javascript'>
	window.parent.frames[1].location.href='creararbolsic.php';
	//window.parent.frames[1].saveMyTree();	
	</script>";
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
}

}

?>
  </body>
</html>