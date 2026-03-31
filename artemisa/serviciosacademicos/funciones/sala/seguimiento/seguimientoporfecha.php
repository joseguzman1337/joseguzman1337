<?php

// Funciones para traer datos por cada proceso vida estudiante

class seguimiento {

    var $codigocarrera;
    var $codigoperiodo;
    var $codigoperiodoanterior;
    var $fechaperiodo;

    function seguimiento($codigocarrera, $codigoperiodo, $fechaperiodo) {
        $this->codigocarrera = $codigocarrera;
        $this->codigoperiodo = $codigoperiodo;
        $this->codigoperiodoanterior = $this->getPeriodoAnterior();
        $this->fechaperiodo = $fechaperiodo;
    }

    function getPeriodoAnterior() {
        global $db;
        $query = "SELECT p.codigoperiodo
        FROM periodo p
        WHERE p.codigoperiodo < '$this->codigoperiodo'
        ORDER by 1 DESC";
        $rta = $db->Execute($query);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        return $row_rta['codigoperiodo'];
    }

    function totalProcesos($codigoprocesovidaestudiante) {
        switch ($codigoprocesovidaestudiante) {
            case 100 :
                return $this->totalInteresados();
                break;
            case 101 :
                return $this->totalAspirantes();
                break;
            case 102 :
                return $this->totalAspirantesVsInscritos();
                break;
            case 200 :
                return $this->totalInscritos();
                break;
            case 201 :
                return $this->totalInscritosEvaluados();
                break;
            case 408 :
                return $this->totalInscritosVsMatriculadosNuevos();
                break;
            case 400 :
                return $this->totalMatriculadosNuevos();
                break;
            case 401 :
                return $this->totalMatriculadosAntiguos();
                break;
            case 402 :
                return $this->totalMatriculadosTransferencia();
                break;
            case 403 :
                return $this->totalMatriculados();
                break;
            case 404 :
                return $this->totalMatriculadosRepitentesSemestre1();
                break;
            case 405 :
                return $this->totalMatriculadosTransferenciaSemestre1();
                break;
            case 406 :
                return $this->totalMatriculadosReintegroSemestre1();
                break;
            case 407 :
                return $this->totalMatriculadosSemestre1();
                break;
            case 409 :
                return $this->totalMatriculadosReintegro();
                break;
            case 500 :
                return $this->totalASeguirPrematriculados();
                break;
            case 501 :
                return $this->totalASeguirNoPrematriculados();
                break;
            default :
                return 0;
                break;
        }
    }

    function totalProcesosSeguimiento($codigoprocesovidaestudiante) {
        switch ($codigoprocesovidaestudiante) {
            case 100 :
                return $this->totalInteresadosSeguimiento();
                break;
            default :
                return $this->totalProcesoSeguimiento($codigoprocesovidaestudiante);
                break;
        }
    }

    function totalProcesosUltimoSeguimiento($codigoprocesovidaestudiante) {
        switch ($codigoprocesovidaestudiante) {
            case 100 :
                return $this->totalInteresadosUltimoSeguimiento();
                break;
            default :
                return $this->totalDemasUltimoSeguimiento($codigoprocesovidaestudiante);
                break;
        }
    }

    function totalProcesosUltimoSeguimientoDetalle($codigoprocesovidaestudiante, $idtipodetalleestudianteseguimiento, $codigotipoestudianteseguimiento) {
        switch ($codigoprocesovidaestudiante) {
            case 100 :
                return $this->totalInteresadosUltimoSeguimientoDetalle($idtipodetalleestudianteseguimiento, $codigotipoestudianteseguimiento);
                break;
            default :
                return $this->totalDemasUltimoSeguimientoDetalle($codigoprocesovidaestudiante, $idtipodetalleestudianteseguimiento, $codigotipoestudianteseguimiento);
                break;
        }
    }

    // Esta no disminuye
    function totalInteresados() {
        global $db;
        $sql = "SELECT count(distinct p.idpreinscripcion) as total, pc.codigocarrera
        FROM preinscripcion p, preinscripcioncarrera pc
        WHERE p.idpreinscripcion=pc.idpreinscripcion
        AND p.codigoestado=100
        AND p.codigoestadopreinscripcionestudiante not like '2%'
        AND p.codigoperiodo='$this->codigoperiodo'
        AND pc.codigocarrera='$this->codigocarrera'
        and p.fechapreinscripcion <= '$this->fechaperiodo'
        GROUP BY 2";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        //and p.codigoestado like '1%'
        //and pc.codigoestado like '1%'

        if ($totalRows_rta > 0)
            return $row_rta['total'];
        return 0;
    }

