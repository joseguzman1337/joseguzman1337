<?php

function clasificarEstudiantes($db, $estudiantes, $totalEstudiantesCohorte, $getPromedio = false, $conSituacion = false) {
    $estudiantesClasificados = array();
    $estudiantesClasificados["graduados"] = array();
    $estudiantesClasificados["sinGrado"] = array();
    for ($i = 0; $i < $totalEstudiantesCohorte; $i++) {
        $codigoestudiante = $estudiantes[$i]['codigoestudiante'];
        $sql = "SELECT e.codigosituacioncarreraestudiante as situacion, rg.fechagradoregistrograduado, 
                rga.fechagradoregistrograduadoantiguo, A.FechaAcuerdo, e.codigoestudiante, e.semestre
                FROM estudiante e 
                LEFT JOIN registrograduadoantiguo rga on rga.codigoestudiante=e.codigoestudiante 
                LEFT JOIN registrograduado rg on rg.codigoestudiante=e.codigoestudiante AND rg.codigoestado = 100 
                LEFT JOIN RegistroGrado R ON e.codigoestudiante = R.EstudianteId AND R.CodigoEstado = 100
		LEFT JOIN AcuerdoActa A ON (A.AcuerdoActaId = R.AcuerdoActaId)
                WHERE e.codigoestudiante='" . $codigoestudiante . "'";
        $result = $db->GetRow($sql);

        if (intval($result["situacion"]) == 400) {
            if (isset($result["fechagradoregistrograduado"]) && $result["fechagradoregistrograduado"] != null && $result["fechagradoregistrograduado"] != "") {
                $periodo = periodo($db, $result["fechagradoregistrograduado"]);
            } else if (isset($result["fechagradoregistrograduadoantiguo"]) && $result["fechagradoregistrograduadoantiguo"] != null && $result["fechagradoregistrograduadoantiguo"] != "") {
                $periodo = periodo($db, $result["fechagradoregistrograduadoantiguo"]);
            } else if (isset($result["FechaAcuerdo"]) && $result["FechaAcuerdo"] != null && $result["FechaAcuerdo"] != "") {
                $periodo = periodo($db, $result["FechaAcuerdo"]);
            }
            if (!$getPromedio) {
                if ($conSituacion) {
                    $estudiantesClasificados["graduados"][$periodo]["cantidad"] += 1;
                    $estudiantesClasificados["graduados"][$periodo]["situacion"] = 400;
                } else {
                    $estudiantesClasificados["graduados"][$periodo] += 1;
                }
            } else {
                $estudiantesClasificados["graduados"][$periodo]["cantidad"] += 1;
                $estudiantesClasificados["graduados"][$periodo]["semestres"] += $result["semestre"];
                if ($conSituacion) {
                    $estudiantesClasificados["graduados"][$periodo]["situacion"] = 400;
                }
            }
        } else {
            //pendiente de grado, perdida calidad, desertor, matriculado
            if (intval($result["situacion"]) == 100) {
                if ($conSituacion) {
                    $estudiantesClasificados["desertores"]["Perdida de la Calidad de Estudiante Académica"]["cantidad"] += 1;
                    $estudiantesClasificados["desertores"]["Perdida de la Calidad de Estudiante Académica"]["situacion"] = 100;
                } else {
                    $estudiantesClasificados["desertores"]["Perdida de la Calidad de Estudiante Académica"] += 1;
                }
            } else if (intval($result["situacion"]) == 101) {
                if ($conSituacion) {
                    $estudiantesClasificados["desertores"]["Perdida de la Calidad de Estudiante Disciplinaria"]["cantidad"] += 1;
                    $estudiantesClasificados["desertores"]["Perdida de la Calidad de Estudiante Disciplinaria"]["situacion"] = 101;
                } else {
                    $estudiantesClasificados["desertores"]["Perdida de la Calidad de Estudiante Disciplinaria"] += 1;
                }
            } else if (intval($result["situacion"]) == 102) {
                if ($conSituacion) {
                    $estudiantesClasificados["desertores"]["Perdida de la Calidad de Estudiante Administrativa"]["cantidad"] += 1;
                    $estudiantesClasificados["desertores"]["Perdida de la Calidad de Estudiante Administrativa"]["situacion"] = 102;
                } else {
                    $estudiantesClasificados["desertores"]["Perdida de la Calidad de Estudiante Administrativa"] += 1;
                }
            } else if (intval($result["situacion"]) == 103) {
                if ($conSituacion) {
                    $estudiantesClasificados["desertores"]["Perdida de la Calidad de Estudiante Voluntaria"]["cantidad"] += 1;
                    $estudiantesClasificados["desertores"]["Perdida de la Calidad de Estudiante Voluntaria"]["situacion"] = 103;
                } else {
                    $estudiantesClasificados["desertores"]["Perdida de la Calidad de Estudiante Voluntaria"] += 1;
                }
            } else if (intval($result["situacion"]) == 110 || intval($result["situacion"]) == 104) {
                if ($conSituacion) {
                    $estudiantesClasificados["sinGrado"]["En proceso de grado"]["cantidad"] += 1;
                    $estudiantesClasificados["sinGrado"]["En proceso de grado"]["situacion"] = "110,104";
                } else {
                    $estudiantesClasificados["sinGrado"]["En proceso de grado"] += 1;
                }
            } else {
                $today = date("Y-m-d");
                $periodo = periodo($db, $today);

                $sql = "SELECT idprematricula,codigoperiodo,semestreprematricula FROM prematricula WHERE codigoestudiante='" . $codigoestudiante . "' 
                    AND codigoperiodo='" . $periodo . "' AND codigoestadoprematricula IN (40,41,51)";

                $matricula = $db->GetRow($sql);
                if (count($matricula) > 0) {
                    //esta matriculado
                    if ($conSituacion) {
                        $estudiantesClasificados["sinGrado"]["Matriculados"]["cantidad"] += 1;
                        $estudiantesClasificados["sinGrado"]["Matriculados"]["situacion"] = 1;
                    } else {
                        $estudiantesClasificados["sinGrado"]["Matriculados"] += 1;
                    }
                } else {
                    if ($conSituacion) {
                        $estudiantesClasificados["desertores"]["Desertores No Clasificados"]["cantidad"] += 1;
                        $estudiantesClasificados["desertores"]["Desertores No Clasificados"]["situacion"] = 0;
                    } else {
                        $estudiantesClasificados["desertores"]["Desertores No Clasificados"] += 1;
                    }
                }
            }
        }
    }
    ksort($estudiantesClasificados["sinGrado"]);
    return $estudiantesClasificados;
}

