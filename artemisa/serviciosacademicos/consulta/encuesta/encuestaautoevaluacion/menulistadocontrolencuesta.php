<?php
session_start();
//require_once('../../../funciones/clases/autenticacion/redirect.php' );
//$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado = ("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
//require_once("../../../funciones/phpmailer/class.phpmailer.php");
//require_once("../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once('../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once('../../../funciones/sala_genericas/FuncionesMatematica.php');
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/Excel/reader.php");
//require_once("cargaarchivoencuesta.php");
if (isset($_GET['tipoentrada']) && trim($_GET['tipoentrada']) != '') {
    $_SESSION["tipoentradasesionencuesta"] = 1;
}
$fechahoy = date("Y-m-d H:i:s");
$formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true');
$objetobase = new BaseDeDatosGeneral($sala);
if (isset($_POST["Enviar"])) {
    //$_FILES
    //$HTTP_POST_FILES
    cargaarchivoencuesta($_FILES, $_POST, $objetobase);
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
        <?php
        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        echo "	<form id=\"form1\" name=\"form1\" action=\"listadocontrolencuesta.php\" method=\"post\"  enctype=\"multipart/form-data\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"" . $idencuestaaleatorio . "\">";

        $formulario->dibujar_fila_titulo('Entrada de encuesta', 'labelresaltado', "2", "align='center'");
        $condicion = " now() between e.fechainicioencuesta and e.fechafinalencuesta";
        $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("encuesta e", "idencuesta", "nombreencuesta", $condicion,"",1);
        $formulario->filatmp[""] = "Seleccionar";
        $menu = "menu_fila";
        $parametrosmenu = "'idencuesta','" . $_POST["idencuesta"] . "',''";
        $formulario->dibujar_campo($menu, $parametrosmenu, "Encuesta", "tdtitulogris", "idencuesta", "requerido");


        unset($formulario->filatmp);

        $formulario->filatmp["respuestainstitucional"] = "respuestainstitucional";
        $formulario->filatmp["respuestabienestarinduccion"] = "respuestabienestarinduccion";
        $formulario->filatmp[""] = "Seleccionar";
        $menu = "menu_fila";
        $parametrosmenu = "'tablarespuesta','" . $_POST["tablarespuesta"] . "',''";
        $formulario->dibujar_campo($menu, $parametrosmenu, "Encuesta", "tdtitulogris", "tablarespuesta", "requerido");


      /*  $menu = "boton_tipo";
        $parametrosmenu = "'text','nombretablarespuesta','" . $_POST["nombretablarespuesta"] . "'";
        $formulario->dibujar_campo($menu, $parametrosmenu, "Tabla respuesta", "tdtitulogris", "nombretablarespuesta", "requerido");
*/

        $conboton = 0;
        $parametrobotonenviar[$conboton] = "'submit','Enviar','Enviar','onClick=\"return enviarpagina();\"'";
        $boton[$conboton] = 'boton_tipo';
        $conboton++;
        $formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar', '');
        echo "</form>";
        echo "</table>";
        ?>
    <br><br>
    <table  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
        <?php $formulario->dibujar_fila_titulo('Columnas Archivo', 'labelresaltado', "4", "align='center'"); ?>
        <tr><td><b>No</b></td><td><b>Pregunta</b></td><td><b>Tipo pregunta</b></td><td><b>No de grupo</b></td></tr></table>