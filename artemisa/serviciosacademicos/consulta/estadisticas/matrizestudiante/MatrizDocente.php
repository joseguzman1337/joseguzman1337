<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MatrizDocente
 *
 * @author fmunozb
 */
class MatrizDocente {
//put your code here
    var $codigocarrera;
    var $codigoperiodo;
    var $codigomodalidadacademicasic;
    var $codigoareadisciplinar;
    var $codigofacultad;
    var $arrayMatrizIzquierda;
    var $cuentaMatrizIzquierda;
    var $arrayModalidadAcademicaSic;
    var $arrayAreaDisciplinar;
    var $obtenerDatosEnLinea=false;
    var $filtroCarreras = "";

    function MatrizDocente($codigocarrera, $codigoperiodo, $codigomodalidadacademicasic, $codigoareadisciplinar, $codigofacultad = "") {
        $this->codigocarrera = $codigocarrera;
        $this->codigoperiodo = $codigoperiodo;
        $this->codigomodalidadacademicasic = $codigomodalidadacademicasic;
        $this->codigoareadisciplinar = $codigoareadisciplinar;
        $this->codigofacultad = $codigofacultad;
        $this->setFiltroCarreras();
        /*if(!$this->existesDatosEstaticos()) {
            $this->setTablaEstadisticaMatriculados();
        }*/
    }

    function selEsqueletoMatrizIzquierda() {
        global $db;
        unset($this->arrayMatrizIzquierda);
        if($this->codigomodalidadacademicasic != "") {
            $filtroModalidad1 = " and m1.codigomodalidadacademicasic = '$this->codigomodalidadacademicasic' ";
            $filtroModalidad2 = " and m.codigomodalidadacademicasic = '$this->codigomodalidadacademicasic' ";
        }
        if($this->codigoareadisciplinar != "") {
            $filtroArea1 = " and f1.codigoareadisciplinar = '$this->codigoareadisciplinar' ";
            $filtroArea2 = " and f.codigoareadisciplinar = '$this->codigoareadisciplinar' ";
        }
        if($this->codigocarrera != "") {
            $filtroCarrera1 = " and ca1.codigocarrera = '$this->codigocarrera' ";
            $filtroCarrera2 = " and ca.codigocarrera = '$this->codigocarrera' ";
        }
        
        $query = "select m.codigomodalidadacademicasic, m.nombremodalidadacademicasic,
        count(distinct a.codigoareadisciplinar) cuentaAreasXModalidad, c2.cuentaCarrerasXModalidad,
        (count(distinct a.codigoareadisciplinar)+ c2.cuentaCarrerasXModalidad) as totalRowsPan
        from areadisciplinar a, facultad f, modalidadacademicasic m, carrera ca,
        (
            select m1.codigomodalidadacademicasic, m1.nombremodalidadacademicasic, count(*) cuentaCarrerasXModalidad
            from areadisciplinar a1, facultad f1, modalidadacademicasic m1, carrera ca1
            where a1.codigoareadisciplinar = f1.codigoareadisciplinar
            and m1.codigomodalidadacademicasic = ca1.codigomodalidadacademicasic
            and ca1.codigofacultad = f1.codigofacultad
            and ca1.codigocarrera $this->filtroCarreras
            $filtroModalidad1
            $filtroArea1
            $filtroCarrera1
            group by 1
        ) c2
        where a.codigoareadisciplinar = f.codigoareadisciplinar
        and m.codigomodalidadacademicasic = ca.codigomodalidadacademicasic
        and ca.codigofacultad = f.codigofacultad
        and c2.codigomodalidadacademicasic = m.codigomodalidadacademicasic
        and ca.codigocarrera $this->filtroCarreras
            $filtroModalidad2
            $filtroArea2
            $filtroCarrera2
        group by m.codigomodalidadacademicasic
        order by m.codigomodalidadacademicasic, a.codigoareadisciplinar";
        /*
        $query = "select m.codigomodalidadacademicasic, m.nombremodalidadacademicasic
        from areadisciplinar a, facultad f, modalidadacademicasic m, carrera ca
        where a.codigoareadisciplinar = f.codigoareadisciplinar
        and m.codigomodalidadacademicasic = ca.codigomodalidadacademicasic
        and ca.codigofacultad = f.codigofacultad
        and ca.codigocarrera $this->filtroCarreras
            $filtroModalidad1
            $filtroArea1
            $filtroCarrera1
        group by m.codigomodalidadacademicasic
        order by m.codigomodalidadacademicasic, a.codigoareadisciplinar";*/
        $sel = $db->Execute($query);
        return $sel;
    }

