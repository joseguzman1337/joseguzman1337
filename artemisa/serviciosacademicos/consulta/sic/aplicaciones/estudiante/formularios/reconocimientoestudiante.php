<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

$rutaado=("../../../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/phpmailer/class.phpmailer.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/validaciones/validaciongenerica.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesSeguridad.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesMatematica.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/tabla.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/dibujaformulario.php");

$formulario=new formulariobaseestudiante($sala,"form1","post","","true");
//,'Los campos marcados con *, no han sido correctamente diligenciados:\n\n',"",false,"../../../../../funciones/sala_genericas/",0

//&$conexion,$nombre,$metodo,$accion="",$validar=false,$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados:\n\n',$archivo_formulario="",$debug=false,$rutaraiz="../../../../",$scriptglobo=1
$formulario->rutaraiz="../../../../../funciones/sala_genericas/";


$objetobase=new BaseDeDatosGeneral($sala);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>

<link rel="stylesheet" type="text/css" href="../../../../../estilos/sala.css">
	<link rel="stylesheet" href="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/css/ajax-tooltip.css" media="screen" type="text/css">
	<link rel="stylesheet" href="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/css/ajax-tooltip-demo.css" media="screen" type="text/css">

<script type="text/javascript" src="../../../../../funciones/sala_genericas/funciones_javascript.js"></script>
	<style type="text/css">

	#ajax_tooltipObj .ajax_tooltip_arrow{	/* Left div for the small arrow */
		background-image:url('../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/images/arrow.gif');
		width:20px;
		position:absolute;
		left:0px;
		top:0px;
		background-repeat:no-repeat;
		background-position:left;
		z-index:1000005;
		height:60px;
	}
	</style>

	<script type="text/javascript" src="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/js/ajax-dynamic-content.js"></script>
	<script type="text/javascript" src="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/js/ajax.js"></script>
	<script type="text/javascript" src="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/js/ajax-tooltip.js"></script>

<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../../../funciones/clases/formulario/globo.js"></script>
<title>Servicios Academicos</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script LANGUAGE="JavaScript">
function enviarpais(idformulario,nombreid,id,nuevo)
{
var formulario=document.getElementById("form1");
if(document.getElementById("iddepartamentoreconocimientoestudiante")!=null)
document.getElementById("iddepartamentoreconocimientoestudiante").value=216;
if(document.getElementById("idciudadreconocimientoestudiante")!=null)
document.getElementById("idciudadreconocimientoestudiante").value=2001;

formulario.action="reconocimientoestudiante.php?Nuevo_Registro="+nuevo+"&idformulario="+idformulario+"&"+nombreid+"="+id;
formulario.submit();
}
function enviardepartamento(idformulario,nombreid,id,nuevo)
{
var formulario=document.getElementById("form1");
if(document.getElementById("idciudadreconocimientoestudiante")!=null)
document.getElementById("idciudadreconocimientoestudiante").value=2001;
formulario.action="reconocimientoestudiante.php?Nuevo_Registro="+nuevo+"&idformulario="+idformulario+"&"+nombreid+"="+id;
formulario.submit();

}
function enviarciudad(idformulario,nombreid,id,nuevo)
{
var formulario=document.getElementById("form1");
formulario.action="reconocimientoestudiante.php?Nuevo_Registro="+nuevo+"&idformulario="+idformulario+"&"+nombreid+"="+id;
formulario.submit();

}
</script>
</head>
<body>
<?php
echo "<form name=\"form1\" id=\"form1\" action=\"\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";


	$usuario=$formulario->datos_usuario();

$condicion=" and codigoestado like '1%'";
	$datosformulario=$objetobase->recuperar_datos_tabla("formulario f","idformulario",$_GET["idformulario"],$condicion,"",0);

$formulario->dibujar_fila_titulo(strtoupper($datosformulario["nombreformulario"]),'labelresaltado',"2","align='center'");

$formulario->dibujar_fila_titulo($datosformulario["descripcionformulario"],'tdtituloencuestadescripcion',"2","align='left'","td");

