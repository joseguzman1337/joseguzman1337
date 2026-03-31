<?php
session_start();
require('../../../Connections/sala2.php');
$sala2 = $sala;
$ruta = "../../../funciones/";
$rutaorden = "../../../funciones/ordenpago/";

require_once($rutaorden . 'claseordenpago.php');
require_once('../../../funciones/funcionip.php');

$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');

if (!isset($_SESSION["MM_Username"]) &&
        trim($_SESSION["MM_Username"]) == '') {
    $_SESSION['auth'] = true;

    $_SESSION["MM_Username"] = "Manejo Sistema";
    $_SESSION['rol'] = "1";
}
?>

<html>
    <head>
        <title>Pago derechos inscripción</title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
        <?php
        /**
         * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Se crea la funcion ocultar() para que en el momento de generar una orden de pago se oculte el hipervinculo,
         * se muestre el 'procesando' mientras se genera la orden y asi evitar que se generen ordenes sin concepto y con valor $0
         * @since Mayo 8, 2019
         */
        ?>
        <script language="javascript">
        function ocultar(){
            document.getElementById('generaorden').style.visibility = 'hidden';
            document.getElementById('procesando').style.display = 'inline';
        }
        </script>
    </head>
    <body>
        <?php
        $codigocarrera = $_SESSION['codigocarrerasesion'];

        $query_data = "SELECT
                        eg.*, c.nombrecarrera,
                        m.nombremodalidadacademica,
                        ci.nombreciudad,
                        m.codigomodalidadacademica,
                        i.idinscripcion,
                        s.nombresituacioncarreraestudiante,
                        i.numeroinscripcion,
                        i.codigosituacioncarreraestudiante,
                        i.codigoperiodo,
                        c.codigoindicadorcobroinscripcioncarrera,
                        c.codigoindicadorprocesoadmisioncarrera,
                        ec.codigocarrera,
                        ec.codigoestudiante
                FROM
                        estudiantegeneral eg
                        INNER JOIN inscripcion i on (eg.idestudiantegeneral = i.idestudiantegeneral AND i.codigoestado = '100')
                        INNER JOIN estudiantecarrerainscripcion e on ( i.idinscripcion = e.idinscripcion and e.codigoestado = 100)
                        INNER JOIN carrera c on ( e.codigocarrera = c.codigocarrera)
                        INNER JOIN modalidadacademica m on ( m.codigomodalidadacademica = i.codigomodalidadacademica)
                        INNER JOIN ciudad ci on ( eg.idciudadnacimiento = ci.idciudad)
                        INNER JOIN situacioncarreraestudiante s on ( s.codigosituacioncarreraestudiante = i.codigosituacioncarreraestudiante)
                        INNER JOIN estudiante ec on ( ec.codigocarrera = e.codigocarrera and ec.idestudiantegeneral = eg.idestudiantegeneral AND ec.codigoperiodo = '" . $_GET['codigoperiodo'] . "')
                        INNER JOIN periodo p on ( i.codigoperiodo = p.codigoperiodo )
                WHERE
                        numerodocumento = " . $db->qstr($_REQUEST['documentoingreso']) . "
                AND e.idnumeroopcion = '1'
                AND ( p.codigoestadoperiodo = '1' OR p.codigoestadoperiodo = '4')
                AND ec.codigocarrera = '$codigocarrera' AND ec.codigosituacioncarreraestudiante <> 109";
        
        $data = $db->Execute($query_data);
        $totalRows_data = $data->RecordCount();
        $row_data = $data->FetchRow();
        $idestudiantegeneral = $row_data['idestudiantegeneral'];

        if ($row_data <> "") {
            $idestudiantegeneral = $row_data['idestudiantegeneral'];
            ?>
            <a href="../../../../aspirantes/enlineacentral.php?documentoingreso=<?php echo $_REQUEST['documentoingreso'] . "&codigocarrera=$codigocarrera"; ?>" id="aparencialinknaranja">Inicio</a><br><br>
            <table width="750" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
                <tr>
                    <td colspan="7" id="tdtitulogris">PAGO DERECHOS DE INSCRIPCION</td>
                </tr>
                <tr>
                    <td align="left" id="tdtitulogris">
                        Modalidad
                    </td>
                    <td align="left" id="tdtitulogris">
                        Programa
                    </td>
                </tr>
            </table>
            <?php
            do {
                //la siguiente consulta la realiza en el archivo claseordenestudiante por medio de la ruta del archivo claseordenpago
                $ordenesxestudiante = new Ordenesestudiante($sala2, $row_data['codigoestudiante'], $row_data['codigoperiodo'], 153);
                $cuentaordenes = $ordenesxestudiante->numerodeordenes();
                ?>
                <table width="750" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
                    <tr>
                        <td align="left" rowspan="<?php echo $cuentaordenes; ?>">
                            <?php echo $row_data['nombremodalidadacademica']; ?> 
                        </td>
                        <td rowspan="<?php echo $cuentaordenes; ?>" align="left">
                            <?php echo $row_data['nombrecarrera']; ?>
                        </td>
                        <?php
                        if ($cuentaordenes > 0 && $ordenesxestudiante->existenordenesdepago()) {
                            $ordenesxestudiante->mostrar_ordenespago($rutaorden, "");
                        } else {
                        ?>
                        <td colspan="4" align="center">
                            <a href="generarordenpagoinscripcion.php?documentoingreso=<?php echo $_GET['documentoingreso'] . "&codigoestudiante=" . $row_data['codigoestudiante'] . "&codigoperiodo=" . $row_data['codigoperiodo'] . "&todos"; ?>" onclick="ocultar();" id="generaorden">Generación Orden de Pago</a>
                        </td>
                        <?php
                        }
                        ?>
                    </tr>
                    <tr class="Estilo1" bgcolor='#FEF7ED'>
                    </tr>
                </table>
                <div id="procesando" style="display:none">
                    <img src="../../../../assets/ejemplos/img/Procesando.gif" witdh="400px"><br>
                    <p>Generando Orden de Pago, por favor espere...</p>
                </div>
                <?php
                $documento = $row_data['numerodocumento'];
                } while ($row_data = $data->FetchRow());
                ?>
            <br>
            <?php
        }
        if (isset($_REQUEST['menuprincipal'])) {
            ?>
            <input type="button" value="Regresar" onClick="location.href = '../../../../aspirantes/enlineacentral.php?documentoingreso=<?php echo "$documento&codigocarrera=$codigocarrera"; ?>'">
            <?php
        }
        ?>
    </body>
</html>