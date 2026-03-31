<?php
$version_js = 16;
session_start();
include "funciones.php";
include_once ('../EspacioFisico/templates/template.php');
$db = getBD();
if (isset($_REQUEST["codigoPeriodo"])) {
    $Periodo = $_REQUEST["codigoPeriodo"];
}
/* * * OBTENER DATOS DEL DOCENTE ** */
if (isset($_GET['id_Docente'])) {
    $id_Docente = $_GET['id_Docente'];
    $SQL = "SELECT * FROM docente WHERE iddocente=" . $id_Docente;

    if ($Docente = &$db->Execute($SQL) === false) {
        echo 'Error en consulta a base de datos';
        die;
    }
} else if (isset($_SESSION["MM_Username"])) {
    $SQL = 'SELECT * FROM docente WHERE numerodocumento="' . $_SESSION["numerodocumento"] . '"';

    if ($Docente = &$db->Execute($SQL) === false) {
        echo 'Error en consulta a base de datos';
        die;
    }
    $id_Docente = $Docente->fields['iddocente'];
} else {
    echo 'No se encuentra registrado en el sistema.';
    die;
}
if ($_SESSION["MM_Username"] == 'coorviceacad' || $_REQUEST["id_Docente"] =='273'){
    $SQL="SELECT codigoperiodo, nombreperiodo, codigoestadoperiodo
            FROM periodo
            WHERE numeroperiodo in (1,2)  order by codigoperiodo desc limit 16;";
}else {
    $SQL = "SELECT codigoperiodo, nombreperiodo, codigoestadoperiodo
        FROM periodo
        WHERE codigoperiodo
                  BETWEEN (SELECT max(codigoperiodo-3)
                           FROM periodo
                           WHERE codigoperiodo <
                                 (SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo IN (1, 3, 4) LIMIT 1))
                  AND (SELECT max(codigoperiodo)
                       FROM periodo
                       WHERE codigoperiodo = (SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo IN (1, 3, 4) LIMIT 1))
        ORDER BY codigoperiodo DESC;";
}
$Periodos = $db->GetArray($SQL);
if ($Periodos === false) {
    echo 'Error al consultar el periodo en la base de datos';
    die;
}

/* * * OBTENER VOCACIONES ** */
$SQL = 'SELECT * FROM VocacionPlanesTrabajoDocentes';

if ($Vocaciones = &$db->Execute($SQL) === false) {
    echo 'Error en consulta a base de datos ';
    die;
} else {
    $i = 0;
    $arr_vocaciones = array();
    $arr_vocaciones_id = array();
    if (!$Vocaciones->EOF) {
        while (!$Vocaciones->EOF) {
            $arr_vocaciones[$i] = $Vocaciones->fields['Nombre'];
            $arr_vocaciones_id[$i] = $Vocaciones->fields['VocacionesPlanesTrabajoDocenteId'];
            $Vocaciones->MoveNext();
            $i++;
        }
    }
}

/* * * OBTENER MODALIDADES ** */
$SQL = 'SELECT codigomodalidadacademica, nombremodalidadacademica FROM modalidadacademica
WHERE codigomodalidadacademica NOT IN(506,600,700)	
AND codigoestado = 100';

if ($Modalidades = &$db->Execute($SQL) === false) {
    echo 'Error en consulta a base de datos';
    die;
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Planeación de Actividades Académicas</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link type="text/css" rel="stylesheet" href="css/styles.css" />
    <link type="text/css" rel="stylesheet" href="css/style2.css?v=1">
    <link type="text/css" rel="stylesheet" href="css/gips.css" />
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="tema/uploadify/css/uploadifive.css">
    <script src="js/libs/jquery-ui.js"></script>
    <link rel="stylesheet" href="../mgi/css/cssreset-min.css" type="text/css" />
    <link rel="stylesheet" href="../css/demo_page.css" type="text/css" />
    <link rel="stylesheet" href="../css/demo_table_jui.css" type="text/css" />
    <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" />
    <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" />
    <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" />
    <link rel="shortcut icon" href="images/favicon.ico" />
    <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="../mgi/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
    <script type="text/javascript" language="javascript" src="../mgi/js/jquery.fastLiveFilter.js"></script>
    <script type="text/javascript" language="javascript" src="../mgi/js/nicEdit.js"></script>
    <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
    <script type="text/javascript" language="javascript" src="../mgi/js/functionsMonitoreo.js"></script>
    <script type="text/javascript" language="javascript" src="js/functionV2.js?v=<?php echo $version_js; ?>"></script>
    <script type="text/javascript" language="javascript" src="js/custom.js"></script>
    <script src="js/gips.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="css/notificaciones.css" />
    <script type="text/javascript" src="js/notificaciones.js"></script>
    <script type="text/javascript" src="js/MainIndex.js"></script>
    <script type="text/javascript" src="js/MainPeriodo.js"></script>
    <script language="javascript" type="text/javascript" src="tema/uploadify/js/jquery.uploadifive.min.js"></script>
    <script language="javascript" type="text/javascript" src="tema/uploadify/js/jquery.uploadifive.js"></script>

    <script language="javascript" type="text/javascript" src="tema/ckeditor/ckeditor.js"></script>
    <style type="text/css">

        table#TablaPortafolio th, td {
            border: 0px solid #000;
        }

        #btnDocenteSobreSueldo{
            background: #fffc0b;
            border: none;
            padding: 5px 15px 5px 15px;
            color: #585858;
            border-radius: 4px;
            -moz-border-radius: 4px;
            -webkit-border-radius: 4px;
            text-shadow: 1px 1px 1px #FFE477;
            font-weight: normal;
            box-shadow: 1px 1px 1px #3D3D3D;
            -webkit-box-shadow:1px 1px 1px #3D3D3D;
            -moz-box-shadow:1px 1px 1px #3D3D3D;
            margin-top:10px;
        }

        #btnManualPortafolio{
            color: #FF0A75;
        }

        #btnDocenteSobreSueldo:hover {
            color: #333;
            background-color: #EBEBEB;
        }

        hr{
            border: 0;
            height: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .ui-dialog .ui-dialog-titlebar-close span { display:none;}


    </style>
    <script type="text/javascript">
        $(function () {
            $("#tabs").tabs({
                beforeLoad: function (event, ui) {
                    ui.jqXHR.error(function () {
                        ui.panel.html(
                            "Ocurrio un problema cargando el contenido.");
                    });
                }
            });
            $("#tabs").tabs({cache: true});
        });
        function popup_carga(url) {

            var centerWidth = (window.screen.width - 910) / 2;
            var centerHeight = (window.screen.height - 700) / 2;

            var opciones = "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=960, height=700, top=" + centerHeight + ", left=" + centerWidth;
            var mypopup = window.open(url, "", opciones);
            //para poner la ventana en frente
            window.focus();
            mypopup.focus();

        }

        function cargar() {
            var url = "index.php?id_Docente=<?php echo $id_Docente; ?>";

            $(".wrapper-general").load(url, {}, function () {
                $("#tabs").tabs({selected: 1});
                $("#contenedorPortafolio").css("display", "block");
            });
        }

        function verResumen(iddocente, codigoperiodo) {

            $.ajax({
                type: 'POST',
                url: 'peticiones_ajax.php',
                async: false,
                dataType: 'json',
                data: ({actionID: 'cargar_resumen',
                    iddocente: iddocente,
                    codigoperiodo: codigoperiodo
                }),
                error: function (objeto, quepaso, otroobj) {
                    alert('Error de Conexión , Favor Vuelva a Intentar');
                },
                success: function (data) {
                    $('#resumenHoras').css("display", "block");
                    $('#resultadoResumen').html(data.tabla);
                }
            });
            $.ajax({
                type: 'POST',
                url: 'peticiones_ajax.php',
                async: false,
                dataType: 'json',
                data: ({actionID: 'cargar_resumenSS',
                    iddocente: iddocente,
                    codigoperiodo: codigoperiodo
                }),
                error: function (objeto, quepaso, otroobj) {
                    alert('Error de Conexión , Favor Vuelva a Intentar');
                },
                success: function (data) {

                    if (data.tablaSobresueldo != "") {
                        $('#resultadoResumenSS').css("display", "block");
                        $('#resultadoResumenSS').html("<h2><font color='white'>SobreSueldo</font></h2><br />" + data.tablaSobresueldo);
                    } else {
                        $('#resultadoResumenSS').css("display", "none");
                    }

                }
            });
            $('#resumenHoras').dialog("open");
        }
    </script>
    <script>
        $(function () {


            $("#dialog").dialog({
                autoOpen: false,
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                }
            });

            $("#dialog_descubrimiento").dialog({
                autoOpen: false,
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                }
            });

            $("#dialog_compromiso").dialog({
                autoOpen: false,
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                }
            });

            $("#dialog_gestion").dialog({
                autoOpen: false,
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                }
            });

            $("#ayuda_ensenanza").click(function () {
                $("#dialog").dialog("open");
            });

            $("#ayuda_descubrimiento").click(function () {
                $("#dialog_descubrimiento").dialog("open");
            });

            $("#ayuda_compromiso").click(function () {
                $("#dialog_compromiso").dialog("open");
            });

            $("#ayuda_gestion").click(function () {
                $("#dialog_gestion").dialog("open");
            });

            $("#dialog_Notificaciones").dialog({
                autoOpen: false,
                modal: true,
                title: 'Observacion del Director del Programa',
                width: 700,
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                }
            });

            $("#dialog_Portafolio").dialog({
                autoOpen: false,
                title: 'Portafolio',
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                }
            });


            $("#dialog_HoraSobreSueldo").dialog({
                autoOpen: false,
                title: 'Horas de Sobre Sueldo',
                width: 450,
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                }
            });

            $("#detalleAutoEvaluacion").dialog({
                autoOpen: false,
                modal: true,
                title: 'AutoEvaluación',
                width: 700,
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                }
            });


            $("#migracionDatos").dialog({
                autoOpen: false,
                modal: true,
                title: 'Migración de Datos',
                width: 'auto',
                closeOnEscape: false,
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                }
            });


            $("#mensageAutoEvaluacion").dialog({
                autoOpen: false,
                modal: true,
                title: 'Confirmar Autoevaluación',
                width: 'auto',
                closeOnEscape: false,
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                }
            });

            $("#mensagePlanMejora").dialog({
                autoOpen: false,
                modal: true,
                title: 'Confirmar Plan Mejora',
                width: 'auto',
                closeOnEscape: false,
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                }
            });

            $("#resumenHoras").dialog({
                autoOpen: false,
                modal: true,
                title: 'Confirmar Plan Mejora',
                width: 'auto',
                closeOnEscape: true,
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                }
            });



        });
    </script>
