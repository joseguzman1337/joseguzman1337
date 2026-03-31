
<script src="../tema/jquery.validate.js"></script>
<script src="../js/MainSeguimiento.js"></script>

<script>
    $(document).ready(function () {
        $('.campoNumeros').keyup(function () {
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        });
    });
</script>

<?php
require_once('../../../assets/lib/Permisos.php');

/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 */
ini_set('display_errors', 'On');

session_start();

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
include '../control/ControlActividadMetaSecundaria.php';
include '../control/controlAvancesIndicadorPlanDesarrollo.php';


if ($_POST) {
    $keys_post = array_keys($_POST);
    foreach ($keys_post as $key_post) {
        $$key_post = strip_tags(trim($_POST[$key_post]));
    }
}

if ($_GET) {
    $keys_get = array_keys($_GET);
    foreach ($keys_get as $key_get) {
        $$key_get = strip_tags(trim($_GET[$key_get]));
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
$permisoEditar = Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 610, "insertar") || Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 607, "editar");
$permisoInsertar = Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 610, "insertar") || Permisos::validarPermisosComponenteUsuario($_SESSION["MM_Username"], 607, "insertar");

$controlAvancesIndicadorPlanDesarrollo = new controlAvancesIndicadorPlanDesarrollo($persistencia);
$controlIndicador = new ControlIndicador($persistencia);

