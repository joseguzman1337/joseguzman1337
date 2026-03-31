<?php
class indicadoresMatriculas extends obtener_datos_matriculas {

	var $codigoperiodoini;
	var $codigoperiodofin;
	var $arrayCarreras;
	var $conexion;
	var $fechahoy;
	var $indicador;
	var $arrayPeriodos;
	var $arrayInforme;
	var $media;

	function indicadoresMatriculas($codigoperiodoini,$codigoperiodofin,$codigomodalidadacademica,$codigocarrera,$indicador,&$conexion){
		$this->indicador=$indicador;
		$this->conexion=$conexion;
		$this->codigoperiodoini=$codigoperiodoini;
		$this->codigoperiodofin=$codigoperiodofin;
		$this->fechahoy=date("Y-m-d H:i:s");
		$this->arrayCarreras=$this->leerCarreras($codigomodalidadacademica,$codigocarrera);
		$this->arrayPeriodos=$this->leerPeriodos($codigoperiodoini,$codigoperiodofin);
		$this->arrayInforme=$this->informe();
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

	function leerPeriodos($codigoperiodoini,$codigoperiodofin){
		$query="SELECT p.* FROM periodo p WHERE p.codigoperiodo BETWEEN '$codigoperiodoini' AND '$codigoperiodofin'";
		$operacion=$this->conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		do {
			if(!empty($row_operacion)){
				$arrayInterno[$row_operacion['codigoperiodo']]=$row_operacion;
			}
		}
		while($row_operacion=$operacion->fetchRow());
		return $arrayInterno;
	}

	function creaArrayInformeGlobal(){
		foreach ($this->arrayInforme as $llave_p => $valor_p){
			foreach ($valor_p as $llave_c => $valor_c){
				$arrayInterno[]=array('codigoperiodo'=>$llave_p,'codigocarrera'=>$llave_c,'nombrecarrera'=>$this->arrayCarreras[$llave_c]['nombrecarrera'],'cantidad'=>$valor_c);
			}
		}
		return $arrayInterno;
	}

	function retornaArrayInforme(){
		return $this->arrayInforme;
	}

	function calculaMedia(){
		$sumatoriaC=0;
		$sumatoriaP=0;
		foreach ($this->arrayInforme as $llave_p => $valor_p){
			foreach ($valor_p as $llave_c => $valor_c){
				$sumatoriaC=$sumatoriaC + $valor_c;
			}
			$sumatoriaP=$sumatoriaP+$sumatoriaC;
			$sumatoriaC=0;
		}
		$this->media=$sumatoriaP / count($this->arrayPeriodos);
		return $this->media;
	}

	function calculaDesviacionEstandar(){
		$sumatoriaC=0;
		$sumatoriaP=0;
		foreach ($this->arrayInforme as $llave_p => $valor_p){
			foreach ($valor_p as $llave_c => $valor_c){
				$sumatoriaC=$sumatoriaC + $valor_c;
			}
			$calc = pow($sumatoriaC - $this->media,2);
			$sumatoriaC=0;
			$sumatoriaP=$sumatoriaP+$calc;
		}
		$division = $sumatoriaP / count($this->arrayPeriodos);
		$sqrt = sqrt($division);
		return $sqrt;
	}

	function informe(){
		switch ($this->indicador){
			case 'Interesados':
				$arrayValorIndicador=$this->leerTotalInteresados();
				break;

			case 'Aspirantes':
				$arrayValorIndicador=$this->leerTotalAspirantes();
				break;

			case 'a_seguir_aspirantes_vs_inscritos':
				$arrayValorIndicador=$this->leerTotala_seguir_aspirantes_vs_inscritos();
				break;
			case 'Inscritos':
				$arrayValorIndicador=$this->leerTotalInscritos();
				break;
			case 'a_seguir_inscritos_vs_matriculados_nuevos':
				$arrayValorIndicador=$this->leerTotala_seguir_inscritos_vs_matriculados_nuevos();
				break;
			case 'Matriculados_Nuevos':
				$arrayValorIndicador=$this->leerTotalMatriculados_Nuevos();
				break;
			case 'Matriculados_Antiguos':
				$arrayValorIndicador=$this->leerTotalMatriculados_Antiguos();
				break;
			case 'Matriculados_Transferencia':
				$arrayValorIndicador=$this->leerTotalMatriculados_Transferencia();
				break;
			case 'Matriculados_Reintegro':
				$arrayValorIndicador=$this->leerTotalMatriculados_Reintegro();
				break;
			case 'Total_Matriculados':
				$arrayValorIndicador=$this->leerTotalMatriculados();
				break;
			case 'Matriculados_Repitentes_1_semestre':
				$arrayValorIndicador=$this->leerTotalMatriculados_Repitentes_1_semestre();
				break;
			case 'Matriculados_Transferencia_1_semestre':
				$arrayValorIndicador=$this->leerTotalMatriculados_Transferencia_1_semestre();
				break;
			case 'Matriculados_Reintegro_1_semestre':
				$arrayValorIndicador=$this->leerTotalMatriculados_Reintegro_1_semestre();
				break;
			case 'Total_Matriculados_1_semestre':
				$arrayValorIndicador=$this->leerTotalTotal_Matriculados_1_semestre();
				break;
			case 'a_seguir_Prematriculados':
				$arrayValorIndicador=$this->leerTotala_seguir_Prematriculados();
				break;
			case 'a_seguir_No_prematriculados':
				$arrayValorIndicador=$this->leerTotala_seguir_No_prematriculados();
				break;
		}
		return $arrayValorIndicador;
	}

	function leerTotala_seguir_No_prematriculados(){
		foreach ($this->arrayPeriodos as $llave_p => $valor_p){
			obtener_datos_matriculas::obtener_datos_matriculas($this->conexion,$llave_p);
			foreach ($this->arrayCarreras as $llave_c => $valor_c){
				$arrayInterno[$llave_c]=$this->obtener_datos_estudiantes_noprematriculados($llave_c,'conteo');
			}
			$arrayExterno[$llave_p]=$arrayInterno;
		}
		return $arrayExterno;
	}

	function leerTotala_seguir_Prematriculados(){
		foreach ($this->arrayPeriodos as $llave_p => $valor_p){
			obtener_datos_matriculas::obtener_datos_matriculas($this->conexion,$llave_p);
			foreach ($this->arrayCarreras as $llave_c => $valor_c){
				$arrayInterno[$llave_c]=$this->obtener_datos_cuentaoperacionprincipal_ordenesnopagas($llave_p,$llave_c,151,'conteo');
			}
			$arrayExterno[$llave_p]=$arrayInterno;
		}
		return $arrayExterno;
	}

	function leerTotalTotal_Matriculados_1_semestre(){
		foreach ($this->arrayPeriodos as $llave_p => $valor_p){
			obtener_datos_matriculas::obtener_datos_matriculas($this->conexion,$llave_p);
			foreach ($this->arrayCarreras as $llave_c => $valor_c){
				$arrayInterno[$llave_c]=$this->obtener_total_matriculados_1_semestre($llave_c,'conteo');
			}
			$arrayExterno[$llave_p]=$arrayInterno;
		}
		return $arrayExterno;
	}

	function leerTotalMatriculados_Reintegro_1_semestre(){
		foreach ($this->arrayPeriodos as $llave_p => $valor_p){
			obtener_datos_matriculas::obtener_datos_matriculas($this->conexion,$llave_p);
			foreach ($this->arrayCarreras as $llave_c => $valor_c){
				$arrayInterno[$llave_c]=$this->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante_1_semestre($llave_c,21,'conteo');
			}
			$arrayExterno[$llave_p]=$arrayInterno;
		}
		return $arrayExterno;
	}

	function leerTotalMatriculados_Transferencia_1_semestre(){
		foreach ($this->arrayPeriodos as $llave_p => $valor_p){
			obtener_datos_matriculas::obtener_datos_matriculas($this->conexion,$llave_p);
			foreach ($this->arrayCarreras as $llave_c => $valor_c){
				$arrayInterno[$llave_c]=$this->obtener_datos_estudiantes_matriculados_transferencia_1_semestre($llave_c,'conteo');
			}
			$arrayExterno[$llave_p]=$arrayInterno;
		}
		return $arrayExterno;
	}

	function leerTotalMatriculados_Repitentes_1_semestre(){
		foreach ($this->arrayPeriodos as $llave_p => $valor_p){
			obtener_datos_matriculas::obtener_datos_matriculas($this->conexion,$llave_p);
			foreach ($this->arrayCarreras as $llave_c => $valor_c){
				$arrayInterno[$llave_c]=$this->obtener_datos_estudiantes_matriculados_repitentes($llave_c,20,'conteo');
			}
			$arrayExterno[$llave_p]=$arrayInterno;
		}
		return $arrayExterno;
	}

	function leerTotalMatriculados_Reintegro(){
		foreach ($this->arrayPeriodos as $llave_p => $valor_p){
			obtener_datos_matriculas::obtener_datos_matriculas($this->conexion,$llave_p);
			foreach ($this->arrayCarreras as $llave_c => $valor_c){
				$arrayInterno[$llave_c]=$this->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($llave_c,21,'conteo');
			}
			$arrayExterno[$llave_p]=$arrayInterno;
		}
		return $arrayExterno;
	}

	function leerTotalMatriculados_Transferencia(){
		foreach ($this->arrayPeriodos as $llave_p => $valor_p){
			obtener_datos_matriculas::obtener_datos_matriculas($this->conexion,$llave_p);
			foreach ($this->arrayCarreras as $llave_c => $valor_c){
				$arrayInterno[$llave_c]=$this->obtener_datos_estudiantes_matriculados_transferencia($llave_c,'conteo');
			}
			$arrayExterno[$llave_p]=$arrayInterno;
		}
		return $arrayExterno;
	}

	function leerTotalMatriculados_Antiguos(){
		foreach ($this->arrayPeriodos as $llave_p => $valor_p){
			obtener_datos_matriculas::obtener_datos_matriculas($this->conexion,$llave_p);
			foreach ($this->arrayCarreras as $llave_c => $valor_c){
				$arrayInterno[$llave_c]=$this->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($llave_c,20,'conteo');
			}
			$arrayExterno[$llave_p]=$arrayInterno;
		}
		return $arrayExterno;
	}

	function leerTotalMatriculados_Nuevos(){
		foreach ($this->arrayPeriodos as $llave_p => $valor_p){
			obtener_datos_matriculas::obtener_datos_matriculas($this->conexion,$llave_p);
			foreach ($this->arrayCarreras as $llave_c => $valor_c){
				$arrayInterno[$llave_c]=$this->obtener_datos_estudiantes_matriculados_nuevos($llave_c,'conteo');
			}
			$arrayExterno[$llave_p]=$arrayInterno;
		}
		return $arrayExterno;
	}

	function leerTotala_seguir_inscritos_vs_matriculados_nuevos(){
		foreach ($this->arrayPeriodos as $llave_p => $valor_p){
			obtener_datos_matriculas::obtener_datos_matriculas($this->conexion,$llave_p);
			foreach ($this->arrayCarreras as $llave_c => $valor_c){
				$arrayInterno[$llave_c]=$this->seguimiento_inscripcionvsmatriculadosnuevos($llave_c,'conteo');
			}
			$arrayExterno[$llave_p]=$arrayInterno;
		}
		return $arrayExterno;
	}

	function leerTotalInscritos(){
		foreach ($this->arrayPeriodos as $llave_p => $valor_p){
			obtener_datos_matriculas::obtener_datos_matriculas($this->conexion,$llave_p);
			foreach ($this->arrayCarreras as $llave_c => $valor_c){
				$arrayInterno[$llave_c]=$this->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($llave_p,$llave_c,153,'conteo');
			}
			$arrayExterno[$llave_p]=$arrayInterno;
		}
		return $arrayExterno;
	}

	function leerTotala_seguir_aspirantes_vs_inscritos(){
		foreach ($this->arrayPeriodos as $llave_p => $valor_p){
			obtener_datos_matriculas::obtener_datos_matriculas($this->conexion,$llave_p);
			foreach ($this->arrayCarreras as $llave_c => $valor_c){
				$arrayInterno[$llave_c]=$this->obtener_datos_aspirantes_vs_inscritos($llave_p,$llave_c,'conteo');
			}
			$arrayExterno[$llave_p]=$arrayInterno;
		}
		return $arrayExterno;
	}

	function leerTotalMatriculados(){
		foreach ($this->arrayPeriodos as $llave_p => $valor_p){
			obtener_datos_matriculas::obtener_datos_matriculas($this->conexion,$llave_p);
			foreach ($this->arrayCarreras as $llave_c => $valor_c){
				$arrayInterno[$llave_c]=$this->obtener_total_matriculados($llave_c,'conteo');
			}
			$arrayExterno[$llave_p]=$arrayInterno;
		}
		return $arrayExterno;
	}

	function leerTotalInteresados(){
		foreach ($this->arrayPeriodos as $llave_p => $valor_p){
			obtener_datos_matriculas::obtener_datos_matriculas($this->conexion,$llave_p);
			foreach ($this->arrayCarreras as $llave_c => $valor_c){
				$arrayInterno[$llave_c]=$this->obtener_preinscripcion_estadopreinscripcionestudiante_general($llave_c,'conteo');
			}
			$arrayExterno[$llave_p]=$arrayInterno;
		}
		return $arrayExterno;
	}

	function leerTotalAspirantes(){
		foreach ($this->arrayPeriodos as $llave_p => $valor_p){
			obtener_datos_matriculas::obtener_datos_matriculas($this->conexion,$llave_p);
			foreach ($this->arrayCarreras as $llave_c => $valor_c){
				$arrayInterno[$llave_c]=$this->ObtenerAspirantesSinmatriculaSinPago($llave_c,$llave_p,'conteo');
			}
			$arrayExterno[$llave_p]=$arrayInterno;
		}
		return $arrayExterno;
	}

	function retornaArrayCarrera($codigocarrera){
		return $this->arrayCarreras[$codigocarrera];
	}

}
?>