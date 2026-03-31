<?php

	@session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php');
    require_once(realpath ( dirname(__FILE__)."/../../../sala/config/Configuration.php" ));
    $Configuration = Configuration::getInstance();
    require_once (PATH_SITE."/lib/Factory.php");

    echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/jquery-3.1.1.js");
    echo Factory::printImportJsCss("css",HTTP_ROOT ."/assets/css/sweetalert.css");
    echo Factory::printImportJsCss("js", HTTP_ROOT ."/assets/js/sweetalert.min.js");

    $ValidarSesion = new ValidarSesion();
	$ValidarSesion->Validar($_SESSION);

	//variable que indica que el modulo es matriculaautomatica
	$_GET['matriculaautomatica'] = true;
	//variable que se pondrá como true en caso de que se necesite habilitar el proceso de matricula para estudiante con deuda
	$habilitarMatriculaDeuda = false;


    if($_SESSION['rol'] == 1)
    {
         if(!isset($_SESSION['MM_prematricula']) || empty($_SESSION['MM_prematricula']) ||  $_SESSION['MM_prematricula'] == 'estudianterestringido'){
            require_once('loginpru.php');
           die;
        }
    }

    //definicion de variables de session
    $codigocarrera = $_SESSION['codigofacultad'];
    $codigoestudiante = $_SESSION['codigo'];
    $codigoperiodo = $_SESSION['codigoperiodosesion'];

    /*require_once(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));
    $sqlconceptosugeridos = "select c.codigoconcepto, c.nombreconcepto, c2.itemcarreraconceptopeople ".
    " from fechacarreraconcepto fcc ".
    " inner join concepto c on fcc.codigoconcepto = c.codigoconcepto ".
    " inner join carreraconceptopeople c2 on c.codigoconcepto = c2.codigoconcepto and c2.codigocarrera = fcc.codigocarrera ".
    " where fcc.fechavencimientofechacarreraconcepto > now() and fcc.codigocarrera = 341".
    " and c2.itemcarreraconceptopeople in ('010560000005', '010560000006', '081040040004')";
    $conceptossugeridos = $db->GetAll($sqlconceptosugeridos);*/


	require_once('../../Connections/sala2.php' );
	require_once("funcionmateriaaprobada.php");

	mysql_select_db($database_sala, $sala);
	$tmpsala=$sala;
	$rutaado=("../../funciones/adodb/");

	require_once("../../Connections/salaado-pear.php");
	require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
	require_once("../../funciones/sala_genericas/encuesta/ValidaEncuesta.php");
	require_once("../../funciones/sala_genericas/FuncionesCadena.php");
	$objetobase=new BaseDeDatosGeneral($sala);

	function valida_pazysalvoestudiante($sala,$codigoestudiante){
		$query_pazysalvo = "select p.idpazysalvoestudiante, e.codigocarrera from pazysalvoestudiante p".
        " , detallepazysalvoestudiante d, estudiante e where  e.codigoestudiante = $codigoestudiante ".
        " and p.idpazysalvoestudiante = d.idpazysalvoestudiante and d.codigotipopazysalvoestudiante <> '100' ".
        " and d.codigoestadopazysalvoestudiante like '1%' and e.idestudiantegeneral = p.idestudiantegeneral";

    	$pazysalvo = mysql_query($query_pazysalvo, $sala) or die("$query_pazysalvo" . mysql_error());
		$totalRows_pazysalvo = mysql_num_rows($pazysalvo);

		if ($totalRows_pazysalvo != ""){
           return false;
		}
		return true;
	}//function valida_pazysalvoestudiante

	function valida_saldoencontra($db,$objordendepago) {
		$saldoencontra = $objordendepago->tomar_saldo_contra($db);

		//fecha de hoy
		$today = date('Y-m-d');

		$response = true;

        if ($saldoencontra) {
			foreach ($saldoencontra as $key => $saldo) {
				if (strtotime($today)>strtotime($saldo[5])) {
					$response = false;
				    break;
				}
			}
		}

		return $response;

	}//function valida_saldoencontra

	$objetobase = new BaseDeDatosGeneral($sala);
	$rutaorden = "../../funciones/ordenpago/";
	$ruta = "../../funciones/";
	require_once($rutaorden . 'claseordenpago.php');

	if(!isset($_SESSION['cursosvacacionalessesion']) && isset($_GET['cursosvacacionales'])){
		$GLOBALS['cursosvacacionalessesion'];
		session_register("cursosvacacionalessesion");
		$_SESSION['cursosvacacionalessesion'] = "existe";
	}

	$sala = $tmpsala;

	$datosperiodoactivo = $objetobase->recuperar_datos_tabla("periodo", "codigoestadoperiodo",
        "1", "", "", 0);
	$datosperiodocierre = $objetobase->recuperar_datos_tabla("periodo", "codigoestadoperiodo",
        "3", "", "", 0);

	if ($datosperiodoactivo["codigoperiodo"] == $_SESSION['codigoperiodosesion']
        || $datosperiodocierre["codigoperiodo"] == $_SESSION['codigoperiodosesion']){
		$objordenesdepago = new Ordenpago($tmpsala, $_SESSION['codigo'], $_SESSION['codigoperiodosesion']);
		$estaapazysalvo = valida_pazysalvoestudiante($tmpsala,$_SESSION['codigo']);

    	$estasindeudas = valida_saldoencontra($db,$objordenesdepago);
    	$continua = 1;

		$codigocarrera = $_SESSION['codigofacultad'];
		$codigoestudiante = $_SESSION['codigo'];
		$codigoperiodo = $_SESSION['codigoperiodosesion'];

		// Datos del estudiante con prematricula hecha
    	$query_estudiante = "select concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, ".
        " e.codigoestudiante, c.nombrecarrera, c.codigocarrera, t.nombretipoestudiante,e.codigotipoestudiante, ".
        " pre.semestreprematricula as semestre, s.nombresituacioncarreraestudiante, ".
        " e.codigosituacioncarreraestudiante, eg.numerodocumento, c.codigoindicadorplanestudio, ".
        " c.codigoindicadortipocarrera, e.codigojornada,codigotipocosto from estudiante e, carrera c, ".
        " tipoestudiante t, situacioncarreraestudiante s, prematricula pre, estudiantegeneral eg ".
        " where e.codigoestudiante = $codigoestudiante  and e.codigocarrera = c.codigocarrera ".
        " and e.codigotipoestudiante = t.codigotipoestudiante and e.codigoperiodo = pre.codigoperiodo ".
        " and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante ".
        " and pre.codigoestudiante = e.codigoestudiante  and pre.codigoperiodo = $codigoperiodo ".
        " and (pre.codigoestadoprematricula like '1%' or pre.codigoestadoprematricula like '4%') ".
        " and eg.idestudiantegeneral = e.idestudiantegeneral";
    	$estudiante = mysql_query($query_estudiante, $sala) or die("$query_estudiante".mysql_error());
		$totalRows_estudiante = mysql_num_rows($estudiante);
		if($totalRows_estudiante == ""){
			// Datos del estudiante sin prematricula
			$query_estudiante = "select concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre,".
            " e.codigoestudiante, c.nombrecarrera, c.codigocarrera, t.nombretipoestudiante,e.codigotipoestudiante, ".
            " e.semestre, c.codigoindicadortipocarrera, s.nombresituacioncarreraestudiante, ".
            " e.codigosituacioncarreraestudiante, eg.numerodocumento, c.codigoindicadorplanestudio, ".
            " e.codigojornada,codigotipocosto from estudiante e, carrera c, tipoestudiante t, ".
            " situacioncarreraestudiante s, estudiantegeneral eg where e.codigoestudiante = $codigoestudiante ".
            " and e.codigocarrera = c.codigocarrera and e.codigotipoestudiante = t.codigotipoestudiante ".
            " and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante ".
            " and e.codigoperiodo <= $codigoperiodo and eg.idestudiantegeneral = e.idestudiantegeneral";
    		$estudiante = mysql_query($query_estudiante, $sala) or die("$query_estudiante".mysql_error());
		}

		$row_estudiante = mysql_fetch_assoc($estudiante);
		if(isset($_GET['cursosvacacionales'])){
			$query_selconceptocobroxcreditos = "select c.codigoconcepto, c.nombreconcepto, ".
            " c.codigoindicadorconceptoprematricula, c.codigoindicadoraplicacobrocreditosacademicos ".
            " from concepto c ".
            " where c.codigoindicadoraplicacobrocreditosacademicos like '1%' ".
            " and c.codigoestado like '1%' and c.nombreconcepto like '%vacaciones%'";
			$selconceptocobroxcreditos=mysql_query($query_selconceptocobroxcreditos, $sala) or die("$query_selconceptocobroxcreditos");
			$totalRows_selconceptocobroxcreditos = mysql_num_rows($selconceptocobroxcreditos);
			$row_selconceptocobroxcreditos = mysql_fetch_array($selconceptocobroxcreditos);
			$pruebaconceptovacacional[] = $row_selconceptocobroxcreditos['codigoconcepto'];
			$fechapago2 = $objordenesdepago->tomar_fechaconceptosbd($pruebaconceptovacacional);
			if($fechapago2 == '00-00-00'
                && $row_estudiante["codigotipoestudiante"]!=10
                && $row_estudiante["codigotipoestudiante"]!=21){
				$continua = 0;
				$mensaje = "No se tiene definida una fechacarreraconcepto para los cursos vacacionales para esta carrera.";
			}
		}//if

		if (!$estaapazysalvo){
			$continua = 0;
			$mensaje = "Señor Estudiante:". '\n'."Usted  no se encuentra a paz y salvo. Revise la Carta ".
            " estudiante situación general y diríjase a las áreas correspondientes para arreglar la situación respectiva.";
		}
		else if (($estasindeudas * 1) == 8){
			$tabla = "desbloqueodeudasestudiante d,estudiante e";
			$condicion = " and d.idestudiantegeneral=e.idestudiantegeneral and d.codigoperiodo='" .
            $_SESSION['codigoperiodosesion'] . "' and '".date("Y-m-d")."' between ".
            " substring(fechadesbloqueodeudasestudiante,1,10) and  ".
            " substring(TIMESTAMPADD(DAY,d.diasdesbloqueodeudasestudiante,d.fechadesbloqueodeudasestudiante),1,10) ".
            " and d.codigoestado like '1%'";
            $continua = 0;
            $mensaje = "PRESENTA DEUDAS DE PACIENTES COMUNIQUESE CON LAS CLINICAS ODONTOLOGICAS";
    	}
		else if (!$estasindeudas){
        	$tabla = "desbloqueodeudasestudiante d,estudiante e";
        	$condicion = " and d.idestudiantegeneral=e.idestudiantegeneral ".
            " and d.codigoperiodo='" . $_SESSION['codigoperiodosesion'] . "' ".
            " and '".date("Y-m-d")."' between substring(fechadesbloqueodeudasestudiante,1,10) ".
            " and substring(TIMESTAMPADD(DAY,d.diasdesbloqueodeudasestudiante,d.fechadesbloqueodeudasestudiante),1,10)".
            " and d.codigoestado like '1%'";
        	if (!$datosbloqueo = $objetobase->recuperar_datos_tabla($tabla, "e.codigoestudiante",
                $_SESSION['codigo'], $condicion,"",0)){
				$continua = 0;
				$mensaje = "Señor Estudiante:". '\n'."Usted  no se encuentra a paz y salvo, si tiene ".
                " ordenes por pagar vencidas,  por favor anúlelas. Revise la Carta estudiante situación general, ".
                " su estado de cuenta y diríjase a las áreas correspondientes para  arreglar la situación respectiva.";
			}
		}//else

		if (!$continua){
			alerta_javascript($mensaje);
			if (!$habilitarMatriculaDeuda) {
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=matriculaautomaticaordenmatricula.php'>";
				exit();
			}
		}
	}
	else{
    	$objordenesdepago = new Ordenpago($tmpsala, $_SESSION['codigo'], $_SESSION['codigoperiodosesion']);
    	$estaapazysalvo = valida_pazysalvoestudiante($tmpsala,$_SESSION['codigo']);
    	$estasindeudas = valida_saldoencontra($db,$objordenesdepago);
    	$continua = 1;

    	$codigocarrera = $_SESSION['codigofacultad'];
    	$codigoestudiante = $_SESSION['codigo'];

    	$codigoperiodo = $_SESSION['codigoperiodosesion'];

    	// Datos del estudiante con prematricula hecha
    	$query_estudiante = "select concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre,".
        " e.codigoestudiante, c.nombrecarrera, c.codigocarrera, t.nombretipoestudiante,e.codigotipoestudiante, ".
        " pre.semestreprematricula as semestre, s.nombresituacioncarreraestudiante, ".
        " e.codigosituacioncarreraestudiante, eg.numerodocumento, c.codigoindicadorplanestudio, ".
        " c.codigoindicadortipocarrera, e.codigojornada,codigotipocosto from estudiante e, ".
        " carrera c, tipoestudiante t, situacioncarreraestudiante s, prematricula pre, estudiantegeneral eg ".
        " where e.codigoestudiante = $codigoestudiante and e.codigocarrera = c.codigocarrera ".
        " and e.codigotipoestudiante = t.codigotipoestudiante and e.codigoperiodo = pre.codigoperiodo ".
        " and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante ".
        " and pre.codigoestudiante = e.codigoestudiante and pre.codigoperiodo = $codigoperiodo ".
        " and (pre.codigoestadoprematricula like '1%' or pre.codigoestadoprematricula like '4%') ".
        " and eg.idestudiantegeneral = e.idestudiantegeneral";
		$estudiante = mysql_query($query_estudiante, $sala) or die("$query_estudiante".mysql_error());
		$totalRows_estudiante = mysql_num_rows($estudiante);

		if($totalRows_estudiante == ""){
    		// Datos del estudiante sin prematricula
    		$query_estudiante = "select concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre,".
            " e.codigoestudiante, c.nombrecarrera, c.codigocarrera, t.nombretipoestudiante,e.codigotipoestudiante, ".
            " e.semestre, c.codigoindicadortipocarrera,	s.nombresituacioncarreraestudiante, ".
            " e.codigosituacioncarreraestudiante, eg.numerodocumento, c.codigoindicadorplanestudio, ".
            " e.codigojornada,codigotipocosto from estudiante e, carrera c, tipoestudiante t, ".
            " situacioncarreraestudiante s, estudiantegeneral eg where e.codigoestudiante = $codigoestudiante ".
            " and e.codigocarrera = c.codigocarrera and e.codigotipoestudiante = t.codigotipoestudiante ".
            " and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante ".
            " and e.codigoperiodo <= $codigoperiodo and eg.idestudiantegeneral = e.idestudiantegeneral";
    		$estudiante = mysql_query($query_estudiante, $sala) or die("$query_estudiante".mysql_error());
    	}
    	$row_estudiante = mysql_fetch_assoc($estudiante);

    	if(isset($_GET['cursosvacacionales'])){
    		$query_selconceptocobroxcreditos = "select c.codigoconcepto, c.nombreconcepto, ".
            " c.codigoindicadorconceptoprematricula, c.codigoindicadoraplicacobrocreditosacademicos ".
            " from concepto c ".
            " where c.codigoindicadoraplicacobrocreditosacademicos like '1%' ".
            " and c.codigoestado like '1%' and c.nombreconcepto like '%vacaciones%'";
			$selconceptocobroxcreditos=mysql_query($query_selconceptocobroxcreditos, $sala) or die("$query_selconceptocobroxcreditos");
			$totalRows_selconceptocobroxcreditos = mysql_num_rows($selconceptocobroxcreditos);
			$row_selconceptocobroxcreditos = mysql_fetch_array($selconceptocobroxcreditos);
			$pruebaconceptovacacional[] = $row_selconceptocobroxcreditos['codigoconcepto'];
    		$fechapago2 = $objordenesdepago->tomar_fechaconceptosbd($pruebaconceptovacacional);
    		if($fechapago2 == '00-00-00' &&
                $row_estudiante["codigotipoestudiante"]!=10 &&
                $row_estudiante["codigotipoestudiante"]!=21) {

    			$continua = 0;
    			$mensaje = "No se tiene definida una fechacarreraconcepto para los cursos vacacionales para esta carrera.";
    		}
    	}
    	if (!$estaapazysalvo){
        	$continua = 0;
        	$mensaje = "Señor Estudiante:". '\n'."Usted  no se encuentra a paz y salvo. Revise la ".
            " Carta estudiante situación general y diríjase a las áreas correspondientes para  ".
            " arreglar la situación respectiva.";
        }
    	else if (($estasindeudas * 1) == 8){
			$tabla = "desbloqueodeudasestudiante d,estudiante e";
			$condicion = " and d.idestudiantegeneral=e.idestudiantegeneral and d.codigoperiodo='" .
            $_SESSION['codigoperiodosesion'] . "' and '".date("Y-m-d")."' ".
            " between substring(fechadesbloqueodeudasestudiante,1,10) ".
            " and substring(TIMESTAMPADD(DAY,d.diasdesbloqueodeudasestudiante,d.fechadesbloqueodeudasestudiante),1,10)".
            " and d.codigoestado like '1%'";
			$continua = 0;
			// Este mensaje es cuando tiene deudas en sap
			$mensaje = "PRESENTA DEUDAS DE PACIENTES COMUNIQUESE CON LAS CLINICAS ODONTOLOGICAS";
		}
    	else if (!$estasindeudas){
			$tabla = "desbloqueodeudasestudiante d,estudiante e";
			$condicion = " and d.idestudiantegeneral=e.idestudiantegeneral ".
            " and d.codigoperiodo='" . $_SESSION['codigoperiodosesion'] . "' and '".date("Y-m-d")."' ".
            " between substring(fechadesbloqueodeudasestudiante,1,10) ".
            " and substring(TIMESTAMPADD(DAY,d.diasdesbloqueodeudasestudiante,d.fechadesbloqueodeudasestudiante),1,10)".
            " and d.codigoestado like '1%'";
			if (!$datosbloqueo = $objetobase->recuperar_datos_tabla($tabla, "e.codigoestudiante",
                $_SESSION['codigo'], $condicion,"",0)){
				$continua = 0;
				// Este mensaje es cuando tiene deudas en sap
				$mensaje = "Señor Estudiante:". '\n'."Usted  no se encuentra a paz y salvo, si tiene ordenes ".
                " por pagar vencidas,  por favor anúlelas. Revise la Carta estudiante situación general, ".
                " su estado de cuenta y diríjase a las áreas correspondientes para  arreglar la situación respectiva.";
			}
		}//else
		if (!$continua){
			alerta_javascript($mensaje);
			if (!$habilitarMatriculaDeuda) {
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=matriculaautomaticaordenmatricula.php'>";
				exit();
			}
		}
	}

	/****************** VALIDACION FECHA PARA PREMATRICULA FACULTAD ***********************************/

	$fecha = "select * from fechaacademica f where f.codigocarrera = '".$_SESSION['codigofacultad']."' ".
    " and f.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'";
	$db = mysql_query($fecha, $sala) or die("$fecha");
	$total = mysql_num_rows($db);
	$resultado = mysql_fetch_array($db);

	if ($resultado <> ""){
		if ((date("Y-m-d",(time())) < $resultado['fechainicialprematriculacarrera'])
            or (date("Y-m-d",(time())) > $resultado['fechafinalprematriculacarrera'])){
			echo '<script language="JavaScript">
			alert("Según el reglamento se podrá inscribir asignaturas adicionales hasta la segunda "+
			" semana de clases y no podrá cancelarse una asignatura respecto de la cual "+
			" se haya cursado el cincuenta por ciento (50 %) o más");
			</script>';
		}
	}
	/****************** FIN VALIDACION FECHA PARA PREMATRICULA ***********************************/

	$tieneunplandeestudios = true;
	$query_periodoactivo = "select nombreperiodo, codigoestadoperiodo from periodo where codigoperiodo = '$codigoperiodo'";
	$periodoactivo = mysql_db_query($database_sala,$query_periodoactivo) or die("$query_periodoactivo");
	$totalRows_periodoactivo = mysql_num_rows($periodoactivo);
	$row_periodoactivo = mysql_fetch_array($periodoactivo);
	$nombreperiodo = $row_periodoactivo['nombreperiodo'];

	if($row_periodoactivo['codigoestadoperiodo'] != '1'
        && $row_periodoactivo['codigoestadoperiodo'] != '4'
        && $row_periodoactivo['codigoestadoperiodo'] != '3'){
	    ?>
		<script language="javascript">
		alert("Cualquier cambio realizado puede eliminar las notas de una materia. Según reglamento"+
        " este tipo de \ncambios solo se puede hacer hasta el 50% del tiempo trascurrido del "+
        " periodo académico (Articulo 42 paragrafo 3).");
		</script>
	    <?php
	}

	$enfasisget = "";

	// Si el estudiante pidio generación de orden para plan de pagos y todavía no se le a creado el plan de pagos en sap
	// no le debe dejar inscribir asignaturas hasta que la orden le sea anulada
	$query_selordenpago = "select o.numeroordenpago from ordenpago o ".
    " where o.codigoperiodo = '$codigoperiodo' and o.codigoestudiante = '$codigoestudiante' ".
    " and o.codigoestadoordenpago like '14%'";
	$selordenpago = mysql_db_query($database_sala,$query_selordenpago) or die("$query_selordenpago");
	$totalRows_selordenpago = mysql_num_rows($selordenpago);

	if($totalRows_selordenpago != ""){
		$row_selordenpago = mysql_fetch_array($selordenpago);
		$query_selordenpagopp = "select opp.numerorodenpagoplandepagosap from ordenpagoplandepago opp ".
        " where opp.numerorodenpagoplandepagosap = '".$row_selordenpago['numeroordenpago']."' ".
        " and opp.codigoestado like '1%' and opp.codigoindicadorprocesosap not like '1%'";
		$selordenpagopp = mysql_db_query($database_sala,$query_selordenpagopp) or die("$query_selordenpagopp");
		$totalRows_selordenpagopp = mysql_num_rows($selordenpagopp);

		if($totalRows_selordenpagopp == ""){
		?>
			<script language="javascript">
				alert("No se le permite hacer la prematricula, primero debe realizar el plan de pagos y "+
                " registrar garantias, y si ya no lo desea debe anular la orden que "+
                " tiene y volver a la prematricula");
				history.go(-1);
			</script>
		<?php
		}
	}//if

    require("plan_pagos.php");
