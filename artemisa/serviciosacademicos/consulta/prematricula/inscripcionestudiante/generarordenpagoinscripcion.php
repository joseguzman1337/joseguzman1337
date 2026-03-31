<?php
require_once('../../../Connections/sala2.php');

require_once('../../../funciones/funcionip.php');

session_start();

$ruta = "../../../funciones/";

$rutaorden = "../../../funciones/ordenpago/";

require_once($rutaorden . 'claseordenpago.php');

mysql_select_db($database_sala, $sala);

/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se agregan validaciones para que las ordenes de pago por concepto de inscripcion se genere una sola vez
 * y se agrega el parametro &codigocarrera=" . $_SESSION['codigocarrerasesion'] . " en la url de redireccionamiento.
 * @since Mayo 8, 2019
 */
if (!isset($_GET['visualizarordenes'])) {

    if (isset($_GET['todos'])) {
        $ordenesxestudiante = new Ordenesestudiante($sala, $_GET['codigoestudiante'], $_GET['codigoperiodo']);
//        $cuentaconceptos = $ordenesxestudiante->existe_conceptosinscripcion($pagos, $porpagar, $enproceso, $sinpagar, $cuentaconceptos);
        $cuentaconceptos = $ordenesxestudiante->existe_conceptosinscripcionPorEstudiante($pagos, $porpagar, $enproceso, $sinpagar, $cuentaconceptos);
        // Aca entran los conceptos de la facultad, 153 y 152

        if (!$ordenesxestudiante->validar_generacionordenesinscripcion()) {
            ?>
            <script language="javascript">
                history.go(-1);
            </script>
            <?php
            exit();
        }
        if (isset($sinpagar) || $sinpagar != null || !empty($sinpagar)) {
            $concept = mysql_fetch_assoc($ordenesxestudiante->obtenerConceptoDeInscripcion());
            if (empty($concept)) {
                ?>

                <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet"/>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
                <script language="javascript">
                    $(function(){
                        setTimeout(function () {
                            swal({
                                    title: "Alerta!",
                                    text: "No se puede generar orden de pago, por favor comunicarse con atención al usuario o finanzas estudiantiles",
                                    type: "error",
                                    confirmButtonText: "OK"
                                },
                                function(isConfirm){
                                    if (isConfirm) {
                                        window.history.back();
                                    }
                                }); }, 1000);
                    });
                </script>
                <?php
                exit();
            } else {
                @$ordenesxestudiante->generarordenpago_conceptosinscripcion($sinpagar);
            }

        }
        ?>
        <script language="javascript">
            window.location.href = "generarordenpagoinscripcion.php?documentoingreso=<?php echo $_GET['documentoingreso']; ?>&codigoestudiante=<?php echo $_GET['codigoestudiante']; ?>&codigoperiodo=<?php echo $_GET['codigoperiodo']; ?>";
        </script>
        <?php
    } else if (isset($_GET['formulario'])) {

        $ordenesxestudiante = new Ordenesestudiante($sala, $_GET['codigoestudiante'], $_GET['codigoperiodo']);

        $conceptos[] = 152;

        if (!$ordenesxestudiante->validar_generacionordenesinscripcion()) {
            ?>
            <script language="javascript">
                history.go(-1);
            </script>
            <?php
            exit();
        }

        if (isset($sinpagar) || $sinpagar != null || !empty($sinpagar)) {
            $concept = mysql_fetch_assoc($ordenesxestudiante->obtenerConceptoDeInscripcion());
            if (empty($concept)) {
                ?>

                <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet"/>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
                <script language="javascript">
                    $(function(){

                        setTimeout(function () {
                            swal({
                                    title: "Alerta!",
                                    text: "No se puede generar orden de pago, por favor comunicarse con atención al usuario o finanzas estudiantiles",
                                    type: "error",
                                    confirmButtonText: "OK"
                                },
                                function(isConfirm){
                                    if (isConfirm) {
                                        window.history.back();
                                    }
                                }); }, 1000);
                    });
                </script>
                <?php
                exit();
            } else {
                @$ordenesxestudiante->generarordenpago_conceptosinscripcion($sinpagar);
            }
        }

        $cuentaconceptos = $ordenesxestudiante->existe_conceptosinscripcion($pagos, $porpagar, $enproceso, $sinpagar, $cuentaconceptos);
        ?>
        <script language="javascript">
            window.location.href = "generarordenpagoinscripcion.php?documentoingreso=<?php echo $_GET['documentoingreso']; ?>&codigoestudiante=<?php echo $_GET['codigoestudiante']; ?>&codigoperiodo=<?php echo $_GET['codigoperiodo']; ?>";
        </script>
        <?php
    } else {
        $ordenesxestudiante = new Ordenesestudiante($sala, $_GET['codigoestudiante'], $_GET['codigoperiodo']);
        $cuentaconceptos = $ordenesxestudiante->existe_conceptosinscripcion($pagos, $porpagar, $enproceso, $sinpagar, $cuentaconceptos);
    }
} else {
    $ordenesxestudiante = new Ordenesestudiante($sala, $_GET['codigoestudiante'], $_GET['codigoperiodo']);
}
?>

<html>
<head>
    <title>Visualizar Ordenes Inscripción</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<style type="text/css">
    <!--
    .Estilo1 {
        font-family: Tahoma;
        font-size: 12px
    }

    .Estilo2 {
        font-family: Tahoma;
        font-size: 12px;
        font-weight: bold;
    }

    .Estilo3 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 14px;
        font-weight: bold;
    }

    -->
</style>
<body>
<?php
// 1. Muestra los conceptos de inscripción que debe generar el estudiante
if (!isset($_GET['visualizarordenes'])) {
    if ($cuentaconceptos['sinpagar'] > 0) {
        // Antes de generar la orden de pago se deben hacer todas las validaciones
        if (!$ordenesxestudiante->validar_generacionordenesinscripcion()) {
            ?>
            <script language="javascript">
                history.go(-1);
            </script>
            <?php
        }
    }
}
?>
<div align="center">
    <br>
    <br>
    <?php
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../../../aspirantes/enlineacentral.php?documentoingreso=" . $_GET['documentoingreso'] . "&codigocarrera=" . $_SESSION['codigocarrerasesion'] . "'>";
    ?>
</div>
</body>
<script language="javascript">
    function recargar(dir) {
        window.location.href = "generarordenpagoinscripcion.php" + dir + "&planestudio='.$idplanestudio.'&visualizado";
        history.go();
    }
</script>
</html>

