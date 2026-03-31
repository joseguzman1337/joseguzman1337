<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

require_once("../../../funciones/validacion.php");
require_once("../../../funciones/errores_plandeestudio.php");
include (realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));




$codigocarrera = $_SESSION['codigofacultad'];
if (isset($_GET['nombrecarrera'])) {
    $nombreCarrera = $_GET['nombrecarrera'];
}
if (isset($_POST['nombrecarrera'])) {
    $nombreCarrera = $_POST['nombrecarrera'];
}


$formulariovalido = 1;
?>
<html>
    <head>
        <title>Nuevo plan de estudio</title>
        <style type="text/css">
            <!--
            .Estilo4 {
                font-size: 12px;
                font-family: Tahoma;
            }
            -->
        </style>
    </head>
    <style type="text/css">
        <!--
        .Estilo1 {
            font-family: Tahoma;
            font-size: x-small;
        }
        .Estilo8 {width: 15px}
        -->
    </style>
    <body>
        <div align="center">
            <form name="f1" method="post" action="nuevoplandeestudio.php">
                <p align="center" class="Estilo1 Estilo4"><strong>PLAN DE ESTUDIO</strong></p>
                <table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
                    <tr>
                        <td align="center" bgcolor="#C5D5D6" class="Estilo4"><strong>Nº Plan Estudio</strong></td>
                        <td align="center" bgcolor="#C5D5D6" class="Estilo4"><strong>Nombre</strong></td>
                        <td align="center" bgcolor="#C5D5D6" class="Estilo4"><strong>Fecha</strong></td>
                    </tr>
                    <tr>
                        <td align="center" class="Estilo4">0</td>
                        <td align="center" class="Estilo4"><input name="penombre" type="text" size="20" value="<?php if (isset($_POST['penombre'])) echo $_POST['penombre']; ?>" >
                            <font color="#FF0000">
                            <?php
                            if (isset($_POST['penombre'])) {
                                $nombre = $_POST['penombre'];
                                $imprimir = true;
                                $nombrerequerido = validar($nombre, "requerido", $error1, $imprimir);
                                $formulariovalido = $formulariovalido * $nombrerequerido;
                            }
                            ?>
                            </font></td>
                        <td align="center" class="Estilo4"><?php echo date("Y-m-d"); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center" bgcolor="#C5D5D6" class="Estilo4"><strong>Nombre Encargado</strong></td>
                        <td align="center" bgcolor="#C5D5D6" class="Estilo4"><strong>Cargo</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center" class="Estilo4"><input name="penombreencargado" type="text" size="20" value="<?php if (isset($_POST['penombreencargado'])) echo $_POST['penombreencargado']; ?>">
                            <font color="#FF0000">
                            <?php
                            if (isset($_POST['penombreencargado'])) {
                                $nombreencargado = $_POST['penombreencargado'];
                                $imprimir = true;
                                $nombreencargadorequerido = validar($nombreencargado, "requerido", $error1, $imprimir);
                                $formulariovalido = $formulariovalido * $nombreencargadorequerido;
                            }
                            ?>
                            </font></td>
                        <td align="center" class="Estilo4"><input name="pecargo" type="text" size="15" value="<?php if (isset($_POST['pecargo'])) echo $_POST['pecargo']; ?>">
                            <font color="#FF0000">
                            <?php
                            if (isset($_POST['pecargo'])) {
                                $cargo = $_POST['pecargo'];
                                $imprimir = true;
                                $cargorequerido = validar($cargo, "requerido", $error1, $imprimir);
                                $formulariovalido = $formulariovalido * $cargorequerido;
                            }
                            ?>
                            </font></td>
                    </tr>
                    <tr>
                        <td align="center" bgcolor="#C5D5D6" class="Estilo4"><strong>Nº Semestres</strong></td>
                        <td align="center" bgcolor="#C5D5D6" class="Estilo4"><strong>Carrera</strong></td>
                        <td align="center" bgcolor="#C5D5D6" class="Estilo4"><strong>Autorización Nº</strong></td>
                    </tr>
                    <tr>
                        <td align="center" class="Estilo4">
                            <input name="pesemestre"  type="number" size="2" value="<?php
                            if (isset($_POST['pesemestre']))
                                echo $_POST['pesemestre'];
                            else
                                echo "1";
                            ?>" style=" width:80%" onBlur="limitesemestre(this)">
                            <font color="#FF0000">
                            <?php
                            if (isset($_POST['pesemestre'])) {
                                $semestre = $_POST['pesemestre'];
                                $imprimir = true;
                                $semestrenumero = validar($semestre, "numero", $error2, $imprimir);
                                $semestrerequerido = validar($semestre, "requerido", $error1, $imprimir);
                                $formulariovalido = $formulariovalido * $semestrerequerido * $semestrenumero;
                            }
                            ?>
                            </font>
                        </td>
                        <td align="center" class="Estilo4">
                            <?php echo $nombreCarrera; ?>
                            <input type="hidden" name="nombrecarrera" value="<?php echo $nombreCarrera; ?>">
                        </td>
                        <td align="center" class="Estilo4"><input name="peautorizacion" type="text" size="20" value="<?php if (isset($_POST['peautorizacion'])) echo $_POST['peautorizacion']; ?>">
                            <font color="#FF0000">
                            <?php
                            if (isset($_POST['peautorizacion'])) {
                                $autorizacion = $_POST['peautorizacion'];
                                $imprimir = true;
                                $autorizacionrequerido = validar($autorizacion, "requerido", $error1, $imprimir);
                                $formulariovalido = $formulariovalido * $autorizacionrequerido;
                            }
                            ?>
                            </font></td>
                    </tr>
                    <tr>
                        <td align="center" bgcolor="#C5D5D6" class="Estilo4"><strong>Fecha de Inicio</strong></td>
                        <td align="center" bgcolor="#C5D5D6" class="Estilo4"><strong>Fecha de Vencimiento</strong></td>
                        <td rowspan="2" class="Estilo4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" class="Estilo4"><input name="pefechainicio" type="text" size="10" value="<?php
                            if (isset($_POST['pefechainicio']))
                                echo $_POST['pefechainicio'];
                            else
                                echo "aaaa-mm-dd";
                            ?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)">
                            <font color="#FF0000">
                            <?php
                            if (isset($_POST['pefechainicio'])) {
                                $fechainicio = $_POST['pefechainicio'];
                                $imprimir = true;
                                $fechainiciofecha = validar($fechainicio, "fecha", $error3, $imprimir);
                                $formulariovalido = $formulariovalido * $fechainiciofecha;
                                if ($formulariovalido == 1) {
                                    if ($_POST['pefechainicio'] > $_POST['pefechavencimiento']) {
                                        echo "La Fecha de Inicio debe ser menor que la Fecha de Vencimiento";
                                        $formulariovalido = 0;
                                    }
                                    if ($_POST['pefechainicio'] == $_POST['pefechavencimiento']) {
                                        echo "La Fecha de Inicio debe ser diferente que la Fecha de Vencimiento";
                                        $formulariovalido = 0;
                                    }
                                }
                            }
                            ?>
                            </font></td>
                        <td align="center" class="Estilo4"><input name="pefechavencimiento" type="text" size="10" value="<?php
                            if (isset($_POST['pefechavencimiento']))
                                echo $_POST['pefechavencimiento'];
                            else
                                echo "2999-12-31";
                            ?>" onBlur="iniciarvencimiento(this)" onFocus="limpiarvencimiento(this)">
                            <font color="#FF0000">
                            <?php
                            if (isset($_POST['pefechavencimiento'])) {
                                $fechavencimiento = $_POST['pefechavencimiento'];
                                $imprimir = true;
                                $fechavencimientofecha = validar($fechavencimiento, "fecha", $error3, $imprimir);
                                $formulariovalido = $formulariovalido * $fechavencimientofecha;
                                if ($formulariovalido == 1) {
                                    if ($_POST['pefechainicio'] > $_POST['pefechavencimiento']) {
                                        echo "La Fecha de Vencimiento debe ser mayor que la Fecha de Inicio";
                                        $formulariovalido = 0;
                                    }
                                    if ($_POST['pefechainicio'] == $_POST['pefechavencimiento']) {
                                        echo "La Fecha de Vencimiento debe ser diferente que la Fecha de Inicio";
                                        $formulariovalido = 0;
                                    }
                                }
                            }
                            ?>
                            </font></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center" class="Estilo4"><br><input type="submit" value="Aceptar" name="aceptarcabecera"><input type="button" value="Regresar" name="cancelarcabecera" onClick="regresar()"></td>
                    </tr>
                </table>
                <?php
                if (isset($_POST['aceptarcabecera'])) {
                    if ($formulariovalido) {

                        $query_insplanestudio = "INSERT INTO planestudio(idplanestudio, nombreplanestudio, codigocarrera, responsableplanestudio, cargoresponsableplanestudio, numeroautorizacionplanestudio, cantidadsemestresplanestudio, fechacreacionplanestudio, fechainioplanestudio, fechavencimientoplanestudio, codigoestadoplanestudio, codigotipocantidadelectivalibre, cantidadelectivalibre)
		VALUES(0, '$nombre', '$codigocarrera', '$nombreencargado', '$cargo', '$autorizacion', '$semestre', '" . date("Y-m-d") . "', '$fechainicio', '$fechavencimiento', '101', '100', '0')";
                        $insplanestudio = $db->Execute($query_insplanestudio);
                        $query_maxIdplanestudio = "SELECT MAX(idplanestudio) idplanestudio FROM planestudio";
                        $idplanestudio = $db->GetRow($query_maxIdplanestudio);

                        echo '<script language="javascript">
		window.location.href="visualizarplandeestudio.php?planestudio=' . $idplanestudio['idplanestudio'] . '";
		</script>';
                    }
                }
                ?>
            </form>
        </div>
    </body>
    <script language="javascript">
        function regresar()
        {
            window.location.href = "plandeestudioinicial.php"
        }

        function limpiarinicio(texto)
        {
            if (texto.value == "aaaa-mm-dd")
                texto.value = "";
        }

        function limpiarvencimiento(texto)
        {
            if (texto.value == "2999-12-31")
                texto.value = "";
        }

        function iniciarinicio(texto)
        {
            if (texto.value == "")
                texto.value = "aaaa-mm-dd";
        }

        function iniciarvencimiento(texto)
        {
            if (texto.value == "")
                texto.value = "2999-12-31";
        }

        function contadorsemestre(accion)
        {
            var cont;
            cont = document.f1.pesemestre.value;
            if (accion == 1)
            {
                if (cont == 12)
                {
                    return;
                }
                cont++;
            }
            if (accion == 2)
            {
                if (cont == 1)
                {
                    return;
                }
                cont--;
            }
            document.f1.pesemestre.value = cont;
        }

        function limitesemestre(texto)
        {
            if (texto.value > 12)
            {
                texto.value = 12;
                return;
            }
        }
    </script>
</html>
