<?php
session_start();
//require_once('../../../funciones/clases/autenticacion/redirect.php' );
//$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../../funciones/adodb/");

require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/encuestav2/ConsultaEncuesta.php");


$objetobase=new BaseDeDatosGeneral($sala);

$objetoconsultapregunta= new ConsultaEncuesta($objetobase,$formulario);

        $tabla="respuestadocentesingindustrialacreditacion20131";
     /*   $filaadicional["codigoestudiante"]=$_SESSION["codigoestudiante_autoenfermeria"];
        $filaadicional["codigomateria"]=$_SESSION["codigomateria_autoenfermeria"];
        $filaadicional["codigoperiodo"]=$_SESSION["codigoperiodo_autoenfermeria"];*/
$filaadicional=array ();

$objetoconsultapregunta->setIdEncuesta($_GET["idencuesta"]);
$objetoconsultapregunta->setIdUsuario($_GET["idusuario"]);
$objetoconsultapregunta->setTablaRespuesta($tabla);
$objetoconsultapregunta->guardarEncuestaAjax($_GET["valorrespuesta"], $_GET["idpregunta"],$filaadicional);
?>
