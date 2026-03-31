<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script language="javascript">
function enviar()
{
	form1.action="";
	document.form1.submit();
	
}
function enviarmodalidad(){

var codigocarrera=document.getElementById("codigocarrera");
//document.getElementById("tr0")
	//alert(form1.action);
	form1.action="";
	//alert(form1.action);
if(codigocarrera!=null)
codigocarrera.value="";
form1.submit();
}
function enviarcarrera(){

var codigoperiodo=document.getElementById("codigoperiodo");
//document.getElementById("tr0")
//alert("Entro numerodocumento="+numerodocumento);
	form1.action="";
if(codigoperiodo!=null)
codigoperiodo.value="";
form1.submit();
}
function enviarperiodo(){

var numerodocumento=document.getElementById("numerodocumento");
//document.getElementById("tr0")
//alert("Entro numerodocumento="+numerodocumento);
	form1.action="";
if(numerodocumento!=null)
numerodocumento.value="";
form1.submit();
}
function enviartarget(){
	form1.action="listadoreporteprocesofacultad.php";
	form1.submit();
}
</script>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<link rel="stylesheet" type="text/css" href="../../../funciones/sala_genericas/ajax/suggest/suggest.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<script type="text/javascript" src="../../../funciones/sala_genericas/ajax/suggest/suggest.js"></script>