    function selEsqueletoMatrizIzquierda2() {
        global $db;
        unset($this->arrayMatrizIzquierda);
        if($this->codigomodalidadacademicasic != "") {
            $filtroModalidad1 = " and m1.codigomodalidadacademicasic = '$this->codigomodalidadacademicasic' ";
            $filtroModalidad2 = " and m.codigomodalidadacademicasic = '$this->codigomodalidadacademicasic' ";
        }
        if($this->codigoareadisciplinar != "") {
            $filtroArea = " and a.codigoareadisciplinar = '$this->codigoareadisciplinar' ";
            $filtroArea2 = " and f.codigoareadisciplinar = '$this->codigoareadisciplinar' ";
        }
        if($this->codigocarrera != "") {
            $filtroCarrera1 = " and ca1.codigocarrera = '$this->codigocarrera' ";
            $filtroCarrera2 = " and ca.codigocarrera = '$this->codigocarrera' ";
        }
        if($this->codigofacultad != "") {
            $filtroFacultad1 = " and f1.codigofacultad = '$this->codigofacultad' ";
            $filtroFacultad2 = " and f.codigofacultad = '$this->codigofacultad' ";
        }
        if($this->filtroCarreras == "in()") {
            $filtroCarrerastmp = "";
        }
        elseif($this->filtroCarreras != "") {
            $filtroCarrerastmp = " and ca.codigocarrera $this->filtroCarreras";
        }

        $query_area = "select distinct a.codigoareadisciplinar, a.nombreareadisciplinar
        from areadisciplinar a, carrera ca, facultad f, modalidadacademicasic m
        where a.codigoareadisciplinar = f.codigoareadisciplinar
        and f.codigofacultad = ca.codigofacultad
        and ca.codigomodalidadacademicasic = m.codigomodalidadacademicasic
        $filtroCarrerastmp
        $filtroArea2
        $filtroFacultad2
        $filtroModalidad2
        $filtroCarrera2";
        /*
        $query = "select m.codigomodalidadacademicasic, m.nombremodalidadacademicasic
        from areadisciplinar a, facultad f, modalidadacademicasic m, carrera ca
        where a.codigoareadisciplinar = f.codigoareadisciplinar
        and m.codigomodalidadacademicasic = ca.codigomodalidadacademicasic
        and ca.codigofacultad = f.codigofacultad
        and ca.codigocarrera $this->filtroCarreras
            $filtroModalidad1
            $filtroArea1
            $filtroCarrera1
        group by m.codigomodalidadacademicasic
        order by m.codigomodalidadacademicasic, a.codigoareadisciplinar";*/
        $sel_area = $db->Execute($query_area);
        $totalRows_area = $sel_area->RecordCount();
        $arrayIzquierda['totalareas'] = $totalRows_area;
        unset($arrayArea);
        while($row_area = $sel_area->FetchRow()) {
            $arrayArea[$row_area['codigoareadisciplinar']]['nombreareadisciplinar'] = $row_area['nombreareadisciplinar'];
            $query_facultad = "select distinct f.nombrefacultad, f.codigofacultad
            from areadisciplinar a, carrera ca, facultad f, modalidadacademicasic m
            where a.codigoareadisciplinar = f.codigoareadisciplinar
            and f.codigofacultad = ca.codigofacultad
            and ca.codigomodalidadacademicasic = m.codigomodalidadacademicasic
            $filtroCarrerastmp
            $filtroArea2
            $filtroFacultad2
            $filtroModalidad2
            $filtroCarrera2
            and f.codigoareadisciplinar = '".$row_area['codigoareadisciplinar']."'";
            $sel_facultad = $db->Execute($query_facultad);
            $totalRows_facultad = $sel_facultad->RecordCount();
            $arrayIzquierda['totalfacultades'] += $totalRows_facultad;
            $arrayArea[$row_area['codigoareadisciplinar']]['totalfacultades'] += $totalRows_facultad;
            unset($arrayFacultades);
            while($row_facultad = $sel_facultad->FetchRow()) {
                $arrayFacultades[$row_facultad['codigofacultad']]['nombrefacultad'] = $row_facultad['nombrefacultad'];
                $query_nivel = "select distinct m.codigomodalidadacademicasic, m.nombremodalidadacademicasic
                from areadisciplinar a, carrera ca, facultad f, modalidadacademicasic m
                where a.codigoareadisciplinar = f.codigoareadisciplinar
                and f.codigofacultad = ca.codigofacultad
                and ca.codigomodalidadacademicasic = m.codigomodalidadacademicasic
                $filtroCarrerastmp
                $filtroArea2
                $filtroFacultad2
                $filtroModalidad2
                $filtroCarrera2
                and f.codigoareadisciplinar = '".$row_area['codigoareadisciplinar']."'
                and f.codigofacultad = '".$row_facultad['codigofacultad']."'";
                $sel_nivel = $db->Execute($query_nivel);
                $totalRows_nivel = $sel_nivel->RecordCount();
                $arrayIzquierda['totalniveles'] += $totalRows_nivel;
                $arrayArea[$row_area['codigoareadisciplinar']]['totalniveles'] += $totalRows_nivel;
                $arrayFacultades[$row_facultad['codigofacultad']]['totalniveles'] = +$totalRows_nivel;
                unset($arrayNiveles);
                while($row_nivel = $sel_nivel->FetchRow()) {
                    $arrayNiveles[$row_nivel['codigomodalidadacademicasic']]['nombremodalidadacademicasic'] = $row_nivel['nombremodalidadacademicasic'];
                    $query_carrera = "select distinct ca.codigocarrera, ca.nombrecarrera
                    from areadisciplinar a, carrera ca, facultad f, modalidadacademicasic m
                    where a.codigoareadisciplinar = f.codigoareadisciplinar
                    and f.codigofacultad = ca.codigofacultad
                    and ca.codigomodalidadacademicasic = m.codigomodalidadacademicasic
                    $filtroCarrerastmp
                    $filtroArea2
                    $filtroFacultad2
                    $filtroModalidad2
                    $filtroCarrera2
                    and f.codigoareadisciplinar = '".$row_area['codigoareadisciplinar']."'
                    and f.codigofacultad = '".$row_facultad['codigofacultad']."'
                    and ca.codigomodalidadacademicasic = '".$row_nivel['codigomodalidadacademicasic']."'";
                    $sel_carrera = $db->Execute($query_carrera);
                    $totalRows_carrera = $sel_carrera->RecordCount();
                    $arrayIzquierda['totalcarreras'] += $totalRows_carrera;
                    $arrayArea[$row_area['codigoareadisciplinar']]['totalcarreras'] += $totalRows_carrera;
                    $arrayFacultades[$row_facultad['codigofacultad']]['totalcarreras'] += $totalRows_carrera;
                    $arrayNiveles[$row_nivel['codigomodalidadacademicasic']]['totalcarreras'] += $totalRows_carrera;
                    unset($arrayCarreras);
                    while($row_carrera = $sel_carrera->FetchRow()) {
                        $arrayCarreras[$row_carrera['codigocarrera']]['nombrecarrera'] = $row_carrera['nombrecarrera'];
                    }
                    $arrayNiveles[$row_nivel['codigomodalidadacademicasic']]['carreras'] = $arrayCarreras;
                }
                $arrayFacultades[$row_facultad['codigofacultad']]['niveles'] = $arrayNiveles;
            }
            $arrayArea[$row_area['codigoareadisciplinar']]['facultades'] = $arrayFacultades;
        }
        $arrayIzquierda['areas'] = $arrayArea;
        return $arrayIzquierda;
    }

