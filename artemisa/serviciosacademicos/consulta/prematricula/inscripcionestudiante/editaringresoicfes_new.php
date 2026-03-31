<?php
    require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
    Factory::validateSession($variables);

    $pos = strpos($Configuration->getEntorno(), "local");
    if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"||$Configuration->getEntorno()=="Preproduccion"||$pos!==false){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        require_once(PATH_ROOT . '/kint/Kint.class.php');
    }

    $tabla = null;
    $opcional = null;
    $editar = !empty($_REQUEST['editar']) ? $_REQUEST['editar'] : null;

    include (PATH_ROOT . "/serviciosacademicos/consulta/prematricula/inscripcionestudiante/calendario/calendario.php");
    require_once(PATH_ROOT . '/serviciosacademicos/consulta/prematricula/inscripcionestudiante/funcionesEditarIngresoIcfesNew.php');

    $row_data = getInfoEstudiante($db, $_REQUEST['codigoestudiante'], $_REQUEST['idestudiante'], @$_SESSION['numerodocumentosesion'], @$_SESSION['inscripcionsession']);

    //se ejecuta la funcion para traer la fecha actual registrada
    $fechaActual = getFechaActual($db, $row_data['idestudiantegeneral']);

    $date = @$_GET['date'];

    //Se ejecuta la funcion para traer los datos Grabados acutalmente
    $data = getDatosGrabados($db, $fechaActual, $date, $row_data['idestudiantegeneral'], @$_GET['tipoPrueba']);
    $dataTipo = $data->dataTipo;
    $aplica_reclasificacion = $data->aplica_reclasificacion;
    $datosgrabados = $data->datosgrabados;
    $row_datosgrabados = $data->row_datosgrabados;

    $data = getMateriasF($db, $dataTipo, $aplica_reclasificacion);
    $materiasF = $data->materiasF;
    $asignaturas2 = $data->asignaturas2;
    $row_asignaturas2 = $data->row_asignaturas2;

    $tipoDocumento = getTipoDocumento($db);
    $datosDocumentoActual = getDatosDocumentoAcutal($db, $_REQUEST['codigoestudiante'], @$_GET['idestudiante'], @$_SESSION['numerodocumentosesion'], $datosgrabados['numeroregistroresultadopruebaestado']);
    $estadoActualizacionPIR = getEstadoActualizacionPIR($db, $datosgrabados['numeroregistroresultadopruebaestado']);

    if (empty($idestudiantegeneral)) {
        $idestudiantegeneral = $_REQUEST['idestudiante'];
    }

    if ($datosgrabados['actualizadoPir'] == '1' ) {
        require (PATH_ROOT . '/serviciosacademicos/PIR/control/ControlConsultarPIR.php');
        require (PATH_ROOT . '/serviciosacademicos/PIR/entidad/ResultadoPruebaEstado.php');
        require (PATH_ROOT . '/serviciosacademicos/PIR/entidad/DetalleResultadoPruebaEstado.php');
        require (PATH_ROOT . '/serviciosacademicos/PIR/control/ControlActualizarMaterias.php');

        $ControlActualizarMaterias = new ControlActualizarMaterias($db);

        $ResultadoPruebaEstado = new ResultadoPruebaEstado($db);
        $ResultadoPruebaEstado->setIdestudiantegeneral($idestudiantegeneral);
        $ResultadoPruebaEstado->setNumeroregistroresultadopruebaestado($datosgrabados['numeroregistroresultadopruebaestado']);
        $ResultadoPruebaEstado->getResultadoEsutiante();

        $DetalleResultadoPruebaEstado = new DetalleResultadoPruebaEstado($db);
        $resultados = $DetalleResultadoPruebaEstado->getDetallesResultadoActual($datosgrabados['idresultadopruebaestado']);

        $ControlConsultarPIR = new ControlConsultarPIR($datosDocumentoActual['nombrecortodocumento'], $datosDocumentoActual['numerodocumento'], $datosgrabados['numeroregistroresultadopruebaestado'], $idestudiantegeneral);

        $tabla = $ControlConsultarPIR->printTablaResultados($ResultadoPruebaEstado, $ControlActualizarMaterias, $resultados, $db);
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>.:INGRESO ICFES:.</title>
        <?php
        echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/font-awesome.css");
        echo Factory::printImportJsCss("css", HTTP_SITE . "/assets/css/loader.css");
        ?>
        <link rel="stylesheet" href="<?php echo HTTP_ROOT ?>/serviciosacademicos/css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" />
        <style type="text/css" title="currentStyle">
            .ui-datepicker{
                display:none;
            }
            <?php
            if (!empty($datosgrabados['actualizadoPir'])) {
                ?>
                table.resultados,
                #btnEnviar{
                    display:none;
                }
                <?php
            }
            ?>
        </style>
        <script src="<?php echo HTTP_ROOT; ?>/sala/assets/js/jquery-3.6.0.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>/sala/assets/js/bootstrap.min.js"></script>
        <link href="<?php echo HTTP_ROOT; ?>/sala/assets/css/bootstrap.min.css" rel="stylesheet">
        <script src="<?php echo HTTP_ROOT; ?>/sala/assets/js/jquery.dataTables.min.js" rel="stylesheet"></script>
        <link rel="stylesheet" href="<?php echo HTTP_ROOT; ?>/sala/assets/css/jquery.dataTables.min.css" type="text/css">
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
        <link rel="stylesheet" href="<?php echo HTTP_ROOT ?>/sala/assets/css/themes/smoothness/jquery-ui-1.8.4.custom.css">

        <link rel="stylesheet" href="<?php echo HTTP_ROOT ?>/sala/assets/js/calendario/calendar-win2k-1.css" type="text/css" />
        <script type="text/javascript" language="javascript" src="<?php echo HTTP_ROOT ?>/sala/assets/js/jquery-3.6.0.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo HTTP_ROOT ?>/sala/assets/js/datatables.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo HTTP_ROOT ?>/sala/assets/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_ROOT ?>/sala/assets/js/calendario/calendar.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_ROOT ?>/sala/assets/js/calendario/calendar-es.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_ROOT ?>/sala/assets/js/calendario/calendar-setup.js"></script>
        <?php
        echo Factory::printImportJsCss("js", HTTP_SITE . "/assets/js/general.js");
        ?>
        <script type="text/javascript">
            var numeroregistroresultadopruebaestado = <?php echo empty($datosgrabados['numeroregistroresultadopruebaestado']) ? "null" : "'" . $datosgrabados['numeroregistroresultadopruebaestado'] . "'"; ?>;
            var idEstudianteGeneral = '<?php echo isset($idestudiantegeneral) ? $idestudiantegeneral : $_REQUEST['idestudiante']; ?>';
            var permiteActualizar = <?php echo empty($estadoActualizacionPIR) ? ( "true" ) : ( "false" ); ?>;

            function cosultarResultadosPIR() {
                showLoader();
                $("#mensajeLoader").html("Consultando puntaje ICFES...");
                clearTimeout(timeOutVar);
                timeOutVar = window.setTimeout(function () {
                    $("#mensajeLoader").html("La carga esta tardando demasiado...");
                    timeOutVar = window.setTimeout(function () {
                        hideLoader();
                    }, 5000);
                }, 15000);
                consultarPermiteActualizar();
                var tipoDocumento = $("#tipoDocumento").val();
                var numeroDocumento = $("#numeroDocumento").val();
                var registro = $("#registro").val();
                var urlCURL = "<?php echo HTTP_ROOT; ?>/serviciosacademicos/PIR/index.php";

                var parametros = {
                    tipoDocumento: tipoDocumento,
                    numeroDocumento: numeroDocumento,
                    registro: registro,
                    idEstudianteGeneral: idEstudianteGeneral,
                    action: 'consultarPIR'
                };

                $.ajax({
                    url: urlCURL,
                    type: "GET",
                    data: parametros,
                    dataType: "json",
                    timeout: 20000,
                    success: function (data) {
                        if (data.s) {
                            $(".resultados").remove();
                            $("#resultados").html(data.tabla);
                            hideLoader();
                        } else {
                            alert("Problema de conexión: " + data.msj + ", por favor intente de nuevo mas tarde o ingrese manualmente sus resultados");
                            $(".fechaPresentacionPrueba").css("display", "table-cell");
                            $("#btnEnviar").css("display", "");
                            hideLoader();
                        }
                    },
                    error: function ( ) {
                        alert("Problema de conexión: No fue posible establecer conexion con el Ministerio de educación, por favor intente de nuevo mas tarde o ingrese manualmente sus resultados");
                        $(".fechaPresentacionPrueba").css("display", "table-cell");
                        $("#btnEnviar").css("display", "");
                        hideLoader();
                    }
                }).always(function () {
                    hideLoader();
                });
            }
            function cosultarEstructuraPIR() {
                var registro = $("#registro").val();
                var urlCURL = "<?php echo HTTP_ROOT; ?>/serviciosacademicos/PIR/index.php";
                var parametros = {
                    registro: registro,
                    action: 'consultarEstructuraPIR'
                };
            }
            function consultarPermiteActualizar() {
                var tipoDocumento = $("#tipoDocumento").val();
                var numeroDocumento = $("#numeroDocumento").val();
                var idestudiante = $("#idestudiante").val();
                var registro = $("#registro").val();
                var urlCURL = "<?php echo HTTP_ROOT; ?>/serviciosacademicos/PIR/index.php";
                var parametros = {
                    tipoDocumento: tipoDocumento,
                    numeroDocumento: numeroDocumento,
                    idestudiante: idestudiante,
                    registro: registro,
                    action: 'validarIdestudiantegeneralAC'
                };
                $.getJSON(
                        urlCURL,
                        parametros,
                        function (data) {
                            if (data.s) {
                                if (registro.trim() != "") {
                                    cosultarEstructuraPIR();
                                }
                            } else {
                                permiteActualizar = false;
                                alert("Error de consulta: " + data.msj + ", por favor intente de nuevo mas tarde");
                            }
                        }
                );
            }
            $(document).ready(function () {
                $("#numeroDocumento").blur(function () {
                    var numeroDocumento = $("#numeroDocumento").val();
                    if (numeroDocumento.trim() != "") {
                        consultarPermiteActualizar();
                    }
                });
                $("#registro").blur(function () {
                    var registro = $("#registro").val();
                    if (registro.trim() != "") {
                        cosultarEstructuraPIR();
                    }
                });
                $("#consultarPIR").click(function (e) {
                    e.stopPropagation();
                    e.preventDefault();
                    var tipoDocumento = $("#tipoDocumento").val();
                    var numeroDocumento = $("#numeroDocumento").val();
                    var registro = $("#registro").val();
                    console.log(numeroregistroresultadopruebaestado);
                    console.log(permiteActualizar);

                    if (registro !== numeroregistroresultadopruebaestado) {
                        permiteActualizar = true;
                    }
                    console.log(permiteActualizar);
                    if (tipoDocumento.trim() == "0") {
                        alert("Debe seleccionar el tipo de documento con el que presento la prueba");
                    } else if (numeroDocumento.trim() == "") {
                        alert("Debe ingresar el número de documento con el que presento la prueba");
                    } else if (registro.trim() == "") {
                        alert("Debe ingresar el número de registro de la prueba");
                    } else if (permiteActualizar) {
                        cosultarResultadosPIR();
                    }
                });
                $("#editarResultadosPir").click(function (e) {
                    e.stopPropagation();
                    e.preventDefault();

                    var confirmar = 'Al editar manualmente los datos, se creará un nuevo registro que no está confirmado por el ministerio de educacion, desea continuar?';

                    if (confirm(confirmar)) {
                        showEditar();
                    }
                });
                function showEditar() {
                    $(".fechaPresentacionPrueba").css("display", "table-cell");
                    $("#resultados").css("display", "none");
                    <?php
                    if (!empty($editar)) {
                        ?>
                        $("#btnEnviar").css("display", "inline-block");
                        $(".resultados").css("display", "block");
                        <?php
                    }
                    ?>
                }
                <?php
                if (!empty($editar)) {
                    ?>
                    showEditar();
                    <?php
                }
                ?>
            });
        </script>
    </head>
    <body>
        <div class="container">
            <div class="loaderContent" style="">
                <div class="contenedorInterior">
                    <i class="fa fa-spinner fa-pulse fa-5x"></i>
                    <span class="sr-only">Cargando...</span>
                    <div id="mensajeLoader"></div>
                </div>
            </div>
            <div class="col-md-12" align="center">
                <form name="inscripcion" method="post" action="editaringresoicfes_new.php">
                    <input type="hidden" id="idestudiante" name="idestudiante" value="<?php if(isset($idestudiantegeneral) && !empty($idestudiantegeneral)){echo $idestudiantegeneral; }else{echo $_REQUEST["idestudiante"]; }?>" />
                    <?php
                    if (isset($_POST['inicial']) or isset($_GET['inicial'])) {
                        ?>
                        <table class="table table-bordered" style="font-size: 13px">
                        <tr id="trtituloNaranjaInst" class="text-center">
                            <td colspan="4">
                                FORMULARIO DEL ASPIRANTE
                            </td>
                        </tr>
                        <tr>
                            <td class="tdtituloWhiteInst">Nombre</td>
                            <td><?php echo $row_data['nombresestudiantegeneral'] . " " . $row_data['apellidosestudiantegeneral']; ?></font></td>
                        </tr>
                        <tr>
                            <td class="tdtituloWhiteInst">Modalidad Acad&eacute;mica</td>
                            <td><?php echo $row_data['nombremodalidadacademica']; ?></td>
                        </tr>
                        <tr>
                            <td class="tdtituloWhiteInst">Nombre del Programa</td>
                            <td><?php echo $row_data['nombrecarrera']; ?></td>
                        </tr>
                    </table>
                        <?php
                        if (isset($_GET['inicial'])) {
                            $moduloinicial = $_GET['inicial'];
                            echo '<input type="hidden" name="inicial" value="' . $_GET['inicial'] . '">';
                        } else {
                            $moduloinicial = $_POST['inicial'];
                            echo '<input type="hidden" name="inicial" value="' . $_POST['inicial'] . '">';
                        }
                        ?>
                        <br>
                        <table class="table table-bordered" style="font-size: 13px">
                            <tr id="trtituloNaranjaInst" class="text-center">
                                <td colspan="7" >RESULTADO PRUEBA DE ESTADO</td>
                            </tr>
                            <tr>
                                <td id="tdtitulogris">
                                    Tipo de documento<span class="Estilo4">*</span><br/>
                                    (Registrado en la prueba)
                                </td>
                                <td>
                                    <select id="tipoDocumento" name="tipoDocumento">
                                        <option value="0">Seleccionar...</option>
                                        <?php
                                        foreach($tipoDocumento as $tipos){
                                            $selected = "";
                                            if (!empty($datosDocumentoActual['nombrecortodocumento']) && ($datosDocumentoActual['nombrecortodocumento'] == $tipos['nombrecortodocumento'])) {
                                                $selected = " selected ";
                                            }
                                            ?>
                                            <option value="<?php echo $tipos['nombrecortodocumento']; ?>" <?php echo $selected; ?>>
                                                <?php echo $tipos['nombredocumento']; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <input type="hidden" id="codigoestudiante" name="codigoestudiante" value="<?php echo $_REQUEST['codigoestudiante'] ?>">
                                </td>
                                <td id="tdtitulogris">
                                    Numero de documento<span class="Estilo4">*</span><br/>
                                    (Registrado en la prueba)
                                </td>
                                <td colspan="4" >
                                    <input name="numeroDocumento" type="text" id="numeroDocumento"  value="<?php echo $datosDocumentoActual['numerodocumento']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td id="tdtitulogris">No. Registro<span class="Estilo4">*</span></td>
                                <td>
                                    <input type="text" name="registro" id="registro" value="<?php echo $datosgrabados['numeroregistroresultadopruebaestado']; ?>">
                                    <input type="hidden" id="codigoestudiante" name="codigoestudiante" value="<?php echo $_REQUEST['codigoestudiante'] ?>">
                                </td>
                                <td class="fechaPresentacionPrueba" id="tdtitulogris">
                                    Fecha de la prueba
                                </td>
                                <td class="fechaPresentacionPrueba" colspan="4" >
                                    <input name="fecha1" type="text" id="fecha1"  size="15" value="<?php
                                    echo $fechaActual = substr($datosgrabados['fecharesultadopruebaestado'], 0, 10);
                                    ?>" onchange="fechasaber11('fecha1');">
                                </td>
                            </tr>
                        </table>
                        <div id="resultados">
                            <?php
                            if (!empty($tabla)) {
                                echo $tabla;
                                ?>
                                <input type="button" id="editarResultadosPir" name="editarResultadosPir" value="Editar" />
                                <?php
                            }
                            ?>
                        </div>
                        <table class="resultados table" style="font-size: 13px">
                            <tr>
                                <?php
                                switch ($datosgrabados['TipoPrueba']){
                                    case '1':{
                                        ?>
                                        <td id="tdtitulogris">Puesto</td>
                                        <td colspan="1">
                                            <input type="text" name="puesto" id="puesto" size="3" value="<?php echo $datosgrabados['puestoresultadopruebaestado']; ?>" maxlength="3"></td>
                                        <?php
                                    }break;
                                    case '2':{
                                        ?>
                                        <td id="tdtitulogris">Puntaje Global</td>
                                        <td colspan="2"><input type="text" value="<?php echo $datosgrabados['PuntajeGlobal']; ?>" name="puntaje_global" id="puntaje_global"/></td>
                                        <td colspan="2">&nbsp;</td>
                                        <?php
                                    }break;
                                    case '3':{
                                        ?>
                                        <td id="tdtitulogris">Puntaje Global</td>
                                        <td colspan="2"><input type="text" value="<?php echo $datosgrabados['PuntajeGlobal']; ?>" name="puntaje_global" id="puntaje_global"/></td>
                                        <td colspan="2">&nbsp;</td>
                                        <?php
                                    }break;
                                    default:{
                                        ?>
                                        <td id="tdtitulogris"></td>
                                        <td colspan="1">/td>
                                        <?php
                                    }break;
                                }
                                ?>
                            </tr>
                            <tr id="trtituloNaranjaInst">
                                <td colspan="2" >Asignatura</td>
                                <td colspan="2" >Puntaje</td>
                                <?php
                                if ($dataTipo == 1) {
                                    ?>
                                    <td colspan="2" >&nbsp;</td>
                                    <td colspan="2" >&nbsp;</td>
                                    <?php
                                }
                                if ($dataTipo == 2) {
                                    ?>
                                    <td colspan="2" >Nivel</td>
                                    <td colspan="2" >Decil</td>
                                    <?php
                                }
                                if ($dataTipo == 3) {
                                    ?>
                                    <td colspan="2" >Nivel</td>
                                    <td colspan="2" >Percentil</td>
                                    <?php
                                }
                                $cuentaidioma = 1;

                                if ($row_datosgrabados <> "") {
                                    //carga las materias y los datos de los puntajes del saber 11
                                    for($i=0;$i>=count($row_datosgrabados);$i++){
                                        unset($materiasF[@$row_datosgrabados['idasignaturaestado']]);
                                        $row_datosgrabados['TipoPrueba'] = $dataTipo;
                                        $row_datosgrabados['opcional'] = $opcional;

                                        include("pintarCamposMaterias.php");
                                    }
                                }
                                //Revisa materia por materia e imprime sus detalles
                                foreach ($row_datosgrabados as $row_datosgrabados) {
                                    if(!empty($row_datosgrabados['nombreasignaturaestado']) && isset($row_datosgrabados['nombreasignaturaestado'])){
                                        include("pintarCamposMaterias.php");
                                    }
                                }

                                ?>
                                <input type="hidden" name="cuentaidioma" id="cuentaidioma" value="<?php echo $cuentaidioma; ?>" />
                            </tr>
                        </table>
                        <?php
                        if ($aplica_reclasificacion) {
                            ?>
                            <table class="resultados table" style="font-size: 13px">
                                <tr id="trtituloNaranjaInst" class="text-center">
                                    <td colspan="7" >RECLASIFICACIÓN</td>
                                </tr>
                                <tr>
                                    <td colspan="2" id="tdtitulogris" align="center">ASIGNATURA</td>
                                    <td colspan="1" id="tdtitulogris" align="center">PUNTAJE (00)</td>
                                </tr>
                                <?php
                                $cuentaidiomar = 1;
                                if (count($row_asignaturas2) > 0) {
                                    foreach($row_asignaturas2 as $asignaturas2){
                                        ?>
                                        <tr>
                                            <td colspan="2"><?php echo $asignaturas2['nombreasignaturaestado']; ?>
                                                <input type="hidden" name="total_array[]" value="1">
                                                <input type="hidden" name="asignatura_reclasificacion<?php echo $cuentaidiomar; ?>" value="<?php echo $asignaturas2['idasignaturaestado']; ?>">
                                            </td>
                                            <td colspan="1"align="center">
                                                <input type="text" name="puntaje_reclasificacion<?php echo $cuentaidiomar; ?>" size="4" maxlength="6" value="<?php if(isset($_POST['puntaje_reclasificacion' . $cuentaidiomar])){echo $_POST['puntaje_reclasificacion' . $cuentaidiomar];} ?>">
                                                <input type="hidden" name="idr<?php echo $cuentaidiomar; ?>" size="3"  value="<?php if(isset($row_datosgrabadosr['ResultadoReclasificacionPruebaEstadoID']) && !empty($row_datosgrabadosr['ResultadoReclasificacionPruebaEstadoID'])) {echo $row_datosgrabadosr['ResultadoReclasificacionPruebaEstadoID']; }?>">
                                            </td>
                                        </tr>
                                        <?php
                                        $cuentaidiomar ++;
                                    }//foreach
                                }
                                ?>
                            </table>
                            <?php
                        }
                        ?>
                        <script language="javascript">
                            function grabar() {
                                document.inscripcion.submit();
                            }
                            function vista() {
                                window.location.href = "vistaformularioinscripcion.php";
                            }
                        </script>
                        <br><br>
                        <input class="button" type="button" id="btnEnviar" value="Enviar" onClick="grabar()" />
                        <input class="button" type="hidden" name="tipoPrueba" id="tipoPrueba" value="<?php echo $dataTipo; ?>" />
                        <input class="button" type="hidden" name="grabado" value="grabado" />
                        <?php
                        if (isset($_GET['codigoestudiante']) && !empty($_GET['codigoestudiante']) && isset($_GET['flag']) && empty($_GET['flag'])) {
                            $url = HTTP_ROOT . "/serviciosacademicos/consulta/prematricula/matriculaautomaticaordenmatricula.php?codigocreado=" . $row_data['numerodocumento'];
                        } else {
                            if(isset($_SESSION['fppal']) && !empty($_SESSION['fppal'])){
                                $url = HTTP_ROOT . "/serviciosacademicos/consulta/prematricula/inscripcionestudiante/formulariodeinscripcion.php?" . $_SESSION['fppal'] . "#ancla" . $_SESSION['modulosesion'];
                            }else{
                                $url = HTTP_ROOT."/serviciosacademicos/consulta/prematricula/matriculaautomaticaordenmatricula.php";
                            }
                        }
                        ?>

                        <input type="button" onClick="window.location.href = '<?php echo $url; ?>'" name="Regresar" value="Regresar">
                        <?php
                        //proceso de guardado
                        $banderagrabar = 0;
                        if (isset($_POST['grabado'])) {
                            if(isset($_POST['nombre']) && !empty($_POST['nombre'])){
                                if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$", $_POST['nombre']) and $_POST['nombre'] <> "")) {
                                    echo '<script language="JavaScript">alert("El Nombre de la Prueba es Incorrecto"); history.go(-1);</script>';
                                    $banderagrabar = 1;
                                }
                            }else{
                                $_POST['nombre'] = "";
                            }
                            if(isset($_POST['puesto']) && !empty($_POST['puesto'])){
                                if (!eregi("^[0-9]{1,15}$", $_POST['puesto']) and $_POST['puesto'] <> "") {
                                    echo '<script language="JavaScript">alert("Puesto Incorrecto"); history.go(-1);</script>';
                                    $banderagrabar = 1;
                                }
                            }else{
                                $_POST['puesto'] = "0";
                            }
                            if(!isset($_POST['descripcion']) && empty($_POST['descripcion'])){
                                $_POST['descripcion'] = "";
                            }

                            if ($_POST['registro'] == "") {
                                echo '<script language="JavaScript">alert("Debe digitar el No. de registro"); history.go(-1);</script>';
                                $banderagrabar = 1;
                            }
                            //validacion de materias y puntajes
                            for ($i = 1; $i < intval($_POST['cuentaidioma']); $i++) {
                                if ($_POST['asignatura' . $i] < 9) {
                                    if (!eregi("^[0-9]{1,3}\.[0-9]{1,2}$", $_POST['puntaje' . $i]) or $_POST['puntaje' . $i] > 100) {
                                        $banderagrabar = 1;
                                    }
                                } else {
                                    if (!(is_numeric($_POST['puntaje' . $i]))) {
                                        $banderagrabar = 1;
                                    } else {
                                        if (floatval($_POST['puntaje' . $i]) > 100) {
                                            $banderagrabar = 1;
                                        }
                                    }
                                }
                            }//for

                            if (isset($_POST['aplica_reclasificacion']) && !empty($_POST['aplica_reclasificacion']) && $_POST['aplica_reclasificacion'] == "1") {
                                for ($i = 1; $i < $cuentaidiomar; $i++) {
                                    if (!eregi("^[0-9]{1,3}$", $_POST['puntaje_reclasificacion' . $i])) {
                                        $banderagrabar = 1;
                                    } else {
                                        if (floatval($_POST['puntaje_reclasificacion' . $i]) > 100) {
                                            $banderagrabar = 1;
                                        }
                                    }
                                }
                            }
                            if ($banderagrabar == 1) {
                                echo '<script language="JavaScript">alert("Los puntajes deben estar dados en rangos de 0 - 100 con dos decimales (00.00)"); history.go(-1);</script>';
                                $banderagrabar = 1;
                            } elseif ($banderagrabar == 0) {
                                $idResultado = desactivarRegistrosAnteriores($db, $_POST['idestudiante']);
                                $where = "";

                                if (!empty($idResultado)) {
                                    $base = "UPDATE ";
                                    $where = " AND idresultadopruebaestado = " . $idResultado;
                                } else {
                                    $base = "INSERT INTO ";
                                }

                                $base .= " resultadopruebaestado
                                SET nombreresultadopruebaestado = '" . $_POST['nombre'] . "',
                                numeroregistroresultadopruebaestado = '" . $_POST['registro'] . "',
                                puestoresultadopruebaestado = '" . $_POST['puesto'] . "',
                                fecharesultadopruebaestado = '" . $_POST['fecha1'] . "',
                                observacionresultadopruebaestado = '" . $_POST['descripcion'] . "',
                                PuntajeGlobal = '" . $_POST['puntaje_global'] . "', 
                                usuarioModificacion = '" . @$_SESSION['idusuario'] . "', 
                                fechaModificacion = NOW()
                                WHERE idestudiantegeneral = '" . $_POST['idestudiante'] . "' 
                                AND codigoestado = 100 " . $where;
                                $sol = $db->Execute($base);


                                if (empty($idResultado)) {
                                    $idResultado = $db->insert_Id();
                                }

                                $datos["idresultadopruebaestado"] = $idResultado;

                                $fech2 = '2014-07-31';
                                $updateEstado = "";
                                for ($i = 1; $i < intval($_POST['cuentaidioma']); $i++) {
                                    if ($_POST['puntaje' . $i] <> "") {
                                        if ($_POST['id' . $i] <> "") {
                                            if(!isset($_POST['nivel' . $i]) && empty($_POST['nivel' . $i])){
                                                $_POST['nivel' . $i] = "";
                                            }
                                            $base1 = "update detalleresultadopruebaestado ".
                                            " set notadetalleresultadopruebaestado = '" . $_POST['puntaje' . $i] . "', ".
                                            " nivel = '" . $_POST['nivel' . $i] . "', decil = '" . $_POST['decil' . $i] . "' ".
                                            " where iddetalleresultadopruebaestado = '" . $_POST['id' . $i] . "'";
                                        } else {
                                            $base1 = "INSERT INTO detalleresultadopruebaestado (idresultadopruebaestado,  ".
                                            " idasignaturaestado, notadetalleresultadopruebaestado, nivel, decil, codigoestado) ".
                                            " VALUES ('" . $datos["idresultadopruebaestado"] . "', '" . $_POST['asignatura' . $i] . "', ".
                                            " '" . $_POST['puntaje' . $i] . "', '" . $_POST['nivel' . $i] . "', '" . $_POST['decil' . $i] . "', '100')";
                                        }
                                        $sol1 = $db->Execute($base1);
                                    }
                                    $idResult = $datos["idresultadopruebaestado"];
                                }//for
                                for ($i = 1; $i < intval($_POST['cuentaidioma']); $i++) {
                                    if (isset($_POST['puntaje_reclasificacion' . $i]) && !empty($_POST['puntaje_reclasificacion' . $i])) {
                                        if ($_POST['idr' . $i] <> "") {
                                            $base1 = "update detalleresultadopruebaestado ".
                                            " set notadetalleresultadopruebaestado = '" . $_POST['puntaje_reclasificacion' . $i] . "', ".
                                            " nivel = '" . $_POST['nivel' . $i] . "', decil = '" . $_POST['decil' . $i] . "' ".
                                            " where iddetalleresultadopruebaestado = '" . $_POST['idr' . $i] . "'";
                                        } else {
                                            $base1 = "INSERT INTO detalleresultadopruebaestado (idresultadopruebaestado,  ".
                                            " idasignaturaestado, notadetalleresultadopruebaestado, nivel, decil, codigoestado) ".
                                            " VALUES ('" . $datos["idresultadopruebaestado"] . "', '" . $_POST['asignatura' . $i] . "', ".
                                            " '" . $_POST['puntaje' . $i] . "', '" . $_POST['nivel' . $i] . "', '" . $_POST['decil' . $i] . "', '100')";
                                        }
                                        $sol1 = $db->Execute($base1);
                                    }
                                }//for
                                $tipoP = $_POST['tipoPrueba'];
                                if ($tipoP !== '1') {
                                    $base1 = "update detalleresultadopruebaestado set codigoestado = '300'  ".
                                    " where idasignaturaestado < 10 AND idresultadopruebaestado ='" . $idResult . "'";
                                    $sol2 = $db->Execute($base1);
                                } else {
                                    $base2 = "update detalleresultadopruebaestado set codigoestado = '300' ".
                                    " where idasignaturaestado >9 AND idresultadopruebaestado ='" . $idResult . "'";
                                    $sol2 = $db->Execute($base2);
                                }
                                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=editaringresoicfes_new.php?inicial&idestudiante=" .$idestudiantegeneral . "&codigoestudiante=" . $_POST['codigoestudiante'] . "&tipoPrueba=" . $_POST['tipoPrueba'] . "'>";
                            }
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            $(function () {
                $("#fecha1").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "button",
                    buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
            });
            function fechasaber11(fechaprueba) {
                var fech1 = document.getElementById(fechaprueba).value;
                var fech2 = '2014-07-31';
                var fech3 = '2016-03-01';
                var idEstudiante = document.getElementById('idestudiante').value;
                if ((parseDate(fech1)) > (parseDate(fech2))) {
                    if ((parseDate(fech1)) > (parseDate(fech3))) {
                        document.location = ('editaringresoicfes_new.php?inicial&idestudiante=' + idEstudiante + '&date=' + fech1 + '&tipoPrueba=3&codigoestudiante=<?php echo $_REQUEST['codigoestudiante']; ?>&editar=true');
                    } else {
                        document.location = ('editaringresoicfes_new.php?inicial&idestudiante=' + idEstudiante + '&date=' + fech1 + '&tipoPrueba=2&codigoestudiante=<?php echo $_REQUEST['codigoestudiante']; ?>&editar=true');
                    }
                } else {
                    document.location = ('editaringresoicfes_new.php?inicial&idestudiante=' + idEstudiante + '&date=' + fech1 + '&codigoestudiante=<?php echo $_REQUEST['codigoestudiante']; ?>&editar=true');
                }
            }

            function parseDate(input) {
                var parts = input.split('-');
                return new Date(parts[0], parts[1] - 1, parts[2]); // Note: months are 0-based
            }
        </script>
    </body>
</html>