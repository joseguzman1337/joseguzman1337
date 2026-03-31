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
$fechahoy = date("Y-m-d H:i:s");
$formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true');
$objetobase = new BaseDeDatosGeneral($sala);
$datosusuario = $formulario->datos_usuario();
if (validaUsuarioMenuOpcion("319", $formulario, $objetobase)) {
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
        echo "	<form id=\"form1\" name=\"form1\" action=\"\" method=\"post\"  enctype=\"multipart/form-data\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"" . $idencuestaaleatorio . "\">";

        $formulario->dibujar_fila_titulo('Desbloqueo Deudas', 'labelresaltado', "2", "align='center'");

        $menu = "boton_tipo";
        $parametro = "'textfield','numerodocumento','" . $_POST['numerodocumento'] . "'";
        $formulario->dibujar_campo($menu, $parametro, "Documento ", "tdtitulogris", "numerodocumento", "requerido");



        $conboton = 0;
        $parametrobotonenviar[$conboton] = "'submit','Buscar','Buscar','onClick=\"return enviarpagina();\"'";
        $boton[$conboton] = 'boton_tipo';
        $conboton++;
        $formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar', '');
        echo "</form>";
        echo "</table>";

        if (isset($_REQUEST["Buscar"])) {
            echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
            echo "	<form id=\"form1\" name=\"form1\" action=\"\" method=\"post\"  enctype=\"multipart/form-data\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"" . $idencuestaaleatorio . "\">";
unset($formulario->filatmp);
	$formulario->filatmp["1"]="1";
	$formulario->filatmp["2"]="2";
        $formulario->filatmp["3"]="3";
	$campo='menu_fila'; $parametros="'diasdesbloqueodeudasestudiante','2','onchange=enviarmenu();'";
	$formulario->dibujar_campo($campo,$parametros,"Dias desbloqueo","tdtitulogris",'diasdesbloqueodeudasestudiante');



            $condicion = "";
//and tr.codigotiporeconocimientodocente=r.codigotiporeconocimientodocente
            $datosestudiante = $objetobase->recuperar_datos_tabla("estudiantegeneral eg", "eg.numerodocumento", $_POST['numerodocumento'], $condicion, "", 0);
            $fila["Documento"] = "";
            $fila["Nombres"] = "";
            $fila["Apellidos"] = "";
            $fila["Periodo"] = "";
            //$fila["Fecha_Reconocimiento"] = "";


            $formulario->dibujar_filas_texto($fila, 'tdtitulogris', '', "colspan=4", "colspan=4");

            //while ($row = $resultado->fetchRow()) {
            unset($fila);
            $fila[$datosestudiante["numerodocumento"]] = "";
            $fila[$datosestudiante["nombresestudiantegeneral"]] = "";
            $fila[$datosestudiante["apellidosestudiantegeneral"]] = "";
            $fila[$_SESSION["codigoperiodosesion"]] = "";
            $formulario->dibujar_filas_texto($fila, '', '', "colspan=4", "colspan=4");

            $menu = "boton_tipo";
            $parametro = "'hidden','idestudiantegeneral','" . $datosestudiante['idestudiantegeneral'] . "'";
            $formulario->boton_tipo('hidden', 'idestudiantegeneral', $datosestudiante['idestudiantegeneral']);
            //$formulario->dibujar_campo($menu, $parametro, "Documento ", "tdtitulogris", "numerodocumento", "requerido");
            //}
            $conboton = 0;
            $parametrobotonenviar[$conboton] = "'submit','Desbloqueo','Desbloqueo','onClick=\"return enviarpagina();\"'";
            $boton[$conboton] = 'boton_tipo';
            $conboton++;
            $parametrobotonenviar[$conboton] = "'submit','Bloqueo','Anular Desbloqueo','onClick=\"return enviarpagina();\"'";
            $boton[$conboton] = 'boton_tipo';
            $formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar', '');
            echo "</table>";
        }

        if (isset($_REQUEST["Desbloqueo"])) {
            $fila["idestudiantegeneral"] = $_POST['idestudiantegeneral'];
            $fila["diasdesbloqueodeudasestudiante"] = $_POST['diasdesbloqueodeudasestudiante'];
            $fila["codigoperiodo"] = $_SESSION["codigoperiodosesion"];
            $fila["idusuario"] = $datosusuario['idusuario'];
            $fila["fechadesbloqueodeudasestudiante"] = $fechahoy;
            $fila["codigoestado"] = '100';
            $load = " idestudiantegeneral='" . $fila["idestudiantegeneral"] . "'"
                    . " and codigoperiodo ='" . $fila["codigoperiodo"] . "'";
            $objetobase->insertar_fila_bd("desbloqueodeudasestudiante", $fila, 0, $load);
            alerta_javascript("Estudiante desbloqueado correctamente");
        }
        if (isset($_REQUEST["Bloqueo"])) {
            $fila["idestudiantegeneral"] = $_POST['idestudiantegeneral'];
            $fila["diasdesbloqueodeudasestudiante"] = $_POST['diasdesbloqueodeudasestudiante'];
            $fila["codigoperiodo"] = $_SESSION["codigoperiodosesion"];
            $fila["idusuario"] = $datosusuario['idusuario'];
            $fila["fechadesbloqueodeudasestudiante"] = $fechahoy;
            $fila["codigoestado"] = '200';
            $load = " idestudiantegeneral='" . $fila["idestudiantegeneral"] . "'"
                    . " and codigoperiodo ='" . $fila["codigoperiodo"] . "'";
            $objetobase->insertar_fila_bd("desbloqueodeudasestudiante", $fila, 0, $load);
            alerta_javascript("Anulacion de Desbloqueo correcta");
        }
    }
        ?>
   