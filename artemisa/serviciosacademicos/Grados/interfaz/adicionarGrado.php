<?php

header('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_start();
include '../tools/includes.php';
include '../control/ControlItem.php';
include '../control/ControlPeriodo.php';
include '../control/ControlFacultad.php';
include '../control/ControlTipoGrado.php';
include '../control/ControlDirectivo.php';

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
$controlDirectivo = new ControlDirectivo($persistencia);

$periodos = $controlPeriodo->consultar();

if ($lrol != 25 && $lrol != 53 && $lrol != 89) {
    $facultades = $controlFacultad->consultar($idPersona);
} else {
    $facultades = $controlFacultad->consultarFacultad();
}
$cuentaFacultad = count($facultades);
$tipoGrados = $controlTipoGrado->consultarTipoGrado();
?>
<script src="../js/MainAdicionarGrado.js"></script>
<script src="../js/MainCarrera.js"></script>
<form id="adicionarGrado">
    <p>
        <input type="hidden" id="txtIdRolU" name="txtIdRolU" value="<?php echo $lrol; ?>" />
        <input type="hidden" id="txtCuentaFacultadEU" name="txtCuentaFacultadEU" value="<?php echo $cuentaFacultad; ?>" />
    </p>
    <fieldset>
        <legend align="right" >Registro de Grado</legend>
        <br />
        <table width="100%" border="0">
            <tr valign="top">
                <td>
                    <fieldset style="margin-left: 20px;">
                        <legend>Registrar</legend>
                        <br />
                        <table width="100%" border="0">
                            <tr>
                                <td id="tdFacultad">Facultad</td>
                                <td id="tdCmbFacultad"><select id="cmbFacultadDistancia" name="cmbFacultadDistancia" class="campobox">
                                        <option value="-1">Seleccione la Facultad</option>
                                        <?php
                                        foreach ($facultades as $facultad) {
                                            ?>
                                            <option value="<?php echo $facultad->getCodigoFacultad(); ?>"><?php echo $facultad->getNombreFacultad(); ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>Programa</td>
                                <td><select id="cmbCarreraDistancia" name="cmbCarreraDistancia" class="campobox">
                                        <option value="-1">Seleccione la Carrera</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Período</td>
                                <td><select id="cmbPeriodoDistancia" name="cmbPeriodoDistancia" class="campobox fechagrado">
                                        <option value="-1">Seleccione el Período</option>
                                        <?php foreach ($periodos as $periodo) { ?>
                                            <option value="<?php echo $periodo->getCodigo(); ?>"><?php echo $periodo->getNombrePeriodo(); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>Tipo Grado</td>
                                <td><select id="cmbTipoGradoDistancia" name="cmbTipoGradoDistancia" class="campobox fechagrado">
                                        <option value="-1">Seleccione el Tipo de Grado</option>
                                        <?php foreach ($tipoGrados as $tipoGrado) { ?>
                                            <option value="<?php echo $tipoGrado->getIdTipoGrado(); ?>"><?php echo $tipoGrado->getNombreTipoGrado(); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Fecha Grado</td>
                                <td><select id="cmbFechaGradoDistancia" name="cmbFechaGradoDistancia" class="campobox">
                                        <option value="-1">Seleccione Fecha de Grado</option>
                                    </select>
                                </td>
                                <td>Numero de acuerdo</td>
                                <td>
                                    <?php
                                    $directivo = $controlDirectivo->buscarSecretarioGeneralId();
                                    ?>
                                    <input type="hidden" id="idDirectivo" name="directivo" value="<?php echo $directivo->getIdDirectivo(); ?>">
                                    <input type="text" id="idNumeroAcuerdo" class="numero" name="idNumeroAcuerdo" value="">
                                </td>
                            </tr>
                            <tr>
                                <td>Numero de acta</td>
                                <td>
                                    <input type="text" id="numeroActa" class="numero" name="numeroActa" value="">
                                </td>
                                <td>Fecha de acuerdo</td>
                                <td>
                                    <input type="text" id="fechaAcuerdo"  name="fechaAcuerdo">
                                </td>
                            </tr>
                            <tr>
                                <td>Numero de acta CF</td>
                                <td>
                                    <input type="text" id="numeroActaCF" class="numero"  name="numeroActaCF" value="">
                                </td>
                                <td>Fecha de acta CF</td>
                                <td>
                                    <input type="text" id="fechaAcuerdoCF" name="fechaAcuerdoCF" >
                                </td>
                            </tr>
                            <tr>
                                <td>N° Diploma</td>
                                <td>
                                    <input type="text" id="numeroDiploma" class="numero" name="numeroDiploma" value="" >
                                </td>
                                <td>Numero documento</td>
                                <td>
                                    <input type="text" id="numeroDocumento" name="numeroDocumento" value="">
                                    <a id="btnConsultarEstudiante">Buscar</a>
                                </td>

                            </tr>

                            <tr>
                                <td>Nombre</td>
                                <td>
                                    <input type="hidden" id="codigoEstudiante" name="codigoEstudiante" value="">
                                    <input type="text" id="nombre" name="nombre" value="" size="60" readonly="">
                                </td>
                                <td></td>
                                <td>
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
        <a id="btnAdicionarGrado">Registrar</a>
        <a id="btnRestaurarAGrado">Restaurar</a>
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