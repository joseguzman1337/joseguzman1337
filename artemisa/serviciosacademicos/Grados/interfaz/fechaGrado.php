<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
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

if ($lrol != 25 && $lrol != 53 && $lrol != 89) {
    $facultades = $controlFacultad->consultar($idPersona);
} else {
    $facultades = $controlFacultad->consultarFacultad();
}

$cuentaFacultad = count($facultades);
$tipoGrados = $controlTipoGrado->consultarTipoGrado();
?>



<script src="../js/MainFechaGrado.js"></script>
<script src="../js/MainCarrera.js"></script>
<form id="formFechaGrado">
    <p>
        <input type="hidden" id="txtIdRol" name="txtIdRol" value="<?php echo $lrol; ?>" />
        <input type="hidden" id="txtCuentaFacultadE" name="txtCuentaFacultadE" value="<?php echo $cuentaFacultad; ?>" />
    </p>
    <fieldset>
        <legend align="right" >Registro de Fechas de Grado de los Programas de la Facultad</legend>
        <br />
        <table width="100%" border="0">
            <tr valign="top">
                <td>
                    <fieldset style="margin-left: 20px;">
                        <legend>Registrar Grado</legend>
                        <br />
                        <table width="100%" border="0">
                            <tr>
                                <td id="tdFacultad">Facultad</td>
                                <td id="tdCmbFacultad"><select id="cmbFacultad" name="cmbFacultad" class="campobox">
                                        <option value="-1">Seleccione la Facultad</option>
<?php foreach ($facultades as $facultad) { ?>
                                            <option value="<?php echo $facultad->getCodigoFacultad(); ?>"><?php echo $facultad->getNombreFacultad(); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>Programa</td>
                                <td><select id="cmbCarrera" name="cmbCarrera" class="campobox">
                                        <option value="-1">Seleccione la Carrera</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Fecha Máxima</td>
                                <td><input type="text" id="fechaMaxCumplimiento" name="fechaMaxCumplimiento"/>
                                <td>Fecha de Ceremonia de Grado</td>
                                <td><input type="text" id="fechaGraduacion" name="fechaGraduacion" />
                                    <input type="hidden" id="idfechaGrado" name="idfechaGrado" /></td>
                            </tr>
                            <tr>
                                <td>Período</td>
                                <td><select id="cmbPeriodo" name="cmbPeriodo" class="campobox">
                                        <option value="-1">Seleccione el Período</option>
                                        <?php foreach ($periodos as $periodo) { ?>
                                        <option value="<?php echo $periodo->getCodigo(); ?>"><?php echo $periodo->getNombrePeriodo(); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>Tipo Grado</td>
                                <td><select id="cmbTipoGrado" name="cmbTipoGrado" class="campobox gradoTipo">
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
    </br>
    <div align="left">
        <a id="btnRegistrarFGrado">Registrar</a>
        <a id="btnBuscarRFGrado">Consultar</a>
        <a id="btnActualizarFGrado">Actualizar</a>	
        <a id="btnRestaurarRFGrado">Restaurar</a>
    </div>
    <br />
</form>
<div style="overflow: auto; width: 100%; top: 0px; height: 100%px">
    <table width="100%" >
        <tbody id="TablaFechaGrado" class="listaRadicaciones">
        </tbody>
    </table>
    <br />
</div>
<div id="mensageFechaGrado" align="center"><br /><br />¿Desea agregar la fecha de Grado?</div>