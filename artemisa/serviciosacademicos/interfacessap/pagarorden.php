<?php
/**
 * Caso 431.
 * Se incluye el archivo adaptador para tener acceso a las funciones basicas de
 * del nuevo sala si la aplicacion se corre en un entorno local o de pruebas 
 * se activa la visualizacion de todos los errores de php
 * @modified Dario Gaulteros Castro <castroluisd@unbosque.edu.do>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 8 de febrero 2019.
 */
require_once(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));

/**
 * El metodo Factory::validateSession($variables) hace una validacion de session activa en el sistema
 * dependiendo de los parametros que se le envíen, si determina que la session acabo redirige el sistema al login
 */
Factory::validateSession($variables);
$usuario = Factory::getSessionVar('usuario');

$ruta = "../";
require_once('../consulta/generacionclaves.php');
require('../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
require_once('../funciones/funcionip.php');
require_once('../funciones/clases/autenticacion/redirect.php');

$itemId = Factory::getSessionVar('itemId');
/**
 * Caso 278.
 * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
 * Ajuste de acceso por usuario por la opción de Gestion de Permisos.
 * @since 21 de Febrero 2019.
 */
require_once('../../assets/lib/Permisos.php');
if (!Permisos::validarPermisosComponenteUsuario($usuario, $itemId)) {
    header("Location: " . HTTP_ROOT . "/serviciosacademicos/GestionRolesYPermisos/index.php?option=error");
    exit();
}

echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/normalize.css");
echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/font-page.css");
echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/font-awesome.css");
echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/bootstrap.css");
echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/general.css");

echo Factory::printImportJsCss("js", HTTP_ROOT . "/assets/js/bootstrap.js");
echo Factory::printImportJsCss("js", HTTP_ROOT . "/assets/js/jquery-3.6.0.min.js");
?>
<html>
    <head>
        <title>Pagar Orden de Pago (Problema que ocurre en la interfaz entre SAP y SALA, en el cual SAP no le reporta el pago de la orden a SALA)</title>
        <style type="text/css">
            <!--
            .Estilo1 {font-family: tahoma}
            .Estilo2 {font-size: x-small}
            .Estilo3 {font-size: xx-small}
            .Estilo4 {
                font-size: 14px;
                font-weight: bold;
            }
            .Estilo6 {font-size: 12px}
            .Estilo8 {font-size: 12px; font-weight: bold; }
            -->
        </style>
    </head>
    <body>
        <div align="center" class="Estilo1">
            <form name="f1" action="pagarorden.php" method="get" onSubmit="return validar(this)">
                <h1 align="left">PAGAR ORDENES EN SALA</h1>
                <p class="Estilo4" align="left">(USARLA CON CUIDADO YA QUE SI SE PAGA UNA ORDEN DE MATRICULA EL ESTUDIANTE QUEDA MATRICULADO AUTOMATICAMENTE)</p>
                <h5 align="left"><STRONG>Si la orden tiene plan de pagos activo, con pagar la cuota automáticamente paga la orden de matricula</STRONG></h5>
                <table width="700" border="1" bordercolor="#003333" align="left">
                    <tr>
                        <td>
                            <span class="Estilo8">Número de Orden : <input name='busqueda_numero' type='text' value="<?php echo $_REQUEST['busqueda_numero']; ?>">
                            </span>
                        </td>
                        <td>
                            <span class="Estilo8">Observación : <input name='busqueda_onservacion' type='text' size="28">
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input class="btn btn-fill-green-XL first" name="buscar" type="submit" value="Pagar">
                        </td>
                    </tr>
                </table>
                <?php
                if (isset($_REQUEST['buscar'])) {
                    if ($_REQUEST['busqueda_onservacion'] != '') {
                        $numeroordenpago = $_REQUEST['busqueda_numero'];
                        $query_data = "SELECT * FROM ordenpago
                        WHERE numeroordenpago = '$numeroordenpago'";

                        $data = mysql_query($query_data, $sala) or die(mysql_error());
                        $row_data = mysql_fetch_assoc($data);
                        $totalRows_data = mysql_num_rows($data);

                        $digito = ereg_replace("^[0-9]{1,1}", "", $row_data['codigoestadoordenpago']);

                        if ($row_data <> "") { //if 2
                            if (ereg("^1", $row_data['codigoestadoordenpago'])) {
                                // Cada vez que se modifique una orden de pago guardar en logordenpago si existe sesión de usuario
                                if (isset($_SESSION['MM_Username'])) {
                                    $query_id = "select idusuario
                                    from usuario
                                    where usuario = '" . $_SESSION['MM_Username'] . "'";
                                    $id = mysql_db_query($database_sala, $query_id) or die("$query_id <br>" . mysql_error());
                                    $row_id = mysql_fetch_assoc($id);

                                    $idusuario = $row_id['idusuario'];

                                    $query_inslogordenpago = "INSERT INTO logordenpago(idlogordenpago, fechalogordenpago, observacionlogordenpago, numeroordenpago, idusuario, ip)
                                    VALUES(0, now(), '" . $_REQUEST['busqueda_onservacion'] . " -- PAGA MANUALMENTE', '$numeroordenpago', '$idusuario', '" . tomarip() . "')";

                                    $query_inslogordenpago = mysql_db_query($database_sala, $query_inslogordenpago) or die("$query_inslogordenpago <br>" . mysql_error());
                                } else {
                                    $query_inslogordenpago = "INSERT INTO logordenpago(idlogordenpago, fechalogordenpago, observacionlogordenpago, numeroordenpago, idusuario, ip)
                                    VALUES(0, now(), '" . $_REQUEST['busqueda_onservacion'] . " -- PAGA MANUALMENTE', '$numeroordenpago', '2', '" . tomarip() . "')";

                                    $query_inslogordenpago = mysql_db_query($database_sala, $query_inslogordenpago) or die("$query_inslogordenpago <br>" . mysql_error());
                                }

                                $query_prematricula = "UPDATE prematricula p, ordenpago o
                                    SET p.codigoestadoprematricula = 4" . $digito . "
                                    WHERE 
                                    o.codigoestudiante = p.codigoestudiante
                                    AND o.numeroordenpago = '$numeroordenpago'
                                    AND o.codigoperiodo = p.codigoperiodo";

                                $prematricula = mysql_db_query($database_sala, $query_prematricula) or die("$query_prematricula<br>" . mysql_error());

                                $query_detalleprematricula = "UPDATE detalleprematricula
                                    set codigoestadodetalleprematricula = '30'
                                    where numeroordenpago = '$numeroordenpago'
                                    and codigoestadodetalleprematricula like '1%'";
                                $detalleprematricula = mysql_db_query($database_sala, $query_detalleprematricula) or die("$query_detalleprematricula<br>" . mysql_error());

                                $query_conceptoorden = "SELECT do.codigoconcepto
                                    FROM detalleordenpago do,concepto c
                                    WHERE do.numeroordenpago = '$numeroordenpago'
                                    AND do.codigoconcepto = c.codigoconcepto
                                    AND c.cuentaoperacionprincipal = '153'";
                                $conceptoorden = mysql_db_query($database_sala, $query_conceptoorden) or die("$query_conceptoorden<br>" . mysql_error());
                                $totalRows_conceptoorden = mysql_num_rows($conceptoorden);
                                $row_conceptoorden = mysql_fetch_array($conceptoorden);

                                //CREA CUENTA CORREO
                                $objetoclaveusuario = new GeneraClaveUsuario($numeroordenpago, $salaobjecttmp);

                                if ($row_conceptoorden <> "") { // if 2
                                    require_once('../funciones/funcion_inscribir.php');
                                    hacerInscripcion_mysql($numeroordenpago);
                                }

                                $query_ordenpago = "UPDATE ordenpago
                                    set codigoestadoordenpago = 4" . $digito . ",
                                    documentocuentaxcobrarsap = '$documentocuentaxcobrarsap',
                                    documentocuentacompensacionsap = '$documentocuentacompensacionsap',
                                    observacionordenpago = '" . $_REQUEST['busqueda_onservacion'] . " -- PAGA MANUALMENTE',
                                    fechapagosapordenpago = now()
                                    where numeroordenpago = '$numeroordenpago'";

                                $ordenpago = mysql_db_query($database_sala, $query_ordenpago) or die("$query_ordenpago<br>" . mysql_error());

                                $query_detalleorden = "SELECT d.codigoconcepto,d.valorconcepto,o.codigoperiodo,o.codigoestudiante
                                    FROM ordenpago o,detalleordenpago d
                                    WHERE o.numeroordenpago = '$numeroordenpago'
                                    AND o.numeroordenpago = d.numeroordenpago
                                    AND d.codigotipodetalleordenpago = 2";

                                $detalleorden = mysql_query($query_detalleorden, $sala) or die(mysql_error());

                                while ($row_detalleorden = mysql_fetch_assoc($detalleorden)) {

                                    $query_consultadvd = "SELECT iddescuentovsdeuda
                                        FROM descuentovsdeuda
                                        WHERE codigoestudiante = '" . $row_detalleorden['codigoestudiante'] . "'
                                        and codigoestadodescuentovsdeuda = '01'
                                        and codigoperiodo = '" . $row_detalleorden['codigoperiodo'] . "'
                                        and codigoconcepto = '" . $row_detalleorden['codigoconcepto'] . "'
                                        and valordescuentovsdeuda = '" . $row_detalleorden['valorconcepto'] . "'";
                                    $consultadvd = mysql_db_query($database_sala, $query_consultadvd) or die("$query_consultadvd" . mysql_error());
                                    $totalRows_consultadvd = mysql_num_rows($consultadvd);
                                    $row_respuestadvd = mysql_fetch_array($consultadvd);

                                    if ($row_respuestadvd <> "") {
                                        $base3 = "update descuentovsdeuda
                                            set  codigoestadodescuentovsdeuda = '03'
                                            where iddescuentovsdeuda = '" . $row_respuestadvd['iddescuentovsdeuda'] . "'";
                                        $sol3 = mysql_db_query($database_sala, $base3);
                                    }
                                }

                                $query_plan = "SELECT o.*, op.codigoestadoordenpago
                                    FROM ordenpagoplandepago o, ordenpago op
                                    WHERE o.numerorodencoutaplandepagosap = '$numeroordenpago'
                                    and op.numeroordenpago = o.numerorodenpagoplandepagosap
                                    and op.codigoestadoordenpago like '1%'";

                                $plan = mysql_query($query_plan, $sala) or die("$query_plan <br>" . mysql_error());
                                $row_plan = mysql_fetch_assoc($plan);
                                $totalRows_plan = mysql_num_rows($plan);

                                if ($row_plan <> "") {
                                    $numeroordenpago = $row_plan['numerorodenpagoplandepagosap'];
                                    $digito = ereg_replace("^[0-9]{1,1}", "", $row_data['codigoestadoordenpago']);

                                    // Cada vez que se modifique una orden de pago guardar en logordenpago si existe sesión de usuario
                                    if (isset($_SESSION['MM_Username'])) {
                                        $query_id = "select idusuario
                                            from usuario
                                            where usuario = '" . $_SESSION['MM_Username'] . "'";
                                        $id = mysql_db_query($database_sala, $query_id) or die("$query_id <br>" . mysql_error());
                                        $row_id = mysql_fetch_assoc($id);

                                        $idusuario = $row_id['idusuario'];

                                        $query_inslogordenpago = "INSERT INTO logordenpago(idlogordenpago, fechalogordenpago, observacionlogordenpago, numeroordenpago, idusuario, ip)
                                            VALUES(0, now(), '" . $_REQUEST['busqueda_onservacion'] . " -- PAGA MANUALMENTE', '$numeroordenpago', '$idusuario', '" . tomarip() . "')";

                                        $query_inslogordenpago = mysql_db_query($database_sala, $query_inslogordenpago) or die("$query_inslogordenpago <br>" . mysql_error());
                                    } else {
                                        $query_inslogordenpago = "INSERT INTO logordenpago(idlogordenpago, fechalogordenpago, observacionlogordenpago, numeroordenpago, idusuario, ip)
                                            VALUES(0, now(), '" . $_REQUEST['busqueda_onservacion'] . " -- PAGA MANUALMENTE', '$numeroordenpago', '2', '" . tomarip() . "')";

                                        $query_inslogordenpago = mysql_query($query_inslogordenpago, $this->sala) or die("$query_inslogordenpago <br>" . mysql_error());
                                    }
                                    //CREA CUENTA CORREO
                                    $objetoclaveusuario = new GeneraClaveUsuario($numeroordenpago, $salaobjecttmp);

                                    $query_detalleprematricula = "UPDATE detalleprematricula
                                        set codigoestadodetalleprematricula = '30'
                                        where numeroordenpago = '$numeroordenpago'
                                        and codigoestadodetalleprematricula like '1%'";
                                    $detalleprematricula = mysql_db_query($database_sala, $query_detalleprematricula) or die("$query_detalleprematricula" . mysql_error());

                                    $query_planes = "update ordenpagoplandepago
                                        set codigoindicadorprocesosap   = '300'
                                        WHERE numerorodencoutaplandepagosap = '" . $row_plan['numerorodencoutaplandepagosap'] . "'";
                                    $planes = mysql_db_query($database_sala, $query_planes) or die("$query_planes<br>" . mysql_error());

                                    $query_conceptoorden = "SELECT do.codigoconcepto
                                        FROM detalleordenpago do,concepto c
                                        WHERE do.numeroordenpago = '$numeroordenpago'
                                        AND do.codigoconcepto = c.codigoconcepto
                                        AND c.cuentaoperacionprincipal = '153'";
                                    $conceptoorden = mysql_db_query($database_sala, $query_conceptoorden) or die("$query_conceptoorden" . mysql_error());
                                    $totalRows_conceptoorden = mysql_num_rows($conceptoorden);
                                    $row_conceptoorden = mysql_fetch_array($conceptoorden);

                                    if ($row_conceptoorden <> "") { // if 2
                                        require_once('../funciones/funcion_inscribir.php');
                                        hacerInscripcion_mysql($numeroordenpago);
                                    }

                                    $query_ordenpago = "UPDATE ordenpago
                                        set codigoestadoordenpago = 4" . $digito . ",
                                        documentocuentaxcobrarsap = '$documentocuentaxcobrarsap',
                                        documentocuentacompensacionsap = '$documentocuentacompensacionsap',
                                        observacionordenpago = '" . $_REQUEST['busqueda_onservacion'] . " -- PAGA MANUALMENTE',
                                        fechapagosapordenpago = now()
                                        where numeroordenpago = '$numeroordenpago'";

                                    $ordenpago = mysql_db_query($database_sala, $query_ordenpago) or die("$query_ordenpago<br>" . mysql_error());

                                    $query_detalleorden = "SELECT d.codigoconcepto,d.valorconcepto,o.codigoperiodo,o.codigoestudiante
                                        FROM ordenpago o,detalleordenpago d
                                        WHERE o.numeroordenpago = '$numeroordenpago'
                                        AND o.numeroordenpago = d.numeroordenpago
                                        AND d.codigotipodetalleordenpago = 2";

                                    $detalleorden = mysql_query($query_detalleorden, $sala) or die(mysql_error());

                                    while ($row_detalleorden = mysql_fetch_assoc($detalleorden)) {
                                        $query_consultadvd = "SELECT iddescuentovsdeuda
                                            FROM descuentovsdeuda
                                            WHERE codigoestudiante = '" . $row_detalleorden['codigoestudiante'] . "'
                                            and codigoestadodescuentovsdeuda = '01'
                                            and codigoperiodo = '" . $row_detalleorden['codigoperiodo'] . "'
                                            and codigoconcepto = '" . $row_detalleorden['codigoconcepto'] . "'
                                            and valordescuentovsdeuda = '" . $row_detalleorden['valorconcepto'] . "'";
                                        $consultadvd = mysql_db_query($database_sala, $query_consultadvd) or die("$query_consultadvd" . mysql_error());
                                        $totalRows_consultadvd = mysql_num_rows($consultadvd);
                                        $row_respuestadvd = mysql_fetch_array($consultadvd);

                                        if ($row_respuestadvd <> "") {
                                            $base3 = "update descuentovsdeuda
                                                set  codigoestadodescuentovsdeuda = '03'
                                                where iddescuentovsdeuda = '" . $row_respuestadvd['iddescuentovsdeuda'] . "'";
                                            $sol3 = mysql_db_query($database_sala, $base3);
                                        }
                                    }
                                    $query_operacion = "select documentocuentaxcobrarsap
                                        from ordenpago
                                        WHERE numeroordenpago = '$numeroordenpago'";
                                    $operacion = mysql_db_query($database_sala, $query_operacion) or die("$query_operacion" . mysql_error());
                                    $totalRows_operacion = mysql_num_rows($operacion);
                                    $row_operacion = mysql_fetch_array($operacion);
                                }
                                ?>
                                <script language="JavaScript">
                                    alert("La orden ha sido pagada satisfactoriamente, por favor revisar");
                                </script>
                                <?php
                            } elseif (ereg("^4", $row_data['codigoestadoordenpago'])) {
                                ?>
                                <script language='javascript'>
                                    alert('ADVERTENCIA: Esta orden ya estaba paga, por lo tanto no se llevo a cabo ninguna operación');
                                    window.location.href = 'pagarorden.php';
                                </script>
                                <?php
                            } elseif (ereg("^2", $row_data['codigoestadoordenpago'])) {
                                ?>
                                <script language='javascript'>
                                    alert('ADVERTENCIA: Esta orden está anulada, por lo tanto no se permite realizar el pago');
                                    window.location.href = 'pagarorden.php';
                                </script>
                                <?php
                            }
                        } else {
                            ?>
                            <script language="JavaScript">
                                alert("La orden de pago ingresada no existe en SALA, por favor verifique el número de la orden");
                                window.location.href = 'pagarorden.php'
                            </script>
                            <?php
                        }
                    } else {
                        ?>
                        <script language="JavaScript">
                            alert("Debe digitar una observación");
                        </script>
                        <?php
                    }
                }
                ?>
            </form>
        </div>
    </body>
</html>