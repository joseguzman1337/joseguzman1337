<?php
header('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

ini_set('display_errors', 'On');
set_time_limit(0);

session_start();
include '../tools/includes.php';

if ($_POST) {
    $keys_post = array_keys($_POST);
    foreach ($keys_post as $key_post) {
        $$key_post = $_POST[$key_post];
    }
}

if ($_GET) {
    $keys_get = array_keys($_GET);
    foreach ($keys_get as $key_get) {
        $$key_get = $_GET[$key_get];
    }
}

if (isset($_SESSION["datoSesion"])) {
    $user = $_SESSION["datoSesion"];
    $idPersona = $user[0];
    $luser = $user[1];
    $lrol = $user[3];
    $persistencia = new Singleton( );
    $persistencia = $persistencia->unserializar($user[4]);
    $persistencia->conectar();
} else {
    header("Location:error.php");
}

include '../control/ControlRegistroGrado.php';
include '../control/ControlCarrera.php';

$controlRegistroGrado = new ControlRegistroGrado($persistencia);
?>

<?php
switch ($tipoOperacion) {

    case "buscar":
        $numeroPromocion = $controlRegistroGrado->buscarPromocion($cmbCarreraPromocion, $cmbPeriodoPromocion, $cmbTipoGradoPromocion);
        if ($numeroPromocion->getContadorRegistros() != 0) {
            ?>
            <script src="../js/MainPromocion.js"></script>

            <form id="formPromocionActualizar">
                <p>
                    <input type="hidden" id="codigoCarrera" name="codigoCarrera" value="<?php echo $cmbCarreraPromocion?>" />
                    <input type="hidden" id="codigoPeriodo" name="codigoPeriodo" value="<?php echo $cmbPeriodoPromocion; ?>" />
                    <input type="hidden" id="tipoGrado" name="tipoGrado" value="<?php echo $cmbTipoGradoPromocion; ?>" />
                </p>

                <br />
                <br />
                <br />
                <table width="40%" border="0" align="center">
                    <tr valign="top">
                        <td>
                            <fieldset>
                                <legend>Actualizar Promoción Carrera</legend>
                                <br />
                                <table width="100%">
                                     <tr>
                                        <td>Periodo</td>
                                        <td><?php echo $cmbPeriodoPromocion?></td>
                                    </tr>
                                     <tr>
                                        <td>Carrera</td>
                                        <td>
                                            <?php 
                                                $carrera =new ControlCarrera($persistencia);
                                                $codigoCarrera = $carrera->buscarCarrera($cmbCarreraPromocion);
                                                echo $codigoCarrera->getNombreCarrera(); 
                                            ?>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Número de promocion</td>
                                        <td><input type="text" value="<?php echo $numeroPromocion->getNumeroPromocion() ?>" id="numeroPromocion" name="numeroPromocion"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center"><br>
                                            <a id="btnActualizarPromocion">Actualizar</a>
                                        </td>
                                    </tr>
                                </table>
                                <br />
                            </fieldset>
                        </td>
                    </tr>
                </table>
                <br />
                </br>

            </form>
            <?php
        } else {
            echo "0";
        }
        break;

    case "actualizar":
        $actualizar=$controlRegistroGrado->actualizarPromocion($codigoCarrera, $codigoPeriodo, $tipoGrado, $numeroPromocion );
        echo $actualizar;
        break;
}
