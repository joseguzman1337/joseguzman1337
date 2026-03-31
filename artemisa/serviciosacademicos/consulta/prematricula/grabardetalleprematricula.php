<?php
include_once(realpath(dirname(__FILE__)) . '/ValidacionGruposCupos.php');
$respuesta = 0;
foreach ($materiascongrupo as $codigomateria3 => $idgrupovalidacion) {
    if ($respuesta == 0) {
        $respuesta = validacuposgrupo($idgrupovalidacion, $codigoperiodo, $codigocarrera);
    }
}
if ($procesoautomatico) {
    require_once("../actualizarmatriculados.php");
} else {
    require_once("actualizarmatriculados.php");
}
if (ereg("^1+", $codigoindicadorconceptoprematricula)) {
    // SELECCIONA LAS MATERIAS QUE TIENE EN DETALLEPREMATRICULA
    $query_detalleprematriculaanterior = "select * from detalleprematricula d where d.idprematricula = '$idprematricula' and (d.codigoestadodetalleprematricula LIKE '3%' or d.codigoestadodetalleprematricula LIKE '1%')";
    $detalleprematriculaanterior = mysql_db_query($database_sala, $query_detalleprematriculaanterior) or die("$query_detalleprematriculaanterior");
    $totalRows_detalleprematriculaanterior = mysql_num_rows($detalleprematriculaanterior);

    while ($row_detalleprematriculaanterior = mysql_fetch_array($detalleprematriculaanterior)) {
        $idgrupo_quitar = $row_detalleprematriculaanterior['idgrupo'];
        $ordenesdepago[$row_detalleprematriculaanterior['codigomateria']] = $row_detalleprematriculaanterior['numeroordenpago'];
        $codigomaterias[$row_detalleprematriculaanterior['codigomateria']] = $row_detalleprematriculaanterior['codigomateriaelectiva'];
        $idgrupos[$row_detalleprematriculaanterior['codigomateria']] = $row_detalleprematriculaanterior['idgrupo'];
        $estadodetalle[$row_detalleprematriculaanterior['codigomateria']] = $row_detalleprematriculaanterior['codigoestadodetalleprematricula'];
        $tipodetalleprematricula[$row_detalleprematriculaanterior['codigomateria']] = $row_detalleprematriculaanterior['codigotipodetalleprematricula'];

        actualizarmatriculadosNew($idgrupo_quitar, $codigoperiodo, $codigocarrera, $sala);
    }
    // Inserta las materias que se encuentran en detalleprematricula anteriormente
    // En el modificado elimina todas las materias de detalleprematricula
    if ($totalRows_detalleprematriculaanterior > 0) {
        $query_deldetalleprematricula = "DELETE FROM detalleprematricula WHERE idprematricula = '$idprematricula'  AND (codigoestadodetalleprematricula like '1%' or codigoestadodetalleprematricula like '3%')";
        $deldetalleprematricula = mysql_query($query_deldetalleprematricula, $sala) or die("$query_deldetalleprematricula");

        if ($respuesta == 1) {
            foreach ($codigomaterias as $codigomateria1 => $codigomateriaelectiva) {
                //$codigotipodetalleprematricula = 10;
                $query_estaendetalleprematricula = "select d.codigomateria  from detalleprematricula d where d.idprematricula = '$idprematricula' and (d.codigoestadodetalleprematricula LIKE '3%' or d.codigoestadodetalleprematricula LIKE '1%') and d.codigomateria = '$codigomateria1'";
                $estaendetalleprematricula = mysql_db_query($database_sala, $query_estaendetalleprematricula) or die("$query_estaendetalleprematricula");
                $totalRows_estaendetalleprematricula = mysql_num_rows($estaendetalleprematricula);

                // Si la materia esta doble inserta una de las dos en detalleprematricula
                if ($totalRows_estaendetalleprematricula == "") {
                    // Si la materia esta en el arreglo cambiodegrupo entonces le hace el update por el nuevo grupo
                    if (isset($cambiodegrupo)) {
                        if ($cambiodegrupo[$codigomateria1] != "") {
                            $query_upddetallenota = "update detallenota  set idgrupo = '" . $idgrupos[$codigomateria1] . "' where idgrupo = '" . $cambiodegrupo[$codigomateria1] . "' and codigoestudiante = '$codigoestudiante' and codigomateria = '$codigomateria1'";
                            $upddetallenota = mysql_db_query($database_sala, $query_upddetallenota) or die("$query_upddetallenota");
                        }
                    }
                    $query_insdetalleprematricula = "insert into detalleprematricula(idprematricula,codigomateria,codigomateriaelectiva,codigoestadodetalleprematricula,codigotipodetalleprematricula,idgrupo,numeroordenpago)	VALUES('$idprematricula','$codigomateria1','$codigomateriaelectiva','" . $estadodetalle[$codigomateria1] . "','" . $tipodetalleprematricula[$codigomateria1] . "$','" . $idgrupos[$codigomateria1] . "','" . $ordenesdepago[$codigomateria1] . "')";

                    $insdetalleprematricula = mysql_query($query_insdetalleprematricula, $sala) or die("$query_insdetalleprematricula");

                    $query_inslogdetalleprematricula = "INSERT INTO logdetalleprematricula(idprematricula, codigomateria, codigomateriaelectiva, codigoestadodetalleprematricula, codigotipodetalleprematricula, idgrupo, numeroordenpago, fechalogfechadetalleprematricula, usuario, ip) "
                            . "VALUES('$idprematricula','$codigomateria1','$codigomateriaelectiva','" . $estadodetalle[$codigomateria1] . "','$codigotipodetalleprematricula','" . $idgrupos[$codigomateria1] . "','" . $ordenesdepago[$codigomateria1] . "','" . date("Y-m-d H:i:s", time()) . "', (SELECT usuario FROM usuario WHERE idusuario = ".$_SESSION['idusuario']."),'" . $ip . "')";
                    $inslogdetalleprematricula = mysql_query($query_inslogdetalleprematricula, $sala) or die("$query_inslogdetalleprematricula");
                }
            }
        }//respuesta 1 		
    }//if
} else {
    $idprematricula = 1;
}