    function setArrayMatrizIzquierda($codigomodalidadacademicasic) {
        unset($this->arrayMatrizIzquierda);
        $this->arrayMatrizIzquierda['cuentacarreras'] = 0;
        $this->arrayMatrizIzquierda['cuentaareas'] = 0;
        $selArea = $this->selEsqueletoAreaDisciplinar($codigomodalidadacademicasic);
        $totalRows_selArea = $selArea->RecordCount();
        if($totalRows_selArea > 1) {
            $this->arrayMatrizIzquierda['cuentaareas'] += 1;
            while($row_selArea = $selArea->FetchRow()) {
                $this->arrayMatrizIzquierda['cuentacarreras'] += $row_selArea['cuentaCarrerasXArea'];
                if($row_selArea['cuentaCarrerasXArea'] > 1)
                    $this->arrayMatrizIzquierda['cuentaareas'] += 1;
            }
        }
        else if($totalRows_selArea == 1) {
                $this->arrayMatrizIzquierda['cuentaareas']++;
                $row_selArea = $selArea->FetchRow();
                if($row_selArea['cuentaCarrerasXArea'] > 1) {
                    $this->arrayMatrizIzquierda['cuentaareas']++;
                    $this->arrayMatrizIzquierda['cuentacarreras'] += $row_selArea['cuentaCarrerasXArea'];
                //print_r($this->arrayMatrizIzquierda);
                }
            //exit();

            }
    }

