<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 */
ini_set('display_errors', 'On');

session_start();

require_once('../../../assets/lib/Permisos.php');
$permisoEditar = Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 610, "editar") || Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 607, "editar");

include '../tools/includes.php';

include '../control/ControlRender.php';
include '../control/ControlItem.php';
include '../control/ControlPeriodo.php';
include '../control/ControlLineaEstrategica.php';
include '../control/ControlPrograma.php';
include '../control/ControlProyecto.php';
include '../control/ControlIndicador.php';
include '../control/ControlMeta.php';
include '../control/ControlTipoIndicador.php';
include '../control/ControlProgramaProyecto.php';


if ($_POST) {
    $keys_post = array_keys($_POST);
    foreach ($keys_post as $key_post) {
        if (is_array($_POST[$key_post])) {
            $$key_post = $_POST[$key_post];
        } else {
            $$key_post = strip_tags(trim($_POST[$key_post]));
        }
    }
}

if ($_GET) {
    $keys_get = array_keys($_GET);
    foreach ($keys_get as $key_get) {
        if (is_array($_GET[$key_get])) {
            $$key_get = $_GET[$key_get];
        } else {
            $$key_post = strip_tags(trim($_GET[$key_get]));
        }
    }
}

if (isset($_SESSION["datoSesion"])) {
    $user = $_SESSION["datoSesion"];
    $idPersona = $user[0];
    $luser = $user[1];
    $lrol = $user[3];
    $txtCodigoFacultad = $user[4];
    $persistencia = new Singleton( );
    $persistencia = $persistencia->unserializar($user[5]);
    $persistencia->conectar();
} else {
    header("Location:error.php");
}
$controlLineaEstrategica = new ControlLineaEstrategica($persistencia);
$controlMeta = new ControlMeta($persistencia);

$lineaEstrategicas = $controlLineaEstrategica->consultarLineaEstrategica();

$metaPlanDesarrollo = $controlMeta->buscarMetaPlanDesarrollo($txtIdMetaPrincipal);

$txtIdPrograma = $metaPlanDesarrollo->getProgramaProyecto()->getPrograma()->getIdProgramaPlanDesarrollo();
$txtIdProyecto = $metaPlanDesarrollo->getProgramaProyecto()->getProyecto()->getProyectoPlanDesarrolloId();
$txtIdIndicador = $metaPlanDesarrollo->getIndicador()->getIndicadorPlanDesarrolloId();

$cuentaMetaSecundaria = $controlMeta->cuentaMetaSecundarias($txtIdMetaPrincipal);
$sumaAlcanceMetasSecundaria = $controlMeta->alcanceMetasSecundarias($txtIdMetaPrincipal);
$valoresMetaSecundaria = $sumaAlcanceMetasSecundaria->getValorMetaSecundaria();
?>


<script src="../js/MainActualizar.js"></script>

<script>
    $(document).ready(function () {
        $('.campoNumeros').keyup(function () {
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        });
    });
</script>


