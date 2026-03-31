<?php

    function getInfoEstudiante($db, $codigoestudiante, $idestudiante, $codigoinscripcion, $inscripcionsession){
        $query_carrera = "";
        if(isset($codigoestudiante) && !empty($codigoestudiante)){
            $query_estudiante = "select idestudiantegeneral,codigocarrera from estudiante ".
            " where codigoestudiante = '".$codigoestudiante."';";
            $datosestudiante = $db->GetRow($query_estudiante);
            $idestudiantegeneral=$datosestudiante['idestudiantegeneral'];
            $query_carrera = " AND c.codigocarrera=".$datosestudiante['codigocarrera'];
        }else{
            $idestudiantegeneral = $idestudiante;
        }

        $session_inscripcion="";
        if(!isset($codigoestudiante)&&(!$codigoestudiante!="")){
            $session_inscripcion=" AND i.idinscripcion = '".$inscripcionsession."'";
        }
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
        $query_carrera.
        " and e.codigoestado = 100 AND eg.codigoestado = e.codigoestado ".
        " and i.codigoestado like '1%' ".$session_inscripcion;
        $data = $db->GetRow($query_data);

        return ($data);
    }//function getInfoEstudiante


    function getFechaActual($db, $idestudiantegeneral){
        $query_datosgrab = "SELECT r.idresultadopruebaestado, a.TipoPrueba, r.fecharesultadopruebaestado ".
            " FROM resultadopruebaestado r "
        . " inner join detalleresultadopruebaestado d on r.idresultadopruebaestado = d.idresultadopruebaestado "
        . " inner join asignaturaestado a on d.idasignaturaestado = a.idasignaturaestado "
        . " WHERE r.idestudiantegeneral = '".$idestudiantegeneral."' "
        . " AND d.codigoestado = '100' AND r.codigoestado = d.codigoestado "
        . " group by a.TipoPrueba";
        $data = $db->GetRow($query_datosgrab);

        if(isset($data['fecharesultadopruebaestado']) && !empty($data['fecharesultadopruebaestado'])){
            $fechaActual=substr($data['fecharesultadopruebaestado'],0,10);
            if($fechaActual == '0000-00-00'){
                $queryupdate = "update resultadopruebaestado set fecharesultadopruebaestado = Now() ".
                " where idestudiantegeneral = '".$idestudiantegeneral."' ".
                " and idresultadopruebaestado = '".$data['idresultadopruebaestado']."' ".
                " AND codigoestado = '100'" ;
                $db->Execute($queryupdate);

                $sql = "select fecharesultadopruebaestado  from resultadopruebaestado ".
                " where idestudiantegeneral = '".$idestudiantegeneral."' ".
                " and idresultadopruebaestado = '".$data['idresultadopruebaestado']."' ".
                " AND codigoestado = '100' " ;
                $fecha = $db->GetRow($sql);
                $fechaActual= $fecha['fecharesultadopruebaestado'];
            }
        }else{
            $fechaActual = "";
        }

        return $fechaActual;
    }//function getFechaActual