function discriminarEstudiantes($db, $estudiantes, $totalEstudiantesCohorte, $situaciones, $grado = null) {
    $estudiantesDiscriminados = array();
    for ($i = 0; $i < $totalEstudiantesCohorte; $i++) {
        $codigoestudiante = $estudiantes[$i]['codigoestudiante'];
        $sql = "SELECT e.codigosituacioncarreraestudiante as situacion, rg.fechagradoregistrograduado, 
                rga.fechagradoregistrograduadoantiguo, A.FechaAcuerdo, e.codigoestudiante, e.semestre, 
                CONCAT(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre,
                eg.numerodocumento, eg.emailestudiantegeneral,eg.telefonoresidenciaestudiantegeneral,
                eg.celularestudiantegeneral, MAX(pr.codigoperiodo) as ultimo_periodo,
                IF(p1.codigoperiodo IS NULL, IF( p2.codigoperiodo IS NULL, p3.codigoperiodo, p2.codigoperiodo), p1.codigoperiodo) as grado
                FROM estudiante e 
                INNER JOIN estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral
                INNER JOIN prematricula pr on pr.codigoestudiante=e.codigoestudiante and pr.codigoestadoprematricula in (40,41)
                LEFT JOIN registrograduadoantiguo rga on rga.codigoestudiante=e.codigoestudiante 
                LEFT JOIN registrograduado rg on rg.codigoestudiante=e.codigoestudiante AND rg.codigoestado = 100 
                LEFT JOIN RegistroGrado R ON e.codigoestudiante = R.EstudianteId AND R.CodigoEstado = 100
                LEFT JOIN AcuerdoActa A ON (A.AcuerdoActaId = R.AcuerdoActaId)                                        
                LEFT JOIN periodo p1 on rga.fechagradoregistrograduadoantiguo BETWEEN p1.fechainicioperiodo AND p1.fechavencimientoperiodo
                LEFT JOIN periodo p2 on rg.fechagradoregistrograduado BETWEEN p2.fechainicioperiodo AND p2.fechavencimientoperiodo
                LEFT JOIN periodo p3 on A.FechaAcuerdo BETWEEN p3.fechainicioperiodo AND p3.fechavencimientoperiodo
                WHERE e.codigoestudiante='" . $codigoestudiante . "'";
        $result = $db->GetRow($sql);
        foreach ($situaciones as $situacion) {

            if ($situacion == 1 || $situacion == 0) {

                $today = date("Y-m-d");
                $periodo = periodo($db, $today);

                $sql = "SELECT idprematricula,pr.codigoperiodo,semestreprematricula,pr.codigoestudiante,e.codigosituacioncarreraestudiante
                        FROM prematricula pr 								
                        inner join estudiante e on e.codigoestudiante=pr.codigoestudiante 
                        WHERE pr.codigoestudiante='" . $codigoestudiante . "' 
                        AND pr.codigoperiodo='" . $periodo . "' AND pr.codigoestadoprematricula IN (40,41,51) 
                        AND e.codigosituacioncarreraestudiante NOT IN (400,100,103,104)";
                $matricula = $db->GetRow($sql);
                if (count($matricula) > 0 && $situacion == 1) {
                    $estudiantesDiscriminados[] = $result;
                } else if (count($matricula) == 0 && $situacion == 0 && intval($result["situacion"]) != 104 && intval($result["situacion"]) != 110 && intval($result["situacion"]) != 103 && intval($result["situacion"]) != 102 && intval($result["situacion"]) != 100 && intval($result["situacion"]) != 101 && intval($result["situacion"]) != 300 && intval($result["situacion"]) != 400) {
                    $estudiantesDiscriminados[] = $result;
                }
            } else if (intval($result["situacion"]) == $situacion) {
                if ($situacion == 400) {
                    if ($result["grado"] == $grado) {
                        $estudiantesDiscriminados[] = $result;
                    }
                } else {
                    $estudiantesDiscriminados[] = $result;
                }
            }
        }
    }
    return $estudiantesDiscriminados;
}

function periodo($db, $fecha) {
    $sql = "SELECT codigoperiodo FROM periodo WHERE '" . $fecha . "' BETWEEN  fechainicioperiodo AND fechavencimientoperiodo";
    $period = $db->GetRow($sql);
    $periodo = $period["codigoperiodo"];
    return $periodo;
}

?>
