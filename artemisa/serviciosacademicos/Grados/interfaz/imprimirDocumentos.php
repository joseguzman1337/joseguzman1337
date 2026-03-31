<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
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

//include '../control/ControlRol.php';
include '../control/ControlCarrera.php';
include '../control/ControlItem.php';
include '../control/ControlPeriodo.php';
include '../control/ControlFacultad.php';
include '../control/ControlTipoDocumento.php';
include '../control/ControlContacto.php';
include '../control/ControlEstudiante.php';
include '../control/ControlTrabajoGrado.php';
include '../control/ControlConcepto.php';
include '../control/ControlDocumentacion.php';
include '../control/ControlCarreraPeople.php';
include '../control/ControlActaAcuerdo.php';
include '../control/ControlRegistroGrado.php';
include '../control/ControlFechaGrado.php';
include '../control/ControlIncentivoAcademico.php';


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

$controlRegistroGrado = new ControlRegistroGrado($persistencia);
$controlEstudiante = new ControlEstudiante($persistencia);
$controlIncentivoAcademico = new ControlIncentivoAcademico($persistencia);

$registroGrados = $controlRegistroGrado->consultarRegistroGrado($txtFechaGrado, $txtCodigoCarrera);
$existeLineaEnfasis = $controlEstudiante->existeLineaEnfasis($txtCodigoCarrera);
$existeIncentivoFechaGrado = $controlIncentivoAcademico->existeIncentivoFechaGrado($txtFechaGrado);
$incentivos = $controlIncentivoAcademico->consultarIncentivo();
?>
<script src="../js/MainImprimir.js"></script>
<script src="../js/MainRegistrarActaAcuerdo.js"></script>
<?php
    /**
     *@modified Diego Rivera<riveradiego@unbosque.edu.co>
     *se configura dialog para visualizar formulario de registro de incentivo
     *@since january 29 
     */
