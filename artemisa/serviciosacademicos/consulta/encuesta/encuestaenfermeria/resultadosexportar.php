<?php
session_start();
$rutaado=("../../../funciones/adodb/");

require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/encuesta/MostrarEncuesta.php");
require_once("../../../funciones/sala_genericas/encuesta/ConsultaEncuesta.php");
require_once("../../../funciones/sala_genericas/encuesta/ValidaEncuesta.php");
require_once("selecciongrupo.php");
unset($_SESSION['tmptipovotante']);
unset($_SESSION['tmptipovotante']);
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true',
        'Los campos marcados con *, no han sido correctamente diligenciados:\n\n',
        "",
        false,
        "../../../../",
        0);
$objetobase=new BaseDeDatosGeneral($sala);
$_SESSION["codigoperiodo_autoenfermeria"]=$_SESSION['codigoperiodosesion'];
$objvalidaautoevaluacion=new ValidaEncuesta($objetobase,$_SESSION["codigoperiodo_autoenfermeria"],$_GET['codigoestudiante']);
if($objvalidaautoevaluacion->encuestaCarreraActiva()) {
    if($objvalidaautoevaluacion->validaEncuestaCompleta()) {
        alerta_javascript('Ha finalizado la evaluacion docente,\n Gracias por su colaboracion');
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../prematricula/matriculaautomaticaordenmatricula.php'>";
    }
}
if(isset($_POST["iddocente"])&&$_POST["iddocente"]!='') {
    $objconsultaencuesta=new ConsultaEncuesta($objetobase,$formulario);
     if($_POST["codigoperiodo"]<'20131'){
    $tabla="respuestaautoevaluacion_2012anteriores";
    }
    else{
    $tabla="respuestaautoevaluacion";
    }
    $objconsultaencuesta->setTablaRespuesta($tabla);
//$idusuarioencuesta=encuentrausuarioencuesta($codigoestudiante,$codigomateria);
    // $_SESSION["codigoestudiante_autoenfermeria"]=$_GET["codigoestudiante"];
    $_SESSION["idgrupo_autoenfermeria"]=$_POST["idgrupo"];


    // $idusuarioencuesta=$_GET["codigoestudiante"]."_".$_POST["codigomateria"]."_".$_SESSION["codigoperiodo_autoenfermeria"];
    $idusuarioencuesta="";
    $objmostrarencuesta=new MostrarEncuesta($idusuarioencuesta,$objetobase,$formulario,$objconsultaencuesta);
   // $condicion=" now() between e.fechainicioencuesta and e.fechafinalencuesta";
    $condicion.=" em.idencuesta=e.idencuesta ";
    $datosencuestamateria=$objetobase->recuperar_datos_tabla("encuesta e,encuestamateria em","em.codigomateria",$_POST["codigomateria"]," and ".$condicion,"",0);
    $idencuesta=$datosencuestamateria["idencuesta"];
}

$strType = 'application/x-msdownload';
$strName = "resultadosencuesta.xls";
header("Content-Type: $strType");
header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Pragma: public");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">

    </head>
    <body>
        <?php

         selecciongrupo($objetobase,$formulario,$_SESSION["codigoperiodo_autoenfermeria"]);
        if(isset($_POST["iddocente"])&&$_POST["iddocente"]!='') {
            $objmostrarencuesta->setIdEncuesta($idencuesta);
            $objmostrarencuesta->iniciarEncuestaUsuario();
            $objmostrarencuesta->mostrarTitulosEncuesta();

            $filaadicional["codigoestudiante"]=$_SESSION["codigoestudiante_autoenfermeria"];
            $filaadicional["codigomateria"]=$_SESSION["codigomateria_autoenfermeria"];
            $filaadicional["codigoperiodo"]=$_POST["codigoperiodo"];
            $mensajeninicial="Califique de 1 a 5 las siguientes preguntas relacionadas a la evaluacion de su asignatura";
            echo "  <form id=\"form1\" name=\"form1\" action=\"\" method=\"post\"  >
        <input type=\"hidden\" name=\"AnularOK\" value=\"\">
        <input type=\"hidden\" name=\"idencuesta\" value=\"".$objmostrarencuesta->idencuesta."\">";

            $cadenaparametros="dp.idprematricula=pr.idprematricula and
pr.codigoestudiante=r.codigoestudiante and
pr.codigoperiodo=r.codigoperiodo and
r.codigomateria=dp.codigomateria and
r.codigoperiodo='".$_POST["codigoperiodo"]."' and
g.idgrupo=dp.idgrupo and
g.numerodocumento=d.numerodocumento and
g.codigoperiodo='".$_POST["codigoperiodo"]."' and
g.codigomateria='".$_POST["codigomateria"]."' and
d.iddocente='".$_POST["iddocente"]."' and ";

            $tablasadicionales=",prematricula pr, detalleprematricula dp,grupo g,docente d";

            $objmostrarencuesta->imprimirResultadosEncuesta($mensajeninicial,$cadenaparametros,$tablasadicionales);
            // $objmostrarencuesta->ingresarTotalPreguntas($tabla,$filaadicional);

            $formulario->boton_tipo("hidden", "codigomateria", $_POST["codigomateria"]);
            echo "</form>";
            $mensajeexito="Asignatura Evaluada,\n sus respuestas son utiles para el mejoramiento de nuestra Institución .";
            $mensajefalta="No puede continuar hasta que diligencie toda la encuesta";
            $direccionexito="encuestaenfermeria.php?codigoestudiante=".$_GET["codigoestudiante"];
            $direccionfalta="encuestaenfermeria.php?codigoestudiante=".$_GET["codigoestudiante"];

        }
        ?>

    </body>
</html>