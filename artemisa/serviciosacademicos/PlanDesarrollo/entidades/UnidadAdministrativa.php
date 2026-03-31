<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 */

 class UnidadAdministrativa
 {
	 
	 private $PlanDesarrolloId;
	 
	 
	 private $NombrePlanDesarrollo;
	 
	 /**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function UnidadAdministrativa( $persistencia ){
		$this->persistencia = $persistencia;
	}

 	public function setPlanDesarrolloId($PlanDesarrolloId)
	 {
	 	$this->PlanDesarrolloId = $PlanDesarrolloId;
	 }
	 
	 public function setNombrePlanDesarrollo($NombrePlanDesarrollo)
	 {
	 	$this->NombrePlanDesarrollo = $NombrePlanDesarrollo;
	 }
	 
 	public function getPlanDesarrolloId(){
	 	return $this->PlanDesarrolloId;
	 }
	 
	 public function getNombrePlanDesarrollo()
	 {
	 	return $this->NombrePlanDesarrollo;
	 }
	 
	 
	 public function buscarUnidadAdministrativas()
	 {
		 $unidades = array( );
		 $sql = "SELECT PD.PlanDesarrolloId, PD.NombrePlanDesarrollo FROM PlanDesarrollo PD INNER JOIN TipoPlanDesarrollo TP ON TP.TipoPlanDesarrolloId = PD.TipoPlanDesarrolloId WHERE TP.TipoPlanDesarrolloId = 2";
		 
		 $this->persistencia->crearSentenciaSQL( $sql );
		 //echo $this->persistencia->getSQLListo( );
		 $this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$unidad = new UnidadAdministrativa( null );
			$unidad->setPlanDesarrolloId( $this->persistencia->getParametro( "PlanDesarrolloId" ) );
			$unidad->setNombrePlanDesarrollo( $this->persistencia->getParametro( "NombrePlanDesarrollo" ) );
			
			$unidades[ count( $unidades ) ] = $unidad;
		}
		return $unidades;
	 }
	 
	 public function ConsultarReporteUnidades($unidadAdministrativa)
	 {
	 	 $unidades = array( );
		 $sql = "SELECT PD.PlanDesarrolloId, PD.NombrePlanDesarrollo FROM PlanDesarrollo PD INNER JOIN TipoPlanDesarrollo TP ON TP.TipoPlanDesarrolloId = PD.TipoPlanDesarrolloId WHERE TP.TipoPlanDesarrolloId = 2";
		 
		 $this->persistencia->crearSentenciaSQL( $sql );
		 //echo $this->persistencia->getSQLListo( );
		 $this->persistencia->ejecutarConsulta( );
			while( $this->persistencia->getNext( ) ){
			$unidad = new UnidadAdministrativa( null );
			$unidad->setPlanDesarrolloId( $this->persistencia->getParametro( "PlanDesarrolloId" ) );
			$unidad->setNombrePlanDesarrollo( $this->persistencia->getParametro( "NombrePlanDesarrollo" ) );
			
			$unidades[ count( $unidades ) ] = $unidad;
		}
		return $unidades;
	 }
	
 }

?>