    function setMatrizIzquierda() {
        global $db;
        unset($this->arrayMatrizIzquierda);
        $query = "select m.codigomodalidadacademicasic, m.nombremodalidadacademicasic, a.codigoareadisciplinar, a.nombreareadisciplinar, ca.codigocarrera, ca.nombrecarrera
        from areadisciplinar a, facultad f, modalidadacademicasic m, carrera ca
        where a.codigoareadisciplinar = f.codigoareadisciplinar
        and m.codigomodalidadacademicasic = ca.codigomodalidadacademicasic
        and ca.codigofacultad = f.codigofacultad
        order by m.codigomodalidadacademicasic, a.codigoareadisciplinar";
        $sel = $db->Execute($query);
        $this->cuentaMatrizIzquierda = 0;
        while($row_sel = $sel->FetchRow()) {

            $this->arrayMatrizIzquierda['codigomodalidadacademicasic'][$i] = $row_sel['codigomodalidadacademicasic'];
            $this->arrayMatrizIzquierda['nombremodalidadacademicasic'][$i] = $row_sel['nombremodalidadacademicasic'];
            $this->arrayMatrizIzquierda['codigoareadisciplinar'][$i] = $row_sel['codigoareadisciplinar'];
            $this->arrayMatrizIzquierda['nombreareadisciplinar'][$i] = $row_sel['nombreareadisciplinar'];
            $this->arrayMatrizIzquierda['codigocarrera'][$i] = $row_sel['codigocarrera'];
            $this->arrayMatrizIzquierda['nombrecarrera'][$i] = $row_sel['nombrecarrera'];
            $this->cuentaMatrizIzquierda++;
        }
    //return $arrayMatrizIzquierda;
    }

    function getTotalDocentes() {
        global $db;
        if($this->obtenerDatosEnLinea) {
            $query = "SELECT count(distinct e.codigoestudiante) conteo
            FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
            WHERE o.numeroordenpago=d.numeroordenpago
            AND e.codigoestudiante=o.codigoestudiante
            AND c.codigocarrera=e.codigocarrera
            AND d.codigoconcepto=co.codigoconcepto
            AND co.cuentaoperacionprincipal='151'
            AND o.codigoestadoordenpago LIKE '4%'
            AND o.codigoperiodo='$this->codigoperiodo'";
        }
        else {
            $query = "select sum(a.conteo) as conteo
            from (SELECT count(distinct de.idestudiantegeneral) as conteo, e.codigocarrera
            FROM carrera c, facultad f, estadisticamatriculados e, detalleestadisticamatriculados de
            WHERE e.codigoperiodo='$this->codigoperiodo'
            and c.codigofacultad = f.codigofacultad
            and c.codigocarrera = e.codigocarrera
            and e.fechaestadisticamatriculados=date(now())
            and e.idestadisticamatriculados = de.idestadisticamatriculados
            group by 2) a";
        }
        $sel = $db->Execute($query);
        //$totalRows_sel = $sel->RecordCount();
        $row_sel = $sel->FetchRow();
        return $row_sel['conteo'];
    }

