<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php');
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    function getMateriasElectivasEnCurso($codigoestudiante,$codigocarrera,$db,$materias=true){
        $date = date('Y-m-d H:i:s');
        $sql="SELECT * FROM periodo WHERE fechainicioperiodo<='".$date."' 
            AND fechavencimientoperiodo>='".$date."'";
        $result = $db->GetRow($sql);
        $select = "SUM(m.numerocreditos) as creditos ";
        if($materias){
            $select = "dp.codigomateria,p.codigoperiodo,m.numerocreditos,
            m.nombremateria,m.codigoestadomateria";
        }
        //var_dump($sql);
        $sql="select $select from prematricula p
                inner join detalleprematricula dp on
                dp.idprematricula=p.idprematricula
                inner join materia m ON m.codigomateria=dp.codigomateria
                where p.codigoperiodo='".$result["codigoperiodo"]."'
                    AND p.codigoestudiante='".$codigoestudiante."' 
                  AND dp.codigoestadodetalleprematricula IN (10,30)
                AND p.codigoestadoprematricula IN (10,11,40,41) 
                AND m.codigomateria IN (
                    SELECT m.codigomateria FROM materia m
                    WHERE m.codigotipomateria=4 
                    AND m.codigocarrera='".$codigocarrera."' 
                    UNION
                    SELECT dg.codigomateria from grupomateria g 
                    join detallegrupomateria dg on dg.idgrupomateria=g.idgrupomateria
                                where codigotipogrupomateria like '1%' AND 
                                g.codigoperiodo='".$result["codigoperiodo"]."'                       
                )
                AND m.codigomateria NOT IN (
                        SELECT nh.codigomateria FROM notahistorico nh 
                        WHERE nh.codigoestudiante='".$codigoestudiante."' AND 
                        nh.codigoperiodo='".$result["codigoperiodo"]."'  
                        AND nh.codigoestadonotahistorico LIKE '%1%'
                    )";
        return $db->GetAll($sql);
    }

    function getEstudiantesPorGraduarse($codigofacultad,$codigocarrera,$db,$semestre,$array=false){
        $carrera = "";
        if(isset($codigocarrera) && $codigocarrera!="" && $codigocarrera!=null){
           $carrera = " AND c.codigocarrera = ".$codigocarrera;
        }

        //me lo pidieron desde sexto ahora
        $sql = "SELECT CONCAT(eg.nombresestudiantegeneral,' ', eg.apellidosestudiantegeneral) as nombre,
          eg.numerodocumento,e.codigoestudiante,c.codigocarrera,c.nombrecarrera,e.semestre,pe.idplanestudio,
          se.nombresituacioncarreraestudiante 
          FROM estudiante e 
          INNER JOIN estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral 
          INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera AND c.codigomodalidadacademica=200 
          and c.fechavencimientocarrera>NOW() 
          INNER JOIN planestudioestudiante pe ON pe.codigoestudiante=e.codigoestudiante AND pe.codigoestadoplanestudioestudiante!=200 
          INNER JOIN situacioncarreraestudiante se ON se.codigosituacioncarreraestudiante=e.codigosituacioncarreraestudiante 
          WHERE e.semestre+0>=".$semestre."  
          AND c.codigofacultad=".$codigofacultad." 
        AND e.codigosituacioncarreraestudiante NOT IN (100,101,102,103,109,400) $carrera 
        ORDER BY c.nombrecarrera ASC, e.semestre+0 DESC, nombre ASC ";

        if($array){
            $estudiantes = $db->GetAll($sql);
        } else {
            $estudiantes = $db->Execute($sql);
        }
      return $estudiantes;
    }

    function getCreditosElectivasPlanEstudio($codigoestudiante,$db=null,$returnQuery=false){
        //miro los creditos necesarios para el plan del estudiante
        $query_creditoselectivos = "SELECT SUM(dp.numerocreditosdetalleplanestudio) as creditos FROM planestudioestudiante pe 
                        INNER JOIN detalleplanestudio dp on dp.idplanestudio=pe.idplanestudio AND dp.codigotipomateria=4 
                        INNER JOIN materia m on m.codigomateria=dp.codigomateria 
                        WHERE pe.codigoestudiante='".$codigoestudiante."' AND pe.codigoestadoplanestudioestudiante!=200";
        if(!$returnQuery){
            $row_creditos = $db->GetRow($query_creditoselectivos);
            if(count($row_creditos)>0){
                $numCreditos = $row_creditos["creditos"];
            } else {
                $numCreditos = 0;
            }
            return $numCreditos;
        } else {
             return $query_creditoselectivos;
        }
    }

    function getQueryMateriasElectivasCPEstudiante($codigoestudiante, $creditos=false){
        $select[0] = "SELECT codigomateria,codigomateriaelectiva,notadefinitiva,
                    codigoperiodo,numerocreditos,nombremateria,
                    urlaarchivofinalcontenidoprogramatico
		,urlasyllabuscontenidoprogramatico
                ,idcontenidoprogramatico,
                    codigoindicadorcredito, ulasa, ulasb, ulasc FROM (";
        $select[1] = ") result 
					WHERE CONCAT(result.codigomateriaelectiva,'-',result.codigoperiodo) NOT IN (
						SELECT CONCAT(gml.codigomateria,'-',gml.codigoperiodo) FROM grupomaterialinea gml 
						INNER JOIN grupomateria gm on gm.idgrupomateria=gml.idgrupomateria and gm.codigotipogrupomateria='200' 
						INNER JOIN materia m on m.codigomateria=gml.codigomateria and m.codigotipomateria!=4 
						INNER JOIN carrera c on c.codigocarrera=m.codigocarrera 
						INNER JOIN estudiante e on e.codigocarrera=c.codigocarrera 
						WHERE e.codigoestudiante='".$codigoestudiante."' 
					) 
		GROUP BY result.codigomateria,result.codigoperiodo ORDER BY result.codigoperiodo ASC";
        if($creditos){
            $select[0] = "SELECT SUM(numerocreditos) as numerocreditos FROM ( ".$select[0];
            $select[1] = ") result 
					WHERE CONCAT(result.codigomateriaelectiva,'-',result.codigoperiodo) NOT IN (
						SELECT CONCAT(gml.codigomateria,'-',gml.codigoperiodo) FROM grupomaterialinea gml 
						INNER JOIN grupomateria gm on gm.idgrupomateria=gml.idgrupomateria and gm.codigotipogrupomateria='200' 
						INNER JOIN materia m on m.codigomateria=gml.codigomateria and m.codigotipomateria!=4 
						INNER JOIN carrera c on c.codigocarrera=m.codigocarrera 
						INNER JOIN estudiante e on e.codigocarrera=c.codigocarrera 
						WHERE e.codigoestudiante='".$codigoestudiante."' 
					) GROUP BY result.codigomateria,result.codigoperiodo) total";
        }


        //miro a ver si el estudiante debe alguna materia
            $materiasVistas = "$select[0] SELECT nh.codigomateria,nh.codigomateriaelectiva,nh.notadefinitiva,
                    nh.codigoperiodo,m.numerocreditos,m.nombremateria,
                    cp.urlaarchivofinalcontenidoprogramatico
		,cp.urlasyllabuscontenidoprogramatico
                ,cp.idcontenidoprogramatico, 
				m.codigoindicadorcredito, m.ulasa, m.ulasb, m.ulasc  FROM notahistorico nh 
                INNER join materia m on m.codigomateria=nh.codigomateria AND nh.notadefinitiva>=m.notaminimaaprobatoria 
                left join contenidoprogramatico cp on m.codigomateria=cp.codigomateria 
                 AND cp.codigoperiodo=nh.codigoperiodo AND cp.codigoestado=100 
                INNER join materia me on me.codigomateria=nh.codigomateriaelectiva 
                INNER join ( select dg.codigomateria, g.codigoperiodo
                                from grupomateria g join detallegrupomateria dg on dg.idgrupomateria=g.idgrupomateria
                                where codigotipogrupomateria like '1%' 
                        ) as sub on sub.codigomateria=m.codigomateria AND sub.codigoperiodo=nh.codigoperiodo 
                WHERE nh.codigoestudiante='".$codigoestudiante."' AND (me.codigotipomateria IN (4,5) OR m.codigotipomateria IN (4))
                    AND nh.codigoestadonotahistorico like '1%' 
					AND nh.codigomateriaelectiva NOT IN (
						SELECT dp.codigomateria from detalleplanestudio dp 
						inner join planestudioestudiante pe 
						on pe.codigoestudiante='".$codigoestudiante."' 
						and pe.codigoestadoplanestudioestudiante like '1%'
						where 
						pe.idplanestudio=dp.idplanestudio and dp.codigotipomateria=1
					)
                UNION
                select nh.codigomateria,nh.codigomateriaelectiva,nh.notadefinitiva,
                    nh.codigoperiodo,dp.numerocreditosdetalleplanestudio as numerocreditos,m.nombremateria,
                    cp.urlaarchivofinalcontenidoprogramatico
		,cp.urlasyllabuscontenidoprogramatico
                ,cp.idcontenidoprogramatico, 
					m.codigoindicadorcredito, m.ulasa, m.ulasb, m.ulasc  from materia m 
                    INNER join notahistorico nh on m.codigomateria=nh.codigomateria 
                    INNER JOIN planestudioestudiante pe ON pe.codigoestudiante=nh.codigoestudiante 
                    INNER JOIN detalleplanestudio dp on dp.idplanestudio=pe.idplanestudio AND dp.codigotipomateria=4 
                    AND dp.codigomateria=m.codigomateria
                    left join contenidoprogramatico cp on m.codigomateria=cp.codigomateria 
                    AND cp.codigoperiodo=nh.codigoperiodo AND cp.codigoestado=100 
                    where (m.codigotipomateria=4) 
                    and nh.codigoestudiante='".$codigoestudiante."' and nh.codigoestadonotahistorico like '1%' 
                    AND nh.codigomateriaelectiva=1 
                   UNION
                    select nh.codigomateria,nh.codigomateriaelectiva,nh.notadefinitiva,
                    nh.codigoperiodo,m.numerocreditos,m.nombremateria,
                    cp.urlaarchivofinalcontenidoprogramatico
		,cp.urlasyllabuscontenidoprogramatico
                ,cp.idcontenidoprogramatico, 
				m.codigoindicadorcredito, m.ulasa, m.ulasb, m.ulasc  from  notahistorico nh 
                    INNER join materia m on m.codigomateria=nh.codigomateria AND nh.notadefinitiva>=m.notaminimaaprobatoria 
                    left join contenidoprogramatico cp on m.codigomateria=cp.codigomateria 
                    AND cp.codigoperiodo=nh.codigoperiodo AND cp.codigoestado=100 
                    WHERE nh.codigoestudiante='".$codigoestudiante."' AND nh.codigomateriaelectiva!=1 AND nh.codigotipomateria IN (4)
                    AND nh.codigoestadonotahistorico like '1%' 
					AND nh.codigomateriaelectiva NOT IN (
						SELECT dp.codigomateria from detalleplanestudio dp 
						inner join planestudioestudiante pe 
						on pe.codigoestudiante='".$codigoestudiante."' 
						and pe.codigoestadoplanestudioestudiante like '1%'
						where 
						pe.idplanestudio=dp.idplanestudio and dp.codigotipomateria=1
					)
                 UNION
                 select nh.codigomateria,nh.codigomateriaelectiva,nh.notadefinitiva,
                    nh.codigoperiodo,m.numerocreditos,m.nombremateria,
                    cp.urlaarchivofinalcontenidoprogramatico
		,cp.urlasyllabuscontenidoprogramatico 
                ,cp.idcontenidoprogramatico, 
					m.codigoindicadorcredito, m.ulasa, m.ulasb, m.ulasc   FROM notahistorico nh 
                    INNER JOIN estudiante e ON e.codigoestudiante=nh.codigoestudiante 
                    INNER join materia m on m.codigomateria=nh.codigomateria AND nh.notadefinitiva>=m.notaminimaaprobatoria 
                    AND m.codigocarrera=e.codigocarrera AND m.codigotipomateria IN (4)
                    left join contenidoprogramatico cp on m.codigomateria=cp.codigomateria 
                    AND cp.codigoperiodo=nh.codigoperiodo AND cp.codigoestado=100 
                    WHERE nh.codigoestudiante='".$codigoestudiante."'  
                    AND nh.codigoestadonotahistorico like '1%'  
					$select[1]";
            return $materiasVistas;
    }


?>