    function totalInteresadosSeguimiento() {
        global $db;
        $sql = "select count(ps.idpreinscripcion) as total, c.codigocarrera, c.nombrecarrera
        from preinscripcionseguimiento ps, preinscripcion p, preinscripcioncarrera pc, carrera c
        where ps.idpreinscripcion = p.idpreinscripcion
        and pc.idpreinscripcion = p.idpreinscripcion
        and pc.codigocarrera = c.codigocarrera
        and ps.codigoestado like '1%'
        and p.codigoestado like '1%'
        and pc.codigoestado like '1%'
        and c.codigocarrera = '$this->codigocarrera'
        and p.codigoperiodo = '$this->codigoperiodo'
        and ps.idusuario <> '1'
        group by 2";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        if ($totalRows_rta > 0)
            return $row_rta['total'];
        return 0;
    }

    function totalInteresadosUltimoSeguimiento() {
        global $db;
        $sql = "select count(ps.idpreinscripcion) as total, ps.codigotipoestudianteseguimiento
        from preinscripcionseguimiento ps, preinscripcion p, preinscripcioncarrera pc, carrera c
        where ps.idpreinscripcion = p.idpreinscripcion
        and pc.idpreinscripcion = p.idpreinscripcion
        and pc.codigocarrera = c.codigocarrera
        and ps.codigoestado like '1%'
        and p.codigoestado like '1%'
        and pc.codigoestado like '1%'
        and ps.idusuario <> '1'
        and ps.codigotipoestudianteseguimiento in (300, 400)
        and p.codigoperiodo = '$this->codigoperiodo'
        and c.codigocarrera = '$this->codigocarrera'
        and ps.idpreinscripcionseguimiento = (
            select max(ps1.idpreinscripcionseguimiento)
            from preinscripcionseguimiento ps1
            where ps1.idpreinscripcion = p.idpreinscripcion
        )
        group by 2";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();

        $total['300'] = 0;
        $total['400'] = 0;

        if ($totalRows_rta > 0) {
            while ($row_rta = $rta->FetchRow()) {
                $total[$row_rta['codigotipoestudianteseguimiento']] = $row_rta['total'];
            }
        }
        return $total;
    }

    function totalInteresadosUltimoSeguimientoDetalle($idtipodetalleestudianteseguimiento, $codigotipoestudianteseguimiento) {
        global $db;
        $sql = "select count(ps.idpreinscripcion) as total, ps.codigotipoestudianteseguimiento
        from preinscripcionseguimiento ps, preinscripcion p, preinscripcioncarrera pc, carrera c
        where ps.idpreinscripcion = p.idpreinscripcion
        and pc.idpreinscripcion = p.idpreinscripcion
        and pc.codigocarrera = c.codigocarrera
        and ps.codigoestado like '1%'
        and p.codigoestado like '1%'
        and pc.codigoestado like '1%'
        and ps.idusuario <> '1'
        and ps.codigotipoestudianteseguimiento in ($codigotipoestudianteseguimiento)
        and p.codigoperiodo = '$this->codigoperiodo'
        and c.codigocarrera = '$this->codigocarrera'
        and ps.Idtipodetalleestudianteseguimiento = '$idtipodetalleestudianteseguimiento'
        and ps.idpreinscripcionseguimiento = (
            select max(ps1.idpreinscripcionseguimiento)
            from preinscripcionseguimiento ps1
            where ps1.idpreinscripcion = p.idpreinscripcion
        )
        group by 2";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        if ($totalRows_rta > 0)
            return $row_rta['total'];
        return 0;
    }

    function totalDemasUltimoSeguimiento($codigoprocesovidaestudiante) {
        global $db;
        //$db->debug = true;
        $sql = "select count(es.codigoestudiante) as total, es.codigotipoestudianteseguimiento
        from estudianteseguimiento es, estudiante e, carrera c, subperiodo s, carreraperiodo p
        where es.codigoestudiante = e.codigoestudiante
        and e.codigocarrera = c.codigocarrera
        and es.idsubperiodo = s.idsubperiodo
        and s.idcarreraperiodo = p.idcarreraperiodo
        and p.codigocarrera = c.codigocarrera
        and es.codigoestado like '1%'
        and p.codigoestado like '1%'
        and c.codigocarrera = '$this->codigocarrera'
        and p.codigoperiodo = '$this->codigoperiodo'
        and es.codigoprocesovidaestudiante = '$codigoprocesovidaestudiante'
        and es.idestudianteseguimiento = (
            select max(es1.idestudianteseguimiento)
            from estudianteseguimiento es1
            where es1.idestudianteseguimiento = es.idestudianteseguimiento
        )
        group by 2";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();

        $total['300'] = 0;
        $total['400'] = 0;

        if ($totalRows_rta > 0) {
            while ($row_rta = $rta->FetchRow()) {
                $total[$row_rta['codigotipoestudianteseguimiento']] = $row_rta['total'];
            }
        }
        return $total;
    }