    function getSelNivelAcademico() {
        global $db;
        $query = "SELECT codigomodalidadacademicasic, nombremodalidadacademicasic
        FROM modalidadacademicasic
        where codigoestado like '1%'
        order by 1";
        $sel = $db->Execute($query);
        return $sel;
    }

    function setArrayModalidadAcademicaSic() {
        global $db;
        unset($this->arrayModalidadAcademicaSic);
        $query = "SELECT codigomodalidadacademicasic, nombremodalidadacademicasic
        FROM modalidadacademicasic
        where codigoestado like '1%'
        order by 1";
        $sel = $db->Execute($query);
        while($row_sel = $sel->FetchRow()) {
            $this->arrayModalidadAcademicaSic[$row_sel['codigomodalidadacademicasic']] = $row_sel['nombremodalidadacademicasic'];
        }
    }

    function setArrayAreaDisciplinar() {
        global $db;
        unset($this->arrayAreaDisciplinar);
        $query = "SELECT codigoareadisciplinar, nombreareadisciplinar
        FROM areadisciplinar
        order by 1";
        $sel = $db->Execute($query);
        while($row_sel = $sel->FetchRow()) {
            $this->arrayAreaDisciplinar[$row_sel['codigoareadisciplinar']] = $row_sel['nombreareadisciplinar'];
        }
    }

    function setFiltroCarreras() {
        global $db;
        //unset($this->filtroCarreras);
        $query = "select e.codigocarrera
        from estadisticodocente e, detalleestadisticodocente d
        where e.fechaestadisticodocente = date(now())
        and d.idestadisticodocente = e.idestadisticodocente
        and e.codigoperiodo = '$this->codigoperiodo'
        group by 1";
        $sel = $db->Execute($query);
        while($row_sel = $sel->FetchRow()) {
            $this->filtroCarreras .= $row_sel['codigocarrera'].",";
        }
        $this->filtroCarreras = ereg_replace(",$","",$this->filtroCarreras);
        $this->filtroCarreras = "in($this->filtroCarreras)";
    }

    function selEsqueletoAreaDisciplinar($codigomodalidadacademicasic) {
        global $db;
        //$db->debug = true;
        if($this->codigoareadisciplinar != "") {
            $filtroAreaDisciplinar = " and a.codigoareadisciplinar = '$this->codigoareadisciplinar' ";
        }
        if($this->codigocarrera != "") {
            $filtroCarrera = " and ca.codigocarrera = '$this->codigocarrera' ";
        }
        $query = "select m.codigomodalidadacademicasic, m.nombremodalidadacademicasic,
        a.codigoareadisciplinar, a.nombreareadisciplinar, count(*) cuentaCarrerasXArea
        from areadisciplinar a, facultad f, modalidadacademicasic m, carrera ca
        where a.codigoareadisciplinar = f.codigoareadisciplinar
        and m.codigomodalidadacademicasic = ca.codigomodalidadacademicasic
        and ca.codigofacultad = f.codigofacultad
        and ca.codigocarrera $this->filtroCarreras
        and ca.codigomodalidadacademicasic = '$codigomodalidadacademicasic'
            $filtroAreaDisciplinar
            $filtroCarrera
        group by 1, 3
        order by m.codigomodalidadacademicasic, a.codigoareadisciplinar";
        $sel = $db->Execute($query);
        return $sel;
    }

