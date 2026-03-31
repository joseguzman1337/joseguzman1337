<?php
//require_once('../../../kint/Kint.class.php');
	function getModalidades($db){
	
		$query = "SELECT DISTINCT m.codigomodalidadacademica,m.nombremodalidadacademica FROM modalidadacademica m 
                                        INNER JOIN carrera c on c.codigomodalidadacademica=m.codigomodalidadacademica and c.fechavencimientocarrera>NOW() 
										AND (c.EsAdministrativa=0 OR c.EsAdministrativa IS NULL)
                                        ORDER BY m.nombremodalidadacademica";
		return $db->Execute($query);
	}

	function getPeriodos($db){
	
		$query = "SELECT * FROM periodo ORDER BY codigoperiodo DESC";
		return $db->Execute($query);
	}

	function getEstudiantesExtranjeros($db,$modalidad,$tipo,$programa="",$periodo=""){
		$condicion = "";
		/*
		 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
		 * Cuando el codigo de programa sea 1 (todas las carreras) no se debe incluir esta validacion
		 * @since  January 10, 2017
		*/
		//if($programa!="" && $programa!=null){
		if($programa!="" && $programa!=null && $programa!=1){
			$condicion = " AND c.codigocarrera='".$programa."' ";
		}
		/* Fin Modificacion */
		
		$condicionP = " p.fechainicioperiodo<=CURDATE() AND p.fechavencimientoperiodo>=CURDATE() ";
		$condicionR = " INNER JOIN registrograduado rg ON rg.fechaactaregistrograduado>=p.fechainicioperiodo  AND rg.fechaactaregistrograduado<=p.fechavencimientoperiodo
						AND e.codigoestudiante=rg.codigoestudiante ";
		if($periodo!="" && $periodo!=null){
			$condicionP = " p.codigoperiodo='".$periodo."' ";
			if($periodo<20061){				
				$condicionR = " INNER JOIN registrograduadoantiguo rg ON rg.fechaactaregistrograduadoantiguo>=p.fechainicioperiodo 
				AND rg.fechaactaregistrograduadoantiguo<=p.fechavencimientoperiodo
						AND e.codigoestudiante=rg.codigoestudiante  ";
			} 
		}
		
		//d($tipo);
				
		switch ($tipo) {
			case 1:
			
				 $sql = "SELECT c.nombrecarrera,e.codigoperiodo, CONCAT(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) AS nombre_completo,
						d.nombrecortodocumento,eg.numerodocumento,pm.semestreprematricula,city.nombreciudad,eg.expedidodocumento,	
						Vc.Nombre as CategoriaVisa,
						V.NumeroVisa,
						V.NumeroVisaT,
						V.TipoPermiso,
						V.FechaExpedicion,
						V.FechaVencimiento
				FROM estudiantegeneral eg 
						INNER JOIN estudiante e ON e.idestudiantegeneral=eg.idestudiantegeneral AND e.codigosituacioncarreraestudiante<>400 
						INNER JOIN carrera c on c.codigocarrera=e.codigocarrera 
						INNER JOIN periodo p ON ".$condicionP." 
						INNER JOIN prematricula pm ON e.codigoestudiante=pm.codigoestudiante AND pm.codigoperiodo=p.codigoperiodo 
						INNER JOIN documento d ON d.tipodocumento=eg.tipodocumento  
						INNER JOIN ciudad city ON city.idciudad=eg.idciudadnacimiento 
						LEFT JOIN EstudianteVisa V ON e.idestudiantegeneral = V.idestudiantegeneral
						LEFT JOIN CategoriaVisa Vc ON Vc.CategoriaVisaId = V.CategoriaVisaId
						WHERE (eg.tipodocumento in ('03','05') OR eg.idciudadnacimiento in (2000) OR 
							(eg.tipodocumento='10' AND eg.expedidodocumento not in (select nombreciudad from ciudad where idciudad<>200 and codigoestado=100 )
							AND eg.expedidodocumento not in (select nombrecortociudad from ciudad where idciudad<>200 and codigoestado=100 ) 
							AND eg.expedidodocumento not like '%bogota%' 
							) 
						) AND pm.codigoestadoprematricula like '4%' 
						AND c.codigomodalidadacademica='".$modalidad."' ".$condicion." 
						ORDER BY c.nombrecarrera,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral";
						//d($sql);
						return $db->Execute($sql);     
				break;
			case 2:
				
				$sql = "SELECT c.nombrecarrera, e.codigoperiodo,CONCAT(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) AS nombre_completo,
						d.nombrecortodocumento,eg.numerodocumento,' ' as semestreprematricula,city.nombreciudad,eg.expedidodocumento,
						Vc.Nombre as CategoriaVisa,
						V.NumeroVisa,
						V.NumeroVisaT,
						V.TipoPermiso,
						V.FechaExpedicion,
						V.FechaVencimiento
				FROM estudiantegeneral eg 
						INNER JOIN estudiante e ON e.idestudiantegeneral=eg.idestudiantegeneral AND e.codigosituacioncarreraestudiante=400 
						INNER JOIN carrera c on c.codigocarrera=e.codigocarrera 
						INNER JOIN periodo p ON ".$condicionP." 
						INNER JOIN documento d ON d.tipodocumento=eg.tipodocumento  
						INNER JOIN ciudad city ON city.idciudad=eg.idciudadnacimiento 
						LEFT JOIN EstudianteVisa V ON e.idestudiantegeneral = V.idestudiantegeneral
						LEFT JOIN CategoriaVisa Vc ON Vc.CategoriaVisaId = V.CategoriaVisaId
						".$condicionR."  
						WHERE (eg.tipodocumento in ('03','05','10') OR eg.idciudadnacimiento in (2000)) 
						AND c.codigomodalidadacademica='".$modalidad."' ".$condicion." 
						ORDER BY c.nombrecarrera,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral";

						return $db->Execute($sql);     
				break;
			default:
				return false;
		}
	}
?>