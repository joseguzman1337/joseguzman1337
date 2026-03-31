<?php
/*
 * Ajustes de limpieza codigo y modificacion de interfaz
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Modificado 14 de Noviembre de 2017.
 */
session_start();
include_once('../../../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
$rutaado = ("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/motorv2/motor.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>

        <link type="text/css" rel="stylesheet" href="../../../../../assets/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="../../../../../assets/css/font-page.css">
        <link type="text/css" rel="stylesheet" href="../../../../../assets/css/font-awesome.css">
        <link type="text/css" rel="stylesheet" href="../../../../../assets/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="../../../../../assets/css/general.css">
        <link type="text/css" rel="stylesheet" href="../../../../../assets/css/chosen.css">
        <script type="text/javascript" src="../../../../../assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../../../../../assets/js/bootstrap.js"></script> 

        <script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/requestxml.js"></script>

        <script LANGUAGE="JavaScript">
            function  ventanaprincipal(pagina) {
                opener.focus();
                opener.location.href = pagina.href;
                window.close();
                return false;
            }
            function reCarga() {
                document.location.href = "<?php echo '../matriculas/menu.php'; ?>";

            }
            function regresarGET()
            {
                document.location.href = "<?php echo '../matriculas/menu.php'; ?>";
            }
            function enviarmenu()
            {
                var formulario = document.getElementById("form1");
                formulario.action = "";
                formulario.submit();
            }
        </script>
    </head>
    <body>
        <?php
        $objetobase = new BaseDeDatosGeneral($sala);
        $formulario = new formulariobaseestudiante($sala, 'form2', 'post', '', 'true');

        echo "<div class=\"container\">
                <form id=\"form1\" name=\"form1\" action=\"listadodetalledesercion.php\" method=\"post\"  >
                    <input type=\"hidden\" name=\"AnularOK\" value=\"\">
                        <div class=\"table-responsive\">
                            <table class=\"table\">";
                            $datos_usuario = $formulario->datos_usuario();
                            $numerodocumento = $datos_usuario["numerodocumento"];
                            unset($formulario->filatmp);
                            $formulario->dibujar_fila_titulo('<h2>GRUPOS DE MATERIAS DE ELECTIVAS LIBRES</h2>', '', "2", "align='center'");
                            $condicion = " g.codigoperiodo='" . $_SESSION["codigoperiodosesion"] . "'
                            and g.codigotipogrupomateria ='100' and g.CodigoEstado ='100'";
                            $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("grupomateria g", "g.idgrupomateria", "g.nombregrupomateria", $condicion, "", 0);
                            $formulario->filatmp[""] = "Seleccionar";
                            $campo = 'menu_fila';
                            $parametros = "'idgrupomateria','" . $_POST['idgrupomateria'] . "','onchange=enviarmenu();'";
                            $formulario->dibujar_campo($campo, $parametros, "<font style='font-weight:bold;'>GRUPO ELECTIVAS</font>", "", 'idgrupomateria', '');
                            if (isset($_POST['idgrupomateria']) && trim($_POST['idgrupomateria']) != '') {
                                $_SESSION["grupoelectivas_idgrupomateria"] = $_POST['idgrupomateria'];
                                $tabla = "materia m,grupomateria gm,detallegrupomateria dgm
                                left join detallegrupomateria dgm2 on dgm2.codigomateria=dgm.codigomateria
                                and dgm2.idgrupomateria=" . $_POST['idgrupomateria'] . "";
                                $condicion = " and gm.idgrupomateria=dgm.idgrupomateria" .
                                        " and m.codigomateria=dgm.codigomateria" .
                                        " and gm.codigotipogrupomateria ='100'" .
                                        " group by m.codigomateria" .
                                        " order by m.nombremateria";
                                $resultmateriaslibres = $objetobase->recuperar_resultado_tabla($tabla, "gm.codigoperiodo", $_SESSION["codigoperiodosesion"], $condicion, ",m.codigomateria codigomateriamateria,dgm2.idgrupomateria idgrupomaterialibre", 0);
                                echo $sql;
                                $i = 0;
                                while ($rowmateriaslibres = $resultmateriaslibres->fetchRow()) {
                                    $arrayparametroscajax[$i]["enunciado"] = $rowmateriaslibres["codigomateriamateria"] . " - " . $rowmateriaslibres["nombremateria"];
                                    $arrayparametroscajax[$i]["nombre"] = $rowmateriaslibres["codigomateriamateria"];
                                    $arrayparametroscajax[$i]["valorsi"] = $_POST['idgrupomateria'];
                                    $arrayparametroscajax[$i]["valorno"] = 0;
                                    if (isset($rowmateriaslibres["idgrupomaterialibre"]) && trim($rowmateriaslibres["idgrupomaterialibre"]) != '') {
                                        $arrayparametroscajax[$i]["check"] = "checked";
                                    } else {
                                        $arrayparametroscajax[$i]["check"] = "";
                                    }
                                    $i++;
                                }

                                $formulario->dibujar_cajax_chequeos($arrayparametroscajax, "asignagrupoelectiva.php", 'labelresaltado', "");
                            }
                    echo "</table>
                    </div>
                </form>
            </div>";
        ?>
    </body>
</html>
<!--end-->