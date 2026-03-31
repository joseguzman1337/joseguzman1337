<?php

/*
 * Ivan Dario Quintero Rios
 * Modificacion 28 de Diciembre del 2017
 */

class Inscripcion {

    public function TipoDocumento($db) {
        $SQL = 'SELECT
                tipodocumento AS id,
                nombredocumento AS name
            FROM
                documento
            WHERE
                codigoestado = 100
            AND tipodocumento <> 0';

        if ($TipoDocumento = &$db->GetAll($SQL) === false) {
            echo 'Error en el SQL del Tipo Documento....<br><br>';
            die;
        }

        return $TipoDocumento;
    }

//public function TipoDocumento

    public function Genero($db) {
        $SQL = 'SELECT
                codigogenero AS id,
                nombregenero AS name
            FROM
                genero';

        if ($Genero = &$db->GetAll($SQL) === false) {
            echo 'Error en el SQL del Genero....<br><br>';
            die;
        }
        return $Genero;
    }

//public function Genero

    public function buscarEstudiante($db, $txtNumeroDocumento) {
        $SQL = "SELECT E.idestudiantegeneral, E.numerodocumento, E.tipodocumento,
    			DATE_FORMAT(E.fechanacimientoestudiantegeneral,'%Y-%m-%d') AS fechanacimientoestudiantegeneral, E.telefonoresidenciaestudiantegeneral,
				E.telefono2estudiantegeneral, E.tipodocumento, E.nombresestudiantegeneral, E.apellidosestudiantegeneral , E.emailestudiantegeneral, E.celularestudiantegeneral,
				D.nombredocumento, E.codigogenero, G.nombregenero
    			FROM estudiantegeneral E
    			INNER JOIN documento D ON ( D.tipodocumento = E.tipodocumento )
    			INNER JOIN genero G ON ( G.codigogenero = E.codigogenero )
    			WHERE numerodocumento = " . $txtNumeroDocumento . " ";

        if ($buscaEstudiante = &$db->GetAll($SQL) === false) {
            echo "Error en el SQL del Genero....<br><br>";
            die;
        }
        return $buscaEstudiante;
    }

    /*
     * Ivan Dario Quintero Rios
     * Modificacion 26 de Diciembre del 2017
     */

    //Consulta el texto de la agrupacion de cursos
    public function TextoCurso($db, $grupo) {
        if (is_numeric($grupo)) { /* Modified Diego Rivera <riveradiego@unbosque.edu.co>
         * Se añade en el in ()  es estado 3 (precierre)
         * Since June 18,2018
         */

            $SQLdatos = 'SELECT
                    c.nombrecarrera,
                    m.nombremateria,
                    g.nombregrupo,
                    g.codigoperiodo,
                    g.maximogrupo,
                    g.matriculadosgrupo,
                    g.idgrupo, 
                    ce.AgrupacionCarreraEducacionContinuadaId,
                    a.NombreAgrupacion
                FROM
                    carrera c
                INNER JOIN materia m ON m.codigocarrera = c.codigocarrera
                INNER JOIN grupo g ON g.codigomateria = m.codigomateria
                INNER JOIN CarrerasEducacionContinuada ce on c.codigocarrera = ce.CodigoCarrera
                INNER JOIN AgrupacionCarreraEducacionContinuada a on ce.AgrupacionCarreraEducacionContinuadaId = a.AgrupacionCarreraEducacionContinuadaId
                WHERE
                    ce.AgrupacionCarreraEducacionContinuadaId = ' . $grupo . '
                    AND g.matriculadosgrupo < g.maximogrupo
                    AND g.codigoperiodo IN (SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo IN (1,4,3))
                    AND g.codigoestadogrupo=10
                    ORDER BY g.codigoperiodo DESC';

            $CursoLabel = $db->GetAll($SQLdatos);

            $count_label = count($CursoLabel);

            if ($CursoLabel[0]['NombreAgrupacion'] <> '') {
                $Data['Label'] = $CursoLabel[0]['NombreAgrupacion'];
                $Data['periodo'] = $CursoLabel[0]['codigoperiodo'];
                $Data['Codigo'] = 1;
                return $Data;
            } else {

                $Data['Label'] = 'Por Favor comunicarse con Educacion Continuada No se puede acceder al Curso o Programa Indicado';
                $Data['Codigo'] = 0;
                return $Data;
            }
        }//if 
    }
 
