<?php 
    /**
	 * @author Diego Rivera<riveradiego@unbosque.edu.co>
	 * @copyright Dirección de Tecnología - Universidad el Bosque
	 * @package control
	 */
	 include('../entidades/avancesIndicadorPlanDesarrollo.php');

	// include ('../../../kint/Kint.class.php'); 
class controlAvancesIndicadorPlanDesarrollo{
	
	private $persistencia;
	
	public function	controlAvancesIndicadorPlanDesarrollo( $persistencia ){
		$this->persistencia = $persistencia;		
	}
	
		/**
		 * Registrar Actividad avances indicador
		 * @param int $txtIndicadorPlanDesarrolloId
		 * @param string $txtNombreActividad
		 * @param string $txtAvancePropuesto
		 * @param string $txtFechaActividad
		 * @param usuario $idPersona
		 * @return booelan
		  */
		  
	public function crearAvanceIndicador( $txtIndicadorPlanDesarrolloId, $txtNombreActividad , $txtAvancePropuesto , $txtFechaActividad , $idPersona , $evidencia ){
		
		$avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo( $this->persistencia );
		$avancesIndicadorPlanDesarrollo->setIndicadorPlanDesarrolloId( $txtIndicadorPlanDesarrolloId );
		$avancesIndicadorPlanDesarrollo->setActividad( $txtNombreActividad );
		$avancesIndicadorPlanDesarrollo->setValorAvance( $txtAvancePropuesto );
		$avancesIndicadorPlanDesarrollo->setFechaActividad( $txtFechaActividad  );
		$avancesIndicadorPlanDesarrollo->setEvidencia( $evidencia );
		
		return  $avancesIndicadorPlanDesarrollo->registrarActividad( $idPersona );
		
	} 
	
	public function verAvancesIndicador ( $txtIndicadorPlanDesarrolloId ){
                $avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo( $this->persistencia );
                return $avancesIndicadorPlanDesarrollo->verAvance( $txtIndicadorPlanDesarrolloId );
	}
       
       /*Modified Diego RIvera <riveradiego@unbosque.edu.co>
       *Se añade parametreo $periodo a funcion con el fin de mostrar unicamente las evidencias correspondientes al año seleccionado
       *Since May 10 ,2018
       */
	public function verAvanceTotales ( $idMeta , $periodo ){
                $avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo( $this->persistencia );
                return $avancesIndicadorPlanDesarrollo->verAvanceTotal( $idMeta , $periodo );
	}
	
	
	public function AvanceActual ( $txtIndicadorPlanDesarrolloId ){
                $avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo( $this->persistencia );
                $avancesIndicadorPlanDesarrollo->verAvanceActual( $txtIndicadorPlanDesarrolloId );
                return $avancesIndicadorPlanDesarrollo;
	}
	
	public function verEvidenciaAvance( $idAvancesIndicadorPlanDesarrollo ){
		$avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo( $this->persistencia );
		return $avancesIndicadorPlanDesarrollo->verAvanceEvidencia( $idAvancesIndicadorPlanDesarrollo );
	 }
	
	
	public function actualizarobservacion( $idMetaSecundaria , $observaciones ,$aprobacion ){
		$avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo( $this->persistencia );
		return $avancesIndicadorPlanDesarrollo->actualizarObservacion( $idMetaSecundaria , $observaciones , $aprobacion );
		
	}

	public function actulaizarAprobacion( $idMeteSecundaria , $valor){
		$avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo( $this->persistencia );
		return $avancesIndicadorPlanDesarrollo->actualizarAprobacion( $idMeteSecundaria , $valor );
	}
	
	/*Modfied Diego Rivera <riveradiego@unbosque.edu.co>
	*Se añada funcion  la cual permite instanciar objeto avancesIndicadorplandesarrollo y ejecutar metodo para acutalizar estado de aprobacion
	*Since August 23,2017
	*/

	public function actualizarAprobacionEliminar ( $idMetaSecundaria ) {
		$avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo( $this->persistencia );
		return $avancesIndicadorPlanDesarrollo->actualizarAprobacionEliminar( $idMetaSecundaria );
	}
	//fin modificacion
	public function AvancePorId ( $IdAvance){
		$avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo( $this->persistencia );
                $avancesIndicadorPlanDesarrollo->verAvanceId( $IdAvance );
		return $avancesIndicadorPlanDesarrollo;
	}
	
	public function actualizarEvidenciaAvance( $idAvancesIndicadorPlanDesarrollo, $actividad, $valorAvance, $evidencia , $fechaActividad ){
		$avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo( $this->persistencia );
		return $avancesIndicadorPlanDesarrollo->actualizarEvidencia($idAvancesIndicadorPlanDesarrollo, $actividad, $valorAvance, $evidencia , $fechaActividad );
	}

	public function verEstadoAvanceId( $idMetaSecundaria ) {
		$avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo( $this->persistencia );
		return $avancesIndicadorPlanDesarrollo->verEstadoAvance( $idMetaSecundaria );
		
	}
	
	public function VerArchivosEvidencia( $idMetaSecundaria , $fechaActividad , $actividad , $valorAvance , $aprobacion ) {
		$avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo( $this->persistencia );	
		return $avancesIndicadorPlanDesarrollo->VerEvidencias( $idMetaSecundaria , $fechaActividad , $actividad , $valorAvance , $aprobacion);
		
		
		}
	
	public function VerArchivosEvidenciaMeta( $idMeta , $fecha , $actividad , $avance , $aprabado ) {
		$avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo( $this->persistencia );	
		return $avancesIndicadorPlanDesarrollo->VerEvidenciasMeta( $idMeta, $fecha , $actividad , $avance , $aprabado  );
		
		}
	
	public function EliminarEvidenciaAvance ( $idAvance ){
		$avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo( $this->persistencia );
		return $avancesIndicadorPlanDesarrollo->eliminarEvidencia( $idAvance );
	}
        
        public function ListaArchivosAnual( $idMetaSecundaria , $periodo  ){
            $avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo( $this->persistencia );
            return $avancesIndicadorPlanDesarrollo ->listaArchivosAnual( $idMetaSecundaria , $periodo );
        }
        public function ListaArchivosTotal( $idMeta  ){
            $avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo( $this->persistencia );
            return $avancesIndicadorPlanDesarrollo ->listaArchivosTotal( $idMeta );
        }
}

?>