<?php
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se incluye el instrumento de configuracion con sus respectivos datos y clases para que muestre tambien las respuestas.
 * @since Abril 4, 2019
 */
session_start();
$rutaado = ("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/encuestav3/MostrarEncuesta.php");
require_once("../../../funciones/sala_genericas/encuestav3/ConsultaEncuesta.php");
require_once("../../../funciones/sala_genericas/encuestav3/MostrarEncuestaInstrumento.php");
require_once("../../../funciones/sala_genericas/encuestav3/ConsultaEncuestaInstrumento.php");
require_once("../../../funciones/sala_genericas/encuestav3/ValidaEncuesta.php");
require_once("selecciongrupo.php");

require('../../../../kint/Kint.class.php');

unset($_SESSION['tmptipovotante']);
$fechahoy = date("Y-m-d H:i:s");
$formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true', 'Los campos marcados con *, no han sido correctamente diligenciados:\n\n', "", false, "../../../../", 0);
$objetobase = new BaseDeDatosGeneral($sala);
$_SESSION["codigoperiodo_autoenfermeria"] = $_SESSION['codigoperiodosesion'];

if (isset($_GET['codigoestudiante']) && !empty($_GET['codigoestudiante'])) {
    $objvalidaautoevaluacion = new ValidaEncuesta($objetobase, $_SESSION["codigoperiodo_autoenfermeria"], $_GET['codigoestudiante']);
}

$iddocgru = explode('**', $_POST["iddocgru"]);
$_POST["iddocente"] = $iddocgru[0];
$_POST["idgrupo"] = $iddocgru[1];