    function selEsqueletoCarrera($codigomodalidadacademicasic, $codigoareadisciplinar) {
        global $db;
        //$db->debug = true;
        if($this->codigocarrera != "") {
            $filtroCarrera = " and ca.codigocarrera = '$this->codigocarrera' ";
        }
        $query = "select ca.nombrecarrera, ca.codigocarrera
        from areadisciplinar a, facultad f, modalidadacademicasic m, carrera ca
        where a.codigoareadisciplinar = f.codigoareadisciplinar
        and m.codigomodalidadacademicasic = ca.codigomodalidadacademicasic
        and ca.codigofacultad = f.codigofacultad
        and ca.codigocarrera $this->filtroCarreras
        and ca.codigomodalidadacademicasic = '$codigomodalidadacademicasic'
        and f.codigoareadisciplinar = '$codigoareadisciplinar'
            $filtroCarrera
        order by 1";
        $sel = $db->Execute($query);
        return $sel;
    }

    /*
     *  Llena la tabla de estadisticamatriculados
     */
    function setTablaEstadisticaMatriculados() {
        global $db;
        $query="insert into estadisticamatriculados
        SELECT 0, ca.codigocarrera, o.codigoperiodo, date(now())
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera ca, concepto co
        WHERE o.numeroordenpago=d.numeroordenpago
        AND e.codigoestudiante=o.codigoestudiante
        AND ca.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal='151'
        AND o.codigoestadoordenpago LIKE '4%'
        group by ca.codigocarrera, o.codigoperiodo
        order by o.codigoperiodo, ca.codigocarrera";
        $sel = $db->Execute($query);
        /*"SELECT 0, ca.codigocarrera, o.codigoperiodo, count(distinct e.codigoestudiante) matriculados, date(now())
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera ca, concepto co
        WHERE o.numeroordenpago=d.numeroordenpago
        AND e.codigoestudiante=o.codigoestudiante
        AND ca.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal='151'
        AND o.codigoestadoordenpago LIKE '4%'
        group by ca.codigocarrera, o.codigoperiodo
        order by o.codigoperiodo, ca.codigocarrera";*/
        $query="insert into detalleestadisticamatriculados
        SELECT distinct 0, es.idestadisticamatriculados, e.idestudiantegeneral, 100
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera ca, concepto co, estadisticamatriculados es
        WHERE o.numeroordenpago=d.numeroordenpago
        AND e.codigoestudiante=o.codigoestudiante
        AND ca.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal='151'
        and es.codigocarrera = ca.codigocarrera
	and es.codigoperiodo = o.codigoperiodo
        AND o.codigoestadoordenpago LIKE '4%'
        order by o.codigoperiodo, ca.codigocarrera, e.idestudiantegeneral";
        $sel = $db->Execute($query);
    }

    function existesDatosEstaticos() {
        global $db;
        $query="SELECT *
        FROM estadisticamatriculados
        where fechaestadisticamatriculados = date(now())
        LIMIT 1";
        $sel = $db->Execute($query);
        $totalRows_sel = $sel->RecordCount();
        if($totalRows_sel > 0)
            return true;
        return false;
    }

    function getListaEstratos() {
        global $db;
        $query = "select concat('Estrato ',nombreestrato) tituloestrato
        from estrato
        order by 1";
        $sel = $db->Execute($query);
        $totalRows_sel = $sel->RecordCount();
        while($row_sel = $sel->FetchRow()) {
            $estratos[] = $row_sel['tituloestrato'];
        }
        $estratos[] = "No Registra";
        return $estratos;
    }

    function getListaEdades() {
        $edades[] = "Menor de 15 años";
        $edades[] = "15 a 20 años";
        $edades[] = "21 a 25 años";
        $edades[] = "26 a 30 años";
        $edades[] = "31 a 35 años";
        $edades[] = "36 a 40 años";
        $edades[] = "41 a 45 años";
        $edades[] = "Mayor de 45 años";
        return $edades;
    }

