<?php
/*
* Caso 90158
* @modified Luis Dario Gualteros 
* <castroluisd@unbosque.edu.co>
 * Se modifica la variable session_start por la session_start( ) ya que es la funcion la que contiene el valor de la variable $_SESSION.
 * @since Mayo 18 de 2017
*/
session_start( );
//End Caso  90158
include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once(realpath(dirname(__FILE__)).'/../Connections/sala2.php');
ini_set('max_execution_time','6000');
?>
<link rel="stylesheet" type="text/css" href="../estilos/sala.css"></link>
<script type="text/javascript" src="js/jquery.js"></script>
<style>
    button, select ,input[type="submit"], input[type="reset"], input[type="button"], .button {
    background-color: #ECF1F4;
    background-image: url("../../../../index.php?entryPoint=getImage&themeName=Sugar5&imageName=bgBtn.gif");
    border-color: #ABC3D7;
    color: #000000;
}
</style>

<script language="javascript">
	function validar(param) {
		var msj="";
		if (param==1) {
			document.form3.numerodocumentoaux.value="";
			msj+=(document.form3.codigocarreraaux.value=="")?'Por favor seleccione una carrera.':"";
		} else if (param==2) {
			document.form3.codigocarreraaux.value="";
			msj+=(document.form3.numerodocumentoaux.value=="")?'Por favor digite un nÃºmero de documento.':"";
		} else {
			document.form3.action="reporte.php";
		}
		if(msj)
			alert(msj);
		else
			document.form3.submit();
	}
</script>
<?php
$rutaado = ("../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__))."/../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../funciones/sala_genericas/FuncionesFecha.php");
require_once(realpath(dirname(__FILE__))."/../funciones/sala_genericas/FuncionesMatriz.php");
require_once(realpath(dirname(__FILE__))."/../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../funciones/sala_genericas/clasebasesdedatosgeneral.php");

$objetobase = new BaseDeDatosGeneral($sala);
$formulario = new formulariobaseestudiante($sala, 'form3', 'post', '', 'true');
?>

<table align="center" width="50%" style="" >
    <tr><td colspan="3">
            <div id="studiofields">
        <input class="button" type="button" onclick="document.location ='admin_egresado.php'" value="Regresar" name="addfieldbtn"/>
        </div>            
        </td></tr>
    <tr><td colspan="3">Informacion General de Egresados<hr></td></tr>
    <tr><td colspan="3">
<?php


//:::::::::::::::::::::
echo "	<form name=\"form3\" action=\"detalle_consulta_egresado.php\" method=\"post\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\" align=\"left\">";

$formulario->dibujar_fila_titulo('INFORMACION EGRESADOS','labelresaltado',"2","align='center'");
$formulario->dibujar_fila_titulo('&nbsp;&nbsp;&nbsp;&nbsp;Filtrar por:','labelresaltado',"2","align='left'");
$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modalidadacademica f","codigomodalidadacademica","nombremodalidadacademica","");
$formulario->filatmp[""]="Seleccionar";
$campo='menu_fila';
$vlr_default_modalidad=($_POST['codigomodalidadacademicaaux'])?$_POST['codigomodalidadacademicaaux']:$_SESSION['codigomodalidadacademicaaux'];
$parametros="'codigomodalidadacademicaaux','".$vlr_default_modalidad."','OnChange=javascript:document.form3.action=\"\";document.form3.submit()'";
$formulario->dibujar_campo($campo,$parametros,"Modalidad Academica","tdtitulogris",'codigomodalidadacademicaaux','');
//$codigofacultad="05";
$condicion="c.codigomodalidadacademica='".$vlr_default_modalidad."'
order by c.nombrecarrera";
$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera",$condicion,'',0);
$formulario->filatmp[""]="Seleccionar";
$vlr_default_carrera=($_POST['codigocarreraaux'])?$_POST['codigocarreraaux']:$_SESSION['codigocarreraaux'];
$campo='menu_fila'; $parametros="'codigocarreraaux','".$vlr_default_carrera."'";
$formulario->dibujar_campo($campo,$parametros,"Carrera","tdtitulogris",'codigocarreraaux','');
$campo="boton_tipo"; $parametros="'button','accion','Enviar','OnClick=javascript:validar(1)'";
$formulario->dibujar_campo($campo,$parametros,"&nbsp;","tdtitulogris","","");

$formulario->dibujar_fila_titulo('&nbsp;','labelresaltado',"2","align='center'");

$formulario->dibujar_fila_titulo('&nbsp;&nbsp;&nbsp;&nbsp;Buscar por:','labelresaltado',"2","align='left'");
$vlr_default_nrodocumento=($_POST['numerodocumentoaux'])?$_POST['numerodocumentoaux']:$_SESSION['numerodocumentoaux'];
$campo="boton_tipo"; $parametros="'text','numerodocumentoaux','".$vlr_default_nrodocumento."'";
$formulario->dibujar_campo($campo,$parametros,"N&uacute;mero de documento","tdtitulogris",'numerodocumentoaux','');
$campo="boton_tipo"; $parametros="'button','accion','Enviar','OnClick=javascript:validar(2)'";
$formulario->dibujar_campo($campo,$parametros,"&nbsp;","tdtitulogris","","");

$formulario->dibujar_fila_titulo('<hr>','labelresaltado',"2","align='center'");



echo "</table></form>";
//:::::::::::::::::::::
?>
        </tr>
</table>
