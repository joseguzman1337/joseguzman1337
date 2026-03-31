<?php

    function getIdsEstudiante($db, $idestudiante, $codigoestudiante, $inscripcionsession){
        if(isset($codigoestudiante)&&($codigoestudiante!="")){
            $query_estudiante = "select idestudiantegeneral,codigocarrera from estudiante ".
            " where codigoestudiante = '".$codigoestudiante."' ";
            $datosestudiante = $db->GetRow($query_estudiante);
            $idestudiantegeneral=$datosestudiante['idestudiantegeneral'];

            $query_inscripcion = "select idinscripcion from estudiantecarrerainscripcion ".
            " where idestudiantegeneral = '".$idestudiantegeneral."'  ".
            " AND codigocarrera='".$datosestudiante['codigocarrera']."' ".
            " AND codigoestado = '100' AND idnumeroopcion = '1' ".
            " ORDER BY idestudiantecarrerainscripcion DESC;";
            $datos = $db->GetRow($query_inscripcion);
            $idinscripcion=$datos['idinscripcion'];
        }else{
            echo "else $idestudiante";
            $idestudiantegeneral = $idestudiante;
            $idinscripcion = $inscripcionsession;
        }

        $return = new stdClass();
        $return->idestudiantegeneral = $idestudiantegeneral;
        $return->idinscripcion = $idinscripcion;
        return ($return);
    }//function getIdsEstudiante

    function getInfoEstudiante($db, $idestudiantegeneral){
        $query_datosgrabados = "SELECT * FROM detalleresultadopruebaestado d,resultadopruebaestado r ".
        " WHERE r.idestudiantegeneral = '".$idestudiantegeneral."' ".
        " and r.idresultadopruebaestado = d.idresultadopruebaestado ".
        " and d.codigoestado like '1%' ";
        $datosgrabados = $db->Execute($query_datosgrabados);
        $totalRows_datosgrabados = $datosgrabados->RecordCount();
        $row_datosgrabados = $datosgrabados->FetchRow();

        $return = new stdClass();

        $return->datosgrabados = $datosgrabados;
        $return->totalRows_datosgrabados = $totalRows_datosgrabados;
        $return->row_datosgrabados = $row_datosgrabados;

        return ($return);
    }

    function getInfoEstudianteCarrera($db, $idestudiantegeneral, $idinscripcion){
        $query_data = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad, ".
        " m.codigomodalidadacademica,i.idinscripcion ".
        " FROM estudiantegeneral eg ".
        " inner join inscripcion i on eg.idestudiantegeneral = i.idestudiantegeneral ".
        " inner join estudiantecarrerainscripcion e on eg.idestudiantegeneral = e.idestudiantegeneral ".
        " inner join carrera c on e.codigocarrera = c.codigocarrera ".
        " inner join modalidadacademica m on c.codigomodalidadacademica = m.codigomodalidadacademica ".
        " inner join ciudad ci on eg.idciudadnacimiento = ci.idciudad ".
        " WHERE eg.idestudiantegeneral = '".$idestudiantegeneral."' ".
        " AND eg.idestudiantegeneral = i.idestudiantegeneral AND i.idinscripcion = e.idinscripcion ".
        " AND e.idnumeroopcion = 1 and e.codigoestado = 100 AND eg.codigoestado = e.codigoestado ".
        " and i.codigoestado like '1%' AND i.idinscripcion = '".$idinscripcion."' ";
        $row_data = $db->GetRow($query_data);
    
        $return = new stdClass();
        $return->data = $row_data;
        $return->row_data = $row_data;
    
        return ($return);
    }//function getInfoEstudianteCarrera

    function getAsignaturas($db){
        $query_asignatura_base = "SELECT ae.idasignaturaestado, ae.nombreasignaturaestado, ae.puntajemaximoasignaturaestado,".
        " ae.puntajeminimoasignaturaestado, tpe.nombre as TipoPrueba, cpa.valor as CuentaProcesoAdmisiones, ".
        " ccb.valor as CuentaCompetenciaBasica ".
        " FROM asignaturaestado ae ".
        " INNER JOIN AsignaturaTipoPruebaEstado atpe ON (atpe.idAsignaturaPruebaEstado = ae.idasignaturaestado) ".
        " INNER JOIN TipoPruebaEstado tpe ON (tpe.id = atpe.idTipoPruebaEstado) ".
        " INNER JOIN AsignaturaCuentaProcesoAdmicion acpa ON (acpa.idAsignaturaPruebaEstado = ae.idasignaturaestado) ".
        " INNER JOIN CuentaProcesoAdmisiones cpa ON (cpa.id = acpa.idCuentaProcesoAdmisiones) ".
        " INNER JOIN AsignaturaCuentaCompetenciaBasica accb ON (accb.idAsignaturaPruebaEstado=ae.idasignaturaestado) ".
        " INNER JOIN CuentaCompetenciaBasica ccb ON (ccb.id=accb.idCuentaCompetenciaBasica) ";

        $query_asignatura = $query_asignatura_base.
        " WHERE tpe.nombre = '1' AND ae.idasignaturaestado IN ('7','2','5','8','3','1','6','4','9')";
        /////tipo de prueba nueva
        $query_asignatura2 = $query_asignatura_base." WHERE tpe.nombre = '2' ORDER BY 1";
        $query_asignatura3 = $query_asignatura_base." WHERE tpe.nombre = '3' ORDER BY 1";

        $asignatura = $db->Execute($query_asignatura);
        $asignatura2 = $db->Execute($query_asignatura2);
        $asignaturas2 = $db->Execute($query_asignatura2);
        $asignatura3 = $db->Execute($query_asignatura3);
        $asignaturas3 = $db->Execute($query_asignatura3);
        $totalRows_asignatura = $asignatura->RecordCount();
        $row_asignatura = $asignatura->FetchRow();
        $row_asignatura2 = $asignatura2->FetchRow();
        $row_asignaturas2 = $asignaturas2->FetchRow();
        $row_asignatura3 = $asignatura3->FetchRow();
        $row_asignaturas3 = $asignaturas3->FetchRow();

        $return = new stdClass();

        $return->asignatura = $asignatura;
        $return->asignatura2 = $asignatura2;
        $return->asignaturas2 = $asignaturas2;
        $return->asignatura3 = $asignatura3;
        $return->asignaturas3 = $asignaturas3;
        $return->totalRows_asignatura = $totalRows_asignatura;
        $return->row_asignatura = $row_asignatura;
        $return->row_asignatura2 = $row_asignatura2;
        $return->row_asignaturas2 = $row_asignaturas2;
        $return->row_asignatura3 = $row_asignatura3;
        $return->row_asignaturas3 = $row_asignaturas3;

        return ($return);
    }

    function getTipoDocumento($db){
        $query = "SELECT nombrecortodocumento, nombredocumento "
        . "FROM documento WHERE tipodocumento <> 0 "
        . "AND codigoestado='100'";
        $tipoDocumento = $db->GetAll($query);
        return $tipoDocumento;
    }//function getTipoDocumento

    function getDatosDocumentoAcutal($db, $codigoestudiante, $idestudiante, $numerodocumentosesion){
        $query = "SELECT eg.numerodocumento,d.tipodocumento,d.nombrecortodocumento,d.nombredocumento  "
                . "FROM estudiantegeneral eg "
                . "INNER JOIN documento d ON (d.tipodocumento = eg.tipodocumento) "
                . "INNER JOIN estudiante e ON (e.idestudiantegeneral = eg.idestudiantegeneral) " ;
        $where=null;
        if(!empty($idestudiante)){
            $where[] = "eg.idestudiantegeneral = '".$idestudiante."' ";
        }
        if(!empty($codigoestudiante)){
            $where[] = "e.codigoestudiante = '".$codigoestudiante."' ";
        }
        if(!empty($where)){
            $query .= "WHERE ".implode(" AND ",$where);
        }
        $datosDocumentoActual = $db->GetRow($query);

        return $datosDocumentoActual;
    }//function getDatosDocumentoAcutal

    function getEstadoActualizacionPIR($db, $numeroregistroresultadopruebaestado){
        $query = "SELECT rpe.actualizadoPir FROM resultadopruebaestado rpe "
                . "WHERE rpe.numeroregistroresultadopruebaestado = '".$numeroregistroresultadopruebaestado."'";
        $resultado = $db->Execute($query);
        $resultado = $resultado->FetchRow();
        return $resultado['actualizadoPir'];
        return 1;
    }//function getEstadoActualizacionPIR

    function desactivarRegistrosAnteriores($db, $idEstudianteGeneral, $actualizadoPir = 1){
        $idReturn = null;
        $ids = array();
        $query = "SELECT idresultadopruebaestado "
                . " FROM resultadopruebaestado "
                . " WHERE codigoestado = 100 "
                . " AND idestudiantegeneral = ".$idEstudianteGeneral
                . " AND actualizadoPir = ".$actualizadoPir
                . " ORDER BY idresultadopruebaestado ASC";
        $rows = $db->getAll($query);

        if(!empty($rows)){
            $count = count($rows)-1;
            foreach($rows as $r){
                $ids[] = $r['idresultadopruebaestado'];
            }
            if($actualizadoPir===0){
                unset($ids[$count]);
            }
            if(!empty($ids)){
                $update = "UPDATE resultadopruebaestado SET "
                        . " codigoestado = 200 "
                        . " WHERE idresultadopruebaestado IN (".implode(",",$ids).") ";
                $db->Execute($update);
                $update = "UPDATE detalleresultadopruebaestado SET "
                        . " codigoestado = 200 "
                        . " WHERE idresultadopruebaestado IN (".implode(",",$ids).") ";
                $db->Execute($update);
            }
        }
        if($actualizadoPir == 1){
            desactivarRegistrosAnteriores($db, $idEstudianteGeneral, 0);
            return 0;
        }

        $query = "SELECT idresultadopruebaestado "
                . " FROM resultadopruebaestado "
                . " WHERE codigoestado = 100 "
                . " AND idestudiantegeneral = ".$idEstudianteGeneral
                . " ORDER BY idresultadopruebaestado ASC";
        $row = $db->GetRow($query);

        if(!empty($row)){
            $idReturn = $row["idresultadopruebaestado"];
        }
        return $idReturn;
    }//function desactivarRegistrosAnteriores