echo "<tr><td colspan=4> <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

	$condicion=" and r.codigoestado like '1%'
		and c.idciudad=r.idciudadreconocimientoestudiante
		and r.codigotiporeconocimientoestudiante=tp.codigotiporeconocimientoestudiante
		order by fechareconocimientoestudiante desc";
	//and tr.codigotiporeconocimientoestudiante=r.codigotiporeconocimientoestudiante
	$resultado=$objetobase->recuperar_resultado_tabla("reconocimientoestudiante  r,ciudad c,tiporeconocimientoestudiante tp","r.idestudiantegeneral",$_SESSION['sissic_idestudiantegeneral'],$condicion,"",0);
		$fila["Codigo"]="";
		$fila["Reconocimiento_Otorgado"]="";
		$fila["Tipo_Reconocimiento"]="";
		$fila["Ciudad"]="";
		$fila["Fecha_Reconocimiento"]="";


		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

	while($row=$resultado->fetchRow()){
		unset($fila);
		$enlacedetalle="<a href='reconocimientoestudiante.php?idreconocimientoestudiante=".$row["idreconocimientoestudiante"]."&idformulario=".$_GET["idformulario"]."'>".$row["idreconocimientoestudiante"]."</a>";
		$fila[$enlacedetalle]="";
		$fila[$row["otorgareconocimientoestudiante"]]="";
		$fila[$row["nombretiporeconocimientoestudiante"]]="";
		$fila[$row["nombreciudad"]]="";
		$fila[$row["fechareconocimientoestudiante"]]="";

		$formulario->dibujar_filas_texto($fila,'','',"colspan=4","colspan=4");

	}

	echo "<tr><td align='center' colspan='16'><input type='submit' name='Nuevo_Registro' id='Nuevo_Registro' value='Nuevo Registro'/> </td></tr>";

	echo "</table></td><tr>";


$muestraformulario=0;
if($_REQUEST["Enviar"]){
$muestraformulario=1;
}


if($_REQUEST["Nuevo_Registro"]){
$muestraformulario=1;
//echo "<h1>ENTRO A ANULAR  idestimulodocente ID=".$muestraformulario."</h1>";
	if(isset($_GET["idreconocimientoestudiante"])&&trim($_GET["idreconocimientoestudiante"])!=''){
		unset($_POST);
		unset($_GET["idreconocimientoestudiante"]);
	}

$_REQUEST["Anulado"]=0;
$_REQUEST["Nuevo_Registro"]=1;

}
if(isset($_GET["idreconocimientoestudiante"])&&trim($_GET["idreconocimientoestudiante"])!=''){
$muestraformulario=1;
//echo "<h1>ENTRO A VERIFICAR ID=".$muestraformulario."</h1>";
}
if($datosdedicacionexterna=$objetobase->recuperar_datos_tabla("reconocimientoestudiante","idreconocimientoestudiante",$_GET["idreconocimientoestudiante"],"","",0)){
 if($datosdedicacionexterna["codigoestado"]=="200"){
	$muestraformulario=0;
		//echo "<h1>ENTRO 1 A CAMBIAR MUESTRA=".$muestraformulario."</h1>";
	}

}
if($_REQUEST["Anulado"]){
$muestraformulario=0;
//echo "<h1>ENTRO 2 A CAMBIAR MUESTRA=".$muestraformulario."</h1>";
}

$nombreidtabla="idreconocimientoestudiante";
$idtablaget=$_GET["idreconocimientoestudiante"];
$idformulario=$_GET["idformulario"];
/*
echo "<pre>";
print_r($_GET);
echo "</pre>";
echo "_POST<pre>";
print_r($_POST);
echo "</pre>";*/
$objdibujaformulario=new DibujaFormulario("reconocimientoestudiante",$_GET["idreconocimientoestudiante"],$sala,$_GET["idformulario"],$formulario);

