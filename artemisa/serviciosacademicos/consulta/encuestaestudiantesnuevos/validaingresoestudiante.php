<?php
session_start();
ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
$rutaado=("../../../funciones/adodb/");



require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/encuesta/ValidaEncuesta.php");
/*echo"GET<pre>";
print_r($_GET);
echo "<br>session";
print_r($_SESSION);

idusuariofinalentradaentrada

echo"</pre>";
exit();*/

unset($_SESSION['tmptipovotante']);
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
$query = "SELECT codigoperiodo from periodo where codigoestadoperiodo in (3,1) ORDER BY codigoestadoperiodo DESC";
$resultado= $objetobase->conexion->query($query);
$rowperiodo=$resultado->fetchRow();




$query_valcarrera = "select * from estudiante e, estudiantegeneral eg 
  where eg.idestudiantegeneral='".$_GET['idusuario']."'
  and e.idestudiantegeneral=eg.idestudiantegeneral
  and e.codigocarrera in(133,134)";   

    $valcarrera = $objetobase->conexion->query($query_valcarrera);
    $totalRows_valcarrera = $valcarrera->numRows();

if($totalRows_valcarrera!=0){
	
	$_GET["codigotipousuario"]=600;
	$_GET["idencuesta"]=50;
	$url_encuesta="encuestaautofacultad/encuestaautofacultad.php";
	$condicion_aux="'200'";
	$condicion_aux2="";

}
else{ 

	$_GET["codigotipousuario"]=600;
	$_GET["idencuesta"]=50;
	$url_encuesta="encuestaautofacultad/encuestaautofacultad.php";
	$condicion_aux="'200'";
	$condicion_aux2="";

}

/*

$_GET["codigotipousuario"]=600;
	$_GET["idencuesta"]=50;
	$url_encuesta="encuestaautofacultad/encuestaautofacultad.php";
	$condicion_aux="'200'";
	$condicion_aux2="";
	
*/	
$carreras="-1";
$fechaInicio="2016-03-14 00:00:00";
$fechaFin="2016-03-18 23:59:59";
if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy)){
	//INGENIERIA AMBIENTAL ,CIENCIA POLITICA,DERECHO
	$carreras= "125,735,595";
}

$fechaInicio="2016-03-28 00:00:00";
$fechaFin="2016-04-01 23:59:59";
if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy)){
	//INGENIERIA ELECTRONICA ,INGENIERIA INDUSTRIAL,MATEMATICAS,ESTADISTICA
	$carreras= "118,119,126,790,857";
}

$fechaInicio="2016-04-04 00:00:00";
$fechaFin="2016-04-08 23:59:59";
if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy)){
	//bioingenieria, diseño industrial, diseño de comunicacion
	$carreras= "564,129,788,126";
}

$fechaInicio="2016-04-11 00:00:00";
$fechaFin="2016-04-15 23:59:59";
if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy)){
	//FILOSOFIA,INSTRUMENTACION QUIRURGICA,ADMINISTRACION DE EMPRESAS,NEGOCIOS INTERNACIONALES,CURSO BASICO (GENERAL)
	$carreras= "427,380,5,748,13";
}

$fechaInicio="2016-04-18 00:00:00";
$fechaFin="2016-04-22 23:59:59";
if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy)){
	//INGENIERIA DE SISTEMAS,LICENCIATURA EN EDUCACION BILINGUE CON ENFASIS EN LA ENSEÑANZA DEL INGLES,LICENCIATURA EN PEDAGOGIA INFANTIL
	$carreras= "123,124,93,90";
}

$fechaInicio="2016-04-25 00:00:00";
$fechaFin="2016-04-29 23:59:59";
if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy)){
	//MEDICINA
	$carreras= "10";
}

$fechaInicio="2016-05-02 00:00:00";
$fechaFin="2016-05-06 23:59:59";
if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy)){
	//BIOLOGIA, OPTOMETRIA, ODONTOLOGIA
	$carreras= "122,375,11";
}

$fechaInicio="2016-05-10 00:00:00";
$fechaFin="2016-05-16 23:59:59";
if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy)){
	//PSICOLOGIA
	$carreras= "133";
}