    function totalDemasUltimoSeguimientoDetalle($codigoprocesovidaestudiante, $idtipodetalleestudianteseguimiento, $codigotipoestudianteseguimiento) {
        global $db;
        $sql = "select count(es.codigoestudiante) as total, es.codigotipoestudianteseguimiento
        from estudianteseguimiento es, estudiante e, carrera c, subperiodo s, carreraperiodo p
        where es.codigoestudiante = e.codigoestudiante
        and e.codigocarrera = c.codigocarrera
        and es.idsubperiodo = s.idsubperiodo
        and s.idcarreraperiodo = p.idcarreraperiodo
        and p.codigocarrera = c.codigocarrera
        and es.codigoestado like '1%'
        and p.codigoestado like '1%'
        and c.codigocarrera = '$this->codigocarrera'
        and p.codigoperiodo = '$this->codigoperiodo'
        and es.idtipodetalleestudianteseguimiento = '$idtipodetalleestudianteseguimiento'
        and es.codigotipoestudianteseguimiento = '$codigotipoestudianteseguimiento'
        and es.codigoprocesovidaestudiante = '$codigoprocesovidaestudiante'
        and es.idestudianteseguimiento = (
            select max(es1.idestudianteseguimiento)
            from estudianteseguimiento es1
            where es1.idestudianteseguimiento = es.idestudianteseguimiento
        )
        group by 2";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        if ($totalRows_rta > 0)
            return $row_rta['total'];
        return 0;
    }

    // Esta función sirve para los demás seguimientos que no sean interesados osea 100
    function totalProcesoSeguimiento($codigoprocesovidaestudiante) {
        global $db;
        $sql = "select count(es.codigoestudiante) as total, c.codigocarrera, c.nombrecarrera
        from estudianteseguimiento es, estudiante e, carrera c, subperiodo s,
        carreraperiodo p
        where es.codigoestudiante = e.codigoestudiante
        and e.codigocarrera = c.codigocarrera
        and es.idsubperiodo = s.idsubperiodo
        and s.idcarreraperiodo = p.idcarreraperiodo
        and p.codigocarrera = c.codigocarrera
        and es.codigoestado like '1%'
        and p.codigoestado like '1%'
        and c.codigocarrera = '$this->codigocarrera'
        and p.codigoperiodo = '$this->codigoperiodo'
        and es.codigoprocesovidaestudiante = '$codigoprocesovidaestudiante'
        group by 2";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        if ($totalRows_rta > 0)
            return $row_rta['total'];
        return 0;
    }

    // La funcion de aspirantes va disminuyendo no sirve con la fecha ya que la situación cambia y se valida que este la orden activa
    function totalAspirantes() {
        global $db;
        /* $sql = "SELECT distinct e.codigoestudiante
          FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
          WHERE o.numeroordenpago=d.numeroordenpago
          AND e.codigoestudiante=o.codigoestudiante
          AND c.codigocarrera=e.codigocarrera
          AND d.codigoconcepto=co.codigoconcepto
          AND co.cuentaoperacionprincipal=153
          AND (o.codigoestadoordenpago LIKE '1%')
          AND o.codigoperiodo='$this->codigoperiodo'
          AND c.codigocarrera='$this->codigocarrera'
          and o.fechaordenpago <= '$this->fechaperiodo'
          and e.codigosituacioncarreraestudiante = 106
          union
          SELECT e.codigoestudiante
          FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
          WHERE o.numeroordenpago=d.numeroordenpago
          AND e.codigoestudiante=o.codigoestudiante
          AND c.codigocarrera=e.codigocarrera
          AND d.codigoconcepto=co.codigoconcepto
          AND co.cuentaoperacionprincipal='153'
          AND o.codigoestadoordenpago LIKE '4%'
          AND o.codigoperiodo='$this->codigoperiodo'
          AND c.codigocarrera=e.codigocarrera
          AND e.codigocarrera = '$this->codigocarrera'
          AND e.codigosituacioncarreraestudiante <> '106'
          and o.fechaordenpago <= '$this->fechaperiodo'
          and o.fechapagosapordenpago > '$this->fechaperiodo'
          "; */
        $sql = "SELECT distinct ee.codigoestudiante, ee.codigoperiodo,  e.codigosituacioncarreraestudiante
                FROM estudianteestadistica ee, carrera c, estudiante e
                where e.codigocarrera = '$this->codigocarrera'
                and e.codigocarrera=c.codigocarrera
                and ee.codigoestudiante=e.codigoestudiante
                and ee.codigoperiodo = '$this->codigoperiodo'
                and ee.codigoprocesovidaestudiante= 101
                and ee.codigoestado like '1%'
                and ee.estudianteestadisticafechafinal > '$this->fechaperiodo'";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        //and p.codigoestado like '1%'
        //and pc.codigoestado like '1%'

        if ($totalRows_rta > 0)
            return $totalRows_rta;
        return 0;
    }

