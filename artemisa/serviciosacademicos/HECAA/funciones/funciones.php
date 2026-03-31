<?php

class funcionesMatriculas {

    public function DatosParticipantes($db, $codigoperiodo) {

        $sqlDatosEstudiante = "SELECT DISTINCT e.codigoestudiante, e.codigocarrera 
        FROM
        estudiante e
        INNER JOIN ordenpago op on op.codigoestudiante = e.codigoestudiante
        INNER JOIN carrera c on e.codigocarrera = c.codigocarrera
        WHERE
        op.codigoperiodo='" . $codigoperiodo . "' AND op.codigoestadoordenpago IN (40, 41, 44, 51, 52)
        AND c.codigomodalidadacademica IN (200,300,600)
        AND c.codigocarrera <> 13 AND c.codigocarrera <> 92 UNION
        SELECT DISTINCT e.codigoestudiante, e.codigocarrera 
        FROM
        estudiante e
        INNER JOIN ordenpago op on op.codigoestudiante = e.codigoestudiante
        INNER JOIN carrera c on e.codigocarrera = c.codigocarrera
        INNER JOIN PeriodosVirtuales pv ON op.codigoperiodo = pv.CodigoPeriodo
        INNER JOIN PeriodoVirtualCarrera pvc ON pv.IdPeriodoVirtual = pvc.idPeriodoVirtual
        AND c.codigomodalidadacademica=pvc.codigoModalidadAcademica
        WHERE
        pvc.codigoPeriodo='" . $codigoperiodo . "' AND op.codigoestadoordenpago IN (40, 41, 44, 51, 52)
        AND c.codigomodalidadacademica IN (800,810)
        AND c.codigocarrera <> 13 AND c.codigocarrera <> 92 GROUP BY e.codigoestudiante";

        $datosEstudiantes = $db->GetAll($sqlDatosEstudiante);
        return $datosEstudiantes;
    }

    //funcion para obtener la lista de estudantes matricualdos nuevos de la carrera
    public function MatriculadosNuevos($db, $codigocarrera, $codigoperiodo) {
        $sqlMatricualdosNuevos = "SELECT e.codigoestudiante, pr.semestreprematricula as semestre FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr WHERE o.numeroordenpago=d.numeroordenpago
            AND pr.codigoperiodo='" . $codigoperiodo . "'
            AND e.codigoestudiante=pr.codigoestudiante
            AND e.codigoestudiante=o.codigoestudiante
            AND c.codigocarrera=e.codigocarrera
            AND d.codigoconcepto=co.codigoconcepto
            AND co.cuentaoperacionprincipal=151
            AND e.codigocarrera='" . $codigocarrera . "'
            AND o.codigoperiodo='" . $codigoperiodo . "'
            AND o.codigoestadoordenpago LIKE '4%'
            AND e.codigotipoestudiante = '10'
            AND e.codigoperiodo='" . $codigoperiodo . "'
            GROUP by e.codigoestudiante";
        $datos = $db->GetAll($sqlMatricualdosNuevos);
        $conteo = count($datos);
        if ($conteo == '0') {
            $datos = '0';
            return $datos;
        } else {
            return $datos;
        }
    }

    //funcion para obtener la lista de estudiantes matriculados antiguos de la carrera
    public function MatriculadosAntiguos($db, $codigocarrera, $codigoperiodo) {
        $sqlmatriculadosantiguos = "SELECT e.codigoestudiante, pr.semestreprematricula as semestre 
		 FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr WHERE o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=pr.codigoestudiante
		AND pr.codigoperiodo='" . $codigoperiodo . "'
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal=151
		AND o.codigoperiodo='" . $codigoperiodo . "'
		AND o.codigoestadoordenpago LIKE '4%'
		AND e.codigocarrera='$codigocarrera'
		AND e.codigoperiodo<>'" . $codigoperiodo . "'
        AND e.codigotipoestudiante = '20'
		GROUP by e.codigoestudiante";
        $datos = $db->GetAll($sqlmatriculadosantiguos);

        $conteo = count($datos);
        if ($conteo == '0') {
            $datos = '0';
            return $datos;
        } else {
            //obtiene el periodo anterior para la consulta
            //$periodoanterior = $this->periodoanterior($codigoperiodo);

            foreach ($datos as $valores) {
                //consulta de la cantidad de orgedes de pago pagadas del periodo anterior
                //consulta la cantidad de ordenes pagadas en periodos anteriores
                $queryVerifOrdenPagoPeriodoAnt = "SELECT COUNT(op.codigoestudiante) as cant FROM ordenpago op, detalleordenpago dop, concepto co
                WHERE
                op.numeroordenpago=dop.numeroordenpago
                AND dop.codigoconcepto=co.codigoconcepto
                AND co.cuentaoperacionprincipal=151
                AND op.codigoperiodo<'" . $codigoperiodo . "'
                AND op.codigoestudiante='" . $valores['codigoestudiante'] . "'
                AND op.codigoestadoordenpago LIKE '4%'
                GROUP BY op.codigoestudiante";
                $op = $db->GetRow($queryVerifOrdenPagoPeriodoAnt);
                if ($op['cant'] > '0') {
                    $arreglo_interno[] = $valores;
                }
            }
            $conteo = count($arreglo_interno);
            if ($conteo == '0') {
                $arreglo_interno = '0';
                return $arreglo_interno;
            } else {
                return $arreglo_interno;
            }
        }
    }