    function getListaGeneros() {
        global $db;
        $query = "select nombregenero
        from genero
        order by 1";
        $sel = $db->Execute($query);
        $totalRows_sel = $sel->RecordCount();
        while($row_sel = $sel->FetchRow()) {
            $generos[] = $row_sel['nombregenero'];
        }
        //$generos[] = "No Registra";
        return $generos;
    }

    function getListaNivelesEducativos() {
        global $db;
        $query = "select codigotiponivelacademico, nombretiponivelacademico
        from tiponivelacademico
        order by 1 desc";
        $sel = $db->Execute($query);
        $totalRows_sel = $sel->RecordCount();
        while($row_sel = $sel->FetchRow()) {
            $niveles[] = $row_sel['nombretiponivelacademico'];
        }
        $niveles[] = "No diligencia";
        return $niveles;
    }

    function getListaPuestoIcfes() {
        $icfes[] = "1 - 199";
        $icfes[] = "200 - 499";
        $icfes[] = "500 - 799";
        $icfes[] = "800 - 1000";
        $icfes[] = "Mayor a 1000";
        $icfes[] = "No registra";
        return $icfes;
    }

    function getListaNacionalidad() {
        $nacionalidad[] = "Extranjeros";
        $nacionalidad[] = "Nacionales";
        return $nacionalidad;
    }

    function getListaParticipacionAcademica() {
        global $db;
        $query = "SELECT nombretipoparticipacionacademicaestudiante
        FROM tipoparticipacionacademicaestudiante";
        $sel = $db->Execute($query);
        $totalRows_sel = $sel->RecordCount();
        while($row_sel = $sel->FetchRow()) {
            $participaciones[] = $row_sel['nombretipoparticipacionacademicaestudiante'];
        }
        $participaciones[] = "No registra";
        return $participaciones;
    }

    function getListaParticipacionInvestigacion() {
        $investigacion[] = "Linea de investigación";
        $investigacion[] = "No registra";
        return $investigacion;
    }

    function getListaProyeccionSocial() {
        global $db;
        $query = "SELECT nombretipoproyeccionsocialestudiante
        FROM tipoproyeccionsocialestudiante";
        $sel = $db->Execute($query);
        $totalRows_sel = $sel->RecordCount();
        while($row_sel = $sel->FetchRow()) {
            $participaciones[] = $row_sel['nombretipoproyeccionsocialestudiante'];
        }
        $participaciones[] = "No registra";
        return $participaciones;
    }

    function getListaParticipacionBienestar() {
        global $db;
        $query = "SELECT nombretipoparticipacionuniversitaria
        FROM tipoparticipacionuniversitaria";
        $sel = $db->Execute($query);
        $totalRows_sel = $sel->RecordCount();
        while($row_sel = $sel->FetchRow()) {
            $participaciones[] = $row_sel['nombretipoparticipacionuniversitaria'];
        }
        $participaciones[] = "No registra";
        return $participaciones;
    }

    function getListaParticipacionGobierno() {
        global $db;
        $query = "SELECT nombretipoconsejouniversidad
        FROM tipoconsejouniversidad
        where codigoestado like '1%'";
        $sel = $db->Execute($query);
        $totalRows_sel = $sel->RecordCount();
        while($row_sel = $sel->FetchRow()) {
            $participaciones[] = $row_sel['nombretipoconsejouniversidad'];
        }
        $participaciones[] = "No registra";
        return $participaciones;
    }

    function getListaAsociacion() {
        global $db;
        $query = "SELECT nombretipoasociaciondocente
        FROM tipoasociaciondocente";
        $sel = $db->Execute($query);
        $totalRows_sel = $sel->RecordCount();
        while($row_sel = $sel->FetchRow()) {
            $participaciones[] = $row_sel['nombretipoasociaciondocente'];
        }
        $participaciones[] = "No registra";
        return $participaciones;
    }

    function getListaParticipacionGestion() {
        global $db;
        $query = "SELECT nombretipoparticipaciongestionestudiante
        FROM tipoparticipaciongestionestudiante";
        $sel = $db->Execute($query);
        $totalRows_sel = $sel->RecordCount();
        while($row_sel = $sel->FetchRow()) {
            $participaciones[] = $row_sel['nombretipoparticipaciongestionestudiante'];
        }
        $participaciones[] = "No registra";
        return $participaciones;
    }

