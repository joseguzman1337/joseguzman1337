<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

// Selecciona toda la informacion del plan de estudio
function getQueryPlanEstudio($idplanestudio){
    return "select p.idplanestudio, p.nombreplanestudio, p.fechacreacionplanestudio,
        p.responsableplanestudio, p.cargoresponsableplanestudio, p.cantidadsemestresplanestudio,
        c.nombrecarrera, p.numeroautorizacionplanestudio, t.nombretipocantidadelectivalibre,
        p.cantidadelectivalibre, p.fechainioplanestudio, p.fechavencimientoplanestudio
        from planestudio p, carrera c, tipocantidadelectivalibre t
        where p.codigocarrera = c.codigocarrera
        and p.codigotipocantidadelectivalibre = t.codigotipocantidadelectivalibre
        and p.idplanestudio = '$idplanestudio'";
}

//Busca planes de estudios con estudiantes matriculados en primer semestre de carreras de pregrado y postgrado
function getQueryPlanesEstudioActivos($codigoperiodo){				
		return "SELECT x.*, COUNT(dp.codigomateria) as numMaterias, SUM(m.numerocreditos) as numCreditos
			  FROM (
			SELECT e.codigoestudiante, pr.semestreprematricula as semestre, pe.idplanestudio, 
					c.nombrecarrera, m.nombremodalidadacademica, c.codigomodalidadacademica, p.nombreplanestudio,
			   p.codigoestadoplanestudio, IF(rp.idlineaenfasisplanestudio IS NULL,'No','Si') as indicadorLinea, p.fechainioplanestudio 
					FROM ordenpago o 
			inner join detalleordenpago d on o.numeroordenpago=d.numeroordenpago
			inner join estudiante e on e.codigoestudiante=o.codigoestudiante
			inner join carrera c on  c.codigocarrera=e.codigocarrera AND c.codigomodalidadacademica IN (200,300) 
			inner join concepto co on d.codigoconcepto=co.codigoconcepto and co.cuentaoperacionprincipal=151
			inner join prematricula pr on e.codigoestudiante=pr.codigoestudiante AND pr.semestreprematricula=1
			inner join planestudioestudiante pe on e.codigoestudiante=pe.codigoestudiante 
			inner join modalidadacademica m on c.codigomodalidadacademica=m.codigomodalidadacademica 
			inner join planestudio p on  pe.idplanestudio=p.idplanestudio 
				left join detallelineaenfasisplanestudio rp on rp.idplanestudio=p.idplanestudio 
					WHERE 
				pr.codigoperiodo='$codigoperiodo'
					AND o.codigoperiodo='$codigoperiodo'
					AND o.codigoestadoordenpago LIKE '4%'
					AND e.codigoperiodo='$codigoperiodo'
					GROUP by pe.idplanestudio
			) x
			inner join detalleplanestudio dp on dp.idplanestudio=x.idplanestudio 
			inner join materia m on m.codigomateria=dp.codigomateria 
					GROUP by x.idplanestudio 
					ORDER BY x.codigomodalidadacademica ASC, x.nombrecarrera ASC";
}

function getQueryPlanesEstudio(){	
	return "SELECT x.*, COUNT(dp.codigomateria) as numMaterias, SUM(m.numerocreditos) as numCreditos
		  FROM (
		SELECT p.idplanestudio, c.nombrecarrera, m.nombremodalidadacademica, c.codigomodalidadacademica, p.nombreplanestudio,
		   p.codigoestadoplanestudio, IF(rp.idlineaenfasisplanestudio IS NULL,'No','Si') as indicadorLinea 
				FROM planestudio p
		inner join carrera c on c.codigocarrera=p.codigocarrera AND c.codigomodalidadacademica IN (200,300)  
		inner join modalidadacademica m on c.codigomodalidadacademica=m.codigomodalidadacademica 
		left join detallelineaenfasisplanestudio rp on rp.idplanestudio=p.idplanestudio 
				GROUP by p.idplanestudio 
		) x
		inner join detalleplanestudio dp on dp.idplanestudio=x.idplanestudio 
		inner join materia m on m.codigomateria=dp.codigomateria 
				GROUP by x.idplanestudio 
				ORDER BY x.codigomodalidadacademica ASC, x.nombrecarrera ASC";
}

function getQueryMateriasElectivas($idplanestudio){
	return "select IF(COUNT(dp.codigomateria) IS NULL,0,COUNT(dp.codigomateria)) as numMaterias,
			IF(SUM(m.numerocreditos) IS NULL,0,SUM(m.numerocreditos)) as numCreditos, '4' as codigotipomateria 
			from detalleplanestudio dp, materia m where dp.idplanestudio='$idplanestudio' 
			and m.codigomateria=dp.codigomateria AND dp.codigotipomateria=4
			UNION
			select IF(COUNT(dp.codigomateria) IS NULL,0,COUNT(dp.codigomateria)) as numMaterias,
			IF(SUM(m.numerocreditos) IS NULL,0,SUM(m.numerocreditos)) as numCreditos, 
			'5' as codigotipomateria 
			from detalleplanestudio dp, materia m where dp.idplanestudio='$idplanestudio' 
			and m.codigomateria=dp.codigomateria AND dp.codigotipomateria=5";
}

function getQueryListadoMateriasPlanesEstudiosPregrado($carreras=null){
	$selectCarreras="";
	if($carreras!=null){
		$selectCarreras=" AND c.codigocarrera IN (".$carreras.")";
	}

	return "SELECT p.idplanestudio, c.nombrecarrera, m.nombremodalidadacademica, c.codigomodalidadacademica, p.nombreplanestudio,
		   p.codigoestadoplanestudio, ma.nombremateria, c.codigocarrera, 
				ma.numerocreditos, dp.semestredetalleplanestudio, IF(rp.idlineaenfasisplanestudio IS NULL,'No','Si') as indicadorLinea,
		rp.codigomateriadetallelineaenfasisplanestudio, 
			IF(rp.codigomateriadetallelineaenfasisplanestudio IS NULL,NULL,lp.nombrelineaenfasisplanestudio) as linea, 
			m2.nombremateria as materia, m2.numerocreditos as creditos, ma.codigomateria,m2.codigomateria as codMateria 
				FROM planestudio p
		inner join carrera c on c.codigocarrera=p.codigocarrera AND c.codigomodalidadacademica IN (200)  ".$selectCarreras." 
		inner join modalidadacademica m on c.codigomodalidadacademica=m.codigomodalidadacademica 
			inner join detalleplanestudio dp on dp.idplanestudio=p.idplanestudio 
				inner join materia ma on ma.codigomateria=dp.codigomateria and ma.numerocreditos>=3 
		left join lineaenfasisplanestudio lp on lp.idplanestudio=p.idplanestudio and lp.codigoestadolineaenfasisplanestudio<>200 
				left join detallelineaenfasisplanestudio rp on rp.idlineaenfasisplanestudio=lp.idlineaenfasisplanestudio 
				and rp.codigoestadodetallelineaenfasisplanestudio<>200 and rp.codigomateria=ma.codigomateria
			left join materia m2 on m2.codigomateria=rp.codigomateriadetallelineaenfasisplanestudio 
			GROUP BY p.idplanestudio,ma.codigomateria,m2.codigomateria,linea
		ORDER BY c.nombrecarrera,p.idplanestudio,cast(dp.semestredetalleplanestudio AS UNSIGNED),ma.nombremateria";
}
?>
