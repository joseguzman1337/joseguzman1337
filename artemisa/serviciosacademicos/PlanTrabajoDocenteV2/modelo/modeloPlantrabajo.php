<?php 
include(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));
class planTrabajoModelo{	
	public function mdlDocente($periodo){
		$db=Factory::createDbo();
	    $sql="
			SELECT a.iddocente,
			       a.apellidodocente,
			       a.nombredocente,
			       a.numerodocumento,
			       a.emaildocente,
			       SUM(HorasEvaluacion)            AS HorasEvaluacion,
			       SUM(HorasInnovar)               AS horasInnovar,
			       SUM(HorasTIC)                   AS horasTIC,
			       SUM(HorasPAE)                   AS horasPAE,
			       SUM(HorasTaller)                AS horasTaller,
			       SUM(HorasAsesoria)              AS horasAsesoria,
			       SUM(HorasPreparacion)           AS horasPreparacion,
			       SUM(HorasPresencialesPorSemana) AS hPresencialesPorSemana,
			       SUM(totalHoras)                 AS totalHoras,
			       programas 					   AS programas,
			       Carrera_id
			FROM docente a,
			     (
			         SELECT iddocente,
			                'ENSENANZA',
			                SUM(HorasEvaluacion)                       AS HorasEvaluacion,
			                SUM(HorasInnovar)                          AS HorasInnovar,
			                SUM(HorasTIC)                              AS HorasTIC,
			                SUM(HorasPAE)                              AS HorasPAE,
			                SUM(HorasTaller)                           AS HorasTaller,
			                SUM(HorasAsesoria)                         AS HorasAsesoria,
			                SUM(HorasPreparacion)                      AS HorasPreparacion,
			                SUM(HorasPresencialesPorSemana)            AS horasPresencialesPorSemana,
			                SUM(HorasPresencialesPorSemana + HorasPreparacion + HorasEvaluacion + HorasAsesoria + HorasTIC +
			                    HorasInnovar + HorasTaller + HorasPAE) AS totalHoras,
			                1                                          AS orden,
			                c.nombrecarrera                            AS programas,
			                c.codigocarrera                            AS Carrera_id
			         FROM PlanesTrabajoDocenteEnsenanza pl
			                  INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
			         WHERE codigoestado = 100
			           AND pl.codigoperiodo = '".$periodo."'
			         GROUP BY pl.iddocente, c.codigocarrera
			         UNION ALL
			         SELECT iddocente,
			                'OTROS',
			                0                   AS HorasEvaluacion,
			                0                   AS HorasInnovar,
			                0                   AS HorasTIC,
			                0                   AS HorasPAE,
			                0                   AS HorasTaller,
			                0                   AS HorasAsesoria,
			                0                   AS HorasPreparacion,
			                0                   AS horasPresencialesPorSemana,
			                SUM(HorasDedicadas) AS totalHoras,
			                2                   AS orden,
			                c.nombrecarrera     AS programas,
			                c.codigocarrera     AS Carrera_id
			         FROM PlanesTrabajoDocenteOtros pl
			                  INNER JOIN VocacionPlanesTrabajoDocentes v
			                             ON v.VocacionesPlanesTrabajoDocenteId = pl.VocacionesPlanesTrabajoDocenteId
			                  INNER JOIN carrera c ON c.codigocarrera = pl.codigocarrera
			         WHERE pl.codigoestado = 100
			           AND pl.codigoperiodo = '".$periodo."'
			         GROUP BY pl.iddocente, c.codigocarrera
			     ) b
			WHERE a.iddocente = b.iddocente

			GROUP BY a.iddocente,
			         a.apellidodocente,
			         a.nombredocente,
			         a.numerodocumento, Carrera_id
			ORDER BY a.apellidodocente,
			         a.nombredocente;
	    ";
		//$consulta = $db->Execute($sql);
		return $db->GetAll($sql);
	}
	public  function mdlConsultaHoras($periodo,$iddocente){
		$db=Factory::createDbo();
		 $sql="SELECT
                    SUM(HorasDedicadas) as hvocacionDescubrimiento,tip.VocacionesPlanesTrabajoDocenteId
                    FROM
                            PlanesTrabajoDocenteOtros tra
                    JOIN TiposPlanesTrabajoDocenteOtros tip ON tra.TipoPlanTrabajoDocenteOtrosId = tip.TipoPlanTrabajoDocenteOtrosId
                    WHERE
                     tip.VocacionesPlanesTrabajoDocenteId in (1,2,3,4)
                    AND tra.iddocente = '". $iddocente ."'
                    AND tra.codigoestado = 100
                    AND codigoperiodo = '".$periodo."'
                    AND TipoHoras = 'CONTRATO'    
                    group by tip.VocacionesPlanesTrabajoDocenteId ";
        $rs=$db->GetAll($sql);
        $totalHorasEstrictas=$horasInvF = $horasEstrictas = $horasConsultoriaExterna = $horasSupervisionPractica = $horasEducacionContinuada= 0;
        $arrayHoras= array();
        foreach ($rs as $key => $value) {
	        switch ($value["VocacionesPlanesTrabajoDocenteId"]) {
	        	case 1:
	        		$horasFormativas = $horasInvF + $value["hvocacionDescubrimiento"];
	        		break;
	        	case 2:
	        		$horasEstrictas = $horasEstrictas + $value["hvocacionDescubrimiento"];
	        		break;
	        	case 3:
	        		$horasSupervisionPractica = $horasSupervisionPractica + $value["hvocacionDescubrimiento"];
	        		break;
	        	case 4:
	        		$horasConsultoriaExterna = $horasConsultoriaExterna + $value["hvocacionDescubrimiento"];
	        		break;        		        		        		
	        	case 5:
	        		$horasEducacionContinuada = $horasEducacionContinuada + $value["hvocacionDescubrimiento"];
	        		break;
	        	default:
	        		$horasInvF = $horasInvEstricta = $horasConsultoriaExterna = $horasSupervisionPractica = $horasEducacionContinuada= 0;
	        		break;
	        }
	        $totalHorasEstrictas + $horasEstrictas;
	       
        }
      //  echo $totalHorasEstrictas;
    $arrayHoras = array(
    "horasFormativas"  => $horasInvF,
    "horasEstrictas" => $horasEstrictas,
    "horasSupervisionPractica" => $horasSupervisionPractica, 
	"horasConsultoriaExterna" => $horasConsultoriaExterna,
	"horasEducacionContinuada"  => $horasEducacionContinuada  
    );


     return $arrayHoras;
	}

