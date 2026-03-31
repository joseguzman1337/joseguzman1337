<?php
    /**
	 * @author Ivan quintero <quinteroivan@unbosque.edu.do>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package control
	 * @since Febrero 22, 2017
	*/
	
	class ReporteFacultades
	{
		public $LineaEstrategicaId;
		
		public $NombreLineaEstrategica;
		
		public $CodigoCarrera;
		
		public $NombrePlanDesarrollo;
		
		public $NombrePrograma;
		
		public $NombreProyectoPlanDesarrollo;
		
		public $NombreIndicador;
		
		public $NombreMetaPlanDesarrollo;
		
		public $AvanceMetaPlanDesarrollo;
		
		public $AlcanceMeta;
		
		public $PlanDesarrolloId;
		
		public $VigenciaMeta;
		
		public $idIndicador;
		
		
		private $persistencia;
		
		
		/**
		 * Constructor
		 * @param Singleton $persistencia
		 */
		public function ReporteFacultades( $persistencia ){ 
			$this->persistencia = $persistencia;
		}
		
		public function ReporteAdministrativas($persistencia)
		{
			$this->persistencia = $persistencia;
		}//public function ReporteAdministrativas
		
		
		public function consulta($Facultad, $codigoperiodo)
		{
			if($Facultad)
			{
				$where = " WHERE VR.CodigoFacultad = ? ";
				$parametros[0]= $Facultad;	
				if($codigoperiodo > 0)
				{
					$parametros[1]= $codigoperiodo;	
					$where.= " AND VR.VigenciaMeta LIKE '%?%'";
				}
			}else
			{
				$where = "";
			}
			
			$reportes = array();
			
			$sql= "SELECT VR.LineaEstrategicaId, VR.NombreLineaEstrategica, VR.CodigoCarrera, VR.NombrePlanDesarrollo, VR.NombrePrograma, VR.NombreProyectoPlanDesarrollo, VR.NombreIndicador, VR.NombreMetaPlanDesarrollo, VR.AvanceMetaPlanDesarrollo, VR.AlcanceMeta, VR.VigenciaMeta ,VR.idIndicador FROM ViewReporteFacultades VR ".$where;
			$this->persistencia->crearSentenciaSQL( $sql );		
			if(!empty($Facultad))
			{
				$this->persistencia->setParametro( 0 , $parametros[0] , false );
				if(!empty($codigoperiodo) > 0)
				{
					$this->persistencia->setParametro( 1 , $parametros[1] , false );
				}
			}
			//echo $this->persistencia->getSQLListo( );
			$this->persistencia->ejecutarConsulta(  );
			while( $this->persistencia->getNext( ) ){
				$reporteFacultades = new ReporteFacultades( null );
				$reporteFacultades->LineaEstrategicaId = $this->persistencia->getParametro( "LineaEstrategicaId" );
				$reporteFacultades->NombreLineaEstrategica = $this->persistencia->getParametro( "NombreLineaEstrategica" );
				$reporteFacultades->CodigoCarrera = $this->persistencia->getParametro( "CodigoCarrera" );
				$reporteFacultades->NombrePlanDesarrollo = $this->persistencia->getParametro( "NombrePlanDesarrollo" );
				$reporteFacultades->NombrePrograma = $this->persistencia->getParametro( "NombrePrograma" );
				$reporteFacultades->NombreProyectoPlanDesarrollo = $this->persistencia->getParametro( "NombreProyectoPlanDesarrollo" );
				$reporteFacultades->NombreIndicador = $this->persistencia->getParametro( "NombreIndicador" );
				$reporteFacultades->NombreMetaPlanDesarrollo = $this->persistencia->getParametro( "NombreMetaPlanDesarrollo" );
				$reporteFacultades->AvanceMetaPlanDesarrollo = $this->persistencia->getParametro( "AvanceMetaPlanDesarrollo" );
				$reporteFacultades->AlcanceMeta = $this->persistencia->getParametro( "AlcanceMeta" );
				$reporteFacultades->VigenciaMeta = $this->persistencia->getParametro( "VigenciaMeta" );
				$reporteFacultades->idIndicador = $this->persistencia->getParametro("idIndicador");
			
				
				$reportes[] = $reporteFacultades;
			}
			$this->persistencia->freeResult( );
			
			return 	$reportes;
		}//public function consulta
		
		
		
	}//class