<?php
/**
 * @author Diego Fernando Rivera <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 */
header('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
ini_set('display_errors', 'On');

session_start();

include '../tools/includes.php';
include '../control/ControlItem.php';
include '../control/ControlPeriodo.php';
include '../control/ControlFacultad.php';
include '../control/ControlTipoGrado.php';

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

$controlPeriodo = new ControlPeriodo($persistencia);
$controlFacultad = new ControlFacultad($persistencia);
$controlTipoGrado = new ControlTipoGrado($persistencia);

$periodos = $controlPeriodo->consultar();
$facultades = $controlFacultad->consultarFacultad();
$tipoGrados = $controlTipoGrado->consultarTipoGrado();
?>
<script src="../js/MainPromocion.js"></script>
<form id="formPromocion">
    <p>
        <input type="hidden" id="tipoOperacionPromocion" name="tipoOperacionPromocion" value="consultarPromocion" />
        <input type="hidden" id="txtIdRol" name="txtIdRol" value="<?php echo $lrol; ?>" />
    </p>
    <fieldset>
        <legend>Promoción Carrera</legend>
        <br />
        <table width="100%" border="0">
            <tr valign="top">
                <td>
                    <fieldset>
                        <legend>Consultar número de promoción carrera</legend>
                        <br />
                        <table width="100%">
                            <tr>
                                <td >Facultad</td>
                                <td ><select id="cmbFacultadPromocion" name="cmbFacultadPromocion" class="campobox">
                                        <option value="-1">Seleccione la Facultad</option>
                                        <?php foreach ($facultades as $facultad) { ?>
                                            <option value="<?php echo $facultad->getCodigoFacultad(); ?>"><?php echo $facultad->getNombreFacultad(); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>Programa</td>
                                <td><select id="cmbCarreraPromocion" name="cmbCarreraPromocion" class="combobox">
                                        <option value="-1">Seleccione la Carrera</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Período</td>
                                <td><select id="cmbPeriodoPromocion" name="cmbPeriodoPromocion" class="combobox">
                                        <option value="-1">Seleccione el Período</option>
                                        <?php foreach ($periodos as $periodo) { ?>
                                            <option value="<?php echo $periodo->getCodigo(); ?>"><?php echo $periodo->getNombrePeriodo(); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>Tipo Grado</td>
                                <td><select id="cmbTipoGradoPromocion" name="cmbTipoGradoPromocion" class="campobox">
                                        <option value="-1">Seleccione el Tipo de Grado</option>
                                        <?php foreach ($tipoGrados as $tipoGrado) { ?>
                                            <option value="<?php echo $tipoGrado->getIdTipoGrado(); ?>"><?php echo $tipoGrado->getNombreTipoGrado(); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <br />

                    </fieldset>
                </td>
            </tr>
        </table>
        <br />

    </fieldset>
    <div style="float:left">
        </br>
        <a id="btnBuscarPromocion">Consultar</a>
    </div>
    </br>
    </br>
    <div>
</form>
</div> 

<div align="right" id="formularioPromocion"></div>