<?php

/**
 * Se incluye el archivo adaptador para tener acceso a las funciones basicas de
 * del nuevo sala si la aplicacion se corre en un entorno local o de pruebas 
 * se activa la visualizacion de todos los errores de php
 * @modified Diego rivera <riveradiego@unbosque.edu.do>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 12 de diciembre de 2018.
 */ 
require_once(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));
/**
 * El metodo Factory::validateSession($variables) hace una validacion de session activa en el sistema
 * dependiendo de los parametros que se le envíen, si determina que la session acabo redirige el sistema al login
 */
Factory::validateSession($variables);

/**
 * Si la aplicacion se corre en un entorno local o de pruebas se activa la visualizacion 
 * de todos los errores de php
 */
$pos = strpos($Configuration->getEntorno(), "local");
if ($Configuration->getEntorno() == "local" || $Configuration->getEntorno() == "pruebas" || $pos !== false) {
    //@error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
    //@ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
    /**
     * Se incluye la libreria Kint para hacer debug controlado de variables y objetos
     */
    require_once(PATH_ROOT . '/kint/Kint.class.php');
}

$codigotipodetalleprematricula = 10;
$codigoindicadorconceptoprematricula = 100;
$codigoindicadoraplicacobrocreditosacademicos = 200;
if (isset($_SESSION['cursosvacacionalessesion'])) {
    $conceptocobroxcreditos = $_POST['conceptocobroxcreditos'];
    if ($conceptocobroxcreditos == "" && isset($_SESSION['cursosvacacionalessesion'])) {
        // Muestra los conceptos que requieren cobro por creditos
        $query_selconceptocobroxcreditos = "select c.codigoconcepto, c.nombreconcepto, c.codigoindicadorconceptoprematricula, c.codigoindicadoraplicacobrocreditosacademicos
			from concepto c
			where c.codigoindicadoraplicacobrocreditosacademicos like '1%'
			and c.codigoestado like '1%' and c.nombreconcepto like '%vacaciones%'";
        //echo "$query_selconceptocobroxcreditos<br>";
        $selconceptocobroxcreditos = mysql_query($query_selconceptocobroxcreditos, $sala) or die("$query_selconceptocobroxcreditos");
        $totalRows_selconceptocobroxcreditos = mysql_num_rows($selconceptocobroxcreditos);
        $row_selconceptocobroxcreditos = mysql_fetch_array($selconceptocobroxcreditos);
        $conceptocobroxcreditos = $row_selconceptocobroxcreditos['codigoconcepto'];
    }
    // Muestra los conceptos que requieren cobro por creditos
    $query_selconceptocobroxcreditos = "select c.codigoconcepto, c.nombreconcepto, c.codigoindicadorconceptoprematricula, c.codigoindicadoraplicacobrocreditosacademicos
	from concepto c
	where c.codigoindicadoraplicacobrocreditosacademicos like '1%'
	and c.codigoestado like '1%'
	and c.codigoconcepto = '$conceptocobroxcreditos'";
    //echo "$query_selconceptocobroxcreditos<br>";
    $selconceptocobroxcreditos = mysql_query($query_selconceptocobroxcreditos, $sala) or die("$query_selconceptocobroxcreditos");
    $totalRows_selconceptocobroxcreditos = mysql_num_rows($selconceptocobroxcreditos);
    $row_selconceptocobroxcreditos = mysql_fetch_array($selconceptocobroxcreditos);
    $codigoindicadorconceptoprematricula = $row_selconceptocobroxcreditos['codigoindicadorconceptoprematricula'];
    $codigoindicadoraplicacobrocreditosacademicos = $row_selconceptocobroxcreditos['codigoindicadoraplicacobrocreditosacademicos'];

    // Si entra aca es por que es curso vacional u otro y el codigotipodetalleprematricula = 20 
    $codigotipodetalleprematricula = 20;

}