    //funcion para obtener la lista de estudiantes matriculados por reintegro para una carrera
    public function reintegro($db, $codigocarrera, $codigoperiodo) {
        $sqlreintegro = "SELECT e.codigoestudiante, pr.semestreprematricula as semestre
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
		WHERE o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=pr.codigoestudiante
		AND pr.codigoperiodo='" . $codigoperiodo . "'
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal=151
		AND o.codigoperiodo='" . $codigoperiodo . "'
		AND o.codigoestadoordenpago LIKE '4%'
		AND e.codigocarrera='" . $codigocarrera . "'
		AND e.codigoperiodo<>'" . $codigoperiodo . "'
        AND e.codigotipoestudiante = '21'
		GROUP by e.codigoestudiante";
        $datos = $db->GetAll($sqlreintegro);

        $conteo = count($datos);
        if ($conteo == '0') {
            $datos = '0';
            return $datos;
        } else {
            //obtiene el periodo anterior para la consulta
            $periodoanterior = $this->periodoanterior($codigoperiodo);

            foreach ($datos as $valores) {
                //consulta de la cantidad de orgedes de pago pagadas del periodo anterior
                $queryVerifOrdenPagoPeriodoAnt = "SELECT COUNT(op.codigoestudiante) as cant
                    FROM ordenpago op, detalleordenpago dop, concepto co
                    WHERE
                    op.numeroordenpago=dop.numeroordenpago
                    AND dop.codigoconcepto=co.codigoconcepto
                    AND co.cuentaoperacionprincipal=151
                    AND op.codigoperiodo<='" . $periodoanterior . "'
                    AND op.codigoestudiante='" . $valores['codigoestudiante'] . "'
                    AND op.codigoestadoordenpago LIKE '4%'
                    GROUP BY op.codigoestudiante";
                $op = $db->GetRow($queryVerifOrdenPagoPeriodoAnt);
                if ($op['cant'] > '0') {
                    $arreglo_interno[] = $valores;
                }
            }
            $conteo = count($arreglo_interno);
            if ($conteo == '0') {
                $arreglo_interno = '0';
                return $arreglo_interno;
            } else {
                return $arreglo_interno;
            }
        }
    }

    //funcion para obtener la informacion de un estudiante
    public function infoestudiante($db, $codigoestudiante) {
        $sqldatosestudiante = "SELECT
        eg.tipodocumento,
        eg.numerodocumento,
        e.codigoestudiante,        
		eg.ciudadresidenciaestudiantegeneral as idciudad,
		DATE_FORMAT(eg.fechanacimientoestudiantegeneral,'%d-%m-%Y') AS 'FECHA_NACIM',
        pa.IdHecaa as idpais,
	    ci.codigosapciudad as idciudad,
        IF (eg.codigogenero = '100', '2', '1' ) AS 'Genero',
        eg.direccioncortaresidenciaestudiantegeneral as dirrecion
		FROM estudiante e
        INNER JOIN estudiantegeneral eg on e.idestudiantegeneral = eg.idestudiantegeneral 
        INNER JOIN periodo p on  e.codigoperiodo = p.codigoperiodo
        INNER JOIN ciudad ci on ci.idciudad = eg.idciudadnacimiento        
        INNER JOIN pais pa ON pa.idpais = eg.idpaisnacimiento
        WHERE
        e.codigoestudiante = '" . $codigoestudiante . "'";
        $datos = $db->GetRow($sqldatosestudiante);
        return $datos;
    }

    //funcion para obtener la informacion de materias de un estudiante
    public function infomateriasestudiante($db, $codigoestudiante, $codigoperiodo) {
        $sqldatosestudiante = "SELECT
        eg.tipodocumento,
        eg.numerodocumento,
        e.codigoestudiante,
	    ci.codigosapciudad as idciudad,
        IF (eg.codigogenero = '100', '2', '1' ) AS 'Genero',
		COUNT(dp.codigomateria) as matriculadas,
		COUNT(n.codigomateria) AS Aprobadas 
		FROM estudiante e
			INNER JOIN estudiantegeneral eg on e.idestudiantegeneral = eg.idestudiantegeneral 
			INNER JOIN genero g ON eg.codigogenero=g.codigogenero 
			INNER JOIN ciudad ci on ci.idciudad = eg.idciudadnacimiento    
			LEFT JOIN prematricula p ON e.codigoestudiante=p.codigoestudiante
			LEFT JOIN detalleprematricula dp on dp.idprematricula=p.idprematricula and dp.codigoestadodetalleprematricula=30
			LEFT JOIN notahistorico n ON n.codigoestudiante=e.codigoestudiante 
				AND n.codigoperiodo=p.codigoperiodo AND n.notadefinitiva >= 3 AND n.codigoestadonotahistorico=100
        WHERE
        e.codigoestudiante = '" . $codigoestudiante . "' 
			AND p.codigoperiodo='" . $codigoperiodo . "' 
			AND
				p.codigoestadoprematricula IN (40,41)
		GROUP BY
			n.codigomateria
		LIMIT 1";
        //	echo $sqldatosestudiante; die;
        $datos = $db->GetRow($sqldatosestudiante);
        return $datos;
    }