<?php
$rutaado=("../../../funciones/adodb/");
require_once('../../../Connections/salaado-pear.php');
require_once("../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once('../../../funciones/sala_genericas/FuncionesFecha.php');
require_once('../../../funciones/sala_genericas/FuncionesCadena.php');

require_once('../../../funciones/sala_genericas/FuncionesMatriz.php');
require_once('../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once('../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');
//require_once('../../../funciones/clases/autenticacion/redirect.php');
//unset($_SESSION);

//$situacioncarreraestudiante[]='CARRERA';

$situacioncarreraestudiante['INSCRITOS']='INSCRITOS';
$situacioncarreraestudiante['TOTAL_MAT_NU']='MATRICULADOS NUEVOS';
$situacioncarreraestudiante['TOTAL_MAT_ANT']='MATRICULADOS ANTIGUOS';
$situacioncarreraestudiante['MATRICULADOS']='TOTAL MATRICULADOS';


$situacioncarrera['INSCRITOS']['INS_RAD']='Inscritos Radicados';
$situacioncarrera['INSCRITOS']['INS_REG']='Inscritos Registrados';
$situacioncarrera['INSCRITOS']['TOTAL_INS']='Inscritos Totales';
$situacioncarrera['INSCRITOS']['FAL_RAD_INS']='Inscritos Faltantes Radicados';
$situacioncarrera['INSCRITOS']['FAL_REG_INS']='Inscritos Faltantes Registrados';
$situacioncarrera['INSCRITOS']['INSCRITOS']='INSCRITOS';

$situacioncarrera['TOTAL_MAT_NU']['MAT_NU_RAD']='Matriculados Nuevos radicados';
$situacioncarrera['TOTAL_MAT_NU']['MAT_NU_REG']='Matriculados Nuevos registrados';
$situacioncarrera['TOTAL_MAT_NU']['TOTAL_MAT_NU']='Matriculados Nuevos Totales';
$situacioncarrera['TOTAL_MAT_NU']['FAL_MAT_NU_REG']='Matriculados Nuevos Faltantes Registrados ';
$situacioncarrera['TOTAL_MAT_NU']['FAL_MAT_NU_RAD']='Matriculados Nuevos Faltantes Radicados';
$situacioncarrera['TOTAL_MAT_NU']['MAT_NUEVO']='MATRICULADOS NUEVOS';


$situacioncarrera['TOTAL_MAT_ANT']['MAT_ANT_RAD']='Matriculados Antiguos Radicados';
$situacioncarrera['TOTAL_MAT_ANT']['MAT_ANT_REG']='Matriculados Antiguos Registrados';
$situacioncarrera['TOTAL_MAT_ANT']['TOTAL_MAT_ANT']='Matriculados Antiguos Totales';
$situacioncarrera['TOTAL_MAT_ANT']['FAL_MAT_ANT_REG']='Matriculados Antiguos Faltantes Registrados';
$situacioncarrera['TOTAL_MAT_ANT']['FAL_MAT_ANT_RAD']='Matriculados Antiguos Faltantes Radicados';
$situacioncarrera['TOTAL_MAT_ANT']['MAT_ANTIGUO']='MATRICULADOS ANTIGUOS';

$situacioncarrera['MATRICULADOS']['MAT_RAD']='Matriculados Radicados';
$situacioncarrera['MATRICULADOS']['MAT_REG']='Matriculados Registrados';
$situacioncarrera['MATRICULADOS']['TOTAL_MAT']='Matriculados Totales';
$situacioncarrera['MATRICULADOS']['FAL_RAD_MAT']='Matriculados Faltantes Radicados';
$situacioncarrera['MATRICULADOS']['FAL_REG_MAT']='Matriculados Faltantes Registrados';
$situacioncarrera['MATRICULADOS']['MATRICULADOS']='MATRICULADOS';


$_SESSION['sesionprocesofacultadcolumnas']=$situacioncarrera;
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
$usuario=$formulario->datos_usuario();
unset($_SESSION['ARREGLOREPORTEPROCESOFACULTAD']);


	$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar',' onclick=\'enviartarget();\''";
	$boton[$conboton]='boton_tipo';
	$conboton++;


echo "<form name='form1' action='' method='POST' >
<input type='hidden' name='AnularOK' value=''>
	<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='750'>
	"; 
	
		$formulario->dibujar_fila_titulo('REGISTRO DE PROCESO DE FACULTAD','labelresaltado');
		$condicion="";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modalidadacademica m","m.codigomodalidadacademica","m.nombremodalidadacademica",$condicion);
		$formulario->filatmp[""]="Seleccionar";
		$campo='menu_fila'; $parametros="'codigomodalidadacademica','".$_REQUEST['codigomodalidadacademica']."','onchange=enviarmodalidad();'";
		$formulario->dibujar_campo($campo,$parametros,"Modalidad Academica","tdtitulogris",'codigomodalidadacademica','requerido');		




			if($_SESSION["MM_Username"]=="admintecnologia"){
				$condicion=" codigomodalidadacademica='".$_REQUEST['codigomodalidadacademica']."'
							and now()  between fechainiciocarrera and fechavencimientocarrera
							order by nombrecarrera2";
				$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
				$formulario->filatmp[""]="Seleccionar";
				$formulario->filatmp["todos"]="*Todos";

			}
			else{
				$condicion=" c.codigocarrera=uf.codigofacultad
					and u.idusuario='".$usuario["idusuario"]."'
					and uf.usuario=u.usuario
					and c.codigomodalidadacademica='".$_REQUEST['codigomodalidadacademica']."'
					and now()  between fechainiciocarrera and fechavencimientocarrera
					order by nombrecarrera2";
				$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c, usuariofacultad uf, usuario u","c.codigocarrera","c.nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
				$formulario->filatmp[""]="Seleccionar";
				$formulario->filatmp["todos"]="*Todos";
				
			}

			$campo='menu_fila'; $parametros="'codigocarrera','".$_REQUEST['codigocarrera']."','onchange=enviarcarrera();'";
			$formulario->dibujar_campo($campo,$parametros,"Carrera","tdtitulogris",'codigocarrera','requerido');		

if(isset($_REQUEST['codigocarrera'])&&($_REQUEST['codigocarrera']!='')){

	$condicion=" 1=1 order by codigoperiodo desc";
	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("periodo","codigoperiodo","codigoperiodo",$condicion,"",0,0);
	//$formulario->filatmp[""]="Seleccionar";

	$codigoperiodo=$_SESSION['codigoperiodosesion'];
	if(!isset($_REQUEST['codigoperiodo']))
	$codigoperiodo="";
	else
	$codigoperiodo=$_REQUEST['codigoperiodo'];
	$campo='menu_fila'; $parametros="'codigoperiodo','".$codigoperiodo."','onchange=enviarperiodo();'";
	$formulario->dibujar_campo($campo,$parametros,"Periodo","tdtitulogris",'codigoperiodo','');
	$formulario->filatmp=$situacioncarreraestudiante;
	$formulario->filatmp["todos"]="TODOS";

	$codigoperiodo=$_REQUEST['codigoperiodo'];
	$campo='menu_fila_multi'; $parametros="'columnas','".$codigoperiodo."','10'";
	$formulario->dibujar_campo($campo,$parametros,"Columnas","tdtitulogris",'columnas','');

	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');


}

echo "</table></form>";

?>