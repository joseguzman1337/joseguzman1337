<?php

class estadisticasSeguimiento extends obtener_datos_matriculas {

	var $codigoperiodo;
	var $arrayCarreras;
	var $conexion;
	var $fechahoy;
	var $arrayInteresados;
	var $arrayInteresadosSinSeguimiento;
	var $arrayInteresadosConSeguimiento;
	var $arrayAspirantes;
	var $arrayAspirantesConSeguimiento;
	var $arrayAspirantesSinSeguimiento;
	var $inf; //variable que determina el tipo de informe
	var $arrayDatosBasicos;

	function estadisticasSeguimiento($codigoperiodo,$codigomodalidadacademica,$codigocarrera,$inf=null,&$conexion){
		$this->conexion=$conexion;
		$this->codigoperiodo=$codigoperiodo;
		$this->fechahoy=date("Y-m-d H:i:s");
		$this->inf=$inf;
		$this->arrayCarreras=$this->leerCarreras($codigomodalidadacademica,$codigocarrera);
		obtener_datos_matriculas::obtener_datos_matriculas($conexion,$codigoperiodo);
		if($inf==null){
			$this->arrayInteresados=$this->leerInteresados('conteo');
			$this->arrayInteresadosSinSeguimiento=$this->leeInteresadosSinSeguimiento('conteo');
			$this->arrayInteresadosConSeguimiento=$this->leeInteresadosConSeguimiento('conteo');
			$this->arrayAspirantes=$this->leerAspirantes('conteo');
			$this->arrayAspirantesSinSeguimiento=$this->leeSeguimientoAspirantes(false,'conteo');
			$this->arrayAspirantesConSeguimiento=$this->leeSeguimientoAspirantes(true,'conteo');
		}
		else{
			switch ($inf){
				case 'interesados_total':
					$this->arrayInteresados=$this->leerInteresados('arreglo');
					break;
				case 'interesados_con_seg':
					$this->arrayInteresadosConSeguimiento=$this->leeInteresadosConSeguimiento('arreglo');
					break;
				case 'interesados_sin_seg':
					$this->arrayInteresadosSinSeguimiento=$this->leeInteresadosSinSeguimiento('arreglo');
					break;
				case 'aspirantes_total':
					$this->arrayAspirantes=$this->leerAspirantes('arreglo');
					break;
				case 'aspirantes_con_seg':
					$this->arrayAspirantesConSeguimiento=$this->leeSeguimientoAspirantes(true,'arreglo');
					break;
				case 'aspirantes_sin_seg':
					$this->arrayAspirantesSinSeguimiento=$this->leeSeguimientoAspirantes(false,'arreglo');
					break;
			}
			$arrayDetalle=$this->leeDatosBasicos($inf);
		}
	}