    public function Infoparticipante($db, $codigoestudiante) {
        $sqlEstudiante = "SELECT
                            eg.tipodocumento AS TipoDocumento,
                            eg.numerodocumento,
                            DATE_FORMAT(eg.FechaDocumento,'%d-%m-%Y') AS 'FechaDocumento',
                            SUBSTRING_INDEX(TRIM(eg.nombresestudiantegeneral),' ',1) AS 'PRIMER_NOMBRE',
                            SUBSTRING_INDEX(TRIM(eg.nombresestudiantegeneral),' ' ,- 1) AS 'SEGUNDO_NOMBRE',
                            SUBSTRING_INDEX(TRIM(eg.apellidosestudiantegeneral),' ',1) AS 'PRIMER_APELLIDO',
                            SUBSTRING_INDEX(TRIM(eg.apellidosestudiantegeneral), ' ' ,- 1 ) AS 'SEGUNDO_APELLIDO',
                        IF (eg.codigogenero = '100', '2', '1' ) AS 'Genero',
                         eg.idestadocivil AS 'EstadoCivil',
                         DATE_FORMAT( eg.fechanacimientoestudiantegeneral, '%d-%m-%Y' ) AS 'FECHA_NACIM',
                        if(pa.IdHecaa is null, pai.IdHecaa,pa.IdHecaa)AS 'Pais', 
                         ciu.codigosapciudad AS 'ciudad',
                         eg.telefonoresidenciaestudiantegeneral AS 'Telefono',
                         eg.emailestudiantegeneral AS 'EmailPersonal',
                         u.usuario AS 'usuario',
                        e.semestre
                        FROM
                            estudiante e
                            INNER JOIN estudiantegeneral eg on e.idestudiantegeneral = eg.idestudiantegeneral
                            INNER JOIN periodo p on e.codigoperiodo = p.codigoperiodo
                            LEFT JOIN usuario u on u.numerodocumento = eg.numerodocumento
                            left JOIN pais pa on pa.idpais = eg.idpaisnacimiento
                            INNER JOIN ciudad ciu on ciu.idciudad = eg.idciudadnacimiento
                            INNER JOIN departamento d on d.iddepartamento = ciu.iddepartamento
                            INNER JOIN pais pai on pai.idpais = d.idpais
                        WHERE
                           e.codigoestudiante='" . $codigoestudiante . "'";
        $listaestudiantes = $db->GetRow($sqlEstudiante);
        return $listaestudiantes;
    }

    public function carreraregistro($db, $codigocarrera) {
        $sqlcodigo = "SELECT codigosniescarreraregistro FROM carreraregistro cr WHERE cr.codigocarrera='" . $codigocarrera . "'";
        $codigo = $db->GetRow($sqlcodigo);
        return $codigo['codigosniescarreraregistro'];
    }

    public function infoprimercurso($db, $codigoestudiante) {
        $sqldatosestudiante = "SELECT
        eg.tipodocumento,
        eg.numerodocumento,
        e.codigoestudiante,  
        e.VinculacionId,
        eg.GrupoEtnicoId,        
        pro.numeroregistroresultadopruebaestado as 'icfes',
        eg.ciudadresidenciaestudiantegeneral as 'idciudad',
        DATE_FORMAT(eg.fechanacimientoestudiantegeneral,'%d-%m-%Y') AS 'FECHA_NACIM',
        pa.IdHecaa as 'idpais',
        ci.codigosapciudad as idciudad,
        IF (eg.codigogenero = '100', '2', '1' ) AS 'Genero',
        eg.direccioncortaresidenciaestudiantegeneral as 'dirrecion' ,
        ee.idestudianteestudio
	FROM estudiante e
        INNER JOIN estudiantegeneral eg on e.idestudiantegeneral = eg.idestudiantegeneral 
        INNER JOIN periodo p on  e.codigoperiodo = p.codigoperiodo
        INNER JOIN ciudad ci on ci.idciudad = eg.idciudadnacimiento
        INNER JOIN departamento de on de.iddepartamento = ci.iddepartamento
        INNER JOIN pais pa on pa.idpais = de.idpais
        LEFT JOIN estudianteestudio ee on ee.idestudiantegeneral = eg.idestudiantegeneral        
        LEFT JOIN resultadopruebaestado pro ON pro.idestudiantegeneral = eg.idestudiantegeneral
        INNER JOIN carrera c on c.codigocarrera = e.codigocarrera
        WHERE
        e.codigoestudiante = '" . $codigoestudiante . "'";
        $datos = $db->GetRow($sqldatosestudiante);
        return $datos;
    }

    public function Inscritos($db, $codigoperiodo) {
        $sqlisncrito = "SELECT e.codigoestudiante, e.codigocarrera,e.idestudiantegeneral 
                FROM estudianteestadistica ee, carrera c, estudiante e
                WHERE e.codigocarrera=c.codigocarrera
                AND ee.codigoestudiante=e.codigoestudiante
                AND ee.codigoperiodo = '" . $codigoperiodo . "'
                AND ee.codigoprocesovidaestudiante= 200
                AND c.codigomodalidadacademica IN(200,300,600)
                AND c.codigocarrera NOT IN(13,468,560,554,92,6,204,417,94,120,355,434,117)
                AND ee.codigoestado LIKE '1%' 
		GROUP BY e.codigoestudiante
                UNION
                SELECT e.codigoestudiante, e.codigocarrera,e.idestudiantegeneral 
                FROM estudianteestadistica ee
                    INNER JOIN PeriodosVirtuales pv ON ee.codigoperiodo = pv.CodigoPeriodo
                    INNER JOIN PeriodoVirtualCarrera pvc ON pv.IdPeriodoVirtual = pvc.idPeriodoVirtual
                    INNER JOIN estudiante e ON ee.codigoestudiante = e.codigoestudiante
                    INNER JOIN carrera c ON e.codigocarrera = c.codigocarrera 
                    AND pvc.codigoModalidadAcademica=c.codigomodalidadacademica
                WHERE ee.codigoprocesovidaestudiante= 200
                AND c.codigomodalidadacademica IN(800,810)
                AND c.codigocarrera NOT IN(13,468,560,554,92,6,204,417,94,120,355,434,117)
		AND pvc.codigoPeriodo = '" . $codigoperiodo . "'
                AND ee.codigoestado LIKE '1%' 
                GROUP BY e.codigoestudiante 
                ORDER BY 1";
        $inscritos = $db->GetAll($sqlisncrito);

        return $inscritos;
    }