    /**
     * Caso 2812 
     * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
     * Se adiciona la validación del estado de la tabla CarrerasEducacionContinuada
     * Para que no se muestren agrupaciones duplicadas en el micrositio de la pagina de la Universidad.
     * @since  Julio 17, 2019.
    */   
    
    public function CursosAgrupcion($db, $grupo) {
        $sqlgrupos = "SELECT ce.CodigoCarrera, c.nombrecarrera 
        FROM CarrerasEducacionContinuada ce 
        INNER JOIN carrera c on ce.CodigoCarrera = c.codigocarrera
        WHERE ce.AgrupacionCarreraEducacionContinuadaId= '" . $grupo . "'
        AND ce.CodigoEstado = 100 ";
        $carreras = $db->GetAll($sqlgrupos);
        return $carreras;
    }

    public function GenerarOrdenPago($codigoestudiante, $codigoperiodo, $db) {
        require_once('../../../../../Connections/sala2.php');
        include_once('../../../../../funciones/funcionip.php');

        $ruta = "../../../../../funciones/";
        $rutaorden = "../../../../../funciones/ordenpago/";

        include_once($rutaorden . 'claseordenpago.php');
        mysql_select_db($database_sala, $db->_connectionID);

        $ordenesxestudiante = new Ordenesestudiante($db->_connectionID, $codigoestudiante, $codigoperiodo);
        if (!$ordenesxestudiante->validar_generacionordenesmatricula(1)) {
            $info['val'] = 1;
            $info['msj'] = "Por favor comunicarse con la mesa de servicio de la universidad a la Tel: 6489000 Ext: 1555.";
            echo json_encode($info);
            exit;
        } else {
            $SQL = 'SELECT
                    numeroordenpago
                FROM
                    ordenpago
                WHERE
                    codigoestudiante="' . $codigoestudiante . '"
                    AND
                    codigoperiodo="' . $codigoperiodo . '"
                    AND
                    codigoestadoordenpago IN(10,40)';
            if ($Existe = &$db->Execute($SQL) === false) {
                echo 'Error en el SQL Existe....';
                die;
            }

            if ($Existe->EOF) {
                $SQL = 'select v.codigoconcepto,v.preciovaloreducacioncontinuada
    			from valoreducacioncontinuada v, estudiante e, carrera ca, modalidadacademica m
    			where v.codigocarrera = e.codigocarrera
    			and v.fechainiciovaloreducacioncontinuada <= NOW()
    			and v.fechafinalvaloreducacioncontinuada >= NOW()
    			and e.codigoestudiante = "' . $codigoestudiante . '"
    			and ca.codigocarrera = e.codigocarrera
    			and ca.codigomodalidadacademica = m.codigomodalidadacademica
    			and ca.codigoreferenciacobromatriculacarrera like "2%"';

                if ($Valores = &$db->GetAll($SQL) === false) {
                    echo 'Error en el SQL valores....';
                    die;
                }

                $SQL = 'SELECT
                        m.codigomateria,
                        g.idgrupo
                    FROM
                        estudiante e
                    INNER JOIN materia m ON m.codigocarrera = e.codigocarrera
                    INNER JOIN grupo g ON g.codigomateria = m.codigomateria
                    INNER JOIN fechaeducacioncontinuada f ON f.idgrupo=g.idgrupo
                    INNER JOIN detallefechaeducacioncontinuada df ON df.idfechaeducacioncontinuada=f.idfechaeducacioncontinuada
                    WHERE
                        e.codigoestudiante = "' . $codigoestudiante . '"
                    AND e.codigoperiodo = "' . $codigoperiodo . '"
                    AND df.fechadetallefechaeducacioncontinuada >= CURDATE()
                    AND g.codigoestadogrupo = 10';

                if ($ValidaGrupoActivo = &$db->Execute($SQL) === false) {
                    $info['val'] = 1;
                    $info['msj'] = "Error al validar el grupo activo";
                    echo json_encode($info);
                    exit;
                }

                if ($ValidaGrupoActivo->EOF) {
                    $info['val'] = 1;
                    $info['msj'] = "El Grupo Asociado no Esta Activo";
                    echo json_encode($info);
                    exit;
                }

                $nuevaorden = $ordenesxestudiante->generarordenpago_matriculaEducacionContinuada($Valores[0]['codigoconcepto'], $Valores[0]['preciovaloreducacioncontinuada']);

                $info['val'] = 2;
                $info['msj'] = "Se ha inscrito correctamente...";
                $info['codigoestudiante'] = $codigoestudiante;
                $info['codigoperiodo'] = $codigoperiodo;
                echo json_encode($info);
                exit;
            } else {
                $info['val'] = 2;
                $info['msj'] = "Estimado Usuario usted ya se incuentra inscrito...";
                $info['codigoestudiante'] = $codigoestudiante;
                $info['codigoperiodo'] = $codigoperiodo;
                echo json_encode($info);
                exit;
            }
        }
    }// public function GenerarOrdenPago