if ($calcularcreditosenfasis) {
    //echo "Entro acas<br>";
    //exit();
    if ($lineaescogida != "") {
        // Mira si el estudiante ya esta en la linea de enfasis
        // Si no esta lo adiciono a la linea
        $query_sellineaestudiante = "select l.idlineaenfasisplanestudio
		from lineaenfasisestudiante l
		where l.codigoestudiante = '$codigoestudiante'";
        $sellineaestudiante = mysql_db_query($database_sala, $query_sellineaestudiante) or die("$query_sellineaestudiante" . mysql_error());
        $totalRows_sellineaestudiante = mysql_num_rows($sellineaestudiante);
        $row_sellineaestudiante = mysql_fetch_array($sellineaestudiante);
        if ($totalRows_sellineaestudiante == "") {
            $idlinea = $lineaescogida;
            $query_selplanestudiante = "select p.idplanestudio
			from planestudioestudiante p
			where p.codigoestudiante = '$codigoestudiante'";
            $selplanestudiante = mysql_db_query($database_sala, $query_selplanestudiante) or die("$query_selplanestudiante" . mysql_error());
            $totalRows_selplanestudiante = mysql_num_rows($selplanestudiante);
            $row_selplanestudiante = mysql_fetch_array($selplanestudiante);
            $idplan = $row_selplanestudiante['idplanestudio'];

            $query_inslineaestudiante = "INSERT INTO lineaenfasisestudiante(idplanestudio, idlineaenfasisplanestudio, codigoestudiante, fechaasignacionfechainiciolineaenfasisestudiante, fechainiciolineaenfasisestudiante, fechavencimientolineaenfasisestudiante) 
			VALUES('$idplan', '$idlinea', '$codigoestudiante', '" . date("Y-m-d") . "', '" . date("Y-m-d") . "', '2999-12-31')";
            $inslineaestudiante = mysql_db_query($database_sala, $query_inslineaestudiante) or die("$query_inslineaestudiante" . mysql_error());
        }
    }
}

