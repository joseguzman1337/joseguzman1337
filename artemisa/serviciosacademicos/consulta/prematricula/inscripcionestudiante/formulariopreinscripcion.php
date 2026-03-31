<?php
require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
Factory::validateSession($variables);

$pos = strpos($Configuration->getEntorno(), "local");
if ($Configuration->getEntorno() == "local" ||
    $Configuration->getEntorno() == "pruebas" ||
    $pos !== false) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once(PATH_ROOT . '/kint/Kint.class.php');
}

@$GLOBALS['sesionmodulos'];
@$GLOBALS['numerodocumentosesion'];
@$GLOBALS['modalidadacademicasesion'];
@$GLOBALS['inscripcionsession'];
@$GLOBALS['study'];

unset($_SESSION["numerodocumentosesion"]);
unset($_SESSION["modalidadacademicasesion"]);
unset($_SESSION["sesionmodulos"]);
unset($_SESSION["inscripcionsession"]);
unset($_SESSION["study"]);

if (!isset($_REQUEST['referred'])) {
    if ((!isset($_SESSION['inscripcionactiva']) ||
            trim($_SESSION['inscripcionactiva']) == '' ||
            trim($_SESSION['inscripcionactiva']) == 0) && ((!isset($_SESSION['MM_Username'])) ||
            ($_SESSION['MM_Username'] == ''))) {
        die;
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=" . HTTP_ROOT . "/aspirantes/aspirantessec.php'>";
    }
}

include('../../../Connections/sala2.php');
$sala2 = $sala;
$ruta = "../../../funciones/";
$rutaorden = "../../../funciones/ordenpago/";
require_once($rutaorden . 'claseordenpago.php');
require_once('../../../funciones/funcionip.php');

include("calendario/calendario.php");
include("../../../funciones/funcionpassword.php");
include("../../../funciones/enviamail.php");
$codigoinscripcion = "";

if (@$_POST['study'] == "antiguo") {
    $_SESSION['study'] = 'antiguo';
}