    function getListaReconocimiento() {
        $reconocimientos[] = "Reconocimientos";
        $reconocimientos[] = "No Registra";
        return $reconocimientos;
    }

    function getListaTipoFinanciacion() {
        global $db;
        $query = "SELECT nombretipoestudianterecursofinanciero
        FROM tipoestudianterecursofinanciero";
        $sel = $db->Execute($query);
        $totalRows_sel = $sel->RecordCount();
        while($row_sel = $sel->FetchRow()) {
            $financiaciones[] = $row_sel['nombretipoestudianterecursofinanciero'];
        }
        $financiaciones[] = "No diligencia";
        return $financiaciones;
    }

    function getListaEstadoEstudiante() {
        $estado[] = "Estudiante en acompañamiento";
        $estado[] = "Estudiante en situación academica normal";
        return $estado;
    }

    function getListaIdiomas() {
        global $db;
        $query = "SELECT nombreidioma
        FROM idioma";
        $sel = $db->Execute($query);
        $totalRows_sel = $sel->RecordCount();
        while($row_sel = $sel->FetchRow()) {
            $idioma[] = $row_sel['nombreidioma'];
        }
        $idioma[] = "No es bilingüe";
        return $idioma;
    }

    function getListaTics() {
        global $db;
        $query = "SELECT nombretipotecnologiainformacion
        FROM tipotecnologiainformacion";
        $sel = $db->Execute($query);
        $totalRows_sel = $sel->RecordCount();
        while($row_sel = $sel->FetchRow()) {
            $tics[] = $row_sel['nombretipotecnologiainformacion'];
        }
        $tics[] = "No registra";
        return $tics;
    }

    function getListaContrato() {
        global $db;
        $query = "select nombretipocontrato
	FROM  tipocontrato where codigoestado like '1%' ";
        $sel = $db->Execute($query);
        $totalRows_sel = $sel->RecordCount();
        while($row_sel = $sel->FetchRow()) {
            $contratos[] = $row_sel['nombretipocontrato'];
        }
        $contratos[] = "Sin contrato activo";
        return $contratos;
    }

    function getListaHistorico() {
        global $db;
        $query = "SELECT codigoperiodo
        FROM periodo
        where codigoperiodo > 20052
        order by 1";
        $sel = $db->Execute($query);
        $totalRows_sel = $sel->RecordCount();
        while($row_sel = $sel->FetchRow()) {
            $periodos[] = $row_sel['codigoperiodo'];
        }
        return $periodos;
    }

    function cuentaDocentes($arrayHistorico) {
        $totalDocentes = 0;
        foreach($arrayHistorico as $carreras) {
            $totalDocentes += array_sum($carreras);
        }
        return $totalDocentes;
    }

    function printArregloTD($arreglo, $atributos="") {
        foreach($arreglo as $nombre) {
            ?>
<td <?php echo $atributos; ?>><?php echo $nombre; ?></td>
        <?php
        }
    }

    function printArregloTotalesTD($arreglo, $arregloTotales, $total, $atributos="") {
        foreach($arreglo as $nombre) {
            ?>
<td <?php echo $atributos; ?>>
            <?php echo $this->getCalcularPorcentanje($arregloTotales[$nombre], $total); ?>
</td>
        <?php
        }
    }

    function getCalcularPorcentanje($totalParcial, $total) {
        if($totalParcial == 0) {
            $porcentaje = 0;
        }
        else {
            $porcentaje = number_format($totalParcial / $total * 100, 2);
        }
        return '<table border="0" width="100%" height="100%" cellspacing="1" cellpadding="0"><tr><td align="left">'.$totalParcial.'</td><td align="right">&nbsp;&nbsp;'.$porcentaje.'%</td></tr></table>';
        //return $totalParcial."|".$porcentaje."%";
    }
}
?>