	public static function mdlVocacion2($periodo,$iddocente){
		$db=Factory::createDbo();
		$sql="SELECT
                    SUM(HorasDedicadas) as HorasDedicadasCompromiso
                    FROM
                            PlanesTrabajoDocenteOtros tra
                    JOIN TiposPlanesTrabajoDocenteOtros tip ON tra.TipoPlanTrabajoDocenteOtrosId = tip.TipoPlanTrabajoDocenteOtrosId
                    WHERE
                     tip.VocacionesPlanesTrabajoDocenteId = 3
                    AND tra.iddocente = '". $iddocente ."'
                    AND tra.codigoestado = 100
                    AND codigoperiodo = '".$periodo."'
                    AND TipoHoras = 'CONTRATO'    
                    LIMIT 1 ";
        $rs=$db->GetRow($sql);
       	if ($rs["HorasDedicadasCompromiso"]!="") {
       		$HorasDedicadasCompromiso = $rs["HorasDedicadasCompromiso"];
       	}else{
       		$HorasDedicadasCompromiso=0;
       	}
        return $HorasDedicadasCompromiso;
	}
	public static function mdlGestionAcademica($periodo,$iddocente){
		$db=Factory::createDbo();
            $sql = 'SELECT
                            SUM(HorasDedicadas) as HorasDedicadasGestionAcademica
                    FROM
                            PlanesTrabajoDocenteOtros tra
                    JOIN TiposPlanesTrabajoDocenteOtros tip ON tra.TipoPlanTrabajoDocenteOtrosId = tip.TipoPlanTrabajoDocenteOtrosId
                    WHERE
                            tip.VocacionesPlanesTrabajoDocenteId = 4
                    AND tra.iddocente = ' . $iddocente . '
                    AND tra.codigoestado = 100
                    AND codigoperiodo = ' . $periodo . '
                    AND TipoHoras = "CONTRATO"    
                    LIMIT 1';
        $rs=$db->GetRow($sql);
       	if ($rs["HorasDedicadasGestionAcademica"]!="") {
       		$HorasDedicadasGestionAcademica = $rs["HorasDedicadasGestionAcademica"];
       	}else{
       		$HorasDedicadasGestionAcademica=0;
       	}
        return $HorasDedicadasGestionAcademica;
	}		
}
?>