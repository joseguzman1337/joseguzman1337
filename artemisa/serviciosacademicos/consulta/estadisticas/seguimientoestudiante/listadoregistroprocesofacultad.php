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

function arreglo_registro_proceso($sala){
$query="select e.codigoestudiante,c.nombrecarrera, e.semestre Semestre,eg.numerodocumento numerodocumento,
td.nombrecortodocumento Tipo_Documento,
eg.apellidosestudiantegeneral Apellidos,eg.nombresestudiantegeneral Nombres,
eg.direccionresidenciaestudiantegeneral Direccion,
eg.telefonoresidenciaestudiantegeneral Telefono,
eg.emailestudiantegeneral,
rf.numeroordenpago,
rf.observacionregistroprocesofacultad,
rf.idregistroprocesofacultad
from estudiantegeneral eg, estudiante e, registroprocesofacultad rf
, carrera c, documento td
where eg.idestudiantegeneral=e.idestudiantegeneral and
td.tipodocumento = eg.tipodocumento and
 e.codigoestudiante=rf.codigoestudiante and
rf.codigoestado like '1%' and
c.codigocarrera=e.codigocarrera and
e.codigocarrera=".$_SESSION['codigocarreraregistroprocesofacultad']." and
rf.codigoperiodo=".$_SESSION['codigoperiodoregistroprocesofacultad']." and
rf.codigotiporegistroprocesofacultad=".$_SESSION['codigotiporegistroregistroprocesofacultad'];
//en.fechainicioestudiantenovedadarp >= '$inicio_mes' 

$operacion=$sala->query($query);
//$row_operacion=$operacion->fetchRow();
while ($row_operacion=$operacion->fetchRow()){
	//if(validar_diferencia_fechas(formato_fecha_defecto($row_operacion['Fecha_Inicio']),formato_fecha_defecto($inicio_mes)))
	$array_interno[]=$row_operacion;
	
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
}
return $array_interno;
}
//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
$objetobase=new BaseDeDatosGeneral($sala);

if($_REQUEST['codigocarrera']!=$_SESSION['codigocarreraregistroprocesofacultad']&&(trim($_REQUEST['codigocarrera'])!=''))
$_SESSION['codigocarreraregistroprocesofacultad']=$_REQUEST['codigocarrera'];

if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiodoregistroprocesofacultad']&&(trim($_REQUEST['codigoperiodo'])!=''))
$_SESSION['codigoperiodoregistroprocesofacultad']=$_REQUEST['codigoperiodo'];

if($_REQUEST['codigotiporegistroprocesofacultad']!=$_SESSION['codigotiporegistroregistroprocesofacultad']&&(trim($_REQUEST['codigotiporegistroprocesofacultad'])!=''))
$_SESSION['codigotiporegistroregistroprocesofacultad']=$_REQUEST['codigotiporegistroprocesofacultad'];


if($_REQUEST['codigomodalidad']!=$_SESSION['codigomodalidadregistroprocesofacultad']&&(trim($_REQUEST['codigomodalidad'])!=''))
$_SESSION['codigomodalidadregistroprocesofacultad']=$_REQUEST['codigomodalidad'];

unset($_GET['Restablecer']);
unset($_GET['Regresar']);
unset($_GET['Recargar']);
$datoscarrera=$objetobase->recuperar_datos_tabla("carrera","codigocarrera",$_SESSION['codigocarreraregistroprocesofacultad'],"","",0);
$datostipoproceso=$objetobase->recuperar_datos_tabla("tiporegistroprocesofacultad","codigotiporegistroprocesofacultad",$_SESSION['codigotiporegistroregistroprocesofacultad'],"","",0);

//$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datose studiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
echo "<table width='100%'><tr><td align='center'><h3>LISTADO DE ESTUDIANTES EN EL PROCESO ".strtoupper($datostipoproceso["nombretiporegistroprocesofacultad"])." DEL PROGRAMA ".$datoscarrera["nombrecarrera"]." EN EL PERIODO ".$_SESSION['codigoperiodoregistroprocesofacultad']."</h3></td></tr></table>";
$motor = new matriz(arreglo_registro_proceso($sala),"Listado de proceso de facultad","listadoregistroprocesofacultad.php?semestre=$semestre","si","si","menu.php","listadoregistroprocesofacultad.php?semestre=$semestre&link_origen=menu.php",true,"si","../../../");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
$motor->agregarllave_drilldown('numerodocumento','listadoregistroprocesofacultad.php','menuregistroprocesofacultad.php','','idregistroprocesofacultad',"codigocarrera=".trim($_SESSION['codigocarreraregistroprocesofacultad'])."&codigoperiodo=".$_SESSION['codigoperiodoregistroprocesofacultad']."&codigotiporegistroprocesofacultad=".$_SESSION['codigotiporegistroregistroprocesofacultad']."&codigomodalidadacademica=".$_SESSION['codigomodalidadregistroprocesofacultad'],'','','','','onclick= "return ventanaprincipal(this)"');
$motor->Recarga=false;
$motor->mostrar();
?>
 