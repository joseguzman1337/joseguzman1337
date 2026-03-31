<?php

    // Seleccion de las materias que tiene matriculados un estudiante y tienen horarios 
    // (y requieren horario and g.codigoindicadorhorario=100 )
    function getMateriasMatriculadas($codigoestudiante,$codigoperiodo,$db){
        $query_materiasestudiante = "SELECT d.codigomateria, d.codigomateriaelectiva, edp.nombreestadodetalleprematricula, d.idgrupo, 
        d.numeroordenpago, m.nombremateria 
                        FROM detalleprematricula d, prematricula p, materia m, estudiante e, estadodetalleprematricula edp, grupo g 
                        where d.codigomateria = m.codigomateria 
                        and d.idprematricula = p.idprematricula
                        and p.codigoestudiante = e.codigoestudiante
                        and e.codigoestudiante = '$codigoestudiante' 
                        and g.idgrupo=d.idgrupo 
                        and edp.codigoestadodetalleprematricula = d.codigoestadodetalleprematricula
                        and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
                        and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula = '23')
                        and p.codigoperiodo = '$codigoperiodo'";
        return $db->GetAll($query_materiasestudiante);
    }
    
    function getHorarioGrupo($idgrupo,$db){
        $query_datoshorarios = "select d.codigodia, d.nombredia, h.horainicial, h.horafinal, s.nombresalon, s.codigosalon, se.codigosede
					from horario h, dia d, salon s, sede se
					where h.codigodia = d.codigodia
					and h.codigosalon = s.codigosalon
					and h.idgrupo = '$idgrupo'
					and s.codigosede = se.codigosede
                                        and h.codigoestado=100 
					order by 1,3,4";
        return $db->GetAll($query_datoshorarios);
    }
    
    function getDatosEsutdiante($codigoestudiante,$db){
        $query_datoshorarios = "select eg.numerodocumento,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral 
                                from estudiantegeneral eg
				inner join estudiante e on e.idestudiantegeneral=eg.idestudiantegeneral 
                where e.codigoestudiante = '$codigoestudiante'";
        return $db->GetRow($query_datoshorarios);
    }
    
    //Revisa si se cruzan los horarios
    function intersectCheck($from, $from_compare, $to, $to_compare){
	$from = strtotime($from);
	$from_compare = strtotime($from_compare);
	$to = strtotime($to);
	$to_compare = strtotime($to_compare);
	$intersect = min($to, $to_compare) - max($from, $from_compare);
		if ( $intersect < 0 ) $intersect = 0;
		$overlap = $intersect / 3600;
		if ( $overlap <= 0 ):
			// There are no time conflicts
			return TRUE;
			else:
			// There is a time conflict
			// echo '<p>There is a time conflict where the times overlap by ' , $overlap , ' hours.</p>';
			return FALSE;
		endif;
    }
?>
