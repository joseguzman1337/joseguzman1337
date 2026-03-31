<html>
    <head>
    </head>
    <body></body>
</html>

<?php
require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php');
require_once(realpath(dirname(__FILE__)).'/../../funciones/funcionip.php');

// Cargue de scripts para la validacion de programación y conceptos people
$cargarVerificacionProgramaFtConcepto_Back = true;
$cargarVerificacionProgramaFtConcepto_Front = true;
require_once (__DIR__ . '/parcialValidacionConceptoPorPrograma.php');

@session_start();

$ruta = "../../funciones/";
$rutaorden = "../../funciones/ordenpago/";
require_once($rutaorden.'claseordenpago.php');
mysql_select_db($database_sala, $sala);
$codigoestudiante = $_SESSION['codigo'];

/*******************  E.G.R 2006-11-30 *******************/

    // Selecciono el periodo de la fecha actual.
	mysql_select_db($database_sala, $sala);

	$query_selperiodo = "SELECT p.codigoperiodo,fechainiciofinancierosubperiodo,fechafinalfinancierosubperiodo
	FROM periodo p, carreraperiodo cp, subperiodo s,estudiante e
	WHERE p.codigoperiodo  = cp.codigoperiodo
	AND s.idcarreraperiodo = cp.idcarreraperiodo
	AND cp.codigocarrera = e.codigocarrera
	AND e.codigoestudiante = '$codigoestudiante'
	AND fechainiciofinancierosubperiodo <= '".date("Y-m-d")."'
	AND fechafinalfinancierosubperiodo >= '".date("Y-m-d")."'";

	$selperiodo = mysql_query($query_selperiodo, $sala) or die("$query_selperiodo");
	$totalRows_selperiodo=mysql_num_rows($selperiodo);
	$row_selperiodo=mysql_fetch_array($selperiodo);

	$codigoperiodo = $row_selperiodo['codigoperiodo'];
    $codigoperiodo = $_SESSION['codigoperiodosesion'];

/******************* Fin  E.G.R 2006-11-30 *******************/

$existeconcepto = false;
$existevalor = false;
$alert =0;

foreach($_POST as $key => $value){
	if(preg_match('/concepto/', $key)){
		$existeconcepto = true;
		$conceptos1[] = $value;
		$conceptos2[$value] = "sin valor";

		// Validar relación de concepto a pagar con people
        $idConcepto = $value;
        $idCodigoEstudiante = $codigoestudiante;

        $objVerificarConcepto = new VerificarConcepto($idConcepto, $idCodigoEstudiante, $db);
        $resultadoVerificacion = $objVerificarConcepto->generarVerificacion();
        $activarScriptConcepto = false;

        if(@$resultadoVerificacion['status'] == VerificarConcepto::STATUS_WITHOUT_LINK){
            die('<a href="'.$_SERVER['HTTP_REFERER'].'">[ Regresar ]</a> <script>objOrdenesPago.respuestaFallida();</script>');
        }

        //verifica si la cantidad es numerica y mayor a cero
		if(is_numeric($_POST['cantidad'.$value]) && $_POST['cantidad'.$value] > 0){
			$cantidades[$value] = $_POST['cantidad'.$value];
			//valida si existe un valor
            if(isset($_POST['valor'.$value])){
                //valida si el valor es mayor a cero
                if($_POST['valor'.$value] > 0) {
                    //asigna el valor al array en la posicion del concepto identificado
                    $conceptos2[ereg_replace("concepto", "", $key)] = $_POST['valor'.$value];
                    $existevalor = true;
                }else{
                    $alert =1;
                }
            }
		}
		else{
            $alert =1;
		}
	}
}

if($alert== 1){
    ?>
    <script language="javascript">
        alert("Todos los valores de los conceptos deben ser numéricos y mayores que cero ");
        history.go(-1);
    </script>
    <?php
    exit();
}

$observacion = $_POST['observacion'];

if(!$existeconcepto){
    ?>
    <script language="javascript">
	    alert("Debe seleccionar al menos un concepto para poder generar la orden de pago");
	    history.go(-1);
    </script>
    <?php
}
else{
    
	$ordenesxestudiante = new Ordenesestudiante($sala, $codigoestudiante, $codigoperiodo);
	if(!$ordenesxestudiante->validar_generacionordenesvarias($conceptos1)){
        ?> <script language="javascript"> history.go(-1); </script> <?php
	}
	else{
		if(!$existevalor){
			$ordenesxestudiante->generarordenpago_conceptoscantidad($conceptos1, $cantidades, $observacion);
		}
		else{
			 $ordenesxestudiante->generarordenpago_conceptosconvalorcantidad($conceptos1, $conceptos2, $cantidades, $observacion);
		}

        ?> <script language="javascript"> window.location.href="ordenpagovarias.php"; </script> <?php
	}
}