    public function ProgramasInscripcion($db, $codigoestudiante, $codigoperiodo) {
        $sqldatos = "SELECT DISTINCT  ei.codigocarrera FROM estudiante e 
                        INNER JOIN estudiantegeneral eg on eg.idestudiantegeneral = e.idestudiantegeneral
                        INNER JOIN inscripcion i on i.idestudiantegeneral = eg.idestudiantegeneral and i.codigoperiodo = '" . $codigoperiodo . "'
                        INNER JOIN estudiantecarrerainscripcion ei on ei.idinscripcion = i.idinscripcion
                        where 
                        e.codigoestudiante = '" . $codigoestudiante . "'
                        and e.codigoperiodo = i.codigoperiodo";
        $datos = $db->GetAll($sqldatos);
        return $datos;
    }

    public function Graduados($db, $codigoperiodo) {
        /**
         * Se incluyen los LEFT JOIN que llaman la tabla foliotemporal
         * Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Universidad el Bosque - Direccion de Tecnologia.
         * Modificado 31 de Julio de 2019.
         */
        $sqlgraduados = "SELECT
                e.codigoestudiante,
                eg.tipodocumento,
                eg.numerodocumento,
                cr.codigosniescarreraregistro as 'pro',
                '11001' as 'ciudad',
                IF(pro.numeroregistroresultadopruebaestado IS NULL, 'AC2000', 
                REPLACE(pro.numeroregistroresultadopruebaestado, ' ', '')) as 'icfes',
                eg.emailestudiantegeneral as 'email',
                eg.telefonocorrespondenciaestudiantegeneral as 'telefono',
                rg.numeroactaregistrograduado as 'acta',
                rg.fechaacuerdoregistrograduado as 'fecha_acta',
                IF(drgf.idregistrograduadofolio IS NULL, fo.folio, drgf.idregistrograduadofolio) as 'folio',
                m.codigomodalidadacademica,
                c.nombrecarrera
                FROM
                    periodo p,
                    registrograduado rg
                INNER JOIN estudiante e ON rg.codigoestudiante = e.codigoestudiante
                INNER JOIN carrera c ON e.codigocarrera = c.codigocarrera
                INNER JOIN modalidadacademica m ON c.codigomodalidadacademica = m.codigomodalidadacademica
                INNER JOIN carreraregistro cr ON c.codigocarrera = cr.codigocarrera
                INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral = eg.idestudiantegeneral                     
                LEFT JOIN foliotemporal fo on fo.idregistrograduado = rg.idregistrograduado
                LEFT JOIN detalleregistrograduadofolio drgf ON rg.idregistrograduado = drgf.idregistrograduado
                LEFT JOIN RegistroGrado r ON (r.EstudianteId = e.codigoestudiante) 
                INNER JOIN ciudad ci on (ci.idciudad = eg.idciudadnacimiento)
                LEFT JOIN resultadopruebaestado pro ON pro.idestudiantegeneral = eg.idestudiantegeneral
                WHERE
                    c.codigocarrera NOT IN (1,12,79,96,117,262,264,355,434,468,2,3,6,7,13,30,39,74,92,94,97,120,138,204,417,554,560)
                AND p.codigoperiodo = '" . $codigoperiodo . "'
                AND m.codigomodalidadacademica IN (200,300,600)
                AND (rg.fechaactaregistrograduado BETWEEN p.fechainicioperiodo and p.fechavencimientoperiodo)
                UNION
                SELECT
                e.codigoestudiante,
                eg.tipodocumento,
                eg.numerodocumento,
                cr.codigosniescarreraregistro as 'pro',
                '11001' as 'ciudad',
                IF(pro.numeroregistroresultadopruebaestado IS NULL, 'AC2000', 
                REPLACE(pro.numeroregistroresultadopruebaestado, ' ', '')) as 'icfes',
                eg.emailestudiantegeneral as 'email',
                eg.telefonocorrespondenciaestudiantegeneral as 'telefono',
                rg.numeroactaregistrograduado as 'acta',
                rg.fechaacuerdoregistrograduado as 'fecha_acta',
                IF(drgf.idregistrograduadofolio IS NULL, fo.folio, drgf.idregistrograduadofolio) as 'folio',
                m.codigomodalidadacademica,
                c.nombrecarrera
                FROM
                    periodo p,
                    PeriodosVirtuales pv,       
                    PeriodoVirtualCarrera pvc,             
                    registrograduado rg
                INNER JOIN estudiante e ON rg.codigoestudiante = e.codigoestudiante
                INNER JOIN carrera c ON e.codigocarrera = c.codigocarrera
                INNER JOIN modalidadacademica m ON c.codigomodalidadacademica = m.codigomodalidadacademica
                INNER JOIN carreraregistro cr ON c.codigocarrera = cr.codigocarrera
                INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral = eg.idestudiantegeneral                     
                LEFT JOIN foliotemporal fo on fo.idregistrograduado = rg.idregistrograduado
                LEFT JOIN detalleregistrograduadofolio drgf ON rg.idregistrograduado = drgf.idregistrograduado
                LEFT JOIN RegistroGrado r ON (r.EstudianteId = e.codigoestudiante) 
                INNER JOIN ciudad ci on (ci.idciudad = eg.idciudadnacimiento)
                LEFT JOIN resultadopruebaestado pro ON pro.idestudiantegeneral = eg.idestudiantegeneral
                WHERE
                    c.codigocarrera NOT IN (1,12,79,96,117,262,264,355,434,468,2,3,6,7,13,30,39,74,92,94,97,120,138,204,417,554,560)
                AND pv.CodigoPeriodo=p.codigoperiodo
                AND pv.IdPeriodoVirtual = pvc.idPeriodoVirtual
                AND pvc.codigoModalidadAcademica=c.codigomodalidadacademica
                AND pvc.codigoPeriodo = '" . $codigoperiodo . "'
                AND m.codigomodalidadacademica IN (800,810)
                AND (rg.fechaactaregistrograduado BETWEEN p.fechainicioperiodo and p.fechavencimientoperiodo)
 ";
        $datos = $db->GetAll($sqlgraduados);

        $sqlgrado = "SELECT
                        E.codigoestudiante,
                        EG.tipodocumento,
                        EG.numerodocumento,
                        CC.codigosniescarreraregistro as 'pro',
                       '11001' as 'ciudad',
                        IF(PRO.numeroregistroresultadopruebaestado IS NULL, 'AC2000', 
			            REPLACE(PRO.numeroregistroresultadopruebaestado, ' ', '')) as 'icfes',
                        EG.emailestudiantegeneral as 'email',
                        IF(EG.telefonoresidenciaestudiantegeneral < 999999, EG.celularestudiantegeneral, 
			            EG.telefonoresidenciaestudiantegeneral) as 'telefono', 
                        R.NumeroDiploma as 'acta',
                        DATE_FORMAT(A.FechaAcuerdo,'%d/%m/%Y') as 'fecha_acta',
                        IF(drgf.idregistrograduadofolio IS NULL, fo.folio, drgf.idregistrograduadofolio) as 'folio',
                        C.codigomodalidadacademica,
                        C.nombrecarrera
                    FROM
                        RegistroGrado R
                    INNER JOIN estudiante E ON  E.codigoestudiante = R.EstudianteId 
                    INNER JOIN estudiantegeneral EG ON EG.idestudiantegeneral = E.idestudiantegeneral 
                    INNER JOIN AcuerdoActa A ON A.AcuerdoActaId = R.AcuerdoActaId 
                    INNER JOIN FechaGrado F ON F.FechaGradoId = A.FechaGradoId 
                    INNER JOIN carrera C ON C.codigocarrera = F.CarreraId 
                    INNER JOIN carreraregistro CC on CC.codigocarrera = C.codigocarrera
                    INNER JOIN ciudad CIU on CIU.idciudad = EG.idciudadnacimiento
                    INNER JOIN periodo P on P.codigoperiodo='" . $codigoperiodo . "'                     
                    LEFT JOIN foliotemporal fo on fo.idregistrograduado = R.RegistroGradoId
					LEFT JOIN detalleregistrograduadofolio drgf on drgf.idregistrograduado=R.RegistroGradoId
                    LEFT JOIN resultadopruebaestado PRO ON PRO.idestudiantegeneral = EG.idestudiantegeneral
                    WHERE
                        C.codigocarrera NOT IN (1,12,79,96,117,262,264,355,434,468,2,3,6,7,13,30,39,74,92,94,97,120,138,204,417,554,560)
                    AND C.codigomodalidadacademica IN (200,300,600)
                    AND ( A.FechaAcuerdo BETWEEN P.fechainicioperiodo AND P.fechavencimientoperiodo ) 
                    GROUP BY E.codigoestudiante 
                    UNION
                    SELECT
                        E.codigoestudiante,
                        EG.tipodocumento,
                        EG.numerodocumento,
                        CC.codigosniescarreraregistro as 'pro',
                       '11001' as 'ciudad',
                        IF(PRO.numeroregistroresultadopruebaestado IS NULL, 'AC2000', 
                        REPLACE(PRO.numeroregistroresultadopruebaestado, ' ', '')) as 'icfes',
                        EG.emailestudiantegeneral as 'email',
                        IF(EG.telefonoresidenciaestudiantegeneral < 999999, EG.celularestudiantegeneral, 
                        EG.telefonoresidenciaestudiantegeneral) as 'telefono', 
                        R.NumeroDiploma as 'acta',
                        DATE_FORMAT(A.FechaAcuerdo,'%d/%m/%Y') as 'fecha_acta',
                        IF(drgf.idregistrograduadofolio IS NULL, fo.folio, drgf.idregistrograduadofolio) as 'folio',
                        C.codigomodalidadacademica,
                        C.nombrecarrera
                    FROM
                        RegistroGrado R
                    INNER JOIN estudiante E ON  E.codigoestudiante = R.EstudianteId 
                    INNER JOIN estudiantegeneral EG ON EG.idestudiantegeneral = E.idestudiantegeneral 
                    INNER JOIN AcuerdoActa A ON A.AcuerdoActaId = R.AcuerdoActaId 
                    INNER JOIN FechaGrado F ON F.FechaGradoId = A.FechaGradoId 
                    INNER JOIN carrera C ON C.codigocarrera = F.CarreraId 
                    INNER JOIN carreraregistro CC on CC.codigocarrera = C.codigocarrera
                    INNER JOIN ciudad CIU on CIU.idciudad = EG.idciudadnacimiento
                    INNER JOIN PeriodoVirtualCarrera pvc ON pvc.codigoPeriodo='" . $codigoperiodo . "'
                    AND pvc.codigoModalidadAcademica=C.codigomodalidadacademica
                    INNER JOIN  PeriodosVirtuales pv ON pv.IdPeriodoVirtual = pvc.idPeriodoVirtual
                    INNER JOIN periodo P on P.codigoperiodo=pvc.codigoPeriodo                     
                    LEFT JOIN foliotemporal fo on fo.idregistrograduado = R.RegistroGradoId
                    LEFT JOIN detalleregistrograduadofolio drgf on drgf.idregistrograduado=R.RegistroGradoId
                    LEFT JOIN resultadopruebaestado PRO ON PRO.idestudiantegeneral = EG.idestudiantegeneral
                    WHERE
                        C.codigocarrera NOT IN (1,12,79,96,117,262,264,355,434,468,2,3,6,7,13,30,39,74,92,94,97,120,138,204,417,554,560)
                    AND C.codigomodalidadacademica IN (800,810)
                    AND ( A.FechaAcuerdo BETWEEN P.fechainicioperiodo AND P.fechavencimientoperiodo ) 
                    GROUP BY E.codigoestudiante ";
        $datos2 = $db->GetAll($sqlgrado);

        $resultado = array_merge($datos2, $datos);

        return $resultado;
    }

