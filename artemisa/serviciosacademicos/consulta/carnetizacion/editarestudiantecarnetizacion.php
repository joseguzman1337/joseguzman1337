<?php
session_start();

include_once('../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

require_once('../../Connections/sala2.php');
require_once('../../funciones/validacion.php' );
require_once('../../funciones/errores_creacionestudiante.php' );
require_once('../../funciones/funcionip.php' );
$ruta = "../../";
require_once($ruta . "Connections/conexionldap.php");
require_once($ruta . "funciones/clases/autenticacion/claseldap.php");
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
require_once('../../class/table.php');
require_once('../../class/Class_andor.php');

$usuario = $_SESSION['MM_Username'];
$periodoactual = $_SESSION['codigoperiodosesion'];

$usuarioeditar = $_GET['usuarioeditar'];
$ip = "SIN DEFINIR";
$ip = tomarip();
if (isset($_GET['codigocreado'])) {
    $codigoestudiante = $_GET['codigocreado'];
} else if (isset($_SESSION['codigo'])) {
    $codigoestudiante = $_SESSION['codigo'];
}
if ($_POST['regresar']) {
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../prematricula/matriculaautomaticaordenmatricula.php'>";
    exit();
}

$query_deuda = "select dpe.* from estudiante e 
					inner join estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral 
					inner join pazysalvoestudiante pe on pe.idestudiantegeneral=eg.idestudiantegeneral 
					inner join detallepazysalvoestudiante dpe on dpe.idpazysalvoestudiante=pe.idpazysalvoestudiante 
					and dpe.codigoestadopazysalvoestudiante=100 AND codigotipopazysalvoestudiante=800 
					where e.codigoestudiante=" . $codigoestudiante . " AND pe.codigoperiodo=" . $periodoactual;
$mat = mysql_query($query_deuda, $sala) or die("error al ejecutar la consulta => $query_deuda" . mysql_error());
$deuda = mysql_fetch_assoc($mat);
//CONSULTA ESTUDIANTE CARNETIZACIÓN.
$query_dataestudiante = "SELECT "
        . " e.codigoestudiante AS codigoestudiante, "
        . " eg.numerodocumento AS numerodocumento, "
        . " c.nombrecarrera AS nombrecarrera "
        . " FROM "
        . " prematricula pr "
        . " JOIN carrera c "
        . " JOIN estudiantegeneral eg "
        . " JOIN estudiante e "
        . " WHERE "
        . " (e.codigoestudiante = " . $codigoestudiante 
        . " AND ( e.codigocarrera = c.codigocarrera ) "
        . " AND ( eg.idestudiantegeneral = e.idestudiantegeneral ) "
        . " AND ( c.codigomodalidadacademica IN ('100', '200', '300', '400', '800', '810') ) "
        . " AND ( pr.codigoestudiante = e.codigoestudiante ) "
        . " AND pr.codigoperiodo IN (SELECT "
        . " p.codigoperiodo AS codigoperiodo "
        . " FROM "
        . " periodo p "
        . " WHERE "
        . " (p.codigoestadoperiodo IN ('1', '3', '4') ) ) "
        . " AND (pr.codigoestadoprematricula IN (40, 41) ) )";

$mat = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante" . mysql_error());
$valestudainte = mysql_fetch_assoc($mat);
if (!is_array($valestudainte)) {
    /* ESTUDIANTES DE COLEGIO */
    $query_dataestudiante = "SELECT "
            . " e.codigoestudiante AS codigoestudiante,"
            . " d.nombrecortodocumento AS nombrecortodocumento,"
            . " eg.numerodocumento AS numerodocumento,"
            . " eg.apellidosestudiantegeneral AS apellidosestudiantegeneral,"
            . " eg.nombresestudiantegeneral AS nombresestudiantegeneral,"
            . " e.codigocarrera AS codigocarrera,"
            . " c.nombrecarrera AS nombrecarrera,"
            . " m.nombremodalidadacademica AS nombremodalidadacademica,"
            . " ee.codigoperiodo AS codigoperiodo,"
            . " e.semestre AS semestre,"
            . " tj.codigotarjetaestudiante AS TarjetaInteligente,"
            . " ts.nombretipogruposanguineo AS TipoSanguineo"
            . " FROM "
            . " ( estudianteestadistica ee "
            . " JOIN carrera c "
            . " JOIN estudiantegeneral eg "
            . " JOIN documento d "
            . " JOIN modalidadacademica m "
            . " JOIN ( (  ( estudiante e "
            . " LEFT JOIN gruposanguineoestudiante ge ON ( ( ("
            . " ge.idestudiantegeneral = e.idestudiantegeneral )"
            . " AND ( ge.codigoestado LIKE _utf8 '1%' ) ) ) )"
            . " LEFT JOIN tipogruposanguineo ts ON ( ( "
            . " ts.idtipogruposanguineo = ge.idtipogruposanguineo ) ) )"
            . " LEFT JOIN tarjetaestudiante tj ON ( ( "
            . " tj.idestudiantegeneral = e.idestudiantegeneral ) ) ) )"
            . " WHERE  ( "
            . " e.codigoestudiante = " . $codigoestudiante
            . " AND ( e.codigocarrera = c.codigocarrera )"
            . " AND ( eg.idestudiantegeneral = e.idestudiantegeneral )"
            . " AND ( c.codigomodalidadacademica IN ('100', '200', '300', '400') )"
            . " AND ( ee.codigoestudiante = e.codigoestudiante )"
            . " AND ( eg.tipodocumento = d.tipodocumento )"
            . " AND ( ee.codigoperiodo = ("
            . " SELECT "
            . " IF ( ("
            . " substr(periodo.codigoperiodo, 5, 5 ) = 2 ),"
            . " ( periodo.codigoperiodo - 1 ),"
            . " ( periodo.codigoperiodo - 9 ) ) AS periodoanterior"
            . " FROM "
            . " periodo "
            . " WHERE "
            . " ( periodo.codigoestadoperiodo IN ('1', '4') ) ) )"
            . " AND ( ee.codigoprocesovidaestudiante IN (400, 401) )"
            . " AND ( e.codigocarrera = 98 )"
            . " AND ( e.codigosituacioncarreraestudiante NOT IN (_utf8 '104', _utf8 '400') )"
            . " AND ( m.codigomodalidadacademica = c.codigomodalidadacademica )"
            . " AND ( ee.codigoestado LIKE _utf8 '1%' ) )";

    $mat = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante" . mysql_error());
    $valestudainte = mysql_fetch_assoc($mat);

    if (!is_array($valestudainte)) {
        /* CURSOS UNIVERSITARIOS */
        $query_dataestudiante = "SELECT "
                . " e.codigoestudiante AS codigoestudiante,"
                . " d.nombrecortodocumento AS nombrecortodocumento,"
                . " eg.numerodocumento AS numerodocumento,"
                . " eg.apellidosestudiantegeneral AS apellidosestudiantegeneral,"
                . " eg.nombresestudiantegeneral AS nombresestudiantegeneral,"
                . " e.codigocarrera AS codigocarrera,"
                . " c.nombrecarrera AS nombrecarrera,"
                . " m.nombremodalidadacademica AS nombremodalidadacademica,"
                . " pr.codigoperiodo AS codigoperiodo,"
                . " e.semestre AS semestre,"
                . " tj.codigotarjetaestudiante AS TarjetaInteligente,"
                . " ts.nombretipogruposanguineo AS TipoSanguineo"
                . " FROM ( ( ( ( "
                . " ( prematricula pr JOIN carrera c )"
                . " JOIN estudiantegeneral eg )"
                . " JOIN documento d )"
                . " JOIN modalidadacademica m )"
                . " JOIN ( ( ( "
                . " estudiante e "
                . " LEFT JOIN gruposanguineoestudiante ge ON ( ( ("
                . " ge.idestudiantegeneral = e.idestudiantegeneral )"
                . " AND ( ge.codigoestado LIKE '1%' ) )  ) )"
                . " LEFT JOIN tipogruposanguineo ts ON ( ( "
                . " ts.idtipogruposanguineo = ge.idtipogruposanguineo ) ) ) "
                . " LEFT JOIN tarjetaestudiante tj ON ( ("
                . " tj.idestudiantegeneral = e.idestudiantegeneral ) ) ) )"
                . " WHERE ( "
                . " e.codigoestudiante = '" . $codigoestudiante . "' "
                . " AND ( e.codigocarrera = c.codigocarrera ) "
                . " AND ( eg.idestudiantegeneral = e.idestudiantegeneral ) "
                . " AND c.codigocarrera IN ( "
                . " SELECT "
                . " carrera.codigocarrera "
                . " FROM "
                . " carrera "
                . " WHERE ( ( "
                . " carrera.nombrecarrera LIKE '%curso univ%' ) "
                . " AND ( carrera.codigomodalidadacademica = '400' ) ) )"
                . " AND ( pr.codigoestudiante = e.codigoestudiante ) "
                . " AND ( eg.tipodocumento = d.tipodocumento ) "
                . " AND ( pr.codigoperiodo IN ( "
                . " SELECT "
                . " periodo.codigoperiodo "
                . " FROM "
                . " periodo "
                . " WHERE ( "
                . " periodo.codigoestadoperiodo IN ('1', '4') ) ) ) "
                . " AND ( pr.codigoestadoprematricula = '40' ) "
                . " AND ( e.codigosituacioncarreraestudiante NOT IN ('104', '400') ) "
                . " AND ( m.codigomodalidadacademica = c.codigomodalidadacademica ) )";

        $mat = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante" . mysql_error());
        $valestudainte = mysql_fetch_assoc($mat);

        if (!is_array($valestudainte)) {
            /* EDUCACION CONTINUADA - TEMPORALES */

            $query_dataestudiante = "SELECT "
                    . " e.codigoestudiante AS codigoestudiante,"
                    . " d.nombrecortodocumento AS nombrecortodocumento,"
                    . " eg.numerodocumento AS numerodocumento,"
                    . " eg.apellidosestudiantegeneral AS apellidosestudiantegeneral,"
                    . " eg.nombresestudiantegeneral AS nombresestudiantegeneral,"
                    . " e.codigocarrera AS codigocarrera,"
                    . " c.nombrecarrera AS nombrecarrera,"
                    . " m.nombremodalidadacademica AS nombremodalidadacademica,"
                    . " e.codigoperiodo AS codigoperiodo,"
                    . " e.semestre AS semestre,"
                    . " tj.codigotarjetaestudiante AS TarjetaInteligente,"
                    . " ts.nombretipogruposanguineo AS TipoSanguineo"
                    . " FROM "
                    . " TemporalCarnetizacion tmp "
                    . " INNER JOIN estudiante e ON e.idestudiantegeneral = tmp.idestudiantegeneral "
                    . " AND e.codigoestudiante = " . $codigoestudiante 
                    . " INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral "
                    . " INNER JOIN carrera c ON c.codigocarrera = e.codigocarrera "
                    . " INNER JOIN documento d ON d.tipodocumento = eg.tipodocumento "
                    . " INNER JOIN modalidadacademica m ON m.codigomodalidadacademica = c.codigomodalidadacademica "
                    . " LEFT JOIN gruposanguineoestudiante ge ON ge.idestudiantegeneral = e.idestudiantegeneral "
                    . " AND ge.codigoestado LIKE '1%' "
                    . " LEFT JOIN tipogruposanguineo ts ON ts.idtipogruposanguineo = ge.idtipogruposanguineo "
                    . " LEFT JOIN tarjetaestudiante tj ON ( tj.idestudiantegeneral = e.idestudiantegeneral ) "
                    . " WHERE "
                    . " tmp.codigoestado LIKE '1%' ";

            $mat = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante" . mysql_error());
            $valestudainte = mysql_fetch_assoc($mat);
        }
    }
}

/* verificar si es egresado.. si es debe permitir generar el carne */

$estuegresado = new table("estudiante");
$estuegresado->sql_select = "codigoestudiante";
$estuegresado->sql_where = " codigoestudiante='$codigoestudiante' and codigosituacioncarreraestudiante in  (104,400)";
$estuegresado = $estuegresado->getData();
$estuegresado = $estuegresado[0];
if (is_array($deuda)) {
    echo "<script type='text/javascript'>alert('El Estudiante tiene el carnet suspendido, favor dirigirse a seguridad.');</script>";
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../prematricula/matriculaautomaticaordenmatricula.php'>";
    exit();
} else if (!is_array($valestudainte)) {
    if (!is_array($estuegresado)) {
        echo "<script type='text/javascript'>alert('El Estudiante no se encuentra matriculado, favor dirigirse a la facultad.');</script>";
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../prematricula/matriculaautomaticaordenmatricula.php'>";
        exit();
    }
}

$query_dataestudiante = "SELECT eg.*, e.codigojornada, e.semestre, e.codigotipoestudiante,
e.codigosituacioncarreraestudiante, e.codigoestudiante, e.codigocarrera
FROM estudiante e, estudiantegeneral eg
WHERE 
e.codigoestudiante = '$codigoestudiante'
and eg.idestudiantegeneral = e.idestudiantegeneral";
$dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante" . mysql_error());
$row_dataestudiante = mysql_fetch_assoc($dataestudiante);
$totalRows_dataestudiante = mysql_num_rows($dataestudiante);
$idestudiantegeneral = $row_dataestudiante['idestudiantegeneral'];
$numerodocumentoinicial = $row_dataestudiante['numerodocumento'];

$carrera = new table("carrera");
$carrera->sql_select = "nombrecarrera";
$carrera->sql_where = " codigocarrera = '" . $row_dataestudiante['codigocarrera'] . "' ";
$carrera = $carrera->getData();
$nombrecarrera = $carrera[0]['nombrecarrera'];

if ($totalRows_dataestudiante != "") {
    $formulariovalido = 1;

    $gruposanguinew = new table("gruposanguineoestudiante");
    $gruposanguinew->sql_select = "idtipogruposanguineo";
    $gruposanguinew->sql_where = " idestudiantegeneral = '$idestudiantegeneral' and codigoestado like '1%'";
    $idgruposanguineo_est = $gruposanguinew->getData();
    $idgruposanguineo_est = $idgruposanguineo_est[0]['idtipogruposanguineo'];

    $query_dataestudianteplan = "select *
    from planestudioestudiante pee, planestudio p
    where pee.codigoestudiante = '$codigoestudiante'
    and p.idplanestudio = pee.idplanestudio
    and p.codigoestadoplanestudio like '1%'
    and pee.codigoestadoplanestudioestudiante like '1%'";

    $dataestudianteplan = mysql_query($query_dataestudianteplan, $sala) or die("$query_dataestudiante" . mysql_error());
    $row_dataestudianteplan = mysql_fetch_assoc($dataestudianteplan);
    $totalRows_dataestudianteplan = mysql_num_rows($dataestudianteplan);

    $regtarjetaestudiante = new table("tarjetaestudiante");
    $regtarjetaestudiante->sql_select = "codigotarjetaestudiante";
    $regtarjetaestudiante->sql_where = " idestudiantegeneral = '$idestudiantegeneral' and codigoestado like '1%'";
    $codigotarjeta = $regtarjetaestudiante->getData();
    $codigotarjeta = $codigotarjeta[0]['codigotarjetaestudiante'];
    ?>


    <html>
        <head>
            <title>Crear Estudiante</title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <script src="../js/jquery.js" language="JavaScript" type="text/javascript"></script>
            <script>
                function val_texto(e) {
                    tecla = (document.all) ? e.keyCode : e.which;
                    if (tecla == 8 || tecla == 0 || tecla == 32)
                        return true;
                    patron = /[A-ZÑÁÉÍÓÚ\s]+$/;
                    te = String.fromCharCode(tecla);
                    return patron.test(te);
                }
            </script>
            <script>
                function val_email(e) {
                    tecla = (document.all) ? e.keyCode : e.which;
                    if (tecla == 8 || tecla == 0 || tecla == 32)
                        return true;
                    patron = /[0-9a-zA-Z\-\.\@\s]+$/;
                    te = String.fromCharCode(tecla);
                    return patron.test(te);
                }
            </script>
        </head>
        <style type="text/css">    
            <!--
            * {font-family: Tahoma; font-size: 12px;}
            .Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;background-color: #C5D5D6; text-align: center;}
            .Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
            .Estilo4 {color: #FF0000}
            -->
        </style>
        <body>
            <form name="form1" method="post" action="editarestudiantecarnetizacion.php?codigocreado=<?php echo $codigoestudiante; ?>&usuarioeditar=<?php echo $usuarioeditar; ?>">
                <p align="center" class="Estilo3">EDITAR ESTUDIANTE</p>
                <center><h2>Por favor digitar en mayusculas los campos de Apellidos y Nombres</h2></center>
                <table width="876" border="1" align="center" cellpadding="1">
                    <tr>
                        <td  class="Estilo2">Facultad<span class="Estilo4">*</span></td>
                        <td colspan="2"><?php echo $nombrecarrera; ?></td>
                        <td colspan="1" class="Estilo2">Plan de Estudio<span class="Estilo4">*</span></td>
                        <td colspan="2"><span>
                                <?php
                                if ($_SESSION['MM_Username'] == 'dirsecgeneral') { 
                                    if ($row_dataestudianteplan['idplanestudio'] <> "") {
                                        $planestudiante = $row_dataestudianteplan['idplanestudio'];
                                    } else {
                                        $planestudiante = 1;
                                    }
                                    echo '<input type="hidden" name="planestudio" value="' . $planestudiante . '">';
                                    echo $planestudiante;
                                } else {
                                    //Valida que el estudidante no tenga prematricula para el periodo activo, si la tiene ya no le permite cambiar el plan de estudio
                                    $query_prematriculaviva = "select distinct p.codigoestudiante
                                    from prematricula p, estudiante e, detalleprematricula d, periodo pe
                                    where p.codigoestudiante = e.codigoestudiante
                                    and p.idprematricula = d.idprematricula
                                    and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
                                    and (d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula like '3%')
                                    and pe.codigoperiodo = p.codigoperiodo                    
                                    and e.codigoestudiante = '$codigoestudiante' and pe.codigoestadoperiodo in(1,3) ";

                                    $prematriculaviva = mysql_query($query_prematriculaviva, $sala) or die($query_prematriculaviva);
                                    $row_prematriculaviva = mysql_fetch_assoc($prematriculaviva);
                                    $totalRows_prematriculaviva = mysql_num_rows($prematriculaviva);

                                    if ($totalRows_prematriculaviva == "") {
                                        $query_planestudios = "SELECT nombreplanestudio,idplanestudio FROM planestudio where codigocarrera = '" . $row_dataestudiante['codigocarrera'] . "'
                                        and codigoestadoplanestudio like '1%'";
                                        if (isset($_POST['planestudio'])) {
                                            $planestudio = $_POST['planestudio'];
                                        } else {
                                            $planestudio = $row_dataestudianteplan['idplanestudio'];
                                        }
                                        $registroplanestudio = $db->Execute($query_planestudios);
                                        echo $registroplanestudio->GetMenu2('planestudio', $planestudio, false, false, 1, ' disabled="disabled"');
                                    } else {
                                        echo '<input type="hidden" name="planestudio" value="' . $row_dataestudianteplan['idplanestudio'] . '">';
                                        if (isset($row_dataestudianteplan['nombreplanestudio'])) {
                                            echo $row_dataestudianteplan['nombreplanestudio'];
                                        } else {
                                            echo "No tiene";
                                        }
                                    }
                                }
                                ?>
                            </span>        
                            <?php
                            echo "<span class='Estilo4'>";
                            if ($_SESSION['MM_Username'] <> 'dirsecgeneral') {
                                if (isset($_POST['planestudio'])) {
                                    $planestudio = $_POST['planestudio'];
                                    $imprimir = true;
                                    $prequerido = validar($planestudio, "combo", $error1, $imprimir);
                                    if ($_POST['planestudio'] == '1') {
                                        echo "Seleccionar plan de estudio";
                                    }
                                }
                            }
                            echo "</span>";
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td  class="Estilo2">Apellidos<span class="Estilo4">*</span></td>
                        <td>
                            <input name="apellidos" type="text" id="apellidos" value="<?php if (isset($_POST['apellidos']))
                            echo $_POST['apellidos'];
                        else
                            echo $row_dataestudiante['apellidosestudiantegeneral'];
                            ?>" size="30" onkeypress="return val_texto(event)">
                                   <?php
                                   echo "<span class='Estilo4'>";
                                   if (isset($_POST['apellidos'])) {
                                       $apellidos = $_POST['apellidos'];
                                       $imprimir = true;
                                       $arequerido = validar($apellidos, "requerido", $error1, $imprimir);
                                       $formulariovalido = $formulariovalido * $arequerido;
                                   }
                                   echo "</span>";
                                   ?>
                        </td>
                        <td class="Estilo2">Nombres<span class="Estilo4">*</span></td>
                        <td>
                            <input name="nombres" type="text" id="nombres2" value="<?php if (isset($_POST['nombres']))
                                       echo $_POST['nombres'];
                                   else
                                       echo $row_dataestudiante['nombresestudiantegeneral'];
                                   ?>" size="30" onkeypress="return val_texto(event)">
                                   <?php
                                   echo "<span class='Estilo4'>";
                                   if (isset($_POST['nombres'])) {
                                       $nombres = $_POST['nombres'];
                                       $imprimir = true;
                                       $nrequerido = validar($nombres, "requerido", $error1, $imprimir);
                                       $formulariovalido = $formulariovalido * $nrequerido;
                                   }
                                   echo "</span>";
                                   ?>
                        </td>
                        <td class="Estilo2">Fecha de Nacimiento<span class="Estilo4">*</span></td>
                        <td>
                            <input name="fnacimiento" type="text" size="10" value="<?php if (isset($_POST['fnacimiento']))
                                   echo $_POST['fnacimiento'];
                               else
                                   echo ereg_replace(" [0-9]+:[0-9]+:[0-9]+", "", $row_dataestudiante['fechanacimientoestudiantegeneral']);
                                   ?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)">
                                   <?php
                                   if (isset($_POST['fnacimiento'])) {
                                       $fnacimiento = $_POST['fnacimiento'];
                                       $imprimir = true;
                                       $anio = substr($fnacimiento, 0, 1);
                                       $ffecha = validar($fnacimiento, "fechaant", $error3, $imprimir, $anio);
                                       $formulariovalido = $formulariovalido * $ffecha;
                                   }
                                   ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="Estilo2">T. Documento<span class="Estilo4">*</span></td>
                        <td>                   
                            <input type='hidden' name='tipodocumentoold' value='<?php echo $row_dataestudiante['tipodocumento'] ?>'>
                            <?php
                            if (isset($_POST['tipodocumento'])) {
                                $tipodocumento = $_POST['tipodocumento'];
                            } else {
                                $tipodocumento = $row_dataestudiante['tipodocumento'];
                            }
                            $query_tipodocenteadministrativo = "SELECT nombredocumento,tipodocumento FROM documento order by 1 desc";
                            $reg_tipodoc = $db->Execute($query_tipodocenteadministrativo);
                            echo $reg_tipodoc->GetMenu2('tipodocumento', $tipodocumento, false, false, 1, ' ');

                            echo "<span class='Estilo4'>";
                            if (isset($_POST['tipodocumento'])) {
                                $tipodocumento = $_POST['tipodocumento'];
                                $imprimir = true;
                                $tdrequerido = validar($tipodocumento, "combo", $error1, $imprimir);
                                $formulariovalido = $formulariovalido * $tdrequerido;
                            }
                            echo "</span>";
                            ?>            
                        </td>
                        <td class="Estilo2">N&uacute;mero<span class="Estilo4">*</span></td>
                        <td>            
                            <input name="documento" type="text" id="documento2" value="<?php if (isset($_POST['documento']))
                                   echo $_POST['documento'];
                               else
                                   echo $row_dataestudiante['numerodocumento'];
                            ?>" size="20">
                            <input name="documentoold" type="hidden" value="<?php if (isset($_POST['documento']))
                                   echo $_POST['documento'];
                               else
                                   echo $row_dataestudiante['numerodocumento'];
                               ?>">
                                   <?php
                                   echo "<span class='Estilo4'>";
                                   if (isset($_POST['documento'])) {
                                       $documento = $_POST['documento'];
                                       $imprimir = true;
                                       $ndrequerido = validar($documento, "requerido", $error1, $imprimir);
                                       $ndnumero = validar($documento, "numero", $error2, $imprimir);
                                       $formulariovalido = $formulariovalido * $ndrequerido * $ndnumero;
                                   }
                                   echo "</span>";
                                   ?>            
                        </td>
                        <td class="Estilo2">Expedido en<span class="Estilo4">*</span></td>
                        <td>
                            <input name="expedido" type="text" id="expedido3" value="<?php if (isset($_POST['expedido']))
                                   echo $_POST['expedido'];
                               else
                                   echo $row_dataestudiante['expedidodocumento'];
                                   ?>" size="19">
                                    <?php
                                    echo "<span class='Estilo4'>";
                                    if (isset($_POST['expedido'])) {
                                        $expedido = $_POST['expedido'];
                                        $imprimir = true;
                                        $erequerido = validar($expedido, "requerido", $error1, $imprimir);
                                        $formulariovalido = $formulariovalido * $erequerido;
                                    }
                                    echo "</span>";
                                    ?>
                        </td>
                    </tr>    
                    <tr>
                        <td class="Estilo2">N&utilde;mero Tarjeta Inteligente<span class="Estilo4">*</span></td>
                        <td>
                            <input name="numerotarjeta" type="text" value="<?php if (isset($_POST['numerotarjeta']))
                            echo $_POST['numerotarjeta'];
                        else
                            echo $codigotarjeta;
                        ?>" size="20">
                        </td>
                        <td class="Estilo2">Semestre<span class="Estilo4">*</span></td>
                        <td>
                            <select name="semestre" disabled="disabled">
                                <option value="<?php echo $row_dataestudiante['semestre'] ?>" selected><?php echo $row_dataestudiante['semestre'] ?></option>
                            </select>
                            <?php
                            echo "<span class='Estilo4'>";
                            if (isset($_POST['semestre'])) {
                                $semestre = $_POST['semestre'];
                                $imprimir = true;
                                $srequerido = validar($semestre, "combo", $error1, $imprimir);
                                $formulariovalido = $formulariovalido * $srequerido;
                            }
                            echo "</span>";
                            ?>
                            &nbsp;
                        </td>        
                        <td  class="Estilo2">Grupo Sanguineo<span class="Estilo4">*</span></td>
                        <td>
                        <?php
                        $query_tipodocenteadministrativo = "SELECT nombretipogruposanguineo,idtipogruposanguineo FROM tipogruposanguineo order by 1";
                        $registrostipousuario = $db->Execute($query_tipodocenteadministrativo);
                        if (isset($_POST['gruposanguineo'])) {
                            $gruposanguineo = $_POST['gruposanguineo'];
                        } else {
                            $gruposanguineo = $idgruposanguineo_est;
                        }
                        echo $registrostipousuario->GetMenu2('gruposanguineo', $gruposanguineo, false, false, 1, ' id="select10"');
                        echo "<span class='Estilo4'>";
                        if (isset($_POST['gruposanguineo'])) {
                            $gruposanguineo = $_POST['gruposanguineo'];
                            $imprimir = true;
                            $jrequerido = validar($gruposanguineo, "combo", $error1, $imprimir);
                            $formulariovalido = $formulariovalido * $jrequerido;
                        }
                        echo "</span>";
                        ?>        
                        </td>
                    </tr>
                    <tr>
                        <td  class="Estilo2">Jornada<span class="Estilo4">*</span></td>
                        <td>
                            <?php
                            $jornada = $db->Execute("SELECT nombrejornada,codigojornada FROM jornada");
                            echo $jornada->GetMenu2('jornada', $row_dataestudiante['codigojornada'], false, false, 1, ' id="select10" disabled="disabled"');
                            ?>
                        </td>
                        <td  class="Estilo2">Tipo Estudiante<span class="Estilo4">*</span></td>        
                        <td>            
                                <?php
                                $query_tipoestudiante = "SELECT nombretipoestudiante ,codigotipoestudiante  FROM tipoestudiante";
                                $reg_tipoestudiante = $db->Execute($query_tipoestudiante);
                                echo $reg_tipoestudiante->GetMenu2('tipoestudiante', $row_dataestudiante['codigotipoestudiante'], false, false, 1, ' id="select13" disabled="disabled" ');
                                ?>            
                                <?php
                                echo "<span class='Estilo4'>";
                                if (isset($_POST['tipoestudiante'])) {
                                    $tipoestudiante = $_POST['tipoestudiante'];
                                    $imprimir = true;
                                    $trequerido = validar($tipoestudiante, "combo", $error1, $imprimir);
                                    $formulariovalido = $formulariovalido * $trequerido;
                                }
                                echo "</span>";
                                ?>
                        </td>        
                        <td  class="Estilo2">Genero<span class="Estilo4">*</span></td>
                        <td colspan="1">
                            <div >
                            <?php
                            if (isset($_POST['genero'])) {
                                $genero = $_POST['genero'];
                            } else {
                                $genero = $row_dataestudiante['codigogenero'];
                            }
                            $query_tipodocenteadministrativo = "SELECT nombregenero,codigogenero FROM genero";
                            $registrostipousuario = $db->Execute($query_tipodocenteadministrativo);
                            echo $registrostipousuario->GetMenu2('genero', $genero, false, false, 1, ' ');

                            echo "<span class='Estilo4'>";
                            if (isset($_POST['genero'])) {
                                $genero = $_POST['genero'];
                                $imprimir = true;
                                $grequerido = validar($genero, "combo", $error1, $imprimir);
                                $formulariovalido = $formulariovalido * $grequerido;
                            }
                            echo "</span>";
                            ?>
                            </div>
                        </td>
                    </tr>    
                    <tr>
                        <td  class="Estilo2">Celular</td>
                        <td>
                            <input name="celular" type="text" value="<?php if (isset($_POST['celular']))
                                   echo $_POST['celular'];
                               else
                                   echo $row_dataestudiante['celularestudiantegeneral'];
                               ?>" size="30">
                        </td>
                        <td  class="Estilo2">E-mail</td>
                        <td>
                            <input name="email" type="text" id="email3" value="<?php if (isset($_POST['email']))
                                   echo $_POST['email'];
                               else
                                   echo $row_dataestudiante['emailestudiantegeneral'];
                            ?>" size="20" onkeypress="return val_email(event)">
                        </td>
                        <td class="Estilo2">Tel&eacute;fono<span class="Estilo4">*</span></td>
                        <td  >
                            <input name="telefono1" type="text" id="telefono13" value="<?php if (isset($_POST['telefono1']))
                                   echo $_POST['telefono1'];
                               else
                                   echo $row_dataestudiante['telefonoresidenciaestudiantegeneral'];
                               ?>" size="22">
                            <?php
                            echo "<span class='Estilo4'>";
                            if (isset($_POST['telefono1'])) {
                                $telefono1 = $_POST['telefono1'];
                                $imprimir = true;
                                $t1requerido = validar($telefono1, "requerido", $error1, $imprimir);
                                $formulariovalido = $formulariovalido * $t1requerido;
                            }
                            echo "</span>";
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td height="27" class="Estilo2">Dir. Estudiante<span class="Estilo4">*</span></td>
                        <td colspan="2" >&nbsp;
                            <INPUT name="direccion1" size="40" readonly onclick="window.open('../facultades/creacionestudiante/direccion.php?inscripcion=1', 'direccion', 'width=1000,height=300,left=150,top=150,scrollbars=yes')"  value="<?php if (isset($_POST['direccion1']))
                            echo $_POST['direccion1'];
                        else
                            echo $row_dataestudiante['direccionresidenciaestudiantegeneral'];
                        ?>">
                            <input name="direccion1oculta" type="hidden" value="<?php if (isset($_POST['direccion1oculta']))
                            echo $_POST['direccion1oculta'];
                        else
                            echo $row_dataestudiante['direccioncortaresidenciaestudiantegeneral'];
                            ?>">
                            <?php
                            echo "<span class='Estilo4'>";
                            if ($_POST['direccion1'] == "" and $_POST['guardar']) {
                                echo '<script language="JavaScript">alert("Debe Digitar una Direccion de Residencia"); history.go(-1);</script>';
                            }
                            echo "</span>";
                            ?>
                        </td>
                        <td class="Estilo2"><span>Ciudad Residencia</span><span class="Estilo4">*</span></td>
                        <td colspan="2">
                        <?php
                        if (isset($_POST['ciudad1'])) {
                            $ciudad1 = $_POST['ciudad1'];
                        } else {
                            $ciudad1 = $row_dataestudiante['ciudadresidenciaestudiantegeneral'];
                        }

                        $registrosciudad = $db->Execute("select substring(concat(nombreciudad,'-', nombredepartamento),1,40) as nombreciudad ,c.idciudad
                    from ciudad c inner join departamento d on c.iddepartamento = d.iddepartamento order by 1");
                        echo $registrosciudad->GetMenu2('ciudad1', $ciudad1, false, false, 1, ' ');

                        echo "<span class='Estilo4'>";
                        if ($_POST['ciudad1'] == 0 and $_POST['guardar']) {
                            echo '<script language="JavaScript">alert("Debe Seleccionar una ciudad de residencia"); history.go(-1);</script>';
                        }
                        echo "</span>";
                        ?>
                        </td>
                    </tr>    
                </table>

                <?php
                if ($_POST['guardar']) {
                    $_POST['nombres'] = strtoupper($_POST['nombres']);
                    $_POST['apellidos'] = strtoupper($_POST['apellidos']);
                    if (trim($numerodocumentoinicial) == '0' || trim($numerodocumentoinicial) == '' || !isset($numerodocumentoinicial)){
                        $formulariovalido = 0;
                    }
                    
                    if (trim($_POST['documento']) == '0' || trim($_POST['documento']) == '' || !isset($_POST['documento'])) {
                        $formulariovalido = 0;
                        echo "<script language='javascript'>alert('El numero del documento no puede ser cero')</script>";
                        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
                    }

                    if ($formulariovalido) {
                        $obj_table = new table("estudiantedocumento");
                        $obj_table->sql_where = " numerodocumento = '" . $_POST['documento'] . "' and idestudiantegeneral <> '$idestudiantegeneral'
                        and fechainicioestudiantedocumento <= '" . date("Y-m-d H:m:s", time()) . "'
                        and fechavencimientoestudiantedocumento >= '" . date("Y-m-d H:m:s", time()) . "' ";
                        $obj_result = $obj_table->getData();
                        $obj_result = $obj_result[0];
                        // Se valida primero si el nuevo  documento que se quiere insertar no este ya en estudiantedocumento en los activos
                        // Esto para los estudiantes que son diferentes al actual
                        if (is_array($obj_result)) {
                            echo '<script language="JavaScript">alert("El documento ' . $_POST['documento'] . ' ya existe en el sistema"); hisroty.go(-1)</script>';
                            exit();
                        }
                        /*                         * ************************************************* */
                        $obj_table->tablename = "gruposanguineoestudiante";
                        $obj_table->setFields();
                        $fieldarray = array('idtipogruposanguineo' => $_POST['gruposanguineo'], 'idestudiantegeneral' => $idestudiantegeneral, 'codigoestado' => 100);
                        if ($idgruposanguineo_est == "" || !isset($idgruposanguineo_est)) {
                            $obj_table->insertRecord($fieldarray);
                        } else {
                            $obj_table->fieldlist['idestudiantegeneral'] = array('pkey' => 'y');
                            $obj_table->fieldlist['codigoestado'] = array('pkey' => 'y');
                            $obj_table->updateRecord($fieldarray);
                        }


                        $obj_table->tablename = "estudiantegeneral";
                        $obj_table->setFields();
                        $fieldarray = array(
                            'tipodocumento' => $_POST['tipodocumento'],
                            'numerodocumento' => $_POST['documento'],
                            'expedidodocumento' => $_POST['expedido'],
                            'nombrecortoestudiantegeneral' => $_POST['documento'],
                            'nombresestudiantegeneral' => $_POST['nombres'],
                            'apellidosestudiantegeneral' => $_POST['apellidos'],
                            'fechanacimientoestudiantegeneral' => $_POST['fnacimiento'],
                            'codigogenero' => $_POST['genero'],
                            'direccionresidenciaestudiantegeneral' => $_POST['direccion1'],
                            'direccioncortaresidenciaestudiantegeneral' => $_POST['direccion1oculta'],
                            'ciudadresidenciaestudiantegeneral' => $_POST['ciudad1'],
                            'telefonoresidenciaestudiantegeneral' => $_POST['telefono1'],
                            'celularestudiantegeneral' => $_POST['celular'],
                            'emailestudiantegeneral' => $_POST['email'],
                            'fechaactualizaciondatosestudiantegeneral' => date("Y-m-d G:i:s", time()),
                            'idestudiantegeneral' => $idestudiantegeneral
                        );
                        $obj_table->fieldlist['idestudiantegeneral'] = array('pkey' => 'y');
                        $obj_table->updateRecord($fieldarray);

                        /*                         * ************************************************* */

                        $fechahoy = date("Y-m-d G:i:s", time());
                        $obj_table = new table("tarjetaestudiante");
                        $obj_table->setFields();
                        $fieldarray_tarjeta = array('codigotarjetaestudiante' => $_POST['numerotarjeta'], 'idestudiantegeneral' => $idestudiantegeneral, 'fechaactivaciontarjetaestudiante' => $fechahoy, 'sinc_andover' => 1);
                        $objAndor = new class_andor($documento);
                        $NivelAcceso = 1;
                        /* dejamos activa la tarjeta en el cardholder del web service> */
                        /* activa la tarjeta si existe si no la crea */
                        $objAndor->setNivelAcceso($NivelAcceso);
                        if ($_POST['numerotarjeta'] == "" || !isset($_POST['numerotarjeta'])) {
                            echo "<script language='javascript'>alert('El campo  Numero Tarjeta Inteligente esta vacio.')</script>";
                            echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=editarestudiantecarnetizacion.php?usuarioeditar=" . $_REQUEST['usuarioeditar'] . "&codigocreado=" . $_REQUEST['codigocreado'] . "&facultad=" . $_SESSION['codigofacultad'] . "'>";
                            exit;
                        } elseif ($codigotarjeta == "" || !isset($codigotarjeta)) {
                            $fieldarray_tarjeta['codigoestado'] = 100;
                            $obj_table->insertRecord($fieldarray_tarjeta);
                        } elseif ($_POST['numerotarjeta'] != $codigotarjeta) {
                            $obj_table->fieldlist['idestudiantegeneral'] = array('pkey' => 'y');
                            $obj_table->fieldlist['codigotarjetaestudiante'] = array('pkey' => 'y');
                            $fieldarray_tarjeta['codigotarjetaestudiante'] = $codigotarjeta;
                            $fieldarray_tarjeta['codigoestado'] = 200;
                            $obj_table->updateRecord($fieldarray_tarjeta);
                            $fieldarray_tarjeta['codigotarjetaestudiante'] = $_POST['numerotarjeta'];
                            $fieldarray_tarjeta['codigoestado'] = 100;
                            $obj_table->insertRecord($fieldarray_tarjeta);
                        }

                        if (isset($_POST['documento'])){
                            $documento = $_POST['documento'];
                        }else{
                            $documento = $row_dataestudiante['numerodocumento'];
                        }
                        $objAndor->setDocumento($documento);
                        $objAndor->setNumeroTarjeta($_REQUEST['numerotarjeta']);
                        if ($objAndor->servidor_activo()) {
                            $rsutl = $objAndor->get_ws_result();
                        }
                        /* debo crearlo por que no tiene la tarjeta */
                        if ($rsutl[0]['NumeroTarjeta'] == "") {
                            $objAndor->setApellido($_REQUEST['apellidos']);
                            $objAndor->setNombres($_REQUEST['nombres']);
                            if ($objAndor->servidor_activo()) {
                                $rsutl = $objAndor->set_ws_result();
                            }
                        } else {
                            /* debo actualizar con los datos resultado del card holder WS */
                            $objAndor->setApellido($rsutl[0]['Apellido']);
                            $objAndor->setNombres($rsutl[0]['Nombres']);
                            if ($objAndor->servidor_activo()) {
                                $rsutl = $objAndor->set_ws_result();
                            }
                        }

                        $objAndor->setNivelAcceso($NivelAcceso);
                        $objAndor->setApellido('');
                        $objAndor->setNombres('');
                        if ($objAndor->servidor_activo()) {
                            $rsutl = $objAndor->get_ws_result();
                        }

                        if ($objAndor->servidor_activo()) {
                            $tableCardHolder = $objAndor->table_cardholder($rsutl);
                        }

                        if ($_POST['documento'] <> $numerodocumentoinicial) {
                            $obj_table->tablename = "estudiantedocumento";
                            $obj_table->setFields();
                            $fieldarray = array('idestudiantegeneral' => $idestudiantegeneral, 'tipodocumento' => $_POST['tipodocumento'],
                                'numerodocumento' => $_POST['documento'], 'expedidodocumento' => $_POST['expedido'],
                                'fechainicioestudiantedocumento' => $fechahoy, 'fechavencimientoestudiantedocumento' => '2999-12-31');
                            $obj_table->insertRecord($fieldarray);

                            $fechahabil = date("Y-m-d");
                            $unDiaMenos = strtotime("-1 day", strtotime($fechahabil));
                            $fechahabil = date("Y-m-d", $unDiaMenos);
                            $fieldarray['fechavencimientoestudiantedocumento'] = $fechahabil;
                            $obj_table->fieldlist['idestudiantegeneral'] = array('pkey' => 'y');
                            $obj_table->fieldlist['numerodocumento'] = array('pkey' => 'y');
                            $obj_table->updateRecord($fieldarray);
                            $db->Execute("UPDATE usuario   SET numerodocumento = '" . $_POST['documento'] . "'
                            WHERE numerodocumento = '$numerodocumentoinicial'");
                        }

                        $obj_table->tablename = "estudiantedocumento";
                        $obj_table->sql_where = " idestudiantegeneral = '$idestudiantegeneral' ";
                        $estudiantedoc = $obj_table->getData();
                        if (is_array($estudiantedoc)) {
                            foreach ($estudiantedoc as $reg_estudiante)
                                $db->Execute("UPDATE usuario   SET numerodocumento = '" . $_POST['documento'] . "'
                                WHERE numerodocumento = '" . $reg_estudiante['numerodocumento'] . "'");
                        }


                        $obj_table->tablename = "usuario";
                        $obj_table->sql_where = " numerodocumento='" . $_POST['documento'] . "'";
                        $usuario = $obj_table->getData();

                        if (is_array($usuario)) {
                            $objetoldap = new claseldap(SERVIDORLDAP, CLAVELDAP, PUERTOLDAP, CADENAADMINLDAP, "", RAIZDIRECTORIO);
                            $objetoldap->ConexionAdmin();
                            foreach ($usuario as $resultado) {
                                $infomodificado["gacctMail"] = $_POST['email'];
                                if (!$objetoldap->ModificacionUsuario($infomodificado, $resultado["usuario"])) {
                                    $objetoldap->AdicionUsuario($infomodificado, $resultado["usuario"]);
                                }
                            }
                        }
                        if ($_SESSION['MM_Username'] == 'dirsecgeneral') {
                            echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=editarestudiantecarnetizacion.php?codigocreado=" . $codigoestudiante . "'>";
                            echo '<script language="JavaScript">history.go(-2);</script>';
                            exit();
                        }else{
                            echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../prematricula/matriculaautomaticaordenmatricula.php'>";
                            echo "<script>alert('Informacion Actualizada Correctamente.')</script>";
                            exit();                            
                        }
                        

                        $centralData = array('SEARCHTERM1' => $_POST['documento'], 'SEARCHTERM2' => '', 'PARTNERTYPE' => '',
                            'AUTHORIZATIONGROUP' => '', 'PARTNERLANGUAGE' => '', 'PARTNERLANGUAGEISO' => '',
                            'DATAORIGINTYPE' => '', 'CENTRALARCHIVINGFLAG' => '', 'CENTRALBLOCK' => '', 'TITLE_KEY' => '',
                            'CONTACTALLOWANCE' => '', 'PARTNEREXTERNAL' => '', 'TITLELETTER' => '', 'NOTRELEASED' => '', 'COMM_TYPE' => '');

                        $centralDataX = array('SEARCHTERM1' => 'X', 'SEARCHTERM2' => '', 'PARTNERTYPE' => '', 'AUTHORIZATIONGROUP' => '',
                            'PARTNERLANGUAGE' => '', 'PARTNERLANGUAGEISO' => '', 'DATAORIGINTYPE' => '', 'CENTRALARCHIVINGFLAG' => '',
                            'CENTRALBLOCK' => '', 'TITLE_KEY' => '', 'CONTACTALLOWANCE' => '', 'PARTNEREXTERNAL' => '', 'TITLELETTER' => '',
                            'NOTRELEASED' => '', 'COMM_TYPE' => '');

                        $dataPersona = array('FIRSTNAME' => $_POST['nombres'], 'LASTNAME' => $_POST['apellidos'], 'BIRTHNAME' => '',
                            'MIDDLENAME' => '', 'SECONDNAME' => '', 'TITLE_ACA1' => '', 'TITLE_ACA2' => '', 'TITLE_SPPL' => '', 'PREFIX1' => '',
                            'PREFIX2' => '', 'NICKNAME' => '', 'INITIALS' => '', 'NAMEFORMAT' => '', 'NAMCOUNTRY' => '', 'NAMCOUNTRYISO' => '',
                            'SEX' => '', 'BIRTHPLACE' => '', 'BIRTHDATE' => '', 'DEATHDATE' => '', 'MARITALSTATUS' => '', 'CORRESPONDLANGUAGE' => '',
                            'CORRESPONDLANGUAGEISO' => '', 'FULLNAME' => $_POST['apellidos'] . ' ' . $_POST['nombres'], 'EMPLOYER' => '',
                            'OCCUPATION' => '', 'NATIONALITY' => '', 'NATIONALITYISO' => '', 'COUNTRYORIGIN' => '');

                        $dataPersonaX = array('FIRSTNAME' => 'X', 'LASTNAME' => 'X', 'BIRTHNAME' => '', 'MIDDLENAME' => '', 'SECONDNAME' => '',
                            'TITLE_ACA1' => '', 'TITLE_ACA2' => '', 'TITLE_SPPL' => '', 'PREFIX1' => '', 'PREFIX2' => '', 'NICKNAME' => '', 'INITIALS' => '',
                            'NAMEFORMAT' => '', 'NAMCOUNTRY' => '', 'NAMCOUNTRYISO' => '', 'SEX' => '', 'BIRTHPLACE' => '', 'BIRTHDATE' => '',
                            'DEATHDATE' => '', 'MARITALSTATUS' => '', 'CORRESPONDLANGUAGE' => '', 'CORRESPONDLANGUAGEISO' => '',
                            'FULLNAME' => 'X', 'EMPLOYER' => '', 'OCCUPATION' => '', 'NATIONALITY' => '', 'NATIONALITYISO' => '', 'COUNTRYORIGIN' => '');

                        if (isset($_POST['telefono1'])) {
                            $telefonoData = array(
                                'COUNTRY' => '', 'COUNTRYISO' => '', 'STD_NO' => '', 'TELEPHONE' => $_POST['telefono1'],
                                'EXTENSION' => '', 'TEL_NO' => '', 'CALLER_NO' => '', 'STD_RECIP' => '', 'R_3_USER' => '',
                                'HOME_FLAG' => '', 'CONSNUMBER' => '000', 'ERRORFLAG' => '', 'FLG_NOUSE' => '');

                            $telefonoDataX = array('COUNTRY' => '', 'COUNTRYISO' => '', 'STD_NO' => '', 'TELEPHONE' => 'X',
                                'EXTENSION' => '', 'TEL_NO' => '', 'CALLER_NO' => '', 'STD_RECIP' => '', 'R_3_USER' => '',
                                'HOME_FLAG' => '', 'CONSNUMBER' => 'X', 'UPDATEFLAG' => 'U', 'FLG_NOUSE' => ''
                            );
                        }
                        $interlocutor = $idestudiantegeneral;
                        require_once('../../interfacessap/modificarinterlocutorDirectamente.php');

                        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../prematricula/loginpru.php?codigocarrera=" . $row_dataestudiante['codigocarrera'] . "&estudiante=" . $row_dataestudiante['codigoestudiante'] . "'>";
                    }
                }
            }
            if (isset($_POST['documento'])){
                $documento = $_POST['documento'];
            }else{
                $documento = $row_dataestudiante['numerodocumento'];
            }
            $objAndor = new class_andor($documento);
            $NivelAcceso = 1;
            $objAndor->setNivelAcceso($NivelAcceso);
            $objAndor->setApellido('');
            $objAndor->setNombres('');
            if ($objAndor->servidor_activo()) {
                $rsutl = $objAndor->get_ws_result();
            }

            echo "<div id=restable>";
            if ($objAndor->servidor_activo()) {
                if (isset($tableCardHolder)) {
                    echo $tableCardHolder;
                } else {
                    echo $objAndor->table_cardholder($rsutl);
                }
            }
            echo "</div>";
            
            ?>

            <script language="javascript">
                function recargar(direccioncompleta, direccioncompletalarga) {
                    document.form1.direccion1.value = direccioncompletalarga;
                    document.form1.direccion1oculta.value = direccioncompleta;
                }

                function recargar1(direccioncompleta, direccioncompletalarga) {
                    document.form1.direccion2.value = direccioncompletalarga;
                    document.form1.direccion2oculta.value = direccioncompleta;
                }


                function limpiarinicio(texto) {
                    if (texto.value == "aaaa-mm-dd")
                        texto.value = "";
                }
                function iniciarinicio(texto) {
                    if (texto.value == "")
                        texto.value = "aaaa-mm-dd";
                }
                function estado(ojbtable) {
                    $(ojbtable.parentNode).each(function (index) {
                        var apellido = $(this.cells[0]).html();
                        var nombre = $(this.cells[1]).html();
                        var tarjeta = $(this.cells[2]).html();
                        var documento = '<?php echo $documento; ?>';
                        var v_estado = $(this.cells[3]).html();
                        var idestudiantegeneral = '<?php echo $idestudiantegeneral; ?>';
                        var v_inactivar = '';
                        if (v_estado == 'Activar') {
                            v_inactivar = 'false';
                        } else {
                            v_inactivar = 'true';
                        }
                        $.get("ajax.php", {Inactivar: v_inactivar, v_apellido: apellido, v_nombre: nombre, v_tarjeta: tarjeta, v_documento: documento, v_idestudiantegeneral: idestudiantegeneral}, function (data) {
                            alert('Tarjeta Actualizada Correctamente');
                            $("#restable").html(data);
                            location.reload();
                        });
                    });
                }
            </script>
            <br>
            <div align="center">
                <input type="submit" name="guardar" value="Guardar">
                <input type="submit" name="regresar" value="Regresar">
            </div>
        </form>
