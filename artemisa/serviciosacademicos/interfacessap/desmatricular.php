<?php
/**
 * Caso 278.
 * Se incluye el archivo adaptador para tener acceso a las funciones basicas de
 * del nuevo sala si la aplicacion se corre en un entorno local o de pruebas 
 * se activa la visualizacion de todos los errores de php
 * @modified Dario Gaulteros Castro <castroluisd@unbosque.edu.do>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 21 de febrero 2019.
 */
require_once(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));

/**
 * El metodo Factory::validateSession($variables) hace una validacion de session activa en el sistema
 * dependiendo de los parametros que se le envíen, si determina que la session acabo redirige el sistema al login
 */

Factory::validateSession($variables);

$usuario = Factory::getSessionVar('usuario');

require('../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
require_once('../funciones/funcionip.php');
require_once('../funciones/clases/autenticacion/redirect.php');


$itemId = Factory::getSessionVar('itemId');
/**
 * Caso 370.
 * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
 * Ajuste de acceso por usuario por la opción de Gestion de Permisos.
 * @since 18 de Febrero 2019.
*/
require_once('../../assets/lib/Permisos.php');
if (!Permisos::validarPermisosComponenteUsuario($usuario, $itemId)) {
    header("Location: " . HTTP_ROOT . "/serviciosacademicos/GestionRolesYPermisos/index.php?option=error");
    exit();
}


?>
    <html>
        <head>
            <title></title>
            <style type="text/css">
                .Estilo1 {font-family: tahoma}
                .Estilo2 {font-size: x-small}
                .Estilo3 {font-size: xx-small}
                .Estilo4 {
                    font-size: 14px;
                    font-weight: bold;
                }
                .Estilo6 {font-size: 12px}
                .Estilo8 {font-size: 12px; font-weight: bold; }
            </style>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">    
        </head>
        <body>
            <div align="center" class="Estilo1">
                <form name="f1" action="desmatricular.php" method="get" onSubmit="return validar(this)">
                    <h1 align="left">Desmatricular Orden de Pago Por Concepto de Matrícula</h1>
                    <p class="Estilo4" align="left">(Problema que ocurre cuando un estudiante no ha traido los soportes para legalizar la financiacion)</p>
                    <table width="700" border="1" bordercolor="#003333" align="left">
                        <tr>
                            <td><span class="Estilo8">Número de Orden : <input name='busqueda_numero' type='text' value="<?php echo $_REQUEST['busqueda_numero']; ?>">
                                </span></td>
                            <td><span class="Estilo8">Observación : <input name='busqueda_onservacion' type='text'>
                                </span></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><span class="Estilo3">
                                    <input name="buscar" type="submit" value="Ejecutar">
                                    &nbsp;</span></td>
                        </tr>
                    </table>
                    <?php
                    if (isset($_REQUEST['buscar'])) {
                        if ($_REQUEST['busqueda_onservacion'] != '') {
                            $numeroordenpago = $_REQUEST['busqueda_numero'];
                            $query_data = "SELECT o.*
                            FROM ordenpago o, detalleordenpago do, concepto c
                            WHERE o.numeroordenpago = '$numeroordenpago'
                            and o.numeroordenpago = do.numeroordenpago
                            and c.codigoconcepto = do.codigoconcepto
                            and (c.cuentaoperacionprincipal = '151' or c.cuentaoperacionprincipal = '153')";
                            
                            $data = mysql_query($query_data, $sala) or die(mysql_error());
                            $row_data = mysql_fetch_assoc($data);
                            $totalRows_data = mysql_num_rows($data);
                           
                            $digito = ereg_replace("^[0-9]{1,1}", "", $row_data['codigoestadoordenpago']);

                            if ($row_data <> "") { //if 2
                                if (ereg("^4", $row_data['codigoestadoordenpago'])) {
                                    $query_prematricula = "UPDATE prematricula p, ordenpago o
                                    set p.codigoestadoprematricula = 1" . $digito . "
                                    where 
                                    o.codigoestudiante = p.codigoestudiante
                                    and o.numeroordenpago = '$numeroordenpago'
                                    and o.codigoperiodo = p.codigoperiodo";
                                    
                                    $prematricula = mysql_db_query($database_sala, $query_prematricula) or die("$query_prematricula<br>" . mysql_error());

                                    
                                    $query_ordenpago = "UPDATE ordenpago
                                    set codigoestadoordenpago = 1" . $digito . ",
                                    observacionordenpago = '" . $_REQUEST['busqueda_onservacion'] . " -- DESMATRICULADA POR FALTA DE GARANTIAS',
                                    fechapagosapordenpago = now()
                                    where numeroordenpago = '$numeroordenpago'";
                                    
                                    $ordenpago = mysql_db_query($database_sala, $query_ordenpago) or die("$query_ordenpago<br>" . mysql_error());

                                    // Cada vez que se modifique una orden de pago guardar en logordenpago si existe sesión de usuario
                                    if (isset($_SESSION['MM_Username'])) {
                                        $query_id = "select idusuario
                                        from usuario
                                        where usuario = '" . $_SESSION['MM_Username'] . "'";
                                        $id = mysql_db_query($database_sala, $query_id) or die("$query_id <br>" . mysql_error());
                                        $row_id = mysql_fetch_assoc($id);

                                        $idusuario = $row_id['idusuario'];

                                        $query_inslogordenpago = "INSERT INTO logordenpago(idlogordenpago, fechalogordenpago, observacionlogordenpago, numeroordenpago, idusuario, ip)
                    VALUES(0, now(), '" . $_REQUEST['busqueda_onservacion'] . " -- DESMATRICULADA POR FALTA DE GARANTIAS', '$numeroordenpago', '$idusuario', '" . tomarip() . "')";
                                        
                                        $query_inslogordenpago = mysql_db_query($database_sala, $query_inslogordenpago) or die("$query_inslogordenpago <br>" . mysql_error());
                                    } else {
                                        $query_inslogordenpago = "INSERT INTO logordenpago(idlogordenpago, fechalogordenpago, observacionlogordenpago, numeroordenpago, idusuario, ip)
                    VALUES(0, now(), '" . $_REQUEST['busqueda_onservacion'] . " -- DESMATRICULADA POR FALTA DE GARANTIAS', '$numeroordenpago', '2', '" . tomarip() . "')";
                                      
                                        $query_inslogordenpago = mysql_db_query($database_sala, $query_inslogordenpago) or die("$query_inslogordenpago <br>" . mysql_error());
                                    }
                                    //Actualiza la prematricula a (10) cuando este matriculada (30).
                                    $query_detalleprematricula = "UPDATE detalleprematricula
                                    set codigoestadodetalleprematricula = '10'
                                    where numeroordenpago = '$numeroordenpago'
                                    and codigoestadodetalleprematricula like '3%'";
                                                                       
                                    $detalleprematricula = mysql_db_query($database_sala, $query_detalleprematricula) or die("$query_detalleprematricula<br>" . mysql_error());

                                    ?>
                                    <script language="JavaScript">
                                        alert("La orden ha sido desmatriculada satisfactoriamente, por favor revisar");
                                    </script>
                                    <?php
                                } elseif (ereg("^1", $row_data['codigoestadoordenpago'])) {
                                    ?>
                                    <script language='javascript'>
                                        alert('ADVERTENCIA: Esta orden ya estaba activa, por lo tanto no se llevo a cabo ninguna operación');
                                        window.location.href = 'desmatricular.php';
                                    </script>
                                    <?php
                                } elseif (ereg("^2", $row_data['codigoestadoordenpago'])) {
                                    ?>
                                    <script language='javascript'>
                                        alert('ADVERTENCIA: Esta orden está anulada, por lo tanto no se permite realizar ninguna operación');
                                        window.location.href = 'desmatricular.php';
                                    </script>
                                    <?php
                                }
                            } else {
                                ?>
                                <script language="JavaScript">
                                    alert("La orden de pago ingresada no existe en SALA, por favor verifique el número de la orden");
                                    window.location.href = 'desmatricular.php'
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