    public function logReporte($db, $variable, $Usuario, $registros, $codigoperiodo) {
        $sqlinsert = "INSERT INTO LogReportesHecaa (Variable, Usuario, RegistrosReportados, CodigoPeriodo, FechaReporte) VALUES ('" . $variable . "', '" . $Usuario . "', '" . $registros . "', '" . $codigoperiodo . "', NOW())";
        $insert = $db->Execute($sqlinsert);
    }

    //funcion para calcular el periodo anterior
    function periodoanterior($codigoperiodo) {
        $anio = substr($codigoperiodo, 0, -1);
        $periodo = substr($codigoperiodo, 4, 1);
        if ($periodo == '1') {
            $anio = $anio - 1;
            $codigoperiodoanterior = $anio . "2";
        } else {
            $codigoperiodoanterior = $anio . "1";
        }
        return $codigoperiodoanterior;
    }

    function primercurso($db, $codigoperiodo, $fecha) {
        $sqlprimercurso = "SELECT DISTINCT e.codigoestudiante, pr.semestreprematricula AS semestre, cc.numeroregistrocarreraregistro, c.nombrecarrera FROM
                ordenpago o,
                detalleordenpago d,
                estudiante e,
                carrera c,
                concepto co,
                prematricula pr,
                carreraregistro cc
            WHERE
                o.numeroordenpago = d.numeroordenpago
            AND pr.codigoperiodo = '" . $codigoperiodo . "'
            AND e.codigoestudiante = pr.codigoestudiante
            AND e.codigoestudiante = o.codigoestudiante
            AND c.codigocarrera = e.codigocarrera
            AND d.codigoconcepto = co.codigoconcepto
            AND co.cuentaoperacionprincipal = 151
            AND o.codigoperiodo = pr.codigoperiodo
            AND o.codigoestadoordenpago LIKE '4%'
            AND e.codigoperiodo = pr.codigoperiodo
            AND cc.codigocarrera = c.codigocarrera
            AND e.codigocarrera in  (SELECT
                c.codigocarrera
            FROM
                carrera c
            LEFT JOIN carreraregistro cr ON cr.codigocarrera = c.codigocarrera
            WHERE
                c.fechainiciocarrera <= '" . $fecha . "'
            AND c.fechavencimientocarrera >= '" . $fecha . "'
            AND c.codigocarrera <> '13'
            AND c.codigocarrera <> '1'
            AND c.codigomodalidadacademica IN (200,300,600)
            AND c.nombrecarrera NOT LIKE '%CURSO%'
            ORDER BY
                c.codigocarrera)
            GROUP BY
                e.codigoestudiante                
            UNION
            SELECT DISTINCT e.codigoestudiante, pr.semestreprematricula AS semestre, cc.numeroregistrocarreraregistro, c.nombrecarrera FROM
                ordenpago o,
                detalleordenpago d,
                estudiante e,
                carrera c,
                concepto co,
                prematricula pr,
                carreraregistro cc,
		PeriodosVirtuales pv,
                PeriodoVirtualCarrera pvc
            WHERE
                o.numeroordenpago = d.numeroordenpago
            AND pr.codigoperiodo=pv.CodigoPeriodo
						AND pv.IdPeriodoVirtual = pvc.idPeriodoVirtual
            AND pvc.codigoPeriodo = '" . $codigoperiodo . "'
            AND e.codigoestudiante = pr.codigoestudiante
            AND e.codigoestudiante = o.codigoestudiante
            AND c.codigocarrera = e.codigocarrera
            AND d.codigoconcepto = co.codigoconcepto
            AND co.cuentaoperacionprincipal = 151
            AND o.codigoperiodo = pr.codigoperiodo
            AND o.codigoestadoordenpago LIKE '4%'
            AND e.codigoperiodo = pr.codigoperiodo
            AND cc.codigocarrera = c.codigocarrera
            AND e.codigocarrera in  (SELECT
                c.codigocarrera
            FROM
                carrera c
            LEFT JOIN carreraregistro cr ON cr.codigocarrera = c.codigocarrera
            WHERE
                c.fechainiciocarrera <= '" . $fecha . "'
            AND c.fechavencimientocarrera >= '" . $fecha . "'
            AND c.codigocarrera <> '13'
            AND c.codigocarrera <> '1'
            AND c.codigomodalidadacademica IN (800,810)
            AND c.nombrecarrera NOT LIKE '%CURSO%'
            ORDER BY
                c.codigocarrera)
            GROUP BY
                e.codigoestudiante";
//        end
        $resultado = $db->GetAll($sqlprimercurso);
        return $resultado;
    }

