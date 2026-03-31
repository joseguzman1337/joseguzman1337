<?php

function ubicaciones($db, $coperiodo)
{
    $ubicaciones = "SELECT ic.InstitucionConvenioId, ic.NombreInstitucion, ui.IdUbicacionInstitucion, ui.NombreUbicacion FROM RotacionEstudiantes re
                            INNER JOIN InstitucionConvenios ic ON ic.InstitucionConvenioId = re.IdInstitucion
                            INNER JOIN UbicacionInstituciones ui ON ui.InstitucionConvenioId = ic.InstitucionConvenioId
                            where ic.InstitucionConvenioId <> 0 and re.codigoperiodo = '".$coperiodo."' GROUP BY IdInstitucion desc";
    $listaubicaciones = $db->GetAll($ubicaciones);
    return $listaestudiantes;
}

function estudiantesrotacion($db, $coperiodo, $posicion)
{
     $sqlestudiantes = "SELECT e.numerodocumento, e.idestudiantegeneral, e.nombresestudiantegeneral, e.apellidosestudiantegeneral, r.FechaIngreso, r.FechaEgreso,            	r.Totalhoras, r.TotalDias, r.codigocarrera, r.idsiq_convenio, er.NombreEstado,      	r.JornadaId,
                        	r.codigomateria,
                        	ui.DomicilioUbicacion,
                        	r.RotacionEstudianteId,
                        	r.codigoperiodo,
                        	r.codigoestudiante                        
                        FROM
                        	Convenios c
                        INNER JOIN RotacionEstudiantes r ON r.idsiq_convenio = c.ConvenioId
                        INNER JOIN InstitucionConvenios i ON i.InstitucionConvenioId = r.IdInstitucion
                        INNER JOIN UbicacionInstituciones ui ON ui.InstitucionConvenioId = i.InstitucionConvenioId
                        INNER JOIN estudiante es ON es.codigoestudiante = r.codigoestudiante
                        INNER JOIN estudiantegeneral e ON e.idestudiantegeneral = es.idestudiantegeneral
                        INNER JOIN EstadoRotaciones er ON er.EstadoRotacionId = r.EstadoRotacionId
                        WHERE
                        r.codigoperiodo = '".$coperiodo."' 
                        and	r.IdUbicacionInstitucion = '".$posicion['IdUbicacionInstitucion']."'
                        and i.InstitucionConvenioId = '".$posicion['InstitucionConvenioId']."'
                        GROUP BY 
                        RotacionEstudianteId
                        ORDER BY
                        codigocarrera DESC";                                           
                     $listaestudiantes = $db->GetAll($sqlestudiantes);
    return $listaestudiantes; 
}

function datosestudiante($db, $estudiante)
{
     $sqlestudiante = "SELECT
                        	e.semestre,
                        	e.codigoperiodo,
                        	e.numerocohorte,
                        	e.codigoestudiante,
                        	eg.nombresestudiantegeneral,
                        	eg.apellidosestudiantegeneral,
                        	eg.numerodocumento
                        FROM
                        	estudiante e,
                        	estudiantegeneral eg
                        WHERE
                        	e.idestudiantegeneral = '".$estudiante['idestudiantegeneral']."'
                        AND e.codigocarrera = '".$estudiante['codigocarrera']."'
                        AND eg.idestudiantegeneral = e.idestudiantegeneral"; 
    $valoresestduiante = $db->GetRow($sqlestudiante);
    echo $sqlestudiante; die;
    return $valoresestduiante;
}

function creditos($db, $valoresestduiante)
{
    $sqlcreditos = "SELECT
                        	sum(
                        		d.numerocreditosdetalleplanestudio
                        	) AS totalcreditossemestre,
                        	d.idplanestudio
                        FROM
                        	detalleplanestudio d,
                        	planestudioestudiante p
                        WHERE
                        	d.idplanestudio = p.idplanestudio
                        AND p.codigoestudiante = '".$valoresestduiante['codigoestudiante']."'
                        AND d.semestredetalleplanestudio = '".$valoresestduiante['semestre']."'
                        AND p.codigoestadoplanestudioestudiante LIKE '1%'
                        AND d.codigotipomateria NOT LIKE '4'
                        AND d.codigotipomateria NOT LIKE '5'";
    $numerocreditos = $db->GetRow($sqlcreditos); 
    return $numerocreditos;
}

function valorsemestre($db, $coperiodo, $valoresestduiante, $estudiante)
{
    $sqlvalorsemestre= "SELECT
                                	dc.valordetallecohorte,
                                	cc.codigomodalidadacademica,
                                    cc.nombrecarrera
                                FROM
                                	cohorte c
                                INNER JOIN detallecohorte dc ON dc.idcohorte = c.idcohorte
                                INNER JOIN carrera cc ON cc.codigocarrera = c.codigocarrera
                                WHERE
                                	c.codigoperiodo = '".$coperiodo."'
                                AND dc.codigoconcepto = '151'
                                AND dc.semestredetallecohorte = '".$valoresestduiante['semestre']."'
                                AND c.codigocarrera = '".$estudiante['codigocarrera']."'"; 
    $valorsemestre= $db->GetRow($sqlvalorsemestre);   
    return $valorsemestre;
}
function  diassemestre($db, $coperiodo, $estudiante)
{
    $sqltotaldiassemestre = "SELECT g.fechainiciogrupo, g.fechafinalgrupo, m.numerocreditos, m.nombremateria 
                                FROM grupo g, materia m 
                                WHERE g.codigoperiodo='".$coperiodo."' and g.codigomateria='".$estudiante['codigomateria']."' and m.codigomateria = g.codigomateria";
    $dias_semestre = $db->GetRow($sqltotaldiassemestre ); 
    return $dias_semestre;
}

function contraprestacion ($db, $estudiante)
{
    $sqlcontraprestacion = "SELECT 	c.ValorContraprestacion, c.IdTipoPagoContraprestacion FROM Contraprestaciones c INNER JOIN Convenios co ON co.ConvenioId = c.ConvenioId WHERE c.ConvenioId = '".$estudiante['idsiq_convenio']."' AND c.codigoestado = '100' AND c.IdTipoPracticante = '".$tipopracticante."'";
    $valorcontrapestacion = $db->GetRow($sqlcontraprestacion);
    return $valorcontrapestacion;
}
?>