    public function VerOrdenes($db, $codigoestudiante, $codigoperiodo) {
        require_once('../../../../../Connections/sala2.php');
        include_once('../../../../../funciones/funcionip.php');

        $ruta = "../../../../../funciones/";
        $rutaorden = "../../../../../funciones/ordenpago/";
        include_once($rutaorden . 'claseordenpago.php');
        mysql_select_db($database_sala, $db->_connectionID);

        $ordenesxestudiante = new Ordenesestudiante($db->_connectionID, $codigoestudiante, $codigoperiodo);
        $rutaorden = "../../../../../funciones/ordenpago/";
        $ordenesxestudiante->mostrar_ordenespago($rutaorden, '');
    }

//public function VerOrdenes

    public function ValidadComunidadBosque($db, $numerodocumento) {
        $SQL = 'SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo IN (1,3)';

        if ($Periodo = &$db->GetAll($SQL) === false) {
            echo 'Error en el SQL del periodo academico...';
            die;
        }

        if (count($Periodo) == 2) {
            $C_Periodos = $Periodo[0]['codigoperiodo'] . ',' . $Periodo[1]['codigoperiodo'];
        } else {
            $arrayP = str_split($Periodo[0]['codigoperiodo'], strlen($Periodo[0]['codigoperiodo']) - 1);
            if ($arrayP[1] == 2) {
                $PeriodNew = $arrayP[0];
                $PeriodNew = $PeriodNew . '1';
            } else {
                $PeriodNew = $arrayP[0] - 1;
                $PeriodNew = $PeriodNew . '2';
            }
            $C_Periodos = $PeriodNew . ',' . $Periodo[0]['codigoperiodo'];
        }

        $SQL = 'SELECT
                eg.idestudiantegeneral
            FROM
                estudiantegeneral eg
            INNER JOIN estudiante e ON e.idestudiantegeneral = eg.idestudiantegeneral
            INNER JOIN carrera c ON c.codigocarrera = e.codigocarrera
            WHERE
                eg.numerodocumento = "' . $numerodocumento . '"
            AND c.codigomodalidadacademica IN (300, 200, 400) limit 1';

        if ($EsTudiante = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL del validacion estudiante comunidad ';
            die;
        }

        if ($EsTudiante->EOF) {
            $SQL_2 = 'SELECT
                    iddocente
                    FROM
                    docente d INNER JOIN grupo g ON g.numerodocumento=d.numerodocumento
                    WHERE
                    d.numerodocumento="' . $numerodocumento . '"
                    AND
                    g.codigoperiodo IN (' . $C_Periodos . ')';

            if ($Docente = &$db->Execute($SQL_2) === false) {
                echo 'Error en el SQL de validacion del docente comunidad';
                die;
            }
            if (!$Docente->EOF) {
                return 1;
            } else {
                return 2; //fals0
            }
        } else {
            return 1;
        }
        return 2;  //fals9      
    }

//public function ValidadComunidadBosque

    public function ValidacionCarrera($db, $Curso) {
        $SQL = 'SELECT
                codigocarrera
            FROM
                carrera
            WHERE
                codigocarrera ="' . $Curso . '"
            AND codigomodalidadacademica = 400';
        if ($validacionCarrera = &$db->Execute($SQL) === false) {
            $info['val'] = 1;
            $info['msj'] = 'errro al validar.';
            echo json_encode($info);
            exit;
        }

        if (!$validacionCarrera->EOF) {
            return true;
        } else {
            return false;
        }
    }//public function ValidacionCarrera
}//class

