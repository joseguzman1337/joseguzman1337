<?php
session_start();
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
require_once("selecciongrupo.php");
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
            function enviarrespuesta(obj,idpregunta,idusuario,idencuesta){
                var params="idpregunta="+idpregunta+"&idusuario="+idusuario+"&idencuesta="+idencuesta+"&valorrespuesta="+obj.value;
                //process("../../../funciones/sala_genericas/encuesta/actualizarespuestapregunta.php",params);
                process("actualizarencuestaenfermeria.php",params);
                //alert("actualizarespuestapregunta.php?"+params);
                return true;
            }

            function enviar(){
                //alert(pagina);

                var formulario=document.getElementById("formescogemateria");
                formulario.action="resultadosestudiantespostgrado.php";
                //formulario.action="encuestaenfermeria.php";
                //alert(formulario.action);
                formulario.submit();
                //return false;
            }
            function enviarmateria(){
                //alert(pagina);

                var formulario=document.getElementById("formescogemateria");
                var grupo=document.getElementById("iddocente");
                formulario.action="resultadosestudiantespostgrado.php";
                grupo.value="";
                //formulario.action="encuestaenfermeria.php";
                //alert(formulario.action);
                formulario.submit();
                //return false;
            }
            function enviarexportar(){
                //alert(pagina);

                var formulario=document.getElementById("formescogemateria");
                formulario.action="resultadosexportar.php";
                //alert(formulario.action);
                formulario.submit();
                //return false;
            }


            //open("../seguridad.html" , "ventana1" , "width=290,height=200,scrollbars=NO");
            //quitarFrame()
        </script>
    </head>
    <body>
<?php
//selecciongrupo($objetobase,$formulario,$_SESSION["codigoperiodo_autoenfermeria"]);
// if(isset($_POST["iddocente"])&&$_POST["iddocente"]!='') {
$_SESSION["codigoperiodosesion"]="20122";
$codigoperiodo=$_SESSION["codigoperiodosesion"];
unset($_SESSION['tmptipovotante']);
$fechahoy = date("Y-m-d H:i:s");
$formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true',
                'Los campos marcados con *, no han sido correctamente diligenciados:\n\n',
                "",
                false,
                "../../../../",
                0);
$objetobase = new BaseDeDatosGeneral($sala);
$_SESSION["codigoperiodo_autoenfermeria"] = $_SESSION['codigoperiodosesion'];
/* $objvalidaautoevaluacion=new ValidaEncuesta($objetobase,$_SESSION["codigoperiodo_autoenfermeria"],$_GET['codigoestudiante']);
  if($objvalidaautoevaluacion->encuestaCarreraActiva()) {
  if($objvalidaautoevaluacion->validaEncuestaCompleta()) {
  alerta_javascript('Ha finalizado la evaluacion docente,\n Gracias por su colaboracion');
  echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../prematricula/matriculaautomaticaordenmatricula.php'>";
  }
  } */

//if(isset($_POST["iddocente"])&&$_POST["iddocente"]!='') {
$objconsultaencuesta = new ConsultaEncuesta($objetobase, $formulario);
$tabla = "respuestaestudiantesposgrado20122";
$objconsultaencuesta->funcionrespuestapregunta = "cantidadRespuestasPreguntaGenerica";
$objconsultaencuesta->funcionobservacionrespuestas = "observacionRespuestasPreguntaGenerica";
$objconsultaencuesta->setAplicaPreguntas(1);
$objconsultaencuesta->setTablaRespuesta($tabla);
$condicion=" and pc.idpregunta=p.idpregunta and (pc.codigocarrera ='".$_POST["codigocarrera"]."' or pc.codigocarrera=1)";
$objconsultaencuesta->setCondicionAdicional($condicion);
$objconsultaencuesta->setTablaAdicional(",preguntacarrera pc");
$objconsultaencuesta->setTablaRespuesta($tabla);
 $objconsultaencuesta->resultadoNumerico();
//$idusuarioencuesta=encuentrausuarioencuesta($codigoestudiante,$codigomateria);
// $_SESSION["codigoestudiante_autoenfermeria"]=$_GET["codigoestudiante"];
$_SESSION["idgrupo_autoenfermeria"] = $_POST["idgrupo"];


// $idusuarioencuesta=$_GET["codigoestudiante"]."_".$_POST["codigomateria"]."_".$_SESSION["codigoperiodo_autoenfermeria"];
$idusuarioencuesta = "";
$objmostrarencuesta = new MostrarEncuesta($idusuarioencuesta, $objetobase, $formulario, $objconsultaencuesta);
//$condicion=" now() between e.fechainicioencuesta and e.fechafinalencuesta";
// $condicion.=" em.idencuesta=e.idencuesta and em.codigomateria='".$_POST["codigomateria"]."'";
// $datosencuestamateria=$objetobase->recuperar_datos_tabla("encuesta e,encuestamateria em","e.codigocarrera",8," and ".$condicion,"",0);
// $objmostrarencuesta->se
$idencuesta = '68';
//}
seleccionCarrera($objetobase,$formulario,$codigoperiodo);
if(isset($_POST["codigocarrera"])&&
        $_POST["codigocarrera"]!=''){


$objmostrarencuesta->setIdEncuesta($idencuesta);
$objmostrarencuesta->iniciarEncuestaUsuario();
//exit();
$objmostrarencuesta->mostrarTitulosEncuesta();

/* $filaadicional["codigoestudiante"]=$_SESSION["codigoestudiante_autoenfermeria"];
  $filaadicional["codigomateria"]=$_SESSION["codigomateria_autoenfermeria"];
  $filaadicional["codigoperiodo"]=$_SESSION["codigoperiodo_autoenfermeria"]; */
$mensajeninicial = "Califique de 1 a 5 las siguientes preguntas relacionadas a la evaluacion de su asignatura";
echo "	<form id=\"form1\" name=\"form1\" action=\"\" method=\"post\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"" . $objmostrarencuesta->idencuesta . "\">";

$cadenaparametros = " r.codigocarrera='".$_POST["codigocarrera"]."'".
" and r.codigoperiodo='".$codigoperiodo."' and ";

$tablasadicionales = "";

$objmostrarencuesta->imprimirResultadosEncuestaV2($mensajeninicial, $cadenaparametros, $tablasadicionales);
// $objmostrarencuesta->ingresarTotalPreguntas($tabla,$filaadicional);

$formulario->boton_tipo("hidden", "codigomateria", $_POST["codigomateria"]);
echo "</form>";
$mensajeexito = "Asignatura Evaluada,\n sus respuestas son utiles para el mejoramiento de nuestra Institución .";
$mensajefalta = "No puede continuar hasta que diligencie toda la encuesta";
$direccionexito = "encuestaenfermeria.php?codigoestudiante=" . $_GET["codigoestudiante"];
$direccionfalta = "encuestaenfermeria.php?codigoestudiante=" . $_GET["codigoestudiante"];

//$objmostrarencuesta->guardarEncuesta($mensajeexito, $mensajefalta, $direccionexito, $direccionfalta,$tabla,$filaadicional);
}
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
                    $cadena.="'" . substr(($con + 1) . ". " . $row["nombre"], 0, 13) . "...'";
                else
                    $cadena.=",'" . substr(($con + 1) . ". " . $row["nombre"], 0, 13) . "...'";

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

    </body>
</html>