if (isset($_GET['documentoingreso']) && !empty($_GET['documentoingreso'])) {
    $_POST['numerodocumento'] = $_GET['documentoingreso'];
    $documentoingreso = $_GET['documentoingreso'];

    //consulta los programas a los cuales esta en proceso de inscripcion y admision
    $query_seldocumentos = "SELECT distinct "
        . "eg.idestudiantegeneral, est.codigoestudiante, "
        . "concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, "
        . "c.nombrecarrera, c.codigocarrera, "
        . "c.codigomodalidadacademica, est.codigoestudiante, "
        . "eg.numerodocumento, est.codigoperiodo "
        . "FROM estudiante est, estudiantegeneral eg, "
        . "estudiantedocumento ed, carrera c, periodo p "
        . "WHERE eg.numerodocumento = " . $db->qstr($documentoingreso) . " "
        . "and eg.idestudiantegeneral = est.idestudiantegeneral "
        . "and ed.idestudiantegeneral = eg.idestudiantegeneral 	"
        . "and c.codigocarrera = est.codigocarrera "
        . "AND ed.fechavencimientoestudiantedocumento > NOW()"
        ." and p.codigoperiodo = est.codigoperiodo  "
        ." and (p.codigoestadoperiodo = 1 or p.codigoestadoperiodo = 4)"
        ." ORDER BY 3, est.codigoperiodo";
    $seldocumentos = $db->GetAll($query_seldocumentos);
    $carrerasenproceso = $seldocumentos;
    $totalRows_seldocumentos = count($seldocumentos);

    if (empty($totalRows_seldocumentos) || $totalRows_seldocumentos == 0) {
        $query_seldocumentos = "SELECT distinct "
            . "eg.idestudiantegeneral, est.codigoestudiante, "
            . "concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, "
            . "c.nombrecarrera, c.codigocarrera, est.codigoestudiante, "
            . "eg.numerodocumento, c.codigomodalidadacademica, est.codigoperiodo "
            . "FROM estudiante est,  "
            . "estudiantegeneral eg, "
            . "carrera c "
            . "WHERE eg.numerodocumento = " . $db->qstr($documentoingreso) . " "
            . "and eg.idestudiantegeneral = est.idestudiantegeneral "
            . "and c.codigocarrera = est.codigocarrera 	"
            . "ORDER BY 3, est.codigoperiodo";
        $seldocumentos = $db->GetAll($query_seldocumentos);
        $totalRows_seldocumentos = count($seldocumentos);

        if ($totalRows_seldocumentos == "") {
            $query_seldocumentos = "SELECT distinct "
                . "eg.idestudiantegeneral, "
                . "concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, "
                . "eg.numerodocumento "
                . "FROM estudiantegeneral eg "
                . "WHERE eg.numerodocumento = " . $db->qstr($documentoingreso) . " ORDER BY 3";
            $seldocumentos = $db->GetAll($query_seldocumentos);
            $totalRows_seldocumentos = count($seldocumentos);
        }
    }//if
    $respuesta = $seldocumentos;

    if (!empty($respuesta)) {
        $_SESSION['numerodocumentosesion'] = $respuesta['0']['numerodocumento'];
        $codigoinscripcion = $_SESSION['numerodocumentosesion'];
        if(!isset($_GET['menuprincipal']) && !empty($carrerasenproceso)) {
            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;  
            URL=../../../../aspirantes/enlineacentral.php?documentoingreso=" . $documentoingreso."'>";
        }
    } else {
        $_SESSION['numerodocumentosesion'] = $_GET['documentoingreso'];
        $codigoinscripcion = $_SESSION['numerodocumentosesion'];
    }

    if (!isset($_GET['logincorrecto']) && !isset($_GET['eliminar']) &&
        $_SESSION['MM_Username'] == "estudiante" && empty($totalRows_seldocumentos)) {
        ?>
        <script language="javascript">
            swal("Usted ya se encuentra registrado en el sistema, ingrese desde el portal de aspirantes digitando su documento y su contrasena", "warning");
            history.go(-2);
        </script>
        <?php
    }
} else if ($_SESSION['numerodocumentosesion'] <> "") {
    $codigoinscripcion = $_SESSION['numerodocumentosesion'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Inscripciones</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <?php
    echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/bootstrap.css");
    echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/bootstrap.min.css");
    echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/font-awesome.css");
    echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/custom.css");
    echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/general.css");
    echo Factory::printImportJsCss("css", HTTP_ROOT . "/sala/assets/css/loader.css");
    echo Factory::printImportJsCss("css", HTTP_ROOT . "/sala/assets/css/CenterRadarIndicator/centerIndicator.css");
    echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/sweetalert.css");
    echo Factory::printImportJsCss("css", HTTP_ROOT . "/serviciosacademicos/estilos/sala.css");

    echo Factory::printImportJsCss("js", HTTP_ROOT . "/assets/js/sweetalert.min.js");
    echo Factory::printImportJsCss("js", HTTP_ROOT . "/sala/assets/js/jquery-3.1.1.js");
    echo Factory::printImportJsCss("js", HTTP_ROOT . "/sala/assets/js/spiceLoading/pace.min.js");
    echo Factory::printImportJsCss("js", HTTP_ROOT . "/sala/assets/js/bootstrap.min.js");
    echo Factory::printImportJsCss("js", HTTP_ROOT . "/sala/assets/js/bootstrap.js");
    ?>
    <script type="text/javascript" src="../../../funciones/sala/js/overlib/overlib.js"></script>
    <script type="text/javascript" src="js/preinscripcion.js"></script>
    <script language="JavaScript" src="calendario/javascripts.js"></script>
    <script language="javascript">
        function enviar() {
            document.inscripcion.submit();
        }
    </script>
</head>
<body>
<?php

$query_selgenero = "select codigogenero, nombregenero from genero";
$row_selgenero = $db->GetAll($query_selgenero);
$totalRows_selgenero = count($row_selgenero);

$query_trato = "select idtrato, inicialestrato, nombretrato from trato";
$row_trato = $db->GetAll($query_trato);
$totalRows_trato = count($row_trato);

$query_documentos = "SELECT tipodocumento, nombredocumento, nombrecortodocumento, "
    . "tipodocumentosap, codigoestado FROM documento where codigoestado like '1%'";
$row_documentos = $db->GetAll($query_documentos);
$documentos = $row_documentos;
$totalRows_documentos = count($row_documentos);

//********************************* tipo usuario **////////////////////////////////////////////////////////
$usuario = $_SESSION['MM_Username'];

$slqrol = "SELECT rol.idrol FROM usuario u  " .
    " INNER JOIN UsuarioTipo ut on ut.UsuarioId = u.idusuario " .
    " INNER JOIN usuariorol rol on rol.idusuariotipo = ut.UsuarioTipoId  " .
    " WHERE u.usuario = '" . $usuario . "'";
$RolData = $db->GetRow($slqrol);
$Rol = $RolData['idrol'];

//consulta las carreras asosciadas al usuario
$query_tipousuario = "SELECT idusuario, usuario, codigofacultad, "
    . "codigotipousuariofacultad, emailusuariofacultad, codigoestado FROM  "
    . "usuariofacultad where usuario = " . $db->qstr($usuario) . " and codigotipousuariofacultad= 200 " .
    " GROUP BY codigotipousuariofacultad";
$row_tipousuario = $db->GetRow($query_tipousuario);

$query_tipousuario = "SELECT idusuario FROM usuario where usuario = " . $db->qstr($usuario) . " ";
$row_usuario = $db->GetRow($query_tipousuario);
$idusuario = $row_usuario["idusuario"];

/* Si viene de educacion continuada solamente carga la modalidad de educacion continuada */
if (isset($_REQUEST['referred']) && $_REQUEST['referred'] == 'educontinuada') {
    $where = " and codigomodalidadacademica = 400";
} else {
    $where = "";
}
$query_modalidad = "SELECT codigomodalidadacademica, nombremodalidadacademica, codigoestado, " .
    " pesomodalidadacademica FROM modalidadacademica where codigoestado = 100 " .
    " AND codigomodalidadacademica not in (500, 501, 502, 503, 506, 507, 100, 1, 700 ) " . $where . " order by 1";
$row_modalidad = $db->GetAll($query_modalidad);
$totalRows_modalidad = count($row_modalidad);

$existe = false;
$query_estudiante = "SELECT eg.idestudiantegeneral, eg.numerodocumento, eg.idtrato, " .
    " eg.nombresestudiantegeneral, eg.apellidosestudiantegeneral, eg.tipodocumento, " .
    " eg.expedidodocumento, eg.fechanacimientoestudiantegeneral, eg.codigogenero, " .
    " d.iddepartamento, eg.idciudadnacimiento, eg.ciudadresidenciaestudiantegeneral, " .
    " eg.direccionresidenciaestudiantegeneral, eg.telefonoresidenciaestudiantegeneral, eg.emailestudiantegeneral, " .
    " eg.telefono2estudiantegeneral, eg.celularestudiantegeneral, ev.FechaExpedicion fechaexpedicionvisa, ".
    " ev.FechaVencimiento fechavencimientovisa " .
    " FROM estudiantegeneral eg " .
    " INNER JOIN ciudad c ON (c.idciudad = eg.idciudadnacimiento) " .
    " INNER JOIN departamento d ON (d.iddepartamento = c.iddepartamento) " .
    " LEFT JOIN EstudianteVisa ev ON (ev.idestudiantegeneral = eg.idestudiantegeneral ) " .
    " WHERE numerodocumento = " . $db->qstr($codigoinscripcion) . " and eg.codigoestado = 100 ";
$row_estudiante = $db->GetRow($query_estudiante);
$totalRows_estudiante = count($row_estudiante);

if (isset($row_estudiante['idestudiantegeneral']) && !empty($row_estudiante['idestudiantegeneral'])) {
    $existe = true;
}

if (isset($_GET['idpreinscripcion']) && empty($row_estudiante['idestudiantegeneral'])) {
    $_POST['especializacion'] = $_GET['especializacion'];

    //se optiene el resultado de la carrera y el periodo
    $carrerainscripcion = explode('-', $_POST['especializacion']);

    //se asigna el resultados a las variables tipo post
    $_POST['periodo'] = preg_replace('([^0-9])', '', $carrerainscripcion['1']);
    $_POST['carrerainscripcion'] = preg_replace('([^0-9])', '', $carrerainscripcion['0']);

    // Inicializar los campos POST con los datos de inscripciÃ³n
    $query_inscripcion = "SELECT * FROM preinscripcion pe,preinscripcioncarrera pc,carrera c "
        . "WHERE pe.idpreinscripcion = " . $db->qstr($_GET['idpreinscripcion']) . " "
        . "AND pc.codigocarrera = c.codigocarrera "
        . "AND c.codigocarrera = " . $db->qstr($_POST['carrerainscripcion']) . " "
        . "AND pe.idpreinscripcion=pc.idpreinscripcion "
        . "AND pe.codigoestado like '1%' and pc.codigoestado like '1%'";
    $inscripcion = $db->Execute($query_inscripcion);
    $totalRows_inscripcion = $inscripcion->RecordCount();
    $row_inscripcion = $inscripcion->FetchRow();

    if ($totalRows_inscripcion == "") {
        $query_inscripcion = "SELECT * "
            . " FROM preinscripcion pe,preinscripcioncarrera pc,carrera c "
            . " WHERE pe.idpreinscripcion = " . $db->qstr($_GET['idpreinscripcion']) . " "
            . " AND pc.codigocarrera = c.codigocarrera "
            . " AND pe.idpreinscripcion=pc.idpreinscripcion "
            . " AND pe.codigoestado like '1%' "
            . " AND pc.codigoestado like '1%'";
        $inscripcion = $db->Execute($query_inscripcion);
        $totalRows_inscripcion = $inscripcion->RecordCount();
        $rowinscripcion = $inscripcion->FetchRow();
    }

    $_POST['trato'] = $row_inscripcion['idtrato'];
    $_POST['nombres'] = $row_inscripcion['nombresestudiante'];
    $_POST['apellidos'] = $row_inscripcion['apellidosestudiante'];
    $_POST['tipodocumento'] = $row_inscripcion['tipodocumento'];
    $_POST['numerodocumento'] = $row_inscripcion['numerodocumento'];
    $_POST['expedidodocumento'] = $row_inscripcion['expedidodocumento'];
    $_POST['telefono'] = $row_inscripcion['telefonoestudiante'];
    $_POST['email'] = $row_inscripcion['emailestudiante'];

    if ($_POST['nombres'] == "") {
        echo '<script language="JavaScript">swal("El nombre es requerido");</script>';
        $banderagrabar = 1;
    } else if ($_POST['apellidos'] == "") {
        echo '<script language="JavaScript">swal("El apellido es requerido");</script>';
        $banderagrabar = 1;
    } else if ($_POST['telefono'] == "") {
        echo '<script language="JavaScript">swal("El nÃºmero telefonico es requerido");</script>';
        $banderagrabar = 1;
    } else if ($_POST['email'] == "") {
        echo '<script language="JavaScript">swal("El correo es requerido");</script>';
        $banderagrabar = 1;
    } else if ($_POST['trato'] == 0) {
        echo '<script language="JavaScript">swal("El trato es requerido");</script>';
        $banderagrabar = 1;
    } else if ($_POST['tipodocumento'] == 0) {
        echo '<script language="JavaScript">swal("El tipo de documento es requerido");</script>';
        $banderagrabar = 1;
    } else if ($_POST['expedidodocumento'] == "" && $_POST['estados'] == 400) {
        echo '<script language="JavaScript">swal("El lugar de expedicion del documento es requerido");</script>';
        $banderagrabar = 1;
    } else if ($_POST['numerodocumento'] == 0 && $_POST['estados'] == 400) {
        echo '<script language="JavaScript">swal("El documento es requerido");</script>';
        $banderagrabar = 1;
    }

    if ($banderagrabar == 1) {
        ?>
        <script language="javascript">
            history.go(-1);
        </script>
        <?php
    }
}

if (isset($_POST['especializacion']) && !empty($_POST['especializacion'])) {
    //se optiene el resultado de la carrera y el periodo
    $carrerainscripcion = explode('-', $_POST['especializacion']);

    //se asigna el resultados a las variables tipo post
    $_POST['periodo'] = (!empty($carrerainscripcion['1'])) ? preg_replace('([^0-9])', '', $carrerainscripcion['1']) : null;
    $_POST['carrerainscripcion'] = (!empty($carrerainscripcion['0'])) ? preg_replace('([^0-9])', '', $carrerainscripcion['0']) : null;

    if (isset($row_estudiante['idestudiantegeneral']) && !empty($row_estudiante['idestudiantegeneral'])) {
        $query_nopermite = "SELECT * FROM inscripcion i "
            . "INNER JOIN estudiantecarrerainscripcion e ON (i.idinscripcion = e.idinscripcion)"
            . "WHERE e.codigocarrera = " . $db->qstr($_POST['carrerainscripcion']) . " "
            . "AND e.codigoestado = '100' "
            . "AND i.codigoperiodo = " . $db->qstr($_POST['periodo']) . " "
            . "AND e.idnumeroopcion = '1' "
            . "AND i.idestudiantegeneral = " . $db->qstr($row_estudiante['idestudiantegeneral']) . " ";

        $nopermite = $db->Execute($query_nopermite);
        $totalRows_nopermite = $nopermite->RecordCount();
        $row_nopermite = $nopermite->FetchRow();

        if ($row_nopermite <> "") {
            echo '<script language="JavaScript">swal("Error!", "Ya presenta preinscripción para esa carrera en este periodo", "warning"); history.go(-2);</script>';
            exit;
        }
    }
}

$query_periodo = "SELECT * FROM periodo p,carreraperiodo c "
    . "WHERE p.codigoperiodo = c.codigoperiodo "
    . "AND c.codigocarrera = " . $db->qstr(@$_POST['carrerainscripcion']) . " "
    . "AND p.codigoestadoperiodo = '1' ORDER BY p.codigoperiodo";
$row_periodo = $db->GetAll($query_periodo);
$totalRows_periodo = count($row_periodo);

if (isset($_GET['idpreinscripcion']) && empty($row_estudiante['idestudiantegeneral'])) {
    if (!isset($_POST['periodo'])) {
        $_POST['periodo'] == $row_periodo['codigoperiodo'];
    }
}

if (isset($_SESSION['inscripcionactiva']) && isset($_SESSION['MM_Username'])
    && ($_SESSION['MM_Username'] == 'estudiante')) { ?>
    <nav class="navbar">
        <a href="http://www.uelbosque.edu.co" title="Inicio" rel="home">
            <img src="<?php echo HTTP_ROOT ?>/aspirantes/admisiones/logo-uelbosque.png" width="180" alt="Inicio">
        </a>
    </nav>
<?php } ?>
<div class="container">
    <form name="inscripcion" method="post" action="">
        <?php
        //consulta de los programas academicos a los actuales esta inscrito el usuario
        $query_data = "SELECT eg.*, c.nombrecarrera, m.nombremodalidadacademica, " .
            " ci.nombreciudad, m.codigomodalidadacademica, i.idinscripcion, " .
            " s.nombresituacioncarreraestudiante, i.numeroinscripcion, " .
            " i.codigosituacioncarreraestudiante, i.codigoperiodo, " .
            " c.codigoindicadorcobroinscripcioncarrera, c.codigoindicadorprocesoadmisioncarrera, " .
            " ec.codigocarrera, ec.codigoestudiante " .
            " FROM estudiantegeneral eg " .
            " INNER JOIN inscripcion i ON (eg.idestudiantegeneral = i.idestudiantegeneral) " .
            " INNER JOIN estudiantecarrerainscripcion e ON (i.idinscripcion = e.idinscripcion) " .
            " INNER JOIN carrera c ON (e.codigocarrera = c.codigocarrera) " .
            " INNER JOIN modalidadacademica m ON ( m.codigomodalidadacademica = i.codigomodalidadacademica) " .
            " INNER JOIN situacioncarreraestudiante s ON (i.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante) " .
            " INNER JOIN ciudad ci ON (eg.idciudadnacimiento = ci.idciudad) " .
            " INNER JOIN estudiante ec ON (ec.idestudiantegeneral = eg.idestudiantegeneral AND ec.codigocarrera = e.codigocarrera) " .
            " INNER JOIN periodo p ON ( i.codigoperiodo = p.codigoperiodo) " .
            " WHERE numerodocumento = " . $db->qstr($codigoinscripcion) . " " .
            " AND i.codigoestado = '100' AND e.idnumeroopcion = '1' " .
            " AND ( p.codigoestadoperiodo = '1' OR p.codigoestadoperiodo = '4' ) ORDER BY i.codigoperiodo";
        $row_data = $db->GetAll($query_data);
        $totalRows_data = count($row_data);

        if ($totalRows_data > 0) {
            $idestudiantegeneral = $row_data['0']['idestudiantegeneral'];
            if (!isset($_SESSION['codigocarrerasesion']) || empty($_SESSION['codigocarrerasesion'])) {
                $_SESSION['codigocarrerasesion'] = $row_data['0']['codigocarrera'];
            }
        }

        //********************************* tipo usuario **////////////////////////////////////////////////////////
        $usuario = $_SESSION['MM_Username'];
        $query_tipousuario = "SELECT * FROM usuariofacultad where usuario = " . $db->qstr($usuario) . " ";
        $row_stipousuario = $db->GetAll($query_tipousuario);
        $totalRows_tipousuario = count($row_stipousuario);

        if ($totalRows_data > 0) {
            ?>
            <a href="../../../../aspirantes/enlineacentral.php?documentoingreso=<?php
            echo $documentoingreso . "&codigocarrera=" . $_SESSION['codigocarrerasesion'] . ""; ?>" id="aparencialinknaranja">Inicio</a>
            <?php
        } else {
            if ($_SESSION['MM_Username'] == "estudiante") {
                ?>
                <a href="../../../../aspirantes/enlineacentral.php" id="aparencialinknaranja"
                   target="_top">Inicio</a><br><br>
                <?php
            }
        }//else
        ?>
        <table class="table table-bordered">
            <tr id="trtituloNaranjaInst" class="text-center">
                <td colspan="7">INFORMACI&Oacute;N PERSONAL</td>
            </tr>
            <tr>
                <td id="tdtitulogris">
                    <select class="form-control" name="trato" <?php
                    if (isset($row_estudiante['idestudiantegeneral']) && !empty($row_estudiante['idestudiantegeneral'])) {
                        echo "";
                    }
                    ?> id="habilita">
                        <option value="0" <?php
                        if(isset($_POST['trato'])) {
                            if (!(strcmp("0", $_POST['trato']))) {
                                echo "SELECTED";
                            }
                        }
                        ?>>Trato
                        </option>
                        <?php
                        foreach ($row_trato as $trato) {
                            if (isset($_POST['trato']) && $trato['idtrato'] == $_POST['trato']) {
                                ?>
                                <option value="<?php echo $trato['idtrato']; ?>"
                                <?php echo "SELECTED"; ?>><?php echo $trato['inicialestrato']; ?></option><?php
                            } else {
                                if (isset($row_estudiante['idtrato']) && !empty($row_estudiante['idtrato'])) {
                                    if ($trato['idtrato'] == $row_estudiante['idtrato']) {
                                        ?>
                                        <option value="<?php echo $trato['idtrato']; ?>"
                                        <?php echo "SELECTED"; ?>><?php echo $trato['inicialestrato']; ?></option><?php
                                    }
                                } else {
                                    ?>
                                <option value="<?php echo $trato['idtrato']; ?>">
                                    <?php echo $trato['inicialestrato']; ?></option><?php
                                }
                            }
                        }//foreach
                        ?>
                    </select>&nbsp;
                    <label id="labelresaltado">*</label>
                </td>
                <?php
                $acum = '';
                if (isset($row_estudiante['numerodocumento']) && !empty($row_estudiante['numerodocumento'])) {
                    $querysituacionestudiantegeneral = "SELECT codigosituacioncarreraestudiante FROM estudiante e " .
                        " INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral " .
                        " WHERE eg.numerodocumento = " . $db->qstr($row_estudiante['numerodocumento']) . " ";
                    $row_selsituacionestudiantegeneral = $db->GetAll($querysituacionestudiantegeneral);
                    $totalRows_selsituacionestudiantegeneral = count($row_selsituacionestudiantegeneral);

                    if ($totalRows_selsituacionestudiantegeneral > 0) {
                        foreach ($row_selsituacionestudiantegeneral as $situacion) {
                            $acum .= $situacion['codigosituacioncarreraestudiante'] . ',';
                        }
                    }
                }
                $tacum = substr($acum, 0, -1);
                $arreglo = array($tacum);
                ?>
                <td id="tdtitulogris">Nombres <label id="labelresaltado">*</label></td>
                <td>
                    <?php
                    if ($Rol == 13) {
                        ?>
                        <input class="form-control" placeholder="Nombres" name="nombres" type="text" id="nombres"
                               size="20"
                               maxlength="50" value="<?php
                        if (isset($_POST['nombres']) && !empty($_POST['nombres'])) {
                            echo $_POST['nombres'];
                        } else {
                            if (isset($row_estudiante['nombresestudiantegeneral']) && !empty($row_estudiante['nombresestudiantegeneral'])) {
                                echo $row_estudiante['nombresestudiantegeneral'];
                            }
                        }
                        ?>"
                            <?php
                            if (isset($row_estudiante['idestudiantegeneral']) && !empty($row_estudiante['idestudiantegeneral'])) {
                                echo "readonly";
                            } else {
                                echo "onblur='javascript:this.value = this.value.toUpperCase();'";
                            }
                            ?>>
                        <?php
                    } else {
                        switch ($arreglo) {
                            default:
                                ?>
                                <input class="form-control" placeholder="Nombres" name="nombres" type="text"
                                       id="nombres" size="20" maxlength="50" value="<?php
                                if (isset($_POST['nombres']) && !empty($_POST['nombres'])) {
                                    echo $_POST['nombres'];
                                } else {
                                    if (isset($row_estudiante['nombresestudiantegeneral']) && !empty($row_estudiante['nombresestudiantegeneral'])) {
                                        echo $row_estudiante['nombresestudiantegeneral'];
                                    }
                                }
                                ?>"
                                    <?php
                                    if (isset($row_estudiante['idestudiantegeneral']) && !empty($row_estudiante['idestudiantegeneral'])) {
                                        echo "readonly";
                                    } else {
                                        echo "onblur='javascript:this.value = this.value.toUpperCase();'";
                                    }
                                    ?>>
                                <?php
                                break;
                            case in_array(400, $arreglo)://graduado
                                ?>
                                <input class="form-control" placeholder="Nombres" name="nombres1" type="text"
                                       id="nombres1" size="20" maxlength="50" value="<?php
                                if (isset($_POST['nombres']) && !empty($_POST['nombres'])) {
                                    echo $_POST['nombres'];
                                } else {
                                    if (isset($row_estudiante['nombresestudiantegeneral']) && !empty($row_estudiante['nombresestudiantegeneral'])) {
                                        echo $row_estudiante['nombresestudiantegeneral'];
                                    }
                                }
                                ?>" disabled>
                                <input name="nombres" type="hidden" id="nombres" size="20" maxlength="50" value="<?php
                            if (isset($_POST['nombres']) && !empty($_POST['nombres'])) {
                                echo $_POST['nombres'];
                            } else {
                                if (isset($row_estudiante['nombresestudiantegeneral']) && !empty($row_estudiante['nombresestudiantegeneral'])) {
                                    echo $row_estudiante['nombresestudiantegeneral'];
                                }
                            }
                            ?>"><?php
                                break;
                        }
                    }
                    ?>
                </td>
                <td id="tdtitulogris">Apellidos <label id="labelresaltado">*</label></td>
                <td colspan="3">
                    <?php
                    if ($Rol == 13) {
                        ?>
                        <input class="form-control" placeholder="Apellidos" name="apellidos" type="text" id="apellidos"
                               size="30" maxlength="50" value="<?php
                        if (isset($_POST['apellidos']) && !empty($_POST['apellidos'])) {
                            echo $_POST['apellidos'];
                        } else {
                            if (isset($row_estudiante['apellidosestudiantegeneral']) && !empty($row_estudiante['apellidosestudiantegeneral'])) {
                                echo $row_estudiante['apellidosestudiantegeneral'];
                            }
                        }
                        ?>"
                            <?php
                            if (isset($row_estudiante['idestudiantegeneral']) && !empty($row_estudiante['idestudiantegeneral'])) {
                                echo "readonly";
                            } else {
                                echo "onblur='javascript:this.value = this.value.toUpperCase();'";
                            }
                            ?>>
                        <?php
                    } else {
                        switch ($arreglo) {
                            default:
                                ?>
                                <input class="form-control" placeholder="Apellidos" name="apellidos" type="text"
                                       id="apellidos" size="30" maxlength="50" value="<?php
                                if (isset($_POST['apellidos']) && !empty($_POST['apellidos'])) {
                                    echo $_POST['apellidos'];
                                } else {
                                    if (isset($row_estudiante['apellidosestudiantegeneral']) && !empty($row_estudiante['apellidosestudiantegeneral'])) {
                                        echo $row_estudiante['apellidosestudiantegeneral'];
                                    }
                                }
                                ?>"
                                    <?php
                                    if (isset($row_estudiante['idestudiantegeneral']) && !empty($row_estudiante['idestudiantegeneral'])) {
                                        echo "readonly";
                                    } else {
                                        echo "onblur='javascript:this.value = this.value.toUpperCase();'";
                                    }
                                    ?>>
                                <?php
                                break;
                            case in_array(400, $arreglo)://graduado
                                ?>
                                <input class="form-control" placeholder="Apellidos" name="apellidos1" type="text"
                                       id="apellidos1" size="30" maxlength="50" value="<?php
                                if (isset($_POST['apellidos']) && !empty($_POST['apellidos'])) {
                                    echo $_POST['apellidos'];
                                } else {
                                    if (isset($row_estudiante['apellidosestudiantegeneral']) && !empty($row_estudiante['apellidosestudiantegeneral']))
                                        echo $row_estudiante['apellidosestudiantegeneral'];
                                }
                                ?>" disabled>
                                <input name="apellidos" type="hidden" id="apellidos" size="30" maxlength="50"
                                       value="<?php
                                       if (isset($_POST['apellidos']) && !empty($_POST['apellidos'])) {
                                           echo $_POST['apellidos'];
                                       } else {
                                           if (isset($row_estudiante['apellidosestudiantegeneral']) && !empty($row_estudiante['apellidosestudiantegeneral'])) {
                                               echo $row_estudiante['apellidosestudiantegeneral'];
                                           }
                                       }
                                       ?>"><?php
                                break;
                        }
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" id="tdtitulogris">Tipo Documento<label id="labelresaltado">*</label>
                </td>
                <td>
                    <?php
                    if ($Rol == 13) {
                        ?>
                        <select class="form-control" name="tipodocumento" <?php
                        if (isset($row_estudiante['idestudiantegeneral']) && !empty($row_estudiante['idestudiantegeneral'])) {
                            echo "";
                        }
                        ?> id="habilita" onchange="getTipoDocumento(this.value)">
                            <?php
                            foreach ($row_documentos as $rdocumentos) {
                                if (isset($_POST['tipodocumento']) && $rdocumentos['tipodocumento'] == $_POST['tipodocumento']) {
                                    ?>
                                    <option value="<?php echo $rdocumentos['tipodocumento']; ?>"
                                    <?php echo "SELECTED"; ?>><?php echo $rdocumentos['nombredocumento']; ?></option><?php
                                } else {
                                    if (isset($row_estudiante['tipodocumento']) && !empty($row_estudiante['tipodocumento'])) {
                                        if ($rdocumentos['tipodocumento'] == $row_estudiante['tipodocumento']) {
                                            ?>
                                            <option value="<?php echo $rdocumentos['tipodocumento']; ?>"
                                            <?php echo "SELECTED"; ?>><?php echo $rdocumentos['nombredocumento']; ?></option><?php
                                        }
                                    } else {
                                        ?>
                                    <option value="<?php echo $rdocumentos['tipodocumento']; ?>">
                                        <?php echo $rdocumentos['nombredocumento']; ?></option><?php
                                    }
                                }
                            }
                            ?>
                        </select>
                        <?php
                    } else {
                        switch ($arreglo) {
                            default:
                                ?>
                                <select class="form-control" name="tipodocumento" <?php
                                if (isset($row_estudiante['tipodocumento']) && !empty($row_estudiante['tipodocumento'])) {
                                    echo "";
                                }
                                ?> id="habilita" onchange="getTipoDocumento(this.value)">
                                    <?php
                                    foreach ($row_documentos as $rdocumentos) {
                                        if (isset($_POST['tipodocumento']) && ($rdocumentos['tipodocumento'] == $_POST['tipodocumento'])) {
                                            ?>
                                            <option value="<?php echo $rdocumentos['tipodocumento']; ?>"
                                            <?php echo "SELECTED"; ?>><?php echo $rdocumentos['nombredocumento']; ?></option><?php
                                        } else {
                                            if (isset($row_estudiante['tipodocumento']) && !empty($row_estudiante['tipodocumento'])) {
                                                if ($rdocumentos['tipodocumento'] == $row_estudiante['tipodocumento']) {
                                                    ?>
                                                    <option value="<?php echo $rdocumentos['tipodocumento']; ?>"
                                                    <?php echo "SELECTED"; ?>><?php echo $rdocumentos['nombredocumento']; ?></option><?php
                                                }
                                            } else {
                                                ?>
                                            <option value="<?php echo $rdocumentos['tipodocumento']; ?>">
                                                <?php echo $rdocumentos['nombredocumento']; ?></option><?php
                                            }
                                        }
                                    }//foreach
                                    ?>
                                </select>
                                <?php
                                break;
                            case in_array(400, $arreglo)://graduado
                                ?>
                                <input class="form-control" name="tipodocumento1" type="text" id="tipodocumento1"
                                       size="30" maxlength="50" value="<?php
                                if (isset($_POST['tipodocumento']) && !empty($_POST['tipodocumento'])) {
                                    echo $_POST['tipodocumento'];
                                } else {
                                    foreach ($documentos as $row_documentos) {
                                        if (isset($row_estudiante['tipodocumento']) && !empty($row_estudiante['tipodocumento'])) {
                                            if ($row_documentos['tipodocumento'] == $row_estudiante['tipodocumento']) {
                                                echo $row_documentos['nombredocumento'];
                                            }
                                        }
                                    }
                                }
                                ?>" disabled>
                                <input name="tipodocumento" type="hidden" id="habilita" size="30" maxlength="50"
                                       value="<?php
                                       if (isset($_POST['tipodocumento']) && !empty($_POST['tipodocumento'])) {
                                           echo $_POST['tipodocumento'];
                                       } else {
                                           if (isset($row_estudiante['tipodocumento']) && !empty($row_estudiante['tipodocumento'])) {
                                               echo $row_estudiante['tipodocumento'];
                                           }
                                       }
                                       ?>"> <?php
                                break;
                        }
                    }
                    ?>
                </td>
                <td id="tdtitulogris">Documento<label id="labelresaltado">*</label>
                </td>
                <td>
                    <?php
                    if ($Rol == 13) {
                        ?>
                        <input class="form-control" placeholder="Numero documento"  name="numerodocumento"
                               type="text" id="numerodocumento" size="10" maxlength="12" value="<?php
                        if (isset($_POST['numerodocumento']) && !empty($_POST['numerodocumento'])) {
                            if (!$_POST['numerodocumento']) {
                                echo $documentoingreso;
                            } else {
                                echo $_POST['numerodocumento'];
                            }
                        } else {
                            if (isset($row_estudiante['numerodocumento']) && !empty($row_estudiante['numerodocumento'])) {
                                echo $row_estudiante['numerodocumento'];
                            }
                        }
                        ?>" <?php
                        if (isset($row_estudiante['numerodocumento']) && !empty($row_estudiante['numerodocumento'])) {
                            echo "readonly";
                        }
                        ?>><?php
                    } else {
                        switch ($arreglo) {
                            default:
                                ?>
                                <input class="form-control" placeholder="Numero documento" name="numerodocumento"
                                       type="text" id="numerodocumento" size="10" maxlength="12" value="<?php
                                if (isset($_POST['numerodocumento']) && !empty($_POST['numerodocumento'])) {
                                    if (!$_POST['numerodocumento']) {
                                        echo $documentoingreso;
                                    } else {
                                        echo $_POST['numerodocumento'];
                                    }
                                } else {
                                    if (isset($row_estudiante['numerodocumento']) && !empty($row_estudiante['numerodocumento'])) {
                                        echo $row_estudiante['numerodocumento'];
                                    }
                                }
                                ?>" <?php
                                if (isset($row_estudiante['numerodocumento']) && !empty($row_estudiante['numerodocumento'])) {
                                    echo "readonly";
                                }
                                ?>>
                                <?php
                                break;
                            case in_array(400, $arreglo)://graduado
                                ?>
                                <input class="form-control" placeholder="Numero documento" name="numerodocumento1"
                                       type="text" id="numerodocumento1" size="10" maxlength="12" value="<?php
                                if (isset($_POST['numerodocumento']) && !empty($_POST['numerodocumento'])) {
                                    if (!$_POST['numerodocumento']) {
                                        echo $documentoingreso;
                                    } else {
                                        echo $_POST['numerodocumento'];
                                    }
                                } else {
                                    if (isset($row_estudiante['numerodocumento']) && !empty($row_estudiante['numerodocumento'])) {
                                        echo $row_estudiante['numerodocumento'];
                                    }
                                }
                                ?>" disabled>
                                <input name="numerodocumento" type="hidden" id="numerodocumento" size="10"
                                       maxlength="12" value="<?php
                            if (isset($_POST['numerodocumento']) && !empty($_POST['numerodocumento'])) {
                                if (!$_POST['numerodocumento']) {
                                    echo $documentoingreso;
                                } else {
                                    echo $_POST['numerodocumento'];
                                }
                            } else {
                                if (isset($row_estudiante['numerodocumento']) && !empty($row_estudiante['numerodocumento'])) {
                                    echo $row_estudiante['numerodocumento'];
                                }
                            }
                            ?>"><?php
                                break;
                        }
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" id="tdtitulogris">Fecha Nacimiento<label id="labelresaltado">*</label>
                </td>
                <td>
                    <input class="form-control" name="fechanacimientoestudiantegeneral" type="date" size="10"
                           value="<?php
                           $date = "";
                           if (isset($_POST['fechanacimientoestudiantegeneral']) && !empty($_POST['fechanacimientoestudiantegeneral'])) {
                               $date = $_POST['fechanacimientoestudiantegeneral'];
                           } else {
                               if (isset($row_estudiante['fechanacimientoestudiantegeneral']) && !empty($row_estudiante['fechanacimientoestudiantegeneral'])) {
                                   $date = $row_estudiante['fechanacimientoestudiantegeneral'];
                               }
                           }

                           if (strlen($date) > 10) {
                               $date = substr($date, 0, -9);
                               echo $date;
                           } else {
                               if (!empty($date)) {
                                   echo $date;
                               }
                           }

                           ?>" maxlength="10"<?php
                    if (isset($row_estudiante['fechanacimientoestudiantegeneral']) && !empty($row_estudiante['fechanacimientoestudiantegeneral'])) {
                        echo "readonly";
                    } ?>>
                </td>
                <td colspan="1" id="tdtitulogris">G&eacute;nero<label id="labelresaltado">*</label>
                </td>
                <td colspan="3">
                        <span class="style2">
                            <select class="form-control" name="codigogenero" <?php
                            if (isset($row_estudiante['codigogenero']) && !empty($row_estudiante['codigogenero'])) {
                                echo "";
                            }
                            ?>>
                            <option value="0" <?php
                            if(isset($_POST['codigogenero'])) {
                                if (!(strcmp(0, $_POST['codigogenero']))) {
                                    echo "SELECTED";
                                }
                            }
                            ?>>Seleccionar</option>
                            <?php
                            foreach ($row_selgenero as $rgeneros) {
                                if (isset($_POST['codigogenero']) && $rgeneros['codigogenero'] == $_POST['codigogenero']) {
                                    ?>
                                    <option value="<?php echo $rgeneros['codigogenero']; ?>"
                                    <?php echo "SELECTED"; ?>><?php echo $rgeneros['nombregenero']; ?></option><?php
                                } else {
                                    if (isset($row_estudiante['codigogenero']) && !empty($row_estudiante['codigogenero'])) {
                                        if ($rgeneros['codigogenero'] == $row_estudiante['codigogenero']) {
                                            ?>
                                            <option value="<?php echo $rgeneros['codigogenero']; ?>"
                                            <?php echo "SELECTED"; ?>><?php echo $rgeneros['nombregenero']; ?></option><?php
                                        }
                                    } else {
                                        ?>
                                    <option value="<?php echo $rgeneros['codigogenero']; ?>">
                                        <?php echo $rgeneros['nombregenero']; ?></option><?php
                                    }
                                }
                            }//foreach
                            ?>
                            </select>
                        </span>
                </td>
            </tr>
            <?php
            if ($_SESSION['MM_Username'] == "estudiante2") {
                ?>
                <tr>
                    <td colspan="2" id="tdtitulogris">
                        Departamento Nacimiento
                        <span class="Estilo4">
                                        <label id="labelresaltado">*</label>
                                    </span>
                    </td>
                    <td id="tdtitulogris">
                        <?php
                        $query_dep_nacimiento = "select iddepartamento, nombrecortodepartamento, "
                            . "nombredepartamento, idpais, codigosapdepartamento, codigoestado, idregionnatural "
                            . "from departamento d where d.codigoestado = '100' and d.idpais = 1 order by 3";
                        $dep_nacimiento = $db->GetAll($query_dep_nacimiento);
                        $totalRows_dep_nacimiento = count($dep_nacimiento);
                        $row_dep_nacimiento = $dep_nacimiento;
                        ?>
                        <select class="form-control" name="dep_nacimiento" id="dep_nacimiento" onChange="enviar()">
                            <option value="0"<?php
                            if (!(strcmp("0", $_POST['dep_nacimiento']))) {
                                echo "SELECTED";
                            }
                            ?>> Seleccionar
                            </option>
                            <option value="Extranjero"<?php
                            if (!(strcmp("Extranjero", $_POST['dep_nacimiento']))) {
                                echo "SELECTED";
                            }
                            ?>>Extranjero
                            </option>
                            <?php
                            foreach ($dep_nacimiento as $row_dep_nacimiento) {
                                ?>
                                <option value="<?php echo $row_dep_nacimiento['iddepartamento'] ?>" <?php
                                if (!(strcmp($row_dep_nacimiento['iddepartamento'], $_POST['dep_nacimiento']))) {
                                    echo "SELECTED";
                                } else {
                                    if (isset($row_estudiante['iddepartamento']) && !empty($row_estudiante['iddepartamento'])) {
                                        if ($row_dep_nacimiento['iddepartamento'] == $row_estudiante['iddepartamento']) {
                                            echo "SELECTED";
                                        }
                                    }
                                }
                                ?>><?php echo $row_dep_nacimiento['nombredepartamento']; ?></option><?php
                            }
                            $rows = count($dep_nacimiento);
                            if ($rows > 0) {
                                $row_dep_nacimiento = $dep_nacimiento;
                            }
                            ?>
                        </select>
                    </td>
                    <td id="tdtitulogris">
                        Lugar Nacimiento<span class="Estilo4"><label id="labelresaltado">*</label></span>
                    </td>
                    <td colspan="3" id="tdtitulogris">
                        <span class="style2"></span>
                        <strong>
                                <span class="style2">
                                    <font size="2" face="Tahoma">
                                        <?php
                                        if ($_POST['dep_nacimiento'] == 'Extranjero') {
                                            $query_ciudad = "SELECT c.idciudad,c.nombreciudad FROM ciudad c,departamento d,pais p "
                                                . "WHERE d.iddepartamento = c.iddepartamento AND p.idpais = d.idpais AND p.idpais <> 1 ORDER BY 2";
                                            $ciudad = $db->GetAll($query_ciudad);
                                            $totalRows_ciudad = count($ciudad);
                                            $row_ciudad = $ciudad;
                                        } else {
                                            $query_ciudad = "select * from ciudad c where iddepartamento = " . $db->qstr($_POST['dep_nacimiento'])
                                                . " order by 3";
                                            $ciudad = $db->GetAll($query_ciudad);
                                            $totalRows_ciudad = count($ciudad);
                                            $row_ciudad = $ciudad;
                                        }
                                        ?>
                                        <select class="form-control" name="ciudadnacimiento" <?php
                                        if ($row_estudiante) {
                                            echo "";
                                        }
                                        ?> id="habilita">
                                            <option value="0"
                                            <?php
                                            if (!(strcmp("0", $_POST['ciudadnacimiento']))) {
                                                echo "SELECTED";
                                            }
                                            ?> >
                                                Seleccionar
                                            </option>
                                            <?php
                                            foreach ($ciudad as $row_ciudad) {
                                                ?>
                                                <option value="<?php echo $row_ciudad['idciudad'] ?>" <?php
                                                if (!(strcmp($row_ciudad['idciudad'], $_POST['ciudadnacimiento']))) {
                                                    echo "SELECTED";
                                                } else if ($row_ciudad['idciudad'] == $row_estudiante['idciudadnacimiento']) {
                                                    echo "SELECTED";
                                                }
                                                ?> >
                                                                    <?php echo $row_ciudad['nombreciudad']; ?>
                                                        </option>
                                                <?php
                                            }
                                            $rows = count($ciudad);
                                            if ($rows > 0) {
                                                $row_ciudad = $ciudad;
                                            }
                                            ?>
                                                </select>
                                            </font>
                                        </span>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" id="tdtitulogris">
                        Departamento Residencia<span class="Estilo4"><label id="labelresaltado">*</label></span>
                    </td>
                    <td id="tdtitulogris">
                        <?php
                        $query_dep_residencia = "select iddepartamento, nombrecortodepartamento, nombredepartamento, idpais, "
                            . " codigosapdepartamento, codigoestado, idregionnatural from  departamento d where d.codigoestado = '100' "
                            . " and d.idpais = 1 order by 3";
                        $dep_residencia = $db->GetAll($query_dep_residencia);
                        $totalRows_dep_residencia = count($dep_residencia);
                        $row_dep_residencia = $dep_residencia;
                        ?>
                        <select class="form-control" name="dep_residencia" <?php
                        if ($row_estudiante) {
                            echo "";
                        }
                        ?> id="dep_residencia" onChange="enviar()">
                            <option value="0"<?php
                            if (!(strcmp("0", $_POST['dep_residencia']))) {
                                echo "SELECTED";
                            }
                            ?>> Seleccionar
                            </option>
                            <option value="Extranjero"<?php
                            if (!(strcmp("Extranjero", $_POST['dep_residencia']))) {
                                echo "SELECTED";
                            }
                            ?>>Extranjero
                            </option>
                            <?php
                            foreach ($dep_residencia as $row_dep_residencia) {
                                ?>
                                <option value="<?php echo $row_dep_residencia['iddepartamento'] ?>" <?php
                                if (!(strcmp($row_dep_residencia['iddepartamento'], $_POST['dep_residencia']))) {
                                    echo "SELECTED";
                                } else if ($row_dep_residencia['iddepartamento'] == $row_estudiante['iddepartamento']) {
                                    echo "SELECTED";
                                }
                                ?>><?php echo $row_dep_residencia['nombredepartamento']; ?> </option>
                                <?php
                            }
                            $rows = count($dep_residencia);
                            if ($rows > 0) {
                                $row_dep_residencia = $dep_residencia;
                            }
                            ?>
                        </select>
                    </td>
                    <td id="tdtitulogris">
                        Ciudad Residencia<span class="Estilo4"><label id="labelresaltado">*</label></span>
                    </td>
                    <td colspan="3" id="tdtitulogris">
                        <?php
                        if ($_POST['dep_residencia'] == 'Extranjero') {
                            $query_ciudad_residencia = "SELECT c.idciudad,c.nombreciudad FROM ciudad c,departamento d,pais p WHERE "
                                . "d.iddepartamento = c.iddepartamento AND p.idpais = d.idpais AND p.idpais <> 1 ORDER BY 2";
                            $ciudad_residencia = $db->GetAll($query_ciudad_residencia);
                            $totalRows_ciudad_residencia = count($ciudad_residencia);
                            $row_ciudad_residencia = $ciudad_residencia;
                        } else {
                            $query_ciudad_residencia = "select * from ciudad c " .
                                " where iddepartamento = " . $db->qstr($_POST['dep_residencia']) . " order by 3";
                            $ciudad_residencia = $db->GetAll($query_ciudad_residencia);
                            $totalRows_ciudad_residencia = count($ciudad_residencia);
                            $row_ciudad_residencia = $ciudad_residencia;
                        }
                        ?>
                        <select class="form-control" name="ciudad" <?php
                        if ($row_estudiante) {
                            echo "";
                        }
                        ?> id="habilita">
                            <option value="0" <?php
                            if (!(strcmp("0", $_POST['ciudad']))) {
                                echo "SELECTED";
                            }
                            ?>>Seleccionar
                            </option>
                            <?php
                            foreach ($ciudad_residencia as $row_ciudad_residencia) {
                                ?>
                                <option value="<?php echo $row_ciudad_residencia['idciudad'] ?>" <?php
                                if (!(strcmp($row_ciudad_residencia['idciudad'], $_POST['ciudad']))) {
                                    echo "SELECTED";
                                } else if ($row_ciudad_residencia['idciudad'] == $row_estudiante['ciudadresidenciaestudiantegeneral']) {
                                    echo "SELECTED";
                                }
                                ?> >
                                    <?php echo $row_ciudad_residencia['nombreciudad']; ?>
                                </option>
                                <?php
                            }
                            $rows = count($ciudad_residencia);
                            if ($rows > 0) {
                                $row_ciudad_residencia = $ciudad_residencia;
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" id="tdtitulogris">
                        Direcc&oacute;n Residencia<span class="Estilo4"><label id="labelresaltado">*</label></span>
                    </td>
                    <td colspan="5" id="tdtitulogris">
                        <?php
                        if ($_SESSION['nuevadireccionlarga'] <> "") {
                            $_POST['direccion'] = $_SESSION['nuevadireccionlarga'];
                        }
                        ?>
                        <INPUT name="direccion" size="90" readonli onclick="window.open('direccion.php?preinscripcion=1',
                            'direccion', 'width=1000,height=300,left=150,top=150,scrollbars=yes')" value="<?php
                        if ($_POST['direccion']) {
                            echo $_POST['direccion'];
                        } else {
                            echo $row_estudiante['direccionresidenciaestudiantegeneral'];
                        }
                        ?>" <?php
                        if ($row_estudiante) {
                            echo "readonli";
                        }
                        ?>/>
                        <INPUT name="direccionoculta" value="<?php echo $_POST['direccionoculta']; ?>" type="hidden">
                        <a onClick="window.open('../../manualdireccion/direccion.htm', 'mensajes', 'width=700,height=700,left=300,top=500,scrollbars=yes')"
                           style="cursor: pointer"/>
                        <img src="../../../../imagenes/pregunta.gif" width="18" height="18" alt="Ayuda">
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="2" id="tdtitulogris">
                    Tel&eacute;fono Residencia
                    <label id="labelresaltado">*</label>
                </td>
                <td>
                    <input class="form-control" placeholder="Telefono" name="telefono" type="text" id="telefono"
                           value="<?php
                           if (isset($_POST['telefono']) && !empty($_POST['telefono'])) {
                               echo $_POST['telefono'];
                           } else {
                               if (isset($row_estudiante['telefonoresidenciaestudiantegeneral']) && !empty($row_estudiante['telefonoresidenciaestudiantegeneral'])) {
                                   echo $row_estudiante['telefonoresidenciaestudiantegeneral'];
                               }
                           }
                           ?>" size="10" maxlength="50" <?php
                    if ($row_estudiante) {
                        echo "readonly";
                    }
                    ?>/>
                </td>
                <td id="tdtitulogris">
                    E-mail
                    <label id="labelresaltado">*</label>
                </td>
                <td colspan="3">
                    <input class="form-control" placeholder="Email" name="email" type="email" id="email" size="50"
                           maxlength="50" value="<?php
                    if (isset($_POST['email']) && !empty($_POST['email'])) {
                        echo $_POST['email'];
                    } else {
                        if (isset($row_estudiante['emailestudiantegeneral']) && !empty($row_estudiante['emailestudiantegeneral'])) {
                            echo $row_estudiante['emailestudiantegeneral'];
                        }
                    }
                    ?>" <?php
                    if ($row_estudiante) {
                        echo "readonly";
                    }
                    ?>/>
                    <input name="correooculto" type="hidden"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" id="tdtitulogris">
                    Tel&eacute;fono Oficina
                </td>
                <td>
                    <input class="form-control" placeholder="Telefono Oficina" name="telefonooficina" type="text"
                           value="<?php
                           if (isset($_POST['telefonooficina']) && !empty($_POST['telefonooficina'])) {
                               echo $_POST['telefonooficina'];
                           } else {
                               if (isset($row_estudiante['telefono2estudiantegeneral']) && !empty($row_estudiante['telefono2estudiantegeneral'])) {
                                   echo $row_estudiante['telefono2estudiantegeneral'];
                               }
                           }
                           ?>" size="10" maxlength="50" <?php
                    if ($row_estudiante) {
                        echo "readonly";
                    }
                    ?>/>
                </td>
                <td id="tdtitulogris">
                    Celular
                </td>
                <td colspan="3">
                    <input class="form-control" placeholder="Celular" name="celular" type="text" size="10"
                           maxlength="50" value="<?php
                    if (isset($_POST['celular']) && !empty($_POST['celular'])) {
                        echo $_POST['celular'];
                    } else {
                        if (isset($row_estudiante['celularestudiantegeneral']) && !empty($row_estudiante['celularestudiantegeneral'])) {
                            echo $row_estudiante['celularestudiantegeneral'];
                        }
                    }
                    ?>" <?php
                    if ($row_estudiante) {
                        echo "readonly";
                    }
                    ?>/>
                </td>
            </tr>
        </table>
        <!-- INICIO ESTUDIANTE EXTRANJERO -->
        <?php
        if (empty($_POST['fechaexpedicionvisa']) && isset($row_estudiante['tipodocumento']) &&
            ($row_estudiante['tipodocumento'] == '01' || $row_estudiante['tipodocumento'] == '0' ||
                $row_estudiante['tipodocumento'] == '02' || $row_estudiante['tipodocumento'] == '04')) {
            $display = 'display:none';
        } else {
            $display = 'display:block';
        }
        ?>
        <table class="table table-bordered" id="table_extranjero" style="<?php echo $display; ?>">
            <tr id="trtituloNaranjaInst" class="text-center">
                <td colspan="6">ESTUDIANTE EXTRANJERO</td>
            </tr>
            <tr>
                <?php
                $SQL_PAIS = 'SELECT * FROM pais WHERE codigoestado = 100 ORDER BY nombrepais';
                $SQL_CATEGORIA = 'SELECT * FROM CategoriaVisa';
                $pais = $db->GetAll($SQL_PAIS);
                $categoria = $db->GetAll($SQL_CATEGORIA);
                ?>
                <td colspan="2" id="tdtitulogris">Nacionalidad</td>
                <td>
                    <select class="form-control" name="paisnacimiento">
                        <option value="0">Seleccione</option>
                        <?php foreach ($pais as $row_pais) { ?>
                            <option value="<?php echo $row_pais['idpais']; ?>" <?php echo (@$_POST['paisnacimiento'] == $row_pais['idpais']) ? 'selected' : ''; ?>><?php echo $row_pais['nombrepais']; ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td id="tdtitulogris">
                    Categor&iacute;a de Visa o Permiso de Ingreso
                </td>
                <td colspan="3">
                    <select class="form-control" name="categoriavisa">
                        <option value="0">Seleccione</option>
                        <?php foreach ($categoria as $row_categoria) { ?>
                            <option value="<?php echo $row_categoria['CategoriaVisaId']; ?>" <?php echo (@$_POST['categoriavisa'] == $row_categoria['CategoriaVisaId']) ? 'selected' : ''; ?>><?php echo $row_categoria['Nombre']; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" id="tdtitulogris">
                    Numero de visa o permiso
                </td>
                <td>
                    <input class="form-control" placeholder="Numero Visa" name="numerovisa" type="text"
                           size="10" value="<?php echo @$_POST['numerovisa'] ?>" maxlength="10"/>
                </td>
                <td id="tdtitulogris">
                </td>
                <td colspan="3">
                </td>
            </tr>
            <tr>
                <td colspan="2" id="tdtitulogris">
                    Fecha de expedici&oacute;n
                </td>
                <td>
                    <input class="form-control" name="fechaexpedicionvisa" type="date" size="10" value="<?php
                    if (isset($_POST['fechaexpedicionvisa']) && !empty($_POST['fechaexpedicionvisa'])) {
                        echo $_POST['fechaexpedicionvisa'];
                    } else {
                        if (isset($row_estudiante['fechaexpedicionvisa']) && !empty($row_estudiante['fechaexpedicionvisa'])) {
                            echo $row_estudiante['fechaexpedicionvisa'];
                        }
                    }
                    ?>" maxlength="10"<?php
                    if ($row_estudiante) {
                        echo "readonly";
                    }
                    ?>/>
                </td>
                <td id="tdtitulogris">
                    Fecha de vencimiento
                </td>
                <td colspan="3">
                    <input class="form-control" name="fechavencimientovisa" type="date" size="10" value="<?php
                    if (isset($_POST['fechavencimientovisa']) && !empty($_POST['fechavencimientovisa'])) {
                        echo $_POST['fechavencimientovisa'];
                    } else {
                        if (isset($row_estudiante['fechavencimientovisa']) && !empty($row_estudiante['fechavencimientovisa'])) {
                            echo $row_estudiante['fechavencimientovisa'];
                        }
                    }
                    ?>" maxlength="10"<?php
                    if ($row_estudiante) {
                        echo "readonly";
                    }
                    ?>/>
                </td>
            </tr>
        </table>
        <!-- FIN ESTUDIANTE EXTRANJERO -->
        <h5>Por favor aseg&uacute;rese de que el E-mail digitado sea el correcto,
            por este medio podra continuar con su proceso de Inscripci&oacute;n. </h5>
        <?php
        //Lista las INSCRIPCIONES REALIZADAS siempre y cuando los periodos esten en los estados 1 o 4 y el estado de vida del estudiante
        $query_data = "SELECT eg.*, c.nombrecarrera, m.nombremodalidadacademica, ci.nombreciudad, m.codigomodalidadacademica, 
            i.idinscripcion, s.nombresituacioncarreraestudiante, i.numeroinscripcion,i.codigosituacioncarreraestudiante,                                       
            c.codigoindicadorcobroinscripcioncarrera, c.codigoindicadorprocesoadmisioncarrera, ec.codigocarrera, 
            ec.codigoestudiante, ec.codigoperiodo 
            FROM estudiantegeneral eg 
            INNER JOIN inscripcion i ON (eg.idestudiantegeneral = i.idestudiantegeneral) 
            INNER JOIN estudiantecarrerainscripcion e ON (i.idinscripcion = e.idinscripcion) 
            INNER JOIN carrera c ON (e.codigocarrera = c.codigocarrera) 
            INNER JOIN modalidadacademica m ON (m.codigomodalidadacademica = c.codigomodalidadacademica) 
            INNER JOIN ciudad ci ON (eg.idciudadnacimiento = ci.idciudad) 
            INNER JOIN situacioncarreraestudiante s ON (i.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante)
            INNER JOIN estudiante ec ON (ec.idestudiantegeneral = eg.idestudiantegeneral)
            INNER JOIN periodo p ON (i.codigoperiodo = p.codigoperiodo)
            WHERE 
            numerodocumento = " . $db->qstr($_REQUEST['documentoingreso']) . " 
            AND i.codigoestado = '100' AND e.idnumeroopcion = '1'
            AND ec.codigosituacioncarreraestudiante <> '109'
            AND ec.codigocarrera = e.codigocarrera
            AND ( p.codigoestadoperiodo = '1' OR p.codigoestadoperiodo = '4' ) 
            AND ec.codigoperiodo IN (SELECT e.codigoperiodo FROM estudiante e 
            INNER JOIN periodo p ON e.codigoperiodo = p.codigoperiodo
            WHERE p.codigoestadoperiodo IN (1,4))
            GROUP BY ec.codigoestudiante ORDER BY ec.codigoperiodo desc";
        $row_data2 = $db->GetAll($query_data);
        $totalRows_data2 = count($row_data2);
        if ($totalRows_data2 > 0) {
            $idestudiantegeneral = $row_data2['0']['idestudiantegeneral'];
        if (!isset($_SESSION['codigocarrerasesion'])) {
            ?>
            <script language="javascript">
                window.location.href = "../../../../aspirantes/enlineacentral.php?documentoingreso=<?php echo $_REQUEST['documentoingreso']
                    . "&codigocarrera=" . $row_data2['0']['codigocarrera'] . "";  ?>";
            </script>
        <?php
        }
        ?>
            <table class="table table-bordered">
                <tr id="trtituloNaranjaInst" class="text-center">
                    <td colspan="4">
                        INSCRIPCIONES REALIZADAS
                    </td>
                </tr>
                <tr>
                    <td align="left" id="tdtitulogris">
                        Modalidad
                    </td>
                    <td align="left" id="tdtitulogris">
                        Programa Academico
                    </td>
                    <td align="left" id="tdtitulogris">
                        Estado
                    </td>
                    <td align="left" id="tdtitulogris">
                        Periodo
                    </td>
                </tr>
                <?php
                foreach ($row_data2 as $datos) {
                    ?>
                    <tr>
                        <td align="left">
                            <?php echo $datos['nombremodalidadacademica']; ?>
                        </td>
                        <td align="left">
                            <?php echo $datos['nombrecarrera']; ?>
                        </td>
                        <td align="left">
                            <?php echo $datos['nombresituacioncarreraestudiante']; ?>
                        </td>
                        <td align="left">
                            <?php echo $datos['codigoperiodo']; ?>
                        </td>
                    </tr>
                    <?php
                    $documento = $datos['numerodocumento'];
                }
                ?>
            </table>
            <br>
            <?php
        }
        //die;
        ?>
        <table class="table table-bordered" id="interna">
            <tr id="trtituloNaranjaInst" class="text-center">
                <td colspan="4">
                    PROGRAMAS DISPONIBLES PARA INSCRIPCION
                </td>
            </tr>
            <tr>
                <td id="tdtitulogris">Modalidad Acad&eacute;mica <label id="labelresaltado">*</label></td>
                <td>
                    <select class="form-control" name="modalidad" id="modalidad" onChange="enviar()">
                        <option value="0"<?php
                        if (!(strcmp("0", @$_POST['modalidad']))) {
                            echo "SELECTED";
                        }
                        ?>>Seleccionar
                        </option>
                        <?php
                        foreach ($row_modalidad as $modalidades) {
                            if ($modalidades['codigomodalidadacademica'] == @$_POST['modalidad']) {
                                ?>
                            <option value="<?php echo $modalidades['codigomodalidadacademica'] ?>" <?php echo "SELECTED"; ?> >
                                <?php echo $modalidades['nombremodalidadacademica'] ?></option><?php
                            } else {
                                ?>
                            <option value="<?php echo $modalidades['codigomodalidadacademica'] ?>">
                                <?php echo $modalidades['nombremodalidadacademica'] ?></option><?php
                            }
                        }
                        ?>
                    </select>
                </td>
                <td colspan="1" id="tdtitulogris">
                    <strong>Fecha&nbsp;&nbsp;</strong>
                    <?php echo date("j-n-Y g:i", time()); ?>
                    &nbsp;
                    <input name="hora" type="hidden" id="hora2" value="<?php echo time(); ?>">
                </td>
                <td>
                    <a onClick="window.open('../../manualpreinscripcion/preinscripcion.html', 'mensajes', 'width=700,height=700,left=300,top=500,scrollbars=yes')"
                       style="cursor: pointer"><img src="../../../../imagenes/pregunta.gif" alt="Ayuda"></a>
                </td>
            </tr>
            <tr>
                <td id="tdtitulogris">
                    Nombre del Programa<label id="labelresaltado">*</label>
                </td>
                <td colspan="3">
                    <?php
                    #obtiene el periodo que este en estado de inscripciones abiertas.
                    $periodoIncripcionQuery = "SELECT codigoperiodo FROM periodo where " .
                        " codigoestadoperiodo = '4' order by codigoperiodo asc";
                    $periodoIncripcion = $db->GetRow($periodoIncripcionQuery);

                    if (isset($periodoIncripcion['codigoperiodo']) && !empty($periodoIncripcion['codigoperiodo'])) {
                        $fecha = date("Y-m-d G:i:s", time());

                        if ("estudiante" == $_SESSION['MM_Username']) {
                            $queryCarrerasExistentes = " order by 1";
                            if (isset($idestudiantegeneral) && !empty($idestudiantegeneral)) {
                                $queryCarrerasExistentes = " and c.codigocarrera not in ( " .
                                    " select distinct eci.codigocarrera  " .
                                    " from estudiantecarrerainscripcion eci " .
                                    " INNER JOIN inscripcion i on (eci.idinscripcion = i.idinscripcion) " .
                                    " where eci.idestudiantegeneral = $idestudiantegeneral " .
                                    " and eci.codigoestado = 100 " .
                                    " and i.codigoperiodo = '" . $periodoIncripcion['codigoperiodo'] . "') order by 1 ";
                            }
                            if (isset($_POST['modalidad']) && !empty($_POST['modalidad'])) {

                                $query_car = "SELECT c.nombrecarrera, c.codigocarrera, cp.codigoperiodo " .
                                    " FROM carrera c, carreragrupofechainscripcion cf, carreraperiodo cp, " .
                                    " subperiodo sp where c.codigomodalidadacademica = " . $db->qstr($_POST['modalidad']) . " " .
                                    " AND  c.fechavencimientocarrera > now() and c.codigocarrera = cf.codigocarrera " .
                                    " and cf.fechahastacarreragrupofechainscripcion >= '" . date("Y-m-d") . "' " .
                                    " and cf.idsubperiodo = sp.idsubperiodo and sp.idcarreraperiodo = cp.idcarreraperiodo " .
                                    " $queryCarrerasExistentes";
                                $car = $db->Execute($query_car);
                                $totalRows_car = $car->RecordCount();
                            }
                        }
                        else {
                            $query_periodopre = "SELECT codigoperiodo FROM periodo where codigoestadoperiodo = '4'";
                            $periodopre = $db->Execute($query_periodopre);
                            $totalRows_periodopre = $periodopre->RecordCount();
                            $row_periodopre = $periodopre->FetchRow();
                            if ($row_periodopre <> "") {
                                $queryCarrerasExistentes = " order by c.nombrecarrera";
                                if (isset($idestudiantegeneral)) {
                                    $queryCarrerasExistentes = " and c.codigocarrera not in (
                                            select distinct eci.codigocarrera
                                        from estudiantecarrerainscripcion eci
                                        INNER JOIN inscripcion i on (eci.idinscripcion = i.idinscripcion)
                                        where eci.idestudiantegeneral = $idestudiantegeneral
                                        and eci.codigoestado = 100
                                        and i.codigoperiodo = cp.codigoperiodo) order by c.nombrecarrera ";
                                }

                                $query_car = "SELECT DISTINCT c.nombrecarrera, c.codigocarrera, cp.codigoperiodo FROM carrera c, "
                                    . " carreragrupofechainscripcion cf, carreraperiodo cp, subperiodo sp WHERE "
                                    . " c.codigomodalidadacademica = " . $db->qstr(@$_POST['modalidad']) . " AND "
                                    . " c.fechavencimientocarrera > now() AND c.codigocarrera = cf.codigocarrera AND "
                                    . " cf.fechahastacarreragrupofechainscripcion >= '" . date("Y-m-d") . "' AND "
                                    . " cf.idsubperiodo = sp.idsubperiodo AND sp.idcarreraperiodo = cp.idcarreraperiodo "
                                    . " " . $queryCarrerasExistentes;
                            } else {
                                $queryCarrerasExistentes = " order by c.nombrecarrera";
                                if (isset($idestudiantegeneral)) {
                                    $queryCarrerasExistentes = " and c.codigocarrera not in (
                                            select distinct eci.codigocarrera
                                            from estudiantecarrerainscripcion eci
                                            INNER JOIN inscripcion i on (eci.idinscripcion = i.idinscripcion)
                                            where eci.idestudiantegeneral = $idestudiantegeneral
                                            and eci.codigoestado = 100
                                            and i.codigoperiodo = '" . $periodoIncripcion['codigoperiodo'] . "') order by c.nombrecarrera ";
                                }
                                $query_car = "SELECT DISTINCT c.nombrecarrera, c.codigocarrera, cp.codigoperiodo FROM carrera c, "
                                    . " carreragrupofechainscripcion cf, carreraperiodo cp, subperiodo sp WHERE "
                                    . " c.codigomodalidadacademica = '" . @$_POST['modalidad'] . "' AND c.fechavencimientocarrera > now() "
                                    . " AND c.codigocarrera = cf.codigocarrera AND cf.fechahastacarreragrupofechainscripcion "
                                    . " >= '" . date("Y-m-d") . "' AND cf.idsubperiodo = sp.idsubperiodo AND sp.idcarreraperiodo = cp.idcarreraperiodo "
                                    . $queryCarrerasExistentes . " ";
                            }
                            $car = $db->Execute($query_car);
                            $totalRows_car = $car->RecordCount();

                        } ?>
                        <select class="form-control" name="especializacion" id="especializacion" onChange="enviar()">
                            <option value="0" <?php
                            if (!(strcmp("0", @$_POST['especializacion']))) {
                                echo "SELECTED";
                            }
                            ?>>
                                Seleccionar
                            </option>
                            <?php
                            if(isset($car) && !empty($car)) {
                                while ($row_car = $car->FetchRow()) {
                                    ?>
                                    <option value="<?php echo $row_car['codigocarrera'] . " - " . $row_car['codigoperiodo']; ?>" <?php
                                    if (!(strcmp($row_car['codigocarrera'] . " - " . $row_car['codigoperiodo'], $_POST['especializacion']))) {
                                        echo "SELECTED";
                                    }
                                    ?>>
                                        <?php echo $row_car['nombrecarrera'] . " - " . $row_car['codigoperiodo'] . "- cod (" . $row_car['codigocarrera'] . ")"; ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <?php
                    } else {
                        ?>
                        <h4>No se encuentra un periodo activo de inscripciones</h4>
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <?php
            $hayrotacion = false;
            if (isset($_POST['especializacion']) && $_POST['especializacion'] <> 0) {  // if 1
                //consulta los periodos activos para la carrera de inscripcion
                $query_periodo = "select * from periodo p,carreraperiodo c " .
                    " where p.codigoperiodo = c.codigoperiodo " .
                    " and c.codigocarrera = " . $db->qstr($_POST['carrerainscripcion']) . " " .
                    " and p.codigoestadoperiodo not like '2' " .
                    " order by p.codigoestadoperiodo";
                $periodo = $db->GetRow($query_periodo);
                $totalRows_periodo = count($periodo);
                $row_periodo = $periodo;

                if ($row_periodo == "") {
                    echo '<script language="JavaScript">swal("No hay periodo para este Programa"); histoy.go(-1);</script>';
                    exit;
                }
                //consulta lugar de rotacion para la carrera seleecionada
                $query_rot = "select * from LugarRotacionCarrera " .
                    " where codigocarrera = " . $db->qstr($_POST['carrerainscripcion']) . " " .
                    " and codigoestado=100 order by lugarRotacionBase ASC";
                $row_rot = $db->GetAll($query_rot);

                if (count($row_rot) > 0 && $row_rot !== false) {
                    $hayrotacion = true;
                }
            }
            if (@$hayrotacion) {
                ?>
                <tr>
                    <td id="tdtitulogris">Lugar Base de Rotaci&oacute;n<label id="labelresaltado">*</label></td>
                    <td colspan="3">
                        <?php foreach ($row_rot as $lugar) { ?>
                            <?php echo $lugar["lugarRotacionBase"]; ?>
                            <input name="rotacion" type="radio"
                                   value="<?php echo $lugar["LugarRotacionCarreraID"]; ?>">&nbsp;&nbsp;&nbsp;
                        <?php } ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <br>
        <?php
        if (isset($periodoIncripcion['codigoperiodo']) && !empty($periodoIncripcion['codigoperiodo'])) {
            ?>
            <button class="btn btn-fill-green-XL" type="submit" value="Enviar" name="Enviar">Enviar</button>
            <?php
        }
        if (isset($_REQUEST['menuprincipal']) && !empty($_REQUEST['menuprincipal'])) {
            ?>
            <input class="btn btn-fill-green-XL" type="button" value="Regresar"
                   onClick="window.location.href = '../../../../aspirantes/enlineacentral.php?documentoingreso=<?php echo $row_estudiante['numerodocumento'] . "&codigocarrera=" . $_SESSION['codigocarrerasesion'] . ""; ?>'">
            <?php
        }
        ?>
        <script language="javascript">
            function correos(correooculto1) {
                document.inscripcion.correooculto.value = correooculto1;
                document.inscripcion.submit();
            }
        </script>
        <script language="javascript">
            function recargar(direccioncompleta, direccioncompletalarga) {
                document.inscripcion.direccion.value = direccioncompletalarga;
                document.inscripcion.direccionoculta.value = direccioncompleta;
            }
        </script>
        <?php
        $banderagrabar = 0;
        if (!empty($_POST['Enviar']) or !empty($_POST['correooculto'])) {
            /**     * ************************************************************** */
            $ano = substr($_POST['fechanacimientoestudiantegeneral'], 0, 4);
            $mes = substr($_POST['fechanacimientoestudiantegeneral'], 5, 2);
            $dia = substr($_POST['fechanacimientoestudiantegeneral'], 8, 2);

            if ($_POST['modalidad'] == 0 or $_POST['especializacion'] == 0) {
                echo '<script language="JavaScript">swal("Debe seleccionar la Modalidad Académica y el Nombre del Programa")</script>';
                $banderagrabar = 1;
            }

            if (isset($_POST['carrerainscripcion']) && !empty($_POST['carrerainscripcion'])) {
                //Se modifica la consulta de los datos del periodo ya que la informacion no esta correctamente relacionada
                $query_periodoactivo = "SELECT p.codigoperiodo FROM periodo p " .
                    " INNER JOIN carreraperiodo cp ON (p.codigoperiodo = cp.codigoperiodo) " .
                    " WHERE cp.codigocarrera = " . $db->qstr($_POST['carrerainscripcion']) . " AND p.codigoestadoperiodo = 4";
                $row_periodoactivo = $db->GetRow($query_periodoactivo);
            }
            $email = "^[A-z0-9\._-]+@[A-z0-9][A-z0-9-]*(\.[A-z0-9_-]+)*\.([A-z]{2,6})$";

            if ($_SESSION['MM_Username'] == "estudiante2") {
                if ($_POST['trato'] == 0 and !$existe) {
                    echo '<script language="JavaScript">swal("Debe seleccionar el trato");</script>';
                    $banderagrabar = 1;
                } else if ($_POST['nombres'] == "" and !$existe) {
                    echo '<script language="JavaScript">swal("El Nombre es Incorrecto");</script>';
                    $banderagrabar = 1;
                } else if ($_POST['apellidos'] == "" and !$existe) {
                    echo '<script language="JavaScript">swal("El Apellido es Incorrecto");</script>';
                    $banderagrabar = 1;
                } else if ($_POST['tipodocumento'] == 0 and !$existe) {
                    echo '<script language="JavaScript">swal("Debe seleccionar el tipo de documento");</script>';
                    $banderagrabar = 1;
                } else if ($_POST['tipodocumento'] != 5 and (!eregi("^[0-9]{1,15}$", $_POST['numerodocumento']) and !$existe)) {
                    echo '<script language="JavaScript">swal("Número de documento Incorrecto");</script>';
                    $banderagrabar = 1;
                } else if (!(@checkdate($mes, $dia, $ano)) or ($ano > date("Y")) or ($ano < 1900)) {
                    echo '<script language="JavaScript">swal("La fecha digitada debe ser valida y en formato aaaa-mm-dd");</script>';
                    $banderagrabar = 1;
                } else if ($_POST['ciudadnacimiento'] == 0 and !$existe) {
                    echo '<script language="JavaScript">swal("Debe seleccionar el lugar de Nacimiento");</script>';
                    $banderagrabar = 1;
                } else if ($_POST['codigogenero'] == 0 and !$existe) {
                    echo '<script language="JavaScript">swal("Debe seleccionar el genero");</script>';
                    $banderagrabar = 1;
                } else if ($_POST['telefono'] == "" and !$existe) {
                    echo '<script language="JavaScript">swal("Debe digitar el e-mail o la dirrección");</script>';
                    $banderagrabar = 1;
                } else if (!eregi("^[0-9]{1,15}$", $_POST['telefono']) and $_POST['telefono'] != "" and !$existe) {
                    echo '<script language="JavaScript">swal("Telefono Incorrecto");</script>';
                    $banderagrabar = 1;
                } else if ($_POST['email'] != "" and !$existe) {
                    if ((!eregi($email, $_POST['email']) and $_POST['email'] != "") and !$existe) {
                        echo '<script language="JavaScript">swal("E-mail Incorrecto");</script>';
                        $banderagrabar = 1;
                    }
                } else if ($_POST['direccion'] == "" and !$existe) {
                    echo '<script language="JavaScript">swal("Debe Digitar una Dirección");</script>';
                    $banderagrabar = 1;
                } else if ($_POST['ciudad'] == 0 and !$existe) {
                    echo '<script language="JavaScript">swal("Seleccione Ciudad de Residencia")</script>';
                    $banderagrabar = 1;
                } else if ($hayrotacion && (!isset($_POST["rotacion"]) || !is_numeric($_POST["rotacion"]))) {
                    echo '<script language="JavaScript">swal("Debe seleccionar el lugar de rotación");	</script>';
                    $banderagrabar = 1;
                }
            } else {
                if ($_POST['trato'] == 0 and !$existe) {
                    echo '<script language="JavaScript">swal("Debe seleccionar el trato");</script>';
                    $banderagrabar = 1;
                } else if ($_POST['nombres'] == "" and !$existe) {
                    echo '<script language="JavaScript">swal("El Nombre es Incorrecto");</script>';
                    $banderagrabar = 1;
                } else if ($_POST['apellidos'] == "" and !$existe) {
                    echo '<script language="JavaScript">swal("El Apellido es Incorrecto");</script>';
                    $banderagrabar = 1;
                } else if (!(@checkdate($mes, $dia, $ano)) or ($ano > date("Y")) or ($ano < 1900)) {
                    echo '<script language="JavaScript">swal("La fecha de nacimiento debe ser valida y en formato aaaa-mm-dd");</script>';
                    $banderagrabar = 1;
                } else if ($_POST['tipodocumento'] == 0 and !$existe) {
                    echo '<script language="JavaScript">swal("Debe seleccionar el tipo de documento");</script>';
                    $banderagrabar = 1;
                } else if ($_POST['tipodocumento'] != 5 and (!eregi("^[0-9]{1,15}$", $_POST['numerodocumento']) and !$existe)) {
                    echo '<script language="JavaScript">swal("Número de documento Incorrecto");</script>';
                    $banderagrabar = 1;
                } else if ($hayrotacion && (!isset($_POST["rotacion"]) && !is_numeric($_POST["rotacion"]))) {
                    echo '<script language="JavaScript">swal("Debe seleccionar el lugar de rotación");	</script>';
                    $banderagrabar = 1;
                } else if ($_POST['codigogenero'] == 0 and !$existe) {
                    echo '<script language="JavaScript">swal("Debe seleccionar el genero");</script>';
                    $banderagrabar = 1;
                } else if ($_POST['email'] == "" and $_POST['telefono'] == "" and !$existe) {
                    echo '<script language="JavaScript">swal("Debe digitar el e-mail o el teléfono de residencia");</script>';
                    $banderagrabar = 1;
                } else if ($_POST['email'] != "" or $_POST['telefono'] != "") {
                    if ((!eregi($email, $_POST['email']) and $_POST['email'] != "") and !$existe) {
                        echo '<script language="JavaScript">swal("E-mail Incorrecto");</script>';
                        $banderagrabar = 1;
                    }
                    if (!eregi("^[0-9]{1,15}$", $_POST['telefono']) and $_POST['telefono'] != "" and !$existe) {
                        echo '<script language="JavaScript">swal("Telefono Incorrecto");</script>';
                        $banderagrabar = 1;
                    }
                }
            }

            if ($banderagrabar == 0) {
                if (isset($_POST['contrasena']) && !empty($_POST['contrasena'])) {
                    $pass = $_POST['contrasena'];
                }
                if (!isset($_POST['expedidodocumento']) && empty($_POST['expedidodocumento'])) {
                    $_POST['expedidodocumento'] = "";
                }

                $idnumeroinscripcion = 0;
                if (!$row_estudiante) {
                    if ($_SESSION['MM_Username'] == "estudiante2") {
                        //usuario generico para estudiante
                        $idusuario = 6492;
                        //creacion de registro de datos del estudiante aspirante
                        $query_insestudiante = "INSERT INTO estudiantegeneral " .
                            " (idtrato, idestadocivil, tipodocumento, numerodocumento, expedidodocumento, " .
                            " nombrecortoestudiantegeneral, nombresestudiantegeneral, apellidosestudiantegeneral, " .
                            " fechanacimientoestudiantegeneral,idciudadnacimiento ,codigogenero, " .
                            " direccionresidenciaestudiantegeneral, direccioncortaresidenciaestudiantegeneral, " .
                            " ciudadresidenciaestudiantegeneral, telefonoresidenciaestudiantegeneral, " .
                            " telefono2estudiantegeneral, celularestudiantegeneral, " .
                            " direccioncorrespondenciaestudiantegeneral, direccioncortacorrespondenciaestudiantegeneral, " .
                            " ciudadcorrespondenciaestudiantegeneral, telefonocorrespondenciaestudiantegeneral, " .
                            " emailestudiantegeneral, fechacreacionestudiantegeneral, " .
                            " fechaactualizaciondatosestudiantegeneral,codigotipocliente, codigoestado) " .
                            " VALUES('" . $_POST['trato'] . "','1', '" . $_POST['tipodocumento'] . "', '" . $_POST['numerodocumento'] . "',"
                            . " '" . $_POST['expedidodocumento'] . "', '" . $_POST['numerodocumento'] . "', '" . $_POST['nombres'] . "',"
                            . " '" . $_POST['apellidos'] . "', '" . $_POST['fechanacimientoestudiantegeneral'] . "', "
                            . "'" . $_POST['ciudadnacimiento'] . "', '" . $_POST['codigogenero'] . "', '" . $_POST['direccion'] . "',"
                            . "'" . $_POST['direccionoculta'] . "' ,'" . $_POST['ciudad'] . "', '" . $_POST['telefono'] . "',"
                            . " '" . $_POST['telefono'] . "', '" . $_POST['celular'] . "','" . $_POST['direccion'] . "', "
                            . "'" . $_POST['direccionoculta'] . "','" . $_POST['ciudad'] . "', '" . $_POST['telefono'] . "', "
                            . "'" . $_POST['email'] . "', '" . date("Y-m-d G:i:s", time()) . "', '" . date("Y-m-d G:i:s", time()) . "','0', '100')";
                        $db->Execute($query_insestudiante);

                        $sqlestudiantegeneral = "select idestudiantegeneral from estudiantegeneral where " .
                            " numerodocumento = '" . $_POST['numerodocumento'] . "' " .
                            " and tipodocumento = '" . $_POST['tipodocumento'] . "' and codigoestado = 100";
                        $idestudiantegeneral = $db->GetRow($sqlestudiantegeneral);
                        $idestudiantegeneral = $idestudiantegeneral['idestudiantegeneral'];

                        if ($_POST['fechaexpedicionvisa'] != '' && $_POST['fechavencimientovisa'] != '') {
                            $query_insestudiante_extranjero = "INSERT INTO EstudianteVisa "
                                . "(idestudiantegeneral, CategoriaVisaId, NumeroVisa, idpais, FechaExpedicion, FechaVencimiento) "
                                . "VALUES (" . $idestudiantegeneral . ", '" . $_POST['categoriavisa'] . "', '" . $_POST['numerovisa'] . "',"
                                . "'" . $_POST['paisnacimiento'] . "', '" . $_POST['fechaexpedicionvisa'] . "', "
                                . "'" . $_POST['fechavencimientovisa'] . "');";
                            $db->Execute($query_insestudiante_extranjero);
                        }
                    } else {
                        if (isset($_POST['email']) && !empty($_POST['email'])) {
                            $maildigitado = $_POST['email'];
                            if (!isset($_POST['direccionoculta']) && empty($_POST['direccionoculta'])) {
                                $_POST['direccionoculta'] = "";
                            }

                            $query_insestudiante = "INSERT INTO estudiantegeneral " .
                                " (idtrato, idestadocivil,tipodocumento, numerodocumento, expedidodocumento, " .
                                " nombrecortoestudiantegeneral, nombresestudiantegeneral, apellidosestudiantegeneral, " .
                                " fechanacimientoestudiantegeneral,idciudadnacimiento ,codigogenero, " .
                                " direccionresidenciaestudiantegeneral, direccioncortaresidenciaestudiantegeneral, " .
                                " ciudadresidenciaestudiantegeneral, telefonoresidenciaestudiantegeneral, " .
                                " telefono2estudiantegeneral, celularestudiantegeneral, " .
                                " direccioncorrespondenciaestudiantegeneral, " .
                                " direccioncortacorrespondenciaestudiantegeneral,ciudadcorrespondenciaestudiantegeneral, " .
                                " telefonocorrespondenciaestudiantegeneral, emailestudiantegeneral, fechacreacionestudiantegeneral, " .
                                " fechaactualizaciondatosestudiantegeneral,codigotipocliente,idtipoestudiantefamilia, codigoestado) " .
                                " VALUES('" . $_POST['trato'] . "','1', '" . $_POST['tipodocumento'] . "', '" . $_POST['numerodocumento'] . "',"
                                . " '" . $_POST['expedidodocumento'] . "', '" . $_POST['numerodocumento'] . "', '" . $_POST['nombres'] . "',"
                                . " '" . $_POST['apellidos'] . "', '" . $_POST['fechanacimientoestudiantegeneral'] . "', '359', "
                                . "'" . $_POST['codigogenero'] . "', 'Campo Faltante','" . $_POST['direccionoculta'] . "' ,'359', "
                                . "'" . $_POST['telefono'] . "', '" . $_POST['telefono'] . "', '" . $_POST['celular'] . "',"
                                . "'Campo Faltante', '" . $_POST['direccionoculta'] . "','359', '" . $_POST['telefono'] . "', "
                                . "'$maildigitado', '" . date("Y-m-d G:i:s", time()) . "', '" . date("Y-m-d G:i:s", time()) . "','0','0','100')";
                            $db->Execute($query_insestudiante);

                            $sqlestudiantegeneral = "select idestudiantegeneral from estudiantegeneral where " .
                                " numerodocumento = '" . $_POST['numerodocumento'] . "' " .
                                " and tipodocumento = '" . $_POST['tipodocumento'] . "' and codigoestado = 100";
                            $idestudiantegeneral = $db->GetRow($sqlestudiantegeneral);
                            $idestudiantegeneral = $idestudiantegeneral['idestudiantegeneral'];

                            if ($_POST['fechaexpedicionvisa'] != '' && $_POST['fechavencimientovisa'] != '') {
                                $query_insestudiante_extranjero = "INSERT INTO EstudianteVisa "
                                    . "(idestudiantegeneral, CategoriaVisaId, NumeroVisa, idpais, FechaExpedicion, FechaVencimiento) "
                                    . "VALUES (" . $idestudiantegeneral . ", '" . $_POST['categoriavisa'] . "', '" . $_POST['numerovisa'] . "',"
                                    . "'" . $_POST['paisnacimiento'] . "', '" . $_POST['fechaexpedicionvisa'] . "', "
                                    . "'" . $_POST['fechavencimientovisa'] . "');";
                                $db->Execute($query_insestudiante_extranjero);
                            }
                        }
                    }
                } else {
                    $idestudiantegeneral = $row_estudiante['idestudiantegeneral'];

                    if (isset($_POST['expedidodocumento']) && !empty($_POST['expedidodocumento'])) {
                        $expedido = "expedidodocumento='" . $_POST['expedidodocumento'] . "', ";
                    } else {
                        $expedido = '';
                    }

                    //actualizacion de datos del estudiante en estudiante general
                    $query_insestudiante = "update estudiantegeneral set idtrato=" . $_POST['trato'] . ", " .
                        " tipodocumento= " . $_POST['tipodocumento'] . ", numerodocumento=" . $_POST['numerodocumento'] . ", " .
                        " " . $expedido . " nombrecortoestudiantegeneral=" . $_POST['numerodocumento'] . " " .
                        " nombresestudiantegeneral=" . $_POST['nombres'] . " apellidosestudiantegeneral=" . $_POST['apellidos'] . " " .
                        " telefonoresidenciaestudiantegeneral=" . $_POST['telefono'] . " " .
                        " telefono2estudiantegeneral=" . $_POST['telefonooficina'] . " " .
                        " celularestudiantegeneral=" . $_POST['celular'] . " " .
                        " emailestudiantegeneral=" . $_POST['email'] . " " .
                        " fechaactualizaciondatosestudiantegeneral =  " . date("Y-m-d G:i:s", time()) . " " .
                        " where idestudiantegeneral = $idestudiantegeneral ";
                    $db->Execute($query_insestudiante);

                    if ($_POST['fechaexpedicionvisa'] != '' && $_POST['fechavencimientovisa'] != '') {
                        //actualizacion de estudainte visa
                        $query_updestudiante_extranjero = "UPDATE EstudianteVisa SET CategoriaVisaId = '" . $_POST['categoriavisa'] . "', "
                            . "NumeroVisa = '" . $_POST['numerovisa'] . "', idpais = '" . $_POST['paisnacimiento'] . "',"
                            . " FechaExpedicion = '" . $_POST['fechaexpedicionvisa'] . "',"
                            . " FechaVencimiento = '" . $_POST['fechavencimientovisa'] . "' "
                            . "where idestudiantegeneral = '$idestudiantegeneral'";
                        $db->Execute($query_updestudiante_extranjero);
                    }
                }

                //consulta si existe algun registro en la tabla estudiante documento con ese mismo numero y tipo
                $query_estudiantedocumento = "SELECT idestudiantegeneral from estudiantedocumento "
                    . "where numerodocumento = '" . $_POST['numerodocumento'] . "' " .
                    " AND tipodocumento = '" . $_POST['tipodocumento'] . "'";
                $row_estudiantedocumento = $db->GetRow($query_estudiantedocumento);

                if (!isset($row_estudiantedocumento['idestudiantegeneral']) && empty($row_estudiantedocumento['idestudiantegeneral'])) {
                    //Si no existe, crea el registro
                    $query_insestudiantedocumento = "INSERT INTO estudiantedocumento(idestudiantedocumento, " .
                        " idestudiantegeneral, tipodocumento, numerodocumento, expedidodocumento, " .
                        " fechainicioestudiantedocumento, fechavencimientoestudiantedocumento) " .
                        " VALUES(0, '$idestudiantegeneral', '" . $_POST['tipodocumento'] . "', '" . $_POST['numerodocumento'] . "', "
                        . "'" . $_POST['expedidodocumento'] . "', '" . date("Y-m-d G:i:s", time()) . "', '2999-12-31')";
                    $db->Execute($query_insestudiantedocumento);
                }

                $query_jornadacarrera = "select codigojornada from jornadacarrera "
                    . "where codigocarrera = '" . $_POST['carrerainscripcion'] . "' ";
                $row_jornadacarrera = $db->GetRow($query_jornadacarrera);
                if (isset($row_jornadacarrera['codigojornada']) && !empty($row_jornadacarrera['codigojornada'])) {
                    $codigojornadacarrera = $row_jornadacarrera['codigojornada'];
                } else {
                    $codigojornadacarrera = '01';
                }

                //Consulta si el estudiante esta inscrito en el mismo programa y el periodo
                $query_estudiantecarrera = "select codigoestudiante from estudiante "
                    . "where idestudiantegeneral = '$idestudiantegeneral' "
                    . "and codigocarrera = '" . $_POST['carrerainscripcion'] . "' "
                    . "and codigoperiodo =" . $_POST['periodo'];
                $row_estudiantecarrera = $db->GetRow($query_estudiantecarrera);

                if (!isset($row_estudiantecarrera['codigoestudiante']) && empty($row_estudiantecarrera['codigoestudiante'])) {
                    /* INSERT si viene de educacion continuada */
                    if (isset($_REQUEST['referred']) && $_REQUEST['referred'] == 'educontinuada') {
                        $query_insestudiantecarrera = "INSERT INTO estudiante(idestudiantegeneral, codigocarrera, " .
                            " semestre, numerocohorte, codigotipoestudiante, codigosituacioncarreraestudiante," .
                            " codigoperiodo, codigojornada) " .
                            " VALUES('$idestudiantegeneral', '" . $_POST['carrerainscripcion'] . "','1', '1', '10', '106', "
                            . "'" . $_POST['periodo'] . "','" . $codigojornadacarrera . "')";
                    } else {
                        $query_insestudiantecarrera = "INSERT INTO estudiante(idestudiantegeneral, codigocarrera, " .
                            " semestre, numerocohorte, codigotipoestudiante, codigosituacioncarreraestudiante, codigoperiodo, codigojornada) " .
                            " VALUES('$idestudiantegeneral', '" . $_POST['carrerainscripcion'] . "','1', '1', '10', '106', "
                            . "'" . $_POST['periodo'] . "','" . $codigojornadacarrera . "')";
                    }
                    $db->Execute($query_insestudiantecarrera);

                    $query_estudiantecarrera = "select codigoestudiante from estudiante where idestudiantegeneral = " . $db->qstr($idestudiantegeneral) . " "
                        . "AND codigocarrera = " . $db->qstr($_POST['carrerainscripcion']) . " "
                        . "AND semestre=1 "
                        . "AND numerocohorte=1 "
                        . "AND codigotipoestudiante=10 "
                        . "AND codigosituacioncarreraestudiante not in (300, 301)"
                        . "AND codigoperiodo = " . $db->qstr($_POST['periodo']) . " ";
                    $estudiantecarrera = $db->Execute($query_estudiantecarrera);
                    $totalRows_estudiantecarrera = $estudiantecarrera->RecordCount();
                    $row_estudiantecarrera = $estudiantecarrera->FetchRow();
                    $codigoestudiantecarrera = $row_estudiantecarrera['codigoestudiante'];
                } else {
                    //Actualiza el periodo de ingreso del estudiante si se presenta en la misma carrera//
                    $query_actualizaperiodo = "update estudiante set codigoperiodo = '" . $_POST['periodo'] . "', " .
                        " codigosituacioncarreraestudiante='106' where codigoestudiante='" . $row_estudiantecarrera['codigoestudiante'] . "' ";
                    $db->Execute($query_actualizaperiodo);
                }

                //Guarda la carrera de rotacion base para el estudiante
                if (isset($_POST["rotacion"]) && is_numeric($_POST["rotacion"])) {
                    $query_rotacion = "select codigoestudiante from LugarRotacionCarreraEstudiante "
                        . "where codigoestudiante = " . $db->qstr($codigoestudiantecarrera) . " ";
                    $row_estudianterotacion = $db->GetRow($query_rotacion);
                    if ($idusuario == null) {
                        //se le asigna el usuario estudiante
                        $idusuario = 6492;
                    }

                    //si el usuario tiene alguna rotacion particular se registra aqui
                    if (!isset($row_estudianterotacion['codigoestudiante']) && empty($row_estudianterotacion['codigoestudiante'])) {
                        $query_rotacion = "INSERT INTO LugarRotacionCarreraEstudiante (codigoestudiante, LugarRotacionCarreraID, " .
                            " FechaCreacion, UsuarioCreacion, FechaModificacion, UsuarioModificacion) " .
                            " VALUES ('" . $codigoestudiantecarrera . "', '" . $_POST["rotacion"] . "', '"
                            . date("Y-m-d") . "', '" . $idusuario . "', '" . date("Y-m-d") . "', '"
                            . $idusuario . "')";
                        $db->Execute($query_rotacion);
                    } else {
                        $query_rotacion = "UPDATE LugarRotacionCarreraEstudiante SET LugarRotacionCarreraID='" . $_POST["rotacion"] . "',  " .
                            " codigoestado='100', FechaModificacion='" . date("Y-m-d") . "', UsuarioModificacion='" . $idusuario . "' " .
                            " WHERE (`codigoestudiante`='" . $codigoestudiantecarrera . "')";
                        $db->Execute($query_rotacion);
                    }
                }
                $anoaspira = substr($_POST['periodo'], 0, 4);
                $periodoaspira = substr($_POST['periodo'], 4, 5);

                //consulta si existe el programa, periodo y estado del proceso de inscripcion.
                $queryinscripciones = "SELECT i.idinscripcion FROM inscripcion i " .
                    " INNER JOIN estudiantecarrerainscripcion ei ON ( i.idestudiantegeneral = ei.idestudiantegeneral ) " .
                    " WHERE i.idestudiantegeneral = " . $db->qstr($idestudiantegeneral) . " " .
                    " AND i.codigoestado = 100 " .
                    " AND ei.codigocarrera = " . $db->qstr($_POST['carrerainscripcion']) . " " .
                    " AND ei.codigoestado = i.codigoestado " .
                    " AND ei.idnumeroopcion = 1 " .
                    " AND i.codigoperiodo = " . $db->qstr($_POST['periodo']) . " ";
                $inscripciones = $db->GetRow($queryinscripciones);

                //si el resultado de la consulta es mayor a cero, significa que el registro ya existe
                if (isset($inscripciones['idinscripcion']) && !empty($inscripciones['idinscripcion'])) {
                    //si ya esiste se actualizan los datos
                    $queryperiodo = "UPDATE inscripcion " .
                        " SET codigoperiodo = " . $_POST['periodo'] . ", anoaspirainscripcion = " . $anoaspira . ", " .
                        " periodoaspirainscripcion = " . $periodoaspira . ", fechainscripcion = now() " .
                        " WHERE idestudiantegeneral = '" . $idestudiantegeneral . "' " .
                        " AND codigosituacioncarreraestudiante NOT IN (300, 301) " .
                        " AND codigoestado = 100 and idinscripcion = " . $inscripciones['idinscripcion'] . " ";
                    $result = $db->Execute($queryperiodo);
                    //si el resultado es falso y no se permite la actualizacion se debe realizar
                    // la creacion del registro
                    if ($result == false) {
                        $query_inscripcion = "INSERT INTO inscripcion(fechainscripcion, codigomodalidadacademica, " .
                            " codigoperiodo, anoaspirainscripcion, periodoaspirainscripcion, idestudiantegeneral, " .
                            " codigosituacioncarreraestudiante,codigoestado) " .
                            " VALUES('" . date("Y-m-d G:i:s", time()) . "', '" . $_POST['modalidad'] . "', '"
                            . $_POST['periodo'] . "','$anoaspira','$periodoaspira', '$idestudiantegeneral', '106',100)";
                        $db->Execute($query_inscripcion);

                        $sqlinscripcion = "select idinscripcion from inscripcion where " .
                            " codigomodalidadacademica = '" . $_POST['modalidad'] . "' and codigoperiodo= '" . $_POST['periodo'] . "' " .
                            " and idestudiantegeneral = '" . $idestudiantegeneral . "' and codigosituacioncarreraestudiante = 106 " .
                            " and codigoestado= 100";
                        $idinscripcion = $db->GetRow($sqlinscripcion);
                        $idnumeroinscripcion = $idinscripcion['idinscripcion'];
                    } else {
                        //obtiene el id de la inscripcion
                        $idnumeroinscripcion = $inscripciones['idinscripcion'];
                    }
                }
                else {
                    /* Insert si viene por educacion continuada */
                    if (isset($_REQUEST['referred']) && $_REQUEST['referred'] == 'educontinuada') {
                        $query_inscripcion = "INSERT INTO inscripcion(fechainscripcion, codigomodalidadacademica," .
                            " codigoperiodo, anoaspirainscripcion, periodoaspirainscripcion, idestudiantegeneral, " .
                            " codigosituacioncarreraestudiante,codigoestado) " .
                            " VALUES('" . date("Y-m-d G:i:s", time()) . "', '" . $_POST['modalidad'] . "', '"
                            . $_POST['periodo'] . "','$anoaspira','$periodoaspira', '$idestudiantegeneral', '106',100)";
                    }
                    else {
                        //Inserta programas de Pregrado y Educación Continuada.
                        $query_inscripcion = "INSERT INTO inscripcion(fechainscripcion, codigomodalidadacademica, " .
                            " codigoperiodo, anoaspirainscripcion, periodoaspirainscripcion, idestudiantegeneral, " .
                            " codigosituacioncarreraestudiante,codigoestado) " .
                            " VALUES('" . date("Y-m-d G:i:s", time()) . "', '" . $_POST['modalidad'] . "', '"
                            . $_POST['periodo'] . "','$anoaspira','$periodoaspira', '$idestudiantegeneral', '106',100)";
                    }
                    $db->Execute($query_inscripcion);

                    $sqlinscripcion = "select idinscripcion from inscripcion where " .
                        " codigomodalidadacademica = '" . $_POST['modalidad'] . "' and codigoperiodo= '" . $_POST['periodo'] . "' " .
                        " and idestudiantegeneral = '" . $idestudiantegeneral . "' and codigosituacioncarreraestudiante = 106 " .
                        " and codigoestado= 100 order by idinscripcion desc";
                    $idinscripcion = $db->GetRow($sqlinscripcion);
                    $idnumeroinscripcion = $idinscripcion['idinscripcion'];
                }

                // Informa a el Administrador de la carrera sobre la InscripciÃ³n.
                $query_facultad = "select emailcarreraemail, nombrecarrera, codigoindicadorcobroinscripcioncarrera " .
                    " from carreraemail ce, carrera c " .
                    " where c.codigocarrera = " . $db->qstr($_POST['carrerainscripcion']) . " " .
                    " AND c.codigocarrera = ce.codigocarrera AND ce.codigoestado = '100'";
                $row_facultad = $db->GetAll($query_facultad);

                if (isset($row_facultad['emailcarreraemail']) && !empty($row_facultad['emailcarreraemail'])) {
                    do {
                        $mailusuario = $row_facultad['emailcarreraemail'];
                        $nombrecarrera = $row_facultad['nombrecarrera'];
                        $nombre = $_POST['apellidos'] . " " . $_POST['nombres'];
                        $documento = $_POST['numerodocumento'];
                        $r = enviamailfacultad($mailusuario, $nombrecarrera, $nombre, $documento);
                    } while ($row_facultad = $facultad->FetchRow());
                }
                $query_facultad = "select nombrecarrera, codigoindicadorcobroinscripcioncarrera " .
                    " from carrera c where c.codigocarrera = " . $db->qstr($_POST['carrerainscripcion']) . " ";
                $facultad = $db->Execute($query_facultad);
                $totalRows_facultad = $facultad->RecordCount();
                $row_facultad = $facultad->FetchRow();

                $query_mayor = "select max(idnumeroopcion) as mayor 
                                        from estudiantecarrerainscripcion e
                                        INNER JOIN inscripcion i on (e.idinscripcion = i.idinscripcion)
                                        where e.idestudiantegeneral = " . $db->qstr($idestudiantegeneral) . "                                
                                        and i.idinscripcion = " . $db->qstr($idnumeroinscripcion) . "  
                                        and i.codigoestado like '1%'";
                $mayor = $db->Execute($query_mayor);
                $totalRows_mayor = $mayor->RecordCount();
                $row_mayor = $mayor->FetchRow();
                $idnumeroinscripciones = $row_mayor['mayor'] + 1;

                //consulta si ya existe uno o mas registros para la misma inscripcion el programa
                $queryestudiante = "SELECT count(*) as contador FROM " .
                    " estudiantecarrerainscripcion WHERE " .
                    " codigocarrera = " . $db->qstr($_POST['carrerainscripcion']) . " " .
                    " AND idinscripcion = " . $db->qstr($idnumeroinscripcion) . " " .
                    " AND idestudiantegeneral = " . $db->qstr($idestudiantegeneral) . " AND codigoestado = 100";
                $contadorcarreras = $db->GetRow($queryestudiante);

                //si no existe carreras para el id de isncpcion
                if ($contadorcarreras['contador'] == 0) {
                    //si ya existe carreras con otro id de inscprcion, consulta si existen
                    $query_existecarrera = "SELECT  COUNT(idinscripcion) as inscripcion  from estudiantecarrerainscripcion 
                                            where idestudiantegeneral = " . $db->qstr($idestudiantegeneral) . " and codigocarrera = " . $db->qstr($_POST['carrerainscripcion']) . "  "
                        . " and codigoestado = 100 and idinscripcion <> " . $db->qstr($idnumeroinscripcion) . " ";
                    $existecontador = $db->GetRow($query_existecarrera);

                    if ($existecontador['inscripcion'] != 0) {
                        //mayo 8 del 2018
                        //si existen registros, se debe actualizar a estado 100 y con el id de inscrpcion el primer registro para evitar duplicidad de datos.
                        $query_update = "update estudiantecarrerainscripcion set idinscripcion = '" .
                            $idnumeroinscripcion . "', idnumeroopcion = 1 " .
                            " where idestudiantegeneral = " . $idestudiantegeneral . " and codigocarrera = " .
                            $_POST['carrerainscripcion'] . " and codigoestado = 100 " .
                            " and idinscripcion <> '" . $idnumeroinscripcion . "' limit 1";
                        $db->Execute($query_update);
                        //para limpieza de datos se inactiva los demas registros que no esten en el proceso para dicha inscrpcion
                        $query_updateinactivo = "update estudiantecarrerainscripcion set codigoestado = 200 " .
                            " where idestudiantegeneral = " . $idestudiantegeneral . " and codigocarrera = "
                            . $_POST['carrerainscripcion'] . " and codigoestado = 100 " .
                            " and idinscripcion <> '" . $idnumeroinscripcion . "'";
                        $db->Execute($query_updateinactivo);
                    } else {
                        //creacion del registro de la opcion
                        $query_carrerainscripcion = "INSERT INTO estudiantecarrerainscripcion"
                            . "(codigocarrera, idnumeroopcion, idinscripcion, idestudiantegeneral,codigoestado) "
                            . "VALUES ('" . $_POST['carrerainscripcion'] . "', "
                            . "'1', "
                            . "'$idnumeroinscripcion', "
                            . "'$idestudiantegeneral', "
                            . "'100')";
                        $db->Execute($query_carrerainscripcion);
                    }
                } else {
                    //update de estado y numero opcion de una carrera
                    $query_carrerainscripcion = "UPDATE  estudiantecarrerainscripcion"
                        . " SET codigoestado = 100, idnumeroopcion= 1 "
                        . " WHERE idestudiantegeneral= '" . $idestudiantegeneral . "' " .
                        " and idinscripcion= '" . $idnumeroinscripcion . "' ";
                    $db->Execute($query_carrerainscripcion);
                }


                if (isset($_SESSION['study']) && $_SESSION['study'] == 'antiguo') {
                    $query_estadoestudiante = "UPDATE estudiante e, inscripcion i, estudiantecarrerainscripcion ec " .
                        " SET i.codigosituacioncarreraestudiante = '300', e.codigosituacioncarreraestudiante = '300' " .
                        " WHERE i.idestudiantegeneral  = e.idestudiantegeneral " .
                        " AND ec.codigocarrera = e.codigocarrera AND i.idinscripcion = ec.idinscripcion " .
                        " AND e.codigoestudiante = '$codigoestudiantecarrera'";
                    $db->Execute($query_estadoestudiante);
                    session_unregister('study');
                }

                if (!isset($row_usuarioclave) && empty($row_usuarioclave)) {
                    echo '<script>swal("Ha sido registrado exitosamente!", "por favor diligencie el formulario de inscripción!", "success");</script>';
                }

                if ($_POST['carrerainscripcion'] == 10) {
                    $mensajemedicina = "Señor aspirante al Programa de Medicina:\nNo olvide diligenciar el puntaje que obtuvo en la prueba de Estado (Saber 11) en la casilla destinada para tal fin en el punto 8 del Formulario de Inscripción. Recuerde que su puntaje tiene un peso del 50% dentro del proceso de admisión";
                    echo "<script language='JavaScript'>swal('" . $mensajemedicina . "');</script>";
                }

                if ($idnumeroinscripcion <> 0) {
                    $inscripcionnueva = $idnumeroinscripcion;
                }
                // Generar la orden de pago con inscripciÃ³n y formulario
                /*         * ************************************************************** */
                // 1. Mirar que la carrera tenga codigoindicadorcobroinscripcio si se debe cobrar muestra el link generar orden de pago
                // si no no mostrar el link, si el estudiante no tiene orden de pago por concepto de inscripciÃ³n y formulario se le debe
                // generar la orden con los conceptos correspondientes.
                if (ereg("^1.+$", $row_facultad['codigoindicadorcobroinscripcioncarrera'])) {
                    $query_ordenpagoinscripcion = "SELECT o.numeroordenpago, o.codigoestadoordenpago 
                                            FROM ordenpago o, detalleordenpago do, concepto c
                                            where o.codigoestudiante = " . $db->qstr($codigoestudiantecarrera) . " 
                                            and o.numeroordenpago = do.numeroordenpago
                                            and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
                                            and o.codigoperiodo = " . $db->qstr($_POST['periodo']) . " 
                                            and do.codigoconcepto = c.codigoconcepto
                                            and c.codigoreferenciaconcepto like '6%'";
                    $ordenpagoinscripcion = $db->Execute($query_ordenpagoinscripcion);
                    $totalRows_ordenpagoinscripcion = $ordenpagoinscripcion->RecordCount();
                    $row_ordenpagoinscripcion = $ordenpagoinscripcion->FetchRow();
                } else {
                    $query_estadoestudiante = "UPDATE estudiante e,inscripcion i,estudiantecarrerainscripcion ec " .
                        " SET i.codigosituacioncarreraestudiante = '107', e.codigosituacioncarreraestudiante = '107' " .
                        " WHERE i.idestudiantegeneral  = e.idestudiantegeneral AND ec.codigocarrera = e.codigocarrera " .
                        " AND i.idinscripcion = ec.idinscripcion " .
                        " AND e.codigoestudiante = " . $db->qstr($row_data2['0']['codigoestudiante']) . " ";
                    $db->Execute($query_estadoestudiante);

                    if (ereg("^2.+$", $row_data2['0']['codigoindicadorprocesoadmisioncarrera'])) {

                        $indicadordocementacion = 0;
                        if ($row_data2['0']['codigomodalidadacademica'] == 400) {
                            $query_valida = "SELECT *
                                                        FROM documentacion d,documentacionfacultad df
                                                        where d.iddocumentacion = df.iddocumentacion
                                                        and df.codigocarrera = " . $db->qstr($row_data2['0']['codigocarrera']) . " 
                                                        AND (df.codigogenerodocumento = '300' OR df.codigogenerodocumento = " . $db->qstr($row_data2['0']['codigogenero']) . " )";
                            $valida = $db->Execute($query_valida);
                            $totalRows_valida = $valida->RecordCount();
                            $row_valida = $valida->FetchRow();

                            if ($row_valida <> "") {
                                do {
                                    $query_documentosestuduante = "SELECT *
                                                                FROM documentacionestudiante d,documentacionfacultad df
                                                                where d.codigoestudiante = " . $db->qstr($row_data2['0']['codigoestudiante']) . " 
                                                                and d.iddocumentacion = " . $db->qstr($row_valida['iddocumentacion']) . " 
                                                                AND d.codigotipodocumentovencimiento = '100'
                                                                and d.iddocumentacion = df.iddocumentacion";
                                    $documentosestuduante = $db->Execute($query_documentosestuduante);
                                    $row_documentosestuduante = $documentosestuduante->FetchRow();

                                    if (!$row_documentosestuduante) {
                                        $indicadordocementacion = 1;
                                    }
                                } while ($row_valida = $valida->FetchRow());
                            }

                            if ($indicadordocementacion == 0) {
                                $query_estadoestudiante = "UPDATE estudiante e,inscripcion i, " .
                                    "estudiantecarrerainscripcion ec SET i.codigosituacioncarreraestudiante = '300', " .
                                    " e.codigosituacioncarreraestudiante = '300' " .
                                    " WHERE i.idestudiantegeneral  = e.idestudiantegeneral " .
                                    " AND ec.codigocarrera = e.codigocarrera AND i.idinscripcion = ec.idinscripcion " .
                                    " AND e.codigoestudiante = " . $db->qstr($row_data2['0']['codigoestudiante']) . " ";
                                $db->Execute($query_estadoestudiante);
                            }
                        }

                        if ($indicadordocementacion != 0) {
                            ?>
                            <script language="javascript">
                                swal("Tiene Documentos Pendientes por Entregar");
                            </script>
                            <?php
                        }
                    }
                }

                if (isset($_REQUEST['referred']) && $_REQUEST['referred'] == 'educontinuada') {
                    echo "<META HTTP-EQUIV='Refresh' CONTENT='0; 
                        URL=http://www.uelbosque.edu.co/programas_academicos/educacion_continuada'>";
                } else {
                    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;  
                        URL=../../../../aspirantes/enlineacentral.php?documentoingreso=" . $_POST['numerodocumento'] . "&codigocarrera=" . $_POST['carrerainscripcion'] . "&logincorrecto'>";
                }
            }
        }
        ?>
    </form>
</div>
</body>
<script language="javascript">
    function toggleBox(szDivID) {
        if (document.layers) { // NN4+
            if (document.layers[szDivID].visibility == 'visible') {
                document.layers[szDivID].visibility = "hide";
                document.layers[szDivID].display = "none";
                document.layers[szDivID + "SD"].fontWeight = "normal";
            } else {
                document.layers[szDivID].visibility = "show";
                document.layers[szDivID].display = "inline";
                document.layers[szDivID + "SD"].fontWeight = "bold";
            }
        } else if (document.getElementById) { // gecko(NN6) + IE 5+
            var obj = document.getElementById(szDivID);
            var objSD = document.getElementById(szDivID + "SD");
            if (obj.style.visibility == 'visible') {
                obj.style.visibility = "hidden";
                obj.style.display = "none";
                objSD.style.fontWeight = "normal";
            } else {
                obj.style.visibility = "visible";
                obj.style.display = "inline";
                objSD.style.fontWeight = "bold";
            }
        } else if (document.all) { // IE 4
            if (document.all[szDivID].style.visibility == 'visible') {
                document.all[szDivID].style.visibility = "hidden";
                document.all[szDivID].style.display = "none";
                document.all[szDivID + "SD"].style.fontWeight = "normal";
            } else {
                document.all[szDivID].style.visibility = "visible";
                document.all[szDivID].style.display = "inline";
                document.all[szDivID + "SD"].style.fontWeight = "bold";
            }
        }
    }
</script>
</html>