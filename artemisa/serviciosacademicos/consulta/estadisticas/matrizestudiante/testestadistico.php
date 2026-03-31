<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();

$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/phpmailer/class.phpmailer.php");
require_once("../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesSeguridad.php");
require_once("../../../funciones/sala_genericas/FuncionesMatematica.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once('../../../funciones/sala/nota/nota.php');
require_once("EstadisticoEstudiante.php");
require_once("EstadisticoDocente.php");
ini_set('max_execution_time','6000');

$objetobase=new BaseDeDatosGeneral($sala);
$objestadisitico=new EstadisticoDocente("20092",$objetobase);

$db=$objetobase->conexion;

$resultado=$objetobase->recuperar_resultado_tabla("carrera","codigomodalidadacademicasic","200","","",0);



echo date("H:i:s")."<br>";
$horainicial=mktime(date("H"),date("i"),date("s"));

$i=0;
while($row=$resultado->fetchRow()){
$i++;
$horainiciali=mktime(date("H"),date("i"),date("s"));
//$arrayestratoi=$objestadisitico->porcentajesTotales("rangoEdad","200");
$horafinali=mktime(date("H"),date("i"),date("s"));
echo "Diferencia Parcial ".$i." =".($horafinali-$horainiciali)."<br>";
ob_flush();
flush();
}
$horafinal=mktime(date("H"),date("i"),date("s"));
echo date("H:i:s")."<br>";


echo "<br>Diferencia Total=".($horafinal-$horainicial)."<br>";


ob_flush();
flush();


echo date("H:i:s")."<br>";
$horainicial=mktime(date("H"),date("i"),date("s"));
//$arrayestratoi=$objestadisitico->porcentajesTotales("rangoEdad","");
$arrayestratoi=$objestadisitico->rangoEdad("200");

/*
$arrayestrato2=$objestadisitico->rangoEstrato("200");
$arrayestrato2=$objestadisitico->rangoGenero("200");
$arrayestrato2=$objestadisitico->rangoNivelEducacion("200");
$arrayestrato2=$objestadisitico->rangoPuestoIcfes("200");
$arrayestrato2=$objestadisitico->rangoNacionalidad("200");
$arrayestrato2=$objestadisitico->rangoParticipacionAcademica("200");
$arrayestrato2=$objestadisitico->rangoLineaInvestigacion("200");
$arrayestrato2=$objestadisitico->rangoParticipacionBienestar("200");
$arrayestrato2=$objestadisitico->rangoParticipacionGobierno("200");
$arrayestrato2=$objestadisitico->rangoAsociacion("200");
$arrayestrato2=$objestadisitico->rangoProyeccionSocial("200");
//$arrayestrato2=$objestadisitico->rangoEstimulo("200");
$arrayestrato2=$objestadisitico->rangoReconocimiento("200");
$arrayestrato2=$objestadisitico->rangoTipoFinanciacion("200");
//$arrayestrato2=$objestadisitico->rangoEstadoEstudiante("200");
$arrayestrato2=$objestadisitico->historicoEstudiante("200");*/
echo "arrayestrato<pre>";
print_r($arrayestratoi);
echo "</pre>";
/*$arrayestrato2=$objestadisitico->rangoHistoricoXPeriodoActivo("000","","","000");
echo "arrayestrato<pre>";
print_r($arrayestrato2);
echo "</pre>";
$arrayestrato3=$objestadisitico->rangoHistorico("000","","","000");
echo "arrayestrato<pre>";
print_r($arrayestrato3);
echo "</pre>";*/

$horafinal=mktime(date("H"),date("i"),date("s"));
//echo "<br>".date("H:i:s")."<br>";
echo "<br>Diferencia query completo=".($horafinal-$horainicial)."<br>";

echo date("H:i:s")."<br>";




?>