$fechaInicio="2016-05-17 00:00:00";
$fechaFin="2016-05-23 23:59:59";
if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy)){
	//ARTE DRAMATICO,FORMACION MUSICAL, ARTES PLASTICAS
	$carreras= "500,130,132";
}

$fechaInicio="2016-05-31 00:00:00";
$fechaFin="2016-06-05 23:59:59";
if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy)){
	//ENFERMERIA
	$carreras= "8";
}

$condicion =" and o.numeroordenpago=d.numeroordenpago
					and eg.idestudiantegeneral=e.idestudiantegeneral
						AND e.codigoestudiante=pr.codigoestudiante
						AND pr.codigoperiodo='".$rowperiodo["codigoperiodo"]."'
						AND e.codigoestudiante=o.codigoestudiante
						AND c.codigocarrera=e.codigocarrera
						AND d.codigoconcepto=co.codigoconcepto
						AND co.cuentaoperacionprincipal=151
						AND o.codigoperiodo='".$rowperiodo["codigoperiodo"]."'
						AND o.codigoestadoordenpago LIKE '4%'
						$condicion_aux2
						and c.codigomodalidadacademica in ($condicion_aux)
						and c.codigocarrera in(".$carreras.")
						and codigomodalidadacademica=200
						";


if($datosnombresegresado=$objetobase->recuperar_datos_tabla("ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr,estudiantegeneral eg","eg.idestudiantegeneral",$_GET['idusuario'],$condicion,'',0)) {
  $siga=1;

    $codigocarrera=$datosnombresegresado['codigocarrera'];
     $codigoestudiante=$datosnombresegresado['codigoestudiante'];
} else {
   $siga=0;
}


if($siga) {
$codigoperiodo="".$rowperiodo["codigoperiodo"];
$codigoestudiante=$datosnombresegresado['codigoestudiante'];
$objvalidaautoevaluacion=new ValidaEncuesta($objetobase,$codigoperiodo,$codigoestudiante);
if($objvalidaautoevaluacion->validaEncuestaCompleta()){
        alerta_javascript('Ha finalizado la evaluacion docente,\n Gracias por su colaboracion');

	$query_actualizaestado = "insert into actualizacionusuario (usuarioid, tipoactualizacion, id_instrumento, codigoperiodo, estadoactualizacion,userid,entrydate)
	values ('".$_SESSION['idusuariofinalentradaentrada']."',3,0,'$codigoperiodo',1,'".$_SESSION['idusuariofinalentradaentrada']."',now())";   
	$actualizaestado = $objetobase->conexion->query($query_actualizaestado);
	  /*if(isset($_GET['redir'])){
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../prematricula/matriculaautomaticaordenmatricula.php'>";
	  }*/	
	echo "<script type='text/javascript'> window.parent.continuar();</script>";

    }
	

	
 $query_selencuesta = "SELECT idencuesta
            FROM encuesta
            where now() between fechainicioencuesta and fechafinalencuesta
		and idencuesta = '".$_GET["idencuesta"]."'";
   

    $selencuesta = $objetobase->conexion->query($query_selencuesta);
    $totalRows_selencuesta = $selencuesta->numRows();    
        
            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../$url_encuesta?idencuesta=".$_GET["idencuesta"]."&idusuario=".$_GET["idusuario"]."&codigoestudiante=".$codigoestudiante."&codigotipousuario=".$_GET["codigotipousuario"]."&codigocarrera=$codigocarrera'>";
  
}

else {
	// SI PASA TODAS LAS VALIDACIONES LO REDIRECCIONA A LA ENCUESTA DE ING INDUSTRIAL
 	// echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../encuestaacreditacioningindustrialestudiantes20131/validaingresoestudiante.php?idusuario=".$_GET["idusuario"]."'>";

	// SI PASA TODAS LAS VALIDACIONES LO REDIRECCIONA A LA ENCUESTA DE PSICOLOGIA 
 	//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../../../uebevdoc/validaingresoestudiante.php?idusuario=".$_GET["idusuario"]."'>";

	// SI PARA TODAS LAS VALIDACIONES LO REDIRECCIONA AL INDEX NORMAL DESPUÉS DEL LOGUEO
	echo "<script type='text/javascript'> window.parent.continuar();</script>";
}

?>
