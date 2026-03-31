<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
$rutaado=("../../funciones/adodb/");
require_once('../../Connections/sala2.php');

require_once("../../Connections/salaado-pear.php");

require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");

$objetobase=new BaseDeDatosGeneral($sala);

/*echo "sala<pre>";
print_r($objetobase);
echo "</pre>";
echo "psico<pre>";
print_r($objetobasepsico);
echo "</pre>";*/
$condicion=" and e.codigocarrera in (133,134) ";
if($datosestudiante=$objetobase->recuperar_datos_tabla("estudiante e  ","codigoestudiante",$_REQUEST['codigoestudiante'],$condicion,'',0)){


$condicion=" and eg.idestudiantegeneral=e.idestudiantegeneral";
$datosestudiante=$objetobase->recuperar_datos_tabla("estudiantegeneral eg, estudiante e  ","codigoestudiante",$_REQUEST['codigoestudiante'],$condicion,'',0);


require_once('../../Connections/psicologiatmp.php');
$objetobasepsico=new BaseDeDatosGeneral($uebautes);
$fila['nombres']=$datosestudiante["nombresestudiantegeneral"];
$fila['apellidos']=$datosestudiante["apellidosestudiantegeneral"];
$fila['cedula']=$datosestudiante["numerodocumento"];
$fila['codigoestudiante']=$_REQUEST['codigoestudiante'];
$fila['codigoperiodo']=$_SESSION['codigoperiodosesion'];
/*echo "<pre>";
print_r($fila);
echo "</pre>";*/
$condicion=" and codigoperiodo=".$_SESSION['codigoperiodosesion'];

if($datosencuesta=$objetobasepsico->recuperar_datos_tabla("tpercont  ","codigoestudiante",$datosestudiante["codigoestudiante"],$condicion,'',0)){
alerta_javascript("Ya ha realizado la autoevaluación");
echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../prematricula/matriculaautomaticaordenmatricula.php'>";
}
else{
//alerta_javascript("Puede Continuar");
$condicionactualiza=" codigoestudiante=".$datosestudiante["codigoestudiante"].
		"  and codigoperiodo=".$_SESSION['codigoperiodosesion'];
$objetobasepsico->insertar_fila_bd("tpercont",$fila,0,$condicionactualiza);
//$formulario=new formulariobaseestudiante($sala,'form2','post','','true');
echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=https://artemisa.unbosque.edu.co/basepsicologia/uebseautest/Autoevalest.php'>";
}
}
else{
alerta_javascript("No puede ingresar a esta opción");
echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../prematricula/matriculaautomaticaordenmatricula.php'>";
}
?>