if (isset($_POST["iddocente"]) && $_POST["iddocente"] != '') {
    $objconsultaencuesta = new ConsultaEncuesta($objetobase, $formulario);

    $objconsultaencuestainstrumento = new ConsultaEncuestaInstrumento($objetobase, $formulario);
    if ($_POST["codigoperiodo"] < '20131') {
        $tabla = "respuestaautoevaluacion_2012anteriores";
    } else {
        //Validacion de parametro id instrumento diferente a vacia, para existencia de instrumentos.
        if ($_POST['idinstrumento'] != '') {
            $tabla = "siq_Apreguntarespuesta";
            $objconsultaencuestainstrumento->setTablaRespuesta($tabla);
        } else {
            $tabla = "respuestaautoevaluacion";
            $objconsultaencuesta->setTablaRespuesta($tabla);
        }
    }

    $_SESSION["idgrupo_autoenfermeria"] = $_POST["idgrupo"];

    $idusuarioencuesta = "";

    if ($_POST['idinstrumento'] != '') {
        $objmostrarencuestainstrumento = new MostrarEncuestaInstrumento($idusuarioencuesta, $objetobase, $formulario, $objconsultaencuestainstrumento);
    } else {
        $objmostrarencuesta = new MostrarEncuesta($idusuarioencuesta, $objetobase, $formulario, $objconsultaencuesta);
        $condicion .= " em.idencuesta=e.idencuesta ";
        $datosencuestamateria = $objetobase->recuperar_datos_tabla("encuesta e,encuestamateria em", "em.codigomateria", $_POST["codigomateria"], " and " . $condicion, "", 0);
        $idencuesta = $datosencuestamateria["idencuesta"];
    }
}
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
        <script LANGUAGE="JavaScript">
            function enviarrespuesta(obj, idpregunta, idusuario, idencuesta) {
                var params = "idpregunta=" + idpregunta + "&idusuario=" + idusuario + "&idencuesta=" + idencuesta + "&valorrespuesta=" + obj.value;
                process("actualizarencuestaenfermeria.php", params);
                return true;
            }

            function enviar() {
                var formulario = document.getElementById("formescogemateria");
                formulario.action = "resultadosenfermeria.php";
                formulario.submit();
            }
            function enviarmateria() {
                var formulario = document.getElementById("formescogemateria");
                var grupo = document.getElementById("iddocgru");
                formulario.action = "resultadosenfermeria.php";
                grupo.value = "";
                formulario.submit();
            }
            function enviarexportar() {
                var formulario = document.getElementById("formescogemateria");
                formulario.action = "resultadosexportar.php";
                formulario.submit();
            }
        </script>
    </head>
    <body>
        <?php
        selecciongrupo($objetobase, $formulario, $_SESSION["codigoperiodo_autoenfermeria"]);
        if (isset($_POST["iddocente"]) && $_POST["iddocente"] != '') {
            //Validacion de parametro id instrumento diferente a vacia, para existencia de instrumentos.
            if ($_POST['idinstrumento'] != '') {
                $objmostrarencuestainstrumento->setIdInstrumento($idinstrumento);
                $objmostrarencuestainstrumento->iniciarEncuestaUsuario();
                $objmostrarencuestainstrumento->mostrarTitulosEncuesta();
            } else {
                $objmostrarencuesta->setIdEncuesta($idencuesta);
                $objmostrarencuesta->iniciarEncuestaUsuario();
                $objmostrarencuesta->mostrarTitulosEncuesta();
            }
            $filaadicional["codigoestudiante"] = $_SESSION["codigoestudiante_autoenfermeria"];
            $filaadicional["codigomateria"] = $_SESSION["codigomateria_autoenfermeria"];
            $filaadicional["codigoperiodo"] = $_POST["codigoperiodo"];
            $mensajeninicial = "Califique de 1 a 5 las siguientes preguntas relacionadas a la evaluacion de su asignatura";
            echo "	<form id=\"form1\" name=\"form1\" action=\"\" method=\"post\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"" . $objmostrarencuesta->idencuesta . "\">";

            if ($_POST['idinstrumento'] != '') {
                $cadenaparametros = "AND sri.idgrupo = '" . $_POST['idgrupo'] . "'  AND sri.codigoestado = 100";
                $tablasadicionales = "LEFT JOIN siq_Apreguntarespuesta spr ON (sri.idsiq_Apreguntarespuesta = spr.idsiq_Apreguntarespuesta)";
                $objmostrarencuestainstrumento->imprimirResultadosEncuesta($mensajeninicial, $cadenaparametros, $tablasadicionales);
            } else {
                $cadenaparametros = "dp.idprematricula=pr.idprematricula and
                pr.codigoestudiante=r.codigoestudiante and
                pr.codigoperiodo=r.codigoperiodo and
                r.codigomateria=dp.codigomateria and
                r.codigoperiodo='" . $_POST["codigoperiodo"] . "' and
                g.idgrupo=dp.idgrupo and
                g.numerodocumento=d.numerodocumento and
                g.codigoperiodo='" . $_POST["codigoperiodo"] . "' and
                g.codigomateria='" . $_POST["codigomateria"] . "' and
                d.iddocente='" . $_POST["iddocente"] . "'   ";
                $tablasadicionales = ",prematricula pr, detalleprematricula dp,grupo g,docente d";
                $objmostrarencuesta->imprimirResultadosEncuesta($mensajeninicial, $cadenaparametros, $tablasadicionales);
            }
            $formulario->boton_tipo("hidden", "codigomateria", $_POST["codigomateria"]);
            echo "</form>";
            $mensajeexito = "Asignatura Evaluada,\n sus respuestas son utiles para el mejoramiento de nuestra Institución .";
            $mensajefalta = "No puede continuar hasta que diligencie toda la encuesta";
            $direccionexito = "encuestaenfermeria.php?codigoestudiante=" . $_GET["codigoestudiante"];
            $direccionfalta = "encuestaenfermeria.php?codigoestudiante=" . $_GET["codigoestudiante"];
        }
        ?>
        <script type="text/javascript">
            var pathruta = '../../../funciones/sala_genericas/ajax/tab/';
<?php
//Validacion de variable id instrumento diferente a vacia, para existencia de instrumentos.
if ($_POST['idinstrumento'] != '') {
    $objmuestraencuesta = $objmostrarencuestainstrumento->arraytitulospestanas;
    $sizeheight = 800;
} else {
    $objmuestraencuesta = $objmostrarencuesta->arraytitulospestanas;
    $sizeheight = 400;
}
$cadena = "var arraypestanas=Array(";
$con = 0;
if (is_array($objmuestraencuesta))
    foreach ($objmuestraencuesta as $i => $row) {

        if ($con == 0)
            $cadena .= "'" . substr(($con + 1) . ". " . $row["nombre"], 0, 13) . "...'";
        else
            $cadena .= ",'" . substr(($con + 1) . ". " . $row["nombre"], 0, 13) . "...'";

        $con++;
    }
$cadena .= ");\n";
echo $cadena;
?>
            initTabs('formularioencuesta', arraypestanas, 0, 760, <?php echo $sizeheight; ?>);

            function cambiapestana(pestana) {
                showTab('formularioencuesta', pestana);
                return false;
            }

        </script>

    </body>
</html>

