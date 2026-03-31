<?php
	function queryAprobadorMateria($idMateria){
		return $query="select	 idaprobador
						,IF(uf.emailusuariofacultad IS NULL OR uf.emailusuariofacultad='', concat(u.usuario,'@unbosque.edu.co'), uf.emailusuariofacultad) as emailaprobador
						,concat(apellidos,' ',nombres) as nombreaprobador
						,nombremateria
					from aprobadoresmodificacionnotas a 
					join usuario u on a.idaprobador=u.idusuario
					join materia m using(codigocarrera)
					left join usuariofacultad uf on uf.usuario=u.usuario and m.codigocarrera=uf.codigofacultad and uf.codigoestado=100
					where codigomateria=".$idMateria;
	}
	
	function queryAprobadorCarrera($codigocarrera){
		return $query="select idaprobador
			,IF(uf.emailusuariofacultad IS NULL OR uf.emailusuariofacultad='', concat(u.usuario,'@unbosque.edu.co'), uf.emailusuariofacultad) as emailaprobador
			,concat(apellidos,' ',nombres) as nombreaprobador 
		from aprobadoresmodificacionnotas a
		join usuario u on a.idaprobador=u.idusuario 
		left join usuariofacultad uf on uf.usuario=u.usuario and a.codigocarrera=uf.codigofacultad and uf.codigoestado=100
		where codigocarrera=".$codigocarrera;
	}
	
	function queryAprobadorSolicitud($idSolicitud){
		return "select   eg.numerodocumento
						,eg.apellidosestudiantegeneral
						,eg.nombresestudiantegeneral
						,s.fechasolicitud
						,s.notamodificada
						,IF(uf.emailusuariofacultad IS NULL OR uf.emailusuariofacultad='', concat(u.usuario,'@unbosque.edu.co'), uf.emailusuariofacultad) as emailaprobador
						,concat(u.apellidos,' ',u.nombres) as nombreaprobador
						,observaciones
						,ma.nombremateria
						,c.nombrecarrera
					from solicitudaprobacionmodificacionnotas s
					join estudiante e using(codigoestudiante)
					join estudiantegeneral eg using(idestudiantegeneral)
					join materia ma using(codigomateria) 
					join carrera c on ma.codigocarrera=c.codigocarrera 
					join aprobadoresmodificacionnotas a on a.codigocarrera=ma.codigocarrera
					join usuario u on a.idaprobador=u.idusuario 
					left join usuariofacultad uf on uf.usuario=u.usuario and ma.codigocarrera=uf.codigofacultad and uf.codigoestado=100
					where s.id=".$idSolicitud;
	}
	
	function queryAprobadorCodigoEstudiante($codigoestudiante){
		return "select idaprobador
				,IF(uf.emailusuariofacultad IS NULL OR uf.emailusuariofacultad='', concat(u.usuario,'@unbosque.edu.co'), uf.emailusuariofacultad) as emailaprobador
				,concat(apellidos,' ',nombres) as nombreaprobador
			from aprobadoresmodificacionnotas a 
			join usuario u on a.idaprobador=u.idusuario 
			join (select codigocarrera from estudiante where codigoestudiante=".$codigoestudiante.") sub 
			left join usuariofacultad uf on uf.usuario=u.usuario and sub.codigocarrera=uf.codigofacultad and uf.codigoestado=100
			WHERE a.codigocarrera=sub.codigocarrera";
	}
?>