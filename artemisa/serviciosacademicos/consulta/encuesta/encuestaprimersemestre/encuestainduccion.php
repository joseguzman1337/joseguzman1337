<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();

$rutaado = ("../../../funciones/adodb/");

require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/encuestav2/MostrarEncuesta.php");
require_once("../../../funciones/sala_genericas/encuestav2/ConsultaEncuesta.php");
require_once("../../../funciones/sala_genericas/encuestav2/ValidaEncuesta.php");
//require_once("seleccionmateria.php");


unset($_SESSION['tmptipovotante']);
$fechahoy = date("Y-m-d H:i:s");
$idencuesta = "70";
//$_GET['idusuario']='74282602';

$codigoperiodo="20122";
$formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true');
$objetobase = new BaseDeDatosGeneral($sala);
$objvalidaautoevaluacion = new ValidaEncuesta($objetobase, '20122', '1');
$objvalidaautoevaluacion->setIdEncuesta($idencuesta);
$tabla = "respuestabienestarinduccion";
$objvalidaautoevaluacion->setTablaRespuesta($tabla);


$objvalidaautoevaluacion->setUsuario($_GET['idusuario']);
$preguntasfacultades=$objvalidaautoevaluacion->validaPreguntasFaltantes();

if (!is_array($preguntasfacultades)||
        (count($preguntasfacultades)<1)) {
   alerta_javascript('Ha finalizado la encuesta,\n Gracias por su colaboracion');
 echo "<script type='text/javascript'>parent.continuar();</script>";
   }
else{
   
}

$objconsultaencuesta = new ConsultaEncuesta($objetobase, $formulario);

$objconsultaencuesta->setTablaRespuesta($tabla);
$_SESSION["codigoestudiante_autoenfermeria"] = $_GET["codigoestudiante"];
$_SESSION["codigomateria_autoenfermeria"] = $_POST["codigomateria"];
$idusuarioencuesta = $_GET['idusuario'];
$objmostrarencuesta = new MostrarEncuesta($idusuarioencuesta, $objetobase, $formulario, $objconsultaencuesta);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>

        <link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
        <script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
        <style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
        <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
        <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
        <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
        <script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
        <link rel="stylesheet" href="../../../funciones/sala_genericas/ajax/tab/css/tab-view.css" type="text/css" media="screen">
        <script type="text/javascript" src="../../../funciones/sala_genericas/ajax/tab/js/ajax.js"></script>


        <script type="text/javascript" src="../../../funciones/sala_genericas/ajax/tab/js/tab-view.js"></script>
        <script type="text/javascript" src="../../../funciones/sala_genericas/ajax/requestxml.js"></script>
        <script type="text/javascript" src="funcionesinduccion.js"></script>
        <script LANGUAGE="JavaScript">

        </script>
    </head>
    <body>
        <center>
        <?php

       
        $objmostrarencuesta->setIdEncuesta($idencuesta);
        
        $objmostrarencuesta->iniciarEncuestaUsuario();
        
        $arraytitulos[]["descripcion"]=$objmostrarencuesta->datosencuesta["descripcionencuesta"];
        $objmostrarencuesta->setTitulosEncuesta($arraytitulos);
        $objmostrarencuesta->mostrarTitulosEncuesta();
        

       
        $filaadicional["codigoperiodo"] = $codigoperiodo;
        $mensajeninicial = "";

        echo "	<form id=\"form1\" name=\"form1\" action=\"\" method=\"post\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"" . $objmostrarencuesta->idencuesta . "\">";

      //  echo "<br>mostrarTitulosEncuesta 4 " . date("Y-m-d H:i:s");

        $objmostrarencuesta->imprimirEncuesta($mensajeninicial);
$condicionactualizaadicion=" and codigoperiodo='".$filaadicional["codigoperiodo"]."'";
        $objmostrarencuesta->ingresarTotalPreguntas($tabla, $filaadicional,$condicionactualizaadicion);

        $formulario->boton_tipo("hidden", "codigomateria", $_POST["codigomateria"]);
        echo "</form>";
        $mensajeexito = "Ha sido para nosotros muy importante su colaboraci�n. \\nGracias, \\nCOMIT� ORGANIZADOR.";
        $mensajefalta = "No puede continuar hasta que diligencie toda la encuesta";
        $direccionexito = "encuestainduccion.php?idusuario=" . $_GET['idusuario'];
        $direccionfalta = "encuestainduccion.php?idusuario=" . $_GET['idusuario'];
        $objmostrarencuesta->guardarEncuesta($tabla,$filaadicional);
	$formulario=$objmostrarencuesta->getFormulario();
        $objvalidaautoevaluacion->mensajeValidaEncuesta($mensajeexito, $mensajefalta,$direccionexito, $direccionfalta,$formulario);

        ?>
        <script type="text/javascript">
            var pathruta='../../../funciones/sala_genericas/ajax/tab/';
<?php

        $cadena = "var arraypestanas=Array(";
        $con = 0;
        if (is_array($objmostrarencuesta->arraytitulospestanas))
            foreach ($objmostrarencuesta->arraytitulospestanas as $i => $row) {
                //trim(sacarpalabras(str_replace("de","",str_replace("y","",$row["nombre"])),0,1))

                if ($con == 0)
                    $cadena.="'" . substr($objconsultaencuesta->numeracionpestana[$con] . ". " . $row["nombre"], 0, 13) . "...'";
                else
                    $cadena.=",'" . substr($objconsultaencuesta->numeracionpestana[$con] . ". " . $row["nombre"], 0, 13) . "...'";

                $con++;
            }
        $cadena.= ");\n";
        echo $cadena;
?>
    initTabs('formularioencuesta',arraypestanas,0,760,400);

    function cambiapestana(pestana){
        //alert("pestana="+pestana);
        //initTabs('formulariohorario',arraypestanas,pestana,760,400);
        showTab('formularioencuesta',pestana);
        return false;
    }

        </script>
    </center>
    </body>
</html>