<form id="formActualizar" >
    <p>
        <input type="hidden" id="tipoOperacion" name="tipoOperacion" value="actualizar" />
        <input type="hidden" id="txtIdMetaPrincipal" name="txtIdMetaPrincipal" value="<?php echo $txtIdMetaPrincipal; ?>" />
        <input type="hidden" id="txtIdPrograma" name="txtIdPrograma" value="<?php echo $txtIdPrograma; ?>" />
        <input type="hidden" id="txtIdProyecto" name="txtIdProyecto" value="<?php echo $txtIdProyecto; ?>" />
        <input type="hidden" id="txtIdIndicador" name="txtIdIndicador" value="<?php echo $txtIdIndicador; ?>" />
        <input type="hidden" id="txtNumeroMetaSecundaria" name="txtNumeroMetaSecundaria" value="<?php echo $cuentaMetaSecundaria; ?>" />
        <input type="hidden" id="txtValoresMetaSecundaria" name="txtValoresMetaSecundaria" value="<?php echo $valoresMetaSecundaria; ?>" />
    </p>
    <fieldset>
        <legend>Actualizar Plan de Desarrollo</legend>
        <table width="100%" border="0">
            <tr>
                <td>
                    <table width="100%" border="0">
                        <tr>
                            <td width="27%">Línea Estratégica</td>
                            <td width="73%">
                                <select id="cmbLineaActualizaEstrategica" name="cmbLineaActualizaEstrategica">
                                    <option value="-1">Seleccionar</option>
                                    <?php foreach ($lineaEstrategicas as $lineaEstrategica) { ?>
                                        <option
                                        <?php
                                        if ($lineaEstrategica->getIdLineaEstrategica() == $metaPlanDesarrollo->getProgramaProyecto()->getPrograma()->getLineaEstrategica()->getIdLineaEstrategica()) {
                                            echo "selected=\"selected\"";
                                        } else {
                                            echo 'disabled="disabled"';
                                        }
                                        ?> value="<?php echo $lineaEstrategica->getIdLineaEstrategica(); ?>">
                                            <?php
                                                echo $lineaEstrategica->getNombreLineaEstrategica();
                                                ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                    <div id="dvPrograma">
                        <table width="100%" border="0">
                            <tr>
                                <td width="27%">Programa</td>
                                <td width="73%"><input type="text" class="lectura" id="txtActualizaPrograma"  name="txtActualizaPrograma" readonly value="<?php echo $metaPlanDesarrollo->getProgramaProyecto()->getPrograma()->getNombrePrograma(); ?>" /><img id="addPrograma" class="addPrograma" src="../css/images/plusAzul.png" width="24" height="24" /></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>

                        <table width="100%" border="0">
                            <tr>
                                <td>
                                    <div id="dvDetallePrograma" style="display: none;">
                                        <fieldset>
                                            <legend>Detalles Programa</legend>
                                            <table width="100%" border="0">
                                                <tr>
                                                    <td width="20%"><span>Justificación:</span></td>
                                                    <td width="80%"><textarea id="justifiActualizaPrograma" class="lectura" name="justifiActualizaPrograma" rows="3" cols="200" readonly><?php echo $metaPlanDesarrollo->getProgramaProyecto()->getPrograma()->getJustificacionProgramaPlanDesarrollo(); ?></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td><span>Descripción:</span></td>
                                                    <td><textarea id="descActualizaPrograma" name="descActualizaPrograma" class="lectura" rows="3" readonly><?php echo $metaPlanDesarrollo->getProgramaProyecto()->getPrograma()->getDescripcionProgramaPlanDesarrollo(); ?></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td><span>Responsable:</span></td>
                                                    <td>
                                                        <div id="responsablePrograma">
                                                            <input type="text" id="txtResponsableActualizaPrograma"  name="txtResponsableActualizaPrograma" value="<?php echo $metaPlanDesarrollo->getProgramaProyecto()->getPrograma()->getResponsableProgramaPlanDesarrollo(); ?>" />
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td><span>Email:</span></td>
                                                    <td>
                                                        <div id="emailPrograma">
                                                            <input type="text" id="txtEmailPrograma"  name="txtEmailPrograma" value="<?php echo $metaPlanDesarrollo->getProgramaProyecto()->getPrograma()->getEmailResponsableProgramaPlanDesarrollo(); ?>" />
                                                            <br/><strong>"Para múltiples responsables,separar los correos con coma"</strong> 
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </table>
                                        </fieldset>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div id="dvProyecto">
                            <table width="100%" border="0">
                                <tr>
                                    <td width="27%"><span>Proyecto:</span></td>
                                    <td width="73%"><input type="text" id="txtActualizaProyecto" readonly class="lectura" name="txtActualizaProyecto" value="<?php echo $metaPlanDesarrollo->getProgramaProyecto()->getProyecto()->getNombreProyectoPlanDesarrollo(); ?>" /><img id="addProyecto" class="addPrograma" src="../css/images/plusAzul.png" width="24" height="24" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            <table width="100%" border="0">
                                <tr>
                                    <td>
                                        <div id="dvDetalleProyecto" style="display: none;">
                                            <fieldset>
                                                <legend>Detalles Proyecto</legend>
                                                <table width="100%" border="0">
                                                    <tr>
                                                        <td width="20%"><span>Justificación:</span></td>
                                                        <td width="80%"><textarea id="justifiActualizaProyecto" class="lectura"  readonly name="justifiActualizaProyecto" rows="3"><?php echo $metaPlanDesarrollo->getProgramaProyecto()->getProyecto()->getJustificacionProyecto(); ?></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Descripción:</span></td>
                                                        <td><textarea id="descActualizaProyecto" name="descActualizaProyecto" class="lectura" readonly rows="3"><?php echo $metaPlanDesarrollo->getProgramaProyecto()->getProyecto()->getDescripcionProyecto(); ?></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Objetivos:</span></td>
                                                        <td><textarea id="objActualizaProyecto" class="lectura" name="objActualizaProyecto" readonly rows="3"><?php echo $metaPlanDesarrollo->getProgramaProyecto()->getProyecto()->getObjetivoProyecto(); ?></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Acciones:</span></td>
                                                        <td><textarea id="accActualizaProyecto" class="lectura"  name="accActualizaProyecto" readonly  rows="3"><?php echo $metaPlanDesarrollo->getProgramaProyecto()->getProyecto()->getAccionProyecto(); ?></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>

                                                    <tr>
                                                        <td><span>Responsable:</span></td>
                                                        <td>
                                                            <div id="contenedorResponsable">
                                                                <input type="text" id="txtResponsableActualizaProyecto" name="txtResponsableActualizaProyecto" value="<?php echo $metaPlanDesarrollo->getProgramaProyecto()->getProyecto()->getResponsableProyecto(); ?>" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Email:</span></td>
                                                        <td>
                                                            <div id="emailProyecto">
                                                                <input type="text" id="txtEmailProyecto" name="txtEmailProyecto" value="<?php echo $metaPlanDesarrollo->getProgramaProyecto()->getProyecto()->getEmailResponsableProyecto(); ?>" />
                                                                <input type="hidden" id="txtEmailProyectoActual" name="txtEmailProyectoActual" value="<?php echo $metaPlanDesarrollo->getProgramaProyecto()->getProyecto()->getEmailResponsableProyecto(); ?>" />
                                                                <br/><strong>"Para múltiples responsables,separar los correos con coma"</strong> 
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>

                                                </table>
                                            </fieldset>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div id="dvIndicador">
                                <table width="100%" border="0">
                                    <tr>
                                        <td width="27%">Tipo Indicador:</td>
                                        <td width="35%"><input type="radio" id="ckTipoIndicadorActualizaCuantitativo" name="ckTipoIndicador" value="1" <?php if ($metaPlanDesarrollo->getIndicador()->getTipoIndicador()->getIdTipoIndicador() == "1") echo "checked"; ?> />Cuantitativo</td>
                                        <td width="38%"><input type="radio" id="ckTipoIndicadorActualizaCualitativo" name="ckTipoIndicador" value="2" <?php if ($metaPlanDesarrollo->getIndicador()->getTipoIndicador()->getIdTipoIndicador() == "2") echo "checked"; ?> />Cualitativo</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                                <table width="100%" border="0">
                                    <tr>
                                        <td width="27%">Indicador</td>
                                        <td width="73%"><input type="text" id="txtActualizaIndicador"  name="txtActualizaIndicador" value="<?php echo $metaPlanDesarrollo->getIndicador()->getNombreIndicador(); ?>" /><img id="addMeta" class="addPrograma" src="../css/images/plusAzul.png" width="24" height="24" /><!--<a id="btnMetaPrincipal" class="btnMetaPrincipal">+ Descripción Meta</a>--></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                                <table width="100%" border="0">
                                    <tr>
                                        <td>
                                            <div id="detalleIndicador" class="dvDetalleIndicador" style="display: none;">
                                                <fieldset>
                                                    <legend>Metas Indicador</legend>
                                                    <div id="dvMetaIndicador" class="dvMetaIndicador">
                                                        <br />
                                                        <table width="84%" border="0">
                                                            <tr>
                                                                <td width="30%">Descripción Meta</td>
                                                                <td width="70%"><input type="text" id="txtMetaActualizaPrincipal" name="txtMetaActualizaPrincipal" value="<?php echo $metaPlanDesarrollo->getNombreMetaPlanDesarrollo(); ?>" /> </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Fecha Vigencia Meta</td>
                                                                <td><input type="text" id="txtVigenciaActualizaMetaPrincipal" name="txtVigenciaActualizaMetaPrincipal" class="valor" value="<?php echo $metaPlanDesarrollo->getVigenciaMeta(); ?>" /> </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Meta a Alcanzar(Valor)</td>
                                                                <td><input type="text" id="txtValorMetaActualizaPrincipal"  name="txtValorMetaActualizaPrincipal" class="valor campoNumeros" value="<?php echo $metaPlanDesarrollo->getAlcanceMeta(); ?>" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                        <?php
                                                        if ($cuentaMetaSecundaria < 15) {
                                                            $cuenta = 15 - $cuentaMetaSecundaria;
                                                            ?>
                                                            <legend>Avances Anuales</legend>
                                                            <div style="text-align: center">
                                                                <?php
                                                                echo "<strong id='color'>Valor pendiente para alcanzar su Meta :<a id='pendiente'>" . ($metaPlanDesarrollo->getAlcanceMeta() - $valoresMetaSecundaria) . "</a></strong>";
                                                                ?>    
                                                            </div>  
                                                            <br>
                                                            <?php
                                                            echo "Recuerde que solo le restan por asociar " . $cuenta . " avance(s)";
                                                            ?> 
                                                            <br />
                                                            <br />
                                                            <table width="75%" border="0">
                                                                <tr>
                                                                    <td width="195">Descripcion del Avance:</td>
                                                                    <td><input type="text" id="txtActualizaMeta" name="txtActualizaMeta[]" class="txtNombreMeta" /><button id="btnAddMetaActualiza" class="btnAddMetaActualiza btn btn-warning"><i class="fa fa-plus-circle" aria-hidden="true"></i> Meta</button></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                            <table width="75%" border="0">
                                                                <tr>
                                                                    <td width="230">Fecha Inicio: </td>
                                                                    <td width="180"><input type="text" id="txtFechaActualizaInicioMeta" name="txtFechaActualizaInicioMeta[]"  /></td>
                                                                    <td width="92">Fecha Final: </td>
                                                                    <td width="180"><input type="text" id="txtFechaActualizaFinalMeta" name="txtFechaActualizaFinalMeta[]" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                            <table width="75%" border="0">
                                                                <tr>
                                                                    <td width="185">Avance Esperado:</td>
                                                                    <td width="388"><input type="text" id="txtActualizaValorMeta" name="txtActualizaValorMeta[]" class="valor campoNumeros acumulado" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Acciones:</td>
                                                                    <td><textarea id="txtActualizaAccionMeta" name="txtActualizaAccionMeta[]" rows="3"></textarea></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                </tr>

                                                                <tr>
                                                                    <td width="185">Responsable:</td>
                                                                    <td width="388"><input type="text" id="txtActualizaResponsableMeta" name="txtActualizaResponsableMeta[]" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="185">Email:</td>
                                                                    <td width="388"><input type="text" class="correos" id="txtemailResponsableMeta" name="txtemailResponsableMeta[]" /><br/><strong>"Para múltiples responsables,separar los correos con coma"</strong> </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                            <?php
                                                        } else {
                                                            echo "Ha completado el número de avances anuales permitidos para agregar";
                                                        }
                                                        ?>
                                                    </div>
                                                    <div id="dvAgregarMeta" class="dvAgregarMeta"></div>
                                                    <div style="text-align: center">
                                                        <strong><a id='pendienteMsg' style="color: red"></a></strong>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </fieldset>
</form>
<br />
<div>
    <?php
    /* 93 rol decano
     * 98 rol Director de Facultad
     * 99 rol Coordinador de Facultad
     * 102 rol apoyo decano
     * 101 rol planeacion
     * 96 rol Coordinador Linea estrategica
     */
    if ($permisoEditar) {
        if ($lrol == 93 or $lrol == 99 or $lrol == 98 or $lrol == 102 or $lrol == 101 or $lrol == 96) {
            ?>
            <button id="btnActualizarPlan" class="btn btn-warning">Guardar</button>
            <?php
        }
    }
    ?>
    <button id="btnCancelarActualizarPlan" class="btn btn-warning">Cancelar</button>

</div>
<div id="mensageActualizar" class="mensageRegistrar"><div>¿Desea Actualizar el Plan de Desarrollo?</div></div>