?>
<html lang="es">
	<head>
		<title>Carga del Estudiante</title>
        <?php
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/bootstrap.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT ."/assets/css/bootstrap.min.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-awesome.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/custom.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/general.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/loader.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT ."/sala/assets/css/CenterRadarIndicator/centerIndicator.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT ."/assets/css/sweetalert.css");

        echo Factory::printImportJsCss("js", HTTP_ROOT ."/assets/js/sweetalert.min.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/jquery-3.1.1.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/spiceLoading/pace.min.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/bootstrap.min.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/bootstrap.js");

		if(!isset($_SESSION['codigo']))
		{
		?>
			<script language="javascript">
				swal("Por seguridad su sesion ha sido cerrada, por favor reinicie.");
			</script>
		<?php
		}
		?>
	</head>
	<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
	<body>
        <div class="container">
            <?php
            if( preg_match("/^1.+$/",$row_estudiante['codigosituacioncarreraestudiante']) ||
                preg_match("/^4.+$/",$row_estudiante['codigosituacioncarreraestudiante'])){
                ?>
                <script language="JavaScript">
                    swal("La situación académica actual es: <?php echo $row_estudiante['nombresituacioncarreraestudiante'] ?>");
                    <?php
                    if(!isset($_SESSION['cursosvacacionalessesion'])){
                    ?>
                        window.location.href="matriculaautomaticaordenmatricula.php";
                    <?php
                    }
                    ?>
                </script>
                <?php
                echo "<h1>La situación académica actual es: ".$row_estudiante['nombresituacioncarreraestudiante'].
                    "<br>No puede realizar la Prematricula por favor Comuniquese con su Facultad.</h1>" ;

                if(!isset($_SESSION['cursosvacacionalessesion'])){
                    ?>
                    <input type="button" name="Regresar" value="Regresar"
                           onclick="window.location.href='matriculaautomaticaordenmatricula.php'">
                    <?php
                }
                exit();
            }

            // Datos de la primera prematricula hecha
            $query_premainicial1 = "SELECT d.codigomateria, d.codigotipodetalleprematricula ".
            " FROM detalleprematricula d, prematricula p, materia m, estudiante e ".
            " where d.codigomateria = m.codigomateria and d.idprematricula = p.idprematricula  ".
            " and p.codigoestudiante = e.codigoestudiante and e.codigoestudiante = $codigoestudiante ".
            " and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%') ".
            " and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%' ".
            " or d.codigoestadodetalleprematricula = '23') and p.codigoperiodo = $codigoperiodo";
            $premainicial1=mysql_query($query_premainicial1, $sala) or die("$query_premainicial1");
            $totalRows_premainicial1 = mysql_num_rows($premainicial1);
            $tieneprema = false;

            while($row_premainicial1 = mysql_fetch_array($premainicial1)){
                $prematricula_inicial[] = $row_premainicial1['codigomateria'];

                // Si la materia ya esta como curso vacacional hay que quitarla de la prematricula
                if(isset($_SESSION['cursosvacacionalessesion'])){
                    $quitarporcursosvacacionales[$row_premainicial1['codigomateria']] = true;
                }
                else if(preg_match("/^2+/",$row_premainicial1['codigotipodetalleprematricula'])){
                    $quitarporcursosvacacionales[$row_premainicial1['codigomateria']] = true;
                }
                $tieneprema = true;
            }//while
		?>

        <form name="form1" method="post" action="matriculaautomatica.php?documentoingreso=<?php echo $_GET['documentoingreso'];?>">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php
                            //valida si existe la vairable de curso vacaionales
                            if(!isset($_SESSION['cursosvacacionalessesion'])){
                                echo "MATRICULA CLASICA";
                            }
                            else{
                                echo "GENERACIÓN DE ORDENES POR CREDITOS";
                            }
                        ?>
                    </h3>
                </div>
            </div>
            <?php
        /* En desarrollo Noviembre 2020
            if($_SESSION['codigotipousuario'] == '400') {
                ?>
                <div>
                    <h4>Gestion administrativa de conceptos adicionales</h4>
                    <table class="table table-striped">
                        <tr>
                            <td id="tdtitulogris">Concepto </td>
                            <td>Descripcion</td>
                            <td>Item</td>
                            <td>Disponibles</td>
                        </tr>
                        <?php
                        foreach ($conceptossugeridos as $concepto) {
                            echo "<tr><td>" . $concepto['codigoconcepto'] . "</td>".
                            " <td>" . $concepto['nombreconcepto'] . "</td>".
                            " <td>" . $concepto['itemcarreraconceptopeople'] . "</td>";
                            echo "<td><input type='checkbox' id='valor' name='valorconcepto'></td></tr>";
                        }
                        ?>
                    </table>
                </div>
                <?php
            }*/
            ?>
            <div>
                <h4>Proceso de prematricula</h4>
                <?php
                    if(!preg_match("/^estudiante+$/", $_SESSION['MM_Username'])){
                        if(!preg_match("/^2.+$/",$row_estudiante['codigotipocosto'])
                            && !(isset($_SESSION['cursosvacacionalessesion']))){
                            ?>
                            <div class="col-md-12">
                                <input type="button" name="modificarcarga"
                               onClick="window.location.href='modificacionprematricula/modificacionprematricula.php?programausadopor=<?php echo $_GET['programausadopor'];?>'"
                               class="btn btn-success btn-xs" value="Modificar Carga Académica">
                                <input class="btn btn-danger btn-xs" name="regresar1" type="button" value="Regresar" onClick="regresar()">
                            </div>
                            <br>
                            <br>
                            <?php
                        }
                    }
                ?>
            </div>
            <div class="col-md-12">
                <table class="table table-striped">
                    <tr>
                        <td id="tdtitulogris">Estudiante</td>
                        <td colspan="6"><?php echo $row_estudiante['nombre'];?></td>
                        <td id="tdtitulogris"> Documento</td>
                        <td><?php echo $row_estudiante['numerodocumento'];?></td>
                    </tr>
                    <tr>
                        <td id="tdtitulogris">Carrera</td>
                        <td colspan="4"><?php echo $row_estudiante['nombrecarrera'];?></td>
                        <td colspan="2" id="tdtitulogris"> Tipo de Estudiante </td>
                        <td colspan="2"><?php echo $row_estudiante['nombretipoestudiante'];?></td>
                    </tr>
                    <tr>
                        <td id="tdtitulogris"> Periodo</td>
                        <td><?php echo $codigoperiodo;?></td>
                        <td id="tdtitulogris"> Semestre</td>
                        <td><?php echo $row_estudiante['semestre'];?></td>
                        <td colspan="2" id="tdtitulogris">Situaci&oacute;n Acad&eacute;mica</td>
                        <td><?php echo $row_estudiante['nombresituacioncarreraestudiante'];?></td>
                        <td id="tdtitulogris"> Fecha</td>
                        <td><?php echo date("Y-m-d");?></td>
                    </tr>
                </table>
            </div>
            <?php
				// Si se trata de las carreras que tienen plan de estudio o que se comportan como pregrad
				if(preg_match("/^1.+$/",$row_estudiante['codigoindicadortipocarrera'])){
					// Se hace la selección de horarios
					//Carga la lista de materias disponibles para el estudiante
					require('matriculaautomaticapregrado.php');
				}

				// Si se trata de carreras que se comportan como cursos donde las materias se selecciona de una en una
				// Se debe mostrar solamente la carga académica
				if(preg_match("/^2.+$/",$row_estudiante['codigoindicadortipocarrera'])){
					// Se hace la selección de horarios
					require('matriculaautomaticacursoscertificados.php');
				}

				// Se debe mostrar solamente la materia y los grupos de esa materia
				if(preg_match("/^3.+$/",$row_estudiante['codigoindicadortipocarrera'])){
					// Se hace la selección de horarios
					require('matriculaautomaticacursoslibres.php');
				}
				echo
                    "<script language='javascript'>
				        function regresar(){
					        window.location.href='matriculaautomaticaordenmatricula.php?programausadopor=".$_GET['programausadopor']."';
				        }
				        
				        function regresarinscripcion(){
					        window.location.href='inscripcionestudiante/formulariopreinscripcion.php?documentoingreso=".$_GET['documentoingreso']."&logincorrecto';
				        }
				    </script>";
			?>
		</form>
	</body>