if ($respuesta == 1) {
    $orden->poner_idprematricula($idprematricula,$sala);
    #mensajeOrdenPago configurado para mostrar en popUp
    $orden->obtenerMensajeOrdenPorCarrera($codigoestudiante,$sala);
    //CREA LA ORDEN DE PAGO
    $orden->insertarordenpago();
    $numeroordenpago = $orden->tomar_numeroordenpago();

    $auxInsertarAporte = true;

    if (isset($_SESSION['cursosvacacionalessesion'])) {
        $auxInsertarAporte = false; 
    }
    $query_aporte = "SELECT
			c.codigomodalidadacademica
		FROM
			prematricula p
		INNER JOIN estudiante e ON e.codigoestudiante = p.codigoestudiante
		INNER JOIN carrera c ON e.codigocarrera = c.codigocarrera
		WHERE
			p.idprematricula = $idprematricula";

    $codigomodalidad = mysql_query($query_aporte, $sala) or die("$query_aporte <br>" . mysql_error());
    $row_modalidad = mysql_fetch_array($codigomodalidad);
    $codigomodalidadacademica = $row_modalidad['codigomodalidadacademica'];
   
    if ($auxInsertarAporte) {
        if ($codigomodalidadacademica == 200 || $codigomodalidadacademica == 300) {
            $orden->insertaAportesBecas();
        }
    }
    //ESTA VARIABLE SE USA PARA SABER SI UNA NUEVA MATERIA FUE INSERTADA
    $creditoscursosvacacionales = 0;

    foreach ($materiascongrupo as $codigomateria3 => $idgrupo3) {
        $codigoestadodetalleprematricula = 10;
        $creardetalle = true;
        //VERIFICAR QUE LAS MATERIAS DE ESTE ARREGLO NO ESTEN EN DETALLE PREMATRICULA PARA INSERTARLAS

        $query_estaendetalleprematricula = "SELECT d.codigomateria
                                            FROM detalleprematricula d 
                                            WHERE d.idprematricula = '".$idprematricula."' 
                                                  AND (d.codigoestadodetalleprematricula LIKE '3%' or
                                                      d.codigoestadodetalleprematricula LIKE '1%') 
                                                  AND d.codigomateria = '".$codigomateria3."'";
        $estaendetalleprematricula = mysql_db_query($database_sala, $query_estaendetalleprematricula) or die("$query_estaendetalleprematricula");
        $totalRows_estaendetalleprematricula = mysql_num_rows($estaendetalleprematricula);
        if ($totalRows_estaendetalleprematricula == "") {
            if ($materiaspapa[$codigomateria3] != "") {
                 $codigomateriaelectiva = ereg_replace("grupo", "", $materiaspapa[$codigomateria3]);
                unset($materiascongrupo[$codigomateria3],$materiascongrupo[$idgrupo3]);
                $materiascongrupo[$codigomateriaelectiva] = $idgrupo3;
            }
            else {
                // Si esta en el plan de estudio no le pongo codigomateriaelectiva
                $query_datosmateria = "SELECT m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio
                                       FROM materia m, detalleplanestudio dpe, planestudioestudiante pee
                                       WHERE m.codigomateria = '".$codigomateria3."'
                                       AND pee.codigoestudiante = '".$codigoestudiante."'
                                       AND m.codigomateria = dpe.codigomateria
                                       AND pee.idplanestudio = dpe.idplanestudio
                                       AND pee.codigoestadoplanestudioestudiante like '1%'";
                $datosmateria = mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
                $totalRows_datosmateria = mysql_num_rows($datosmateria);

                if ($totalRows_datosmateria != "") {
                    $codigomateriaelectiva = "";
                } else {
                    // Toma los datos de la materia si es enfasis
                    $query_datosmateria = "select m.nombremateria, m.codigomateria, 
						dle.semestredetallelineaenfasisplanestudio as semestredetalleplanestudio, dle.codigomateria as codigomateriaelectiva
						from materia m, detallelineaenfasisplanestudio dle, lineaenfasisestudiante lee
						where m.codigomateria = '$codigomateria3'
						and lee.codigoestudiante = '$codigoestudiante'
						and m.codigomateria = dle.codigomateriadetallelineaenfasisplanestudio
						and lee.idplanestudio = dle.idplanestudio
						and lee.idlineaenfasisplanestudio = dle.idlineaenfasisplanestudio
						and dle.codigoestadodetallelineaenfasisplanestudio like '1%'
						and (NOW() between lee.fechainiciolineaenfasisestudiante and lee.fechavencimientolineaenfasisestudiante)";
                    $datosmateria = mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
                    $totalRows_datosmateria = mysql_num_rows($datosmateria);
                    // Si se trata de una electiva
                    if ($totalRows_datosmateria != "") {
                        $row_datosmateria = mysql_fetch_array($datosmateria);
                        $codigomateriaelectiva = $row_datosmateria['codigomateriaelectiva'];
                    } else {
                        // Toma los datos de la materia si es electiva
                        // Si esta en grupo materia, toma la primera electiva del plan de estudio
                        $query_datosmateria = "select d.codigomateria, m.nombremateria, m.numerohorassemanales, m.numerocreditos
							from detallegrupomateria d, materia m, grupomateria g
							where d.codigomateria = m.codigomateria
							and d.idgrupomateria = g.idgrupomateria
							and g.codigoperiodo = '$codigoperiodo'				
							and m.codigomateria = '$codigomateria3'
							AND g.codigotipogrupomateria = '100'
							order by m.nombremateria";
                        // Otro query para selecciona los datos de las materias cuando el anterior es vacio para las demás materias
                        // Tanto enfasis como electivas libres											
                        $datosmateria = mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
                        $totalRows_datosmateria = mysql_num_rows($datosmateria);

                        if ($totalRows_datosmateria != "") {
                            // Selecciona una de las electivas del plan de estudio
                            $query_datosmateria = "select m.nombremateria, m.codigomateria as codigomateriaelectiva, dpe.semestredetalleplanestudio
								from materia m, detalleplanestudio dpe, planestudioestudiante pee
								where pee.codigoestudiante = '$codigoestudiante'
								and m.codigomateria = dpe.codigomateria
								and pee.idplanestudio = dpe.idplanestudio
								and pee.codigoestadoplanestudioestudiante like '1%'
								and dpe.codigotipomateria = '4'";
                            // Otro query para selecciona los datos de las materias cuando el anterior es vacio para las demás materias
                            // Tanto enfasis como electivas libres
                            $datosmateria = mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
                            $totalRows_datosmateria = mysql_num_rows($datosmateria);
                            if ($totalRows_datosmateria != "") {
                                $row_datosmateria = mysql_fetch_array($datosmateria);
                                $codigomateriaelectiva = $row_datosmateria['codigomateriaelectiva'];
                            }
                        } else {
                            $codigomateriaelectiva = "";
                        }
                    }
                }
            }
            if (ereg("^1+", $codigoindicadorconceptoprematricula)) {
                if (isset($cambiodegrupo)) {
                    if ($cambiodegrupo[$codigomateria3] != "") {
                        $query_upddetallenota = "update detallenota
							set idgrupo = '$idgrupo3'
							where idgrupo = '" . $cambiodegrupo[$codigomateria3] . "'
							and codigoestudiante = '$codigoestudiante'
							and codigomateria = '$codigomateria3'";
                        $upddetallenota = mysql_db_query($database_sala, $query_upddetallenota) or die("$query_upddetallenota");
                    }
                }
            }
            if (isset($_SESSION['cursosvacacionalessesion'])) {
                // Por cada materia a insertar averiguo los creditos
                $query_datomateria = "select m.nombremateria, m.codigomateria, m.numerocreditos
					from materia m
					where m.codigomateria = '$codigomateria3'";
                // Otro query para selecciona los datos de las materias cuando el anterior es vacio para las demás materias
                // Tanto enfasis como electivas libres
                $datomateria = mysql_query($query_datomateria, $sala) or die("$query_datomateria");
                $totalRows_datomateria = mysql_num_rows($datomateria);
                $row_datomateria = mysql_fetch_array($datomateria);
                $creditoscursosvacacionales = $creditoscursosvacacionales + $row_datomateria['numerocreditos'];
            }
            if (ereg("^1+", $codigoindicadorconceptoprematricula) || !isset($_SESSION['cursosvacacionalessesion'])) {

                /* ********************************************************************************************************** */
                $query_electivasvistas1 = "SELECT d.codigomateria,( semestredetalleplanestudio * 1)
					FROM planestudioestudiante p, detalleplanestudio d, materia m, tipomateria t
					WHERE p.codigoestudiante = '$codigoestudiante'
					AND p.idplanestudio = d.idplanestudio
					AND p.codigoestadoplanestudioestudiante LIKE '1%'
					AND d.codigoestadodetalleplanestudio LIKE '1%'
					AND d.codigomateria = m.codigomateria
					AND d.codigotipomateria = t.codigotipomateria
					AND d.codigotipomateria = '4'
					order by 2";

                $electivasvistas1 = mysql_query($query_electivasvistas1, $sala) or die("$query_electivasvistas1");
                $totalRows_electivasvistas1 = mysql_num_rows($electivasvistas1);
                $row_electivasvistas1 = mysql_fetch_array($electivasvistas1);

                $codigomateriaelectivapapa = 0;

                do {
                    $query_electivasvistas = "select n.notadefinitiva, m.numerocreditos, n.codigomateria, 
						m.codigoindicadorcredito, m.ulasa, m.ulasb, m.ulasc 
						from notahistorico n, materia m
						where n.codigomateria = m.codigomateria
						and m.notaminimaaprobatoria <= n.notadefinitiva
						and n.codigotipomateria = '4'
						and n.codigoestudiante = '$codigoestudiante'
						and n.codigomateriaelectiva = '" . $row_electivasvistas1['codigomateria'] . "'";

                    $electivasvistas = mysql_query($query_electivasvistas, $sala) or die("$query_electivasvistas");
                    $totalRows_electivasvistas = mysql_num_rows($electivasvistas);
                    $row_electivasvistas = mysql_fetch_array($electivasvistas);

                    if ($row_electivasvistas == "") {
                        if ($codigomateriaelectivapapa == 0) {
                            $codigomateriaelectivapapa = $row_electivasvistas1['codigomateria'];
                        }
                    }
                } while ($row_electivasvistas1 = mysql_fetch_array($electivasvistas1));


                if ($codigomateria3 == $codigomateriaelectiva) {
                    $codigomateriaelectiva = $codigomateriaelectivapapa;
                }

                /*                 * ********************************************************************************************************** */

                $query_insdetalleprematricula = "insert into detalleprematricula(idprematricula,codigomateria,codigomateriaelectiva,codigoestadodetalleprematricula,codigotipodetalleprematricula,idgrupo,numeroordenpago)	VALUES('$idprematricula','$codigomateria3','$codigomateriaelectiva','$codigoestadodetalleprematricula','$codigotipodetalleprematricula','$idgrupo3','$numeroordenpago')";

                $insdetalleprematricula = mysql_query($query_insdetalleprematricula, $sala) or die("$query_insdetalleprematricula" . mysql_error());

                actualizarmatriculadosNew($idgrupo3, $codigoperiodo, $codigocarrera, $sala);

                $query_inslogdetalleprematricula = "INSERT INTO logdetalleprematricula(idprematricula, codigomateria, codigomateriaelectiva, codigoestadodetalleprematricula, codigotipodetalleprematricula, idgrupo, numeroordenpago, fechalogfechadetalleprematricula, usuario, ip)"
                        . " 	VALUES('$idprematricula','$codigomateria3','$codigomateriaelectiva','$codigoestadodetalleprematricula','$codigotipodetalleprematricula','$idgrupo3','$numeroordenpago','" . date("Y-m-d H:i:s", time()) . "', (SELECT usuario FROM usuario WHERE idusuario = ".$_SESSION['idusuario']."),'" . $ip . "')";
                $inslogdetalleprematricula = mysql_query($query_inslogdetalleprematricula, $sala) or die("$query_inslogdetalleprematricula");
            }
            $idgrupofinal = $idgrupo3;
        }
    }
    // Calcula el semestre y el numero de creditos
    if (!ereg("^1+", $codigoindicadoraplicacobrocreditosacademicos)) {
        unset($materiaselegidas);
        $usarcondetalleprematricula = true;
    } else {
        $usarcondetalleprematricula = false;
    }
    if ($procesoautomatico) {
        require("../calculocreditossemestre.php");
    } else {
        require("calculocreditossemestre.php");
    }
    unset($materiaselegidas);
    #si el semestre calaculado falla en primera
    #instancia se ejecuta el metodo para calcularlo
        require_once('CalculoSemestreEstudiante.php');
    #instancia de clase que se encarga de calcular semestres y creditos del estudiante.
        $calculoSemestre = new CalculoSemestreEstudiante($materiascongrupo, $codigoestudiante);
        $semestrecalculado = $calculoSemestre->calculoSemestreEstudiantes();
    // Seleccionar le maximo numero de creditos para el semestre del plan de estudio
    // No se toman para este calculo las electivas libres ni las lineas de enfasis
    $query_seltotalcreditossemestre = "select sum(d.numerocreditosdetalleplanestudio) as totalcreditossemestre, d.idplanestudio
	from detalleplanestudio d, planestudioestudiante p
	where d.idplanestudio = p.idplanestudio
	and p.codigoestudiante = '$codigoestudiante'
	and d.semestredetalleplanestudio = '$semestrecalculado'
	and p.codigoestadoplanestudioestudiante like '1%'
	and d.codigotipomateria not like '4'
	and d.codigotipomateria not like '5'
	group by 2";
    $seltotalcreditossemestre = mysql_db_query($database_sala, $query_seltotalcreditossemestre) or die("$query_seltotalcreditossemestre");
    $totalRows_seltotalcreditossemestre = mysql_num_rows($seltotalcreditossemestre);
    $row_seltotalcreditossemestre = mysql_fetch_array($seltotalcreditossemestre);
    $totalcreditossemestre = $row_seltotalcreditossemestre['totalcreditossemestre'];

    if ($calcularcreditosenfasis == false) {
        $query_seltotalcreditossemestre = "select sum(d.numerocreditosdetallelineaenfasisplanestudio) as totalcreditossemestre, d.idplanestudio
		from detallelineaenfasisplanestudio d, lineaenfasisestudiante l
		where d.idplanestudio = l.idplanestudio
		and l.codigoestudiante = '$codigoestudiante'
		and d.semestredetallelineaenfasisplanestudio = '$semestrecalculado'
		and d.codigoestadodetallelineaenfasisplanestudio like '1%'
		and d.idlineaenfasisplanestudio = l.idlineaenfasisplanestudio
		and (NOW() between l.fechainiciolineaenfasisestudiante and l.fechavencimientolineaenfasisestudiante)
		group by 2";
        $seltotalcreditossemestre = mysql_db_query($database_sala, $query_seltotalcreditossemestre) or die("$query_seltotalcreditossemestre");
        $totalRows_seltotalcreditossemestre = mysql_num_rows($seltotalcreditossemestre);
        $row_seltotalcreditossemestre = mysql_fetch_array($seltotalcreditossemestre);
        if ($row_seltotalcreditossemestre <> "") {
            $calcularcreditosenfasis = true;
        }
    }
    if ($calcularcreditosenfasis) {
        $query_seltotalcreditossemestre = "select sum(d.numerocreditosdetallelineaenfasisplanestudio) as totalcreditossemestre, d.idplanestudio
		from detallelineaenfasisplanestudio d, lineaenfasisestudiante l
		where d.idplanestudio = l.idplanestudio
		and l.codigoestudiante = '$codigoestudiante'
		and d.semestredetallelineaenfasisplanestudio = '$semestrecalculado'
		and d.codigoestadodetallelineaenfasisplanestudio like '1%'
		and d.idlineaenfasisplanestudio = l.idlineaenfasisplanestudio
		and (NOW() between l.fechainiciolineaenfasisestudiante and l.fechavencimientolineaenfasisestudiante)
		group by 2";
        $seltotalcreditossemestre = mysql_db_query($database_sala, $query_seltotalcreditossemestre) or die("$query_seltotalcreditossemestre");
        $totalRows_seltotalcreditossemestre = mysql_num_rows($seltotalcreditossemestre);
        $row_seltotalcreditossemestre = mysql_fetch_array($seltotalcreditossemestre);
        $totalcreditossemestre = $totalcreditossemestre + $row_seltotalcreditossemestre['totalcreditossemestre'];
        if ($totalRows_seltotalcreditossemestre == "") {
            $query_seltotalcreditossemestre = "select sum(d.numerocreditosdetalleplanestudio) as totalcreditossemestre, d.idplanestudio
			from detalleplanestudio d, planestudioestudiante p
			where d.idplanestudio = p.idplanestudio
			and p.codigoestudiante = '$codigoestudiante'
			and d.semestredetalleplanestudio = '$semestrecalculado'
			and d.codigoestadodetalleplanestudio like '1%'
        and d.codigotipomateria like '5%'
			group by 2";
            $seltotalcreditossemestre = mysql_db_query($database_sala, $query_seltotalcreditossemestre) or die("$query_seltotalcreditossemestre");
            $totalRows_seltotalcreditossemestre = mysql_num_rows($seltotalcreditossemestre);
            $row_seltotalcreditossemestre = mysql_fetch_array($seltotalcreditossemestre);
            $totalcreditossemestre = $totalcreditossemestre + $row_seltotalcreditossemestre['totalcreditossemestre'];
        }
    }
    // Se selecciona el valor a pagar por el estudiante y la fecha de esntrega y el idfechafinanciera
    if ($codigoreferenciacobromatriculacarrera == '100') {

        $query_detallecohorte = "SELECT d.valordetallecohorte, d.codigoconcepto
		FROM cohorte c, detallecohorte d
		WHERE c.numerocohorte = '$numerocohorte'
		AND c.codigocarrera = '$codigocarrera'
		AND c.codigoperiodo = '$codigoperiodo'
		and c.codigojornada = '$codigojornada'
		AND c.codigoestadocohorte = '01'
		AND c.idcohorte = d.idcohorte 
		AND d.semestredetallecohorte = '$semestrecalculado'";
    } else {
        $query_detallecohorte = "select ve.preciovaloreducacioncontinuada as valordetallecohorte, ve.codigoconcepto
		from valoreducacioncontinuada ve
		where ve.fechainiciovaloreducacioncontinuada <= '" . date("Y-m-d", time()) . "'
		and ve.fechafinalvaloreducacioncontinuada >= '" . date("Y-m-d", time()) . "'
		and ve.codigocarrera = '$codigocarrera'";
    }
    $detallecohorte = mysql_db_query($database_sala, $query_detallecohorte) or die("$query_detallecohorte");
    $totalRows_detallecohorte = mysql_num_rows($detallecohorte);
    $row_detallecohorte = mysql_fetch_array($detallecohorte);
    $valordetallecohorte = $row_detallecohorte['valordetallecohorte'];
    $codigoconcepto = $row_detallecohorte['codigoconcepto'];

    $query_updprematriculaanterior = "UPDATE prematricula 
	SET semestreprematricula = '$semestrecalculado'
	WHERE idprematricula = '$idprematricula'";
    $updprematriculaanterior = mysql_query($query_updprematriculaanterior, $sala) or die("$query_updprematriculaanterior");

    $query_updestudiante = "UPDATE estudiante  SET semestre='$semestrecalculado' WHERE codigoestudiante = '$codigoestudiante'";
    $updestudiante = mysql_query($query_updestudiante, $sala) or die("$query_updestudiante" . mysql_error());

    if ($procesoautomatico) {
        require("../matriculaautomaticagrabarordendepago.php");
    } else {
        require("matriculaautomaticagrabarordendepago.php");
    }
    
}
?>
