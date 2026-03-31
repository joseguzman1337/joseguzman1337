<?php
    session_start();
    require_once(realpath(dirname(__FILE__) . "/../sala/includes/adaptador.php"));

$pos = strpos($Configuration->getEntorno(), "local");
    if ($Configuration->getEntorno() == "local" ||
        $Configuration->getEntorno() == "pruebas" ||
        $pos !== false) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        require_once (PATH_ROOT . '/kint/Kint.class.php');
    }

    if (isset($_GET['depurar']) && $_GET['depurar'] == 'si') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    unset($_SESSION['array_salon']);
    @$GLOBALS['nombreprograma'];
    $_SESSION['nombreprograma'] = "ingresopreinscripcion.php";

    unset($_SESSION['fppal']);

    if ($_SESSION['MM_Username'] == "estudiante") {
        $_SESSION['codigocarrerasesion'] = "";
    }

    $tipoUsuario = Factory::getSessionVar('codigotipousuario');

    require("../serviciosacademicos/funciones/funcionpassword.php");
    require_once("../serviciosacademicos/funciones/sala/inscripcion/inscripcion.php");
    require_once("../serviciosacademicos/funciones/sala/estudiante/estudiante.php");

    $numerodocumento = @$_REQUEST['documentoingreso'];
    $codigomodalidadacademica = @$_REQUEST['modalidad'];

    if(isset($_REQUEST['codigocarrera']) && !empty($_REQUEST['codigocarrera'])){
        $codigocarreraOrigen = $_REQUEST['codigocarrera'];
    }else{
        $codigocarreraOrigen = null;
    }

    if(isset($_SESSION['modalidadacademicasesion'])){
        $codigomodalidadacademicasesion = $_SESSION['modalidadacademicasesion'];
    }
    $idestudiantegeneral = tomarIdestudiantegeneral($numerodocumento);
    $estudiantegeneral = new estudiantegeneral($idestudiantegeneral);

    if (isset($_SESSION['usuario'])) {
        $user = $_SESSION['usuario'];
        $SQL_usuario = "SELECT idusuario FROM usuario WHERE usuario = " . $db->qstr($user) . " ";
        $identificadorUsuario = $db->GetRow($SQL_usuario);
        $_SESSION['idReferente'] = $identificadorUsuario['idusuario'];
    }