    public function ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago_admitidos($db, $codigoperiodo, $codigocarrera, $cuentaoperacionprincipal, $retorno, $codigomodalidadacademicasic = null) {
        if (trim($codigocarrera) != '') {
            $carrera = " AND e.codigocarrera='" . $codigocarrera . "'";
        }
        $modalidad = "";
        if (trim($codigomodalidadacademicasic) != '' && $codigomodalidadacademicasic != null) {
            $modalidad = " AND c.codigomodalidadacademicasic='" . $codigomodalidadacademicasic . "'";
        }
        $query = "SELECT e.codigoestudiante,e.codigocarrera FROM ordenpago o" .
                " inner join detalleordenpago d on (o.numeroordenpago = d.numeroordenpago) " .
                " inner join estudiante e on (o.codigoestudiante = e.codigoestudiante and " .
                " e.codigosituacioncarreraestudiante not in (108,302))" .
                " inner join carrera c on (e.codigocarrera = c.codigocarrera) " .
                " inner join concepto co on (d.codigoconcepto = co.codigoconcepto) " .
                " inner join inscripcion i on (e.idestudiantegeneral = i.idestudiantegeneral) " .
                " WHERE co.codigoconcepto='151' " .
                " and i.idinscripcion in " .
                " ( select e_2.idinscripcion from estudiantecarrerainscripcion e_2 " .
                " where e_2.idnumeroopcion = 1 and e_2.idestudiantegeneral = e.idestudiantegeneral " .
                " and e_2.codigocarrera = e.codigocarrera and e_2.codigoestado = '100' )" .
                " AND o.codigoestadoordenpago NOT LIKE '4%' " .
                " AND o.codigoperiodo =e.codigoperiodo AND o.codigoperiodo= $codigoperiodo " .
                " AND e.codigosituacioncarreraestudiante in(300,301,302)  " . $carrera . " " . $modalidad
                . " UNION " .
                " SELECT e.codigoestudiante,e.codigocarrera
        FROM ordenpago o " .
                " inner join detalleordenpago d on (o.numeroordenpago = d.numeroordenpago) " .
                " inner join estudiante e on (o.codigoestudiante = e.codigoestudiante and " .
                " e.codigosituacioncarreraestudiante not in (108,302))" .
                " inner join carrera c on (e.codigocarrera = c.codigocarrera) " .
                " inner join concepto co on (d.codigoconcepto = co.codigoconcepto) " .
                " inner join inscripcion i on (e.idestudiantegeneral = i.idestudiantegeneral) " .
                " WHERE co.cuentaoperacionprincipal='" . $cuentaoperacionprincipal . "' " .
                " and i.idinscripcion in ( " .
                " select e_2.idinscripcion from estudiantecarrerainscripcion e_2 " .
                " where e_2.idnumeroopcion = 1 and e_2.idestudiantegeneral = e.idestudiantegeneral " .
                " and e_2.codigocarrera = e.codigocarrera and e_2.codigoestado = '100' ) " .
                " AND o.codigoestadoordenpago LIKE '4%' " .
                " AND o.codigoperiodo=" . $codigoperiodo . " " .
                " AND e.codigosituacioncarreraestudiante in(300,301,302) " .
                " " . $carrera . " " . $modalidad . " " .
                " UNION
        SELECT e.codigoestudiante,e.codigocarrera
        FROM estudiante e, inscripcion i, estudiantecarrerainscripcion eci, carrera c " .
                " WHERE e.idestudiantegeneral = i.idestudiantegeneral " .
                " AND i.codigosituacioncarreraestudiante IN ('107','111','300') " .
                " AND i.idinscripcion=eci.idinscripcion AND eci.codigocarrera= e.codigocarrera " .
                " AND i.codigoperiodo = " . $codigoperiodo . " AND e.codigoperiodo = i.codigoperiodo " .
                " AND e.codigosituacioncarreraestudiante not in (108,302) " .
                " AND e.codigosituacioncarreraestudiante like '300' " .
                " AND eci.idnumeroopcion = '1' AND c.codigocarrera=e.codigocarrera " . $carrera . " " . $modalidad;
        $row_operacion = $db->GetAll($query);
        $conteo = count($row_operacion);
        if ($retorno == 'arreglo') {
            return $row_operacion;
        } elseif ($retorno == 'conteo') {
            return $conteo;
        }
    }