if($muestraformulario){

	$arrayquitacolumnas[0]="idestudiantegeneral";
	$arrayquitacolumnas[1]="codigoestado";
	$arrayquitacolumnas[2]="idpaisreconocimientoestudiante";
	$arrayquitacolumnas[3]="iddepartamentoreconocimientoestudiante";
	$arrayquitacolumnas[4]="idciudadreconocimientoestudiante";
	$objdibujaformulario->quitarcolumnas($arrayquitacolumnas);
	$formulario->boton_tipo("hidden","idestudiantegeneral",$_SESSION['sissic_idestudiantegeneral'],"");
	$formulario->boton_tipo("hidden","codigoestado","100","");
	$objdibujaformulario->muestraFormulario();
	$objdibujaformulario->columnas[]="idestudiantegeneral";
	$objdibujaformulario->columnas[]="codigoestado";


	if(is_array($_POST)&&count($_POST)>0){

		$pais=$_POST["idpaisreconocimientoestudiante"];
		$departamento=$_POST["iddepartamentoreconocimientoestudiante"];
		$ciudad=$_POST["idciudadreconocimientoestudiante"];
	}
	else{
		$tmpdatosidtabla=$objdibujaformulario->objetoadmintabla->obtenerdatosidtabla($objdibujaformulario->idtabla,0);
		$tmpcamposidtabla=$objdibujaformulario->objetoadmintabla->campostabla();

		foreach($tmpcamposidtabla as $icampo=>$nombrecampo){
			if("idpaisreconocimientoestudiante"==$nombrecampo)
			$pais=$tmpdatosidtabla[$icampo];

			if("iddepartamentoreconocimientoestudiante"==$nombrecampo)
			$departamento=$tmpdatosidtabla[$icampo];

			if("idciudadreconocimientoestudiante"==$nombrecampo)
			$ciudad=$tmpdatosidtabla[$icampo];
		}

	}


/*Muestra los menu de seleccion dependientes pais, depatamento, ciudad*/
	$condicion=" 1=1 order by nombrepais";
	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("pais p","idpais","nombrepais",$condicion,'',0);
	$formulario->filatmp["0"]="*Otro*";
	$formulario->filatmp[""]="Seleccionar";
	$campo='menu_fila'; $parametros="'idpaisreconocimientoestudiante','".$pais."','onchange=enviarpais(\'".$idformulario."\',\'".$nombreidtabla."\',\'".$idtablaget."\',\'".$_REQUEST["Nuevo_Registro"]."\');'";
	$formulario->dibujar_campo($campo,$parametros,"Pais ","tdtitulogris",'idpaisreconocimientoestudiante','requerido');
	$objdibujaformulario->columnas[]="idpaisreconocimientoestudiante";

	//if(isset($pais)&&trim($pais)!=''&&trim($pais)!='todos'){

        $condicion=" idpais='".$pais."' and d.codigoestado like '1%' order by nombredepartamento
			";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("departamento d","iddepartamento","nombredepartamento",$condicion,'',0);
		$formulario->filatmp["216"]="*Otro*";
		$formulario->filatmp[""]="Seleccionar";
		$campo='menu_fila'; $parametros="'iddepartamentoreconocimientoestudiante','".$departamento."','onchange=enviardepartamento(\'".$idformulario."\',\'".$nombreidtabla."\',\'".$idtablaget."\',\'".$_REQUEST["Nuevo_Registro"]."\');'";
		$formulario->dibujar_campo($campo,$parametros,"Departamento ","tdtitulogris",'iddepartamentoreconocimientoestudiante','requerido');
		$objdibujaformulario->columnas[]="iddepartamentoreconocimientoestudiante";

        $condicion=" iddepartamento='".$departamento."' and c.codigoestado like '1%' order by nombreciudad
					";
			$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("ciudad c","idciudad","nombreciudad",$condicion,'',0);
			$formulario->filatmp["2000"]="*Otro*";;
			$formulario->filatmp[""]="Seleccionar";
			$campo='menu_fila'; $parametros="'idciudadreconocimientoestudiante','".$ciudad."','onchange=enviarciudad(\'".$idformulario."\',\'".$nombreidtabla."\',\'".$idtablaget."\',\'".$_REQUEST["Nuevo_Registro"]."\');'";
			$formulario->dibujar_campo($campo,$parametros,"Ciudad ","tdtitulogris",'idciudadreconocimientoestudiante','requerido');
			$objdibujaformulario->columnas[]="idciudadreconocimientoestudiante";



	$objdibujaformulario->botonesEnvio();
}

	if($objdibujaformulario->ingresarModificacion()){
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."'>";
	echo "<script type='text/javascript'>
		window.parent.frames[1].cambiaEstadoImagen(true,".$_GET["idformulario"].");
	</script>";

	}

	if($objdibujaformulario->ingresarNuevo()){


	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."'>";
	echo "<script type='text/javascript'>
		window.parent.frames[1].cambiaEstadoImagen(true,".$_GET["idformulario"].");
	</script>";

	}
	if($objdibujaformulario->ingresarAnulacion()){
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."&Anulado=1'>";
	}

echo "</table>";
echo "</form>";
?>
</body>
</html>