	function leeDatosBasicos($inf){
		switch ($inf){
			case 'interesados_total':
				if(is_array($this->arrayInteresados)){
					foreach ($this->arrayCarreras as $llave_c => $valor_c){
						foreach ($this->arrayInteresados[$llave_c] as $llave => $valor){
							$this->arrayDatosBasicos[]=$this->obtener_datos_estudiante_preinscripcion($valor['idpreinscripcion'],$llave_c);
						}
					}
				}
				break;
			case 'interesados_con_seg':
				if(is_array($this->arrayInteresadosConSeguimiento)){
					foreach ($this->arrayCarreras as $llave_c => $valor_c){
						foreach ($this->arrayInteresadosConSeguimiento[$llave_c] as $llave => $valor){
							$this->arrayDatosBasicos[]=$this->obtener_datos_estudiante_preinscripcion($valor['idpreinscripcion'],$llave_c);
						}
					}
				}
				break;
			case 'interesados_sin_seg':
				if(is_array($this->arrayInteresadosSinSeguimiento)){
					foreach ($this->arrayCarreras as $llave_c => $valor_c){
						foreach ($this->arrayInteresadosSinSeguimiento[$llave_c] as $llave => $valor){
							$this->arrayDatosBasicos[]=$this->obtener_datos_estudiante_preinscripcion($valor['idpreinscripcion'],$llave_c);
						}
					}
				}
				break;
			case 'aspirantes_total':
				if(is_array($this->arrayAspirantes)){
					foreach ($this->arrayCarreras as $llave_c => $valor_c){
						foreach ($this->arrayAspirantes[$llave_c] as $llave => $valor){
							$this->arrayDatosBasicos[]=$this->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
						}
					}
				}
				break;
			case 'aspirantes_con_seg':
				if(is_array($this->arrayAspirantesConSeguimiento)){
					foreach ($this->arrayCarreras as $llave_c => $valor_c){
						foreach ($this->arrayAspirantesConSeguimiento[$llave_c] as $llave => $valor){
							$this->arrayDatosBasicos[]=$this->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
						}
					}
				}
				break;
			case 'aspirantes_sin_seg':
				if(is_array($this->arrayAspirantesSinSeguimiento)){
					foreach ($this->arrayCarreras as $llave_c => $valor_c){
						foreach ($this->arrayAspirantesSinSeguimiento[$llave_c] as $llave => $valor){
							$this->arrayDatosBasicos[]=$this->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
						}
					}
				}
				break;
		}
	}

	function leerCarreras($codigomodalidadacademica="",$codigocarrera="")
	{
		if($codigomodalidadacademica=="todos" and $codigocarrera=="todos")
		{
			$query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica
			FROM
			carrera c
			WHERE
			c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			ORDER BY c.codigocarrera
			";
		}
		elseif($codigomodalidadacademica=="todos" and $codigocarrera<>"todos")
		{
			$query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica
			FROM
			carrera c
			WHERE
			c.codigocarrera='".$codigocarrera."'
			AND c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			ORDER BY c.codigocarrera
			";
		}
		elseif($codigomodalidadacademica<>"todos" and $codigocarrera=="todos")
		{
			$query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica
			FROM
			carrera c
			WHERE
			c.codigomodalidadacademica='$codigomodalidadacademica'
			AND c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			ORDER BY c.codigocarrera
			";
		}
		elseif($codigomodalidadacademica<>"todos" and $codigocarrera<>"todos")
		{
			$query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica
			FROM
			carrera c
			WHERE
			c.codigocarrera='$codigocarrera'
			AND c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			ORDER BY c.codigocarrera
			";
		}
		$obtener_carreras=$this->conexion->query($query_obtener_carreras);
		$row_obtener_carreras=$obtener_carreras->fetchRow();
		do
		{
			$array_obtener_carreras[$row_obtener_carreras['codigocarrera']]=$row_obtener_carreras;
		}
		while($row_obtener_carreras=$obtener_carreras->fetchRow());
		return $array_obtener_carreras;
	}

	function leerInteresados($retorno='conteo'){
		foreach ($this->arrayCarreras as $llave_carreras => $valor_carreras){
			$array_interno[$llave_carreras]=$this->obtener_preinscripcion_estadopreinscripcionestudiante_general($llave_carreras,$retorno);
		}
		return $array_interno;
	}

	function leerAspirantes($retorno='conteo'){
		foreach ($this->arrayCarreras as $llave_c => $valor_c){
			$array_interno[$llave_c]=$this->ObtenerAspirantesSinmatriculaSinPago($llave_c,$this->codigoperiodo,$retorno);
		}
		return $array_interno;
	}

	function leeSeguimientoAspirantes($conSeguimiento=false,$retorno='conteo'){
		foreach ($this->arrayCarreras as $llave_c => $valor_c){
			$array_interno[$llave_c]=$this->obtieneSeguimientoAspirante($llave_c,$conSeguimiento,$retorno);
		}
		return $array_interno;
	}