    /* MatriculadosNuevos */

    public function obtener_datos_estudiantes_matriculados_nuevos($db, $codigocarrera, $retorno, $codigoperiodo, $codigomodalidadacademicasic = null, $codigomodalidadacademica = null, $spadies = null) {
        $carrera = "";
        $extranjeros = "";
        if (trim($codigocarrera) != '') {
            $carrera = " AND e.codigocarrera='" . $codigocarrera . "'";
        }
        $modalidad = "";
        if (trim($codigomodalidadacademicasic) != '' && $codigomodalidadacademicasic != null) {
            $modalidad = " AND c.codigomodalidadacademicasic='" . $codigomodalidadacademicasic . "'";
        }
        if (trim($codigomodalidadacademica) != '' && $codigomodalidadacademica != null) {
            $modalidad = " AND c.codigomodalidadacademica='" . $codigomodalidadacademica . "'";
        }

        $select = "SELECT ee.codigoestudiante, e.codigocarrera ";
        if ($retorno == 'conteo') {
            $select = "SELECT COUNT(distinct ee.codigoestudiante) as total ";
        } else {
            $group = "group by o.codigoestudiante";
        }
        if ($spadies == '1') {
            $extranjeros = "AND e.codigoestudiante NOT IN ( SELECT codigoestudiante FROM estudiantesituacionmovilidad WHERE idsituacionmovilidad IN ('4', '5', '10', '11', '12', '13', '14', '15', '16') AND periodoinicial <= '" . $codigoperiodo . "' and periodofinal >= '" . $codigoperiodo . "')";
        }

        $query = $select . " FROM estudianteestadistica ee " .
                " INNER JOIN estudiante e ON (e.codigoestudiante=ee.codigoestudiante " .
                $carrera . " AND e.codigosituacioncarreraestudiante not in (108, 302)) " .
                " INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera " . $modalidad . " " .
                " INNER JOIN ordenpago o on (e.codigoestudiante = o.codigoestudiante and o.codigoestadoordenpago in (40, 41)) " .
                " INNER JOIN detalleordenpago od on (od.numeroordenpago = o.numeroordenpago and od.codigoconcepto = 151) " .
                " WHERE ee.codigoperiodo = '" . $codigoperiodo . "' and ee.codigoprocesovidaestudiante= 400 " .
                " and o.codigoperiodo = ee.codigoperiodo and ee.codigoestado like '1%' " .
                $extranjeros . " " . $group . "  order by 1";

        $row_operacion = $db->GetAll($query);
        $conteo = count($row_operacion);
        if ($retorno == 'arreglo') {
            return $row_operacion;
        } elseif ($retorno == 'conteo') {
            return $conteo;
        }
    }


