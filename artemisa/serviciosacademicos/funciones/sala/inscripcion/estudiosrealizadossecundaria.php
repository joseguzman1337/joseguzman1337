<?php
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se agregan los parametros codigoestudiante y flag para que redireccionen y se asocien a la carrera que 
 * previamente haya seleccionado
 * @since Mayo 14, 2019
 */
@session_start();

$codigoinscripcion = $_SESSION['numerodocumentosesion'];

$query_niveleducacion = "select *
from niveleducacion
where idniveleducacion in(2)
order by 2";
$niveleducacion = $db->Execute($query_niveleducacion);
$totalRows_niveleducacion = $niveleducacion->RecordCount();
$row_niveleducacion = $niveleducacion->FetchRow();

$query_titulo = "select *
from titulo
where codigotitulo <> 1
and codigotitulo = 74
order by 2";
$titulo = $db->Execute($query_titulo);
$totalRows_titulo = $titulo->RecordCount();
$row_titulo = $titulo->FetchRow();

$query_ciudad = "SELECT distinct concat(departamentoinstitucioneducativa,' - ', municipioinstitucioneducativa) as nombreciudad
FROM institucioneducativa
having nombreciudad <> ' - '
and nombreciudad not like '%ESTADOS%UNIDOS%'
and nombreciudad not like '%SIN DEFINIR%'
and nombreciudad not like '%REPUBLICA%'
and nombreciudad not like '%VENEZUELA%'
and nombreciudad not like '%North%'
order by 1";
$ciudad = $db->Execute($query_ciudad);
$totalRows_ciudad = $ciudad->RecordCount();
$row_ciudad = $ciudad->FetchRow();