?>
<script>
$( "#dvRegistrarIncentivoNuevo" ).dialog({
            autoOpen: false,
            modal: true,
            resizable: false,
            title: "Detalle de Trabajo de Grado",
            width: 'auto',
            height: 'auto',
            show: {
            effect: "blind",
            duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
            buttons: {
                    "Cerrar": function( ) { 
                            $(this).dialog("close"); 
                    }
            }
});

</script>
<form id="formImprimirDocumentos" method="post">
    <br />
    <input type="hidden" id="txtCodigoCarrera" name="txtCodigoCarrera" value="<?php echo $txtCodigoCarrera; ?>" />
    <input type="hidden" id="txtFechaGrado" name="txtFechaGrado" value="<?php echo $txtFechaGrado; ?>" />
    <input type="hidden" id="txtCodigoModalidadAcademica" name="txtCodigoModalidadAcademica" value="<?php echo $txtCodigoModalidadAcademica; ?>" />
    <p align="justify">Por favor seleccione los documentos a imprimir</p>
    <table width="100%" border="0">
        <tr>
            <td>
                <fieldset>
                    <legend>Imprimir Documentos de Grado</legend>
                    <table width="100%" border="0">
                        <tr>
                            <td>Documentos</td>
                            <td>
                                <input type="checkbox" id="ckImprimirDocumentos[]" name="ckImprimirDocumentos[]" value="1" />
                                <label for="ckImprimirDocumentos">DIPLOMA</label><br />
                                <input type="checkbox" id="ckImprimirDocumentos[]" name="ckImprimirDocumentos[]" value="2" />
                                <label for="ckImprimirDocumentos">ACTA DE GRADO</label><br />
                                <input type="checkbox" id="ckImprimirDocumentos[]" name="ckImprimirDocumentos[]" value="3" />
                                <label for="ckImprimirDocumentos">HISTÓRICO DE NOTAS</label><br />
                                <?php if ($existeIncentivoFechaGrado != 0) { ?>
                                    <input type="checkbox" id="ckImprimirDocumentos[]" name="ckImprimirDocumentos[]" value="4" />
                                    <label for="ckImprimirDocumentos">CERTIFICADO DE INCENTIVOS</label><br />
                                <?php }
                                if ($existeLineaEnfasis != 0) {
                                    ?>
                                    <input type="checkbox" id="ckImprimirDocumentos[]" name="ckImprimirDocumentos[]" value="5" />
                                    <label for="ckImprimirDocumentos">LINEA DE ENFASIS</label><br />
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td>Documentos con Firmas</td>
                            <td>
                                <input type="checkbox" id="ckImprimirDocumentos[]" name="ckImprimirDocumentos[]" value="6" />
                                <label for="ckImprimirDocumentos">DIPLOMA</label><br />
                                <input type="checkbox" id="ckImprimirDocumentos[]" name="ckImprimirDocumentos[]" value="7" />
                                <label for="ckImprimirDocumentos">ACTA DE GRADO</label>
                                <input type="number" d="NumeroActaGrado" name="NumeroActaGrado"/>
                                <label for="ckImprimirDocumentos">Numero Acta</label><br />
                                <input type="checkbox" id="ckImprimirDocumentos[]" name="ckImprimirDocumentos[]" value="8" />
                                <label for="ckImprimirDocumentos">CERTIFICADO DE INCENTIVOS</label><br />
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <br />


                <fieldset>
                    <legend>Imprimir Documentos de Grado Formato 4 Firmas</legend>
                    <table width="100%" border="0">
                        <tr>
                            <td width="29%">Documentos</td>
                            <td>
                                <input type="checkbox" id="ckImprimirDocumentos[]" name="ckImprimirDocumentos[]" value="9" />
                                <label for="ckImprimirDocumentos">DIPLOMA</label><br />
                                <?php if ($existeIncentivoFechaGrado != 0) { ?>
                                    <input type="checkbox" id="ckImprimirDocumentos[]" name="ckImprimirDocumentos[]" value="10" />
                                    <label for="ckImprimirDocumentos">CERTIFICADO DE INCENTIVOS</label><br />
                                <?php }?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td width="29%">Documentos con Firmas</td>
                            <td>
                                <input type="checkbox" id="ckImprimirDocumentos[]" name="ckImprimirDocumentos[]" value="12" />
                                <label for="ckImprimirDocumentos">DIPLOMA</label><br />
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <br />

                <table width="100%" id="registroGrado" cellpadding="0" cellspacing="0" class="display">
                    <thead>
                        <tr >
                            <th>No</th>
                            <th>Nombre Estudiante</th>

                            <?php
                            /**
                             * @modified Diego Rivera <riveradiego@unbosque.edu.co>
                             * Se cambia titulo de encabezado <th>Imprimir</th> por <th>Incentivos</th>  
                             * @SInce january 29 ,2019
                             */
                            ?>
                            <th>Incentivos</th>
                        </tr>
                    </thead>
                    <tbody class="listaRadicaciones">
                        <?php
                        $estudiantes = array();
                        $documentosImprimir = array();
                        $i = 1;
                        foreach ($registroGrados as $registroGrado) {
                            $txtCodigoEstudiante = $registroGrado->getEstudiante()->getCodigoEstudiante();
                            $verIncentivos = $controlIncentivoAcademico->VerIncentivoEstudiantes($txtCodigoEstudiante, $txtCodigoCarrera);
                            $estudiantes[count($estudiantes)] = $txtCodigoEstudiante;
                            ?>
                            <tr>
                                <td align="center"><?php echo $i++; ?></td>
                                <td ><?php echo $txtNombreEstudiante = $registroGrado->getEstudiante()->getNombreEstudiante(); ?>
                                </td>
                                <td align="center">
                                    <img src="../css/images/vcard_edit.png" id="imgIncentivo" width="15" height="15" onClick="capturarEstudianteIncentivo('<?php echo $txtCodigoEstudiante; ?>', '<?php echo $txtNombreEstudiante; ?>')" style="cursor:pointer;" /><br>

                                <?php
                                /**
                                 * @Modified Diego Rivera<riveradiego@unbosque.edu.co> 
                                 * Se elimina opcion <img src="../css/images/documento.png" id="imgImprimir" width="15" height="15" onClick="imprimirDocu( '<?php echo $txtCodigoEstudiante; ?>' )" style="cursor:pointer;" /><br />
                                    no esta funcionando  se añade opcion editar nombre de incentivo
                                 * Since january 29, 2019
                                 */
                                foreach ($verIncentivos as $verIncentivo) {
                                    $incentivoEstudianteId = $verIncentivo->getCodigoIncentivo();
                                    echo $incentivoEstudiante = $verIncentivo->getNombreIncentivo();
                                    ?>
                                        &nbsp&nbsp<img src="../css/images/vcard_edit.png" id="imgIncentivo" width="15" height="15" style="cursor:pointer;" title="Actualizar" onclick ="incentivos('<?php echo $txtCodigoCarrera ?>', '<?php echo $txtCodigoEstudiante ?>', '<?php echo $incentivoEstudianteId ?>', 'actualizarIncentivo', '<?php echo $txtNombreEstudiante ?>')"/>&nbsp&nbsp<img src="../css/images/delete.png" id="imgIncentivo" width="15" height="15" style="cursor:pointer;" title="Eliminar" onclick ="anularIncentivo('<?php echo $txtCodigoCarrera ?>', '<?php echo $txtCodigoEstudiante ?>', '<?php echo $incentivoEstudianteId ?>', 'eliminarIncentivo', '<?php echo $txtNombreEstudiante ?>', 'imprimirIncentivos')" />
                                    <?php
                                        echo '<br>';
                                    }
                                    ?>



                                </td>
                            </tr>
                            <?php
                            }
                            $txtCodigoEstudiantes = serialize($estudiantes);
                            ?>
                    </tbody>
                </table>
                <input type="hidden" id="txtCodigoEstudiantes" name="txtCodigoEstudiantes" value="<?php echo htmlentities($txtCodigoEstudiantes); ?>" />
            </td>
        </tr>
    </table>
    </br>
    <div align="left">
        <input type="submit" id="btnImprimirDocumentos" value="Imprimir Todos"  onclick="this.form.action = '../servicio/imprimir.php'"/>
        <!--<a id="btnImprimirDocumentos">Imprimir Todos</a>-->
    </div>
</form>

<?php
    /**
     *@modified Diego Rivera<riveradiego@unbosque.edu.co>
     *Se crea formulario  para registro de incentivo
     *@since january 29 
     */
?>
<div id="dvRegistrarIncentivoNuevo" style="display: none;">
    <p><input type="hidden" id="txtEstudiante" name="txtEstudiante" />
        <input type="hidden" id="txtCarrera" name="txtCarrera" value="<?php echo $txtCodigoCarrera; ?>" />
        <input type="hidden" id="txtCodigoModalidad" name="txtCodigoModalidad" value="<?php echo $txtCodigoModalidadAcademica; ?>" />
    </p>
    <form id="formRegistrarIncentivoNuevo">
        <br />
        <h3><span id="txtNombreEstudiante"></span></h3>
        <table width="80%" border="0">
            <tr>
                <td>
                    <fieldset>
                        <legend>Registrar Incentivo Académico</legend>
                        <table width="100%" border="0">
                            <tr>
                                <td>Tipo Incentivo</td>
                                <td>
                                <?php
                                foreach ($incentivos as $incentivo) {
                                    if ($txtCodigoModalidadAcademica == 200) {
                                        if ($incentivo->getIdIncentivo() == 2 || $incentivo->getIdIncentivo() == 3) {
                                ?>
                                                <input type="checkbox" id="ckIncentivo" name="ckIncentivo" value="<?php echo $incentivo->getIdIncentivo(); ?>" />
                                                <input type="hidden" id="txtNombreIncentivo" name="txtNombreIncentivo" class="txtNombreIncentivo" value="<?php echo $incentivo->getNombreIncentivo(); ?>" />
                                                <label for="ckIncentivo"><?php echo $incentivo->getNombreIncentivo(); ?></label><br />	
                                <?php
                                        }
                                    } else {
                                    if ($incentivo->getIdIncentivo() == 4 || $incentivo->getIdIncentivo() == 5 || $incentivo->getIdIncentivo() == 6 || $incentivo->getIdIncentivo() == 7 || $incentivo->getIdIncentivo() == 8 || $incentivo->getIdIncentivo() == 9) {
                                ?>
                                                <input type="checkbox" id="ckIncentivo" name="ckIncentivo" value="<?php echo $incentivo->getIdIncentivo(); ?>" />
                                                <input type="hidden" id="txtNombreIncentivo" name="txtNombreIncentivo" class="txtNombreIncentivo" value="<?php echo $incentivo->getNombreIncentivo(); ?>" />
                                                <label for="ckIncentivo"><?php echo $incentivo->getNombreIncentivo(); ?></label><br />
                                        <?php
                                        }
                                    }
                                }
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Observación</td>
                                <td><textarea id="txtObservacion" name="txtObservacion" rows="4" cols="40"></textarea></td>
                            </tr>
                            <tr>
                                <td>Acta Incentivo</td>
                                <td><input type="text" id="txtNumeroActaIncentivo" name="txtNumeroActaIncentivo" /></td>
                            </tr>
                            <tr>
                                <td>Fecha Acta Incentivo</td>
                                <td><input type="text" id="txtFechaActaIncentivo" name="txtFechaActaIncentivo" /></td>
                            </tr>
                        </table>
                    </fieldset>
                </td>
            </tr>
        </table>
        </br>
        <div align="left"><a id="btnRegistrarIncentivoNuevo">Guardar</a>
        </div>
    </form>
</div>