?>
<html>
    <head>
        <title>Documento sin t&iacute;tulo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <?php
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/bootstrap.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT ."/assets/css/bootstrap.min.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-awesome.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/custom.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/general.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/loader.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT ."/sala/assets/css/CenterRadarIndicator/centerIndicator.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT ."/assets/css/sweetalert.css");

        echo Factory::printImportJsCss("js", HTTP_ROOT ."/assets/js/sweetalert.min.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/jquery-3.1.1.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/spiceLoading/pace.min.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/bootstrap.min.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/bootstrap.js");
        ?>

        <link rel="stylesheet" type="text/css" href="css/ajax-tooltip.css">
        <script type="text/javascript" src="../assets/js/bootbox.min.js"></script>
        <script type="text/javascript" src="../assets/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="js/convenioinscripcion.js"></script>
        <script type="text/javascript" src="js/ajax.js"></script>
        <script type="text/javascript" src="js/ajax-tooltip.js"></script>
        <script type="text/javascript" src="js/ajax-dynamic-content.js"></script>
        <style type="text/css">
            .link-semaforo{
                color: black !important;
                font-size: small;
            }
        </style>
        <script type="text/javascript" src="../serviciosacademicos/AgendadeEntrevistas/js/main.js"></script>
        <script type="text/javascript" src="js/lineacentral.js"></script>
    </head>
    <body>
        <?php if(isset($_SESSION['inscripcionactiva']) && isset($_SESSION['MM_Username'])
        && ($_SESSION['MM_Username'] == 'estudiante')){ ?>
        <nav class="navbar">
            <a href="http://www.uelbosque.edu.co" title="Inicio" rel="home">
                <img src="<?php echo HTTP_ROOT?>/aspirantes/admisiones/logo-uelbosque.png" width="180" alt="Inicio">
            </a>
        </nav>
        <?php } ?>
        <div class="container">
            <div id="divglobo" style="position:absolute; width:5px; height:5px; z-index:1; left: 330px; top: 80px;">
            </div>
            <?php
            //si existe una carrera en post o get
            if (empty($codigocarreraOrigen)) {
                //consulta para obtener los datos personales del usuario
                $query_data = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,".
                " m.codigomodalidadacademica, i.idinscripcion, s.nombresituacioncarreraestudiante, ".
                " i.numeroinscripcion,i.codigosituacioncarreraestudiante, ec.codigosituacioncarreraestudiante as ".
                " estudiantecodigosituacioncarrera, i.codigoperiodo, c.codigoindicadorcobroinscripcioncarrera, ".
                " c.codigoindicadorprocesoadmisioncarrera, ec.codigocarrera, ".
                " ec.codigoestudiante, t.nombretrato,e.idestudiantecarrerainscripcion ".
                " FROM estudiantegeneral eg ".
                 " inner join inscripcion i on eg.idestudiantegeneral = i.idestudiantegeneral ".
                 " inner join estudiantecarrerainscripcion e on eg.idestudiantegeneral = e.idestudiantegeneral ".
                 " inner join carrera c on e.codigocarrera = c.codigocarrera AND i.idinscripcion = e.idinscripcion ".
                 " inner join modalidadacademica m on i.codigomodalidadacademica = m.codigomodalidadacademica ".
                 " inner join ciudad ci on eg.idciudadnacimiento = ci.idciudad ".
                 " inner join situacioncarreraestudiante s on i.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante ".
                 " inner join estudiante ec on c.codigocarrera = ec.codigocarrera and ec.idestudiantegeneral = eg.idestudiantegeneral ".
                 " inner join trato t on eg.idtrato = t.idtrato ".
                 " inner join periodo p on ec.codigoperiodo = p.codigoperiodo and i.codigoperiodo = p.codigoperiodo ".
                " WHERE ec.codigoestudiante in ( SELECT est.codigoestudiante  FROM estudiante est ".
                " INNER JOIN estudiantegeneral ege on  est.idestudiantegeneral = ege.idestudiantegeneral ".
                " WHERE ege.numerodocumento = " . $db->qstr($numerodocumento) . " ) ".
                " AND i.codigoestado = 100 and e.codigoestado = i.codigoestado AND e.idnumeroopcion = '1' ".
                " and (p.codigoestadoperiodo = 1 or p.codigoestadoperiodo = 4) order by i.codigoperiodo desc ";
            } else {
                $queryPeriodo = "SELECT max( i.codigoperiodo ) codigoperiodo FROM inscripcion i".
                " INNER JOIN estudiantecarrerainscripcion  eci ON ( i.idinscripcion = eci.idinscripcion ) ".
                " INNER JOIN estudiantegeneral eg ON ( eci.idestudiantegeneral = eg.idestudiantegeneral ) ".
                " WHERE eci.codigocarrera = " . $db->qstr($codigocarreraOrigen) . " ".
                " AND eg.numerodocumento = " . $db->qstr($numerodocumento) . " ".
                " AND i.codigoestado = 100";
                $periodo = $db->GetRow($queryPeriodo);
                $periodo = $periodo['codigoperiodo'];

                $query_data = "SELECT EG.*, C.nombrecarrera, MA.nombremodalidadacademica, CIU.nombreciudad, ".
                " MA.codigomodalidadacademica, I.idinscripcion, SCE.nombresituacioncarreraestudiante, I.numeroinscripcion, ".
                " I.codigosituacioncarreraestudiante, E.codigosituacioncarreraestudiante as estudiantecodigosituacioncarrera, ".
                " I.codigoperiodo, C.codigoindicadorcobroinscripcioncarrera, C.codigoindicadorprocesoadmisioncarrera, ".
                " E.codigocarrera, E.codigoestudiante, T.nombretrato, ECI.idestudiantecarrerainscripcion ".
                " FROM estudiante E ".
                " INNER JOIN estudiantegeneral EG ON ( E.idestudiantegeneral = EG.idestudiantegeneral ) ".
                " INNER JOIN trato T ON ( EG.idtrato = T.idtrato ) ".
                " INNER JOIN ciudad CIU ON ( EG.idciudadnacimiento = CIU.idciudad ) ".
                " INNER JOIN periodo P ON ( E.codigoperiodo = P.codigoperiodo ) ".
                " INNER JOIN carrera C ON ( E.codigocarrera = C.codigocarrera ) ".
                " INNER JOIN situacioncarreraestudiante SCE ON ( E.codigosituacioncarreraestudiante = SCE.codigosituacioncarreraestudiante ) ".
                " INNER JOIN modalidadacademica MA ON ( C.codigomodalidadacademica = MA.codigomodalidadacademica ) ".
                " INNER JOIN estudiantecarrerainscripcion ECI ON ( C.codigocarrera = ECI.codigocarrera AND EG.idestudiantegeneral = ECI.idestudiantegeneral ) ".
                " INNER JOIN inscripcion I ON ( ECI.idinscripcion = I.idinscripcion AND P.codigoperiodo = I.codigoperiodo ) ".
                " WHERE EG.numerodocumento = " . $db->qstr($numerodocumento) ." ".
                " AND E.codigoperiodo = " .$db->qstr($periodo). " AND I.codigoestado = 100 ".
                " AND ECI.codigoestado = 100 AND E.codigosituacioncarreraestudiante = I.codigosituacioncarreraestudiante ".
                " AND ( P.codigoestadoperiodo = 1 OR P.codigoestadoperiodo = 4 ) AND ECI.idnumeroopcion = 1 ".
                " AND I.codigoperiodo = " . $db->qstr($periodo) ." ".
                " AND C.codigocarrera = " . $db->qstr($codigocarreraOrigen) . " ";

                $queryCarrerasInscritasPeriodo = "select distinct i.idestudiantegeneral,i.codigoperiodo, e.codigocarrera ".
                " from estudiantegeneral eg ".
                " inner join estudiantedocumento ed on eg.idestudiantegeneral = ed.idestudiantegeneral ".
                " inner join inscripcion i on eg.idestudiantegeneral = i.idestudiantegeneral ".
                " inner join estudiantecarrerainscripcion e on i.idestudiantegeneral = e.idestudiantegeneral ".
                " where eg.numerodocumento = '".$numerodocumento."' ".
                " and ed.fechavencimientoestudiantedocumento >= now() ".
                " and i.codigoperiodo = '".$periodo."' and e.idnumeroopcion = 1";
                $dataCarrerasInscritas = $db->Execute($queryCarrerasInscritasPeriodo);
                $totalRowsCarrerasInscritas = $dataCarrerasInscritas->RecordCount();

                $andCarreraInscrita = "";
                if($totalRowsCarrerasInscritas > 1){
                    $andCarreraInscrita = " AND C.codigocarrera = ".$_GET['codigocarrera']."";
                }

                $query_dataAuxiliar = "SELECT EG.*, C.nombrecarrera, MA.nombremodalidadacademica, CIU.nombreciudad, ".
                " MA.codigomodalidadacademica,  I.idinscripcion, SCE.nombresituacioncarreraestudiante, ".
                " I.numeroinscripcion, I.codigosituacioncarreraestudiante, E.codigosituacioncarreraestudiante as ".
                " estudiantecodigosituacioncarrera, I.codigoperiodo, C.codigoindicadorcobroinscripcioncarrera, ".
                " C.codigoindicadorprocesoadmisioncarrera, E.codigocarrera, E.codigoestudiante, T.nombretrato, ".
                " ECI.idestudiantecarrerainscripcion ".
                " FROM estudiante E ".
                " INNER JOIN estudiantegeneral EG ON ( E.idestudiantegeneral = EG.idestudiantegeneral ) ".
                " INNER JOIN trato T ON ( EG.idtrato = T.idtrato ) ".
                " INNER JOIN ciudad CIU ON ( EG.idciudadnacimiento = CIU.idciudad ) ".
                " INNER JOIN periodo P ON ( E.codigoperiodo = P.codigoperiodo ) ".
                " INNER JOIN carrera C ON ( E.codigocarrera = C.codigocarrera ) ".
                " INNER JOIN situacioncarreraestudiante SCE ON ( E.codigosituacioncarreraestudiante = ".
                " SCE.codigosituacioncarreraestudiante ) ".
                " INNER JOIN modalidadacademica MA ON ( C.codigomodalidadacademica = MA.codigomodalidadacademica ) ".
                " INNER JOIN estudiantecarrerainscripcion ECI ON ( C.codigocarrera = ECI.codigocarrera ".
                " AND EG.idestudiantegeneral = ECI.idestudiantegeneral ) ".
                " INNER JOIN inscripcion I ON ( ECI.idinscripcion = I.idinscripcion AND P.codigoperiodo = I.codigoperiodo ) ".
                " WHERE EG.numerodocumento = " . $db->qstr($numerodocumento) ." ".
                " AND I.codigoestado = 100 AND ECI.codigoestado = 100 ".
                " AND ( P.codigoestadoperiodo = 1 OR P.codigoestadoperiodo = 4 ) AND ECI.idnumeroopcion = 1 ". $andCarreraInscrita;
            }

            $data = $db->Execute($query_data);
            $totalRows_data = $data->RecordCount();

            if($totalRows_data > 0){
                $row_data = $data->FetchRow();
                $idestudiantegeneral = $row_data['idestudiantegeneral'];
                $idEstudianteCarreraInscripcion = $row_data['idestudiantecarrerainscripcion'];
            }else{
                $data = $db->Execute($query_dataAuxiliar);
                $totalRows_data = $data->RecordCount();
                $row_data = $data->FetchRow();
                $idestudiantegeneral = $row_data['idestudiantegeneral'];
                $idEstudianteCarreraInscripcion = $row_data['idestudiantecarrerainscripcion'];
            }

            $query_selcarreras = "SELECT eg.idestudiantegeneral, i.codigoperiodo, ca.nombrecarrera, ca.codigocarrera, ".
                " s.nombresituacioncarreraestudiante, ca.codigomodalidadacademica, p.codigoestadoperiodo, ca.codigofacultad, ".
                " e.codigoestudiante FROM  estudiantegeneral eg ".
                " INNER JOIN estudiante e ON ( eg.idestudiantegeneral = e.idestudiantegeneral ) ".
                " INNER JOIN carrera ca ON ( e.codigocarrera = ca.CodigoCarrera ) ".
                " INNER JOIN inscripcion i ON ( eg.idestudiantegeneral = i.idestudiantegeneral ) ".
                " INNER JOIN estudiantecarrerainscripcion ec ON ( i.idinscripcion = ec.idinscripcion ".
                " AND eg.idestudiantegeneral = ec.idestudiantegeneral and ec.codigocarrera=ca.CodigoCarrera ) ".
                " INNER JOIN situacioncarreraestudiante s ON ( i.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante ) ".
                " INNER JOIN periodo p ON ( i.codigoperiodo = p.codigoperiodo AND e.codigoperiodo = p.codigoperiodo ) ".
                " WHERE eg.numerodocumento = " . $db->qstr($numerodocumento) . " ".
                " AND i.codigoestado = 100 AND ec.codigoestado = 100 ".
                " AND ( p.codigoestadoperiodo = 1 OR p.codigoestadoperiodo = 4 ) ".
                " AND ec.idnumeroopcion = 1 AND e.codigosituacioncarreraestudiante <> '109' ".
                " GROUP BY e.codigoestudiante ORDER BY i.codigoperiodo desc";
            $row_selcarreras = $db->GetAll($query_selcarreras);
            $totalRows_selcarreras = count($row_selcarreras);

            $query_serPiloPaga = "SELECT t.idtipoestudianterecursofinanciero, t.nombretipoestudianterecursofinanciero ".
                " FROM estudianterecursofinanciero e,tipoestudianterecursofinanciero t ".
                " WHERE e.idestudiantegeneral = " . $db->qstr($idestudiantegeneral) . " ".
                " and e.idtipoestudianterecursofinanciero = t.idtipoestudianterecursofinanciero ".
                " and e.codigoestado like '1%' order by nombretipoestudianterecursofinanciero";
            $serPiloPagaEstudiante = $db->Execute($query_serPiloPaga);
            $totalRows_serPiloPaga = $serPiloPagaEstudiante->RecordCount();
            $row_serPiloPaga = $serPiloPagaEstudiante->FetchRow();

            $query_CarreraInscripcion = "SELECT codigoindicadorcobroinscripcioncarrera FROM carrera ".
                " WHERE codigocarrera = " . $db->qstr($codigocarreraOrigen) . "  ";
            $row_cobroInscripcion = $db->GetRow($query_CarreraInscripcion);
            // Siempre entra con la carrera que inscribio por primera vez,
            // si desea cambiar debe seleccionar la carrera de la tabla

            if(!isset($idestudiantegeneral) && empty($idestudiantegeneral)){
                ?>
                <script>swal("El programa seleccionado no cuenta con un periodo activo para insciprciones, por favor comuniquese con la facultad o inscribase a un programa diferente");</script>
                <?php
            }

            $idinscripcion = $row_data['idinscripcion'];
            $codigoperiodo = $row_data['codigoperiodo'];
            $codigocarrera = $row_data['codigocarrera'];
            $codigoestudiante = $row_data['codigoestudiante'];
            $_SESSION['modalidadacademicasesion'] = $row_data['codigomodalidadacademica'];

            $query_subperiodo = "SELECT sp.idsubperiodo FROM subperiodo sp, carreraperiodo cp ".
            " WHERE cp.codigoperiodo = " . $db->qstr($codigoperiodo) . " ".
            " AND sp.codigoestadosubperiodo like '1%' ".
            " AND sp.idcarreraperiodo=cp.idcarreraperiodo ".
            " AND cp.codigocarrera = " . $db->qstr($codigocarrera) . "  ";
            $row_sel_subperiodo = $db->GetRow($query_subperiodo);
            $idsubperiodo = $row_sel_subperiodo['idsubperiodo'];

            if (!empty($idsubperiodo)) {
                $query_salon = "SELECT a.*, dsa.codigosalon, hdsa.*,s.* ".
                " FROM admision a, detalleadmision da, estudianteadmision ea, detalleestudianteadmision dea, ".
                " detallesitioadmision dsa, horariodetallesitioadmision hdsa, salon s ".
                " WHERE a.codigocarrera = " . $db->qstr($codigocarrera) . " ".
                " AND a.idsubperiodo = " . $db->qstr($idsubperiodo) . " AND a.codigoestado = '100' ".
                " AND da.idadmision = a.idadmision AND da.codigoestado = '100' AND ea.codigoestado = '100' ".
                " AND dea.codigoestado = '100' AND ea.idadmision = a.idadmision ".
                " AND ea.idestudianteadmision = dea.idestudianteadmision ".
                " AND dsa.idadmision = a.idadmision ".
                " AND hdsa.iddetallesitioadmision = dsa.iddetallesitioadmision ".
                " AND now() < hdsa.fechafinalhorariodetallesitioadmision ".
                " AND dsa.codigosalon = s.codigosalon ".
                " AND dea.idhorariodetallesitioadmision = hdsa.idhorariodetallesitioadmision ".
                " AND ea.codigoestudiante = " . $db->qstr($codigoestudiante) . " ".
                " AND dsa.iddetalleadmision = da.iddetalleadmision AND da.codigotipodetalleadmision = '1'";
                
                $data_salon = $db->Execute($query_salon);
                $totalRows_salon = $data_salon->RecordCount();
                if ($totalRows_salon > 0) {
                    $row_data_salon = $data_salon->FetchRow();
                    $_SESSION['array_salon'] = $row_data_salon;
                    ?>
                    <script type="text/javascript">
                        var globo = document.getElementById('divglobo');
                        ajax_showTooltip('mostrarArraySalon.php?codigomodalidadacademica=<?php
                            echo $row_data["codigomodalidadacademica"]; ?>', document.getElementById('divglobo'));
                        Event.observe('ajax_tooltipObj', 'click', function (event) {
                            ajax_hideTooltip()
                        }, false);
                    </script>
                    <?php
                }
            }
            ?>
            <table class="table">
                <tr id="trtituloNaranjaInst">
                    <td>
                        <h3>
                            Bienvenido(a)<br>
                            <?php echo $row_data['nombretrato'] . " " .
                            $row_data['nombresestudiantegeneral'] . " " .
                            $row_data['apellidosestudiantegeneral']; ?>
                        </h3>
                        <?php echo $row_data['nombrecarrera'] . " - " . $codigoperiodo; ?>
                        <input type="hidden" id="idusuario" name="idusuario" value="<?php echo $_SESSION["idReferente"];?>">
                        <input type="hidden" id="codigoperiodo" name="codigoperiodo" value="<?php echo $codigoperiodo?>">
                        <input type="hidden" id="codigoestudiante" name="codigoestudiante" value="<?php echo $row_data['codigoestudiante']?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="javascript: window.location.href='../serviciosacademicos/consulta/prematricula/inscripcionestudiante/formulariopreinscripcion.php?logincorrecto&idEstudianteCarreraInscripcion=<?php
                        echo $idEstudianteCarreraInscripcion ?>&documentoingreso=<?php
                        echo "$numerodocumento"; ?>&menuprincipal=1'" >Inscribete en un nuevo programa</a>
                    </td>
                </tr>
                <?php
                $_SESSION['codigocarrerasesion'] = $row_data['codigocarrera'];
                if ($totalRows_selcarreras > 0) {
                    ?>
                    <tr>
                        <td>
                            <table class="table">
                                <tr id="trtituloNaranjaInst">
                                    <td colspan="3">
                                        Seleccione la carrera que desea consultar
                                    </td>
                                </tr>
                                <?php
                                foreach($row_selcarreras as $rowcarrera){
                                    echo "<tr><td>";
                                    $hoy = date("Y-m-d");
                                    $SQL_periodoActivo = "SELECT cg.codigocarrera,  ".
                                    " cg.fechahastacarreragrupofechainscripcion, cp.codigoperiodo ".
                                    " FROM  carreragrupofechainscripcion cg ".
                                    " INNER JOIN subperiodo sp ON cg.idsubperiodo = sp.idsubperiodo ".
                                    " INNER JOIN carreraperiodo cp ON sp.idcarreraperiodo = cp.idcarreraperiodo ".
                                    " WHERE ".
                                    " cp.codigoperiodo = " . $db->qstr($rowcarrera['codigoperiodo']) . " ".
                                    " AND cg.codigocarrera = " . $db->qstr($rowcarrera['codigocarrera']) . " ".
                                    " AND cg.fechahastacarreragrupofechainscripcion >= " . $db->qstr($hoy) . " ";
                                    $selPeriodo = $db->GetRow($SQL_periodoActivo);

                                    if (isset($selPeriodo['codigocarrera']) && !empty($selPeriodo['codigocarrera'])) {
                                        ?>
                                        <a href="enlineacentral.php?codigocarrera=<?php
                                        echo $rowcarrera['codigocarrera'] .
                                            "&documentoingreso=$numerodocumento&idEstudianteCarreraInscripcion=" .
                                            $idEstudianteCarreraInscripcion . "" ?>"><?php
                                            echo $rowcarrera['nombrecarrera']." - ".$rowcarrera['codigoperiodo']; ?>
                                        </a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="javascript:swal('Las inscripciones para el Programa <?php
                                        echo $rowcarrera['nombrecarrera'] . " Periodo " .
                                            $rowcarrera['codigoperiodo']; ?> Se encuentran Cerradas');"><?php
                                            echo $rowcarrera['nombrecarrera']." - ".$rowcarrera['codigoperiodo']; ?>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                    </td>
                                    <td class="Estilo6">
                                        <?php echo $rowcarrera['nombresituacioncarreraestudiante'] ?>
                                    </td>
                                    <td>
                                        <a href="../serviciosacademicos/consulta/prematricula/inscripcionestudiante/vistaformularioinscripcion.php?facultad=<?php
                                        echo $rowcarrera['codigofacultad'].'&codigoestudiante='.
                                            $rowcarrera['codigoestudiante'];?>" target="_blank"> <?php
                                            echo 'Previsualizar Formulario de Datos'; ?></a>
                                    </td>
                                </tr>
                                <?php
                            }//foreach
                            ?>
                        </table>
                    </td>
                </tr>
                <?php
                } else {
                    //obtiene fecha de periodo activo vigente a la fecha actual
                    $queryPeriodoActivo  = "select codigoperiodo from periodo ".
                    " where codigoestadoperiodo in (1,4) and fechainicioperiodo >= now() limit 1";
                    $periodoActivoPorFecha = $db->GetRow($queryPeriodoActivo);

                    //Valida si la carrera tiene fechas activas para la inscripción para el periodo seleccionado.
                    $hoy = date("Y-m-d");
                    $SQL_periodoActivo = "SELECT cg.codigocarrera, cg.fechahastacarreragrupofechainscripcion, ".
                    " cp.codigoperiodo FROM carreragrupofechainscripcion cg ".
                    " INNER JOIN subperiodo sp ON cg.idsubperiodo = sp.idsubperiodo ".
                    " INNER JOIN carreraperiodo cp ON sp.idcarreraperiodo = cp.idcarreraperiodo ".
                    " WHERE cp.codigoperiodo = '" . $periodoActivoPorFecha['codigoperiodo'] . "' ".
                    " AND cg.codigocarrera= '" . $_GET['codigocarrera'] . "' ".
                    " AND cg.fechahastacarreragrupofechainscripcion >= '" . $hoy . "'  ";
                    $selPeriodo = $db->GetRow($SQL_periodoActivo);
                    $totalRows_selPeriodo = count($selPeriodo);
                    $_SESSION['codigocarrerasesion'] = $selPeriodo['codigocarrera'];
                }

                // Toma el porcentaje de diligenciamiento del fromulario
                $inscripcion = new inscripcion($estudiantegeneral, $idsubperiodo, $idinscripcion,
                $row_data['codigomodalidadacademica']);
                $porcentaje = tomarPorcentajeDiligenciadoFormulario();
                $pasossiguientes = false;
                ?>
                <tr id="trtituloNaranjaInst">
                    <td>
                        <h4>Seguimiento a su Proceso de Ingreso</h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        if ($codigocarreraOrigen) {
                            $consultacarrera = "SELECT DISTINCT c.nombrecarrera, c.codigocarrera, cp.codigoperiodo ".
                            " FROM carrera c ".
                            " INNER JOIN  carreragrupofechainscripcion cf ON (c.codigocarrera = cf.codigocarrera ) ".
                            " INNER JOIN subperiodo sp ON (cf.idsubperiodo = sp.idsubperiodo ) ".
                            " INNER JOIN carreraperiodo cp ON (sp.idcarreraperiodo = cp.idcarreraperiodo ) ".
                            " WHERE  c.codigocarrera = '" . $codigocarreraOrigen . "' ".
                            " AND c.fechavencimientocarrera > now() ".
                            " AND cf.fechahastacarreragrupofechainscripcion >= '" . date("Y-m-d") . "' ".
                            " AND cp.codigoestado = 100  ORDER BY c.nombrecarrera;";
                            $rcarera = $db->Execute($consultacarrera);
                            $nombrecarrera = $rcarera->FetchRow();

                            if ($nombrecarrera['nombrecarrera']) {
                                $onclick = "window.location.href='../serviciosacademicos/consulta/prematricula/inscripcionestudiante/formulariodeinscripcion.php?modalidad=" . $row_data['codigomodalidadacademica'] . "&inscripcionactiva=" . $row_data['idinscripcion'] . "&documento=" . $row_data['numerodocumento'] . "&idsubperiodo=" .
                                $row_sel_subperiodo['idsubperiodo'] . "&idEstudianteCarreraInscripcion="
                                . $idEstudianteCarreraInscripcion . "'";
                                $pasoUno = 0;
                                $pasoDos = 0;

                                if ($porcentaje <= 0) {
                                    $semaforo = "color:red;";
                                    $icono = "fa-times-circle fa-2x";
                                }
                                if ($porcentaje > 0) {
                                    $semaforo = "color:orange;";
                                    $icono = "fa-exclamation-circle fa-2x";
                                }
                                if ($porcentaje == 1) {
                                    $semaforo = "color:green;";
                                    $icono = "fa-check-circle fa-2x";

                                    $pasoUno = 1;
                                    if ($row_data['codigoindicadorcobroinscripcioncarrera'] == '200'
                                        && $row_data['codigosituacioncarreraestudiante'] == '106') {
                                        // Si cumple debe pasarlo a inscrito sin pago
                                        $query_updinscripcion = "UPDATE estudiante e,inscripcion i,estudiantecarrerainscripcion ec ".
                                        " SET i.codigosituacioncarreraestudiante = '111', ".
                                        " e.codigosituacioncarreraestudiante = '111', ".
                                        " e.codigoperiodo = '" . $row_data['codigoperiodo'] . "' ".
                                        " WHERE e.codigoestudiante = '" . $row_data['codigoestudiante'] . "' ".
                                        " AND e.idestudiantegeneral = i.idestudiantegeneral ".
                                        " AND e.codigocarrera = ec.codigocarrera ".
                                        " AND i.idinscripcion = ec.idinscripcion ".
                                        " and i.idinscripcion = '" . $row_data['idinscripcion'] . "'";
                                        $upd_inscripcion = $db->Execute($query_updinscripcion);
                                    } else {
                                        if ($row_serPiloPaga["idtipoestudianterecursofinanciero"] == "13"
                                            && $row_data['codigosituacioncarreraestudiante'] == '106') {
                                            $query_updinscripcion2 = "UPDATE estudiante e,inscripcion i,".
                                            " estudiantecarrerainscripcion ec ".
                                            " SET i.codigosituacioncarreraestudiante = '111', ".
                                            " e.codigosituacioncarreraestudiante = '111', ".
                                            " e.codigoperiodo = '" . $row_data['codigoperiodo'] . "' ".
                                            " WHERE e.codigoestudiante = '" . $row_data['codigoestudiante'] . "' ".
                                            " AND e.idestudiantegeneral = i.idestudiantegeneral ".
                                            " AND e.codigocarrera = ec.codigocarrera ".
                                            " AND i.idinscripcion = ec.idinscripcion ".
                                            " and i.idinscripcion = '" . $row_data['idinscripcion'] . "'";
                                            $upd_inscripcion2 = $db->Execute($query_updinscripcion2);
                                        }
                                    }
                                }//if porcentaje == 1
                                ?>
                                <p>
                                <?php
                                $hoy = date("Y-m-d");
                                $SQL_periodoActivo = "SELECT cg.codigocarrera, ".
                                " cg.fechahastacarreragrupofechainscripcion, cp.codigoperiodo ".
                                " FROM carreragrupofechainscripcion cg ".
                                " INNER JOIN subperiodo sp ON cg.idsubperiodo = sp.idsubperiodo ".
                                " INNER JOIN carreraperiodo cp ON sp.idcarreraperiodo = cp.idcarreraperiodo ".
                                " WHERE cp.codigoperiodo = '" . $codigoperiodo . "' ".
                                " AND cg.codigocarrera= '" . $codigocarreraOrigen . "' ".
                                " AND cg.fechahastacarreragrupofechainscripcion >= '" . $hoy . "'  ";
                                $selPeriodo = $db->Execute($SQL_periodoActivo);
                                $totalRows_selPeriodo = $selPeriodo->RecordCount();

                                if ($totalRows_selPeriodo == '0') {
                                    ?>
                                    <i class="fa <?php echo $icono; ?>" style="<?php echo $semaforo ?>">
                                    </i>
                                    <a href="#" align="middle" class="link-semaforo" style="cursor:pointer"
                                        onClick="javascript:swal('Las inscripciones para el Programa
                                        <?php echo $row_selcarreras['nombrecarrera'] . " Periodo " .
                                            $row_selcarreras['codigoperiodo']; ?> Se encuentran Cerradas');">Diligenciar Formulario de Inscripción</a>
                                    <?php
                                } else {
                                    ?>
                                    <i class="fa <?php echo $icono; ?>" style="<?php echo $semaforo ?>"></i>
                                    <a  href="#" align="middle" class="link-semaforo" style="cursor:pointer"
                                        onClick="<?php echo $onclick; ?>">Diligenciar Formulario de Inscripción</a>
                                    <?php
                                }
                                $semaforo = "";
                                $onclick = "";
                                // Valida si el estudiante ya genero orden de pago por formulario
                                $query_selordenpago = "select o.numeroordenpago, o.codigoestadoordenpago ".
                                " from ordenpago o, concepto c, detalleordenpago dop ".
                                " where o.codigoestudiante = '" . $row_data['codigoestudiante'] . "' ".
                                " and o.codigoperiodo = '" . $row_data['codigoperiodo'] . "' ".
                                " and (c.cuentaoperacionprincipal = '152' or c.cuentaoperacionprincipal = '153') ".
                                " and c.codigoconcepto = dop.codigoconcepto ".
                                " and dop.numeroordenpago = o.numeroordenpago ".
                                " and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like ".
                                " '4%' or o.codigoestadoordenpago like '6%')";
                                $selordenpago = $db->Execute($query_selordenpago);
                                $totalRows_selordenpago = $selordenpago->RecordCount();
                                $row_selordenpago = $selordenpago->FetchRow();

                                if ($totalRows_selordenpago == "") {
                                    $semaforo = "color:red;";
                                    $icono = "fa-times-circle fa-2x";
                                } else {
                                    if (ereg("^4.+$", $row_selordenpago['codigoestadoordenpago'])) {
                                        $semaforo = "color:green;";
                                        $icono = "fa-check-circle fa-2x";
                                        $pasossiguientes = true;
                                        $pasoDos = 1;
                                    } else {
                                        $semaforo = "color:orange;";
                                        $icono = "fa-exclamation-circle fa-2x";
                                    }
                                }
                                if ($row_data['codigoindicadorcobroinscripcioncarrera'] == "200") {
                                    $onclick = "swal('Este programa no requiere de pago de derechos de inscripcion')";
                                    $semaforo = "color:green;";
                                    $icono = "fa-check-circle fa-2x";
                                    $pasoDos = 1;
                                    $pasossiguientes = true;
                                } else {

                                    if ($row_serPiloPaga["idtipoestudianterecursofinanciero"] == "13") {
                                        $onclick = "swal('El estudiante no requiere pago de derechos de inscripción')";
                                        $semaforo = "color:green;";
                                        $icono = "fa-check-circle fa-2x";
                                        $pasoDos = 1;
                                        $pasossiguientes = true;
                                    } else {

                                        if ($porcentaje < 1) {
                                            $onclick = "swal('Debe diligenciar todo el formulario de inscripción');";
                                            $onclick .= "window.location.href='../serviciosacademicos/consulta/prematricula/inscripcionestudiante/formulariodeinscripcion.php?modalidad=" . $row_data['codigomodalidadacademica'] . "&inscripcionactiva=" . $row_data['idinscripcion'] . "&documento=" . $row_data['numerodocumento'] . "&idsubperiodo=" . $row_sel_subperiodo['idsubperiodo'] . "&idEstudianteCarreraInscripcion=" . $idEstudianteCarreraInscripcion . "'";
                                        } else
                                            $onclick = "window.location.href='../serviciosacademicos/consulta/prematricula/inscripcionestudiante/pagoderechosinscripcion.php?documentoingreso=$numerodocumento&codigoestudiante=" . $row_data['codigoestudiante'] . "&codigoperiodo=" . $row_data['codigoperiodo'] . "&menuprincipal'";
                                    }
                                }
                                ?>
                                <p>
                                <?php
                                if ($totalRows_selPeriodo == '0') {
                                    ?>
                                    <i class="fa <?php echo $icono; ?>" style="<?php echo $semaforo ?>"></i>
                                    <a href="#" class="link-semaforo" style="cursor:pointer"
                                       onClick="javascript:swal('Las inscripciones para el Programa <?php
                                       echo $row_selcarreras['nombrecarrera'] . " Periodo " .
                                           $row_selcarreras['codigoperiodo']; ?> Se encuentran Cerradas');">Pago Derechos de Inscripción</a>
                                    <?php
                                } else {
                                    ?>
                                    <i class="fa <?php echo $icono; ?>" style="<?php echo $semaforo ?>"></i>
                                    <a href="#" class="link-semaforo"a style="cursor:pointer"
                                       onClick="<?php echo $onclick ?>">Pago Derechos de Inscripción</a>
                                    <?php
                                }
                                ?>
                            </p>
                            <?php
                            $semaforoEntrevista = "";
                            $entrevistado = 0;

                            $sqlEntrevistaAsignada = "SELECT COUNT(1) as count FROM AsignacionEntrevistas ".
                            " WHERE IdEstudianteCarreraInscripcion=" . $db->qstr($idEstudianteCarreraInscripcion)
                            ." AND EstadoAsignacionEntrevista = 400";

                            $sqlEntrevista = $db->GetRow($sqlEntrevistaAsignada);
                            $entrevistado = $sqlEntrevista['count'];

                            if ($pasoUno == 0 and $pasoDos == 0 and $entrevistado == 0) {
                                $semaforoEntrevista = "color:red";
                                $icono = "fa-times-circle fa-2x";
                            } else if ($pasoUno == 0 or $pasoDos == 0) {
                                $semaforoEntrevista = "color:red";
                                $icono = "fa-times-circle fa-2x";
                            } else if ($pasoUno == 1 and $pasoDos == 1 and $entrevistado == 1) {
                                $semaforoEntrevista = "color:green";
                                $icono = "fa-check-circle fa-2x";
                            } else {
                                $semaforoEntrevista = "color:red";
                                $icono = "fa-times-circle fa-2x";
                            }

                            if ($totalRows_selPeriodo == '0') {
                                ?>
                                <input type="hidden" id='activarAsignacion' value="<?php echo $porcentaje . '_' . $pasossiguientes ?>">
                                <p><i class="fa identificador <?php echo $icono; ?>"
                                      style="<?php echo $semaforoEntrevista ?>"></i>
                                    <a onclick="javascript:swal('Las inscripciones para el Programa <?php
                                    echo $row_selcarreras['nombrecarrera'] . " Periodo " .
                                        $row_selcarreras['codigoperiodo']; ?> Se encuentran Cerradas');"
                                       style="cursor:pointer" class="link-semaforo"> Programe su entrevista / Prueba</a></p>
                                <?php
                            } else {
                                ?>
                                <input type="hidden" id='activarAsignacion' value="<?php echo $porcentaje . '_' . $pasossiguientes ?>">
                                <p><i class="fa identificador <?php echo $icono; ?>"
                                      style="<?php echo $semaforoEntrevista ?>"></i>
                                    <a href="#" id ="asignarEntrevista" class="link-semaforo"
                                       data-clase=<?php echo $icono; ?>> Programe su entrevista / Prueba</a></p>
                                <input type="hidden" value="<?php echo $idEstudianteCarreraInscripcion ?>" id="idEstudianteCarreraInscripcion" >
                                <input type="hidden" value="<?php echo $codigocarrera ?>" id="codigoCarreraAspirante" >
                                <input type="hidden" value="<?php echo $row_data['nombresestudiantegeneral'] . " " .
                                    $row_data['apellidosestudiantegeneral'] ?>" id="nombreAspirante" >
                                <input type="hidden" value="<?php echo $row_data['nombrecarrera'] ?>" id="nombreCarreraAspirante" >
                                <input type="hidden" value="<?php echo $entrevistado ?>" id="entrevistado" >
                                <?php
                            }

                            $tmpinscritosinpago = false;
                            if ($row_data['codigosituacioncarreraestudiante'] == 111) {
                                $tmpinscritosinpago = true;
                            }

                            if ((!$pasossiguientes && !$tmpinscritosinpago)) {
                                if (ereg("^4.+$", $row_selordenpago['codigoestadoordenpago'])) {
                                    $onclick = "swal('No puede diligenciar el formulario hasta que pague ".
                                    " los derechos de inscripciÃ³n')";
                                }else {
                                    $onclick = "window.location.href='../serviciosacademicos/consulta/prematricula/inscripcionestudiante/formulariodeinscripcion.php?modalidad=" . $row_data['codigomodalidadacademica'] . "&inscripcionactiva=" . $row_data['idinscripcion'] . "&documento=" . $row_data['numerodocumento'] . "&idsubperiodo=" . $row_sel_subperiodo['idsubperiodo'] . "&idEstudianteCarreraInscripcion=" . $idEstudianteCarreraInscripcion . "'";
                                }
                            }else {
                                $onclick = "window.location.href='../serviciosacademicos/consulta/prematricula/inscripcionestudiante/formulariodeinscripcion.php?modalidad=" . $row_data['codigomodalidadacademica'] . "&inscripcionactiva=" . $row_data['idinscripcion'] . "&documento=" . $row_data['numerodocumento'] . "&idsubperiodo=" . $row_sel_subperiodo['idsubperiodo'] . "&idEstudianteCarreraInscripcion=" . $idEstudianteCarreraInscripcion . "'";
                            }

                            // Paso de diligenciamiento de formulario
                            // 1. Mirar cuales son los formularios que tien que diligenciar
                            // 2. Mirar culaes tablas han sido diligenciadas de acuerdo a los formularios a diligenciar
                            $query_formularios = "SELECT linkinscripcionmodulo,posicioninscripcionformulario, ".
                            " nombreinscripcionmodulo,im.idinscripcionmodulo,ip.codigoindicadorinscripcionformulario ".
                            " FROM inscripcionformulario ip, inscripcionmodulo im ".
                            " WHERE ip.idinscripcionmodulo = im.idinscripcionmodulo ".
                            " AND ip.codigomodalidadacademica = '" . $row_data['codigomodalidadacademica'] . "' ".
                            " AND ip.codigoestado LIKE '1%' order by posicioninscripcionformulario";
                            $formularios = $db->Execute($query_formularios);
                            $totalRows_formularios = $formularios->RecordCount();
                            $informacionpersonal = false;
                            $estudiorealizados = false;

                            $cuentapasos = 0;
                            $ratafinal = 0;
                            $cuentaratas = 0;

                            require("../serviciosacademicos/consulta/prematricula/inscripcionestudiante/funcionformulario.php");

                            while ($row_formularios = $formularios->FetchRow()) {
                                if ($row_formularios['idinscripcionmodulo'] == 1) {
                                    $query = "select nombresestudiantegeneral, apellidosestudiantegeneral, ".
                                    " tipodocumento, numerodocumento, expedidodocumento, ".
                                    " codigogenero, idestadocivil, idciudadnacimiento, ".
                                    " fechanacimientoestudiantegeneral, direccionresidenciaestudiantegeneral, ".
                                    " telefonoresidenciaestudiantegeneral, ciudadresidenciaestudiantegeneral, ".
                                    " emailestudiantegeneral from estudiantegeneral ".
                                    " where idestudiantegeneral = '" . $row_data['idestudiantegeneral'] . "'";
                                    $ratatotal = valida_formulario($query, $db);

                                    if ($row_formularios['codigoindicadorinscripcionformulario'] == 100) {
                                        $ratafinal = $ratafinal + $ratatotal;
                                        $cuentaratas++;
                                    }
                                }
                                if ($row_formularios['idinscripcionmodulo'] == 2) {
                                    if ($row_data['codigomodalidadacademica'] != 300) {
                                        $query = "SELECT e.anogradoestudianteestudio, n.nombreniveleducacion, ".
                                        " e.idinstitucioneducativa, e.codigotitulo, e.ciudadinstitucioneducativa, ".
                                        " e.idestudianteestudio, ".
                                        " concat(ins.nombreinstitucioneducativa,'',e.otrainstitucioneducativaestudianteestudio) as nombreinstitucioneducativa, ".
                                        " concat(t.nombretitulo,'',e.otrotituloestudianteestudio) as nombretitulo ".
                                        " FROM estudianteestudio e,niveleducacion n,institucioneducativa ins,titulo t ".
                                        " WHERE e.idestudiantegeneral = '" . $row_data['idestudiantegeneral'] . "' ".
                                        " and e.idniveleducacion = n.idniveleducacion ".
                                        " and ins.idinstitucioneducativa = e.idinstitucioneducativa ".
                                        " and e.codigotitulo = t.codigotitulo and e.codigoestado like '1%' ".
                                        " and e.idniveleducacion = 2 order by anogradoestudianteestudio";
                                    } else {
                                        $query = "SELECT e.anogradoestudianteestudio, n.nombreniveleducacion, ".
                                        " e.idinstitucioneducativa, e.codigotitulo, e.ciudadinstitucioneducativa, ".
                                        " e.idestudianteestudio, ".
                                        " concat(ins.nombreinstitucioneducativa,'',e.otrainstitucioneducativaestudianteestudio) as nombreinstitucioneducativa, ".
                                        " concat(t.nombretitulo,'',e.otrotituloestudianteestudio) as nombretitulo ".
                                        " FROM estudianteestudio e,niveleducacion n,institucioneducativa ins,titulo t ".
                                        " WHERE e.idestudiantegeneral = '" . $row_data['idestudiantegeneral'] . "' ".
                                        " and e.idniveleducacion = n.idniveleducacion ".
                                        " and ins.idinstitucioneducativa = e.idinstitucioneducativa ".
                                        " and e.codigotitulo = t.codigotitulo and e.codigoestado like '1%' ".
                                        " order by anogradoestudianteestudio";
                                    }
                                    $rata1 = $inscripcion->valida_formulario($query, $db);

                                    $query = "SELECT r.nombreresultadopruebaestado, r.numeroregistroresultadopruebaestado, ".
                                    " r.puestoresultadopruebaestado ".
                                    " FROM detalleresultadopruebaestado d,resultadopruebaestado r ".
                                    " WHERE r.idestudiantegeneral = '" . $row_data['idestudiantegeneral'] . "' ".
                                    " and r.idresultadopruebaestado = d.idresultadopruebaestado ".
                                    " and d.codigoestado like '1%'";
                                    $rata2 = $inscripcion->valida_formulario($query, $db);
                                    $ratatotal = $rata1;

                                    if ($row_formularios['codigoindicadorinscripcionformulario'] == 100) {
                                        $ratafinal = $ratafinal + $ratatotal;
                                        $cuentaratas++;
                                    }
                                }
                                if ($row_formularios['idinscripcionmodulo'] == 4) {
                                    $query = "SELECT idnumeroopcion, c.nombrecarrera, m.nombremodalidadacademica,".
                                    " c.codigocarrera, e.idinscripcion , e.idestudiantecarrerainscripcion ".
                                    " FROM estudiantecarrerainscripcion e,carrera c,modalidadacademica m ".
                                    " WHERE e.idestudiantegeneral = '" . $row_data['idestudiantegeneral'] . "' ".
                                    " and m.codigomodalidadacademica = c.codigomodalidadacademica ".
                                    " and e.codigocarrera = c.codigocarrera ".
                                    " and e.codigoestado like '1%' ".
                                    " and e.idinscripcion = '" . $row_data['idinscripcion'] . "' ".
                                    " and e.idnumeroopcion > 1 order by idnumeroopcion";
                                    $ratatotal = valida_formulario($query, $db);
                                    if ($row_formularios['codigoindicadorinscripcionformulario'] == 100) {
                                        $ratafinal = $ratafinal + $ratatotal;
                                        $cuentaratas++;
                                    }
                                }
                                if ($row_formularios['idinscripcionmodulo'] == 7) {
                                    if ($row_data['codigomodalidadacademica'] != 200) {
                                        $query = "SELECT t.nombretipoestudiantefamilia, e.nombresestudiantefamilia,".
                                        " e.apellidosestudiantefamilia, ".
                                        " e.idestudiantefamilia, e.idtipoestudiantefamilia ".
                                        " FROM estudiantefamilia e,tipoestudiantefamilia t,niveleducacion n ".
                                        " WHERE e.idestudiantegeneral = '" . $row_data['idestudiantegeneral'] . "' ".
                                        " and e.idtipoestudiantefamilia = t.idtipoestudiantefamilia ".
                                        " and e.idniveleducacion = n.idniveleducacion ".
                                        " and e.codigoestado like '1%' order by e.idtipoestudiantefamilia";
                                        $ratatotal = valida_formulario($query, $db);
                                        if ($row_formularios['codigoindicadorinscripcionformulario'] == 100) {
                                            $ratafinal = $ratafinal + $ratatotal;
                                            $cuentaratas++;
                                        }
                                    } else {
                                        $query = "SELECT t.nombretipoestudiantefamilia, e.nombresestudiantefamilia, ".
                                        " e.apellidosestudiantefamilia, e.idestudiantefamilia, e.idtipoestudiantefamilia ".
                                        " FROM estudiantefamilia e,tipoestudiantefamilia t,niveleducacion n ".
                                        " WHERE e.idestudiantegeneral = '" . $row_data['idestudiantegeneral'] . "' ".
                                        " and e.idtipoestudiantefamilia = t.idtipoestudiantefamilia ".
                                        " and e.idniveleducacion = n.idniveleducacion ".
                                        " and e.codigoestado like '1%' and e.idtipoestudiantefamilia = '1' ".
                                        " order by e.idtipoestudiantefamilia";
                                        $rata1 = valida_formulario($query, $db);

                                        $query = "SELECT t.nombretipoestudiantefamilia, e.nombresestudiantefamilia, ".
                                        " e.apellidosestudiantefamilia, e.idestudiantefamilia, e.idtipoestudiantefamilia ".
                                        " FROM estudiantefamilia e,tipoestudiantefamilia t,niveleducacion n ".
                                        " WHERE e.idestudiantegeneral = '" . $row_data['idestudiantegeneral'] . "' ".
                                        " and e.idtipoestudiantefamilia = t.idtipoestudiantefamilia ".
                                        " and e.idniveleducacion = n.idniveleducacion ".
                                        " and e.codigoestado like '1%' and e.idtipoestudiantefamilia = '2' ".
                                        " order by e.idtipoestudiantefamilia";
                                        $rata2 = valida_formulario($query, $db);

                                        $query = "SELECT t.nombretipoestudiantefamilia, e.nombresestudiantefamilia, ".
                                        " e.apellidosestudiantefamilia, e.idestudiantefamilia, e.idtipoestudiantefamilia ".
                                        " FROM estudiantefamilia e,tipoestudiantefamilia t,niveleducacion n ".
                                        " WHERE e.idestudiantegeneral = '" . $row_data['idestudiantegeneral'] . "' ".
                                        " and e.idtipoestudiantefamilia = t.idtipoestudiantefamilia ".
                                        " and e.idniveleducacion = n.idniveleducacion ".
                                        " and e.codigoestado like '1%' and e.idtipoestudiantefamilia = '7' ".
                                        " order by e.idtipoestudiantefamilia";
                                        $rata3 = valida_formulario($query, $db);

                                        $ratatotal = ($rata1 + $rata2 + $rata3) / 3;

                                        if ($row_formularios['codigoindicadorinscripcionformulario'] == 100) {
                                            $ratafinal = $ratafinal + $ratatotal;
                                            $cuentaratas++;
                                        }
                                    }
                                }
                                if ($row_formularios['idinscripcionmodulo'] == 8) {
                                    $query = "SELECT i.nombreidioma, ".
                                    " if(e.porcentajeleeestudianteidioma = 0,1,e.porcentajeleeestudianteidioma) AS porcentajeleeestudianteidioma, ".
                                    " if(e.porcentajehablaestudianteidioma = 0,1,e.porcentajehablaestudianteidioma) AS porcentajehablaestudianteidioma, ".
                                    " if(e.porcentajeescribeestudianteidioma = 0,1,e.porcentajeescribeestudianteidioma) AS porcentajeescribeestudianteidioma, ".
                                    " e.idestudianteidioma ".
                                    " FROM estudianteidioma e, idioma i ".
                                    " WHERE e.idestudiantegeneral = '" . $row_data['idestudiantegeneral'] . "' ".
                                    " and e.ididioma = i.ididioma and e.codigoestado like '1%' ".
                                    " order by nombreidioma";
                                    $ratatotal = valida_formulario($query, $db);
                                    if ($row_formularios['codigoindicadorinscripcionformulario'] == 100) {
                                        $ratafinal = $ratafinal + $ratatotal;
                                        $cuentaratas++;
                                    }
                                }
                                if ($row_formularios['idinscripcionmodulo'] == 9) {
                                    $query = "SELECT nombremediocomunicacion ".
                                    " FROM estudiantemediocomunicacion e,mediocomunicacion m ".
                                    " WHERE e.idestudiantegeneral = '" . $row_data['idestudiantegeneral'] . "' ".
                                    " and e.idinscripcion = '" . $row_data['idinscripcion'] . "' ".
                                    " and e.codigomediocomunicacion = m.codigomediocomunicacion ".
                                    " and e.codigoestadoestudiantemediocomunicacion like '1%' ".
                                    " order by nombremediocomunicacion";
                                    $ratatotal = valida_formulario($query, $db);
                                    if ($row_formularios['codigoindicadorinscripcionformulario'] == 100) {
                                        $ratafinal = $ratafinal + $ratatotal;
                                        $cuentaratas++;
                                    }
                                }
                                if ($row_formularios['idinscripcionmodulo'] == 10) {
                                    $query = "SELECT nombretipoestudianterecursofinanciero ".
                                    " FROM estudianterecursofinanciero e,tipoestudianterecursofinanciero t ".
                                    " WHERE e.idestudiantegeneral = '" . $row_data['idestudiantegeneral'] . "' ".
                                    " and e.idtipoestudianterecursofinanciero = t.idtipoestudianterecursofinanciero ".
                                    " and e.codigoestado like '1%' ".
                                    " order by nombretipoestudianterecursofinanciero";
                                    $ratatotal = valida_formulario($query, $db);
                                    if ($row_formularios['codigoindicadorinscripcionformulario'] == 100) {
                                        $ratafinal = $ratafinal + $ratatotal;
                                        $cuentaratas++;
                                    }
                                }
                                if ($row_formularios['idinscripcionmodulo'] == 11) {
                                    $query = "select e.presentadoestudianteotrauniversidad ".
                                    " from estudianteotrauniversidad e ".
                                    " where e.idestudiantegeneral = '" . $row_data['idestudiantegeneral'] . "' ".
                                    " and e.codigoestado like '1%' ".
                                    " and e.idinscripcion = '" . $row_data['idinscripcion'] . "'";
                                    $ratatotal = valida_formulario($query, $db);
                                    if ($row_formularios['codigoindicadorinscripcionformulario'] == 100) {
                                        $ratafinal = $ratafinal + $ratatotal;
                                        $cuentaratas++;
                                    }
                                }
                            }//while

                            $rata = null;
                            if ($cuentaratas != 0) {
                                $rata = $ratafinal / $cuentaratas;
                            }

                            if ($rata < 0.9) {
                                $semaforo = "color:red;";
                                $icono = "fa-times-circle fa-2x";
                            } else if ($rata == 2) {
                                $semaforo = "color:green;";
                                $icono = "fa-check-circle fa-2x";
                            } else {
                                $semaforo = "color:orange;";
                                $icono = "fa-exclamation-circle fa-2x";
                            }

                            if(!isset($mensaje) || empty($mensaje)){
                                $mensaje = "";
                            }

                            $onclick = "swal('En este paso se le muestra como esta el estado de su admisión a esta carrera ')";
                            if ($row_data['codigosituacioncarreraestudiante'] == 106) {
                                if ($row_cobroInscripcion["codigoindicadorcobroinscripcioncarrera"] == "200" || $row_serPiloPaga["idtipoestudianterecursofinanciero"] == "13") {
                                    $semaforo = "color:orange;";
                                    $icono = "fa-exclamation-circle fa-2x";
                                    $onclick = "swal('Actualmente se encuentra inscrito sin pago, por ende se encuentra en proceso de admisión $mensaje')";
                                } else {
                                    $semaforo = "color:red;";
                                    $icono = "fa-times-circle fa-2x";
                                    $onclick = "swal('Actualmente se encuentra preinscrito, por ende no ha iniciado su proceso de admisión $mensaje')";
                                }
                            } else if ($row_data['codigosituacioncarreraestudiante'] == 107) {
                                $semaforo = "color:orange;";
                                $icono = "fa-exclamation-circle fa-2x";
                                $onclick = "swal('Actualmente se encuentra inscrito, por ende se encuentra en proceso de admisión $mensaje')";
                            } else if ($row_data['codigosituacioncarreraestudiante'] == 111) {
                                $semaforo = "color:orange;";
                                $icono = "fa-exclamation-circle fa-2x";
                                $onclick = "swal('Actualmente se encuentra inscrito sin pago, por ende se encuentra en proceso de admisión $mensaje')";
                            } else if (($row_data['codigosituacioncarreraestudiante'] == 300) || ($row_data['estudiantecodigosituacioncarrera'] == 300)) {
                                $semaforo = "color:green;";
                                $icono = "fa-check-circle fa-2x";
                                $onclick = "swal('Actualmente se encuentra admitido, por ende ha finalizado su proceso de admisión $mensaje')";
                            } else {
                                $semaforo = "color:orange;";
                                $icono = "fa-exclamation-circle fa-2x";
                            }
                            ?>
                            <p>
                            <i class="fa <?php echo $icono; ?>" style="<?php echo $semaforo ?>"></i>
                            <a href="#" class="link-semaforo" style="cursor:pointer" onClick="<?php echo $onclick ?>">Selección - Admisión</a>
                            </p>
                            <?php
                            // Valida si el estudiante ya genero orden de pago por formulario
                            $query_selordenpago = "select o.numeroordenpago, o.codigoestadoordenpago ".
                            " from ordenpago o, concepto c, detalleordenpago do ".
                            " where o.codigoestudiante = '" . $row_data['codigoestudiante'] . "' ".
                            " and o.codigoperiodo = '" . $row_data['codigoperiodo'] . "' ".
                            " and c.cuentaoperacionprincipal = '151' ".
                            " and c.codigoconcepto = do.codigoconcepto ".
                            " and do.numeroordenpago = o.numeroordenpago ".
                            " and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago ".
                            " like '4%' or o.codigoestadoordenpago like '6%')";
                            $selordenpago = $db->Execute($query_selordenpago);
                            $totalRows_selordenpago = $selordenpago->RecordCount();
                            $row_selordenpago = $selordenpago->FetchRow();
                            if ($totalRows_selordenpago == "") {
                                $semaforo = "color:red;";
                                $icono = "fa-times-circle fa-2x";
                            } else {
                                if (ereg("^4.+$", $row_selordenpago['codigoestadoordenpago'])) {
                                    $semaforo = "color:green;";
                                    $icono = "fa-check-circle fa-2x";
                                    $pasossiguientes = true;
                                } else {
                                    $semaforo = "color:orange;";
                                    $icono = "fa-exclamation-circle fa-2x";
                                }
                            }
                            if (($row_data['codigosituacioncarreraestudiante'] == 300)
                                || ($row_data['estudiantecodigosituacioncarrera'] == 300)){
                                $onclick = "window.location.href='../serviciosacademicos/consulta/prematricula/inscripcionestudiante/pagoderechosmatricula.php?documentoingreso=$numerodocumento&codigoestudiante=" . $row_data['codigoestudiante'] . "&codigoperiodo=" . $row_data['codigoperiodo'] . "&menuprincipal'";
                            }else{
                                $onclick = "swal('Usted no se encuentra en el momento admitido para poder ingresar')";
                            }
                            ?>
                            <p>
                                <i class="fa <?php echo $icono; ?>" style="<?php echo $semaforo ?>"></i>
                                <a href="#" class="link-semaforo" style="cursor:pointer"
                                   onClick="<?php echo $onclick; ?>">Matrícula</a>
                            </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>Descripcion de estados:</h4>
                        <i class="fa fa-times-circle fa-2x" aria-hidden="true" style="color:red;"></i> No Iniciado &ensp;
                        <i class="fa fa-exclamation-circle fa-2x" aria-hidden="true" style="color:orange;"></i>  En Proceso &ensp;
                        <i class="fa fa-check-circle fa-2x" aria-hidden="true" style="color:green;"></i> Finalizado
                    </td>
                </tr>
                <?php
                //Esta seccion solo aplica para usuarios administrativos a estudiantes en pregrado o educacion continuada
                if(isset($_SESSION['codigotipousuario']) && $_SESSION['codigotipousuario'] == '400'
                    && $row_data['codigomodalidadacademica'] == '200'
                    || $row_data['codigomodalidadacademica'] == '800') {

                    $sqlconvenios = "select idconvenioinscripcion, NombreConvenio from convenioinscripcion ".
                    " where codigoestado= 100";
                    $convenios = $db->GetAll($sqlconvenios);

                    $sqlconsulta = "select idconvenioinscripcion from logconvenioinscripcion where codigoestudiante ='".$row_data['codigoestudiante']."' ".
                    " and codigoestado = 100";
                    $idlog = $db->GetRow($sqlconsulta);

                    ?>
                    <tr>
                        <td>
                            <h4>Asignacion de convenio:</h4>
                            <p>Esta asignacion es para aquellos estudiantes asociados a proyectos o convenios</p>
                            <div class="row">
                            <select class="form-control" id="idconvenio" name="idconvenio">
                                <option>Seleecionar</option>
                                <?php
                                foreach($convenios as $convenio){
                                    if($idlog['idconvenioinscripcion'] == $convenio['idconvenioinscripcion']){
                                        echo "<option id='".$convenio['idconvenioinscripcion']."' selected='selected'>".$convenio['NombreConvenio']."</option>";
                                    }else{
                                        echo "<option id='".$convenio['idconvenioinscripcion']."' >".$convenio['NombreConvenio']."</option>";
                                    }
                                }
                                ?>
                            </select>
                            </div>
                            <button class="btn btn-fill-green-XL" type="submit" id="convenioinscrip_btn">Asignar</button>

                        </td>
                    </tr>
                    <?php
                }?>
                <tr>
                <?php
                } else {
                        ?>
                        <enter>
                        <table class="table">
                            <tr>
                                <td>
                                    <center>Señor(a) aspirante:<br>Las inscripciones al Programa de <strong>
                                    <?php echo $row_data['nombrecarrera']; ?></strong>  para el periodo <strong>
                                    <?php echo $codigoperiodo; ?></strong>,
                                    ya se encuentran cerradas.<br> Para mayor información comuníquese con
                                    el área de Atención al Usuario 6489000 Ext 1170, 1511. </center>
                                </td>
                            </tr>
                        </table>
                        </enter>
                        <?php
                    }//else
                } else {
                    ?>
                    <enter>
                        <table class="table" >
                            <tr>
                                <td width="10%">
                                    <center>Señor(a) aspirante:<br>Debe seleccionar uno de los Programas
                                    para ver los detalles. </center>
                                </td>
                            </tr>
                        </table>
                        </enter>
                        <?php
                        }
                        if ($_SESSION['MM_Username'] == "" || $_SESSION['MM_Username'] == "estudiante") {
                            ?>
                            <tr>
                                <td width="10%"><br><br>
                                <button type="button" class="btn btn-fill-green-XL"
                                        onclick="location.href = '../aspirantes/admisiones/logout.php'">Salir</button>
                                </td>
                            </tr>
                            <?php
                        } ?>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>