    // Esta va disminuyendo
    function totalAspirantesVsInscritos() {
        global $db;
        //$db->debug = true;
        $sql = "SELECT e.codigoestudiante
        FROM estudiante e
        WHERE e.codigocarrera = '$this->codigocarrera'
        AND e.codigoperiodo='$this->codigoperiodo'
        and e.codigoestudiante not in
        (
            SELECT e1.codigoestudiante
            FROM ordenpago o1, detalleordenpago d1, estudiante e1, carrera c1, concepto co1
            WHERE o1.numeroordenpago=d1.numeroordenpago
            AND e1.codigoestudiante=o1.codigoestudiante
            AND c1.codigocarrera=e1.codigocarrera
            AND d1.codigoconcepto=co1.codigoconcepto
            AND co1.cuentaoperacionprincipal='153'
            AND o1.codigoestadoordenpago LIKE '4%'
            AND o1.codigoperiodo='$this->codigoperiodo'
            AND c1.codigocarrera=e.codigocarrera
            AND e1.codigocarrera = '$this->codigocarrera'
            AND e1.codigosituacioncarreraestudiante <> '106'
            and e1.codigoestudiante = e.codigoestudiante
            UNION
            SELECT e1.codigoestudiante
            FROM estudiante e1, inscripcion i1, estudiantecarrerainscripcion eci1
            WHERE e1.idestudiantegeneral = i1.idestudiantegeneral
            AND i1.codigosituacioncarreraestudiante = '111'
            AND i1.idinscripcion=eci1.idinscripcion
            AND eci1.codigocarrera= e1.codigocarrera
            AND i1.codigoperiodo = '$this->codigoperiodo'
            AND e1.codigocarrera = '$this->codigocarrera'
            and e1.codigoestudiante = e.codigoestudiante
        )
        UNION
        SELECT e.codigoestudiante
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
        WHERE o.numeroordenpago=d.numeroordenpago
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal=153
        AND (o.codigoestadoordenpago LIKE '1%' OR o.codigoestadoordenpago LIKE '4%')
        AND o.codigoperiodo = '$this->codigoperiodo'
        AND c.codigocarrera = '$this->codigocarrera'
        and e.codigoestudiante not in
        (
            SELECT e1.codigoestudiante
            FROM ordenpago o1, detalleordenpago d1, estudiante e1, carrera c1, concepto co1
            WHERE o1.numeroordenpago=d1.numeroordenpago
            AND e1.codigoestudiante=o1.codigoestudiante
            AND c1.codigocarrera=e1.codigocarrera
            AND d1.codigoconcepto=co1.codigoconcepto
            AND co1.cuentaoperacionprincipal='153'
            AND o1.codigoestadoordenpago LIKE '4%'
            AND o1.codigoperiodo='$this->codigoperiodo'
            AND c1.codigocarrera=e.codigocarrera
            AND e1.codigocarrera = '$this->codigocarrera'
            AND e1.codigosituacioncarreraestudiante <> '106'
            and e1.codigoestudiante = e.codigoestudiante
            UNION
            SELECT e1.codigoestudiante
            FROM estudiante e1, inscripcion i1, estudiantecarrerainscripcion eci1
            WHERE e1.idestudiantegeneral = i1.idestudiantegeneral
            AND i1.codigosituacioncarreraestudiante = '111'
            AND i1.idinscripcion=eci1.idinscripcion
            AND eci1.codigocarrera= e1.codigocarrera
            AND i1.codigoperiodo = '$this->codigoperiodo'
            AND e1.codigocarrera = '$this->codigocarrera'
            and e1.codigoestudiante = e.codigoestudiante
        )
        ORDER BY 1";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        //and p.codigoestado like '1%'
        //and pc.codigoestado like '1%'

        if ($totalRows_rta > 0)
            return $totalRows_rta;
        return 0;
    }

    // Esta se mantiene fija por lo tanto si aplica
    function totalInscritos() {
        global $db;
        /* $sql = "SELECT e.codigoestudiante
          FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
          WHERE o.numeroordenpago=d.numeroordenpago
          AND e.codigoestudiante=o.codigoestudiante
          AND c.codigocarrera=e.codigocarrera
          AND d.codigoconcepto=co.codigoconcepto
          AND co.cuentaoperacionprincipal='153'
          AND o.codigoestadoordenpago LIKE '4%'
          AND o.codigoperiodo='$this->codigoperiodo'
          AND c.codigocarrera=e.codigocarrera
          AND e.codigocarrera = '$this->codigocarrera'
          AND e.codigosituacioncarreraestudiante <> '106'
          and o.fechapagosapordenpago <= '$this->fechaperiodo'
          UNION
          SELECT e.codigoestudiante
          FROM estudiante e, inscripcion i, estudiantecarrerainscripcion eci
          WHERE e.idestudiantegeneral = i.idestudiantegeneral
          AND i.codigosituacioncarreraestudiante = '111'
          AND i.idinscripcion=eci.idinscripcion
          AND eci.codigocarrera= e.codigocarrera
          AND i.codigoperiodo = '$this->codigoperiodo'
          AND e.codigocarrera = '$this->codigocarrera'"; */
        $sql = "SELECT ee.codigoestudiante, ee.codigoperiodo, ee.codigoprocesovidaestudiante, e.codigocarrera,ee.estudianteestadisticafechafinal
                FROM estudianteestadistica ee, carrera c, estudiante e
                  where e.codigocarrera=c.codigocarrera
                  and c.codigocarrera= '$this->codigocarrera'
                  and ee.codigoestudiante=e.codigoestudiante
                  and ee.codigoperiodo = '$this->codigoperiodo'
                  and ee.codigoprocesovidaestudiante= 200
                  and ee.codigoestado like '1%'
                  order by 1";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        //and p.codigoestado like '1%'
        //and pc.codigoestado like '1%'

        if ($totalRows_rta > 0)
            return $totalRows_rta;
        return 0;
    }