switch ($tipoOperacion) {

    case "registrarAvance":

        $indicador = $controlIndicador->consultarIndicador($txtProyectoPlanDesarrolloId);
        foreach ($indicador as $tipoDeIndicador) {
            $tipoIndicador = $tipoDeIndicador->getTipoIndicador()->getIdTipoIndicador();
        }

        $mensaje = "";
        if ($tipoIndicador != 1) {
            $mensaje = "Valor avanzado";
        } else {
            $mensaje = "Valor Avance";
        }
        ?>
        <div class="detalleMetaResponsable" >
            <form id="formObservaciones" class="form-horizontal">
                <input type="hidden" id="txtProyectoPlanDesarrolloId" name="txtProyectoPlanDesarrolloId" value="<?php echo $txtProyectoPlanDesarrolloId; ?>" />
                <input type="hidden" id="txtIndicadorPlanDesarrolloId" name="txtIndicadorPlanDesarrolloId" value="<?php echo $txtIndicadorPlanDesarrolloId; ?>" />
                <input type="hidden" id="tipoIndicador" name="tipoIndicador" value="<?php echo $tipoIndicadores ?>" />
                <fieldset>
                    <legend>Registrar Actividades de Avance</legend>
                    <div class="form-group ">
                        <label for="inputName" class=" col-xs-12 col-md-4">Acciones realizadas:</label>
                        <div class="col-xs-12 col-md-8">
                            <textarea id="txtNombreActividad" name="txtNombreActividad" class="form-control  rediTextArea" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputName" class=" col-xs-12 col-md-4"><?php echo $mensaje; ?>:</label>
                        <div class="col-xs-12 col-md-8">
                            <input type="text" id="txtAvancePropuesto" name="txtAvancePropuesto" class="form-control campoNumeros" value="" autocomplete="off" />
                        </div>
                    </div>
                    <?php
                    /**
                     * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
                     * Se agrega el mensaje (Meta del año: <?php echo $alcance; ?>) por solicittud de la Divison de calidad.
                     * @since Marzo 8, 2019
                     */
                    ?>
                    <div class="form-group">
                        <div class="col-xs-12 col-md-4"></div>
                        <label for="inputName" class=" col-xs-12 col-md-8">(Meta del año: <?php echo $alcance; ?>)</label>
                    </div>	

                    <div class="form-group">
                        <label for="inputName" class=" col-xs-12 col-md-4">Fecha Actividad:</label>
                        <div class="col-xs-12 col-md-8">
                            <input type="text" id="txtFechaActividad" name="txtFechaActividad" value="" autocomplete="off" readonly="" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputName" class=" col-xs-12 col-md-4">Evidencia:</label>
                        <div class="col-xs-12 col-md-3">
                            <input type="file"  multiple="multiple" id="txtFileAvance" name="txtFileAvance" class="form-control-file filestyle" data-buttonName="btn-warning"  accept=".pdf,text/plain,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        </div>
                        <div class="col-xs-12 col-md-5">(.doc, .docx, .txt, .xls, .xlsx, .pdf) </div>
                    </div>
                    <input type="hidden" id="alcanceMetaSecundaria" value="<?php echo $alcance; ?>" >
                    <input type="hidden" class="identificador" id="<?php echo $numerador; ?>" value="<?php echo $numerador; ?>" ><br />
                    <input type="hidden" class="identificadorMeta" id="<?php echo $numeradorMeta; ?>" value="<?php echo $numeradorMeta; ?>" name="idMetaPrincipal" >
                </fieldset>
                <br />
                <div class="form-group" align="right">
                    <?php
                    if ($permisoInsertar) {
                        ?>	
                        <button id="btnGuardarActividad" class="btn btn-warning">Guardar</button>
                        <?php
                    }
                    ?>
                    <button id="btnRestaurarActividad" class="btn btn-warning">Cancelar</button>
                </div>
            </form>
            <div id="confirmarAlcance">El avance registrado sobrepasa el valor de la meta para este año.<br> ¿Está seguro que desea continuar?</div>
        </div>
        <?php
        break;

    case "VerEvidencia":
        ?>
        <fieldset>
            <div>
                <label>Avances  realizados:</label>
            </div>
            <br />
            <table width="100%" border="0" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <td>
                            <table width="100%" border="0" align="center" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Fecha</th>
                                        <th>Actividad</th>
                                        <th>Avance</th>
                                        <th>Observacion</th>										
                                        <th>Evidencia</th>
                                        <th>Aprobación</th>
                                        <th>Actualizar</th>
                                    </tr>
                                </thead>
                                <?php
                                $avances = $controlAvancesIndicadorPlanDesarrollo->verAvancesIndicador($txtIndicadorPlanDesarrolloId);
                                $contador = 0;
                                foreach ($avances as $avancesIndicador) {
                                    $contador++;
                                    ?>
                                    <tr>
                                        <td><?php echo $contador; ?><input type="hidden"  id="idMetaSecundaria_<?php echo $contador ?>" value="<?php echo $avancesIndicador->getIndicadorPlanDesarrolloId() ?>"></td>
                                    <input type="hidden" value="<?php echo $idMetaPrincipal ?>" id="idMetaPrinciapl_<?php echo $contador ?>">	
                                    <td id="fecha_<?php echo $contador ?>"><?php echo $avancesIndicador->getFechaActividad(); ?></td>
                                    <td id="actividad_<?php echo $contador ?>"><?php echo $avancesIndicador->getActividad(); ?></td>
                                    <td id="avances_<?php echo $contador ?>"><?php echo $avancesIndicador->getValorAvance(); ?></td>
                                    <td id="observacion_<?php echo $contador ?>">
                                        <?php
                                        $observacion = $avancesIndicador->getObservaciones();
                                        $aprobacion = $avancesIndicador->getAprobacion();

                                        if ($observacion == "" and $aprobacion == '') {

                                            /* 93 Decanos de Facultades
                                             * 98 Director de Facultad
                                             * 99 Coordinador de Facultad
                                             * 102 apoyo decano
                                             * 101 planeacion
                                             */
                                            if ($lrol == 93 or $lrol == 98 or $lrol == 99 or $lrol == 102 or $lrol == 101) {
                                                ?>	
                                                <img id="imgAnexo" src="../css/images/documento.png" class="imgCursor" onclick="actualizarObservacion('<?php echo 'nuevaObservacion' ?>', '<?php echo $txtIndicadorPlanDesarrolloId ?>', '<?php echo $aprobacion ?>', '<?php echo $contador ?>')" />
                                                <?php
                                            }
                                        } else {
                                            echo $observacion;
                                        }
                                        ?>
                                    </td>
                                    <td id="descargar">
                                        <?php $cadena = mysql_escape_string($avancesIndicador->getActividad()); ?>
                                        <img id="imgAnexo" src="../css/images/pdf.png" width="20" height="20" class="imgCursor"  onclick="verEvidencias('<?php echo $txtIndicadorPlanDesarrolloId ?>', 'verAvances', '<?php echo $avancesIndicador->getFechaActividad(); ?>', '<?php echo htmlspecialchars($cadena); ?>', '<?php echo $avancesIndicador->getValorAvance(); ?>', '<?php echo $aprobacion ?>', '<?php echo $facultadPlan; ?>')"/></a>
                                    </td>
                                    <td id="aprobado_<?php echo $contador ?>">
                                        <?php
                                        if ($aprobacion == "" && $permisoEditar) {
                                            /* 93 Decanos de Facultades
                                             * 98 Director de Facultad
                                             * 99 Coordinador de Facultad
                                             * 102 apoyo decano
                                             * 101 planeacion
                                             */

                                            if ($lrol == 93 or $lrol == 99 or $lrol == 98 or $lrol == 101 or $lrol == 102) {
                                                ?>
                                                <div class="radio">
                                                    <label><input type="radio" name="aprobacion_<?php echo $contador ?>" class="aprobado" id="aprobadoS_<?php echo $contador; ?>" value="Aprobado">Aprobado</label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" name="aprobacion_<?php echo $contador ?>"  class="aprobado" id="aprobadoN_<?php echo $contador; ?>" value="No aprobado">No aprobado</label>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <p  align="center">	
                                                <?php
                                                echo $aprobacion . '<br>';
                                                if (( $lrol == 93 or $lrol == 98 or $lrol == 101 ) and $aprobacion == 'Aprobado') {
                                                    ?>
                                                    <img src="../css/images/eliminar.png"  class="aprobado" id="aprobadoE_<?php echo $contador; ?>"  value="Sinestadodeaprobacion">
                                                    <?php
                                                }
                                                ?>
                                            </p>
                                            <?php
                                        }
                                        ?>									 		
                                    </td>
                                    <td id="estado_<?php echo $avancesIndicador->getIdAvancesIndicadorPlanDesarrollo() ?>">
                                        <?php
                                        $estado = $avancesIndicador->getAprobacion();

                                        if ($estado == "") {
                                            /* 93  Decanos de Facultades
                                             * 98  Director de Facultad
                                             * 99  Coordinador de Facultad
                                             * 3   Admon Facultades - Secretari@s Academic@s
                                             * 102 apoyo decano
                                             */
                                            if ($lrol == 99 or $lrol == 98 or $lrol == 3 or $lrol == 93 or $lrol == 102 or $lrol == 101) {
                                                ?>
                                                <button class="btn btn-warning btn-labeled fa fa-pencil-square-o" id="btnActAvance"  onclick="actualizarEvidencia('actualizarEvidencia', '<?php echo $txtIndicadorPlanDesarrolloId ?>', '<?php echo $contador ?>')">
                                                    Editar
                                                </button>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </td>
                        </tr> 
                        <?php
                    }
                    ?>
            </table>

        </td>
        </tr>
        </thead>
        <div id="dialogConfirm"><span id="spanMessage"></span></div>
        </table>	
        </fieldset>
        <div style="float:right">
            <button id="btnCerrarAvances" class="btn btn-warning">Salir</button>
        </div>
        <div id="actualizarObservacion"></div>
        <div id="actualizarEvidencia"></div>
        <?php
        break;

    case "verDetalle":

        $controlMeta = new ControlMeta($persistencia);
        $controlActividadMetaSecundaria = new ControlActividadMetaSecundaria($persistencia);
        $metaSecundaria = $controlMeta->buscarMetaSecundariaId($txtIdMetaSecundaria);
        $txtIdMetaPrincipal = $metaSecundaria->getMeta()->getMetaIndicadorPlanDesarrolloId();

        $tipoIndicador = $metaSecundaria->getMeta()->getIndicador()->getTipoIndicador()->getIdTipoIndicador();

        $avance = 0;
        $actividadMetaSecundaria = $controlActividadMetaSecundaria->buscarActividadMetaSecundariaId($txtIdMetaSecundaria);


        $mensaje = "";
        if ($tipoIndicador != 1) {
            $mensaje = "Valor avanzado";
        } else {
            $mensaje = "Valor Avance";
        }

        if ($actividadMetaSecundaria->getIdActividadMetaSecundaria() != "") {
            ?>
            <script src="../js/MainDetallePlan.js"></script>
            <div class="detalleMetaResponsable" >
                <form id="formDetallePlan">
                    <p>
                        <input type="hidden" id="txtIdMetaPrincipal" name="txtIdMetaPrincipal" value="<?php echo $txtIdMetaPrincipal; ?>" />
                        <input type="hidden" id="txtIdMetaSecundaria" name="txtIdMetaSecundaria" value="<?php echo $txtIdMetaSecundaria; ?>" />
                        <input type="hidden" id="txtIdActividadMetaSecundaria" name="txtIdActividadMetaSecundaria" value="<?php echo $actividadMetaSecundaria->getIdActividadMetaSecundaria(); ?>" />
                        <input type="hidden" id="txtAvancePropuesto" name="txtAvancePropuesto" id value="<?php echo $actividadMetaSecundaria->getMetaSecundaria()->getAvanceResponsableMetaSecundaria(); ?>" />
                        <input type="hidden" id="txtIdTipoIndicador" name="txtIdTipoIndicador" id value="<?php echo $tipoIndicador; ?>" />
                    </p>
                    <fieldset>
                        <legend>Registrar Actividades de Avance</legend>
                        <br />
                        <div>
                            <label>Actividades realizadas por el responsable de la meta:</label>
                        </div>
                        <br />
                        <table width="100%" border="0">
                            <tr>
                                <td>
                                    <table width="80%" border="0">
                                        <tr>
                                            <td>Actividades:</td>
                                            <td><textarea id="txtNombreActividad" name="txtNombreActividad" class="rediTextArea" readonly="readonly" rows="4"><?php if ($actividadMetaSecundaria->getIdActividadMetaSecundaria() != "") echo $actividadMetaSecundaria->getNombreActividadMetaSecundaria(); ?></textarea></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $mensaje; ?></td>
                                            <td><?php if ($actividadMetaSecundaria->getIdActividadMetaSecundaria() != "") echo $actividadMetaSecundaria->getMetaSecundaria()->getAvanceResponsableMetaSecundaria(); ?></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>Fecha Actividad</td>
                                            <td><?php if ($actividadMetaSecundaria->getIdActividadMetaSecundaria() != "") echo date("Y-m-d", strtotime($actividadMetaSecundaria->getFechaActividadMetaSecundaria())); ?></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>Anexos</td>
                                            <td><img id="imgAnexo" src="../css/images/pdf.png" class="imgCursor" onClick="verPDF('<?php echo $txtIdMetaPrincipal; ?>', '<?php echo $txtIdMetaSecundaria; ?>')" /></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td><legend>Comentarios</legend></td>
                            </tr>
                            <tr>
                                <td>Observaciones</td>
                                <td><textarea id="txtObservacionSupervisor" name="txtObservacionSupervisor" class="rediTextArea"><?php if ($actividadMetaSecundaria->getIdActividadMetaSecundaria() != "") echo $actividadMetaSecundaria->getObservacionActividad(); ?></textarea></td>
                            </tr>
                            <?php if ($tipoIndicador != 1) { ?>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Avance Supervisor</td>
                                    <td><input type="text" id="txtAvanceSupervisor" name="txtAvanceSupervisor" class="valor" /></td>
                                </tr>	
                            <?php } ?>	
                        </table>
                        </td>
                        </tr>
                        </table>
                    </fieldset>
                    <br />
                    <div>
                        <br />
                        <button id="btnGuardarObservacion" class="btn btn-warning">Guardar</button>
                        <button id="btnRestaurarObservacion" class="btn btn-warning">Cancelar</button>
                    </div>
                </form>
            </div>
            <div id="verArchivos"></div>
            <?php
        } else {
            ?>
            <div align="center">
                <br />
                <label>No existen actividades registradas</label>
                <br />
            </div>
            <?php
        }
        break;

    case "nuevaObservacion":
        ?>
        <form id="registroObsevacion" role="form">
            <fieldset>
                <legend>Registrar Observación</legend>
                <br />
                <div class="form-group">
                    <label >Digite la Observación:</label>
                    <input type="hidden" id="conteo" value="<?php echo $contador; ?>">
                    <input type="hidden" id="idMetaSecundaria" value="<?php echo $idMetaSecundaria; ?>">
                    <input type="hidden" id="aprobacion" value="<?php echo $aprobacion; ?>">
                    <textarea id="txtNuevaObservacion" name="txtNuevaObservacion" class="form-control rediTextArea"></textarea>	
                </div>
            </fieldset>
            <br />
            <div>
                <br />
                <div class="form-group">
                    <?php
                    if ($permisoEditar) {
                        ?>
                        <button id="btnNuevaObservacion" class="btn btn-warning">Guardar</button>
                        <?php
                    }
                    ?>
                    <button id="btnSalirNuevaObservacion" class="btn btn-warning">Cancelar</button>
                </div>
            </div>
        </form>
        <?php
        break;

    case "actualizarEvidencia":
        include '../tools/includes.php';
        ?>
        <form id="formActualizarEvidencia" class="form-horizontal">
            <fieldset>
                <?php
                $evidencia = $controlAvancesIndicadorPlanDesarrollo->verEvidenciaAvance($idAvanceIndicador);
                ?>
                <input type="hidden" name="idAvance" id="idAvance" value="<?php echo $idAvanceIndicador ?>">
                <input type="hidden" name="archivo" id="archivo" value="<?php //echo $evidencia->getEvidencia()        ?>">
                <input type="hidden" name="contador" id="contador" value="<?php echo $contador ?>">
                <div class="form-group ">
                    <label for="inputName" class=" col-xs-12 col-md-4">Acciones realizadas:</label>
                    <div class="col-xs-12 col-md-8">
                        <textarea id="actividadA" name="actividad" class="form-control  rediTextArea" rows="4"><?php echo $evidencia->getActividad(); ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputName" class=" col-xs-12 col-md-4">Valor Avance:</label>
                    <div class="col-xs-12 col-md-8">
                        <input type="text" id="avanceA" name="avance" class="form-control campoNumeros"  autocomplete="off"  value="<?php echo $evidencia->getValorAvance(); ?>"/>
                    </div>
                </div>	
                <div class="form-group">
                    <label for="inputName" class=" col-xs-12 col-md-4">Fecha Actividad:</label>
                    <div class="col-xs-12 col-md-8">
                        <input type="text" id="fechaActividad" name="fechaActividad" value="<?php echo $evidencia->getFechaActividad() ?>" autocomplete="off" readonly="" class="form-control" />
                    </div>
                </div>
                <div class="form-group hidden" >
                    <label for="inputName" class=" col-xs-12 col-md-4">Evidencia:</label>
                    <div class="col-xs-12 col-md-3">
                        <input type="file" id="txtFileAvanceActualizar" name="txtFileAvanceActualizar" class="form-control-file filestyle" accept=".pdf,text/plain,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" data-buttonName="btn-warning" multiple="multiple" value="<?php echo $evidencia->getEvidencia() ?>">                            
                    </div>
                    <div class="col-xs-12 col-md-5">(.doc, .docx, .txt, .xls, .xlsx, .pdf) </div>
                </div>
                <br />
                <br />
                <br />
            </fieldset>
            <div class="form-group" align="right">
                <?php
                if ($permisoEditar) {
                    ?>
                    <button id="btnActualizarEvidencia" class="btn btn-warning">Actualizar</button>
                    <?php
                }
                ?>
                <button id="btnRestaurarEvidencia" class="btn btn-warning">Cancelar</button>
            </div>
        </form>
        <?php
        break;
    case "VerEvidenciaTotal":
        ?>
        <fieldset>
            <br />
            <div>
                <label>Avances  realizados:</label>
            </div>
            <br />
            <table width="100%" border="0" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <td>
                            <table width="100%" border="0" align="center" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Fecha</th>
                                        <th>Actividad</th>
                                        <th>Avance</th>
                                        <th>Observacion</th>										
                                        <th>Evidencia</th>
                                        <th>Aprobación</th>
                                    </tr>
                                </thead>
                                <?php
                                $avances = $controlAvancesIndicadorPlanDesarrollo->verAvanceTotales($idMetaPrincipal, $periodo);
                                $contador = 0;
                                foreach ($avances as $avancesIndicador) {
                                    $contador++;
                                    ?>
                                    <tr>
                                        <td><?php echo $contador; ?></td>
                                        <td id="fecha"><?php echo $avancesIndicador->getFechaActividad(); ?></td>
                                        <td id="actividad"><?php echo $avancesIndicador->getActividad(); ?></td>
                                        <td id="avances"><?php echo $avancesIndicador->getValorAvance(); ?></td>
                                        <td id="observacion"><?php
                                            $observacion = $avancesIndicador->getObservaciones();
                                            $aprobacion = $avancesIndicador->getAprobacion();
                                            echo $observacion;
                                            ?>
                                        <td id="descargar">
                                            <?php
                                            $cadena = mysql_escape_string($avancesIndicador->getActividad());
                                            ?>
                                            <img id="imgAnexo" src="../css/images/pdf.png" class="imgCursor" onclick="verEvidencias('<?php echo $idMetaPrincipal ?>', 'verAvanceMeta', '<?php echo $avancesIndicador->getFechaActividad() ?>', '<?php echo htmlspecialchars($cadena); ?>', '<?php echo $avancesIndicador->getValorAvance(); ?>', '<?php echo $aprobacion ?>')" width="20" height="20">
                                        </td>
                                        <td id="aprobado"><?php echo $aprobacion; ?></td>
                                    </tr> 
                                    <?php
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                </thead>
            </table>	
        </fieldset>
        <div style="float:right">
            <button id="btnCerrarAvances" class="btn btn-warning">Salir</button>
        </div>
        <div id="actualizarObservacion"></div>
        <div id="actualizarEvidencia"></div>
        <?php
        break;
}
?>