</head>
<body>
<div class="wrapper-general">
    <div class="wrapper-header">
        <div class="header">
            <img class="logo" src="images/logotipo_negativo.png" />
            <div class="id" id="id">
                <div class="nombre" id="nombre">
                    <?php echo $Docente->fields['nombredocente'] . ' ' . $Docente->fields['apellidodocente']; ?>
                </div>
                <div class="tipodoc" id="tipodoc">
                    Cédula de Ciudadanía: <?php echo $Docente->fields['numerodocumento'] ?>
                    <input type="hidden" value="<?php echo $Docente->fields['numerodocumento'] ?>" id="NumDocumento" />
                    <input type="hidden" value="<?php echo $id_Docente; ?>" id="DocenteId" />
                </div>
                <div class="periodo" id="periodo">
                    Periodo actual:
                    <select id="periodoNuevo" class="periodoNuevo" style="width: 70px;">
                        <?php
                        foreach ($Periodos as $period) {
                            $estadoPeriodo = $period['codigoestadoperiodo'];
                            if ($estadoPeriodo == 2) {
                                $Periodo = $period['codigoperiodo'];
                            }
                            $numPeriodo = substr($period['codigoperiodo'],4,5);
                            if($numPeriodo!=3 && $numPeriodo!=4 && $numPeriodo!=5) {
                                echo "<option value='" . $period['codigoperiodo'] . "' >" . $period['codigoperiodo'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <?php
                    $sqlEstadoPeriodo = 'select codigoestadoperiodo 
										from periodo where';
                    if (isset($_REQUEST["codigoPeriodo"])) {
                        $sqlEstadoPeriodo .= ' codigoperiodo = "' . $_REQUEST['codigoPeriodo'] . '" ';
                    } else {
                        $sqlEstadoPeriodo .= ' codigoperiodo ="' . $Periodo . '"';
                    }

                    $codigoEstadoPeriodo = $db->Execute($sqlEstadoPeriodo);

                    $estadoNuevoPerido = $codigoEstadoPeriodo->fields["codigoestadoperiodo"];
                    ?>
                    <br/>
                    <input type="hidden" value="<?php
                    if (isset($_REQUEST["codigoPeriodo"])) {
                        $Periodo = $_REQUEST["codigoPeriodo"];
                        echo $Periodo;
                    } else {
                        echo $Periodo;
                    }
                    ?>" id="Periodo" />
                    <input type="hidden" value="<?php echo $estadoNuevoPerido; ?>" id="estadoPeriodo" />
                </div>
                <div id="migracionDatos" style="font-family: Arial, Helvetica, sans-serif; font-size: 10pt;">¿ Desea cargar la información del período inmediatamente anterior al     período actual ?
                </div>
            </div>
        </div>
    </div>
    <div id="cuerpo" >
        <div id="grueso">
            <div id="tabs" class="dontCalculate">
                <div style="background:#7f7f7f;">
                    <div class="cajon">
                        <ul>
                            <li><a href="#tabs-1"></a></li>
                            <li><a href="#tabs-2" id="tabs_2">Planeación de actividades</a></li>
                            <li><a href="#tabs-3" id="tabs_resumen_boton">Resumen</a></li>

                            <?php if ($Docente->fields['numerodocumento'] == 52256041 || $Docente->fields['numerodocumento'] == 35497790 || $Docente->fields['numerodocumento'] == 51826550 || $Docente->fields['numerodocumento'] == 1020768207) { ?>
                                <li><a href="./reporteGeneral.php?txtNumeroDocumento=<?php echo $Docente->fields['numerodocumento']; ?>&txtCodigoPeriodo=<?php echo $Periodo; ?>" id="tabs_resumen_boton">Reporte de Diligenciamiento</a></li>
                                <li><a href="./_tablaReporteGeneralDocenteHoras.php?txtNumeroDocumento=<?php echo $Docente->fields['numerodocumento']; ?>&txtCodigoPeriodo=<?php echo $Periodo; ?>" id="tabs_resumen_boton">Reporte Horas</a></li>
                            <?php } else { ?>
                                <li><a href="./reporteGeneral.php?iddocente=<?php echo $id_Docente ?>&txtCodigoPeriodo=<?php echo $Periodo; ?>" id="tabs_resumen_boton">Reporte de Diligenciamiento</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

                <!-- primera pesta&ntilde;a -->
                <div id="tabs-1" class="tab">
                    <div class="cajon">
                        <img id="sombrilla" src="images/sombrilla.png" />
                        <div id="introduccion">
                            <div id="titulo">
                                <span>Planeaci&oacute;n de</span>
                                <span>Actividades</span>
                                <span>Acad&eacute;micas</span>
                            </div>
                            <p>Como acad&eacute;mico en la Universidad El Bosque usted puede desarrollar su actividad a trav&eacute;s de cuatro orientaciones complementarias no excluyentes:</p>
                            <ul>
                                <li><span>Ense&ntilde;anza-Aprendizaje:</span> Se enfoca en la formaci&oacute;n del estudiante y se centra en el aprendizaje de este.</li>
                                <li><span>Descubrimiento:</span> Se concentra en la generaci&oacute;n y desarrollo de conocimiento a trav&eacute;s de la investigaci&oacute;n.</li>
                                <li><span>Compromiso:</span> Aplica el conocimiento a trav&eacute;s del servicio mediante relaciones para la colaboraci&oacute;n.</li>
                                <li><span>Gesti&oacute;n Academica:</span> conecta las diferentes disciplinas y demas vocaciones en busca de un bien com&uacute;n.</li>
                            </ul>
                            <p>Esta herramienta le permitir&aacute; llevar un registro de su actividad en cualquiera de las cuatro orientaciones e identificar oportunidades de mejora para el desarrollo de su curso.</p>
                            <ul>
                                <li><span style="color: yellow;">Nota: Recuerde que la dedicacion en horas semanales no puede exceder  a lo contratado por la Universidad</span></li>
                            </ul>
                        </div>

                    </div>
                </div>

                <!-- segunda pesta&ntilde;a -->
                <div id="tabs-2" class="tab">
                    <div class="cajon">
                        <form id="TabUno" name="TabUno">
                            <table>
                                <tr>
                                    <td>
                                        <p style="padding-top: 30px">A continuación llene su plan de trabajo de acuerdo a las vocaciones.</p>
                                    </td>
                                    <?php
                                    /*                                             * **Obtener Docentes con Sobre Sueldo**** */
                                    $sqlDocentesSobreSueldo = "SELECT COUNT(DocenteId) AS existe FROM DocenteSobreSueldos
                                                                        WHERE DocenteID = $id_Docente AND CodigoEstado = 100";

                                    $docentesSobreSueldo = $db->Execute($sqlDocentesSobreSueldo);

                                    $docentesSobreSueldo = $docentesSobreSueldo->fields["existe"];
                                    ?>
                                    <td><input type="hidden" id="txtExisteDocente" name="txtExisteDocente" value="<?php if (isset($docentesSobreSueldo)) echo $docentesSobreSueldo; ?>" /></td>
                                </tr>
                            </table>

                            <?php
                            $sqlObservacion = "SELECT CRA.nombrecarrera as programa, CRA.CodigoCarrera as CodigoCarrera
                                                        FROM ObservacionDecanos OBS
                                                        INNER JOIN carrera CRA ON (CRA.codigocarrera = OBS.CodigoCarrera)
                                                        WHERE DocenteId = $id_Docente AND CodigoPeriodo = " . $Periodo . "
                                                        AND CodigoEstado = 100 GROUP BY CodigoCarrera ORDER BY CodigoCarrera";


                            $selectObservaciones = $db->GetArray($sqlObservacion);

                            $cantidadNuevos = $selectObservaciones->_numOfRows;

                            foreach ($selectObservaciones as $selectObservacion) {



                                $id_Programas = $selectObservacion['CodigoCarrera'];

                                $sqlContar = "SELECT count( OBS.CodigoCarrera ) total, OBS.CodigoCarrera
                                                        FROM ObservacionDecanos OBS
                                                        WHERE DocenteId = $id_Docente AND CodigoPeriodo = $Periodo
                                                        AND CodigoCarrera = " . $selectObservacion['CodigoCarrera'] . "
                                                        AND CodigoEstado = 100 ORDER BY total";


                                $contar = $db->Execute($sqlContar);
                                ?>
                                <script type="text/javascript">
                                    $(document).ready(function () {

                                        //si no existe la ventana notificaciones la creamos,
                                        //esta será la que contendrá a todas las notificaciones
                                        if ($("#notificaciones").length == 0) {
                                            //creamos el div con id notificaciones
                                            var contenedor_notificaciones = $(window.document.createElement('div')).attr("id", "notificaciones");
                                            //a continuación la añadimos al body
                                            $('#tabs-2').append(contenedor_notificaciones);
                                        }


                                        //llamamos al plugin y le pasamos las opciones
                                        $.notificaciones({
                                            mensaje: '<a href="observacion.php?id_Programa=<?php echo $id_Programas; ?>&id_Docente=<?php echo $id_Docente; ?>&Periodo=<?php echo $Periodo; ?>" id="txtIdPrograma" style="text-decoration:none"><font color="white"><?php echo "Tiene " . $contar->fields['total'] . " " . "observación de" . " " . $selectObservacion['programa']; ?></font></a>',
                                            width: 300,
                                            cssClass: 'info', //clase de la notificación
                                            timeout: 0, //milisegundos
                                            fadeout: 8000, //tiempo en desaparecer
                                            radius: 6//border-radius


                                        });

                                        $('a#txtIdPrograma').click(function () {

                                            var url = $(this).attr("href");

                                            var tipoOperacion = "listarObservaciones";
                                            $.ajax({
                                                url: url,
                                                data: {tipoOperacion: tipoOperacion},
                                                success: function (data) {
                                                    $("#dialog_Notificaciones").html(data);
                                                }
                                            });
                                            $("#dialog_Notificaciones").dialog("option", "buttons", {
                                                "Aceptar Recomendación": function () {
                                                    var tipoOperacion = "actualizarObservaciones";
                                                    $.ajax({
                                                        url: url,
                                                        data: {tipoOperacion: tipoOperacion},
                                                        success: function (data) {
                                                            $("#dialog_Notificaciones").dialog("close");
                                                            location.reload();
                                                        }
                                                    });
                                                },
                                                "Marcar como no leído": function () {
                                                    $("#dialog_Notificaciones").dialog("close");
                                                }
                                            });

                                            $("#dialog_Notificaciones").dialog("open");
                                            return false
                                        });



                                    });
                                </script>
                                <?php
                            }
                            $sqlAutoEvaluacion = "SELECT
                        CRA.nombrecarrera AS programa,
                        AED.CodigoCarrera AS CodigoCarrera,
                        GROUP_CONCAT(
                            AED.VocacionesId ORDER BY
                            AED.VocacionesId SEPARATOR '|'
                                ) AS vocacionesid
                        FROM AutoevaluacionDocentes AED
                        INNER JOIN carrera CRA ON (CRA.codigocarrera = AED.CodigoCarrera)
                        WHERE AED.DocenteId = $id_Docente ND AED.CodigoPeriodo = $Periodo
                        AND AED.CodigoEstado = 100 AND AED.ComentarioDecanos IS NOT NULL
                        GROUP BY AED.CodigoCarrera ORDER BY AED.CodigoCarrera";

                            $selectAutoEvaluaciones = $db->GetArray($sqlAutoEvaluacion);

                            $cantidadNuevos = $selectObservaciones->_numOfRows;

                            foreach ($selectAutoEvaluaciones as $selectAutoEvaluacion) {



                                $id_Programa = $selectAutoEvaluacion['CodigoCarrera'];

                                $id_Vocaciones = $selectAutoEvaluacion['vocacionesid'];

                                $sqlContarAE = "SELECT
                    count(AED.CodigoCarrera) total,
                    AED.CodigoCarrera
                    FROM AutoevaluacionDocentes AED
                    WHERE DocenteId = $id_Docente AND CodigoPeriodo = $Periodo
                    AND CodigoCarrera = $id_Programa AND CodigoEstado = 100
                    AND AED.ComentarioDecanos IS NOT NULL ORDER BY total";
                                $contarAE = $db->Execute($sqlContarAE);
                                ?>
                                <script type="text/javascript">
                                    $(document).ready(function () {

                                        //si no existe la ventana notificaciones la creamos,
                                        //esta será la que contendrá a todas las notificaciones
                                        if ($("#notificaciones").length == 0) {
                                            //creamos el div con id notificaciones
                                            var contenedor_notificaciones = $(window.document.createElement('div')).attr("id", "notificaciones");
                                            //a continuación la añadimos al body
                                            $('#tabs-2').append(contenedor_notificaciones);
                                        }


                                        //llamamos al plugin y le pasamos las opciones
                                        $.notificaciones({
                                            mensaje: '<a href="detalleAutoevaluacion.php?id_Programa=<?php echo $id_Programa; ?>&id_Docente=<?php echo $id_Docente; ?>&Periodo=<?php echo $Periodo; ?>&idVocaciones=<?php echo $id_Vocaciones; ?>" id="txtIdProgramaAE" style="text-decoration:none"><font color="white"><?php echo "Tiene " . $contarAE->fields['total'] . " " . "Comentario de Autoevaluación de" . " " . $selectAutoEvaluacion['programa']; ?></font></a>',
                                            width: 300,
                                            cssClass: 'success', //clase de la notificación
                                            timeout: 0, //milisegundos
                                            fadeout: 8000, //tiempo en desaparecer
                                            radius: 6//border-radius
                                        });

                                        $('a#txtIdProgramaAE').click(function () {

                                            var url = $(this).attr("href");
                                            var tipoOperacion = "listaAutoEvaluacion";
                                            $.ajax({
                                                url: url,
                                                data: {tipoOperacion: tipoOperacion},
                                                success: function (data) {
                                                    $("#detalleAutoEvaluacion").html(data);
                                                }
                                            });
                                            $("#detalleAutoEvaluacion").dialog("option", "buttons", {
                                                "Aceptar": function () {
                                                    var tipoOperacion = "actualizarAutoEvaluacion";
                                                    $.ajax({
                                                        url: url,
                                                        data: {tipoOperacion: tipoOperacion},
                                                        success: function (data) {
                                                            $("#detalleAutoEvaluacion").dialog("close");
                                                            location.reload();
                                                        }
                                                    });
                                                },
                                                "Cancelar": function () {
                                                    $("#detalleAutoEvaluacion").dialog("close");
                                                }
                                            });

                                            $("#detalleAutoEvaluacion").dialog("open");
                                            return false
                                        });



                                    });
                                </script>
                                <?php
                            }
                            ?>
                            <div id="dialog_Notificaciones" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                            </div>
                            <table class="selector">
                                <thead>
                                <tr>
                                    <th><input type="hidden" id="Docente_id" name="Docente_id" value="<?php echo $id_Docente; ?>" /><h2>Modalidad</h2></th>
                                    <td><select id="modalidad">
                                            <option value="0" selected="selected">Seleccione</option>
                                            <?php
                                            if (!$Modalidades->EOF) {
                                                while (!$Modalidades->EOF) {

                                                    if ($Modalidades->fields['codigomodalidadacademica'] == 400) {
                                                        $Modalidades->fields['nombremodalidadacademica'] = "Centro de Lenguas";
                                                    }
                                                    echo '<option value="' . $Modalidades->fields['codigomodalidadacademica'] . '">' . $Modalidades->fields['nombremodalidadacademica'] . '</option>';
                                                    $Modalidades->MoveNext();
                                                }
                                            }
                                            ?>
                                        </select></td>
                                </tr>
                                <tr id="Div_Facultad">
                                    <th><h2>Unidad académica</h2></th>
                                    <td><div ><select id="facultad" disabled="disabled">
                                                <option value="0" selected="selected">Seleccione</option>
                                            </select></div></td>
                                </tr>
                                <tr>
                                    <th><h2>Programa adscrito</h2></th>
                                    <td><div id="Div_Programa"><select id="programa" disabled="disabled">
                                                <option value="0" selected="selected">Seleccione</option>
                                            </select></div></td>
                                </tr>
                                </thead>
                            </table>
                            <br />
                            <table border="0" style="width:100%; margin: auto">
                                <tr>
                                    <td>
                                        <button type="button" id="planTrabajo" class="buttons-menu">Plan de trabajo</button>
                                    </td>
                                    <td>
                                        <button type="button" id="btnPortafolio" class="buttons-menu" >Portafolio de seguimiento</button>
                                    </td>
                                    <td>
                                        <button type="button" id="btnAutoevaluacion" class="buttons-menu" >Autoevaluación</button>
                                    </td>
                                    <td>
                                        <button type="button" id="btnPlanMejora" class="buttons-menu" >Plan de mejora</button>
                                    </td>
                                </tr>
                            </table>
                            <br />
                            <div id="contenedores" class="contenedores" style="display: none;">
                                <fieldset id="cuadro1">
                                    <legend><?php echo ($arr_vocaciones[0]); ?></legend>
                                    <div align="right" id="plus-ensenanza"><img class="plus_pestana" src="images/plus.png" /></div>
                                    <div class="ensenanza" id="ensenanza" style="display: none;">
                                        <div id="dialog" title="Ayuda Ense&ntildeanza y aprendizaje">
                                            <p><strong>Vocaci&oacute;n ense&ntilde;anza aprendizaje</strong></p>

                                            <p>&middot;&nbsp; <strong>CLASE:</strong> horas destinadas al desarrollo de la asignatura</p>

                                            <p>&middot;&nbsp; <strong>PREPARACI&Oacute;N </strong>: horas destinadas para la preparaci&oacute;n</p>

                                            <p>&middot;&nbsp; <strong>EVALUACI&Oacute;N</strong>: horas destinadas a la evaluaci&oacute;n de las actividades de los acad&eacute;micos</p>

                                            <p>&middot;&nbsp; <strong>LABORATORIO</strong>: Horas de acompa&ntilde;amiento a los estudiantes en laboratorios, anfiteatro, talleres y precl&iacute;nicas.</p>

                                            <p>&middot;&nbsp; <strong>&Eacute;XITO</strong>: horas destinadas para el programa institucional de &eacute;xito estudiantil, (PDI 2011 &ndash; 2016, Eje 3, es decir las horas que se destinan para el acompa&ntilde;amiento de estudiantes especialmente para pregrado); o las horas de asesor&iacute;a acad&eacute;mica</p>

                                            <p>&middot;&nbsp; <strong>TIC: </strong>horas destinadas para el programa institucional de TIC, (PDI 2011 &ndash; 2016, es decir las horas que se destinan para el desarrollo de TIC (aulas virtuales)</p>

                                        </div>
                                        <div class="ayuda" id="ayuda_ensenanza" align="right">Ayuda <img src="images/help.png" class="ayuda_ico" /></div>
                                        <div class="orientacion">
                                            <img src="images/orientacion-ensenanza.png" />
                                            <p>La Vocaci&oacute;n de la Ense&ntilde;anza-Aprendizaje se orienta a la actividad formativa con un enfoque centrado en el aprendizaje y en el estudiante en contraste con los enfoques centrados en la ense&ntilde;anza y transmisi&oacute;n de contenidos desde el profesor. El car&aacute;cter Acad&eacute;mico se sustenta en la actitud de pensamiento sobre la actividad docente misma y la evidencia del aprendizaje del estudiante como problemas a ser investigados, analizados, representados y debatidose? y la evidencia de &eacute;ste pensamiento en productos acad&eacute;micos y una mejora continua y sustentada en el quehacer docente.</p>
                                        </div><div id="anteriores_ensenanza" align="center" style="margin-bottom:20px">
                                            <h2>Borrar anteriores</h2>
                                        </div>
                                        <table id="TablaEnsenanzaAprendizaje" >
                                            <tr>
                                                <td>Tareas a desarrollar</td>
                                                <td>
                                                    <select id="tipo_ensenanza">
                                                        <option selected="selected" value="0">Seleccione</option>
                                                        <?php
                                                        $SQL = 'SELECT * FROM TiposPlanesTrabajoDocenteEnsenanza ';
                                                        if ($Tipo_ensenanza = &$db->Execute($SQL) === false) {
                                                            echo 'Error en consulta a base de datos';
                                                            die;
                                                        } else {
                                                            if (!$Tipo_ensenanza->EOF) {
                                                                while (!$Tipo_ensenanza->EOF) {
                                                                    echo '<option value="' . $Tipo_ensenanza->fields['TipoPlanTrabajoDocenteEnsenanzaId'] . '">' . $Tipo_ensenanza->fields['Nombre'] . '</option>';
                                                                    $Tipo_ensenanza->MoveNext();
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr id="table_materia" style="display: none;">
                                                <td>Asignatura</td>
                                                <td><select id="materia" disabled="disabled">
                                                        <option selected="selected" value="-1">Seleccione...</option>
                                                        <option value="0">Asignatura</option>
                                                    </select></td>
                                            </tr>
                                            <?php if ($docentesSobreSueldo == 1) { ?>
                                                <tr id="table_tipoHorasEnsenanza" name="table_tipoHorasEnsenanza" style="display: none">
                                                    <td>Tipo Horas</td>
                                                    <td><select id="cmbTipoHorasEnsenanza" name="cmbTipoHorasEnsenanza">
                                                            <option value="CONTRATO" selected="selected">CONTRATO</option>
                                                            <option value="SOBRESUELDO" >SOBRE SUELDO</option>
                                                        </select></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                        <div id="table_asignatura" style="display: none;">
                                            <table border="0" aling="left" class="" style="width:70%; margin: auto">
                                                <thead>
                                                <tr>
                                                    <td>
                                                        <strong> horas presenciales por semana</strong><span style="color:#FF0000">*</span></strong>
                                                        <input type="text" style="text-align: center;" value="<?PHP echo $Hora['hora'] ?>" size="5" id="HorasSemana_<?PHP echo $CodigoMateria ?>" name="HorasSemana_<?PHP echo $CodigoMateria ?>"  size="5"  onkeypress="return isNumberKey(event);" onchange="Suma()" />
                                                    </td>
                                                    <td>
                                                        <strong> horas de preparaci&oacute;n </strong><span style="color:#FF0000">*</span>
                                                        <input type="text" style="text-align: center;" value="<?PHP echo $Hora['horaTrabajo'] ?>" size="5"  onkeypress="return isNumberKey(event);" onchange="Suma()" id="H_Preparacio_<?PHP echo $CodigoMateria ?>" name="H_Preparacio_<?PHP echo $CodigoMateria ?>"  />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong> horas de evaluaci&oacute;n </strong><span style="color:#FF0000">*</span>
                                                        <input type="text" style="text-align: center;" value="<?PHP echo $Hora['horaEvaluacion'] ?>" size="5"  onkeypress="return isNumberKey(event);" onchange="Suma()" id="H_Evaluacion_<?PHP echo $CodigoMateria ?>" name="H_Evaluacion_<?PHP echo $CodigoMateria ?>"  />
                                                    </td>
                                                    <td>
                                                        <strong> horas de asesor&iacute;a acad&eacute;mica</strong><span style="color:#FF0000">*</span>
                                                        <input type="text" style="text-align: center;" value="<?PHP echo $Hora['horaAsesoria'] ?>" size="5"  onkeypress="return isNumberKey(event);" onchange="Suma()" id="H_Asesoria_<?PHP echo $CodigoMateria ?>" name="H_Asesoria_<?PHP echo $CodigoMateria ?>"  />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="table-center" colspan="2">
                                                        <strong> Total horas semanales</strong><input type="text" readonly="readonly" style="text-align: center;" value="" size="5" id="T_horas"  name="T_horas" /><input type="hidden" id="Plan_<?PHP echo $CodigoMateria ?>" name="Plan_<?PHP echo $CodigoMateria ?>" value="<?PHP echo $Hora['id_plan'] ?>" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><label>Nota: Recuerde que la dedicacion en horas semanales no puede exceder  a lo contratado por la Universidad</label></td>
                                                </tr>
                                                </thead>
                                            </table>
                                            <table id="expense_table" cellspacing="0" cellpadding="0">
                                                <thead>
                                                <tr>
                                                    <th style="width:95%">Planeación de actividades a desarrollar</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><input class="actividad" type='text' id="e0" name='subjects[]' maxlength='800' />
                                                        <input type='hidden' value='0' id='oculto_e0' /></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <input type="button" value="Añadir actividad" id="add_ExpenseRow" />
                                            <br />
                                            <div class="div-btn-guardar"><input type="button" value="Guardar" class="guardar" onclick="ensenanza('asignatura');"/><img align="right" class="less_pestana" onclick="oculta_vocacion('ensenanza');" src="images/less.png" /></div>
                                        </div>
                                        <div id="table_laboratorios" style="display: none;">
                                            <table border="0" aling="left" class="" style="width:70%; margin: auto">
                                                <thead>
                                                <tr>
                                                    <td style="padding-left: 220px;">
                                                        <strong> Laboratorios - talleres - preclinicas</strong><span style="color:#FF0000">*</span></strong>
                                                        <input type="text" style="text-align: center;" value="" size="5" id="HorasTaller_" name="HorasLaboratorio_"  size="5" onchange="Suma('<?PHP echo $CodigoMateria ?>')" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><label>Nota: Recuerde que la dedicacion en horas semanales no puede exceder  a lo contratado por la Universidad</label></td>
                                                </tr>
                                                </thead>
                                            </table>
                                            <table id="expense_table_laboratorios" cellspacing="0" cellpadding="0">
                                                <thead>
                                                <tr>
                                                    <th style="width:95%">Planeación de actividades a desarrollar</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><input class="actividad" type='text' id="l0" name='laboratorios[]' maxlength='800' />
                                                        <input type='hidden' value='0' id='oculto_l0' /></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <input type="button" value="Añadir actividad" id="add_ExpenseRow_laboratorios" />


                                            <br />

                                            <div class="div-btn-guardar" id="btnGuardar" name="btnGuardar" ><input type="button" value="Guardar" class="guardar" onclick="ensenanza('laboratorios');"/><img align="right" class="less_pestana" onclick="oculta_vocacion('ensenanza');" src="images/less.png" /></div>

                                            <div class="div-btn-actualizar" id="btnActualizar" name="btnActualizar" style="display: none;" ><button id="btn-Actualizar" class="actualizar" value="laboratorios" />Actualizar</button><img align="right" class="less_pestana" onclick="oculta_vocacion('ensenanza');" src="images/less.png" /></div>
                                        </div>


                                        <div id="table_pae" style="display: none;">
                                            <table border="0" aling="left" class="" style="width:70%; margin: auto">
                                                <thead>
                                                <tr>
                                                    <td style="padding-left: 220px;">
                                                        <strong> Horas PAE</strong><span style="color:#FF0000">*</span></strong>
                                                        <input type="text" style="text-align: center;" value="" size="5" id="HorasPAE_" name="HorasPAE_"  size="5" onchange="Suma('<?PHP echo $CodigoMateria ?>')" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><label>Nota: Recuerde que la dedicacion en horas semanales no puede exceder  a lo contratado por la Universidad</label></td>
                                                </tr>
                                                </thead>
                                            </table>
                                            <table id="expense_table_pae" cellspacing="0" cellpadding="0">
                                                <thead>
                                                <tr>
                                                    <th style="width:95%">Planeación de actividades a desarrollar</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><input class="actividad" type='text' id="p0" name='pae[]' maxlength='800' />
                                                        <input type='hidden' value='0' id='oculto_p0' /></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <input type="button" value="Añadir actividad" id="add_ExpenseRow_pae" />


                                            <br />
                                            <div class="div-btn-guardar" id="btnGuardarPAE" name="btnGuardarPAE" ><input type="button" value="Guardar" class="guardar" onclick="ensenanza('pae');"/><img align="right" class="less_pestana" onclick="oculta_vocacion('ensenanza');" src="images/less.png" /></div>

                                            <div class="div-btn-actualizar" id="btnActualizarPAE" name="btnActualizarPAE" style="display: none;" ><button id="btn-ActualizarPAE" class="actualizar" value="pae" />Actualizar</button><img align="right" class="less_pestana" onclick="oculta_vocacion('ensenanza');" src="images/less.png" /></div>
                                        </div>

                                        <div id="table_tic" style="display: none;">
                                            <table border="0" aling="left" class="" style="width:70%; margin: auto">
                                                <thead>
                                                <tr>
                                                    <td style="padding-left: 220px;">
                                                        <strong> Horas TIC</strong><span style="color:#FF0000">*</span></strong>
                                                        <input type="text" style="text-align: center;" value="" size="5" id="HorasTIC_" name="HorasTIC_"  size="5" onchange="Suma('<?PHP echo $CodigoMateria ?>')" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><label>Nota: Recuerde que la dedicacion en horas semanales no puede exceder  a lo contratado por la Universidad</label></td>
                                                </tr>
                                                </thead>
                                            </table>
                                            <table id="expense_table_tic" cellspacing="0" cellpadding="0">
                                                <thead>
                                                <tr>
                                                    <th style="width:95%">Planeación de actividades a desarrollar</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><input class="actividad" type='text' id="t0" name='tic[]' maxlength='800' />
                                                        <input type='hidden' value='0' id='oculto_t0' /></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <input type="button" value="Añadir actividad" id="add_ExpenseRow_tic"/>
                                            <br/>
                                            <div class="div-btn-guardar" id="btnGuardarTIC" name="btnGuardarTIC" ><input type="button" value="Guardar" class="guardar" onclick="ensenanza('tic');"/><img align="right" class="less_pestana" onclick="oculta_vocacion('ensenanza');" src="images/less.png" /></div>
                                            <div class="div-btn-actualizar" id="btnActualizarTIC" name="btnActualizarTIC" style="display: none;" ><button id="btn-ActualizarTIC" class="actualizar" value="tic" />Actualizar</button><img align="right" class="less_pestana" onclick="oculta_vocacion('ensenanza');" src="images/less.png" /></div>
                                        </div>

                                        <!--Tabla Inovacion-->
                                        <div id="table_Innovar" style="display: none;">
                                            <table border="0" aling="left" class="" style="width:70%; margin: auto">
                                                <thead>
                                                <tr>
                                                    <td style="padding-left: 220px;">
                                                        <strong> Horas Invovación</strong><span style="color:#FF0000">*</span></strong>
                                                        <input type="text" style="text-align: center;" value="" size="5" id="HorasInnovar_" name="HorasInnovar_"  size="5" onchange="Suma('<?PHP echo $CodigoMateria ?>')" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><label>Nota: Recuerde que la dedicacion en horas semanales no puede exceder  a lo contratado por la Universidad</label></td>
                                                </tr>
                                                </thead>
                                            </table>
                                            <table id="expense_table_Innovar" cellspacing="0" cellpadding="0">
                                                <thead>
                                                <tr>
                                                    <th style="width:95%">Planeación de actividades a desarrollar</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><input class="actividad" type='text' id="t0" name='Innovar[]' maxlength='800' />
                                                        <input type='hidden' value='0' id='oculto_t0' /></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <input type="button" value="Añadir actividad" id="add_ExpenseRow_Innovar"/>
                                            <br/>
                                            <div class="div-btn-guardar" id="btnGuardarInnovar" name="btnGuardarInnovar" ><input type="button" value="Guardar" class="guardar" onclick="ensenanza('Innovar');"/><img align="right" class="less_pestana" onclick="oculta_vocacion('ensenanza');" src="images/less.png" /></div>
                                            <div class="div-btn-actualizar" id="btnActualizarInnovar" name="btnActualizarInnovar" style="display: none;" ><button id="btn-ActualizarInnovar" class="actualizar" value="Innovación" />Actualizar</button><img align="right" class="less_pestana" onclick="oculta_vocacion('ensenanza');" src="images/less.png" /></div>
                                        </div>
                                        <!--End tabla Innovacion-->
                                        <input id="oculto_ensenanza" value="0" type="hidden" />
                                        <input id="oculto_ensenanza_talleres" value="0" type="hidden" />
                                    </div>
                                </fieldset>
                        </form>
                        <form id="TabDos" name="TabDos">
                            <fieldset id="cuadro2">
                                <legend><?php echo ($arr_vocaciones[1]); ?></legend>
                                <div align="right" id="plus-descubrimiento"><img class="plus_pestana" src="images/plus.png" /></div>
                                <div id="descubrimiento" style="display: none;">
                                    <div id="dialog_descubrimiento" title="Ayuda Descubrimiento">
                                        <p><strong>Vocaci&oacute;n de descubrimiento</strong></p>

                                        <p>&middot;&nbsp; <strong>FORMATIVA</strong>: Horas destinadas a Investigaci&oacute;n formativa (direcci&oacute;n o asesor&iacute;a en trabajos de grado, jurados de tesis, etc.)</p>

                                        <p>&middot;&nbsp; <strong>INVESTIGACI&Oacute;N EN SENTIDO ESTRICTO</strong>: Horas destinadas a investigaci&oacute;n propiamente dicha en grupos de investigaci&oacute;n de la Universidad, &uacute;nicamente los investigadores inscritos en Cvlac de Colciencias y de acuerdo a la dedicaci&oacute;n registrada en ese sistema</p>
                                    </div>
                                    <div class="ayuda" id="ayuda_descubrimiento" align="right">Ayuda <img src="images/help.png" class="ayuda_ico" /></div>
                                    <div class="orientacion">
                                        <img src="images/orientacion-investigacion.png" />
                                        <p>La Vocaci&oacute;n del Descubrimiento se concentra en la generaci&oacute;n y desarrollo de conocimiento y la innovaci&oacute;n. Se orienta bien en la disciplina particular, en el quehacer de los procesos de ense&ntilde;anza aprendizaje o en los procesos de transferencia de conocimiento. Sustenta su car&aacute;cter Acad&eacute;mico en la reflexi&oacute;n permanente sobre la propia actividad investigativa y su impacto en los procesos formativos y sobre el entorno.</p>
                                    </div>
                                    <table class="noborder">
                                        <tr>
                                            <td>Nombre del proyecto</td>
                                            <td colspan="3"><input type="hidden" id="vocacion_descubrimiento" value="<?php echo $arr_vocaciones_id[1]; ?>" />
                                                <input type="text" id="nombre_descubrimiento" name="nombre_descubrimiento" maxlength="500" style="width:450px" /></td>
                                        </tr>
                                        <tr>
                                            <td>Modalidad</td>
                                            <td style="width:20px">
                                                <select id="tipo_descubrimiento" name="tipo_descubrimiento">
                                                    <?php
                                                    echo '<option value="0" selected="selected">Seleccione</option>';
                                                    $SQL = 'SELECT * FROM TiposPlanesTrabajoDocenteOtros WHERE VocacionesPlanesTrabajoDocenteId = 2';
                                                    if ($Tipo_2 = &$db->Execute($SQL) === false) {
                                                        echo 'Error en consulta a base de datos';
                                                        die;
                                                    } else {
                                                        if (!$Tipo_2->EOF) {
                                                            while (!$Tipo_2->EOF) {
                                                                echo '<option value="' . $Tipo_2->fields['TipoPlanTrabajoDocenteOtrosId'] . '">' . $Tipo_2->fields['Nombre'] . '</option>';
                                                                $Tipo_2->MoveNext();
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>Total horas semanales de dedicación</td>
                                            <td><input id="horas_descubrimiento" name="horas_descubrimiento" type="text" style="width:40px" /></td>
                                        </tr>
                                        <?php if ($docentesSobreSueldo == 1) { ?>
                                            <tr id="table_tipoHorasDescubrimiento" name="table_tipoHorasDescubrimiento">
                                                <td>Tipo Horas</td>
                                                <td><select id="cmbTipoHorasDescubrimiento" name="cmbTipoHorasDescubrimiento">
                                                        <option value="CONTRATO" selected="selected">CONTRATO</option>
                                                        <option value="SOBRESUELDO" >SOBRE SUELDO</option>
                                                    </select></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                    <div id="anteriores_descubrimiento" align="center" style="margin-bottom:20px">
                                        <h2>Cargar anteriores</h2>
                                    </div>
                                    <table id="expense_table_descubrimiento" cellspacing="0" cellpadding="0">
                                        <thead>
                                        <tr>
                                            <th style="width:95%">Planeación de actividades a desarrollar</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><input class="actividad" type='text' name='descubrimiento[]' maxlength='800' id='d0' />
                                                <input type='hidden' id='oculto_d0' value='0' /></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <input type="button" value="Añadir actividad" id="add_ExpenseRow_descubrimiento" />
                                    <br />
                                    <div class="div-btn-guardar"><input type="button" value="Guardar" onclick="guarda_descubrimiento();" class="guardar"/><img align="right" class="less_pestana" onclick="oculta_vocacion('descubrimiento');" src="images/less.png" /></div>
                                    <input id="oculto_descubrimiento" value="0" type="hidden" class="descubrimiento" />
                                </div>
                            </fieldset>
                        </form>
                        <form id="TabTres" name="TabTres">
                            <fieldset id="cuadro3">
                                <legend><?php echo ($arr_vocaciones[2]); ?></legend>
                                <div align="right" id="plus-compromiso"><img class="plus_pestana" src="images/plus.png" /></div>
                                <div id="compromiso" style="display: none;">
                                    <div id="dialog_compromiso" title="Ayuda Compromiso">
                                        <p><strong>Vocaci&oacute;n de Compromiso</strong></p>

                                        <p>&middot;&nbsp; <strong>PRACTICAS:</strong> Horas dedicadas a la supervisi&oacute;n, direcci&oacute;n o coordinaci&oacute;n de pr&aacute;cticas profesionales (cl&iacute;nicas, sociales, organizacionales, etc.)</p>

                                        <p>&middot;&nbsp; <strong>CONSULTORIA</strong>: Horas destinadas a la consultor&iacute;a</p>

                                        <p>&middot;&nbsp; <strong>CONTINUADA</strong>: Horas destinadas a las actividades de educaci&oacute;n continuada</p>

                                    </div>
                                    <div class="ayuda" id="ayuda_compromiso" align="right">Ayuda <img src="images/help.png" class="ayuda_ico" /></div>

                                    <div class="orientacion">
                                        <img src="images/orientacion-compromiso.png" />
                                        <p>La Vocaci&oacute;n del Compromiso comprende la aplicaci&oacute;n del conocimiento. Sin embargo va m&aacute;s all&aacute; de una aplicaci&oacute;n de conocimiento con un flujo unidireccional (Universidad-Sociedad). Tambi&eacute;n comprende el servicio, pero transforma el servicio comunitario en una actividad de construcci&oacute;n conjunta y no de &iacute;ndole asistencial. La Vocaci&oacute;n de Compromiso enfatiza la colaboraci&oacute;n genuina en que la ense&ntilde;anza y aprendizaje ocurren en la Universidad y en la Sociedad. El car&aacute;cter Acad&eacute;mico se sustenta en la reflexi&oacute;n sobre las relaciones con el estudiante, con la comunidad y sienta las bases para la Investigaci&oacute;n Centrada en la Comunidad propia del enfoque Biopsicosocial.</p>
                                    </div>
                                    <table class="noborder">
                                        <tr>
                                            <td>Nombre del proyecto</td>
                                            <td colspan="3"><input type="hidden" id="vocacion_compromiso" value="<?php echo $arr_vocaciones_id[2]; ?>" />
                                                <input type="text" id="nombre_compromiso" maxlength="500" style="width:450px" /></td>
                                        </tr>
                                        <tr>
                                            <td>Modalidad
                                            </td>
                                            <td style="width:20px">
                                                <select id="tipo_compromiso">
                                                    <?php
                                                    echo '<option value="0" selected="selected">Seleccione</option>';
                                                    $SQL = 'SELECT * FROM TiposPlanesTrabajoDocenteOtros WHERE VocacionesPlanesTrabajoDocenteId = 3';
                                                    if ($Tipo_3 = &$db->Execute($SQL) === false) {
                                                        echo 'Error en consulta a base de datos';
                                                        die;
                                                    } else {
                                                        if (!$Tipo_3->EOF) {
                                                            while (!$Tipo_3->EOF) {
                                                                echo '<option value="' . $Tipo_3->fields['TipoPlanTrabajoDocenteOtrosId'] . '">' . $Tipo_3->fields['Nombre'] . '</option>';
                                                                $Tipo_3->MoveNext();
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>Total horas semanales de dedicación</td>
                                            <td><input id="horas_compromiso" type="text" style="width:40px" /></td>
                                        </tr>
                                        <?php if ($docentesSobreSueldo == 1) { ?>
                                            <tr id="table_tipoHorasCompromiso" name="table_tipoHorasCompromiso">
                                                <td>Tipo Horas</td>
                                                <td><select id="cmbTipoHorasCompromiso" name="cmbTipoHorasCompromiso">
                                                        <option value="CONTRATO" selected="selected">CONTRATO</option>
                                                        <option value="SOBRESUELDO" >SOBRE SUELDO</option>
                                                    </select></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                    <div id="anteriores_compromiso" align="center" style="margin-bottom:20px">
                                        <h2>Cargar anteriores</h2>
                                    </div>
                                    <table id="expense_table_orientacion" cellspacing="0" cellpadding="0">
                                        <thead>
                                        <tr>
                                            <th style="width:95%">Planeación de actividades a desarrollar</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><input class="actividad" type='text' name='compromiso[]' maxlength='800' id="o0" />
                                                <input type='hidden' id='oculto_o0' value='0' /></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <input type="button" value="Añadir actividad" id="add_ExpenseRow_orientacion" />
                                    <br />
                                    <div class="div-btn-guardar"><input type="button" value="Guardar" class="guardar" onclick="guarda_compromiso();"/><img align="right" class="less_pestana" onclick="oculta_vocacion('compromiso');" src="images/less.png" /></div>
                                    <input id="oculto_compromiso" value="0" type="hidden" />
                                </div>
                            </fieldset>
                        </form>
                        <form id="TabCuatro" name="TabCuatro">
                            <fieldset id="cuadro4">
                                <legend><?php echo ($arr_vocaciones[3]); ?></legend>
                                <div align="right" id="plus-gestion"><img class="plus_pestana" src="images/plus.png" /></div>
                                <div id="gestion" style="display: none;">
                                    <div id="dialog_gestion" title="Ayuda Ense&ntildeanza y aprendizaje">
                                        <p><strong>GESTION ACAD&Eacute;MICO - ADMINISTRATIVA</strong>: Horas dedicadas a las actividades de gesti&oacute;n acad&eacute;mico-administrativa</p>

                                    </div>
                                    <div class="ayuda" id="ayuda_gestion" align="right">Ayuda <img src="images/help.png" class="ayuda_ico" /></div>

                                    <div class="orientacion">
                                        <img src="images/orientacion-admin.png" />
                                        <p>La Gesti&oacute;n acad&eacute;mico administrativa se orienta principalmente a la organizaci&oacute;n acad&eacute;mica, al desarrollo de procesos administrativos, a la gesti&oacute;n de recursos humanos y financieros y la mejora de la administraci&oacute;n de la informaci&oacute;n institucional</p>
                                    </div>
                                    <table class="noborder">
                                        <tr>
                                            <td>Nombre actividad</td>
                                            <td><input type="hidden" id="vocacion_gestion" value="<?php echo $arr_vocaciones_id[3]; ?>" />
                                                <input id="nombre_gestion" type="text" maxlength="500" style="width:450px" /></td>
                                        </tr>
                                        <?php if ($docentesSobreSueldo == 1) { ?>
                                            <tr id="table_tipoHorasGestion" name="table_tipoHorasGestion">
                                                <td>Tipo Horas</td>
                                                <td><select id="cmbTipoHorasGestion" name="cmbTipoHorasGestion">
                                                        <option value="CONTRATO" selected="selected">CONTRATO</option>
                                                        <option value="SOBRESUELDO" >SOBRE SUELDO</option>
                                                    </select></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td>Total horas semanales de dedicación</td>
                                            <td><input id="horas_gestion" type="text" style="width:40px" /></td>
                                        </tr>
                                    </table>
                                    <div id="anteriores_gestion" align="center" style="margin-bottom:20px">
                                        <h2>Cargar anteriores</h2>
                                    </div>
                                    <table id="expense_table_gestion" cellspacing="0" cellpadding="0">
                                        <thead>
                                        <tr>
                                            <th style="width:95%">Planeación de actividades a desarrollar</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><input class="actividad" type='text' name='gestion[]' maxlength='800' id='g0' />
                                                <input type='hidden' id='oculto_g0' value='0' /></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <input type="button" value="Añadir actividad" id="add_ExpenseRow_gestion" />
                                    <br />
                                    <div class="div-btn-guardar"><input type="button" value="Guardar" class="guardar" onclick="guarda_gestion();"/><img align="right" class="less_pestana" onclick="oculta_vocacion('gestion');" src="images/less.png" /></div>
                                </div>
                                <input id="oculto_gestion" value="0" type="hidden" />
                            </fieldset>
                        </form>
                    </div>
                    <div id="contenedorPortafolio" style="display: none;">
                        <div id="portafolioDefinicion">
                            <p><strong>Portafolio de seguimiento:</strong> Es una recopilación de evidencias, o conjunto de pruebas que demuestran que se ha cubierto satisfactoriamente una actividad, función o proyecto; es una información seleccionada sobre las actividades relacionadas en el plan de trabajo y una sólida evidencia de su efectividad.
                                El Portafolio de Seguimiento permite, organizadamente, registrar durante semestre, las evidencias que usted ha seleccionado como aquellas experiencias significativas de ejecución de sus actividades</p>
                        </div>
                        <div>
                            <span style="font-size: 14pt;"><a href="manual/ManualPortafolioSeguimiento.pdf" id="btnManualPortafolio"><strong>Manual de Usuario Portafolio de Seguimiento</strong></a></span>
                        </div>
                        <br />
                        <?php
                        $maximoPorcentaje = 100;
                        $sqlPortafolio = "SELECT DISTINCT
                                                    'Enseñanza y aprendizaje' AS vocaciones,
                                                    1 AS vocacionesid,
                                                    GROUP_CONCAT( DISTINCT c.codigocarrera SEPARATOR '|' ) AS Carrera_id,
                                                    GROUP_CONCAT( DISTINCT c.nombrecarrera SEPARATOR '|' ) AS programas
                                                    FROM PlanesTrabajoDocenteEnsenanza pl
                                                    INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                                    WHERE pl.iddocente = $id_Docente
                                                    AND pl.codigoperiodo = $Periodo
                                                    AND pl.codigoestado = 100
                                                    GROUP BY pl.iddocente
                                                    UNION ALL
                                                    SELECT DISTINCT
                                                    GROUP_CONCAT( DISTINCT v.Nombre ORDER BY v.Nombre SEPARATOR '|' ) AS vocaciones,
                                                    GROUP_CONCAT( v.VocacionesPlanesTrabajoDocenteId ORDER BY v.Nombre SEPARATOR '|' ) AS vocacionesid,
                                                    GROUP_CONCAT( DISTINCT c.codigocarrera SEPARATOR '|' ) AS Carrera_id,
                                                    GROUP_CONCAT( DISTINCT c.nombrecarrera SEPARATOR '|' ) AS programas
                                                    FROM PlanesTrabajoDocenteOtros pl
                                                    INNER JOIN VocacionPlanesTrabajoDocentes v ON v.VocacionesPlanesTrabajoDocenteId = pl.VocacionesPlanesTrabajoDocenteId
                                                    INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                                    WHERE pl.iddocente = $id_Docente
                                                    AND pl.codigoperiodo = $Periodo
                                                    AND pl.codigoestado = 100
                                                    GROUP BY pl.iddocente";

                        $portafoliosDocentes = $db->GetArray($sqlPortafolio);
                        $i = 1;
                        $contarMateria = 1;
                        $contarProyecto = 1;
                        $contarDescubrimiento = 1;
                        $contarCompromiso = 1;
                        $contarGestion = 1;
                        $contarBoton = 1;
                        foreach ($portafoliosDocentes as $portafolioDocente) {

                            $id_Vocaciones = explode("|", $portafolioDocente["vocacionesid"]);
                            $id_Vocaciones = array_merge(array_unique($id_Vocaciones));
                            $id_Vocaciones = orderMultiDimensionalArray($id_Vocaciones);


                            foreach ($id_Vocaciones as $id_Vocacion) {
                                if ($id_Vocacion == 1) {

                                    $sqlPortafolioEnsenanza = "SELECT DISTINCT
                                        'Enseñanza y aprendizaje' AS vocaciones,
                                        SUM( pl.HorasPresencialesPorSemana + pl.HorasPreparacion + pl.HorasEvaluacion + pl.HorasAsesoria + pl.HorasTIC + pl.HorasInnovar + pl.HorasTaller + pl.HorasPAE) AS totalHorasPEnsenanza,
                                        GROUP_CONCAT( DISTINCT c.codigocarrera SEPARATOR '|' ) AS Carrera_id
                                        FROM PlanesTrabajoDocenteEnsenanza pl
                                        INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                        WHERE pl.iddocente = $id_Docente
                                        AND pl.codigoperiodo = $Periodo
                                        AND pl.codigoestado = 100
                                        GROUP BY pl.iddocente";
                                    $portafoliosEnsenanzas = $db->GetArray($sqlPortafolioEnsenanza);

                                    foreach ($portafoliosEnsenanzas as $portafolioEnsenanza) {

                                        $programasId = explode("|", $portafolioEnsenanza["Carrera_id"]);
                                        $programasId = array_merge(array_unique($programasId));

                                        $totalHorasPEnsenanza = $portafolioEnsenanza["totalHorasPEnsenanza"];
                                        if ($totalHorasPEnsenanza != 0) {
                                            ?>

                                            <form id="formPortafolioEnsenanza" enctype="multipart/form-data">

                                                <table width="100%" border="0">
                                                    <tr>
                                                        <td>
                                                            <fieldset id="cuadro<?php echo $i++; ?>" style="border: 1px groove;" >
                                                                <legend><?php echo $portafolioEnsenanza["vocaciones"]; ?></legend>
                                                                <?php
                                                                foreach ($programasId as $programaId) {

                                                                    $sqlCarreraPortafolio = "SELECT DISTINCT GROUP_CONCAT( DISTINCT pl.PlanTrabajoDocenteEnsenanzaId SEPARATOR '|' ) AS id_TrabajosDocentes,
                                                                                iddocente,
                                                                                'ENSENANZA',
                                                                                SUM(
                                                                                    HorasPresencialesPorSemana + HorasPreparacion + HorasEvaluacion + HorasAsesoria + HorasTIC + HorasInnovar + HorasTaller + HorasPAE
                                                                                ) AS totalHoras,
                                                                                'Enseñanza y aprendizaje' AS vocaciones,
                                                                                1 AS vocacionesid,
                                                                                1 AS orden,
                                                                                GROUP_CONCAT( DISTINCT c.nombrecarrera SEPARATOR '|' ) AS programas,
                                                                                GROUP_CONCAT( M.nombremateria SEPARATOR '|' ) as materias,
                                                                                GROUP_CONCAT( M.codigomateria SEPARATOR '|' ) as Codigo_materias,
                                                                                GROUP_CONCAT( pl.TipoHoras SEPARATOR '|' ) as Tipo_Horas
                                                                                FROM PlanesTrabajoDocenteEnsenanza pl
                                                                                INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                                                                INNER JOIN materia M ON ( M.codigomateria = pl.codigomateria )
                                                                                WHERE pl.iddocente = $id_Docente
                                                                                AND pl.codigoperiodo = $Periodo
                                                                                AND c.codigocarrera = $programaId
                                                                                AND pl.codigoestado = 100
                                                                                GROUP BY pl.iddocente";
                                                                    $portafoliosEnsenanzasMaterias = $db->GetArray($sqlCarreraPortafolio);

                                                                    foreach ($portafoliosEnsenanzasMaterias as $portafolioEnsenanzaMateria) {

                                                                        $carrerasPortafolios = explode("|", $portafolioEnsenanzaMateria["programas"]);
                                                                        $carrerasPortafolios = array_merge($carrerasPortafolios);

                                                                        $id_Materias = explode("|", $portafolioEnsenanzaMateria["Codigo_materias"]);
                                                                        $id_Materias = array_merge(($id_Materias));

                                                                        $totalHorasMaterias = $portafolioEnsenanzaMateria["totalHoras"];

                                                                        $id_TrabajosDocentes = explode("|", $portafolioEnsenanzaMateria["id_TrabajosDocentes"]);
                                                                        $id_TrabajosDocentes = array_merge(array_unique($id_TrabajosDocentes));

                                                                        $tipoHorasE = explode("|", $portafolioEnsenanzaMateria["Tipo_Horas"]);


                                                                        foreach ($carrerasPortafolios as $carreraPortafolio) {

                                                                            $materiasPortafolios = explode("|", $portafolioEnsenanzaMateria["materias"]);
                                                                            $materiasPortafolios = array_merge(($materiasPortafolios));
                                                                        if ($totalHorasMaterias != 0 && $totalHorasMaterias != NULL) {
                                                                            ?>
                                                                        <br />
                                                                            <span style="color: #5169B1; font-weight: bold; font-size: 16pt;"><?php echo ucwords(strtolower_utf8($carreraPortafolio)) . "<br /><br />"; ?></span>



                                                                        <?php
                                                                        }
                                                                        $codigoMateria = 0;
                                                                        foreach ($materiasPortafolios as $materiaPortafolio) {
                                                                        $rutaCarpeta = "documentos/" . $id_Docente . "/" . $Periodo . "/" . $programaId . "/" . $id_Vocacion . "/" . $id_TrabajosDocentes[$codigoMateria] . "/";
                                                                        ?>
                                                                            <script type="text/javascript">

                                                                                $(document).ready(function () {

                                                                                    $('#txtIdSubirArchivoEnsenanza<?php echo $contarMateria; ?>').uploadifive({
                                                                                        'auto': false,
                                                                                        'fileTypeDesc': 'archivos',
                                                                                        'fileTypeExts': '*.jpg;*.jpeg;*.gif;*.png;*.xlsx;*.xls;*.docx;*.doc;*.ppt*;*.pptx;*.txt;*.pdf',
                                                                                        'multi': true,
                                                                                        'buttonText': 'Seleccionar',
                                                                                        'checkScript': 'tema/uploadify/check-exists.php',
                                                                                        'formData': {
                                                                                            'folder': 'documentos/' + $('#Docente_id').val() + '/' + $('#Periodo').val() + '/' + $('#txtIdCarrera<?php echo $contarMateria; ?>').val() + '/' + $('#txtIdVocacion').val() + '/' + $('#txtIdMateriaEnsenanza<?php echo $contarMateria; ?>').val( ),
                                                                                            'timestamp': '<?php echo $timestamp; ?>',
                                                                                            'token': '<?php echo md5('unique_salt' . $timestamp); ?>',

                                                                                        },
                                                                                        'queueID': 'listaArchivos<?php echo $contarMateria; ?>',
                                                                                        'uploadScript': 'tema/uploadify/uploadifive.php',
                                                                                        'cancelImg': 'tema/uploadify/imagenes/cancel.png',
                                                                                        'onUploadComplete': function (file, data) {
                                                                                            console.log(data);
                                                                                        }
                                                                                    });



                                                                                    $('#btnCarpeta<?php echo $contarMateria; ?>').click(function () {
                                                                                        var id_Docente = $('#Docente_id').val();
                                                                                        var idPeriodo = $('#Periodo').val();
                                                                                        var txtIdCarrera = $('#txtIdCarrera<?php echo $contarMateria; ?>').val();
                                                                                        var txtIdVocacion = $('#txtIdVocacion').val();
                                                                                        var txtIdMateria = $('#txtIdMateriaEnsenanza<?php echo $contarMateria; ?>').val( );
                                                                                        popup_carga('./verSoportePortafolio.php?id_Docente=' + id_Docente + '&idPeriodo=' + idPeriodo + '&txtIdCarrera=' + txtIdCarrera + '&txtIdVocacion=' + txtIdVocacion + '&txtIdMateria=' + txtIdMateria);
                                                                                        return false;
                                                                                    });

                                                                                });

                                                                            </script>
                                                                        <input type="hidden" id="txtIdVocacion" name="txtIdVocacion" value="<?php echo $id_Vocacion; ?>" />
                                                                        <input type="hidden" id="txtIdCarrera<?php echo $contarMateria; ?>" name="txtIdCarrera<?php echo $contarMateria; ?>" value="<?php echo $programaId; ?>" />
                                                                        <?php
                                                                        if ($id_Materias[$codigoMateria] != 1 && $totalHorasMaterias != 0) {
                                                                        ?>
                                                                            <div style="font-size: 14pt; border: 1px groove; border-radius:4px;">
                                                                                <table id="TablaPortafolioEnsenanza" width="90%" border="0" style="margin-left:5%; margin-top: 20px;" >
                                                                                    <tr>
                                                                                        <td ><?php
                                                                                            if ($docentesSobreSueldo == 1) {
                                                                                                echo titleCase(strtolower_utf8($materiaPortafolio)) . " - " . ucwords(strtolower($tipoHorasE[$codigoMateria]));
                                                                                            } else {
                                                                                                echo titleCase(strtolower_utf8($materiaPortafolio));
                                                                                            }
                                                                                            ?>
                                                                                            <input type="hidden" id="txtIdMateriaEnsenanza<?php echo $contarMateria; ?>" name="txtIdMateriaEnsenanza<?php echo $contarMateria; ?>" value="<?php echo $id_TrabajosDocentes[$codigoMateria]; ?>">
                                                                                        </td>
                                                                                        <td >
                                                                                            <div id="listaArchivos<?php echo $contarMateria; ?>" class="listaArchivo"></div>
                                                                                            <div style="color:#EEEEEE;" ><input type="file" id="txtIdSubirArchivoEnsenanza<?php echo $contarMateria; ?>" name="txtIdSubirArchivoEnsenanza<?php echo $contarMateria; ?>" multiple="multiple" ></div>
                                                                                            <a href="javascript:$('#txtIdSubirArchivoEnsenanza<?php echo $contarMateria; ?>').uploadifive('upload')" class="linkCancelar" style="color:#EEEEEE;" >Guardar Archivo</a>
                                                                                        </td>
                                                                                        <td ><span style="font-size: small;">Fecha:</span></td>
                                                                                        <td ><input type="text" style="text-align: center; font-family: Arial, Helvetica, sans-serif; font-size: small;" id="txtFechaDocenteEnsenanza" name="txtFechaDocenteEnsenanza<?php echo $contarMateria; ?>" size="10" value="<?php echo date('Y-m-d'); ?>" readonly /></td>
                                                                                        <?php if (file_exists($rutaCarpeta)) { ?>
                                                                                            <td><button id="btnCarpeta<?php echo $contarMateria; ?>" name="btnCarpeta<?php echo $contarMateria; ?>" class="btnCarpeta">Evidencias</button></td>
                                                                                        <?php } ?>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>

                                                                        <br />

                                                                            <?php
                                                                        } else {
                                                                            $sqlActividades = "SELECT SUM( HorasTIC + HorasInnovar + HorasTaller + HorasPAE ) AS totalHoras, HorasTIC , HorasInnovar, HorasTaller , HorasPAE, Tipo_Horas 
                                                                                                                FROM (SELECT
                                                                                                                        pl.PlanTrabajoDocenteEnsenanzaId as id,
                                                                                                                        pl.HorasTIC,
                                                                                                                        pl.HorasInnovar
                                                                                                                        pl.HorasTaller,
                                                                                                                        pl.HorasPAE,
                                                                                                                        GROUP_CONCAT(DISTINCT a.Nombre SEPARATOR '|') as actividad,
                                                                                                                        pl.TipoHoras as Tipo_Horas
                                                                                                                        FROM PlanesTrabajoDocenteEnsenanza pl
                                                                                                                        INNER JOIN materia M ON ( M.codigomateria = pl.codigomateria )
                                                                                                                LEFT JOIN ActividadesPlanesTrabajoDocenteEnsenanza a ON a.PlanTrabajoDocenteEnsenanzaId=pl.PlanTrabajoDocenteEnsenanzaId
                                                                                                                WHERE pl.codigoestado = 100  AND pl.iddocente = $id_Docente AND pl.codigoperiodo = $Periodo
                                                                                                                AND pl.codigocarrera = $programaId AND pl.PlanTrabajoDocenteEnsenanzaId = $id_TrabajosDocentes[$codigoMateria]
                                                                                                                AND pl.codigomateria = $id_Materias[$codigoMateria] AND (a.codigoestado=100 OR a.codigoestado IS NULL)
                                                                                                                GROUP BY pl.PlanTrabajoDocenteEnsenanzaId ) b";



                                                                            $actividadesEnsenanzas = $db->GetArray($sqlActividades);
                                                                        foreach ($actividadesEnsenanzas as $actividadesEnsenanza) {
                                                                            $totalHorasActividades = $actividadesEnsenanza["totalHoras"];

                                                                            $tipoHorasEO = $actividadesEnsenanza["Tipo_Horas"];
                                                                            $horasTICs = $actividadesEnsenanza["HorasTIC"];
                                                                            $horasInnovar = $actividadesEnsenanza["HorasInnovar"];
                                                                            $horasTalleres = $actividadesEnsenanza["HorasTaller"];
                                                                            $horasPAEs = $actividadesEnsenanza["HorasPAE"];

                                                                        if ($totalHorasActividades != 0 && $totalHorasActividades != NULL) {
                                                                            ?>
                                                                            <div style="font-size: 14pt; border: 1px groove; border-radius:4px;">
                                                                                <table id="TablaPortafolioEnsenanza" width="90%" border="0" style="margin-left:5%; margin-top: 20px;" >
                                                                                    <tr>
                                                                                        <td ><?php
                                                                                            if ($horasTICs != 0 && $horasTICs != NULL) {
                                                                                                if ($docentesSobreSueldo == 1) {
                                                                                                    echo "Horas TIC" . " - " . ucfirst(strtolower($tipoHorasEO)) . "<br/>";
                                                                                                } else {
                                                                                                    echo "Horas TIC" . "<br/>";
                                                                                                }
                                                                                            }
                                                                                            if ($horasInnovar != 0 && $horasInnovar != NULL) {
                                                                                                if ($docentesSobreSueldo == 1) {
                                                                                                    echo "Horas Innovación" . " - " . ucfirst(strtolower($tipoHorasEO)) . "<br/>";
                                                                                                } else {
                                                                                                    echo "Horas Innovación" . "<br/>";
                                                                                                }
                                                                                            }
                                                                                            if ($horasTalleres != 0 && $horasTalleres != NULL) {
                                                                                                if ($docentesSobreSueldo == 1) {
                                                                                                    echo "Horas Taller" . " - " . ucfirst(strtolower($tipoHorasEO)) . "<br/>";
                                                                                                } else {
                                                                                                    echo "Horas Taller" . "<br/>";
                                                                                                }
                                                                                            }
                                                                                            if ($horasPAEs != 0 && $horasPAEs != NULL) {
                                                                                                if ($docentesSobreSueldo == 1) {
                                                                                                    echo "Horas PAE" . " - " . ucfirst(strtolower($tipoHorasEO)) . "<br/>";
                                                                                                } else {
                                                                                                    echo "Horas PAE" . "<br/>";
                                                                                                }
                                                                                            }
                                                                                            ?>
                                                                                            <input type="hidden" id="txtIdMateriaEnsenanza<?php echo $contarMateria; ?>" name="txtIdMateriaEnsenanza<?php echo $contarMateria; ?>" value="<?php echo $id_TrabajosDocentes[$codigoMateria]; ?>">
                                                                                        </td>
                                                                                        <td >
                                                                                            <div id="listaArchivos<?php echo $contarMateria; ?>" class="listaArchivo"></div>
                                                                                            <div style="color:#EEEEEE;"><input type="file" id="txtIdSubirArchivoEnsenanza<?php echo $contarMateria; ?>" name="txtIdSubirArchivoEnsenanza<?php echo $contarMateria; ?>" multiple="multiple" ></div>
                                                                                            <a href="javascript:$('#txtIdSubirArchivoEnsenanza<?php echo $contarMateria; ?>').uploadifive('upload')" class="linkCancelar" style="color:#EEEEEE;" >Guardar Archivo</a>
                                                                                        </td>
                                                                                        <td><span style="font-size: small;">Fecha:</span></td>
                                                                                        <td><input type="text" style="text-align: center; font-family: Arial, Helvetica, sans-serif; font-size: small;" id="txtFechaDocenteEnsenanza" name="txtFechaDocenteEnsenanza<?php echo $contarMateria; ?>" size="10" value="<?php echo date('Y-m-d'); ?>" readonly /></td>
                                                                                        <?php if (file_exists($rutaCarpeta)) { ?>
                                                                                            <td><button id="btnCarpeta<?php echo $contarMateria; ?>" name="btnCarpeta<?php echo $contarMateria; ?>" class="btnCarpeta">Evidencias</button></td>
                                                                                        <?php } ?>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>

                                                                        <br />

                                                                            <?php
                                                                        }
                                                                        }
                                                                        }
                                                                            $codigoMateria = $codigoMateria + 1;
                                                                            $contarMateria = $contarMateria + 1;
                                                                        }
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </fieldset>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>

                                            <?php
                                        }
                                    }
                                } else {
                                    $sqlPortafolioOtros = "SELECT DISTINCT
                                                                                            GROUP_CONCAT( DISTINCT v.Nombre ORDER BY v.Nombre SEPARATOR '|' ) AS vocaciones,
                                                                                            GROUP_CONCAT( DISTINCT c.codigocarrera SEPARATOR '|' ) AS Carrera_id
											FROM PlanesTrabajoDocenteOtros pl
											INNER JOIN VocacionPlanesTrabajoDocentes v ON v.VocacionesPlanesTrabajoDocenteId = pl.VocacionesPlanesTrabajoDocenteId
											INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
											WHERE pl.iddocente = $id_Docente AND pl.codigoperiodo = $Periodo
											AND v.VocacionesPlanesTrabajoDocenteId = $id_Vocacion AND pl.codigoestado = 100
											GROUP BY pl.iddocente";
                                    $portafoliosOtros = $db->GetArray($sqlPortafolioOtros);

                                    foreach ($portafoliosOtros as $portafolioOtro) {

                                        $programasIdOtros = explode("|", $portafolioOtro["Carrera_id"]);
                                        $programasIdOtros = array_merge(array_unique($programasIdOtros));
                                        if ($id_Vocacion == 2) {
                                            ?>
                                            <form id="formPortafolioOtroDescubrimiento" enctype="multipart/form-data">
                                                <table width="100%" border="0">
                                                    <tr>
                                                        <td>
                                                            <fieldset id="cuadro<?php echo $i++; ?>" style="border: 1px groove;">
                                                                <legend><?php echo $portafolioOtro["vocaciones"]; ?></legend>

                                                                <?php
                                                                foreach ($programasIdOtros as $programaIdOtro) {

                                                                    $sqlCarreraOtroPortafolio = "SELECT DISTINCT
                                                                                        iddocente,
                                                                                        'OTROS',
                                                                                        SUM(HorasDedicadas) AS totalHoras,
                                                                                        GROUP_CONCAT( DISTINCT v.Nombre ORDER BY
                                                                                                        v.Nombre SEPARATOR '|' ) AS vocaciones,
                                                                                        GROUP_CONCAT( v.VocacionesPlanesTrabajoDocenteId ORDER BY v.Nombre SEPARATOR '|' ) AS vocacionesid,
                                                                                        2 AS orden,
                                                                                        GROUP_CONCAT( DISTINCT c.nombrecarrera SEPARATOR '|' ) AS programas,
                                                                                        GROUP_CONCAT( DISTINCT c.codigocarrera SEPARATOR '|' ) AS Carrera_id, 
                                                                                        GROUP_CONCAT( DISTINCT pl.Nombres SEPARATOR '|' ) AS proyectos,
                                                                                        GROUP_CONCAT( DISTINCT pl.PlanTrabajoDocenteOtrosId SEPARATOR '|' ) AS Codigo_proyectos
                                                                                        FROM PlanesTrabajoDocenteOtros pl
                                                                                        INNER JOIN VocacionPlanesTrabajoDocentes v ON v.VocacionesPlanesTrabajoDocenteId = pl.VocacionesPlanesTrabajoDocenteId
                                                                                        INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                                                                        WHERE pl.iddocente = $id_Docente AND pl.codigoperiodo = $Periodo
                                                                                        AND v.VocacionesPlanesTrabajoDocenteId = $id_Vocacion AND c.codigocarrera = $programaIdOtro
                                                                                        AND pl.codigoestado = 100 GROUP BY pl.iddocente";

                                                                    $portafoliosOtrosProyectos = $db->GetArray($sqlCarreraOtroPortafolio);

                                                                    foreach ($portafoliosOtrosProyectos as $portafolioOtroProyecto) {

                                                                        $carrerasOtrosPortafolios = explode("|", $portafolioOtroProyecto["programas"]);
                                                                        $carrerasOtrosPortafolios = array_merge(array_unique($carrerasOtrosPortafolios));

                                                                        $id_Proyectos = explode("|", $portafolioOtroProyecto["Codigo_proyectos"]);
                                                                        $id_Proyectos = array_merge(array_unique($id_Proyectos));

                                                                        foreach ($carrerasOtrosPortafolios as $carreraOtroPortafolio) {

                                                                            $proyectosOtrosPortafolios = explode("|", $portafolioOtroProyecto["proyectos"]);
                                                                            $proyectosOtrosPortafolios = array_merge(array_unique($proyectosOtrosPortafolios));
                                                                            ?>
                                                                            <span style="color: #5169B1; font-weight: bold; font-size: 16pt;"><?php echo ucwords(strtolower_utf8($carreraOtroPortafolio)) . "<br /><br />"; ?></span>

                                                                        <?php
                                                                        $codigoProyecto = 0;
                                                                        foreach ($proyectosOtrosPortafolios as $proyectoOtroPortafolio) {
                                                                        $rutaDescubrimiento = "documentos/" . $id_Docente . "/" . $Periodo . "/" . $programaIdOtro . "/" . $id_Vocacion . "/" . $id_Proyectos[$codigoProyecto];
                                                                        ?>
                                                                            <script type="text/javascript">
                                                                                $(document).ready(function () {

                                                                                    $('#txtIdSubirArchivoDescubrimiento<?php echo $contarDescubrimiento; ?>').uploadifive({
                                                                                        'auto': false,
                                                                                        'fileTypeDesc': 'archivos',
                                                                                        'fileTypeExts': '*.jpg;*.jpeg;*.gif;*.png;*.xlsx;*.xls;*.docx;*.doc;*.ppt*;*.pptx;*.txt;*.pdf',
                                                                                        'multi': true,
                                                                                        'buttonText': 'Seleccionar',
                                                                                        'checkScript': 'tema/uploadify/check-exists.php',
                                                                                        'formData': {
                                                                                            'folder': 'documentos/' + $('#Docente_id').val() + '/' + $('#Periodo').val() + '/' + $('#txtIdCarreraDescubrimiento<?php echo $contarDescubrimiento; ?>').val() + '/' + $('#txtIdVocacionDescubrimiento').val() + '/' + $('#txtIdProyectoDescubrimiento<?php echo $contarDescubrimiento; ?>').val( ),
                                                                                            'timestamp': '<?php echo $timestamp; ?>',
                                                                                            'token': '<?php echo md5('unique_salt' . $timestamp); ?>',

                                                                                        },
                                                                                        'queueID': 'listaArchivosDescubrimiento<?php echo $contarDescubrimiento; ?>',
                                                                                        'uploadScript': 'tema/uploadify/uploadifive.php',
                                                                                        'cancelImg': 'tema/uploadify/imagenes/cancel.png',
                                                                                        'onUploadComplete': function (file, data) {
                                                                                            console.log(data);
                                                                                        }
                                                                                    });

                                                                                    $('#btnCarpetaDescubrimiento<?php echo $contarDescubrimiento; ?>').click(function () {
                                                                                        var id_Docente = $('#Docente_id').val();
                                                                                        var idPeriodo = $('#Periodo').val();
                                                                                        var txtIdCarrera = $('#txtIdCarreraDescubrimiento<?php echo $contarDescubrimiento; ?>').val();
                                                                                        var txtIdVocacion = $('#txtIdVocacionDescubrimiento').val();
                                                                                        var txtIdMateria = $('#txtIdProyectoDescubrimiento<?php echo $contarDescubrimiento; ?>').val( );
                                                                                        popup_carga('./verSoportePortafolio.php?id_Docente=' + id_Docente + '&idPeriodo=' + idPeriodo + '&txtIdCarrera=' + txtIdCarrera + '&txtIdVocacion=' + txtIdVocacion + '&txtIdMateria=' + txtIdMateria);
                                                                                        return false;
                                                                                    });
                                                                                });
                                                                            </script>
                                                                        <input type="hidden" id="txtIdVocacionDescubrimiento" name="txtIdVocacionDescubrimiento" value="<?php echo $id_Vocacion; ?>">
                                                                        <input type="hidden" id="txtIdCarreraDescubrimiento<?php echo $contarDescubrimiento; ?>" name="txtIdCarreraDescubrimiento<?php echo $contarDescubrimiento; ?>" value="<?php echo $programaIdOtro; ?>" />

                                                                            <div style="font-size: 14pt; border: 1px groove; border-radius:4px;">
                                                                                <table id="TablaPortafolioOtrosDescubrimiento" width="90%" border="0" style="margin-left:5%; margin-top: 20px;" >
                                                                                    <tr>
                                                                                        <td ><?php echo ucfirst($proyectoOtroPortafolio); ?>
                                                                                            <input type="hidden" id="txtIdProyectoDescubrimiento<?php echo $contarDescubrimiento; ?>" name="txtIdProyectoDescubrimiento<?php echo $contarDescubrimiento; ?>" value="<?php echo $id_Proyectos[$codigoProyecto]; ?>">

                                                                                        </td>
                                                                                        <td >
                                                                                            <div id="listaArchivosDescubrimiento<?php echo $contarDescubrimiento; ?>" class="listaArchivo"></div>
                                                                                            <div style="color:#EEEEEE;"><input type="file" id="txtIdSubirArchivoDescubrimiento<?php echo $contarDescubrimiento; ?>" name="txtIdSubirArchivoDescubrimiento<?php echo $contarDescubrimiento; ?>" multiple="multiple" ></div>
                                                                                            <a href="javascript:$('#txtIdSubirArchivoDescubrimiento<?php echo $contarDescubrimiento; ?>').uploadifive('upload')" class="linkCancelar" style="color:#EEEEEE;" >Guardar Archivo</a>
                                                                                        </td>
                                                                                        <td><span style="font-size: small;">Fecha:</span></td>
                                                                                        <td><input type="text" style="text-align: center; font-family: Arial, Helvetica, sans-serif; font-size: small;" id="txtFechaDocenteDescubrimiento" name="txtFechaDocenteDescubrimiento<?php echo $contarDescubrimiento; ?>" size="10" value="<?php echo date('Y-m-d'); ?>" readonly /></td>
                                                                                        <?php if (file_exists($rutaDescubrimiento)) { ?>
                                                                                            <td><button id="btnCarpetaDescubrimiento<?php echo $contarDescubrimiento; ?>" name="btnCarpetaDescubrimiento<?php echo $contarDescubrimiento; ?>" class="btnCarpeta">Evidencias</button></td>
                                                                                        <?php } ?>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        <br />
                                                                            <?php
                                                                            $codigoProyecto = $codigoProyecto + 1;
                                                                            $contarDescubrimiento = $contarDescubrimiento + 1;
                                                                        }
                                                                        }
                                                                    }
                                                                }
                                                                ?>

                                                            </fieldset>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                            <?php
                                        }
                                        if ($id_Vocacion == 3) {
                                            ?>
                                            <form id="formPortafolioOtroCompromiso" enctype="multipart/form-data" >
                                                <table width="100%" border="0">
                                                    <tr>
                                                        <td>
                                                            <fieldset id="cuadro<?php echo $i++; ?>" style="border: 1px groove;">
                                                                <legend><?php echo $portafolioOtro["vocaciones"]; ?></legend>

                                                                <?php
                                                                foreach ($programasIdOtros as $programaIdOtro) {

                                                                    $sqlCarreraOtroPortafolio = "SELECT DISTINCT
                                                                                                        iddocente,
                                                                                                        'OTROS',
                                                                                                        SUM(HorasDedicadas) AS totalHoras,
                                                                                                        GROUP_CONCAT( DISTINCT v.Nombre ORDER BY v.Nombre SEPARATOR '|' ) AS vocaciones,
                                                                                                        GROUP_CONCAT( v.VocacionesPlanesTrabajoDocenteId ORDER BY v.Nombre SEPARATOR '|' ) AS vocacionesid,
                                                                                                        2 AS orden,
                                                                                                        GROUP_CONCAT( DISTINCT c.nombrecarrera SEPARATOR '|' ) AS programas,
                                                                                                        GROUP_CONCAT( DISTINCT c.codigocarrera SEPARATOR '|' ) AS Carrera_id, 
                                                                                                        GROUP_CONCAT( DISTINCT pl.Nombres SEPARATOR '|' ) AS proyectos,
                                                                                                        GROUP_CONCAT( DISTINCT pl.PlanTrabajoDocenteOtrosId SEPARATOR '|' ) AS Codigo_proyectos
													FROM PlanesTrabajoDocenteOtros pl
													INNER JOIN VocacionPlanesTrabajoDocentes v ON v.VocacionesPlanesTrabajoDocenteId = pl.VocacionesPlanesTrabajoDocenteId
													INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
													WHERE pl.iddocente = $id_Docente AND pl.codigoperiodo = $Periodo
													AND v.VocacionesPlanesTrabajoDocenteId = $id_Vocacion AND c.codigocarrera = $programaIdOtro
													AND pl.codigoestado = 100 GROUP BY pl.iddocente";

                                                                    $portafoliosOtrosProyectos = $db->GetArray($sqlCarreraOtroPortafolio);

                                                                    foreach ($portafoliosOtrosProyectos as $portafolioOtroProyecto) {

                                                                        $carrerasOtrosPortafolios = explode("|", $portafolioOtroProyecto["programas"]);
                                                                        $carrerasOtrosPortafolios = array_merge(array_unique($carrerasOtrosPortafolios));

                                                                        $id_Proyectos = explode("|", $portafolioOtroProyecto["Codigo_proyectos"]);
                                                                        $id_Proyectos = array_merge(array_unique($id_Proyectos));

                                                                        foreach ($carrerasOtrosPortafolios as $carreraOtroPortafolio) {

                                                                            $proyectosOtrosPortafolios = explode("|", $portafolioOtroProyecto["proyectos"]);
                                                                            $proyectosOtrosPortafolios = array_merge(array_unique($proyectosOtrosPortafolios));
                                                                            ?>
                                                                            <span style="color: #5169B1; font-weight: bold; font-size: 16pt;"><?php echo ucwords(strtolower_utf8($carreraOtroPortafolio)) . "<br /><br />"; ?></span>

                                                                        <?php
                                                                        $codigoProyecto = 0;
                                                                        foreach ($proyectosOtrosPortafolios as $proyectoOtroPortafolio) {
                                                                        $rutaCompromiso = "documentos/" . $id_Docente . "/" . $Periodo . "/" . $programaIdOtro . "/" . $id_Vocacion . "/" . $id_Proyectos[$codigoProyecto];
                                                                        ?>
                                                                            <script type="text/javascript">
                                                                                $(document).ready(function () {

                                                                                    $('#txtIdSubirArchivoCompromiso<?php echo $contarCompromiso; ?>').uploadifive({
                                                                                        'auto': false,
                                                                                        'fileTypeDesc': 'archivos',
                                                                                        'fileTypeExts': '*.jpg;*.jpeg;*.gif;*.png;*.xlsx;*.xls;*.docx;*.doc;*.ppt*;*.pptx;*.txt;*.pdf',
                                                                                        'multi': true,
                                                                                        'buttonText': 'Seleccionar',
                                                                                        'checkScript': 'tema/uploadify/check-exists.php',
                                                                                        'formData': {
                                                                                            'folder': 'documentos/' + $('#Docente_id').val() + '/' + $('#Periodo').val() + '/' + $('#txtIdCarreraCompromiso<?php echo $contarCompromiso; ?>').val() + '/' + $('#txtIdVocacionCompromiso').val() + '/' + $('#txtIdProyectoCompromiso<?php echo $contarCompromiso; ?>').val( ),
                                                                                            'timestamp': '<?php echo $timestamp; ?>',
                                                                                            'token': '<?php echo md5('unique_salt' . $timestamp); ?>',

                                                                                        },
                                                                                        'queueID': 'listaArchivosCompromiso<?php echo $contarCompromiso; ?>',
                                                                                        'uploadScript': 'tema/uploadify/uploadifive.php',
                                                                                        'cancelImg': 'tema/uploadify/imagenes/cancel.png',
                                                                                        'onUploadComplete': function (file, data) {
                                                                                            console.log(data);
                                                                                        }
                                                                                    });

                                                                                    $('#btnCarpetaCompromiso<?php echo $contarCompromiso; ?>').click(function () {
                                                                                        var id_Docente = $('#Docente_id').val();
                                                                                        var idPeriodo = $('#Periodo').val();
                                                                                        var txtIdCarrera = $('#txtIdCarreraCompromiso<?php echo $contarCompromiso; ?>').val();
                                                                                        var txtIdVocacion = $('#txtIdVocacionCompromiso').val();
                                                                                        var txtIdMateria = $('#txtIdProyectoCompromiso<?php echo $contarCompromiso; ?>').val( );
                                                                                        popup_carga('./verSoportePortafolio.php?id_Docente=' + id_Docente + '&idPeriodo=' + idPeriodo + '&txtIdCarrera=' + txtIdCarrera + '&txtIdVocacion=' + txtIdVocacion + '&txtIdMateria=' + txtIdMateria);
                                                                                        return false;
                                                                                    });
                                                                                });
                                                                            </script>
                                                                        <input type="hidden" id="txtIdVocacionCompromiso" name="txtIdVocacionCompromiso" value="<?php echo $id_Vocacion; ?>">
                                                                        <input type="hidden" id="txtIdCarreraCompromiso<?php echo $contarCompromiso; ?>" name="txtIdCarreraCompromiso<?php echo $contarCompromiso; ?>" value="<?php echo $programaIdOtro; ?>" />

                                                                            <div style="font-size: 14pt; border: 1px groove; border-radius:4px;">
                                                                                <table id="TablaPortafolioOtrosCompromiso" width="90%" border="0" style="margin-left:5%; margin-top: 20px;" >
                                                                                    <tr>
                                                                                        <td ><?php echo $proyectoOtroPortafolio; ?>
                                                                                            <input type="hidden" id="txtIdProyectoCompromiso<?php echo $contarCompromiso; ?>" name="txtIdProyectoCompromiso<?php echo $contarCompromiso; ?>" value="<?php echo $id_Proyectos[$codigoProyecto]; ?>">
                                                                                        </td>
                                                                                        <td >
                                                                                            <div id="listaArchivosCompromiso<?php echo $contarCompromiso; ?>" class="listaArchivo"></div>
                                                                                            <div style="color:#EEEEEE;"><input type="file" id="txtIdSubirArchivoCompromiso<?php echo $contarCompromiso; ?>" name="txtIdSubirArchivoCompromiso<?php echo $contarCompromiso; ?>" multiple="multiple" ></div>
                                                                                            <a href="javascript:$('#txtIdSubirArchivoCompromiso<?php echo $contarCompromiso; ?>').uploadifive('upload')" class="linkCancelar" style="color:#EEEEEE;" >Guardar Archivo</a>
                                                                                        </td>
                                                                                        <td><span style="font-size: small;">Fecha:</span></td>
                                                                                        <td><input type="text" style="text-align: center; font-family: Arial, Helvetica, sans-serif; font-size: small;" id="txtFechaDocenteCompromiso" name="txtFechaDocenteCompromiso<?php echo $contarCompromiso; ?>" size="10" value="<?php echo date('Y-m-d'); ?>" readonly /></td>
                                                                                        <?php if (file_exists($rutaCompromiso)) { ?>
                                                                                            <td><button id="btnCarpetaCompromiso<?php echo $contarCompromiso; ?>" name="btnCarpetaCompromiso<?php echo $contarCompromiso; ?>" class="btnCarpeta">Evidencias</button></td>
                                                                                        <?php } ?>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        <br />
                                                                            <?php
                                                                            $codigoProyecto = $codigoProyecto + 1;
                                                                            $contarCompromiso = $contarCompromiso + 1;
                                                                        }
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </fieldset>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                            <?php
                                        }
                                        if ($id_Vocacion == 4) {
                                            ?>
                                            <form id="formPortafolioOtroGestion" enctype="multipart/form-data" >
                                                <table width="100%" border="0">
                                                    <tr>
                                                        <td>
                                                            <fieldset id="cuadro<?php echo $i++; ?>" style="border: 1px groove;">
                                                                <legend><?php echo $portafolioOtro["vocaciones"]; ?></legend>

                                                                <?php
                                                                foreach ($programasIdOtros as $programaIdOtro) {

                                                                    $sqlCarreraOtroPortafolio = "SELECT DISTINCT
                                                        iddocente,
                                                        'OTROS',
                                                        SUM(HorasDedicadas) AS totalHoras,
                                                        GROUP_CONCAT( DISTINCT v.Nombre ORDER BY v.Nombre SEPARATOR '|' ) AS vocaciones,
                                                        GROUP_CONCAT( v.VocacionesPlanesTrabajoDocenteId ORDER BY v.Nombre SEPARATOR '|' ) AS vocacionesid,
                                                        2 AS orden,
                                                        GROUP_CONCAT( DISTINCT c.nombrecarrera SEPARATOR '|' ) AS programas,
                                                        GROUP_CONCAT( DISTINCT c.codigocarrera SEPARATOR '|' ) AS Carrera_id, 
                                                        GROUP_CONCAT( DISTINCT pl.Nombres SEPARATOR '|' ) AS proyectos,
                                                        GROUP_CONCAT( DISTINCT pl.PlanTrabajoDocenteOtrosId SEPARATOR '|' ) AS Codigo_proyectos
                                                        FROM PlanesTrabajoDocenteOtros pl
                                                        INNER JOIN VocacionPlanesTrabajoDocentes v ON v.VocacionesPlanesTrabajoDocenteId = pl.VocacionesPlanesTrabajoDocenteId
                                                        INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                                        WHERE pl.iddocente = $id_Docente
                                                        AND pl.codigoperiodo = $Periodo
                                                        AND v.VocacionesPlanesTrabajoDocenteId = $id_Vocacion
                                                        AND c.codigocarrera = $programaIdOtro
                                                        AND pl.codigoestado = 100
                                                        GROUP BY pl.iddocente";
                                                                    $portafoliosOtrosProyectos = $db->GetArray($sqlCarreraOtroPortafolio);

                                                                    foreach ($portafoliosOtrosProyectos as $portafolioOtroProyecto) {

                                                                        $carrerasOtrosPortafolios = explode("|", $portafolioOtroProyecto["programas"]);
                                                                        $carrerasOtrosPortafolios = array_merge(array_unique($carrerasOtrosPortafolios));

                                                                        $id_Proyectos = explode("|", $portafolioOtroProyecto["Codigo_proyectos"]);
                                                                        $id_Proyectos = array_merge(array_unique($id_Proyectos));

                                                                        foreach ($carrerasOtrosPortafolios as $carreraOtroPortafolio) {

                                                                            $proyectosOtrosPortafolios = explode("|", $portafolioOtroProyecto["proyectos"]);
                                                                            $proyectosOtrosPortafolios = array_merge(array_unique($proyectosOtrosPortafolios));
                                                                            ?>
                                                                            <span style="color: #5169B1; font-weight: bold; font-size: 16pt;"><?php echo ucwords(strtolower_utf8($carreraOtroPortafolio)) . "<br /><br />"; ?></span>

                                                                        <?php
                                                                        $codigoProyecto = 0;
                                                                        foreach ($proyectosOtrosPortafolios as $proyectoOtroPortafolio) {
                                                                        $rutaGestion = "documentos/" . $id_Docente . "/" . $Periodo . "/" . $programaIdOtro . "/" . $id_Vocacion . "/" . $id_Proyectos[$codigoProyecto];
                                                                        ?>
                                                                            <script type="text/javascript">
                                                                                $(document).ready(function () {

                                                                                    $('#txtIdSubirArchivoGestion<?php echo $contarGestion; ?>').uploadifive({
                                                                                        'auto': false,
                                                                                        'fileTypeDesc': 'archivos',
                                                                                        'fileTypeExts': '*.jpg;*.jpeg;*.gif;*.png;*.xlsx;*.xls;*.docx;*.doc;*.ppt*;*.pptx;*.txt;*.pdf',
                                                                                        'multi': true,
                                                                                        'buttonText': 'Seleccionar',
                                                                                        'checkScript': 'tema/uploadify/check-exists.php',
                                                                                        'formData': {
                                                                                            'folder': 'documentos/' + $('#Docente_id').val() + '/' + $('#Periodo').val() + '/' + $('#txtIdCarreraGestion<?php echo $contarGestion; ?>').val() + '/' + $('#txtIdVocacionGestion').val() + '/' + $('#txtIdProyectoGestion<?php echo $contarGestion; ?>').val( ),
                                                                                            'timestamp': '<?php echo $timestamp; ?>',
                                                                                            'token': '<?php echo md5('unique_salt' . $timestamp); ?>',

                                                                                        },
                                                                                        'queueID': 'listaArchivosGestion<?php echo $contarGestion; ?>',
                                                                                        'uploadScript': 'tema/uploadify/uploadifive.php',
                                                                                        'cancelImg': 'tema/uploadify/imagenes/cancel.png',
                                                                                        'onUploadComplete': function (file, data) {
                                                                                            console.log(data);
                                                                                        }
                                                                                    });
                                                                                    $('#btnCarpetaGestion<?php echo $contarGestion; ?>').click(function () {
                                                                                        var id_Docente = $('#Docente_id').val();
                                                                                        var idPeriodo = $('#Periodo').val();
                                                                                        var txtIdCarrera = $('#txtIdCarreraGestion<?php echo $contarGestion; ?>').val();
                                                                                        var txtIdVocacion = $('#txtIdVocacionGestion').val();
                                                                                        var txtIdMateria = $('#txtIdProyectoGestion<?php echo $contarGestion; ?>').val( );
                                                                                        popup_carga('./verSoportePortafolio.php?id_Docente=' + id_Docente + '&idPeriodo=' + idPeriodo + '&txtIdCarrera=' + txtIdCarrera + '&txtIdVocacion=' + txtIdVocacion + '&txtIdMateria=' + txtIdMateria);
                                                                                        return false;
                                                                                    });
                                                                                });
                                                                            </script>
                                                                        <input type="hidden" id="txtIdVocacionGestion" name="txtIdVocacionGestion" value="<?php echo $id_Vocacion; ?>">
                                                                        <input type="hidden" id="txtIdCarreraGestion<?php echo $contarGestion; ?>" name="txtIdCarreraGestion<?php echo $contarGestion; ?>" value="<?php echo $programaIdOtro; ?>" />

                                                                            <div style="font-size: 14pt; border: 1px groove; border-radius:4px;">
                                                                                <table id="TablaPortafolioOtrosGestion" width="90%" border="0" style="margin-left:5%; margin-top: 20px;" >
                                                                                    <tr>
                                                                                        <td ><?php echo ucfirst($proyectoOtroPortafolio); ?>
                                                                                            <input type="hidden" id="txtIdProyectoGestion<?php echo $contarGestion; ?>" name="txtIdProyectoGestion<?php echo $contarGestion; ?>" value="<?php echo $id_Proyectos[$codigoProyecto]; ?>">
                                                                                        </td>
                                                                                        <td >
                                                                                            <div id="listaArchivosGestion<?php echo $contarGestion; ?>" class="listaArchivo"></div>
                                                                                            <div style="color:#EEEEEE;"><input type="file" id="txtIdSubirArchivoGestion<?php echo $contarGestion; ?>" name="txtIdSubirArchivoGestion<?php echo $contarGestion; ?>" multiple="multiple" ></div>
                                                                                            <a href="javascript:$('#txtIdSubirArchivoGestion<?php echo $contarGestion; ?>').uploadifive('upload')" class="linkCancelar" style="color:#EEEEEE;" >Guardar Archivo</a>
                                                                                        </td>
                                                                                        <td><span style="font-size: small;">Fecha:</span></td>
                                                                                        <td><input type="text" style="text-align: center; font-family: Arial, Helvetica, sans-serif; font-size: small;" id="txtFechaDocenteGestion" name="txtFechaDocenteGestion<?php echo $contarGestion; ?>" size="10" value="<?php echo date('Y-m-d'); ?>" readonly /></td>
                                                                                        <?php if (file_exists($rutaGestion)) { ?>
                                                                                            <td><button id="btnCarpetaGestion<?php echo $contarGestion; ?>" name="btnCarpetaGestion<?php echo $contarGestion; ?>" class="btnCarpeta">Evidencias</button></td>
                                                                                        <?php } ?>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        <br />
                                                                            <?php
                                                                            $codigoProyecto = $codigoProyecto + 1;
                                                                            $contarGestion = $contarGestion + 1;
                                                                        }
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </fieldset>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                            <?php
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                    </div>
                    <div id="dialog_Portafolio" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                    </div>
                    <div id="contenedorAutoevaluacion" style="display: none;">
                        <div id="AutoevaluacionDefinicion">
                            <p><strong>Autoevaluación:</strong> Al cierre de este primer semestre académico, usted deberá consignar su autoevaluación referente al cumplimiento de las actividades registradas en su plan de trabajo,
                                así como las evidencias recopiladas a lo largo del semestre, las cuales son las que registro en el portafolio de seguimiento. La autoevaluación le permitirá a usted retroalimentarse a partir de los insumos propuestos, adquirir compromisos consigo mismo y frente a la comunidad académica, desde el desarrollo de competencias ,
                                asi como su desempeño en cada una de las orientaciones de la vocación académica ( enseñanza aprendizaje,  descubrimiento, compromiso e integración ).</p>
                        </div>
                        <div>
                            <span style="font-size: 14pt;"><a href="manual/ManualdeAutoevaluacion.pdf" id="btnManualPortafolio"><strong>Manual de Usuario Autoevaluación</strong></a></span>
                        </div>
                        <br />
                        <?php
                        $sqlAutoEvaluacionCarrera = "SELECT
                                                                GROUP_CONCAT( DISTINCT Carrera_id SEPARATOR '|' ) AS Carrera_id,
                                                                GROUP_CONCAT( DISTINCT programas SEPARATOR '|' ) AS programas
                                                                FROM
                                                                (
                                                                    SELECT DISTINCT
                                                                    'Enseñanza y aprendizaje' AS vocaciones,
                                                                    1 AS vocacionesid,
                                                                    GROUP_CONCAT( DISTINCT c.codigocarrera SEPARATOR '|' ) AS Carrera_id,
                                                                    GROUP_CONCAT( DISTINCT c.nombrecarrera SEPARATOR '|' ) AS programas,
                                                                    pl.iddocente
                                                                    FROM PlanesTrabajoDocenteEnsenanza pl
                                                                    INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                                                    WHERE pl.iddocente = $id_Docente AND pl.codigoperiodo = $Periodo
                                                                    AND pl.codigoestado = 100 GROUP BY pl.iddocente
                                                                    UNION ALL
                                                                    SELECT DISTINCT
                                                                    GROUP_CONCAT( DISTINCT v.Nombre ORDER BY v.Nombre SEPARATOR '|' ) AS vocaciones,
                                                                    GROUP_CONCAT( v.VocacionesPlanesTrabajoDocenteId ORDER BY v.Nombre SEPARATOR '|' ) AS vocacionesid,
                                                                    GROUP_CONCAT( DISTINCT c.codigocarrera SEPARATOR '|' ) AS Carrera_id,
                                                                    GROUP_CONCAT( DISTINCT c.nombrecarrera SEPARATOR '|' ) AS programas,
                                                                    pl.iddocente
                                                                    FROM PlanesTrabajoDocenteOtros pl
                                                                    INNER JOIN VocacionPlanesTrabajoDocentes v ON v.VocacionesPlanesTrabajoDocenteId = pl.VocacionesPlanesTrabajoDocenteId
                                                                    INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                                                    WHERE pl.iddocente = $id_Docente AND pl.codigoperiodo = $Periodo
                                                                    AND pl.codigoestado = 100 GROUP BY pl.iddocente
                                                                ) b
                                                                GROUP BY iddocente";

                        $autoevaluaciones = $db->Execute($sqlAutoEvaluacionCarrera);


                        $idProgramas = explode("|", $autoevaluaciones->fields["Carrera_id"]);
                        $idProgramas = array_merge(array_unique($idProgramas));


                        $nombresProgramas = explode("|", $autoevaluaciones->fields["programas"]);
                        $nombresProgramas = array_merge(array_unique($nombresProgramas));

                        $contarAutoEvaluacion = 1;
                        $contarProgramaAE = 0;

                        foreach ($idProgramas as $idPrograma) {

                            $sqlAutoEvaluacionVocacion = "SELECT
                                                                    GROUP_CONCAT( DISTINCT vocacionesid SEPARATOR '|' ) AS vocacionesid
                                                                    FROM (
                                                                            SELECT DISTINCT
                                                                            'Enseñanza y aprendizaje' AS vocaciones,
                                                                            1 AS vocacionesid,
                                                                            GROUP_CONCAT( DISTINCT c.codigocarrera SEPARATOR '|' ) AS Carrera_id,
                                                                            GROUP_CONCAT( DISTINCT c.nombrecarrera SEPARATOR '|' ) AS programas,
                                                                            pl.iddocente
                                                                            FROM PlanesTrabajoDocenteEnsenanza pl
                                                                            INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                                                            WHERE pl.iddocente = $id_Docente AND pl.codigoperiodo = $Periodo
                                                                            AND pl.codigoestado = 100 AND pl.codigocarrera = $idPrograma
                                                                            GROUP BY pl.iddocente
                                                                            UNION ALL
                                                                            SELECT DISTINCT
                                                                            GROUP_CONCAT( DISTINCT v.Nombre ORDER BY v.Nombre SEPARATOR '|' ) AS vocaciones,
                                                                            GROUP_CONCAT( v.VocacionesPlanesTrabajoDocenteId ORDER BY v.Nombre SEPARATOR '|' ) AS vocacionesid,
                                                                            GROUP_CONCAT( DISTINCT c.codigocarrera SEPARATOR '|' ) AS Carrera_id,
                                                                            GROUP_CONCAT( DISTINCT c.nombrecarrera SEPARATOR '|' ) AS programas,
                                                                            pl.iddocente
                                                                            FROM PlanesTrabajoDocenteOtros pl
                                                                            INNER JOIN VocacionPlanesTrabajoDocentes v ON v.VocacionesPlanesTrabajoDocenteId = pl.VocacionesPlanesTrabajoDocenteId
                                                                            INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                                                            WHERE pl.iddocente = $id_Docente AND pl.codigoperiodo = $Periodo
                                                                            AND pl.codigoestado = 100 AND pl.codigocarrera = $idPrograma
                                                                            GROUP BY pl.iddocente
                                                                        ) b
                                                                    GROUP BY iddocente";

                            $autoevaluacionesVocaciones = $db->Execute($sqlAutoEvaluacionVocacion);

                            $idVocaciones = explode("|", $autoevaluacionesVocaciones->fields["vocacionesid"]);
                            $idVocaciones = array_merge(array_unique($idVocaciones));
                            $idVocaciones = orderMultiDimensionalArray($idVocaciones);

                            if ($idPrograma != null) {
                                ?>

                                <fieldset id="cuadro<?php echo $contarAutoEvaluacion; ?>" style="border: 1px groove;">
                                    <legend ><font size="6,5"><?php echo ucwords(strtolower_utf8($nombresProgramas[$contarProgramaAE])); ?></font></legend>

                                    <?php
                                    $contarVocacionAE = 0;
                                    foreach ($idVocaciones as $idVocacion) {
                                        $sqlExisteAEv = "SELECT 
                            COUNT(DocenteId) AS existe 
                            FROM AutoevaluacionDocentes
                            WHERE DocenteId = $id_Docente
                            AND CodigoPeriodo = $Periodo
                            AND CodigoCarrera = $idPrograma
                            AND VocacionesId = $idVocacion
                            AND CodigoEstado = 100";

                                        $existeAEv = $db->Execute($sqlExisteAEv);

                                        $existeAEv = $existeAEv->fields["existe"];
                                        ?>
                                        <script type="text/javascript">
                                            $(document).ready(function () {
                                                <?php if ($existeAEv == 0) { ?>
                                                CKEDITOR.replace("txtAutoEvaluacion<?php echo $contarAutoEvaluacion; ?>", {
                                                    enterMode: CKEDITOR.ENTER_BR,
                                                    skin: 'office2013'
                                                });
                                                <?php } ?>



                                                $("#btnGuardaAEvaluacion<?php echo $contarAutoEvaluacion; ?>").click(function () {

                                                    var porcentaje = $("#cmbAutoEvaluacion<?php echo $contarAutoEvaluacion; ?>").val();


                                                    var tipoOperacion = "insertarAutoEvaluacion";

                                                    var autoEvaluacion = CKEDITOR.instances['txtAutoEvaluacion<?php echo $contarAutoEvaluacion; ?>'].getData();

                                                    var txtCarreraAE = $("#txtCarreraAE<?php echo $contarAutoEvaluacion; ?>").val();
                                                    var idVocacion = $("#txtIdVocacionAE<?php echo $contarAutoEvaluacion; ?>").val();
                                                    var id_Docente = $("#Docente_id").val();
                                                    var Periodo = $("#Periodo").val();
                                                    var txtNumeroDocumento = $("#NumDocumento").val();

                                                    if (porcentaje != "-1") {
                                                        $("#mensageAutoEvaluacion").dialog("option", "buttons", {
                                                            "Aceptar": function () {
                                                                $.ajax({
                                                                    url: "detalleAutoevaluacion.php",
                                                                    type: "POST",
                                                                    data: {tipoOperacion: tipoOperacion, autoEvaluacion: autoEvaluacion, porcentaje: porcentaje, txtCarreraAE: txtCarreraAE, idVocacion: idVocacion, id_Docente: id_Docente, Periodo: Periodo, txtNumeroDocumento: txtNumeroDocumento},
                                                                    success: function (data) {
                                                                        if (data != 0) {
                                                                            alert("La Autoevaluación ha sido guardada exitosamente");
                                                                            $("#btnGuardaAEvaluacion<?php echo $contarAutoEvaluacion; ?>").attr("disabled", true);
                                                                            $("#btnGuardaAEvaluacion<?php echo $contarAutoEvaluacion; ?>").css("display", "none");
                                                                            location.reload( );
                                                                        } else {
                                                                            alert("No se pudo guardar la Autoevaluación");
                                                                        }

                                                                    }
                                                                });
                                                            },
                                                            "Cancelar": function () {
                                                                $("#mensageAutoEvaluacion").dialog("close");
                                                            }
                                                        });
                                                        $("#mensageAutoEvaluacion").dialog("open");
                                                        return false
                                                    } else {
                                                        alert("Por favor seleccione el porcentaje de cumplimiento");
                                                    }
                                                    return false;
                                                });
                                            });
                                        </script>
                                        <style type="text/css">
                                            .btnGuardaAEvaluacion{
                                                -moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
                                                -webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
                                                box-shadow:inset 0px 1px 0px 0px #ffffff;
                                                background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #ffffff), color-stop(1, #f6f6f6));
                                                background:-moz-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
                                                background:-webkit-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
                                                background:-o-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
                                                background:-ms-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
                                                background:linear-gradient(to bottom, #ffffff 5%, #f6f6f6 100%);
                                                background-color:#ffffff;
                                                -moz-border-radius:6px;
                                                -webkit-border-radius:6px;
                                                border-radius:6px;
                                                border:1px solid #dcdcdc;
                                                display:inline-block;
                                                cursor:pointer;
                                                color:#666666;
                                                font-family:Arial;
                                                font-size:12px;
                                                font-weight:normal;
                                                padding:4px 22px;
                                                text-decoration:none;
                                                text-shadow:0px 1px 0px #ffffff;
                                            }
                                            .btnGuardaAEvaluacion:hover {
                                                background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #f6f6f6), color-stop(1, #ffffff));
                                                background:-moz-linear-gradient(top, #f6f6f6 5%, #ffffff 100%);
                                                background:-webkit-linear-gradient(top, #f6f6f6 5%, #ffffff 100%);
                                                background:-o-linear-gradient(top, #f6f6f6 5%, #ffffff 100%);
                                                background:-ms-linear-gradient(top, #f6f6f6 5%, #ffffff 100%);
                                                background:linear-gradient(to bottom, #f6f6f6 5%, #ffffff 100%);
                                                background-color:#f6f6f6;
                                            }
                                            .btnGuardaAEvaluacion:active {
                                                position:relative;
                                                top:1px;
                                            }

                                            #cke_txtAutoEvaluacion<?php echo $contarAutoEvaluacion; ?>{
                                                border-radius: 4px;
                                            }

                                        </style>
                                    <?php
                                    if ($idVocacion == 1) {
                                        $sqlActividadesE = "SELECT DISTINCT
                                    'Enseñanza y aprendizaje' AS vocacion,
                                    GROUP_CONCAT( DISTINCT m.nombremateria SEPARATOR '|' ) AS Nombres,
                                    GROUP_CONCAT( DISTINCT m.codigomateria SEPARATOR '|' ) AS idMaterias
                                    FROM PlanesTrabajoDocenteEnsenanza pl
                                    INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                    INNER JOIN materia m ON ( m.codigomateria = pl.codigomateria )
                                    WHERE pl.iddocente = $id_Docente AND pl.codigoperiodo = $Periodo
                                    AND pl.codigoestado = 100 AND pl.codigocarrera = $idPrograma
                                    GROUP BY pl.iddocente";

                                        $nombresProyectos = $db->Execute($sqlActividadesE);
                                        $nombreActividades = explode("|", $nombresProyectos->fields["Nombres"]);

                                        $idMaterias = explode("|", $nombresProyectos->fields["idMaterias"]);
                                        $idMaterias = array_merge(array_unique($idMaterias));
                                        foreach ($idMaterias as $idMateria) {
                                            if ($idMateria != 1) {
                                                $nombreActividades = explode("|", $nombresProyectos->fields["Nombres"]);
                                            } else {
                                                $sqlActividadesEOtros = "SELECT DISTINCT
                                                    GROUP_CONCAT( DISTINCT m.nombremateria SEPARATOR '|' ) AS Nombres,
                                                    pl.HorasTIC,
                                                    pl.HorasInnovar,
                                                    pl.HorasTaller,
                                                    pl.HorasPAE
                                                    FROM PlanesTrabajoDocenteEnsenanza pl
                                                    INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                                    INNER JOIN materia m ON ( m.codigomateria = pl.codigomateria )
                                                    WHERE pl.iddocente = $id_Docente AND pl.codigoperiodo = $Periodo
                                                    AND pl.codigoestado = 100 AND pl.codigocarrera = $idPrograma
                                                    AND pl.codigomateria = $idMateria GROUP BY pl.iddocente";


                                                $TipoHoraActividades = $db->Execute($sqlActividadesEOtros);
                                                $horasTIC = $TipoHoraActividades->fields["HorasTIC"];
                                                $horasInnovar = $TipoHoraActividades->fields["HorasInnovar"];
                                                $horasTaller = $TipoHoraActividades->fields["HorasTaller"];
                                                $horasPAE = $TipoHoraActividades->fields["HorasPAE"];
                                            }
                                        }
                                    } else {

                                        $sqlActividadesO = "SELECT DISTINCT
                                        v.Nombre AS vocacion,
                                        GROUP_CONCAT( DISTINCT pl.Nombres SEPARATOR '|' ) AS Nombres
                                        FROM PlanesTrabajoDocenteOtros pl
                                        INNER JOIN VocacionPlanesTrabajoDocentes v ON v.VocacionesPlanesTrabajoDocenteId = pl.VocacionesPlanesTrabajoDocenteId
                                        INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                        WHERE pl.iddocente = $id_Docente AND pl.codigoperiodo = $Periodo
                                        AND pl.codigoestado = 100 AND pl.codigocarrera = $idPrograma
                                        AND pl.VocacionesPlanesTrabajoDocenteId = $idVocacion GROUP BY pl.iddocente";

                                        $nombresProyectos = $db->Execute($sqlActividadesO);
                                        $nombreActividades = explode("|", $nombresProyectos->fields["Nombres"]);
                                    }
                                    ?>
                                        <span style="color: #5169B1; font-weight: bold; font-size: 16pt;"><?php echo $nombresProyectos->fields["vocacion"] . "<br /><br />"; ?></span>
                                        <span style="color: #5169B1; font-weight: bold; font-size: 12pt;">Actividades: </span><br />
                                    <?php
                                    foreach ($nombreActividades as $nombreActividad) {

                                        if (titleCase(strtolower_utf8($nombreActividad)) != "Manejo Del Sistema") {
                                            echo titleCase(strtolower_utf8($nombreActividad)) . "<br />";
                                        } else {
                                            if ($horasTIC != 0 && $horasTIC != null) {
                                                echo "Horas TIC" . "<br />";
                                            }
                                            if ($horasInnovar != 0 && $horasInnovar != null) {
                                                echo "Horas Innovación" . "<br />";
                                            }
                                            if ($horasTaller != 0 && $horasTaller != null) {
                                                echo "Horas Taller" . "<br />";
                                            }
                                            if ($horasPAE != 0 && $horasPAE != null) {
                                                echo "Horas PAE" . "<br />";
                                            }
                                        }
                                    }
                                    ?>
                                        <br />
                                        <input type="hidden" id="txtCarreraAE<?php echo $contarAutoEvaluacion; ?>" name="txtCarreraAE<?php echo $contarAutoEvaluacion; ?>" value="<?php echo $idPrograma; ?>" />
                                        <input type="hidden" id="txtIdVocacionAE<?php echo $contarAutoEvaluacion; ?>" name="txtIdVocacionAE<?php echo $contarAutoEvaluacion; ?>" value="<?php echo $idVocacion; ?>" />
                                    <?php if ($existeAEv == 0) { ?>
                                    <textarea cols="80" id="txtAutoEvaluacion<?php echo $contarAutoEvaluacion; ?>" name="txtAutoEvaluacion<?php echo $contarAutoEvaluacion; ?>" rows="10"  />
                                        </textarea>
                                    <br />
                                        <span><strong>Porcentaje de Cumplimiento&nbsp;&nbsp;&nbsp;</strong></span>
                                        <select id="cmbAutoEvaluacion<?php echo $contarAutoEvaluacion; ?>" name="cmbAutoEvaluacion<?php echo $contarAutoEvaluacion; ?>" style="width: 110px; font-size: small;">
                                            <option value="-1">Seleccione</option>
                                            <?php for ($k = 5; $k <= $maximoPorcentaje; $k += 5) { ?>
                                                <option value="<?php echo $k; ?>"><?php echo $k . "%"; ?> </option>
                                            <?php } ?>
                                        </select>
                                    <br />
                                        <div align="center">

                                            <button id="btnGuardaAEvaluacion<?php echo $contarAutoEvaluacion; ?>" name="btnGuardaAEvaluacion<?php echo $contarAutoEvaluacion; ?>" class="btnGuardaAEvaluacion">Guardar</button>

                                        </div>
                                    <?php } else { ?>
                                        <span style="color: #F5E506; font-weight: bold; font-size: 14pt;">Usted ya ha diligenciado la autoevaluación para este programa y esta vocación.</span>
                                    <?php } ?>
                                        <br />
                                        <hr />
                                        <br />
                                        <?php
                                        $contarAutoEvaluacion = $contarAutoEvaluacion + 1;
                                        $contarVocacionAE = $contarVocacionAE + 1;
                                    }
                                    ?>
                                </fieldset>
                                <br />
                                <?php
                                $contarProgramaAE = $contarProgramaAE + 1;
                            }
                        }
                        ?>
                    </div>
                    <br />
                    <div id="detalleAutoEvaluacion" style="font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif; font-size: 12px;">
                    </div>
                    <div id="mensageAutoEvaluacion" style="font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif; font-size: 12px;">
                        ¿ Desea agregar la Autoevaluación, por favor recuerde <br /> que una vez guardada la autoevaluación no podrá modificarla ?
                    </div>
                    <div id="contenedorPlanMejora" style="display: none;">
                        <div id="PlanMejoraDefinicion">
                            <p><strong>Plan Mejora:</strong> A partir de los resultados de la autoevaluación realizada y de la evaluación del decano se identificarán las oportunidades de consolidación y mejora.
                                Las oportunidades son situaciones o realidades sobre las cuales se puede tomar o no acción.
                                Al consolidar aquellos aspectos en los cuales se es fuerte (fortalezas), se pretende  identificar  las acciones, estrategias, objetivos o metas que permitirán asegurar la presencia de estos aspectos en el próximo periodo académico.
                                <br /><br />
                                Así mismo, al identificar las oportunidades de mejora, se buscará  superar las debilidades invitando a tomar las acciones, estrategias, objetivos o metas requeridos para abordarlos en el siguiente periodo académico.</p>
                        </div>
                        <br />
                        <div>
                            <span style="font-size: 14pt;"><a href="manual/ManualPlanMejora.pdf" id="btnManualPortafolio"><strong>Manual de Plan Mejora</strong></a></span>
                        </div>
                        <br />
                        <?php
                        $sqlPlanMejoraCarrera = "SELECT
                            GROUP_CONCAT( DISTINCT Carrera_id SEPARATOR '|' ) AS Carrera_id,
                            GROUP_CONCAT( DISTINCT programas SEPARATOR '|' ) AS programas
                            FROM (
                                SELECT DISTINCT
                                'Enseñanza y aprendizaje' AS vocaciones,
                                1 AS vocacionesid,
                                GROUP_CONCAT( DISTINCT c.codigocarrera SEPARATOR '|' ) AS Carrera_id,
                                GROUP_CONCAT( DISTINCT c.nombrecarrera SEPARATOR '|' ) AS programas,
                                pl.iddocente
                                FROM PlanesTrabajoDocenteEnsenanza pl
                                INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                WHERE pl.iddocente = $id_Docente AND pl.codigoperiodo = $Periodo
                                AND pl.codigoestado = 100 GROUP BY pl.iddocente
                                UNION ALL
                                SELECT DISTINCT
                                GROUP_CONCAT( DISTINCT v.Nombre ORDER BY v.Nombre SEPARATOR '|' ) AS vocaciones,
                                GROUP_CONCAT( v.VocacionesPlanesTrabajoDocenteId ORDER BY v.Nombre SEPARATOR '|' ) AS vocacionesid,
                                GROUP_CONCAT( DISTINCT c.codigocarrera SEPARATOR '|' ) AS Carrera_id,
                                GROUP_CONCAT( DISTINCT c.nombrecarrera SEPARATOR '|' ) AS programas,
                                pl.iddocente
                                FROM PlanesTrabajoDocenteOtros pl
                                INNER JOIN VocacionPlanesTrabajoDocentes v ON v.VocacionesPlanesTrabajoDocenteId = pl.VocacionesPlanesTrabajoDocenteId
                                INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                WHERE pl.iddocente = $id_Docente AND pl.codigoperiodo = $Periodo
                                AND pl.codigoestado = 100 GROUP BY pl.iddocente
                            ) b
                            GROUP BY iddocente";

                        $planesMejoras = $db->Execute($sqlPlanMejoraCarrera);


                        $idProgramas = explode("|", $planesMejoras->fields["Carrera_id"]);
                        $idProgramas = array_merge(array_unique($idProgramas));


                        $nombresProgramas = explode("|", $planesMejoras->fields["programas"]);
                        $nombresProgramas = array_merge(array_unique($nombresProgramas));

                        $contarPlanMejora = 1;
                        $contarProgramaPM = 0;

                        foreach ($idProgramas as $idPrograma) {

                            $sqlPlanMejoraVocacion = "SELECT
                                GROUP_CONCAT( DISTINCT vocacionesid SEPARATOR '|' ) AS vocacionesid
                                FROM (
                                        SELECT DISTINCT
                                        'Enseñanza y aprendizaje' AS vocaciones,
                                        1 AS vocacionesid,
                                        GROUP_CONCAT( DISTINCT c.codigocarrera SEPARATOR '|' ) AS Carrera_id,
                                        GROUP_CONCAT( DISTINCT c.nombrecarrera SEPARATOR '|' ) AS programas,
                                        pl.iddocente
                                        FROM PlanesTrabajoDocenteEnsenanza pl
                                        INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                        WHERE pl.iddocente = $id_Docente AND pl.codigoperiodo = $Periodo
                                        AND pl.codigoestado = 100 AND pl.codigocarrera = $idPrograma
                                        GROUP BY pl.iddocente
                                        UNION ALL
                                        SELECT DISTINCT
                                        GROUP_CONCAT( DISTINCT v.Nombre ORDER BY v.Nombre SEPARATOR '|' ) AS vocaciones,
                                        GROUP_CONCAT( v.VocacionesPlanesTrabajoDocenteId ORDER BY v.Nombre SEPARATOR '|' ) AS vocacionesid,
                                        GROUP_CONCAT( DISTINCT c.codigocarrera SEPARATOR '|' ) AS Carrera_id,
                                        GROUP_CONCAT( DISTINCT c.nombrecarrera SEPARATOR '|' ) AS programas,
                                        pl.iddocente
                                        FROM PlanesTrabajoDocenteOtros pl
                                        INNER JOIN VocacionPlanesTrabajoDocentes v ON v.VocacionesPlanesTrabajoDocenteId = pl.VocacionesPlanesTrabajoDocenteId
                                        INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                        WHERE pl.iddocente = $id_Docente AND pl.codigoperiodo = $Periodo
                                        AND pl.codigoestado = 100 AND pl.codigocarrera = $idPrograma
                                        GROUP BY pl.iddocente
                                    ) b
                                GROUP BY iddocente";
                            $planMejorasVocaciones = $db->Execute($sqlPlanMejoraVocacion);

                            $idVocaciones = explode("|", $planMejorasVocaciones->fields["vocacionesid"]);
                            $idVocaciones = array_merge(array_unique($idVocaciones));
                            $idVocaciones = orderMultiDimensionalArray($idVocaciones);

                            if ($idPrograma != null) {
                                ?>

                                <fieldset id="cuadro<?php echo $contarPlanMejora; ?>" style="border: 1px groove;">
                                    <legend ><font size="5,8"><?php echo ucwords(strtolower_utf8($nombresProgramas[$contarProgramaPM])); ?></font></legend>

                                    <?php
                                    $contarVocacionPM = 0;
                                    foreach ($idVocaciones as $idVocacion) {
                                        $sqlExistePME = "SELECT COUNT(DocenteId) AS existePMe 
                                                                FROM PlanMejoraDocentes
                                                                WHERE DocenteId = $id_Docente
                                                                AND CodigoPeriodo = $Periodo
                                                                AND CodigoCarrera = $idPrograma
                                                                AND VocacionesId = $idVocacion
                                                                AND CodigoEstado = 100";

                                        $existePME = $db->Execute($sqlExistePME);

                                        $existePME = $existePME->fields["existePMe"];
                                        ?>
                                        <script type="text/javascript">
                                            $(document).ready(function () {

                                                <?php if ($existePME == 0) { ?>

                                                CKEDITOR.replace("txtPlanMejora<?php echo $contarPlanMejora; ?>", {
                                                    enterMode: CKEDITOR.ENTER_BR,
                                                    skin: 'office2013'
                                                });

                                                CKEDITOR.replace("txtPlanMejoraConsolidacion<?php echo $contarPlanMejora; ?>", {
                                                    enterMode: CKEDITOR.ENTER_BR,
                                                    skin: 'office2013'
                                                });

                                                <?php } ?>

                                                $("#btnGuardaPlanMejora<?php echo $contarPlanMejora; ?>").click(function () {

                                                    var porcentaje = $("#cmbPlanMejora<?php echo $contarPlanMejora; ?>").val();


                                                    var tipoOperacion = "insertarPlanMejora";

                                                    var planMejora = CKEDITOR.instances['txtPlanMejora<?php echo $contarPlanMejora; ?>'].getData();
                                                    var planMejoraConsolidado = CKEDITOR.instances['txtPlanMejoraConsolidacion<?php echo $contarPlanMejora; ?>'].getData();

                                                    var txtCarreraPM = $("#txtCarreraPM<?php echo $contarPlanMejora; ?>").val();
                                                    var idVocacion = $("#txtIdVocacionPM<?php echo $contarPlanMejora; ?>").val();
                                                    var id_Docente = $("#Docente_id").val();
                                                    var Periodo = $("#Periodo").val();
                                                    var txtNumeroDocumento = $("#NumDocumento").val();

                                                    $("#mensagePlanMejora").dialog("option", "buttons", {
                                                        "Aceptar": function () {
                                                            $.ajax({
                                                                url: "detallePlanMejora.php",
                                                                type: "POST",
                                                                data: {tipoOperacion: tipoOperacion, planMejora: planMejora, planMejoraConsolidado: planMejoraConsolidado, txtCarreraPM: txtCarreraPM, idVocacion: idVocacion, id_Docente: id_Docente, Periodo: Periodo, txtNumeroDocumento: txtNumeroDocumento},
                                                                success: function (data) {
                                                                    if (data != 0) {
                                                                        alert("El Plan Mejora ha sido guardado exitosamente");
                                                                        $("#btnGuardaPlanMejora<?php echo $contarPlanMejora; ?>").attr("disabled", true);
                                                                        $("#btnGuardaPlanMejora<?php echo $contarPlanMejora; ?>").css("display", "none");
                                                                        location.reload( );
                                                                        //$( "#detalleAutoEvaluacion" ).html(data);
                                                                    } else {
                                                                        alert("No se pudo guardar el Plan de Mejora");
                                                                    }

                                                                }
                                                            });
                                                        },
                                                        "Cancelar": function () {
                                                            $("#mensagePlanMejora").dialog("close");
                                                        }
                                                    });
                                                    $("#mensagePlanMejora").dialog("open");
                                                    return false;
                                                });
                                            });
                                        </script>

                                    <?php
                                    if ($idVocacion == 1) {
                                        $sqlActividadesEPM = "SELECT DISTINCT
                                        'Enseñanza y aprendizaje' AS vocacion,
                                        GROUP_CONCAT( DISTINCT m.nombremateria SEPARATOR '|' ) AS Nombres,
                                        GROUP_CONCAT( DISTINCT m.codigomateria SEPARATOR '|' ) AS idMaterias
                                        FROM PlanesTrabajoDocenteEnsenanza pl
                                        INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                        INNER JOIN materia m ON ( m.codigomateria = pl.codigomateria )
                                        WHERE pl.iddocente = $id_Docente
                                        AND pl.codigoperiodo = $Periodo
                                        AND pl.codigoestado = 100
                                        AND pl.codigocarrera = $idPrograma
                                        GROUP BY pl.iddocente";


                                        $nombresProyectos = $db->Execute($sqlActividadesEPM);
                                        $nombreActividades = explode("|", $nombresProyectos->fields["Nombres"]);

                                        $idMaterias = explode("|", $nombresProyectos->fields["idMaterias"]);
                                        $idMaterias = array_merge(array_unique($idMaterias));
                                        foreach ($idMaterias as $idMateria) {
                                            if ($idMateria != 1) {
                                                $nombreActividades = explode("|", $nombresProyectos->fields["Nombres"]);
                                            } else {
                                                $sqlActividadesEPMOtros = "SELECT DISTINCT
                                                        GROUP_CONCAT( DISTINCT m.nombremateria SEPARATOR '|' ) AS Nombres,
                                                        pl.HorasTIC,
                                                        pl.HorasInnovar,
                                                        pl.HorasTaller,
                                                        pl.HorasPAE
                                                        FROM PlanesTrabajoDocenteEnsenanza pl
                                                        INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                                        INNER JOIN materia m ON ( m.codigomateria = pl.codigomateria )
                                                        WHERE pl.iddocente = $id_Docente AND pl.codigoperiodo = $Periodo
                                                        AND pl.codigoestado = 100 AND pl.codigocarrera = $idPrograma
                                                        AND pl.codigomateria = $idMateria GROUP BY pl.iddocente";


                                                $TipoHoraActividades = $db->Execute($sqlActividadesEPMOtros);
                                                $horasTIC = $TipoHoraActividades->fields["HorasTIC"];
                                                $horasInnovar = $TipoHoraActividades->fields["HorasInnovar"];
                                                $horasTaller = $TipoHoraActividades->fields["HorasTaller"];
                                                $horasPAE = $TipoHoraActividades->fields["HorasPAE"];
                                            }
                                        }
                                    } else {

                                        $sqlActividadesPMO = "SELECT DISTINCT
                                        v.Nombre AS vocacion,
                                        GROUP_CONCAT( DISTINCT pl.Nombres SEPARATOR '|' ) AS Nombres
                                        FROM PlanesTrabajoDocenteOtros pl
                                        INNER JOIN VocacionPlanesTrabajoDocentes v ON v.VocacionesPlanesTrabajoDocenteId = pl.VocacionesPlanesTrabajoDocenteId
                                        INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
                                        WHERE pl.iddocente = $id_Docente AND pl.codigoperiodo = $Periodo
                                        AND pl.codigoestado = 100 AND pl.codigocarrera = $idPrograma
                                        AND pl.VocacionesPlanesTrabajoDocenteId = $idVocacion
                                        GROUP BY pl.iddocente";

                                        $nombresProyectos = $db->Execute($sqlActividadesPMO);
                                        $nombreActividades = explode("|", $nombresProyectos->fields["Nombres"]);
                                    }
                                    ?>
                                        <span style="color: #5169B1; font-weight: bold; font-size: 16pt;"><?php echo $nombresProyectos->fields["vocacion"] . "<br /><br />"; ?></span>
                                        <span style="color: #5169B1; font-weight: bold; font-size: 12pt;">Actividades: </span><br />
                                    <?php
                                    foreach ($nombreActividades as $nombreActividad) {

                                        if (titleCase(strtolower_utf8($nombreActividad)) != "Manejo Del Sistema") {
                                            echo titleCase(strtolower_utf8($nombreActividad)) . "<br />";
                                        } else {
                                            if ($horasTIC != 0 && $horasTIC != null) {
                                                echo "Horas TIC" . "<br />";
                                            }
                                            if ($horasInnovar != 0 && $horasInnovar != null) {
                                                echo "Horas Innovación" . "<br />";
                                            }
                                            if ($horasTaller != 0 && $horasTaller != null) {
                                                echo "Horas Taller" . "<br />";
                                            }
                                            if ($horasPAE != 0 && $horasPAE != null) {
                                                echo "Horas PAE" . "<br />";
                                            }
                                        }
                                    }
                                    ?>
                                        <br />
                                        <input type="hidden" id="txtCarreraPM<?php echo $contarPlanMejora; ?>" name="txtCarreraPM<?php echo $contarPlanMejora; ?>" value="<?php echo $idPrograma; ?>" />
                                        <input type="hidden" id="txtIdVocacionPM<?php echo $contarPlanMejora; ?>" name="txtIdVocacionPM<?php echo $contarPlanMejora; ?>" value="<?php echo $idVocacion; ?>" />
                                        <span><strong>Oportunidades de Consolidación</strong></span>
                                        <br />
                                        <br />
                                    <?php if ($existePME == 0) { ?>
                                    <textarea cols="80" id="txtPlanMejoraConsolidacion<?php echo $contarPlanMejora; ?>" name="txtPlanMejoraConsolidacion<?php echo $contarPlanMejora; ?>" rows="10"  />
                                        </textarea>
                                    <br />
                                        <span><strong>Oportunidades de Mejora</strong></span>
                                    <br />
                                    <br />
                                    <textarea cols="80" id="txtPlanMejora<?php echo $contarPlanMejora; ?>" name="txtPlanMejora<?php echo $contarPlanMejora; ?>" rows="10"  />
                                        </textarea>
                                    <br />
                                        <div align="center">
                                            <button id="btnGuardaPlanMejora<?php echo $contarPlanMejora; ?>" name="btnGuardaPlanMejora<?php echo $contarPlanMejora; ?>" class="btnGuardaAEvaluacion">Guardar</button>
                                        </div>
                                    <?php } else { ?>
                                        <span style="color: #F5E506; font-weight: bold; font-size: 14pt;">Usted ya ha diligenciado el plan de mejora para este programa y esta vocación.</span>
                                    <?php } ?>
                                        <br />
                                        <hr />
                                        <br />
                                        <?php
                                        $contarPlanMejora = $contarPlanMejora + 1;
                                        $contarVocacionPM = $contarVocacionPM + 1;
                                    }
                                    ?>
                                </fieldset>
                                <br />
                                <?php
                                $contarProgramaPM = $contarProgramaPM + 1;
                            }
                        }
                        ?>
                    </div>
                    <div id="mensagePlanMejora" style="font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif; font-size: 12px;">
                        ¿ Desea agregar el Plan de Mejora, por favor recuerde <br /> que una vez guardado el plan de mejora no podrá modificarlo ?
                    </div>
                </div>
            </div>
            <!-- tercera pesta&ntilde;a -->
            <div id="tabs-3" class="tab">
                <div class="cajon">
                    <div id="reporteDedicacionAcademico" style="margin-top:15px;">
                        <h2><font color="white">Dedicaci&oacute;n del acad&eacute;mico por actividades</font></h2>
                        <br />
                        <?php if ($docentesSobreSueldo != 0) { ?>
                            <h2><font color="white">Contrato</font></h2>
                            <br />
                        <?php } ?>
                        <div id="tabla_resumen">
                            <span style="color: white;">Cargando informaci&oacute;n</span></div>
                        <ul>
                            <li><span style="color: yellow;">Nota: Recuerde que la dedicacion en horas semanales no puede exceder  a lo contratado por la Universidad</span></li>
                        </ul>
                        <?php if ($docentesSobreSueldo != 0) { ?>
                            <h2><font color="white">Sobresueldo</font></h2>
                            <br />
                            <div id="tabla_resumenSobresueldo">
                                <span style="color: white;">Cargando informaci&oacute;n</span></div>
                        <?php } ?>
                    </div>
                </div>
            </div><!--Div 3-->
            <div id="resumenHoras" style="background-color: black;">
                <div class="cajon">
                    <div id="reporteResumen" style="margin-top:15px;">
                        <h2><font color="white">Dedicaci&oacute;n del acad&eacute;mico por actividades</font></h2>
                        <br />
                        <h2><font color="white">Contrato</font></h2>
                        <br />

                        <div id="resultadoResumen">
                            <span style="color: white;">Cargando informaci&oacute;n</span></div>
                        <ul>
                            <li><span style="color: yellow;">Nota: Recuerde que la dedicacion en horas semanales no puede exceder  a lo contratado por la Universidad</span></li>
                        </ul>
                        <br />
                        <div id="resultadoResumenSS" style="display: none;">

                        </div>
                        <br />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>