    function totalInscritosEvaluados() {
        global $db;
        $sql = "select count(distinct ea.codigoestudiante) as total
        from estudianteadmision ea,admision a,carreraperiodo cp,subperiodo sp,
        estudiante e,estudiantegeneral eg
        where ea.idadmision=a.idadmision
        and cp.codigocarrera=cp.codigocarrera
        and sp.idcarreraperiodo=cp.idcarreraperiodo
        and a.idsubperiodo=sp.idsubperiodo
        and e.codigoestudiante=ea.codigoestudiante
        and eg.idestudiantegeneral=e.idestudiantegeneral
        and cp.codigoperiodo='$this->codigoperiodo'
        and cp.codigocarrera='$this->codigocarrera'
        and ea.codigoestadoestudianteadmision like '1%'";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        //and p.codigoestado like '1%'
        //and pc.codigoestado like '1%'

        if ($totalRows_rta > 0)
            return $row_rta['total'];
        return 0;
    }

    function totalInscritosVsMatriculadosNuevos() {
        global $db;
        //$db->debug = true;
        $sql = "SELECT e.codigoestudiante,e.codigoperiodo
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
        WHERE o.numeroordenpago=d.numeroordenpago
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal='153'
        AND o.codigoestadoordenpago LIKE '4%'
        AND o.codigoperiodo='$this->codigoperiodo'
        AND c.codigocarrera=e.codigocarrera
        AND e.codigocarrera='$this->codigocarrera'
        AND e.codigosituacioncarreraestudiante <> '106'
        and e.codigoestudiante not in(
            SELECT e1.codigoestudiante
            FROM ordenpago o1, detalleordenpago d1, estudiante e1, carrera c1, concepto co1, prematricula pr1
            WHERE o1.numeroordenpago=d1.numeroordenpago
            AND pr1.codigoperiodo='$this->codigoperiodo'
            AND e1.codigoestudiante=pr1.codigoestudiante
            AND e1.codigoestudiante=o1.codigoestudiante
            AND c1.codigocarrera=e1.codigocarrera
            AND d1.codigoconcepto=co1.codigoconcepto
            AND co1.cuentaoperacionprincipal=151
            AND e1.codigocarrera='$this->codigocarrera'
            AND o1.codigoperiodo='$this->codigoperiodo'
            AND o1.codigoestadoordenpago LIKE '4%'
            AND e1.codigoperiodo='$this->codigoperiodo'
            and e1.codigoestudiante = e.codigoestudiante
        )
        UNION
        SELECT e.codigoestudiante, i.codigoperiodo
        FROM estudiante e, inscripcion i, estudiantecarrerainscripcion eci
        WHERE e.idestudiantegeneral = i.idestudiantegeneral
        AND i.codigosituacioncarreraestudiante = '111'
        AND i.idinscripcion=eci.idinscripcion
        AND eci.codigocarrera= e.codigocarrera
        AND i.codigoperiodo = '$this->codigoperiodo'
        AND e.codigocarrera='$this->codigocarrera'
        and e.codigoestudiante not in(
            SELECT e1.codigoestudiante
            FROM ordenpago o1, detalleordenpago d1, estudiante e1, carrera c1, concepto co1, prematricula pr1
            WHERE o1.numeroordenpago=d1.numeroordenpago
            AND pr1.codigoperiodo='$this->codigoperiodo'
            AND e1.codigoestudiante=pr1.codigoestudiante
            AND e1.codigoestudiante=o1.codigoestudiante
            AND c1.codigocarrera=e1.codigocarrera
            AND d1.codigoconcepto=co1.codigoconcepto
            AND co1.cuentaoperacionprincipal=151
            AND e1.codigocarrera='$this->codigocarrera'
            AND o1.codigoperiodo='$this->codigoperiodo'
            AND o1.codigoestadoordenpago LIKE '4%'
            AND e1.codigoperiodo='$this->codigoperiodo'
            and e1.codigoestudiante = e.codigoestudiante
        )";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        //and p.codigoestado like '1%'
        //and pc.codigoestado like '1%'

        if ($totalRows_rta > 0)
            return $totalRows_rta;
        return 0;
    }