function getNumeroRegistroAcActivo($db, $idestudiantegeneral){
    $query = "SELECT numeroregistroresultadopruebaestado FROM "
        . "resultadopruebaestado r  "
        . "WHERE r.idestudiantegeneral = '".$idestudiantegeneral."' "
        . "AND codigoestado=100 ";
    $datos = $db->Execute($query);
    $row = $datos->FetchRow();
    
    return($row['numeroregistroresultadopruebaestado']);
}

    function getDatosGrabados($db, $fechaActual, $date, $idestudiantegeneral, $tipoPrueba){
        $fech2 = '2014-07-31';
        $fech3 = '2012-01-01';
        $fech4 = '2016-03-01';

        $aplica_reclasificacion=0;
        if($fechaActual > $fech2){
            if($fechaActual > $fech4){
                $dataTipo=3;
            }else{
                $dataTipo=2;
            }
        }else{
            $dataTipo=1;
            if($fechaActual > $fech3){
                $aplica_reclasificacion=1;
            }
        }

        if(!empty($date)){
            if($date > $fech2){
                if($date > $fech4){
                    $dataTipo=3;
                }else{
                    $dataTipo=2;
                }
            }else{
                $dataTipo=1;
                if($date > $fech3){
                    $aplica_reclasificacion=1;
                }
            }
        }

        //limpieza de registros
        limpiezaDuplicados($db, $idestudiantegeneral);

        //consulta el registro de puebra
        $queryResultadoPruebSaber = "select r.idresultadopruebaestado, r.numeroregistroresultadopruebaestado, r.puestoresultadopruebaestado, ".
        " r.PuntajeGlobal, r.actualizadoPir, r.fecharesultadopruebaestado from resultadopruebaestado r ".
        " where r.idestudiantegeneral = '".$idestudiantegeneral."' and r.codigoestado = 100 ".
        " GROUP BY r.numeroregistroresultadopruebaestado";
        $row_Resultado = $db->GetRow($queryResultadoPruebSaber);

        //Sí existe un registro consulta los detalles de asignaturas activos
        if(!empty($row_Resultado['idresultadopruebaestado'])){
            $query_datosgrabados = "SELECT a.TipoPrueba, a.nombreasignaturaestado, a.idasignaturaestado, ".
                " d.notadetalleresultadopruebaestado,d.iddetalleresultadopruebaestado, d.nivel, d.decil "
                . " FROM detalleresultadopruebaestado d  "
                . " inner join asignaturaestado a on d.idasignaturaestado = a.idasignaturaestado "
                . " WHERE d.idresultadopruebaestado = '".$row_Resultado['idresultadopruebaestado']."' "
                . " AND d.codigoestado = '100' AND a.TipoPrueba in ('".$dataTipo."', '0' )"
                . "ORDER BY a.nombreasignaturaestado ";
            $row_datosgrabados= $db->GetAll($query_datosgrabados);

            if(empty($tipoPrueba)){
                if(!empty($dataTipo)){
                    $row_Resultado['TipoPrueba']=$dataTipo;
                }
            }else{
                $row_Resultado['TipoPrueba']=$tipoPrueba;
            }
        }

        $retunr = new stdClass();
        $retunr->dataTipo = $dataTipo;
        $retunr->aplica_reclasificacion = $aplica_reclasificacion;
        $retunr->datosgrabados = $row_Resultado;
        $retunr->row_datosgrabados = $row_datosgrabados;

        return ($retunr);
    }//function getDatosGrabados


    function getMateriasF($db, $dataTipo, $aplica_reclasificacion){
        $asignaturas2 = null ;
        $row_asignaturas2 = null ;

        $query = "SELECT ae.idasignaturaestado, ae.nombreasignaturaestado "
        . "FROM asignaturaestado ae "
        . "INNER JOIN AsignaturaTipoPruebaEstado atpe ON (atpe.idAsignaturaPruebaEstado = ae.idasignaturaestado) "
        . "INNER JOIN TipoPruebaEstado tpe ON (tpe.id = atpe.idTipoPruebaEstado) "
        . "WHERE tpe.nombre = '".$dataTipo."' ";
        $materias = $db->GetAll($query);
        $materiasF = array();

        if($aplica_reclasificacion){
            $query = "SELECT ae.idasignaturaestado, ae.nombreasignaturaestado "
            . "FROM asignaturaestado ae "
            . "INNER JOIN AsignaturaTipoPruebaEstado atpe ON (atpe.idAsignaturaPruebaEstado = ae.idasignaturaestado) "
            . "INNER JOIN TipoPruebaEstado tpe ON (tpe.id = atpe.idTipoPruebaEstado) "
            . "WHERE tpe.nombre = '2' ";
            $row_asignaturas2 = $db->GetAll($query);
        }

        foreach($materias as $materia){
            $materiasF[$materia["idasignaturaestado"]]["idasignaturaestado"] = $materia["idasignaturaestado"];
            $materiasF[$materia["idasignaturaestado"]]["nombreasignaturaestado"] = $materia["nombreasignaturaestado"];
        }//foreach

        $retunr = new stdClass();

        $retunr->materiasF = $materiasF;
        $retunr->asignaturas2 = $asignaturas2;
        $retunr->row_asignaturas2  = $row_asignaturas2 ;

        return ($retunr);
    }//function getMateriasF

    function getTipoDocumento($db){
        $query = "SELECT nombrecortodocumento, nombredocumento "
        . "FROM documento WHERE tipodocumento <> 0 AND codigoestado='100'";
        $tipoDocumento = $db->GetAll($query);
        return $tipoDocumento;
    }

    function getDatosDocumentoAcutal($db, $codigoestudiante, $idestudiante, $numerodocumentosesion, $ac){
        if(!empty($ac)){
            $query = "SELECT ed.numerodocumento, d.tipodocumento,d.nombrecortodocumento,d.nombredocumento "
            . " FROM resultadopruebaestado rpe "
            . " INNER JOIN estudiantedocumento ed ON (ed.idestudiantegeneral = rpe.idestudiantegeneral) "
            . " INNER JOIN documento d ON ( d.tipodocumento = ed.tipodocumento ) "
            . " INNER JOIN DocumentoPresentacionPruebaEstado dppe ON ( dppe.idEstudianteDocumento = ed.idestudiantedocumento "
            . " AND dppe.codigoEstado=1 ) "
            . " WHERE rpe.numeroregistroresultadopruebaestado = '".$ac."' AND rpe.codigoestado=100 ";
            if(!empty($idestudiante)){
                $query .= "AND ed.idestudiantegeneral = '".$idestudiante."' ";
            }
            $datosDocumentoActual = $db->GetRow($query);

            if(!isset($datosDocumentoActual['numerodocumento']) && empty($datosDocumentoActual['numerodocumento'])){
                $ac = 1;
            }
        }
        if($ac== 1){
            $query = "SELECT eg.numerodocumento,d.tipodocumento,d.nombrecortodocumento,d.nombredocumento  "
                . "FROM estudiantegeneral eg "
                . "INNER JOIN documento d ON (d.tipodocumento = eg.tipodocumento) "
                . "INNER JOIN estudiante e ON (e.idestudiantegeneral = eg.idestudiantegeneral) ";
            $where = null;
            if (!empty($idestudiante)) {
                $where[] = "eg.idestudiantegeneral = '" . $idestudiante . "' ";
            }
            if (!empty($codigoestudiante)) {
                $where[] = "e.codigoestudiante = '" . $codigoestudiante . "' ";
            }
            if (!empty($numerodocumentosesion)) {
                //$where[] = "eg.numerodocumento = '".$numerodocumentosesion."' ";
            }
            if (!empty($where)) {
                $query .= "WHERE " . implode(" AND ", $where);
            }
            $datosDocumentoActual = $db->GetRow($query);
        }

        return $datosDocumentoActual;
    }//function getDatosDocumentoAcutal

