<?php
//session_start();
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script LANGUAGE="JavaScript">
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
function reCarga(){
	document.location.href="<?php echo 'listadoreporteprocesofacultad.php';?>";

}
function regresarGET()
{
	document.location.href="<?php echo 'listadoreporteprocesofacultad.php';?>";
}

</script>
<?php
$rutaado=("../../../funciones/adodb/");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../seguridadsocial/funciones/FuncionesAportes.php");
require_once("../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../matriculas/funciones/obtener_datos.php");


function arreglo_registro_proceso($sala,$objetobase){
	$i=0;
	$arrayresultado=$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$_SESSION['codigocarreradetallereporteprocesofacultad']][$_SESSION['columnadetallereporteprocesofacultad']];
	unset($arraydatosestudiante);
	foreach($arrayresultado as $llave => $valor)
	{
		
		$arraydatosestudiante[]=$objetobase->recuperar_datos_tabla("carrera c,estudiantegeneral eg, estudiante e","e.codigoestudiante",$valor," and eg.idestudiantegeneral=e.idestudiantegeneral and e.codigocarrera = c.codigocarrera","",0);	
		unset($arraydatosestudiante[$i]["idestudiantegeneral"]);
		unset($arraydatosestudiante[$i]["idtrato"]);		
		unset($arraydatosestudiante[$i]["idestadocivil"]);		
		unset($arraydatosestudiante[$i]["tipodocumento"]);		
		unset($arraydatosestudiante[$i]["codigojornada"]);		
		unset($arraydatosestudiante[$i]["codigosituacioncarreraestudiante"]);		
		unset($arraydatosestudiante[$i]["codigotipoestudiante"]);		
		unset($arraydatosestudiante[$i]["numerocohorte"]);		
		unset($arraydatosestudiante[$i]["codigocarrera"]);		
		unset($arraydatosestudiante[$i]["idtipoestudiantefamilia"]);	
		unset($arraydatosestudiante[$i]["numerolibretamilitar"]);
		unset($arraydatosestudiante[$i]["numerodistritolibretamilitar"]);
		unset($arraydatosestudiante[$i]["expedidalibretamilitar"]);	
		unset($arraydatosestudiante[$i]["nombrecortoestudiantegeneral"]);	
		unset($arraydatosestudiante[$i]["idciudadnacimiento"]);	
		unset($arraydatosestudiante[$i]["codigogenero"]);			
		unset($arraydatosestudiante[$i]["ciudadresidenciaestudiantegeneral"]);	
		unset($arraydatosestudiante[$i]["codigotipocliente"]);	
                   

		unset($arraydatosestudiante[$i]["codigocortocarrera"]);	
		unset($arraydatosestudiante[$i]["codigofacultad"]);	
		unset($arraydatosestudiante[$i]["centrocosto"]);	
		unset($arraydatosestudiante[$i]["codigocentrobeneficio"]);	
		unset($arraydatosestudiante[$i]["codigosucursal"]);	
		unset($arraydatosestudiante[$i]["codigomodalidadacademica"]);	
		unset($arraydatosestudiante[$i]["fechainiciocarrera"]);	
		unset($arraydatosestudiante[$i]["fechavencimientocarrera"]);	
		unset($arraydatosestudiante[$i]["abreviaturacodigocarrera"]);	
		unset($arraydatosestudiante[$i]["iddirectivo"]);	
		unset($arraydatosestudiante[$i]["codigotitulo"]);	
		unset($arraydatosestudiante[$i]["codigoindicadorcobroinscripcioncarrera"]);	
		unset($arraydatosestudiante[$i]["codigoindicadorprocesoadmisioncarrera"]);	
		unset($arraydatosestudiante[$i]["codigoindicadorplanestudio"]);	
		unset($arraydatosestudiante[$i]["codigoindicadortipocarrera"]);	
		unset($arraydatosestudiante[$i]["codigoreferenciacobromatriculacarrera"]);	
		unset($arraydatosestudiante[$i]["numerodiaaspirantecarrera"]);	
		unset($arraydatosestudiante[$i]["nombrecortocarrera"]);	
		unset($arraydatosestudiante[$i]["codigotipocosto"]);	
		unset($arraydatosestudiante[$i]["codigoindicadorcarreragrupofechainscripcion"]);	
		$arraydatosestudiante[$i]["estudiante"]=$arraydatosestudiante[$i]["codigoestudiante"];
		//unset($arraydatosestudiante[$i]["codigoindicadorcarreragrupofechainscripcion"]);	
		$i++;

	}

return $arraydatosestudiante;
}
//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
$objetobase=new BaseDeDatosGeneral($sala);

if($_REQUEST['codigocarrera']!=$_SESSION['codigocarreradetallereporteprocesofacultad']&&(trim($_REQUEST['codigocarrera'])!=''))
$_SESSION['codigocarreradetallereporteprocesofacultad']=$_REQUEST['codigocarrera'];

if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiododetallereporteprocesofacultad']&&(trim($_REQUEST['codigoperiodo'])!=''))
$_SESSION['codigoperiododetallereporteprocesofacultad']=$_REQUEST['codigoperiodo'];
unset($_REQUEST['codigoperiodo']);
//echo "MODALIDAD ACADEMICA=".$_REQUEST['codigomodalidadacademica'];
if($_REQUEST['codigomodalidadacademica']!=$_SESSION['codigomodalidaddetallereporteprocesofacultad']&&(trim($_REQUEST['codigomodalidadacademica'])!=''))
$_SESSION['codigomodalidaddetallereporteprocesofacultad']=$_REQUEST['codigomodalidadacademica'];

if($_REQUEST['columna']!=$_SESSION['columnadetallereporteprocesofacultad']&&(trim($_REQUEST['columna'])!=''))
$_SESSION['columnadetallereporteprocesofacultad']=$_REQUEST['columna'];

$datoscarrera=$objetobase->recuperar_datos_tabla("carrera","codigocarrera",$_SESSION['codigocarreradetallereporteprocesofacultad'],"","",0);
$datostipoproceso=$objetobase->recuperar_datos_tabla("tiporegistroprocesofacultad","codigotiporegistroprocesofacultad",$_SESSION['codigotiporeporteprocesofacultad'],"","",0);

//$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datose studiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
echo "<table width='100%'><tr><td align='center'><h3>LISTADO DE ESTUDIANTES EN EL PROCESO ".strtoupper($_SESSION['columnadetallereporteprocesofacultad'])." DEL PROGRAMA ".$datoscarrera["nombrecarrera"]." EN EL PERIODO ".$_SESSION['codigoperiododetallereporteprocesofacultad']."</h3></td></tr></table>";
$motor = new matriz(arreglo_registro_proceso($sala,$objetobase),"Listado de proceso de facultad","listadodetallereporteprocesofacultad.php?semestre=$semestre","si","si","menu.php","listadodetallereporteprocesofacultad.php?semestre=$semestre&link_origen=menu.php",true,"si","../../../");
$formulario->filatmp["todos"]="*Todos*";

//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
$motor->agregarllave_drilldown('numerodocumento','listadodetallereporteprocesofacultad.php','../../prematricula/loginpru.php','','estudiante',"&codigofacultad=".$_SESSION['codigocarreradetallereporteprocesofacultad']."&programausadopor=facultad&descriptor=pantallaestudiante");
$motor->Recarga=false;
$motor->mostrar();
?>