    function totalMatriculadosNuevos() {
        global $db;
        /* $sql = "SELECT count(distinct e.codigoestudiante) as total
          FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
          WHERE o.numeroordenpago=d.numeroordenpago
          AND pr.codigoperiodo='$this->codigoperiodo'
          AND e.codigoestudiante=pr.codigoestudiante
          AND e.codigoestudiante=o.codigoestudiante
          AND c.codigocarrera=e.codigocarrera
          AND d.codigoconcepto=co.codigoconcepto
          AND co.cuentaoperacionprincipal=151
          AND e.codigocarrera='$this->codigocarrera'
          AND o.codigoperiodo='$this->codigoperiodo'
          AND o.codigoestadoordenpago LIKE '4%'
          AND e.codigoperiodo='$this->codigoperiodo'
          and o.fechapagosapordenpago <= '$this->fechaperiodo'"; */
        $sql = "SELECT count(distinct ee.codigoestudiante) as total, ee.codigoperiodo
                FROM estudianteestadistica ee, carrera c, estudiante e
                where e.codigocarrera = '$this->codigocarrera'
                and e.codigocarrera=c.codigocarrera
                and ee.codigoestudiante=e.codigoestudiante
                and ee.codigoperiodo = '$this->codigoperiodo'
                and ee.codigoprocesovidaestudiante= 400
                and ee.estudianteestadisticafechainicial <= '$this->fechaperiodo'
                and ee.codigoestado like '1%'
                order by 1";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        //and p.codigoestado like '1%'
        //and pc.codigoestado like '1%'

        if ($totalRows_rta > 0)
            return $row_rta['total'];
        return 0;
    }

    function totalMatriculadosAntiguos() {
        global $db;
        /* $sql = "SELECT count(distinct e.codigoestudiante) as total
          FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
          WHERE o.numeroordenpago=d.numeroordenpago
          AND e.codigoestudiante=pr.codigoestudiante
          AND pr.codigoperiodo='$this->codigoperiodo'
          AND e.codigoestudiante=o.codigoestudiante
          AND c.codigocarrera=e.codigocarrera
          AND d.codigoconcepto=co.codigoconcepto
          AND co.cuentaoperacionprincipal=151
          AND o.codigoperiodo='$this->codigoperiodo'
          AND o.codigoestadoordenpago LIKE '4%'
          AND e.codigocarrera='$this->codigocarrera'
          AND e.codigoperiodo<>'$this->codigoperiodo'
          and o.fechapagosapordenpago <= '$this->fechaperiodo'
          and e.codigoestudiante in(
          SELECT op1.codigoestudiante
          FROM ordenpago op1, detalleordenpago dop1, concepto co1
          WHERE op1.numeroordenpago=dop1.numeroordenpago
          AND dop1.codigoconcepto=co1.codigoconcepto
          AND co1.cuentaoperacionprincipal=151
          AND op1.codigoperiodo='$this->codigoperiodoanterior'
          AND op1.codigoestadoordenpago LIKE '4%'
          and op1.codigoestudiante = e.codigoestudiante
          )"; */
        $sql = "SELECT count(distinct ee.codigoestudiante) as total, ee.codigoperiodo
                FROM estudianteestadistica ee, carrera c, estudiante e
                where e.codigocarrera = '$this->codigocarrera'
                and e.codigocarrera=c.codigocarrera
                and ee.codigoestudiante=e.codigoestudiante
                and ee.codigoperiodo = '$this->codigoperiodo'
                and ee.codigoprocesovidaestudiante= 401
                and ee.estudianteestadisticafechainicial <= '$this->fechaperiodo'
                and ee.codigoestado like '1%'
                order by 1";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        //and p.codigoestado like '1%'
        //and pc.codigoestado like '1%'

        if ($totalRows_rta > 0)
            return $row_rta['total'];
        return 0;
    }

    function totalMatriculadosTransferencia() {
        global $db;
        $sql = "SELECT count(distinct e.codigoestudiante) as total
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
        WHERE o.numeroordenpago=d.numeroordenpago
        AND pr.codigoperiodo='$this->codigoperiodo'
        AND e.codigoestudiante=pr.codigoestudiante
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal=151
        AND e.codigocarrera='$this->codigocarrera'
        AND o.codigoperiodo='$this->codigoperiodo'
        AND o.codigoestadoordenpago LIKE '4%'
        AND e.codigoperiodo='$this->codigoperiodo'
        and o.fechapagosapordenpago <= '$this->fechaperiodo'
        and e.codigoestudiante in (
            SELECT nh.codigoestudiante
            FROM notahistorico nh
            WHERE nh.codigotiponotahistorico = '400'
            AND nh.codigoestudiante = e.codigoestudiante
        )";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        //and p.codigoestado like '1%'
        //and pc.codigoestado like '1%'

        if ($totalRows_rta > 0)
            return $row_rta['total'];
        return 0;
    }

