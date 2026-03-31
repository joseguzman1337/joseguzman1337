<?php
session_start();
$rutaado = ("../../../funciones/adodb/");

require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/encuesta/MostrarEncuesta.php");
require_once("../../../funciones/sala_genericas/encuesta/ConsultaEncuesta.php");
require_once("../../../funciones/sala_genericas/encuesta/ValidaEncuesta.php");
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

        <?php
        $formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true');
        $objetobase = new BaseDeDatosGeneral($sala);

        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        echo "	<form id=\"formescogemateria\" name=\"formescogemateria\" action=\"listadoestudiantediligenciado.php\" method=\"post\"  enctype=\"multipart/form-data\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"" . $idencuestaaleatorio . "\">";
        $usuario = $formulario->datos_usuario();
        if ($usuario["idusuario"] == 4186) {
            //if(1) {
            //codigomodalidadacademica='".$_SESSION['admisiones_codigomodalidadacademica']."'
            $condicion = "now()  between fechainiciocarrera and fechavencimientocarrera
                and codigomodalidadacademica like '2%'
			order by nombrecarrera2";
            $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("carrera c", "codigocarrera", "nombrecarrera", $condicion, " , replace(c.nombrecarrera,' ','') nombrecarrera2", 0);
            $formulario->filatmp[""] = "Seleccionar";
        } else {
            $condicion = " c.codigocarrera=uf.codigofacultad
					and u.idusuario='" . $usuario["idusuario"] . "'
					and uf.usuario=u.usuario
					and now()  between fechainiciocarrera and fechavencimientocarrera
					order by nombrecarrera2";
            $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("carrera c, usuariofacultad uf, usuario u", "c.codigocarrera", "c.nombrecarrera", $condicion, " , replace(c.nombrecarrera,' ','') nombrecarrera2", 0);
            $formulario->filatmp[""] = "Seleccionar";
        }
        $formulario->dibujar_fila_titulo('Listado Estudiantes Evaluacion Docente', 'labelresaltado', "2", "align='center'");

        $menu = "menu_fila";
        $parametrosmenu = "'codigocarrera','" . $_POST['codigocarrera'] . "','onchange=\'enviar();\''";
        $formulario->dibujar_campo($menu, $parametrosmenu, "Carrera", "tdtitulogris", "codigocarrera", "requerido");

        $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("periodo", "codigoperiodo", "codigoperiodo", "codigoperiodo=codigoperiodo order by codigoperiodo desc");
        $codigoperiodo = $_SESSION['codigoperiodosesion'];
        if (isset($_POST['codigoperiodo']))
            $codigoperiodo = $_POST['codigoperiodo'];
        if (isset($_GET['codigoperiodo']))
            $codigoperiodo = $_GET['codigoperiodo'];
        $campo = 'menu_fila';
        $parametros = "'codigoperiodo','" . $codigoperiodo . "',''";
        $formulario->dibujar_campo($campo, $parametros, "Periodo", "tdtitulogris", 'codigoperiodo', '');

        $parametrosmenu = "'submit','Enviar','Enviar',''";
        $formulario->dibujar_campo("boton_tipo", $parametrosmenu, "Enviar", "tdtitulogris", "enviar", "");

        echo "</form></table>";
        ?>
    </body>
</html>