	function obtieneSeguimientoAspirante($codigocarrera,$conSeguimiento,$retorno='conteo'){
		$aspirantes=$this->ObtenerAspirantesSinmatriculaSinPago($codigocarrera,$this->codigoperiodo,'arreglo');
		if(is_array($aspirantes)){
			foreach ($aspirantes as $llave_a => $valor_a){
				$query="SELECT es.idestudianteseguimiento FROM estudianteseguimiento es WHERE es.codigoestudiante='".$valor_a['codigoestudiante']."'";
				$operacion=$this->conexion->query($query);
				$row_operacion=$operacion->fetchRow();
				do{
					if(!empty($row_operacion)){
						$array_con_seg[]=array('codigoestudiante'=>$valor_a['codigoestudiante']);
					}
					else{
						$array_sin_seg[]=array('codigoestudiante'=>$valor_a['codigoestudiante']);
					}
				}
				while($row_operacion=$operacion->fetchRow());
			}

			if($conSeguimiento==false){
				if($retorno=='conteo'){
					return count($array_sin_seg);
				}
				else{
					return $array_sin_seg;
				}
			}
			else{
				if($retorno=='conteo'){
					return count($array_con_seg);
				}
				else{
					return $array_con_seg;
				}
			}
		}
		else {
			return 0;
		}
	}

	function leePreinscripcion($codigocarrera,$conSeguimiento=false,$retorno='conteo'){
		$query="SELECT distinct
		p.idpreinscripcion,pc.codigocarrera
		FROM
		preinscripcion p,preinscripcioncarrera pc
		WHERE
		p.idpreinscripcion=pc.idpreinscripcion
		AND p.codigoestado=100
		AND p.codigoestadopreinscripcionestudiante not like '2%'
		AND p.codigoperiodo='".$this->codigoperiodo."'
		AND pc.codigocarrera='$codigocarrera'";
		if($conSeguimiento==false){
			$query=$query." and p.codigoestadopreinscripcionestudiante='300'";
		}
		else{
			$query=$query." and p.codigoestadopreinscripcionestudiante<>'300'";
		}
		$query=$query." group by idpreinscripcion";

		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do{
			if(!empty($row_operacion)){
				$array_interno[]=$row_operacion;
			}
		}
		while ($row_operacion=$operacion->fetchRow());
		if($retorno=='conteo'){
			return count($array_interno);
		}
		else{
			return $array_interno;
		}

	}

	function leeInteresadosSinSeguimiento($retorno='conteo'){
		foreach ($this->arrayCarreras as $llave_c => $valor_c){
			$array_interno[$llave_c]=$this->leePreinscripcion($llave_c,false,$retorno);
		}
		return $array_interno;
	}

	function leeInteresadosConSeguimiento($retorno='conteo'){
		foreach ($this->arrayCarreras as $llave_c => $valor_c){
			$array_interno[$llave_c]=$this->leePreinscripcion($llave_c,true,$retorno);
		}
		return $array_interno;
	}

	function creaArrayEstadisticasSeguimiento(){
		foreach ($this->arrayCarreras as $llave_c => $valor_c){
			$array_interno[]=array(
			'codigocarrera'=>$llave_c,
			'carrera'=>$valor_c['nombrecarrera'],
			'interesados_total'=>$this->arrayInteresados[$llave_c],
			'interesados_con_seg'=>$this->arrayInteresadosConSeguimiento[$llave_c],
			'interesados_sin_seg'=>$this->arrayInteresadosSinSeguimiento[$llave_c],
			'aspirantes_total'=>$this->arrayAspirantes[$llave_c],
			'aspirantes_con_seg'=>$this->arrayAspirantesConSeguimiento[$llave_c],
			'aspirantes_sin_seg'=>$this->arrayAspirantesSinSeguimiento[$llave_c],
			);
		}
		return $array_interno;
	}

	function retornaDatosBasicos(){
		return $this->arrayDatosBasicos;
	}
}

?>