$query_codest = "select codigoestudiante
from estudiante
where idestudiantegeneral='" . $this->estudiantegeneral->idestudiantegeneral . "'
and codigocarrera='" . $_SESSION['codigocarrerasesion'] . "' ";
$codest = $db->Execute($query_codest);
$totalRows_codest = $codest->RecordCount();
$row_codest = $codest->FetchRow();
?>
<label id="labelresaltado">Los datos de Secundaria y el resultado del ICFES son obligatorios.</label>
<?php
$query_datosgrabados = "SELECT e.anogradoestudianteestudio, n.nombreniveleducacion , e.idinstitucioneducativa,
e.codigotitulo, e.ciudadinstitucioneducativa, e.observacionestudianteestudio, e.idestudianteestudio,
ins.nombreinstitucioneducativa, t.nombretitulo,
e.otrainstitucioneducativaestudianteestudio, e.otrotituloestudianteestudio, e.colegiopertenececundinamarca
FROM estudianteestudio e,niveleducacion n,institucioneducativa ins,titulo t
WHERE e.idestudiantegeneral = '" . $this->estudiantegeneral->idestudiantegeneral . "'
and e.idniveleducacion = n.idniveleducacion
and ins.idinstitucioneducativa = e.idinstitucioneducativa
and e.codigotitulo = t.codigotitulo
and e.codigoestado like '1%'
and e.codigotitulo = 74
order by anogradoestudianteestudio";
$datosgrabados = $db->Execute($query_datosgrabados);
$totalRows_datosgrabados = $datosgrabados->RecordCount();
$row_datosgrabados = $datosgrabados->FetchRow();
if ($row_datosgrabados <> "") {
    ?>
    <br><table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
        <tr>
            <td id="tdtitulogris">Nivel</td>
            <td id="tdtitulogris">Institución</td>
            <td id="tdtitulogris">Titulo</td>
            <td id="tdtitulogris">Ciudad</td>
            <td id="tdtitulogris">Colegio pertenece al Departamento de Cundinamarca y es público</td>
            <td id="tdtitulogris">Año</td>
            <td id="tdtitulogris">Observaciones</td>
            <td id="tdtitulogris">Acción</td>
        </tr>    
        <?php
        do {
            ?>
            <tr>
                <td><?php echo $row_datosgrabados['nombreniveleducacion']; ?></td>
                <td><?php
                    if ($row_datosgrabados['idinstitucioneducativa'] != '1') {
                        echo $row_datosgrabados['nombreinstitucioneducativa'];
                    } else {
                        echo $row_datosgrabados['otrainstitucioneducativaestudianteestudio'];
                    }
                    ?></td>
                <td><?php
                    if ($row_datosgrabados['codigotitulo'] != '1') {
                        echo $row_datosgrabados['nombretitulo'];
                    } else {
                        echo $row_datosgrabados['otrotituloestudianteestudio'];
                    }
                    ?></td>
                <td><?php echo $row_datosgrabados['ciudadinstitucioneducativa']; ?></td>
                <td><?php echo $row_datosgrabados['colegiopertenececundinamarca']; ?></td>
                <td><?php echo $row_datosgrabados['anogradoestudianteestudio']; ?></td>
                <td><?php echo $row_datosgrabados['observacionestudianteestudio']; ?></td>
                <td><a onClick="window.location.href = 'editarestudiosrealizadossecundaria_new.php?id=<?php echo $row_datosgrabados['idestudianteestudio']; ?>'" style="cursor: pointer"><img src="http://artemisa.unbosque.edu.co/imagenes/editar.png" width="20" height="20" alt="Editar"></a>
                    <a onClick="if (!confirm('¿Está seguro de elimiar el registro?'))
                                return true;
                            else
                                window.location.href = 'eliminar_new.php?estudiosrealizadossecundaria&id=<?php echo $row_datosgrabados['idestudianteestudio']; ?>'" style="cursor: pointer"><img src="http://artemisa.unbosque.edu.co/imagenes/eliminar.png" width="20" height="20" alt="Eliminar"></a>
                </td>
            </tr>    
            <?php
        } while ($row_datosgrabados = $datosgrabados->FetchRow());
        ?>

        <?php
        if ($this->codigomodalidadacademica == 200 || $this->codigomodalidadacademica == 800) {
            if (!defined("HTTP_ROOT")) {
                $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $actual_link = explode("/serviciosacademicos", $actual_link);
                define("HTTP_ROOT", $actual_link[0]);
            }
            if (!defined("PATH_ROOT")) {
                //Definimos el root del http
                $actual_link = getcwd();
                $actual_link = explode("/serviciosacademicos", $actual_link);
                define("PATH_ROOT", $actual_link[0]);
            }
            require_once(PATH_ROOT . '/kint/Kint.class.php');

            require_once(PATH_ROOT . '/serviciosacademicos/Connections/sala2.php');
            $sala2 = $sala;
            $rutaado = PATH_ROOT . "/serviciosacademicos/funciones/adodb/";
            require_once(PATH_ROOT . '/serviciosacademicos/Connections/salaado.php');

            require_once(PATH_ROOT . '/serviciosacademicos/consulta/prematricula/inscripcionestudiante/funcionesEditarIngresoIcfesNew.php');
            $tipoDocumento = getTipoDocumento($db);
            //Se ejecuta la funcion para traer los datos Grabados acutalmente
            //se ejecuta la funcion para traer la fecha actual registrada
            $fechaActual = getFechaActual($db, $this->estudiantegeneral->idestudiantegeneral);
            $data = getDatosGrabados($db, $fechaActual, $date, $this->estudiantegeneral->idestudiantegeneral, @$_GET['tipoPrueba']);
            $dataTipo = $data->dataTipo;
            $aplica_reclasificacion = $data->aplica_reclasificacion;

            $numeroregistroresultadopruebaestado = getNumeroRegistroAcActivo($db, $this->estudiantegeneral->idestudiantegeneral);

            $datosDocumentoActual = getDatosDocumentoAcutal($db, null, $this->estudiantegeneral->idestudiantegeneral, $this->estudiantegeneral->numerodocumento, $numeroregistroresultadopruebaestado);
            ?>
            <tr>
                <td colspan="6">
                    <label id="labelresaltado"><h2>Datos prueba SABER 11</h2></label>
                </td>
            </tr>
            <tr>
                <td colspan="6"><h2><a style="color: red" href="ingresoicfes_new.php?inicial&idestudiante=<?php echo $this->estudiantegeneral->idestudiantegeneral; ?>&codigoestudiante=<?php echo $row_codest['codigoestudiante']; ?>&flag=1" id="aparencialinknaranja">DILIGENCIE RESULTADO PRUEBA DE ESTADO</a></h2></td>
            </tr>
            <?php
        }
        ?> 
    </table>
    <br>
    <?php
}
if ($totalRows_datosgrabados == 0) {
    ?>
    <input type="hidden" name="idniveleducacion" value="2">
    <input type="hidden" name="codigotitulo" value="74">
    <table  width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
        <tr>
            <td colspan="6" id="tdtitulogris"><?php echo $nombremodulo[$moduloinicial]; ?><a onClick="window.open('pregunta.php?id=<?php echo $iddescripcion[$moduloinicial]; ?>', 'mensajes', 'width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer">&nbsp;&nbsp;<img src="http://artemisa.unbosque.edu.co/imagenes/pregunta.gif" alt="Ayuda"></a></td>
        </tr>
        <tr>
            <td id="tdtitulogris">Instituci&oacute;n<label id="labelresaltado">*</label></td>
            <td colspan="5">
                <INPUT name="institucioneducativa" size="70" readonly onclick="window.open('editarestudiantecolegio.php?codigomodalidad=<?php echo $row_institucioneducativa2['codigomodalidadacademica'] . "&estudio=informacionestudiossecundaria"; ?>', 'mensajes', 'width=800,height=400,left=150,top=200,scrollbars=yes')"  value="<?php if (isset($_POST['institucioneducativa']))
        echo $_POST['institucioneducativa'];
    else
        echo $row_institucioneducativa['nombreinstitucioneducativa'];
    ?>">
                <INPUT name="idinstitucioneducativa"  type="hidden" value="<?php if (isset($_POST['idinstitucioneducativa']))
                       echo $_POST['idinstitucioneducativa'];
                   else
                       echo $row_institucioneducativa['idinstitucioneducativa'];
                   ?>">
    <?php $this->crearunicoboton($_SESSION['MM_Username'], ereg_replace(".*\/", "", $HTTP_SERVER_VARS['SCRIPT_NAME']), $valores, "21"); ?>
                <br><br><label id="labelresaltado">Si la institución no aparece en el listado digitelo en el siguiente campo de texto</label>
                <input type="text" name="otrainstitucioneducativaestudianteestudio" style="width:100% " value="<?php echo $_REQUEST['otrainstitucioneducativaestudianteestudio'] ?>">
            </td>
        </tr>
        <tr>
            <td id="tdtitulogris">Ciudad de la institución<label id="labelresaltado">*</label></td>
            <td><select name="ciudadinstitucioneducativa" id="ciudadinstitucioneducativa">
                    <option value="0" <?php
                            if (!(strcmp("0", $_POST['ciudadinstitucioneducativa']))) {
                                echo "SELECTED";
                            }
                            ?>>Seleccionar</option>
                    <?php
                            do {
                                ?>
                        <option value="<?php echo $row_ciudad['nombreciudad'] ?>"<?php
                                if (!(strcmp($row_ciudad['nombreciudad'], $_POST['ciudadinstitucioneducativa']))) {
                                    echo "SELECTED";
                                }
                                ?>><?php echo $row_ciudad['nombreciudad']; ?></option>
        <?php
    } while ($row_ciudad = $ciudad->FetchRow());
    ?>
                </select>
            </td>	
            <td id="tdtitulogris">A&ntilde;o de grado</td>
            <td><input name="anogradoestudianteestudio" type="number" id="anogradoestudianteestudio" size="" maxlength="4" value="<?php echo $_POST['anogradoestudianteestudio']; ?>"></td>
        </tr>
        <?php
        if ($this->codigomodalidadacademica == 200) {
            if (!defined("HTTP_ROOT")) {
                $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $actual_link = explode("/serviciosacademicos", $actual_link);
                define("HTTP_ROOT", $actual_link[0]);
            }
            if (!defined("PATH_ROOT")) {
                //Definimos el root del http
                $actual_link = getcwd();
                $actual_link = explode("/serviciosacademicos", $actual_link);
                define("PATH_ROOT", $actual_link[0]);
            }
            require_once(PATH_ROOT . '/kint/Kint.class.php');

            require_once(PATH_ROOT . '/serviciosacademicos/Connections/sala2.php');
            $sala2 = $sala;
            $rutaado = PATH_ROOT . "/serviciosacademicos/funciones/adodb/";
            require_once(PATH_ROOT . '/serviciosacademicos/Connections/salaado.php');

            require_once(PATH_ROOT . '/serviciosacademicos/consulta/prematricula/inscripcionestudiante/funcionesEditarIngresoIcfesNew.php');
            $tipoDocumento = getTipoDocumento($db);
            //Se ejecuta la funcion para traer los datos Grabados acutalmente
            //se ejecuta la funcion para traer la fecha actual registrada
            $fechaActual = getFechaActual($db, $this->estudiantegeneral->idestudiantegeneral);
            $data = getDatosGrabados($db, $fechaActual, $date, $this->estudiantegeneral->idestudiantegeneral, @$_GET['tipoPrueba']);
            $dataTipo = $data->dataTipo;
            $aplica_reclasificacion = $data->aplica_reclasificacion;

            $numeroregistroresultadopruebaestado = getNumeroRegistroAcActivo($db, $this->estudiantegeneral->idestudiantegeneral);
            $datosDocumentoActual = getDatosDocumentoAcutal($db, null, $this->estudiantegeneral->idestudiantegeneral, $this->estudiantegeneral->numerodocumento, $numeroregistroresultadopruebaestado);
            ?>
            <tr>
                <td colspan="6">
                    <label id="labelresaltado"><h2>Datos prueba SABER 11</h2></label>
                </td>
            </tr>
            <tr>
                <td colspan="6"><h2><a style="color: red" href="ingresoicfes_new.php?inicial&idestudiante=<?php echo $this->estudiantegeneral->idestudiantegeneral; ?>&codigoestudiante=<?php echo $row_codest['codigoestudiante']; ?>&flag=1" id="aparencialinknaranja">DILIGENCIE RESULTADO PRUEBA DE ESTADO</a></h2></td>
            </tr>
        <?php
    }
    ?>
    </table>
    <br>
    <br>
    <?php
}
?>