if (ereg("^1+", $codigoindicadorconceptoprematricula)) {
    //1. Se toman los datos de la prematricula anterior
    // Si es colegio se modifica este query
    if ($codigomodalidadacademica == 100) {
        $query_prematriculaanterior = "SELECT p.idprematricula, p.semestreprematricula
		FROM prematricula p
		WHERE (p.codigoestadoprematricula LIKE '4%' or p.codigoestadoprematricula LIKE '1%')
		AND p.codigoestudiante = '$codigoestudiante'
		and p.codigoperiodo = '$codigoperiodo'";
        
    } else {
        $query_prematriculaanterior = "SELECT p.idprematricula, p.semestreprematricula
		FROM prematricula p
		WHERE (p.codigoestadoprematricula LIKE '4%' or p.codigoestadoprematricula LIKE '1%')
		AND p.codigoestudiante = '$codigoestudiante'
		and p.codigoperiodo = '$codigoperiodo'";
    }
    $prematriculaanterior = mysql_db_query($database_sala, $query_prematriculaanterior) or die("$query_prematriculaanterior");
    $totalRows_prematriculaanterior = mysql_num_rows($prematriculaanterior);
    $row_prematriculaanterior = mysql_fetch_array($prematriculaanterior);
    //$tieneprematriculaactiva = true;
    begin;
    if ($totalRows_prematriculaanterior == "") {
        // Provicionalmente deja el semestre en 1 
        // Selecciona el estado de la prematricula
        $codigoestadoprematricula = '10';
        if ($procesoautomatico) {
            $codigoestadoprematricula = '11';
        }

        $query_insertprematriculanueva = "insert into prematricula(codigoestudiante,fechaprematricula,codigoperiodo,codigoestadoprematricula,observacionprematricula,semestreprematricula)
		VALUES('$codigoestudiante','" . date("Y-m-d", time()) . "','" . $codigoperiodo . "','$codigoestadoprematricula',' ','1')";
        //echo "$query_insertprematricula2 <br>";
        $insertprematriculanueva = mysql_db_query($database_sala, $query_insertprematriculanueva) or die("query_insertprematriculanueva");
        $idprematricula = mysql_insert_id();
        //exit();
        $totalcreditosinicial = $totalcreditos;
        $semestreprematriculainicial = $semestre;
        //$tieneprematriculaactiva = false;
    } else {
        // 1 Selecciona las materias que estan en estado 23 y las guarda en una matriz
        // 2 Le pone el idgrupo de esa materia que estaba en 23
        // Si había una materia para cambio de grupo la pasa a eliminada y vuelve a insertarla
        $idprematricula = $row_prematriculaanterior['idprematricula'];
        $semestreprematriculainicial = $row_prematriculaanterior['semestreprematricula'];

        $query_seldetalleprematriculacambiogrupo = "select codigomateria, idgrupo, codigomateriaelectiva, codigotipodetalleprematricula, numeroordenpago
		from detalleprematricula 
		WHERE idprematricula = '$idprematricula'
		and codigoestadodetalleprematricula = '23'";
        $seldetalleprematriculacambiogrupo = mysql_query($query_seldetalleprematriculacambiogrupo, $sala) or die("$query_seldetalleprematriculacambiogrupo");
        //$row_seldetalleprematriculacambiogrupo = mysql_fetch_array($seldetalleprematriculacambiogrupo);
        $totalRows_seldetalleprematriculacambiogrupo = mysql_num_rows($seldetalleprematriculacambiogrupo);
        if ($totalRows_seldetalleprematriculacambiogrupo != "") {
            while ($row_seldetalleprematriculacambiogrupo = mysql_fetch_array($seldetalleprematriculacambiogrupo)) {
                /**
                  * Caso 1613  
                  * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
                  * Ajuste de variable de Sessión idusuario con el fin que se almacene correctamente en la tabla
                  * logdetalleprematricula con el fin de evidenciar quien crea y anula materias de la carga académica. 
                  * @since Junio 17, 2019.
                */
                $query_inslogdetalleprematricula = "INSERT INTO logdetalleprematricula(idprematricula, codigomateria, codigomateriaelectiva, codigoestadodetalleprematricula, codigotipodetalleprematricula, idgrupo, numeroordenpago, fechalogfechadetalleprematricula, usuario, ip) 
				VALUES('$idprematricula','" . $row_seldetalleprematriculacambiogrupo['codigomateria'] . "','" . $row_seldetalleprematriculacambiogrupo['codigomateriaelectiva'] . "','22','" . $row_seldetalleprematriculacambiogrupo['codigotipodetalleprematricula'] . "','" . $row_seldetalleprematriculacambiogrupo['idgrupo'] . "','" . $row_seldetalleprematriculacambiogrupo['numeroordenpago'] . "','" . date("Y-m-d H:i:s", time()) . "',(SELECT usuario FROM usuario WHERE idusuario = ".$_SESSION['idusuario']."),'" . $ip . "')";
                $inslogdetalleprematricula = mysql_query($query_inslogdetalleprematricula, $sala) or die("$query_inslogdetalleprematricula");

                $cambiodegrupo[$row_seldetalleprematriculacambiogrupo['codigomateria']] = $row_seldetalleprematriculacambiogrupo['idgrupo'];
            }
        }

        $query_upddetalleprematriculaanterior = "UPDATE detalleprematricula 
		SET codigoestadodetalleprematricula = '22'
		WHERE idprematricula = '$idprematricula'
		and codigoestadodetalleprematricula = '23'";
        $upddetalleprematriculaanterior = mysql_query($query_upddetalleprematriculaanterior, $sala) or die("$query_upddetalleprematriculaanterior");
    }
} else {
    $idprematricula = 1;
}

//////////////////////////////////////////////////////////// grabar detalleprematricula
//exit();
//echo "concepto Valida ".$codigoconcepto."<br/>";
if ($procesoautomatico) {

    require("../grabardetalleprematricula.php");
} else {

    require("grabardetalleprematricula.php");
}

// De este archivo se llama a grabar la orden de pago
?> 