    function totalMatriculados() {
        global $db;
        /* $sql = "SELECT count(distinct e.codigoestudiante) as total
          FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
          WHERE o.numeroordenpago=d.numeroordenpago
          AND pr.codigoperiodo='$this->codigoperiodo'
          AND e.codigoestudiante=pr.codigoestudiante
          AND e.codigoestudiante=o.codigoestudiante
          AND c.codigocarrera=e.codigocarrera
          AND d.codigoconcepto=co.codigoconcepto
          AND co.cuentaoperacionprincipal=151
          AND e.codigocarrera='$this->codigocarrera'
          AND o.codigoperiodo='$this->codigoperiodo'
          AND o.codigoestadoordenpago LIKE '4%'
          and o.fechapagosapordenpago <= '$this->fechaperiodo'"; */
        $sql = "SELECT count(distinct ee.codigoestudiante) as total, ee.codigoperiodo
                FROM estudianteestadistica ee, carrera c, estudiante e
                where e.codigocarrera = '$this->codigocarrera'
                and e.codigocarrera=c.codigocarrera
                and ee.codigoestudiante=e.codigoestudiante
                and ee.codigoperiodo = '$this->codigoperiodo'
                and ee.codigoprocesovidaestudiante in(401, 400)
                and ee.estudianteestadisticafechainicial <= '$this->fechaperiodo'
                and ee.codigoestado like '1%'
                order by 1";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        //and p.codigoestado like '1%'
        //and pc.codigoestado like '1%'

        if ($totalRows_rta > 0)
            return $row_rta['total'];
        return 0;
    }

    function totalMatriculadosRepitentesSemestre1() {
        global $db;
        $sql = "SELECT count(distinct e.codigoestudiante) as total
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
        WHERE o.numeroordenpago=d.numeroordenpago
        AND e.codigoestudiante=pr.codigoestudiante
        AND pr.codigoperiodo='$this->codigoperiodo'
        AND pr.semestreprematricula=1
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal=151
        AND o.codigoperiodo='$this->codigoperiodo'
        AND o.codigoestadoordenpago LIKE '4%'
        AND e.codigocarrera='$this->codigocarrera'
        AND e.codigoperiodo<>'$this->codigoperiodo'
        AND e.codigotipoestudiante='20'
        and o.fechapagosapordenpago <= '$this->fechaperiodo'
        and e.codigoestudiante in(
            SELECT e1.codigoestudiante
            FROM ordenpago o1, detalleordenpago d1, estudiante e1, carrera c1, concepto co1, prematricula pr1
            WHERE o1.numeroordenpago=d1.numeroordenpago
            AND e1.codigoestudiante=pr1.codigoestudiante
            AND pr1.semestreprematricula=1
            AND pr1.codigoperiodo='$this->codigoperiodoanterior'
            AND e1.codigoestudiante=o1.codigoestudiante
            AND c1.codigocarrera=e1.codigocarrera
            AND d1.codigoconcepto=co1.codigoconcepto
            AND co1.cuentaoperacionprincipal=151
            AND o1.codigoperiodo='$this->codigoperiodo'
            AND o1.codigoestadoordenpago LIKE '4%'
            AND e1.codigocarrera='$this->codigocarrera'
            AND e1.codigoperiodo<>'$this->codigoperiodo'
            AND e1.codigotipoestudiante='20'
            and e.codigoestudiante = e1.codigoestudiante
            and o1.fechapagosapordenpago <= '$this->fechaperiodo'
        )";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        //and p.codigoestado like '1%'
        //and pc.codigoestado like '1%'

        if ($totalRows_rta > 0)
            return $row_rta['total'];
        return 0;
    }

    function totalMatriculadosTransferenciaSemestre1() {
        global $db;
        $sql = "SELECT count(distinct e.codigoestudiante) as total
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
        WHERE o.numeroordenpago=d.numeroordenpago
        AND pr.codigoperiodo='$this->codigoperiodo'
        AND e.codigoestudiante=pr.codigoestudiante
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal=151
        AND e.codigocarrera='$this->codigocarrera'
        AND o.codigoperiodo='$this->codigoperiodo'
        AND o.codigoestadoordenpago LIKE '4%'
        AND e.codigoperiodo='$this->codigoperiodo'
        and pr.semestreprematricula = 1
        and o.fechapagosapordenpago <= '$this->fechaperiodo'
        and e.codigoestudiante in(
            SELECT nh.codigoestudiante
            FROM notahistorico nh
            WHERE nh.codigotiponotahistorico = '400'
            AND nh.codigoestudiante = e.codigoestudiante
        )";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        //and p.codigoestado like '1%'
        //and pc.codigoestado like '1%'

        if ($totalRows_rta > 0)
            return $row_rta['total'];
        return 0;
    }

    function totalMatriculadosReintegroSemestre1() {
        global $db;
        $sql = "SELECT count(distinct e.codigoestudiante) as total
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
        WHERE o.numeroordenpago=d.numeroordenpago
        AND e.codigoestudiante=pr.codigoestudiante
        AND pr.codigoperiodo='$this->codigoperiodo'
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal=151
        AND o.codigoperiodo='$this->codigoperiodo'
        AND o.codigoestadoordenpago LIKE '4%'
        AND e.codigocarrera='$this->codigocarrera'
        AND e.codigoperiodo<>'$this->codigoperiodo'
        and pr.semestreprematricula = 1
        and o.fechapagosapordenpago <= '$this->fechaperiodo'
        and e.codigoestudiante not in(
            SELECT op1.codigoestudiante
            FROM ordenpago op1, detalleordenpago dop1, concepto co1
            WHERE op1.numeroordenpago=dop1.numeroordenpago
            AND dop1.codigoconcepto=co1.codigoconcepto
            AND co1.cuentaoperacionprincipal=151
            AND op1.codigoperiodo='$this->codigoperiodoanterior'
            AND op1.codigoestudiante=e.codigoestudiante
            AND op1.codigoestadoordenpago LIKE '4%'
        )";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        //and p.codigoestado like '1%'
        //and pc.codigoestado like '1%'

        if ($totalRows_rta > 0)
            return $row_rta['total'];
        return 0;
    }