</html>

<script language="javascript">
	function ChequearTodos(chkbox, seleccion){
		for (var i=0;i < document.forms[0].elements.length;i++){
			var elemento = document.forms[0].elements[i];
			if(elemento.type != "checkbox"){
				if (elemento.title == seleccion){
					elemento.checked = chkbox.checked
				}
			}
		}
	}//function ChequearTodos

	function HabilitarGrupo(seleccion){
		for (var i=0;i < document.forms[0].elements.length;i++){
			var elemento = document.forms[0].elements[i];
			if(elemento.type == "checkbox"){
				var reg = new RegExp("^electoblig");
				if(!elemento.name.search(reg)){
					if(elemento.title == seleccion){
						elemento.disabled = false;
					}
					else{
						elemento.disabled = true;
					}
				}
			}
		}
	}//function HabilitarGrupo

	function HabilitarGrupoCheck(seleccion){
		for (var i=0;i < document.forms[0].elements.length;i++){
			var elemento = document.forms[0].elements[i];
			if(elemento.type == "radio"){
				if (elemento.title == seleccion){
					if(elemento.disabled){
						elemento.disabled = false;
					}
					else{
						elemento.disabled = true;
					}
				}
			}
		}
	}//function HabilitarGrupoCheck

    function DesabilitarGrupo(seleccion){
		for (var i=0;i < document.forms[0].elements.length;i++){
			var elemento = document.forms[0].elements[i];
			if(elemento.type == "checkbox"){
				if (elemento.title == seleccion){
					elemento.disabled = true;
				}
			}
		}
	}//function DesabilitarGrupo

	function limpiar0(numero){
		if(document.form1.dat[numero-2].checked){
			document.form1.dat[numero-2].checked = false;
		}
	}//unction limpiar

	function limpiar1(numero){
		if(document.form1.dat[numero-1].checked){
			document.form1.dat[numero-1].checked = false;
		}
	}//function limpiar1

	function limpiar2(numero){
		if(document.form1.data[numero-2].checked){
			document.form1.data[numero-2].checked = false;
		}
	}//function limpiar2

	function limpiar3(numero){
		if(document.form1.data[numero-1].checked){
			document.form1.data[numero-1].checked = false;
		}
	}//function limpiar3

	function habilitar(campo){
		var entro = false;
		for (i = 0; i < campo.length; i++){
			campo[i].disabled = false;
			entro = true;
		}
		if(!entro){
			form1.habilita.disabled = false;
		}
	}//function habilitar

	function iramodificar(){
		window.location.href="modificacionprematricula/modificacionprematricula.php";
	}//function iramodificar
</script>