    /* Admitidos_No_Matriculados */

    public function seguimiento_inscripcionvsmatriculadosnuevos($db, $codigocarrera, $retorno, $codigoperiodo) {
        $array_inscripcion = $this->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago_admitidos($db, $codigoperiodo, $codigocarrera, 153, $retorno);
        $array_matriculados_nuevos = $this->obtener_datos_estudiantes_matriculados_nuevos($db, $codigocarrera, $retorno, $codigoperiodo);
        $todo1= array_merge($array_inscripcion, $array_matriculados_nuevos);        
        $array_diferencia = array_map("unserialize", array_unique(array_map("serialize", $todo1)));
        $conteo = count($array_diferencia);
        if ($retorno == 'conteo') {
            return $conteo;
        } elseif ($retorno == 'arreglo') {
            return $array_diferencia;
        }
    }

    /* Admitidos_Que_No_Ingresaron */

    public function ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron($db, $codigoperiodo, $codigocarrera, $cuentaoperacionprincipal, $retorno, $codigomodalidadacademicasic = null) {
        if (trim($codigocarrera) != '') {
            $carrera = " AND e.codigocarrera='" . $codigocarrera . "'";
        }
        $modalidad = "";
        if (trim($codigomodalidadacademicasic) != '' && $codigomodalidadacademicasic != null) {
            $modalidad = " AND c.codigomodalidadacademicasic='" . $codigomodalidadacademicasic . "'";
        }
        $query = "SELECT e.codigoestudiante,e.codigocarrera
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
        WHERE o.numeroordenpago=d.numeroordenpago
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal='$cuentaoperacionprincipal'
        AND o.codigoestadoordenpago in (40, 41, 42, 44)
        AND o.codigoperiodo='$codigoperiodo' 
        AND e.codigoperiodo=o.codigoperiodo 
        AND c.codigocarrera=e.codigocarrera 
        and e.codigosituacioncarreraestudiante in(105,108,302)
                $carrera $modalidad 
        UNION
        SELECT e.codigoestudiante,
        e.codigocarrera
        FROM
        estudiante e
        INNER JOIN inscripcion i ON (	e.idestudiantegeneral = i.idestudiantegeneral	)
        INNER JOIN estudiantecarrerainscripcion eci ON (	i.idinscripcion = eci.idinscripcion	AND eci.codigocarrera = e.codigocarrera	)
        INNER JOIN carrera c ON (	c.codigocarrera = e.codigocarrera	)
        WHERE
        i.codigosituacioncarreraestudiante in (111, 105,108,302)
        AND e.codigosituacioncarreraestudiante in (105,108,302) 
        AND eci.codigocarrera= e.codigocarrera  
        AND i.codigoperiodo = '$codigoperiodo'
        AND e.codigoperiodo = i.codigoperiodo
        and eci.idnumeroopcion = '1'
                $carrera $modalidad ";

        $row_operacion = $db->GetAll($query);
        $conteo = count($row_operacion);
        if ($retorno == 'arreglo') {
            return $row_operacion;
        } elseif ($retorno == 'conteo') {
            return $conteo;
        }
    }

    public function listadocarreras($db) {

        $query = "SELECT codigocarrera, nombrecarrera 
                    FROM carrera 
                    WHERE codigomodalidadacademica IN(200,300)
                    AND fechavencimientocarrera > NOW() 
                    and fechainiciocarrera <=now() and fechavencimientocarrera >= now()  
                    ORDER BY nombrecarrera";
        $row_operacion = $db->GetAll($query);
        $conteo = count($row_operacion);
        return $row_operacion;
    }

}

?>