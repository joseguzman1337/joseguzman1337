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
//require_once("seleccionmateria.php");


unset($_SESSION['tmptipovotante']);
$fechahoy = date("Y-m-d H:i:s");

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
        <script type="text/javascript" src="funciones.js"></script>
        <script LANGUAGE="JavaScript">

        </script>
    </head>
    <body>
        <center>
        <?php

$
$_GET['idusuario']='74282602';
$formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true');
$objetobase = new BaseDeDatosGeneral($sala);

        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        echo "	<form id=\"form1\" name=\"form1\" action=\"\" method=\"post\"  enctype=\"multipart/form-data\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"" . $idencuestaaleatorio . "\">";

        $condicion = " idencuesta<=36";
        $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("encuesta e", "idencuesta", "nombreencuesta", $condicion);
        $formulario->filatmp[""] = "Seleccionar";
        $menu = "menu_fila";
        $parametrosmenu = "'idencuesta','" . $_POST["idencuesta"] . "','onchange=\'enviar();\''";
        $formulario->dibujar_campo($menu, $parametrosmenu, "Encuesta", "tdtitulogris", "idencuesta", "requerido");
        if(isset($_POST['idencuesta'])&&
        trim($_POST['idencuesta'])!=''){
        unset($formulario->filatmp);
        $formulario->filatmp["Si"] = "Si";
        $formulario->filatmp["No"] = "No";
        $formulario->filatmp[""] = "Seleccionar";

        $menu = "menu_fila";
        $parametrosmenu = "'muestrapestana','" . $_POST["muestrapestana"] . "','onchange=\'enviar();\''";
        $formulario->dibujar_campo($menu, $parametrosmenu, "Mostrar Pestañas", "tdtitulogris", "muestrapestana", "requerido");
        }

echo "</form></table>";

if(isset($_POST['idencuesta'])&&
        trim($_POST['idencuesta'])!=''){

$idencuesta = $_POST['idencuesta'];
$objvalidaautoevaluacion = new ValidaEncuesta($objetobase, '20102', '1');
$objvalidaautoevaluacion->setIdEncuesta($idencuesta);
$tabla = "respuestabienestar";
$objvalidaautoevaluacion->setTablaRespuesta($tabla);
/*
if(!$objvalidaautoevaluacion->encuentraEstudianteEncuestaBienestar($_GET['idusuario'])){
    echo "<script type='text/javascript'>parent.continuar();</script>";
}
//if($objvalidaautoevaluacion->encuestaCarreraActiva()){
$objvalidaautoevaluacion->setUsuario($_GET['idusuario']);
$preguntasfacultades=$objvalidaautoevaluacion->validaPreguntasFaltantes();
/*echo "<pre>";
print_r($preguntasfacultades);
echo "</pre>";*/
//if (!is_array($preguntasfacultades)||
//        (count($preguntasfacultades)<1)) {
//  // alerta_javascript('Ha finalizado la encuesta,\n Gracias por su colaboracion');
// echo "<script type='text/javascript'>parent.continuar();</script>";
//   //echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../educacioncontinuada/certificadoymemorias.php?documento=" . $datosasistente['documentoasistente'] . "&iddiploma=" . $datosasistente['iddiploma'] . "'>";
//}
//else{
//   // alerta_javascript('No ha finalizado la encuesta');
//}
//}
//if(isset($_POST["codigomateria"])&&$_POST["codigomateria"]!='') {
$objconsultaencuesta = new ConsultaEncuesta($objetobase, $formulario);

$objconsultaencuesta->setTablaRespuesta($tabla);
//$idusuarioencuesta=encuentrausuarioencuesta($codigoestudiante,$codigomateria);
$_SESSION["codigoestudiante_autoenfermeria"] = $_GET["codigoestudiante"];
$_SESSION["codigomateria_autoenfermeria"] = $_POST["codigomateria"];
$idusuarioencuesta = $_GET['idusuario'];
$objmostrarencuesta = new MostrarEncuesta($idusuarioencuesta, $objetobase, $formulario, $objconsultaencuesta);

/* $condicion=" now() between e.fechainicioencuesta and e.fechafinalencuesta";
  $condicion.=" and em.idencuesta=e.idencuesta and em.codigomateria='".$_POST["codigomateria"]."'";
  $datosencuestamateria=$objetobase->recuperar_datos_tabla("encuesta e,encuestamateria em","e.codigocarrera",8," and ".$condicion,"",0);
 */


//}

// seleccionmateria($_GET["codigoestudiante"],$objetobase,$formulario,$_SESSION["codigoperiodo_autoenfermeria"]);
//if(isset($_POST["codigomateria"])&&$_POST["codigomateria"]!='') {
      //  echo "<br>mostrarTitulosEncuesta 1 " . date("Y-m-d H:i:s");
        $objmostrarencuesta->setIdEncuesta($idencuesta);
        //echo "<br>mostrarTitulosEncuesta 2 " . date("Y-m-d H:i:s");
        $objmostrarencuesta->iniciarEncuestaUsuario();
        //echo "<H1>CONTADOR=".$objmostrarencuesta->objconsultaencuesta->contadoramaarbol."</H1>";
        //echo "<br>mostrarTitulosEncuesta 3 " . date("Y-m-d H:i:s");
        $objmostrarencuesta->mostrarTitulosEncuesta();

        $filaadicional["codigoestudiante"] = $_SESSION["codigoestudiante_autoenfermeria"];
        $filaadicional["codigomateria"] = $_SESSION["codigomateria_autoenfermeria"];
        $filaadicional["codigoperiodo"] = $_SESSION["codigoperiodo_autoenfermeria"];
        //$mensajeninicial = "Califique las siguientes preguntas relacionadas al evento realizado";
        $mensajeninicial = "";

        echo "	<form id=\"form1\" name=\"form1\" action=\"\" method=\"post\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"" . $objmostrarencuesta->idencuesta . "\">";

      //  echo "<br>mostrarTitulosEncuesta 4 " . date("Y-m-d H:i:s");

        $objmostrarencuesta->imprimirEncuesta($mensajeninicial);

      //  $objmostrarencuesta->ingresarTotalPreguntas($tabla, $filaadicional);

        $formulario->boton_tipo("hidden", "codigomateria", $_POST["codigomateria"]);
        echo "</form>";
        $mensajeexito = "Ha sido para nosotros muy importante su colaboración. \\nGracias, \\nCOMITÉ ORGANIZADOR.";
        $mensajefalta = "No puede continuar hasta que diligencie toda la encuesta";
        $direccionexito = "encuestabienestar.php?idusuario=" . $_GET['idusuario'];
        $direccionfalta = "encuestabienestar.php?idusuario=" . $_GET['idusuario'];
       // $objmostrarencuesta->guardarEncuesta($tabla,$filaadicional);
	//$formulario=$objmostrarencuesta->getFormulario();
        //$objvalidaautoevaluacion->mensajeValidaEncuesta($mensajeexito, $mensajefalta,$direccionexito, $direccionfalta,$formulario);
if($_POST["muestrapestana"]=="Si"){
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
            <?php

}
?>

    </center>
    </body>
</html>
<?php

}
?>
