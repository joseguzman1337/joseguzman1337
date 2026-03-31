<?php
    require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));

    $pos = strpos($Configuration->getEntorno(), "local");
    if ($Configuration->getEntorno() == "local" || $Configuration->getEntorno() == "pruebas" || $pos !== false) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_WARNING);
        require_once(PATH_ROOT . '/kint/Kint.class.php');
    }

    session_start();
    include_once(realpath(dirname(__FILE__)) . '/../../../utilidades/ValidarSesion.php');
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    if (isset($_POST['action'])) {
        require_once('../../../Connections/sala2.php');
        mysql_select_db($database_sala, $sala);
        if ($_POST['action'] == 'verificar_admitido') {
            require_once('../../../funciones/validacion.php');
            require_once('../../../funciones/errores_creacionestudiante.php');
            require_once('../../../funciones/funcionip.php');
            $ruta = "../../../";
            require_once($ruta . "Connections/conexionldap.php");
            require_once($ruta . "funciones/clases/autenticacion/claseldap.php");

            $usuario = $_SESSION['MM_Username'];
            $periodoactual = $_SESSION['codigoperiodosesion'];

            $valorRespuesta = 0;
            $idestudiantegeneral = $_POST['idestudiantegeneral'];

            //Si la situacion a cambiar es admitido
            if ($_POST['situacion'] == 300) {
                $SQL = "SELECT car.codigomodalidadacademica, car.codigocarrera ".
                " FROM estudiante est JOIN carrera car ON est.codigocarrera = car.codigocarrera ".
                " WHERE est.idestudiantegeneral = '".$idestudiantegeneral."' ".
                " AND car.codigocarrera = '" . $_POST['codigocarrera'] . "'";
                $resultado = mysql_query($SQL, $sala);
                $row_resultado = mysql_fetch_assoc($resultado);

                //si el estado es 200 pregrado
                if ($row_resultado['codigomodalidadacademica'] == 200) {
                    $valorRespuesta = 1;
                } else {
                    $valorRespuesta = 0;
                }
            }

            // Actualiza los datos
            if ($_POST['fechaexpediciovisa'] != '' && $_POST['fechavencimientovisa'] != '') {
                $select_extranjero = "SELECT * FROM EstudianteVisa WHERE idestudiantegeneral = '$idestudiantegeneral'";
                $selectext = mysql_query($select_extranjero, $sala) or die("$select_extranjero" . mysql_error());
                if (mysql_num_rows($selectext) == 0) {
                    if ($_POST['tipoPermiso'] === '2' || $_POST['tipoPermiso'] === '3') {
                        $_POST['categoriavisa'] = 0;
                    }
                    $query_insestudiante_extranjero = "INSERT INTO EstudianteVisa (idestudiantegeneral, ".
                    " CategoriaVisaId, NumeroVisa, NumeroVisaT, PaisId, TipoPermiso, FechaExpedicion, FechaVencimiento,estado) ".
                    " VALUES (".$idestudiantegeneral.", '".$_POST['categoriavisa']."', '".$_POST['numerovisa']."', '".$_POST['numerovisaT']
                    ."', '".$_POST['idpaisnacimiento']."', '".$_POST['tipoPermiso']."', '".$_POST['fechaexpediciovisa']."', '".$_POST['fechavencimientovisa'] . "','100');";
                    $updestudiantegeneralvisa = mysql_query($query_insestudiante_extranjero, $sala) or die("$query_insestudiante_extranjero" . mysql_error());
                } else {
                    if ($_POST['tipoPermiso'] === '2' || $_POST['tipoPermiso'] === '3') {
                        $_POST['categoriavisa'] = 0;
                    }
                    if ($_POST['idpaisnacimiento'] === '1') {
                        $updateEstado = " estado = '200', ";
                    } else {
                        $updateEstado = " estado = '100', ";
                    }
                    $query_updestudiante_extranjero = "UPDATE EstudianteVisa SET CategoriaVisaId = '" . $_POST['categoriavisa'] .
                    "', NumeroVisa = '" . $_POST['numerovisa'] . "', NumeroVisaT = '" . $_POST['numerovisaT'] . "', PaisId = '" .
                    $_POST['idpaisnacimiento'] . "', TipoPermiso = '" . $_POST['tipoPermiso'] . "', FechaExpedicion = '" .
                    $_POST['fechaexpediciovisa'] . "', ".$updateEstado." FechaVencimiento = '" . $_POST['fechavencimientovisa'] . "' ".
                    " where idestudiantegeneral = '$idestudiantegeneral';";
                    $updestudiantegeneralvisa = mysql_query($query_updestudiante_extranjero, $sala) or die("$query_updestudiante_extranjero" . mysql_error());
                }
            }
            $a_array['respuesta'] = $valorRespuesta;
            echo json_encode($a_array);
            exit;
        }

        if ($_POST['action'] == 'enviar_carta') {
            $queryExistenceLogSituacion = "select * from historicosituacionestudiante where ".
            " codigoestudiante = " . $_POST['codigoestudiante'] . " and codigosituacioncarreraestudiante = 300 ".
            " and fechafinalhistoricosituacionestudiante >= NOW();";

            $queryExistenceLogSituacionExecute = mysql_query($queryExistenceLogSituacion, $sala);
            #valida si existe algun registro en historicosituacionestudiante para
            #saber si se tiene que enviar la carta de admitidos nuevamente.
            if (mysql_num_rows($queryExistenceLogSituacionExecute) == 0) {
                $nombre = $_POST['apellidos'] . $_POST['documento'] . '.pdf';
                $nombre = str_replace(' ', '', $nombre);
                include('plantillasHtml/admitidosTemplate.php');
                $nombreCarta = $_POST['nombres'] . ' ' . $_POST['apellidos'];
                $html = getTemplateAdmitidos($nombreCarta, $_POST['nombrecarrera']);

                require_once('phpmailer/class.phpmailer.php');
                // optional, gets called from within class.phpmailer.php if not already loaded

                $mail = new PHPMailer();
                $body = $html;
                $mail->SetFrom('atencionalusuario@unbosque.edu.co ', 'Universidad El Bosque');
                $mail->AddReplyTo("atencionalusuario@unbosque.edu.co ", "Universidad El Bosque");
                $mail->Subject = "Felicitaciones. Ha sido admitido en la Universidad El Bosque.";
                $mail->MsgHTML($body);

                $address = $_POST['email'];
                $mail->AddAddress($address, $_POST['nombres']);
                $mail->AddAttachment("pdf/" . $nombre);      // attachment
                if (!$mail->Send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }
                @unlink('pdf/' . $nombre);
                echo 'carta enviada';
                exit;
            }
        }
    }

    require_once('../../../Connections/sala2.php');
    require_once('../../../funciones/validacion.php');
    require_once('../../../funciones/errores_creacionestudiante.php');
    require_once('../../../funciones/funcionip.php');
    $ruta = "../../../";
    require_once($ruta . "Connections/conexionldap.php");
    require_once($ruta . "funciones/clases/autenticacion/claseldap.php");
    include_once(realpath(dirname(__FILE__)) . '/../../../EspacioFisico/templates/template.php');
    $db = getBD();

    $usuario = $_SESSION['MM_Username'];
    $periodoactual = $_SESSION['codigoperiodosesion'];
    mysql_select_db($database_sala, $sala);

    $usuarioeditar = $_GET['usuarioeditar'];
    $ip = "SIN DEFINIR";
    $ip = tomarip();

    if (isset($_GET['codigocreado'])) {
        $_SESSION['codigo'] = $codigoestudiante = $_GET['codigocreado'];
    } elseif (isset($_SESSION['codigo'])) {
        $codigoestudiante = $_SESSION['codigo'];
    }

    if ($_POST['regresar']) {
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=menucrearnuevoestudiante.php'>";
        exit();
    }

    //consulta de datos del estudiante
    $query_dataestudiante = "SELECT eg.*, c.nombrecarrera, d.nombredocumento, e.codigojornada, j.nombrejornada, ".
	" e.semestre, e.numerocohorte, e.codigotipoestudiante, t.nombretipoestudiante, e.codigosituacioncarreraestudiante, ".
	" s.nombresituacioncarreraestudiante, g.nombregenero, e.codigoestudiante, c.codigocarrera, c.codigomodalidadacademicasic, ".
	" tge.idtipogruposanguineo, tge.nombretipogruposanguineo, e.VinculacionId, ".
    " GROUP_CONCAT(DISTINCT CONCAT(ed.tipodocumento,'**',ed.numerodocumento) ORDER BY ed.numerodocumento ASC SEPARATOR ',') edtipnumdo ".
    " FROM estudiante e ".
	" INNER JOIN estudiantegeneral eg on eg.idestudiantegeneral = e.idestudiantegeneral ".
	" INNER JOIN carrera c on e.codigocarrera = c.codigocarrera ".
	" INNER JOIN documento d on eg.tipodocumento = d.tipodocumento ".
	" INNER JOIN jornada j on e.codigojornada = j.codigojornada ".
	" INNER JOIN tipoestudiante t on e.codigotipoestudiante = t.codigotipoestudiante ".
	" INNER JOIN situacioncarreraestudiante s on e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante ".
	" INNER JOIN genero g on eg.codigogenero = g.codigogenero ".
	" LEFT JOIN gruposanguineoestudiante ge on ge.idestudiantegeneral = eg.idestudiantegeneral ".
	" LEFT JOIN tipogruposanguineo tge on tge.idtipogruposanguineo = ge.idtipogruposanguineo ".
    " LEFT JOIN estudiantedocumento ed on eg.idestudiantegeneral = ed.idestudiantegeneral ".
    " WHERE e.codigoestudiante = '" . $codigoestudiante . "'";
    $dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante" . mysql_error());
    $row_dataestudiante = mysql_fetch_assoc($dataestudiante);
    $totalRows_dataestudiante = mysql_num_rows($dataestudiante);

    $idestudiantegeneral = $row_dataestudiante['idestudiantegeneral'];
    $numerodocumentoinicial = $row_dataestudiante['numerodocumento'];

    if ($totalRows_dataestudiante != "") {
        $formulariovalido = 1;

        $query_jornadas = "SELECT jo.codigojornada, jo.nombrejornada FROM jornada jo";
        $jornadas = mysql_query($query_jornadas, $sala) or die(mysql_error());
        $row_jornadas = mysql_fetch_assoc($jornadas);
        $totalRows_jornadas = mysql_num_rows($jornadas);

        $query_tipoestudiante = "SELECT ti.codigotipoestudiante, ti.nombretipoestudiante FROM tipoestudiante ti";
        $tipoestudiante = mysql_query($query_tipoestudiante, $sala) or die(mysql_error());
        $row_tipoestudiante = mysql_fetch_assoc($tipoestudiante);
        $totalRows_tipoestudiante = mysql_num_rows($tipoestudiante);

        $query_situacionestudiante = "SELECT * FROM situacioncarreraestudiante where ".
        " codigosituacioncarreraestudiante not like '4%'";
        $situacionestudiante = mysql_query($query_situacionestudiante, $sala) or die(mysql_error());
        $row_situacionestudiante = mysql_fetch_assoc($situacionestudiante);
        $totalRows_situacionestudiante = mysql_num_rows($situacionestudiante);

        $query_carreras = "SELECT codigocarrera, nombrecarrera FROM carrera where ".
        " codigocarrera = '" . $_SESSION['codigofacultad'] . "' order by 2 asc";
        $carreras = mysql_query($query_carreras, $sala) or die(mysql_error());
        $row_carreras = mysql_fetch_assoc($carreras);
        $totalRows_carreras = mysql_num_rows($carreras);

        $query_documentos = "SELECT * FROM documento where codigoestado like '1%'";
        $documentos = mysql_query($query_documentos, $sala) or die(mysql_error());
        $row_documentos = mysql_fetch_assoc($documentos);
        $totalRows_documentos = mysql_num_rows($documentos);

        $query_planestudios = "SELECT * FROM planestudio where ".
        " codigocarrera = '" . $row_dataestudiante['codigocarrera'] . "' and codigoestadoplanestudio like '1%'";
        $planestudios = mysql_query($query_planestudios, $sala) or die("$query_planestudios");
        $row_planestudios = mysql_fetch_assoc($planestudios);
        $totalRows_planestudios = mysql_num_rows($planestudios);

        $query_selgenero = "select codigogenero, nombregenero from genero";
        $selgenero = mysql_query($query_selgenero, $sala) or die("$query_selgenero");
        $totalRows_selgenero = mysql_num_rows($selgenero);
        $row_selgenero = mysql_fetch_assoc($selgenero);
        $query_seldecision = "select codigodecisionuniversidad, nombredecisionuniversidad from decisionuniversidad";
        $seldecision = mysql_query($query_seldecision, $sala) or die("$query_seldecision");
        $totalRows_seldecision = mysql_num_rows($seldecision);

        $query_seldecisionestudiante = "SELECT * ".
        " FROM estudiantedecisionuniversidad e,decisionuniversidad d ".
        " WHERE e.idestudiantegeneral = '" . $row_dataestudiante['idestudiantegeneral'] . "' ".
        " and e.codigodecisionuniversidad = d.codigodecisionuniversidad ".
        " and e.codigoestadoestudiantedecisionuniversidad like '1%' ".
        " order by nombredecisionuniversidad";

        $seldecisionestudiante = mysql_query($query_seldecisionestudiante, $sala) or die("$query_seldecisionestudiante");
        $row_seldecisionestudiante = mysql_fetch_assoc($seldecisionestudiante);
        $totalRows_seldecisionestudiante = mysql_num_rows($seldecisionestudiante);

        $query_dataestudianteplan = "select * from planestudioestudiante pee, planestudio p ".
        " where pee.codigoestudiante = '$codigoestudiante' and p.idplanestudio = pee.idplanestudio ".
	    " and p.codigoestadoplanestudio like '1%' and pee.codigoestadoplanestudioestudiante like '1%'";
        $dataestudianteplan = mysql_query($query_dataestudianteplan, $sala) or die("$query_dataestudiante" . mysql_error());
        $row_dataestudianteplan = mysql_fetch_assoc($dataestudianteplan);
        $totalRows_dataestudianteplan = mysql_num_rows($dataestudianteplan);

        /* query oferta dependiendo de la modalidad */
        $query_programa = "SELECT  codigocarrera, nombrecarrera, codigomodalidadacademicasic ".
        " FROM carrera WHERE codigomodalidadacademicasic IN ('".$row_dataestudiante['codigomodalidadacademicasic']."') ".
        " AND codigocarrera NOT IN (354, 6, 428, 7, 120, 600, 605) ORDER BY nombrecarrera ASC ";
        $dataPrograma = mysql_query($query_programa, $sala) or die("$query_dataestudiante" . mysql_error());

        //cosnulta rol del usuario
        $slqrol = "SELECT rol.idrol FROM usuario u INNER JOIN UsuarioTipo ut on ut.UsuarioId = u.idusuario ".
        " INNER JOIN usuariorol rol on rol.idusuariotipo = ut.UsuarioTipoId WHERE u.usuario = '" . $usuario . "'";
        $RolData = $db->GetRow($slqrol);
        $Rol = $RolData['idrol'];

        //consulta los tipos de grupos sangiuineos
        $sqlrh = "SELECT tip.idtipogruposanguineo, tip.nombretipogruposanguineo FROM tipogruposanguineo tip";
        $rh = $db->GetAll($sqlrh);

        //Lista de grupos etnicos
        $sqletnico = "SELECT GrupoEtnicoId, NombreGrupoEtnico FROM GrupoEtnico";
        $grupoetnico = $db->GetAll($sqletnico);

        //lista de vinculaciones
        $sqlvinculacion = "SELECT VinculacionId, NombreVinculacion FROM Vinculacion";
        $vinculaciones = $db->GetAll($sqlvinculacion);

        //validacion de tipodocumento y numerodocumento antiguos
        $partes = explode(",", $row_dataestudiante['edtipnumdo']);
        $tipodocumentoold='';
        $documentoold='';
        foreach ($partes as $val) {
            list($tipo,$num) = explode("**", $val);
            if($tipo!=$row_dataestudiante['tipodocumento'] || $num!=$row_dataestudiante['numerodocumento']){
            $tipodocumentoold=$tipo;
            $documentoold=$num;
            }
        }
    ?>
    <html>
        <head>
            <title>Crear Estudiante</title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <script src="../../../../assets/js/jquery-3.6.0.min.js" type="text/javascript"></script>
            <!--  Space loading indicator  -->
            <script src="<?php echo HTTP_SITE; ?>/assets/js/spiceLoading/pace.min.js"></script>
            <!--  loading cornerIndicator  -->
            <link href="<?php echo HTTP_SITE; ?>/assets/css/cornerIndicator/cornerIndicator.css" rel="stylesheet">
        </head>
        <style type="text/css">
            <!--
            .Estilo1 {
                font-family: Tahoma;
                font-size: 12px
            }

            .Estilo2 {
                font-family: Tahoma;
                font-size: 12px;
                font-weight: bold;
            }

            .Estilo3 {
                font-family: Tahoma;
                font-size: 14px;
                font-weight: bold;
            }

            .Estilo4 {
                color: #FF0000
            }
            -->
        </style>
        <body>
            <form name="form1" id="editarestudianteForm" method="post"
              action="editarestudiante.php?codigocreado=<?php echo $codigoestudiante; ?>&usuarioeditar=<?php echo $usuarioeditar; ?>">
                <center><h2>EDITAR ESTUDIANTE</h2></center>
                <table width="876" border="1" align="center" cellpadding="1" bordercolor="#003333">
                    <tr>
                        <td bgcolor="#C5D5D6" class="Estilo2" align="center">
                            Facultad<span class="Estilo4">*</span>
                        </td>
                        <td colspan="2" class="Estilo1" align="center">
                            <?php
                            if ($Rol == '13'){
                                ?>
                                <input type="hidden" name="programaanterior" value="<?php echo $row_dataestudiante['codigocarrera']; ?>"/>
                                <input type="hidden" name="nombrecarrera" id="nombrecarrera" value="<?php echo $row_dataestudiante['nombrecarrera']; ?>"/>
                                <select name="programa">
                                    <?php
                                    while ($row = mysql_fetch_array($dataPrograma)) {
                                        ?>
                                        <option value="<?php echo $row['codigocarrera']; ?>"<?php
                                        if (!(strcmp($row['codigocarrera'], $row_dataestudiante['codigocarrera']))) {
                                            echo "SELECTED";
                                        }
                                        ?>>
                                        <?php echo $row['nombrecarrera'] ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php
                            } else {
                                echo $row_dataestudiante['nombrecarrera'];
                                echo '<input type="hidden" name="nombrecarrera" id="nombrecarrera" 
                                value="'.$row_dataestudiante['nombrecarrera'].'"/>';
                            }
                            ?>
                        </td>
                        <td colspan="1" bgcolor="#C5D5D6" align="center" class="Estilo2">
                            Plan de Estudio<span class="Estilo4">*</span>
                        </td>
                        <td colspan="2" align="center"><span class="Estilo1">
                            <?php
                            if ($_SESSION['MM_Username'] == 'dirsecgeneral') { 
                                if ($row_dataestudianteplan['idplanestudio'] <> "") {
                                    $planestudiante = $row_dataestudianteplan['idplanestudio'];
                                } else {
                                    $planestudiante = 1;
                                }
                                ?>
                                <input type="hidden" name="planestudio" value="<?php echo $planestudiante; ?>">
                                <?php
                                echo $planestudiante;
                            } else {
                                // Verifica que el estudiante no tenga prematricula para el periodo activo, si la tiene ya no le permite cambiar el plan de estudio
                                $query_prematriculaviva = "select distinct e.codigoestudiante from prematricula p, estudiante e, detalleprematricula d, periodo pe 		where p.codigoestudiante = e.codigoestudiante and p.idprematricula = d.idprematricula and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%') and (d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula like '3%') and pe.codigoperiodo = p.codigoperiodo and pe.codigoestadoperiodo = '3' and e.codigoestudiante = '$codigoestudiante'";
                                $prematriculaviva = mysql_query($query_prematriculaviva, $sala) or die("$query_prematriculaviva");
                                $row_prematriculaviva = mysql_fetch_assoc($prematriculaviva);
                                $totalRows_prematriculaviva = mysql_num_rows($prematriculaviva);
                                if ($totalRows_prematriculaviva == "") {
                                    $query_prematriculaviva = "select distinct e.codigoestudiante
                                from prematricula p, estudiante e, detalleprematricula d, periodo pe
                                where p.codigoestudiante = e.codigoestudiante
                                and p.idprematricula = d.idprematricula
                                and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
                                and (d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula like '3%')
                                and pe.codigoperiodo = p.codigoperiodo
                                and pe.codigoestadoperiodo = '1'
                                and e.codigoestudiante = '$codigoestudiante'";

                                    $prematriculaviva = mysql_query($query_prematriculaviva, $sala) or die("$query_prematriculaviva");
                                    $row_prematriculaviva = mysql_fetch_assoc($prematriculaviva);
                                    $totalRows_prematriculaviva = mysql_num_rows($prematriculaviva);
                                }
                                /* Permitir a admintecnologia cambiar el plan de estudio */
                                if ($_SESSION['MM_Username'] == 'admintecnologia') {
                                    $totalRows_prematriculaviva = "";
                                }
                                if ($totalRows_prematriculaviva == "") {
                                    ?>
                                    <select name="planestudio">
                                        <?php
                                        if ($totalRows_dataestudianteplan == "") {
                                            ?>
                                            <option value="0" <?php
                                            if (!(strcmp(0, $row_dataestudianteplan['idplanestudio']))) {
                                                echo "SELECTED";
                                            }
                                            ?>>Seleccionar ..........</option>
                                            <?php
                                        }
                                        do {
                                            ?>
                                            <option value="<?php echo $row_planestudios['idplanestudio']; ?>"<?php
                                            if (!(strcmp($row_planestudios['idplanestudio'], $row_dataestudianteplan['idplanestudio']))) {
                                                echo "SELECTED";
                                            }
                                            ?>><?php echo $row_planestudios['nombreplanestudio'] ?></option>
                                            <?php
                                        } while ($row_planestudios = mysql_fetch_assoc($planestudios));
                                        $totalRows_planestudios = mysql_num_rows($planestudios);
                                        if ($totalRows_planestudios > 0) {
                                            mysql_data_seek($planestudios, 0);
                                            $row_planestudios = mysql_fetch_assoc($planestudios);
                                        }
                                        ?>
                                        </select>
                                    <?php
                                } else {
                                    ?>
                                    <input type="hidden" name="planestudio"
                                           value="<?php echo $row_dataestudianteplan['idplanestudio']; ?>">
                                    <?php
                                    if (isset($row_dataestudianteplan['nombreplanestudio'])) {
                                        echo $row_dataestudianteplan['nombreplanestudio'];
                                    } else {
                                        echo "No tiene";
                                    }
                                }
                            }
                            ?>
                            </span><span class="Estilo1"><font size="2" face="Tahoma">
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
                                </font>
                                <font size="2" face="Tahoma"></font>
                            </span>
            </td>
        </tr>
        <?php

        $querysituacionestudiantegeneral = 'SELECT codigosituacioncarreraestudiante ';
        $querysituacionestudiantegeneral .= 'FROM estudiante e ';
        $querysituacionestudiantegeneral .= 'INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral ';
        $querysituacionestudiantegeneral .= 'WHERE eg.numerodocumento="' . $row_dataestudiante['numerodocumento'] . '" ';
        $selsituacionestudiantegeneral = $db->Execute($querysituacionestudiantegeneral);
        $totalRows_selsituacionestudiantegeneral = $selsituacionestudiantegeneral->RecordCount();
        $acum = '';
        while ($row_selsituacionestudiantegeneral = $selsituacionestudiantegeneral->FetchRow()) {
            $acum .= $row_selsituacionestudiantegeneral['codigosituacioncarreraestudiante'] . ',';
        }
        $tacum = substr($acum, 0, -1);
        $arreglo = array($tacum);
        ?>
        <tr>
            <td bgcolor="#C5D5D6" class="Estilo2" align="center">Apellidos<span class="Estilo4">*</span></td>
            <td colspan="1" class="Estilo1">
                <?php

                if ($Rol == 13) {
                    ?>
                    <input name="apellidos" type="text" id="apellidos" value="<?php if (isset($_POST['apellidos']))
                        echo $_POST['apellidos'];
                    else
                        echo $row_dataestudiante['apellidosestudiantegeneral'];
                    ?>" size="30">
                    <?php
                } else {

                    switch ($arreglo) {
                        default:
                            ?>
                            <input name="apellidos" type="text" id="apellidos"
                                   value="<?php if (isset($_POST['apellidos']))
                                       echo $_POST['apellidos'];
                                   else
                                       echo $row_dataestudiante['apellidosestudiantegeneral'];
                                   ?>" size="30">
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
                            <?php
                            break;
                        case in_array(400, $arreglo)://graduado
                            ?>
                            <input name="apellidos" type="hidden" id="apellidos"
                                   value="<?php if (isset($_POST['apellidos']))
                                       echo $_POST['apellidos'];
                                   else
                                       echo $row_dataestudiante['apellidosestudiantegeneral'];
                                   ?>" size="30">
                            <input name="apellidos1" type="text" id="apellidos1"
                                   value="<?php if (isset($_POST['apellidos']))
                                       echo $_POST['apellidos'];
                                   else
                                       echo $row_dataestudiante['apellidosestudiantegeneral'];
                                   ?>" size="30" disabled>
                            <?php
                            break;
                    }
                }
                ?>
            </td>
            <td align="center" bgcolor="#C5D5D6" class="Estilo2">Nombres<span class="Estilo4">*</span></td>
            <td colspan="1">
                <div align="left">
                    <font size="1" face="tahoma">
                        <?php
                        if ($Rol == 13) {
                            ?>
                            <input name="nombres" type="text" id="nombres2"
                                   value="<?php if (isset($_POST['nombres']))
                                       echo $_POST['nombres'];
                                   else
                                       echo $row_dataestudiante['nombresestudiantegeneral'];
                                   ?>" size="30">
                            <?php
                        } else {
                            switch ($arreglo) {
                                default:
                                    ?>
                                    <input name="nombres" type="text" id="nombres2"
                                           value="<?php if (isset($_POST['nombres']))
                                               echo $_POST['nombres'];
                                           else
                                               echo $row_dataestudiante['nombresestudiantegeneral'];
                                           ?>" size="30">
                                    <?php
                                    break;
                                case in_array(400, $arreglo)://graduado
                                    ?>
                                    <input name="nombres" type="hidden" id="nombres2"
                                           value="<?php if (isset($_POST['nombres']))
                                               echo $_POST['nombres'];
                                           else
                                               echo $row_dataestudiante['nombresestudiantegeneral'];
                                           ?>" size="30">
                                    <input name="nombres1" type="text" id="nombres2a"
                                           value="<?php if (isset($_POST['nombres']))
                                               echo $_POST['nombres'];
                                           else
                                               echo $row_dataestudiante['nombresestudiantegeneral'];
                                           ?>" size="30" disabled>
                                    <?php
                                    break;
                            }
                        }
                        ?>
                    </font>
                    <font size="2" face="Tahoma">
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
                    </font>
                    <font size="1" face="tahoma"> </font>
                </div>
            </td>
            <td bgcolor="#C5D5D6" colspan="1" class="Estilo2" align="center">Fecha de Nacimiento (aaaa-mm-dd)<span
                        class="Estilo4">*</span></td>
            <td colspan="1">
                <div align="left">
                    <font size="1" face="tahoma">
                        <input name="fnacimiento" type="date" size="10" value="<?php
                        if (isset($_POST['fnacimiento'])) {
                            echo $_POST['fnacimiento'];
                        } else {

                            $fnac = ereg_replace(" [0-9]+:[0-9]+:[0-9]+ ", " ", $row_dataestudiante['fechanacimientoestudiantegeneral']);
                            echo substr($fnac, 0, -9);

                        }
                        ?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)">
                    </font>
                    <font size="1" face="Tahoma">
                        <font color="#FF0000">
                            <?php
                            if (isset($_POST['fnacimiento'])) {
                                $fnacimiento = $_POST['fnacimiento'];
                                $imprimir = true;
                                $ffecha = validar($fnacimiento, "fechaant", $error3, $imprimir, $fnacimiento[0]);
                                $formulariovalido = $formulariovalido * $ffecha;
                            }
                            ?>
                        </font>
                    </font>
                    <font size="1" face="tahoma"> </font>
                </div>
            </td>
        </tr>
        <tr>
            <td bgcolor="#C5D5D6" class="Estilo2" align="center">T. Documento<span class="Estilo4">*</span></td>
            <td colspan="1" class="Estilo1">
                <font size="2" face="Tahoma">
                    <div align="left">
                        <?php
                        if ($Rol == 13) {
                            ?>
                            <select name="tipodocumento">
                                <option value="<?php echo $row_dataestudiante['tipodocumento'] ?>"
                                        selected><?php echo $row_dataestudiante['nombredocumento'] ?></option>
                                <?php
                                do {
                                    if ($row_dataestudiante['tipodocumento'] != $row_documentos['tipodocumento'] && $row_documentos['nombredocumento'] != "Seleccionar") {
                                        ?>
                                        <option value="<?php echo $row_documentos['tipodocumento'] ?>"<?php
                                        if (!(strcmp($row_documentos['tipodocumento'], $_POST['tipodocumento']))) {
                                            echo "SELECTED";
                                        }
                                        ?>><?php echo $row_documentos['nombredocumento'] ?></option>
                                        <?php
                                    }
                                } while ($row_documentos = mysql_fetch_assoc($documentos));
                                $rows = mysql_num_rows($documentos);
                                if ($rows > 0) {
                                    mysql_data_seek($documentos, 0);
                                    $row_documentos = mysql_fetch_assoc($documentos);
                                }
                                ?>
                            </select>
                            <?php
                        } else {
                            switch ($arreglo) {
                                default:
                                    ?>
                                    <select name="tipodocumento">
                                        <option value="<?php echo $row_dataestudiante['tipodocumento'] ?>"
                                                selected><?php echo $row_dataestudiante['nombredocumento'] ?></option>
                                        <?php
                                        do {
                                            if ($row_dataestudiante['tipodocumento'] != $row_documentos['tipodocumento'] && $row_documentos['nombredocumento'] != "Seleccionar") {
                                                ?>
                                                <option value="<?php echo $row_documentos['tipodocumento'] ?>"<?php
                                                if (!(strcmp($row_documentos['tipodocumento'], $_POST['tipodocumento']))) {
                                                    echo "SELECTED";
                                                }
                                                ?>><?php echo $row_documentos['nombredocumento'] ?></option>
                                                <?php
                                            }
                                        } while ($row_documentos = mysql_fetch_assoc($documentos));
                                        $rows = mysql_num_rows($documentos);
                                        if ($rows > 0) {
                                            mysql_data_seek($documentos, 0);
                                            $row_documentos = mysql_fetch_assoc($documentos);
                                        }
                                        ?>
                                    </select>
                                    <?php
                                    break;
                                case in_array(400, $arreglo):
                                    $query_nomdocu = 'SELECT nombredocumento ';
                                    $query_nomdocu .= 'FROM documento ';
                                    $query_nomdocu .= 'WHERE tipodocumento="' . $row_dataestudiante['tipodocumento'] . '" ';
                                    $query_nomdocu .= '';
                                    $nomdocu = $db->Execute($query_nomdocu);
                                    $row_nomdocu = $nomdocu->FetchRow();
                                    ?>
                                    <input type='hidden' name='tipodocumento'
                                           value='<?php echo $row_dataestudiante['tipodocumento']; ?>'>
                                    <input type='text' name='tipodocumento1'
                                           value='<?php echo $row_nomdocu['nombredocumento']; ?>' disabled>
                                    <?php
                                    break;
                            }
                        }
                        ?>
                        <input type='hidden' name='tipodocumentoold'
                               value='<?php echo $row_dataestudiante['tipodocumento']; ?>'>
                        <font size="2" face="Tahoma">
                            <?php
                            echo "<span class='Estilo4'>";
                            if (isset($_POST['tipodocumento'])) {
                                $tipodocumento = $_POST['tipodocumento'];
                                $imprimir = true;
                                $tdrequerido = validar($tipodocumento, "combo", $error1, $imprimir);
                                $formulariovalido = $formulariovalido * $tdrequerido;
                            }
                            echo "</span>";
                            ?>
                        </font>
                    </div>
                </font>
            </td>
            <td align="center" bgcolor="#C5D5D6" class="Estilo2">N&uacute;mero<span class="Estilo4">*</span></td>
            <td colspan="1" align="center">
                <div align="left">
                    <?php

                    if ($Rol == 13) {
                        ?>
                        <input name="documento" type="text" id="documento2" size="20" value="<?php
                        if (isset($_POST['documento'])) {
                            echo $_POST['documento'];
                        } else {
                            echo $row_dataestudiante['numerodocumento'];
                        }
                        ?>">
                        <?php
                    } else {
                        switch ($arreglo) {
                            default:
                                ?>
                                <input name="documento" type="text" id="documento2" size="20" value="<?php
                                if (isset($_POST['documento'])) {
                                    echo $_POST['documento'];
                                } else {
                                    echo $row_dataestudiante['numerodocumento'];
                                }
                                ?>">
                                <?php
                                break;
                            case in_array(400, $arreglo)://graduado
                                ?>
                                <input name="documento" type="hidden" id="requerido" size="20" value="<?php
                                if (isset($_POST['documento'])) {
                                    echo $_POST['documento'];
                                } else {
                                    echo $row_dataestudiante['numerodocumento'];
                                }
                                ?>">
                                <input name="documento1" type="text" id="requerido" size="20" value="<?php
                                if (isset($_POST['documento'])) {
                                    echo $_POST['documento'];
                                } else {
                                    echo $row_dataestudiante['numerodocumento'];
                                }
                                ?>" disabled>
                                <?php
                                break;
                        }
                    }
                    ?>

                    <input name="documentoold" type="hidden" value="<?php
                    if (isset($_POST['documento']) && !empty($_POST['documento'])) {
                        echo $_POST['documento'];
                    } else {
                        //echo $documentoold;
                        echo $row_dataestudiante['numerodocumento'];
                    }
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
                </div>
            </td>
            <td bgcolor="#C5D5D6" align="center" class="Estilo2">Expedido en (lugar)<span class="Estilo4">*</span></td>
            <td colspan="1" align="left" class="Estilo1">
                <?php
                if ($Rol == 13) {
                    ?>
                    <input name="expedido" type="text" id="expedido3" size="19"
                           value="<?php if (isset($_POST['expedido']))
                               echo $_POST['expedido'];
                           else
                               echo $row_dataestudiante['expedidodocumento'];
                           ?>">
                    <?php
                } else {
                    switch ($arreglo) {
                        default:
                            ?>
                            <input name="expedido" type="text" id="expedido3" size="19"
                                   value="<?php if (isset($_POST['expedido']))
                                       echo $_POST['expedido'];
                                   else
                                       echo $row_dataestudiante['expedidodocumento'];
                                   ?>">
                            <?php
                            break;
                        case in_array(400, $arreglo)://graduado
                            ?>
                            <input name="expedido" type="hidden" id="requerido" size="19"
                                   value="<?php if (isset($_POST['expedido']))
                                       echo $_POST['expedido'];
                                   else
                                       echo $row_dataestudiante['expedidodocumento'];
                                   ?>">
                            <input name="expedido1" type="text" id="expedido3" size="19"
                                   value="<?php if (isset($_POST['expedido']))
                                       echo $_POST['expedido'];
                                   else
                                       echo $row_dataestudiante['expedidodocumento'];
                                   ?>" disabled>
                            <?php
                            break;
                    }
                }
                

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
            <td bgcolor="#C5D5D6" class="Estilo2" align="center">Fecha de Expedicion (aaaa-mm-dd)<span
                        class="Estilo4">*</span></td>
            <td><input name="fechaexpedicion" type="text" id="fechadocumento" value="<?php
                if (isset($_POST['fechaexpedicion'])) {
                    echo $_POST['fechaexpedicion'];
                } else {
                    echo $row_dataestudiante['FechaDocumento'];
                }
                ?>" size="19"></td>
            <td bgcolor="#C5D5D6" class="Estilo2" align="center">Grupo Sanguineo(RH)<span class="Estilo4">*</span></td>
            <td>
                <select name="rh" id="rh">
                    <?php
                    foreach ($rh as $campos) {
                        if ($campos['idtipogruposanguineo'] == $row_dataestudiante['idtipogruposanguineo']) {
                            ?>
                            <option value="<?php echo $campos['idtipogruposanguineo']; ?>"
                                    selected="selected"><?php echo $campos['nombretipogruposanguineo']; ?></option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $campos['idtipogruposanguineo']; ?>"><?php echo $campos['nombretipogruposanguineo']; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </td>
            <td bgcolor="#C5D5D6" class="Estilo2" align="center">Grupo Etnico<span class="Estilo4">*</span></td>
            <td>
                <select name="etnia" id="etnia">
                    <?php
                    foreach ($grupoetnico as $etnia) {
                        if ($etnia['GrupoEtnicoId'] == $row_dataestudiante['GrupoEtnicoId']) {
                            ?>
                            <option value="<?php echo $etnia['GrupoEtnicoId']; ?>"
                                    selected="selected"><?php echo $etnia['NombreGrupoEtnico']; ?></option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $etnia['GrupoEtnicoId']; ?>"><?php echo $etnia['NombreGrupoEtnico']; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td bgcolor="#C5D5D6" class="Estilo2" align="center">Tipo de Vinculacion<span class="Estilo4">*</span></td>
            <td colspan="2" class="Estilo1" align="center">
                <div align="left">
                    <select name="vinculacion" id="vinculacion">
                        <?php
                        foreach ($vinculaciones as $tipo) {
                            if ($tipo['VinculacionId'] == $row_dataestudiante['VinculacionId']) {
                                ?>
                                <option value="<?php echo $tipo['VinculacionId']; ?>"
                                        selected='selected'><?php echo $tipo['NombreVinculacion']; ?></option>
                                <?php
                            } else {
                                ?>
                                <option value="<?php echo $tipo['VinculacionId']; ?>"><?php echo $tipo['NombreVinculacion']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </td>
            <td bgcolor="#C5D5D6" class="Estilo2" align="center">Jornada<span class="Estilo4">*</span></td>
            <td colspan="2" class="Estilo1" align="center">
                <div align="left">
                    <select name="jornada" id="select10">
                        <option value="<?php echo $row_dataestudiante['codigojornada'] ?>"
                                selected><?php echo $row_dataestudiante['nombrejornada'] ?></option>
                        <?php
                        do {
                            if ($row_dataestudiante['codigojornada'] != $row_jornadas['codigojornada']) {
                                ?>
                                <option value="<?php echo $row_jornadas['codigojornada'] ?>"<?php
                                if (!(strcmp($row_jornadas['codigojornada'], $_POST['jornada']))) {
                                    echo "SELECTED";
                                }
                                ?>>
                                    <?php echo $row_jornadas['nombrejornada'] ?></option>
                                <?php
                            }
                        } while ($row_jornadas = mysql_fetch_assoc($jornadas));
                        $rows = mysql_num_rows($jornadas);
                        if ($rows > 0) {
                            mysql_data_seek($jornadas, 0);
                            $row_jornadas = mysql_fetch_assoc($jornadas);
                        }
                        ?>
                    </select>
                    <?php
                    echo "<span class='Estilo4'>";
                    if (isset($_POST['jornada'])) {
                        $jornada = $_POST['jornada'];
                        $imprimir = true;
                        $jrequerido = validar($jornada, "combo", $error1, $imprimir);
                        $formulariovalido = $formulariovalido * $jrequerido;
                    }
                    echo "</span>";
                    ?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="1" align="center" bgcolor="#C5D5D6" class="Estilo2">Semestre<span class="Estilo4">*</span></td>
            <td colspan="2">
                <select name="semestre">
                    <option value="<?php echo $row_dataestudiante['semestre'] ?>"
                            selected><?php echo $row_dataestudiante['semestre'] ?></option>
                    <?php
                    for ($i = 1; $i < 13; $i++) {
                        if ($row_dataestudiante['semestre'] != $i) {
                            ?>
                            <option value="<?php echo $i; ?>"<?php
                            if (!(strcmp($i, $_POST['semestre']))) {
                                echo "SELECTED";
                            }
                            ?>><?php echo $i; ?></option>
                            <?php
                        }
                    }
                    ?>
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
            <td bgcolor="#C5D5D6" align="center" class="Estilo2">Genero<span class="Estilo4">*</span></td>
            <td colspan="2">
                <font size="1" face="tahoma">
                    <div align="left">
                        <select name="genero">
                            <option value="<?php echo $row_dataestudiante['codigogenero'] ?>"
                                    selected><?php echo $row_dataestudiante['nombregenero'] ?></option>
                            <?php
                            do {
                                if ($row_dataestudiante['codigogenero'] != $row_selgenero['codigogenero']) {
                                    ?>
                                    <option value="<?php echo $row_selgenero['codigogenero'] ?>"<?php
                                    if (!(strcmp($row_selgenero['codigogenero'], $_POST['genero']))) {
                                        echo "SELECTED";
                                    }
                                    ?>><?php echo $row_selgenero['nombregenero'] ?></option>
                                    <?php
                                }
                            } while ($row_selgenero = mysql_fetch_assoc($selgenero));
                            $rows = mysql_num_rows($selgenero);
                            if ($rows > 0) {
                                mysql_data_seek($selgenero, 0);
                                $row_selgenero = mysql_fetch_assoc($selgenero);
                            }
                            ?>
                        </select>
                        <?php
                        echo "<span class='Estilo4'>";
                        if (isset($_POST['genero'])) {
                            $genero = $_POST['genero'];
                            $imprimir = true;
                            $grequerido = validar($genero, "combo", $error1, $imprimir);
                            $formulariovalido = $formulariovalido * $grequerido;
                        }
                        echo "</span>";

                        $query_rot = "SELECT lc.codigocarrera, lc.LugarRotacionCarreraID, lc.lugarRotacionBase, ".
                        " l.LugarRotacionCarreraID AS lugarestudiante ".
                        " FROM estudiante e  ".
                        " INNER JOIN LugarRotacionCarrera lc ON lc.codigocarrera = e.codigocarrera ".
                        " INNER JOIN InstitucionConvenios ic ON ( lc.lugarRotacionBase = ic.InstitucionConvenioId ) ".
                        " LEFT JOIN LugarRotacionCarreraEstudiante l ON l.codigoestudiante = e.codigoestudiante ".
                        " AND l.LugarRotacionCarreraID = lc.LugarRotacionCarreraID ".
                        " WHERE e.codigoestudiante = '" . $codigoestudiante . "' ".
                        " ORDER BY lc.lugarRotacionBase ASC";
                        $rot = mysql_query($query_rot, $sala) or die("$query_rot");
                        $totalRows_rot = mysql_num_rows($rot);
                        $row_rot = mysql_fetch_assoc($rot);
                        $hayrotacion = false;
                        if (count($row_rot) > 0 && $row_rot !== false) {
                            $query_usuario = "SELECT codigotipousuario FROM usuario WHERE usuario LIKE '%" . $_SESSION['usuario'] . "%'";
                            $usuario_rot = mysql_query($query_rot, $sala) or die("$query_usuario");
                            $row_usuario_rot = mysql_fetch_assoc($usuario_rot);
                            if ($row_usuario_rot['codigotipousuario'] != 600) {
                                $hayrotacion = true;
                            }
                        }
                        ?>
                    </div>
                </font>
            </td>
        </tr>
        <tr>
            <td colspan="1" bgcolor="#C5D5D6" align="center" class="Estilo2">Situaci&oacute;n Estudiante</td>
            <td colspan="<?php
            if ($hayrotacion) {
                echo 1;
            } else {
                echo 2;
            }
            ?>" align="left" class="Estilo1">
                <?php
                if (substr($row_dataestudiante['codigosituacioncarreraestudiante'], 0, 1) <> 4) {
                    ?>
                    <select name="situacion" id="situacion" onChange="if (this.value == '400') {
                                                    sitgraduado.style.display = '';
                                                } else {
                                                    sitgraduado.style.display = 'none';
                                                }">
                        <option value="<?php echo $row_dataestudiante['codigosituacioncarreraestudiante'] ?>" selected>
                            <?php echo $row_dataestudiante['nombresituacioncarreraestudiante'] ?>
                        </option>
                        <?php
                        if ($_SESSION['MM_Username'] == "dirsecgeneral") {
                            ?>
                            <option value="400"
                                    onClick="alert('Recuerde que el paso a graduado es delicado, asï¿½ que debe estar seguro de hacerlo')">
                                Graduado
                            </option>
                            <?php
                        }
                        do {
                            if ($row_dataestudiante['codigosituacioncarreraestudiante'] != $row_situacionestudiante['codigosituacioncarreraestudiante']) {
                                $disabled = '';
                                $txt_add = '';
                                if ($row_situacionestudiante['codigosituacioncarreraestudiante'] == 108) {
                                    if ($_SESSION['codigofacultad'] != 156 && $_SESSION['usuario'] != 'admintecnologia') {
                                        $disabled = 'disabled';
                                        $txt_add = '(disponible solo para el área de crédito y cartera)';
                                    }
                                }
                                if ($row_dataestudiante['codigosituacioncarreraestudiante'] != 107) {
                                    ?>
                                    <option value="<?php echo $row_situacionestudiante['codigosituacioncarreraestudiante'] ?>"
                                        <?php
                                        if (!(strcmp($row_situacionestudiante['codigosituacioncarreraestudiante'], $_POST['situacion']))) {
                                            echo "SELECTED";
                                        }
                                        echo $disabled
                                        ?>
                                    >
                                        <?php echo $row_situacionestudiante['nombresituacioncarreraestudiante'] . " " . $txt_add ?>
                                    </option>
                                    <?php
                                } else {
                                    if ($row_situacionestudiante['codigosituacioncarreraestudiante'] == 300 || $row_situacionestudiante['codigosituacioncarreraestudiante'] == 107 || $row_situacionestudiante['codigosituacioncarreraestudiante'] == 113 || $row_situacionestudiante['codigosituacioncarreraestudiante'] == 111 || $row_situacionestudiante['codigosituacioncarreraestudiante'] == 115) {
                                        ?>
                                        <option value="<?php echo $row_situacionestudiante['codigosituacioncarreraestudiante'] ?>"<?php if (!(strcmp($row_situacionestudiante['codigosituacioncarreraestudiante'], $_POST['situacion']))) {
                                            echo "SELECTED";
                                        }
                                        echo $disabled ?>>
                                            <?php echo $row_situacionestudiante['nombresituacioncarreraestudiante'] . " " . $txt_add ?>
                                        </option>
                                        <?php
                                    }
                                }
                            }
                        } while ($row_situacionestudiante = mysql_fetch_assoc($situacionestudiante));
                        $rows = mysql_num_rows($situacionestudiante);
                        if ($rows > 0) {
                            mysql_data_seek($situacionestudiante, 0);
                            $row_situacionestudiante = mysql_fetch_assoc($situacionestudiante);
                        }
                        ?>
                    </select>
                    <div id="sitgraduado" style="display:none">Debe digitar una observación para pasarlo a graduado *
                        <input type="text"
                               value="<?php if (isset($_POST['observacionsituacion'])) echo $_POST['observacionsituacion']; ?>"
                               name="observacionsituacion">
                    </div>
                    <?php
                } else {
                    echo $row_dataestudiante['nombresituacioncarreraestudiante'];
                    echo '<input name="situacion" type="hidden" value=' . $row_dataestudiante['codigosituacioncarreraestudiante'] . '>';
                }
                echo "<span class='Estilo4'>";
                if (isset($_POST['situacion'])) {
                    $situacion = $_POST['situacion'];
                    $imprimir = true;
                    $srequerido = validar($situacion, "combo", $error1, $imprimir);
                    $formulariovalido = $formulariovalido * $srequerido;
                    if ($_POST['situacion'] == 400) {
                        if ($_POST['observacionsituacion'] == '' && $row_dataestudiante['codigosituacioncarreraestudiante'] != 400) {
                            ?>
                            <script type="text/javascript">
                                alert("Debido a que está pasando a graduado debe colocar una observación");

                            </script>
                            <?php
                            $formulariovalido = 0;
                        }
                    }
                }
                echo "</span>";
                ?>
            </td>
            <td bgcolor="#C5D5D6" class="Estilo2" align="center">Tipo Estudiante<span class="Estilo4">*</span></td>
            <td colspan="<?php
            if ($hayrotacion) {
                echo 1;
            } else {
                echo 2;
            }
            ?>" class="Estilo1">
                <font size="1" face="tahoma">
                    <select name="tipoestudiante" id="select13">
                        <option value="<?php echo $row_dataestudiante['codigotipoestudiante'] ?>"
                                selected><?php echo $row_dataestudiante['nombretipoestudiante'] ?></option>
                        <?php
                        do {
                            if ($row_dataestudiante['codigotipoestudiante'] != $row_tipoestudiante['codigotipoestudiante']) {
                                ?>
                                <option value="<?php echo $row_tipoestudiante['codigotipoestudiante'] ?>"<?php
                                if (!(strcmp($row_tipoestudiante['codigotipoestudiante'], $_POST['tipoestudiante']))) {
                                    echo "SELECTED";
                                }
                                ?>><?php echo $row_tipoestudiante['nombretipoestudiante'] ?></option>
                                <?php
                            }
                        } while ($row_tipoestudiante = mysql_fetch_assoc($tipoestudiante));
                        $rows = mysql_num_rows($tipoestudiante);
                        if ($rows > 0) {
                            mysql_data_seek($tipoestudiante, 0);
                            $row_tipoestudiante = mysql_fetch_assoc($tipoestudiante);
                        }
                        ?>
                    </select>
                </font>
                <font size="2" face="Tahoma">
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
                </font>
            </td>
            <?php if ($hayrotacion) { ?>
                <td bgcolor="#C5D5D6" class="Estilo2" align="center">Lugar de Rotación<span class="Estilo4">*</span>
                </td>
                <td class="Estilo1" align="center">
                    <div align="left">
                        <select name="lugarRotacion" id="select10">
                            <?php
                            do {
                                $idR = $row_rot["lugarestudiante"];
                                if (isset($_POST["lugarRotacion"])) {
                                    $idR = $_POST["lugarRotacion"];
                                }
                                ?>
                                <option value="<?php echo $row_rot['LugarRotacionCarreraID']; ?>" <?php
                                if ($row_rot['LugarRotacionCarreraID'] == $idR) {
                                    echo "selected";
                                }
                                ?>>
                                    <?php echo $row_rot['lugarRotacionBase']; ?></option>
                                <?php
                            } while ($row_rot = mysql_fetch_assoc($rot));
                            ?>
                        </select>
                    </div>
                </td>
            <?php } ?>
        </tr>
        <tr>
            <td bgcolor="#C5D5D6" class="Estilo2" align="center">Celular</td>
            <td colspan="2" class="Estilo1" align="left">
                <input name="celular" type="text" value="<?php if (isset($_POST['celular']))
                    echo $_POST['celular'];
                else
                    echo $row_dataestudiante['celularestudiantegeneral'];
                ?>" size="30">
            </td>
            <td bgcolor="#C5D5D6" align="center" class="Estilo2">E-mail <span class="Estilo4">*</span></td>
            <td colspan="2">
                <input name="email" type="text" id="email3" value="<?php
                if (isset($_POST['email']))
                    echo $_POST['email'];
                else {
                    echo $row_dataestudiante['emailestudiantegeneral'];
                }
                ?>" size="30">
            </td>
        </tr>
        <tr>
            <td height="27" bgcolor="#C5D5D6" class="Estilo2" align="center">Dir. Estudiante<span
                        class="Estilo4">*</span></td>
            <td colspan="5" class="Estilo1" align="left">&nbsp;
                <INPUT name="direccion1" size="90" readonly
                       onClick="window.open('direccion.php?inscripcion=1', 'direccion', 'width=1000,height=300,left=150,top=150,scrollbars=yes')"
                       value="<?php if (isset($_POST['direccion1']))
                           echo $_POST['direccion1'];
                       else
                           echo $row_dataestudiante['direccionresidenciaestudiantegeneral'];
                       ?>"/>
                <input name="direccion1oculta" type="hidden" value="<?php if (isset($_POST['direccion1oculta']))
                    echo $_POST['direccion1oculta'];
                else
                    echo $row_dataestudiante['direccioncortaresidenciaestudiantegeneral'];
                ?>">
                <?php
                // Set up regular expression strings to evaluate the value of email variable against
                $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
                echo "<span class='Estilo4'>";
                if ($_POST['direccion1'] == "" && $_POST['guardar']) {
                    echo utf8_decode('<script language="JavaScript">alert("Debe Digitar una Dirección de Residencia"); history.go(-1);</script>');
                }
                if (($_POST['email'] == "" || !preg_match($regex, $_POST['email'])) && $_POST['guardar']) {
                    echo utf8_decode('<script language="JavaScript">alert("Debe digitar una dirección de E-mail válida"); history.go(-1);</script>');
                }
                echo "</span>";
                ?>
            </td>
        </tr>
        <tr>
            <td height="27" bgcolor="#C5D5D6" class="Estilo2" align="center">Tel&eacute;fono<span
                        class="Estilo4">*</span></td>
            <td colspan="2" class="Estilo1" align="left">
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
            <td colspan="1" align="left" bgcolor="#C5D5D6">
                <div align="center"><span class="Estilo2">Ciudad Residencia<span class="Estilo4">*</span></span>
                </div>
            </td>
            <td colspan="2" align="center" class="Estilo2">
                <?php
                $query_ciudad = "select * from ciudad c,departamento d where c.iddepartamento = d.iddepartamento order by 3";
                $ciudad = mysql_query($query_ciudad, $sala) or die("$query_ciudad");
                $totalRows_ciudad = mysql_num_rows($ciudad);
                $row_ciudad = mysql_fetch_assoc($ciudad);
                ?>
                <select name="ciudad1">
                    <option value="0" <?php
                    if (!(strcmp("0", $row_dataestudiante['ciudadresidenciaestudiantegeneral']))) {
                        echo "SELECTED";
                    }
                    ?>>Seleccionar
                    </option>
                    <?php
                    do {
                        ?>
                        <option value="<?php echo $row_ciudad['idciudad'] ?>"<?php
                        if (!(strcmp($row_ciudad['idciudad'], $row_dataestudiante['ciudadresidenciaestudiantegeneral']))) {
                            echo "SELECTED";
                        }
                        ?>><?php echo $row_ciudad['nombreciudad'], "-", $row_ciudad['nombredepartamento']; ?></option>
                        <?php
                    } while ($row_ciudad = mysql_fetch_assoc($ciudad));
                    $rows = mysql_num_rows($ciudad);
                    if ($rows > 0) {
                        mysql_data_seek($ciudad, 0);
                        $row_ciudad = mysql_fetch_assoc($ciudad);
                    }
                    ?>
                </select>
                <?php
                echo "<span class='Estilo4'>";
                if ($_POST['ciudad1'] == 0 and $_POST['guardar']) {
                    echo '<script language="JavaScript">alert("Debe Seleccionar una ciudad de residencia"); history.go(-1);</script>';
                }
                echo "</span>";
                ?>
            </td>
        </tr>
        <tr>
            <td height="27" bgcolor="#C5D5D6" class="Estilo2" align="center">Dir. Correspondencia</td>
            <td colspan="2" class="Estilo1" align="left">&nbsp;
                <INPUT name="direccion2" size="70" onClick="" value="<?php if (isset($_POST['direccion2']))
                    echo $_POST['direccion2'];
                else
                    echo $row_dataestudiante['direccioncorrespondenciaestudiantegeneral'];
                ?>"/>
                <input name="direccion2oculta" type="hidden" size="25"
                       value="<?php if (isset($_POST['direccion2oculta']))
                           echo $_POST['direccion2oculta'];
                       else
                           echo $row_data['direccioncortacorrespondenciaestudiantegeneral'];
                       ?>"/>
            </td>
            <td colspan="1" align="left" bgcolor="#C5D5D6">
                <div align="center"><span class="Estilo2">Movilidad</span></div>
            </td>
            <td colspan="2" align="center" class="Estilo2"><a
                        href="../../../mgi/datos/internacionalizacion/ingresa_info.php?codigoestudiante=<?php echo $row_dataestudiante['codigoestudiante']; ?>"
                        target="popup" onClick="window.open(this.href, this.target, 'width=860,height=650,scrollbars=yes');
                                    return false;">click aqui para movilidad estudiantil</a>
            </td>
        </tr>
        <tr>
            <td height="26" bgcolor="#C5D5D6" class="Estilo2" align="center">Tel&eacute;fono</td>
            <td colspan="2" class="Estilo1" align="left"><input name="telefono2" type="text" id="telefono23"
                                                                value="<?php if (isset($_POST['telefono2']))
                                                                    echo $_POST['telefono2'];
                                                                else
                                                                    echo $row_dataestudiante['telefonocorrespondenciaestudiantegeneral'];
                                                                ?>" size="22">
            </td>
            <td colspan="1" align="left" class="Estilo1" bgcolor="#C5D5D6">
                <div align="center"><span class="Estilo2">Ciudad Corespondencia</span></div>
            </td>
            <td colspan="2" align="center" class="Estilo2">
                <?php
                $query_ciudad = "select * from ciudad c,departamento d where c.iddepartamento = d.iddepartamento order by 3";
                $ciudad = mysql_query($query_ciudad, $sala) or die("$query_ciudad");
                $totalRows_ciudad = mysql_num_rows($ciudad);
                $row_ciudad = mysql_fetch_assoc($ciudad);
                ?>
                <select name="ciudad2">
                    <option value="0" <?php
                    if (!(strcmp("0", $row_dataestudiante['ciudadcorrespondenciaestudiantegeneral']))) {
                        echo "SELECTED";
                    }
                    ?>>Seleccionar
                    </option>
                    <?php
                    do {
                        ?>
                        <option value="<?php echo $row_ciudad['idciudad'] ?>"<?php
                        if (!(strcmp($row_ciudad['idciudad'], $row_dataestudiante['ciudadcorrespondenciaestudiantegeneral']))) {
                            echo "SELECTED";
                        }
                        ?>><?php echo $row_ciudad['nombreciudad'], "-", $row_ciudad['nombredepartamento']; ?></option>
                        <?php
                    } while ($row_ciudad = mysql_fetch_assoc($ciudad));
                    $rows = mysql_num_rows($ciudad);
                    if ($rows > 0) {
                        mysql_data_seek($ciudad, 0);
                        $row_ciudad = mysql_fetch_assoc($ciudad);
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td height="26" bgcolor="#C5D5D6" class="Estilo2" align="center">Lugar de Nacimiento</td>
            <td colspan="2" class="Estilo1" align="left">
                <?php
                $ciudad = mysql_query($query_ciudad, $sala) or die("$query_ciudad");
                $totalRows_ciudad = mysql_num_rows($ciudad);
                $row_ciudad = mysql_fetch_assoc($ciudad);
                ?>
                <div style="margin:5px 2px;">(Si usted es extranjero seleccione en el menú .EXTRANJERO)</div>
                <select name="ciudadnacimiento">
                    <option value="0" <?php
                    if (!(strcmp("0", $row_dataestudiante['idciudadnacimiento']))) {
                        echo "SELECTED";
                    }
                    ?>>Seleccionar
                    </option>
                    <?php
                    do {
                        ?>
                        <option value="<?php echo $row_ciudad['idciudad'] ?>"<?php
                        if (!(strcmp($row_ciudad['idciudad'], $row_dataestudiante['idciudadnacimiento']))) {
                            echo "SELECTED";
                        }
                        ?>><?php echo $row_ciudad['nombreciudad'], "-", $row_ciudad['nombredepartamento']; ?></option>
                        <?php
                    } while ($row_ciudad = mysql_fetch_assoc($ciudad));
                    $rows = mysql_num_rows($ciudad);
                    if ($rows > 0) {
                        mysql_data_seek($ciudad, 0);
                        $row_ciudad = mysql_fetch_assoc($ciudad);
                    }
                    ?>
                </select>
            </td>
            <td colspan="1" align="left" class="Estilo1" bgcolor="#C5D5D6">
                <div align="center"><span class="Estilo2">País de Nacimiento</span></div>
            </td>
            <td colspan="2" align="center" class="Estilo2">
                <?php
                $query_pais = "select * from pais p Where codigoestado=100 order by 3";
                $pais = mysql_query($query_pais, $sala) or die("$query_pais");
                $totalRows_ciudad = mysql_num_rows($pais);
                $row_ciudad = mysql_fetch_assoc($pais);
                if ($row_dataestudiante['idpaisnacimiento'] == null) {
                    $row_dataestudiante['idpaisnacimiento'] = 1;
                }
                ?>
                <select id="idpaisnacimiento" name="idpaisnacimiento">
                    <?php
                    do {
                        ?>
                        <option value="<?php echo $row_ciudad['idpais'] ?>"<?php
                        if (!(strcmp($row_ciudad['idpais'], $row_dataestudiante['idpaisnacimiento']))) {
                            echo "SELECTED";
                        }
                        ?>><?php echo $row_ciudad['nombrepais']; ?></option>
                        <?php
                    } while ($row_ciudad = mysql_fetch_assoc($pais));
                    $rows = mysql_num_rows($pais);
                    if ($rows > 0) {
                        mysql_data_seek($pais, 0);
                        $row_ciudad = mysql_fetch_assoc($pais);
                    }
                    ?>
                </select>
            </td>
        </tr>
        <?php

        if ($Rol != 13) {

            switch ($arreglo) {
                case in_array(400, $arreglo)://graduado
                    ?>
                    <tr>
                        <td height="26" class="Estilo4 Estilo2" align="center" colspan="6">
                            LOS CAMPOS SOMBREADOS NO PUEDEN SER MODIFICADOS DEBIDO A LA SITUACI&Oacute;N DE GRADUADO DEL
                            ESTUDIANTE EN ESTE U OTRO PROGRAMA ACADEMICO.
                        </td>
                    </tr>
                    <?php
                    break;
            }
        }        
        ?>
    </table>
    <?php
    $SQL_DATA = 'SELECT * FROM EstudianteVisa WHERE idestudiantegeneral = "' . $idestudiantegeneral . '" AND estado = 100 ; ';
    $dataVisa = mysql_query($SQL_DATA, $sala) or die("$SQL_DATA");
    $TipoPermiso = '';

    while ($row_dataVisa = mysql_fetch_assoc($dataVisa)) {
        $TipoPermiso = $row_dataVisa['TipoPermiso'];
        $CategoriaVisaId = $row_dataVisa['CategoriaVisaId'];
        $NumeroVisa = $row_dataVisa['NumeroVisa'];
        $NumeroVisaT = $row_dataVisa['NumeroVisaT'];
        $FechaExpedicion = $row_dataVisa['FechaExpedicion'];
        $FechaVencimiento = $row_dataVisa['FechaVencimiento'];
        $idpaisnacimiento = $row_dataVisa['PaisId'];
    }
    if ($TipoPermiso) {
        $style = "";
    } else {

        $style = "display:none";
    }
    ?>
    <div id="table_extranjero" style="<?php echo $style; ?>">
        <p align="center" class="Estilo3">EXTRANJERO</p>
        <table width="876" border="1" align="center" cellpadding="1" bordercolor="#003333">
            <tr>
                <td class="Estilo2" bgcolor="#C5D5D6" align="center">Tipo Permiso:<span class="Estilo4">*</span></td>
                <td><select id="tipoPermiso" name="tipoPermiso">
                        <option value="">Seleccione</option>
                        <option value="1">VISA</option>
                        <option value="2">Permiso de estudio</option>
                        <option value="3">Permiso especial de permanencia</option>
                    </select></td>
            </tr>
        </table>
    </div>

    <div id="table_extranjero1" style="<?php echo $style; ?>">
        <table width="876" border="1" align="center" cellpadding="1" bordercolor="#003333">
            <tr>
                <td bgcolor="#C5D5D6" class="Estilo2" align="center">Categoria Visa<span class="Estilo4">*</span></td>
                <td colspan="2" class="Estilo1">
                    <select id="categoriavisa" name="categoriavisa">
                        <?php
                        $SQL_CATEGORIA = 'SELECT * FROM CategoriaVisa WHERE estado="100"; ';
                        $categoria = mysql_query($SQL_CATEGORIA, $sala) or die("$SQL_CATEGORIA");
                        ?>
                        <option value="0">Seleccione</option>
                        <?php while ($row_categoria = mysql_fetch_assoc($categoria)) { ?>
                            <option value="<?php echo $row_categoria['CategoriaVisaId']; ?>"><?php echo $row_categoria['Nombre']; ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td colspan="1" bgcolor="#C5D5D6" align="center" class="Estilo2">Número Visa<span
                            class="Estilo4">*</span></td>
                <td colspan="2" align="left" class="Estilo1"><input type="text" id="numerovisa1" name="numerovisa1"
                                                                    value="<?php echo $NumeroVisa; ?>"/></td>
            </tr>
            <tr>
                <td bgcolor="#C5D5D6" class="Estilo2" align="center">Fecha expedición visa (aaaa-mm-dd)<span
                            class="Estilo4">*</span></td>
                <td colspan="2" class="Estilo1">
                    <input type="text" id="fechaexpediciovisa1" name="fechaexpediciovisa1"
                           value="<?php echo $FechaExpedicion; ?>"/>
                </td>
                <td colspan="1" bgcolor="#C5D5D6" align="center" class="Estilo2">Fecha vencimiento visa
                    (aaaa-mm-dd)<span class="Estilo4">*</span></td>
                <td colspan="2" align="left" class="Estilo1"><input type="text" id="fechavencimientovisa1"
                                                                    name="fechavencimientovisa1"
                                                                    value="<?php echo $FechaVencimiento; ?>"/></td>
            </tr>
            <input type="hidden" name="exCategoria" value="1" id="exCategoria">
        </table>
    </div>

    <div id="table_extranjero2" style="<?php echo $style; ?>">
        <table width="876" border="1" align="center" cellpadding="1" bordercolor="#003333">
            <tr>
                <td colspan="1" bgcolor="#C5D5D6" align="center" class="Estilo2">Número <span class="Estilo4">*</span>
                </td>
                <td colspan="2" align="left" class="Estilo1"><input type="text" id="numerovisa" name="numerovisa"
                                                                    value="<?php echo $NumeroVisaT; ?>"/></td>
            </tr>
            <tr>
                <td bgcolor="#C5D5D6" class="Estilo2" align="center">Fecha expedición (aaaa-mm-dd)<span class="Estilo4">*</span>
                </td>
                <td colspan="2" class="Estilo1">
                    <input type="text" id="fechaexpediciovisa" name="fechaexpediciovisa"
                           value="<?php echo $FechaExpedicion; ?>"/>
                </td>
                <td colspan="1" bgcolor="#C5D5D6" align="center" class="Estilo2">Fecha vencimiento (aaaa-mm-dd)<span
                            class="Estilo4">*</span></td>
                <td colspan="2" align="left" class="Estilo1"><input type="text" id="fechavencimientovisa"
                                                                    name="fechavencimientovisa"
                                                                    value="<?php echo $FechaVencimiento; ?>"/></td>
            </tr>
            <input type="hidden" name="exCategoriaTipo" value="2" id="exCategoriaTipo">
        </table>
    </div>
    <?php
    //inicia el proceso para guardar los cambios
    if ($_POST['guardar']) {
        if (isset($_POST['programa'])) {
            $SQL = "SELECT codigojornada FROM jornadacarrera WHERE codigocarrera = '" . $_POST['programa'] . "'";
            $result_jornada = mysql_query($SQL, $sala) or die(mysql_error());
            $row_resultado_jornada = mysql_fetch_assoc($result_jornada);

            if ($row_resultado_jornada['codigojornada'] <> $_POST['jornada']) {
                echo "<script>alert('La jornada no corresponde al programa seleccionado');
                              history.go(-1);
                        </script>";
                die;
            }
        }

        if ($_POST['situacion'] == 300) {
            $SQL = 'SELECT codigosituacioncarreraestudiante FROM estudiante WHERE idestudiantegeneral = ' . $idestudiantegeneral;
            $resultado = mysql_query($SQL, $sala) or die(mysql_error());
            $row_resultado = mysql_fetch_assoc($resultado);
            if ($row_resultado['codigosituacioncarreraestudiante'] != 300) {
                $SQL = 'SELECT car.codigomodalidadacademica, car.codigocarrera FROM estudiante est
                                JOIN carrera car ON est.codigocarrera = car.codigocarrera
                                WHERE est.idestudiantegeneral = ' . $idestudiantegeneral . ' AND car.codigocarrera = ' . $row_dataestudiante['codigocarrera'];
                $resultado = mysql_query($SQL, $sala) or die(mysql_error());
                $row_resultado = mysql_fetch_assoc($resultado);
                if ($row_resultado['codigomodalidadacademica'] == 200 && $row_resultado['codigomodalidadacademica'] != 92) {

                }
            }
        }
        $_POST['nombres'] = strtoupper($_POST['nombres']);
        $_POST['apellidos'] = strtoupper($_POST['apellidos']);
        if ($_POST['situacion'] == 111) {
            $query_updest1 = "UPDATE inscripcion i, estudiantecarrerainscripcion  e
                    SET i.codigosituacioncarreraestudiante = '111'
                    WHERE i.idestudiantegeneral = '$idestudiantegeneral'
                    and i.codigoperiodo = '" . $_SESSION['codigoperiodosesion'] . "'
                    and e.idestudiantegeneral = i.idestudiantegeneral
                    and e.idinscripcion = i.idinscripcion
                    and e.codigocarrera = '" . $row_dataestudiante['codigocarrera'] . "'";

            $updest1 = mysql_query($query_updest1, $sala) or die(mysql_error());

        }

        if (trim($numerodocumentoinicial) == '0' || trim($numerodocumentoinicial) == '' || !isset($numerodocumentoinicial))
            $formulariovalido = 0;

        if (trim($_POST['documento']) == '0' || trim($_POST['documento']) == '' || !isset($_POST['documento'])) {
            $formulariovalido = 0;
            echo "<script language='javascript'>alert('El numero del documento no puede ser cero')</script>";
            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
        }
        if ($formulariovalido) {
            // Lo primero que se mira es si el nuevo documento que se quiere insertar no este ya en estudiantedocumento en los activos
            // Esto para los estudiantes que son diferentes al actual

            $query_estudianteexiste = "select * from estudiantedocumento where numerodocumento = '" . $_POST['documento'] . "' and fechainicioestudiantedocumento <= '" . date("Y-m-d H:m:s", time()) . "' and fechavencimientoestudiantedocumento >= '" . date("Y-m-d H:m:s", time()) . "' and idestudiantegeneral <> '$idestudiantegeneral'";

            $estudianteexiste = mysql_query($query_estudianteexiste, $sala) or die(mysql_error());
            $row_estudianteexiste = mysql_fetch_assoc($estudianteexiste);
            $totalRows_estudianteexiste = mysql_num_rows($estudianteexiste);

            if ($totalRows_estudianteexiste != "") {
                echo '<script language="JavaScript">alert("El documento ' . $_POST['documento'] . ' ya existe en el sistema"); hisroty.go(-1)</script>';
                exit();
            }

            if ($_POST['situacion'] == 103) {
                $query_ordenespagas = "SELECT *
                        FROM ordenpago o
                        WHERE codigoestadoordenpago LIKE '4%'
                        AND o.codigoestudiante = '" . $codigoestudiante . "'
                        AND o.codigoperiodo = '$periodoactual'";

                $ordenespagas = mysql_query($query_ordenespagas, $sala) or die(mysql_error());
                $row_ordenespagas = mysql_fetch_assoc($ordenespagas);
                $totalRows_ordenespagas = mysql_num_rows($ordenespagas);
                if ($row_ordenespagas <> "") {
                    echo '<script language="javascript">
                            alert ("Este estudiante se encuentra en estado matriculado, se retiraran las materias inscritas")
                            </script>';

                    $base = "update prematricula set  codigoestadoprematricula = 50
                            where codigoestudiante = '" . $codigoestudiante . "'
                            and codigoestadoprematricula like '4%'
                            and codigoperiodo = '$periodoactual'";
                    $sol = mysql_db_query($database_sala, $base);

                    $base1 = "update detalleprematricula set  codigoestadodetalleprematricula = 24
                            where idprematricula='" . $row_ordenespagas['idprematricula'] . "'";
                    $sol1 = mysql_db_query($database_sala, $base1);
                    $base2 = "update ordenpago set  codigoestadoordenpago = 52
                            where codigoestudiante = '" . $codigoestudiante . "'
                            and codigoestadoordenpago like '4%'
                            and codigoperiodo = '$periodoactual'";
                    $sol2 = mysql_db_query($database_sala, $base2);
                } else {
                    $query_ordenespagas = "SELECT * FROM ordenpago o WHERE codigoestadoordenpago LIKE '1%' AND o.codigoestudiante = '" . $codigoestudiante . "' AND o.codigoperiodo = '$periodoactual'";
                    $ordenespagas = mysql_query($query_ordenespagas, $sala) or die(mysql_error());
                    $row_ordenespagas = mysql_fetch_assoc($ordenespagas);
                    $totalRows_ordenespagas = mysql_num_rows($ordenespagas);
                    if ($row_ordenespagas <> "") {
                        echo '<script language="javascript">alert("Estudiante con prematricula activa por favor anulï¿½rsela antes de retirarlo")</script>';
                        echo '<script language="javascript">history.go(-1)</script>';
                    }
                }
            }

            $query_situacionestudiante1 = "SELECT * FROM historicosituacionestudiante WHERE  codigoestudiante = '" . $codigoestudiante . "' ORDER BY idhistoricosituacionestudiante DESC";

            $situacionestudiante1 = mysql_query($query_situacionestudiante1, $sala) OR die(mysql_error());
            $row_situacionestudiante1 = mysql_fetch_assoc($situacionestudiante1);
            $totalRows_situacionestudiante1 = mysql_num_rows($situacionestudiante1);

            $fechahoy = date("Y-m-d G:i:s", time());

            if ($_POST['situacion'] <> $row_situacionestudiante1['codigosituacioncarreraestudiante']) {
                if ($_POST['situacion'] == 104) {
                    require('../cierresemestre/funcionmateriaaprobada.php');
                    require('../cierresemestre/generarcargaestudiante.php');
                    if ($materiaspropuestas <> "") {
                        foreach ($materiaspropuestas as $k => $v) {
                            $totalmaterias[] = $v['codigomateria'];
                        }
                    }
                    if ($materiasobligatorias <> "") {
                        foreach ($materiasobligatorias as $k1 => $v1) {
                            $totalmaterias[] = $v1['codigomateria'];
                        }
                    }
                    if ($totalmaterias == "") {
                        $sql = "insert into historicosituacionestudiante(idhistoricosituacionestudiante,codigoestudiante,codigosituacioncarreraestudiante,codigoperiodo,fechahistoricosituacionestudiante,fechainiciohistoricosituacionestudiante,fechafinalhistoricosituacionestudiante,usuario)";
                        $sql .= "VALUES('0','" . $codigoestudiante . "','" . $_POST['situacion'] . "','" . $periodoactual . "','" . $fechahoy . "','" . $fechahoy . "','2999-12-31','" . $usuario . "')";
                        $result = mysql_query($sql, $sala);
                        $query_updest1 = "UPDATE historicosituacionestudiante  SET fechafinalhistoricosituacionestudiante = '" . $fechahoy . "' WHERE idhistoricosituacionestudiante = '" . $row_situacionestudiante1['idhistoricosituacionestudiante'] . "'";
                        $updest1 = mysql_query($query_updest1, $sala);
                    } else {
                        echo '<script language="JavaScript">alert("El estudiante tiene materias pendientes por Cursar de su plan de estudios, no puede pasar a egresado."); history.go(-1);</script>';
                        exit();
                    }
                } else {
                    $sql = "insert into historicosituacionestudiante(idhistoricosituacionestudiante,codigoestudiante,codigosituacioncarreraestudiante,codigoperiodo,fechahistoricosituacionestudiante,fechainiciohistoricosituacionestudiante,fechafinalhistoricosituacionestudiante,usuario)";
                    $sql .= "VALUES('0','" . $codigoestudiante . "','" . $_POST['situacion'] . "','" . $periodoactual . "','" . $fechahoy . "','" . $fechahoy . "','2999-12-31','" . $usuario . "')";
                    $result = mysql_query($sql, $sala);
                    $query_updest1 = "UPDATE historicosituacionestudiante SET fechafinalhistoricosituacionestudiante = '" . $fechahoy . "' WHERE idhistoricosituacionestudiante = '" . $row_situacionestudiante1['idhistoricosituacionestudiante'] . "'";
                    $updest1 = mysql_query($query_updest1, $sala);
                }
            }

            if ($_POST['situacion'] == 400 && $_POST['situacion'] != $row_dataestudiante['codigosituacioncarreraestudiante']) {
                require_once('../../../Connections/sala2.php');
                $rutaado = "../../../funciones/adodb/";
                require_once('../../../Connections/salaado.php');
                require_once('../../../funciones/sala/auditoria/auditoria.php');

                $auditoria = new auditoria();
                // Guardar en el logsituaciongraduados
                $sql = "INSERT INTO logsituaciongraduado(idlogsituaciongraduado, fechalogsituaciongraduado,  observacionlogsituaciongraduado, codigosituacioncarreraestudiante, idusuario, ip)
                        VALUES(0, now(), '" . $_POST['observacionsituacion'] . "', '" . $row_dataestudiante['codigosituacioncarreraestudiante'] . "', '$auditoria->idusuario', '$auditoria->ip')";

                $result = mysql_query($sql, $sala) or die(mysql_error());
            }
            $query_tipo = "SELECT * FROM historicotipoestudiante WHERE  codigoestudiante = '" . $codigoestudiante . "' ORDER BY idhistoricotipoestudiante DESC";

            $tipo = mysql_query($query_tipo, $sala) OR die(mysql_error());
            $row_tipo = mysql_fetch_assoc($tipo);
            $totalRows_tipo = mysql_num_rows($tipo);

            if ($_POST['tipoestudiante'] <> $row_tipo['codigotipoestudiante']) {
                $sql1 = "insert into historicotipoestudiante(idhistoricotipoestudiante,codigoestudiante,codigotipoestudiante,codigoperiodo,fechahistoricotipoestudiante,fechainiciohistoricotipoestudiante,fechafinalhistoricotipoestudiante,usuario,iphistoricotipoestudiante)";
                $sql1 .= "VALUES('0','" . $codigoestudiante . "','" . $_POST['tipoestudiante'] . "','" . $periodoactual . "','" . $fechahoy . "','" . $fechahoy . "','2999-12-31','" . $usuario . "','$ip')";
                $result1 = mysql_query($sql1, $sala);

                $query_updest1 = "UPDATE historicotipoestudiante SET fechafinalhistoricotipoestudiante = '" . $fechahoy . "' WHERE idhistoricotipoestudiante = '" . $row_tipo['idhistoricotipoestudiante'] . "'";
                $updest1 = mysql_query($query_updest1, $sala);
            }
            //*******************************************************************************************************************
            // INVOCA EL WEB SERVICE DE PS PARA REALIZAR LA ACTUALIZACION DE LOS DATOS, SI LA RESPUESTA ES ERRONEA NO SE HACE LA ACTUALIZACION EN SALA DE LOS DATOS

            require_once(realpath(dirname(__FILE__)) . '/../../interfacespeople/ordenesdepago/reportarmodificacionestudiantesala.php');
            //var_dump($result);
            if (($result['ERRNUM'] != 0 || $result['ERRNUM'] === '' || empty($result)) && $_POST['situacion'] == 400) {//Cambio realizado Por Marcos 11/06/2013
                echo "<script>alert('No se pudo realizar la actualizacion de la informacion. Por favor contáctese con la universidad para recibir ayuda en este proceso. Gracias.')</script>";
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=editarestudiante.php?usuarioeditar=" . $_POST['usuarioeditar'] . "&codigocreado=" . $_POST['codigocreado'] . "&facultad=" . $_SESSION['codigofacultad'] . "'>";
                exit;
            }
            //*******************************************************************************************************************
            // Miro si el documento es diferente al que se encuentra en estudiantegeneral.
            // Si es diferente inserta uno nuevo en estudiantedocumento y hace el update en estudiantegeneral

            $query_upddocumento = "select * from estudiantedocumento WHERE idestudiantegeneral = '$idestudiantegeneral' and numerodocumento = '" . $_POST['documento'] . "' and tipodocumento = '" . $_POST['tipodocumento'] . "' order by idestudiantedocumento DESC";
            $resultestdocumentos = mysql_query($query_upddocumento, $sala) or die("$query_upddocumento" . mysql_error());
            $totalRows_documentos = mysql_num_rows($resultestdocumentos);
            #recupera la ultima fila registrada en estudiante documento.
            $queryEstDocumentoRow = mysql_fetch_assoc($resultestdocumentos);

            if ($totalRows_documentos != "" && $totalRows_documentos > 0) {
                $upddocumento = mysql_query($query_upddocumento, $sala) or die("$query_upddocumento" . mysql_error());
                #valida si se ha cambiado el tipo o el numero de documento para generar un registro en estudiante documento
                if ($_POST['tipodocumento'] != $queryEstDocumentoRow['tipodocumento']
                    || $_POST['documento'] != $queryEstDocumentoRow['numerodocumento']) {
                    #valida duplicado en estudiantedocumento
                    $queryExistenceTypeNumberIdent = "
            select * from estudiantedocumento 
            where tipodocumento = " . $_POST['tipodocumento'] . " 
            and  numerodocumento = " . $_POST['documento'] . " 
            and idestudiantegeneral = $idestudiantegeneral;;
                    ";
                    $queryExistenceTypeNumberIdentExec = mysql_query($queryExistenceTypeNumberIdent, $sala) or die(mysql_error() . " LINE:" . __LINE__);
                    $queryExistenceTypeNumberIdentRow = mysql_fetch_assoc($queryExistenceTypeNumberIdentExec);
                    #si existe duplicado el tipo y el numero de documento
                    if (!empty($queryExistenceTypeNumberIdentRow)) {
                        #vence todos los documentos del estudiante
                        updateAllEstudianteDocumentoDueDate($sala, $idestudiantegeneral);
                        #actualiza fecha de vencimiento a vigente del documento existente.
                        $updateDueDateExistence = "
        update estudiantedocumento set fechavencimientoestudiantedocumento = '2999-12-31' where 
        idestudiantegeneral = $idestudiantegeneral 
        and idestudiantedocumento = " . $queryExistenceTypeNumberIdentRow['idestudiantedocumento'] . ";                        
        ";
                        $updateDueDateExistenceExecute = mysql_query($updateDueDateExistence, $sala) or die(mysql_error() . " LINE:" . __LINE__);

                    } else {
                        #vence todos los documentos del estudiante
                        updateAllEstudianteDocumentoDueDate($sala, $idestudiantegeneral);
                        #insercion de nuevo registro en estudiante documento cuando el tipo o numero de identificación es diferente
                        $query_insdocumento = "INSERT INTO estudiantedocumento(idestudiantegeneral, tipodocumento, numerodocumento, expedidodocumento, fechainicioestudiantedocumento, fechavencimientoestudiantedocumento)
                    VALUES('$idestudiantegeneral', '" . $_POST['tipodocumento'] . "', '" . $_POST['documento'] . "', '" . $_POST['expedido'] . "', '$fechaactual', '2999-12-31')";
                        mysql_query($query_insdocumento, $sala) or die("$query_upddocumento" . mysql_error() . " linea:" . __LINE__);
                    }

                } else {
                    #vence todos los documentos del estudiante
                    updateAllEstudianteDocumentoDueDate($sala, $idestudiantegeneral);
                    $updateDueDateExistence = "
                        update estudiantedocumento set fechavencimientoestudiantedocumento = '2999-12-31' where 
                        idestudiantegeneral = $idestudiantegeneral 
                        and numerodocumento = '" . $_POST['documento'] . "' and tipodocumento = '" . $_POST['tipodocumento'] . "';                        
        ";
                    $updateDueDateExistenceExecute = mysql_query($updateDueDateExistence, $sala) or die(mysql_error() . " LINE:" . __LINE__);

                }

            } else {
                #vence todos los documentos del estudiante
                updateAllEstudianteDocumentoDueDate($sala, $idestudiantegeneral);
                #cuando no existe registros en estudiantedocumento del estudiante general
                $query_insdocumento = "INSERT INTO estudiantedocumento(idestudiantedocumento, idestudiantegeneral, tipodocumento, numerodocumento, expedidodocumento, fechainicioestudiantedocumento, fechavencimientoestudiantedocumento)
            VALUES(0, '$idestudiantegeneral', '" . $_POST['tipodocumento'] . "', '" . $_POST['documento'] . "', '" . $_POST['expedido'] . "', '$fechahoy', '2999-12-31')";

                mysql_query($query_insdocumento, $sala) or die("$query_upddocumento" . mysql_error());
            }
            $fechahabil = date("Y-m-d");

            $unDiaMenos = strtotime("-1 day", strtotime($fechahabil));
            $fechahabil = date("Y-m-d", $unDiaMenos);

            $query_upddocumento = "UPDATE estudiantedocumento SET fechavencimientoestudiantedocumento='$fechahabil' WHERE idestudiantegeneral = '$idestudiantegeneral' and numerodocumento<>'" . $_POST['documento'] . "' AND fechavencimientoestudiantedocumento>NOW()";
            $upddocumento = mysql_query($query_upddocumento, $sala) or die("$query_upddocumento" . mysql_error());

            $query_updusuario = "UPDATE usuario SET numerodocumento = '" . $_POST['documento'] . "' WHERE numerodocumento = '$numerodocumentoinicial'";
            $updusuario = mysql_query($query_updusuario, $sala) or die("$query_updusuario" . mysql_error());

            $query_upddocumento = "select * from estudiantedocumento WHERE idestudiantegeneral = '$idestudiantegeneral'";
            $resultestdocumentos = mysql_query($query_upddocumento, $sala) or die("$query_upddocumento" . mysql_error());

            while ($row_estdocumentos = mysql_fetch_assoc($resultestdocumentos)) {
                $query_updusuario = "UPDATE usuario
                        SET numerodocumento = '" . $_POST['documento'] . "'
                        WHERE numerodocumento = '" . $row_estdocumentos["numerodocumento"] . "'";
                $updusuario = mysql_query($query_updusuario, $sala) or die("$query_updusuario" . mysql_error());
            }
            if ($_POST['fechaexpedicion'] == '' || $_POST['fechaexpedicion'] == null) {
                $_POST['fechaexpedicion'] = '2015-01-01';
            }
            if ($_POST['rh']) {
                $sqlrhbuscar = "SELECT idgruposanguineoestudiante FROM gruposanguineoestudiante WHERE idestudiantegeneral = '" . $idestudiantegeneral . "'";
                $id = $db->GetRow($sqlrhbuscar);

                if ($id['idgruposanguineoestudiante']) {
                    $sqlupdaterh = "UPDATE gruposanguineoestudiante SET idtipogruposanguineo='" . $_POST['rh'] . "' WHERE (idestudiantegeneral = '" . $idestudiantegeneral . "')";
                    $updaterh = mysql_query($sqlupdaterh, $sala) or die("$sqlupdaterh" . mysql_error());
                } else {
                    $sqlrhinserte = "INSERT INTO gruposanguineoestudiante (idtipogruposanguineo, idestudiantegeneral, codigoestado) VALUES ('" . $_POST['rh'] . "', '" . $idestudiantegeneral . "', '100')";
                    $insertrh = mysql_query($sqlrhinserte, $sala) or die("$sqlrhinserte" . mysql_error());
                }
            }//if rh

            $query_updestudiantegeneral = "UPDATE estudiantegeneral
                    SET tipodocumento='" . $_POST['tipodocumento'] . "',
                    numerodocumento='" . $_POST['documento'] . "',
                    expedidodocumento='" . $_POST['expedido'] . "',
                    nombrecortoestudiantegeneral='" . $_POST['documento'] . "',
                    nombresestudiantegeneral='" . $_POST['nombres'] . "',
                    apellidosestudiantegeneral='" . $_POST['apellidos'] . "',
                    fechanacimientoestudiantegeneral='" . $_POST['fnacimiento'] . "',
                    codigogenero='" . $_POST['genero'] . "',
                    direccionresidenciaestudiantegeneral='" . $_POST['direccion1'] . "',
                    direccioncortaresidenciaestudiantegeneral = '" . $_POST['direccion1oculta'] . "',
                    ciudadresidenciaestudiantegeneral='" . $_POST['ciudad1'] . "',
                    telefonoresidenciaestudiantegeneral='" . $_POST['telefono1'] . "',
                    telefono2estudiantegeneral='" . $_POST['telefono2'] . "',
                    celularestudiantegeneral='" . $_POST['celular'] . "',
                    direccioncorrespondenciaestudiantegeneral='" . $_POST['direccion2'] . "',
                    direccioncortacorrespondenciaestudiantegeneral = '" . $_POST['direccion2oculta'] . "',
                    ciudadcorrespondenciaestudiantegeneral='" . $_POST['ciudad2'] . "',
                    telefonocorrespondenciaestudiantegeneral='" . $_POST['telefono2'] . "',
                    emailestudiantegeneral='" . $_POST['email'] . "',
                    idciudadnacimiento='" . $_POST['ciudadnacimiento'] . "',
                    idpaisnacimiento='" . $_POST['idpaisnacimiento'] . "',
                    GrupoEtnicoId='" . $_POST['etnia'] . "',
                    FechaDocumento='" . $_POST['fechaexpedicion'] . "',                    
                    fechaactualizaciondatosestudiantegeneral='" . date("Y-m-d G:i:s", time()) . "'
                    WHERE idestudiantegeneral = '$idestudiantegeneral'";
            $updestudiantegeneral = mysql_query($query_updestudiantegeneral, $sala) or die("$query_updestudiantegeneral" . mysql_error());

            $query_datausuario = "select * from usuario where numerodocumento='" . $_POST['documento'] . "'";
            $datausuario = mysql_query($query_datausuario, $sala) or die("$query_datausuario" . mysql_error());
            $row_datausuario = mysql_fetch_assoc($datausuario);

            $objetoldap = new claseldap(SERVIDORLDAP, CLAVELDAP, PUERTOLDAP, CADENAADMINLDAP, "", RAIZDIRECTORIO);
            $objetoldap->ConexionAdmin();
            $infomodificado["gacctMail"] = $_POST['email'];

            if (!$objetoldap->ModificacionUsuario($infomodificado, $row_datausuario["usuario"])) {
                $objetoldap->AdicionUsuario($infomodificado, $row_datausuario["usuario"]);
            }

            if (isset($_POST['programa'])) {
                $query_updestudiante = "UPDATE estudiante
                        SET semestre='" . $_POST['semestre'] . "',
                        codigotipoestudiante='" . $_POST['tipoestudiante'] . "',
                        codigosituacioncarreraestudiante='" . $_POST['situacion'] . "',
                        codigojornada='" . $_POST['jornada'] . "',
                        codigocarrera='" . $_POST['programa'] . "',
                        VinculacionId = '" . $_POST['vinculacion'] . "'
                        WHERE codigoestudiante = '$codigoestudiante'";
            } else {
                $query_updestudiante = "UPDATE estudiante
                        SET semestre='" . $_POST['semestre'] . "',
                        codigotipoestudiante='" . $_POST['tipoestudiante'] . "',
                        codigosituacioncarreraestudiante='" . $_POST['situacion'] . "',
                        codigojornada='" . $_POST['jornada'] . "',
                        VinculacionId = '" . $_POST['vinculacion'] . "'
                        WHERE codigoestudiante = '$codigoestudiante'";
            }

            $updestudiante = mysql_query($query_updestudiante, $sala) or die("$query_updestudiantegeneral" . mysql_error());

            if (isset($_POST['programa']) && $_POST['programa'] != $_POST['programaanterior']) {
                $query_subperiodo = "select s.idsubperiodo from carreraperiodo c inner join subperiodo s on s.idcarreraperiodo=c.idcarreraperiodo  where c.codigocarrera='" . $_POST['programa'] . "' and c.codigoperiodo='" . $_SESSION['codigoperiodosesion'] . "' and c.codigoestado=100";
                $subperiodo = $db->GetRow($query_subperiodo);
                $sql = "UPDATE ordenpago SET idsubperiodo='" . $subperiodo["idsubperiodo"] . "', idsubperiododestino='" . $subperiodo["idsubperiodo"] . "' WHERE codigoperiodo='" . $_SESSION['codigoperiodosesion'] . "' and codigoestudiante='$codigoestudiante' and codigoestadoordenpago in (40,41) and idprematricula<>1";
                $db->Execute($sql);
            }

            $query_tipousuario = "SELECT idusuario FROM usuario  where usuario = '" . $usuario . "'";
            $tipousuario = $db->Execute($query_tipousuario);
            $totalRows_tipousuario = $tipousuario->RecordCount();
            $row_usuario = $tipousuario->FetchRow();
            $idusuario = $row_usuario["idusuario"];

            if (isset($_POST["lugarRotacion"]) && is_numeric($_POST["lugarRotacion"])) {
                $query_rotacion = "select codigoestudiante from LugarRotacionCarreraEstudiante where codigoestudiante = '" . $codigoestudiante . "'";
                $estudianterotacion = $db->Execute($query_rotacion);
                $totalRows_estudianterotacion = $estudianterotacion->RecordCount();
                $row_estudianterotacion = $estudianterotacion->FetchRow();
                if (!$row_estudianterotacion) {
                    $query_rotacion = "INSERT INTO `LugarRotacionCarreraEstudiante` (`codigoestudiante`, `LugarRotacionCarreraID`,                                      `FechaCreacion`, `UsuarioCreacion`, `FechaModificacion`, `UsuarioModificacion`) VALUES ('" . $codigoestudiante . "', '" . $_POST["lugarRotacion"] . "', '" . date("Y-m-d") . "', '" . $idusuario . "', '" . date("Y-m-d") . "', '" . $idusuario . "')";
                    $actualizarotacion = $db->Execute($query_rotacion);
                } else {
                    $query_rotacion = "UPDATE `LugarRotacionCarreraEstudiante` SET `LugarRotacionCarreraID`='" . $_POST["lugarRotacion"] . "', `codigoestado`= '100',`FechaModificacion`='" . date("Y-m-d") . "', `UsuarioModificacion`='" . $idusuario . "' WHERE (`codigoestudiante`='" . $codigoestudiante . "')";
                    $actualizarotacion = $db->Execute($query_rotacion);
                }
            }
            if ($_SESSION['MM_Username'] == 'dirsecgeneral') {
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=editarestudiante.php?codigocreado=" . $codigoestudiante . "'>";
                echo '<script language="JavaScript">history.go(-2);</script>';
                exit();
            }

            if ($totalRows_dataestudianteplan == "") {
                $query_planestudioestudiante = "UPDATE planestudioestudiante SET codigoestadoplanestudioestudiante = 200 WHERE codigoestudiante = '$codigoestudiante'";
                $planestudioestudiante = mysql_query($query_planestudioestudiante, $sala);

                $query_insplanestudioestudiante = "INSERT INTO planestudioestudiante(idplanestudio, codigoestudiante, fechaasignacionplanestudioestudiante, fechainicioplanestudioestudiante, fechavencimientoplanestudioestudiante, codigoestadoplanestudioestudiante)
                        VALUES('" . $_POST['planestudio'] . "', '$codigoestudiante', '" . date("Y-m-d") . "', '" . date("Y-m-d") . "', '2999-12-31', '101')";
                $insplanestudioestudiante = mysql_query($query_insplanestudioestudiante, $sala);
            } else {
                $query_planestudioestudiante = "UPDATE planestudioestudiante SET idplanestudio='" . $_POST['planestudio'] . "', fechaasignacionplanestudioestudiante='" . date("Y-m-d") . "' WHERE codigoestudiante = '$codigoestudiante'";
                $planestudioestudiante = mysql_query($query_planestudioestudiante, $sala);
            }

            $centralData = array(
                'SEARCHTERM1' => $_POST['documento'],
                'SEARCHTERM2' => '',
                'PARTNERTYPE' => '',
                'AUTHORIZATIONGROUP' => '',
                'PARTNERLANGUAGE' => '',
                'PARTNERLANGUAGEISO' => '',
                'DATAORIGINTYPE' => '',
                'CENTRALARCHIVINGFLAG' => '',
                'CENTRALBLOCK' => '',
                'TITLE_KEY' => '',
                'CONTACTALLOWANCE' => '',
                'PARTNEREXTERNAL' => '',
                'TITLELETTER' => '',
                'NOTRELEASED' => '',
                'COMM_TYPE' => ''
            );

            $centralDataX = array(
                'SEARCHTERM1' => 'X',
                'SEARCHTERM2' => '',
                'PARTNERTYPE' => '',
                'AUTHORIZATIONGROUP' => '',
                'PARTNERLANGUAGE' => '',
                'PARTNERLANGUAGEISO' => '',
                'DATAORIGINTYPE' => '',
                'CENTRALARCHIVINGFLAG' => '',
                'CENTRALBLOCK' => '',
                'TITLE_KEY' => '',
                'CONTACTALLOWANCE' => '',
                'PARTNEREXTERNAL' => '',
                'TITLELETTER' => '',
                'NOTRELEASED' => '',
                'COMM_TYPE' => ''
            );

            $dataPersona = array(
                'FIRSTNAME' => $_POST['nombres'],
                'LASTNAME' => $_POST['apellidos'],
                'BIRTHNAME' => '',
                'MIDDLENAME' => '',
                'SECONDNAME' => '',
                'TITLE_ACA1' => '',
                'TITLE_ACA2' => '',
                'TITLE_SPPL' => '',
                'PREFIX1' => '',
                'PREFIX2' => '',
                'NICKNAME' => '',
                'INITIALS' => '',
                'NAMEFORMAT' => '',
                'NAMCOUNTRY' => '',
                'NAMCOUNTRYISO' => '',
                'SEX' => '',
                'BIRTHPLACE' => '',
                'BIRTHDATE' => '',
                'DEATHDATE' => '',
                'MARITALSTATUS' => '',
                'CORRESPONDLANGUAGE' => '',
                'CORRESPONDLANGUAGEISO' => '',
                'FULLNAME' => $_POST['apellidos'] . ' ' . $_POST['nombres'],
                'EMPLOYER' => '',
                'OCCUPATION' => '',
                'NATIONALITY' => '',
                'NATIONALITYISO' => '',
                'COUNTRYORIGIN' => ''
            );

            $dataPersonaX = array(
                'FIRSTNAME' => 'X',
                'LASTNAME' => 'X',
                'BIRTHNAME' => '',
                'MIDDLENAME' => '',
                'SECONDNAME' => '',
                'TITLE_ACA1' => '',
                'TITLE_ACA2' => '',
                'TITLE_SPPL' => '',
                'PREFIX1' => '',
                'PREFIX2' => '',
                'NICKNAME' => '',
                'INITIALS' => '',
                'NAMEFORMAT' => '',
                'NAMCOUNTRY' => '',
                'NAMCOUNTRYISO' => '',
                'SEX' => '',
                'BIRTHPLACE' => '',
                'BIRTHDATE' => '',
                'DEATHDATE' => '',
                'MARITALSTATUS' => '',
                'CORRESPONDLANGUAGE' => '',
                'CORRESPONDLANGUAGEISO' => '',
                'FULLNAME' => 'X',
                'EMPLOYER' => '',
                'OCCUPATION' => '',
                'NATIONALITY' => '',
                'NATIONALITYISO' => '',
                'COUNTRYORIGIN' => ''
            );

            if (isset($_POST['telefono1'])) {
                $telefonoData = array(
                    'COUNTRY' => '',
                    'COUNTRYISO' => '',
                    'STD_NO' => '',
                    'TELEPHONE' => $_POST['telefono1'],
                    'EXTENSION' => '',
                    'TEL_NO' => '',
                    'CALLER_NO' => '',
                    'STD_RECIP' => '',
                    'R_3_USER' => '',
                    'HOME_FLAG' => '',
                    'CONSNUMBER' => '000',
                    'ERRORFLAG' => '',
                    'FLG_NOUSE' => ''
                );

                $telefonoDataX = array(
                    'COUNTRY' => '',
                    'COUNTRYISO' => '',
                    'STD_NO' => '',
                    'TELEPHONE' => 'X',
                    'EXTENSION' => '',
                    'TEL_NO' => '',
                    'CALLER_NO' => '',
                    'STD_RECIP' => '',
                    'R_3_USER' => '',
                    'HOME_FLAG' => '',
                    'CONSNUMBER' => 'X',
                    'UPDATEFLAG' => 'U',
                    'FLG_NOUSE' => ''
                );
            }

            $interlocutor = $idestudiantegeneral;
            
            $querySelect = "SELECT i.idinscripcion
                        FROM inscripcion i,
                        estudiantecarrerainscripcion e 
                        WHERE i.idestudiantegeneral = '$idestudiantegeneral'
                        and i.codigoperiodo = '" . $_SESSION['codigoperiodosesion'] . "'
                        and e.idestudiantegeneral = i.idestudiantegeneral
                        and e.idinscripcion = i.idinscripcion
                        and e.codigocarrera = '" . $row_dataestudiante['codigocarrera'] . "' ";
            $resultado1 = mysql_query($querySelect, $sala) or die(mysql_error());
            $row_resultado1 = mysql_fetch_assoc($resultado1);
            require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
            require_once(PATH_SITE . "/utiles/SincronizarInscripcionEstudiante/Fachada.php");

            class localFachadaED extends Sala\utiles\SincronizarInscripcionEstudiante\Fachada
            {

                function __construct()
                {

                }

            }

            $idinscripcion = $row_resultado1['idinscripcion'];
            $localFachada = new localFachadaED();
            $constructor = $localFachada->construir($idinscripcion, $codigoestudiante);
            $localFachada->sincronizar($constructor->getEstudiante()->getCodigoPeriodo(), $_POST['situacion'], $constructor->getEstudiante()->getCodigoestudiante(), $constructor->getInscripcion()->getIdinscripcion());
            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../prematricula/loginpru.php?codigocarrera=" . $row_dataestudiante['codigocarrera'] . "&estudiante=" . $row_dataestudiante['codigoestudiante'] . "'>";
        } 
    }
    }

    #actualiza la fecha de vencimiento para estudiantedocumento para un estudiante general
    function updateAllEstudianteDocumentoDueDate($sala, $idestudiantegeneral)
    {
        $queryUpdateDueDateAllDocuments = "
                            update estudiantedocumento set fechavencimientoestudiantedocumento = NOW() where idestudiantegeneral = $idestudiantegeneral;
                        ";
        $queryGetAllDocumentsExecute = mysql_query($queryUpdateDueDateAllDocuments, $sala) or die(mysql_error() . " LINE:" . __LINE__);

    }

    ?>
    <br>
    <div align="center">
        <input type="submit" name="guardar" value="guardar" id="guardar">
    </div>
</form>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.13.1.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script language="javascript" type="text/javascript">
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

    $('input#guardar').click(function (event) {

        event.preventDefault();
        var resultadov = verifica_admitido();

        if (resultadov) {
            $('#editarestudianteForm').append("<input type='hidden' name='guardar' value='guardar' />");
            document.getElementById('editarestudianteForm').submit();
        }

    });

    function verifica_admitido() {
        var situacion = $('#situacion').val();
        var guardar = $('#guardar').val();
        var tipoForm = $('#exCategoria').val();
        var tipoForm2 = $('#exCategoriaTipo').val();
        var categoriavisa = $('#categoriavisa').val();
        var numerovisaT = $('#numerovisa').val();
        var numerovisa = $('#numerovisa1').val();
        var idpaisnacimiento = $('#idpaisnacimiento').val();
        var tipoPermiso = $('#tipoPermiso').val();
        var idpaisnacimiento = $('#idpaisnacimiento').val();

        var fechaexpediciovisa = $('#fechaexpediciovisa1').val();
        if (fechaexpediciovisa == '') {
            var fechaexpediciovisa = $('#fechaexpediciovisa').val();
        }
        var fechavencimientovisa = $('#fechavencimientovisa1').val();
        if (fechavencimientovisa == '') {
            var fechavencimientovisa = $('#fechavencimientovisa').val();
        }
        var ciudadnacimiento = document.getElementsByName("ciudadnacimiento")[0].value;
        if (tipoPermiso == 1) {
            if (categoriavisa == 0) {
                alert('Debe Seleccionar Categoria Visa');
                return false;
            }
        }
        if (ciudadnacimiento != 2000) {
            if (idpaisnacimiento != 1) {
                alert('Verifique que la ciudad de nacimiento concuerde con el pais de nacimiento');
                return false;
            }
        } else {
            if (idpaisnacimiento == 1) {
                alert('Verifique que la ciudad de nacimiento concuerde con el pais de nacimiento');
                return false;
            }
        }

        if (idpaisnacimiento != 1) {
            if (numerovisaT == '') {
                if (numerovisa == '') {
                    alert('Debe Digitar El número de tarjeta');
                    return false;
                }
            }
            if (fechaexpediciovisa == '') {
                alert('Debe Seleccionar Fecha de Expedición de la tarjeta');
                return false;
            }
            if (fechavencimientovisa == '') {
                alert('Debe Seleccionar Fecha de Vencimiento de la tarjeta');
                return false;
            }
        }

        var respuesta = 1;

        $.ajax({
            type: 'POST',
            url: 'editarestudiante.php',
            async: false,
            dataType: 'json',
            data: ({
                action: 'verificar_admitido',
                situacion: situacion,
                idestudiantegeneral: '<?php echo $idestudiantegeneral; ?>',
                codigocarrera: '<?php echo $row_dataestudiante['codigocarrera']; ?>',
                guardar: guardar,
                fechaexpediciovisa: fechaexpediciovisa,
                fechavencimientovisa: fechavencimientovisa,
                categoriavisa: categoriavisa,
                numerovisa: numerovisa,
                numerovisaT: numerovisaT,
                idpaisnacimiento: idpaisnacimiento,
                tipoPermiso: tipoPermiso
            }),
            success: function (data) {
                respuesta = data.respuesta;
                if (data.respuesta == 0) {
                    respuesta = 1;
                } else {
                    var r = confirm('¿Está seguro que desea cambiar el estado a admitido?');
                    if (r == true) {
                        var nombres = $('#nombres2').val();
                        var apellidos = $('#apellidos').val();
                        var documento = $('#documento2').val();
                        var email = $('#email3').val();
                        //Creacion de nuvea varible nombre carrera para envio de datos
                        var nombrecarrera = $('#nombrecarrera').val();
                        $.ajax({
                            type: 'POST',
                            url: 'editarestudiante.php',
                            async: false,
                            dataType: 'json',
                            data: ({
                                action: 'enviar_carta',
                                nombres: nombres,
                                apellidos: apellidos,
                                nombrecarrera: nombrecarrera,
                                codigoestudiante: <?php echo $codigoestudiante?>,
                                documento: documento,
                                email: email
                            }),
                            success: function (data) {
                                respuesta = 1;
                            }
                        });
                    } else {
                        respuesta = 0;
                    }
                }
            }
        });
        if (respuesta == 0) {
            return false;
        } else {
            return true;
        }
    }

    $(document).ready(function () {
        $("#fechaexpediciovisa").datepicker({
            changeMonth: true,
            changeYear: true,
            buttonImage: "../css/themes/smoothness/images/calendar.gif",
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        });
        $('#ui-datepicker-div').css('display', 'none');
        $("#fechaexpediciovisa1").datepicker({
            changeMonth: true,
            changeYear: true,
            buttonImage: "../css/themes/smoothness/images/calendar.gif",
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        });
        $('#ui-datepicker-div').css('display', 'none');
        $("#fechavencimientovisa").datepicker({
            changeMonth: true,
            changeYear: true,
            buttonImage: "../css/themes/smoothness/images/calendar.gif",
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        });
        $("#fechavencimientovisa1").datepicker({
            changeMonth: true,
            changeYear: true,
            buttonImage: "../css/themes/smoothness/images/calendar.gif",
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        });
        var selectPrograma = "<?php echo $TipoPermiso; ?>";
        $('#tipoPermiso > option[value="' + selectPrograma + '"]').attr('selected', 'selected');
        var CategoriaVisaId = "<?php echo $CategoriaVisaId; ?>";
        var idpaisnacimiento = "<?php echo $idpaisnacimiento; ?>";
        if (idpaisnacimiento == '') {
            idpaisnacimiento = $('#idpaisnacimiento').val();
        }
        $('#idpaisnacimiento > option[value="' + idpaisnacimiento + '"]').attr('selected', 'selected');
        if (CategoriaVisaId != '0') {
            $('#categoriavisa > option[value="' + CategoriaVisaId + '"]').attr('selected', 'selected');
        }
        if (idpaisnacimiento !== '1') {
            if (idpaisnacimiento !== '') {
                $('#table_extranjero').css('display', 'block');
            }
        }

        if (selectPrograma == '1') {
            $('#table_extranjero2').css('display', 'none');
            $('#table_extranjero1').css('display', 'block');
            $(":text", $("#table_extranjero2")).val('');

        } else {
            if (selectPrograma !== '') {
                $('#table_extranjero1').css('display', 'none');
                $('#table_extranjero2').css('display', 'block');
                $(":text", $("#table_extranjero1")).val('');


            }
        }
        if (selectPrograma == '2') {
            $('#table_extranjero2').css('display', 'block');
            $('#table_extranjero1').css('display', 'none');
            $(":text", $("#table_extranjero1")).val('');
        }
        if (selectPrograma == '') {
            $('#table_extranjero1').css('display', 'none');
            $('#table_extranjero2').css('display', 'none');
        }
    });
    $(document).ready(function () {
        var CategoriaVisaId = "<?php echo $CategoriaVisaId; ?>";
        if (CategoriaVisaId == '0') {
            $("#categoriavisa").css("display", "none");
        }
        if (CategoriaVisaId == '') {
            $("#categoriavisa").css("display", "none");
        }

        var visa;
        $("#tipoPermiso").change(function () {
            visa = document.getElementById("tipoPermiso").value;

            if (visa == 1) {
                $("#categoriavisa").css("display", "block");
                $('#table_extranjero1').css('display', 'block');
                $('#table_extranjero2').css('display', 'none');
                $(":text", $("#table_extranjero2")).val('');

            } else {
                $('#table_extranjero2').css('display', 'block');
                $('#table_extranjero1').css('display', 'none');
                $(":text", $("#table_extranjero1")).val('');

            }
            if (visa == "") {
                $("#categoriavisa").css("display", "none");

            }
        });
    });
    $(document).ready(function () {

        $('#idpaisnacimiento').change(function () {

            if ($('#idpaisnacimiento option:selected').val() == 1) {
                $('#table_extranjero1').css('display', 'none');
                $('#table_extranjero').css('display', 'none');
                $('#table_extranjero2').css('display', 'none');
            } else {
                $('#table_extranjero').css('display', 'block');
            }
        });
    });

</script>
