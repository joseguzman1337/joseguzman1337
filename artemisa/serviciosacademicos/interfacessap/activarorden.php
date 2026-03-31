<?php

is_file(dirname(__FILE__) . "/../../sala/includes/adaptador.php")
    ? require_once(dirname(__FILE__) . "/../../sala/includes/adaptador.php")
    : require_once(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));

// require_once('../Connections/sala2.php');
/**
 * Caso 278.
 * Se incluye el archivo adaptador para tener acceso a las funciones basicas de
 * del nuevo sala si la aplicacion se corre en un entorno local o de pruebas
 * se activa la visualizacion de todos los errores de php
 * @modified Dario Gaulteros Castro <castroluisd@unbosque.edu.do>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 18 de febrero 2019.
 */
// require_once(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));
/**
 * El metodo Factory::validateSession($variables) hace una validacion de session activa en el sistema
 * dependiendo de los parametros que se le envíen, si determina que la session acabo redirige el sistema al login
 */
Factory::validateSession($variables);
$usuario = Factory::getSessionVar('usuario');

require_once('../Connections/sala2.php');
//mysql_select_db($database_sala, $sala);
require_once('../funciones/funcionip.php');
require_once('../funciones/zfica_sala_crea_aspirante.php');
require_once('../funciones/zfica_crea_estudiante.php');
require_once('../funciones/clases/autenticacion/redirect.php');
require_once('controlador/ActivarOrdenControl.php');
require_once('modelo/ActivarOrdenModelo.php');

/**
 * Caso 278.
 * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
 * Ajuste de acceso por usuario por la opción de Gestion de Permisos.
 * @since 21 de Febrero 2019.
*/
$itemId = Factory::getSessionVar('itemId');
require_once('../../assets/lib/Permisos.php');
if (!Permisos::validarPermisosComponenteUsuario($usuario, $itemId)) {
   header("Location: " . HTTP_ROOT . "/serviciosacademicos/GestionRolesYPermisos/index.php?option=error");
    exit();
}
/*
 * ESTA OPCIÓN Activará Ordenes que se encuentren en los siguientes estados:
 * 20 Anulada
 * 21 Anulada Reemplazo
 * 22 Anulada Creada Precierre
 * 24 Anula Plan de Pagos
 */
   ?>
    <html>
        <head>
            <title>Activación de ordenes de pago</title>
        </head>
        <link rel="stylesheet" src=""
        <?php
        echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/bootstrap.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/sweetalert.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/plugins/materialize/css/materialize.min.css");
        //cho Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-page.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/font-awesome.css");

        //echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/general.css");
        echo Factory::printImportJsCss("js",HTTP_ROOT."/sala/assets/js/jquery-3.1.1.js");
        echo Factory::printImportJsCss("js",HTTP_ROOT."/sala/assets/js/bootstrap.js");
        echo Factory::printImportJsCss("js",HTTP_ROOT."/sala/assets/js/sweetAlert/sweetalert.min.js");
        echo Factory::printImportJsCss("js",HTTP_ROOT."/sala/assets/plugins/materialize/js/materialize.min.js");

        ?>
        <script src="assets/js/activarOrden.js"></script>
        <body>
            <div class="container">

                <div class="col s12 m8 offset-m2 l6 offset-l3 z-depth-4">
                    <div class="card-panel grey lighten-5 z-depth-1">
                        <div class="row valign-wrapper">
                            <div class="col s12">
                              <span class="black-text">
                                <h5>Si se va activar una orden de matrícula por favor comunicarse con la facultad para que vuelvan a generar la carga del estudiante, informar esto después de activar la orden.</h5>
                              </span>
                                <p class="Estilo4" align="left">ACTIVAR ORDEN DE PAGO</p>
                                <p class="Estilo4" align="left">Esta Opción Activará Ordenes que se encuentren en los siguientes estados:</p>
                                <p class="Estilo4" align="left">20 Anulada<br>21 Anulada Reemplazo<br>22 Anulada Creada Precierre<br>24 Anula Plan de Pagos</p>

                            </div>
                        </div>
                    </div>
                </div>
               <br>
                <form name="f1" id="f1" action="activarorden.php" method="post"">
                    <div class="row">
                        <div class="col s6">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="number" name='busqueda_numero' id='busqueda_numero' class="autocomplete" required>
                                    <label for="busqueda_numero">Numero Orden</label>
                                </div>
                            </div>
                        </div>
                        <div class="col s6">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" name='busqueda_observacion' id='busqueda_observacion' class="autocomplete" required>
                                    <label for="busqueda_observacion">Observacion</label>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="col s12">
                        <div class="input-field col s12">
                            <button class="btn btn-fill-green-XL first"  name="buscar" id="buscar" >Activar</button>
                        </div>
                    </div>
                </div>
                </form>
                <div id="preLoad" hidden>
                    <div class="progress">
                        <div class="indeterminate"></div>
                    </div>
                </div>

            </div>
            <?php
            if (isset($_POST['busqueda_numero'])) {
                $validaorden = ActivarOrdenControl::ctrActivaOrdenPago();
                echo '<script language="javascript">swal('.$validaorden.');</script>';
            }
            ?>
        </body>
</html>