    function totalMatriculadosSemestre1() {
        global $db;
        $sql = "SELECT count(distinct e.codigoestudiante) as total
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
        WHERE o.numeroordenpago=d.numeroordenpago
        AND pr.codigoperiodo='$this->codigoperiodo'
        AND e.codigoestudiante=pr.codigoestudiante
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal=151
        AND e.codigocarrera='$this->codigocarrera'
        AND o.codigoperiodo='$this->codigoperiodo'
        AND o.codigoestadoordenpago LIKE '4%'
        and pr.semestreprematricula = 1
        and o.fechapagosapordenpago <= '$this->fechaperiodo'";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        //and p.codigoestado like '1%'
        //and pc.codigoestado like '1%'

        if ($totalRows_rta > 0)
            return $row_rta['total'];
        return 0;
    }

    function totalMatriculadosReintegro() {
        global $db;
        $sql = "SELECT count(distinct e.codigoestudiante) as total
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
        WHERE o.numeroordenpago=d.numeroordenpago
        AND pr.codigoperiodo='$this->codigoperiodo'
        AND e.codigoestudiante=pr.codigoestudiante
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal=151
        AND e.codigocarrera='$this->codigocarrera'
        AND o.codigoperiodo='$this->codigoperiodo'
        AND o.codigoestadoordenpago LIKE '4%'
        AND e.codigoperiodo<>'$this->codigoperiodo'
        and o.fechapagosapordenpago <= '$this->fechaperiodo'
        and e.codigoestudiante not in(
        SELECT op.codigoestudiante
        FROM ordenpago op, detalleordenpago dop, concepto co
        WHERE op.numeroordenpago=dop.numeroordenpago
        AND dop.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal=151
        AND op.codigoperiodo='$this->codigoperiodoanterior'
        AND op.codigoestadoordenpago LIKE '4%'
        and op.codigoestudiante = e.codigoestudiante
        )";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        //and p.codigoestado like '1%'
        //and pc.codigoestado like '1%'

        if ($totalRows_rta > 0)
            return $row_rta['total'];
        return 0;
    }

    function totalASeguirPrematriculados() {
        global $db;
        $sql = "SELECT count(distinct e.codigoestudiante) as total
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
        WHERE o.numeroordenpago=d.numeroordenpago
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND e.codigocarrera='$this->codigocarrera'
        AND co.cuentaoperacionprincipal='151'
        AND o.codigoperiodo='$this->codigoperiodo'
        AND o.codigoestadoordenpago LIKE '1%'";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        //and p.codigoestado like '1%'
        //and pc.codigoestado like '1%'

        if ($totalRows_rta > 0)
            return $row_rta['total'];
        return 0;
    }

    function totalASeguirNoPrematriculados() {
        global $db;
        $sql = "SELECT count(distinct e1.codigoestudiante) as total
        FROM ordenpago o1, detalleordenpago d1, estudiante e1, carrera c1, concepto co1
        WHERE o1.numeroordenpago=d1.numeroordenpago
        AND e1.codigoestudiante=o1.codigoestudiante
        AND c1.codigocarrera=e1.codigocarrera
        AND d1.codigoconcepto=co1.codigoconcepto
        AND co1.cuentaoperacionprincipal='151'
        AND o1.codigoestadoordenpago LIKE '4%'
        AND o1.codigoperiodo='$this->codigoperiodoanterior'
        AND c1.codigocarrera='$this->codigocarrera'
        AND e1.codigosituacioncarreraestudiante not like '4%'
        AND e1.codigosituacioncarreraestudiante not like '1%'
        and e1.codigoestudiante not in(
            SELECT e.codigoestudiante
            FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
            WHERE o.numeroordenpago=d.numeroordenpago
            AND e.codigoestudiante=o.codigoestudiante
            AND c.codigocarrera=e.codigocarrera
            AND d.codigoconcepto=co.codigoconcepto
            AND e.codigocarrera='$this->codigocarrera'
            AND co.cuentaoperacionprincipal='151'
            AND o.codigoperiodo='$this->codigoperiodo'
            AND (o.codigoestadoordenpago LIKE '1%' or o.codigoestadoordenpago LIKE '4%')
            and e.codigoestudiante = e1.codigoestudiante
        )";
        $rta = $db->Execute($sql);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();
        //and p.codigoestado like '1%'
        //and pc.codigoestado like '1%'

        if ($totalRows_rta > 0)
            return $row_rta['total'];
        return 0;
    }

}
?>