function getEstadoActualizacionPIR($db, $numeroregistroresultadopruebaestado){
    $query = "SELECT rpe.actualizadoPir FROM resultadopruebaestado rpe "
    . " WHERE rpe.numeroregistroresultadopruebaestado = '".$numeroregistroresultadopruebaestado."'";
    $resultado = $db->Execute($query);
    $resultado = $resultado->FetchRow();
    return $resultado['actualizadoPir'];
}

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
}

    function limpiezaDuplicados($db, $idestudiantegeneral){
        if(isset($idestudiantegeneral) && !empty($idestudiantegeneral)){
            $queryresultados = "select r.idresultadopruebaestado, r.numeroregistroresultadopruebaestado, ".
            " r.actualizadoPir, count(r.idresultadopruebaestado) as 'conteoR', ".
            " (select count(*) from detalleresultadopruebaestado d where ".
            " r.idresultadopruebaestado = d.idresultadopruebaestado and d.codigoestado = 100) as 'conteoD' ".
            " from resultadopruebaestado r where r.idestudiantegeneral = '".$idestudiantegeneral."' ".
            " and r.codigoestado = 100 group by r.numeroregistroresultadopruebaestado, r.actualizadoPir";
            $resultado = $db->GetAll($queryresultados);

            foreach($resultado as $idresultado){
                if($idresultado['conteoR'] > 1 ) {
                    $limiteresultado = $idresultado['conteoR'] - 1;
                    $queryupdateresultado = "update resultadopruebaestado r set r.codigoestado = 200 where " .
                    " r.idestudiantegeneral = '" . $idestudiantegeneral . "' and r.actualizadoPir = '".$idresultado['actualizadoPir']."'".
                    " and r.numeroregistroresultadopruebaestado='".$idresultado['numeroregistroresultadopruebaestado']."' ".
                    " and r.codigoestado = 100 ".
                    " and r.idresultadopruebaestado not in ( select d.idresultadopruebaestado from detalleresultadopruebaestado d ".
                    " where r.idresultadopruebaestado = d.idresultadopruebaestado ) ".
                    " limit " . $limiteresultado . " ";
                    $db->Execute($queryupdateresultado);
                }
                $queryasignaturas = "select idasignaturaestado, decil, notadetalleresultadopruebaestado, ".
                " count(*) as 'conteo' from detalleresultadopruebaestado ".
                " where idresultadopruebaestado = '".$idresultado['idresultadopruebaestado']."' ".
                " and codigoestado = 100 group by idasignaturaestado, decil";
                $conteo = $db->GetAll($queryasignaturas);

                if(count($conteo) > 0){
                    foreach ($conteo as $listado) {
                        if ($listado['conteo'] > 1) {
                            $limite = $listado['conteo'] - 1;
                            $queryupdate = "update detalleresultadopruebaestado set codigoestado = 200 " .
                            " where idresultadopruebaestado = '" . $idresultado['idresultadopruebaestado'] . "' ".
                            " and idasignaturaestado = '" . $listado['idasignaturaestado'] . "' " .
                            " and codigoestado = 100 limit " . $limite . " ";
                            $db->Execute($queryupdate);
                        }
                    }//foreach
                }
            }//foreach
        }
    }//function limpiezaDuplicados