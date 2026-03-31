<?php
	function hayVotaciones($sala){
		$query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, v.fechafinalvotacion, ". 
		" v.fechainiciovigenciacargoaspiracionvotacion,  fechafinalvigenciacargoaspiracionvotacion  ".
		" FROM votacion v WHERE v.codigoestado=100 ".
		" AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion";
		$votaciones=$sala->query($query_votacion);
		$arrayVotaciones = array();
		$row_operacion=$votaciones->fetchRow();
		do{
			$arrayVotaciones[]=$row_operacion;
		}
		while($row_operacion=$votaciones->fetchRow());
	
		$hayVotaciones = false;
		if(count($arrayVotaciones)>0 && $arrayVotaciones[0]!=""){
			$hayVotaciones = true;
		}
		
		return $hayVotaciones;
	}

	function getVotaciones($sala){
		$query="select * from votacion where codigoestado=100 ORDER BY fechafinalvotacion DESC, nombrevotacion ASC";
        $votaciones=$sala->query($query);
		$arrayVotaciones = array();
		$row_operacion=$votaciones->fetchRow();
		do{
			$arrayVotaciones[]=$row_operacion;
		}
		while($row_operacion=$votaciones->fetchRow());
		
		return json_encode($arrayVotaciones );
	}
	
	function getDatosVotacion($sala,$id){
		$query="select * from votacion where idvotacion=".$id;
        $votaciones=$sala->query($query);
		$row=$votaciones->fetchRow();
		
		return $row;
	}
	
	function getDatosFacultades($sala){
		$query="select codigofacultad,nombrefacultad from facultad where codigoestado=100 ORDER BY nombrefacultad ASC";
        $facultades=$sala->query($query);
		$arrayFacultades = array();
		$row_operacion=$facultades->fetchRow();
		do{
			$arrayFacultades[]=$row_operacion;
		}
		while($row_operacion=$facultades->fetchRow());
		
		return $arrayFacultades;
	}
	
	function getPlantillasVotacion($sala,$idvotacion){
		$query="SELECT distinct tpv.* FROM tipoplantillavotacion tpv,plantillavotacion pv ".
		" WHERE tpv.codigoestado=100 and tpv.idtipoplantillavotacion=pv.idtipoplantillavotacion ".
		" and pv.idvotacion=".$idvotacion;
				
		$votaciones=$sala->query($query);
		$arrayVotaciones = array();
		$row_operacion=$votaciones->fetchRow();
		do{
			$arrayVotaciones[]=$row_operacion;
		}
		while($row_operacion=$votaciones->fetchRow());
		
		return $arrayVotaciones;
	}
	
	function getVotoTipoPlantilla($sala,$idvotacion,$idtipo){
		$query = "SELECT COUNT(vv.idplantillavotacion) as votos, p.nombreplantillavotacion, c.nombrecarrera, dp.idcargo, ".
		" CONCAT(cv.nombrescandidatovotacion,' ',cv.apellidoscandidatovotacion) as nombrePrincipal,  ".
		" CONCAT(cvs.nombrescandidatovotacion,' ',cvs.apellidoscandidatovotacion) as nombreSuplente  ".
		" FROM votosvotacion vv  ".
		" INNER JOIN plantillavotacion p on p.idplantillavotacion=vv.idplantillavotacion  ".
		" INNER JOIN detalleplantillavotacion dp on dp.idplantillavotacion=p.idplantillavotacion and dp.idcargo!=3 ".
		" INNER JOIN candidatovotacion cv on cv.idcandidatovotacion=dp.idcandidatovotacion  ".
		" INNER JOIN carrera c on c.codigocarrera=p.codigocarrera  ".
		" LEFT JOIN detalleplantillavotacion dps on dps.idplantillavotacion=dp.idplantillavotacion and dps.idcargo=3 ".
		" LEFT JOIN candidatovotacion cvs on cvs.idcandidatovotacion=dps.idcandidatovotacion  ".
		" WHERE vv.codigoestado=100  ".
		" AND p.idtipoplantillavotacion='".$idtipo."' AND p.idvotacion=".$idvotacion." ".
		" GROUP BY vv.idplantillavotacion ORDER BY dp.idcargo DESC, votos DESC";
		$votos=$sala->query($query);
		$arrayVotos = array();
		$row=$votos->fetchRow();
		do{
			$arrayVotos[]=$row;
		}
		while($row=$votos->fetchRow());
			
		return $arrayVotos;
	}
	
	function getCarrerasFacultad($sala,$codigofacultad){
		$query="select codigocarrera,nombrecarrera from carrera where codigofacultad='".$codigofacultad."' ORDER BY nombrecarrera ASC";

        $facultades=$sala->query($query);
		$arrayFacultades = array();
		$row_operacion=$facultades->fetchRow();
		do{
			$arrayFacultades[]=$row_operacion;
		}
		while($row_operacion=$facultades->fetchRow());
		
		return $arrayFacultades;
	}
	
	function getVotoPorCarrera($sala,$idvotacion,$idtipo,$codigocarrera){
		$query = "SELECT c.idcandidatovotacion, CONCAT(c.nombrescandidatovotacion, ' ',c.apellidoscandidatovotacion, ' ', c.numerodocumentocandidatovotacion ) AS nombrePrincipal, ".
		" IF ( d.idcargo = 2, 'Principal', 'Suplente' ) AS Tipocargo, d.idcargo, p.nombreplantillavotacion,d.idplantillavotacion, v.idvotosvotacion, p.codigocarrera, ".				 
		" k.nombrecarrera, COUNT(v.idvotosvotacion) AS votos, CONCAT( cvs.nombrescandidatovotacion, ' ', cvs.apellidoscandidatovotacion ) AS nombreSuplente ".
		" FROM candidatovotacion c ".		
		" INNER JOIN detalleplantillavotacion d ON c.idcandidatovotacion = d.idcandidatovotacion AND d.idcargo !=3 ".
		" INNER JOIN plantillavotacion p ON p.idplantillavotacion = d.idplantillavotacion AND p.codigocarrera = $codigocarrera  ".
		" INNER JOIN carrera k ON k.codigocarrera = p.codigocarrera ". 
		" LEFT JOIN votosvotacion v ON v.idplantillavotacion = d.idplantillavotacion ".
		" LEFT JOIN detalleplantillavotacion dps ON dps.idplantillavotacion = d.idplantillavotacion AND dps.idcargo = 3 ".
		" LEFT JOIN candidatovotacion cvs ON cvs.idcandidatovotacion = dps.idcandidatovotacion ".
		" WHERE c.codigoestado = 100 AND d.codigoestado = 100 AND ( v.codigoestado = 100 OR v.codigoestado IS NULL ) ".
		" AND p.idvotacion = ".$idvotacion."  and p.idtipoplantillavotacion = '".$idtipo."' ".
		" GROUP BY c.idcandidatovotacion,v.idplantillavotacion";		
		$votos=$sala->query($query);
		$arrayVotos = array();
		$row=$votos->fetchRow();
		do{
			$arrayVotos[]=$row;
		}
		while($row=$votos->fetchRow());
			
		return $arrayVotos;
	}
	
	function getVotacionesActuales($sala){
		$fechaInicio = date("Y")."-".date("m")."-01 00:00:00";
		$fechaFin = date("Y")."-".date("m")."-31 00:00:00";
		$query="select idvotacion from votacion where codigoestado=100 and fechainiciovotacion>='".$fechaInicio."'  ".
		" and fechafinalvotacion<='".$fechaFin."'  ".
		" ORDER BY fechafinalvotacion DESC, nombrevotacion ASC";
        $votaciones=$sala->query($query);
		$arrayVotaciones = array();
		$row_operacion=$votaciones->fetchRow();
		do{
			$arrayVotaciones[]=$row_operacion;
		}
		while($row_operacion=$votaciones->fetchRow());
		
		return $arrayVotaciones;
	}
?>
