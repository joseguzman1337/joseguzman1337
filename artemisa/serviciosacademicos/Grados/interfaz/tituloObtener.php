<?php
/**
 * @author Diego Fernando Rivera <riveradeigo@unbosque.edu.co>
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
include '../control/ControlFacultad.php';

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

$controlFacultad = new ControlFacultad($persistencia);
$facultades = $controlFacultad->consultarFacultad();
?>
<script src="../js/MainTitulo.js"></script>
<form id="formTitulo">
    <fieldset>
        <legend>Titulo a obtener</legend>
        <br />
        <table width="100%" border="0">
            <tr valign="top">
                <td>
                    <fieldset>
                        <legend>Consultar programa</legend>
                        <br />
                        <table width="100%">
                            <tr>
                                <td >Facultad</td>
                                <td ><select id="cmbFacultadTitulo" name="cmbFacultadTitulo" class="campobox">
                                        <option value="-1">Seleccione la Facultad</option>
                                        <?php foreach ($facultades as $facultad) { ?>
                                            <option value="<?php echo $facultad->getCodigoFacultad(); ?>"><?php echo $facultad->getNombreFacultad(); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>Programa</td>
                                <td><select id="cmbCarreraTitulo" name="cmbCarreraTitulo" class="combobox">
                                        <option value="-1">Seleccione la Carrera</option>
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
    <div>
    <div style="float:left">
        <a id="btnBuscarTitulo">Consultar</a>
        <a id="btnRestaurarTitulo">Restaurar</a>
    </div>
</form>
<br />
<br />
<div align="right" id="reportePaginadorTitulo"></div>

